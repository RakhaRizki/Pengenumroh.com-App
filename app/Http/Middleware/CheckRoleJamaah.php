<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleJamaah
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek apakah user udah login (punya token)
        if (!session()->has('api_token') || !session()->has('user')) {
            return redirect()->route('login')->with('error', 'Sesi telah berakhir. Silakan login kembali.');
        }

        // 2. Cek apakah rolenya BUKAN Jamaah (id_level = 3)
        $user = session('user');
        if (!isset($user['id_level']) || $user['id_level'] != 3) {
            
            // Kalau dia ternyata Travel (id_level = 4), lempar ke dashboard travel
            if (isset($user['id_level']) && $user['id_level'] == 4) {
                return redirect()->route('marketplace.travel.profil');
            }

            // Kalau role lainnya yang gak jelas, paksa logout
            session()->flush();
            return redirect()->route('login')->with('error', 'Akses ditolak. Akun Anda bukan jamaah.');
        }

        return $next($request);
    }
}