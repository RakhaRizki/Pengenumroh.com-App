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

        // 2. Tembak API Kategori
        $responseKategori = Http::get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/category');
        $daftarKategori = [];
        if ($responseKategori->successful()) {
            $daftarKategori = $responseKategori->json('data') ?? []; 
        }

        // Lempar dua-duanya (Produk & Kategori) ke Blade
        return view('marketplace.index', compact('daftarProduk', 'daftarKategori'));
    }

  
    public function produk(Request $request)
    {
        // 1. Tangkap parameter dari URL
        $namaMitra = $request->query('mitra');
        $kategoriFilter = $request->query('kategori'); 

        // 2. Tembak API Kategori
        $responseKategori = Http::get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/category');
        $daftarKategori = $responseKategori->successful() ? ($responseKategori->json('data') ?? []) : [];

        // 3. Tembak API Produk (Ambil Semua)
        $responseProduk = Http::get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products');
        $daftarProduk = $responseProduk->successful() ? ($responseProduk->json('data') ?? []) : [];

        // --- FILTER MITRA TRAVEL (Tetap butuh di PHP) ---
        if (!empty($namaMitra)) {
            $daftarProduk = array_filter($daftarProduk, function($item) use ($namaMitra) {
                $namaTravel = $item['creator']['fullname'] ?? '';
                return stripos($namaTravel, $namaMitra) !== false;
            });
            
            // Rapihkan ulang urutan index array
            $daftarProduk = array_values($daftarProduk); 
        }

        // --- FILTER KATEGORI DIHAPUS DARI PHP ---
        // Semua produk kita lempar ke HTML. 
        // Nanti HTML & Javascript yang bakal nyentang otomatis kotak 'Haji' dan nyembunyiin produk lainnya.

        // 4. Lempar data ke Blade
        return view('marketplace.produk.index', compact('daftarProduk', 'daftarKategori', 'namaMitra', 'kategoriFilter'));
    }

    public function detail($id)
    {
        // 1. Tembak API spesifik berdasarkan ID produk yang dilempar dari URL
        $response = Http::get("https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/{$id}");

        // 2. Cek apakah request sukses dan datanya ada
        if ($response->successful() && $response->json('data')) {
            // Ambil data spesifik dari object 'data'
            $produk = $response->json('data');

            // Return ke view 'marketplace.produk.detail' sambil bawa variabel $produk
            return view('marketplace.produk.detail', compact('produk'));
        }

        // Jika API gagal atau ID produk gak valid, lempar user ke halaman 404 (Not Found)
        abort(404, 'Paket perjalanan tidak ditemukan atau sedang tidak tersedia.');
    }

    public function bandingkan(Request $request)
    {
        // 1. Tangkap parameter 'ids' dari URL (Misal: ?ids=104,105)
        $idsParam = $request->query('ids');
        $produkPerbandingan = [];

        // 2. Kalau ada ID yang dikirim dari Javascript
        if ($idsParam) {
            // Pecah string "104,105" jadi array [104, 105]
            $idsArray = explode(',', $idsParam); 
            
            // Batasi maksimal 2 produk untuk keamanan backend (walaupun di JS udah dibatasin)
            $idsArray = array_slice($idsArray, 0, 2);

            // Looping untuk nembak API satu-satu berdasarkan ID yang dipilih
            foreach ($idsArray as $id) {
                $response = Http::get("https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/{$id}");
                if ($response->successful() && $response->json('data')) {
                    $produkPerbandingan[] = $response->json('data');
                }
            }
        }

        // 3. Lempar data array yang isinya 2 produk itu ke view
        return view('marketplace.bandingkan', compact('produkPerbandingan'));
    }

}