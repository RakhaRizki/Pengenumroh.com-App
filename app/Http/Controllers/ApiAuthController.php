<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiAuthController extends Controller
{
  
  public function prosesLogin(Request $request)
    {
        // Kita tes kirim data lewat URL (Query String)
        $response = Http::get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/user/login', [
            'username' => explode('@', $request->email)[0],
            'password' => $request->password,
        ]);

        dd([
            'INFO' => 'Ngetes Login via GET (Kirim data lewat URL)',
            'STATUS' => $response->status(),
            'BALASAN' => $response->json(),
        ]);
    }

    public function prosesRegister(Request $request)
    {
        $usernameOtomatis = explode('@', $request->email)[0];

        $paketBuatAPI = [
            'username'  => $usernameOtomatis,
            'fullname'  => $request->name,
            'email'     => $request->email,
            'password'  => $request->password,
            'no_wa'     => $request->no_hp,
            'role'      => ucfirst($request->role), // ucfirst buat ngegedein huruf depan jadi "Jamaah" atau "Travel"
            
            'id_level'  => 3, 
            'is_active' => 'Y',
            'app'       => 'N', 
        ];

        // 2. TEMBAK API (HAPUS asForm() BIAR BALIK PAKE FORMAT JSON)
        $response = Http::post('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/user', $paketBuatAPI);

        // ========================================================
        // Ngetes API
        // ========================================================
        // dd([
        //     '1. PAKET YANG DIKIRIM KE API' => $paketBuatAPI,
        //     '2. STATUS HTTP DARI API' => $response->status(),
        //     '3. BALASAN API' => $response->json(),
        // ]);

        if ($response->successful()) {
            return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
        } 
        
        return back()->with('error', 'Gagal mendaftar. Pastikan data benar.');
    }

}
