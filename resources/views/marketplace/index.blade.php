<x-layouts.marketplace>

    <!-- HERO -->

    <section class="relative min-h-[90vh] flex items-center pt-32 pb-32 lg:pt-40 lg:pb-48 overflow-hidden" id="hero">
        <div class="absolute inset-0 z-0">
            <img src="/assets/img/marketplace/hero.png" alt="Makkah"
                class="w-full h-full object-cover scale-105 animate-pulse-slow">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/60 to-slate-900/90"></div>
        </div>

        <div
            class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center text-center">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6 drop-shadow-2xl"
                data-aos="fade-up">
                Langkah Mudah <br class="hidden md:block">
                <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-orange-200 via-white to-orange-200">Menuju
                    Baitullah</span>
            </h1>

            <p class="text-base md:text-xl text-slate-100/90 max-w-2xl mx-auto mb-10 font-medium leading-relaxed"
                data-aos="fade-up" data-aos-delay="100">
                Temukan paket Umroh & Haji terbaik dari travel berizin resmi. Tanpa rasa khawatir, fokus pada ibadah
                Anda.
            </p>

            <div class="w-full max-w-5xl" data-aos="fade-up" data-aos-delay="200">

                <div class="w-full max-w-5xl mx-auto mb-8 px-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="overflow-x-auto no-scrollbar py-2">
                        <div
                            class="flex flex-nowrap md:flex-wrap justify-start md:justify-center items-center gap-3 min-w-max px-2">
                           <div class="bg-black/40 backdrop-blur-md p-1.5 rounded-full flex gap-1.5 border border-white/10 shadow-lg overflow-x-auto no-scrollbar">
    <button onclick="filterKategori('all')" id="btn-kategori-all"
        class="kategori-btn active px-4 py-2 rounded-full text-xs md:text-sm font-bold text-white bg-orange-600 shadow-md transition-all duration-300 whitespace-nowrap hover:bg-orange-700">
        Semua
    </button>
    
    @foreach($daftarKategori as $kategori)
        <button onclick="filterKategori('{{ $kategori['id'] }}')" id="btn-kategori-{{ $kategori['id'] }}"
            class="kategori-btn px-4 py-2 rounded-full text-xs md:text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-300 whitespace-nowrap">
            {{ $kategori['name'] ?? ($kategori['nama_kategori'] ?? 'Kategori') }}
        </button>
    @endforeach
</div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white rounded-[2rem] p-3 shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/20 relative backdrop-blur-sm bg-opacity-95">
                    <form id="searchForm"
                        class="flex flex-col lg:flex-row divide-y lg:divide-y-0 lg:divide-x divide-slate-100 relative z-10"
                        onsubmit="handleSearch(event)">

                        <div
                            class="flex-1 px-4 py-3 hover:bg-orange-50/50 rounded-xl transition-colors group cursor-pointer text-left relative">
                            <label
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block group-hover:text-orange-500 transition-colors">Berangkat
                                Dari</label>
                            <div class="flex items-center gap-3">
                                <i
                                    class="ph-duotone ph-airplane-takeoff text-2xl text-slate-400 group-hover:text-orange-500 transition-colors"></i>
                            <div class="relative w-full">
    {{-- HAPUS tulisan 'required' biar user bebas nyari --}}
    <select id="input-departure" 
        class="w-full bg-transparent border-none p-0 text-slate-800 font-bold text-base focus:ring-0 cursor-pointer truncate pr-4 outline-none">
        <option value="" selected>Semua Kota</option>
        {{-- Value disamakan dengan data API (huruf kecil) --}}
        <option value="jakarta">Jakarta (CGK)</option>
        <option value="surabaya">Surabaya (SUB)</option>
        <option value="medan">Medan (KNO)</option>
        <option value="makassar">Makassar (UPG)</option>
        <option value="jeddah">Jeddah (Langsung)</option>
    </select>
    <i class="ph-bold ph-caret-down absolute right-0 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none group-hover:text-orange-500 transition"></i>
