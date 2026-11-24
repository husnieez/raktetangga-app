<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CatalogBrowser extends Component
{
    public string $search = '';
    public string $category = 'all'; // all, boardgame, book, comic
    public int $maxDistance = 1500; // meters
    public string $statusFilter = 'all'; // all, available, queue
    public ?array $mysteryPick = null;
    public bool $isRollingDice = false;

    protected $listeners = [
        'rental-confirmed' => 'handleRentalConfirmed',
        'checklist-verified' => 'handleChecklistVerified',
    ];

    public function getItemsProperty(): array
    {
        $query = Item::with('owner')
            ->where('distance', '<=', $this->maxDistance);

        if ($this->category !== 'all') {
            $query->where('type', $this->category);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('code', 'like', '%' . $this->search . '%')
                  ->orWhere('author_or_genre', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter === 'available') {
            $query->where('status', 'TERSEDIA');
        }

        return $query->latest()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'code' => $item->code,
                'type' => $item->type,
                'title' => $item->title,
                'genre' => $item->author_or_genre,
                'author' => $item->author_or_genre,
                'category' => $item->author_or_genre,
                'pages' => $item->meta_info,
                'players' => explode('•', $item->meta_info ?? '')[0] ?? '2-4 Pemain',
                'duration' => explode('•', $item->meta_info ?? '')[1] ?? '60 Mnt',
                'pieces' => $item->pieces,
                'daily_rate' => $item->daily_rate,
                'deposit' => $item->deposit,
                'owner' => $item->owner->name ?? 'Warga RT',
                'location' => $item->location,
                'distance' => $item->distance,
                'status' => $item->status,
                'cover_bg' => $item->cover_color,
                'cover_tone' => $item->cover_color,
            ];
        })->toArray();
    }

    public function rollMysteryDice(): void
    {
        $this->isRollingDice = true;
        
        $avail = array_filter($this->items, fn($i) => $i['status'] === 'TERSEDIA');
        if (empty($avail)) {
            $avail = $this->items;
        }

        if (!empty($avail)) {
            $keys = array_keys($avail);
            $randomKey = $keys[array_rand($keys)];
            $this->mysteryPick = $avail[$randomKey];
        }

        $this->dispatch('mystery-picked', $this->mysteryPick);
    }

    public function handleRentalConfirmed(
        $itemId = null,
        $days = 3,
        $dueDate = null,
        $location = 'pos_satpam',
        $note = '',
        $otp = null
    ): void {
        if (!$itemId || !Auth::check()) {
            return;
        }

        $user = Auth::user();
        $item = Item::find($itemId);

        if (!$item || $item->status !== 'TERSEDIA') {
            return;
        }

        $days = (int) $days;
        $totalRentalFee = $item->daily_rate * $days;
        $grandTotal = $totalRentalFee + $item->deposit;

        if ($user->balance < $grandTotal) {
            return;
        }

        DB::transaction(function () use ($user, $item, $days, $totalRentalFee, $grandTotal, $location, $note, $otp) {
            Rental::create([
                'item_id' => $item->id,
                'borrower_id' => $user->id,
                'days' => $days,
                'due_date' => now()->addDays($days)->toDateString(),
                'total_rental_fee' => $totalRentalFee,
                'deposit_held' => $item->deposit,
                'handover_location' => $location,
                'handover_otp' => $otp ?? rand(100, 999) . '-' . rand(100, 999),
                'note' => $note,
                'status' => 'SIAP_DIAMBIL',
            ]);

            $user->decrement('balance', $grandTotal);
            $item->update(['status' => 'DIPINJAM']);
        });

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Peminjaman berhasil dicatat di Kartu Tanggal Kembali!'
        ]);
    }

    public function handleChecklistVerified($itemId = null): void
    {
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Berita acara cek fisik komponen berhasil dikonfirmasi!'
        ]);
    }

    public function render()
    {
        return view('livewire.catalog-browser', [
            'items' => $this->getItemsProperty(),
        ]);
    }
}