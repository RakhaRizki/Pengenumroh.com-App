<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==========================================================
// AUTHENTICATION (UI / STATIS)
// ==========================================================

// 1. Halaman Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// 2. Halaman Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

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

    // KATEGORI

     // Kategori Umroh 9 Hari
    Route::get('/produk/umroh-9-hari', function () {
        return view('marketplace.produk.umroh-9-hari'); 
    })->name('produk.umroh-9-hari');

     // Kategori Umroh 12 Hari
    Route::get('/produk/umroh-12-hari', function () {
        return view('marketplace.produk.umroh-12-hari'); 
    })->name('produk.umroh-12-hari');

     // Kategori Umroh Plus Wisata
    Route::get('/produk/umroh-plus-wisata', function () {
        return view('marketplace.produk.umroh-plus-wisata'); 
    })->name('produk.umroh-plus-wisata');

     // Kategori Umroh Ramadhan
    Route::get('/produk/umroh-ramadhan', function () {
        return view('marketplace.produk.umroh-ramadhan'); 
    })->name('produk.umroh-ramadhan');

   // Kategori Haji Khusus
    Route::get('/produk/haji-khusus', function () {
        return view('marketplace.produk.haji-khusus'); 
    })->name('produk.haji-khusus');

   // Kategori Haramainku Travel
    Route::get('/produk/travel/haramainku-travel', function () {
        return view('marketplace.produk.travel.haramainku-travel'); 
    })->name('produk.travel.haramainku-travel');

    // DETAIL PAKET

    // {{ route('marketplace.produk.haji-khusus-program-26-hari') }}

    // Detail Paket 1
    Route::get('/produk/umroh-9-hari/easy-22-juni-2026', function () {
        return view('marketplace.produk.easy-22-juni-2026'); // Nama file blade
    })->name('produk.easy-22-juni-2026');

    // Detail Paket 2
    Route::get('/produk/umroh-15-hari/libur-lebaran-23-maret-2026', function () {
        return view('marketplace.produk.libur-lebaran-23-maret-2026'); // Nama file blade
    })->name('produk.libur-lebaran-23-maret-2026');

    // Detail Paket 3
    Route::get('/produk/haji-khusus/haji-khusus-program-26-hari', function () {
        return view('marketplace.produk.haji-khusus-program-26-hari'); // Nama file blade
    })->name('produk.haji-khusus-program-26-hari');

    // ==========================================================
    // SUB-GRUP: AREA DASHBOARD MITRA TRAVEL
    // ==========================================================
    Route::prefix('travel')->name('travel.')->group(function () {
        
        // Nama Route: marketplace.travel.profil
        Route::get('/', function () {
            return view('marketplace.travel.index'); 
        })->name('profil');

        // URL: domain.com/marketplace/travel/pesanan-masuk
        Route::get('/pesanan-masuk', function () {
            return view('marketplace.travel.pesanan-masuk'); 
        })->name('pesanan-masuk');

        // URL: domain.com/marketplace/travel/upload-produk
        Route::get('/upload-produk', function () {
            return view('marketplace.travel.upload-produk'); 
        })->name('upload-produk');

        // URL: domain.com/marketplace/travel/produk/tambah
        Route::get('/kelola-produk', function () {
            return view('marketplace.travel.kelola-produk'); 
        })->name('kelola-produk');

        Route::get('/kelola-produk/edit', function () {
    return view('marketplace.travel.edit-produk'); 
})->name('produk.edit');

    });

    // ==========================================================
    // SUB-GRUP: AREA HALAMAN PROFIL MEMBER
    // ==========================================================
    Route::prefix('profil')->name('profil.')->group(function () {

        // URL: domain.com/marketplace/profil
        // Nama Route: marketplace.profil.index
        Route::get('/', function () {
            return view('marketplace.profil.index'); 
        })->name('index');

        // URL: domain.com/marketplace/profil/pesanan
        Route::get('/pesanan', function () {
            return view('marketplace.profil.pesanan'); 
        })->name('pesanan');

        // URL: domain.com/marketplace/profil/wishlist
        Route::get('/wishlist', function () {
            return view('marketplace.profil.wishlist'); 
        })->name('wishlist');
    });

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