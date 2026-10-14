<x-layouts.marketplace>

    @php
    // CEK STATUS AKUN (Apakah dia Mitra Travel / Admin)
    $userData = session('user') ?? [];
    $idLevel = $userData['id_level'] ?? null;
    $userDataString = strtolower(json_encode($userData));

    $isTravelAccount = (
        in_array($idLevel, [1, 2, 4]) || 
        strpos($userDataString, '"id_level":4') !== false ||
        strpos($userDataString, '"id_level": 4') !== false ||
        strpos($userDataString, '"nama_level":"travel"') !== false
    );
    @endphp

    <!-- HERO -->
    <section class="relative min-h-[90vh] flex items-center pt-32 pb-32 lg:pt-40 lg:pb-48" id="hero">
        
        <!-- PERBAIKAN 1: overflow-hidden dipindah ke sini agar gambar tidak bocor, tapi form tetap bisa keluar -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="/assets/img/marketplace/hero.png" alt="Makkah"
                class="w-full h-full object-cover scale-105 animate-pulse-slow">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/80 via-slate-900/60 to-slate-900/90"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center justify-center text-center">
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight leading-tight mb-6 drop-shadow-2xl"
                data-aos="fade-up">
                Langkah Mudah <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-200 via-white to-orange-200">Menuju Baitullah</span>
            </h1>

            <p class="text-base md:text-xl text-slate-100/90 max-w-2xl mx-auto mb-10 font-medium leading-relaxed"
                data-aos="fade-up" data-aos-delay="100">
                Temukan paket Umroh & Haji terbaik dari travel berizin resmi. Tanpa rasa khawatir, fokus pada ibadah Anda.
            </p>

            <div class="w-full max-w-5xl" data-aos="fade-up" data-aos-delay="200">

                <div class="w-full max-w-5xl mx-auto mb-8 px-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="overflow-x-auto no-scrollbar py-2">
                        <div class="flex flex-nowrap md:flex-wrap justify-start md:justify-center items-center gap-3 min-w-max px-2">
                            <div class="bg-black/40 backdrop-blur-md p-1.5 rounded-full flex gap-1.5 border border-white/10 shadow-lg overflow-x-auto no-scrollbar">
                                <button onclick="filterKategori('all')" id="btn-kategori-all" class="kategori-btn active px-4 py-2 rounded-full text-xs md:text-sm font-bold text-white bg-orange-600 shadow-md transition-all duration-300 whitespace-nowrap hover:bg-orange-700">
                                    Semua
                                </button>
                                
                                @foreach($daftarKategori as $kategori)
                                    <button onclick="filterKategori('{{ $kategori['id'] }}')" id="btn-kategori-{{ $kategori['id'] }}" class="kategori-btn px-4 py-2 rounded-full text-xs md:text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-300 whitespace-nowrap">
                                        {{ $kategori['name'] ?? ($kategori['nama_kategori'] ?? 'Kategori') }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PERBAIKAN: Tambahkan z-[50] di class div ini agar dia menang dari konten di bawahnya -->
                <div class="bg-white rounded-[2rem] p-3 shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/20 relative z-[50] backdrop-blur-sm bg-opacity-95">
                    <form id="searchForm" class="flex flex-col lg:flex-row divide-y lg:divide-y-0 lg:divide-x divide-slate-200/60 relative z-[70]" onsubmit="handleSearch(event)">

                        {{-- KOTA KEBERANGKATAN --}}
                        <div class="flex-1 px-5 py-4 hover:bg-orange-50/40 transition-colors group cursor-pointer text-left relative custom-dropdown-container first:rounded-t-[2rem] lg:first:rounded-l-[2rem] lg:first:rounded-tr-none">
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1.5 block group-hover:text-orange-500 transition-colors">Berangkat Dari</label>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-orange-100 group-hover:scale-110 transition-all duration-300 flex-shrink-0">
                                    <i class="ph-duotone ph-airplane-takeoff text-2xl text-slate-500 group-hover:text-orange-600"></i>
                                </div>
                                
                                <div class="relative w-full dropdown-trigger" data-target="dropdown-departure">
                                    <button type="button" class="w-full bg-transparent border-none p-0 text-slate-800 font-bold text-base focus:ring-0 cursor-pointer text-left flex items-center justify-between outline-none">
                                        <span class="selected-text truncate text-lg">Semua Kota</span>
                                        <i class="ph-bold ph-caret-down text-slate-300 group-hover:text-orange-500 transition-transform duration-300 caret-icon flex-shrink-0"></i>
                                    </button>
                                    <input type="hidden" id="input-departure" value="">
                                </div>
                            </div>

                            <!-- Menu Dropdown Departure -->
                            <div id="dropdown-departure" class="absolute top-full left-0 mt-3 w-full lg:w-[110%] bg-white rounded-2xl shadow-[0_30px_60px_rgba(0,0,0,0.15)] border border-slate-100 opacity-0 invisible translate-y-4 transition-all duration-300 dropdown-menu z-[100] overflow-hidden">
                                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pilih Lokasi Keberangkatan</span>
                                </div>
                                <ul class="py-2 flex flex-col max-h-72 overflow-y-auto no-scrollbar">
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item active" data-value="" data-label="Semua Kota">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover/item:bg-orange-200 transition-colors">
                                                <i class="ph-duotone ph-map-pin text-slate-500 group-hover/item:text-orange-700"></i>
                                            </div>
                                            <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Semua Kota</span>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-100 transition-opacity check-icon"></i>
                                    </li>
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item" data-value="jakarta" data-label="Jakarta (CGK)">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover/item:bg-orange-200 transition-colors">
                                                <i class="ph-duotone ph-buildings text-slate-500 group-hover/item:text-orange-700"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Jakarta</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Soekarno-Hatta (CGK)</span>
                                            </div>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                    </li>
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item" data-value="surabaya" data-label="Surabaya (SUB)">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover/item:bg-orange-200 transition-colors">
                                                <i class="ph-duotone ph-bridge text-slate-500 group-hover/item:text-orange-700"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Surabaya</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Juanda (SUB)</span>
                                            </div>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                    </li>
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item" data-value="medan" data-label="Medan (KNO)">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover/item:bg-orange-200 transition-colors">
                                                <i class="ph-duotone ph-mosque text-slate-500 group-hover/item:text-orange-700"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Medan</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Kualanamu (KNO)</span>
                                            </div>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                    </li>
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item" data-value="makassar" data-label="Makassar (UPG)">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover/item:bg-orange-200 transition-colors">
                                                <i class="ph-duotone ph-anchor text-slate-500 group-hover/item:text-orange-700"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Makassar</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Sultan Hasanuddin (UPG)</span>
                                            </div>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                    </li>
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item" data-value="jeddah" data-label="Jeddah (Langsung)">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover/item:bg-orange-200 transition-colors">
                                                <i class="ph-duotone ph-star-and-crescent text-slate-500 group-hover/item:text-orange-700"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Jeddah</span>
                                                <span class="text-[10px] text-slate-400 font-medium">Keberangkatan Langsung</span>
                                            </div>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- HYBRID RENCANA WAKTU (BULAN & TANGGAL) --}}
                        <div class="flex-1 px-5 py-4 hover:bg-orange-50/40 transition-colors group cursor-pointer text-left relative custom-dropdown-container">
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1.5 block group-hover:text-orange-500 transition-colors">Rencana Waktu</label>
                            
                            @php
                                $months = [];
                                for($i = 0; $i < 12; $i++) {
                                    $date = \Carbon\Carbon::now()->addMonths($i);
                                    $months[] = [
                                        'value' => $date->format('Y-m'),
                                        'label' => $date->translatedFormat('F Y')
                                    ];
                                }
                            @endphp

                            <div class="flex items-center gap-3 w-full">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-orange-100 group-hover:scale-110 transition-all duration-300 flex-shrink-0">
                                    <i class="ph-duotone ph-calendar-blank text-2xl text-slate-500 group-hover:text-orange-600"></i>
                                </div>
                                
                                {{-- Dropdown Bulan --}}
                                <div class="relative w-full dropdown-trigger" id="month-wrapper" data-target="dropdown-month">
                                    <button type="button" class="w-full bg-transparent border-none p-0 text-slate-800 font-bold text-base focus:ring-0 cursor-pointer text-left flex items-center justify-between outline-none">
                                        <span class="selected-text truncate text-lg">Semua Waktu</span>
                                        <i class="ph-bold ph-caret-down text-slate-300 group-hover:text-orange-500 transition-transform duration-300 caret-icon flex-shrink-0"></i>
                                    </button>
                                    <input type="hidden" id="input-month" value="">
                                </div>

                                {{-- Element Flatpickr (Bawaan) --}}
                                <div id="date-wrapper" class="hidden w-full items-center justify-between relative z-[105]">
                                    <input type="text" id="input-date" placeholder="Pilih Tanggal..." class="w-full bg-transparent border-none p-0 text-orange-600 font-bold text-lg focus:ring-0 cursor-pointer placeholder-slate-400 outline-none">
                                    <button type="button" id="btn-clear-date" class="text-slate-300 hover:text-red-500 pl-2 transition-colors flex-shrink-0" title="Batal Pilih Tanggal">
                                        <i class="ph-bold ph-x-circle text-xl"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Menu Dropdown Waktu -->
                            <div id="dropdown-month" class="absolute top-full left-0 lg:-left-4 mt-3 w-full lg:w-[120%] bg-white rounded-2xl shadow-[0_30px_60px_rgba(0,0,0,0.15)] border border-slate-100 opacity-0 invisible translate-y-4 transition-all duration-300 dropdown-menu z-[100] overflow-hidden">
                                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pilih Estimasi Waktu</span>
                                </div>
                                <ul class="py-2 flex flex-col max-h-72 overflow-y-auto no-scrollbar">
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item active" data-value="" data-label="Semua Waktu">
                                        <div class="flex items-center gap-3">
                                            <i class="ph-duotone ph-infinity text-xl text-slate-400 group-hover/item:text-orange-600"></i>
                                            <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Semua Waktu</span>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-100 transition-opacity check-icon"></i>
                                    </li>
                                    
                                    @foreach($months as $month)
                                        <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item" data-value="{{ $month['value'] }}" data-label="{{ $month['label'] }}">
                                            <div class="flex items-center gap-3">
                                                <i class="ph-duotone ph-calendar-check text-xl text-slate-400 group-hover/item:text-orange-600"></i>
                                                <span class="font-bold text-slate-700 group-hover/item:text-orange-700">{{ $month['label'] }}</span>
                                            </div>
                                            <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                        </li>
                                    @endforeach
                                    
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item border-t border-slate-100 bg-orange-50/30" data-value="specific" data-label="Pilih Tanggal Pasti...">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center">
                                                <i class="ph-duotone ph-calendar-plus text-orange-600"></i>
                                            </div>
                                            <span class="font-black text-orange-600">Pilih Tanggal Pasti...</span>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- BUDGET --}}
                        <div class="flex-1 px-5 py-4 hover:bg-orange-50/40 transition-colors group cursor-pointer text-left relative custom-dropdown-container">
                            <label class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1.5 block group-hover:text-orange-500 transition-colors">Budget Per Orang</label>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-orange-100 group-hover:scale-110 transition-all duration-300 flex-shrink-0">
                                    <i class="ph-duotone ph-wallet text-2xl text-slate-500 group-hover:text-orange-600"></i>
                                </div>
                                
                                <div class="relative w-full dropdown-trigger" data-target="dropdown-budget">
                                    <button type="button" class="w-full bg-transparent border-none p-0 text-slate-800 font-bold text-base focus:ring-0 cursor-pointer text-left flex items-center justify-between outline-none">
                                        <span class="selected-text truncate text-lg">Semua Harga</span>
                                        <i class="ph-bold ph-caret-down text-slate-300 group-hover:text-orange-500 transition-transform duration-300 caret-icon flex-shrink-0"></i>
                                    </button>
                                    <input type="hidden" id="input-budget" value="all">
                                </div>
                            </div>

                            <!-- Menu Dropdown Budget -->
                            <div id="dropdown-budget" class="absolute top-full left-0 lg:left-auto lg:right-0 mt-3 w-full lg:w-[110%] bg-white rounded-2xl shadow-[0_30px_60px_rgba(0,0,0,0.15)] border border-slate-100 opacity-0 invisible translate-y-4 transition-all duration-300 dropdown-menu z-[100] overflow-hidden">
                                <div class="px-4 py-3 bg-slate-50 border-b border-slate-100">
                                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sesuaikan Anggaran</span>
                                </div>
                                <ul class="py-2 flex flex-col max-h-72 overflow-y-auto no-scrollbar">
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item active" data-value="all" data-label="Semua Harga">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Semua Harga</span>
                                            <span class="text-[10px] text-slate-400 font-medium">Tampilkan semua paket</span>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-100 transition-opacity check-icon"></i>
                                    </li>
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item" data-value="hemat" data-label="Hemat (< 28 Jt)">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Paket Hemat</span>
                                            <span class="text-[10px] text-slate-400 font-medium">Di bawah Rp 28 Juta</span>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                    </li>
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item" data-value="reguler" data-label="Reguler (28-35 Jt)">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Paket Reguler</span>
                                            <span class="text-[10px] text-slate-400 font-medium">Rp 28 Juta - Rp 35 Juta</span>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                    </li>
                                    <li class="px-4 py-3 cursor-pointer flex items-center justify-between group/item transition-colors hover:bg-orange-50 option-item" data-value="vip" data-label="VIP (> 35 Jt)">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-700 group-hover/item:text-orange-700">Paket VIP / Plus</span>
                                            <span class="text-[10px] text-slate-400 font-medium">Di atas Rp 35 Juta</span>
                                        </div>
                                        <i class="ph-bold ph-check text-orange-600 opacity-0 transition-opacity check-icon"></i>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Tombol Pencarian -->
                        <div class="p-3 lg:px-4 lg:py-0 flex items-center justify-center relative z-50">
                            <button type="submit" id="btn-search" class="w-full lg:w-auto h-14 lg:h-16 px-8 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl lg:rounded-[1.25rem] shadow-lg shadow-orange-500/40 transition-all duration-300 transform hover:scale-[1.03] active:scale-95 flex items-center justify-center gap-2 group/btn relative overflow-hidden">
                                <!-- Efek kilau (shine) pada tombol saat hover -->
                                <div class="absolute inset-0 -translate-x-full group-hover/btn:animate-[shimmer_1.5s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
                                
                                <i class="ph-bold ph-magnifying-glass text-2xl"></i>
                                <span class="lg:hidden text-lg">Cari Paket Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Badges di bawah form -->
                <div class="mt-8 flex flex-wrap justify-center gap-4 md:gap-8 text-white/90">
                    <!-- PERBAIKAN: z-10 pada badges saya hilangkan agar tidak berlomba prioritas dengan dropdown form -->
                    <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full backdrop-blur-sm border border-white/5 relative">
                        <i class="ph-fill ph-seal-check text-green-400 text-lg"></i>
                        <span class="text-xs md:text-sm font-semibold">Resmi Kemenag</span>
                    </div>
                    <div class="flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full backdrop-blur-sm border border-white/5 relative">
                        <i class="ph-fill ph-shield-check text-blue-400 text-lg"></i>
                        <span class="text-xs md:text-sm font-semibold">Transaksi Aman</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- BONUS SECTION -->
    <section class="pt-20 pb-10 md:pt-24 md:pb-10 bg-slate-50/50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 md:mb-12" data-aos="fade-up">
            <h2 class="text-2xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Daftar Sekarang, <span class="text-orange-600">Bonus Spesial</span> Menanti</h2>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5 md:gap-6">
            
            <div class="group bg-white rounded-2xl md:rounded-3xl p-4 md:p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 hover:border-emerald-200 transition-all duration-300 hover:-translate-y-2 cursor-default relative overflow-hidden" data-aos="fade-up" data-aos-delay="100">
                <div class="absolute top-0 right-0 w-16 h-16 md:w-24 md:h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative w-12 h-12 md:w-16 md:h-16 mx-auto bg-emerald-50 rounded-xl md:rounded-2xl flex items-center justify-center text-emerald-600 mb-3 md:mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-inner">
                    <i class="ph-fill ph-syringe text-2xl md:text-3xl"></i>
                </div>
                <div class="text-center relative z-10">
                    <h3 class="font-bold text-slate-900 text-sm md:text-lg mb-0.5 md:mb-1 group-hover:text-emerald-600 transition-colors">Free Vaksin</h3>
                    <p class="text-[10px] md:text-sm text-slate-500 leading-tight">Meningitis resmi bersertifikat</p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl md:rounded-3xl p-4 md:p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-blue-500/10 hover:border-blue-200 transition-all duration-300 hover:-translate-y-2 cursor-default relative overflow-hidden" data-aos="fade-up" data-aos-delay="200">
                <div class="absolute top-0 right-0 w-16 h-16 md:w-24 md:h-24 bg-blue-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative w-12 h-12 md:w-16 md:h-16 mx-auto bg-blue-50 rounded-xl md:rounded-2xl flex items-center justify-center text-blue-600 mb-3 md:mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-inner">
                    <i class="ph-fill ph-identification-card text-2xl md:text-3xl"></i>
                </div>
                <div class="text-center relative z-10">
                    <h3 class="font-bold text-slate-900 text-sm md:text-lg mb-0.5 md:mb-1 group-hover:text-blue-600 transition-colors">Diskon 40%</h3>
                    <p class="text-[10px] md:text-sm text-slate-500 leading-tight">Biaya pembuatan Paspor</p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl md:rounded-3xl p-4 md:p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-orange-500/10 hover:border-orange-200 transition-all duration-300 hover:-translate-y-2 cursor-default relative overflow-hidden" data-aos="fade-up" data-aos-delay="300">
                <div class="absolute top-0 right-0 w-16 h-16 md:w-24 md:h-24 bg-orange-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative w-12 h-12 md:w-16 md:h-16 mx-auto bg-orange-50 rounded-xl md:rounded-2xl flex items-center justify-center text-orange-600 mb-3 md:mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-inner">
                    <i class="ph-fill ph-backpack text-2xl md:text-3xl"></i>
                </div>
                <div class="text-center relative z-10">
                    <h3 class="font-bold text-slate-900 text-sm md:text-lg mb-0.5 md:mb-1 group-hover:text-orange-600 transition-colors">Free Backpack</h3>
                    <p class="text-[10px] md:text-sm text-slate-500 leading-tight">Tas punggung premium</p>
                </div>
            </div>

            <div class="group bg-white rounded-2xl md:rounded-3xl p-4 md:p-8 border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-purple-500/10 hover:border-purple-200 transition-all duration-300 hover:-translate-y-2 cursor-default relative overflow-hidden" data-aos="fade-up" data-aos-delay="400">
                <div class="absolute top-0 right-0 w-16 h-16 md:w-24 md:h-24 bg-purple-50 rounded-bl-full -mr-4 -mt-4 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                <div class="relative w-12 h-12 md:w-16 md:h-16 mx-auto bg-purple-50 rounded-xl md:rounded-2xl flex items-center justify-center text-purple-600 mb-3 md:mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-inner">
                    <i class="ph-fill ph-gift text-2xl md:text-3xl"></i>
                </div>
                <div class="text-center relative z-10">
                    <h3 class="font-bold text-slate-900 text-sm md:text-lg mb-0.5 md:mb-1 group-hover:text-purple-600 transition-colors">Free Oleh-oleh</h3>
                    <p class="text-[10px] md:text-sm text-slate-500 leading-tight">Paket lengkap 30 pack</p>
                </div>
            </div> 
          </div>
       </div>
    </section>

    <!-- PRODUK SECTION -->
    <section class="py-16 md:py-24 bg-slate-50" id="produk">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-6" data-aos="fade-down">
                <div class="text-center md:text-left w-full md:w-auto">
                    <span class="text-orange-600 font-bold text-xs md:text-sm tracking-widest uppercase mb-2 block">Pilihan Terbaik</span>
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold text-slate-900 leading-tight">Program Ibadah Unggulan</h2>
                </div>
                <div class="w-full md:w-auto overflow-x-auto no-scrollbar pb-2 md:pb-0 -mx-4 px-4 md:mx-0 md:px-0">
                    <div class="flex flex-nowrap md:flex-wrap justify-start md:justify-center gap-2 min-w-max bg-transparent md:bg-white md:p-1.5 md:rounded-full md:shadow-sm md:border md:border-slate-100">
                        <button onclick="filterKategori('all')" class="filter-btn active px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-300 whitespace-nowrap border bg-orange-600 text-white border-transparent shadow-md hover:bg-orange-700" data-filter="all">Semua</button>
                        @foreach($daftarKategori as $kategori)
                        <button onclick="filterKategori('{{ $kategori['id'] }}')" class="filter-btn px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 whitespace-nowrap border bg-white text-slate-600 border-slate-200 hover:bg-slate-100 md:bg-transparent md:border-transparent" data-filter="{{ $kategori['id'] }}">
                            {{ $kategori['name'] ?? ($kategori['nama_kategori'] ?? 'Kategori') }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6" id="product-grid">
                @forelse($daftarProduk as $produk)
                    @php
                        // 👇 UBAH: Cari spesifik harga untuk kamar Quad
                        $kamarQuad = collect($produk['prices'] ?? [])->first(function($kamar) {
                            return stripos($kamar['room_types'] ?? '', 'quad') !== false;
                        });

                        // Jika kamar Quad ketemu, ambil harganya. Kalau nggak ada, pakai harga pertama (fallback)
                        if ($kamarQuad) {
                            $hargaAsli = $kamarQuad['harga'] ?? ($kamarQuad['price'] ?? 0);
                        } else {
                            $hargaAsli = $produk['prices'][0]['harga'] ?? ($produk['prices'][0]['price'] ?? 0);
                        }
                    @endphp
                   <div class="product-card group bg-white rounded-xl md:rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full hover:-translate-y-1" data-id="{{ $produk['id'] }}" data-category="{{ $produk['category_id'] }}" data-kota="{{ strtolower($produk['tmp_keberangkatan'] ?? '') }}" data-tanggal="{{ \Carbon\Carbon::parse($produk['tgl_keberangkatan'])->format('Y-m-d') }}" data-harga="{{ $hargaAsli }}" data-nama="{{ $produk['nama_produk'] }}" data-aos="fade-up">
                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                            <img src="https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/{{ rawurlencode($produk['thumbnail_url']) }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700 cursor-pointer" 
                                alt="{{ $produk['nama_produk'] }}" 
                                onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ str_replace(' ', '+', $produk['nama_produk']) }}&background=F97316&color=fff';" 
                                onclick="openBerandaLightbox(this.src); event.stopPropagation();" 
                                title="Perbesar Gambar">
                            
                            <!-- 👇 INDIKATOR ZOOM GAMBAR (BARU) 👇 -->
                            <!-- Efek kaca (backdrop-blur), muncul dari bawah (translate-y) saat di-hover -->
                            <div class="absolute bottom-2 left-2 md:bottom-3 md:left-3 z-10 flex gap-2 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300 pointer-events-none">
                                <div class="px-2 py-1 md:px-2.5 md:py-1.5 rounded-lg bg-black/40 backdrop-blur-md flex items-center gap-1.5 text-white/90 shadow-sm border border-white/20">
                                    <i class="ph-bold ph-arrows-out-simple text-[10px] md:text-xs"></i>
                                    <span class="text-[8px] md:text-[10px] font-bold uppercase tracking-wider">Perbesar</span>
                                </div>
                            </div>
                            
                            <div class="absolute top-2 right-2 md:top-3 md:right-3 z-10 flex gap-1.5 md:gap-2">
                                {{-- Tombol Compare (Selalu Tampil) --}}
                                <button onclick="addToCompare(this)" class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-teal-600 hover:text-white transition border border-white/30 group/btn" title="Bandingkan">
                                    <i class="ph-bold ph-arrows-left-right text-xs md:text-lg transform group-hover/btn:rotate-180 transition-transform duration-500"></i>
                                </button>

                                {{-- Tombol Wishlist (Hanya tampil jika bukan akun Travel) --}}
                                @if(!$isTravelAccount)
                                    @php
                                        $isWishlisted = in_array($produk['id'], $wishlistIds ?? []);
                                        // 👇 Cek apakah user guest (belum login) 👇
                                        $isGuest = !session()->has('api_token');
                                    @endphp
                                    <!-- 👇 UPDATE: Logika onclick dinamis 👇 -->
                                    <button onclick="{{ $isGuest ? 'requireLoginAlert(event)' : 'toggleWishlist(this, \''.$produk['id'].'\')' }}" class="wishlist-btn w-6 h-6 md:w-8 md:h-8 rounded-full backdrop-blur-md flex items-center justify-center transition-colors border group/wishlist {{ $isWishlisted ? 'bg-white text-red-500 border-red-500' : 'bg-white/20 text-white hover:bg-white hover:text-red-500 border-white/30' }}" title="Simpan ke Wishlist">
                                        <i class="ph-fill ph-heart text-xs md:text-lg pointer-events-none transition-transform group-active/wishlist:scale-75"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-3 md:p-5 flex flex-col flex-grow cursor-pointer hover:bg-slate-50/50 transition-colors" 
                        onclick="window.location.href='{{ route('marketplace.produk.detail', $produk['id']) }}'" 
                        title="Lihat Detail Paket">

                            {{-- 👇 INI JUDULNYA BIAR GAK HILANG 👇 --}}
                            <div class="min-h-[2.5rem] md:min-h-[3.5rem] mb-1 md:mb-0">
                                <h3 class="text-[11px] sm:text-xs md:text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                    {{ $produk['nama_produk'] }}
                                </h3>
                            </div>
                            
                            <!-- Spasi list info dikecilkan di mobile -->
                            <div class="flex-grow space-y-1.5 md:space-y-3 mb-4 md:mb-6">
                                @if(!empty($produk['hotels'][0]))
                                <div class="flex items-center gap-1.5 md:gap-3">
                                    <i class="ph-duotone ph-buildings text-orange-500 text-sm md:text-xl flex-shrink-0"></i>
                                    <p class="text-[9px] md:text-sm font-semibold text-slate-600 truncate">
                                        {{ $produk['hotels'][0]['city'] ?? 'Kota' }}: {{ $produk['hotels'][0]['name'] ?? 'Hotel' }} ⭐{{ $produk['hotels'][0]['rating'] ?? '5' }}
                                    </p>
                                </div>
                                @endif
                                
                                @if(!empty($produk['hotels'][1]))
                                <div class="flex items-center gap-1.5 md:gap-3">
                                    <i class="ph-duotone ph-buildings text-orange-500 text-sm md:text-xl flex-shrink-0"></i>
                                    <p class="text-[9px] md:text-sm font-semibold text-slate-600 truncate">
                                        {{ $produk['hotels'][1]['city'] ?? 'Kota' }}: {{ $produk['hotels'][1]['name'] ?? 'Hotel' }} ⭐{{ $produk['hotels'][1]['rating'] ?? '5' }}
                                    </p>
                                </div>
                                @endif
                                
                                <div class="flex items-center gap-1.5 md:gap-3">
                                    <i class="ph-duotone ph-airplane-tilt text-blue-500 text-sm md:text-xl flex-shrink-0"></i>
                                    <p class="text-[9px] md:text-sm font-semibold text-slate-600 truncate">{{ $produk['flights'][0]['airline_name'] ?? 'Maskapai' }}</p>
                                </div>
                                
                                <div class="flex items-center gap-1.5 md:gap-3">
                                    <i class="ph-duotone ph-calendar-blank text-green-500 text-sm md:text-xl flex-shrink-0"></i>
                                    <p class="text-[9px] md:text-sm font-semibold text-slate-600">{{ \Carbon\Carbon::parse($produk['tgl_keberangkatan'])->translatedFormat('d M y') }}</p>
                                </div>

                                <div class="pt-1.5 md:pt-2">
                                    @php
                                        $kuota = intval($produk['total_quota'] ?? 0);
                                        $maxSeat = ($kuota > 45) ? 100 : 45;
                                        $persenSeat = $maxSeat > 0 ? round(($kuota / $maxSeat) * 100) : 0;
                                        if ($persenSeat > 100) $persenSeat = 100;
                                    @endphp
                                    <div class="flex justify-between text-[8px] md:text-[11px] mb-1 font-bold">
                                        <span class="text-slate-500 uppercase tracking-tighter">Seat Sisa</span>
                                        <span class="text-[#ff782e] font-black">{{ $kuota }} Seat</span>
                                    </div>
                                    <!-- Bar lebih tipis di mobile -->
                                    <div class="w-full bg-slate-200 h-2 md:h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                        <div class="progress-orange-animated h-full rounded-full transition-all duration-700" style="width: {{ $persenSeat }}%; min-width: 5%;"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-2 md:pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                <div>
                                    <p class="text-[8px] md:text-[10px] text-slate-400 uppercase font-black tracking-wider">Mulai</p>
                                    <p class="text-xs sm:text-sm md:text-xl font-black text-slate-900">
                                        @if($hargaAsli > 0)
                                            Rp {{ number_format($hargaAsli / 1000000, 1, ',', '.') }} <span class="text-[8px] md:text-sm">Jt</span>
                                        @else
                                            <span class="text-[10px] md:text-sm">Hubungi Kami</span>
                                        @endif
                                    </p>
                                </div>
                                <a href="{{ route('marketplace.produk.detail', $produk['id']) }}" class="w-7 h-7 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30 flex-shrink-0">
                                    <i class="ph-bold ph-arrow-right text-xs md:text-lg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">Paket Tidak Ditemukan</div>
                @endforelse

                <div id="empty-state" class="hidden col-span-full py-20 px-6 bg-white rounded-3xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-center transition-all duration-500" data-aos="fade-up">
                    {{-- Ikon Container --}}
                    <div class="w-20 h-20 bg-orange-50 rounded-2xl flex items-center justify-center mb-6 shadow-inner ring-4 ring-orange-50/50">
                        <i class="ph-duotone ph-magnifying-glass text-4xl text-orange-400"></i>
                    </div>
                    
                    {{-- Teks --}}
                    <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-slate-500 max-w-sm mx-auto mb-8 leading-relaxed">
                        Maaf, untuk saat ini belum ada paket perjalanan yang tersedia pada kategori pilihan Anda.
                    </p>

                    {{-- Tombol --}}
                    <button onclick="filterKategori('all')" class="group flex items-center gap-2 px-8 py-3.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-orange-600 transition-all duration-300 shadow-lg hover:shadow-orange-500/30 active:scale-95">
                        <i class="ph-bold ph-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i>
                        <span>Lihat Semua Paket</span>
                    </button>
                </div>

            </div>

            <div class="mt-8 md:mt-12 text-center">
                <a href="{{ route('marketplace.produk.index') }}" class="inline-flex items-center justify-center gap-2 text-sm font-semibold text-slate-500 hover:text-orange-600 transition group px-6 py-3 rounded-full hover:bg-orange-50">
                    Lihat Seluruh Paket 
                    <i class="ph-bold ph-arrow-right transform group-hover:translate-x-1 transition"></i>
                </a>
            </div>
        </div>

        {{-- 👇 TAMBAHAN BARU: LIGHTBOX IMAGE BERANDA 👇 --}}
        <div id="beranda-lightbox" class="fixed inset-0 z-[70] bg-black/90 flex items-center justify-center hidden p-4" onclick="closeBerandaLightbox()">
            <button class="absolute top-4 right-4 text-white text-3xl hover:text-orange-500 transition"><i class="ph-bold ph-x"></i></button>
            <img id="beranda-lightbox-img" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
        </div>

        <script>
        function openBerandaLightbox(src) {
            const lightbox = document.getElementById('beranda-lightbox');
            const img = document.getElementById('beranda-lightbox-img');
            img.src = src;
            lightbox.classList.remove('hidden');
            setTimeout(() => img.classList.remove('scale-95'), 10);
        }
        function closeBerandaLightbox() {
            const lightbox = document.getElementById('beranda-lightbox');
            const img = document.getElementById('beranda-lightbox-img');
            img.classList.add('scale-95');
            setTimeout(() => lightbox.classList.add('hidden'), 300);
        }
        // 👇 TAMBAHAN FIX BUG: SYNC COMPARE BUTTON DI BERANDA 👇
        document.addEventListener('DOMContentLoaded', function() {
            syncBerandaCompareState();
        });

        function syncBerandaCompareState() {
            // Ambil data perbandingan dari memori browser
            let compareList = localStorage.getItem('compareList');
            let currentList = compareList ? JSON.parse(compareList) : [];

            // Cari semua card produk yang ada di Beranda
            const productCards = document.querySelectorAll('#product-grid .product-card');

            productCards.forEach(card => {
                const idProduk = card.getAttribute('data-id');
                // Cari tombol compare (yang ada title="Bandingkan")
                const compareBtn = card.querySelector('button[title="Bandingkan"]');

                if (compareBtn && currentList.includes(idProduk)) {
                    // Jika produk ada di memori, ubah warna tombol jadi nyala (Teal)
                    compareBtn.classList.remove('bg-white/20', 'border-white/30');
                    compareBtn.classList.add('bg-teal-500', 'border-teal-500');
                }
            });
        }
    </script>

    </section>

    <!-- LIGHTBOX & LAINNYA --> 
    <div id="lightbox-modal" class="fixed inset-0 z-[60] bg-black/95 hidden flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" onclick="closeLightbox()"> 
        <button class="absolute top-6 right-6 text-white hover:text-orange-500 transition"> 
            <i class="ph-bold ph-x text-4xl"></i> 
        </button> 
        <div class="relative max-w-5xl w-full max-h-screen"> 
            <img id="lightbox-image" src="" class="w-full h-auto max-h-[85vh] object-contain rounded-lg shadow-2xl transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()"> 
            <div id="lightbox-caption" class="text-white text-center mt-4 font-medium text-lg"></div> 
        </div> 
    </div>

    <!-- MITRA -->
    <section class="py-16 md:py-24 bg-slate-50 relative overflow-hidden" id="mitra">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none opacity-40">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-orange-100 rounded-full blur-3xl mix-blend-multiply"></div>
            <div class="absolute top-1/2 right-0 w-72 h-72 bg-blue-100 rounded-full blur-3xl mix-blend-multiply"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-10 md:mb-16" data-aos="fade-up">
                <span class="inline-block py-1 px-3 rounded-full bg-orange-100 text-orange-700 text-[10px] md:text-xs font-bold tracking-wider uppercase mb-3">Partner Resmi</span>
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight">Mitra Travel Terpercaya</h2>
                <p class="text-sm md:text-lg text-slate-500 mt-3 md:mt-4 max-w-2xl mx-auto leading-relaxed">
                    Kami hanya bekerjasama dengan penyelenggara Umroh & Haji yang telah terverifikasi dan memiliki izin resmi PPIU dari Kementerian Agama RI.
                </p>
            </div>

                <!-- 👇 GRID DIUBAH JADI FLEX CENTER 👇 -->
                <div id="mitra-container" class="flex flex-wrap justify-center gap-3 sm:gap-4 md:gap-6 lg:gap-8">
                    
                    @forelse ($mitras as $mitra)
                        @php
                            // 1. Ambil nama travel
                            $namaTravel = $mitra['fullname'] ?? ($mitra['username'] ?? 'Biro Travel');
                            
                            // 2. Langsung ambil avatar_url dari Controller. 
                            $avatar = !empty($mitra['avatar_url']) 
                                ? $mitra['avatar_url'] 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($namaTravel) . '&background=F97316&color=fff';
                        @endphp

                        <!-- Mitra Item Dinamis (Ukurannya di-set manual agar konsisten seperti grid) -->
                        <a href="{{ route('marketplace.produk.index', ['mitra' => $namaTravel]) }}" 
                        class="group bg-white rounded-xl md:rounded-2xl p-4 md:p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:border-orange-200 transition-all duration-300 cursor-pointer relative flex flex-col justify-center items-center text-center w-[calc(50%-0.375rem)] sm:w-[calc(33.333%-0.667rem)] lg:w-[calc(25%-1.125rem)] xl:w-[calc(16.666%-1.333rem)]" 
                        data-aos="fade-up">
                            
                            <!-- Foto Profil Travel -->
                            <div class="w-16 h-16 md:w-20 md:h-20 flex items-center justify-center mb-3 md:mb-5 rounded-full bg-slate-50 group-hover:bg-white transition-colors border-2 border-transparent group-hover:border-orange-200 overflow-hidden shadow-sm">
                                <img src="{{ $avatar }}" 
                                    alt="Logo {{ $namaTravel }}" 
                                    class="w-full h-full object-cover transition-all duration-500 group-hover:scale-110"
                                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ str_replace(' ', '+', $namaTravel) }}&background=F97316&color=fff';">
                            </div>
                            
                            <!-- Nama Travel -->
                            <div>
                                <h3 class="text-xs md:text-sm font-bold text-slate-900 group-hover:text-orange-600 transition-colors leading-tight mb-1 line-clamp-2">{{ $namaTravel }}</h3>
                            </div>
                            
                        </a>
                    @empty
                        <div class="w-full text-center py-8">
                            <p class="text-slate-500 text-sm">Belum ada mitra travel yang bergabung.</p>
                        </div>
                    @endforelse

                </div>

        </div>
    </section>

    <!-- KARIR -->
    <section class="py-12 px-4 bg-slate-50" id="karir">
        <div class="max-w-6xl mx-auto rounded-3xl bg-gradient-to-r from-orange-600 to-amber-500 overflow-hidden relative shadow-2xl">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full blur-3xl -ml-16 -mb-16"></div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between p-10 md:p-16 text-center md:text-left">
                <div class="mb-6 md:mb-0">
                    <h2 class="text-3xl font-bold text-white mb-2">Ingin berkarya bersama kami?</h2>
                    <p class="text-orange-50 text-lg">Bergabung dengan tim pengenumroh.com dan bantu jutaan orang beribadah.</p>
                </div>
                <a href="https://karir.pengenumroh.com/" class="bg-white text-orange-600 hover:bg-slate-100 font-bold py-4 px-8 rounded-xl shadow-lg transition transform hover:scale-105">Lihat Lowongan</a>
            </div>
        </div>
    </section>

</x-layouts.marketplace>