</div>
                            </div>
                        </div>

                        <div
                            class="flex-1 px-4 py-3 hover:bg-orange-50/50 rounded-xl transition-colors group cursor-pointer text-left relative">
                            <label
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block group-hover:text-orange-500 transition-colors">Rencana
                                Waktu</label>
                            <div class="flex items-center gap-3">
                                <i
                                    class="ph-duotone ph-calendar-blank text-2xl text-slate-400 group-hover:text-orange-500 transition-colors"></i>
                                <input type="text" id="input-date" required placeholder="Pilih Tanggal Keberangkatan"
                                    class="w-full bg-transparent border-none p-0 text-slate-800 font-bold text-base focus:ring-0 cursor-pointer placeholder-slate-400 outline-none">
                            </div>
                        </div>

                        <div
                            class="flex-1 px-4 py-3 hover:bg-orange-50/50 rounded-xl transition-colors group cursor-pointer text-left relative">
                            <label
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block group-hover:text-orange-500 transition-colors">Budget
                                Per Orang</label>
                            <div class="flex items-center gap-3">
                                <i
                                    class="ph-duotone ph-wallet text-2xl text-slate-400 group-hover:text-orange-500 transition-colors"></i>
                                <div class="relative w-full">
                                    <select id="input-budget"
                                        class="w-full bg-transparent border-none p-0 text-slate-800 font-bold text-base focus:ring-0 cursor-pointer appearance-none truncate pr-4 outline-none">
                                        <option value="all">Semua Harga</option>
                                        <option value="hemat">Hemat (< 28 Jt)</option>
                                        <option value="reguler">Reguler (28-35 Jt)</option>
                                        <option value="vip">VIP (> 35 Jt)</option>
                                    </select>
                                    <i
                                        class="ph-bold ph-caret-down absolute right-0 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none group-hover:text-orange-500 transition"></i>
                                </div>
                            </div>
                        </div>

                        <div class="p-2 lg:pl-4 flex items-center justify-center">
                            <button type="submit" id="btn-search"
                                class="w-full lg:w-auto h-full min-h-[56px] px-8 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-[1.5rem] shadow-lg shadow-orange-500/30 transition-all duration-300 transform hover:scale-[1.02] active:scale-95 flex items-center justify-center gap-2 group/btn">
                                <i class="ph-bold ph-magnifying-glass text-xl group-hover/btn:animate-pulse"></i>
                                <span class="lg:hidden">Cari Paket Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-8 flex flex-wrap justify-center gap-4 md:gap-8 text-white/90">
                    <div
                        class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full backdrop-blur-sm border border-white/5">
                        <i class="ph-fill ph-seal-check text-green-400 text-lg"></i>
                        <span class="text-xs md:text-sm font-semibold">Resmi Kemenag</span>
                    </div>
                    <div
                        class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full backdrop-blur-sm border border-white/5">
                        <i class="ph-fill ph-shield-check text-blue-400 text-lg"></i>
                        <span class="text-xs md:text-sm font-semibold">Transaksi Aman</span>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- BONUS -->
    <section class="md:pt-24 bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-12" data-aos="fade-up">

                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">

                    Daftar Sekarang, <span class="text-orange-600">Bonus Spesial</span> Menanti

                </h2>

            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-6">

                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 hover:border-emerald-200 transition-all duration-300 hover:-translate-y-2 cursor-default relative overflow-hidden"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div
                        class="relative w-16 h-16 mx-auto bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-inner">
                        <i class="ph-fill ph-syringe text-3xl"></i>
                    </div>
                    <div class="text-center relative z-10">
                        <h3
                            class="font-bold text-slate-900 text-lg mb-1 group-hover:text-emerald-600 transition-colors">
                            Free Vaksin</h3>
                        <p class="text-sm text-slate-500">Meningitis resmi bersertifikat</p>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 hover:border-blue-200 transition-all duration-300 hover:-translate-y-2 cursor-default relative overflow-hidden"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div
                        class="relative w-16 h-16 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-inner">
                        <i class="ph-fill ph-identification-card text-3xl"></i>
                    </div>
                    <div class="text-center relative z-10">
                        <h3 class="font-bold text-slate-900 text-lg mb-1 group-hover:text-blue-600 transition-colors">
                            Diskon
                            40%</h3>
                        <p class="text-sm text-slate-500">Biaya pembuatan Paspor</p>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-orange-500/10 hover:border-orange-200 transition-all duration-300 hover:-translate-y-2 cursor-default relative overflow-hidden"
                    data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-orange-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div
                        class="relative w-16 h-16 mx-auto bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-inner">
                        <i class="ph-fill ph-backpack text-3xl"></i>
                    </div>
                    <div class="text-center relative z-10">
                        <h3 class="font-bold text-slate-900 text-lg mb-1 group-hover:text-orange-600 transition-colors">
                            Free
                            Backpack</h3>
                        <p class="text-sm text-slate-500">Tas punggung premium</p>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-purple-500/10 hover:border-purple-200 transition-all duration-300 hover:-translate-y-2 cursor-default relative overflow-hidden"
                    data-aos="fade-up" data-aos-delay="400">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform duration-500">
                    </div>

                    <div
                        class="relative w-16 h-16 mx-auto bg-purple-50 rounded-2xl flex items-center justify-center text-purple-600 mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-inner">
                        <i class="ph-fill ph-gift text-3xl"></i>
                    </div>
                    <div class="text-center relative z-10">
                        <h3 class="font-bold text-slate-900 text-lg mb-1 group-hover:text-purple-600 transition-colors">
                            Free
                            Oleh-oleh</h3>
                        <p class="text-sm text-slate-500">Paket lengkap 30 pack</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- PRODUK -->

    <section class="py-16 md:py-24 bg-slate-50" id="produk">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6" data-aos="fade-down">
    <div class="text-center md:text-left w-full md:w-auto">
        <span class="text-orange-600 font-bold text-xs md:text-sm tracking-widest uppercase mb-2 block">
            Pilihan Terbaik
        </span>
        <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">
            Program Ibadah Unggulan
        </h2>
    </div>

   <div class="w-full md:w-auto overflow-x-auto no-scrollbar pb-2 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0">
    <div class="flex flex-nowrap md:flex-wrap justify-start md:justify-center gap-2 min-w-max bg-transparent md:bg-white md:p-1.5 md:rounded-full md:shadow-sm md:border md:border-slate-100">
        
        <!-- Tombol Statis untuk "Semua" -->
        <button onclick="filterKategori('all')" 
            class="filter-btn active px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-300 whitespace-nowrap border bg-orange-600 text-white border-transparent shadow-md hover:bg-orange-700"
            data-filter="all">Semua</button>

        <!-- Looping Tombol dari API Kategori -->
        @foreach($daftarKategori as $kategori)
            <button onclick="filterKategori('{{ $kategori['id'] }}')" 
                class="filter-btn px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 whitespace-nowrap border bg-white text-slate-600 border-slate-200 hover:bg-slate-100 md:bg-transparent md:border-transparent"
                data-filter="{{ $kategori['id'] }}">
                {{ $kategori['name'] ?? ($kategori['nama_kategori'] ?? 'Kategori') }}
            </button>
        @endforeach

      </div>
   </div>
