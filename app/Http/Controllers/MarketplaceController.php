<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MarketplaceController extends Controller
{
    // =======================================================
    // 🛠️ HELPER FUNCTIONS (Biar kode nggak diulang-ulang)
    // =======================================================
    
    // 1. Helper buat URL API dinamis (Bisa diatur dari .env)
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api');
        return $baseUrl . $endpoint;
    }

    // 2. Helper khusus ngambil Wishlist (Sekarang cukup panggil 1 baris, gak perlu nulis belasan baris lagi!)
    private function getWishlistIds($signature)
    {
        $token = session('api_token');
        if (!$token) return []; // Kalau belum login, langsung balikin array kosong

        $wishlistIds = [];
        try {
            $response = Http::timeout(10)->withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ])->get($this->getApiUrl('/products/wishlist'));

            if ($response->successful()) {
                $dataApi = $response->json('data') ?? $response->json() ?? [];
                foreach ($dataApi as $w) {
                    $productData = $w['product'] ?? $w;
                    if (isset($productData['id'])) {
                        $wishlistIds[] = $productData['id'];
                    }
                }
            }
        } catch (\Exception $e) {
            // Silently fail kalau API ngadat, wishlist anggap kosong biar web nggak error
        }
        
        return $wishlistIds;
    }

    // =======================================================
    // 🌐 HALAMAN UTAMA (INDEX)
    // =======================================================
    public function index()
    {
        $signature = config('app.api_signature');

        // 1. TEMBAK API PRODUK & EKSTRAK MITRA
        $responseProduk = Http::timeout(10)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->get($this->getApiUrl('/products'));

        $daftarProduk = [];
        $mitras = []; 

        if ($responseProduk->successful()) {
            $dataAsli = $responseProduk->json('data') ?? [];
            
            $dataPublish = collect($dataAsli)->filter(function ($item) {
                return strtolower($item['status'] ?? '') === 'publish';
            })->map(function ($item) {
                $item['total_quota'] = collect($item['prices'] ?? [])->sum('quota');
                return $item;
            })->values();

            $daftarProduk = $dataPublish->take(8)->toArray();

            $mitras = $dataPublish->map(function ($produk) {
                $userData = $produk['creator'] ?? null;
                if (!$userData) return null;

                $namaFotoDb = $userData['profile']['image'] ?? ($userData['image'] ?? ($userData['avatar'] ?? ''));
                $avatarFinal = '';

                if (!empty($namaFotoDb)) {
                    if (str_starts_with($namaFotoDb, 'http')) {
                        $avatarFinal = $namaFotoDb;
                    } else {
                        // Hilangkan bagian '/api' dari baseUrl untuk assets
                        $domainUtama = str_replace('/api', '', env('API_BASE_URL', 'https://mediumspringgreen-meerkat-585223.hostingersite.com'));
                        $avatarFinal = $domainUtama . '/assets/img/profiles/' . ltrim(trim($namaFotoDb), '/');
                    }
                }

                return [
                    'id'         => $userData['id'] ?? 0,
                    'username'   => $userData['username'] ?? 'Biro Travel',
                    'fullname'   => $userData['fullname'] ?? ($userData['username'] ?? 'Biro Travel'),
                    'avatar_url' => $avatarFinal,
                    'id_level'   => (int) ($userData['id_level'] ?? 4)
                ];
            })->filter(function ($mitra) {
                return $mitra !== null && in_array($mitra['id_level'], [2, 4]);
            })->unique('fullname')->values()->all();
        }

        // 2. TEMBAK API KATEGORI
        $responseKategori = Http::timeout(10)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->get($this->getApiUrl('/category'));
        
        $daftarKategori = $responseKategori->successful() ? ($responseKategori->json('data') ?? []) : [];

        // 3. AMBIL WISHLIST (Panggil helper 1 baris aja)
        $wishlistIds = $this->getWishlistIds($signature);

        return view('marketplace.index', compact('daftarProduk', 'daftarKategori', 'wishlistIds', 'mitras'));
    }

    // =======================================================
    // 📦 HALAMAN SEMUA PRODUK / KATALOG
    // =======================================================
    public function produk(Request $request)
    {
        $signature = config('app.api_signature');
        $namaMitra = $request->query('mitra');
        $kategoriFilter = $request->query('kategori');

        // Tembak API Kategori
        $responseKategori = Http::timeout(10)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->get($this->getApiUrl('/category'));
        $daftarKategori = $responseKategori->successful() ? ($responseKategori->json('data') ?? []) : [];

        // Tembak API Produk
        $responseProduk = Http::timeout(15)->withHeaders([ // Timeout lebih lama buat load semua produk
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->get($this->getApiUrl('/products'));
        
        $dataSemuaProduk = $responseProduk->successful() ? ($responseProduk->json('data') ?? []) : [];

        $daftarProduk = collect($dataSemuaProduk)->filter(function ($item) {
            return strtolower($item['status'] ?? '') === 'publish';
        })->map(function ($item) {
            $item['total_quota'] = collect($item['prices'] ?? [])->sum('quota');
            return $item;
        })->values()->all();

        // Filter Mitra Travel
        if (!empty($namaMitra)) {
            $daftarProduk = array_filter($daftarProduk, function($item) use ($namaMitra) {
                $namaTravel = $item['creator']['fullname'] ?? '';
                return stripos($namaTravel, $namaMitra) !== false;
            });
            $daftarProduk = array_values($daftarProduk);
        }

        // Ambil Wishlist pakai Helper
        $wishlistIds = $this->getWishlistIds($signature);

        return view('marketplace.produk.index', compact('daftarProduk', 'daftarKategori', 'namaMitra', 'kategoriFilter', 'wishlistIds'));
    }

    // =======================================================
    // 🔍 HALAMAN DETAIL PRODUK
    // =======================================================
    public function detail($id)
    {
        $signature = config('app.api_signature');

        // Tembak API spesifik ID (Jangan lupa timeout!)
        $response = Http::timeout(10)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->get($this->getApiUrl("/products/{$id}"));

        if ($response->successful() && $response->json('data')) {
            $produk = $response->json('data');
            $produk['total_quota'] = collect($produk['prices'] ?? [])->sum('quota');

            // Ambil Wishlist pakai Helper (Cuma 1 baris, gila bersih banget kan?)
            $wishlistIds = $this->getWishlistIds($signature);

            return view('marketplace.produk.detail', compact('produk', 'wishlistIds'));
        }

        abort(404, 'Paket perjalanan tidak ditemukan atau sedang tidak tersedia.');
    }

    // =======================================================
    // ⚖️ HALAMAN BANDINGKAN (ADVANCED SECURITY & SELF-HEALING URL)
    // =======================================================
    public function bandingkan(Request $request)
    {
        $signature = config('app.api_signature');
        $idsParam = $request->query('ids');
        $produkPerbandingan = [];

        // Jika URL kosong murni (Gak ada parameter ids)
        // Nanti Javascript di Frontend akan otomatis memanggil ulang URL dengan ID yang benar dari memori HP/Laptop user
        if (empty($idsParam)) {
            return view('marketplace.bandingkan', compact('produkPerbandingan'));
        }

        // 1. Pecah string koma menjadi array & Bersihkan dari karakter aneh
        $idsArray = explode(',', $idsParam);
        $idsArray = array_filter($idsArray, function($id) {
            return !empty(trim($id)) && is_numeric(trim($id));
        });

        // 🚨 SECURITY FIX 1: JIKA USER HAPUS ID ATAU NAMBAH SEMBARANGAN 🚨
        // Kalau ID tidak genap 2 (misal dihapus 1 jadi 'ids=120,'), 
        // JANGAN KASIH ERROR! Kita lempar ke URL bersih. Nanti Javascript akan otomatis nge-REVERT ke parameter aslinya!
        if (count($idsArray) !== 2) {
            return redirect('/marketplace/bandingkan')->with('error', 'Tautan diubah secara ilegal. Mengembalikan data semula...');
        }

        // 2. Ambil data API
        foreach ($idsArray as $id) {
            $id = trim($id);
            
            $response = Http::timeout(10)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ])->get($this->getApiUrl("/products/{$id}"));

            // 🚨 SECURITY FIX 2: JIKA USER TEBAK-TEBAK ID NGASAL 🚨
            if ($response->successful() && $response->json('data')) {
                $produkPerbandingan[] = $response->json('data');
            } else {
                // Kalau ID diganti ke produk yang gak ada di database (misal 9999),
                // JANGAN DITENDANG KE 404. Lempar ke URL bersih, biar sistem me-REVERT otomatis ke produk awal!
                return redirect('/marketplace/bandingkan')->with('error', 'Paket tidak ditemukan. Mengembalikan data semula...');
            }
        }

        return view('marketplace.bandingkan', compact('produkPerbandingan'));
    }


}