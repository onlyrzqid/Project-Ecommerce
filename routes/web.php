<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

// RUTE KATALOG & DETAIL PRODUK PELANGGAN
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product}', [HomeController::class, 'show'])->name('products.show');

// Ubah rute /dashboard bawaan menjadi seperti ini:
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
   return view('dashboard'); // Untuk user biasa
})->middleware(['auth', 'verified'])->name('dashboard');
// ==========================================
// RUTE USER / PELANGGAN (Bawaan Breeze)
// ==========================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
}); // <- Penutup grup rute user

// RUTE KERANJANG BELANJA (Hanya User Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.add');
    Route::patch('/cart/update/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/delete/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
});

// ==========================================
// RUTE KHUSUS ADMIN (Fase 2)
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Jalur Halaman Utama Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Jalur Otomatis untuk Semua Fungsi CRUD Produk
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
}); // <- Penutup grup rute admin yang benar

require __DIR__.'/auth.php';