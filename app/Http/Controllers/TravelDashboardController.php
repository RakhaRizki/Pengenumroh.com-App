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

   // =======================================================
    // Update Data Profil Travel (100% Clone dari Jamaah)
    // =======================================================
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

    // =======================================================
    // Update Password Travel
    // =======================================================
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

   // =======================================================
    // Halaman Pesanan Masuk (Travel)
    // =======================================================
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

    // =======================================================
    // Aksi Verifikasi Pembayaran (AJAX) - Fix Validation
    // =======================================================
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

            // Meneruskan 'status' dan 'evidence_url' ke backend (BAWA TOKEN + SIGNATURE)
            $response = Http::withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ])->put($urlApi, [
                'status'       => 'PAID',
                'evidence_url' => $request->input('evidence_url') 
            ]);

            if ($response->successful()) {
                return response()->json(['status' => 'success', 'message' => 'Pembayaran berhasil diverifikasi!']);
            }

            // Menangkap pesan error asli dari validator backend
            $pesanError = $response->json('message') ?? 'Gagal memverifikasi di server.';
            return response()->json(['status' => 'error', 'message' => $pesanError], 400);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Koneksi ke server terputus.'], 500);
        }
    }

   public function kelolaProduk(Request $request)
    {
        $token = session('api_token');
        // Ambil data user yang lagi login dari session
        $userData = session('user'); 
        
        // 1. KEAMANAN: Tendang user jika sesi token atau data user kosong
        if (!$token || !$userData) {
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login ulang.');
        }
        
        // Ambil ID user travel lu
        $userId = $userData['id'] ?? null;
            $signature = config('app.api_signature');

        try {
            // Hit API ke backend Darda
            $response = Http::withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ])->timeout(10)->get($this->apiUrl . '/products'); 

            if ($response->successful()) {
                // Ambil semua tumpukan produk dari API
                $semuaProduk = $response->json('data') ?? [];

                // 2. FILTERING: Saring produk, ambil HANYA yang 'user_id'-nya sama dengan ID akun lu
                $produk = collect($semuaProduk)
                            ->where('user_id', $userId)
                            ->values()
                            ->all();

            } else {
                $produk = [];
                \Illuminate\Support\Facades\Log::warning('API Kelola Produk merespon gagal: Status ' . $response->status() . ' - ' . $response->body());
                // Pakai session()->now biar errornya nggak nyangkut/delay ke halaman berikutnya
                session()->now('error', 'Gagal menyinkronkan data terbaru dari server.');
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Koneksi API Kelola Produk Gagal atau Timeout: ' . $e->getMessage());
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

            $payload = [
                'nama_produk'       => $data['product_name'] ?? '',
                'category_id'       => (int) ($data['category'] ?? 0), 
                'tgl_keberangkatan' => $data['departure_date'] ?? '',
                'tmp_keberangkatan' => $data['departure_from'] ?? '',
                'duration'          => (int) ($data['duration'] ?? 0),
                'quota'             => (int) ($data['quota'] ?? 0),
                'description'       => $data['description'] ?? '',
                'status'            => $data['status'] ?? 'publish', 
            ];

            $payload['prices'] = [
                ['room_types' => 'Quad', 'price' => (int) ($data['price_quad'] ?? 0)],
                ['room_types' => 'Double', 'price' => (int) ($data['price_double'] ?? 0)],
                ['room_types' => 'Triple', 'price' => (int) ($data['price_triple'] ?? 0)]
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

   // ==========================================
    // 1. TAMPILKAN FORM EDIT DENGAN DATA LAMA
    // ==========================================
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

    // ==========================================
    // 2. PROSES SIMPAN PERUBAHAN DATA (PUT)
    // ==========================================
    public function updateProduk(Request $request, $id)
    {
        $token = session('api_token');
        if (!$token) {
            return response()->json(['message' => 'Sesi telah berakhir. Silakan login ulang.'], 401);
        }

        $signature = config('app.api_signature');
        $apiUrl = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/api/products/' . $id;

        try {
            // SINKRONISASI: Susun payload prices sesuai key request frontend lu
            $prices = [
                ['room_types' => 'Quad', 'price' => (int) $request->price_quad],
                ['room_types' => 'Double', 'price' => (int) $request->price_double],
                ['room_types' => 'Triple', 'price' => (int) $request->price_triple]
            ];

            // SINKRONISASI: Susun payload flights sesuai data maskapai
            $flights = [
                ['airline_name' => $request->flight_departure, 'type' => 'Departure'],
                ['airline_name' => $request->flight_return, 'type' => 'Return']
            ];

            // Decode string JSON hotel & fasilitas dari frontend agar dikirim sebagai object array bersih ke Express.js
            $hotelMakkah = json_decode($request->hotel_makkah, true) ?? [];
            $hotelMadinah = json_decode($request->hotel_madinah, true) ?? [];
            
            $hotels = [
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

            // Rekonstruksi facility INCLUDE & EXCLUDE
            $facilitiesPayload = [];
            $included = json_decode($request->included_facilities, true) ?? [];
            if (is_array($included)) {
                foreach ($included as $inc) { $facilitiesPayload[] = ['facility' => $inc, 'type' => 'INCLUDE']; }
            }
            $excluded = json_decode($request->excluded_facilities, true) ?? [];
            if (is_array($excluded)) {
                foreach ($excluded as $exc) { $facilitiesPayload[] = ['facility' => $exc, 'type' => 'EXCLUDE']; }
            }

            // Rekonstruksi itinerary day_order
            $itineraryRaw = json_decode($request->itinerary, true) ?? [];
            $itinerariesPayload = [];
            if (is_array($itineraryRaw)) {
                foreach ($itineraryRaw as $it) {
                    $itinerariesPayload[] = [
                        'day_order'   => (int) ($it['day'] ?? 0),
                        'title'       => $it['title'] ?? '',
                        'description' => $it['description'] ?? ''
                    ];
                }
            }

            // Rekonstruksi SNK & Notes
            $termsRaw = json_decode($request->terms, true) ?? [];
            $snksPayload = [];
            if (is_array($termsRaw)) {
                foreach ($termsRaw as $t) { $snksPayload[] = ['name' => $t]; }
            }

            $notesRaw = json_decode($request->notes, true) ?? [];
            $notesPayload = [];
            if (is_array($notesRaw)) {
                foreach ($notesRaw as $n) { $notesPayload[] = ['note' => $n]; }
            }

            // Gabungkan semua payload utama
            $payload = [
                'nama_produk'          => $request->product_name,
                'category_id'          => (int) $request->category,
                'quota'                => (int) $request->quota,
                'status'               => $request->status,
                'tgl_keberangkatan'    => $request->departure_date,
                'duration'             => (int) $request->duration,
                'tmp_keberangkatan'    => $request->departure_from,
                'description'          => $request->description,
                'prices'               => json_encode($prices),
                'flights'              => json_encode($flights),
                'hotels'               => json_encode($hotels),
                'facility'             => json_encode($facilitiesPayload),
                'itinerary'            => json_encode($itinerariesPayload),
                'snk'                  => json_encode($snksPayload),
                'notes'                => json_encode($notesPayload),
            ];

            // Kirim PUT request ke API Darda Hostinger
            $http = \Illuminate\Support\Facades\Http::timeout(30)->withToken($token)->withHeaders([
                'X-App-Signature' => $signature,
                'Accept'          => 'application/json'
            ]);

            // Handling lampiran file gambar baru jika user melakukan upload ulang
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

            $response = $http->post($apiUrl . '?_method=PUT', $payload); // Menggunakan POST + Method Override PUT agar multipart-form-data file terbaca sempurna oleh Express Multer

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