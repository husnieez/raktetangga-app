<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class CheckoutModal extends Component
{
    public bool $isOpen = false;
    public ?array $item = null;
    public int $days = 3;
    public string $borrowerName = 'Budi Prasetyo';
    public string $borrowerUnit = 'Blok A-05 / RT 04';
    public string $handoverLocation = 'pos_satpam';
    public string $catatan = '';
    public bool $stampedSuccess = false;

    /** OTP serah terima, diisi setelah checkout berhasil */
    public ?string $otpCode = null;

    /** Penanda checkout sudah tersimpan */
    public bool $submitted = false;

    protected $listeners = [
        'open-checkout' => 'open',
    ];

    public function open(array $itemData): void
    {
        $this->resetValidation();
        $this->item = $itemData;
        $this->days = 3;
        $this->catatan = '';
        $this->otpCode = null;
        $this->submitted = false;
        $this->stampedSuccess = false;
        $this->isOpen = true;
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    public function incrementDays(): void
    {
        if ($this->days < 14) {
            $this->days++;
        }
    }

    public function decrementDays(): void
    {
        if ($this->days > 1) {
            $this->days--;
        }
    }

    public function getRentalFeeProperty(): int
    {
        return (int) (($this->item['daily_rate'] ?? 0) * $this->days);
    }

    public function getDepositFeeProperty(): int
    {
        return (int) ($this->item['deposit'] ?? 0);
    }

    public function getTotalPayProperty(): int
    {
        return $this->rentalFee + $this->depositFee;
    }

    public function getDueDateStringProperty(): string
    {
        $months = ['JAN', 'FEB', 'MAR', 'APR', 'MEI', 'JUN', 'JUL', 'AGU', 'SEP', 'OKT', 'NOV', 'DES'];
        $ts = strtotime("+{$this->days} days");
        $day = date('d', $ts);
        $month = $months[(int) date('n', $ts) - 1];
        $year = date('Y', $ts);

        return "{$day} {$month} {$year}";
    }

    /**
     * Dipertahankan agar tombol lama (wire:click="confirmBooking") tetap jalan.
     */
    public function confirmBooking(): void
    {
        $this->submitCheckout();
    }

    public function submitCheckout(): void
    {
        if (! $this->item || empty($this->item['id'])) {
            return;
        }

        // Jika belum login, arahkan ke halaman login
        if (! Auth::check()) {
            $this->redirect('/login');

            return;
        }

        $this->validate([
            'days' => ['required', 'integer', 'min:1', 'max:14'],
            'handoverLocation' => ['required', Rule::in(['pos_satpam', 'rumah_warga', 'balai_warga'])],
            'catatan' => ['nullable', 'string', 'max:500'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        DB::transaction(function () use ($user) {
            // Ambil ulang item dari DB + lock agar tidak terjadi double booking
            /** @var Item|null $item */
            $item = Item::whereKey($this->item['id'])->lockForUpdate()->first();

            if (! $item || $item->status !== 'TERSEDIA') {
                throw ValidationException::withMessages([
                    'item' => 'Barang sudah tidak tersedia untuk disewa.',
                ]);
            }

            // Hitung ulang dari data DB (bukan dari array listener yang bisa stale)
            $rentalFee = (int) ($item->daily_rate * $this->days);
            $deposit = (int) $item->deposit;
            $grandTotal = $rentalFee + $deposit;

            /** @var \App\Models\User $lockedUser */
            $lockedUser = $user->newQuery()->whereKey($user->getKey())->lockForUpdate()->first();

            if ($lockedUser->balance < $grandTotal) {
                throw ValidationException::withMessages([
                    'balance' => 'Saldo dompet warga tidak mencukupi.',
                ]);
            }

            $this->otpCode = strtoupper(Str::random(4)) . '-' . rand(10, 99);

            // 1. Simpan transaksi ke tabel rentals
            Rental::create([
                'item_id' => $item->getKey(),
                'borrower_id' => $lockedUser->getKey(),
                'days' => $this->days,
                'due_date' => now()->addDays($this->days)->toDateString(),
                'total_rental_fee' => $rentalFee,
                'deposit_held' => $deposit,
                'handover_location' => $this->handoverLocation,
                'handover_otp' => $this->otpCode,
                'note' => $this->catatan,
                'status' => 'SIAP_DIAMBIL',
            ]);

            // 2. Potong saldo penyewa (biaya sewa + uang jaminan ditahan)
            $lockedUser->decrement('balance', $grandTotal);

            // 3. Ubah status barang menjadi DIPINJAM
            $item->update(['status' => 'DIPINJAM']);
        });

        $this->submitted = true;
        $this->stampedSuccess = true;

        $this->dispatch('rental-confirmed', [
            'item_id' => $this->item['id'],
            'days' => $this->days,
            'due_date' => $this->dueDateString,
            'location' => $this->handoverLocation,
            'otp' => $this->otpCode,
        ]);

        $this->dispatch('balance-updated');
    }

    public function render()
    {
        return view('livewire.checkout-modal');
    }
}