</div>
            
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="product-grid">
        
       @forelse($daftarProduk as $produk)
            
            @php
                // Ambil harga asli buat filter (dalam bentuk angka full)
                $hargaAsli = $produk['prices'][0]['harga'] ?? ($produk['prices'][0]['price'] ?? 0);
            @endphp

            {{-- 2. TAMBAHIN DATA-KOTA, DATA-TANGGAL, DATA-HARGA DI DALAM DIV INI --}}
            <div class="product-card group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full"
                data-category="{{ $produk['category_id'] }}" 
                data-kota="{{ strtolower($produk['tmp_keberangkatan'] ?? '') }}"
                data-tanggal="{{ \Carbon\Carbon::parse($produk['tgl_keberangkatan'])->format('Y-m-d') }}"
                data-harga="{{ $hargaAsli }}"
                data-aos="fade-up">

                <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                    
                   <img src="https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/{{ rawurlencode($produk['thumbnail_url']) }}"
         class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
         alt="{{ $produk['nama_produk'] }}"
         onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ str_replace(' ', '+', $produk['nama_produk']) }}&background=F97316&color=fff';">

                    <div class="absolute top-3 right-3 z-10 flex gap-2">
                        <button onclick="addToCompare(this)"
                            class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-teal-600 hover:text-white transition border border-white/30 group/btn"
                            title="Bandingkan">
                            <i class="ph-bold ph-arrows-left-right text-lg transform group-hover/btn:rotate-180 transition-transform duration-500"></i>
                        </button>

                        <button
                            class="wishlist-btn w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-white hover:text-red-500 transition border border-white/30">
                            <i class="ph-fill ph-heart text-lg"></i>
                        </button>
                    </div>
                </div>

                <div class="p-5 flex flex-col flex-grow">
                    <div class="min-h-[3.5rem]">
                        <h3 class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                            {{ $produk['nama_produk'] }}
                        </h3>
                    </div>
                    
                    <div class="flex-grow space-y-3 mb-6">
                        {{-- Cek apakah ada data hotel pertama di array hotels --}}
                        @if(!empty($produk['hotels'][0]))
                        <div class="flex items-center gap-3">
                            <i class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                            <p class="text-sm font-semibold text-slate-600 truncate">
                                {{ $produk['hotels'][0]['city'] ?? 'Kota' }}: {{ $produk['hotels'][0]['name'] ?? 'Hotel' }} ⭐{{ $produk['hotels'][0]['rating'] ?? '5' }}
                            </p>
                        </div>
                        @endif
                        
                        {{-- Cek apakah ada data hotel kedua di array hotels --}}
                        @if(!empty($produk['hotels'][1]))
                        <div class="flex items-center gap-3">
                            <i class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                            <p class="text-sm font-semibold text-slate-600 truncate">
                                {{ $produk['hotels'][1]['city'] ?? 'Kota' }}: {{ $produk['hotels'][1]['name'] ?? 'Hotel' }} ⭐{{ $produk['hotels'][1]['rating'] ?? '5' }}
                            </p>
                        </div>
                        @endif

                        <div class="flex items-center gap-3">
                            <i class="ph-duotone ph-airplane-tilt text-blue-500 text-xl flex-shrink-0"></i>
                            {{-- Panggil kunci airline_name --}}
                            <p class="text-sm font-semibold text-slate-600 truncate">{{ $produk['flights'][0]['airline_name'] ?? 'Maskapai' }}</p>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <i class="ph-duotone ph-calendar-blank text-green-500 text-xl flex-shrink-0"></i>
                            <p class="text-sm font-semibold text-slate-600">{{ \Carbon\Carbon::parse($produk['tgl_keberangkatan'])->translatedFormat('d M Y') }}</p>
                        </div>
                        
                        <div class="pt-2">
                            <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                <span class="text-slate-500 uppercase tracking-tighter">Seat Tersisa</span>
                                <span class="text-[#ff782e] font-black">{{ $produk['quota'] }} Seat</span>
                            </div>

                            <div class="w-full bg-slate-200 h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                <div class="progress-orange-animated h-full rounded-full transition-all duration-700"
                                    style="width: {{ rand(30, 90) }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                        <div>
    <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">Mulai Dari</p>
    <p class="text-xl font-black text-slate-900">
        @php
            // Mencoba mengambil harga dari kunci 'harga' atau 'price'
            $hargaInput = $produk['prices'][0]['harga'] ?? ($produk['prices'][0]['price'] ?? 0);
        @endphp

        @if($hargaInput > 0)
            {{-- Jika harga jutaan, kita format jadi 25.9 Jt --}}
            Rp {{ number_format($hargaInput / 1000000, 1, ',', '.') }} <span class="text-sm">Jt</span>
        @else
            <span class="text-sm">Hubungi Kami</span>
        @endif
    </p>
