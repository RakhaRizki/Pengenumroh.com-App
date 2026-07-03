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
        $user = session('user');

        $response = Http::withToken($token)->get($this->apiUrl . '/transaction');

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

        // 1. Siapkan data teks (Sesuai dengan name input di Blade Travel)
        $payloadData = [
            'fullname' => $request->fullname,
        ];

        $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/my-profile';

        $apiRequest = Http::withToken($token);

        // 2. LOGIKA EXACTLY SAMA DENGAN JAMAAH
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
            $userData = session('user');
            $userData['fullname'] = $request->input('fullname');
            
            $responseData = $response->json('data');

            // 👇 KITA PAKAI FOLDER YANG SAMA PERSIS DENGAN PUNYA JAMAAH
            if (isset($responseData['image']) && $responseData['image'] != null) {
                
                $namaFoto = ltrim($responseData['image'], '/'); // Bersihkan garis miring biar rapi
                
                // INI FOLDER ASLINYA DARI BACKEND LU!
                $baseImageUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/profiles/'; 
                
                $newAvatar = $baseImageUrl . $namaFoto;
                $userData['avatar_url'] = $newAvatar;
                session(['user_avatar' => $newAvatar]);
                session(['foto_global_navbar' => $newAvatar]);
            }
            
            session(['user' => $userData]);

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

        // 1. Validasi
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed', 
        ], [
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok!',
            'new_password.min' => 'Password baru minimal 6 karakter!'
        ]);

        // 2. Tembak API Backend
        $response = Http::withToken($token)->post('https://mediumspringgreen-meerkat-585223.hostingersite.com/changePassword', [
            'oldPassword'     => $request->current_password,
            'newPassword'     => $request->new_password,
            'confirmPassword' => $request->new_password 
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Password berhasil diubah!');
        }

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
                    // 👇 LOGIKA FILTER 100% PRESISI BERDASARKAN HASIL DD() 👇
                    $pesanan = collect($rawData)
                        ->filter(function ($trx) use ($myTravelId) {
                            // Ambil user_id dari dalam object product
                            $pemilikProduk = $trx['product']['user_id'] ?? null;
                            
                            // Hanya loloskan transaksi kalau produknya punya Travel ini
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

    // 0. Ambil Signature Keamanan
    $signature = config('app.api_signature');

    try {
        $urlApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/transactions/' . $id;

        // 1. Siapkan data dasar yang PASTI di-update
        $payload = [
            'status' => 'PAID'
        ];

        // 2. CEGAH ERROR API: Hanya kirim evidence_url kalau datanya beneran ada/nggak null
        if ($request->filled('evidence_url') && $request->input('evidence_url') !== 'null') {
            $payload['evidence_url'] = $request->input('evidence_url');
        }

        // 3. Tembak API dengan asJson() biar Backend ngebaca datanya secara sempurna
        // NOTE: Kalau API lu ternyata pakenya PATCH (bukan PUT), tinggal ganti ->put jadi ->patch
        $response = Http::asJson()->withToken($token)->withHeaders([
            'X-App-Signature' => $signature,
            'Accept'          => 'application/json'
        ])->put($urlApi, $payload);

        // 4. Cek apakah update ke database berhasil
        if ($response->successful()) {
            return response()->json(['status' => 'success', 'message' => 'Pembayaran berhasil diverifikasi ke database!']);
        }

        // 5. Tangkap pesan error ASLI dari server API lu kalau misal masih gagal
        $pesanError = $response->json('message') ?? 'Gagal memverifikasi di database server.';
        
        return response()->json([
            'status' => 'error', 
            'message' => $pesanError,
            'debug' => $response->json() // Biar kita tau error sebenernya dari API apa
        ], 400);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error', 
            'message' => 'Koneksi ke server terputus: ' . $e->getMessage()
        ], 500);
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
            // 1. Susun data dasar ke format Array Asli PHP
            $pricesArray = [
                ['room_types' => 'Quad', 'price' => (int) $request->price_quad],
                ['room_types' => 'Double', 'price' => (int) $request->price_double],
                ['room_types' => 'Triple', 'price' => (int) $request->price_triple]
            ];

            $flightsArray = [
                ['airline_name' => $request->flight_departure, 'type' => 'Departure'],
                ['airline_name' => $request->flight_return, 'type' => 'Return']
            ];

            // Decode string JSON hotel & fasilitas dari frontend
            $hotelMakkah = json_decode($request->hotel_makkah ?? '{}', true) ?? [];
            $hotelMadinah = json_decode($request->hotel_madinah ?? '{}', true) ?? [];
            
            $hotelsArray = [
                [
                    'city'       => 'Mekkah',
                    'name'       => $hotelMakkah['name'] ?? '',
                    'rating'     => (int) ($hotelMakkah['rating'] ?? 0),
                    'jarak'      => $hotelMakkah['distance'] ?? '',
                    'facilities' => is_array($hotelMakkah['facilities'] ?? '') ? implode(', ', $hotelMakkah['facilities']) : ($hotelMakkah['facilities'] ?? '')
                ],
                [
                    'city'       => 'Madinah',
                    'name'       => $hotelMadinah['name'] ?? '',
                    'rating'     => (int) ($hotelMadinah['rating'] ?? 0),
                    'jarak'      => $hotelMadinah['distance'] ?? '',
                    'facilities' => is_array($hotelMadinah['facilities'] ?? '') ? implode(', ', $hotelMadinah['facilities']) : ($hotelMadinah['facilities'] ?? '')
                ]
            ];

            // Rekonstruksi model data facility
            $facilitiesPayload = [];
            $includedRaw = json_decode($request->included_facilities ?? '[]', true) ?? [];
            if (is_array($includedRaw)) {
                foreach ($includedRaw as $inc) { 
                    if(!empty($inc)) $facilitiesPayload[] = ['facility' => $inc, 'type' => 'INCLUDE']; 
                }
            }
            $excludedRaw = json_decode($request->excluded_facilities ?? '[]', true) ?? [];
            if (is_array($excludedRaw)) {
                foreach ($excludedRaw as $exc) { 
                    if(!empty($exc)) $facilitiesPayload[] = ['facility' => $exc, 'type' => 'EXCLUDE']; 
                }
            }

            // Rekonstruksi Itinerary
            $itineraryRaw = json_decode($request->itinerary ?? '[]', true) ?? [];
            $itinerariesPayload = [];
            if (is_array($itineraryRaw)) {
                foreach ($itineraryRaw as $it) {
                    if(!empty($it['title'])) {
                        $itinerariesPayload[] = [
                            'day_order'   => (int) ($it['day'] ?? 0),
                            'day'         => (int) ($it['day'] ?? 0),
                            'title'       => $it['title'] ?? '',
                            'description' => $it['description'] ?? ''
                        ];
                    }
                }
            }

            // Rekonstruksi S&K & Notes
            $termsRaw = json_decode($request->terms ?? '[]', true) ?? [];
            $snksPayload = [];
            if (is_array($termsRaw)) {
                foreach ($termsRaw as $t) { 
                    if(!empty($t)) $snksPayload[] = ['name' => $t]; 
                }
            }

            $notesRaw = json_decode($request->notes ?? '[]', true) ?? [];
            $notesPayload = [];
            if (is_array($notesRaw)) {
                foreach ($notesRaw as $n) { 
                    if(!empty($n)) $notesPayload[] = ['note' => $n]; 
                }
            }

            // ==========================================================================
            // PAYLOAD ALL-IN-ONE (BOM SEMUA VARIASI NAMA BIAR PASTI MASUK)
            // ==========================================================================
            $payload = [
                'nama_produk'         => $request->product_name,
                'product_name'        => $request->product_name,
                'category_id'         => (int) $request->category,
                'category'            => (int) $request->category,
                'quota'               => (int) $request->quota,
                'status'              => $request->status,
                'tgl_keberangkatan'   => $request->departure_date,
                'departure_date'      => $request->departure_date,
                'duration'            => (int) $request->duration,
                'durasi_hari'         => (int) $request->duration,
                'tmp_keberangkatan'   => $request->departure_from,
                'departure_from'      => $request->departure_from,
                'description'         => $request->description,
                
                'prices'              => json_encode($pricesArray),
                'flights'             => json_encode($flightsArray),
                'hotels'              => json_encode($hotelsArray),
                
                'facility'            => json_encode($facilitiesPayload),
                'facilities'          => json_encode($facilitiesPayload),
                'included_facilities' => $request->included_facilities,
                'excluded_facilities' => $request->excluded_facilities,
                
                'itinerary'           => json_encode($itinerariesPayload),
                'itineraries'         => json_encode($itinerariesPayload),
                
                // 👇 INI DIA BOM-NYA: Kita kirim semua variasi S&K ke backend 👇
                'snk'                 => json_encode($snksPayload),
                'snks'                => json_encode($snksPayload),
                'terms'               => $request->terms, 
                'term'                => $request->terms,
                'syarat'              => json_encode($snksPayload),
                
                'notes'               => json_encode($notesPayload),
            ];

            // Setup HTTP Client sebagai Multipart
            $http = \Illuminate\Support\Facades\Http::timeout(30)
                ->asMultipart()
                ->withToken($token)
                ->withHeaders([
                    'X-App-Signature' => $signature,
                    'Accept'          => 'application/json'
                ]);

            // Proses Attach Gambar (Udah aman)
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $http->attach('thumbnail', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName());
            }
            if ($request->hasFile('image_makkah')) {
                $file = $request->file('image_makkah');
                $http->attach('hotel_image_mekkah', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName());
            }
            if ($request->hasFile('image_madinah')) {
                $file = $request->file('image_madinah');
                $http->attach('hotel_image_madinah', fopen($file->getRealPath(), 'r'), $file->getClientOriginalName());
            }

            // Eksekusi PUT Request
            $response = $http->put($apiUrl, $payload);

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Produk berhasil diperbarui!']);
            }

            return response()->json([
                'message' => 'Gagal memperbarui data di server pusat.',
                'debug'   => $response->json() ?? $response->body()
            ], 400);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()], 500);
        }
    }

}