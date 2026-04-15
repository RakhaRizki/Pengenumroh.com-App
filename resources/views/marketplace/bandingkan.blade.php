<x-layouts.marketplace>

    <body class="bg-gray-50 text-gray-800">

        <div class="pt-28 pb-12 lg:pt-32 container mx-auto px-4 max-w-7xl">

            <div
                class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-10 bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <a href="/marketplace/"
                    class="flex items-center gap-3 text-gray-500 hover:text-teal-700 font-medium transition-colors group">
                    <div
                        class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-teal-50 group-hover:text-teal-600 transition-colors border border-gray-100">
                        <i class="fas fa-arrow-left text-sm group-hover:-translate-x-0.5 transition-transform"></i>
                    </div>
                    <span class="text-sm">Kembali ke Beranda</span>
                </a>

                <div class="text-center hidden sm:block">
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">Perbandingan Paket</h2>
                    <div id="product-counter-container"
                        class="flex items-center justify-center gap-2 mt-1 transition-all duration-300">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <p id="product-counter-text" class="text-xs text-gray-500 font-medium">2 Produk dipilih</p>
                    </div>
                </div>

                <button onclick="deleteAllProducts()"
                    class="flex items-center gap-2 text-red-500 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500 font-medium text-sm transition-all px-5 py-2.5 rounded-xl shadow-sm cursor-pointer">
                    <i class="fas fa-trash-alt text-xs"></i>
                    <span>Hapus Semua</span>
                </button>
            </div>

            <div class="relative">

                <div id="comparison-grid"
                    class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-14 items-stretch transition-all duration-500">

                    <div
                        class="product-card group relative flex flex-col h-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-teal-300 hover:shadow-[0_8px_30px_rgb(13,148,136,0.15)] transition-all duration-300 overflow-hidden">

                        <button onclick="deleteProduct(this)"
                            class="cursor-pointer absolute top-4 right-4 z-30 w-9 h-9 bg-white/30 backdrop-blur-md hover:bg-red-500 border border-white/50 rounded-full flex items-center justify-center text-white hover:text-white transition-all duration-200 shadow-lg group-hover:scale-110"
                            title="Hapus produk ini">
                            <i class="fas fa-times text-sm drop-shadow-md"></i>
                        </button>

                        <div class="relative h-156 overflow-hidden cursor-pointer"
                            onclick="openModal(this.querySelector('img').src)">
                            <!-- <div
                                                class="absolute top-5 left-5 bg-teal-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg z-10 shadow-lg tracking-wide uppercase">
                                                <i class="fas fa-star text-yellow-300 mr-1"></i> Best Seller
                                            </div> -->
                            <img src="/assets/img/marketplace/produk-dummy.png"
                                onerror="this.src='https://images.unsplash.com/photo-1565552684305-7e8d5eb09539?q=80&w=1000&auto=format&fit=crop'"
                                alt="Mutiara Sunnah"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-20">
                                <div
                                    class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/30 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 px-6 pb-2 flex flex-col items-center text-center">

                            <div class="mb-3">
                                <span
                                    class="inline-flex items-center gap-1.5 py-1 px-3 rounded-md bg-teal-50 text-teal-700 text-[11px] font-bold tracking-wider uppercase shadow-sm">
                                    <i class="ph-fill ph-seal-check text-teal-500 text-xs"></i>
                                    Mutiara Sunnah Travel
                                </span>
                            </div>

                            <h3
                                class="text-xl md:text-2xl font-bold text-gray-900 leading-snug group-hover:text-teal-600 transition-colors">
                                Umroh Easy 22 Juni<br>
                                2026
                            </h3>

                        </div>

                        <div class="px-6 py-4 flex justify-center items-center border-b border-dashed border-gray-100">
                            <div class="text-center">
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5">
                                    Mulai Dari
                                </p>
                                <div class="flex items-baseline justify-center gap-1">
                                    <span class="text-sm font-bold text-teal-600">Rp</span>
                                    <span class="text-3xl font-extrabold text-teal-700 tracking-tight">
                                        25.9<span class="text-lg">jt</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 flex-grow flex flex-col gap-6">

                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Durasi
                                    </p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-clock text-orange-500 text-base"></i> 9 Hari
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Tanggal
                                    </p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-calendar-blank text-orange-500 text-base"></i> 22 Juni
                                        2026
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Maskapai
                                    </p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-airplane-takeoff text-orange-500 text-base"></i>Oman Air
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">
                                        Keberangkatan</p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-airplane-takeoff text-orange-500 text-base"></i>Jakarta
                                        (CGK)
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Hotel
                                        Makkah
                                    </p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-buildings text-orange-500 text-base"></i> Lemeridien
                                        Tower
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Jarak
                                        Hotel
                                        Makkah</p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-map-pin text-orange-500 text-base"></i> ± by shuttle
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Hotel
                                        Madinah</p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-buildings text-orange-500 text-base"></i> Jiwal Al Saha
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Jarak
                                        Hotel
                                        Madinah</p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-map-pin text-orange-500 text-base"></i> ± 500m
                                    </p>
                                </div>
                            </div>

                            <div class="border border-gray-100 rounded-2xl p-4 bg-white relative overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 w-16 h-16 bg-teal-50 rounded-bl-full -mr-8 -mt-8 z-0">
                                </div>
                                <p
                                    class="text-[10px] font-bold text-gray-400 uppercase mb-4 flex items-center gap-2 relative z-10">
                                    <i class="fas fa-hotel text-teal-500"></i> Akomodasi & Hotel
                                </p>
                                <div class="space-y-4 pl-2 relative z-10">
                                    <div class="flex gap-3 relative">
                                        <div class="flex flex-col items-center">
                                            <div class="w-2.5 h-2.5 rounded-full bg-teal-500 ring-4 ring-teal-50"></div>
                                            <div class="w-0.5 h-full bg-gray-200 my-1"></div>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold text-gray-900 block">Lemeridien Tower</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span
                                                    class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-500 rounded border border-gray-200">Mekkah</span>
                                                <span class="text-[10px] text-teal-600 font-medium"><i
                                                        class="fas fa-bus mr-1"></i>Shuttle</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex flex-col items-center">
                                            <div class="w-2.5 h-2.5 rounded-full bg-teal-500 ring-4 ring-teal-50"></div>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold text-gray-900 block">Jiwal Al Saha</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span
                                                    class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-500 rounded border border-gray-200">Madinah</span>
                                                <span class="text-[10px] text-gray-400"><i
                                                        class="fas fa-walking mr-1"></i>500m</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-teal-50/40 rounded-2xl p-4 border border-teal-100">
                                <p class="text-[10px] font-bold text-teal-800 uppercase mb-3 flex items-center gap-2">
                                    <i class="fas fa-box-open text-teal-500"></i> Fasilitas Paket
                                </p>
                                <div class="grid grid-cols-2 gap-y-2 gap-x-2">
                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>

                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">
                                            Tiket Pesawat
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Visa
                                            Umroh</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Handling
                                            Bandara</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Handling
                                            Hotel</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Transportasi
                                            Bus</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span
                                            class="text-[10px] text-gray-600 font-medium leading-tight">Asuransi</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span
                                            class="text-[10px] text-gray-600 font-medium leading-tight">Muthawif</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Makan
                                            3x</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Zamzam
                                            5L</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Ayam Al
                                            Baik</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-teal-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Kuliner
                                            Arab</span>
                                    </div>

                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-3 mt-auto">
                                <div class="bg-white rounded-xl p-3 border border-gray-100 shadow-sm">
                                    <h5
                                        class="text-[10px] font-bold text-red-600 uppercase mb-2 flex items-center gap-1.5">
                                        <i class="fas fa-times-circle text-red-500"></i> Tidak Termasuk
                                    </h5>
                                    <ul class="space-y-1.5">
                                        <li class="text-[10px] text-gray-500 flex items-start gap-1.5 leading-tight">
                                            <span class="w-1 h-1 rounded-full bg-red-300 mt-1.5 shrink-0"></span>
                                            Pembuatan
                                            Paspor
                                        </li>
                                        <li class="text-[10px] text-gray-500 flex items-start gap-1.5 leading-tight">
                                            <span class="w-1 h-1 rounded-full bg-red-300 mt-1.5 shrink-0"></span>
                                            Kelebihan
                                            Bagasi
                                        </li>
                                        <li class="text-[10px] text-gray-500 flex items-start gap-1.5 leading-tight">
                                            <span class="w-1 h-1 rounded-full bg-red-300 mt-1.5 shrink-0"></span>
                                            Perlengkapan Umroh
                                        </li>
                                        <li class="text-[10px] text-gray-500 flex items-start gap-1.5 leading-tight">
                                            <span class="w-1 h-1 rounded-full bg-red-300 mt-1.5 shrink-0"></span>
                                            Vaksin
                                            Meningitis & Polio
                                        </li>
                                        <li class="text-[10px] text-gray-500 flex items-start gap-1.5 leading-tight">
                                            <span class="w-1 h-1 rounded-full bg-red-300 mt-1.5 shrink-0"></span>
                                            Pengeluaran Pribadi
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="p-5 bg-gray-50 border-t border-gray-100">
                            <a href="/marketplace/paket1/"
                                class="w-full py-3.5 bg-white border-2 border-teal-600 text-teal-700 font-bold rounded-xl hover:bg-teal-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-0.5 flex justify-center items-center gap-2 group decoration-0">
                                Pilih Paket Ini
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>

                    <div
                        class="product-card group relative flex flex-col h-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-orange-300 hover:shadow-[0_8px_30px_rgb(234,88,12,0.15)] transition-all duration-300 overflow-hidden ring-1 ring-orange-50">

                        <button onclick="deleteProduct(this)"
                            class="cursor-pointer absolute top-4 right-4 z-30 w-9 h-9 bg-white/30 backdrop-blur-md hover:bg-red-500 border border-white/50 rounded-full flex items-center justify-center text-white hover:text-white transition-all duration-200 shadow-lg group-hover:scale-110"
                            title="Hapus produk ini">
                            <i class="fas fa-times text-sm drop-shadow-md"></i>
                        </button>

                        <div class="relative h-156 overflow-hidden cursor-pointer"
                            onclick="openModal(this.querySelector('img').src)">
                            <!-- <div
                                                class="absolute top-5 left-5 bg-gradient-to-r from-orange-500 to-amber-500 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg z-10 shadow-lg tracking-wide uppercase">
                                                <i class="fas fa-moon text-yellow-100 mr-1"></i> Ramadhan
                                            </div> -->
                            <img src="/assets/img/marketplace/produk-dummy2.png" alt="Elmarwa Travel"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div
                                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-20">
                                <div
                                    class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/30 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 px-6 pb-2 flex flex-col items-center text-center">

                            <div class="mb-3">
                                <span
                                    class="inline-flex items-center gap-1.5 py-1 px-3 rounded-md bg-orange-50 text-orange-700 text-[11px] font-bold tracking-wider uppercase shadow-sm">
                                    <i class="ph-fill ph-seal-check text-orange-500 text-xs"></i> Haramainku Travel
                                </span>
                            </div>

                            <h3
                                class="text-xl md:text-2xl font-bold text-gray-900 leading-snug group-hover:text-orange-600 transition-colors">
                                Umroh Libur Lebaran<br>
                                23 Maret 2026
                            </h3>

                        </div>

                        <div class="px-6 py-4 flex justify-center items-center border-b border-dashed border-gray-100">
                            <div class="text-center">
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5">
                                    Mulai Dari
                                </p>
                                <div class="flex items-baseline justify-center gap-1">
                                    <span class="text-sm font-bold text-orange-600">Rp</span>
                                    <span class="text-3xl font-extrabold text-orange-600 tracking-tight">
                                        31.9<span class="text-lg">jt</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 flex-grow flex flex-col gap-6">

                            <div class="grid grid-cols-3 gap-3">
                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Durasi
                                    </p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-clock text-orange-500 text-base"></i> 12 Hari
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Tanggal
                                    </p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-calendar-blank text-orange-500 text-base"></i> 23 Maret
                                        2026
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">
                                        Maskapai</p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-airplane-takeoff text-orange-500 text-base"></i> Garuda
                                        Indonesia
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">
                                        Keberangkatan</p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-airplane-takeoff text-orange-500 text-base"></i>Jakarta
                                        (CGK)
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Hotel
                                        Makkah
                                    </p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-buildings text-orange-500 text-base"></i> Waha Ajyad
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Jarak
                                        Hotel
                                        Makkah</p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-map-pin text-orange-500 text-base"></i> ± 550m
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Hotel
                                        Madinah</p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-buildings text-orange-500 text-base"></i> Odst
                                        Almadinah
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Jarak
                                        Hotel
                                        Madinah</p>
                                    <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                        <i class="ph-duotone ph-map-pin text-orange-500 text-base"></i> ± 500m
                                    </p>
                                </div>
                            </div>

                            <div class="border border-gray-100 rounded-2xl p-4 bg-white relative overflow-hidden">
                                <div
                                    class="absolute top-0 right-0 w-16 h-16 bg-orange-50 rounded-bl-full -mr-8 -mt-8 z-0">
                                </div>
                                <p
                                    class="text-[10px] font-bold text-gray-400 uppercase mb-4 flex items-center gap-2 relative z-10">
                                    <i class="fas fa-hotel text-orange-500"></i> Akomodasi & Hotel
                                </p>
                                <div class="space-y-4 pl-2 relative z-10">
                                    <div class="flex gap-3 relative">
                                        <div class="flex flex-col items-center">
                                            <div class="w-2.5 h-2.5 rounded-full bg-orange-500 ring-4 ring-orange-50">
                                            </div>
                                            <div class="w-0.5 h-full bg-gray-200 my-1"></div>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold text-gray-900 block">Waha Ajyad</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span
                                                    class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-500 rounded border border-gray-200">Makkah</span>
                                                <span class="text-[10px] text-gray-400"><i
                                                        class="fas fa-walking mr-1"></i>550m</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex gap-3">
                                        <div class="flex flex-col items-center">
                                            <div class="w-2.5 h-2.5 rounded-full bg-orange-500 ring-4 ring-orange-50">
                                            </div>
                                        </div>
                                        <div>
                                            <span class="text-xs font-bold text-gray-900 block">Odst Almadinah</span>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span
                                                    class="text-[10px] px-1.5 py-0.5 bg-gray-100 text-gray-500 rounded border border-gray-200">Madinah</span>
                                                <span class="text-[10px] text-gray-400"><i
                                                        class="fas fa-walking mr-1"></i>500m</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-orange-50/40 rounded-2xl p-4 border border-orange-100">
                                <p
                                    class="text-[10px] font-bold text-orange-800 uppercase mb-3 flex items-center gap-2">
                                    <i class="fas fa-box-open text-orange-500"></i> Fasilitas Paket
                                </p>

                                <div class="grid grid-cols-2 gap-y-2 gap-x-2">

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Visa
                                            Umroh</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Tiket Pesawat
                                            International (PP)</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Makan
                                            3x</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Ziarah Makkah
                                            &
                                            Madinah</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span
                                            class="text-[10px] text-gray-600 font-medium leading-tight">Muthawif</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Pembimbing
                                            Ibadah</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Zam Zam
                                            5L</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span
                                            class="text-[10px] text-gray-600 font-medium leading-tight">Tahalul</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Albaik
                                            Chicken</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Perlengkapan
                                            Umroh</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <i class="ph-duotone ph-check-circle text-orange-500 text-[14px]"></i>
                                        <span class="text-[10px] text-gray-600 font-medium leading-tight">Manasik dan
                                            Lounge</span>
                                    </div>

                                </div>

                            </div>

                            <div class="grid grid-cols-1 gap-3 mt-auto">
                                <div class="bg-white rounded-xl p-3 border border-gray-100 shadow-sm">
                                    <h5
                                        class="text-[10px] font-bold text-red-600 uppercase mb-2 flex items-center gap-1.5">
                                        <i class="fas fa-times-circle text-red-500"></i> Tidak Termasuk
                                    </h5>
                                    <ul class="space-y-1.5">
                                        <li class="text-[10px] text-gray-500 flex items-start gap-1.5 leading-tight">
                                            <span class="w-1 h-1 rounded-full bg-red-300 mt-1.5 shrink-0"></span>
                                            Pembuatan
                                            Paspor
                                        </li>
                                        <li class="text-[10px] text-gray-500 flex items-start gap-1.5 leading-tight">
                                            <span class="w-1 h-1 rounded-full bg-red-300 mt-1.5 shrink-0"></span>
                                            Pengeluaran Pribadi
                                        </li>
                                        <li class="text-[10px] text-gray-500 flex items-start gap-1.5 leading-tight">
                                            <span class="w-1 h-1 rounded-full bg-red-300 mt-1.5 shrink-0"></span>
                                            Kelebihan Bagasi
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="p-5 bg-gray-50 border-t border-gray-100">
                            <a href="/marketplace/paket2/"
                                class="w-full py-3.5 bg-white border-2 border-orange-600 text-orange-700 font-bold rounded-xl hover:bg-orange-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:shadow-orange-100 hover:-translate-y-0.5 flex justify-center items-center gap-2 group decoration-0">
                                Pilih Paket Ini
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div id="imageModal"
            class="fixed inset-0 z-[100] hidden items-center justify-center transition-all duration-300 opacity-0"
            role="dialog" aria-modal="true">

            <div class="absolute inset-0 bg-gray-900/90 backdrop-blur-sm transition-opacity" onclick="closeModal()">
            </div>

            <button onclick="closeModal()"
                class="absolute top-5 right-5 z-[110] w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all hover:rotate-90 hover:scale-110 focus:outline-none">
                <i class="fas fa-times text-xl"></i>
            </button>

            <div class="relative z-[110] p-4 max-w-5xl w-full h-full flex items-center justify-center">
                <img id="modalImage" src="" alt="Preview"
                    class="max-h-[90vh] max-w-full object-contain rounded-xl shadow-2xl transform scale-95 transition-transform duration-300 select-none">

                <div
                    class="absolute bottom-8 left-1/2 -translate-x-1/2 bg-black/50 backdrop-blur-md px-4 py-2 rounded-full text-white text-sm font-medium border border-white/10">
                    Tekan ESC untuk menutup
                </div>
            </div>
        </div>

        <!-- CDN SCRIPT -->

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

        <script>
            AOS.init({
                duration: 800,
                once: true
            });

            // Toggle Mobile Filter
            function toggleMobileFilter() {
                const modal = document.getElementById('mobile-filter');
                const content = document.getElementById('mobile-filter-content');

                if (modal.classList.contains('hidden')) {
                    // Open
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        content.classList.remove('translate-y-full');
                    }, 10);
                    document.body.style.overflow = 'hidden';
                } else {
                    // Close
                    content.classList.add('translate-y-full');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }, 300);
                }
            }

            function showDetail(event) {
                event.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Halaman Detail',
                    text: 'Fitur ini akan mengarah ke halaman detail produk.',
                    confirmButtonColor: '#ea580c'
                });
            }

            // --- NEW SCRIPTS FOR NAVBAR ---

            // 1. Toggle Mobile Menu
            function toggleMobileMenu() {
                const menu = document.getElementById('mobile-menu');
                menu.classList.toggle('hidden');
            }

            // 2. Simulasi Auth (Login/Logout)
            // Fungsi ini hanya untuk demo, agar Anda bisa melihat tampilan Guest vs User
            function toggleAuth(isLoggedIn) {
                // Desktop Elements
                const desktopGuest = document.getElementById('desktop-guest');
                const desktopUser = document.getElementById('desktop-user');

                // Mobile Elements
                const mobileGuest = document.getElementById('mobile-guest-actions');
                const mobileUser = document.getElementById('mobile-user-actions');
                const mobileProfile = document.getElementById('mobile-profile-section');
                const mobileUserIcon = document.getElementById('mobile-user-icon');

                if (isLoggedIn) {
                    // Tampilkan User, Sembunyikan Guest
                    desktopGuest.classList.add('hidden');
                    desktopUser.classList.remove('hidden');

                    mobileGuest.classList.add('hidden');
                    mobileUser.classList.remove('hidden');
                    mobileProfile.classList.remove('hidden');
                    mobileProfile.classList.add('flex'); // Ensure flex
                    mobileUserIcon.classList.remove('hidden');
                } else {
                    // Tampilkan Guest, Sembunyikan User
                    desktopGuest.classList.remove('hidden');
                    desktopUser.classList.add('hidden');

                    mobileGuest.classList.remove('hidden');
                    mobileUser.classList.add('hidden');
                    mobileProfile.classList.add('hidden');
                    mobileProfile.classList.remove('flex');
                    mobileUserIcon.classList.add('hidden');
                }
            }

            // Initialize (Default: Belum Login)
            toggleAuth(false);
        </script>

        <script>
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');

            // Fungsi Buka Modal
            function openModal(src) {
                // Set gambar source
                modalImg.src = src;

                // Tampilkan container (hapus hidden, set flex)
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                // Animasi masuk (sedikit delay agar transisi CSS berjalan)
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalImg.classList.remove('scale-95');
                    modalImg.classList.add('scale-100');
                }, 10);

                // Matikan scroll body agar tidak bisa scroll ke bawah saat modal terbuka
                document.body.style.overflow = 'hidden';
            }

            // Fungsi Tutup Modal
            function closeModal() {
                // Animasi keluar
                modal.classList.add('opacity-0');
                modalImg.classList.remove('scale-100');
                modalImg.classList.add('scale-95');

                // Tunggu animasi selesai baru hide elemen
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    modalImg.src = ''; // Reset src
                }, 300); // Sesuaikan dengan duration-300 di CSS

                // Kembalikan scroll body
                document.body.style.overflow = 'auto';
            }

            // Event Listener: Tutup dengan tombol ESC
            document.addEventListener('keydown', function(event) {
                if (event.key === "Escape" && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        </script>

        <script>
            // 1. Fungsi Hapus Produk Satuan
            function deleteProduct(button) {
                // Cari elemen card terdekat (parent dari tombol)
                const productCard = button.closest('.product-card');

                if (productCard) {
                    // Tambahkan class animasi fade-out
                    productCard.classList.add('fade-out-scale');

                    // Tunggu animasi selesai (300ms) baru hapus elemen
                    setTimeout(() => {
                        productCard.remove();
                        updateCounter(); // Panggil fungsi update jumlah
                    }, 300);
                }
            }

            // 2. Fungsi Hapus Semua Produk
            function deleteAllProducts() {
                Swal.fire({
                    title: 'Hapus Perbandingan?',
                    text: "Semua produk akan dihapus dari daftar perbandingan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#cbd5e1',
                    confirmButtonText: 'Ya, Hapus Semua',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const grid = document.getElementById('comparison-grid');
                        const badge = document.getElementById('vs-badge');

                        // Efek visual sebelum menghapus
                        grid.style.opacity = '0';
                        if (badge) badge.style.opacity = '0';

                        setTimeout(() => {
                            grid.innerHTML = ''; // Kosongkan Grid
                            updateCounter(); // Update UI ke state kosong

                            // Kembalikan opacity untuk menampilkan empty state
                            grid.style.opacity = '1';

                            Swal.fire(
                                'Terhapus!',
                                'Daftar perbandingan telah dikosongkan.',
                                'success'
                            )
                        }, 300);
                    }
                })
            }

            // 3. Fungsi Update Counter & Cek Empty State
            function updateCounter() {
                const grid = document.getElementById('comparison-grid');
                const products = grid.querySelectorAll('.product-card');
                const count = products.length;

                const counterText = document.getElementById('product-counter-text');
                const counterContainer = document.getElementById('product-counter-container');
                const vsBadge = document.getElementById('vs-badge');

                // Update Text Jumlah
                if (count > 0) {
                    counterText.textContent = `${count} Produk dipilih`;

                    // Atur visibilitas VS Badge (hanya muncul jika ada > 1 produk)
                    if (count > 1) {
                        if (vsBadge) vsBadge.classList.remove('hidden');
                    } else {
                        if (vsBadge) vsBadge.classList.add('hidden');
                    }

                } else {
                    // KONDISI KOSONG (EMPTY STATE)
                    counterContainer.innerHTML = `<p class="text-xs text-red-500 font-bold">Tidak ada produk</p>`;
                    if (vsBadge) vsBadge.classList.add('hidden');

                    // Inject HTML Empty State ke dalam Grid
                    grid.classList.remove('lg:grid-cols-2'); // Hapus grid 2 kolom agar empty state di tengah
                    grid.classList.add('place-items-center');

                    grid.innerHTML = `
                        <div class="col-span-1 w-full flex flex-col items-center justify-center py-16 text-center animate-[fadeIn_0.5s_ease-in-out]">
                            <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mb-6 ring-4 ring-white shadow-sm">
                                <i class="fas fa-box-open text-4xl text-slate-300"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-2">Perbandingan Kosong</h3>
                            <p class="text-slate-500 mb-8 max-w-md leading-relaxed">
                                Anda belum memilih paket apapun. Silakan cari paket umroh terbaik untuk dibandingkan fasilitasnya.
                            </p>
                            <a href="/marketplace/#produk" 
                               class="px-8 py-3.5 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-orange-200 hover:-translate-y-1">
                                <i class="ph-bold ph-magnifying-glass mr-2"></i> Cari Paket Umroh
                            </a>
                        </div>
                    `;
                }
            }
        </script>

    </body>

</x-layouts.marketplace>
