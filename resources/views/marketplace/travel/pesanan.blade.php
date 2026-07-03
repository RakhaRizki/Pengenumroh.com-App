<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Pesanan Masuk - Pengenumroh</title>
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

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

    @php
        // 1. Ambil data user dari session
        $userData = session('user') ?? [];
        $namaTravel = $userData['fullname'] ?? ($userData['username'] ?? 'Biro Travel');
        
        // 2. Variabel buat ngisi input Email di Profil biar gak Undefined
        $emailTravel = $userData['email'] ?? 'Belum ada email';
        
        // 3. KEMBALI KE LOGIKA AWAL: Ambil URL avatar langsung dari session/API tanpa modifikasi path
        $avatar = $userData['avatar_url'] ?? session('user_avatar') ?? 'https://ui-avatars.com/api/?name=' . urlencode($namaTravel) . '&background=F97316&color=fff';
        
        // 4. Format Tanggal Perjalanan/Bergabung Dinamis
        $bergabung = isset($userData['created_at']) ? \Carbon\Carbon::parse($userData['created_at'])->translatedFormat('F Y') : date('Y');
        
        // 5. Status Akun Dinamis biar aman di sidebar
        $statusRaw = $userData['status'] ?? 'aktif'; 
        $isAktif = strtolower($statusRaw) === 'aktif' || $statusRaw == 1;
        
        // 6. Notif Badge Pesanan Masuk
        $pesanan = $pesanan ?? [];
        $countPending = collect($pesanan)->filter(function ($trx) {
            return in_array(strtoupper($trx['status'] ?? ''), ['UNPAID', 'PENDING']);
        })->count();
    @endphp

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
                            <p class="text-xs font-bold text-slate-700">{{ $namaTravel }}</p>
                            <p class="text-[10px] text-slate-500">Mitra Travel</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                            <img src="{{ $avatar }}" class="w-full h-full object-cover">
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
                                <img id="sidebar-avatar" src="{{ $avatar }}" class="w-full h-full object-cover">
                            </div>
                            <h2 class="text-lg font-bold text-slate-900">{{ $namaTravel }}</h2>
                            <p class="text-sm text-slate-500">Bergabung sejak {{ $bergabung }}</p>
                            <div class="mt-4 text-left">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-600">Status Akun</span>
                                    <span class="font-bold text-emerald-600">Aktif</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="bg-emerald-500 h-2 rounded-full transition-all duration-1000 w-full">
                                    </div>
                                </div>
                                <p
                                    class="text-[11px] text-emerald-700 mt-2 flex items-center gap-1 font-medium bg-emerald-50 py-1 px-2 rounded-lg">
                                    <i class="ph-fill ph-check-circle text-emerald-600"></i> Mitra Travel Terverifikasi
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <nav class="flex flex-col">
                            <a href="{{ route('marketplace.travel.profil') }}"
                                class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.profil') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                                <i class="ph-bold ph-user text-xl"></i> Profil
                            </a>
                            <a href="{{ route('marketplace.travel.pesanan-masuk') }}"
                                class="flex items-center justify-between px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.pesanan-masuk') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                                <div class="flex items-center gap-3">
                                    <i class="ph-bold ph-receipt text-xl"></i> Pesanan Masuk
                                </div>
                                {{-- @if ($countPending > 0)
                                    <span
                                        class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">
                                        {{ $countPending }}
                                    </span>
                                @endif --}}
                            </a>
                            <a href="{{ route('marketplace.travel.upload-produk') }}"
                                class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.upload-produk') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                                <i class="ph-bold ph-upload text-xl"></i> Upload Produk
                            </a>
                            <a href="{{ route('marketplace.travel.kelola-produk') }}"
                            class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.kelola-produk', 'marketplace.travel.produk.edit') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                            <i class="ph-bold ph-package text-xl"></i> Kelola Produk
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 min-h-[600px]">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pesanan Masuk</h1>
                                <p class="text-slate-500 text-sm mt-1">Kelola pesanan masuk dan verifikasi pembayaran
                                    jamaah.</p>
                            </div>
                            <div class="relative w-full md:w-80">
                                <i
                                    class="ph-bold ph-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                <input type="text" placeholder="Cari Kode Booking / Nama Jamaah..."
                                    class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm font-medium focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-2 focus:ring-orange-100 transition shadow-sm"
                                    onkeyup="searchOrders(this.value)">
                            </div>
                        </div>

                        <div class="mb-8 overflow-x-auto no-scrollbar">
                            <div class="flex gap-4 min-w-max border-b border-slate-100 pb-1">
                                <button
                                    class="tab-btn active group relative px-2 py-3 text-sm font-bold text-orange-600 transition-all"
                                    onclick="filterOrder('all', this)">
                                    Semua Pesanan
                                    <span
                                        class="absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></span>
                                </button>
                                <button
                                    class="tab-btn group relative px-2 py-3 text-sm font-medium text-slate-500 hover:text-slate-800 transition-all"
                                    onclick="filterOrder('verifikasi', this)">
                                    Perlu Verifikasi
                                    @if ($countPending > 0)
                                        <span
                                            class="ml-1.5 bg-red-100 text-red-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countPending }}</span>
                                    @endif
                                    <span
                                        class="hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></span>
                                </button>
                                <button
                                    class="tab-btn group relative px-2 py-3 text-sm font-medium text-slate-500 hover:text-slate-800 transition-all"
                                    onclick="filterOrder('lunas', this)">
                                    Lunas / Siap Berangkat
                                    <span
                                        class="hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></span>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-6" id="order-container">
                            @forelse($pesanan as $item)
                                @php
                                    $statusAPI = strtoupper($item['status'] ?? 'UNPAID');
                                    $tglOrder = isset($item['created_at'])
                                        ? \Carbon\Carbon::parse($item['created_at'])->translatedFormat('d M Y, H:i')
                                        : 'Tanggal tidak diketahui';
                                    $totalHarga = number_format($item['total_price'] ?? 0, 0, ',', '.');
                                    $invoice =
                                        $item['transaction_no'] ??
                                        'INV/UMR/' . str_pad($item['id'] ?? 0, 4, '0', STR_PAD_LEFT);

                                    $dataStatus = 'verifikasi';
                                    $bgCard = 'bg-white hover:border-orange-300 hover:shadow-orange-500/10';
                                    $borderCard = 'border-orange-100';
                                    $badgeColor = 'bg-orange-50 border-orange-200 text-orange-700';
                                    $headerBg = 'bg-orange-50/50';

                                    if (in_array($statusAPI, ['PAID', 'LUNAS', 'SUCCESS'])) {
                                        $dataStatus = 'lunas';
                                        $bgCard = 'bg-white hover:border-blue-300 hover:shadow-blue-500/10';
                                        $borderCard = 'border-blue-100';
                                        $badgeColor = 'bg-blue-50 border-blue-200 text-blue-700';
                                        $headerBg = 'bg-blue-50/50';
                                    } elseif (in_array($statusAPI, ['DONE', 'COMPLETED', 'SELESAI'])) {
                                        $dataStatus = 'selesai';
                                        $bgCard = 'bg-white hover:border-emerald-300 hover:shadow-emerald-500/10';
                                        $borderCard = 'border-emerald-100';
                                        $badgeColor = 'bg-emerald-50 border-emerald-200 text-emerald-700';
                                        $headerBg = 'bg-emerald-50/50';
                                    } elseif (in_array($statusAPI, ['CANCELLED', 'FAILED', 'BATAL'])) {
                                        $dataStatus = 'selesai';
                                        $bgCard = 'bg-white hover:border-red-300 hover:shadow-red-500/10';
                                        $borderCard = 'border-red-100';
                                        $badgeColor = 'bg-red-50 border-red-200 text-red-700';
                                        $headerBg = 'bg-red-50/50';
                                    }

                                    // ==========================================
                                    // LOGIKA DETAIL PRODUK
                                    // ==========================================
                                    $detail = $item['details'][0] ?? [];
                                    $namaProduk = $detail['product_name'] ?? 'Paket Umroh';

                                    $fotoProduk =
                                        $detail['thumbnail_url'] ??
                                        ($detail['thumbnail_product'] ?? '/assets/img/marketplace/produk-dummy.png');
                                    if (
                                        $fotoProduk &&
                                        !str_starts_with($fotoProduk, 'http') &&
                                        $fotoProduk !== '/assets/img/marketplace/produk-dummy.png'
                                    ) {
                                        $fotoProduk =
                                            'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/' .
                                            ltrim($fotoProduk, '/');
                                    }

                                    // Bongkar Data Snapshot
                                    $hotelsSnap = json_decode($detail['hotels_snapshot'] ?? '[]', true);
                                    $flightsSnap = json_decode($detail['flights_snapshot'] ?? '[]', true);

                                    $hotelMakkahName = 'TBA';
                                    $hotelMakkahRating = 5;
                                    $hotelMadinahName = 'TBA';
                                    $hotelMadinahRating = 5;

                                    foreach ($hotelsSnap as $htl) {
                                        if (
                                            stripos(strtolower($htl['city'] ?? ''), 'mekkah') !== false ||
                                            stripos(strtolower($htl['city'] ?? ''), 'makkah') !== false
                                        ) {
                                            $hotelMakkahName = $htl['name'] ?? 'TBA';
                                            $hotelMakkahRating = $htl['rating'] ?? 5;
                                        }
                                        if (stripos(strtolower($htl['city'] ?? ''), 'madinah') !== false) {
                                            $hotelMadinahName = $htl['name'] ?? 'TBA';
                                            $hotelMadinahRating = $htl['rating'] ?? 5;
                                        }
                                    }

                                    // Grouping Kamar
                                    $totalQty = 0;
                                    $arrKamar = [];
                                    $detailsArray = is_array($item['details']) ? $item['details'] : [];
                                    foreach ($detailsArray as $det) {
                                        $room = $det['room_types'] ?? 'Standar';
                                        $qty = $det['quantity'] ?? 1;
                                        $totalQty += $qty;
                                        if (!in_array($room, $arrKamar)) {
                                            $arrKamar[] = $room;
                                        }
                                    }
                                    $tipeKamarStr = implode(', ', $arrKamar);

                                    // ==========================================
