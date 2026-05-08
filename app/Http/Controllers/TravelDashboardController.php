<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TravelDashboardController extends Controller
{
    // Halaman Utama Dashboard Travel (Statistik singkat)
    public function index(Request $request)
    {
        return view('marketplace.travel.index');
    }

    // Halaman Daftar Pesanan Masuk dari Jamaah
    public function pesananMasuk(Request $request)
    {
        return view('marketplace.travel.pesanan-masuk');
    }

    // Halaman Daftar Produk Milik Travel Tersebut
    public function kelolaProduk(Request $request)
    {
        return view('marketplace.travel.kelola-produk');
    }

    // Halaman Form Tambah/Upload Produk Baru
    public function uploadProduk(Request $request)
    {
        return view('marketplace.travel.upload-produk');
    }

    // Halaman Edit Produk
    public function editProduk(Request $request, $id)
    {
        return view('marketplace.travel.edit-produk', compact('id'));
    }
}