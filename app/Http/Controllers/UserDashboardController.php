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

                // dd([
                //     'Data_Asli_Dari_Darda' => $apiData
                // ]);
                
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
                    'telepon'       => $apiData['no_wa'] ?? '',
                    
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
            return redirect()->route('login')->with('error', 'Sesi Anda telah habis, silakan login kembali.'); 
        } 

        $token = session('api_token'); 
        $sessionUser = session('user'); 
        $myUserId = $sessionUser['id'] ?? $sessionUser['id_user'] ?? null; 

        // 0. Ambil Signature Keamanan
        $signature = config('app.api_signature');

        try { 
            // 3. Tembak API Transactions Utama (BAWA TOKEN + SIGNATURE)
            $responseTrx = Http::withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ])
                ->timeout(10) 
                ->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions'); 
                
            $allTransactions = []; 
            if ($responseTrx->successful()) { 
                $allTransactions = $responseTrx->json('data') ?? $responseTrx->json() ?? []; 
            } 

            // 4. FILTER, SECURITY, SORTING & SUNTIK GAMBAR (PAKAI KEY BARU)
            $transactions = collect($allTransactions) 
                ->filter(function ($trx) use ($myUserId) { 
                    return isset($trx['user_id']) && $trx['user_id'] == $myUserId; 
                }) 
                ->map(function ($trx) { 
                    $gambarFinal = null;
                    $detailUtama = $trx['details'][0] ?? [];

                    // NAH INI DIA TERSANGKANYA! Kita ambil pakai key 'thumbnail_product'
                    $gambarSmentara = $detailUtama['thumbnail_product'] ?? $detailUtama['thumbnail_url'] ?? null;

                    // Format URL gambarnya biar siap pakai di HTML
                    if ($gambarSmentara) {
                        if (str_starts_with($gambarSmentara, 'http')) {
                            $gambarFinal = $gambarSmentara; // Udah full URL dari sana
                        } else {
                            // Gabungin URL domain sama nama filenya
                            $gambarFinal = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/' . rawurlencode(ltrim($gambarSmentara, '/'));
                        }
                    } else {
                        // Fallback terakhir (Dummy) kalau Darda emang beneran gak ngirim data gambarnya
                        $gambarFinal = '/assets/img/marketplace/produk-dummy.png';
                    }

                    // SUNTIKKAN KE DALAM VARIABEL TRX DENGAN NAMA BARU
                    $trx['gambar_paket_final'] = $gambarFinal;
                    
                    return $trx; 
                }) 
                ->sortByDesc('created_at') 
                ->values() 
                ->toArray(); 

        } catch (\Exception $e) { 
            $transactions = []; 
            session()->now('error', 'Gagal memuat riwayat pesanan. Silakan coba lagi nanti.'); 
        } 

        return view('marketplace.user.pesanan', compact('userProfile', 'transactions')); 
    }

  public function uploadBukti(Request $request) 
    { 
        $token = session('api_token'); 
        if (!$token) return response()->json(['status' => 'error', 'message' => 'Sesi berakhir.']);

        // 0. Ambil Signature Keamanan
        $signature = config('app.api_signature');

        try { 
            $foto = $request->file('bukti_bayar'); 
            $idTransaksi = $request->id_transaksi;
            
            // 1. URL BERDASARKAN ID (Sesuai request backend)
            $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions/' . $idTransaksi; 

            // 2. METHOD PUT MURNI + SIGNATURE + TOKEN
            $response = Http::withToken($token)
                ->withHeaders([
                    'X-App-Signature' => $signature,
                    'Accept'          => 'application/json'
                ])
                ->attach(
                    'evidence_url', // Pakai key 'evidence_url' sesuai data dari backend sebelumnya
                    file_get_contents($foto->getPathname()), 
                    $foto->getClientOriginalName()
                )
                ->put($urlApi, [ 
                    'status' => 'PENDING' // Update status sekalian (kalau backend butuh)
                ]); 

            // Kalau Sukses
            if ($response->successful()) { 
                return response()->json(['status' => 'success']); 
            } 

            // Kalau Gagal, kita keluarin pesan errornya
            return response()->json([
                'status' => 'error', 
                'message' => 'Status: ' . $response->status() . ' | ' . $response->body() 
            ]); 

        } catch (\Exception $e) { 
            return response()->json(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]); 
        } 
    }

