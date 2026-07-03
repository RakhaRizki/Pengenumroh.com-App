<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Kelola Produk - Pengenumroh</title>
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .form-input:focus { border-color: #ea580c; box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1); }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .product-card { transition: opacity 0.3s ease, transform 0.3s ease; }
    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

    @php
        $userData = session('user') ?? [];
        $namaTravel = $userData['fullname'] ?? ($userData['username'] ?? 'Biro Travel');
        $avatar = $userData['avatar_url'] ?? session('user_avatar') ?? 'https://ui-avatars.com/api/?name=' . urlencode($namaTravel) . '&background=F97316&color=fff';
        $bergabung = isset($userData['created_at']) ? \Carbon\Carbon::parse($userData['created_at'])->translatedFormat('F Y') : date('Y');
        $statusRaw = $userData['status'] ?? 'aktif'; 
        $isAktif = strtolower($statusRaw) === 'aktif' || $statusRaw == 1;
        
        $pesanan = $pesanan ?? [];
        $countPending = collect($pesanan)->filter(function ($trx) {
            return in_array(strtoupper($trx['status'] ?? ''), ['UNPAID', 'PENDING']);
        })->count();

        // 👇 PERBAIKAN URL: Hilangkan kata 'public/' agar tidak broken
        $baseUrlThumbnail = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/';
    @endphp

    <nav class="fixed w-full z-50 transition-all duration-300 bg-white border-b border-slate-200 shadow-sm" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <a href="/marketplace/" class="flex items-center gap-2 group">
                    <img src="/assets/img/marketplace/logo.png" alt="Logo PengenUmroh" class="h-10 w-auto object-contain">
                </a>

                <div class="hidden lg:flex items-center gap-4">
                    <a href="/marketplace/" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-600 transition bg-slate-50 px-4 py-2 rounded-full border border-slate-100 hover:bg-orange-50 hover:border-orange-100">
                        <i class="ph-bold ph-arrow-left"></i> Kembali ke Beranda
                    </a>
                    
                    <div class="h-6 w-px bg-slate-200 mx-2"></div>
                    
                    <div class="relative group">
                        <button class="flex items-center gap-3 focus:outline-none">
                            <div class="text-right">
                                <p class="text-xs font-bold text-slate-700">{{ $namaTravel }}</p>
                                <p class="text-[10px] text-slate-500">Mitra Travel</p>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                                <img id="nav-avatar" src="{{ $avatar }}" class="w-full h-full object-cover">
                            </div>
                        </button>
                        
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                            <div class="py-2">
                                <a href="{{ route('marketplace.travel.profil') }}" class="px-4 py-2 text-sm font-bold text-slate-600 hover:text-orange-600 block"><i class="ph-bold ph-user mr-2"></i> Profil Travel</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm font-bold text-red-600 hover:bg-red-50"><i class="ph-bold ph-sign-out mr-2"></i> Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:hidden flex items-center gap-3">
                    <button class="text-slate-700 hover:text-orange-600 focus:outline-none p-1" onclick="toggleMobileMenu()">
                        <i class="ph-bold ph-list text-3xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden fixed inset-0 bg-white z-[60] p-4 overflow-y-auto">
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <img src="/assets/img/marketplace/logo.png" class="h-8">
                <button onclick="toggleMobileMenu()" class="text-2xl text-slate-500 hover:text-red-500 bg-slate-100 p-2 rounded-full"><i class="ph-bold ph-x"></i></button>
            </div>
            <div class="space-y-2">
                <div class="mb-6 p-4 bg-orange-50 rounded-xl border border-orange-100 flex items-center gap-3">
                    <img src="{{ $avatar }}" class="w-12 h-12 rounded-full border border-orange-200 object-cover">
                    <div>
                        <p class="font-bold text-slate-800">{{ $namaTravel }}</p>
                        <p class="text-xs text-orange-600 font-bold">Mitra Travel</p>
                    </div>
                </div>
                <a href="/marketplace/" class="block px-4 py-3 text-lg font-bold text-slate-600 hover:bg-orange-50 rounded-xl"><i class="ph-bold ph-house mr-2"></i> Beranda</a>
                <a href="{{ route('marketplace.travel.profil') }}" class="block px-4 py-3 text-lg font-bold text-slate-600 hover:bg-orange-50 rounded-xl"><i class="ph-bold ph-user mr-2"></i> Profil Travel</a>
                <a href="{{ route('marketplace.travel.pesanan-masuk') }}" class="block px-4 py-3 text-lg font-bold text-slate-600 hover:bg-orange-50 rounded-xl"><i class="ph-bold ph-receipt mr-2"></i> Pesanan Masuk</a>
                <a href="{{ route('marketplace.travel.upload-produk') }}" class="block px-4 py-3 text-lg font-bold text-slate-600 hover:bg-orange-50 rounded-xl"><i class="ph-bold ph-upload mr-2"></i> Upload Produk</a>
                <a href="{{ route('marketplace.travel.kelola-produk') }}" class="block px-4 py-3 text-lg font-bold text-orange-600 bg-orange-50 border border-orange-100 rounded-xl"><i class="ph-bold ph-package mr-2"></i> Kelola Produk</a>
                
                <hr class="my-4 border-slate-100">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 text-lg font-bold text-red-600 hover:bg-red-50 rounded-xl"><i class="ph-bold ph-sign-out mr-2"></i> Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="pt-28 pb-5 min-h-screen bg-slate-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <div class="hidden lg:block lg:col-span-1 space-y-6" data-aos="fade-right">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-orange-100 to-orange-50"></div>
                        <div class="relative z-10">
                            <div class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow-md overflow-hidden bg-slate-100 mb-3">
                                <img src="{{ $avatar }}" class="w-full h-full object-cover">
                            </div>
                            <h2 class="text-lg font-bold text-slate-900">{{ $namaTravel }}</h2>
                            <p class="text-sm text-slate-500">Bergabung sejak {{ $bergabung }}</p>
                            <div class="mt-4 text-left">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-600">Status Akun</span>
                                    <span class="font-bold {{ $isAktif ? 'text-emerald-600' : 'text-red-600' }}">
                                        {{ $isAktif ? 'Aktif' : 'Menunggu Verifikasi' }}
                                    </span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="{{ $isAktif ? 'bg-emerald-500' : 'bg-red-500' }} h-2 rounded-full transition-all duration-1000 w-full"></div>
                                </div>
                                <p class="text-[11px] mt-2 flex items-center gap-1 font-medium px-2 py-1 rounded-lg {{ $isAktif ? 'text-emerald-700 bg-emerald-50' : 'text-red-700 bg-red-50' }}">
                                    <i class="ph-fill {{ $isAktif ? 'ph-check-circle text-emerald-600' : 'ph-clock text-red-600' }}"></i>
                                    {{ $isAktif ? 'Mitra Terverifikasi' : 'Harap Lengkapi Data' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <nav class="flex flex-col">
                            <a href="{{ route('marketplace.travel.profil') }}" class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent">
                                <i class="ph-bold ph-user text-xl"></i> Profil
                            </a>
                            <a href="{{ route('marketplace.travel.pesanan-masuk') }}" class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent">
                                <i class="ph-bold ph-receipt text-xl"></i> Pesanan Masuk
                            </a>
                            <a href="{{ route('marketplace.travel.upload-produk') }}" class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent">
                                <i class="ph-bold ph-upload text-xl"></i> Upload Produk
                            </a>
                            <a href="{{ route('marketplace.travel.kelola-produk') }}" class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 bg-orange-50 text-orange-700 border-orange-600">
                                <i class="ph-bold ph-package text-xl"></i> Kelola Produk
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 min-h-[600px]">
                        
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Produk</h1>
                                <p class="text-slate-500 text-sm mt-1">Atur ketersediaan dan informasi paket perjalanan Anda.</p>
                            </div>
                            <div class="flex gap-3 w-full md:w-auto">
                                <div class="relative flex-grow md:w-64">
                                    <i class="ph-bold ph-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                    <input type="text" id="searchInput" placeholder="Cari nama paket..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-medium focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition shadow-sm">
                                </div>
                                <a href="/marketplace/travel/upload-produk/" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2.5 rounded-xl font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-orange-500/20 transition whitespace-nowrap">
                                    <i class="ph-bold ph-plus"></i> <span class="hidden sm:inline">Tambah</span>
                                </a>
                            </div>
                        </div>

                        <div class="mb-8 overflow-x-auto no-scrollbar">
                            <div class="flex gap-4 min-w-max border-b border-slate-100 pb-1">
                                <button class="tab-btn active group relative px-2 py-3 text-sm font-bold text-orange-600 transition-all" onclick="changeTab('all', this)">
                                    Semua Paket <span class="ml-1.5 bg-orange-100 text-orange-700 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ count($produk) }}</span>
                                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></span>
                                </button>
                                <button class="tab-btn group relative px-2 py-3 text-sm font-medium text-slate-500 hover:text-slate-800 transition-all" onclick="changeTab('active', this)">
                                    Aktif (Tayang) <span class="ml-1.5 bg-orange-100 text-orange-700 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ collect($produk)->where('status', 'publish')->count() }}</span>
                                    <span class="hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></span>
                                </button>
                                <button class="tab-btn group relative px-2 py-3 text-sm font-medium text-slate-500 hover:text-slate-800 transition-all" onclick="changeTab('archive', this)">
                                    Arsip (Draft) <span class="ml-1.5 bg-orange-100 text-orange-700 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ collect($produk)->where('status', 'draft')->count() }}</span>
                                    <span class="hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></span>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-4" id="product-container">
                          @forelse($produk as $item)
                            @php
                                $statusTab = ($item['status'] ?? 'publish') == 'publish' ? 'active' : 'archive';
                                
                                // 1. Amankan data prices (Jaga-jaga kalau format dari backend berupa string JSON)
                                $pricesData = is_string($item['prices'] ?? null) ? json_decode($item['prices'], true) : ($item['prices'] ?? []);
                                
                                // 2. Kalkulasi Harga Display & Total Kuota Kamar
                                $hargaDisplay = 0;
                                $totalKuota = 0;
                                
                                if(!empty($pricesData) && is_array($pricesData)) {
                                    $hargaDisplay = $pricesData[0]['price'] ?? 0;
                                    $totalKuota = collect($pricesData)->sum('quota');
                                }
                                
                                // Fallback jika array prices kosong
                                if ($totalKuota === 0) {
                                    $totalKuota = intval($item['total_quota'] ?? $item['quota'] ?? 0);
                                }

                                // 3. Konfigurasi Label Kategori
                                $kategoriTeks = match((int)($item['category_id'] ?? 0)) {
                                    1 => 'Umroh Reguler 9 Hari',
                                    2 => 'Umroh Reguler 12 Hari',
                                    3 => 'Umroh Plus Tour',
                                    4 => 'Umroh Ramadhan',
                                    5 => 'Haji Khusus',
                                    default => 'Paket Perjalanan'
                                };
                                $badgeBg = ($item['category_id'] == 5) ? 'bg-purple-50 text-purple-600 border-purple-100' : 'bg-blue-50 text-blue-600 border-blue-100';
                            @endphp
                            
                            <div class="product-card group bg-white rounded-xl border border-slate-200 p-4 flex flex-col sm:flex-row gap-5 transition hover:shadow-md {{ $statusTab == 'archive' ? 'opacity-75 hover:opacity-100' : 'hover:border-orange-200' }}" data-status="{{ $statusTab }}">
                                
                                <div class="w-full sm:w-32 h-40 sm:h-28 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 relative {{ $statusTab == 'archive' ? 'grayscale' : '' }}">
                                    <img src="{{ !empty($item['thumbnail_url']) ? $baseUrlThumbnail . $item['thumbnail_url'] : '/assets/img/marketplace/produk-dummy.png' }}" class="w-full h-full object-cover transition group-hover:scale-105 duration-500" onerror="console.log('❌ GAMBAR GAGAL DILOAD DARI URL:', this.src); this.onerror=null; this.src='/assets/img/marketplace/produk-dummy.png';">
                                    @if($statusTab == 'archive')
                                        <div class="absolute inset-0 bg-slate-900/10"></div>
                                    @endif
                                </div>
                                
                                <div class="flex-grow flex flex-col justify-center">
                                    <div class="flex flex-wrap gap-2 mb-2">
                                        <span class="{{ $badgeBg }} text-[10px] font-bold px-2.5 py-1 rounded-md border shadow-sm">{{ $kategoriTeks }}</span>
                                        <span class="text-[11px] text-slate-500 font-medium flex items-center gap-1.5 bg-slate-50 px-2 py-1 rounded-md border border-slate-100">
                                            <i class="ph-bold ph-calendar text-slate-400"></i> {{ \Carbon\Carbon::parse($item['tgl_keberangkatan'])->translatedFormat('d M Y') ?? $item['tgl_keberangkatan'] }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="product-title text-base font-bold text-slate-900 mb-2.5 {{ $item['category_id'] == 5 ? 'group-hover:text-purple-600' : 'group-hover:text-orange-600' }} transition line-clamp-1 leading-snug">
                                        {{ $item['nama_produk'] }}
                                    </h3>
                                    
                                    <div class="flex flex-wrap items-center gap-3 text-sm">
                                        <p class="{{ $statusTab == 'archive' ? 'text-slate-500' : 'text-orange-600' }} font-extrabold text-base">
                                            Rp {{ number_format($hargaDisplay, 0, ',', '.') }} <span class="text-slate-400 font-normal text-[11px]">/ Pax</span>
                                        </p>
                                        
                                        <div class="hidden sm:block h-4 w-[1px] bg-slate-200"></div>
                                        
                                        {{-- 👇 UI SISA SEAT YANG SUDAH DIRAPIKAN 👇 --}}
                                        @if($totalKuota > 0)
                                            <div class="flex items-center gap-1.5 text-xs font-medium text-slate-500">
                                                <i class="ph-fill ph-users text-orange-400"></i> Sisa Kuota: 
                                                <span class="text-slate-700 font-bold bg-slate-100 border border-slate-200 px-2 py-0.5 rounded-md shadow-sm">{{ $totalKuota }} Seat</span>
                                            </div>
                                        @else
                                            <div class="text-red-600 text-xs flex items-center gap-1.5 font-bold bg-red-50 border border-red-100 px-2 py-0.5 rounded-md shadow-sm">
                                                <i class="ph-fill ph-warning-circle"></i> Kuota Habis
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                    <div class="flex flex-row sm:flex-col items-center justify-between sm:justify-center gap-4 border-t sm:border-t-0 sm:border-l border-slate-100 pt-4 sm:pt-0 sm:pl-5 min-w-[140px]">
                                        <div class="flex flex-col items-center gap-1.5 w-full">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer toggle-status" data-id="{{ $item['id'] }}" {{ $statusTab == 'active' ? 'checked' : '' }}>
                                                <div class="w-10 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500 shadow-inner"></div>
                                            </label>
                                            <span class="text-[10px] font-bold {{ $statusTab == 'active' ? 'text-green-600 bg-green-50 border-green-100' : 'text-slate-400 bg-slate-100 border-slate-200' }} px-2 py-0.5 rounded-full border transition-all duration-300 status-label">
                                                {{ $statusTab == 'active' ? 'Tayang' : 'Arsip' }}
                                            </span>
                                        </div>
                                        <div class="w-full flex gap-2">
                                            <a href="{{ route('marketplace.travel.produk.edit', $item['id']) }}" class="flex-1 py-2 flex items-center justify-center gap-1.5 text-slate-500 hover:text-blue-600 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-lg transition text-xs font-bold">
                                                <i class="ph-bold ph-pencil-simple text-sm"></i> Edit
                                            </a>
                                            <button onclick="deleteProduct('{{ $item['id'] }}')" class="py-2 px-3 flex items-center justify-center text-slate-500 hover:text-red-600 hover:bg-red-50 border border-slate-200 hover:border-red-200 rounded-lg transition text-xs font-bold">
                                                <i class="ph-bold ph-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @endforelse
                        </div>

                        <div id="empty-product" class="{{ count($produk) > 0 ? 'hidden' : 'flex' }} flex-col items-center justify-center py-16 md:py-24 text-center">
                            <div class="w-20 h-20 md:w-24 md:h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4 ring-8 ring-slate-50/50">
                                <i class="ph-duotone ph-package text-4xl md:text-5xl text-slate-300" id="empty-icon"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900" id="empty-title">Belum ada paket</h3>
                            <p class="text-slate-500 text-sm mt-1 mb-6 max-w-xs mx-auto" id="empty-desc">Anda belum memiliki paket perjalanan pada kategori ini.</p>
                            <a href="/marketplace/travel/upload-produk/" class="px-5 py-2.5 rounded-xl bg-orange-600 text-white font-bold text-sm shadow-lg hover:bg-orange-700 transition">Buat Paket Baru</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // ==========================================
        // SCRIPT NAVBAR MOBILE (HAMBURGER MENU)
        // ==========================================
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Kunci scroll layar belakang
            } else {
                menu.classList.add('hidden');
                document.body.style.overflow = 'auto'; // Buka scroll layar belakang
            }
        }

        // ==========================================
        // FITUR SEARCH & FILTER PROFESIONAL
        // ==========================================
        let currentTab = 'all';
        const searchInput = document.getElementById('searchInput');

        function changeTab(status, btn) {
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active', 'text-orange-600', 'font-bold');
                b.classList.add('text-slate-500', 'font-medium');
                b.querySelector('span:last-child').classList.add('hidden');
            });
            btn.classList.add('active', 'text-orange-600', 'font-bold');
            btn.classList.remove('text-slate-500', 'font-medium');
            btn.querySelector('span:last-child').classList.remove('hidden');

            currentTab = status;
            applyFilters();
        }

        searchInput.addEventListener('input', function() { applyFilters(); });

        function applyFilters() {
            const query = searchInput.value.toLowerCase().trim();
            const cards = document.querySelectorAll('.product-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.querySelector('.product-title').innerText.toLowerCase();
                const cardStatus = card.getAttribute('data-status');
                
                const matchTab = (currentTab === 'all' || cardStatus === currentTab);
                const matchSearch = title.includes(query);

                if (matchTab && matchSearch) {
                    card.style.display = 'flex';
                    setTimeout(() => { card.style.opacity = '1'; }, 50);
                    visibleCount++;
                } else {
                    card.style.opacity = '0';
                    setTimeout(() => { card.style.display = 'none'; }, 50);
                }
            });

            const emptyState = document.getElementById('empty-product');
            if (visibleCount === 0 && cards.length > 0) {
                emptyState.classList.remove('hidden');
                emptyState.classList.add('flex');
                
                if(query) {
                    document.getElementById('empty-icon').className = "ph-duotone ph-magnifying-glass text-5xl text-slate-300";
                    document.getElementById('empty-title').innerText = "Pencarian tidak ditemukan";
                    document.getElementById('empty-desc').innerText = `Tidak ada paket dengan nama "${searchInput.value}" pada tab ini.`;
                } else {
                    document.getElementById('empty-icon').className = "ph-duotone ph-package text-5xl text-slate-300";
                    document.getElementById('empty-title').innerText = "Belum ada paket";
                    document.getElementById('empty-desc').innerText = "Anda belum memiliki paket perjalanan pada tab ini.";
                }
            } else {
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');
            }
        }

        // ==========================================
        // AJAX UPDATE STATUS TAYANG / ARSIP
        // ==========================================
        document.querySelectorAll('.toggle-status').forEach(toggle => {
            toggle.addEventListener('change', async function() {
                const labelSpan = this.closest('div.flex-col').querySelector('.status-label');
                const isChecked = this.checked;
                const productId = this.getAttribute('data-id');
                const newStatus = isChecked ? 'publish' : 'draft';
                const originalState = !isChecked;
                
                let urlStatus = "{{ route('marketplace.travel.produk.status', ':id') }}";
                urlStatus = urlStatus.replace(':id', productId);

                try {
                    const response = await fetch(urlStatus, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status: newStatus })
                    });
                    
                    const result = await response.json();
                    
                    if(response.ok) {
                        const card = this.closest('.product-card');
                        if (isChecked) {
                            labelSpan.textContent = "Tayang";
                            labelSpan.className = "text-[10px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full border border-green-100 transition-all duration-300 status-label";
                            card.dataset.status = 'active';
                            card.classList.remove('opacity-75', 'grayscale');
                            showAlert('Berhasil Diterbitkan', 'Produk kini tampil di pencarian', 'success');
                        } else {
                            labelSpan.textContent = "Arsip";
                            labelSpan.className = "text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200 transition-all duration-300 status-label";
                            card.dataset.status = 'archive';
                            card.classList.add('opacity-75', 'grayscale');
                            showAlert('Produk Diarsipkan', 'Produk disembunyikan', 'info');
                        }
                        applyFilters();
                    } else {
                        this.checked = originalState;
                        Swal.fire('Gagal!', result.message || 'Gagal mengubah status', 'error');
                    }
                } catch(error) {
                    this.checked = originalState;
                    Swal.fire('Error!', 'Terjadi kesalahan sistem saat menghubungi server.', 'error');
                }
            });
        });

        // ==========================================
        // AJAX HAPUS PRODUK
        // ==========================================
        function deleteProduct(id) {
            Swal.fire({
                title: 'Hapus Paket?',
                text: "Data paket yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); }});
                    let urlDelete = "{{ route('marketplace.travel.produk.destroy', ':id') }}";
                    urlDelete = urlDelete.replace(':id', id);
                    try {
                        const response = await fetch(urlDelete, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });
                        if(response.ok) {
                            Swal.fire({ icon: 'success', title: 'Terhapus!', text: 'Paket berhasil dihapus.', timer: 1500, showConfirmButton: false })
                            .then(() => { window.location.reload(); });
                        } else {
                            const res = await response.json();
                            Swal.fire('Gagal!', res.message || 'Gagal menghapus produk.', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                    }
                }
            });
        }

        function showAlert(title, text, icon) {
            Swal.fire({ icon: icon, title: title, text: text, position: 'center', showConfirmButton: false, timer: 1500, timerProgressBar: true });
        }
    </script>
</body>
</html>