<x-layouts.products>

    <header class="pt-28 pb-6 lg:pt-32 lg:pb-10 bg-white border-b border-slate-100" id="hero">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end gap-4 md:gap-6">
                <div class="w-full md:w-auto">
                    <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-2">Temukan Paket Impian</h1>
                    <p class="text-slate-500 text-xs md:text-base">Menampilkan
                        <span id="product-counter" class="font-bold text-orange-600">{{ count($daftarProduk) }}</span> paket perjalanan ibadah tersedia.
                    </p>
                </div>

                <div class="hidden md:block relative w-48 group">
                    <select class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm font-bold rounded-xl px-4 py-3 appearance-none focus:outline-none focus:border-orange-500 focus:bg-white focus:shadow-[0_0_0_3px_rgba(234,88,12,0.1)] cursor-pointer hover:bg-slate-100 transition-all duration-300">
                        <option>Paling Sesuai</option>
                        <option>Harga Terendah</option>
                        <option>Harga Tertinggi</option>
                        <option>Keberangkatan Terdekat</option>
                    </select>
                    <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none group-hover:text-orange-500 transition-colors duration-300"></i>
                </div>
            </div>
        </div>
    </header>

    <main class="py-6 lg:py-10 bg-slate-50 min-h-screen" id="produk">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                {{-- SIDEBAR DESKTOP --}}
                <aside class="hidden lg:block lg:col-span-1 space-y-7 sticky top-28 h-fit bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    
                    {{-- HEADER FILTER & RESET --}}
                    <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                        <h2 class="font-extrabold text-slate-900 text-lg">Filter</h2>
                        <button onclick="resetAllFilters()" class="group flex items-center gap-1.5 text-xs font-bold text-slate-400 hover:text-orange-600 transition-colors">
                            <i class="ph-bold ph-arrows-counter-clockwise transition-transform duration-500 group-hover:-rotate-180"></i>
                            Reset
                        </button>
                    </div>

                    {{-- SEARCH BAR --}}
                    <div class="relative group">
                        <i class="ph-bold ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg group-focus-within:text-orange-500 transition-colors duration-300"></i>
                        <input type="text" id="search-input" placeholder="Cari nama paket..."
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:border-orange-500 focus:bg-white focus:shadow-[0_0_0_3px_rgba(234,88,12,0.1)] transition-all duration-300">
                    </div>

                    {{-- KATEGORI HARGA (RADIO TANPA BULETAN) --}}
                    <div>
                        <h3 class="font-bold text-slate-900 mb-3 text-xs uppercase tracking-wider">Kategori Harga</h3>
                        <div class="grid grid-cols-1 gap-2.5">
                            
                            <label class="cursor-pointer group relative block active:scale-[0.98] transition-transform duration-200">
                                <input type="radio" name="price_category" value="hemat" class="hidden peer category-radio">
                                <div class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-white hover:border-orange-300 hover:shadow-sm peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:shadow-[0_0_0_1px_rgba(234,88,12,1)] transition-all duration-300">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 peer-checked:bg-orange-100 peer-checked:text-orange-600 flex items-center justify-center transition-colors duration-300">
                                        <i class="ph-bold ph-tag text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 peer-checked:text-orange-700 transition-colors">Paket Hemat</p>
                                        <p class="text-xs text-slate-500 font-medium">&lt; Rp 28 Juta</p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer group relative block active:scale-[0.98] transition-transform duration-200">
                                <input type="radio" name="price_category" value="standar" class="hidden peer category-radio">
                                <div class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-white hover:border-orange-300 hover:shadow-sm peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:shadow-[0_0_0_1px_rgba(234,88,12,1)] transition-all duration-300">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 peer-checked:bg-orange-100 peer-checked:text-orange-600 flex items-center justify-center transition-colors duration-300">
                                        <i class="ph-bold ph-check-circle text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 peer-checked:text-orange-700 transition-colors">Paket Standar</p>
                                        <p class="text-xs text-slate-500 font-medium">Rp 28 - 35 Juta</p>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer group relative block active:scale-[0.98] transition-transform duration-200">
                                <input type="radio" name="price_category" value="vip" class="hidden peer category-radio">
                                <div class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 bg-white hover:border-orange-300 hover:shadow-sm peer-checked:border-orange-500 peer-checked:bg-orange-50/50 peer-checked:shadow-[0_0_0_1px_rgba(234,88,12,1)] transition-all duration-300">
                                    <div class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 peer-checked:bg-orange-100 peer-checked:text-orange-600 flex items-center justify-center transition-colors duration-300">
                                        <i class="ph-bold ph-crown text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800 peer-checked:text-orange-700 transition-colors">Paket VIP</p>
                                        <p class="text-xs text-slate-500 font-medium">&gt; Rp 35 Juta</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- RENTANG HARGA --}}
                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-4 text-xs uppercase tracking-wider">Rentang Harga (Rp)</h3>
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
                                <label class="flex items-center gap-3 p-2 -ml-2 cursor-pointer group rounded-lg hover:bg-slate-50 active:scale-[0.98] transition-all duration-200">
                                    <div class="relative flex items-center justify-center">
                                        <input type="checkbox" class="peer hidden filter-category" value="{{ $kategori['id'] }}">
                                        {{-- Kotak Luar Checkbox --}}
                                        <div class="w-5 h-5 rounded-[4px] border-2 border-slate-300 bg-white peer-checked:bg-orange-600 peer-checked:border-orange-600 transition-all duration-200 group-hover:border-orange-400"></div>
                                        {{-- Logo Centang (SVG) --}}
                                        <svg class="absolute w-3 h-3 text-white opacity-0 scale-50 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <span class="text-sm text-slate-600 font-semibold group-hover:text-slate-900 transition-colors">
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
                    <div id="empty-state" class="hidden text-center py-20 bg-white rounded-2xl border border-slate-100 shadow-sm transition-all">
                        <div class="w-20 h-20 mx-auto bg-slate-50 rounded-full flex items-center justify-center mb-4 border border-slate-100">
                            <i class="ph-duotone ph-magnifying-glass text-4xl text-slate-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Paket Tidak Ditemukan</h3>
                        <p class="text-sm text-slate-500 mt-2 mb-6 max-w-sm mx-auto">Maaf, kami tidak dapat menemukan paket yang sesuai dengan kriteria filter Anda.</p>
                        <button onclick="resetAllFilters()" class="px-8 py-3 bg-orange-50 text-orange-600 font-bold rounded-full hover:bg-orange-600 hover:text-white transition-colors duration-300 shadow-sm">Reset Filter</button>
                    </div>

                    {{-- GRID PRODUK (Dikasih min-h biar gak loncat ke footer) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 min-h-[600px] content-start" id="product-container">
                        @forelse($daftarProduk as $produk)
                            @php
                                $hargaAsli = $produk['prices'][0]['harga'] ?? ($produk['prices'][0]['price'] ?? 0);
                            @endphp

                            <div class="product-card group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-[0_20px_40px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col h-full hover:-translate-y-1"
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
                                        <button onclick="addToCompare(this)" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-teal-500 hover:text-white transition-colors border border-white/30 group/btn" title="Bandingkan">
                                            <i class="ph-bold ph-arrows-left-right text-lg transform group-hover/btn:rotate-180 transition-transform duration-500"></i>
                                        </button>
                                        <button class="wishlist-btn w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-white hover:text-red-500 transition-colors border border-white/30">
                                            <i class="ph-fill ph-heart text-lg"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="min-h-[3.5rem]">
                                        <h3 class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition-colors line-clamp-2 leading-tight">
                                            {{ $produk['nama_produk'] }}
                                        </h3>
                                    </div>

                                    <div class="flex-grow space-y-3 mb-6 mt-2">
                                        @if (!empty($produk['hotels'][0]))
                                            <div class="flex items-center gap-3">
                                                <div class="w-7 h-7 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="ph-duotone ph-buildings text-orange-500 text-sm"></i>
                                                </div>
                                                <p class="text-sm font-semibold text-slate-600 truncate">
                                                    {{ $produk['hotels'][0]['city'] ?? 'Kota' }}: {{ $produk['hotels'][0]['name'] ?? 'Hotel' }} ⭐{{ $produk['hotels'][0]['rating'] ?? '5' }}
                                                </p>
                                            </div>
                                        @endif

                                        @if (!empty($produk['hotels'][1]))
                                            <div class="flex items-center gap-3">
                                                <div class="w-7 h-7 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0">
                                                    <i class="ph-duotone ph-buildings text-orange-500 text-sm"></i>
                                                </div>
                                                <p class="text-sm font-semibold text-slate-600 truncate">
                                                    {{ $produk['hotels'][1]['city'] ?? 'Kota' }}: {{ $produk['hotels'][1]['name'] ?? 'Hotel' }} ⭐{{ $produk['hotels'][1]['rating'] ?? '5' }}
                                                </p>
                                            </div>
                                        @endif

                                        <div class="flex items-center gap-3">
                                            <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0">
                                                <i class="ph-duotone ph-airplane-tilt text-blue-500 text-sm"></i>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-600 truncate">
                                                {{ $produk['flights'][0]['airline_name'] ?? 'Maskapai' }}
                                            </p>
                                        </div>

                                        <div class="flex items-center gap-3">
                                            <div class="w-7 h-7 rounded-full bg-green-50 flex items-center justify-center flex-shrink-0">
                                                <i class="ph-duotone ph-calendar-blank text-green-500 text-sm"></i>
                                            </div>
                                            <p class="text-sm font-semibold text-slate-600">
                                                {{ \Carbon\Carbon::parse($produk['tgl_keberangkatan'])->translatedFormat('d M Y') }}
                                            </p>
                                        </div>

                                        <div class="pt-3">
                                            <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                                <span class="text-slate-500 uppercase tracking-tighter">Seat Tersisa</span>
                                                <span class="text-[#ff782e] font-black">{{ $produk['quota'] }} Seat</span>
                                            </div>
                                            <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                                <div class="progress-orange-animated h-full rounded-full transition-all duration-700" style="width: {{ rand(30, 90) }}%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">Mulai Dari</p>
                                            <p class="text-xl font-black text-slate-900">
                                                @if ($hargaAsli > 0)
                                                    Rp {{ number_format($hargaAsli / 1000000, 1, ',', '.') }} <span class="text-sm text-slate-500 font-bold">Jt</span>
                                                @else
                                                    <span class="text-sm">Hubungi Kami</span>
                                                @endif
                                            </p>
                                        </div>
                                        <a href="/marketplace/produk/{{ $produk['id'] }}" class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition-colors shadow-md hover:shadow-orange-500/30">
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
        <button onclick="toggleMobileFilter()" class="w-full bg-slate-900/90 backdrop-blur-md text-white py-3.5 rounded-full font-bold shadow-2xl flex items-center justify-center gap-2 active:scale-95 transition border border-white/20">
            <i class="ph-bold ph-sliders-horizontal text-lg"></i>
            <span>Filter & Urutkan</span>
        </button>
    </div>

    {{-- MODAL MOBILE FILTER --}}
    <div id="mobile-filter" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="toggleMobileFilter()"></div>
        <div class="absolute bottom-0 left-0 w-full bg-white rounded-t-3xl p-6 h-[85vh] overflow-y-auto transform transition-transform duration-300 translate-y-full flex flex-col shadow-2xl" id="mobile-filter-content">
            <div class="flex justify-between items-center mb-6 flex-shrink-0">
                <h3 class="text-xl font-bold text-slate-900">Filter Produk</h3>
                <button onclick="toggleMobileFilter()" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors active:scale-90">
                    <i class="ph-bold ph-x"></i>
                </button>
            </div>

            <div class="space-y-8 pb-24 overflow-y-auto flex-grow">
                <div>
                    <h4 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wide">Kategori Paket</h4>
                    <div class="space-y-1">
                        @foreach ($daftarKategori as $kategori)
                            <label class="flex items-center gap-3 p-3 -ml-3 cursor-pointer group rounded-xl hover:bg-slate-50 active:scale-[0.98] transition-all">
                                <div class="relative flex items-center justify-center">
                                    <input type="checkbox" class="peer hidden filter-category-mobile" value="{{ $kategori['id'] }}">
                                    <div class="w-5 h-5 rounded-[4px] border-2 border-slate-300 bg-white peer-checked:bg-orange-600 peer-checked:border-orange-600 transition-all duration-200"></div>
                                    <svg class="absolute w-3 h-3 text-white opacity-0 scale-50 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-300 pointer-events-none" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-slate-700 group-hover:text-slate-900 transition-colors">{{ $kategori['name'] ?? ($kategori['nama_kategori'] ?? 'Kategori') }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex-shrink-0 flex gap-3">
                <button onclick="resetAllFilters(); toggleMobileFilter();" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 py-3.5 rounded-xl font-bold transition-colors active:scale-95">
                    Reset
                </button>
                <button onclick="toggleMobileFilter()" class="flex-1 bg-orange-600 hover:bg-orange-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/30 transition-all active:scale-95">
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
        
        const productCards = document.querySelectorAll('.product-card');
        const counterElement = document.getElementById('product-counter');
        const emptyState = document.getElementById('empty-state');
        const paginationContainer = document.getElementById('pagination-container');

        const priceMap = {
            'hemat': { min: 0, max: 28000000 },
            'standar': { min: 28000000, max: 35000000 },
            'vip': { min: 35000000, max: 999999999 } 
        };

        document.addEventListener('DOMContentLoaded', function () {
            
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const prices = priceMap[this.value];
                    if (prices) {
                        if(minInput) minInput.value = prices.min;
                        if(maxInput) maxInput.value = prices.max < 999999999 ? prices.max : '';
                        if(rangeInput) rangeInput.value = prices.max < 999999999 ? prices.max : rangeInput.max;
                        applyAllFilters();
                    }
                });
            });

            if(minInput) minInput.addEventListener('input', () => { uncheckRadios(); applyAllFilters(); });
            if(maxInput) maxInput.addEventListener('input', () => { uncheckRadios(); applyAllFilters(); });
            if(rangeInput) {
                rangeInput.addEventListener('input', function () {
                    if(maxInput) maxInput.value = this.value;
                    uncheckRadios();
                    applyAllFilters();
                });
            }

            if(searchInput) searchInput.addEventListener('input', applyAllFilters); 
            categoryCheckboxes.forEach(cb => cb.addEventListener('change', applyAllFilters)); 

            applyAllFilters();
        });

        function uncheckRadios() {
            radios.forEach(radio => radio.checked = false);
        }

        window.resetAllFilters = function() {
            if(searchInput) searchInput.value = '';
            uncheckRadios();
            if(minInput) minInput.value = '';
            if(maxInput) maxInput.value = '';
            if(rangeInput) rangeInput.value = rangeInput.min;
            categoryCheckboxes.forEach(cb => cb.checked = false);
            
            applyAllFilters();
        };

        function applyAllFilters() {
            let query = searchInput ? searchInput.value.toLowerCase() : '';
            let min = minInput && minInput.value ? parseInt(minInput.value) : 0;
            let max = maxInput && maxInput.value ? parseInt(maxInput.value) : Infinity;
            
            let checkedCategories = Array.from(categoryCheckboxes)
                                        .filter(cb => cb.checked)
                                        .map(cb => cb.value);

            filteredCardsArray = [];

            // PENTING: Jangan hide semua card di sini biar layout gak kempis ke footer
            productCards.forEach(card => {
                let isMatch = true;
                let namaPaket = (card.getAttribute('data-nama') || '').toLowerCase();
                let hargaPaket = parseInt(card.getAttribute('data-harga')) || 0;
                let kategoriPaket = card.getAttribute('data-category');

                if (query && !namaPaket.includes(query)) isMatch = false;
                if (hargaPaket < min || hargaPaket > max) isMatch = false;
                if (checkedCategories.length > 0 && !checkedCategories.includes(kategoriPaket)) isMatch = false;

                if (isMatch) {
                    filteredCardsArray.push(card);
                }
            });

            if(counterElement) counterElement.innerText = filteredCardsArray.length;

            if (emptyState) {
                emptyState.style.display = filteredCardsArray.length === 0 ? 'block' : 'none';
            }

            currentPage = 1;
            renderPagination();
            displayCurrentPage();
        }

        function displayCurrentPage() {
            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
            const endIndex = startIndex + ITEMS_PER_PAGE;
            const cardsToShow = filteredCardsArray.slice(startIndex, endIndex);

            productCards.forEach(card => {
                if (cardsToShow.includes(card)) {
                    card.style.display = 'flex';
                    // Animasi muncul mulus
                    card.style.animation = 'none';
                    card.offsetHeight; 
                    card.style.animation = null; 
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function renderPagination() {
            if(!paginationContainer) return;
            
            const totalPages = Math.ceil(filteredCardsArray.length / ITEMS_PER_PAGE);
            paginationContainer.innerHTML = ''; 

            if (totalPages <= 1) {
                paginationContainer.style.display = 'none';
                return;
            } else {
                paginationContainer.style.display = 'flex';
            }

            const prevBtn = document.createElement('button');
            prevBtn.className = `w-10 h-10 rounded-xl border flex items-center justify-center transition-all duration-200 active:scale-95 ${currentPage === 1 ? 'border-slate-100 text-slate-300 cursor-not-allowed bg-slate-50' : 'border-slate-200 text-slate-600 hover:border-slate-400 hover:bg-slate-50 bg-white shadow-sm'}`;
            prevBtn.innerHTML = '<i class="ph-bold ph-caret-left"></i>';
            prevBtn.onclick = () => {
                if(currentPage > 1) {
                    currentPage--;
                    updateView();
                }
            };
            paginationContainer.appendChild(prevBtn);

            for(let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('button');
                if (i === currentPage) {
                    pageBtn.className = "w-10 h-10 rounded-xl bg-orange-600 text-white font-bold flex items-center justify-center shadow-[0_8px_20px_rgba(234,88,12,0.3)] transition-all duration-200";
                } else {
                    pageBtn.className = "w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-600 font-bold flex items-center justify-center hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 shadow-sm active:scale-95";
                }
                pageBtn.innerText = i;
                pageBtn.onclick = () => {
                    currentPage = i;
                    updateView();
                };
                paginationContainer.appendChild(pageBtn);
            }

            const nextBtn = document.createElement('button');
            nextBtn.className = `w-10 h-10 rounded-xl border flex items-center justify-center transition-all duration-200 active:scale-95 ${currentPage === totalPages ? 'border-slate-100 text-slate-300 cursor-not-allowed bg-slate-50' : 'border-slate-200 text-slate-600 hover:border-slate-400 hover:bg-slate-50 bg-white shadow-sm'}`;
            nextBtn.innerHTML = '<i class="ph-bold ph-caret-right"></i>';
            nextBtn.onclick = () => {
                if(currentPage < totalPages) {
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
                window.scrollTo({ top: offset, behavior: 'smooth' });
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
    </script>
</x-layouts.products>