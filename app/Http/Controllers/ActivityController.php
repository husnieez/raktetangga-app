<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Daftar barang yang sedang dipinjam oleh user ini
        $borrowedRentals = Rental::with(['item.owner'])
            ->where('borrower_id', $userId)
            ->latest()
            ->get();

        // Daftar barang milik user ini yang sedang dipinjam tetangga
        $lentRentals = Rental::with(['item', 'borrower'])
            ->whereHas('item', fn ($q) => $q->where('user_id', $userId))
            ->latest()
            ->get();

        return view('livewire.activity-hub', compact('borrowedRentals', 'lentRentals'));
    }

    // Proses Pengembalian Barang & Pencairan Uang Jaminan
    public function completeReturn(Rental $rental)
    {
        if ($rental->status === 'SELESAI') {
            return back();
        }

        DB::transaction(function () use ($rental) {
            // 1. Tandai transaksi selesai
            $rental->update(['status' => 'SELESAI']);

            // 2. Kembalikan status barang menjadi TERSEDIA
            $rental->item->update(['status' => 'TERSEDIA']);

            // 3. Kembalikan 100% uang jaminan ke penyewa
            $rental->borrower->increment('balance', $rental->deposit_held);

            // 4. Cairkan biaya sewa ke saldo pemilik barang
            $rental->item->owner->increment('balance', $rental->total_rental_fee);
        });

        return back()->with('success', 'Barang dikembalikan! Jaminan Rp ' . number_format($rental->deposit_held, 0, ',', '.') . ' telah cair kembali ke dompet.');
    }

    public function wallet()
    {
        $user = Auth::user();
        $heldDeposit = Rental::where('borrower_id', $user->id)
            ->where('status', '!=', 'SELESAI')
            ->sum('deposit_held');

        $history = Rental::with('item')
            ->where('borrower_id', $user->id)
            ->latest()
            ->get();

        return view('livewire.wallet-waitlist', compact('user', 'heldDeposit', 'history'));
    }
}