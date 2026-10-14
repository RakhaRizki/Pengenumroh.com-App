<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiAuthController extends Controller
{
    // Ambil Base URL dari .env (Otomatis pakai default kalau di .env belum ada)
    private function getApiUrl($endpoint)
    {
        $baseUrl = env('API_BASE_URL', 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api');
        return $baseUrl . $endpoint;
    }

    // =======================================================
    // 1. PROSES LOGIN
    // =======================================================
    public function prosesLogin(Request $request)
    {
        // 1. BENTENG VALIDASI (Cegah Error 500)
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $usernameOtomatis = explode('@', $request->email)[0];

        $paketLogin = [
            'username' => $usernameOtomatis,
            'fullname' => $usernameOtomatis,
            'password' => $request->password,
        ];

        // 2. TAMBAH TIMEOUT 15 Detik & Gunakan Dynamic URL
        $response = Http::timeout(15)->acceptJson()->post($this->getApiUrl('/login'), $paketLogin);

        if ($response->successful()) {
            
            $resBody = $response->json();
            $dataUser = $resBody['user'] ?? null;
            $token = $resBody['token'] ?? $resBody['access_token'] ?? null;

            if (!$token) {
                return back()->with('error', 'Token tidak ditemukan dari API. Hubungi Backend.');
            }

            $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($dataUser['fullname'] ?? 'User') . '&background=F97316&color=fff';
            $userId = $dataUser['id'] ?? $dataUser['id_user'] ?? null;

            if ($userId) {
                try {
                    $profileRes = Http::withToken($token)->timeout(3)->get($this->getApiUrl('/user/' . $userId));
                    
                    if ($profileRes->successful()) {
                        $apiData = $profileRes->json('data') ?? $profileRes->json();
                        if (isset($apiData[0])) $apiData = $apiData[0];
                        $profileData = $apiData['profile'][0] ?? $apiData['profile'] ?? [];
                        
                        if (!empty($profileData['image'])) {
                            $foto = ltrim($profileData['image'], '/');
                            $avatarUrl = str_starts_with($foto, 'http') ? $foto : str_replace('/api', '', env('API_BASE_URL')) . '/assets/img/profiles/' . $foto;
                        }
                    }
                } catch (\Exception $e) {
                    // Silently fail, tetap pakai avatar inisial
                }
            }

            // Mencegah Session Fixation sebelum membuat sesi baru
            $request->session()->regenerate();

            session([
                'user' => $dataUser,
                'api_token' => $token,
                'user_avatar' => $avatarUrl
            ]);

            if (isset($dataUser['id_level']) && $dataUser['id_level'] == 4) {
                return redirect()->route('marketplace.travel.profil')->with('success', 'Selamat datang Mitra Travel!');
            }

            return redirect()->route('marketplace.profil.index')->with('success', 'Berhasil masuk!');
        }

        $pesanError = $response->json('message') ?? 'Gagal masuk. Periksa kembali email dan kata sandi Anda.';
        return back()->with('error', $pesanError);
    }

    // =======================================================
    // 2. PROSES REGISTER
    // =======================================================
    public function prosesRegister(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email',
            'no_hp'    => 'required',
            'password' => 'required|min:6',
            'role'     => 'required'
        ], [
            'password.min' => 'Gagal! Kata sandi harus minimal 6 karakter.'
        ]);

        $usernameOtomatis = explode('@', $request->email)[0];
        
        $paketBuatAPI = [
            'username'  => $usernameOtomatis,
            'fullname'  => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
            'no_wa'     => $request->no_hp,
            'id_level'  => $request->role,
            'is_active' => 'Y',
        ];

        // Tambah Timeout & Dynamic URL
        $response = Http::timeout(15)->post($this->getApiUrl('/user'), $paketBuatAPI);

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
        }

        $pesanError = $response->json('message') ?? 'Gagal mendaftar. Pastikan data benar.';
        return back()->with('error', $pesanError);
    }

    // =======================================================
    // 3. PROSES LOGOUT
    // =======================================================
    public function logout(Request $request)
    {
        $token = session('api_token');

        if ($token) {
            // Pasang timeout agar logout tidak bikin web macet
            Http::timeout(5)->withToken($token)->post($this->getApiUrl('/logout'));
        }

        // Keamanan tingkat tinggi untuk Laravel Logout
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda berhasil keluar dari sistem.');
    }
}