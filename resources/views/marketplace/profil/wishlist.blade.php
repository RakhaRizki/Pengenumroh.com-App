<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Wishlist - Pengenumroh</title>
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }

        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* seat bar */
        @keyframes move-stripes {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 40px 0;
            }
        }

        /* Animasi tambahan agar bar terlihat berdenyut cahayanya */
        @keyframes glow-pulse {

            0%,
            100% {
                filter: brightness(1);
                box-shadow: 0 0 5px rgba(255, 120, 46, 0.4);
            }

            50% {
                filter: brightness(1.15);
                box-shadow: 0 0 15px rgba(255, 120, 46, 0.8);
            }
        }

        .progress-orange-animated {
            /* Warna Dasar Oranye Terang (Lebih Vibrant) */
            background-color: #ff782e;

            /* Lapisan Garis Putih dengan Opacity yang disesuaikan agar tidak membuat kusam */
            background-image: linear-gradient(45deg,
                    rgba(255, 255, 255, 0.4) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.4) 50%,
                    rgba(255, 255, 255, 0.4) 75%,
                    transparent 75%,
                    transparent);
            background-size: 40px 40px;

            /* Menggabungkan animasi jalan dan animasi berdenyut */
            animation: move-stripes 0.8s linear infinite, glow-pulse 2s ease-in-out infinite;

            /* Memberikan efek glossy/licin */
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>

</head>

