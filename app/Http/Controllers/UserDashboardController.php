<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use Carbon\Carbon;

class UserDashboardController extends Controller
{
    
 private function getProfileData()
    {
        // 1. Ambil token dan data user dari session pas login
        $token = session('api_token'); 
        $sessionUser = session('user'); // <-- INI PENTING, JANGAN DIHAPUS

        if (!$token || !$sessionUser) {
            return null;
        }

        // 2. Ambil ID User-nya
        $userId = $sessionUser['id'] ?? $sessionUser['id_user'] ?? null;

        if (!$userId) {
            return null;
        }

        try {
            // URL TETAP PAKE CARA LAMA BIAR DATA NGGAK HILANG
            $urlAPI = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/user/' . $userId;
            
            $response = Http::withToken($token)
                            ->timeout(5) 
                            ->get($urlAPI);

            if ($response->successful()) {
                // Ambil datanya
                $apiData = $response->json('data') ?? $response->json();
                
                // Jaga-jaga kalau backend masih ngebungkus di dalam array [0]
                if (isset($apiData[0])) {
                    $apiData = $apiData[0];
                }
                
                // Ambil bungkus 'profile'
                $profileData = $apiData['profile'][0] ?? $apiData['profile'] ?? [];

                // dd([
                //     'Data Utama (User)' => $apiData,
                //     'Data Profil (Detail)' => $profileData
                // ]);

                $nama = $apiData['fullname'] ?? $apiData['username'] ?? 'Jamaah';

                // --- 1. LOGIKA TANGGAL BERGABUNG (BAHASA INDONESIA) ---
                $bergabung = 'Baru bergabung';
                if (isset($apiData['createdAt'])) {
                    $bergabung = Carbon::parse($apiData['createdAt'])->locale('id')->translatedFormat('F Y');
                }

                // Siapkan variabel tanggal lahir dulu
                $tanggalLahir = (isset($profileData['tgl_lahir']) && $profileData['tgl_lahir']) 
                                    ? date('Y-m-d', strtotime($profileData['tgl_lahir'])) 
                                    : '';

                // --- 2. LOGIKA HITUNG PERSENTASE KELENGKAPAN DATA ---
                $fieldDicek = [
                    $nama, 
                    $apiData['email'] ?? null, 
                    $apiData['no_wa'] ?? null, 
                    $tanggalLahir, 
                    $profileData['address'] ?? null, 
                    $profileData['no_nik'] ?? null, 
                    $profileData['no_paspor'] ?? null, 
                    $profileData['nama_paspor'] ?? null, 
                    $profileData['jk'] ?? null
                ];

                $fieldTerisi = 0;
                foreach ($fieldDicek as $field) {
                    if (!empty($field) && $field !== '-') {
                        $fieldTerisi++;
                    }
                }
                $persentaseKelengkapan = round(($fieldTerisi / count($fieldDicek)) * 100);

                // --- 3. LOGIKA FOTO PROFIL (AVATAR) ---
                $fotoBackend = $profileData['image'] ?? null;
                // Kalau ada foto, pake url dari backend (asumsi foldernya /storage/). Kalau nggak ada, pake inisial.
                $avatarUrl = $fotoBackend 
                    ? 'https://mediumspringgreen-meerkat-585223.hostingersite.com/storage/' . $fotoBackend 
                    : 'https://ui-avatars.com/api/?name=' . urlencode($nama) . '&background=ea580c&color=fff';

                return [
                    'nama'          => $nama, 
                    'email'         => $apiData['email'] ?? 'Belum ada email',
                    'telepon'       => $apiData['no_wa'] ?? '-',
                    
                    // 👇 Variabel Avatar diubah manggil $avatarUrl
                    'avatar'        => $avatarUrl,
                    
                    'bergabung'     => $bergabung,
                    'kelengkapan'   => $persentaseKelengkapan, 
                    'tanggal_lahir' => $tanggalLahir,

                    'address'       => $profileData['address'] ?? '',
                    'no_nik'        => $profileData['no_nik'] ?? '',
                    'no_paspor'     => $profileData['no_paspor'] ?? '',
                    'nama_paspor'   => $profileData['nama_paspor'] ?? '',
                    'jk'            => $profileData['jk'] ?? '',
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

        // 1. Ambil token user dari session
        $token = session('api_token');

        // 2. Tembak API Wishlist dari backend
        $response = Http::withToken($token)->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/wishlist');

        // 3. Cek hasilnya
        if ($response->successful()) {
            // Biasanya data API dibungkus di dalam key 'data'. Kalau nggak ada, ambil semua json-nya.
            $wishlistData = $response->json('data') ?? $response->json() ?? [];
            
            // 👇 BUKA KOMENTAR DD() INI KALAU HALAMANNYA ERROR / BLANK 👇
            // dd($wishlistData); 

        } else {
            // Kalau API lagi down / error, kasih array kosong biar nggak error di HTML
            $wishlistData = [];
        }

        // Lempar variabel $wishlistData ke tampilan HTML
        return view('marketplace.user.wishlist', compact('userProfile', 'wishlistData'));
    }

   public function toggleWishlist(Request $request)
    {
        $token = session('api_token');

        // Proteksi API
        if (!$token) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $productId = $request->product_id;
        $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/wishlist';

        // 1. KITA COBA TAMBAHIN DULU (POST)
        $response = Http::withToken($token)->post($urlApi, [
            'product_id' => $productId
        ]);

        $apiData = $response->json();
        $pesan = $apiData['message'] ?? '';

        // 2. LOGIKA PINTAR: Kalau API nolak karena "udah ada", berarti kita harus HAPUS (DELETE)!
        if (stripos($pesan, 'already') !== false || $response->status() == 400) {
            
            // Asumsi standar API: buat hapus pakai method DELETE dan naruh ID di URL
            // Kalau API temen lu beda (misal ID-nya ditaruh di body), tinggal disesuaikan.
            $deleteResponse = Http::withToken($token)->delete($urlApi . '/' . $productId);

            // Coba skenario 2 kalau API temen lu butuh ID di dalem Body (bukan di URL)
            if ($deleteResponse->status() == 404 || $deleteResponse->status() == 405) {
                 $deleteResponse = Http::withToken($token)->delete($urlApi, [
                     'product_id' => $productId
                 ]);
            }

            if ($deleteResponse->successful()) {
                return response()->json([
                    'status' => 'success',
                    'action' => 'removed',
                    'message' => 'Berhasil dihapus dari wishlist'
                ], 200);
            }

            return response()->json(['message' => 'Gagal menghapus data di server'], 500);
        }

        // 3. Kalau POST-nya sukses (Berarti produk emang belum ada dan berhasil ditambah)
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'action' => 'added',
                'message' => 'Berhasil ditambah ke wishlist'
            ], 200);
        }

        // Kalau error lain (misal server down)
        return response()->json(['message' => $pesan ?: 'Gagal terhubung ke server backend'], $response->status());
    }

