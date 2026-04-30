<nav class="fixed w-full z-50 transition-all duration-300" id="navbar">
    <div class="bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Logo -->
                <a href="/marketplace/" class="flex items-center gap-2 group">
                    <div class="flex-shrink-0 flex items-center cursor-pointer transform hover:scale-105 transition duration-300">
                        <img src="/assets/img/marketplace/logo.png" alt="Logo PengenUmroh" class="h-10 w-auto object-contain">
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex space-x-8">
                    <a href="/marketplace/" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                        Beranda
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#produk" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                        Produk
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="#mitra" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                        Mitra
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('marketplace.bandingkan') }}" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                        Perbandingan
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('marketplace.produk.haji-khusus') }}" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                        Haji Khusus
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('company.beranda') }}" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">
                        Tentang Kami
                        <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>

                <!-- Desktop Auth Section -->
                <div class="hidden lg:flex items-center gap-4">
                    @if(session()->has('user'))
                        <!-- TAMPILAN JIKA SUDAH LOGIN (DESKTOP) -->
                        <div class="relative group">
                            <button class="flex items-center gap-3 pl-3 pr-1 py-1 bg-white border border-slate-200 rounded-full hover:shadow-md transition-all group-hover:border-orange-200">
                                <div class="text-right">
                                    <p class="text-xs font-bold text-slate-700">{{ session('user.fullname', 'Jamaah') }}</p>
                                    
                                    <!-- LOGIKA TAMPILAN JABATAN BERDASARKAN ID LEVEL -->
                                    <p class="text-[10px] text-slate-500">
                                        @if(session('user.id_level') == 4)
                                            Mitra Travel
                                        @else
                                            Jamaah
                                        @endif
                                    </p>

                                </div>
                                <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user.fullname', 'User')) }}&background=F97316&color=fff" alt="Profile" class="w-full h-full object-cover">
                                </div>
                                <i class="ph-bold ph-caret-down text-slate-400 pr-2 group-hover:text-orange-500 transition"></i>
                            </button>

                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50 overflow-hidden">
                                <div class="py-2">
                                    <!-- LOGIKA MENU DROPDOWN (BEDA ROLE BEDA MENU) -->
                                    @if(session('user.id_level') == 4)
                                        <a href="/travel/dashboard" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition">
                                            <i class="ph-bold ph-squares-four mr-3 text-lg"></i> Dashboard Travel
                                        </a>
                                    @endif

                                    <a href="{{ route('marketplace.profil.index') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition">
                                        <i class="ph-bold ph-user mr-3 text-lg"></i> Profil
                                    </a>
                                    
                                    @if(session('user.id_level') != 4)
                                        <a href="{{ route('marketplace.profil.pesanan') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition">
                                            <i class="ph-bold ph-ticket mr-3 text-lg"></i> Pesanan
                                        </a>
                                        <a href="{{ route('marketplace.profil.wishlist') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition">
                                            <i class="ph-bold ph-heart mr-3 text-lg"></i> Wishlist
                                        </a>
                                    @endif

                                    <div class="border-t border-gray-100 my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                            <i class="ph-bold ph-sign-out mr-3 text-lg"></i> Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- TAMPILAN JIKA BELUM LOGIN (DESKTOP) -->
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-orange-600 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-orange-600 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-0.5 flex items-center gap-2">
                                <i class="ph-bold ph-note-pencil"></i> Daftar Sekarang
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Mobile Hamburger Icon -->
                <div class="lg:hidden flex items-center gap-3">
                    @if(session()->has('user'))
                        <div class="w-8 h-8 rounded-full bg-orange-100 overflow-hidden border border-orange-200 cursor-pointer" onclick="toggleMobileMenu()">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user.fullname', 'User')) }}&background=F97316&color=fff" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <button id="mobile-menu-btn" class="text-slate-700 hover:text-orange-600 focus:outline-none p-1" onclick="toggleMobileMenu()">
                        <i class="ph ph-list text-3xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Wrapper -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white fixed inset-0 z-50 h-screen w-full overflow-y-auto flex flex-col">
            <div class="px-4 py-4 border-b border-slate-100 flex items-center justify-between">
                <a href="#">
                    <img src="/assets/img/marketplace/logo.png" alt="Pengenumroh" class="h-8 w-auto">
                </a>
                <button onclick="toggleMobileMenu()" class="p-2 text-slate-500 hover:text-red-500 hover:bg-red-50 rounded-full transition">
                    <i class="ph-bold ph-x text-xl"></i>
                </button>
            </div>

            <div class="px-4 pt-4 pb-6 space-y-2 flex-1">
                @if(session()->has('user'))
                    <!-- TAMPILAN PROFIL JIKA SUDAH LOGIN (MOBILE) -->
                    <div class="mb-4 p-4 bg-orange-50 rounded-xl border border-orange-100 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-white border border-orange-200 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user.fullname', 'User')) }}&background=F97316&color=fff" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ session('user.fullname') }}</p>
                            <!-- TAMPILAN JABATAN DI MOBILE -->
                            <p class="text-xs text-orange-600 font-bold">
                                @if(session('user.id_level') == 4)
                                    Mitra Travel
                                @else
                                    Jamaah
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Mobile Menu Links -->
                <a href="/marketplace/" class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Beranda</a>
                <a href="#produk" class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Produk</a>
                <a href="#mitra" class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Mitra</a>
                <a href="{{ route('marketplace.bandingkan') }}" class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Perbandingan</a>
                <a href="{{ route('marketplace.produk.haji-khusus') }}" class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Haji Khusus</a>
                <a href="{{ route('company.beranda') }}" class="block px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">Tentang Kami</a>

                <div class="border-t border-slate-100 my-2"></div>

                @if(session()->has('user'))
                    <!-- MENU USER JIKA SUDAH LOGIN (MOBILE) -->
                    <div class="space-y-2 pt-2">
                        
                        @if(session('user.id_level') == 4)
                            <a href="/travel/dashboard" class="flex items-center px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">
                                <i class="ph-bold ph-squares-four mr-3"></i> Dashboard Travel
                            </a>
                        @endif

                        <a href="{{ route('marketplace.profil.index') }}" class="flex items-center px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">
                            <i class="ph-bold ph-user mr-3"></i> Profil
                        </a>

                        @if(session('user.id_level') != 4)
                            <a href="{{ route('marketplace.profil.pesanan') }}" class="flex items-center px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">
                                <i class="ph-bold ph-ticket mr-3"></i> Pesanan
                            </a>
                            <a href="{{ route('marketplace.profil.wishlist') }}" class="flex items-center px-3 py-3 rounded-md text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600">
                                <i class="ph-bold ph-heart mr-3"></i> Wishlist
                            </a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full mt-2 py-3 text-red-600 font-bold hover:bg-red-50 rounded-xl transition text-left px-3">
                                <i class="ph-bold ph-sign-out mr-3"></i> Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <!-- TOMBOL AUTH JIKA BELUM LOGIN (MOBILE) -->
                    <div class="space-y-2 pt-2">
                        <a href="{{ route('login') }}" class="flex items-center justify-center w-full py-3 rounded-xl font-bold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">Masuk</a>
                        <a href="{{ route('register') }}" class="flex items-center justify-center w-full py-3 bg-slate-900 text-white font-bold rounded-xl shadow-md active:scale-95 transition">Daftar Sekarang</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</nav>