</div>
                        {{-- Ganti URL ini nanti dengan halaman detail lu --}}
                        <a href="/marketplace/produk/{{ $produk['id'] }}" onclick="showDetail(event)"
                            class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30">
                            <i class="ph-bold ph-arrow-right text-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">Belum ada paket produk dari API.</div>
        @endforelse

       </div>

        </div>
            <div class="mt-12 text-center">
                <a href="{{ route('marketplace.produk.index') }}"
                    class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-slate-500 hover:text-orange-600 transition group px-6 py-3 rounded-full hover:bg-orange-50">
                    Lihat Seluruh Paket
                    <i class="ph-bold ph-arrow-right transform group-hover:translate-x-1 transition"></i>
                </a>
            </div>
        </div>
        
    </section>

    <div id="lightbox-modal"
        class="fixed inset-0 z-[60] bg-black/95 hidden flex items-center justify-center p-4 transition-opacity duration-300 opacity-0"
        onclick="closeLightbox()">
        <button class="absolute top-6 right-6 text-white hover:text-orange-500 transition">
            <i class="ph-bold ph-x text-4xl"></i>
        </button>
        <div class="relative max-w-5xl w-full max-h-screen">
            <img id="lightbox-image" src=""
                class="w-full h-auto max-h-[85vh] object-contain rounded-lg shadow-2xl transform scale-95 transition-transform duration-300"
                onclick="event.stopPropagation()">
            <div id="lightbox-caption" class="text-white text-center mt-4 font-medium text-lg"></div>
        </div>
    </div>

    <!-- MITRA -->

    <section class="py-16 bg-slate-50 relative overflow-hidden" id="mitra">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-40">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-orange-100 rounded-full blur-3xl mix-blend-multiply">
            </div>
            <div class="absolute top-1/2 right-0 w-72 h-72 bg-blue-100 rounded-full blur-3xl mix-blend-multiply"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16" data-aos="fade-up">
                <span
                    class="inline-block py-1 px-3 rounded-full bg-orange-100 text-orange-700 text-xs font-bold tracking-wider uppercase mb-3">Partner
                    Resmi</span>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">Mitra Travel Terpercaya
                </h2>
                <p class="text-slate-500 mt-4 max-w-2xl mx-auto text-lg leading-relaxed">
                    Kami hanya bekerjasama dengan penyelenggara Umroh & Haji yang telah terverifikasi dan memiliki izin
                    resmi PPIU dari Kementerian Agama RI.
                </p>
            </div>

            <div id="mitra-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

                <a href="{{ route('marketplace.produk.travel.haramainku-travel') }}"
                    class="group bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-orange-200 transition-all duration-300 cursor-pointer relative flex flex-col h-full"
                    data-aos="fade-up" data-aos-delay="100">

                    <div
                        class="h-28 flex items-center justify-center mb-6 p-4 bg-slate-50 rounded-xl group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100">
                        <img src="/assets/img/marketplace/travel/haramainku.png" alt="Logo"
                            class="max-h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500 opacity-70 group-hover:opacity-100">
                    </div>

                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-orange-600 transition-colors">
                            Haramain Tour
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">Cikeas, Gunung Putri, Bogor</p>
                    </div>

                    <div class="border-t border-slate-100 w-full my-auto"></div>

                    <div class="pt-4 flex justify-between items-center text-sm">
                        <div class="flex items-center gap-1.5">
                            <i class="ph-fill ph-star text-yellow-400 text-lg"></i>
                            <span class="font-bold text-slate-700">4.9</span>
                        </div>
                        <div class="text-slate-500 font-medium">
                            <span class="text-slate-900 font-bold">5k+</span> Jamaah
                        </div>
                    </div>
                </a>

                <div class="group bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-orange-200 transition-all duration-300 cursor-pointer relative flex flex-col h-full"
                    data-aos="fade-up" data-aos-delay="200">
                    <div
                        class="h-28 flex items-center justify-center mb-6 p-4 bg-slate-50 rounded-xl group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100">
                        <img src="/assets/img/marketplace/travel/elmarwa.png" alt="Logo"
                            class="max-h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500 opacity-70 group-hover:opacity-100">
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-orange-600 transition-colors">
                            Elmarwa Travel</h3>
                        <p class="text-xs text-slate-400 mt-1">Jagakarsa, Jakarta Selatan, Jakarta
                        </p>
                    </div>
                    <div class="border-t border-slate-100 w-full my-auto"></div>
                    <div class="pt-4 flex justify-between items-center text-sm">
                        <div class="flex items-center gap-1.5"><i
                                class="ph-fill ph-star text-yellow-400 text-lg"></i><span
                                class="font-bold text-slate-700">4.8</span></div>
                        <div class="text-slate-500 font-medium"><span class="text-slate-900 font-bold">2.5k+</span>
                            Jamaah</div>
                    </div>
                </div>

                <div class="group bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-orange-200 transition-all duration-300 cursor-pointer relative flex flex-col h-full"
                    data-aos="fade-up" data-aos-delay="300">
                    <div
                        class="h-28 flex items-center justify-center mb-6 p-4 bg-slate-50 rounded-xl group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100">
                        <img src="/assets/img/marketplace/travel/namira.png" alt="Logo"
                            class="max-h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500 opacity-70 group-hover:opacity-100">
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-orange-600 transition-colors">
                            Namira Travel</h3>
                        <p class="text-xs text-slate-400 mt-1">Kecamatan Laweyan, Surakarta, Jawa Tengah</p>
                    </div>
                    <div class="border-t border-slate-100 w-full my-auto"></div>
                    <div class="pt-4 flex justify-between items-center text-sm">
                        <div class="flex items-center gap-1.5"><i
                                class="ph-fill ph-star text-yellow-400 text-lg"></i><span
                                class="font-bold text-slate-700">4.7</span></div>
                        <div class="text-slate-500 font-medium"><span class="text-slate-900 font-bold">8k+</span> Jamaah
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-orange-200 transition-all duration-300 cursor-pointer relative flex flex-col h-full"
                    data-aos="fade-up" data-aos-delay="400">
                    <div
                        class="h-28 flex items-center justify-center mb-6 p-4 bg-slate-50 rounded-xl group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100">
                        <img src="/assets/img/marketplace/travel/uhud-tour.png" alt="Logo"
                            class="max-h-10 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500 opacity-70 group-hover:opacity-100">
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-orange-600 transition-colors">Uhud
                            Tour</h3>
                        <p class="text-xs text-slate-400 mt-1">Jl.Raya Condet No.50, Batu Ampar, Jakarta
                            Timur, Jakarta</p>
                    </div>
                    <div class="border-t border-slate-100 w-full my-auto"></div>
                    <div class="pt-4 flex justify-between items-center text-sm">
                        <div class="flex items-center gap-1.5"><i
                                class="ph-fill ph-star text-yellow-400 text-lg"></i><span
                                class="font-bold text-slate-700">5.0</span></div>
                        <div class="text-slate-500 font-medium"><span class="text-slate-900 font-bold">1k+</span> Jamaah
                        </div>
                    </div>
                </div>

                <div
                    class="group bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-orange-200 transition-all duration-300 cursor-pointer relative flex-col h-full">
                    <div
                        class="h-28 flex items-center justify-center mb-6 p-4 bg-slate-50 rounded-xl group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100">
                        <img src="/assets/img/marketplace/travel/arsy.png" alt="Logo"
                            class="max-h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500 opacity-70 group-hover:opacity-100">
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-orange-600 transition-colors">Arsy
                            Tour</h3>
                        <p class="text-xs text-slate-400 mt-1">Cilandak, Jakarta Selatan, Jakarta
                        </p>
                    </div>
                    <div class="border-t border-slate-100 w-full my-auto"></div>
                    <div class="pt-4 flex justify-between items-center text-sm">
                        <div class="flex items-center gap-1.5"><i
                                class="ph-fill ph-star text-yellow-400 text-lg"></i><span
                                class="font-bold text-slate-700">4.9</span></div>
                        <div class="text-slate-500 font-medium"><span class="text-slate-900 font-bold">1.2k+</span>
                            Jamaah</div>
                    </div>
                </div>

                <div
                    class="group bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-orange-200 transition-all duration-300 cursor-pointer relative flex-col h-full">
                    <div
                        class="h-28 flex items-center justify-center mb-6 p-4 bg-slate-50 rounded-xl group-hover:bg-white transition-colors border border-transparent group-hover:border-slate-100">
                        <img src="/assets/img/marketplace/travel/mutiara-sunnah.png" alt="Logo"
                            class="max-h-12 w-auto object-contain grayscale group-hover:grayscale-0 transition-all duration-500 opacity-70 group-hover:opacity-100">
                    </div>
                    <div class="text-center mb-4">
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-orange-600 transition-colors">
                            Mutiara Sunnah Travel</h3>
                        <p class="text-xs text-slate-400 mt-1">Jakasampurna, Bekasi Barat, Bekasi</p>
                    </div>
                    <div class="border-t border-slate-100 w-full my-auto"></div>
                    <div class="pt-4 flex justify-between items-center text-sm">
                        <div class="flex items-center gap-1.5"><i
                                class="ph-fill ph-star text-yellow-400 text-lg"></i><span
                                class="font-bold text-slate-700">4.9</span></div>
                        <div class="text-slate-500 font-medium"><span class="text-slate-900 font-bold">1.2k+</span>
                            Jamaah</div>
                    </div>
                </div>
            </div>

            <!-- <div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="500">
                <button id="toggle-mitra-btn"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 rounded-full text-slate-600 font-semibold hover:border-orange-500 hover:text-orange-600 hover:shadow-lg transition-all duration-300">
                    <span id="toggle-btn-text">Lihat Semua Mitra</span>
                    <i id="toggle-btn-icon" class="ph-bold ph-arrow-right"></i>
                </button>
            </div> -->

        </div>
    </section>

    <!-- KARIR -->

    <section class="py-16 px-4 bg-slate-50" id="karir">
        <div
            class="max-w-6xl mx-auto rounded-3xl bg-gradient-to-r from-orange-600 to-amber-500 overflow-hidden relative shadow-2xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full blur-3xl -ml-16 -mb-16"></div>
            <div
                class="relative z-10 flex flex-col md:flex-row items-center justify-between p-10 md:p-16 text-center md:text-left">
                <div class="mb-6 md:mb-0">
                    <h2 class="text-3xl font-bold text-white mb-2">Ingin berkarya bersama kami?</h2>
                    <p class="text-orange-50 text-lg">Bergabung dengan tim pengenumroh.com dan bantu jutaan orang
                        beribadah.
                    </p>
                </div>
                <a href="https://karir.pengenumroh.com/"
                    class="bg-white text-orange-600 hover:bg-slate-100 font-bold py-4 px-8 rounded-xl shadow-lg transition transform hover:scale-105">Lihat
                    Lowongan</a>
            </div>
        </div>
    </section>

</x-layouts.marketplace>
