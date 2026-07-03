<nav class="fixed w-full z-50 transition-all duration-300 bg-white border-b border-slate-200 shadow-sm" id="navbar">
    @php
        $navUserName = session('user.fullname', 'Jamaah');
        if (isset($userProfile['nama'])) {
            $navUserName = $userProfile['nama'];
        }
        $defaultAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($navUserName) . '&background=F97316&color=fff';
        
        $navAvatarUrl = session('foto_global_navbar', session('user_avatar', $defaultAvatar));
        if (isset($userProfile['avatar']) && !empty($userProfile['avatar'])) {
            $navAvatarUrl = $userProfile['avatar'];
        }
    @endphp

    <div class="relative z-50 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/marketplace/" class="flex items-center gap-2 group">
                    <div class="flex-shrink-0 flex items-center cursor-pointer transform hover:scale-105 transition duration-300">
                        <img src="/assets/img/marketplace/logo.png" alt="Logo PengenUmroh" class="h-10 w-auto object-contain">
                    </div>
                </a>

                <div class="hidden lg:flex space-x-8">
                    <a href="/marketplace/" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">Beranda <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span></a>
                    <a href="{{ request()->routeIs('marketplace.beranda') ? '#produk' : route('marketplace.beranda') . '#produk' }}" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">Produk <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span></a>
                    <a href="{{ request()->routeIs('marketplace.beranda') ? '#mitra' : route('marketplace.beranda') . '#mitra' }}" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">Mitra <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span></a>
                    <a href="{{ route('marketplace.bandingkan') }}" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">Perbandingan <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span></a>
                    <a href="{{ route('marketplace.produk.index', ['kategori' => 'haji']) }}" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">Haji Khusus <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span></a>
                    <a href="{{ route('company.beranda') }}" class="group relative text-sm font-bold text-slate-500 hover:text-orange-600 transition duration-300">Tentang Kami <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-orange-500 transition-all duration-300 group-hover:w-full"></span></a>
                </div>

                <div class="hidden lg:flex items-center gap-4">
                    @if(session()->has('user'))
                        <div class="relative group">
                            <button class="flex items-center gap-3 pl-3 pr-1 py-1 bg-white border border-slate-200 rounded-full hover:shadow-md transition-all group-hover:border-orange-200">
                                <div class="text-right">
                                    <p class="text-xs font-bold text-slate-700">{{ $navUserName }}</p>
                                    <p class="text-[10px] text-slate-500">
                                        @if(session('user.id_level') == 4) Mitra Travel @else Jamaah @endif
                                    </p>
                                </div>
                                <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                                    <img src="{{ $navAvatarUrl }}" alt="Profile" class="w-full h-full object-cover">
                                </div>
                                <i class="ph-bold ph-caret-down text-slate-400 pr-2 group-hover:text-orange-500 transition"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50 overflow-hidden">
                                <div class="py-2">
                                    @if(session('user.id_level') == 4)
                                        <a href="{{ route('marketplace.travel.profil') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition"><i class="ph-bold ph-user mr-3 text-lg"></i> Profil Travel</a>
                                        <a href="{{ route('marketplace.travel.pesanan-masuk') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition"><i class="ph-bold ph-receipt mr-3 text-lg"></i> Pesanan Masuk</a>
                                        <a href="{{ route('marketplace.travel.upload-produk') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition"><i class="ph-bold ph-upload mr-3 text-lg"></i> Upload Produk</a>
                                        <a href="{{ route('marketplace.travel.kelola-produk') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition"><i class="ph-bold ph-package mr-3 text-lg"></i> Kelola Produk</a>
                                    @else
                                        <a href="{{ route('marketplace.profil.index') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition"><i class="ph-bold ph-user mr-3 text-lg"></i> Profil</a>
                                        <a href="{{ route('marketplace.profil.pesanan') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition"><i class="ph-bold ph-ticket mr-3 text-lg"></i> Pesanan</a>
                                        <a href="{{ route('marketplace.profil.wishlist') }}" class="flex items-center px-4 py-2.5 text-sm font-bold text-slate-500 hover:bg-orange-50 hover:text-orange-600 transition"><i class="ph-bold ph-heart mr-3 text-lg"></i> Wishlist</a>
                                    @endif
                                    <div class="border-t border-slate-100 my-1"></div>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 transition"><i class="ph-bold ph-sign-out mr-3 text-lg"></i> Keluar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-600 hover:text-orange-600 transition">Masuk</a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-slate-900 hover:bg-orange-600 text-white text-sm font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-orange-500/30 flex items-center gap-2">
                                <i class="ph-bold ph-note-pencil"></i> Daftar Sekarang
                            </a>
                        </div>
                    @endif
                </div>

                <div class="lg:hidden flex items-center gap-4">
                    @if(session()->has('user'))
                        <button id="mobile-profile-btn" class="w-9 h-9 rounded-full bg-orange-100 overflow-hidden border border-orange-200 shadow-sm focus:outline-none hover:ring-2 ring-orange-400 transition" onclick="toggleMobileProfile()">
                            <img src="{{ $navAvatarUrl }}" class="w-full h-full object-cover pointer-events-none">
                        </button>
                    @endif

                    <button id="mobile-menu-btn" class="text-slate-600 hover:text-orange-600 focus:outline-none p-1 rounded-xl transition-all duration-300 flex items-center justify-center" onclick="toggleMobileMenu()">
                        <i id="hamburger-icon" class="ph ph-list text-3xl transition-transform duration-300 transform"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="mobile-overlay" class="absolute left-0 right-0 h-screen bg-slate-900/40 z-30 opacity-0 pointer-events-none transition-opacity duration-300 backdrop-blur-sm" onclick="closeAllMobileMenus()" style="top: 100%;"></div>

    <div id="mobile-main-menu" class="absolute left-0 right-0 w-full bg-white/95 backdrop-blur-md z-40 transform -translate-y-[150%] opacity-0 transition-all duration-500 ease-in-out shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] rounded-b-3xl border-b border-slate-100 flex flex-col max-h-[calc(100vh-80px)] overflow-y-auto" style="top: 100%;">
        <div class="px-6 pt-4 pb-8 space-y-1">
            <a href="/marketplace/" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group">
                <i class="ph-bold ph-house mr-4 text-xl text-slate-400 group-hover:text-orange-500 transition"></i> Beranda
            </a>
            <a href="{{ request()->routeIs('marketplace.beranda') ? '#produk' : route('marketplace.beranda') . '#produk' }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group">
                <i class="ph-bold ph-package mr-4 text-xl text-slate-400 group-hover:text-orange-500 transition"></i> Produk
            </a>
            <a href="{{ request()->routeIs('marketplace.beranda') ? '#mitra' : route('marketplace.beranda') . '#mitra' }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group">
                <i class="ph-bold ph-handshake mr-4 text-xl text-slate-400 group-hover:text-orange-500 transition"></i> Mitra
            </a>
            <a href="{{ route('marketplace.bandingkan') }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group">
                <i class="ph-bold ph-scales mr-4 text-xl text-slate-400 group-hover:text-orange-500 transition"></i> Perbandingan
            </a>
            <a href="{{ route('marketplace.produk.index', ['kategori' => 'haji']) }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group">
                <i class="ph-bold ph-moon-stars mr-4 text-xl text-slate-400 group-hover:text-orange-500 transition"></i> Haji Khusus
            </a>
            <a href="{{ route('company.beranda') }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group">
                <i class="ph-bold ph-buildings mr-4 text-xl text-slate-400 group-hover:text-orange-500 transition"></i> Tentang Kami
            </a>

            @if(!session()->has('user'))
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-3 px-2">
                    <a href="{{ route('login') }}" class="flex items-center justify-center w-full py-3.5 rounded-xl font-bold text-slate-600 border-2 border-slate-200 hover:bg-slate-50 transition">Masuk</a>
                    <a href="{{ route('register') }}" class="flex items-center justify-center w-full py-3.5 bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-200 hover:bg-orange-700 active:scale-95 transition">Daftar Sekarang</a>
                </div>
            @endif
        </div>
    </div>

    @if(session()->has('user'))
    <div id="mobile-profile-menu" class="absolute left-0 right-0 w-full bg-white/95 backdrop-blur-md z-40 transform -translate-y-[150%] opacity-0 transition-all duration-500 ease-in-out shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] rounded-b-3xl border-b border-slate-100 flex flex-col max-h-[calc(100vh-80px)] overflow-y-auto" style="top: 100%;">
        <div class="px-6 py-5 bg-orange-50/80 border-b border-slate-100 flex items-center gap-4">
            <div class="w-14 h-14 rounded-full bg-white border-2 border-orange-200 overflow-hidden shadow-sm">
                <img src="{{ $navAvatarUrl }}" class="w-full h-full object-cover">
            </div>
            <div>
                <p class="font-bold text-slate-800 text-lg">{{ $navUserName }}</p>
                <p class="text-xs text-orange-600 font-bold uppercase mt-0.5 bg-orange-100 inline-block px-2 py-0.5 rounded-full">
                    @if(session('user.id_level') == 4) Mitra Travel @else Jamaah @endif
                </p>
            </div>
        </div>

        <div class="px-6 pt-4 pb-8 space-y-1">
            @if(session('user.id_level') == 4)
                <a href="{{ route('marketplace.travel.profil') }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group"><i class="ph-bold ph-user mr-4 text-xl text-slate-400 group-hover:text-orange-500"></i> Profil Travel</a>
                <a href="{{ route('marketplace.travel.pesanan-masuk') }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group"><i class="ph-bold ph-receipt mr-4 text-xl text-slate-400 group-hover:text-orange-500"></i> Pesanan Masuk</a>
                <a href="{{ route('marketplace.travel.upload-produk') }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group"><i class="ph-bold ph-upload mr-4 text-xl text-slate-400 group-hover:text-orange-500"></i> Upload Produk</a>
                <a href="{{ route('marketplace.travel.kelola-produk') }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group"><i class="ph-bold ph-package mr-4 text-xl text-slate-400 group-hover:text-orange-500"></i> Kelola Produk</a>
            @else
                <a href="{{ route('marketplace.profil.index') }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group"><i class="ph-bold ph-user mr-4 text-xl text-slate-400 group-hover:text-orange-500"></i> Profil</a>
                <a href="{{ route('marketplace.profil.pesanan') }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group"><i class="ph-bold ph-ticket mr-4 text-xl text-slate-400 group-hover:text-orange-500"></i> Pesanan</a>
                <a href="{{ route('marketplace.profil.wishlist') }}" class="flex items-center px-4 py-3.5 rounded-xl text-base font-bold text-slate-600 hover:bg-orange-50 hover:text-orange-600 transition group"><i class="ph-bold ph-heart mr-4 text-xl text-slate-400 group-hover:text-orange-500"></i> Wishlist</a>
            @endif
            
            <div class="mt-4 pt-4 border-t border-slate-100 px-2">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center py-3.5 rounded-xl font-bold text-red-600 bg-red-50 hover:bg-red-100 transition shadow-sm border border-red-100">
                        <i class="ph-bold ph-sign-out mr-3 text-xl"></i> Keluar Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
