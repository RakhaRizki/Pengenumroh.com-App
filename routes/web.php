<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\TravelDashboardController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

// ==========================================================
// AUTHENTICATION
// ==========================================================

// A. Halaman UI Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// B. Proses Tembak API Login 
Route::post('/login/proses', [ApiAuthController::class, 'prosesLogin'])->name('login.proses');

// C. Halaman UI Register (Nampilin desain)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Proses Tembak API Register (Nangkep data dari form)
Route::post('/register/proses', [ApiAuthController::class, 'prosesRegister'])->name('register.proses');

// D. Logout 
Route::post('/logout', [ApiAuthController::class, 'logout'])->name('logout');

// Saat user membuka pengenumroh.com //
Route::get('/', function () {
    return view('beranda'); // Merender beranda.blade.php (company profile)
});

// saat user membuka button loyalty card //
Route::get('/loyaltyCard', function () {
    // 'company.loyaltycard' artinya folder company, file loyaltycard.blade.php
    return view('company.loyaltycard'); 
})->name('company.loyalty');

// untuk kembali ke beranda //
Route::get('/', function () {
    return view('index'); // Sesuaikan dengan nama file HTML/Blade berandamu
})->name('company.beranda'); // <-- Berikan nama, misalnya 'home' atau 'beranda'

// Membungkus semua route yang berawalan '/marketplace' dan bernama 'marketplace.'
Route::prefix('marketplace')->name('marketplace.')->group(function () {

    // Beranda Marketplace 
    Route::get('/', [MarketplaceController::class, 'index'])->name('beranda');

    // ----------------------------------------------------
    // GRUP RUTE PRODUK
    // ----------------------------------------------------

    Route::get('/produk', [MarketplaceController::class, 'produk'])->name('produk.index');

    // DETAIL PAKET
    Route::get('/produk/{id}', [MarketplaceController::class, 'detail'])->name('produk.detail');

   // ==========================================================
    // SUB-GRUP: AREA DASHBOARD MITRA TRAVEL
    // ==========================================================
    // Nanti di sini lu bisa tambahin middleware khusus, misal: ->middleware(['auth', 'role:mitra'])
    Route::prefix('travel')->name('travel.')->group(function () {
        
        Route::get('/', [TravelDashboardController::class, 'index'])->name('profil');
        Route::get('/pesanan-masuk', [TravelDashboardController::class, 'pesananMasuk'])->name('pesanan-masuk');
        Route::get('/kelola-produk', [TravelDashboardController::class, 'kelolaProduk'])->name('kelola-produk');
        Route::get('/upload-produk', [TravelDashboardController::class, 'uploadProduk'])->name('upload-produk');
        Route::get('/kelola-produk/edit/{id}', [TravelDashboardController::class, 'editProduk'])->name('produk.edit');
    });

  // ==========================================================
    // SUB-GRUP: AREA HALAMAN PROFIL MEMBER (JAMAAH)
    // ==========================================================
    Route::prefix('profil')->name('profil.')->group(function () {
        // Halaman Akun / Biodata
        Route::get('/', [UserDashboardController::class, 'index'])->name('index');
        // Halaman Daftar Pesanan
        Route::get('/pesanan', [UserDashboardController::class, 'pesanan'])->name('pesanan');
        // Halaman Wishlist
        Route::get('/wishlist', [UserDashboardController::class, 'wishlist'])->name('wishlist');
        // Update Profile
        Route::post('/update', [UserDashboardController::class, 'updateProfile'])->name('update');
    });

    // Halaman Perbandingan
    Route::get('/bandingkan', [MarketplaceController::class, 'bandingkan'])->name('bandingkan');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');