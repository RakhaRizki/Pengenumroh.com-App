<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TravelDashboardController extends Controller
{
    // Benerin Base URL: Cukup sampai /api
    private $apiUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api';

    public function index(Request $request)
    {
        $token = session('api_token');
        $user = session('user');

        // URL jadi: https://.../api/transaction
        $response = Http::withToken($token)->get($this->apiUrl . '/transaction');

        $statistik = [];
        if ($response->successful()) {
            $statistik = $response->json('data') ?? [];
        }

        return view('marketplace.travel.dashboard', compact('statistik', 'user'));
    }

   // =======================================================
    // Update Data Profil Travel (100% Clone dari Jamaah)
    // =======================================================
    public function updateProfile(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login ulang.');
        }

        // 1. Siapkan data teks (Sesuai dengan name input di Blade Travel)
        $payloadData = [
            'fullname' => $request->fullname,
        ];

        $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/my-profile';

        $apiRequest = Http::withToken($token);

        // 2. LOGIKA EXACTLY SAMA DENGAN JAMAAH
        if ($request->hasFile('avatar')) {
            $foto = $request->file('avatar');
            $response = $apiRequest->attach(
                'image', file_get_contents($foto->getPathname()), $foto->getClientOriginalName()
            )->put($urlApi, $payloadData);
        } else {
            $response = $apiRequest->put($urlApi, $payloadData);
        }

        // Fallback POST kalau PUT ditolak (404)
        if ($response->status() == 404 || stripos($response->json('message') ?? '', 'tidak ditemukan') !== false) {
            $apiRequestRetry = Http::withToken($token);
            if ($request->hasFile('avatar')) {
                $foto = $request->file('avatar');
                $response = $apiRequestRetry->attach(
                    'image', file_get_contents($foto->getPathname()), $foto->getClientOriginalName()
                )->post($urlApi, $payloadData);
            } else {
                $response = $apiRequestRetry->post($urlApi, $payloadData);
            }
        }

      // 3. Cek Hasil Akhirnya
        if ($response->successful()) {  
            $userData = session('user');
            $userData['fullname'] = $request->input('fullname');
            
            $responseData = $response->json('data');

            // 👇 KITA PAKAI FOLDER YANG SAMA PERSIS DENGAN PUNYA JAMAAH
            if (isset($responseData['image']) && $responseData['image'] != null) {
                
                $namaFoto = ltrim($responseData['image'], '/'); // Bersihkan garis miring biar rapi
                
                // INI FOLDER ASLINYA DARI BACKEND LU!
                $baseImageUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/profiles/'; 
                
                $newAvatar = $baseImageUrl . $namaFoto;
                $userData['avatar_url'] = $newAvatar;
                session(['user_avatar' => $newAvatar]);
                session(['foto_global_navbar' => $newAvatar]);
            }
            
            session(['user' => $userData]);

            return back()->with('success', 'Data profil berhasil disimpan!');
        }

        // Kalau masih error
        $pesanError = $response->json('message') ?? 'Gagal memperbarui profil.';
        return back()->with('error', $pesanError);

    }

    // =======================================================
    // Update Password Travel
    // =======================================================
    public function updatePassword(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login ulang.');
        }

        // 1. Validasi
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', 
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok!',
            'new_password.min' => 'Password baru minimal 6 karakter!'
        ]);

        // 2. Tembak API Backend
        $response = Http::withToken($token)->post('https://mediumspringgreen-meerkat-585223.hostingersite.com/changePassword', [
            'oldPassword'     => $request->current_password,
            'newPassword'     => $request->new_password,
            'confirmPassword' => $request->new_password 
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Password berhasil diubah!');
        }

        $pesanAsliServer = strtolower($response->json('message') ?? '');

        if (
            str_contains($pesanAsliServer, 'wrong') || 
            str_contains($pesanAsliServer, 'incorrect') || 
            str_contains($pesanAsliServer, 'match') || 
            str_contains($pesanAsliServer, 'salah') ||
            str_contains($pesanAsliServer, 'lama')
        ) {
            return back()->with('error', 'Password lama yang Anda masukkan salah!');
        }

        $pesanError = $response->json('message') ?? 'Gagal mengubah password. Silakan coba lagi nanti.';
        return back()->with('error', $pesanError);
    }

   // =======================================================
    // Halaman Pesanan Masuk (Travel)
    // =======================================================
    public function pesananMasuk(Request $request)
    {
        $token = session('api_token');
        
        $sessionUser = session('user');
        $myTravelId = $sessionUser['id'] ?? $sessionUser['id_user'] ?? null;
        
        if (!$token || !$myTravelId) {
            return redirect()->route('login')->with('error', 'Sesi telah berakhir. Silakan login kembali.');
        }

        try {
            $response = Http::withToken($token)
                ->timeout(15) 
                ->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions');

            $pesanan = [];

            if ($response->successful()) {
                $rawData = $response->json('data') ?? $response->json() ?? [];
                
                if (is_array($rawData)) {
                    // 👇 LOGIKA FILTER 100% PRESISI BERDASARKAN HASIL DD() 👇
                    $pesanan = collect($rawData)
                        ->filter(function ($trx) use ($myTravelId) {
                            // Ambil user_id dari dalam object product
                            $pemilikProduk = $trx['product']['user_id'] ?? null;
                            
                            // Hanya loloskan transaksi kalau produknya punya Travel ini
                            return $pemilikProduk == $myTravelId;
                        })
                        ->sortByDesc('created_at')
                        ->values()
                        ->toArray();
                }
            } else {
                $pesanError = $response->json('message') ?? 'Terjadi kesalahan pada server API.';
                session()->now('error', 'Gagal memuat daftar pesanan: ' . $pesanError);
            }

        } catch (\Exception $e) {
            $pesanan = [];
            session()->now('error', 'Koneksi ke server terputus. Silakan coba lagi nanti.');
        }

        return view('marketplace.travel.pesanan', compact('pesanan'));
    }

    // =======================================================
    // Aksi Verifikasi Pembayaran (AJAX) - Fix Validation
    // =======================================================
    public function verifikasiPembayaran(Request $request, $id)
    {
        $token = session('api_token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Sesi telah berakhir. Silakan refresh halaman.'], 401);
        }

        try {
            $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions/' . $id;

            // Meneruskan 'status' dan 'evidence_url' yang dikirim dari JS agar lolos validasi backend
            $response = Http::withToken($token)->put($urlApi, [
                'status'       => 'PAID',
                'evidence_url' => $request->input('evidence_url') 
            ]);

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Pembayaran berhasil diverifikasi!']);
            }

            // Menangkap pesan error asli dari validator backend
            $pesanError = $response->json('message') ?? 'Gagal memverifikasi di server.';
            return response()->json(['status' => 'error', 'message' => $pesanError], 400);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Koneksi ke server terputus.'], 500);
        }
    }

    public function kelolaProduk(Request $request)
    {
        $token = session('api_token');
        // URL jadi: https://.../api/product
        $response = Http::withToken($token)->get($this->apiUrl . '/product');
        $produk = $response->successful() ? $response->json('data') : [];

        return view('marketplace.travel.kelola-produk', compact('produk'));
    }

    public function uploadProduk(Request $request)
    {
        return view('marketplace.travel.upload-produk');
    }

    public function editProduk(Request $request, $id)
    {
        $token = session('api_token');
        
        // URL jadi: https://.../api/product/{id}
        $response = Http::withToken($token)->get($this->apiUrl . '/product/' . $id);
        $detailProduk = $response->successful() ? $response->json('data') : null;

        if (!$detailProduk) {
            return redirect()->route('travel.kelola-produk')->with('error', 'Produk tidak ditemukan.');
        }

        return view('marketplace.travel.edit-produk', compact('id', 'detailProduk'));
    }
}