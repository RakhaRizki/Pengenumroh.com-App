<x-layouts.marketplace>

    @php
        // 1. FORMAT TANGGAL
        $tanggalBerangkat = \Carbon\Carbon::parse($produk['tgl_keberangkatan'] ?? now());
        
        // 2. AMANKAN DATA PRICES & HITUNG KUOTA + HARGA TERMURAH
        $pricesData = is_string($produk['prices'] ?? null) ? json_decode($produk['prices'], true) : ($produk['prices'] ?? []);
        
        $hargaTermurah = 0;
        if(count($pricesData) > 0) {
            // Ambil harga paling murah
            $hargaTermurah = min(array_column($pricesData, 'price'));
        }

        // Hitung total kuota dari semua tipe kamar
        $totalKuota = collect($pricesData)->sum('quota');
        
        // Fallback kalau array kosong
        if ($totalKuota === 0) {
            $totalKuota = intval($produk['total_quota'] ?? $produk['quota'] ?? 0);
        }

        // 3. PISAHKAN FASILITAS (INCLUDE & EXCLUDE)
        $includeFacilities = [];
        $excludeFacilities = [];
        foreach($produk['facility'] ?? [] as $fac) {
            if(strtoupper($fac['type']) === 'INCLUDE') {
                $includeFacilities[] = $fac['facility'];
            } elseif(strtoupper($fac['type']) === 'EXCLUDE') {
                $excludeFacilities[] = $fac['facility'];
            }
        }

        // 4. DATA UMUM & FALLBACK
        $gambarUtama = !empty($produk['thumbnail_url']) ? "https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/" . rawurlencode($produk['thumbnail_url']) : "/assets/img/marketplace/produk-dummy.png";
        
        // Cek Maskapai (Array flights)
        $maskapai = count($produk['flights'] ?? []) > 0 ? $produk['flights'][0]['airline_name'] : 'Maskapai Belum Ditentukan';
        
        // Cek Hotel
        $hotelMakkah = 'Hotel Makkah (TBA)';
        $hotelMadinah = 'Hotel Madinah (TBA)';
        foreach($produk['hotels'] ?? [] as $htl) {
            if(stripos(strtolower($htl['city']), 'mekkah') !== false || stripos(strtolower($htl['city']), 'makkah') !== false) {
                $hotelMakkah = $htl['name'];
            }
            if(stripos(strtolower($htl['city']), 'madinah') !== false) {
                $hotelMadinah = $htl['name'];
            }
        }

        $kotaBerangkat = $produk['tmp_keberangkatan'] ?? 'Jakarta';
        $biroTravel = $produk['creator']['fullname'] ?? 'Biro Travel';

        // 5. CEK STATUS AKUN & KEPEMILIKAN
        $userData = session('user') ?? [];
        $loggedInUserId = $userData['id'] ?? null;
        // Berdasarkan API: 1 = Super Admin, 2 = Admin, 3 = Jamaah, 4 = Travel
        // 1. Ekstrak langsung dari key 'id_level' (kalau datanya diluar)
        $idLevel = $userData['id_level'] ?? null;
        // 2. Sapu Jagat (Jaga-jaga kalau datanya bersarang di dalam array, misal: user.level.id_level)
        $userDataString = strtolower(json_encode($userData));
        // Kunci akun jika dia adalah Travel (4), Admin (2), atau Super Admin (1)
        $isTravelAccount = (
            in_array($idLevel, [1, 2, 4]) || 
            strpos($userDataString, '"id_level":4') !== false ||
            strpos($userDataString, '"id_level": 4') !== false ||
            strpos($userDataString, '"nama_level":"travel"') !== false
        );
        $productOwnerId = $produk['user_id'] ?? ($produk['creator']['id'] ?? null);
        $isOwnProduct = ($loggedInUserId && $loggedInUserId == $productOwnerId);
        // Cek apakah produk beneran habis
        $isSoldOut = $totalKuota <= 0;

        // 6. CEK STATUS WISHLIST (Pindah ke atas biar aman dari error)
        $isWishlisted = in_array($produk['id'], $wishlistIds ?? []);

    @endphp

    <style>
        /* Custom Scrollbar & Utility */
        html { scroll-behavior: smooth; scroll-padding-top: 100px; }
        .timeline-line::before { content: ''; position: absolute; top: 0; bottom: 0; left: 20px; width: 2px; background: #E2E8F0; z-index: 0; }
        #lightbox { transition: opacity 0.3s ease; }
        #lightbox.hidden { opacity: 0; pointer-events: none; }
        #lightbox:not(.hidden) { opacity: 1; pointer-events: auto; }
        .tab-link.active { border-color: #F97316; color: #EA580C; }
    </style>

    <main class="pt-24 lg:pt-32 pb-10 md:pb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- BREADCRUMB --}}
        <nav class="flex mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs md:text-sm whitespace-nowrap overflow-x-auto no-scrollbar">
                <li class="inline-flex items-center">
                    <a href="/marketplace/" class="inline-flex items-center hover:text-orange-600 transition-colors duration-200">
                        <i class="ph ph-house mr-2 text-lg"></i> Beranda
                    </a>
                </li>
                <li><i class="ph ph-caret-right text-gray-400"></i></li>
                <li>
                    <a href="{{ route('marketplace.produk.index') }}" class="hover:text-orange-600 transition-colors duration-200">Katalog Produk</a>
                </li>
                <li><i class="ph ph-caret-right text-gray-400"></i></li>
                <li aria-current="page">
                    <span class="text-gray-900 font-bold truncate max-w-[150px] md:max-w-xs block">{{ $produk['nama_produk'] }}</span>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">

            {{-- BAGIAN KIRI: KONTEN UTAMA --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- GALERI FOTO --}}
                <div class="flex flex-col gap-4 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        {{-- FIX: md:h-[600px] dan lg:h-[750px] agar poster vertikal tidak banyak terpotong di laptop --}}
                        <div class="relative w-full aspect-[3/4] md:aspect-auto md:h-[600px] lg:h-[1000px] md:col-span-4 rounded-2xl overflow-hidden shadow-sm group cursor-pointer" onclick="openLightbox(this)">
                            <img src="{{ $gambarUtama }}" class="w-full h-full object-cover transition duration-700 ease-in-out group-hover:scale-105" alt="{{ $produk['nama_produk'] }}">
                            <div class="absolute bottom-4 left-4 bg-black/50 backdrop-blur-sm text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 transition group-hover:bg-black/60">
                                <i class="ph-fill ph-camera"></i> Lihat Gambar
                            </div>
                        </div>
                    </div>
                </div>

                {{-- JUDUL PAKET & SUMMARY --}}
                <div class="space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-md font-bold uppercase tracking-wide mb-2 inline-block">
                                Tersisa {{ $totalKuota }} Seat
                            </span>
                            <h1 class="text-2xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $produk['nama_produk'] }}</h1>
                            <div class="flex items-center gap-2 mt-2 text-gray-500 text-sm font-medium">
                                <i class="ph-fill ph-calendar-blank text-orange-500 text-lg"></i> 
                                <span>{{ $tanggalBerangkat->translatedFormat('d F Y') }}</span>
                                <span class="mx-1">•</span>
                                <i class="ph-fill ph-clock text-orange-500 text-lg"></i> 
                                <span>{{ $produk['duration'] ?? 0 }} Hari</span>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-200">

                    {{-- KOTAK INFORMASI SINGKAT --}}
                    {{-- FIX: Diubah menjadi grid 3 kolom di Desktop, dan baris kedua untuk hotel agar lebih leluasa --}}
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4">
                        <!-- Baris Atas: Keberangkatan, Maskapai, Travel -->
                        <div class="bg-white p-3 md:p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center">
                            <i class="ph-duotone ph-airplane-takeoff text-2xl text-orange-500 mb-1.5"></i>
                            <span class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wide font-medium">Keberangkatan</span>
                            <span class="text-sm font-bold text-gray-800 leading-tight mt-0.5 line-clamp-2" title="{{ $kotaBerangkat }}">{{ $kotaBerangkat }}</span>
                        </div>
                        <div class="bg-white p-3 md:p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center">
                            <i class="ph-duotone ph-airplane-tilt text-2xl text-orange-500 mb-1.5"></i>
                            <span class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wide font-medium">Maskapai</span>
                            <span class="text-sm font-bold text-gray-800 leading-tight mt-0.5 line-clamp-2" title="{{ $maskapai }}">{{ $maskapai }}</span>
                        </div>
                        <div class="col-span-2 md:col-span-1 bg-white p-3 md:p-4 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center justify-center text-center">
                            <i class="ph-duotone ph-users-three text-2xl text-orange-500 mb-1.5"></i>
                            <span class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wide font-medium">Biro Travel</span>
                            <span class="text-sm font-bold text-gray-800 leading-tight mt-0.5 line-clamp-2" title="{{ $biroTravel }}">{{ $biroTravel }}</span>
                        </div>

                        <!-- Baris Bawah: Hotel (Dibuat responsif: 1 kolom di HP, 2 kolom di iPad/Laptop) -->
                        <div class="col-span-2 md:col-span-3 grid grid-cols-1 sm:grid-cols-2 gap-3 md:gap-4">
                            
                            <!-- Hotel Makkah -->
                            <div class="bg-white p-3.5 md:p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-3.5 group hover:border-orange-300 hover:shadow-md transition-all duration-300">
                                <!-- Icon Box -->
                                <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center flex-shrink-0 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                                    <i class="ph-duotone ph-buildings text-xl md:text-2xl"></i>
                                </div>
                                <!-- Text Content -->
                                <div class="flex-1 min-w-0">
                                    <span class="text-[10px] md:text-[11px] text-gray-500 uppercase tracking-wider font-bold block mb-0.5">Hotel Makkah</span>
                                    <span class="text-sm md:text-[14px] font-bold text-gray-800 leading-snug block break-words">{{ $hotelMakkah }}</span>
                                </div>
                            </div>

                            <!-- Hotel Madinah -->
                            <div class="bg-white p-3.5 md:p-4 rounded-xl border border-gray-100 shadow-sm flex items-center gap-3.5 group hover:border-orange-300 hover:shadow-md transition-all duration-300">
                                <!-- Icon Box -->
                                <div class="w-10 h-10 md:w-11 md:h-11 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center flex-shrink-0 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                                    <i class="ph-duotone ph-buildings text-xl md:text-2xl"></i>
                                </div>
                                <!-- Text Content -->
                                <div class="flex-1 min-w-0">
                                    <span class="text-[10px] md:text-[11px] text-gray-500 uppercase tracking-wider font-bold block mb-0.5">Hotel Madinah</span>
                                    <span class="text-sm md:text-[14px] font-bold text-gray-800 leading-snug block break-words">{{ $hotelMadinah }}</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                {{-- NAVIGASI TAB STICKY --}}
                <div class="sticky top-20 z-30 bg-[#F8FAFC] pt-2 pb-4 transition-all" id="sticky-tabs">
                    <div class="flex space-x-6 border-b border-gray-200 overflow-x-auto no-scrollbar">
                        <a href="#hotel" class="tab-link pb-3 border-b-2 font-semibold text-sm whitespace-nowrap transition active" data-target="hotel">Akomodasi</a>
                        <a href="#fasilitas" class="tab-link pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm whitespace-nowrap transition" data-target="fasilitas">Fasilitas</a>
                        <a href="#itinerary" class="tab-link pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm whitespace-nowrap transition" data-target="itinerary">Itinerary</a>
                        <a href="#syarat" class="tab-link pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm whitespace-nowrap transition" data-target="syarat">S&K</a>
                        <a href="#catatan" class="tab-link pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm whitespace-nowrap transition" data-target="catatan">Catatan Produk</a>
                    </div>
                </div>

                {{-- SECTION: HOTEL (DINAMIS DARI API) --}}
                <section id="hotel" class="scroll-mt-40">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Akomodasi & Hotel</h3>
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        @forelse($produk['hotels'] ?? [] as $hotel)
                            <div class="flex flex-col md:flex-row gap-6 mb-6 last:mb-0 border-b border-dashed border-gray-200 last:border-0 pb-6 last:pb-0">
                                @php
                                    $hotelImg = !empty($hotel['image']) 
                                        ? "https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/hotels/" . rawurlencode($hotel['image']) 
                                        : "https://ui-avatars.com/api/?name=".urlencode($hotel['name'])."&background=F97316&color=fff";
                                @endphp
                                <img src="{{ $hotelImg }}" class="w-full md:w-1/3 rounded-lg object-cover h-48 cursor-pointer" onclick="openLightbox(this)" alt="{{ $hotel['name'] }}" onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=Hotel&background=e2e8f0&color=94a3b8';">
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-lg font-bold text-gray-800">{{ $hotel['name'] }}</h4>
                                        <span class="flex text-yellow-400 text-xs">
                                            @for($i=0; $i < ($hotel['rating'] ?? 0); $i++) ⭐ @endfor
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                                        <i class="ph-fill ph-map-pin text-gray-400"></i> Kota {{ $hotel['city'] }}
                                        @if(isset($hotel['jarak'])) | Jarak: {{ $hotel['jarak'] }} @endif
                                    </p>
                                    
                                    {{-- Render Fasilitas Hotel dari string comma-separated --}}
                                    <ul class="mt-4 flex flex-wrap gap-2">
                                        @php
                                            $fasilitasHotel = explode(',', $hotel['facilities'] ?? '');
                                        @endphp
                                        @foreach($fasilitasHotel as $f_htl)
                                            @if(trim($f_htl) != '')
                                                <li class="flex items-center text-xs text-gray-600 gap-1 bg-slate-50 px-2 py-1 rounded-md border border-slate-100">
                                                    <i class="ph-fill ph-check-circle text-green-500"></i> {{ trim($f_htl) }}
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">Informasi akomodasi belum tersedia.</p>
                        @endforelse
                    </div>
                </section>

                {{-- SECTION: FASILITAS (DINAMIS DARI API) --}}
                <section id="fasilitas" class="scroll-mt-40 mt-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 px-1">Fasilitas Paket</h3>
                    <div class="grid grid-cols-1 gap-6">
                        
                        {{-- Termasuk (INCLUDE) --}}
                        <div class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-sm">
                            <div class="flex items-start gap-4 mb-6 border-b border-gray-100 pb-5">
                                <div class="bg-green-100 p-3 rounded-full text-green-600 flex-shrink-0">
                                    <i class="ph-fill ph-check text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">Harga Termasuk</h4>
                                    <p class="text-sm text-gray-500 mt-0.5">Benefit dan layanan lengkap yang Anda dapatkan:</p>
                                </div>
                            </div>
                            
                            <!-- FIX UX: Ubah gap-y-6 menjadi gap-y-3 (jarak atas bawah lebih rapat) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3">
                                @forelse($includeFacilities as $item)
                                    <!-- FIX UX: Hapus bg hover (orange-50) & kurangi padding agar tidak terlihat boros tempat -->
                                    <div class="flex gap-2.5 items-start py-1">
                                        <i class="ph-fill ph-check-circle text-[18px] text-green-500 flex-shrink-0 mt-0.5"></i>
                                        <p class="font-bold text-gray-700 text-[13.5px] leading-snug">{{ $item }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-500">Belum ada rincian fasilitas termasuk.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Tidak Termasuk (EXCLUDE) --}}
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 border-dashed">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="bg-red-100 p-2 rounded-full text-red-500 flex-shrink-0"><i class="ph-fill ph-x text-lg"></i></div>
                                <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Harga Tidak Termasuk</h4>
                            </div>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
                                @forelse($excludeFacilities as $item)
                                    <li class="flex items-start gap-3 text-sm text-slate-600">
                                        <i class="ph-bold ph-minus-circle text-slate-400 mt-1"></i> <span>{{ $item }}</span>
                                    </li>
                                @empty
                                    <li class="text-sm text-gray-500">Belum ada rincian.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </section>

                {{-- SECTION: ITINERARY (DINAMIS DARI API) --}}
                <section id="itinerary" class="scroll-mt-40">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Rencana Perjalanan</h3>
                    <div class="relative timeline-line space-y-8 pl-2">
                        @forelse($produk['itinerary'] ?? [] as $index => $itin)
                            <div class="relative pl-10">
                                <div class="absolute left-[11px] top-1 w-5 h-5 {{ $index === 0 ? 'bg-orange-500 border-white shadow-md' : 'bg-white border-orange-500' }} border-4 rounded-full z-10"></div>
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
                                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari {{ $itin['day_order'] ?? ($index + 1) }}</span>
                                    <h4 class="text-lg font-bold text-gray-900 mt-1">{{ $itin['title'] ?? 'Agenda' }}</h4>
                                    <p class="text-gray-600 text-sm mt-2">{{ $itin['description'] ?? '' }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic pl-10">Rencana perjalanan belum tersedia.</p>
                        @endforelse
                    </div>
                </section>

                {{-- SECTION: SYARAT & KETENTUAN (DINAMIS DARI API) --}}
                <section id="syarat" class="scroll-mt-40">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Syarat & Ketentuan</h3>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 text-sm text-gray-600 space-y-2 shadow-sm">
                        @forelse($produk['snk'] ?? [] as $snk)
                            <p class="flex gap-2 items-start">
                                <i class="ph-bold ph-caret-right text-orange-500 mt-0.5"></i>
                                <span>{{ $snk['name'] }}</span>
                            </p>
                        @empty
                            <p class="italic text-gray-400">Tidak ada Syarat & Ketentuan khusus.</p>
                        @endforelse
                    </div>
                </section>

                {{-- SECTION: CATATAN & DESKRIPSI (DINAMIS DARI API) --}}
                <section id="catatan" class="scroll-mt-40">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Catatan & Deskripsi Produk</h3>
                    
                    <!-- 👇 FIX: Tambahin overflow-hidden biar nggak bocor keluar kotak -->
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-sm text-gray-600 space-y-4 leading-relaxed overflow-hidden">
                        
                        <div class="w-full">
                            <h4 class="font-bold text-gray-800 mb-2">Deskripsi Paket</h4>
                            <!-- 👇 FIX: Tambahin break-words biar teks panjang otomatis dibungkus ke bawah -->
                            <p class="break-words">
                                @if(!empty($produk['description']))
                                    {!! nl2br(e($produk['description'])) !!}
                                @else
                                    Belum ada deskripsi untuk paket ini.
                                @endif
                            </p>
                        </div>

                        @if(isset($produk['notes']) && count($produk['notes']) > 0)
                        <hr class="border-gray-100">
                        <div class="w-full">
                            <h4 class="font-bold text-gray-800 mb-2">Catatan Tambahan</h4>
                            <!-- 👇 FIX: Tambahin break-words juga di list biar aman -->
                            <ul class="list-disc pl-5 space-y-1 marker:text-orange-500 break-words">
                                @foreach($produk['notes'] as $note)
                                    <li>{{ $note['note'] }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                    </div>
                </section>

            </div>

            {{-- BAGIAN KANAN: CHECKOUT CARD (DINAMIS KAMAR & HARGA) --}}
            <div class="lg:col-span-1 relative">
                {{-- FIX SCROLLING: Mengubah sticky menjadi max-h-screen dan nambahin overflow-y-auto --}}
                <div class="sticky top-28 w-full max-h-[calc(100vh-130px)] overflow-y-auto no-scrollbar pb-6" id="booking-card">
                    
                    {{-- KARTU UTAMA --}}
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-5 md:p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-orange-100 rounded-full opacity-50 blur-xl"></div>
                        
                        <div class="space-y-4 mb-6 relative z-10">
                            <p class="text-sm font-bold text-gray-800 border-b border-gray-100 pb-2">Pilih Tipe Kamar & Jumlah</p>
                            
                            {{-- Looping Array Kamar (Prices) dari API --}}
                            <div class="space-y-3">
                                @php
                                    // Urutkan manual agar: Quad (1) -> Triple (2) -> Double (3)
                                    $sortedPrices = collect($produk['prices'] ?? [])->sortBy(function($kamar) {
                                        $jenis = strtolower($kamar['room_types'] ?? '');
                                        if (strpos($jenis, 'quad') !== false) return 1;
                                        if (strpos($jenis, 'triple') !== false) return 2;
                                        if (strpos($jenis, 'double') !== false) return 3;
                                        return 4; // Jaga-jaga kalau ada tipe kamar lain
                                    })->values()->all();

                                    $defaultAssigned = false; // Penanda untuk fallback urutan default
                                @endphp

                                @forelse($sortedPrices as $kamar)
                                    @php
                                        $namaKamar = $kamar['room_types'] ?? 'Kamar';
                                        $hargaKamar = $kamar['price'] ?? 0;
                                        $kuotaKamar = $kamar['quota'] ?? 0;
                                        $idInputKamar = \Illuminate\Support\Str::slug($namaKamar);
                                        
                                        // Bikin Icon dinamis
                                        $iconKamar = 'ph-users';
                                        if(stripos($namaKamar, 'quad') !== false) $iconKamar = 'ph-users-four';
                                        if(stripos($namaKamar, 'triple') !== false) $iconKamar = 'ph-users-three';

                                        // Kasih angka 1 ke tipe kamar urutan teratas yang kuotanya masih ada
                                        $isDefault = false;
                                        if (!$defaultAssigned && $kuotaKamar > 0 && !$isTravelAccount && !$isSoldOut) {
                                            $isDefault = true;
                                            $defaultAssigned = true;
                                        }
                                    @endphp
                                    <div class="p-3 rounded-xl border border-gray-200 flex items-center justify-between group hover:border-orange-300 transition-all bg-slate-50 hover:bg-orange-50/50 relative overflow-hidden">
                                        {{-- Badge Kuota Habis (Kalau 0) --}}
                                        @if($kuotaKamar <= 0)
                                            <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] z-10 flex items-center justify-center">
                                                <span class="bg-red-100 text-red-600 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-red-200 shadow-sm">
                                                    Sold Out
                                                </span>
                                            </div>
                                        @endif

                                        <div class="flex items-center gap-3 min-w-0 flex-1">
                                            <div class="bg-white p-2.5 rounded-lg text-orange-600 shadow-sm border border-gray-100 group-hover:border-orange-200 flex-shrink-0">
                                                <i class="ph-fill {{ $iconKamar }} text-xl"></i>
                                            </div>
                                            <div class="flex flex-col justify-center min-w-0 pr-2">
                                                <div class="flex items-center gap-2 mb-0.5 flex-wrap">
                                                    <p class="font-bold text-sm text-gray-800 truncate">{{ $namaKamar }}</p>
                                                    <span class="text-[9px] font-bold tracking-wide {{ $kuotaKamar <= 3 ? 'text-red-500 bg-red-50 border-red-100' : 'text-orange-500 bg-orange-50 border-orange-100' }} px-1.5 py-0.5 rounded-md border shadow-sm whitespace-nowrap">
                                                        Sisa {{ $kuotaKamar }}
                                                    </span>
                                                </div>
                                                <p class="text-xs text-gray-500 font-medium">Rp {{ number_format($hargaKamar / 1000000, 1, ',', '.') }} <span class="text-[10px]">Jt/pax</span></p>
                                            </div>
                                        </div>
                                        <div class="flex items-center bg-white border border-gray-200 rounded-lg p-0.5 md:p-1 shadow-sm flex-shrink-0 z-0">
                                            <button onclick="updateQty('{{ $idInputKamar }}', -1, {{ $kuotaKamar }})" class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center text-slate-500 hover:text-orange-600 hover:bg-orange-50 rounded-md transition font-bold text-base md:text-lg disabled:opacity-30 disabled:hover:bg-transparent disabled:cursor-not-allowed" {{ ($kuotaKamar <= 0 || $isTravelAccount || $isSoldOut) ? 'disabled' : '' }}>-</button>
                                            <input type="number" id="qty-{{ $idInputKamar }}" value="{{ $isDefault ? 1 : 0 }}" data-name="{{ $namaKamar }}" data-price="{{ $hargaKamar }}" data-max="{{ $kuotaKamar }}" class="qty-input w-6 md:w-8 text-center text-xs md:text-sm font-bold bg-transparent focus:outline-none pointer-events-none" readonly>
                                            <button onclick="updateQty('{{ $idInputKamar }}', 1, {{ $kuotaKamar }})" class="w-7 h-7 md:w-8 md:h-8 flex items-center justify-center text-orange-600 hover:bg-orange-50 rounded-md transition font-bold text-base md:text-lg disabled:opacity-30 disabled:hover:bg-transparent disabled:cursor-not-allowed" {{ ($kuotaKamar <= 0 || $isTravelAccount || $isSoldOut) ? 'disabled' : '' }}>+</button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-red-500 italic">Harga belum disetting oleh Travel.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- Summary Container --}}
                        <div id="summary-container" class="mb-5 p-3.5 bg-orange-50/50 rounded-xl border border-orange-100 border-dashed transition-all">
                            <p class="text-[10px] uppercase tracking-wider font-bold text-orange-400 mb-2">Rincian Pax</p>
                            <div id="order-summary-list" class="space-y-1.5 text-sm font-medium text-orange-800"></div>
                        </div>

                        {{-- 👇 METODE PEMBAYARAN 👇 --}}
                        <div class="border-t border-gray-100 pt-5 mt-5">
                            <p class="text-xs font-bold text-gray-800 mb-3 uppercase tracking-wide">Pilih Pembayaran</p>
                            
                            <!-- Toggle Button -->
                            <div class="grid grid-cols-2 gap-1.5 p-1 bg-slate-100/80 rounded-xl mb-4">
                                <button id="btn-pay-full" onclick="setPaymentMode('full')" class="py-2.5 text-[11px] font-bold bg-white text-orange-600 rounded-lg shadow-sm transition-all border border-slate-200 focus:outline-none">
                                    Bayar Penuh
                                </button>
                                <button id="btn-pay-dp" onclick="setPaymentMode('dp')" class="py-2.5 text-[11px] font-bold text-slate-500 hover:text-slate-800 rounded-lg transition-all focus:outline-none">
                                    Bayar Bertahap
                                </button>
                            </div>

                           <!-- Box Simulasi DP (Hidden by default) -->
                            <div id="dp-simulation-box" class="hidden bg-white rounded-xl border border-blue-100 mt-2 overflow-hidden shadow-sm transition-all duration-500 animate-fade-in mb-2">
                                <!-- Header Banner -->
                                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-4 py-3 border-b border-blue-100 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-blue-600 shadow-sm border border-blue-50">
                                        <i class="ph-fill ph-wallet text-lg"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-[11px] font-black text-blue-900 uppercase tracking-wider">Rincian Pembayaran Bertahap</h4>
                                        <p class="text-[10px] text-blue-700 font-medium leading-tight">Estimasi tagihan untuk pesanan ini</p>
                                    </div>
                                </div>
                                
                                <!-- Body Simulasi -->
                                <div class="p-4 space-y-4">
                                    <!-- Baris DP (Uang Muka) -->
                                    <div class="flex items-start gap-3">
                                        <div class="mt-1 flex flex-col items-center">
                                            <div class="w-2.5 h-2.5 rounded-full bg-blue-500 ring-4 ring-blue-50"></div>
                                            <div class="w-0.5 h-12 bg-blue-100 mt-1"></div>
                                        </div>
                                        <div class="flex-1 pb-3 border-b border-dashed border-slate-200">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="text-xs font-bold text-slate-800">Pembayaran Pertama</p>
                                                    <p class="text-[10px] text-slate-500 mt-0.5">Uang Muka (Booking Fee)</p>
                                                </div>
                                                <div class="text-right">
                                                    <span class="text-xs font-black text-orange-600 bg-orange-50 px-2 py-1 rounded border border-orange-100" id="dp-amount-display">Rp 0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Baris Pelunasan -->
                                    <div class="flex items-start gap-3">
                                        <div class="mt-1">
                                            <div class="w-2.5 h-2.5 rounded-full bg-slate-300 ring-4 ring-slate-50"></div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start gap-2">
                                                <div>
                                                    <p class="text-xs font-bold text-slate-800">Sisa Tagihan</p>
                                                    <p class="text-[9px] text-slate-500 mt-1 leading-relaxed">Tagihan senilai <span id="sisa-amount-display" class="font-bold text-slate-700">Rp 0</span> akan dibagi secara merata menjadi 2 termin angsuran.</p>
                                                </div>
                                                <div class="text-right flex-shrink-0 bg-slate-50 p-2 rounded-lg border border-slate-100">
                                                    <span class="text-[11px] font-black text-slate-800 block" id="cicilan-amount-display">Rp 0</span>
                                                    <span class="text-[9px] font-bold text-slate-400">2x Angsuran</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- 👆 SELESAI FITUR METODE PEMBAYARAN 👆 --}}

                        <div class="mb-5 pt-4 mt-2 border-t border-gray-100 relative">
                            <div class="flex justify-between items-center mb-1">
                                <div class="flex flex-col items-start">
                                    <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wider block mb-1" id="label-total-display">Total Tagihan</span>
                                    <span class="text-[10px] text-orange-600 font-bold bg-orange-50 px-2 py-0.5 rounded border border-orange-100" id="total-pax">0 Pax</span>
                                </div>
                                <!-- text-3xl diubah jadi text-2xl agar lebih compact -->
                                <span class="text-2xl font-black text-orange-600 tracking-tight leading-none" id="total-price-display">Rp 0</span>
                            </div>
                        </div>

                        {{-- Tombol Action Khusus Desktop --}}
                        <div class="hidden md:block">
                            <div class="flex gap-2.5">
                                {{-- Tombol Compare Selalu Tampil --}}
                                <button onclick="toggleCompareDetail()" id="btn-compare-detail" class="flex-shrink-0 w-12 lg:w-14 h-12 lg:h-14 rounded-xl border-2 border-gray-200 text-gray-400 hover:border-teal-400 hover:text-teal-600 hover:bg-teal-50 transition-all duration-300 flex items-center justify-center group" title="Bandingkan Paket">
                                    <i id="icon-compare-detail" class="ph-bold ph-arrows-left-right text-xl lg:text-2xl transform group-hover:rotate-180 transition-transform duration-500"></i>
                                </button>
                                
                                {{-- Tombol Wishlist --}}
                                @if(!$isTravelAccount)
                                    @php $isWishlisted = in_array($produk['id'], $wishlistIds ?? []); @endphp
                                    <button onclick="toggleWishlistDetail('{{ $produk['id'] }}')" id="btn-fav-desktop" class="flex-shrink-0 w-12 lg:w-14 h-12 lg:h-14 rounded-xl border-2 transition-all duration-300 flex items-center justify-center group {{ $isWishlisted ? 'border-red-200 text-red-500 bg-red-50' : 'border-slate-200 text-slate-400 hover:border-red-200 hover:text-red-500 hover:bg-red-50' }}" title="Simpan ke Wishlist">
                                        <i id="icon-fav-desktop" class="text-xl lg:text-2xl transform group-hover:scale-110 transition-transform {{ $isWishlisted ? 'ph-fill ph-heart' : 'ph-bold ph-heart' }}"></i>
                                    </button>
                                @endif
                                
                                {{-- LOGIKA 4 KONDISI TOMBOL (CHECKOUT) --}}
                                @if($isOwnProduct)
                                    <a href="{{ route('marketplace.travel.produk.edit', $produk['id']) }}" class="flex-1 bg-slate-800 text-white font-bold py-3 lg:py-3.5 rounded-xl hover:bg-slate-900 transition shadow-lg flex justify-center items-center gap-2 group">
                                        <i class="ph-bold ph-pencil-simple text-xl group-hover:scale-110 transition"></i> <span>Edit Paket</span>
                                    </a>
                                @elseif($isTravelAccount)
                                    <button disabled class="flex-1 bg-slate-50 text-slate-400 font-bold py-3 lg:py-3.5 px-2 rounded-xl border border-slate-200 cursor-not-allowed flex justify-center items-center gap-1.5 md:gap-2 overflow-hidden">
                                        <i class="ph-bold ph-prohibit text-lg lg:text-xl flex-shrink-0"></i> <span class="text-xs lg:text-sm truncate">Khusus Jamaah</span>
                                    </button>
                                @elseif($isSoldOut)
                                    <button disabled class="flex-1 bg-red-50 text-red-500 font-bold py-3 lg:py-3.5 rounded-xl border border-red-200 cursor-not-allowed flex justify-center items-center gap-2">
                                        <i class="ph-bold ph-x-circle text-xl"></i> <span>Kuota Habis</span>
                                    </button>
                                @else
                                    <button onclick="handleCheckout()" class="flex-1 bg-orange-600 text-white font-bold py-3 lg:py-3.5 rounded-xl hover:bg-orange-700 transition shadow-lg shadow-orange-500/30 flex justify-center items-center gap-2 group active:scale-[0.98]">
                                        <i class="ph-bold ph-shopping-cart-simple text-xl group-hover:scale-110 transition"></i> <span>Pesan Sekarang</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Tombol WhatsApp Bantuan --}}
                    <button onclick="contactWhatsApp()" class="w-full bg-green-50 p-4 rounded-xl border border-green-100 flex gap-4 items-center hover:bg-green-100 hover:border-green-200 transition-all duration-300 group text-left mt-5">
                        <div class="bg-green-500 p-2 rounded-lg text-white group-hover:scale-110 transition-transform duration-300"><i class="ph-bold ph-whatsapp-logo text-2xl"></i></div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h5 class="font-bold text-green-900 text-sm truncate pr-2">Butuh Bantuan?</h5>
                                <i class="ph-bold ph-caret-right text-green-600 text-xs group-hover:translate-x-1 transition-transform flex-shrink-0"></i>
                            </div>
                            <p class="text-[11px] text-green-700 mt-0.5 line-clamp-1">Tanya detail paket langsung via WhatsApp.</p>
                        </div>
                    </button>

                </div> {{-- Akhir Wrapper Scroll Sticky --}}
            </div>

        </div>
    </main>

    {{-- BOTTOM BAR KHUSUS MOBILE (Fixed posisi di bawah HP, UI/UX Premium) --}}
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 px-4 pt-3 pb-4 shadow-[0_-15px_30px_rgba(0,0,0,0.1)] md:hidden z-50 flex items-center justify-between gap-3 animate-fade-in pb-safe">
        
        {{-- Sisi Kiri: Harga Total & Info (FIX: flex-1 min-w-0 pr-3 Mencegah Teks Mendorong Tombol) --}}
        <div class="flex flex-col justify-center cursor-pointer group active:scale-95 transition-all flex-1 min-w-0 pr-3" onclick="scrollToBookingCard()">
            
            {{-- Label Harga --}}
            <span class="text-[10px] text-slate-500 font-medium mb-0.5 block truncate" id="mobile-price-label">Harga Mulai</span>
            
            {{-- Nominal Harga --}}
            <div class="flex items-baseline gap-1 w-full min-w-0" id="total-price-mobile">
                {{-- Harga bisa truncate (titik tiga) kalau angkanya miliaran, tapi 'Jt' nya aman (flex-shrink-0) --}}
                <span class="text-xl font-black text-slate-900 tracking-tight truncate block">
                    Rp {{ number_format($hargaTermurah / 1000000, 1, ',', '.') }}
                </span>
                <span class="text-xs font-bold text-orange-500 flex-shrink-0">Jt</span>
            </div>

            {{-- Indikator Scroll (Teks + Panah Bawah) --}}
            <div class="flex items-center gap-1 mt-0.5 w-full min-w-0">
                <span id="mobile-pax-summary" class="text-[10px] font-bold text-orange-600 uppercase tracking-wider truncate block">
                    Pilih Kamar
                </span>
                <i class="ph-bold ph-caret-down text-orange-500 text-[11px] animate-bounce flex-shrink-0 mt-0.5"></i>
            </div>
            
        </div>

        {{-- Sisi Kanan: Kumpulan Tombol Aksi (FIX: flex-shrink-0 Biar Tombol Gak Gepeng) --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            {{-- Tombol Compare --}}
            <button onclick="toggleCompareDetail()" id="btn-compare-mobile" class="w-11 h-11 rounded-xl border border-slate-200 text-slate-400 bg-slate-50 hover:bg-slate-100 active:scale-95 transition-all flex items-center justify-center shadow-sm relative">
                <i id="icon-compare-mobile" class="ph-bold ph-arrows-left-right text-[22px]"></i>
            </button>

            {{-- Tombol Wishlist --}}
            @if(!$isTravelAccount)
                <button onclick="toggleWishlistDetail('{{ $produk['id'] }}')" id="btn-fav-mobile" class="w-11 h-11 rounded-xl border active:scale-95 transition-all flex items-center justify-center shadow-sm {{ $isWishlisted ? 'border-red-200 text-red-500 bg-red-50' : 'border-slate-200 text-slate-400 bg-slate-50 hover:bg-slate-100' }}">
                    <i id="icon-fav-mobile" class="text-[22px] {{ $isWishlisted ? 'ph-fill ph-heart' : 'ph-bold ph-heart' }}"></i>
                </button>
            @endif

            {{-- Logika Tombol Pesan --}}
            @if($isOwnProduct)
                <a href="{{ route('marketplace.travel.produk.edit', $produk['id']) }}" class="bg-slate-900 text-white px-5 h-11 rounded-xl font-bold text-sm shadow-md shadow-slate-900/20 active:scale-95 transition-all flex items-center justify-center gap-1.5 whitespace-nowrap flex-shrink-0">
                    <i class="ph-bold ph-pencil-simple text-lg"></i> Edit
                </a>
            @elseif($isTravelAccount)
                <button disabled class="bg-slate-100 text-slate-400 border border-slate-200 px-4 h-11 rounded-xl font-bold text-xs cursor-not-allowed flex items-center justify-center gap-1 whitespace-nowrap flex-shrink-0">
                    <i class="ph-bold ph-prohibit text-base"></i> Travel
                </button>
            @elseif($isSoldOut)
                <button disabled class="bg-red-50 text-red-500 border border-red-200 px-5 h-11 rounded-xl font-bold text-sm cursor-not-allowed flex items-center justify-center gap-1.5 whitespace-nowrap flex-shrink-0">
                    <i class="ph-bold ph-x-circle text-lg"></i> Habis
                </button>
            @else
                <button onclick="handleCheckout()" class="bg-gradient-to-r from-orange-500 to-orange-600 text-white px-6 h-11 rounded-xl font-bold text-sm shadow-lg shadow-orange-500/30 active:scale-95 transition-all flex items-center justify-center gap-2 whitespace-nowrap flex-shrink-0">
                    Pesan <i class="ph-bold ph-arrow-right text-base"></i>
                </button>
            @endif
        </div>
    </div>

    {{-- LIGHTBOX IMAGE --}}
    <div id="lightbox" class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center hidden p-4" onclick="closeLightbox()">
        <button class="absolute top-4 right-4 text-white text-3xl hover:text-orange-500 transition"><i class="ph-bold ph-x"></i></button>
        <img id="lightbox-img" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
    </div>

    {{-- SCRIPTS KHUSUS DETAIL HALAMAN --}}
    <script>
        // 1. SCROLL SPY & SMOOTH SCROLL UNTUK TAB STICKY (DIPERBAIKI)
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.tab-link');
        const stickyTabContainer = document.getElementById('sticky-tabs');

        // A. Fungsi klik tab biar berhentinya pas (gak ketutupan header)
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault(); // Mencegah lompatan kasar bawaan HTML
                
                const targetId = this.getAttribute('data-target');
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    // Cari tau tinggi dari navbar lengket biar kita tau harus ngerem di mana
                    const headerOffset = stickyTabContainer ? stickyTabContainer.offsetHeight + 100 : 150; 
                    const elementPosition = targetSection.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }
            });
        });

        // B. Fungsi mendeteksi posisi scroll (Scroll Spy) biar garis oren ngikutin scroll user
        window.addEventListener('scroll', () => {
            let current = '';
            // Tinggi toleransi (biar scroll spy gak telat ganti nama tab pas di-scroll ke bawah)
            const scrollOffset = (stickyTabContainer ? stickyTabContainer.offsetHeight : 0) + 120; 

            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (scrollY >= (sectionTop - scrollOffset)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active', 'border-orange-500', 'text-orange-600');
                link.classList.add('border-transparent', 'text-gray-500');
                
                if (current && link.getAttribute('data-target') === current) {
                    link.classList.add('active', 'border-orange-500', 'text-orange-600');
                    link.classList.remove('border-transparent', 'text-gray-500');
                }
            });
        });

       // --- FITUR BARU: LOGIKA DP & CICILAN ---
        let currentPaymentMode = 'full'; // Default bayar lunas
        
        // 👇 DETEKSI H-14 DARI PHP LARAVEL 👇
        const isH14 = {{ (\Carbon\Carbon::now()->startOfDay()->diffInDays($tanggalBerangkat->copy()->startOfDay(), false) <= 14) ? 'true' : 'false' }};

        function setPaymentMode(mode) {
            // 🚨 BLOKIR JIKA MEMILIH DP PADA H-14 🚨
            if (mode === 'dp' && isH14) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Hanya Pembayaran Penuh',
                    text: 'Khusus keberangkatan di bawah 14 hari, metode pembayaran bertahap dinonaktifkan untuk mempercepat proses persiapan Anda',
                    confirmButtonText: '<i class="ph-bold ph-check-circle"></i> Baik, Mengerti',
                    confirmButtonColor: '#ea580c',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl px-6 py-2.5 font-bold shadow-md shadow-orange-500/20 active:scale-95 transition-all'
                    }
                });
                return; // Hentikan eksekusi, biarkan tombol tetap di mode "Bayar Penuh"
            }

            currentPaymentMode = mode;
            const btnFull = document.getElementById('btn-pay-full');
            const btnDp = document.getElementById('btn-pay-dp');
            const dpBox = document.getElementById('dp-simulation-box');
            const labelTotal = document.getElementById('label-total-display');

            if (mode === 'full') {
                if (btnFull) btnFull.className = "py-2.5 text-[11px] font-bold bg-white text-orange-600 rounded-lg shadow-sm transition-all border border-slate-200 focus:outline-none";
                if (btnDp) btnDp.className = "py-2.5 text-[11px] font-bold text-slate-500 hover:text-slate-800 rounded-lg transition-all focus:outline-none";
                if (dpBox) dpBox.classList.add('hidden');
                if (labelTotal) labelTotal.innerText = "Total Tagihan";
            } else {
                if (btnDp) btnDp.className = "py-2.5 text-[11px] font-bold bg-white text-orange-600 rounded-lg shadow-sm transition-all border border-slate-200 focus:outline-none";
                if (btnFull) btnFull.className = "py-2.5 text-[11px] font-bold text-slate-500 hover:text-slate-800 rounded-lg transition-all focus:outline-none";
                if (dpBox) dpBox.classList.remove('hidden');
                if (labelTotal) labelTotal.innerText = "Total Keseluruhan";
            }

            calculateTotal();
        }

        // FUNGSI INI UNTUK MENGUBAH ANGKA (QTY) KAMAR
        function updateQty(type, change, maxQuota) {
            const input = document.getElementById(`qty-${type}`);
            if(!input) return;

            const allInputs = document.querySelectorAll('.qty-input');
            let currentTotalPax = 0;
            allInputs.forEach(inp => currentTotalPax += parseInt(inp.value));

            let currentVal = parseInt(input.value);
            let newVal = currentVal + change;

            if (change === -1 && currentTotalPax <= 1 && currentVal >= 1) {
                showSweetAlertToast('Minimal pemesanan adalah 1 Pax', 'warning');
                return;
            }
            if (newVal < 0) newVal = 0;
            if (change === 1 && newVal > maxQuota) {
                showSweetAlertToast(`Tipe kamar ini hanya sisa ${maxQuota} seat!`, 'error');
                return;
            }
            input.value = newVal;
            calculateTotal();
        }

        // FUNGSI MENGHITUNG HARGA TOTAL (UPDATE UI)
        function calculateTotal() {
            let total = 0;
            let totalPax = 0;
            let summaryHtml = '';
            let selectedRoomNames = [];

            const inputs = document.querySelectorAll('.qty-input');
            const summaryContainer = document.getElementById('summary-container');
            const summaryList = document.getElementById('order-summary-list');
            const totalPriceMobiles = document.querySelectorAll('#total-price-mobile');
            const mobilePaxSummary = document.getElementById('mobile-pax-summary');

            inputs.forEach(input => {
                const qty = parseInt(input.value);
                const price = parseInt(input.getAttribute('data-price'));
                const name = input.getAttribute('data-name');

                if (qty > 0) {
                    total += qty * price;
                    totalPax += qty;
                    selectedRoomNames.push(name);
                    summaryHtml += `
                    <div class="flex justify-between text-xs font-medium text-orange-800 mb-1">
                        <span>${qty}x Pax ${name}</span>
                        <span>Rp ${(qty * price).toLocaleString('id-ID')}</span>
                    </div>`;
                }
            });

            // --- 🌟 KALKULASI DP & CICILAN (FIXED DP PER TRANSAKSI) 🌟 ---
            if (currentPaymentMode === 'dp' && totalPax > 0) {
                const DP_TRANSACTION = 10000000; // FIX: DP 10 Juta per TRANSAKSI (bukan per Pax)
                
                // Logika: DP maksimal adalah 10 Juta ATAU seharga total paket (jika total paket di bawah 10 Juta)
                let totalDP = Math.min(DP_TRANSACTION, total); 
                
                // Sisa tagihan dikurangi DP
                let sisaTagihan = total - totalDP; 
                
                // Sisa dibagi 2 termin pelunasan
                let cicilanPerTahap = sisaTagihan > 0 ? sisaTagihan / 2 : 0; 

                const dpAmountEl = document.getElementById('dp-amount-display');
                const sisaAmountEl = document.getElementById('sisa-amount-display');
                const cicilanAmountEl = document.getElementById('cicilan-amount-display');

                // Format ke Rupiah
                if (dpAmountEl) dpAmountEl.innerText = 'Rp ' + totalDP.toLocaleString('id-ID');
                if (sisaAmountEl) sisaAmountEl.innerText = 'Rp ' + sisaTagihan.toLocaleString('id-ID');
                
                // Jika ada sisa, tampilkan per termin. Jika tidak ada sisa (paket di bawah 10 Juta), tampilkan Rp 0
                if (cicilanAmountEl) {
                    if (sisaTagihan > 0) {
                        cicilanAmountEl.innerText = `Rp ${Math.round(cicilanPerTahap).toLocaleString('id-ID')}`;
                    } else {
                        cicilanAmountEl.innerText = `Lunas`;
                    }
                }
            }

            // 1. Update Desktop Total
            const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');
            const totalDisplayEl = document.getElementById('total-price-display');
            const totalPaxEl = document.getElementById('total-pax');

            if (totalDisplayEl) totalDisplayEl.innerText = formattedTotal;
            if (totalPaxEl) totalPaxEl.innerText = totalPax + ' Pax';

            // 2. Update Mobile Total & Summary Label
            totalPriceMobiles.forEach(mobileEl => {
                const priceLabel = document.getElementById('mobile-price-label');
                if (totalPax > 0) {
                    let totalJt = total / 1000000;
                    let formatJt = totalJt % 1 === 0 ? totalJt : totalJt.toFixed(1);

                    if (priceLabel) priceLabel.innerText = currentPaymentMode === 'dp' ? "Total Tagihan Keseluruhan" : "Total Tagihan";
                    mobileEl.innerHTML = `
                        <span class="text-xl font-black text-orange-600 tracking-tight truncate block">Rp ${formatJt}</span>
                        <span class="text-xs font-bold text-orange-500 flex-shrink-0">Jt</span>
                    `;
                    if (mobilePaxSummary) {
                        let uniqueRooms = [...new Set(selectedRoomNames)].join(', ');
                        mobilePaxSummary.innerHTML = `<span class="text-slate-700 font-extrabold">${totalPax} Pax</span> • ${uniqueRooms}`;
                    }
                } else {
                    let termurahJt = {{ $hargaTermurah / 1000000 }};
                    let formatTermurahJt = termurahJt % 1 === 0 ? termurahJt : termurahJt.toFixed(1);
                    if (priceLabel) priceLabel.innerText = "Harga Mulai";
                    mobileEl.innerHTML = `
                        <span class="text-xl font-black text-slate-900 tracking-tight truncate block">Rp ${formatTermurahJt}</span>
                        <span class="text-xs font-bold text-orange-500 flex-shrink-0">Jt</span>
                    `;
                    if (mobilePaxSummary) mobilePaxSummary.innerHTML = `Pilih Kamar`;
                }
            });

            // 3. Toggle Summary Box Desktop
            if (totalPax > 0 && summaryContainer) {
                summaryContainer.classList.remove('hidden');
                summaryList.innerHTML = summaryHtml;
            } else if(summaryContainer) {
                summaryContainer.classList.add('hidden');
            }
        }

    // JALANKAN SAAT HALAMAN PERTAMA DIBUKA
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof checkInitialCompareState === 'function') checkInitialCompareState();
        calculateTotal();
    });

        // 3. LIGHTBOX GALLERY
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');

        function openLightbox(element) {
            const img = element.querySelector('img');
            lightboxImg.src = img.src;
            lightbox.classList.remove('hidden');
            setTimeout(() => lightboxImg.classList.remove('scale-95'), 10);
        }

        function closeLightbox() {
            lightboxImg.classList.add('scale-95');
            setTimeout(() => lightbox.classList.add('hidden'), 300);
        }

        // 4. WHATSAPP & SWEETALERT TOAST
        let isFavorited = false;
        let isCompared = false;

        function showSweetAlertToast(title, icon) {
            Swal.fire({
                toast: true, position: 'top-end', icon: icon, title: title,
                showConfirmButton: false, timer: 2000, timerProgressBar: true
            });
        }

        // --- FUNGSI WISHLIST KHUSUS HALAMAN DETAIL ---
        async function toggleWishlistDetail(productId) {
            // 👇 1. FIX: CEK LOGIN DI AWAL (Cegah nembak API kalau belum login) 👇
            const isLoggedIn = {{ session('api_token') ? 'true' : 'false' }};
            if (!isLoggedIn) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Harap Login',
                    text: 'Silakan masuk ke akun Anda terlebih dahulu untuk menyimpan paket ke Wishlist.',
                    showCancelButton: true,
                    confirmButtonText: 'Login Sekarang',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ea580c',
                    reverseButtons: true
                }).then((res) => {
                    if (res.isConfirmed) window.location.href = '/login';
                });
            }

            // 2. Ambil elemen tombol (Desktop & Mobile)
            const dtBtn = document.getElementById('btn-fav-desktop');
            const mbBtn = document.getElementById('btn-fav-mobile');
            const dtIcon = document.getElementById('icon-fav-desktop');
            const mbIcon = document.getElementById('icon-fav-mobile');

            // Cek status saat ini berdasarkan class di tombol desktop
            const isCurrentlyWishlisted = dtBtn.classList.contains('text-red-500');

            // 3. Loading State UI (Ganti icon jadi spinner di kedua tombol)
            if(dtBtn) dtBtn.disabled = true;
            if(mbBtn) mbBtn.disabled = true;

            // Simpan class icon asli
            const originalDtIconClass = dtIcon.className;
            const originalMbIconClass = mbIcon.className;

            if(dtIcon) dtIcon.className = 'ph-bold ph-spinner animate-spin text-2xl text-slate-400';
            if(mbIcon) mbIcon.className = 'ph-bold ph-spinner animate-spin text-xl text-slate-400';

            try {
                // 4. Tembak API Laravel
                const response = await fetch('{{ route("marketplace.profil.wishlist.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                const result = await response.json();

                if (!response.ok) throw new Error(result.message || 'Gagal menyimpan wishlist');

                // 5. Update UI Jika Sukses
                if (result.action === 'added' || !isCurrentlyWishlisted) {
                    // Aktifin Tombol Desktop
                    if(dtBtn) dtBtn.className = 'flex-shrink-0 w-12 lg:w-14 h-12 lg:h-14 rounded-xl border-2 transition-all duration-300 flex items-center justify-center group border-red-200 text-red-500 bg-red-50';
                    if(dtIcon) dtIcon.className = 'ph-fill ph-heart text-xl lg:text-2xl transform group-hover:scale-110 transition-transform';
                    
                    // Aktifin Tombol Mobile
                    if(mbBtn) mbBtn.className = 'w-11 h-11 rounded-xl border active:scale-95 transition-all flex items-center justify-center shadow-sm flex-shrink-0 border-red-200 text-red-500 bg-red-50';
                    if(mbIcon) mbIcon.className = 'ph-fill ph-heart text-xl';
                    
                    showSweetAlertToast('Disimpan ke Wishlist', 'success');
                } else {
                    // Nonaktifin Tombol Desktop
                    if(dtBtn) dtBtn.className = 'flex-shrink-0 w-12 lg:w-14 h-12 lg:h-14 rounded-xl border-2 transition-all duration-300 flex items-center justify-center group border-slate-200 text-slate-400 hover:border-red-200 hover:text-red-500 hover:bg-red-50';
                    if(dtIcon) dtIcon.className = 'ph-bold ph-heart text-xl lg:text-2xl transform group-hover:scale-110 transition-transform';
                    
                    // Nonaktifin Tombol Mobile
                    if(mbBtn) mbBtn.className = 'w-11 h-11 rounded-xl border active:scale-95 transition-all flex items-center justify-center shadow-sm flex-shrink-0 border-slate-200 text-slate-500 bg-white';
                    if(mbIcon) mbIcon.className = 'ph-bold ph-heart text-xl';
                    
                    showSweetAlertToast('Dihapus dari Wishlist', 'info');
                }

            } catch (error) {
                // Kalau error dari server, balikin icon ke semula
                if(dtIcon) dtIcon.className = originalDtIconClass;
                if(mbIcon) mbIcon.className = originalMbIconClass;
                
                showSweetAlertToast('Terjadi kesalahan sistem', 'error');
                console.error("Wishlist Error:", error);
            } finally {
                // Nyalakan kembali tombol
                if(dtBtn) dtBtn.disabled = false;
                if(mbBtn) mbBtn.disabled = false;
            }
        }

        // Fungsi Toast-nya (Gue biarin nama fungsinya sesuai punya lu)
        function showSweetAlertToast(message, iconType) {
            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            }).fire({
                icon: iconType,
                title: message
            });
        }

       // ==========================================================
        // LOGIKA PERBANDINGAN (COMPARE) DI HALAMAN DETAIL
        // ==========================================================
        
        // Ambil ID produk yang lagi dibuka dari PHP Laravel
        const currentProductId = "{{ $produk['id'] }}";
        const MAX_COMPARE = 2;

        // Ambil data keranjang dari memori browser
        function getCompareList() {
            let compareList = localStorage.getItem('compareList');
            return compareList ? JSON.parse(compareList) : [];
        }

        function goToComparePage() {
            let currentList = getCompareList();
            if (currentList.length === 0) return;
            window.location.href = `/marketplace/bandingkan?ids=${currentList.join(',')}`;
        }

        // Atur UI tombol Aktif (Teal) / Tidak Aktif (Abu-abu)
        function setCompareBtnActive(isActive) {
            const dtBtn = document.getElementById('btn-compare-detail');
            const mbBtn = document.getElementById('btn-compare-mobile');

            if (isActive) {
                // Style saat Aktif
                if(dtBtn) { dtBtn.classList.remove('border-gray-200', 'text-gray-400'); dtBtn.classList.add('border-teal-400', 'text-teal-600', 'bg-teal-50'); }
                if(mbBtn) { mbBtn.classList.remove('border-gray-200', 'text-gray-400'); mbBtn.classList.add('border-teal-200', 'text-teal-600', 'bg-teal-50'); }
            } else {
                // Style saat Mati
                if(dtBtn) { dtBtn.classList.add('border-gray-200', 'text-gray-400'); dtBtn.classList.remove('border-teal-400', 'text-teal-600', 'bg-teal-50'); }
                if(mbBtn) { mbBtn.classList.add('border-gray-200', 'text-gray-400'); mbBtn.classList.remove('border-teal-200', 'text-teal-600', 'bg-teal-50'); }
            }
        }

        // Cek status pas halaman baru di-refresh
        function checkInitialCompareState() {
            let currentList = getCompareList();
            setCompareBtnActive(currentList.includes(String(currentProductId)));
        }

        // Fungsi Utama Pas Tombol Ditekan
        function toggleCompareDetail() {
            let currentList = getCompareList();
            let idStr = String(currentProductId);

            // LOGIKA 1: JIKA SUDAH ADA, MAKA HAPUS
            if (currentList.includes(idStr)) {
                currentList = currentList.filter(id => id !== idStr);
                localStorage.setItem('compareList', JSON.stringify(currentList));
                
                setCompareBtnActive(false);

                Swal.fire({
                    icon: 'info', title: 'Dihapus dari perbandingan',
                    toast: true, position: 'top-end', showConfirmButton: false, timer: 2000
                });
            } 
            // LOGIKA 2: JIKA BELUM ADA, MAKA TAMBAHKAN
            else {
                if (currentList.length >= MAX_COMPARE) {
                    Swal.fire({
                        icon: 'warning', title: 'Batas Maksimal!',
                        text: 'Anda hanya bisa membandingkan maksimal 2 paket sekaligus.',
                        confirmButtonColor: '#ea580c', confirmButtonText: 'Lihat Perbandingan',
                        showCancelButton: true, cancelButtonText: 'Tutup'
                    }).then((result) => {
                        if (result.isConfirmed) goToComparePage();
                    });
                    return;
                }

                currentList.push(idStr);
                localStorage.setItem('compareList', JSON.stringify(currentList));
                
                setCompareBtnActive(true);

                if (currentList.length === MAX_COMPARE) {
                    Swal.fire({
                        icon: 'success', title: 'Siap Dibandingkan!',
                        text: '2 Paket sudah dipilih. Ingin melihat perbandingannya sekarang?',
                        confirmButtonColor: '#14b8a6', confirmButtonText: 'Ya, Bandingkan',
                        showCancelButton: true, cancelButtonText: 'Pilih Lagi'
                    }).then((result) => {
                        if (result.isConfirmed) goToComparePage();
                    });
                } else {
                    Swal.fire({
                        icon: 'success', title: 'Ditambahkan ke perbandingan',
                        toast: true, position: 'top-end', showConfirmButton: false, timer: 2000
                    });
                }
            }
        }

        function contactWhatsApp() {
            const phoneNumber = "62811917988"; 
            const packageName = "{{ $produk['nama_produk'] }}";
            const currentUrl = window.location.href;
            const message = `Assalamu'alaikum CS pengenumroh.com, saya ingin bertanya mengenai *${packageName}* yang saya lihat di website: ${currentUrl}`;
            window.open(`https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`, '_blank');
        }

        async function handleCheckout() {
            // 1. CEK LOGIN
            const isLoggedIn = {{ session('api_token') ? 'true' : 'false' }};
            if (!isLoggedIn) {
                return Swal.fire({
                    icon: 'warning',
                    title: 'Harap Login Terlebih Dahulu',
                    text: 'Silakan masuk ke akun Anda untuk melanjutkan pemesanan paket Umroh.',
                    showCancelButton: true,
                    confirmButtonText: 'Login Sekarang',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ea580c',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = "{{ route('login') }}";
                });
            }

            // 2. AMBIL DATA PRODUK & KAMAR
            const inputs = document.querySelectorAll('.qty-input');
            let selectedRooms = [];
            let totalPax = 0;

            inputs.forEach(input => {
                const qty = parseInt(input.value);
                if (qty > 0) {
                    totalPax += qty;
                    for (let i = 0; i < qty; i++) {
                        selectedRooms.push({
                            product_id: "{{ $produk['id'] }}",
                            room_type: input.getAttribute('data-name'), 
                            quantity: 1, 
                            price: parseInt(input.getAttribute('data-price'))
                        });
                    }
                }
            });

            if (totalPax === 0) {
                scrollToBookingCard();
                return showSweetAlertToast('Pilih tipe kamar & jumlah jamaah dulu ya', 'warning');
            }

            // ==========================================
            // 3. AMBIL OPSI PEMBAYARAN (PEMISAH MUTLAK PUSAT VS MANDIRI)
            // ==========================================
            Swal.fire({
                title: 'Memuat Pilihan Rekening...',
                html: 'Sedang menyiapkan metode pembayaran...',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            let paymentSelection = null;

            try {
                const fetchUrl = "{{ url('/marketplace/produk') }}/{{ $produk['id'] }}/payment-options";
                const optRes = await fetch(fetchUrl, {
                    method: 'GET',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                });

                const optData = await optRes.json();
                
                if (!optRes.ok || optData.status === 'error') {
                    throw new Error(optData.message || 'API Gagal dimuat');
                }
                
                let strData = JSON.stringify(optData).toLowerCase();

                // 🌟 KUMPULKAN SEMUA DATA BANK YANG ADA DI JSON 🌟
                let rawBanks = [];
                function extractBanks(curr) {
                    if (Array.isArray(curr)) {
                        let valid = curr.filter(item => typeof item === 'object' && (item.nama_bank || item.bank_name || item.no_rekening || item.bank_account));
                        if (valid.length > 0) rawBanks.push(...valid);
                    } else if (typeof curr === 'object' && curr !== null) {
                        if (curr.nama_bank || curr.bank_name || curr.no_rekening || curr.bank_account) {
                            rawBanks.push(curr);
                        } else {
                            for (let k in curr) extractBanks(curr[k]);
                        }
                    }
                }
                extractBanks(optData);
                
                // 🌟 TENTUKAN MODE BERDASARKAN API ATAU DATA PRODUK 🌟
                let isMandiri = false;
                
                // Cek flag dari API Payment Options
                if (strData.includes('"rekening_mode":"mandiri"') || strData.includes('"allow_marketplace":false') || strData.includes('"allow_marketplace":0')) {
                    isMandiri = true;
                } 
                else if (strData.includes('"rekening_mode":"marketplace"') || strData.includes('"allow_marketplace":true') || strData.includes('"allow_marketplace":1')) {
                    isMandiri = false;
                } 
                // Jika API bungkam, kita baca paksa dari detail produk Laravel-nya
                else {
                    const bladeRekMode = "{{ $produk['creator']['rekening_mode'] ?? '' }}".toUpperCase();
                    const bladeAllow = "{{ $produk['creator']['allow_marketplace'] ?? '' }}";
                    
                    if (bladeRekMode === 'MANDIRI' || bladeAllow === '0' || bladeAllow === 'false') {
                        isMandiri = true;
                    } else if (bladeRekMode === 'MARKETPLACE' || bladeAllow === '1' || bladeAllow === 'true') {
                        isMandiri = false;
                    } else {
                        // Pasrah, tebak dari ketersediaan array bank
                        isMandiri = rawBanks.length > 0;
                    }
                }

                // 🌟 RENDER HTML BERDASARKAN MODE MUTLAK 🌟
                let htmlRadio = '<div class="space-y-3 mt-4 text-left max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">';

                if (!isMandiri) {
                    // --- JALUR REKENING PUSAT (BCA & BSI TERPISAH) ---
                    // 🔥 FIX: Tambahkan nama_bank dan bank_code agar dibaca utuh oleh API Backend Darda 🔥
                    let valBca = JSON.stringify({ type: 'MARKETPLACE', bank: 'BCA', nama_bank: 'BCA', bank_code: 'BCA', no_rekening: '7131720452', atas_nama: 'PT Kolaborasi Para Sahabat' }).replace(/'/g, "&#39;");
                    let valBsi = JSON.stringify({ type: 'MARKETPLACE', bank: 'BSI', nama_bank: 'BSI', bank_code: 'BSI', no_rekening: '7215671498', atas_nama: 'PT Kolaborasi Para Sahabat' }).replace(/'/g, "&#39;");

                    htmlRadio += `
                    <!-- Pilihan BCA Pusat -->
                    <label for="rek-bca" class="relative flex items-start gap-4 p-4 rounded-2xl cursor-pointer border border-slate-200/80 bg-gradient-to-br from-white via-slate-50/50 to-blue-50/30 hover:border-blue-400 hover:shadow-md transition-all duration-300 has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50/40 has-[:checked]:ring-2 has-[:checked]:ring-blue-500/20 shadow-sm overflow-hidden group mb-3">
                        <div class="pt-1 relative z-10 flex-shrink-0">
                            <input type="radio" id="rek-bca" name="pilih_rekening" value='${valBca}' class="w-5 h-5 text-blue-600 focus:ring-blue-500 transition-all cursor-pointer mt-0.5" checked>
                        </div>
                        <div class="flex-1 relative z-10 min-w-0">
                            <div class="flex items-center justify-between mb-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                                    <p class="text-xs font-black text-slate-900 tracking-tight uppercase">Rekening Resmi PengenUmroh</p>
                                </div>
                                <span class="bg-blue-600 text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-sm flex-shrink-0">
                                    Pusat
                                </span>
                            </div>
                            <div class="flex items-center justify-between bg-white px-3 py-3 rounded-xl border border-slate-100 shadow-2xs group-hover:border-blue-200 transition-colors mb-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="px-2.5 h-6 bg-blue-100/80 text-blue-700 text-[10px] font-black rounded flex items-center justify-center tracking-wider shadow-inner flex-shrink-0">
                                        BCA
                                    </div>
                                    <!-- 👇 FIX: Tambah id="norek-pusat-bca" 👇 -->
                                    <span class="text-sm font-extrabold text-slate-800 font-mono tracking-wider truncate" id="norek-pusat-bca">7131720452</span>
                                </div>
                                <!-- 👇 FIX: TOMBOL COPY REKENING PUSAT (BCA) 👇 -->
                                <button type="button" onclick="copyRekeningDesktop(event, 'norek-pusat-bca')" class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors flex-shrink-0" title="Salin Nomor Rekening">
                                    <i class="ph-bold ph-copy text-lg"></i>
                                </button>
                            </div>
                            <div class="flex items-center justify-between px-1">
                                <span class="text-[11px] text-slate-500 font-medium flex-shrink-0">Atas Nama (A.N)</span>
                                <span class="text-[11px] font-bold text-slate-800 truncate ml-2">PT Kolaborasi Para Sahabat</span>
                            </div>
                        </div>
                    </label>

                    <!-- Pilihan BSI Pusat -->
                    <label for="rek-bsi" class="relative flex items-start gap-4 p-4 rounded-2xl cursor-pointer border border-slate-200/80 bg-gradient-to-br from-white via-slate-50/50 to-teal-50/30 hover:border-teal-400 hover:shadow-md transition-all duration-300 has-[:checked]:border-teal-600 has-[:checked]:bg-teal-50/40 has-[:checked]:ring-2 has-[:checked]:ring-teal-500/20 shadow-sm overflow-hidden group">
                        <div class="pt-1 relative z-10 flex-shrink-0">
                            <input type="radio" id="rek-bsi" name="pilih_rekening" value='${valBsi}' class="w-5 h-5 text-teal-600 focus:ring-teal-500 transition-all cursor-pointer mt-0.5">
                        </div>
                        <div class="flex-1 relative z-10 min-w-0">
                            <div class="flex items-center justify-between mb-3.5">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-teal-600 animate-pulse"></span>
                                    <p class="text-xs font-black text-slate-900 tracking-tight uppercase">Rekening Resmi PengenUmroh</p>
                                </div>
                                <span class="bg-teal-600 text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-sm flex-shrink-0">
                                    Pusat
                                </span>
                            </div>
                            <div class="flex items-center justify-between bg-white px-3 py-3 rounded-xl border border-slate-100 shadow-2xs group-hover:border-teal-200 transition-colors mb-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="px-2.5 h-6 bg-teal-100/80 text-teal-700 text-[10px] font-black rounded flex items-center justify-center tracking-wider shadow-inner flex-shrink-0">
                                        BSI
                                    </div>
                                    <!-- 👇 FIX: Tambah id="norek-pusat-bsi" 👇 -->
                                    <span class="text-sm font-extrabold text-slate-800 font-mono tracking-wider truncate" id="norek-pusat-bsi">7215671498</span>
                                </div>
                                <!-- 👇 FIX: TOMBOL COPY REKENING PUSAT (BSI) 👇 -->
                                <button type="button" onclick="copyRekeningDesktop(event, 'norek-pusat-bsi')" class="p-1.5 rounded-lg text-slate-400 hover:text-teal-600 hover:bg-teal-50 transition-colors flex-shrink-0" title="Salin Nomor Rekening">
                                    <i class="ph-bold ph-copy text-lg"></i>
                                </button>
                            </div>
                            <div class="flex items-center justify-between px-1">
                                <span class="text-[11px] text-slate-500 font-medium flex-shrink-0">Atas Nama (A.N)</span>
                                <span class="text-[11px] font-bold text-slate-800 truncate ml-2">PT Kolaborasi Para Sahabat</span>
                            </div>
                        </div>
                    </label>
                    `;
                } else {
                    // --- JALUR REKENING TRAVEL/MANDIRI (Desain Modern FinTech Grade) ---
                    if (rawBanks.length === 0) {
                        throw new Error("Travel menggunakan rekening Mandiri, namun data bank belum diatur.");
                    }

                    rawBanks.forEach((rek, idx) => {
                        let rekId = rek.id || rek.travel_rekening_id || rek.rekening_id || null;
                        let bank = rek.nama_bank || rek.bank_name || rek.bank || 'Bank Transfer';
                        let noRek = rek.no_rekening || rek.bank_account || rek.nomor_rekening || rek.account_number || '';
                        let owner = rek.atas_nama || rek.bank_owner || rek.pemilik_rekening || rek.account_name || '';
                        let isChecked = idx === 0 ? 'checked' : '';
                        let valObj = { type: 'MANDIRI' };
                        if (rekId) valObj.travel_rekening_id = parseInt(rekId);
                        let jsonValue = JSON.stringify(valObj).replace(/'/g, "&#39;");
                        
                        // 👇 FIX: Buat ID unik untuk elemen span yang berisi nomor rekening 👇
                        let spanId = `norek-travel-${idx}`;

                        htmlRadio += `
                        <label class="relative flex items-start gap-4 p-4 rounded-2xl cursor-pointer border border-slate-200/80 bg-gradient-to-br from-white via-slate-50/50 to-orange-50/30 hover:border-orange-400 hover:shadow-md transition-all duration-300 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50/40 has-[:checked]:ring-2 has-[:checked]:ring-orange-500/20 shadow-sm overflow-hidden group mb-3">
                            <!-- Efek Cahaya Halus di Kanan Atas (Warna Oranye) -->
                            <div class="absolute top-0 right-0 w-24 h-24 bg-orange-100/50 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none transition-all group-hover:bg-orange-200/50"></div>
                            
                            <!-- Radio Button -->
                            <div class="pt-1 relative z-10 flex-shrink-0">
                                <input type="radio" name="pilih_rekening" value='${jsonValue}' class="w-5 h-5 text-orange-600 focus:ring-orange-500 transition-all cursor-pointer mt-0.5" ${isChecked}>
                            </div>
                            <div class="flex-1 relative z-10 min-w-0">
                                <!-- Top Header: Title & Travel Badge -->
                                <div class="flex items-center justify-between mb-3.5">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                                        <p class="text-xs font-black text-slate-900 tracking-tight uppercase">Rekening Mitra Travel</p>
                                    </div>
                                    <span class="bg-gradient-to-r from-orange-500 to-orange-600 text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-sm flex-shrink-0">
                                        Travel
                                    </span>
                                </div>
                                <!-- Bank Info Row -->
                                <div class="flex items-center justify-between bg-white px-3 py-3 rounded-xl border border-slate-100 shadow-2xs group-hover:border-orange-200 transition-colors mb-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="px-2.5 h-6 bg-orange-100/80 text-orange-700 text-[10px] font-black rounded flex items-center justify-center tracking-wider shadow-inner flex-shrink-0">
                                            ${bank.toUpperCase()}
                                        </div>
                                        <!-- 👇 FIX: Tambah id ke span 👇 -->
                                        <span class="text-sm font-extrabold text-slate-800 font-mono tracking-wider truncate" id="${spanId}">${noRek}</span>
                                    </div>
                                    <!-- 👇 FIX: TOMBOL COPY REKENING TRAVEL 👇 -->
                                    <button type="button" onclick="copyRekeningDesktop(event, '${spanId}')" class="p-1.5 rounded-lg text-slate-400 hover:text-orange-600 hover:bg-orange-50 transition-colors flex-shrink-0" title="Salin Nomor Rekening">
                                        <i class="ph-bold ph-copy text-lg"></i>
                                    </button>
                                </div>
                                <!-- Footer Atas Nama (Clean Minimalist) -->
                                <div class="flex items-center justify-between px-1">
                                    <span class="text-[11px] text-slate-500 font-medium flex-shrink-0">Atas Nama (A.N)</span>
                                    <span class="text-[11px] font-bold text-slate-800 truncate ml-2">${owner}</span>
                                </div>
                            </div>
                        </label>
                        `;
                    });
                }
                htmlRadio += '</div>';

                const { value: selectedVal, isConfirmed: isRekConfirmed } = await Swal.fire({
                    title: 'Pilih Tujuan Pembayaran',
                    html: `
                        <p class="text-sm text-slate-600 mb-2">Silakan pilih ke mana Anda akan mentransfer dana pembayaran:</p>
                        ${htmlRadio}
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjut Pesan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ea580c',
                    focusConfirm: false,
                    preConfirm: () => {
                        const checkedEl = Swal.getPopup().querySelector('input[name="pilih_rekening"]:checked');
                        if (!checkedEl) {
                            Swal.showValidationMessage('Silakan pilih salah satu rekening!');
                            return false;
                        }
                        return JSON.parse(checkedEl.value);
                    }
                });

                if (!isRekConfirmed) return;
                paymentSelection = selectedVal;
                
                if (paymentSelection && paymentSelection.travel_rekening_id) {
                localStorage.setItem(`saved_rek_{{ $produk['id'] }}`, paymentSelection.travel_rekening_id);
        }

            } catch(e) {
                // ==========================================
                // JIKA TETAP GAGAL, FALLBACK KE CHECKOUT STANDAR
                // ==========================================
                console.warn("Pesan Error Rekening:", e);
                let textKonfirmasi = `Anda akan memesan ${totalPax} Pax untuk paket ini. Lanjutkan?`;
                
                const fallback = await Swal.fire({
                    title: 'Konfirmasi Pemesanan',
                    text: textKonfirmasi,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Pesan Sekarang',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ea580c'
                });
                if (!fallback.isConfirmed) return;
            }

            // ==========================================
            // 4. KIRIM FINAL KE CHECKOUT API
            // ==========================================
            Swal.fire({
                title: 'Sedang Memproses...',
                html: 'Mohon tunggu sebentar, kami sedang membuat pesanan Anda.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            try {
                const payloadData = {
                    product_id: "{{ $produk['id'] }}",
                    items: selectedRooms,
                    payment_method: currentPaymentMode // Full atau DP
                };

                // SISIPKAN DATA REKENING
                if (paymentSelection) {
                    payloadData.payment_selection = paymentSelection;
                }

                const response = await fetch("{{ route('marketplace.produk.checkout') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(payloadData)
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Pemesanan Berhasil!',
                        text: 'Pesanan Anda telah dicatat. Silakan lakukan pembayaran.',
                        confirmButtonText: 'Lihat Pesanan Saya',
                        confirmButtonColor: '#ea580c'
                    }).then(() => {
                        window.location.href = "{{ route('marketplace.profil.pesanan') }}";
                    });
                } else {
                    throw new Error(result.message || 'Gagal memproses pesanan');
                }
            } catch (error) {
                Swal.fire('Gagal!', error.message, 'error');
            }
        }

        // Animasi meluncur otomatis ke kotak pemilihan kamar (HP UX)
        function scrollToBookingCard() {
            const bookingCard = document.getElementById('booking-card');
            if(bookingCard) {
                // Nge-highlight sebentar (nge-blink) biar user sadar ini yg dituju
                bookingCard.classList.add('ring-4', 'ring-orange-200', 'transition-all', 'duration-500');
                
                bookingCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Ilangin efek blink setelah 1.5 detik
                setTimeout(() => {
                    bookingCard.classList.remove('ring-4', 'ring-orange-200');
                }, 1500);
            }
        }

        // Fungsi untuk menyalin nomor rekening (Tanpa menutup modal SweetAlert)
        function copyRekeningDesktop(event, spanId) {
            // Stop propagation biar radio button gak ikut kepencet
            event.preventDefault();
            event.stopPropagation();
            
            const norekEl = document.getElementById(spanId);
            if (norekEl) {
                const textToCopy = norekEl.innerText.trim();
                navigator.clipboard.writeText(textToCopy).then(() => {
                    // Ambil elemen tombol yang baru saja diklik
                    const btn = event.currentTarget;
                    const originalHtml = btn.innerHTML; // Simpan ikon copy asli
                    
                    // Ubah ikon jadi Centang Hijau 
                    btn.innerHTML = '<i class="ph-bold ph-check text-emerald-600 text-lg"></i>';
                    btn.classList.add('bg-emerald-50', 'border', 'border-emerald-200');
                    
                    // Kembalikan ke ikon Copy seperti semula setelah 2 detik
                    setTimeout(() => {
                        btn.innerHTML = originalHtml;
                        btn.classList.remove('bg-emerald-50', 'border', 'border-emerald-200');
                    }, 2000);

                }).catch(err => {
                    console.error('Gagal menyalin:', err);
                    // Kasih tau kalau error dengan ikon silang merah
                    const btn = event.currentTarget;
                    btn.innerHTML = '<i class="ph-bold ph-x text-red-500 text-lg"></i>';
                    setTimeout(() => {
                        btn.innerHTML = '<i class="ph-bold ph-copy text-lg"></i>';
                    }, 2000);
                });
            }
        }
       
    </script>
</x-layouts.marketplace>