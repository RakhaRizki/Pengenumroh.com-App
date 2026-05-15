<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiAuthController extends Controller
{
    // =======================================================
    // 1. PROSES LOGIN
    // =======================================================
    public function prosesLogin(Request $request)
    {
        $usernameOtomatis = explode('@', $request->email)[0];

        $paketLogin = [
            'username' => $usernameOtomatis,
            'fullname' => $usernameOtomatis, 
            'password' => $request->password,
        ];

        $response = Http::acceptJson()
            ->post('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/login', $paketLogin);

        if ($response->successful()) {
            
            // 1. Ambil body JSON secara utuh dulu biar gampang debug
            $resBody = $response->json();
            
            // 2. Ambil data user dari key 'user' sesuai struktur API lu
            $dataUser = $resBody['user'] ?? null;

            // dd('DATA USER DARI BACKEND: ', $dataUser);

            // 3. AMBIL TOKEN (Sangat Penting!)
            // Pastikan key-nya 'token' atau 'access_token' sesuai respon API lu
            $token = $resBody['token'] ?? $resBody['access_token'] ?? null;

            if (!$token) {
                return back()->with('error', 'Token tidak ditemukan dari API. Hubungi Backend.');
            }

            // 👇 AWAL TAMBAHAN LOGIKA PINTAR BUAT NGAMBIL FOTO PP 👇
            $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($dataUser['fullname'] ?? 'User') . '&background=F97316&color=fff';
            $userId = $dataUser['id'] ?? $dataUser['id_user'] ?? null;

            if ($userId) {
                try {
                    // Tembak API secara rahasia pas login buat narik foto
                    $profileRes = Http::withToken($token)->timeout(3)->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/user/' . $userId);
                    
                    if ($profileRes->successful()) {
                        $apiData = $profileRes->json('data') ?? $profileRes->json();
                        if (isset($apiData[0])) $apiData = $apiData[0];
                        $profileData = $apiData['profile'][0] ?? $apiData['profile'] ?? [];
                        
                        // Kalau ternyata user punya foto di database, kita ubah linknya!
                        if (!empty($profileData['image'])) {
                            $foto = ltrim($profileData['image'], '/');
                            $avatarUrl = str_starts_with($foto, 'http') ? $foto : 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/profiles/' . $foto;
                        }
                    }
                } catch (\Exception $e) {
                    // Kalau API gagal, tetep aman pakai avatar inisial
                }
            }

            // 4. SIMPAN KE SESSION
            session([
                'user' => $dataUser,
                'api_token' => $token,
                'user_avatar' => $avatarUrl 
            ]);

            // 5. LOGIKA REDIRECT (Gunakan Route Name agar lebih aman)
            
            // Jika Travel (id_level = 4)
            if (isset($dataUser['id_level']) && $dataUser['id_level'] == 4) {
                return redirect()->route('marketplace.travel.profil')->with('success', 'Selamat datang Mitra Travel!');
            }

            // Jika Jamaah (id_level = 3)
            // PERBAIKAN: Arahkan ke route index profil yang sudah kita buat
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
        $usernameOtomatis = explode('@', $request->email)[0];

        $paketBuatAPI = [
            'username'  => $usernameOtomatis,
            'fullname'  => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
            'no_wa'     => $request->no_hp,
            'id_level'  => $request->role, 
            'is_active' => 'Y',
            'app'       => 'N', 
        ];

        $response = Http::post('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/user', $paketBuatAPI);

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
        } 
        
        // UPDATE: Tampilkan pesan error asli dari API kalau ada (misal: "Email sudah terdaftar")
        $pesanError = $response->json('message') ?? 'Gagal mendaftar. Pastikan data benar.';
        return back()->with('error', $pesanError);
    }

    // =======================================================
    // 3. PROSES LOGOUT (BARU)
    // =======================================================
    public function logout(Request $request)
    {
        $token = session('api_token');

        // UPDATE: Beritahu backend untuk mematikan token ini (Best Practice Keamanan)
        if ($token) {
            Http::withToken($token)->post('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/logout');
        }

        // Hapus SEMUA session terkait akun
        $request->session()->forget('user');
        $request->session()->forget('api_token');
        $request->session()->flush();

        // Tendang balik ke halaman login
        return redirect('/login')->with('success', 'Anda berhasil keluar dari sistem.');
    }
}