</nav>

<script>
    // ELEMENT SELECTORS
    const mobileMainMenu = document.getElementById('mobile-main-menu');
    const mobileProfileMenu = document.getElementById('mobile-profile-menu');
    const mobileOverlay = document.getElementById('mobile-overlay');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    
    // STATE MANAGERS
    let isMainMenuOpen = false;
    let isProfileMenuOpen = false;

    // FUNGSI UMUM UNTUK MENGATUR ANIMASI TIRAI (CURTAIN)
    function animateCurtain(element, action) {
        if (!element) return;
        if (action === 'open') {
            element.classList.remove('-translate-y-[150%]', 'opacity-0');
            element.classList.add('translate-y-0', 'opacity-100');
        } else {
            element.classList.remove('translate-y-0', 'opacity-100');
            element.classList.add('-translate-y-[150%]', 'opacity-0');
        }
    }

    // 1. FUNGSI TOGGLE MENU UTAMA (HAMBURGER)
    function toggleMobileMenu() {
        isMainMenuOpen = !isMainMenuOpen;

        if (isMainMenuOpen) {
            if (isProfileMenuOpen) toggleMobileProfile(); // Tutup profil kalau lagi kebuka

            mobileOverlay.classList.remove('pointer-events-none', 'opacity-0');
            animateCurtain(mobileMainMenu, 'open');
            
            // LOCK SCROLL (Biar background gak goyang)
            document.body.style.overflow = 'hidden';

            hamburgerIcon.classList.remove('ph-list');
            hamburgerIcon.classList.add('ph-x', 'rotate-90');
        } else {
            closeAllMobileMenus();
        }
    }

    // 2. FUNGSI TOGGLE MENU PROFIL
    function toggleMobileProfile() {
        isProfileMenuOpen = !isProfileMenuOpen;

        if (isProfileMenuOpen) {
            if (isMainMenuOpen) toggleMobileMenu(); // Tutup hamburger kalau lagi kebuka

            mobileOverlay.classList.remove('pointer-events-none', 'opacity-0');
            animateCurtain(mobileProfileMenu, 'open');
            
            // LOCK SCROLL
            document.body.style.overflow = 'hidden';
        } else {
            closeAllMobileMenus();
        }
    }

    // 3. FUNGSI SAPU JAGAT (TUTUP SEMUA)
    function closeAllMobileMenus() {
        mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
        
        animateCurtain(mobileMainMenu, 'close');
        animateCurtain(mobileProfileMenu, 'close');

        // UNLOCK SCROLL
        document.body.style.overflow = 'auto';

        if (hamburgerIcon) {
            hamburgerIcon.classList.remove('ph-x', 'rotate-90');
            hamburgerIcon.classList.add('ph-list');
        }

        isMainMenuOpen = false;
        isProfileMenuOpen = false;
    }

    // 4. STICKY NAVBAR EFFECT
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('py-0');
        } else {
            navbar.classList.remove('py-0');
        }
    });
</script>