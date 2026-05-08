<x-layouts.marketplace>

    @php
        // 1. FORMAT TANGGAL
        $tanggalBerangkat = \Carbon\Carbon::parse($produk['tgl_keberangkatan'] ?? now());
        
        // 2. AMBIL HARGA TERENDAH UNTUK DISPLAY (Cari harga paling murah dari array prices)
        $hargaTermurah = 0;
        if(isset($produk['prices']) && count($produk['prices']) > 0) {
            $hargaTermurah = min(array_column($produk['prices'], 'price'));
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
        $gambarUtama = isset($produk['thumbnail_url']) ? "https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/" . rawurlencode($produk['thumbnail_url']) : "/assets/img/marketplace/produk-dummy2.png";
        
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

    <main class="pt-32 pb-32 md:pb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

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
                        <div class="relative w-full aspect-[3/4] md:aspect-auto md:h-[500px] lg:h-[600px] md:col-span-4 rounded-2xl overflow-hidden shadow-sm group cursor-pointer" onclick="openLightbox(this)">
                            <img src="{{ $gambarUtama }}" class="w-full h-full object-cover transition duration-700 ease-in-out group-hover:scale-105" alt="{{ $produk['nama_produk'] }}">
                            <div class="absolute bottom-4 left-4 bg-black/50 backdrop-blur-sm text-white px-4 py-2 rounded-xl text-sm font-semibold flex items-center gap-2 transition group-hover:bg-black/60">
                                <i class="ph-fill ph-camera"></i> Lihat Galeri
                            </div>
                        </div>
                    </div>
                </div>

                {{-- JUDUL PAKET & SUMMARY --}}
                <div class="space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-md font-bold uppercase tracking-wide mb-2 inline-block">
                                Tersisa {{ $produk['quota'] ?? 0 }} Seat
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
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-airplane-takeoff text-2xl text-orange-500 mb-1"></i>
                            <span class="text-[10px] text-gray-500">Keberangkatan</span>
                            <span class="text-sm font-bold text-gray-800 line-clamp-1" title="{{ $kotaBerangkat }}">{{ $kotaBerangkat }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-airplane-right text-2xl text-orange-500 mb-1"></i>
                            <span class="text-[10px] text-gray-500">Maskapai</span>
                            <span class="text-sm font-bold text-gray-800 line-clamp-1" title="{{ $maskapai }}">{{ $maskapai }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-buildings text-2xl text-orange-500 mb-1"></i>
                            <span class="text-[10px] text-gray-500">Hotel Makkah</span>
                            <span class="text-sm font-bold text-gray-800 line-clamp-1" title="{{ $hotelMakkah }}">{{ $hotelMakkah }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-buildings text-2xl text-orange-500 mb-1"></i>
                            <span class="text-[10px] text-gray-500">Hotel Madinah</span>
                            <span class="text-sm font-bold text-gray-800 line-clamp-1" title="{{ $hotelMadinah }}">{{ $hotelMadinah }}</span>
                        </div>
                        <div class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-users-three text-2xl text-orange-500 mb-1"></i>
                            <span class="text-[10px] text-gray-500">Biro Travel</span>
                            <span class="text-sm font-bold text-gray-800 line-clamp-1" title="{{ $biroTravel }}">{{ $biroTravel }}</span>
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
                        <a href="#catatan" class="tab-link pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm whitespace-nowrap transition" data-target="catatan">Catatan</a>
                    </div>
                </div>

                {{-- SECTION: HOTEL (DINAMIS DARI API) --}}
                <section id="hotel" class="scroll-mt-40">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Akomodasi & Hotel</h3>
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                        @forelse($produk['hotels'] ?? [] as $hotel)
                            <div class="flex flex-col md:flex-row gap-6 mb-6 last:mb-0 border-b border-dashed border-gray-200 last:border-0 pb-6 last:pb-0">
                                @php
                                    $hotelImg = isset($hotel['image']) ? "https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/hotels/" . rawurlencode($hotel['image']) : "https://ui-avatars.com/api/?name=".str_replace(' ','+',$hotel['name'])."&background=F97316&color=fff";
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
                            <div class="flex items-start gap-4 mb-8 border-b border-gray-100 pb-6">
                                <div class="bg-green-100 p-3 rounded-full text-green-600 flex-shrink-0">
                                    <i class="ph-fill ph-check text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">Harga Termasuk</h4>
                                    <p class="text-sm text-gray-500 mt-1">Benefit dan layanan lengkap yang Anda dapatkan:</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                                @forelse($includeFacilities as $item)
                                    <div class="group flex gap-3 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                        <i class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform mt-0.5"></i>
                                        <p class="font-bold text-gray-800 text-sm">{{ $item }}</p>
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
                    <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-sm text-gray-600 space-y-4 leading-relaxed">
                        
                        <div>
                            <h4 class="font-bold text-gray-800 mb-2">Deskripsi Paket</h4>
                            <p>
                                @if(!empty($produk['description']))
                                    {!! nl2br(e($produk['description'])) !!}
                                @else
                                    Belum ada deskripsi untuk paket ini.
                                @endif
                            </p>
                        </div>

                        @if(isset($produk['notes']) && count($produk['notes']) > 0)
                            <hr class="border-gray-100">
                            <div>
                                <h4 class="font-bold text-gray-800 mb-2">Catatan Tambahan</h4>
                                <ul class="list-disc pl-5 space-y-1 marker:text-orange-500">
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
            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-6" id="booking-card">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-orange-100 rounded-full opacity-50 blur-xl"></div>

                        <div class="space-y-3 mb-6 relative z-10">
                            <p class="text-sm font-semibold text-gray-800">Pilih Tipe Kamar & Jumlah</p>

                            {{-- Looping Array Kamar (Prices) dari API --}}
                            @forelse($produk['prices'] ?? [] as $kamar)
                                @php
                                    $namaKamar = $kamar['room_types'] ?? 'Kamar';
                                    $hargaKamar = $kamar['price'] ?? 0;
                                    $idInputKamar = \Illuminate\Support\Str::slug($namaKamar);
                                    
                                    // Bikin Icon dinamis berdasarkan nama kamar
                                    $iconKamar = 'ph-users';
                                    if(stripos($namaKamar, 'quad') !== false) $iconKamar = 'ph-users-four';
                                    if(stripos($namaKamar, 'triple') !== false) $iconKamar = 'ph-users-three';
                                @endphp

                                <div class="p-3 rounded-xl border border-gray-200 flex items-center justify-between group hover:border-orange-300 transition-all bg-slate-50 hover:bg-orange-50/50">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-white p-2 rounded-lg text-orange-600 shadow-sm border border-gray-100 group-hover:border-orange-200">
                                            <i class="ph-fill {{ $iconKamar }} text-xl"></i>
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-gray-800">{{ $namaKamar }}</p>
                                            <p class="text-xs text-gray-500">Rp {{ number_format($hargaKamar / 1000000, 1, ',', '.') }} Jt/pax</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center bg-white border border-gray-200 rounded-lg p-1 shadow-sm">
                                        <button onclick="updateQty('{{ $idInputKamar }}', -1)" class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-orange-600 transition">-</button>
                                        {{-- Value awal Quad dikasih 1, sisanya 0 biar otomatis kehitung --}}
                                        <input type="number" id="qty-{{ $idInputKamar }}" value="{{ $loop->first ? 1 : 0 }}" data-name="{{ $namaKamar }}" data-price="{{ $hargaKamar }}" class="qty-input w-10 text-center text-sm font-bold bg-transparent focus:outline-none" readonly>
                                        <button onclick="updateQty('{{ $idInputKamar }}', 1)" class="w-8 h-8 flex items-center justify-center text-orange-600 transition">+</button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-red-500 italic">Harga belum disetting oleh Travel.</p>
                            @endforelse
                        </div>

                        {{-- Summary Container --}}
                        <div id="summary-container" class="mb-4 p-3 bg-orange-50 rounded-xl border border-orange-100 border-dashed">
                            <p class="text-[10px] uppercase tracking-wider font-bold text-orange-400 mb-2">Rincian Pax</p>
                            <div id="order-summary-list" class="space-y-1 text-sm font-medium text-orange-800"></div>
                        </div>

                        <div class="mb-6 pt-4 border-t border-dashed border-gray-300 relative">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-gray-500 font-medium">Estimasi Total</span>
                                <span class="text-xs text-gray-400 font-bold" id="total-pax">0 Pax</span>
                            </div>
                            <div class="flex items-end">
                                <span class="text-3xl font-extrabold text-orange-600" id="total-price-display">Rp 0</span>
                            </div>
                        </div>

                        <div class="hidden md:block">
                            <div class="flex gap-2">
                                <button onclick="toggleFavorite()" id="btn-fav-desktop" class="flex-shrink-0 w-14 h-14 rounded-xl border-2 border-gray-200 text-gray-400 hover:border-red-200 hover:text-red-500 hover:bg-red-50 transition-all duration-300 flex items-center justify-center group">
                                    <i id="icon-fav-desktop" class="ph-bold ph-heart text-2xl transform group-hover:scale-110 transition-transform"></i>
                                </button>
                                <button onclick="toggleCompareDetail()" id="btn-compare-detail" class="flex-shrink-0 w-14 h-14 rounded-xl border-2 border-gray-200 text-gray-400 hover:border-teal-400 hover:text-teal-600 hover:bg-teal-50 transition-all duration-300 flex items-center justify-center group">
                                    <i id="icon-compare-detail" class="ph-bold ph-arrows-left-right text-2xl transform group-hover:rotate-180 transition-transform duration-500"></i>
                                </button>
                                <button onclick="Swal.fire('Segera Hadir!', 'Fitur pemesanan langsung sedang dalam tahap pengembangan.', 'info')" class="flex-1 bg-orange-500 text-white font-bold py-3.5 rounded-xl hover:bg-orange-600 transition shadow-lg shadow-orange-500/30 flex justify-center items-center gap-2">
                                    <i class="ph-bold ph-chat-teardrop-text text-xl"></i>
                                    <span>Pesan Sekarang</span>
                                </button>
                            </div>
                        </div>

                    </div>

                    {{-- Tombol WhatsApp Bantuan --}}
                    <button onclick="contactWhatsApp()" class="w-full bg-green-50 p-4 rounded-xl border border-green-100 flex gap-4 items-center hover:bg-green-100 hover:border-green-200 transition-all duration-300 group text-left">
                        <div class="bg-green-500 p-2 rounded-lg text-white group-hover:scale-110 transition-transform duration-300"><i class="ph-bold ph-whatsapp-logo text-2xl"></i></div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h5 class="font-bold text-green-900 text-sm">Butuh Bantuan? Hubungi CS</h5>
                                <i class="ph-bold ph-caret-right text-green-600 text-xs group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <p class="text-[11px] text-green-700 mt-0.5">Tanya detail paket atau cara pemesanan langsung via WhatsApp.</p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </main>

    {{-- BOTTOM BAR MOBILE --}}
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 p-3 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] md:hidden z-40 flex items-center justify-between gap-2 animate-fade-in">
        <div class="flex flex-col flex-1 min-w-0 pr-1">
            <span class="text-[10px] text-gray-500 uppercase font-medium tracking-wide">Total Harga</span>
            <span class="text-base font-extrabold text-orange-600 truncate" id="total-price-mobile">Rp 0</span>
        </div>
        <button onclick="toggleCompareDetail()" id="btn-compare-mobile" class="flex-shrink-0 w-11 h-11 rounded-xl border border-gray-200 text-gray-400 active:scale-95 transition-all flex items-center justify-center relative">
            <i id="icon-compare-mobile" class="ph-bold ph-arrows-left-right text-xl"></i>
        </button>
        <button onclick="toggleFavorite()" id="btn-fav-mobile" class="flex-shrink-0 w-11 h-11 rounded-xl border border-gray-200 text-gray-400 active:scale-95 transition-all flex items-center justify-center">
            <i id="icon-fav-mobile" class="ph-bold ph-heart text-xl"></i>
        </button>
        <button onclick="Swal.fire('Segera Hadir!', 'Sedang dalam pengembangan', 'info')" class="flex-shrink-0 bg-orange-500 text-white px-5 py-3 rounded-xl font-bold text-sm shadow-lg shadow-orange-500/20 active:scale-95 transition flex items-center gap-2">
            <i class="ph-bold ph-chat-teardrop-text"></i> Pesan
        </button>
    </div>

    {{-- LIGHTBOX IMAGE --}}
    <div id="lightbox" class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center hidden p-4" onclick="closeLightbox()">
        <button class="absolute top-4 right-4 text-white text-3xl hover:text-orange-500 transition"><i class="ph-bold ph-x"></i></button>
        <img id="lightbox-img" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
    </div>

    {{-- SCRIPTS KHUSUS DETAIL HALAMAN --}}
    <script>
        // 1. SCROLL SPY UNTUK TAB STICKY
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.tab-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                if (scrollY >= sectionTop - 180) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active', 'border-orange-500', 'text-orange-600');
                link.classList.add('border-transparent', 'text-gray-500');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.add('active', 'border-orange-500', 'text-orange-600');
                    link.classList.remove('border-transparent', 'text-gray-500');
                }
            });
        });

        // 2. LOGIKA CHECKOUT BOX (KALKULASI HARGA DINAMIS)
        function updateQty(type, change) {
            const input = document.getElementById(`qty-${type}`);
            if(!input) return;

            const allInputs = document.querySelectorAll('.qty-input');
            let currentTotalPax = 0;
            allInputs.forEach(inp => currentTotalPax += parseInt(inp.value));

            let newVal = parseInt(input.value) + change;
            if (change === -1 && currentTotalPax <= 1) return; // Wajib minimal 1 pax
            if (newVal < 0) newVal = 0;
            
            input.value = newVal;
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            let totalPax = 0;
            let summaryHtml = ''; 
            const inputs = document.querySelectorAll('.qty-input');
            const summaryContainer = document.getElementById('summary-container');
            const summaryList = document.getElementById('order-summary-list');
            const totalPriceMobile = document.getElementById('total-price-mobile');

            inputs.forEach(input => {
                const qty = parseInt(input.value);
                const price = parseInt(input.getAttribute('data-price'));
                const name = input.getAttribute('data-name');

                if (qty > 0) {
                    total += qty * price;
                    totalPax += qty;
                    summaryHtml += `
                        <div class="flex justify-between text-xs font-medium text-orange-800">
                            <span>${qty}x Pax ${name}</span>
                            <span>Rp ${(qty * price).toLocaleString('id-ID')}</span>
                        </div>`;
                }
            });

            const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');

            document.getElementById('total-price-display').innerText = formattedTotal;
            document.getElementById('total-pax').innerText = totalPax + ' Pax';
            if (totalPriceMobile) totalPriceMobile.innerText = 'Rp ' + (total/1000000).toFixed(1) + ' Jt';

            if (totalPax > 0 && summaryContainer) {
                summaryContainer.classList.remove('hidden');
                summaryList.innerHTML = summaryHtml;
            } else if(summaryContainer) {
                summaryContainer.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            checkInitialCompareState();
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

        function toggleFavorite() {
            isFavorited = !isFavorited;
            const dtBtn = document.getElementById('btn-fav-desktop');
            const mbBtn = document.getElementById('btn-fav-mobile');
            const dtIcon = document.getElementById('icon-fav-desktop');
            const mbIcon = document.getElementById('icon-fav-mobile');

            if (isFavorited) {
                if(dtBtn) dtBtn.classList.replace('text-gray-400', 'text-red-500');
                if(dtIcon) dtIcon.classList.replace('ph-bold', 'ph-fill');
                if(mbBtn) mbBtn.classList.replace('text-gray-400', 'text-red-500');
                if(mbIcon) mbIcon.classList.replace('ph-bold', 'ph-fill');
                showSweetAlertToast('Disimpan ke Wishlist', 'success');
            } else {
                if(dtBtn) dtBtn.classList.replace('text-red-500', 'text-gray-400');
                if(dtIcon) dtIcon.classList.replace('ph-fill', 'ph-bold');
                if(mbBtn) mbBtn.classList.replace('text-red-500', 'text-gray-400');
                if(mbIcon) mbIcon.classList.replace('ph-fill', 'ph-bold');
                showSweetAlertToast('Dihapus dari Wishlist', 'info');
            }
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
    </script>
</x-layouts.marketplace>