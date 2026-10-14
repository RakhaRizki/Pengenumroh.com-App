<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Edit Produk - Pengenumroh</title>
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .form-input:focus { border-color: #ea580c; box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1); }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
        .animate-fade-in-down { animation: fadeInDown 0.2s ease-out; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

    @php
        // 1. Data User / Mitra Travel
        $userData = session('user') ?? [];
        $namaTravel = $userData['fullname'] ?? ($userData['username'] ?? 'Biro Travel');
        $emailTravel = $userData['email'] ?? 'Belum ada email';
        $avatar = $userData['avatar_url'] ?? session('user_avatar') ?? 'https://ui-avatars.com/api/?name=' . urlencode($namaTravel) . '&background=F97316&color=fff';
        $bergabung = isset($userData['created_at']) ? \Carbon\Carbon::parse($userData['created_at'])->translatedFormat('F Y') : date('Y');
        $statusRaw = $userData['status'] ?? 'aktif'; 
        $isAktif = strtolower($statusRaw) === 'aktif' || $statusRaw == 1;
        
        $pesanan = $pesanan ?? [];
        $countPending = collect($pesanan)->filter(function ($trx) {
            return in_array(strtoupper($trx['status'] ?? ''), ['UNPAID', 'PENDING']);
        })->count();

        // 2. Data Produk Utama
        $p = $produk ?? [];
        $isPublish = ($p['status'] ?? 'publish') === 'publish';

        // 3. Ekstrak Fasilitas (Safe Guarded via data_get)
        $fasilitasDB = $p['facility'] ?? '[]';
        $rawFacilities = is_string($fasilitasDB) ? json_decode($fasilitasDB, true) : $fasilitasDB;
        $facilities = collect(is_array($rawFacilities) ? $rawFacilities : []);
        $included = $facilities->where('type', 'INCLUDE')->pluck('facility')->toArray();
        $excluded = $facilities->where('type', 'EXCLUDE')->pluck('facility')->toArray();

        // 4. Ekstrak Itinerary
        $itineraryDB = $p['itinerary'] ?? '[]';
        $rawItinerary = is_string($itineraryDB) ? json_decode($itineraryDB, true) : $itineraryDB;
        $itineraries = is_array($rawItinerary) ? $rawItinerary : [];

        // 5. Ekstrak Harga (Safe Guarded via data_get)
        $pricesDB = $p['prices'] ?? '[]';
        $rawPrices = is_string($pricesDB) ? json_decode($pricesDB, true) : $pricesDB;
        $prices = collect(is_array($rawPrices) ? $rawPrices : []);
        
        $hargaQuad = data_get($prices->firstWhere('room_types', 'Quad'), 'price', '');
        $kuotaQuad = data_get($prices->firstWhere('room_types', 'Quad'), 'quota', '');

        $hargaTriple = data_get($prices->firstWhere('room_types', 'Triple'), 'price', '');
        $kuotaTriple = data_get($prices->firstWhere('room_types', 'Triple'), 'quota', '');

        $hargaDouble = data_get($prices->firstWhere('room_types', 'Double'), 'price', '');
        $kuotaDouble = data_get($prices->firstWhere('room_types', 'Double'), 'quota', '');

        // 6. Ekstrak Maskapai (Safe Guarded via data_get)
        $flightsDB = $p['flights'] ?? '[]';
        $rawFlights = is_string($flightsDB) ? json_decode($flightsDB, true) : $flightsDB;
        $flights = collect(is_array($rawFlights) ? $rawFlights : []);
        $maskapaiBerangkat = data_get($flights->firstWhere('type', 'Departure'), 'airline_name', '');
        $maskapaiPulang = data_get($flights->firstWhere('type', 'Return'), 'airline_name', '');
        $isMaskapaiSama = empty($maskapaiPulang) || $maskapaiBerangkat === $maskapaiPulang;

        // 7. Ekstrak Data Hotel (SAFE GUARDED & KEBAL TYPO)
        $hotelsDB = $p['hotels'] ?? '[]';
        $rawHotels = is_string($hotelsDB) ? json_decode($hotelsDB, true) : $hotelsDB;
        $hotels = collect(is_array($rawHotels) ? $rawHotels : []);

        // 👇 FIX: Menggunakan stripos biar mau 'Mekkah', 'Makkah', atau 'makkah' tetep ketemu datanya! 👇
        $hotelMakkah = $hotels->first(function($h) {
            $city = strtolower($h['city'] ?? '');
            return strpos($city, 'mekkah') !== false || strpos($city, 'makkah') !== false;
        }) ?? [];

        $hotelMadinah = $hotels->first(function($h) {
            return strpos(strtolower($h['city'] ?? ''), 'madinah') !== false;
        }) ?? [];

        $fasilitasMakkahArr = !empty($hotelMakkah['facilities']) ? array_map('trim', explode(',', $hotelMakkah['facilities'])) : [];
        $fasilitasMadinahArr = !empty($hotelMadinah['facilities']) ? array_map('trim', explode(',', $hotelMadinah['facilities'])) : [];

        $fasilitasMakkahArr = !empty($hotelMakkah['facilities']) ? array_map('trim', explode(',', $hotelMakkah['facilities'])) : [];
        $fasilitasMadinahArr = !empty($hotelMadinah['facilities']) ? array_map('trim', explode(',', $hotelMadinah['facilities'])) : [];

        // 8. Ekstrak Syarat & Catatan
        $snksDB = $p['snk'] ?? '[]';
        $rawSnks = is_string($snksDB) ? json_decode($snksDB, true) : $snksDB;
        $snks = collect(is_array($rawSnks) ? $rawSnks : [])->pluck('name')->toArray();

        $notesDB = $p['notes'] ?? '[]';
        $rawNotes = is_string($notesDB) ? json_decode($notesDB, true) : $notesDB;
        $notes = collect(is_array($rawNotes) ? $rawNotes : [])->pluck('note')->toArray();

        // 9. URL Gambar Existing
        $domainApi = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/';
        $baseUrlThumbnail = $domainApi . 'assets/img/products/thumbnails/';
        $baseUrlHotel     = $domainApi . 'assets/img/products/hotels/';

        $imgThumbnail = !empty($p['thumbnail_url']) ? $baseUrlThumbnail . $p['thumbnail_url'] : '';
        $imgMakkah    = !empty($hotelMakkah['image']) ? $baseUrlHotel . $hotelMakkah['image'] : '';
        $imgMadinah   = !empty($hotelMadinah['image']) ? $baseUrlHotel . $hotelMadinah['image'] : '';
    @endphp

   <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo diklik balik ke kelola produk (atau bisa dibiarin ke beranda) -->
                <a href="{{ route('marketplace.travel.kelola-produk') }}" class="flex items-center gap-2 group">
                    <img src="/assets/img/marketplace/logo.png" alt="Logo PengenUmroh" class="h-10 w-auto object-contain">
                </a>
                <!-- Menu Desktop -->
                <div class="hidden lg:flex items-center gap-4">
                    <a href="{{ route('marketplace.travel.kelola-produk') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-600 transition bg-slate-50 px-4 py-2 rounded-full border border-slate-100 hover:bg-orange-50 hover:border-orange-100">
                        <i class="ph-bold ph-arrow-left"></i> Kembali ke Kelola Produk
                    </a>
                    <div class="h-6 w-px bg-slate-200 mx-2"></div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-700">{{ $namaTravel }}</p>
                            <p class="text-[10px] text-slate-500">Mitra Travel</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                            <img id="nav-avatar" src="{{ $avatar }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
                <!-- Menu Mobile -->
                <div class="lg:hidden">
                    <a href="{{ route('marketplace.travel.kelola-produk') }}" class="text-slate-700 hover:text-orange-600">
                        <i class="ph-bold ph-arrow-left text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-28 pb-5 min-h-screen bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <div class="lg:col-span-1 space-y-6" data-aos="fade-right">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-orange-100 to-orange-50"></div>
                        <div class="relative z-10">
                            <div class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow-md overflow-hidden bg-slate-100 mb-3">
                                <img id="sidebar-avatar" src="{{ $avatar }}" class="w-full h-full object-cover">
                            </div>
                            <h2 class="text-lg font-bold text-slate-900">{{ $namaTravel }}</h2>
                            <p class="text-sm text-slate-500">Bergabung sejak {{ $bergabung }}</p>
                            <div class="mt-4 text-left">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-600">Status Akun</span>
                                    <span class="font-bold {{ $isAktif ? 'text-emerald-600' : 'text-red-600' }}">{{ $isAktif ? 'Aktif' : 'Menunggu Verifikasi' }}</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="{{ $isAktif ? 'bg-emerald-500' : 'bg-red-500' }} h-2 rounded-full w-full"></div>
                                </div>
                                <p class="text-[11px] mt-2 flex items-center gap-1 font-medium px-2 py-1 rounded-lg {{ $isAktif ? 'text-emerald-700 bg-emerald-50' : 'text-red-700 bg-red-50' }}">
                                    <i class="ph-fill {{ $isAktif ? 'ph-check-circle text-emerald-600' : 'ph-clock text-red-600' }}"></i>
                                    {{ $isAktif ? 'Mitra Travel Terverifikasi' : 'Harap Lengkapi Data' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <nav class="flex flex-col">
                            <a href="{{ route('marketplace.travel.profil') }}" class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.profil') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                                <i class="ph-bold ph-user text-xl"></i> Profil
                            </a>
                            <a href="{{ route('marketplace.travel.pesanan-masuk') }}" class="flex items-center justify-between px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.pesanan-masuk') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                                <div class="flex items-center gap-3"><i class="ph-bold ph-receipt text-xl"></i> Pesanan Masuk</div>
                                @if ($countPending > 0) <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">{{ $countPending }}</span> @endif
                            </a>
                            <a href="{{ route('marketplace.travel.upload-produk') }}" class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.upload-produk') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                                <i class="ph-bold ph-upload text-xl"></i> Upload Produk
                            </a>
                            <div class="bg-orange-50 border-l-4 border-orange-600">
                                <a href="{{ route('marketplace.travel.kelola-produk') }}" class="flex items-center gap-3 px-5 py-3 text-slate-600 hover:text-orange-900 transition group font-bold">
                                    <i class="ph-bold ph-package text-xl group-hover:scale-110 transition-transform"></i> <span>Kelola Produk</span>
                                </a>
                                <div class="flex items-center gap-2 pl-12 pb-4 pr-5">
                                    <div class="w-1.5 h-1.5 rounded-full bg-orange-600 animate-pulse"></div>
                                    <span class="text-sm font-bold text-orange-600">Edit Produk</span>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-3" data-aos="fade-up">
                    <form id="productForm" onsubmit="handleUpdate(event)">

                       <input type="hidden" id="old_img_makkah" value="{{ $hotelMakkah['image'] ?? '' }}">
                       <input type="hidden" id="old_img_madinah" value="{{ $hotelMadinah['image'] ?? '' }}">   
                        
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">Edit Produk</h1>
                                <p class="text-slate-500 text-sm mt-1">Perbarui informasi paket perjalanan Anda.</p>
                            </div>
                            <div class="hidden md:flex gap-3">
                                <a href="{{ route('marketplace.travel.kelola-produk') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition flex items-center justify-center text-sm">Batal</a>
                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-orange-600 text-white font-bold hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition flex items-center gap-2 text-sm">
                                    <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>

                        <div class="space-y-6">
                            
                           <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-broadcast text-red-500 text-xl"></i> Status Produk
                                </h3>
                                <div class="flex flex-col md:flex-row justify-between items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <div class="flex items-start gap-4">
                                        <div class="p-3 bg-white rounded-full border border-slate-200 text-orange-600 shadow-sm">
                                            <i class="ph-bold ph-eye text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-slate-900 text-sm">Status Penayangan</h4>
                                            <p class="text-xs text-slate-500 mt-1 max-w-sm">Otomatis tersimpan ke database saat tombol ini digeser.</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" id="statusToggle" data-id="{{ $p['id'] ?? 0 }}" class="sr-only peer" {{ $isPublish ? 'checked' : '' }}>
                                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-green-500"></div>
                                        <span class="ml-3 text-sm font-bold {{ $isPublish ? 'text-slate-700' : 'text-slate-400' }}" id="statusLabel">{{ $isPublish ? 'Aktif (Tayang)' : 'Non-Aktif (Draft)' }}</span>
                                    </label>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <i class="ph-duotone ph-image text-orange-500 text-xl"></i> Foto Produk Utama
                                </h3>
                                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:bg-slate-50 hover:border-orange-400 transition cursor-pointer group {{ $imgThumbnail ? 'hidden' : '' }}" id="dropzone-thumbnail" onclick="document.getElementById('thumbnail_product').click()">
                                    <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition"><i class="ph-bold ph-upload-simple text-3xl"></i></div>
                                    <h4 class="text-sm font-bold text-slate-900">Klik untuk upload foto baru</h4>
                                </div>
                                <input type="file" id="thumbnail_product" name="thumbnail_product" class="hidden" accept="image/*" onchange="previewMainImg(event)">
                                <div class="mt-4 flex justify-center relative group w-fit mx-auto">
                                    <img id="preview-thumbnail" src="{{ $imgThumbnail }}" class="h-48 w-auto rounded-lg object-cover shadow-md border border-slate-200 {{ $imgThumbnail ? '' : 'hidden' }}">
                                    <button type="button" onclick="document.getElementById('thumbnail_product').click()" class="absolute inset-0 bg-black/50 text-white flex items-center justify-center rounded-lg opacity-0 group-hover:opacity-100 transition font-bold text-sm {{ $imgThumbnail ? '' : 'hidden' }}" id="btn-change-thumbnail"><i class="ph-bold ph-pencil-simple mr-2"></i> Ganti Foto Utama</button>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-info text-blue-500 text-xl"></i> Informasi Paket
                                </h3>
                                <div class="space-y-8">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="text-sm font-bold text-slate-700">Nama Paket</label>
                                            <input type="text" id="product_name" value="{{ $p['nama_produk'] ?? '' }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>

                                        <!-- Kategori -->
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="text-sm font-bold text-slate-700">Kategori</label>
                                            <div class="relative">
                                                <i class="ph-bold ph-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                <select id="category" required onchange="handleCategoryChange(this)" class="w-full pl-11 pr-10 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition appearance-none bg-white">
                                                    <option value="1" @selected(($p['category_id'] ?? 0) == 1)>Umroh Reguler 9 Hari</option>
                                                    <option value="2" @selected(($p['category_id'] ?? 0) == 2)>Umroh Reguler 12 Hari</option>
                                                    <option value="3" @selected(($p['category_id'] ?? 0) == 3)>Umroh Plus Tour</option>
                                                    <option value="4" @selected(($p['category_id'] ?? 0) == 4)>Umroh Ramadhan</option>
                                                    <option value="6" @selected(($p['category_id'] ?? 0) == 6)>Haji</option>
                                                </select>
                                                <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                            </div>
                                        </div>

                                        <!-- 👇 BAGIAN KUOTA (DIPECAH 3) 👇 -->
                                        <div class="space-y-3 md:col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                            <label class="text-sm font-bold text-slate-700">Jumlah Kuota per Tipe Kamar (Pax)</label>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <!-- Quad -->
                                                <div class="space-y-1.5">
                                                    <span class="text-xs font-semibold text-slate-500">Kamar Quad</span>
                                                    <div class="relative">
                                                        <i class="ph-bold ph-users-four absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                        <input type="number" id="quota_quad" value="{{ $kuotaQuad }}" min="0" required class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                                    </div>
                                                </div>
                                                <!-- Double -->
                                                <div class="space-y-1.5">
                                                    <span class="text-xs font-semibold text-slate-500">Kamar Double</span>
                                                    <div class="relative">
                                                        <i class="ph-bold ph-users absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                        <input type="number" id="quota_double" value="{{ $kuotaDouble }}" min="0" required class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                                    </div>
                                                </div>
                                                <!-- Triple -->
                                                <div class="space-y-1.5">
                                                    <span class="text-xs font-semibold text-slate-500">Kamar Triple</span>
                                                    <div class="relative">
                                                        <i class="ph-bold ph-users-three absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                        <input type="number" id="quota_triple" value="{{ $kuotaTriple }}" min="0" required class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="border-slate-100">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="space-y-3">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2"><i class="ph-fill ph-check-circle text-green-500"></i> Fasilitas Termasuk</label>
                                            <div class="flex gap-2">
                                                <input type="text" id="input-included" placeholder="Ketik lalu Enter" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-green-500 transition" onkeypress="handleEnter(event, 'included')">
                                                <button type="button" onclick="addItemFromInput('included')" class="bg-green-100 text-green-700 p-2.5 rounded-xl hover:bg-green-200 transition"><i class="ph-bold ph-plus"></i></button>
                                            </div>
                                            <ul id="list-included" class="space-y-2"></ul>
                                        </div>
                                        <div class="space-y-3">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2"><i class="ph-fill ph-x-circle text-red-500"></i> Tidak Termasuk</label>
                                            <div class="flex gap-2">
                                                <input type="text" id="input-excluded" placeholder="Ketik lalu Enter" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-red-500 transition" onkeypress="handleEnter(event, 'excluded')">
                                                <button type="button" onclick="addItemFromInput('excluded')" class="bg-red-100 text-red-700 p-2.5 rounded-xl hover:bg-red-200 transition"><i class="ph-bold ph-plus"></i></button>
                                            </div>
                                            <ul id="list-excluded" class="space-y-2"></ul>
                                        </div>
                                    </div>

                                    <hr class="border-slate-100">

                                    <div class="space-y-4">
                                        <label class="text-sm font-bold text-slate-700 flex items-center gap-2"><i class="ph-duotone ph-path text-orange-500 text-lg"></i> Rencana Perjalanan (Itinerary)</label>
                                        <div id="itinerary-container" class="space-y-0 relative pl-4 border-l-2 border-slate-100 ml-2"></div>
                                        <button type="button" onclick="addItineraryDay()" class="w-full py-3 border-2 border-dashed border-slate-200 text-slate-500 rounded-xl font-bold text-sm hover:border-orange-400 hover:text-orange-600 hover:bg-orange-50 transition flex items-center justify-center gap-2"><i class="ph-bold ph-plus-circle"></i> Tambah Hari Perjalanan</button>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-airplane-tilt text-purple-500 text-xl"></i> Jadwal & Penerbangan
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700">Tanggal Keberangkatan</label>
                                        <input type="date" id="departure_date" value="{{ $p['tgl_keberangkatan'] ?? '' }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700">Durasi (Hari)</label>
                                        <div class="relative">
                                            <input type="number" id="duration" value="{{ $p['duration'] ?? ($p['durasi_hari'] ?? 9) }}" required onchange="adjustItinerary(this.value)" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Hari</span>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700">Keberangkatan</label>
                                    <div class="relative">
                                        <i class="ph-bold ph-map-pin absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                        @php
                                            // Logika cerdas untuk membaca data lama, meskipun ada typo/pakai kode bandara
                                            $kotaAwal = strtolower($p['tmp_keberangkatan'] ?? '');
                                        @endphp
                                        <select id="departure_from" required class="w-full pl-11 pr-10 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition appearance-none bg-white">
                                            <option value="" disabled {{ empty($kotaAwal) ? 'selected' : '' }}>Pilih Kota Keberangkatan</option>
                                            <option value="Jakarta" {{ str_contains($kotaAwal, 'jakarta') || str_contains($kotaAwal, 'cgk') ? 'selected' : '' }}>Jakarta (CGK)</option>
                                            <option value="Surabaya" {{ str_contains($kotaAwal, 'surabaya') || str_contains($kotaAwal, 'sub') ? 'selected' : '' }}>Surabaya (SUB)</option>
                                            <option value="Medan" {{ str_contains($kotaAwal, 'medan') || str_contains($kotaAwal, 'kno') ? 'selected' : '' }}>Medan (KNO)</option>
                                            <option value="Makassar" {{ str_contains($kotaAwal, 'makassar') || str_contains($kotaAwal, 'upg') ? 'selected' : '' }}>Makassar (UPG)</option>
                                            <option value="Jeddah" {{ str_contains($kotaAwal, 'jeddah') ? 'selected' : '' }}>Jeddah (Langsung)</option>
                                        </select>
                                        <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                    </div>
                                </div>
                                </div>
                                <div class="p-5 bg-slate-50 rounded-xl border border-slate-100 transition-all duration-300">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="flex items-center gap-2 cursor-pointer select-none">
                                            <div class="relative">
                                                <input type="checkbox" id="sameAirlineToggle" class="sr-only peer" {{ $isMaskapaiSama ? 'checked' : '' }} onchange="toggleReturnAirline()">
                                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                                            </div>
                                            <span class="text-sm font-semibold text-slate-700">Maskapai Pulang Pergi sama</span>
                                        </label>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2 {{ $isMaskapaiSama ? 'md:col-span-2' : 'md:col-span-1' }}" id="departureContainer">
                                            <label class="text-sm font-bold text-slate-700" id="departureLabel">Nama Maskapai</label>
                                            <div class="relative">
                                                <i class="ph-bold ph-airplane-tilt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                <input type="text" id="flight_departure" value="{{ $maskapaiBerangkat }}" required class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                            </div>
                                        </div>
                                        <div class="space-y-2 {{ $isMaskapaiSama ? 'hidden' : '' }}" id="returnContainer">
                                            <label class="text-sm font-bold text-slate-700">Maskapai Kepulangan</label>
                                            <div class="relative">
                                                <i class="ph-bold ph-airplane-landing absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                <input type="text" id="flight_return" value="{{ $maskapaiPulang }}" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-buildings text-yellow-500 text-xl"></i> Akomodasi Hotel
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    
                                    <div class="space-y-4 p-5 bg-slate-50 rounded-xl border border-slate-100 group hover:border-orange-200 transition duration-300">
                                        <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2">
                                            <p class="font-bold text-slate-700">Hotel Makkah</p>
                                            <i class="ph-fill ph-kaaba text-slate-400"></i>
                                        </div>
                                        <div class="relative h-32 w-full rounded-xl border-2 border-dashed border-slate-300 bg-white hover:bg-orange-50 hover:border-orange-400 transition cursor-pointer flex flex-col items-center justify-center group/upload overflow-hidden" onclick="document.getElementById('img_makkah').click()">
                                          <input type="file" id="img_makkah" accept="image/*" class="hidden" onchange="previewHotelImg(event, 'preview-makkah', 'placeholder-makkah')">
                                          <input type="hidden" id="old_img_makkah" value="{{ $hotelMakkah['image'] ?? '' }}">
                                            <div class="text-center p-2 {{ $imgMakkah ? 'hidden' : '' }}" id="placeholder-makkah">
                                                <i class="ph-bold ph-image text-2xl text-slate-300 group-hover/upload:text-orange-500 transition mb-1"></i>
                                                <p class="text-xs font-bold text-slate-400 group-hover/upload:text-orange-600 transition">Foto Hotel Makkah</p>
                                            </div>
                                            <img id="preview-makkah" src="{{ $imgMakkah }}" class="absolute inset-0 w-full h-full object-cover pointer-events-none {{ $imgMakkah ? '' : 'hidden' }}">
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/upload:opacity-100 transition duration-300 {{ $imgMakkah ? '' : 'hidden' }}" id="overlay-makkah">
                                                <p class="text-white text-xs font-bold"><i class="ph-bold ph-pencil-simple"></i> Ganti Foto</p>
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Nama Hotel</label>
                                                <input type="text" id="makkah_name" value="{{ $hotelMakkah['name'] ?? '' }}" required class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Bintang</label>
                                                <div class="relative">
                                                    <select id="makkah_rating" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white appearance-none transition shadow-sm focus:shadow-md">
                                                        <option value="5" @selected(($hotelMakkah['rating'] ?? 0) == 5)>⭐⭐⭐⭐⭐ (Bintang 5)</option>
                                                        <option value="4" @selected(($hotelMakkah['rating'] ?? 0) == 4)>⭐⭐⭐⭐ (Bintang 4)</option>
                                                        <option value="3" @selected(($hotelMakkah['rating'] ?? 0) == 3)>⭐⭐⭐ (Bintang 3)</option>
                                                        <option value="2" @selected(($hotelMakkah['rating'] ?? 0) == 2)>⭐⭐ (Bintang 2)</option>
                                                        <option value="1" @selected(($hotelMakkah['rating'] ?? 0) == 1)>⭐ (Bintang 1)</option>
                                                    </select>
                                                    <i class="ph-bold ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                                </div>
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Jarak ke Masjidil Haram</label>
                                                <div class="relative">
                                                    <i class="ph-bold ph-person-simple-walk absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                    <input type="text" id="makkah_distance" value="{{ $hotelMakkah['jarak'] ?? '' }}" class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                                </div>
                                            </div>
                                            <div class="space-y-1.5 pt-2">
                                                <label class="text-xs font-semibold text-slate-500">Fasilitas Hotel</label>
                                                <div class="flex gap-2 mb-2">
                                                    <input type="text" id="input-fasilitas_makkah" placeholder="Ketik lalu Enter" class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-orange-500 bg-white shadow-sm" onkeypress="handleEnter(event, 'fasilitas_makkah')">
                                                    <button type="button" onclick="addItemFromInput('fasilitas_makkah')" class="bg-orange-100 text-orange-700 px-3 rounded-lg hover:bg-orange-200 transition"><i class="ph-bold ph-plus"></i></button>
                                                </div>
                                                <ul id="list-fasilitas_makkah" class="space-y-1.5 flex flex-wrap gap-2"></ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-y-4 p-5 bg-slate-50 rounded-xl border border-slate-100 group hover:border-orange-200 transition duration-300">
                                        <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2">
                                            <p class="font-bold text-slate-700">Hotel Madinah</p>
                                        </div>
                                        <div class="relative h-32 w-full rounded-xl border-2 border-dashed border-slate-300 bg-white hover:bg-orange-50 hover:border-orange-400 transition cursor-pointer flex flex-col items-center justify-center group/upload overflow-hidden" onclick="document.getElementById('img_madinah').click()">
                                           <input type="file" id="img_madinah" accept="image/*" class="hidden" onchange="previewHotelImg(event, 'preview-madinah', 'placeholder-madinah')">
                                           <input type="hidden" id="old_img_madinah" value="{{ $hotelMadinah['image'] ?? '' }}">
                                            <div class="text-center p-2 {{ $imgMadinah ? 'hidden' : '' }}" id="placeholder-madinah">
                                                <i class="ph-bold ph-image text-2xl text-slate-300 group-hover/upload:text-orange-500 transition mb-1"></i>
                                                <p class="text-xs font-bold text-slate-400 group-hover/upload:text-orange-600 transition">Foto Hotel Madinah</p>
                                            </div>
                                            <img id="preview-madinah" src="{{ $imgMadinah }}" class="absolute inset-0 w-full h-full object-cover pointer-events-none {{ $imgMadinah ? '' : 'hidden' }}">
                                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover/upload:opacity-100 transition duration-300 {{ $imgMadinah ? '' : 'hidden' }}" id="overlay-madinah">
                                                <p class="text-white text-xs font-bold"><i class="ph-bold ph-pencil-simple"></i> Ganti Foto</p>
                                            </div>
                                        </div>
                                        <div class="space-y-3">
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Nama Hotel</label>
                                                <input type="text" id="madinah_name" value="{{ $hotelMadinah['name'] ?? '' }}" required class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Bintang</label>
                                                <div class="relative">
                                                    <select id="madinah_rating" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white appearance-none transition shadow-sm focus:shadow-md">
                                                        <option value="5" @selected(($hotelMadinah['rating'] ?? 0) == 5)>⭐⭐⭐⭐⭐ (Bintang 5)</option>
                                                        <option value="4" @selected(($hotelMadinah['rating'] ?? 0) == 4)>⭐⭐⭐⭐ (Bintang 4)</option>
                                                        <option value="3" @selected(($hotelMadinah['rating'] ?? 0) == 3)>⭐⭐⭐ (Bintang 3)</option>
                                                        <option value="2" @selected(($hotelMadinah['rating'] ?? 0) == 2)>⭐⭐ (Bintang 2)</option>
                                                        <option value="1" @selected(($hotelMadinah['rating'] ?? 0) == 1)>⭐ (Bintang 1)</option>
                                                    </select>
                                                    <i class="ph-bold ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                                </div>
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Jarak ke Masjid Nabawi</label>
                                                <div class="relative">
                                                    <i class="ph-bold ph-person-simple-walk absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                    <input type="text" id="madinah_distance" value="{{ $hotelMadinah['jarak'] ?? '' }}" class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                                </div>
                                            </div>
                                            <div class="space-y-1.5 pt-2">
                                                <label class="text-xs font-semibold text-slate-500">Fasilitas Hotel</label>
                                                <div class="flex gap-2 mb-2">
                                                    <input type="text" id="input-fasilitas_madinah" placeholder="Ketik lalu Enter" class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-orange-500 bg-white shadow-sm" onkeypress="handleEnter(event, 'fasilitas_madinah')">
                                                    <button type="button" onclick="addItemFromInput('fasilitas_madinah')" class="bg-orange-100 text-orange-700 px-3 rounded-lg hover:bg-orange-200 transition"><i class="ph-bold ph-plus"></i></button>
                                                </div>
                                                <ul id="list-fasilitas_madinah" class="space-y-1.5 flex flex-wrap gap-2"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-money text-green-600 text-xl"></i> Harga Paket
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <div class="flex justify-between"><label class="text-sm font-bold text-slate-700">Harga Quad (Sekamar Ber-4) *</label></div>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                            <input type="text" id="price_quad" value="{{ $hargaQuad }}" required oninput="formatCurrency(this)" class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-lg font-bold focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between"><label class="text-sm font-bold text-slate-700">Harga Triple (Sekamar Ber-3) *</label></div>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                            <input type="text" id="price_triple" value="{{ $hargaTriple }}" required oninput="formatCurrency(this)" class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-lg font-bold focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <div class="flex justify-between"><label class="text-sm font-bold text-slate-700">Harga Double (Sekamar Ber-2) *</label></div>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                            <input type="text" id="price_double" value="{{ $hargaDouble }}" required oninput="formatCurrency(this)" class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-lg font-bold focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-notebook text-orange-500 text-xl"></i> Syarat & Deskripsi
                                </h3>
                                <div class="space-y-8">
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700 block">Tentang Paket / Deskripsi</label>
                                        <textarea id="description" rows="5" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition resize-none leading-relaxed">{{ $p['description'] ?? '' }}</textarea>
                                    </div>
                                    <hr class="border-slate-100">
                                    <div class="space-y-3">
                                        <label class="text-sm font-bold text-slate-700 flex items-center gap-2"><i class="ph-fill ph-shield-check text-orange-500"></i> Syarat Pendaftaran</label>
                                        <div class="flex gap-2">
                                            <input type="text" id="input-syarat" placeholder="Ketik syarat lalu tekan Enter" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-orange-500 transition" onkeypress="handleEnter(event, 'syarat')">
                                            <button type="button" onclick="addItemFromInput('syarat')" class="bg-orange-100 text-orange-700 p-2.5 rounded-xl hover:bg-orange-200 transition"><i class="ph-bold ph-plus"></i></button>
                                        </div>
                                        <ul id="list-syarat" class="space-y-2"></ul>
                                    </div>
                                    <hr class="border-slate-100">
                                    <div class="space-y-3">
                                        <label class="text-sm font-bold text-slate-700 flex items-center gap-2"><i class="ph-fill ph-warning-circle text-orange-500"></i> Poin Catatan Penting</label>
                                        <div class="flex gap-2">
                                            <input type="text" id="input-catatan" placeholder="Ketik poin catatan lalu Enter" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-orange-500 transition" onkeypress="handleEnter(event, 'catatan')">
                                            <button type="button" onclick="addItemFromInput('catatan')" class="bg-orange-100 text-orange-700 p-2.5 rounded-xl hover:bg-orange-200 transition"><i class="ph-bold ph-plus"></i></button>
                                        </div>
                                        <ul id="list-catatan" class="space-y-2"></ul>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="md:hidden pt-4 pb-8 space-y-3">
                            <button type="submit" class="w-full py-3.5 rounded-xl bg-orange-600 text-white font-bold hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition flex items-center justify-center gap-2">
                                <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('marketplace.travel.kelola-produk') }}" class="block text-center w-full py-3.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition"> Batal </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // ===== 1. PRE-FILL DATA DARI DATABASE (DYNAMIC LISTS) =====
        const existingData = {
            included: @json($included ?? []),
            excluded: @json($excluded ?? []),
            fasilitas_makkah: @json($fasilitasMakkahArr),
            fasilitas_madinah: @json($fasilitasMadinahArr),
            syarat: @json($snks ?? []),
            catatan: @json($notes ?? []),
            itinerary: @json($itineraries ?? [])
        };

        window.onload = function() {
            toggleReturnAirline();
            
            // Render list dinamis
            ['included', 'excluded', 'fasilitas_makkah', 'fasilitas_madinah', 'syarat', 'catatan'].forEach(type => {
                if (existingData[type] && Array.isArray(existingData[type])) {
                    existingData[type].forEach(item => {
                        if (item) insertItemToList(type, item);
                    });
                }
            });

            // Render itinerary lama
            if (existingData.itinerary && existingData.itinerary.length > 0) {
                existingData.itinerary.forEach(it => {
                    addItineraryDay(it.title || '', it.description || '');
                });
            } else {
                addItineraryDay(); 
            }

            formatCurrency(document.getElementById('price_quad'));
            formatCurrency(document.getElementById('price_triple'));
            formatCurrency(document.getElementById('price_double'));
        };

        // ==========================================
        // FITUR TAMBAHAN: AUTO-DURASI & AUTO-ITINERARY (VERSI EDIT)
        // ==========================================
        function handleCategoryChange(select) {
            const durationInput = document.getElementById('duration');
            const selectedText = select.options[select.selectedIndex].text;
            
            // Cari angka di teks kategori
            const match = selectedText.match(/(\d+)\s*Hari/i);
            
            if (match) {
                const jumlahHari = parseInt(match[1]);
                const container = document.getElementById('itinerary-container');
                const currentDays = container.children.length; // Cek jumlah form yang ada sekarang
                
                durationInput.value = jumlahHari;
                adjustItinerary(jumlahHari); // Panggil fungsi nyesuaiin itinerary
                
                // FIX: Toast notif HANYA muncul kalau harinya TETAP atau NAMBAH.
                // Kalau harinya BERKURANG, biarkan popup peringatan (Warning) muncul dengan aman tanpa tertimpa.
                if (currentDays <= jumlahHari) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'info',
                        title: `Durasi disesuaikan ke ${jumlahHari} Hari`,
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                }
            }
        }

        function adjustItinerary(targetDays) {
            targetDays = parseInt(targetDays);
            if (!targetDays || targetDays <= 0) return;

            const container = document.getElementById('itinerary-container');
            const currentDays = container.children.length;
            
            // Kalau hari kurang, tambahin kolom otomatis
            if (currentDays < targetDays) {
                for (let i = currentDays; i < targetDays; i++) {
                    addItineraryDay();
                }
            } 
            // Kalau hari lebih, HAPUS DENGAN PERINGATAN (biar data lama gak lenyap)
            else if (currentDays > targetDays) {
                Swal.fire({
                    title: 'Hapus Sisa Itinerary?',
                    text: `Perubahan durasi akan menghapus data Itinerary dari hari ke-${targetDays + 1} sampai ke-${currentDays}. Yakin?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ea580c',
                    cancelButtonColor: '#94a3b8',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    allowOutsideClick: false // Biar gak batal kalau gak sengaja klik luar
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User setuju hapus
                        for (let i = currentDays; i > targetDays; i--) {
                            container.lastElementChild.remove();
                        }
                    } else {
                        // User batalin, balikin angka durasi ke jumlah kolom yang sebenernya
                        document.getElementById('duration').value = currentDays;
                        
                        // Opsional: Balikin dropdown kategori ke default (biar selaras sama durasi yang batal diubah)
                        // document.getElementById('category').value = ''; 
                    }
                });
            }
        }
        // ==========================================

        // ===== 2. FUNGSI UI & UTILS =====
        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, '');
            if (value !== '') value = new Intl.NumberFormat('id-ID').format(value);
            input.value = value;
        }

        function getRawNumber(formattedString) {
            return formattedString.replace(/\D/g, '');
        }

       // ==========================================
        // FITUR 1: AJAX STATUS PENAYANGAN (DINAMIS KAYA DI LIST)
        // ==========================================
        const statusToggle = document.getElementById('statusToggle');
        const statusLabel = document.getElementById('statusLabel');

        if (statusToggle) {
            statusToggle.addEventListener('change', async function () {
                const isChecked = this.checked;
                const newStatus = isChecked ? 'publish' : 'draft';
                const originalState = !isChecked;
                const productId = this.getAttribute('data-id');

                // Update UI Sementara
                if (isChecked) {
                    statusLabel.textContent = "Aktif (Tayang)";
                    statusLabel.classList.replace('text-slate-400', 'text-slate-700');
                } else {
                    statusLabel.textContent = "Non-Aktif (Draft)";
                    statusLabel.classList.replace('text-slate-700', 'text-slate-400');
                }

                // Tembak API Laravel
                let urlStatus = "{{ route('marketplace.travel.produk.status', ':id') }}".replace(':id', productId);
                
                try {
                    const response = await fetch(urlStatus, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: newStatus })
                    });
                    
                    const result = await response.json();
                    
                    if(response.ok) {
                        // Munculin notif kecil (toast) biar elegan
                        Swal.fire({
                            icon: 'success',
                            title: isChecked ? 'Tayang di Publik' : 'Disimpan ke Arsip',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        throw new Error(result.message || 'Gagal dari server');
                    }
                } catch(error) {
                    console.error("Error Status:", error);
                    // Revert UI kalau API gagal
                    this.checked = originalState;
                    if (originalState) {
                        statusLabel.textContent = "Aktif (Tayang)";
                        statusLabel.classList.replace('text-slate-400', 'text-slate-700');
                    } else {
                        statusLabel.textContent = "Non-Aktif (Draft)";
                        statusLabel.classList.replace('text-slate-700', 'text-slate-400');
                    }
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat mengupdate status.', 'error');
                }
            });
        }

        // ==========================================
        // FITUR 2 & 3: PREVIEW GAMBAR & DYNAMIC LISTS
        // ==========================================
        function toggleReturnAirline() {
            const isChecked = document.getElementById('sameAirlineToggle').checked;
            document.getElementById('returnContainer').classList.toggle('hidden', isChecked);
            document.getElementById('departureContainer').classList.toggle('md:col-span-2', isChecked);
            document.getElementById('departureLabel').innerText = isChecked ? "Nama Maskapai (PP)" : "Maskapai Keberangkatan";
        }

        function previewMainImg(event) {
            if (event.target.files[0]) {
                document.getElementById('preview-thumbnail').src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('preview-thumbnail').classList.remove('hidden');
                document.getElementById('dropzone-thumbnail').classList.add('hidden');
                document.getElementById('btn-change-thumbnail').classList.remove('hidden');
            }
        }

        function previewHotelImg(event, imgId, placeholderId) {
            if (event.target.files[0]) {
                document.getElementById(imgId).src = URL.createObjectURL(event.target.files[0]);
                document.getElementById(imgId).classList.remove('hidden');
                document.getElementById(placeholderId).classList.add('hidden');
                document.getElementById(`overlay-${imgId.split('-')[1]}`).classList.remove('hidden');
            }
        }

        function insertItemToList(type, value) {
            const list = document.getElementById(`list-${type}`);
            const li = document.createElement('li');
            let colorClass = 'bg-orange-50 border-orange-100 text-orange-800';
            let btnColor = 'text-orange-400 hover:text-red-500';
            if (type === 'included') { colorClass = 'bg-green-50 border-green-100 text-green-800'; btnColor = 'text-green-400 hover:text-red-500'; }
            if (type === 'excluded') { colorClass = 'bg-red-50 border-red-100 text-red-800'; btnColor = 'text-red-400 hover:text-red-500'; }
            
            if (type === 'fasilitas_makkah' || type === 'fasilitas_madinah') {
                li.className = `flex items-center gap-1.5 px-2.5 py-1 rounded-md border bg-white text-slate-600 text-xs shadow-sm list-item-${type}`;
                li.innerHTML = `<span class="font-medium item-text">${value}</span><button type="button" onclick="this.parentElement.remove()" class="text-slate-300 hover:text-red-500 transition ml-1"><i class="ph-bold ph-x"></i></button>`;
            } else {
                li.className = `flex justify-between items-center ${colorClass} px-3 py-2 rounded-lg border animate-fade-in-down list-item-${type}`;
                li.innerHTML = `<span class="text-sm font-medium item-text">${value}</span><button type="button" onclick="this.parentElement.remove()" class="${btnColor} transition"><i class="ph-bold ph-x"></i></button>`;
            }
            list.appendChild(li);
        }

        function addItemFromInput(type) {
            const input = document.getElementById(`input-${type}`);
            const value = input.value.trim();
            if (value) {
                insertItemToList(type, value);
                input.value = '';
                input.focus();
            }
        }

        function handleEnter(event, type) {
            if (event.key === 'Enter') {
                event.preventDefault();
                addItemFromInput(type);
            }
        }

        function addItineraryDay(title = "", desc = "") {
            const container = document.getElementById('itinerary-container');
            const dayCount = container.children.length + 1;
            const div = document.createElement('div');
            div.className = 'relative pl-6 pb-8 itinerary-item';

            div.innerHTML = `
                <div class="absolute -left-[21px] top-0 w-10 h-10 bg-white border-2 border-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold text-xs shadow-sm z-10">H<span class="day-num">${dayCount}</span></div>
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 group hover:border-orange-200 transition">
                    <div class="flex justify-between mb-2">
                        <!-- Tambah REQUIRED di input judul -->
                        <input type="text" value="${title}" required class="itinerary-title w-full bg-transparent font-bold text-slate-800 text-sm focus:outline-none placeholder:text-slate-400" placeholder="Judul Kegiatan (Wajib diisi)">
                        <button type="button" onclick="removeDay(this)" class="text-slate-400 hover:text-red-500 transition"><i class="ph-bold ph-trash"></i></button>
                    </div>
                    <!-- Tambah REQUIRED di textarea deskripsi -->
                    <textarea rows="2" required class="itinerary-desc w-full bg-white px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-orange-500 resize-none" placeholder="Deskripsi kegiatan... (Wajib diisi)">${desc}</textarea>
                </div>`;

            container.appendChild(div);
        }

        function removeDay(btn) {
            btn.closest('.itinerary-item').remove();
            document.querySelectorAll('.itinerary-item').forEach((el, index) => {
                el.querySelector('.day-num').innerText = index + 1;
            });
        }

        // ==========================================
        // FITUR 4: SUBMIT FORM UTAMA (DENGAN PELACAK ERROR)
        // ==========================================
        async function handleUpdate(e) {
            e.preventDefault();
            const getListArray = (type) => Array.from(document.querySelectorAll(`.list-item-${type} .item-text`)).map(el => el.innerText);
            const itineraryData = Array.from(document.querySelectorAll('.itinerary-item')).map((el, i) => ({
                day: i + 1,
                title: el.querySelector('.itinerary-title').value,
                description: el.querySelector('.itinerary-desc').value
            }));

            const formData = new FormData();
            formData.append('product_name', document.getElementById('product_name').value);
            formData.append('category', document.getElementById('category').value);
            formData.append('quota_quad', document.getElementById('quota_quad').value || 0);
            formData.append('quota_double', document.getElementById('quota_double').value || 0);
            formData.append('quota_triple', document.getElementById('quota_triple').value || 0);
            formData.append('status', document.getElementById('statusToggle').checked ? 'publish' : 'draft');
            formData.append('departure_date', document.getElementById('departure_date').value);
            formData.append('duration', document.getElementById('duration').value || 0);
            formData.append('departure_from', document.getElementById('departure_from').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('price_quad', getRawNumber(document.getElementById('price_quad').value) || 0);
            formData.append('price_triple', getRawNumber(document.getElementById('price_triple').value) || 0);
            formData.append('price_double', getRawNumber(document.getElementById('price_double').value) || 0);

            const isSameAirline = document.getElementById('sameAirlineToggle').checked;
            const flightDep = document.getElementById('flight_departure').value;
            formData.append('flight_departure', flightDep);
            formData.append('flight_return', isSameAirline ? flightDep : document.getElementById('flight_return').value);

            // 👇 AMBIL NAMA FOTO LAMA
            const oldMakkah = document.getElementById('old_img_makkah') ? document.getElementById('old_img_makkah').value : '';
            const oldMadinah = document.getElementById('old_img_madinah') ? document.getElementById('old_img_madinah').value : '';

            // 👇 FIX UTAMA 1: Wajib dikirim ke Controller Laravel biar ditangkep sama PHP lu
            formData.append('old_image_makkah', oldMakkah);
            formData.append('old_image_madinah', oldMadinah);

            // 👇 FIX UTAMA 2: Masukin key "existing_image" langsung dari sini sesuai rikues orang backend
            formData.append('hotel_makkah', JSON.stringify({
                name: document.getElementById('makkah_name').value,
                rating: document.getElementById('makkah_rating').value,
                distance: document.getElementById('makkah_distance').value,
                facilities: getListArray('fasilitas_makkah'),
                image: oldMakkah,
                existing_image: oldMakkah // Penuhi permintaan backend
            }));

            formData.append('hotel_madinah', JSON.stringify({
                name: document.getElementById('madinah_name').value,
                rating: document.getElementById('madinah_rating').value,
                distance: document.getElementById('madinah_distance').value,
                facilities: getListArray('fasilitas_madinah'),
                image: oldMadinah,
                existing_image: oldMadinah // Penuhi permintaan backend
            }));

            formData.append('included_facilities', JSON.stringify(getListArray('included')));
            formData.append('excluded_facilities', JSON.stringify(getListArray('excluded')));
            formData.append('terms', JSON.stringify(getListArray('syarat')));
            formData.append('notes', JSON.stringify(getListArray('catatan')));
            formData.append('itinerary', JSON.stringify(itineraryData));

            const imgMain = document.getElementById('thumbnail_product').files[0];
            const imgMakkah = document.getElementById('img_makkah').files[0];
            const imgMadinah = document.getElementById('img_madinah').files[0];
            
            if (imgMain) formData.append('thumbnail', imgMain);
            if (imgMakkah) formData.append('image_makkah', imgMakkah);
            if (imgMadinah) formData.append('image_madinah', imgMadinah);

            const submitUrl = "/marketplace/travel/produk/{{ $p['id'] ?? 0 }}/update";

            Swal.fire({
                title: 'Menyimpan Perubahan...',
                text: 'Sedang menghubungi server...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            try {
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok) {
                    Swal.fire({
                        title: 'Berhasil Diperbarui!',
                        text: 'Data paket umroh berhasil disimpan.',
                        icon: 'success',
                        confirmButtonColor: '#ea580c'
                    }).then(() => {
                        window.location.href = "{{ route('marketplace.travel.kelola-produk') }}";
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ditolak Server Darda!',
                        html: `<div style="text-align: left; background: #f8fafc; padding: 15px; border-radius: 8px; font-family: monospace; font-size: 12px; color: #ef4444; overflow-x: auto; border: 1px solid #f87171;">
                                <strong>Pesan Error:</strong><br>
                                ${JSON.stringify(result, null, 2)}
                            </div>
                            <p style="margin-top: 15px; font-size: 14px;">Silakan <b>Copy</b> teks merah di atas dan kirim ke sini biar langsung kita benerin!</p>`,
                        width: '600px'
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error Sistem', 'Tidak dapat terhubung ke server Controller.', 'error');
            }
        }
        
    </script>
</body>

</html>