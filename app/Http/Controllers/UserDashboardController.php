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
                $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($nama) . '&background=ea580c&color=fff';
                if ($fotoBackend) {
                    if (str_starts_with($fotoBackend, 'http')) {
                        $avatarUrl = $fotoBackend;
                    } else {
                        // Bersihin slash di nama file biar gak dobel
                        $fotoBackend = ltrim($fotoBackend, '/'); 
                    
                        $avatarUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/profiles/' . $fotoBackend;
                    }
                }

                session(['foto_global_navbar' => $avatarUrl]);

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
    // 1. Ambil data profil & proteksi session
    $userProfile = $this->getProfileData(); 
    if (!$userProfile) { 
        return redirect()->route('login')->with('error', 'Sesi Anda telah habis, silakan login kembali.'); 
    } 

    // 2. Ambil Identitas User & Token
    $token = session('api_token'); 
    $sessionUser = session('user');
    // Ambil ID user dari session untuk filter keamanan
    $myUserId = $sessionUser['id'] ?? $sessionUser['id_user'] ?? null;

    try {
        // 3. Tembak API Transactions dengan Timeout (Biar web gak lemot kalo API down)
        $response = Http::withToken($token)
            ->timeout(10)
            ->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions'); 
        
        $allTransactions = []; 
        if ($response->successful()) { 
            $allTransactions = $response->json('data') ?? $response->json() ?? []; 
        } 

        // 4. JURUS PROFESIONAL: FILTER & SORTING
        $transactions = collect($allTransactions)
            // FILTER: Hanya ambil pesanan milik user yang sedang login (Security)
            ->filter(function ($trx) use ($myUserId) {
                return isset($trx['user_id']) && $trx['user_id'] == $myUserId;
            })
            // SORTING: Urutkan dari yang terbaru (Terakhir beli ada di paling atas)
            ->sortByDesc('created_at') 
            ->values()
            ->toArray();

    } catch (\Exception $e) {
        // Jika API error/down, kirim array kosong agar UI tidak error
        $transactions = [];
        session()->now('error', 'Gagal memuat riwayat pesanan. Silakan coba lagi nanti.');
    }

    // 5. Lempar ke View
    return view('marketplace.user.pesanan', compact('userProfile', 'transactions')); 
}