// DATA JAMAAH (PERBAIKAN FOTO)
// ==========================================
$jamaah = $item['user'] ?? [];
$namaJamaah = $jamaah['fullname'] ?? ($jamaah['username'] ?? 'Jamaah Tidak Diketahui');
$emailJamaah = $jamaah['email'] ?? '-';
$waJamaah = $jamaah['no_wa'] ?? null;
$fotoJamaahAsli = $jamaah['image'] ?? ($jamaah['avatar'] ?? null);

if (!empty($fotoJamaahAsli)) {
    // Kalau udah ada 'http', langsung pake. Kalau cuma nama file, tambahin prefix Darda
    $fotoJamaah = str_starts_with($fotoJamaahAsli, 'http') 
        ? $fotoJamaahAsli 
        : 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/profiles/' . rawurlencode(ltrim($fotoJamaahAsli, '/'));
} else {
    // Kalau kosong, tembak avatar default
    $fotoJamaah = 'https://ui-avatars.com/api/?name=' . urlencode($namaJamaah) . '&background=random';
}

                                @endphp

                                <div class="order-card searchable-item group rounded-2xl border border-slate-200 overflow-hidden shadow-sm {{ $bgCard }} transition-all duration-300 relative"
                                    data-status="{{ $dataStatus }}"
                                    data-search="{{ strtolower($invoice . ' ' . $namaJamaah . ' ' . $namaProduk) }}">

                                    <!-- HEADER INVOICE -->
                                    <div
                                        class="{{ $headerBg }} backdrop-blur-sm px-5 py-3.5 border-b {{ $borderCard }} flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex items-center gap-2 border {{ $badgeColor }} text-[10px] font-bold px-3 py-1 rounded-md uppercase tracking-wider shadow-sm">
                                                @if ($dataStatus == 'verifikasi')
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse ring-2 ring-orange-200"></span>
                                                    Menunggu Verifikasi
                                                @elseif($dataStatus == 'lunas')
                                                    <i class="ph-fill ph-check-circle text-sm"></i> Pembayaran Lunas
                                                @elseif(in_array($statusAPI, ['CANCELLED', 'FAILED', 'BATAL']))
                                                    <i class="ph-fill ph-x-circle text-sm"></i> Dibatalkan
                                                @else
                                                    <i class="ph-fill ph-check-square-offset text-sm"></i> Selesai
                                                @endif
                                            </div>
                                            <span
                                                class="text-xs text-slate-500 font-semibold flex items-center gap-1.5">
                                                <i class="ph-duotone ph-calendar-blank"></i> {{ $tglOrder }}
                                            </span>
                                        </div>
                                        <div
                                            class="flex items-center gap-2 text-sm text-slate-600 bg-white/80 px-3 py-1.5 rounded-lg border {{ $borderCard }} shadow-sm">
                                            <span
                                                class="font-medium text-slate-500 text-xs uppercase tracking-wider">Invoice:</span>
                                            <span
                                                class="font-bold font-mono tracking-wide text-slate-900 select-all">{{ $invoice }}</span>
                                            <button onclick="copyToClipboard('{{ $invoice }}')"
                                                class="ml-1 text-slate-400 hover:text-orange-600 transition"
                                                title="Salin Invoice">
                                                <i class="ph-bold ph-copy text-base"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- BODY CARD (RESPONSIVE SPLIT) -->
                                    <div class="p-5 sm:p-6 flex flex-col lg:flex-row gap-6 lg:gap-8 items-stretch">

                                        <!-- BAGIAN KIRI: FOTO & DETAIL PAKET -->
                                        <div class="flex-grow flex flex-col sm:flex-row gap-5 lg:gap-6">
                                            <!-- Foto Produk -->
                                            <div class="w-full sm:w-40 flex-shrink-0">
                                                <div
                                                    class="w-full h-48 sm:h-full min-h-[160px] rounded-xl overflow-hidden bg-slate-100 border border-slate-100 shadow-inner relative group-hover:shadow-md transition duration-300">
                                                    <img src="{{ $fotoProduk }}"
                                                        class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700">
                                                </div>
                                            </div>

                                            <!-- Detail Paket -->
                                            <div class="flex-grow flex flex-col justify-center py-1">
                                                <h3
                                                    class="text-lg sm:text-xl font-bold text-slate-900 leading-tight mb-5 group-hover:text-orange-600 transition">
                                                    {{ $namaProduk }}
                                                </h3>

                                                <!-- Grid 2x2 Detail -->
                                                <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                                                    <!-- Hotel Makkah -->
                                                    <div class="flex items-start gap-3">
                                                        <div
                                                            class="w-9 h-9 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0 text-orange-500 ring-1 ring-orange-100/50">
                                                            <i class="ph-duotone ph-buildings text-xl"></i>
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p
                                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                                                                Makkah</p>
                                                            <p class="text-xs font-bold text-slate-700 truncate"
                                                                title="{{ $hotelMakkahName }}">{{ $hotelMakkahName }}
                                                            </p>
                                                            <p
                                                                class="text-[10px] text-yellow-500 font-bold mt-0.5 tracking-widest">
                                                                {{ str_repeat('★', $hotelMakkahRating) }}<span
                                                                    class="text-slate-200">{{ str_repeat('★', 5 - $hotelMakkahRating) }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- Hotel Madinah -->
                                                    <div class="flex items-start gap-3">
                                                        <div
                                                            class="w-9 h-9 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0 text-orange-500 ring-1 ring-orange-100/50">
                                                            <i class="ph-duotone ph-buildings text-xl"></i>
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p
                                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                                                                Madinah</p>
                                                            <p class="text-xs font-bold text-slate-700 truncate"
                                                                title="{{ $hotelMadinahName }}">
                                                                {{ $hotelMadinahName }}</p>
                                                            <p
                                                                class="text-[10px] text-yellow-500 font-bold mt-0.5 tracking-widest">
                                                                {{ str_repeat('★', $hotelMadinahRating) }}<span
                                                                    class="text-slate-200">{{ str_repeat('★', 5 - $hotelMadinahRating) }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- Maskapai -->
                                                    <div class="flex items-start gap-3">
                                                        <div
                                                            class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0 text-blue-500 ring-1 ring-blue-100/50">
                                                            <i class="ph-duotone ph-airplane-tilt text-xl"></i>
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p
                                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                                                                Maskapai</p>
                                                            <p class="text-xs font-bold text-slate-700 truncate">
                                                                {{ $flightsSnap[0]['airline_name'] ?? 'TBA' }}</p>
                                                        </div>
                                                    </div>
                                                    <!-- Pesanan Pax -->
                                                    <div class="flex items-start gap-3">
                                                        <div
                                                            class="w-9 h-9 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0 text-emerald-500 ring-1 ring-emerald-100/50">
                                                            <i class="ph-duotone ph-users text-xl"></i>
                                                        </div>
                                                        <div class="min-w-0">
                                                            <p
                                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">
                                                                Pesanan</p>
                                                            <p class="text-xs font-bold text-slate-700 truncate">
                                                                {{ $totalQty }} Pax</p>
                                                            <p
                                                                class="text-[10px] text-slate-500 font-medium mt-0.5 truncate bg-slate-100 px-1.5 py-0.5 rounded inline-block">
                                                                {{ $tipeKamarStr }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BAGIAN KANAN: PEMESAN & AKSI (Fixed Width on Desktop) -->
                                        <div
                                            class="lg:w-64 flex-shrink-0 flex flex-col justify-between border-t lg:border-t-0 lg:border-l border-slate-200 pt-5 lg:pt-0 lg:pl-8">

                                          <!-- Kotak Data Jamaah -->
<div class="mb-5">
    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3 flex items-center gap-1.5">
        <i class="ph-bold ph-user-circle text-sm"></i> Informasi Jamaah
    </p>
    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100 flex items-center gap-3">
        
        @php
            $fotoJamaahAsli = $jamaah['image'] ?? ($jamaah['avatar'] ?? ($jamaah['foto'] ?? null));
            $fotoJamaah = 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $namaJamaah) . '&background=F97316&color=fff';

            if (!empty($fotoJamaahAsli)) {
                if (str_starts_with($fotoJamaahAsli, 'http')) {
                    $fotoJamaah = $fotoJamaahAsli;
                } else {
                    // Nebak path folder user di backend (bisa profiles / users / avatar)
                    $fotoJamaah = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/users/' . rawurlencode(ltrim($fotoJamaahAsli, '/'));
                }
            }
        @endphp

        <!-- FOTO PROFIL JAMAAH -->
        <div class="w-10 h-10 rounded-full bg-slate-200 border border-slate-200 p-0.5 flex-shrink-0 shadow-sm overflow-hidden">
            <img src="{{ $fotoJamaah }}" class="w-full h-full rounded-full object-cover" 
                 onerror="console.log('📸 FOTO JAMAAH ERROR NYARINYA KE SINI:', this.src); this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ str_replace(' ', '+', $namaJamaah) }}&background=F97316&color=fff';">
        </div>
        
        <div class="min-w-0 flex-grow">
            <p class="text-sm font-bold text-slate-900 truncate"> {{ $namaJamaah }}</p>
            @if ($waJamaah)
                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $waJamaah) }}" target="_blank" class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-700 bg-emerald-100/80 px-2 py-1 rounded-md hover:bg-emerald-200 transition mt-1.5">
                    <i class="ph-fill ph-whatsapp-logo text-emerald-600"></i> Hubungi
                </a>
            @else
                <p class="text-[10px] text-slate-500 truncate mt-1"> {{ $emailJamaah }}</p>
            @endif
        </div>
    </div>