 public function updateProfile(Request $request)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login ulang.');
        }

        // 1. Siapkan data teks yang mau di-update (Gue udah tambahin fullname!)
        $payloadData = [
            'fullname'    => $request->nama, // <-- Ini yang kelupaan kemaren
            'address'     => $request->address,
            'no_paspor'   => $request->no_paspor,
            'nama_paspor' => $request->nama_paspor,
            'jk'          => $request->jk,
            'no_nik'      => $request->no_nik,
            'no_wa'       => $request->telepon, 
            'tgl_lahir'   => $request->tanggal_lahir,
        ];

        // 2. Siapkan penembak API (HTTP Client)
        $apiRequest = Http::withToken($token);

        // 3. Eksekusi API
        if ($request->hasFile('avatar')) {
            $foto = $request->file('avatar');
            
            // Note: Kunci fotonya sementara gue tebak 'image'.
            $response = $apiRequest->attach(
                'image', file_get_contents($foto->getPathname()), $foto->getClientOriginalName()
            )->put('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/my-profile', $payloadData);

        } else {
            $response = $apiRequest->put('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/my-profile', $payloadData);
        }

        // dd([
        //     '1. Status HTTP' => $response->status(),
        //     '2. Balasan Server' => $response->json(),
        //     '3. Data Yang Kita Kirim' => $payloadData,
        //     '4. Apakah Ada File?' => $request->hasFile('avatar')
        // ]);
        // dd([
        //     'Cek Tanggal Lahir' => $request->tanggal_lahir,
        //     'Semua Data Yang Dikirim' => $payloadData
        // ]);

        // 4. Cek Hasilnya
        if ($response->successful()) {
            return back()->with('success', 'Data profil berhasil diperbarui!');
        }

        $pesanError = $response->json('message') ?? 'Gagal memperbarui profil.';
        return back()->with('error', $pesanError);
    }

    public function updatePassword(Request $request)
    {
        $token = session('api_token');

        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login ulang.');
        }

        // 1. Validasi sederhana di Laravel dulu
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', // 'confirmed' otomatis nyocokin sama field 'new_password_confirmation'
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok!',
            'new_password.min' => 'Password baru minimal 6 karakter!'
        ]);

        // 2. Tembak API Backend Temen Lu
        // NOTE: Tanya temen lu apa endpoint-nya. Gue asumsiin sementara ke /api/change-password
        $response = Http::withToken($token)->put('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/change-password', [
            'old_password' => $request->current_password,
            'new_password' => $request->new_password
        ]);

        // dd(
        //     'Status API: ' . $response->status(),
        //     'Pesan Error Server: ', $response->json()
        // );

        if ($response->successful()) {
            return back()->with('success', 'Password berhasil diubah!');
        }

        // Kalau gagal
        $pesanError = $response->json('message') ?? 'Gagal mengubah password.';
        return back()->with('error', $pesanError);
    }

}