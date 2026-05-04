<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MarketplaceController extends Controller
{
    public function index()
    {
          // 1. Tembak API Produk
        $responseProduk = Http::get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products');
        $daftarProduk = [];
        if ($responseProduk->successful()) {
            $dataAsli = $responseProduk->json('data') ?? []; 
            $daftarProduk = collect($dataAsli)->take(8)->toArray();
        }

          // 2. Tembak API Kategori (BARU)
        $responseKategori = Http::get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/category');
        $daftarKategori = [];
        if ($responseKategori->successful()) {
            // Asumsi datanya juga dibungkus dalam kunci 'data'
            $daftarKategori = $responseKategori->json('data') ?? []; 
        }

        // Lempar dua-duanya (Produk & Kategori) ke Blade
        return view('marketplace.index', compact('daftarProduk', 'daftarKategori'));

        // dd([
        //      'INFO' => 'Ini data produk dari API:',
        //      'PRODUK' => $daftarProduk,
        //      'FULL_RESPONSE' => $response->json()
        // ]);

    }

}