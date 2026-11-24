<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShelfController;
use App\Livewire\CatalogBrowser;
use Illuminate\Support\Facades\Route;

// Halaman Utama Katalog (Livewire)
Route::get('/', CatalogBrowser::class)->name('home');

// Autentikasi
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Fitur Warga (Wajib Login)
Route::middleware('auth')->group(function () {
    Route::get('/rak-koleksiku', [ShelfController::class, 'index'])->name('shelf.index');
    Route::post('/rak-koleksiku', [ShelfController::class, 'store'])->name('shelf.store');

    Route::get('/aktivitas', [ActivityController::class, 'index'])->name('activity.index');
    Route::post('/aktivitas/{rental}/selesai', [ActivityController::class, 'completeReturn'])->name('activity.return');

    Route::get('/dompet', [ActivityController::class, 'wallet'])->name('wallet.index');
});