<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showAuthForm()
    {
        return view('livewire.auth');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:100',
            'phone' => 'required|string|min:8|unique:users,phone',
            'block' => 'required|string',
            'role' => 'required|in:peminjam,pemilik,keduanya',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'member_code' => '#RT-' . rand(100, 999),
            'name' => $validated['name'],
            'email' => preg_replace('/[^0-9]/', '', $validated['phone']) . '@raktetangga.local',
            'phone' => $validated['phone'],
            'block' => $validated['block'],
            'role' => $validated['role'],
            'balance' => 125000, // Bonus saldo awal simulasi
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Kartu warga berhasil dicetak!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        // Bisa login pakai No WA atau Member Code (#RT-xxx)
        $user = User::where('phone', $request->identifier)
            ->orWhere('member_code', $request->identifier)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect('/');
        }

        return back()->withErrors([
            'identifier' => 'Nomor WA / ID Anggota atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}