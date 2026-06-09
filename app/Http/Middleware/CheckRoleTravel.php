<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRoleTravel
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Cek apakah user udah login (punya token)
        if (!session()->has('api_token') || !session()->has('user')) {
            return redirect()->route('login')->with('error', 'Sesi telah berakhir. Silakan login kembali.');
        }

        // 2. Cek apakah rolenya BUKAN Travel (id_level = 4)
        $user = session('user');
        if (!isset($user['id_level']) || $user['id_level'] != 4) {
            
            // Kalau dia ternyata Jamaah (id_level = 3), lempar ke dashboard jamaah
            if (isset($user['id_level']) && $user['id_level'] == 3) {
                return redirect()->route('marketplace.profil.index');
            }

            // Kalau role lainnya yang gak jelas, paksa logout
            session()->flush();
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini khusus Mitra Travel.');
        }

        return $next($request);
    }
}