public function processCheckout(Request $request)
{
    $token = session('api_token');
    if (!$token) {
        return response()->json(['status' => 'error', 'message' => 'Sesi login berakhir.'], 401);
    }

    // 0. Ambil Signature Keamanan
    $signature = config('app.api_signature');

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

        // QTY QUAD, QTY DOUBLE, QTY TRIPLE //

       // 2. PAYLOAD FINAL      
        $payload = [
            'user_id'        => (int) $userId,
            'product_id'     => (int) $request->product_id,
            'items'          => $details,         
            'total_price'    => (int) array_sum(array_column($details, 'price')), 
            'payment_method' => 'TRANSFER',
        ];

        // 3. TEMBAK API DARDA SEBAGAI JSON MURNI (BAWA TOKEN + SIGNATURE)
        $response = Http::withToken($token)
            ->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json',
                'Content-Type'    => 'application/json'
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

    public function wishlist(Request $request) 
    { 

    $userProfile = $this->getProfileData(); 
    if (!$userProfile) { 
        return redirect()->route('login'); 
    } 

    // 1. Ambil token user dari session & Ambil Signature Keamanan 
    $token = session('api_token'); 
    $signature = config('app.api_signature'); 

    // 2. Tembak API Wishlist dari backend (BAWA TOKEN + SIGNATURE) 
    $response = Http::withToken($token)->withHeaders([ 
        'X-App-Signature' => $signature, 
        'Accept'          => 'application/json' 
    ])->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/wishlist'); 

    // 3. Cek hasilnya dan KALKULASI DATA
    if ($response->successful()) { 
        $rawData = $response->json('data') ?? $response->json() ?? []; 

        // dd($rawData);
        
        // 👇 PERBAIKAN: Kita rapihin struktur dan hitung total kuotanya di Controller 👇
        $wishlistData = collect($rawData)->map(function ($row) {
            
            // Deteksi struktur API (kadang di dalem 'product', kadang di luar)
            $item = isset($row['product']) ? $row['product'] : $row;
            
            // 1. Paksa 'prices' jadi Array (buat jaga-jaga kalau dari API wujudnya masih string JSON)
            $pricesData = is_string($item['prices'] ?? null) ? json_decode($item['prices'], true) : ($item['prices'] ?? []);
            $item['prices'] = $pricesData;
            
            // 2. Hitung total_quota dari semua tipe kamar
            $item['total_quota'] = collect($pricesData)->sum('quota');
            
            // Balikin ke struktur asalnya
            if (isset($row['product'])) {
                $row['product'] = $item;
                return $row;
            }
            return $item;
        })->toArray();

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

        // Ambil Signature Keamanan
        $signature = config('app.api_signature');
        
        $productId = $request->product_id;
        $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/wishlist';

        // 1. KITA COBA TAMBAHIN DULU (POST + SIGNATURE)
        $response = Http::withToken($token)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->post($urlApi, [
            'product_id' => $productId
        ]);

        $apiData = $response->json();
        $pesan = $apiData['message'] ?? '';

        // 2. LOGIKA PINTAR: Kalau API nolak karena "udah ada", berarti kita harus HAPUS (DELETE)!
        if (stripos($pesan, 'already') !== false || $response->status() == 400) {
            
            // Asumsi standar API: buat hapus pakai method DELETE (Bawa Signature)
            $deleteResponse = Http::withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ])->delete($urlApi . '/' . $productId);

            // Coba skenario 2 kalau API temen lu butuh ID di dalem Body (bukan di URL)
            if ($deleteResponse->status() == 404 || $deleteResponse->status() == 405) {
                 $deleteResponse = Http::withToken($token)->withHeaders([
                     'X-App-Signature' => $signature,
                     'Accept'          => 'application/json'
                 ])->delete($urlApi, [
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

        // 1. Siapkan data teks (Bentuk Paling Bersih)
        $payloadData = [
            'fullname'    => $request->nama,
            'address'     => $request->address,
            'no_paspor'   => $request->no_paspor,
            'nama_paspor' => $request->nama_paspor,
            'jk'          => $request->jk,
            'no_nik'      => $request->no_nik,
            'no_wa'       => $request->telepon, // <-- Balikin normal gini aja
            'tgl_lahir'   => $request->tanggal_lahir,
        ];

        $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/my-profile';

        $apiRequest = Http::withToken($token);

        if ($request->hasFile('avatar')) {
            $foto = $request->file('avatar');
            $response = $apiRequest->attach(
                'image', file_get_contents($foto->getPathname()), $foto->getClientOriginalName()
            )->put($urlApi, $payloadData);
        } else {
            $response = $apiRequest->put($urlApi, $payloadData);
        }

        // Fallback POST kalau PUT ditolak (404)
        if ($response->status() == 404 || stripos($response->json('message') ?? '', 'tidak ditemukan') !== false) {
            $apiRequestRetry = Http::withToken($token);
            if ($request->hasFile('avatar')) {
                $foto = $request->file('avatar');
                $response = $apiRequestRetry->attach(
                    'image', file_get_contents($foto->getPathname()), $foto->getClientOriginalName()
                )->post($urlApi, $payloadData);
            } else {
                $response = $apiRequestRetry->post($urlApi, $payloadData);
            }
        }

        // 3. Cek Hasil Akhirnya
        if ($response->successful()) {
            return back()->with('success', 'Data profil berhasil disimpan!');
        }

        // Kalau masih error
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
            'new_password' => 'required|min:6|confirmed', 
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok!',
            'new_password.min' => 'Password baru minimal 6 karakter!'
        ]);

        // 2. Tembak API Backend pakai "MANTRA RAHASIA" dari Darda
        $response = Http::withToken($token)->post('https://mediumspringgreen-meerkat-585223.hostingersite.com/changePassword', [
            'oldPassword'     => $request->current_password,
            'newPassword'     => $request->new_password,
            'confirmPassword' => $request->new_password // Laravel udah ngecek konfirmasinya, jadi kita lempar data yang sama aja
        ]);

        // 3. Cek kalau SUKSES (Status 200)
        if ($response->successful()) {
            return back()->with('success', 'Password berhasil diubah!');
        }

        // 4. LOGIKA PINTAR BUAT BACA ERROR PASSWORD SALAH
        $statusHTTP = $response->status();
        $pesanAsliServer = strtolower($response->json('message') ?? '');

        // Kalau ada kata-kata dari backend yang nunjukin password lamanya salah
        if (
            str_contains($pesanAsliServer, 'wrong') || 
            str_contains($pesanAsliServer, 'incorrect') || 
            str_contains($pesanAsliServer, 'match') || 
            str_contains($pesanAsliServer, 'salah') ||
            str_contains($pesanAsliServer, 'lama')
        ) {
            return back()->with('error', 'Password lama yang Anda masukkan salah!');
        }

        // Kalau errornya hal lain (misal dari Darda nya emang ngasih pesan error lain)
        $pesanError = $response->json('message') ?? 'Gagal mengubah password. Silakan coba lagi nanti.';
        return back()->with('error', $pesanError);
    }

}