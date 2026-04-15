<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    // URL Akhir: domain.com/marketplace
    // Nama Route: marketplace.beranda
    Route::get('/', function () {
        return view('marketplace.index'); 
    })->name('beranda');

    // ----------------------------------------------------
    // GRUP RUTE PRODUK
    // ----------------------------------------------------

    // 1. Halaman SEMUA Produk / Katalog (TIDAK PAKE SLUG)
    // URL: domain.com/marketplace/paket
    Route::get('/produk', function () {
        return view('marketplace.produk.index'); 
    })->name('produk.index');

   // 2. KATALOG PER KATEGORI (domain.com/marketplace/produk/haji-khusus)
    Route::get('/produk/{kategori_slug}', function ($kategori_slug) {
        return view('marketplace.produk.kategori', ['kategori' => $kategori_slug]);
    })->name('produk.kategori');

    // 3. DETAIL PRODUK (domain.com/marketplace/produk/haji-khusus/furoda-2026)
    Route::get('/produk/{kategori_slug}/{produk_slug}', function ($kategori_slug, $produk_slug) {
        return view('marketplace.produk.detail', [
            'kategori' => $kategori_slug,
            'slug' => $produk_slug
        ]);
    })->name('produk.detail');

    // ----------------------------------------------------
    // GRUP RUTE PERBANDINGAN
    // ----------------------------------------------------

    // Halaman Perbandingan
    // URL Akhir: domain.com/marketplace/bandingkan
    // Nama Route: marketplace.bandingkan
    Route::get('/bandingkan', function () {
        return view('marketplace.bandingkan'); 
    })->name('bandingkan');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// {{ asset('assets/img/company/logo.webp') }}
// {{ asset('assets/css/company.css') }
// background-image: url('{{ asset('assets/img/mengapamemilih.webp') }}');