</div>

<!-- Kotak Tagihan & Tombol -->
<div class="mt-auto flex flex-col">
    <div class="flex flex-row lg:flex-col justify-between items-center lg:items-end mb-4 bg-orange-50/50 p-3.5 rounded-xl border border-orange-100/50">
        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider lg:mb-1 w-full text-left lg:text-right"> Total Tagihan</p>
        <p class="text-lg sm:text-xl font-black text-orange-600 w-full text-right"> Rp {{ $totalHarga }}</p>
    </div>

    <div class="w-full space-y-2.5">
        @if ($dataStatus == 'verifikasi')
            @php 
                $urlBukti = ''; 
                $rawEvidenceName = $item['evidence_url'] ?? ''; 
                
                if (!empty($rawEvidenceName)) { 
                    if (str_starts_with($rawEvidenceName, 'http')) { 
                        $urlBukti = $rawEvidenceName; 
                    } else { 
                        // Fix Path & Spasi pada nama file
                        $namaFileB = rawurlencode(ltrim($rawEvidenceName, '/')); 
                        
                        // Coba pakai path default assets/img/transactions/
                        $urlBukti = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/transactions/' . $namaFileB; 
                    } 
                } 
            @endphp
            
            <!-- 👇 TOMBOLNYA UDAH DIPERBAIKI (Tanda kutipnya dipastikan aman) 👇 -->
            <button onclick="console.log('🔗 Link Bukti:', '{{ $urlBukti }}'); lihatBuktiBayar('{{ $urlBukti }}', '{{ $item['id'] }}', '{{ $rawEvidenceName }}')" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl shadow-lg shadow-slate-300 transition-all active:scale-95 flex items-center justify-center gap-2">
                <i class="ph-bold ph-check-circle"></i> Verifikasi Bayar
            </button>
            
      @elseif(in_array($statusAPI, ['PAID', 'LUNAS', 'SUCCESS', 'DONE', 'COMPLETED']))
    <button onclick="cetakInvoice('{{ $invoice }}', '{{ addslashes($namaJamaah) }}', '{{ addslashes($emailJamaah) }}', '{{ addslashes($waJamaah ?? '-') }}', '{{ addslashes($namaTravel) }}', '{{ addslashes($namaProduk) }}', '{{ $totalQty }}', '{{ $totalHarga }}', '{{ $tglOrder }}')" 
            class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 flex items-center justify-center gap-2">
        <i class="ph-bold ph-file-pdf"></i> Cetak Invoice
    </button>
