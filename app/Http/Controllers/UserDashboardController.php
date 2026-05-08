<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 

class UserDashboardController extends Controller
{
    
  private function getProfileData()
    {
        // 1. Ambil token dan data user dari session pas login
        $token = session('api_token'); 
        $sessionUser = session('user'); // <-- UBAHAN: Tarik data user di session

        if (!$token || !$sessionUser) {
            return null;
        }

        // 2. Ambil ID User-nya (Biar bisa manggil per ID)
        $userId = $sessionUser['id'] ?? $sessionUser['id_user'] ?? null;

        if (!$userId) {
            return null;
        }

        try {
            // 3. UBAHAN: URL-nya sekarang dinamis ditambahin ID di belakangnya
            $urlAPI = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/user/' . $userId;
            
            $response = Http::withToken($token)
                            ->timeout(5) 
                            ->get($urlAPI);

            // dd($response->json());

            if ($response->successful()) {
                // Ambil datanya
                $apiData = $response->json('data') ?? $response->json();
                
                // 4. UBAHAN: Jaga-jaga kalau backend masih ngebungkus di dalam array [0]
                if (isset($apiData[0])) {
                    $apiData = $apiData[0];
                }
                
                // Ambil bungkus 'profile'
                $profileData = $apiData['profile'][0] ?? $apiData['profile'] ?? [];

                $nama = $apiData['fullname'] ?? $apiData['username'] ?? 'Jamaah';

                return [
                    'nama'        => $nama, 
                    'email'       => $apiData['email'] ?? 'Belum ada email',
                    'telepon'     => $apiData['no_wa'] ?? '-',
                    'avatar'      => 'https://ui-avatars.com/api/?name=' . urlencode($nama) . '&background=ea580c&color=fff',
                    'bergabung'   => isset($apiData['createdAt']) ? date('M Y', strtotime($apiData['createdAt'])) : 'Baru bergabung',
                    'tanggal_lahir' => $profileData['tgl_lahir'] ?? '',
                    'address'     => $profileData['address'] ?? '',
                    'no_nik'      => $profileData['no_nik'] ?? '',
                    'no_paspor'   => $profileData['no_paspor'] ?? '',
                    'nama_paspor' => $profileData['nama_paspor'] ?? '',
                    'jk'          => $profileData['jk'] ?? '',
                ];
            }
        } catch (\Exception $e) {
            // Kalau koneksi putus / error
            return null;
        }

        return null;
    }

    /**
     * 1. Halaman Profil Utama
     */
    public function index(Request $request)
    {
        $userProfile = $this->getProfileData();

        if (!$userProfile) {
            // Hapus session kotor sebelum ditendang ke login
            session()->forget(['api_token', 'user']);
            
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu atau sesi Anda telah habis.');
        }

        return view('marketplace.user.profil', compact('userProfile'));
    }

    /**
     * 2. Halaman Riwayat Pesanan
     */
    public function pesanan(Request $request)
    {
        $userProfile = $this->getProfileData();

        if (!$userProfile) {
            return redirect()->route('login');
        }

        return view('marketplace.user.pesanan', compact('userProfile'));
    }

    /**
     * 3. Halaman Wishlist
     */
    public function wishlist(Request $request)
    {
        $userProfile = $this->getProfileData();

        if (!$userProfile) {
            return redirect()->route('login');
        }

        return view('marketplace.user.wishlist', compact('userProfile'));
    }

   public function updateProfile(Request $request)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login ulang.');
        }

        // Bungkus data dari form HTML
        $payloadData = [
            'address'     => $request->address,
            'no_paspor'   => $request->no_paspor,
            'nama_paspor' => $request->nama_paspor,
            'jk'          => $request->jk,
            'no_nik'      => $request->no_nik,
            // Asumsi temen lu pake nama no_telp buat nomor WA
            'no_wa'     => $request->telepon, 
            'tgl_lahir'     => $request->tanggal_lahir,
        ];

        // Tembak API Profile dengan metode POST
        $response = Http::withToken($token)
            ->post('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/my-profile', $payloadData);

        if ($response->successful()) {
            // Kalau sukses, balikin ke halaman profil bawa pesan sukses
            return back()->with('success', 'Data profil berhasil diperbarui!');
        }

        // Kalau gagal, ambil pesan error dari backend
        $pesanError = $response->json('message') ?? 'Gagal memperbarui profil.';
        return back()->with('error', $pesanError);
    }

}