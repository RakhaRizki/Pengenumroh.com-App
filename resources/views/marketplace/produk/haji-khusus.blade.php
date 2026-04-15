<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Haramainku Travel - Pengenumroh</title>
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }

        /* Custom Checkbox Style */
        .checkbox-wrapper input:checked+div {
            background-color: #ea580c;
            border-color: #ea580c;
        }

        .checkbox-wrapper input:checked+div svg {
            display: block;
        }

        /* Hide scrollbar for clean look */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
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

<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white pb-24 lg:pb-0">

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

    <header class="pt-28 pb-6 lg:pt-32 lg:pb-10 bg-white border-b border-slate-100" id="hero">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end gap-4 md:gap-6">
                <div class="w-full md:w-auto">
                    <h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 mb-2">Pilihan Paket Ibadah Haji</h1>
                    <p class="text-slate-500 text-xs md:text-base">Menampilkan <span
                            class="font-bold text-orange-600">1</span> paket perjalanan ibadah tersedia.</p>
                </div>

                <div class="hidden md:block relative w-48">
                    <select
                        class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm font-bold rounded-xl px-4 py-3 appearance-none focus:outline-none focus:border-orange-500 cursor-pointer hover:bg-slate-100 transition">
                        <option>Paling Sesuai</option>
                        <option>Harga Terendah</option>
                        <option>Harga Tertinggi</option>
                        <option>Keberangkatan Terdekat</option>
                    </select>
                    <i
                        class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>
            </div>
        </div>
    </header>

    <main class="py-6 lg:py-10 bg-slate-50 min-h-screen" id="produk">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <aside
                    class="hidden lg:block lg:col-span-1 space-y-8 sticky top-28 h-fit bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">

                    <div class="relative">
                        <i
                            class="ph-bold ph-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                        <input type="text" placeholder="Cari nama paket..."
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium focus:outline-none focus:border-orange-500 focus:bg-white transition">
                    </div>

                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-4 text-sm uppercase tracking-wider">Kategori Paket</h3>

                        <div class="grid grid-cols-1 gap-3">

                            <label class="cursor-pointer group relative">
                                <input type="radio" name="price_category" value="hemat"
                                    class="hidden peer category-radio">

                                <div class="flex items-center justify-between p-3 rounded-xl border-2 border-slate-100 bg-white 
                                            hover:border-orange-300 hover:bg-orange-50/30 hover:shadow-md hover:-translate-y-0.5
                                            peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:shadow-sm
                                            transition-all duration-200 ease-in-out">

                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 group-hover:bg-green-50 group-hover:text-green-500 peer-checked:bg-green-100 peer-checked:text-green-600 flex items-center justify-center transition-colors duration-200">
                                            <i class="ph-bold ph-tag text-xl"></i>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-bold text-slate-800 group-hover:text-orange-700 peer-checked:text-orange-800 transition-colors">
                                                Paket Hemat</p>
                                            <p class="text-xs text-slate-500 font-medium">&lt; Rp 28 Juta</p>
                                        </div>
                                    </div>

                                    <div class="w-5 h-5 rounded-full border-2 border-slate-300 bg-white 
                                                group-hover:border-orange-400
                                                peer-checked:border-orange-500 peer-checked:bg-orange-500 
                                                flex items-center justify-center transition-all duration-200">
                                        <div
                                            class="w-2 h-2 bg-white rounded-full opacity-0 transform scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200">
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer group relative">
                                <input type="radio" name="price_category" value="standar"
                                    class="hidden peer category-radio">

                                <div class="flex items-center justify-between p-3 rounded-xl border-2 border-slate-100 bg-white 
                                            hover:border-orange-300 hover:bg-orange-50/30 hover:shadow-md hover:-translate-y-0.5
                                            peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:shadow-sm
                                            transition-all duration-200 ease-in-out">

                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 group-hover:bg-blue-50 group-hover:text-blue-500 peer-checked:bg-blue-100 peer-checked:text-blue-600 flex items-center justify-center transition-colors duration-200">
                                            <i class="ph-bold ph-check-circle text-xl"></i>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-bold text-slate-800 group-hover:text-orange-700 peer-checked:text-orange-800 transition-colors">
                                                Paket Standar</p>
                                            <p class="text-xs text-slate-500 font-medium">Rp 28 - 35 Juta</p>
                                        </div>
                                    </div>

                                    <div class="w-5 h-5 rounded-full border-2 border-slate-300 bg-white 
                                                group-hover:border-orange-400
                                                peer-checked:border-orange-500 peer-checked:bg-orange-500 
                                                flex items-center justify-center transition-all duration-200">
                                        <div
                                            class="w-2 h-2 bg-white rounded-full opacity-0 transform scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200">
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <label class="cursor-pointer group relative">
                                <input type="radio" name="price_category" value="vip"
                                    class="hidden peer category-radio">

                                <div class="flex items-center justify-between p-3 rounded-xl border-2 border-slate-100 bg-white 
                                            hover:border-orange-300 hover:bg-orange-50/30 hover:shadow-md hover:-translate-y-0.5
                                            peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:shadow-sm
                                            transition-all duration-200 ease-in-out">

                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 group-hover:bg-purple-50 group-hover:text-purple-500 peer-checked:bg-purple-100 peer-checked:text-purple-600 flex items-center justify-center transition-colors duration-200">
                                            <i class="ph-bold ph-crown text-xl"></i>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-bold text-slate-800 group-hover:text-orange-700 peer-checked:text-orange-800 transition-colors">
                                                Paket VIP</p>
                                            <p class="text-xs text-slate-500 font-medium">&gt; Rp 35 Juta</p>
                                        </div>
                                    </div>

                                    <div class="w-5 h-5 rounded-full border-2 border-slate-300 bg-white 
                                                group-hover:border-orange-400
                                                peer-checked:border-orange-500 peer-checked:bg-orange-500 
                                                flex items-center justify-center transition-all duration-200">
                                        <div
                                            class="w-2 h-2 bg-white rounded-full opacity-0 transform scale-0 peer-checked:opacity-100 peer-checked:scale-100 transition-all duration-200">
                                        </div>
                                    </div>
                                </div>
                            </label>

                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-4 text-sm uppercase tracking-wider">Rentang Harga</h3>

                        <div class="mb-4 px-1">
                            <input type="range" id="price-range" min="20000000" max="100000000" step="500000"
                                class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-orange-600 hover:accent-orange-700">
                        </div>

                        <div class="flex items-center gap-2 mb-3">
                            <div class="relative w-full">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Rp</span>
                                <input type="number" id="price-min" placeholder="Min"
                                    class="w-full pl-8 pr-2 py-2 text-sm font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white transition">
                            </div>
                            <div class="w-2 h-0.5 bg-slate-300"></div>
                            <div class="relative w-full">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Rp</span>
                                <input type="number" id="price-max" placeholder="Max"
                                    class="w-full pl-8 pr-2 py-2 text-sm font-bold text-slate-700 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:border-orange-500 focus:bg-white transition">
                            </div>
                        </div>

                        <button onclick="alert('Filter diterapkan!')"
                            class="w-full py-2 text-xs font-bold text-orange-600 bg-orange-50 hover:bg-orange-100 rounded-lg transition">
                            Terapkan Harga
                        </button>
                    </div>

                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-4 text-sm uppercase tracking-wider">Mitra Travel</h3>
                        <div class="space-y-3 max-h-[300px] overflow-y-auto pr-1 custom-scrollbar">

                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Haramainku
                                    Tour</span>
                            </label>

                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Elmarwa
                                    Travel</span>
                            </label>

                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Namira
                                    Travel</span>
                            </label>

                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Uhud
                                    Tour</span>
                            </label>

                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Arsy
                                    Tour</span>
                            </label>

                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Mutiara
                                    Sunnah
                                    Travel</span>
                            </label>

                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-100">
                        <h3 class="font-bold text-slate-900 mb-4 text-sm uppercase tracking-wider">Jenis Paket</h3>
                        <div class="space-y-3">
                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Umroh
                                    Reguler 9
                                    Hari</span>
                            </label>
                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Umroh
                                    Reguler 12
                                    Hari</span>
                            </label>
                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Umroh
                                    Plus
                                    Wisata</span>
                            </label>
                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden">
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Umroh
                                    Ramadhan</span>
                            </label>
                            <label class="checkbox-wrapper flex items-center gap-3 cursor-pointer group">
                                <input type="checkbox" class="hidden" checked>
                                <div
                                    class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center transition-colors group-hover:border-orange-400">
                                    <svg class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                        <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-sm text-slate-600 font-medium group-hover:text-slate-900 transition">Haji
                                    Khusus</span>
                            </label>
                        </div>
                    </div>

                </aside>

                <div class="lg:col-span-3">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6" id="product-container">

                        <div class="product-card group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full"
                            data-category="umroh-reguler" data-aos="fade-up">
                            <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                                <img src="/assets/img/marketplace/produk-dummy3.png"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                                    alt="Umroh">
                                <div class="absolute top-3 right-3 z-10 flex gap-2">

                                    <button onclick="addToCompare(this)"
                                        class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-teal-600 hover:text-white transition border border-white/30 group/btn"
                                        title="Bandingkan">
                                        <i
                                            class="ph-bold ph-arrows-left-right text-lg transform group-hover/btn:rotate-180 transition-transform duration-500"></i>
                                    </button>

                                    <button
                                        class="wishlist-btn w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-white hover:text-red-500 transition border border-white/30">
                                        <i class="ph-fill ph-heart text-lg"></i>
                                    </button>

                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-grow">
                                <div class="min-h-[3.5rem]">
                                    <h3
                                        class="text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                        Pendaftaran Haji Khusus 2026 Program 26 Hari
                                    </h3>
                                </div>

                                <div class="flex-grow space-y-3 mb-6">
                                    <div class="flex items-center gap-3">
                                        <i class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                        <p class="text-sm font-semibold text-slate-600 truncate">Makkah: Hotel bintang
                                            ⭐5
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <i class="ph-duotone ph-buildings text-orange-500 text-xl flex-shrink-0"></i>
                                        <p class="text-sm font-semibold text-slate-600 truncate">Madinah: Hotel Bintang
                                            ⭐5
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <i class="ph-duotone ph-airplane-tilt text-blue-500 text-xl flex-shrink-0"></i>
                                        <p class="text-sm font-semibold text-slate-600 truncate">Maskapai Internasional
                                        </p>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <i
                                            class="ph-duotone ph-calendar-blank text-green-500 text-xl flex-shrink-0"></i>
                                        <p class="text-sm font-semibold text-slate-600">31 Desember 2035</p>
                                    </div>
                                    <div class="pt-2">
                                        <div class="flex justify-between text-[11px] mb-1.5 font-bold">
                                            <span class="text-slate-500 uppercase tracking-tighter">Seat Tersisa</span>
                                            <span class="text-[#ff782e] font-black">15 / 80</span>
                                        </div>

                                        <div
                                            class="w-full bg-slate-200 h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                            <div class="progress-orange-animated h-full rounded-full transition-all duration-700"
                                                style="width: 85%">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                    <div>
                                        <p class="text-[10px] text-slate-400 uppercase font-black tracking-wider">Mulai
                                            Dari</p>
                                        <p class="text-xl font-black text-slate-900">$ 16.000 <span
                                                class="text-sm">Usd</span></p>
                                    </div>
                                    <a href="{{ route('marketplace.produk.haji-khusus-program-26-hari') }}"
                                        class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30">
                                        <i class="ph-bold ph-arrow-right text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-12 flex justify-center gap-2">
                        <button
                            class="w-10 h-10 rounded-lg border border-slate-200 flex items-center justify-center text-slate-400 hover:border-slate-900 hover:text-slate-900 transition"><i
                                class="ph-bold ph-caret-left"></i></button>
                        <button
                            class="w-10 h-10 rounded-lg bg-orange-600 text-white font-bold flex items-center justify-center shadow-lg shadow-orange-500/30">1</button>
                        <!-- <button
                            class="w-10 h-10 rounded-lg border border-slate-200 text-slate-600 font-bold flex items-center justify-center hover:bg-slate-50 transition">2</button>
                        <button
                            class="w-10 h-10 rounded-lg border border-slate-200 text-slate-600 font-bold flex items-center justify-center hover:bg-slate-50 transition">3</button> -->
                        <button
                            class="w-10 h-10 rounded-lg border border-slate-200 flex items-center justify-center text-slate-600 hover:border-slate-900 hover:text-slate-900 transition"><i
                                class="ph-bold ph-caret-right"></i></button>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-full max-w-xs px-4 lg:hidden z-40">
        <button onclick="toggleMobileFilter()"
            class="w-full bg-slate-900/90 backdrop-blur-md text-white py-3.5 rounded-full font-bold shadow-2xl flex items-center justify-center gap-2 active:scale-95 transition border border-white/20">
            <i class="ph-bold ph-sliders-horizontal text-lg"></i>
            <span>Filter & Urutkan</span>
        </button>
    </div>

    <div id="mobile-filter" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="toggleMobileFilter()"></div>
        <div class="absolute bottom-0 left-0 w-full bg-white rounded-t-3xl p-6 h-[85vh] overflow-y-auto transform transition-transform duration-300 translate-y-full flex flex-col"
            id="mobile-filter-content">
            <div class="flex justify-between items-center mb-6 flex-shrink-0">
                <h3 class="text-xl font-bold text-slate-900">Filter Produk</h3>
                <button onclick="toggleMobileFilter()"
                    class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition">
                    <i class="ph-bold ph-x"></i>
                </button>
            </div>

            <div class="space-y-8 pb-24 overflow-y-auto flex-grow">
                <div>
                    <h4 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wide">Urutkan</h4>
                    <div class="flex flex-wrap gap-2">
                        <button
                            class="px-4 py-2 rounded-full bg-orange-50 border border-orange-500 text-orange-700 text-xs font-bold transition">Paling
                            Sesuai</button>
                        <button
                            class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 text-xs font-bold hover:border-orange-500 hover:text-orange-600 transition">Termurah</button>
                        <button
                            class="px-4 py-2 rounded-full border border-slate-200 text-slate-600 text-xs font-bold hover:border-orange-500 hover:text-orange-600 transition">Termahal</button>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wide">Kategori</h4>
                    <div class="space-y-3">
                        <label
                            class="checkbox-wrapper flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-slate-50 transition">
                            <input type="checkbox" class="hidden" checked>
                            <div class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center"><svg
                                    class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                </svg></div>
                            <span class="text-sm font-medium text-slate-700">Umroh Reguler</span>
                        </label>
                        <label
                            class="checkbox-wrapper flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-slate-50 transition">
                            <input type="checkbox" class="hidden">
                            <div class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center"><svg
                                    class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                </svg></div>
                            <span class="text-sm font-medium text-slate-700">Umroh Plus Wisata</span>
                        </label>
                        <label
                            class="checkbox-wrapper flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-slate-50 transition">
                            <input type="checkbox" class="hidden">
                            <div class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center"><svg
                                    class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                </svg></div>
                            <span class="text-sm font-medium text-slate-700">Haji Khusus</span>
                        </label>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-slate-800 mb-3 text-sm uppercase tracking-wide">Budget</h4>
                    <div class="space-y-3">
                        <label
                            class="checkbox-wrapper flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-slate-50 transition">
                            <input type="checkbox" class="hidden">
                            <div class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center"><svg
                                    class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                </svg></div>
                            <span class="text-sm font-medium text-slate-700">
                                < 28 Juta</span>
                        </label>
                        <label
                            class="checkbox-wrapper flex items-center gap-3 cursor-pointer p-2 rounded-lg hover:bg-slate-50 transition">
                            <input type="checkbox" class="hidden">
                            <div class="w-5 h-5 rounded border-2 border-slate-300 flex items-center justify-center"><svg
                                    class="hidden w-3 h-3 text-white fill-current" viewBox="0 0 20 20">
                                    <path d="M0 11l2-2 5 5L18 3l2 2L7 18z" />
                                </svg></div>
                            <span class="text-sm font-medium text-slate-700">> 35 Juta</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex-shrink-0">
                <button onclick="toggleMobileFilter()"
                    class="w-full bg-orange-600 hover:bg-orange-700 text-white py-3.5 rounded-xl font-bold shadow-lg transition active:scale-95">
                    Terapkan Filter
                </button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Ambil elemen-elemen yang dibutuhkan
            const radios = document.querySelectorAll('.category-radio');
            const minInput = document.getElementById('price-min');
            const maxInput = document.getElementById('price-max');
            const rangeInput = document.getElementById('price-range');

            // 2. Definisi Harga untuk setiap kategori
            const priceMap = {
                'hemat': { min: '', max: 28000000 },
                'standar': { min: 28000000, max: 35000000 },
                'vip': { min: 35000000, max: '' } // Kosong artinya tidak ada batas atas
            };

            // 3. Fungsi saat Radio Button dipilih
            radios.forEach(radio => {
                radio.addEventListener('change', function () {
                    const selectedCategory = this.value;
                    const prices = priceMap[selectedCategory];

                    if (prices) {
                        // Update input text Min & Max
                        minInput.value = prices.min;
                        maxInput.value = prices.max;

                        // Update range slider (opsional: set ke nilai max kategori tersebut)
                        if (prices.max) {
                            rangeInput.value = prices.max;
                        } else {
                            rangeInput.value = rangeInput.max; // Mentok kanan untuk VIP
                        }
                    }
                });
            });

            // 4. Fitur UX: Reset Radio jika user ketik manual
            // Jika user mengubah angka di input Min/Max, berarti mereka tidak pakai kategori preset lagi
            function resetRadios() {
                radios.forEach(radio => radio.checked = false);
            }

            minInput.addEventListener('input', resetRadios);
            maxInput.addEventListener('input', resetRadios);
            rangeInput.addEventListener('input', function () {
                // Sinkronkan slider dengan input Max (opsional)
                maxInput.value = this.value;
                resetRadios();
            });
        });
    </script>

    <script>
        AOS.init({ duration: 800, once: true });

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

        // --- WISHLIST BUTTON LOGIC ---
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault(); // Mencegah klik tembus ke card
                e.stopPropagation(); // Mencegah event bubbling

                btn.classList.toggle('is-liked');

                // Definisi Toast (Bisa dipakai berulang)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                if (btn.classList.contains('is-liked')) {
                    // State: LIKED
                    btn.classList.remove('text-white', 'bg-white/20', 'backdrop-blur-md');
                    btn.classList.add('text-red-500', 'bg-white', 'shadow-md', 'scale-110');

                    // Notifikasi Sukses
                    Toast.fire({
                        icon: 'success',
                        title: 'Ditambahkan ke Wishlist'
                    });

                } else {
                    // State: UNLIKED (Kembali ke default HTML)
                    btn.classList.remove('text-red-500', 'bg-white', 'shadow-md', 'scale-110');
                    btn.classList.add('text-white', 'bg-white/20', 'backdrop-blur-md');

                    // Notifikasi Hapus (BAGIAN INI YANG DITAMBAHKAN)
                    Toast.fire({
                        icon: 'info', // Menggunakan icon info agar beda dengan sukses
                        title: 'Dihapus dari Wishlist'
                    });
                }
            });
        });

        function addToCompare(button) {
            // Mencegah event bubbling (agar tidak men-trigger klik gambar jika ada)
            event.stopPropagation();

            // Efek visual pada tombol (Ganti warna jadi aktif)
            // Cek apakah tombol sudah aktif atau belum
            const isActive = button.classList.contains('bg-teal-600');

            if (!isActive) {
                // -- LOGIKA MENAMBAHKAN --

                // Ubah style tombol jadi "Aktif"
                button.classList.remove('bg-white/20', 'text-white');
                button.classList.add('bg-teal-600', 'text-white', 'border-teal-600');

                // Tampilkan Notifikasi SweetAlert (Toast Kecil di Pojok)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Ditambahkan ke perbandingan'
                });

            } else {
                // -- LOGIKA MENGHAPUS (Opsional: Jika diklik lagi) --

                // Kembalikan style tombol ke awal
                button.classList.add('bg-white/20', 'text-white');
                button.classList.remove('bg-teal-600', 'text-white', 'border-teal-600');

                // Tampilkan Notifikasi Hapus
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });

                Toast.fire({
                    icon: 'info',
                    title: 'Dihapus dari perbandingan'
                });
            }
        }

    </script>

</body>

</html>