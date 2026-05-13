<x-layouts.products>

    <header class="pt-28 pb-6 lg:pt-32 lg:pb-10 bg-white border-b border-slate-100" id="hero">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end gap-4 md:gap-6">
                <div class="w-full md:w-auto">

                    {{-- LOGIKA JUDUL DINAMIS MITRA & KATEGORI --}}
                    @if (!empty($namaMitra))
                        <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-2">
                            Paket dari <span class="text-orange-600">{{ ucwords($namaMitra) }}</span>
                        </h1>
                        <div class="flex items-center gap-3 flex-wrap">
                            <p class="text-slate-500 text-xs md:text-base">Menampilkan
                                <span id="product-counter"
                                    class="font-bold text-orange-600">{{ count($daftarProduk) }}</span> paket
                                perjalanan.
                            </p>
                            <span class="w-1.5 h-1.5 bg-slate-300 rounded-full hidden sm:block"></span>
                            <a href="{{ route('marketplace.produk.index') }}"
                                class="text-xs md:text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition-all">
                                <i class="ph-bold ph-x-circle"></i> Lihat Semua Travel
                            </a>
                        </div>
                    @elseif (!empty($kategoriFilter))
                        {{-- TAMPILAN JIKA FILTER KATEGORI (HAJI) AKTIF --}}
                        <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-2">
                            Kategori <span
                                class="text-orange-600">{{ ucwords(str_replace('-', ' ', $kategoriFilter)) }}</span>
                        </h1>
                        <div class="flex items-center gap-3 flex-wrap">
                            <p class="text-slate-500 text-xs md:text-base">Menampilkan
                                <span id="product-counter"
                                    class="font-bold text-orange-600">{{ count($daftarProduk) }}</span> paket tersedia.
                            </p>
                            <span class="w-1.5 h-1.5 bg-slate-300 rounded-full hidden sm:block"></span>
                            <a href="{{ route('marketplace.produk.index') }}"
                                class="text-xs md:text-sm font-bold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition-all">
                                <i class="ph-bold ph-x-circle"></i> Hapus Filter
                            </a>
                        </div>
                    @else
                        <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-2">Temukan Paket Impian</h1>
                        <p class="text-slate-500 text-xs md:text-base">Menampilkan
                            <span id="product-counter"
                                class="font-bold text-orange-600">{{ count($daftarProduk) }}</span> paket perjalanan
                            ibadah tersedia.
                        </p>
                    @endif

                </div>

                {{-- DROPDOWN SORTING --}}
                <div class="hidden md:block relative w-48 group">
                    <select id="sort-select"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm font-bold rounded-xl px-4 py-3 appearance-none focus:outline-none focus:border-orange-500 focus:bg-white focus:shadow-[0_0_0_3px_rgba(234,88,12,0.1)] cursor-pointer hover:bg-slate-100 transition-all duration-300">
                        <option value="default">Pilihan Terbaik</option>
                        <option value="price_asc">Harga Terendah</option>
                        <option value="price_desc">Harga Tertinggi</option>
                        <option value="name_asc">Nama Paket (A - Z)</option>
                        <option value="name_desc">Nama Paket (Z - A)</option>
                    </select>
                    <i
                        class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none group-hover:text-orange-500 transition-colors duration-300"></i>
                </div>
            </div>
        </div>
    </header>

    <main class="py-6 lg:py-10 bg-slate-50 min-h-screen" id="produk">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                {{-- SIDEBAR DESKTOP --}}
                <aside
                    class="hidden lg:block lg:col-span-1 space-y-7 sticky top-28 h-fit bg-white p-6 rounded-2xl border border-slate-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)]">

                    {{-- HEADER FILTER & RESET --}}
                    <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                        <h2 class="font-extrabold text-slate-900 text-lg">Filter</h2>
                        <button onclick="resetAllFilters()"
                            class="group flex items-center gap-1.5 text-xs font-bold text-slate-400 hover:text-orange-600 transition-colors">
                            <i
                                class="ph-bold ph-arrows-counter-clockwise transition-transform duration-500 group-hover:-rotate-180"></i>
                            Reset
                        </button>
                    </div>

                    {{-- SEARCH BAR --}}
                    <div class="relative group">
                        <i
                            class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-orange-500 transition-colors duration-300"></i>
                        <input type="text" id="search-input" placeholder="Cari nama paket..."
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-orange-500 focus:bg-white focus:shadow-[0_0_0_3px_rgba(234,88,12,0.1)] transition-all duration-300">
                    </div>

                    {{-- HYBRID RENCANA WAKTU (BULAN vs TANGGAL) --}}
                    <div class="pt-6 border-t border-slate-100 relative">
                        <h3 class="font-bold text-slate-900 mb-3 text-xs uppercase tracking-wider">Rencana Waktu</h3>

                        {{-- Logic PHP nge-generate 12 Bulan Kedepan otomatis --}}
                        @php
                            $months = [];
                            for ($i = 0; $i < 12; $i++) {
                                $date = \Carbon\Carbon::now()->addMonths($i);
                                $months[] = [
                                    'value' => $date->format('Y-m'),
                                    'label' => $date->translatedFormat('F Y'),
                                ];
                            }
                        @endphp

                        <div
                            class="flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl hover:bg-slate-100 transition-colors group cursor-pointer focus-within:border-orange-500 focus-within:bg-white focus-within:shadow-[0_0_0_3px_rgba(234,88,12,0.1)]">
                            <i
                                class="ph-duotone ph-calendar-blank text-xl text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>

                            {{-- Element Dropdown Bulan --}}
                            <div class="relative w-full">
                                <select id="input-month"
                                    class="w-full bg-transparent border-none p-0 text-slate-800 font-bold text-sm focus:ring-0 cursor-pointer truncate pr-4 outline-none appearance-none">
                                    <option value="" selected>Semua Waktu</option>
                                    @foreach ($months as $month)
                                        <option value="{{ $month['value'] }}">{{ $month['label'] }}</option>
                                    @endforeach
                                    <option value="specific" class="font-black text-orange-600">Pilih Tanggal Pasti...
                                    </option>
                                </select>
                                <i id="month-icon"
                                    class="ph-bold ph-caret-down absolute right-0 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none group-focus-within:text-orange-500 transition"></i>
                            </div>

                            {{-- Element Flatpickr (Awalnya disembunyiin) --}}
                            <div id="date-wrapper" class="hidden w-full items-center justify-between">
                                <input type="text" id="input-date" placeholder="Pilih Tanggal..."
                                    class="w-full bg-transparent border-none p-0 text-orange-600 font-bold text-sm focus:ring-0 cursor-pointer placeholder-slate-400 outline-none">
                                <button type="button" id="btn-clear-date"
                                    class="text-slate-300 hover:text-red-500 pl-2 transition-colors flex-shrink-0"
                                    title="Batal Pilih Tanggal">
                                    <i class="ph-bold ph-x-circle text-lg"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- KATEGORI HARGA (RADIO) --}}
                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-3 text-xs uppercase tracking-wider">Kategori Harga</h3>
                        <div class="grid grid-cols-1 gap-2.5">

                            <label
                                class="cursor-pointer group relative block active:scale-[0.98] transition-transform duration-200">
                                <input type="radio" name="price_category" value="hemat"
                                    class="hidden peer category-radio">
                                <div
                                    class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-white hover:border-orange-300 hover:shadow-sm peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:shadow-[0_0_0_1px_rgba(234,88,12,1)] transition-all duration-300">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 peer-checked:bg-orange-100 peer-checked:text-orange-600 flex items-center justify-center transition-colors duration-300">
                                        <i class="ph-bold ph-tag text-xl"></i>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-bold text-slate-800 peer-checked:text-orange-700 transition-colors">
                                            Paket Hemat</p>
                                        <p class="text-xs text-slate-500 font-medium">&lt; Rp 28 Juta</p>
                                    </div>
                                </div>
                            </label>

                            <label
                                class="cursor-pointer group relative block active:scale-[0.98] transition-transform duration-200">
                                <input type="radio" name="price_category" value="standar"
                                    class="hidden peer category-radio">
                                <div
                                    class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-white hover:border-orange-300 hover:shadow-sm peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:shadow-[0_0_0_1px_rgba(234,88,12,1)] transition-all duration-300">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 peer-checked:bg-orange-100 peer-checked:text-orange-600 flex items-center justify-center transition-colors duration-300">
                                        <i class="ph-bold ph-check-circle text-xl"></i>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-bold text-slate-800 peer-checked:text-orange-700 transition-colors">
                                            Paket Standar</p>
                                        <p class="text-xs text-slate-500 font-medium">Rp 28 - 35 Juta</p>
                                    </div>
                                </div>
                            </label>

                            <label
                                class="cursor-pointer group relative block active:scale-[0.98] transition-transform duration-200">
                                <input type="radio" name="price_category" value="vip"
                                    class="hidden peer category-radio">
                                <div
                                    class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-white hover:border-orange-300 hover:shadow-sm peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:shadow-[0_0_0_1px_rgba(234,88,12,1)] transition-all duration-300">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 peer-checked:bg-orange-100 peer-checked:text-orange-600 flex items-center justify-center transition-colors duration-300">
                                        <i class="ph-bold ph-crown text-xl"></i>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-bold text-slate-800 peer-checked:text-orange-700 transition-colors">
                                            Paket VIP</p>
                                        <p class="text-xs text-slate-500 font-medium">&gt; Rp 35 Juta</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- RENTANG HARGA SLIDER --}}
                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-4 text-xs uppercase tracking-wider">Rentang Harga (Rp)
                        </h3>
                        <div class="mb-5 px-1">
                            <input type="range" id="price-range" min="20000000" max="100000000" step="1000000"
                                class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-orange-600 hover:accent-orange-700 transition-all">
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="relative w-full group">
                                <input type="number" id="price-min" placeholder="Min"
                                    class="w-full pl-3 pr-2 py-2.5 text-sm font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:shadow-[0_0_0_3px_rgba(234,88,12,0.1)] transition-all duration-300">
                            </div>
                            <div class="w-3 h-0.5 bg-slate-300 rounded-full flex-shrink-0"></div>
                            <div class="relative w-full group">
                                <input type="number" id="price-max" placeholder="Max"
                                    class="w-full pl-3 pr-2 py-2.5 text-sm font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white focus:shadow-[0_0_0_3px_rgba(234,88,12,0.1)] transition-all duration-300">
                            </div>
                        </div>
                    </div>

                    {{-- JENIS PAKET (KATEGORI API) --}}
                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-3 text-xs uppercase tracking-wider">Jenis Paket</h3>
                        <div class="space-y-1">
                            @foreach ($daftarKategori as $kategori)
                                <label
                                    class="flex items-center gap-3 p-2 -ml-2 cursor-pointer group rounded-lg hover:bg-slate-50 active:scale-[0.98] transition-all duration-200">
                                    <div class="relative flex items-center justify-center">

                                        {{-- PERBAIKAN DI SINI: Ditambahin (string) dan ?? '' biar stripos gak crash --}}
                                        <input type="checkbox" class="peer hidden filter-category"
                                            value="{{ $kategori['id'] }}"
                                            @if (
                                                !empty($kategoriFilter) &&
                                                    stripos((string) ($kategori['name'] ?? ($kategori['nama_kategori'] ?? '')), $kategoriFilter) !== false) checked @endif>

                                        {{-- Kotak Luar Checkbox --}}
                                        <div
                                            class="w-5 h-5 rounded-[4px] border-2 border-slate-300 bg-white peer-checked:bg-orange-600 peer-checked:border-orange-600 transition-all duration-200 group-hover:border-orange-400">
                                        </div>

                                        {{-- Logo Centang (SVG) --}}
                                        <svg class="absolute w-3 h-3 text-white opacity-0 scale-50 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300 pointer-events-none"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span
                                        class="text-sm text-slate-600 font-semibold group-hover:text-slate-900 transition-colors">
                                        {{ $kategori['name'] ?? ($kategori['nama_kategori'] ?? 'Kategori') }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </aside>

                {{-- AREA PRODUK --}}
                <div class="lg:col-span-3">

                    {{-- PESAN KOSONG (Disembunyikan default) --}}
                    <div id="empty-state"
                        class="hidden text-center py-20 bg-white rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] transition-all">
                        <div
                            class="w-20 h-20 mx-auto bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                            <i class="ph-duotone ph-magnifying-glass text-4xl text-slate-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Paket Tidak Ditemukan</h3>
                        <p class="text-sm text-slate-500 mt-2 mb-6 max-w-sm mx-auto">Maaf, kami tidak dapat menemukan
                            paket yang sesuai dengan kriteria filter Anda.</p>
                        <button onclick="resetAllFilters()"
                            class="px-8 py-3 bg-orange-50 text-orange-600 font-bold rounded-full hover:bg-orange-600 hover:text-white transition-colors duration-300 shadow-sm">Reset
                            Filter</button>
                    </div>

                    {{-- GRID PRODUK --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 min-h-[600px] content-start"
                        id="product-container">
                        @forelse($daftarProduk as $produk)
                            @php
                                $hargaAsli = $produk['prices'][0]['harga'] ?? ($produk['prices'][0]['price'] ?? 0);
                            @endphp

                            <div class="product-card group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col h-full hover:-translate-y-1"
                                data-id="{{ $produk['id'] }}" {{-- KUNCI UTAMANYA ADA DI SINI BRO --}}
                                data-category="{{ $produk['category_id'] }}"
                                data-kota="{{ strtolower($produk['tmp_keberangkatan'] ?? '') }}"
                                data-tanggal="{{ \Carbon\Carbon::parse($produk['tgl_keberangkatan'])->format('Y-m-d') }}"
                                data-harga="{{ $hargaAsli }}"
                                data-nama="{{ strtolower($produk['nama_produk'] ?? '') }}">

                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                                    <img src="https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/{{ rawurlencode($produk['thumbnail_url']) }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out"
                                        alt="{{ $produk['nama_produk'] }}"
                                        onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ str_replace(' ', '+', $produk['nama_produk']) }}&background=F97316&color=fff';">

                                    <div class="absolute top-3 right-3 z-10 flex gap-2">
                                        {{-- Tombol Bandingkan --}}
                                        <button onclick="addToCompare(this)"
                                            class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-teal-500 hover:text-white transition-colors border border-white/30 group/btn"
                                            title="Bandingkan">
                                            <i
                                                class="ph-bold ph-arrows-left-right text-lg transform group-hover/btn:rotate-180 transition-transform duration-500"></i>
                                        </button>

                                        {{-- 👇 PERBAIKAN TOMBOL WISHLIST 👇 --}}
                                        @php
                                            // Cek apakah ID produk ini ada di dalam array $wishlistIds (dikirim dari Controller)
                                            // Kalau user belum login atau array kosong, defaultnya false
                                            $isWishlisted = in_array($produk['id'], $wishlistIds ?? []);
                                        @endphp

                                        <button onclick="toggleWishlist(this, '{{ $produk['id'] }}')"
                                            class="wishlist-btn w-8 h-8 rounded-full backdrop-blur-md flex items-center justify-center transition-colors border group/wishlist 
                                            {{ $isWishlisted ? 'bg-white text-red-500 border-red-500' : 'bg-white/20 text-white hover:bg-white hover:text-red-500 border-white/30' }}"
                                            title="Simpan ke Wishlist">
                                            <i
                                                class="ph-fill ph-heart text-lg pointer-events-none transition-transform group-active/wishlist:scale-75"></i>
                                        </button>
                                    </div>

                                </div>

                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="min-h-[3.5rem]">
                                        <h3
                                            class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition-colors line-clamp-2 leading-tight">
                                            {{ $produk['nama_produk'] }}
                                        </h3>
                                    </div>

                                    <div class="flex-grow space-y-3 mb-6 mt-2">
                                        @if (!empty($produk['hotels'][0]))
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-7 h-7 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="ph-duotone ph-buildings text-orange-500 text-sm"></i>
                                                </div>
                                                <p class="text-sm font-semibold text-slate-600 truncate">
                                                    {{ $produk['hotels'][0]['city'] ?? 'Kota' }}:
                                                    {{ $produk['hotels'][0]['name'] ?? 'Hotel' }}
                                                    ⭐{{ $produk['hotels'][0]['rating'] ?? '5' }}
                                                </p>
                                            </div>
                                        @endif

                                        @if (!empty($produk['hotels'][1]))
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-7 h-7 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="ph-duotone ph-buildings text-orange-500 text-sm"></i>
                                                </div>
                                                <p class="text-sm font-semibold text-slate-600 truncate">
                                                    {{ $produk['hotels'][1]['city'] ?? 'Kota' }}:
                                                    {{ $produk['hotels'][1]['name'] ?? 'Hotel' }}
                                                    ⭐{{ $produk['hotels'][1]['rating'] ?? '5' }}
                                                </p>
                                            </div>
                                        @endif

                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
                                                <i class="ph-duotone ph-airplane-tilt text-blue-500 text-sm"></i>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-600 truncate">
                                                {{ $produk['flights'][0]['airline_name'] ?? 'Maskapai' }}
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-7 h-7 rounded-full bg-green-50 flex items-center justify-center flex-shrink-0">
                                                <i class="ph-duotone ph-calendar-blank text-green-500 text-sm"></i>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-600">
                                                {{ \Carbon\Carbon::parse($produk['tgl_keberangkatan'])->translatedFormat('d M Y') }}
                                            </p>
                                        </div>

                                       <div class="pt-3">
                                            @php
                                                // 1. Ambil data quota asli dari API
                                                $kuota = intval($produk['quota'] ?? 0);
                                                
                                                // 2. Logika Progress Bar Pintar (Samain kayak Wishlist)
                                                // Asumsi: 45 (bus) atau 100 (pesawat) adalah kapasitas wajar.
                                                $maxSeat = ($kuota > 45) ? 100 : 45; 
                                                
                                                $persenSeat = $maxSeat > 0 ? round(($kuota / $maxSeat) * 100) : 0;
                                                
                                                // Cegah bar lebih dari 100%
                                                if ($persenSeat > 100) $persenSeat = 100;
                                            @endphp

                                            <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                                <span class="text-slate-500 uppercase tracking-tighter">Seat Tersisa</span>
                                                <span class="text-[#ff782e] font-black">{{ $kuota }} Seat</span>
                                            </div>
                                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                                {{-- Pakai variabel $persenSeat dan kasih min-width 5% biar aman kalau 0 --}}
                                                <div class="progress-orange-animated h-full rounded-full transition-all duration-700"
                                                    style="width: {{ $persenSeat }}%; min-width: 5%;"></div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div
                                        class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">
                                                Mulai Dari</p>
                                            <p class="text-xl font-black text-slate-900">
                                                @if ($hargaAsli > 0)
                                                    Rp {{ number_format($hargaAsli / 1000000, 1, ',', '.') }} <span
                                                        class="text-sm text-slate-500 font-bold">Jt</span>
                                                @else
                                                    <span class="text-sm">Hubungi Kami</span>
                                                @endif
                                            </p>
                                        </div>
                                        <a href="{{ route('marketplace.produk.detail', $produk['id']) }}"
                                            class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition-colors shadow-md hover:shadow-orange-500/30">
                                            <i class="ph-bold ph-arrow-right text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">Belum ada paket produk dari API.</div>
                        @endforelse
                    </div>

                    {{-- PAGINATION CONTAINER --}}
                    <div class="mt-14 flex justify-center gap-2" id="pagination-container">
                        {{-- Diisi Otomatis oleh JS --}}
                    </div>

                </div>

            </div>
        </div>
    </main>

    {{-- TOMBOL MOBILE FILTER --}}
    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-full max-w-xs px-4 lg:hidden z-40">
        <button onclick="toggleMobileFilter()"
            class="w-full bg-slate-900/90 backdrop-blur-md text-white py-3.5 rounded-full font-bold shadow-2xl flex items-center justify-center gap-2 active:scale-95 transition border border-white/20">
            <i class="ph-bold ph-sliders-horizontal text-lg"></i>
            <span>Filter & Urutkan</span>
        </button>
    </div>

    {{-- MODAL MOBILE FILTER --}}
    <div id="mobile-filter" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="toggleMobileFilter()">
        </div>
        <div class="absolute bottom-0 left-0 w-full bg-white rounded-t-3xl p-6 h-[85vh] overflow-y-auto transform transition-transform duration-300 translate-y-full flex flex-col shadow-2xl"
            id="mobile-filter-content">
            <div class="flex justify-between items-center mb-6 flex-shrink-0">
                <h3 class="text-xl font-bold text-slate-900">Filter Produk</h3>
                <button onclick="toggleMobileFilter()"
                    class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors active:scale-90">
                    <i class="ph-bold ph-x"></i>
                </button>
            </div>

            <div class="space-y-8 pb-24 overflow-y-auto flex-grow">
                {{-- OPSI PENGURUTAN MOBILE --}}
                <div>
                    <h4 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wide">Urutkan</h4>
                    <select id="sort-select-mobile"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm font-bold rounded-xl px-4 py-3 appearance-none focus:outline-none focus:border-orange-500 cursor-pointer">
                        <option value="default">Pilihan Terbaik</option>
                        <option value="price_asc">Harga Terendah</option>
                        <option value="price_desc">Harga Tertinggi</option>
                        <option value="name_asc">Nama Paket (A - Z)</option>
                        <option value="name_desc">Nama Paket (Z - A)</option>
                    </select>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wide">Kategori Paket</h4>
                    <div class="space-y-1">
                        @foreach ($daftarKategori as $kategori)
                            <label
                                class="flex items-center gap-3 p-2 -ml-2 cursor-pointer group rounded-lg hover:bg-slate-50 active:scale-[0.98] transition-all duration-200">
                                <div class="relative flex items-center justify-center">

                                    {{-- PERBAIKAN DI SINI: Ditambahin (string) dan ?? '' biar stripos gak crash --}}
                                    <input type="checkbox" class="peer hidden filter-category"
                                        value="{{ $kategori['id'] }}"
                                        @if (
                                            !empty($kategoriFilter) &&
                                                stripos((string) ($kategori['name'] ?? ($kategori['nama_kategori'] ?? '')), $kategoriFilter) !== false) checked @endif>

                                    {{-- Kotak Luar Checkbox --}}
                                    <div
                                        class="w-5 h-5 rounded-[4px] border-2 border-slate-300 bg-white peer-checked:bg-orange-600 peer-checked:border-orange-600 transition-all duration-200 group-hover:border-orange-400">
                                    </div>

                                    {{-- Logo Centang (SVG) --}}
                                    <svg class="absolute w-3 h-3 text-white opacity-0 scale-50 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300 pointer-events-none"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-semibold group-hover:text-slate-900 transition-colors">
                                    {{ $kategori['name'] ?? ($kategori['nama_kategori'] ?? 'Kategori') }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex-shrink-0 flex gap-3">
                <button onclick="resetAllFilters(); toggleMobileFilter();"
                    class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3.5 rounded-xl font-bold transition-colors active:scale-95">
                    Reset
                </button>
                <button onclick="toggleMobileFilter()"
                    class="flex-1 bg-orange-600 hover:bg-orange-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition-all active:scale-95">
                    Terapkan
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPTS KHUSUS HALAMAN KATALOG --}}
    <script>
        const ITEMS_PER_PAGE = 9;
        let currentPage = 1;
        let filteredCardsArray = [];

        const searchInput = document.getElementById('search-input');
        const radios = document.querySelectorAll('.category-radio');
        const minInput = document.getElementById('price-min');
        const maxInput = document.getElementById('price-max');
        const rangeInput = document.getElementById('price-range');
        const categoryCheckboxes = document.querySelectorAll('.filter-category, .filter-category-mobile');

        // Element Bulan & Tanggal Baru
        const inputMonth = document.getElementById('input-month');
        const dateWrapper = document.getElementById('date-wrapper');
        const monthIcon = document.getElementById('month-icon');
        const btnClearDate = document.getElementById('btn-clear-date');

        const sortSelect = document.getElementById('sort-select');
        const sortSelectMobile = document.getElementById('sort-select-mobile');

        const productCards = document.querySelectorAll('.product-card');
        const counterElement = document.getElementById('product-counter');
        const emptyState = document.getElementById('empty-state');
        const paginationContainer = document.getElementById('pagination-container');

        const priceMap = {
            'hemat': {
                min: 0,
                max: 28000000
            },
            'standar': {
                min: 28000000,
                max: 35000000
            },
            'vip': {
                min: 35000000,
                max: 999999999
            }
        };

        let datePicker; // Inisialisasi nanti

        document.addEventListener('DOMContentLoaded', function() {

            syncCompareState();

            // Inisialisasi Flatpickr
            if (typeof flatpickr !== 'undefined') {
                datePicker = flatpickr("#input-date", {
                    locale: "id",
                    altInput: true,
                    altFormat: "j F Y",
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    disableMobile: "true",
                    theme: "airbnb",
                    onChange: function() {
                        applyAllFilters();
                    }
                });
            }

            // EVENT LISTENER TANGGAL / BULAN
            if (inputMonth) {
                inputMonth.addEventListener('change', function() {
                    if (this.value === 'specific') {
                        // Sembunyiin Dropdown Bulan, Tampilin Date Picker
                        this.classList.add('hidden');
                        if (monthIcon) monthIcon.classList.add('hidden');
                        if (dateWrapper) {
                            dateWrapper.classList.remove('hidden');
                            dateWrapper.classList.add('flex');
                        }
                        // Langsung buka kalendernya
                        if (datePicker) setTimeout(() => datePicker.open(), 50);
                    } else {
                        applyAllFilters();
                    }
                });
            }

            if (btnClearDate) {
                btnClearDate.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (datePicker) datePicker.clear();

                    // Sembunyiin Date Picker, Balikin Dropdown Bulan
                    if (dateWrapper) {
                        dateWrapper.classList.add('hidden');
                        dateWrapper.classList.remove('flex');
                    }
                    if (inputMonth) {
                        inputMonth.classList.remove('hidden');
                        inputMonth.value = "";
                    }
                    if (monthIcon) monthIcon.classList.remove('hidden');

                    applyAllFilters();
                });
            }

            // EVENT LISTENERS UNTUK FILTER & SORTING
            if (sortSelect) sortSelect.addEventListener('change', () => {
                if (sortSelectMobile) sortSelectMobile.value = sortSelect.value;
                applyAllFilters();
            });
            if (sortSelectMobile) sortSelectMobile.addEventListener('change', () => {
                if (sortSelect) sortSelect.value = sortSelectMobile.value;
                applyAllFilters();
            });

            radios.forEach(radio => {
                radio.addEventListener('change', function() {
                    const prices = priceMap[this.value];
                    if (prices) {
                        if (minInput) minInput.value = prices.min;
                        if (maxInput) maxInput.value = prices.max < 999999999 ? prices.max : '';
                        if (rangeInput) rangeInput.value = prices.max < 999999999 ? prices.max :
                            rangeInput.max;
                        applyAllFilters();
                    }
                });
            });

            if (minInput) minInput.addEventListener('input', () => {
                uncheckRadios();
                applyAllFilters();
            });
            if (maxInput) maxInput.addEventListener('input', () => {
                uncheckRadios();
                applyAllFilters();
            });
            if (rangeInput) {
                rangeInput.addEventListener('input', function() {
                    if (maxInput) maxInput.value = this.value;
                    uncheckRadios();
                    applyAllFilters();
                });
            }

            if (searchInput) searchInput.addEventListener('input', applyAllFilters);
            categoryCheckboxes.forEach(cb => cb.addEventListener('change', applyAllFilters));

            applyAllFilters();
        });

        function syncCompareState() {
            let currentList = getCompareList(); // Ambil dari localStorage

            // Cari semua kartu produk di halaman
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                const idProduk = card.getAttribute('data-id');
                // Cari tombol bandingkan di dalam kartu ini
                const compareBtn = card.querySelector('button[onclick="addToCompare(this)"]');

                if (compareBtn && currentList.includes(idProduk)) {
                    // Kalau ID-nya ada di localStorage, nyalain tombolnya!
                    compareBtn.classList.remove('bg-white/20');
                    compareBtn.classList.add('bg-teal-500', 'border-teal-500');
                }
            });
        }

        function uncheckRadios() {
            radios.forEach(radio => radio.checked = false);
        }

        window.resetAllFilters = function() {
            // CEK URL: Kalau ada parameter dari backend, bersihkan URL-nya dengan reload
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('mitra') || urlParams.has('kategori')) {
                window.location.href = window.location.pathname;
                return; // Stop JS disini karena halaman akan memuat ulang
            }

            // Kalau gak ada URL parameter, jalankan reset JS biasa
            if (searchInput) searchInput.value = '';
            uncheckRadios();
            if (minInput) minInput.value = '';
            if (maxInput) maxInput.value = '';
            if (rangeInput) rangeInput.value = rangeInput.min;
            categoryCheckboxes.forEach(cb => cb.checked = false);
            if (sortSelect) sortSelect.value = 'default';
            if (sortSelectMobile) sortSelectMobile.value = 'default';

            // Reset Tanggal
            if (datePicker) datePicker.clear();
            if (dateWrapper) {
                dateWrapper.classList.add('hidden');
                dateWrapper.classList.remove('flex');
            }
            if (inputMonth) {
                inputMonth.classList.remove('hidden');
                inputMonth.value = "";
            }
            if (monthIcon) monthIcon.classList.remove('hidden');

            applyAllFilters();
        };

        function applyAllFilters() {
            let query = searchInput ? searchInput.value.toLowerCase() : '';
            let min = minInput && minInput.value ? parseInt(minInput.value) : 0;
            let max = maxInput && maxInput.value ? parseInt(maxInput.value) : Infinity;

            let checkedCategories = Array.from(categoryCheckboxes)
                .filter(cb => cb.checked)
                .map(cb => cb.value);

            // Logika Tanggal Hybrid
            let monthVal = inputMonth ? inputMonth.value : '';
            let dateVal = document.getElementById('input-date') ? document.getElementById('input-date').value : '';
            let tglFilter = (monthVal === 'specific') ? dateVal : monthVal;

            filteredCardsArray = [];

            // 1. FILTERING
            productCards.forEach(card => {
                let isMatch = true;
                let namaPaket = (card.getAttribute('data-nama') || '').toLowerCase();
                let hargaPaket = parseInt(card.getAttribute('data-harga')) || 0;
                let kategoriPaket = card.getAttribute('data-category');
                let cardTanggal = card.getAttribute('data-tanggal') || '';

                if (query && !namaPaket.includes(query)) isMatch = false;
                if (hargaPaket < min || hargaPaket > max) isMatch = false;
                if (checkedCategories.length > 0 && !checkedCategories.includes(kategoriPaket)) isMatch = false;

                // Filter Waktu (Support cek exact date ATAU cek bulan aja)
                if (tglFilter !== '' && !cardTanggal.startsWith(tglFilter)) isMatch = false;

                card.style.display = 'none';

                if (isMatch) {
                    filteredCardsArray.push(card);
                }
            });

            // 2. SORTING
            let sortValue = sortSelect ? sortSelect.value : 'default';

            if (sortValue === 'price_asc') {
                filteredCardsArray.sort((a, b) => (parseInt(a.getAttribute('data-harga')) || 0) - (parseInt(b.getAttribute(
                    'data-harga')) || 0));
            } else if (sortValue === 'price_desc') {
                filteredCardsArray.sort((a, b) => (parseInt(b.getAttribute('data-harga')) || 0) - (parseInt(a.getAttribute(
                    'data-harga')) || 0));
            } else if (sortValue === 'name_asc') {
                filteredCardsArray.sort((a, b) => (a.getAttribute('data-nama') || '').localeCompare(b.getAttribute(
                    'data-nama') || ''));
            } else if (sortValue === 'name_desc') {
                filteredCardsArray.sort((a, b) => (b.getAttribute('data-nama') || '').localeCompare(a.getAttribute(
                    'data-nama') || ''));
            }

            // Apply visual order for CSS Grid
            filteredCardsArray.forEach((card, index) => {
                card.style.order = index;
            });

            if (counterElement) counterElement.innerText = filteredCardsArray.length;

            if (emptyState) {
                emptyState.style.display = filteredCardsArray.length === 0 ? 'block' : 'none';
            }

            currentPage = 1;
            renderPagination();
            displayCurrentPage();
        }

        function displayCurrentPage() {
            filteredCardsArray.forEach(card => card.style.display = 'none');

            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
            const endIndex = startIndex + ITEMS_PER_PAGE;
            const cardsToShow = filteredCardsArray.slice(startIndex, endIndex);

            cardsToShow.forEach(card => {
                card.style.display = 'flex';
                card.style.animation = 'none';
                card.offsetHeight;
                card.style.animation = null;
            });
        }

        function renderPagination() {
            if (!paginationContainer) return;

            const totalPages = Math.ceil(filteredCardsArray.length / ITEMS_PER_PAGE);
            paginationContainer.innerHTML = '';

            if (totalPages <= 1) {
                paginationContainer.style.display = 'none';
                return;
            } else {
                paginationContainer.style.display = 'flex';
            }

            const prevBtn = document.createElement('button');
            prevBtn.className =
                `w-10 h-10 rounded-xl border flex items-center justify-center transition-all duration-200 active:scale-95 ${currentPage === 1 ? 'border-slate-100 text-slate-300 cursor-not-allowed bg-slate-50' : 'border-slate-200 text-slate-600 hover:border-slate-400 hover:bg-slate-50 bg-white shadow-sm'}`;
            prevBtn.innerHTML = '<i class="ph-bold ph-caret-left"></i>';
            prevBtn.onclick = () => {
                if (currentPage > 1) {
                    currentPage--;
                    updateView();
                }
            };
            paginationContainer.appendChild(prevBtn);

            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('button');
                if (i === currentPage) {
                    pageBtn.className =
                        "w-10 h-10 rounded-xl bg-orange-600 text-white font-bold flex items-center justify-center shadow-[0_8px_20px_rgba(234,88,12,0.3)] transition-all duration-200";
                } else {
                    pageBtn.className =
                        "w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 shadow-sm active:scale-95";
                }
                pageBtn.innerText = i;
                pageBtn.onclick = () => {
                    currentPage = i;
                    updateView();
                };
                paginationContainer.appendChild(pageBtn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.className =
                `w-10 h-10 rounded-xl border flex items-center justify-center transition-all duration-200 active:scale-95 ${currentPage === totalPages ? 'border-slate-100 text-slate-300 cursor-not-allowed bg-slate-50' : 'border-slate-200 text-slate-600 hover:border-slate-400 hover:bg-slate-50 bg-white shadow-sm'}`;
            nextBtn.innerHTML = '<i class="ph-bold ph-caret-right"></i>';
            nextBtn.onclick = () => {
                if (currentPage < totalPages) {
                    currentPage++;
                    updateView();
                }
            };
            paginationContainer.appendChild(nextBtn);
        }

        function updateView() {
            displayCurrentPage();
            renderPagination();
            const productSection = document.getElementById('produk');
            if (productSection) {
                const offset = productSection.offsetTop - 100;
                window.scrollTo({
                    top: offset,
                    behavior: 'smooth'
                });
            }
        }

        window.toggleMobileFilter = function() {
            const modal = document.getElementById('mobile-filter');
            const content = document.getElementById('mobile-filter-content');

            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                setTimeout(() => content.classList.remove('translate-y-full'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                content.classList.add('translate-y-full');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 300);
            }
        }

        // --- FUNGSI PERBANDINGAN (COMPARE) DI HALAMAN KATALOG ---
        const MAX_COMPARE = 2;

        function getCompareList() {
            let compareList = localStorage.getItem('compareList');
            return compareList ? JSON.parse(compareList) : [];
        }

        function goToComparePage() {
            let currentList = getCompareList();
            if (currentList.length === 0) return;
            window.location.href = `/marketplace/bandingkan?ids=${currentList.join(',')}`;
        }

        function addToCompare(button) {
            if (window.event) window.event.stopPropagation();

            const card = button.closest('.product-card');
            if (!card) return;

            const idProduk = card.getAttribute('data-id');
            if (!idProduk) {
                console.error("data-id tidak ditemukan di HTML product-card!");
                return;
            }

            let currentList = getCompareList();

            if (currentList.includes(idProduk)) {
                // Hapus dari array
                currentList = currentList.filter(id => id !== idProduk);
                localStorage.setItem('compareList', JSON.stringify(currentList));

                // Kembalikan style tombol ke tidak aktif
                button.classList.add('bg-white/20', 'text-white');
                button.classList.remove('bg-teal-500', 'border-teal-500');

                Swal.fire({
                    icon: 'info',
                    title: 'Dihapus dari perbandingan',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
                return;
            }

            if (currentList.length >= MAX_COMPARE) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Batas Maksimal!',
                    text: 'Anda hanya bisa membandingkan maksimal 2 paket sekaligus.',
                    confirmButtonColor: '#ea580c',
                    confirmButtonText: 'Lihat Perbandingan',
                    showCancelButton: true,
                    cancelButtonText: 'Tutup'
                }).then((result) => {
                    if (result.isConfirmed) goToComparePage();
                });
                return;
            }

            // Tambah ke array
            currentList.push(idProduk);
            localStorage.setItem('compareList', JSON.stringify(currentList));

            // Ubah style tombol jadi aktif (Teal)
            button.classList.remove('bg-white/20');
            button.classList.add('bg-teal-500', 'border-teal-500');

            if (currentList.length === MAX_COMPARE) {
                Swal.fire({
                    icon: 'success',
                    title: 'Siap Dibandingkan!',
                    text: '2 Paket sudah dipilih. Ingin melihat perbandingannya sekarang?',
                    confirmButtonColor: '#14b8a6',
                    confirmButtonText: 'Ya, Bandingkan',
                    showCancelButton: true,
                    cancelButtonText: 'Pilih Lagi'
                }).then((result) => {
                    if (result.isConfirmed) goToComparePage();
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Ditambahkan ke perbandingan',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    </script>

    <script>
        // --- FUNGSI WISHLIST DINAMIS (AJAX) ---
        async function toggleWishlist(button, productId) {
            // Mencegah klik nyasar ke link detail produk kalau tombolnya ditindih
            if (window.event) window.event.stopPropagation();

            const icon = button.querySelector('i');

            // Simpan class asli buat jaga-jaga kalau gagal
            const originalIconClass = icon.className;
            const isWishlisted = button.classList.contains('bg-white'); // Cek apakah udah merah/aktif

            // 1. UI Loading State (Ganti icon heart jadi spinner loading)
            icon.className = 'ph-bold ph-spinner animate-spin text-lg pointer-events-none';
            button.disabled = true;

            try {
                // 👇 PERBAIKAN 1: PAKAI ROUTE LARAVEL BIAR GAK NYASAR 👇
                const response = await fetch('{{ route('marketplace.profil.wishlist.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        // Wajib bawa CSRF Token biar gak ditolak Laravel
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });

                const result = await response.json();

                // 3. Handle kalau belum Login (Session Habis / Gak Punya Token)
                if (response.status === 401 || result.message === 'Unauthenticated') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Harap Login',
                        text: 'Anda harus masuk ke akun untuk menyimpan paket impian.',
                        confirmButtonText: 'Login Sekarang',
                        confirmButtonColor: '#ea580c',
                        showCancelButton: true,
                        cancelButtonText: 'Batal'
                    }).then((res) => {
                        // 👇 PERBAIKAN 2: TYPO VARIABEL 'res' 👇
                        if (res.isConfirmed) window.location.href = '/login';
                    });
                    throw new Error('Unauthenticated');
                }

                if (!response.ok) throw new Error(result.message || 'Gagal menyimpan wishlist');

                // 4. Update UI Berdasarkan Hasil (Aktif / Non-aktif)
                if (result.action === 'added' || !isWishlisted) {
                    button.classList.remove('bg-white/20', 'text-white');
                    button.classList.add('bg-white', 'text-red-500', 'border-red-500');
                    showToast('success', 'Disimpan ke Wishlist!');
                } else {
                    button.classList.remove('bg-white', 'text-red-500', 'border-red-500');
                    button.classList.add('bg-white/20', 'text-white');
                    showToast('info', 'Dihapus dari Wishlist');
                }

                // Kembalikan Icon Heart
                icon.className =
                    'ph-fill ph-heart text-lg pointer-events-none transition-transform group-active/wishlist:scale-75';

            } catch (error) {
                // Kalau gagal/error, kembalikan tombol seperti semula
                button.disabled = false;
                icon.className = originalIconClass;

                if (error.message !== 'Unauthenticated') {
                    showToast('error', 'Terjadi kesalahan sistem.');
                    console.error('Wishlist Error:', error);
                }
            } finally {
                button.disabled = false;
            }
        }

        // Fungsi pembantu buat manggil Toast SweetAlert
        function showToast(iconType, message) {
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
    </script>

</x-layouts.products>
