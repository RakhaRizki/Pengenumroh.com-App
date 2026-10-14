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

        $user = session('user');
        if (!isset($user['id_level']) || $user['id_level'] != 3) {
            
            if (isset($user['id_level']) && $user['id_level'] == 4) {
                return redirect()->route('marketplace.travel.profil');
            }

            // UBAHAN: Jangan logout, cukup arahkan ke home/beranda
            return redirect('/')->with('error', 'Akses ditolak. Halaman ini khusus Jamaah.');
        }

        return $next($request);
        
    }
}