<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

    <nav class="fixed w-full z-50 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/marketplace/" class="flex items-center gap-2 group">
                    <img src="/assets/img/marketplace/logo.png" alt="Logo PengenUmroh"
                        class="h-10 w-auto object-contain">
                </a>

                <div class="hidden lg:flex items-center gap-4">
                    <a href="/marketplace/"
                        class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-600 transition bg-slate-50 px-4 py-2 rounded-full border border-slate-100 hover:bg-orange-50 hover:border-orange-100">
                        <i class="ph-bold ph-arrow-left"></i> Kembali ke Beranda
                    </a>

                    <div class="h-6 w-px bg-slate-200 mx-2"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-700">Rakha Rizki</p>
                            <p class="text-[10px] text-slate-500">Jamaah</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                            <img src="https://ui-avatars.com/api/?name=Rakha+Rizki&background=F97316&color=fff"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <div class="lg:hidden">
                    <a href="/marketplace/" class="text-slate-700 hover:text-orange-600">
                        <i class="ph-bold ph-house text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-28 pb-10 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <div class="lg:col-span-1 space-y-6" data-aos="fade-right">

                    <div
                        class="bg-white rounded-2xl p-6 border border-slate-200 text-center shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-orange-100 to-orange-50">
                        </div>
                        <div class="relative z-10">
                            <div
                                class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow-md overflow-hidden bg-slate-100 mb-3">
                                <img src="https://ui-avatars.com/api/?name=Rakha+Rizki&background=F97316&color=fff"
                                    class="w-full h-full object-cover">
                            </div>
                            <h2 class="text-lg font-bold text-slate-900">Rakha Rizki</h2>
                            <p class="text-sm text-slate-500">Bergabung sejak 2024</p>

                            <div class="mt-4 text-left">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-600">Kelengkapan Data</span>
                                    <span class="font-bold text-orange-600">80%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full w-[80%]"></div>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1 italic">*Lengkapi data untuk kemudahan Umroh.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <nav class="flex flex-col">
                            <a href="{{ route('marketplace.profil.index') }}"
                                class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition border-l-4 border-transparent">
                                <i class="ph-bold ph-user text-xl"></i> Profil
                            </a>
                            <a href="{{ route('marketplace.profil.pesanan') }}"
                                class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition border-l-4 border-transparent">
                                <i class="ph-bold ph-ticket text-xl"></i> Pesanan
                            </a>

                            <a href="{{ route('marketplace.profil.wishlist') }}"
                                class="flex items-center gap-3 px-5 py-4 bg-orange-50 text-orange-700 font-bold border-l-4 border-orange-600">
                                <i class="ph-bold ph-heart text-xl"></i> Wishlist
                            </a>

                        </nav>

                        <!-- <div class="mt-auto border-t border-slate-100 p-2 bg-slate-50">
                            <button onclick="confirmLogout()"
                                class="flex w-full items-center justify-center gap-2 px-5 py-3 text-red-600 hover:bg-red-100/50 hover:text-red-700 font-bold transition rounded-xl text-sm border border-transparent hover:border-red-100">
                                <i class="ph-bold ph-sign-out text-lg"></i> Keluar Akun
                            </button>
                        </div> -->
                    </div>
                </div>

                <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="100">

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 min-h-[600px]">

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">Wishlist</h1>
                                <p class="text-slate-500 text-sm mt-1">Paket impian yang Anda simpan.</p>
                            </div>
                            <div class="relative w-full md:w-64">
                                <i
                                    class="ph-bold ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" placeholder="Cari paket..."
                                    class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-1 focus:ring-orange-500 transition">
                            </div>
                        </div>

                        <div id="wishlist-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                            <div class="wishlist-item group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full"
                                data-category="9hari">
                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                                    <img src="/assets/img/marketplace/produk-dummy.png"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                        alt="Umroh">
                                    <button onclick="removeItem(this)"
                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white text-red-500 shadow-md flex items-center justify-center hover:bg-red-50 transition z-10 border border-slate-100"
                                        title="Hapus dari Wishlist">
                                        <i class="ph-fill ph-heart text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="min-h-[3.5rem]">
                                        <h3
                                            class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                            Umroh Easy 22 Juni 2026
                                        </h3>
                                    </div>
                                    <div class="flex-grow space-y-3 mb-6">
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Makkah: Lemeridien
                                                Tower ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Madinah: Jiwal Al
                                                Saha ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-airplane-tilt text-blue-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Oman Air</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-calendar-blank text-green-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600">22 Juni 2026</p>
                                        </div>
                                        <div class="pt-2">
                                            <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                                <span class="text-slate-500 uppercase tracking-tighter">Seat
                                                    Tersisa</span>
                                                <span class="text-[#ff782e] font-black">3 / 45</span>
                                            </div>

                                            <div
                                                class="w-full bg-slate-200 h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                                <div class="progress-orange-animated h-full rounded-full transition-all duration-700"
                                                    style="width: 88%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">
                                                Mulai
                                                Dari</p>
                                            <p class="text-xl font-black text-slate-900">Rp 28.9 <span
                                                    class="text-sm">Jt</span></p>
                                        </div>
                                        <a href="/marketplace/paket1/"
                                            class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30">
                                            <i class="ph-bold ph-arrow-right text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="wishlist-item group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full"
                                data-category="ramadhan">
                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                                    <img src="/assets/img/marketplace/produk-dummy2.png"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                        alt="Umroh">
                                    <button onclick="removeItem(this)"
                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white text-red-500 shadow-md flex items-center justify-center hover:bg-red-50 transition z-10 border border-slate-100"
                                        title="Hapus dari Wishlist">
                                        <i class="ph-fill ph-heart text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="min-h-[3.5rem]">
                                        <h3
                                            class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                            Umroh Libur Lebaran 23 Maret 2026
                                        </h3>
                                    </div>
                                    <div class="flex-grow space-y-3 mb-6">
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Makkah: Waha Ajyad
                                                ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Madinah: Odst
                                                Almadinah ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-airplane-tilt text-blue-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Garuda Indonesia
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-calendar-blank text-green-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600">23 Maret 2026</p>
                                        </div>
                                        <div class="pt-2">
                                            <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                                <span class="text-slate-500 uppercase tracking-tighter">Seat
                                                    Tersisa</span>
                                                <span class="text-[#ff782e] font-black">12 / 45</span>
                                            </div>

                                            <div
                                                class="w-full bg-slate-200 h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                                <div class="progress-orange-animated h-full rounded-full transition-all duration-700"
                                                    style="width: 70%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">
                                                Mulai
                                                Dari</p>
                                            <p class="text-xl font-black text-slate-900">Rp 31.9 <span
                                                    class="text-sm">Jt</span></p>
                                        </div>
                                        <a href="/marketplace/paket2/"
                                            class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30">
                                            <i class="ph-bold ph-arrow-right text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="wishlist-item group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full"
                                data-category="haji">
                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                                    <img src="/assets/img/marketplace/produk1.jpg"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                        alt="Umroh">
                                    <button onclick="removeItem(this)"
                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white text-red-500 shadow-md flex items-center justify-center hover:bg-red-50 transition z-10 border border-slate-100"
                                        title="Hapus dari Wishlist">
                                        <i class="ph-fill ph-heart text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="min-h-[3.5rem]">
                                        <h3
                                            class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                            Haji Furoda Langsung Berangkat
                                        </h3>
                                    </div>
                                    <div class="flex-grow space-y-3 mb-6">
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Makkah: Zamzam ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Madinah: Rawda
                                                Royal ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-airplane-tilt text-blue-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Saudia Airlines
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-calendar-blank text-green-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600">Juni 2025</p>
                                        </div>
                                        <div class="pt-2">
                                            <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                                <span class="text-slate-500 uppercase tracking-tighter">Seat
                                                    Tersisa</span>
                                                <span class="text-[#ff782e] font-black">2 / 45</span>
                                            </div>

                                            <div
                                                class="w-full bg-slate-200 h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                                <div class="progress-orange-animated h-full rounded-full transition-all duration-700"
                                                    style="width: 93%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">
                                                Mulai
                                                Dari</p>
                                            <p class="text-xl font-black text-slate-900">USD 14,500</p>
                                        </div>
                                        <a href="/marketplace/wishlist/"
                                            class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30">
                                            <i class="ph-bold ph-arrow-right text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="wishlist-item group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full"
                                data-category="9hari">
                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                                    <img src="/assets/img/marketplace/produk1.jpg"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                        alt="Umroh">
                                    <button onclick="removeItem(this)"
                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white text-red-500 shadow-md flex items-center justify-center hover:bg-red-50 transition z-10 border border-slate-100"
                                        title="Hapus dari Wishlist">
                                        <i class="ph-fill ph-heart text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="min-h-[3.5rem]">
                                        <h3
                                            class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                            Paket Hemat 9 Hari Reguler
                                        </h3>
                                    </div>
                                    <div class="flex-grow space-y-3 mb-6">
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Makkah: Al Ansar
                                                ⭐4
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Madinah: Rawda
                                                Royal ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-airplane-tilt text-blue-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Lion Air</p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-calendar-blank text-green-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600">05 Mar 2025</p>
                                        </div>
                                        <div class="pt-2">
                                            <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                                <span class="text-slate-500 uppercase tracking-tighter">Seat
                                                    Tersisa</span>
                                                <span class="text-[#ff782e] font-black">2 / 45</span>
                                            </div>

                                            <div
                                                class="w-full bg-slate-200 h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                                <div class="progress-orange-animated h-full rounded-full transition-all duration-700"
                                                    style="width: 93%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">
                                                Mulai
                                                Dari</p>
                                            <p class="text-xl font-black text-slate-900">Rp 24.5 <span
                                                    class="text-sm">Jt</span></p>
                                        </div>
                                        <a href="/marketplace/wishlist/"
                                            class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30">
                                            <i class="ph-bold ph-arrow-right text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="wishlist-item group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full"
                                data-category="ramadhan">
                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                                    <img src="/assets/img/marketplace/produk1.jpg"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                        alt="Umroh">
                                    <button onclick="removeItem(this)"
                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white text-red-500 shadow-md flex items-center justify-center hover:bg-red-50 transition z-10 border border-slate-100"
                                        title="Hapus dari Wishlist">
                                        <i class="ph-fill ph-heart text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="min-h-[3.5rem]">
                                        <h3
                                            class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                            Paket Umroh Awal Ramadhan 2025 Hemat
                                        </h3>
                                    </div>
                                    <div class="flex-grow space-y-3 mb-6">
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Makkah: Fairmont
                                                ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Madinah: Rawda
                                                Royal ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-airplane-tilt text-blue-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Garuda Indonesia
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-calendar-blank text-green-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600">25 Feb 2025</p>
                                        </div>
                                        <div class="pt-2">
                                            <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                                <span class="text-slate-500 uppercase tracking-tighter">Seat
                                                    Tersisa</span>
                                                <span class="text-[#ff782e] font-black">2 / 45</span>
                                            </div>

                                            <div
                                                class="w-full bg-slate-200 h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                                <div class="progress-orange-animated h-full rounded-full transition-all duration-700"
                                                    style="width: 93%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">
                                                Mulai
                                                Dari</p>
                                            <p class="text-xl font-black text-slate-900">Rp 32.5 <span
                                                    class="text-sm">Jt</span></p>
                                        </div>
                                        <a href="/marketplace/wishlist/"
                                            class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30">
                                            <i class="ph-bold ph-arrow-right text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="wishlist-item group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full"
                                data-category="haji">
                                <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                                    <img src="/assets/img/marketplace/produk1.jpg"
                                        class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                        alt="Umroh">
                                    <button onclick="removeItem(this)"
                                        class="absolute top-3 right-3 w-8 h-8 rounded-full bg-white text-red-500 shadow-md flex items-center justify-center hover:bg-red-50 transition z-10 border border-slate-100"
                                        title="Hapus dari Wishlist">
                                        <i class="ph-fill ph-heart text-lg"></i>
                                    </button>
                                </div>
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="min-h-[3.5rem]">
                                        <h3
                                            class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                            Haji Furoda Langsung Berangkat
                                        </h3>
                                    </div>
                                    <div class="flex-grow space-y-3 mb-6">
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Makkah: Zamzam ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Madinah: Rawda
                                                Royal ⭐5
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-airplane-tilt text-blue-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600 truncate">Saudia Airlines
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <i
                                                class="ph-duotone ph-calendar-blank text-green-500 text-xl flex-shrink-0"></i>
                                            <p class="text-sm font-semibold text-slate-600">Juni 2025</p>
                                        </div>
                                        <div class="pt-2">
                                            <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                                <span class="text-slate-500 uppercase tracking-tighter">Seat
                                                    Tersisa</span>
                                                <span class="text-[#ff782e] font-black">2 / 45</span>
                                            </div>

                                            <div
                                                class="w-full bg-slate-200 h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                                <div class="progress-orange-animated h-full rounded-full transition-all duration-700"
                                                    style="width: 93%">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                        <div>
                                            <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">
                                                Mulai
                                                Dari</p>
                                            <p class="text-xl font-black text-slate-900">USD 14,500</p>
                                        </div>
                                        <a href="/marketplace/wishlist/"
                                            class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30">
                                            <i class="ph-bold ph-arrow-right text-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div id="empty-state"
                            class="hidden flex-col items-center justify-center py-20 text-center h-full">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <i class="ph-duotone ph-heart-break text-5xl text-slate-300"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Wishlist Kosong</h3>
                            <p class="text-slate-500 text-sm mt-1 mb-6 max-w-xs">Anda belum menyimpan paket impian
                                apapun.
                            </p>
                            <a href="/marketplace/#produk"
                                class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/30 transition">
                                Cari Paket Umroh
                            </a>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Fungsi Logout dengan UX yang Jelas
        function confirmLogout() {
            Swal.fire({
                title: 'Keluar dari Akun?',
                text: "Anda harus masuk kembali untuk mengakses Profil & Pesanan.",
                icon: 'warning',
                iconColor: '#dc2626', // Merah agar terlihat warning
                showCancelButton: true,
                confirmButtonColor: '#dc2626', // Merah untuk aksi logout
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Keluar Akun',
                cancelButtonText: 'Batal',
                reverseButtons: true // UX Pattern: Tombol batal di kiri
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil Keluar',
                        text: 'Mengalihkan ke beranda...',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/marketplace/'; // Redirect
                    });
                }
            });
        }

        function removeItem(button) {
            Swal.fire({
                title: 'Hapus dari Wishlist?',
                text: "Paket ini akan dihapus dari daftar simpan Anda.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ea580c',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const card = button.closest('.wishlist-item');

                    // Animation out
                    card.style.transition = "all 0.3s ease";
                    card.style.opacity = "0";
                    card.style.transform = "scale(0.9)";

                    setTimeout(() => {
                        card.remove();
                        checkEmpty();

                        // Show toast
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: false
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Dihapus dari wishlist'
                        });
                    }, 300);
                }
            });
        }

        function checkEmpty() {
            const container = document.getElementById('wishlist-container');
            const emptyState = document.getElementById('empty-state');

            if (container.children.length === 0) {
                container.classList.add('hidden');
                emptyState.classList.remove('hidden');
                emptyState.classList.add('flex');
            }
        }
    </script>
</body>

</html>