public function processCheckout(Request $request)
{
    $token = session('api_token');
    if (!$token) {
        return response()->json(['status' => 'error', 'message' => 'Sesi login berakhir.'], 401);
    }

    try {
        $sessionUser = session('user');
        $userId = $sessionUser['id'] ?? $sessionUser['id_user'] ?? null;

        // 1. KITA SESUAIKAN KEY-NYA DENGAN DATABASE DARDA (Pake 'S')
        $details = [];
        foreach ($request->items as $item) {
            $details[] = [
                'product_id' => (int) $request->product_id, // Masukin ID produk di tiap baris
                'room_types' => $item['room_type'],        // GANTI: room_type -> room_types (Tambah S)
                'quantity'   => (int) $item['quantity'],
                'price'      => (int) $item['price']
            ];
        }

       // 2. PAYLOAD FINAL
        $payload = [
            'user_id'        => (int) $userId,
            'product_id'     => (int) $request->product_id,
            'items'          => $details,         
            'total_price'    => (int) array_sum(array_column($details, 'price')), 
            'payment_method' => 'TRANSFER',
        ];

        // 3. TEMBAK API DARDA SEBAGAI JSON MURNI
        $response = Http::withToken($token)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->post('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions', $payload);

        // 4. CEK HASIL
        if ($response->successful()) {
            return response()->json([
                'status'  => 'success',
                'message' => 'Pesanan berhasil dibuat! Silakan bayar.',
            ]);
        }

        // JIKA MASIH ERROR: Kita paksa keluarin apa alasan Darda kali ini
        $pesanBackend = $response->json('message') ?? 'Gagal membuat pesanan.';
        return response()->json([
            'status'  => 'error', 
            'message' => $pesanBackend . " (Detail: " . json_encode($response->json()) . ")"
        ], 400);

    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Sistem sibuk: ' . $e->getMessage()], 500);
    }
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

        // 1. Siapkan data teks
        $payloadData = [
            'fullname'    => $request->nama,
            'address'     => $request->address,
            'no_paspor'   => $request->no_paspor,
            'nama_paspor' => $request->nama_paspor,
            'jk'          => $request->jk,
            'no_nik'      => $request->no_nik,
            'no_wa'       => $request->telepon,
            'tgl_lahir'   => $request->tanggal_lahir,
        ];

        $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/my-profile';

      
        
        // LANGKAH A: Kita coba tembak pake "PUT" dulu (Anggap dia akun lama)
        $apiRequest = Http::withToken($token);
        if ($request->hasFile('avatar')) {
            $foto = $request->file('avatar');
            $response = $apiRequest->attach(
                'image', file_get_contents($foto->getPathname()), $foto->getClientOriginalName()
            )->put($urlApi, $payloadData);
        } else {
            $response = $apiRequest->put($urlApi, $payloadData);
        }

        // LANGKAH B: Kalau Backend nolak (404/Tidak ditemukan), berarti dia Akun Baru!
        // Langsung kita ganti senjata, tembak ulang pake "POST" secara diam-diam.
        if ($response->status() == 404 || stripos($response->json('message') ?? '', 'tidak ditemukan') !== false) {
            
            $apiRequestRetry = Http::withToken($token); // Bikin request baru biar bersih
            
            if ($request->hasFile('avatar')) {
                $foto = $request->file('avatar');
                $response = $apiRequestRetry->attach(
                    'image', file_get_contents($foto->getPathname()), $foto->getClientOriginalName()
                )->post($urlApi, $payloadData); // <-- INI JADI POST
            } else {
                $response = $apiRequestRetry->post($urlApi, $payloadData); // <-- INI JADI POST
            }
        }
        // =========================================================

        // 3. Cek Hasil Akhirnya
        if ($response->successful()) {
            return back()->with('success', 'Data profil berhasil disimpan!');
        }

        // Kalau masih error juga (misal server down atau salah validasi)
        $pesanError = $response->json('message') ?? 'Gagal memperbarui profil.';
        return back()->with('error', $pesanError);
    }

      // dd([
        //     '1. Status HTTP' => $response->status(),
        //     '2. Balasan Server' => $response->json(),
        //     '3. Data Yang Kita Kirim' => $payloadData,
        //     '4. Apakah Ada File?' => $request->hasFile('avatar')
        // ]);

    public function updatePassword(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login ulang.');
        }

        // 1. Validasi sederhana di Laravel dulu
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', 
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok!',
            'new_password.min' => 'Password baru minimal 6 karakter!'
        ]);

        // 2. Tembak API Backend Temen Lu
        $response = Http::withToken($token)->put('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/change-password', [
            'old_password' => $request->current_password,
            'new_password' => $request->new_password
        ]);

        // =======================================================
        // BUKA KOMENTAR DD() INI KALAU MASIH GAGAL / MAU RONTGEN
        // =======================================================
        // dd([
        //     'Status HTTP' => $response->status(),
        //     'Pesan Asli Server' => $response->json(),
        //     'Data yang dikirim' => [
        //         'old_password' => $request->current_password,
        //         'new_password' => $request->new_password
        //     ]
        // ]);

        // 3. Cek kalau SUKSES
        if ($response->successful()) {
            return back()->with('success', 'Password berhasil diubah!');
        }

        // 4. LOGIKA PINTAR BUAT BACA ERROR PASSWORD SALAH
        $statusHTTP = $response->status();
        $pesanAsliServer = strtolower($response->json('message') ?? '');

        // Kalau statusnya 400/401/403, ATAU ada kata-kata "salah/wrong/incorrect/match" dari backend
        if (
            $statusHTTP == 400 || 
            $statusHTTP == 401 || 
            str_contains($pesanAsliServer, 'wrong') || 
            str_contains($pesanAsliServer, 'incorrect') || 
            str_contains($pesanAsliServer, 'match') || 
            str_contains($pesanAsliServer, 'salah')
        ) {
            return back()->with('error', 'Password lama yang Anda masukkan salah!');
        }

        // Kalau errornya hal lain (misal server down)
        $pesanError = $response->json('message') ?? 'Gagal mengubah password. Silakan coba lagi nanti.';
        return back()->with('error', $pesanError);
    }

}