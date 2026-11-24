<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShelfController extends Controller
{
    public function index()
    {
        $items = Item::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('livewire.my-shelf', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'type' => 'required|in:boardgame,book,comic',
            'author_or_genre' => 'required|string|max:100',
            'daily_rate' => 'required|integer|min:1000',
            'deposit' => 'required|integer|min:0',
            'pieces' => 'nullable|string',
        ], [
            'title.required' => 'Judul buku atau board game wajib diisi.',
            'author_or_genre.required' => 'Nama pengarang atau genre wajib diisi.',
            'daily_rate.required' => 'Tarif sewa per hari wajib diisi.',
            'daily_rate.min' => 'Tarif sewa minimal Rp 1.000.',
        ]);

        $prefix = match ($validated['type']) {
            'boardgame' => 'BG',
            'comic' => 'KM',
            default => 'BK',
        };

        $user = Auth::user();

        Item::create([
            'user_id' => $user->id,
            'code' => $prefix . '-' . rand(100, 999),
            'type' => $validated['type'],
            'title' => $validated['title'],
            'author_or_genre' => $validated['author_or_genre'],
            'pieces' => $validated['pieces'] ?? 'Buku fisik cetakan asli',
            'daily_rate' => $validated['daily_rate'],
            'deposit' => $validated['deposit'],
            'location' => ($user->block ?? 'Blok C') . ' • 200m',
            'distance' => 200,
            'status' => 'TERSEDIA',
            'cover_color' => $validated['type'] === 'boardgame' ? '#E09F3E' : '#FFFDF9',
        ]);

        return back()->with('success', 'Koleksi baru berhasil disimpan ke Rak!');
    }
}