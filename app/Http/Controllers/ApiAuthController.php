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

        // Tembak API dan paksa minta JSON
        $response = Http::acceptJson()
            ->post('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/login', $paketLogin);

        // --- LOGIKA SETELAH NEMBAK API ---

        if ($response->successful() && $response->json() === null) {
            return back()->with('error', 'Sistem Backend belum merespon JSON. Hubungi Developer Back-End.');
        }

        if ($response->successful()) {
            
            // ========================================================
            // PERUBAHAN DI SINI: Kita panggil 'user', BUKAN 'data'
            // ========================================================
            $dataUser = $response->json('user') ?? [
                'fullname' => $usernameOtomatis,
                'username' => $usernameOtomatis,
                'email'    => $request->email,
                'id_level' => 3, 
            ];

            // SIMPAN KE SESSION!
            session(['user' => $dataUser]);

            // --- LOGIKA REDIRECT BERDASARKAN ID LEVEL ---
            // Jika yang login adalah Travel (id_level = 4)
            if (isset($dataUser['id_level']) && $dataUser['id_level'] == 4) {
                // Lempar ke Dashboard khusus Mitra Travel
                return redirect('/marketplace/travel')->with('success', 'Selamat datang Mitra Travel!');
            }

            // Jika yang login adalah Jamaah (id_level = 3 atau default)
            return redirect('/marketplace')->with('success', 'Berhasil masuk!');
        }

        // Skenario 3: Login gagal
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
            
            // Langsung ambil angkanya dari request, nggak perlu ucfirst
            'id_level'  => $request->role, 
            'is_active' => 'Y',
            'app'       => 'N', 
        ];

        $response = Http::post('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/user', $paketBuatAPI);

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
        } 
        
        return back()->with('error', 'Gagal mendaftar. Pastikan data benar.');
    }

    // =======================================================
    // 3. PROSES LOGOUT (BARU)
    // =======================================================
    public function logout(Request $request)
    {
        // Hapus session 'user' supaya Navbar balik ke mode "Masuk / Daftar"
        $request->session()->forget('user');
        $request->session()->flush();

        // Tendang balik ke halaman login
        return redirect('/login')->with('success', 'Anda berhasil keluar dari sistem.');
    }
}