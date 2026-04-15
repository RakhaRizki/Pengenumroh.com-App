<!doctype html>
<html lang="id">

<head>
    <title>Umroh Easy 26 Juni 2026 - Pengenumroh</title>
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #1E293B;
            -webkit-tap-highlight-color: transparent;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
        }

        .timeline-line::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 20px;
            width: 2px;
            background: #E2E8F0;
            z-index: 0;
        }

        /* Radio Card Styling */
        .radio-card:checked+div {
            border-color: #F97316;
            background-color: #FFF7ED;
            box-shadow: 0 4px 6px -1px rgba(249, 115, 22, 0.1);
        }

        .radio-card:checked+div .check-icon {
            opacity: 1;
            transform: scale(1);
        }

        /* Modal / Lightbox */
        #lightbox {
            transition: opacity 0.3s ease;
        }

        #lightbox.hidden {
            opacity: 0;
            pointer-events: none;
        }

        #lightbox:not(.hidden) {
            opacity: 1;
            pointer-events: auto;
        }

        /* Active Tab Styling */
        .tab-link.active {
            border-color: #F97316;
            color: #EA580C;
        }
    </style>
</head>

<body class="antialiased">

    <nav class="fixed w-full z-50 transition-all duration-300" id="navbar">
        <div class="bg-white border-b border-slate-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">

                    <a href="/marketplace/" class="flex items-center gap-2 group">
                        <div
                            class="flex-shrink-0 flex items-center cursor-pointer transform hover:scale-105 transition duration-300">
                            <img src="/assets/img/marketplace/logo.png" alt="Logo PengenUmroh"
                                class="h-10 w-auto object-contain">
                        </div>
                    </a>

                    <div class="hidden lg:flex space-x-8">
                        <a href="/marketplace/"
                            class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                            Beranda
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="#produk"
                            class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                            Produk
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="#mitra"
                            class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                            Mitra
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('marketplace.bandingkan') }}"
                            class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                            Perbandingan
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('marketplace.produk.haji-khusus') }}"
                            class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                            Haji Khusus
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('company.beranda') }}"
                            class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                            Tentang Kami
                            <span
                                class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                        </a>
                    </div>

                    <div class="hidden lg:flex items-center gap-4">

                        <div id="desktop-guest" class="flex items-center gap-4">
                            <a href="#" onclick="toggleAuth(true)"
                                class="text-sm font-bold text-slate-500 hover:text-orange-600 transition">
                                Masuk
                            </a>
                            <a href="#" onclick="toggleAuth(true)"
                                class="px-5 py-2.5 bg-slate-900 hover:bg-orange-600 text-white text-sm font-bold rounded-full transition-all duration-300 shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-0.5 flex items-center gap-2">
                                <i class="ph-bold ph-note-pencil"></i> Daftar Sekarang
                            </a>
                        </div>

                        <div id="desktop-user" class="hidden relative group">
                            <button
                                class="flex items-center gap-3 pl-3 pr-1 py-1 bg-white border border-slate-200 rounded-full hover:shadow-md transition-all group-hover:border-orange-200">
                                <div class="text-right">
                                    <p class="text-xs font-bold text-slate-700">Rakha Rizki</p>
                                    <p class="text-[10px] text-slate-500">Jamaah</p>
                                </div>
                                <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                                    <img src="https://ui-avatars.com/api/?name=Rakha+Rizki&background=F97316&color=fff"
                                        alt="Profile" class="w-full h-full object-cover">
                                </div>
                                <i
                                    class="ph-bold ph-caret-down text-slate-400 pr-2 group-hover:text-orange-500 transition"></i>
                            </button>

                             <div
                                class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50 overflow-hidden">
                                <div class="py-2">
                                    <a href="{{ route('marketplace.profil.index') }}"
                                        class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition">
                                        <i class="ph-bold ph-user mr-3 text-lg"></i> Profil
                                    </a>
                                    <a href="{{ route('marketplace.profil.pesanan') }}"
                                        class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition">
                                        <i class="ph-bold ph-ticket mr-3 text-lg"></i> Pesanan
                                    </a>
                                    <a href="{{ route('marketplace.profil.wishlist') }}"
                                        class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition">
                                        <i class="ph-bold ph-heart mr-3 text-lg"></i> Wishlist
                                    </a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="#" onclick="toggleAuth(false)"
                                        class="flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                        <i class="ph-bold ph-sign-out mr-3 text-lg"></i> Keluar
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="lg:hidden flex items-center gap-3">
                        <div id="mobile-user-icon"
                            class="hidden w-8 h-8 rounded-full bg-orange-100 overflow-hidden border border-orange-200 cursor-pointer"
                            onclick="toggleMobileMenu()">
                            <img src="https://ui-avatars.com/api/?name=Rakha+Rizki&background=F97316&color=fff"
                                class="w-full h-full object-cover">
                        </div>

                        <button id="mobile-menu-btn" onclick="toggleMobileMenu()"
                            class="text-slate-700 hover:text-orange-600 focus:outline-none p-1">
                            <i class="ph ph-list text-3xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div id="mobile-menu"
                class="hidden lg:hidden bg-white border-t border-slate-100 absolute w-full left-0 shadow-xl max-h-[85vh] overflow-y-auto">
                <div class="px-4 pt-4 pb-6 space-y-2">

                    <div id="mobile-profile-section"
                        class="hidden mb-4 p-4 bg-orange-50 rounded-xl border border-orange-100 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-white border border-orange-200 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=Rakha+Rizki&background=F97316&color=fff"
                                class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">Rakha Rizki</p>
                            <p class="text-xs text-slate-500">rakharizki@gmail.com</p>
                        </div>
                    </div>

                     <a href="/marketplace/"
                        class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Beranda</a>
                    <a href="#produk"
                        class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Produk</a>
                    <a href="#mitra"
                        class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Mitra</a>
                    <a href="{{ route('marketplace.bandingkan') }}"
                        class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Perbandingan</a>
                    <a href="{{ route('marketplace.produk.haji-khusus') }}"
                        class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Haji
                        Khusus</a>
                    <a href="{{ route('company.beranda') }}"
                        class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Tentang
                        Kami</a>

                    <div class="border-t border-slate-100 my-2"></div>

                     <div id="mobile-guest-actions" class="space-y-2 pt-2">
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center w-full py-3 rounded-xl font-bold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Masuk</a>
                        <a href="{{ route('register') }}"
                            class="flex items-center justify-center w-full py-3 bg-slate-900 text-white font-bold rounded-xl shadow-md active:scale-95 transition">Daftar
                            Sekarang</a>
                    </div>

                    <div id="mobile-user-actions" class="hidden space-y-2">
                        <a href="{{ route('marketplace.profil.pesanan') }}"
                            class="flex items-center px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">
                            <i class="ph-bold ph-ticket mr-3"></i> Pesanan
                        </a>
                        <a href="{{ route('marketplace.profil.index') }}"
                            class="flex items-center px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">
                            <i class="ph-bold ph-user mr-3"></i> Profil
                        </a>
                        <a href="{{ route('marketplace.profil.wishlist') }}"
                            class="flex items-center px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">
                            <i class="ph-bold ph-heart mr-3"></i> Wishlist
                        </a>
                        <a href="#karir"
                            class="flex items-center px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition">
                            <i class="ph-bold ph-briefcase mr-3"></i> Karir
                        </a>
                        <button onclick="toggleAuth(false)"
                            class="w-full mt-2 py-3 text-red-600 font-bold hover:bg-red-50 rounded-xl transition">Keluar</button>
                    </div>

                </div>
            </div>
        </div>
    </nav>

    <main class="pt-32 pb-32 md:pb-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <nav class="flex mb-6 text-sm text-gray-500" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">

                <li class="inline-flex items-center">
                    <a href="/marketplace/"
                        class="inline-flex items-center hover:text-orange-600 transition-colors duration-200">
                        <i class="ph ph-house mr-2 text-lg"></i>
                        Beranda
                    </a>
                </li>

                <li>
                    <i class="ph ph-caret-right text-gray-400"></i>
                </li>

                <li>
                    <div class="flex items-center">
                        <a href="#" class="hover:text-orange-600 transition-colors duration-200">
                            Reguler 9 Hari
                        </a>
                    </div>
                </li>

                <li>
                    <i class="ph ph-caret-right text-gray-400"></i>
                </li>

                <li>
                    <div class="flex items-center">
                        <a href="#" class="hover:text-orange-600 transition-colors duration-200">
                            Mutiara Sunnah Travel
                        </a>
                    </div>
                </li>

                <li>
                    <i class="ph ph-caret-right text-gray-400"></i>
                </li>

                <li aria-current="page">
                    <span class="text-gray-900 font-bold">Umroh Easy 22 Juni 2026</span>
                </li>

            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">

            <div class="lg:col-span-2 space-y-8">

                <div class="flex flex-col gap-4 mb-8">

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="relative w-full aspect-[3/4] md:aspect-auto md:h-[700px] md:col-span-3 rounded-2xl overflow-hidden shadow-sm group cursor-pointer"
                            onclick="openLightbox(this)">
                            <img src="/assets/img/marketplace/produk-dummy.png"
                                class="w-full h-full object-cover transition duration-700 ease-in-out group-hover:scale-105"
                                alt="Ka'bah">
                        </div>

                        <div class="hidden md:grid md:col-span-1 grid-rows-2 gap-4 h-[700px]">
                            <div class="relative rounded-2xl overflow-hidden cursor-pointer group shadow-sm"
                                onclick="openLightbox(this)">
                                <img src="/assets/img/marketplace/lemeredien-tower.jpg"
                                    class="w-full h-full object-cover hover:scale-110 transition duration-500"
                                    alt="Madinah">
                            </div>
                            <div class="relative rounded-2xl overflow-hidden cursor-pointer group shadow-sm"
                                onclick="openLightbox(this)">
                                <img src="/assets/img/marketplace/al-saha.webp"
                                    class="w-full h-full object-cover hover:scale-110 transition duration-500"
                                    alt="Hotel Room">
                                <!-- <div
                                    class="absolute inset-0 bg-black/40 flex items-center justify-center group-hover:bg-black/50 transition">
                                    <span class="text-white font-bold text-sm">+3 Foto</span>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <div class="flex md:hidden gap-3 overflow-x-auto no-scrollbar pb-2">
                        <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden border-2 border-orange-500">
                            <img src="/assets/img/marketplace/produk-dummy.png" class="w-full h-full object-cover">
                        </div>
                        <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden grayscale opacity-70 cursor-pointer"
                            onclick="openLightbox(this)">
                            <img src="/assets/img/marketplace/lemeredien-tower.jpg" class="w-full h-full object-cover">
                        </div>
                        <div class="w-20 h-20 flex-shrink-0 rounded-lg overflow-hidden grayscale opacity-70 cursor-pointer"
                            onclick="openLightbox(this)">
                            <img src="/assets/img/marketplace/al-saha.webp" class="w-full h-full object-cover">
                        </div>
                    </div>

                </div>

                <div class="space-y-4">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <span
                                class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-md font-bold uppercase tracking-wide mb-2 inline-block">Paket
                                Reguler 9 Hari</span>
                            <h1 class="text-2xl md:text-4xl font-bold text-gray-900 leading-tight">Umroh Easy 22 Juni
                                2026</h1>
                            <div class="flex items-center gap-2 mt-2 text-gray-500 text-sm">
                                <i class="ph-fill ph-calendar-blank text-orange-500 text-lg"></i> <span>22 Juni
                                    2026</span>
                                <span class="mx-1">•</span>
                                <i class="ph-fill ph-clock text-orange-500 text-lg"></i> <span>9 Hari</span>
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-200">

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div
                            class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-airplane-takeoff text-2xl text-orange-500 mb-1"></i>
                            <span class="text-xs text-gray-500">Keberangkatan</span>
                            <span class="text-sm font-bold text-gray-800">Jakarta (CGK)</span>
                        </div>
                        <div
                            class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-airplane-takeoff text-2xl text-orange-500 mb-1"></i>
                            <span class="text-xs text-gray-500">Maskapai</span>
                            <span class="text-sm font-bold text-gray-800">Oman Air</span>
                        </div>
                        <div
                            class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-buildings text-2xl text-orange-500 mb-1"></i>
                            <span class="text-xs text-gray-500">Hotel Mekkah</span>
                            <span class="text-sm font-bold text-gray-800">Lemeridien Tower</span>
                        </div>
                        <div
                            class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-map-pin text-2xl text-orange-500 mb-1"></i>
                            <span class="text-xs text-gray-500">Jarak Hotel Makkah</span>
                            <span class="text-sm font-bold text-gray-800">± by shuttle</span>
                        </div>
                        <div
                            class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-buildings text-2xl text-orange-500 mb-1"></i>
                            <span class="text-xs text-gray-500">Hotel Madinah</span>
                            <span class="text-sm font-bold text-gray-800">Jiwal Al Saha</span>
                        </div>
                        <div
                            class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-map-pin text-2xl text-orange-500 mb-1"></i>
                            <span class="text-xs text-gray-500">Jarak Hotel Madinah</span>
                            <span class="text-sm font-bold text-gray-800">± 500m</span>
                        </div>
                        <div
                            class="bg-white p-3 rounded-xl border border-gray-100 shadow-sm flex flex-col items-center text-center">
                            <i class="ph-duotone ph-users-three text-2xl text-orange-500 mb-1"></i>
                            <span class="text-xs text-gray-500">Biro Travel</span>
                            <span class="text-sm font-bold text-gray-800">Mutiara Sunnah Travel</span>
                        </div>
                    </div>
                </div>

                <div class="sticky top-20 z-30 bg-[#F8FAFC] pt-2 pb-4 transition-all" id="sticky-tabs">
                    <div class="flex space-x-6 border-b border-gray-200 overflow-x-auto no-scrollbar">
                        <a href="#hotel"
                            class="tab-link pb-3 border-b-2 font-semibold text-sm whitespace-nowrap transition active"
                            data-target="hotel">Akomodasi</a>
                        <a href="#fasilitas"
                            class="tab-link pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm whitespace-nowrap transition"
                            data-target="fasilitas">Fasilitas</a>
                        <a href="#itinerary"
                            class="tab-link pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm whitespace-nowrap transition"
                            data-target="itinerary">Rencana Perjalanan</a>
                        <a href="#syarat"
                            class="tab-link pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm whitespace-nowrap transition"
                            data-target="syarat">Syarat & Ketentuan</a>
                        <a href="#catatan"
                            class="tab-link pb-3 border-b-2 border-transparent text-gray-500 hover:text-gray-800 font-medium text-sm whitespace-nowrap transition"
                            data-target="catatan">Catatan & Deskripsi</a>
                    </div>
                </div>

                <section id="hotel" class="scroll-mt-40">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Akomodasi & Hotel</h3>
                    <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row gap-6">
                            <img src="/assets/img/marketplace/lemeredien-tower.jpg"
                                class="w-full md:w-1/3 rounded-lg object-cover h-48 cursor-pointer"
                                onclick="openLightbox(this)" alt="Fairmont Hotel">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="text-lg font-bold text-gray-800">Lemeridien Tower</h4>
                                    <span class="flex text-yellow-400 text-xs">⭐⭐⭐⭐⭐</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1"><i
                                        class="ph-fill ph-map-pin text-gray-400"></i> by shuttle</p>
                                <ul class="mt-4 space-y-2">
                                    <li class="flex items-center text-sm text-gray-600 gap-2"><i
                                            class="ph-fill ph-check-circle text-green-500"></i>Restoran, WIFI, Brankas,
                                        AC
                                    </li>
                                    <!-- <li class="flex items-center text-sm text-gray-600 gap-2"><i
                                            class="ph-fill ph-check-circle text-green-500"></i> Full Board (Menu
                                        Indonesia)</li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="mt-5 flex flex-col md:flex-row gap-6">
                            <img src="/assets/img/marketplace/al-saha.webp"
                                class="w-full md:w-1/3 rounded-lg object-cover h-48 cursor-pointer"
                                onclick="openLightbox(this)" alt="Fairmont Hotel">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="text-lg font-bold text-gray-800">Jiwal Al Saha</h4>
                                    <span class="flex text-yellow-400 text-xs">⭐⭐⭐⭐⭐</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1 flex items-center gap-1"><i
                                        class="ph-fill ph-map-pin text-gray-400"></i> 500m</p>
                                <ul class="mt-4 space-y-2">
                                    <li class="flex items-center text-sm text-gray-600 gap-2"><i
                                            class="ph-fill ph-check-circle text-green-500"></i>Restaurant, AC, Wifi,
                                        Kulkas
                                    </li>
                                    <!-- <li class="flex items-center text-sm text-gray-600 gap-2"><i
                                            class="ph-fill ph-check-circle text-green-500"></i> Full Board (Menu
                                        Indonesia)</li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="fasilitas" class="scroll-mt-40 mt-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 px-1">Fasilitas Paket</h3>

                    <div class="grid grid-cols-1 gap-6">

                        <div
                            class="bg-white rounded-2xl p-6 md:p-8 border border-gray-100 shadow-sm transition-all hover:shadow-md">

                            <div class="flex items-start gap-4 mb-8 border-b border-gray-100 pb-6">
                                <div class="bg-green-100 p-3 rounded-full text-green-600 flex-shrink-0">
                                    <i class="ph-fill ph-check text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-lg">Harga Termasuk</h4>
                                    <p class="text-sm text-gray-500 mt-1">Benefit dan layanan lengkap yang Anda
                                        dapatkan:</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                                <div
                                    class="group flex gap-4 items-center p-2 rounded-xl hover:bg-green-50 transition-colors duration-200 cursor-pointer">
                                    <div class="flex-shrink-0">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>

                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Tiket Pesawat Internasional</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Visa Umroh</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Handling Bandara</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Handling Hotel</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Transportasi & City Tour</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Asuransi Perjalanan</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Muthawif & Tour Guide</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Makan 3x Sehari</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Zamzam 5L</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Free Ayam Al Baik</p>
                                    </div>
                                </div>

                                <div
                                    class="group flex gap-4 items-start p-2 rounded-xl hover:bg-orange-50 transition-colors duration-200">
                                    <div class="flex-shrink-0 mt-1">
                                        <i
                                            class="ph-duotone ph-check-circle text-2xl text-green-500 group-hover:scale-110 transition-transform"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 text-sm">Free Kuliner Arab / Kebab Shawarma
                                        </p>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 border-dashed">
                            <div class="flex items-center gap-3 mb-5">
                                <div class="bg-red-100 p-2 rounded-full text-red-500 flex-shrink-0">
                                    <i class="ph-fill ph-x text-lg"></i>
                                </div>
                                <h4 class="font-bold text-slate-700 text-sm uppercase tracking-wide">Harga Tidak
                                    Termasuk</h4>
                            </div>

                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
                                <li class="flex items-start gap-3 text-sm text-slate-600">
                                    <i class="ph-bold ph-minus-circle text-slate-400 mt-1"></i>
                                    <span>Pembuatan Paspor</span>
                                </li>
                                <li class="flex items-start gap-3 text-sm text-slate-600">
                                    <i class="ph-bold ph-minus-circle text-slate-400 mt-1"></i>
                                    <span>Vaksin Meningitis & Polio</span>
                                </li>
                                <li class="flex items-start gap-3 text-sm text-slate-600">
                                    <i class="ph-bold ph-minus-circle text-slate-400 mt-1"></i>
                                    <span>Kelebihan Bagasi</span>
                                </li>
                                <li class="flex items-start gap-3 text-sm text-slate-600">
                                    <i class="ph-bold ph-minus-circle text-slate-400 mt-1"></i>
                                    <span>Pengeluaran Pribadi</span>
                                </li>
                                <li class="flex items-start gap-3 text-sm text-slate-600">
                                    <i class="ph-bold ph-minus-circle text-slate-400 mt-1"></i>
                                    <span>Perlengkapan Umroh</span>
                                </li>
                            </ul>
                        </div>

                    </div>

                </section>

                <section id="itinerary" class="scroll-mt-40">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Rencana Perjalanan</h3>
                    <div class="relative timeline-line space-y-8 pl-2">
                        <div class="relative pl-10">
                            <div
                                class="absolute left-[11px] top-1 w-5 h-5 bg-orange-500 rounded-full border-4 border-white shadow-md z-10">
                            </div>
                            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari 1</span>
                                <h4 class="text-lg font-bold text-gray-900 mt-1">Keberangkatan Jakarta - Muscat</h4>
                                <p class="text-gray-600 text-sm mt-2">Keberangkatan - Transit di Oman</p>
                            </div>
                        </div>
                        <div class="relative pl-10">
                            <div
                                class="absolute left-[11px] top-1 w-5 h-5 bg-white border-4 border-orange-500 rounded-full z-10">
                            </div>
                            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari 2</span>
                                <h4 class="text-lg font-bold text-gray-900 mt-1">Muscat - Madinah</h4>
                                <p class="text-gray-600 text-sm mt-2">Tiba di Madinah - Tour Masjid Nabawi</p>
                            </div>
                        </div>

                        <div id="extra-itinerary" class="hidden space-y-8">
                            <div class="relative pl-10">
                                <div
                                    class="absolute left-[11px] top-1 w-5 h-5 bg-white border-4 border-orange-500 rounded-full z-10">
                                </div>
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari
                                        3</span>
                                    <h4 class="text-lg font-bold text-gray-900 mt-1">Madinah</h4>
                                    <p class="text-gray-600 text-sm mt-2">City Tour Madinah</p>
                                </div>
                            </div>
                            <div class="relative pl-10">
                                <div
                                    class="absolute left-[11px] top-1 w-5 h-5 bg-white border-4 border-orange-500 rounded-full z-10">
                                </div>
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari
                                        4</span>
                                    <h4 class="text-lg font-bold text-gray-900 mt-1">Madinah - Makkah</h4>
                                    <p class="text-gray-600 text-sm mt-2">Melanjutkan ke Makkah dan Melaksanakan Ibadah
                                        Umroh</p>
                                </div>
                            </div>
                            <div class="relative pl-10">
                                <div
                                    class="absolute left-[11px] top-1 w-5 h-5 bg-white border-4 border-orange-500 rounded-full z-10">
                                </div>
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari
                                        5</span>
                                    <h4 class="text-lg font-bold text-gray-900 mt-1">Makkah</h4>
                                    <p class="text-gray-600 text-sm mt-2">Tour Masjidil Haram</p>
                                </div>
                            </div>
                            <div class="relative pl-10">
                                <div
                                    class="absolute left-[11px] top-1 w-5 h-5 bg-white border-4 border-orange-500 rounded-full z-10">
                                </div>
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari
                                        6</span>
                                    <h4 class="text-lg font-bold text-gray-900 mt-1">Makkah</h4>
                                    <p class="text-gray-600 text-sm mt-2">City Tour Makkah</p>
                                </div>
                            </div>
                            <div class="relative pl-10">
                                <div
                                    class="absolute left-[11px] top-1 w-5 h-5 bg-white border-4 border-orange-500 rounded-full z-10">
                                </div>
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari
                                        7</span>
                                    <h4 class="text-lg font-bold text-gray-900 mt-1">Thaif</h4>
                                    <p class="text-gray-600 text-sm mt-2">City Tour Thaif</p>
                                </div>
                            </div>
                            <div class="relative pl-10">
                                <div
                                    class="absolute left-[11px] top-1 w-5 h-5 bg-white border-4 border-orange-500 rounded-full z-10">
                                </div>
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari
                                        8</span>
                                    <h4 class="text-lg font-bold text-gray-900 mt-1">Makkah - Jeddah - Muscat</h4>
                                    <p class="text-gray-600 text-sm mt-2">Persiapan Kepulangan - Transit di Oman</p>
                                </div>
                            </div>
                            <div class="relative pl-10">
                                <div
                                    class="absolute left-[11px] top-1 w-5 h-5 bg-white border-4 border-orange-500 rounded-full z-10">
                                </div>
                                <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm">
                                    <span class="text-xs font-bold text-orange-600 uppercase tracking-wider">Hari
                                        9</span>
                                    <h4 class="text-lg font-bold text-gray-900 mt-1">Kepulangan Muscat - Jakarta</h4>
                                    <p class="text-gray-600 text-sm mt-2">Tiba di Indonesia</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative pl-10">
                            <div class="absolute left-[11px] top-1 w-5 h-5 bg-gray-300 rounded-full z-10"></div>
                            <div class="text-center py-2">
                                <button id="toggle-itinerary-btn" onclick="toggleItinerary()"
                                    class="text-orange-500 font-semibold text-sm hover:underline flex items-center justify-center gap-1 mx-auto">
                                    Lihat itinerary lengkap <i class="ph-bold ph-caret-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <section id="syarat" class="scroll-mt-40">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Syarat & Ketentuan</h3>
                    <div class="bg-white p-6 rounded-xl border border-gray-100 text-sm text-gray-600 space-y-2">
                        <p>1. Paspor</p>
                        <p>2. KTP</p>
                        <p>3. KK</p>
                        <p>4. Buku Nikah (Suami Istri)</p>
                        <p>5. Akte (Anak)</p>
                        <p>6. Pas Foto (Latar Putih)</p>
                    </div>
                </section>

                <section id="catatan" class="scroll-mt-40">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Catatan & Deskripsi Produk</h3>

                    <div
                        class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm text-sm text-gray-600 space-y-4 leading-relaxed">

                        <div>
                            <h4 class="font-bold text-gray-800 mb-2">Tentang Paket Ini</h4>
                            <p>
                                Paket Umrah Easy ini dirancang khusus untuk jamaah yang menginginkan kenyamanan dengan
                                harga terjangkau.
                                Menggunakan maskapai Oman Air dengan pelayanan premium dan hotel yang berlokasi
                                strategis dekat dengan
                                Masjidil Haram dan Masjid Nabawi.
                            </p>
                        </div>

                        <hr class="border-gray-100">

                        <div>
                            <h4 class="font-bold text-gray-800 mb-2">Catatan Penting</h4>
                            <ul class="list-disc pl-5 space-y-1 marker:text-orange-500">
                                <li>Harga dapat berubah sewaktu-waktu mengikuti kebijakan maskapai dan kurs mata uang
                                    asing.</li>
                                <li>Jadwal perjalanan (Itinerary) bersifat tentatif dan dapat berubah menyesuaikan
                                    kondisi di lapangan
                                    tanpa mengurangi nilai ibadah.</li>
                                <li>Pelunasan pembayaran wajib dilakukan maksimal H-30 sebelum tanggal keberangkatan.
                                </li>
                                <li>Bagi jamaah lansia atau berkebutuhan khusus, diwajibkan membawa pendamping keluarga.
                                </li>
                            </ul>
                        </div>

                    </div>
                </section>

            </div>

            <div class="lg:col-span-1">
                <div class="sticky top-28 space-y-6" id="booking-card">

                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-orange-100 rounded-full opacity-50 blur-xl">
                        </div>

                        <div class="space-y-3 mb-6 relative">
                            <p class="text-sm font-semibold text-gray-800">Pilih Tipe Kamar & Jumlah</p>

                            <div
                                class="p-3 rounded-xl border border-orange-200 bg-orange-50/30 flex items-center justify-between group hover:border-orange-300 transition-all">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="bg-white p-2 rounded-lg text-orange-600 shadow-sm border border-orange-100">
                                        <i class="ph-fill ph-users-four text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800">Quad</p>
                                        <p class="text-xs text-gray-500">Rp 25,9 Jt/pax</p>
                                    </div>
                                </div>
                                <div class="flex items-center bg-white border border-gray-200 rounded-lg p-1 shadow-sm">
                                    <button onclick="updateQty('quad', -1)"
                                        class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-orange-600 transition">-</button>
                                    <input type="number" id="qty-quad" value="1" data-name="Quad" data-price="25900000"
                                        class="qty-input w-10 text-center text-sm font-bold bg-transparent focus:outline-none"
                                        readonly>
                                    <button onclick="updateQty('quad', 1)"
                                        class="w-8 h-8 flex items-center justify-center text-orange-600 transition">+</button>
                                </div>
                            </div>

                            <div
                                class="p-3 rounded-xl border border-gray-200 flex items-center justify-between group hover:border-orange-300 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gray-100 p-2 rounded-lg text-gray-600">
                                        <i class="ph-fill ph-users-three text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800">Triple</p>
                                        <p class="text-xs text-gray-500">Rp 27 Jt/pax</p>
                                    </div>
                                </div>
                                <div class="flex items-center bg-gray-50 border border-gray-200 rounded-lg p-1">
                                    <button onclick="updateQty('triple', -1)"
                                        class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-orange-600 transition">-</button>
                                    <input type="number" id="qty-triple" value="0" data-name="Triple"
                                        data-price="27000000"
                                        class="qty-input w-10 text-center text-sm font-bold bg-transparent focus:outline-none"
                                        readonly>
                                    <button onclick="updateQty('triple', 1)"
                                        class="w-8 h-8 flex items-center justify-center text-orange-600 transition">+</button>
                                </div>
                            </div>

                            <div
                                class="p-3 rounded-xl border border-gray-200 flex items-center justify-between group hover:border-orange-300 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="bg-gray-100 p-2 rounded-lg text-gray-600">
                                        <i class="ph-fill ph-users text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-gray-800">Double</p>
                                        <p class="text-xs text-gray-500">Rp 28,9 Jt/pax</p>
                                    </div>
                                </div>
                                <div class="flex items-center bg-gray-50 border border-gray-200 rounded-lg p-1">
                                    <button onclick="updateQty('double', -1)"
                                        class="w-8 h-8 flex items-center justify-center text-gray-500 hover:text-orange-600 transition">-</button>
                                    <input type="number" id="qty-double" value="0" data-name="Double"
                                        data-price="28900000"
                                        class="qty-input w-10 text-center text-sm font-bold bg-transparent focus:outline-none"
                                        readonly>
                                    <button onclick="updateQty('double', 1)"
                                        class="w-8 h-8 flex items-center justify-center text-orange-600 transition">+</button>
                                </div>
                            </div>
                        </div>

                        <div id="summary-container"
                            class="mb-4 p-3 bg-orange-50 rounded-xl border border-orange-100 border-dashed">
                            <p class="text-[10px] uppercase tracking-wider font-bold text-orange-400 mb-2">Rincian Pax
                            </p>
                            <div id="order-summary-list" class="space-y-1 text-sm font-medium text-orange-800">
                            </div>
                        </div>

                        <div class="mb-6 pt-4 border-t border-dashed border-gray-300 relative">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm text-gray-500 font-medium">Estimasi Total</span>
                                <span class="text-xs text-gray-400 font-bold" id="total-pax">1 Pax</span>
                            </div>
                            <div class="flex items-end">
                                <span class="text-3xl font-extrabold text-orange-600" id="total-price-display">Rp
                                    25.900.000</span>
                            </div>
                        </div>

                        <div class="hidden md:block">
                            <div class="flex gap-2">
                                <button onclick="toggleFavorite()" id="btn-fav-desktop"
                                    class="flex-shrink-0 w-12 h-12 lg:w-14 lg:h-14 rounded-xl border-2 border-gray-200 text-gray-400 hover:border-red-200 hover:text-red-500 hover:bg-red-50 transition-all duration-300 flex items-center justify-center group">
                                    <i id="icon-fav-desktop"
                                        class="ph-bold ph-heart text-2xl transform group-hover:scale-110 transition-transform"></i>
                                </button>

                                <button onclick="toggleCompareDetail()" id="btn-compare-detail"
                                    class="flex-shrink-0 w-12 h-12 lg:w-14 lg:h-14 rounded-xl border-2 border-gray-200 text-gray-400 hover:border-teal-400 hover:text-teal-600 hover:bg-teal-50 transition-all duration-300 flex items-center justify-center group">
                                    <i id="icon-compare-detail"
                                        class="ph-bold ph-arrows-left-right text-2xl transform group-hover:rotate-180 transition-transform duration-500"></i>
                                </button>

                                <button onclick="window.location.href='/marketplace/pesanan/'"
                                    class="flex-1 bg-orange-500 text-white font-bold py-3.5 rounded-xl hover:bg-orange-600 transition shadow-lg shadow-orange-500/30 flex justify-center items-center gap-2">
                                    <i class="ph-bold ph-chat-teardrop-text text-xl"></i>
                                    <span>Pesan Sekarang</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button onclick="contactWhatsApp()"
                        class="w-full bg-green-50 p-4 rounded-xl border border-green-100 flex gap-4 items-center hover:bg-green-100 hover:border-green-200 transition-all duration-300 group text-left">

                        <div
                            class="bg-green-500 p-2 rounded-lg text-white group-hover:scale-110 transition-transform duration-300">
                            <i class="ph-bold ph-whatsapp-logo text-2xl"></i>
                        </div>

                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h5 class="font-bold text-green-900 text-sm">Butuh Bantuan? Hubungi CS</h5>
                                <i
                                    class="ph-bold ph-caret-right text-green-600 text-xs group-hover:translate-x-1 transition-transform"></i>
                            </div>
                            <p class="text-[11px] text-green-700 mt-0.5">Tanya detail paket atau cara pemesanan langsung
                                via WhatsApp.</p>
                        </div>
                    </button>

                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 flex gap-3 items-start">
                        <i class="ph-fill ph-shield-check text-blue-600 text-2xl"></i>
                        <div>
                            <h5 class="font-bold text-blue-900 text-sm">Aman & Terpercaya</h5>
                            <p class="text-xs text-blue-700 mt-1">Pembayaran langsung ke rekening Mutiara Sunnah Travel.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>

    <div
        class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 p-3 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] md:hidden z-40 flex items-center justify-between gap-2 animate-fade-in">

        <div class="flex flex-col flex-1 min-w-0 pr-1">
            <span class="text-[10px] text-gray-500 uppercase font-medium tracking-wide">Total Harga</span>
            <span class="text-base font-extrabold text-orange-600 truncate" id="total-price-mobile">Rp 25.9 Jt</span>
        </div>

        <button onclick="toggleCompareDetail()" id="btn-compare-mobile"
            class="flex-shrink-0 w-11 h-11 rounded-xl border border-gray-200 text-gray-400 active:scale-95 transition-all flex items-center justify-center relative">
            <i id="icon-compare-mobile" class="ph-bold ph-arrows-left-right text-xl"></i>
        </button>

        <button onclick="toggleFavorite()" id="btn-fav-mobile"
            class="flex-shrink-0 w-11 h-11 rounded-xl border border-gray-200 text-gray-400 active:scale-95 transition-all flex items-center justify-center">
            <i id="icon-fav-mobile" class="ph-bold ph-heart text-xl"></i>
        </button>

        <button onclick="window.location.href='/marketplace/pesanan/'"
            class="flex-shrink-0 bg-orange-500 text-white px-5 py-3 rounded-xl font-bold text-sm shadow-lg shadow-orange-500/20 active:scale-95 transition flex items-center gap-2">
            <i class="ph-bold ph-chat-teardrop-text"></i> Pesan
        </button>

    </div>

    <div id="lightbox" class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center hidden p-4"
        onclick="closeLightbox()">
        <button class="absolute top-4 right-4 text-white text-3xl hover:text-orange-500 transition"><i
                class="ph-bold ph-x"></i></button>
        <img id="lightbox-img" src=""
            class="max-w-full max-h-[90vh] rounded-lg shadow-2xl transform scale-95 transition-transform duration-300"
            onclick="event.stopPropagation()">
    </div>

    <!-- fav -->
    <div id="fav-toast"
        class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 transition-all duration-300 opacity-0 invisible translate-y-[-20px]">
        <div
            class="bg-gray-900/90 backdrop-blur-sm text-white px-6 py-3 rounded-full shadow-2xl flex items-center gap-3">
            <div id="toast-icon-container" class="bg-white/20 p-1.5 rounded-full">
                <i id="toast-icon" class="ph-fill ph-heart text-red-400"></i>
            </div>
            <span id="toast-message" class="text-sm font-medium">Disimpan ke Favorit</span>
        </div>
    </div>

    <script>
        // --- 1. Smart Navbar & Scroll Spy ---
        const navbar = document.getElementById('navbar');
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.tab-link');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
                navbar.classList.remove('bg-white/0');
            } else {
                navbar.classList.remove('bg-white/90', 'backdrop-blur-md', 'shadow-sm');
                navbar.classList.add('bg-white/0');
            }

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

        function scrollToBooking() {
            const card = document.getElementById('booking-card');
            const offset = 100;
            const elementPosition = card.getBoundingClientRect().top;
            const offsetPosition = elementPosition + window.pageYOffset - offset;
            window.scrollTo({ top: offsetPosition, behavior: "smooth" });
        }

        // --- 2. Calculator & Booking Logic ---
        const qtyInput = document.getElementById('quantity');
        const priceDesktop = document.getElementById('total-price-desktop');
        const priceMobile = document.getElementById('total-price-mobile');
        const displayPriceCard = document.getElementById('display-price-card');
        const radios = document.querySelectorAll('input[name="room_type"]');

        function formatRupiah(number) {
            return "Rp " + number.toLocaleString('id-ID');
        }

        function updatePricing() {
            const selected = document.querySelector('input[name="room_type"]:checked');
            const pricePerPax = parseInt(selected.dataset.price);
            const qty = parseInt(qtyInput.value);
            const total = pricePerPax * qty;

            displayPriceCard.textContent = formatRupiah(pricePerPax);
            priceDesktop.textContent = formatRupiah(total);
            priceMobile.textContent = formatRupiah(total);
        }

        function changeQty(amount) {
            let newVal = parseInt(qtyInput.value) + amount;
            if (newVal >= 1) {
                qtyInput.value = newVal;
                updatePricing();
            }
        }

        radios.forEach(r => r.addEventListener('change', updatePricing));

        // --- 3. Lightbox Gallery ---
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

        // --- 4. Toggle Itinerary ---
        function toggleItinerary() {
            const extra = document.getElementById('extra-itinerary');
            const btn = document.getElementById('toggle-itinerary-btn');

            if (extra.classList.contains('hidden')) {
                extra.classList.remove('hidden');
                extra.classList.add('animate-fade-in');
                btn.innerHTML = 'Tutup itinerary <i class="ph-bold ph-caret-up"></i>';
            } else {
                extra.classList.add('hidden');
                btn.innerHTML = 'Lihat itinerary lengkap <i class="ph-bold ph-caret-down"></i>';
                window.location.href = "#itinerary";
            }
        }

        // --- 5. Mobile Menu ---
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        function toggleMobileMenu() {
            mobileMenu.classList.toggle('hidden');
        }

        menuBtn.addEventListener('click', toggleMobileMenu);

        // Close menu when clicking a link
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => mobileMenu.classList.add('hidden'));
        });

        // --- 6. Auth Simulation (DEMO PURPOSE ONLY) ---
        // Ubah true/false untuk melihat perubahan tampilan
        // DISINI PERUBAHANNYA: SAYA UBAH JADI TRUE
        let isLoggedIn = true;

        function toggleAuth(status) {
            isLoggedIn = status;
            renderAuth();
        }

        function renderAuth() {
            const guestEl = document.getElementById('desktop-guest');
            const userEl = document.getElementById('desktop-user');
            const mobileGuest = document.getElementById('mobile-guest-actions');
            const mobileUser = document.getElementById('mobile-user-actions');
            const mobileProfile = document.getElementById('mobile-profile-section');
            const mobileUserIcon = document.getElementById('mobile-user-icon');

            if (isLoggedIn) {
                // Desktop
                guestEl.classList.add('hidden');
                userEl.classList.remove('hidden');
                // Mobile
                mobileGuest.classList.add('hidden');
                mobileUser.classList.remove('hidden');
                mobileProfile.classList.remove('hidden');
                mobileUserIcon.classList.remove('hidden');
                mobileUserIcon.classList.add('block');
            } else {
                // Desktop
                guestEl.classList.remove('hidden');
                userEl.classList.add('hidden');
                // Mobile
                mobileGuest.classList.remove('hidden');
                mobileUser.classList.add('hidden');
                mobileProfile.classList.add('hidden');
                mobileUserIcon.classList.add('hidden');
                mobileUserIcon.classList.remove('block');
            }
        }

        // Init Price & Auth
        updatePricing();
        renderAuth();

        // --- 7. Logic Favorit (Wishlist) dengan SweetAlert ---
        let isFavorited = false; // Status awal

        function toggleFavorite() {
            isFavorited = !isFavorited; // Balik status (True/False)
            updateFavoriteUI(); // Update Tampilan Tombol

            // Panggil SweetAlert Toast
            showSweetAlertToast(isFavorited);
        }

        function updateFavoriteUI() {
            const desktopBtn = document.getElementById('btn-fav-desktop');
            const mobileBtn = document.getElementById('btn-fav-mobile'); // Pastikan elemen ini ada di HTML Anda
            const desktopIcon = document.getElementById('icon-fav-desktop');
            const mobileIcon = document.getElementById('icon-fav-mobile'); // Pastikan elemen ini ada di HTML Anda

            // Definisi Class
            const activeBtnClasses = ['border-red-200', 'bg-red-50', 'text-red-500'];
            const inactiveBtnClasses = ['text-gray-400', 'border-gray-200'];

            if (isFavorited) {
                // --- State: LIKED ---

                // Update Desktop
                if (desktopBtn) {
                    desktopBtn.classList.add(...activeBtnClasses);
                    desktopBtn.classList.remove(...inactiveBtnClasses);
                }
                if (desktopIcon) {
                    desktopIcon.classList.replace('ph-bold', 'ph-fill');
                    desktopIcon.classList.add('text-red-500');
                    // Efek detak jantung kecil
                    desktopIcon.classList.add('scale-125');
                    setTimeout(() => desktopIcon.classList.remove('scale-125'), 200);
                }

                // Update Mobile (Jika ada)
                if (mobileBtn) {
                    mobileBtn.classList.add(...activeBtnClasses);
                    mobileBtn.classList.remove(...inactiveBtnClasses);
                }
                if (mobileIcon) {
                    mobileIcon.classList.replace('ph-bold', 'ph-fill');
                }

            } else {
                // --- State: UNLIKED ---

                // Update Desktop
                if (desktopBtn) {
                    desktopBtn.classList.remove(...activeBtnClasses);
                    desktopBtn.classList.add(...inactiveBtnClasses);
                }
                if (desktopIcon) {
                    desktopIcon.classList.replace('ph-fill', 'ph-bold');
                    desktopIcon.classList.remove('text-red-500');
                }

                // Update Mobile (Jika ada)
                if (mobileBtn) {
                    mobileBtn.classList.remove(...activeBtnClasses);
                    mobileBtn.classList.add(...inactiveBtnClasses);
                }
                if (mobileIcon) {
                    mobileIcon.classList.replace('ph-fill', 'ph-bold');
                }
            }
        }

        function showSweetAlertToast(liked) {
            // Konfigurasi Toast SweetAlert
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end', // Posisi di pojok kanan atas
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // Tampilkan Pesan Berdasarkan Status
            if (liked) {
                Toast.fire({
                    icon: 'success',
                    title: 'Disimpan ke Wishlist'
                });
            } else {
                Toast.fire({
                    icon: 'info',
                    title: 'Dihapus dari Wishlist'
                });
            }
        }

        function contactWhatsApp() {
            const phoneNumber = "62811917988"; // Ganti dengan nomor kantor

            // Mengambil nama paket secara otomatis (asumsi ada di tag H1)
            const packageName = document.querySelector('h1')?.innerText || "Paket Travel";
            const currentUrl = window.location.href;

            const message = `Assalamu'alaikum CS pengenumroh.com, saya ingin bertanya mengenai *${packageName}* yang saya lihat di website: ${currentUrl}`;

            const encodedMessage = encodeURIComponent(message);
            window.open(`https://wa.me/${phoneNumber}?text=${encodedMessage}`, '_blank');
        }

    </script>

    <script>

        function updateQty(type, change) {
            const input = document.getElementById(`qty-${type}`);
            const allInputs = document.querySelectorAll('.qty-input');

            let currentTotalPax = 0;
            allInputs.forEach(inp => currentTotalPax += parseInt(inp.value));

            let newVal = parseInt(input.value) + change;

            // Minimum 1 pax secara keseluruhan
            if (change === -1 && currentTotalPax <= 1) return;

            if (newVal < 0) newVal = 0;
            input.value = newVal;
            calculateTotal();
        }

        function calculateTotal() {
            let total = 0;
            let totalPax = 0;
            let summaryHtml = ''; // Untuk desktop box
            let mobileSummaryArr = []; // Untuk teks singkat di mobile bar

            const inputs = document.querySelectorAll('.qty-input');
            const summaryContainer = document.getElementById('summary-container');
            const summaryList = document.getElementById('order-summary-list');

            // Element Mobile
            const totalPriceMobile = document.getElementById('total-price-mobile');
            const paxSummaryMobile = document.getElementById('pax-summary-mobile');

            inputs.forEach(input => {
                const qty = parseInt(input.value);
                const price = parseInt(input.getAttribute('data-price'));
                const name = input.getAttribute('data-name');

                if (qty > 0) {
                    total += qty * price;
                    totalPax += qty;

                    // Detail Desktop
                    summaryHtml += `
                    <div class="flex justify-between text-xs font-medium text-orange-800">
                        <span>${qty}x Pax ${name}</span>
                        <span>Rp ${(qty * price).toLocaleString('id-ID')}</span>
                    </div>`;

                    // Ringkasan Mobile (Contoh: "1 Double, 2 Triple")
                    mobileSummaryArr.push(`${qty} ${name}`);
                }
            });

            // Format Rupiah
            const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');

            // UPDATE DESKTOP
            document.getElementById('total-price-display').innerText = formattedTotal;
            document.getElementById('total-pax').innerText = totalPax + ' Pax';

            // UPDATE MOBILE
            if (totalPriceMobile) totalPriceMobile.innerText = formattedTotal;
            if (paxSummaryMobile) {
                paxSummaryMobile.innerText = totalPax > 0 ? mobileSummaryArr.join(', ') : 'Pilih Kamar';
            }

            // Tampilkan/Sembunyikan box rincian Desktop
            if (totalPax > 0) {
                summaryContainer.classList.remove('hidden');
                summaryList.innerHTML = summaryHtml;
            } else {
                summaryContainer.classList.add('hidden');
            }
        }

        // Inisialisasi saat load
        document.addEventListener('DOMContentLoaded', calculateTotal);

        function checkout() {
            alert("Pesanan akan diproses. Pastikan jumlah pax sudah sesuai.");
        }

    </script>

    <script>
        // Variable state global untuk status perbandingan
        let isCompared = false;

        function toggleCompareDetail() {
            // Toggle status
            isCompared = !isCompared;

            // Ambil elemen Desktop & Mobile
            const desktopBtn = document.getElementById('btn-compare-detail');
            const mobileBtn = document.getElementById('btn-compare-mobile');

            // Setup SweetAlert Toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            // --- UPDATE UI LOGIC ---
            if (isCompared) {
                // AKTIF (Teal Color)

                // Desktop Update
                if (desktopBtn) {
                    desktopBtn.classList.remove('border-gray-200', 'text-gray-400');
                    desktopBtn.classList.add('border-teal-400', 'text-teal-600', 'bg-teal-50');
                }

                // Mobile Update
                if (mobileBtn) {
                    mobileBtn.classList.remove('border-gray-200', 'text-gray-400');
                    mobileBtn.classList.add('border-teal-200', 'text-teal-600', 'bg-teal-50');
                }

                Toast.fire({
                    icon: 'success',
                    title: 'Ditambahkan ke perbandingan'
                });

            } else {
                // NON-AKTIF (Gray Color)

                // Desktop Update
                if (desktopBtn) {
                    desktopBtn.classList.add('border-gray-200', 'text-gray-400');
                    desktopBtn.classList.remove('border-teal-400', 'text-teal-600', 'bg-teal-50');
                }

                // Mobile Update
                if (mobileBtn) {
                    mobileBtn.classList.add('border-gray-200', 'text-gray-400');
                    mobileBtn.classList.remove('border-teal-200', 'text-teal-600', 'bg-teal-50');
                }

                Toast.fire({
                    icon: 'info',
                    title: 'Dihapus dari perbandingan'
                });
            }
        }
    </script>

</body>

</html>