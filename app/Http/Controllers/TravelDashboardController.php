<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TravelDashboardController extends Controller
{
    // Benerin Base URL: Cukup sampai /api
    private $apiUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api';

    public function index(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login');
        }

        $user = session('user');
        $signature = config('app.api_signature');

        // 👇 1. TARIK STATUS MODE REKENING (PUSAT/MANDIRI) 👇
        $profileRes = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/my-profile');
        
        if ($profileRes->successful()) {
            $dataProfile = $profileRes->json('data') ?? $profileRes->json();
            
            $allowMarketplace = true; 
            if (isset($dataProfile['allow_marketplace'])) {
                $allowMarketplace = filter_var($dataProfile['allow_marketplace'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
                if ($allowMarketplace === null) $allowMarketplace = false; 
            } elseif (isset($dataProfile['rekening_mode'])) {
                $allowMarketplace = strtoupper($dataProfile['rekening_mode']) === 'MARKETPLACE';
            }

            if ($allowMarketplace === false) {
                $user['rekening_mode'] = 'MANDIRI';
                $user['allow_marketplace'] = false;
            } else {
                $user['rekening_mode'] = 'MARKETPLACE';
                $user['allow_marketplace'] = true;
            }
        }

        // 🌟 FIX UTAMA: TARIK LIST REKENING LANGSUNG DARI API REKENING 🌟
        // (Biar pas login ulang, data rekening travelnya ditarik lagi dari database Backend)
        $rekRes = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/rekening');

        if ($rekRes->successful()) {
            $dataRekening = $rekRes->json('data') ?? $rekRes->json();
            // Pastikan datanya berbentuk Array biar HTML nggak error
            if (is_array($dataRekening)) {
                $user['rekening'] = $dataRekening;
            } else {
                // Jaga-jaga kalau backend ngirim single object
                $user['rekening'] = [$dataRekening];
            }
        } else {
            $user['rekening'] = [];
        }

        // Kunci semua datanya ke memori!
        session(['user' => $user]); 
        session()->save(); 

        // Mengambil statistik pesanan
        $response = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions');
        
        $statistik = [];
        if ($response->successful()) {
            $statistik = $response->json('data') ?? [];
        }

        return view('marketplace.travel.dashboard', compact('statistik', 'user'));
    }

    public function updateProfile(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login ulang.');
        }

        $signature = config('app.api_signature');
        $userData = session('user');

        $rekMode = $request->input('rekening_mode', $userData['rekening_mode'] ?? 'MARKETPLACE');
        $allowMarketplace = ($rekMode === 'MARKETPLACE') ? true : false;

        $payloadData = [
            'fullname'          => $request->fullname,
            'no_wa'             => $request->no_wa,
            'rekening_mode'     => $rekMode,           
            'allow_marketplace' => $allowMarketplace   
        ];
        
        $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/my-profile';
        $apiRequest = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ]);

        if ($request->hasFile('avatar')) {
            $foto = $request->file('avatar');
            $responseProfile = $apiRequest->attach('image', file_get_contents($foto->getPathname()), $foto->getClientOriginalName())->put($urlApi, $payloadData);
        } else {
            $responseProfile = $apiRequest->put($urlApi, $payloadData);
        }

        // Fallback jika API Darda butuh POST
        if ($responseProfile->status() == 404 || stripos($responseProfile->json('message') ?? '', 'tidak ditemukan') !== false) {
            $apiRequestRetry = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ]);
            if ($request->hasFile('avatar')) {
                $foto = $request->file('avatar');
                $responseProfile = $apiRequestRetry->attach('image', file_get_contents($foto->getPathname()), $foto->getClientOriginalName())->post($urlApi, $payloadData);
            } else {
                $responseProfile = $apiRequestRetry->post($urlApi, $payloadData);
            }
        }

        if ($responseProfile->successful()) {
            
            // TEMBAK API TOGGLE DENGAN PARAMETER "status" SESUAI PERMINTAAN BACKEND
            $toggleUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/rekening/toggle-marketplace';
            $togglePayload = [
                'status'            => $allowMarketplace, 
                'allow_marketplace' => $allowMarketplace,
                'rekening_mode'     => $rekMode
            ];

            $httpToggle = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ]);
            
            // Hajar pakai POST, kalau gagal hajar pakai PUT
            $resToggle = $httpToggle->post($toggleUrl, $togglePayload);
            if (!$resToggle->successful()) {
                $httpToggle->put($toggleUrl, $togglePayload);
            }

            $userData['fullname'] = $request->fullname;
            $userData['no_wa']    = $request->no_wa;
            $userData['rekening_mode'] = $rekMode;
            $userData['allow_marketplace'] = $allowMarketplace;
            
            $responseData = $responseProfile->json('data');
            if (isset($responseData['image']) && $responseData['image'] != null) {
                $namaFoto = ltrim($responseData['image'], '/');
                $baseImageUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/profiles/';
                $newAvatar = $baseImageUrl . $namaFoto;
                $userData['avatar_url'] = $newAvatar;
                session(['user_avatar' => $newAvatar]);
                session(['foto_global_navbar' => $newAvatar]);
            }
            
            session(['user' => $userData]); 
            
            // 🔥 Fungsi paksa save dihapus biar pesan success bisa masuk ke session 🔥
            return back()->with('success', 'Data Profil & Pengaturan Rekening berhasil disimpan!');
        }

        return back()->with('error', $responseProfile->json('message') ?? 'Gagal memperbarui profil utama.');
    }

    public function toggleRekeningMode(Request $request)
    {
        $token = session('api_token');
        $signature = config('app.api_signature'); 
        $mode = $request->input('mode'); 
        $allow = ($mode === 'MARKETPLACE') ? true : false;

        // 🌟 FIX 3: API TOGGLE LEWAT AJAX JUGA DIHAJAR PAKAI PARAMETER "status" 🌟
        $url = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/rekening/toggle-marketplace';
        $payload = [
            'status'            => $allow, // Ini yang diminta Backend!
            'allow_marketplace' => $allow,
            'rekening_mode'     => $mode
        ];

        $http = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ]);

        $response = $http->post($url, $payload);
        if (!$response->successful()) {
            $response = $http->put($url, $payload);
        }

        // APAPUN HASILNYA DARI BACKEND, KITA PAKSA SESI BERUBAH LOKAL!
        $user = session('user');
        $user['rekening_mode'] = $mode;
        $user['allow_marketplace'] = $allow;
        session(['user' => $user]);
        session()->save(); // 🔥 PAKSA MEMORI TERSIMPAN!

        return response()->json(['status' => 'success', 'message' => 'Opsi rekening berhasil diubah.']);
    }

    public function simpanRekeningTunggal(Request $request)
    {
        $token = session('api_token');
        $signature = config('app.api_signature'); 
        $url = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/rekening';
        
        $payload = [
            'nama_bank'   => $request->bank_name,
            'no_rekening' => $request->bank_account,
            'atas_nama'   => $request->bank_owner,
        ];

        $http = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ]);

        if ($request->has('id') && $request->id != '') {
            $url .= '/' . $request->id;
            $response = $http->put($url, $payload);
        } else {
            $response = $http->post($url, $payload);
        }

        if ($response->successful()) {
            $dataRekening = $response->json('data') ?? [];
            
            $user = session('user');
            $rekeningList = $user['rekening'] ?? [];
            
            $newRek = [
                'id'          => $dataRekening['id'] ?? $request->id ?? uniqid(),
                'nama_bank'   => $request->bank_name,
                'no_rekening' => $request->bank_account,
                'atas_nama'   => $request->bank_owner,
            ];

            $isUpdate = false;
            foreach ($rekeningList as $key => $rek) {
                if (isset($rek['id']) && $rek['id'] == $newRek['id']) {
                    $rekeningList[$key] = $newRek; 
                    $isUpdate = true;
                    break;
                }
            }
            if (!$isUpdate) {
                $rekeningList[] = $newRek; 
            }

            $user['rekening'] = $rekeningList;
            
            // Kunci paksa mode ke MANDIRI kalau Travel nambah rekening
            $user['rekening_mode'] = 'MANDIRI';
            $user['allow_marketplace'] = false;
            
            // Tembak API Toggle
            $toggleUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/rekening/toggle-marketplace';
            $togglePayload = ['status' => false, 'allow_marketplace' => false, 'rekening_mode' => 'MANDIRI'];
            
            $httpToggle = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ]);
            $resToggle = $httpToggle->post($toggleUrl, $togglePayload);
            if (!$resToggle->successful()) $httpToggle->put($toggleUrl, $togglePayload);

            session(['user' => $user]);
            session()->save(); // 🔥 PAKSA MEMORI TERSIMPAN!

            return response()->json(['status' => 'success', 'message' => 'Rekening disimpan', 'data' => $dataRekening]);
        }

        return response()->json(['status' => 'error', 'message' => $response->json('message') ?? 'Gagal menyimpan rekening'], 400);
    }

    public function hapusRekeningTunggal($id)
    {
        $token = session('api_token');
        $signature = config('app.api_signature'); // 🔥 WAJIB ADA
        $url = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/rekening/' . $id;
        
        $response = \Illuminate\Support\Facades\Http::withToken($token)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->delete($url);

        if ($response->successful()) {
            $user = session('user');
            $rekeningList = $user['rekening'] ?? [];
            
            foreach ($rekeningList as $key => $rek) {
                if (isset($rek['id']) && $rek['id'] == $id) {
                    unset($rekeningList[$key]);
                    break;
                }
            }
            
            $user['rekening'] = array_values($rekeningList); 
            session(['user' => $user]);

            return response()->json(['status' => 'success', 'message' => 'Rekening dihapus']);
        }
        return response()->json(['status' => 'error', 'message' => 'Gagal menghapus rekening'], 400);
    }
 
    public function updatePassword(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Sesi telah berakhir. Silakan login ulang.');
        }

        // 1. Validasi Input Laravel
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:6|confirmed',
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok!',
            'new_password.min'       => 'Password baru minimal 6 karakter!'
        ]);

        // 2. Tembak API Backend
        $response = Http::withToken($token)->post('https://mediumspringgreen-meerkat-585223.hostingersite.com/changePassword', [
            'oldPassword'     => $request->current_password,
            'newPassword'     => $request->new_password,
            'confirmPassword' => $request->new_password 
        ]);

        // 3. Cek kalau SUKSES (Status 200)
        if ($response->successful()) {
            return back()->with('success', 'Password berhasil diubah!');
        }

        // 4. Logika error password salah (sesuai pesan dari backend)
        $pesanAsliServer = strtolower($response->json('message') ?? '');
        
        if (
            str_contains($pesanAsliServer, 'wrong') || 
            str_contains($pesanAsliServer, 'incorrect') || 
            str_contains($pesanAsliServer, 'match') || 
            str_contains($pesanAsliServer, 'salah') || 
            str_contains($pesanAsliServer, 'lama')
        ) {
            return back()->with('error', 'Password lama yang Anda masukkan salah!');
        }

        // Fallback error lainnya
        $pesanError = $response->json('message') ?? 'Gagal mengubah password. Silakan coba lagi nanti.';
        return back()->with('error', $pesanError);
    }

    public function pesananMasuk(Request $request)
    {
        $token = session('api_token');
        
        $sessionUser = session('user');
        $myTravelId = $sessionUser['id'] ?? $sessionUser['id_user'] ?? null;
        
        if (!$token || !$myTravelId) {
            return redirect()->route('login')->with('error', 'Sesi telah berakhir. Silakan login kembali.');
        }

        // 0. Ambil Signature Keamanan
        $signature = config('app.api_signature');

        try {
            // Tembak API Transactions (Bawa Token + Signature)
            $response = Http::withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ])
                ->timeout(15) 
                ->get('https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions');

            $pesanan = [];

            if ($response->successful()) {
                $rawData = $response->json('data') ?? $response->json() ?? [];
                
                if (is_array($rawData)) {
                    $pesanan = collect($rawData)
                    ->filter(function ($trx) use ($myTravelId) {
                        // 1. Coba ambil dari relasi product (kalau produk masih ada)
                        $pemilikProduk = $trx['product']['user_id'] ?? null;
                        
                        // 2. FALLBACK: Kalau produk dihapus, ambil dari snapshot detail transaksi!
                        // (Ini asumsi backend lu ngasih snapshot 'travel_id' di dalam 'details')
                        if (!$pemilikProduk && isset($trx['details'][0])) {
                            $travelSnapshot = is_string($trx['details'][0]['travel_snapshot'] ?? null) 
                                            ? json_decode($trx['details'][0]['travel_snapshot'], true) 
                                            : ($trx['details'][0]['travel_snapshot'] ?? []);
                                            
                            $pemilikProduk = $travelSnapshot['id'] ?? null;
                        }

                        return $pemilikProduk == $myTravelId;
                    })
                    ->sortByDesc('created_at')
                    ->values()
                    ->toArray();
                }
            } else {
                $pesanError = $response->json('message') ?? 'Terjadi kesalahan pada server API.';
                session()->now('error', 'Gagal memuat daftar pesanan: ' . $pesanError);
            }

        } catch (\Exception $e) {
            $pesanan = [];
            session()->now('error', 'Koneksi ke server terputus. Silakan coba lagi nanti.');
        }

        return view('marketplace.travel.pesanan', compact('pesanan'));
    }

    public function verifikasiPembayaran(Request $request, $id)
    {
        $token = session('api_token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Sesi telah berakhir. Silakan refresh halaman.'], 401);
        }

        $signature = config('app.api_signature');

        try {
            // 🌟 TANGKAP STATUS DAN TIPE DARI JAVASCRIPT ('PAID' / 'FAILED' & 'FULL' / 'INSTALLMENT')
            $targetStatus = strtoupper($request->input('target_status', 'PAID'));
            $type = strtoupper($request->input('type', 'FULL'));
            $payload = [];
            $pesanSukses = '';

            // ==========================================
            // 🌟 LOGIKA KHUSUS CICILAN (INSTALLMENT)
            // ==========================================
            if ($type === 'INSTALLMENT') { 
                if ($targetStatus === 'PAID') { 
                    // 👇 JALUR ACC: Pakai endpoint khusus '/status' yang strict minta 'SUCCESS' 👇 
                    $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions/installments/' . $id . '/status'; 
                    $payload['status'] = 'SUCCESS'; 
                    $pesanSukses = 'Bukti Cicilan berhasil diverifikasi (ACC)!'; 

                    $response = \Illuminate\Support\Facades\Http::asJson() 
                        ->withToken($token) 
                        ->withHeaders(['X-App-Signature' => $signature, 'Accept' => 'application/json']) 
                        ->patch($urlApi, $payload); 
                } else { 
                    // 👇 JALUR TOLAK: Kita samakan dengan Jalur ACC, pakai PATCH 👇 
                    $urlApiStatus = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions/installments/' . $id . '/status'; 
                    $pesanSukses = 'Bukti Cicilan ditolak. Status dikembalikan agar jamaah bisa unggah ulang.'; 
                    
                    // 1. Set status menjadi FAILED
                    $payload['status'] = 'FAILED'; 
                    $payload['evidence_url'] = 'REJECTED_IMAGE'; // 🌟 TAMBAHKAN BARIS INI
                    
                    // KITA GANTI JADI PATCH
                    $response = \Illuminate\Support\Facades\Http::asJson() 
                        ->withToken($token) 
                        ->withHeaders(['X-App-Signature' => $signature, 'Accept' => 'application/json']) 
                        ->patch($urlApiStatus, $payload); 

                    // 2. Kalau FAILED masih ditolak, fallback ke UNPAID (Tetap PATCH)
                    if (!$response->successful()) { 
                        $payload['status'] = 'UNPAID'; 
                        // (evidence_url 'REJECTED_IMAGE' otomatis ikut terkirim)
                        $response = \Illuminate\Support\Facades\Http::asJson() 
                            ->withToken($token) 
                            ->withHeaders(['X-App-Signature' => $signature, 'Accept' => 'application/json']) 
                            ->patch($urlApiStatus, $payload); 
                    } 
                }
            }
            // ==========================================
            // 🌟 LOGIKA PEMBAYARAN FULL (NORMAL)
            // ==========================================
            else {
                $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions/' . $id;

                if ($targetStatus === 'FAILED') {
                    $payload['status'] = 'FAILED';
                    $payload['evidence_url'] = 'REJECTED_IMAGE';
                    $pesanSukses = 'Bukti pembayaran ditolak. Pesanan masuk ke tab Dibatalkan.';
                    
                    $response = \Illuminate\Support\Facades\Http::asJson()
                        ->withToken($token)
                        ->withHeaders(['X-App-Signature' => $signature, 'Accept' => 'application/json'])
                        ->put($urlApi, $payload);
                } else {
                    $payload['status'] = 'PAID';
                    if ($request->filled('evidence_url') && $request->input('evidence_url') !== 'null') {
                        $payload['evidence_url'] = $request->input('evidence_url');
                    }
                    $pesanSukses = 'Pembayaran berhasil diverifikasi menjadi LUNAS!';

                    $response = \Illuminate\Support\Facades\Http::asJson()
                        ->withToken($token)
                        ->withHeaders(['X-App-Signature' => $signature, 'Accept' => 'application/json'])
                        ->patch($urlApi, $payload);
                }
            }

            $apiResult = $response->json();

            // Cek Response Akhir
            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => $pesanSukses]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Dari Backend: ' . ($apiResult['message'] ?? $response->body())
            ], 400);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Sistem Error: ' . $e->getMessage()], 500);
        }
    }

    public function kelolaProduk(Request $request) 
    { 
        $token = session('api_token'); 
        $userData = session('user'); 
        
        // 1. KEAMANAN
        if (!$token || !$userData) { 
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login ulang.'); 
        } 
        
        $userId = $userData['id'] ?? null; 
        $signature = config('app.api_signature'); 
        
        try { 
            // Hit API ke backend
            $response = Http::withToken($token)->withHeaders([ 
                'X-App-Signature' => $signature, 
                'Accept'          => 'application/json' 
            ])->timeout(10)->get($this->apiUrl . '/products'); 
            
            if ($response->successful()) { 
                $semuaProduk = $response->json('data') ?? []; 
                
                // 2. FILTERING & KALKULASI DATA PINTAR
                $produk = collect($semuaProduk)
                    ->where('user_id', $userId)
                    ->map(function ($item) {
                        // A. Paksa 'prices' jadi Array (buat jaga-jaga kalau dari API wujudnya string JSON)
                        $pricesData = is_string($item['prices'] ?? null) ? json_decode($item['prices'], true) : ($item['prices'] ?? []);
                        $item['prices'] = $pricesData;
                        
                        // B. Kalkulasi total_quota dari semua kamar
                        $totalKuota = collect($pricesData)->sum('quota');
                        
                        // C. Fallback: Kalau array kosong, ambil dari kuota root lama
                        if ($totalKuota === 0) {
                            $totalKuota = (int) ($item['total_quota'] ?? $item['quota'] ?? 0);
                        }
                        
                        $item['total_quota'] = $totalKuota;
                        
                        return $item;
                    })
                    ->values() // Reset index array biar berurutan (0, 1, 2...)
                    ->all(); 
                    
            } else { 
                $produk = []; 
                \Illuminate\Support\Facades\Log::warning('API Kelola Produk gagal: ' . $response->status()); 
                session()->now('error', 'Gagal menyinkronkan data terbaru dari server.'); 
            } 
        } catch (\Exception $e) { 
            \Illuminate\Support\Facades\Log::error('API Kelola Produk Timeout: ' . $e->getMessage()); 
            $produk = []; 
            session()->now('error', 'Tidak dapat terhubung ke server backend.'); 
        } 
        
        return view('marketplace.travel.produk.index', compact('produk')); 
    }

    public function uploadProduk(Request $request)
    {
        // 1. KEAMANAN: Pastikan user beneran punya akses sebelum masuk ke form
        $token = session('api_token');
        $userData = session('user');

        if (!$token || !$userData) {
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login ulang untuk membuat produk baru.');
        }

        // Jika aman dan tiketnya ada, silakan masuk ke halaman form
        return view('marketplace.travel.produk.create');
    }

    public function storeProduk(Request $request)
    {
        $token = session('api_token');
        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Sesi telah berakhir. Silakan login ulang.'], 401);
        }

        $signature = config('app.api_signature');

        try {
            // 👇 TAMBAHAN: timeout(30) biar nggak loading abadi kalo server backend lagi lemot
            $http = \Illuminate\Support\Facades\Http::timeout(30)->withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ]);

            $fileThumbnail = $request->file('thumbnail') ?? $request->file('thumbnail_product');
            $fileMekkah = $request->file('image_makkah') ?? $request->file('image_mekkah');
            $fileMadinah = $request->file('image_madinah');
            
            $adaGambar = $fileThumbnail || $fileMekkah || $fileMadinah;

            if ($fileThumbnail) {
                $http->attach('thumbnail', fopen($fileThumbnail->getRealPath(), 'r'), $fileThumbnail->getClientOriginalName());
            }
            if ($fileMekkah) {
                $http->attach('hotel_image_mekkah', fopen($fileMekkah->getRealPath(), 'r'), $fileMekkah->getClientOriginalName());
            }
            if ($fileMadinah) {
                $http->attach('hotel_image_madinah', fopen($fileMadinah->getRealPath(), 'r'), $fileMadinah->getClientOriginalName());
            }

            $apiUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products';
            $data = $request->except(['thumbnail', 'thumbnail_product', 'image_makkah', 'image_mekkah', 'image_madinah']);

          // 1. Tangkap masing-masing kuota kamar dari input form HTML
        $quotaQuad = (int) ($data['quota_quad'] ?? 0);
        $quotaDouble = (int) ($data['quota_double'] ?? 0);
        $quotaTriple = (int) ($data['quota_triple'] ?? 0);

        // 2. Buat Payload Utama (Root quota kita isi totalnya aja buat jaga-jaga kalau DB API masih butuh)
        $payload = [
            'nama_produk'       => $data['product_name'] ?? '',
            'category_id'       => (int) ($data['category'] ?? 0),
            'tgl_keberangkatan' => $data['departure_date'] ?? '',
            'tmp_keberangkatan' => $data['departure_from'] ?? '',
            'duration'          => (int) ($data['duration'] ?? 0),
            'quota'             => $quotaQuad + $quotaDouble + $quotaTriple, // Dijumlah total
            'description'       => $data['description'] ?? '',
            'status'            => $data['status'] ?? 'publish',
        ];

        // 3. Masukkan harga DAN KUOTA ke masing-masing tipe kamar
        $payload['prices'] = [
            [
                'room_types' => 'Quad', 
                'price' => (int) ($data['price_quad'] ?? 0),
                'quota' => $quotaQuad
            ],
            [
                'room_types' => 'Double', 
                'price' => (int) ($data['price_double'] ?? 0),
                'quota' => $quotaDouble
            ],
            [
                'room_types' => 'Triple', 
                'price' => (int) ($data['price_triple'] ?? 0),
                'quota' => $quotaTriple
            ]
        ];

            $payload['flights'] = [
                ['airline_name' => $data['flight_departure'] ?? '', 'type' => 'Departure'],
                ['airline_name' => $data['flight_return'] ?? '', 'type' => 'Return']
            ];

            $makkah = isset($data['hotel_makkah']) ? json_decode($data['hotel_makkah'], true) : [];
            $madinah = isset($data['hotel_madinah']) ? json_decode($data['hotel_madinah'], true) : [];
            
            $payload['hotels'] = [
                [
                    'city'       => 'Mekkah',
                    'name'       => $makkah['name'] ?? '',
                    'rating'     => (int) ($makkah['rating'] ?? 0),
                    'jarak'      => $makkah['distance'] ?? '',
                    'facilities' => isset($makkah['facilities']) && is_array($makkah['facilities']) ? implode(', ', $makkah['facilities']) : ''
                ],
                [
                    'city'       => 'Madinah',
                    'name'       => $madinah['name'] ?? '',
                    'rating'     => (int) ($madinah['rating'] ?? 0),
                    'jarak'      => $madinah['distance'] ?? '',
                    'facilities' => isset($madinah['facilities']) && is_array($madinah['facilities']) ? implode(', ', $madinah['facilities']) : ''
                ]
            ];

            $facilities = [];
            $included = isset($data['included_facilities']) ? json_decode($data['included_facilities'], true) : [];
            if (is_array($included)) {
                foreach ($included as $inc) { $facilities[] = ['facility' => $inc, 'type' => 'INCLUDE']; }
            }
            $excluded = isset($data['excluded_facilities']) ? json_decode($data['excluded_facilities'], true) : [];
            if (is_array($excluded)) {
                foreach ($excluded as $exc) { $facilities[] = ['facility' => $exc, 'type' => 'EXCLUDE']; }
            }
            $payload['facilities'] = $facilities; 

            $itineraryRaw = isset($data['itinerary']) ? json_decode($data['itinerary'], true) : [];
            $itineraries = [];
            if (is_array($itineraryRaw)) {
                foreach ($itineraryRaw as $it) {
                    $itineraries[] = ['day_order' => (int) ($it['day'] ?? 0), 'title' => $it['title'] ?? '', 'description' => $it['description'] ?? ''];
                }
            }
            $payload['itineraries'] = $itineraries; 

            $snkRaw = isset($data['terms']) ? json_decode($data['terms'], true) : [];
            $snks = [];
            if (is_array($snkRaw)) {
                foreach ($snkRaw as $t) { $snks[] = ['name' => $t]; }
            }
            $payload['snks'] = $snks; 

            $notesRaw = isset($data['notes']) ? json_decode($data['notes'], true) : [];
            $notes = [];
            if (is_array($notesRaw)) {
                foreach ($notesRaw as $n) { $notes[] = ['note' => $n]; }
            }
            $payload['notes'] = $notes;

            if ($adaGambar) {
                foreach (['prices', 'flights', 'hotels', 'facilities', 'itineraries', 'snks', 'notes'] as $arrField) {
                    $payload[$arrField] = json_encode($payload[$arrField]);
                }
                $response = $http->post($apiUrl, $payload);
            } else {
                // 👇 TAMBAHAN: timeout(30) juga untuk mode JSON
                $httpTanpaFile = \Illuminate\Support\Facades\Http::timeout(30)->withToken($token)->withHeaders([
                    'X-App-Signature' => $signature,
                    'Accept'          => 'application/json',
                    'Content-Type'    => 'application/json'
                ]);
                $response = $httpTanpaFile->post($apiUrl, $payload);
            }

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Produk berhasil diterbitkan!']);
            }

            // 👇 TAMBAHAN: Log Error API diam-diam di background (Aman untuk Hosting)
            \Illuminate\Support\Facades\Log::error('API Upload Produk Darda Gagal: ' . $response->body());

            return response()->json([
                'status' => 'error', 
                // Pesan disederhanakan untuk user biasa biar nggak bingung liat JSON mentah
                'message' => 'Gagal menerbitkan produk. Pastikan data sudah benar atau coba lagi nanti.',
                // Debug info hanya tampil kalau mode debug di file .env Laravel lu lagi nyala (APP_DEBUG=true)
                'debug_info' => config('app.debug') ? [
                    'Status_Code' => $response->status(),
                    'Full_Response' => $response->json() ?? $response->body()
                ] : null
            ], 400);

        } catch (\Exception $e) {
            // 👇 TAMBAHAN: Log Exception sistem
            \Illuminate\Support\Facades\Log::error('Exception Upload Produk: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error', 
                'message' => 'Terjadi kesalahan internal server. Silakan coba beberapa saat lagi.'
            ], 500);
        }
    }

    public function updateStatusProduk(Request $request, $id) 
    {
        $token = session('api_token');
        if (!$token) {
            return response()->json(['message' => 'Sesi telah berakhir. Silakan login ulang.'], 401);
        }
        
        $signature = config('app.api_signature');
        
        // 👇 UPDATE: Tambahin '/status' di belakang URL id produk
        $apiUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/' . $id . '/status';
        
        try {
            // 👇 UPDATE: Balikin jadi method put() sesuai instruksi Darda
            $response = \Illuminate\Support\Facades\Http::timeout(30)->withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept' => 'application/json'
            ])->put($apiUrl, [
                'status' => $request->status
            ]);

            if($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Status berhasil diubah.']);
            }
            
            return response()->json([
                'message' => 'Gagal mengubah status dari server pusat.',
                'debug' => $response->json() ?? $response->body()
            ], 400);
            
        } catch(\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan internal: ' . $e->getMessage()], 500);
        }
    }

    public function destroyProduk($id) 
    {
        $token = session('api_token');
        if (!$token) {
            return response()->json(['message' => 'Sesi telah berakhir. Silakan login ulang.'], 401);
        }
        
        $signature = config('app.api_signature');
        
        // 👇 UPDATE: Tembak langsung ke API Hostinger lu
        $apiUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/' . $id;
        
        try {
            $response = \Illuminate\Support\Facades\Http::timeout(30)->withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept' => 'application/json'
            ])->delete($apiUrl);

            if($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Produk terhapus.']);
            }
            
            return response()->json([
                'message' => 'Gagal menghapus data dari server pusat.',
                'debug' => $response->json() ?? $response->body()
            ], 400);
            
        } catch(\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan internal: ' . $e->getMessage()], 500);
        }
    }

    public function editProduk(Request $request, $id)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login ulang.');
        }
        
        $signature = config('app.api_signature');
        $apiUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/' . $id;

        try {   
            $response = \Illuminate\Support\Facades\Http::timeout(15)->withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ])->get($apiUrl);

            // Ambil bungkus 'data' atau langsung objek response JSON Darda
            $produk = $response->successful() ? ($response->json('data') ?? $response->json()) : null;

            if (!$produk) {
                \Illuminate\Support\Facades\Log::warning("Detail produk ID {$id} tidak ditemukan di API Darda.");
                return redirect()->route('marketplace.travel.kelola-produk')->with('error', 'Produk tidak ditemukan.');
            }

            return view('marketplace.travel.produk.edit', compact('produk'));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Koneksi API Edit Produk Gagal: " . $e->getMessage());
            return redirect()->route('marketplace.travel.kelola-produk')->with('error', 'Gagal terhubung ke server backend.');
        }
    }

    public function updateProduk(Request $request, $id)
    {
        $token = session('api_token');
        if (!$token) {
            return response()->json(['message' => 'Sesi telah berakhir.'], 401);
        }

        $signature = config('app.api_signature');
        $apiUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/' . $id;

        try {
            // 🌟 1. TARIK DATA FOTO LAMA LANGSUNG DARI JAVASCRIPT
            $oldImgMakkah = $request->old_image_makkah ?? '';
            $oldImgMadinah = $request->old_image_madinah ?? '';

            // 🌟 2. SUSUN ARRAY MENTAH
            $quotaQuad = (int) ($request->quota_quad ?? 0);
            $quotaDouble = (int) ($request->quota_double ?? 0);
            $quotaTriple = (int) ($request->quota_triple ?? 0);

            $pricesArray = [
                ['room_types' => 'Quad', 'price' => (int) $request->price_quad, 'quota' => $quotaQuad],
                ['room_types' => 'Double', 'price' => (int) $request->price_double, 'quota' => $quotaDouble],
                ['room_types' => 'Triple', 'price' => (int) $request->price_triple, 'quota' => $quotaTriple]
            ];

            $flightsArray = [
                ['airline_name' => $request->flight_departure, 'type' => 'Departure'],
                ['airline_name' => $request->flight_return, 'type' => 'Return']
            ];

            $hotelMakkahReq = json_decode($request->hotel_makkah ?? '{}', true) ?? [];
            $hotelMadinahReq = json_decode($request->hotel_madinah ?? '{}', true) ?? [];

            // 👇 KUNCI UTAMA (REQUEST DARI BACKEND): KITA PAKE KEY "existing_image" 👇
            $hotelsArray = [
                [
                    'city'           => 'Mekkah',
                    'name'           => $hotelMakkahReq['name'] ?? '',
                    'rating'         => (int) ($hotelMakkahReq['rating'] ?? 0),
                    'jarak'          => $hotelMakkahReq['distance'] ?? '',
                    'facilities'     => is_array($hotelMakkahReq['facilities'] ?? '') ? implode(', ', $hotelMakkahReq['facilities']) : ($hotelMakkahReq['facilities'] ?? ''),
                    'image'          => $oldImgMakkah, // Tetap kirim buat jaga-jaga
                    'existing_image' => $oldImgMakkah  // 🔥 INI DIA PERMINTAAN BACKEND LU!
                ],
                [
                    'city'           => 'Madinah',
                    'name'           => $hotelMadinahReq['name'] ?? '',
                    'rating'         => (int) ($hotelMadinahReq['rating'] ?? 0),
                    'jarak'          => $hotelMadinahReq['distance'] ?? '',
                    'facilities'     => is_array($hotelMadinahReq['facilities'] ?? '') ? implode(', ', $hotelMadinahReq['facilities']) : ($hotelMadinahReq['facilities'] ?? ''),
                    'image'          => $oldImgMadinah, // Tetap kirim buat jaga-jaga
                    'existing_image' => $oldImgMadinah  // 🔥 INI DIA PERMINTAAN BACKEND LU!
                ]
            ];

            $facilitiesPayload = [];
            $incRaw = json_decode($request->included_facilities ?? '[]', true) ?? [];
            foreach ($incRaw as $inc) { if(!empty($inc)) $facilitiesPayload[] = ['facility' => $inc, 'type' => 'INCLUDE']; }
            $excRaw = json_decode($request->excluded_facilities ?? '[]', true) ?? [];
            foreach ($excRaw as $exc) { if(!empty($exc)) $facilitiesPayload[] = ['facility' => $exc, 'type' => 'EXCLUDE']; }

            $itinerariesPayload = [];
            $itRaw = json_decode($request->itinerary ?? '[]', true) ?? [];
            foreach ($itRaw as $it) { if(!empty($it['title'])) $itinerariesPayload[] = ['day_order' => (int)($it['day']??0), 'title' => $it['title'], 'description' => $it['description']??'']; }

            $snksPayload = [];
            $termRaw = json_decode($request->terms ?? '[]', true) ?? [];
            foreach ($termRaw as $t) { if(!empty($t)) $snksPayload[] = ['name' => $t]; }

            $notesPayload = [];
            $noteRaw = json_decode($request->notes ?? '[]', true) ?? [];
            foreach ($noteRaw as $n) { if(!empty($n)) $notesPayload[] = ['note' => $n]; }

            // 🌟 3. BUNGKUS PAYLOAD (WAJIB ENCODE SEMUA ARRAY BIAR NODE.JS AMAN)
            $payload = [
                'nama_produk'       => $request->product_name ?? '',
                'category_id'       => (int) ($request->category ?? 0),
                'tgl_keberangkatan' => $request->departure_date ?? '',
                'tmp_keberangkatan' => $request->departure_from ?? '',
                'duration'          => (int) ($request->duration ?? 0),
                'quota'             => $quotaQuad + $quotaDouble + $quotaTriple,
                'description'       => $request->description ?? '',
                'status'            => $request->status ?? 'publish',
                
                'prices'            => json_encode($pricesArray),
                'flights'           => json_encode($flightsArray),
                'hotels'            => json_encode($hotelsArray), // Sekarang udah ada "existing_image"
                'facilities'        => json_encode($facilitiesPayload),
                'itineraries'       => json_encode($itinerariesPayload),
                'snks'              => json_encode($snksPayload),
                'notes'             => json_encode($notesPayload),
            ];

            // BOM Variabel Root Jaga-jaga buat Multer Darda (Kita tembak pake nama existing_image juga)
            if (!empty($oldImgMakkah)) {
                $payload['hotel_image_mekkah'] = $oldImgMakkah;
                $payload['existing_image_mekkah'] = $oldImgMakkah;
            }
            if (!empty($oldImgMadinah)) {
                $payload['hotel_image_madinah'] = $oldImgMadinah;
                $payload['existing_image_madinah'] = $oldImgMadinah;
            }

            // 🌟 4. KUNCI PERMANEN: WAJIB MULTIPART WALAUPUN GAK ADA GAMBAR BARU
            $http = \Illuminate\Support\Facades\Http::timeout(60)
                ->asMultipart()
                ->withToken($token)
                ->withHeaders([
                    'X-App-Signature' => $signature,
                    'Accept'          => 'application/json'
                ]);

            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $http->attach('thumbnail', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName());
            }
            if ($request->hasFile('image_makkah')) {
                $file = $request->file('image_makkah');
                $http->attach('hotel_image_mekkah', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName());
                unset($payload['hotel_image_mekkah'], $payload['existing_image_mekkah']); // Buang string biar nggak nabrak file asli
            }
            if ($request->hasFile('image_madinah')) {
                $file = $request->file('image_madinah');
                $http->attach('hotel_image_madinah', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName());
                unset($payload['hotel_image_madinah'], $payload['existing_image_madinah']); // Buang string biar nggak nabrak file asli
            }

            // 5. EKSEKUSI
            $response = $http->put($apiUrl, $payload);

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Produk berhasil diperbarui!']);
            }

            $responseData = $response->json();
            $errorPesan = $responseData['message'] ?? 'Gagal memperbarui data.';
            if (isset($responseData['errors'])) {
                $errorList = collect($responseData['errors'])->flatten()->implode(', ');
                $errorPesan .= " (Detail: " . $errorList . ")";
            }

            return response()->json(['message' => $errorPesan, 'debug' => $responseData ?? $response->body()], 400);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
        }
    }

}