@endif

    </div>
</div>

                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div id="empty-state"
                                    class="{{ count($pesanan) > 0 ? 'hidden' : 'flex' }} flex-col items-center justify-center py-24 text-center">
                                    <div
                                        class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-5 ring-8 ring-slate-50/50">
                                        <i class="ph-duotone ph-inbox text-5xl text-slate-300"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900">Tidak ada pesanan</h3>
                                    <p class="text-slate-500 text-sm mt-2 mb-6 max-w-sm mx-auto">
                                        Belum ada pesanan masuk untuk filter yang Anda pilih saat ini.
                                    </p>
                                </div>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({ duration: 800, once: true });

    // --- FITUR PENCARIAN & FILTER (TETAP SAMA) ---
    function searchOrders(keyword) {
        keyword = keyword.toLowerCase();
        const cards = document.querySelectorAll('.searchable-item');
        let visibleCount = 0;
        const activeTab = document.querySelector('.tab-btn.active').innerText.trim();
        let currentStatus = 'all';

        if (activeTab.includes('Verifikasi')) currentStatus = 'verifikasi';
        if (activeTab.includes('Lunas')) currentStatus = 'lunas';
        if (activeTab.includes('Selesai')) currentStatus = 'selesai';

        cards.forEach(card => {
            const dataSearch = card.getAttribute('data-search');
            const dataStatus = card.getAttribute('data-status');
            const matchSearch = dataSearch.includes(keyword);
            const matchStatus = (currentStatus === 'all' || dataStatus === currentStatus);

            if (matchSearch && matchStatus) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        checkEmptyState(visibleCount);
    }

    function filterOrder(status, btn) {
        const buttons = document.querySelectorAll('.tab-btn');
        buttons.forEach(b => {
            b.classList.remove('active', 'text-orange-600', 'font-bold');
            b.classList.add('text-slate-500', 'font-medium');
            if (b.querySelector('span:last-child')) b.querySelector('span:last-child').classList.add('hidden');
        });

        btn.classList.add('active', 'text-orange-600', 'font-bold');
        btn.classList.remove('text-slate-500', 'font-medium');
        if (btn.querySelector('span:last-child')) btn.querySelector('span:last-child').classList.remove('hidden');

        const searchInput = document.querySelector('input[placeholder^="Cari"]');
        if (searchInput) searchInput.value = '';

        const cards = document.querySelectorAll('.order-card');
        let visibleCount = 0;
        cards.forEach(card => {
            if (status === 'all' || card.getAttribute('data-status') === status) {
                card.style.display = 'block';
                card.classList.remove('aos-animate');
                setTimeout(() => card.classList.add('aos-animate'), 50);
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        checkEmptyState(visibleCount);
    }

    function checkEmptyState(count) {
        const emptyState = document.getElementById('empty-state');
        if (count === 0) {
            emptyState.classList.remove('hidden');
            emptyState.classList.add('flex');
        } else {
            emptyState.classList.add('hidden');
            emptyState.classList.remove('flex');
        }
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            const Toast = Swal.mixin({
                toast: true, position: "top-end", showConfirmButton: false, timer: 2000, timerProgressBar: true
            });
            Toast.fire({ icon: "success", title: "Invoice " + text + " disalin!" });
        });
    }

    // --- FITUR VERIFIKASI PEMBAYARAN (FIXED) ---
    function lihatBuktiBayar(imgUrl, idTransaksi, rawEvidence) {
        // Tanda console log sudah dipindah ke dalam fungsi biar gak error script
        console.log("🔗 Cek link bukti bayar:", imgUrl);

        if (!imgUrl || imgUrl === '' || imgUrl === 'null') {
            Swal.fire({
                icon: 'warning',
                title: 'Belum Ada Bukti',
                text: 'Jamaah ini belum mengunggah bukti pembayaran. Tetap ingin memverifikasi (tandai lunas)?',
                showCancelButton: true,
                confirmButtonText: 'Ya, Verifikasi Saja',
                cancelButtonText: 'Tutup',
                confirmButtonColor: '#16a34a',
            }).then((result) => {
                if (result.isConfirmed) {
                    prosesVerifikasi(idTransaksi, rawEvidence);
                }
            });
            return;
        }

        Swal.fire({
            title: 'Bukti Pembayaran',
            imageUrl: imgUrl,
            imageWidth: 400,
            imageAlt: 'Gambar Bukti Transfer',
            showCancelButton: true,
            confirmButtonText: 'Validasi & Terima',
            cancelButtonText: 'Tutup',
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#64748b',
            footer: '<p class="text-sm text-slate-500">Pastikan nominal transfer sesuai tagihan.</p>'
        }).then((result) => {
            if (result.isConfirmed) {
                prosesVerifikasi(idTransaksi, rawEvidence);
            }
        });
    }

    function prosesVerifikasi(idTransaksi, rawEvidence) {
        Swal.fire({
            title: 'Memproses...', text: 'Sedang memvalidasi pembayaran', allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        let urlApi = '{{ route('marketplace.travel.pesanan.verifikasi', ['id' => 'DUMMY_ID']) }}';
        urlApi = urlApi.replace('DUMMY_ID', idTransaksi);

        fetch(urlApi, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ evidence_url: rawEvidence })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire('Berhasil!', data.message, 'success').then(() => {
                    window.location.reload();
                });
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        })
        .catch(error => {
            console.error("Detail Error:", error);
            Swal.fire('Error Sistem!', 'Terjadi kesalahan saat memproses data.', 'error');
        });
    }

   // --- FITUR CETAK INVOICE DINAMIS (PROFESIONAL) ---
    function cetakInvoice(invoice, namaJamaah, emailJamaah, waJamaah, namaTravel, paket, qty, total, tanggal) {
        const printWindow = window.open('', '_blank', 'width=900,height=1000');
        
        // Desain struk kelas Enterprise (Bersih, Rapi, Detail)
        const htmlContent = `
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <title>INVOICE - ${invoice}</title>
                <style>
                    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
                    
                    body { 
                        font-family: 'Inter', sans-serif; 
                        padding: 50px; 
                        color: #1e293b; 
                        line-height: 1.6;
                        max-width: 900px;
                        margin: 0 auto;
                        background: #fff;
                    }
                    .header { 
                        display: flex; 
                        justify-content: space-between; 
                        align-items: flex-start; 
                        border-bottom: 2px solid #f1f5f9; 
                        padding-bottom: 30px; 
                        margin-bottom: 40px; 
                    }
                    .logo-area h1 { 
                        color: #ea580c; 
                        margin: 0; 
                        font-size: 32px; 
                        font-weight: 800;
                        letter-spacing: -0.5px;
                    }
                    .logo-area p { 
                        margin: 5px 0 0 0; 
                        color: #64748b; 
                        font-size: 14px; 
                    }
                    .invoice-details { text-align: right; }
                    .invoice-details h2 { 
                        margin: 0; 
                        color: #cbd5e1; 
                        font-size: 36px; 
                        font-weight: 800;
                        text-transform: uppercase;
                        letter-spacing: 2px;
                    }
                    .invoice-details p { margin: 5px 0; font-size: 14px; font-weight: 500; }
                    
                    .info-section {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 40px;
                    }
                    .info-box { width: 45%; }
                    .info-box h3 {
                        font-size: 12px;
                        color: #94a3b8;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                        margin-bottom: 10px;
                        border-bottom: 1px solid #f1f5f9;
                        padding-bottom: 5px;
                    }
                    .info-box p { margin: 4px 0; font-size: 14px; }
                    .info-box strong { color: #0f172a; font-size: 16px; display: block; margin-bottom: 4px;}

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-bottom: 30px;
                    }
                    th {
                        background-color: #f8fafc;
                        color: #64748b;
                        font-size: 12px;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                        text-align: left;
                        padding: 15px;
                        border-y: 1px solid #e2e8f0;
                    }
                    th.text-right, td.text-right { text-align: right; }
                    th.text-center, td.text-center { text-align: center; }
                    td {
                        padding: 15px;
                        border-bottom: 1px solid #f1f5f9;
                        font-size: 15px;
                        color: #334155;
                    }
                    td strong { color: #0f172a; }

                    .summary-section {
                        display: flex;
                        justify-content: flex-end;
                        margin-bottom: 40px;
                    }
                    .summary-box {
                        width: 400px;
                    }
                    .summary-row {
                        display: flex;
                        justify-content: space-between;
                        padding: 10px 15px;
                        font-size: 15px;
                        color: #64748b;
                    }
                    .summary-row.total {
                        background-color: #fff7ed;
                        color: #ea580c;
                        font-size: 20px;
                        font-weight: 800;
                        border-radius: 8px;
                        padding: 20px 15px;
                        margin-top: 10px;
                        border: 1px solid #ffedd5;
                    }
                    
                    .stamp {
                        display: inline-block;
                        color: #16a34a;
                        border: 3px solid #16a34a;
                        padding: 10px 30px;
                        font-size: 24px;
                        font-weight: 800;
                        border-radius: 8px;
                        transform: rotate(-10deg);
                        opacity: 0.8;
                        margin-bottom: 20px;
                    }

                    .footer {
                        text-align: center;
                        font-size: 13px;
                        color: #94a3b8;
                        border-top: 1px solid #f1f5f9;
                        padding-top: 30px;
                    }

                    @media print {
                        body { padding: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                        .summary-row.total { background-color: #fff7ed !important; }
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <div class="logo-area">
                        <h1>${namaTravel}</h1>
                        <p>Mitra Resmi Pengenumroh Marketplace</p>
                    </div>
                    <div class="invoice-details">
                        <h2>INVOICE</h2>
                        <p><strong>NO:</strong> ${invoice}</p>
                        <p><strong>Tanggal:</strong> ${tanggal}</p>
                    </div>
                </div>

                <div class="info-section">
                    <div class="info-box">
                        <h3>DITAGIHKAN KEPADA:</h3>
                        <strong>${namaJamaah}</strong>
                        <p>No. WhatsApp: ${waJamaah}</p>
                        <p>Email: ${emailJamaah}</p>
                    </div>
                    <div class="info-box">
                        <h3>STATUS PEMBAYARAN:</h3>
                        <div class="stamp">LUNAS</div>
                        <p style="color: #16a34a; font-weight: 600;">Terverifikasi oleh Sistem</p>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Deskripsi Paket</th>
                            <th class="text-center">Kuantitas</th>
                            <th class="text-right">Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>${paket}</strong><br>
                                <span style="font-size: 13px; color: #64748b;">Paket Ibadah Umroh / Haji Khusus</span>
                            </td>
                            <td class="text-center">${qty} Pax</td>
                            <td class="text-right">Rp ${total}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="summary-section">
                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span>Rp ${total}</span>
                        </div>
                        <div class="summary-row">
                            <span>Biaya Admin</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="summary-row total">
                            <span>Grand Total</span>
                            <span>Rp ${total}</span>
                        </div>
                    </div>
                </div>

                <div class="footer">
                    <p>Terima kasih telah mempercayakan perjalanan ibadah Anda bersama <strong>${namaTravel}</strong> dan <strong>Pengenumroh</strong>.</p>
                    <p>Dokumen ini adalah bukti pembayaran yang sah dan diterbitkan secara elektronik. Tidak memerlukan tanda tangan basah.</p>
                </div>

                <script>
                    window.onload = function() {
                        setTimeout(() => {
                            window.print();
                        }, 800);
                    }
                <\/script>
            </body>
            </html>
        `;
        
        printWindow.document.write(htmlContent);
        printWindow.document.close();
    }

</script>

</body>

</html>
