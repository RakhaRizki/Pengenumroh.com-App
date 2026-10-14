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
        
        // 6. Notif Badge Pesanan Masuk & Logika Deteksi Cicilan

        $pesananData = [];
        $countSemua = count($pesanan ?? []);
        $countPending = 0;
        $countCicilan = 0; // 👈 Tab Baru!
        $countLunas = 0;
        $countBatal = 0;

        foreach ($pesanan as $trx) {
            $stat = strtoupper($trx['status'] ?? 'UNPAID');
            $ev = $trx['evidence_url'] ?? '';
            $payType = strtoupper($trx['payment_type'] ?? 'FULL');
            $insts = $trx['installments'] ?? [];
            $isInst = $payType === 'INSTALLMENT' && count($insts) > 0;
            
            $pendingInst = null;
            $nextUnpaidInst = null;
            $tahapLunas = 0;

            if ($isInst) {
                usort($insts, function($a, $b) {
                    return $a['installment_number'] <=> $b['installment_number'];
                });
                $computedStat = 'UNPAID';
                foreach($insts as $i) {
                    $is = strtoupper($i['status'] ?? 'UNPAID');
                    $evInst = $i['evidence_url'] ?? ''; // 👈 Ambil URL bukti cicilan
                    
                    if (in_array($is, ['PAID', 'SUCCESS'])) {
                        $tahapLunas++;
                    } elseif ($is === 'PENDING') {
                        $computedStat = 'PENDING';
                        $pendingInst = $i;
                        break;
                    } elseif (in_array($is, ['FAILED', 'REJECTED']) || $evInst === 'REJECTED_IMAGE') {
                        // 🌟 KUNCI PERBAIKAN: Pisahkan cicilan gagal agar masuk Tab Batal
                        $computedStat = 'DITOLAK_TRAVEL'; 
                        $nextUnpaidInst = $i;
                        break;
                    } elseif ($is === 'UNPAID') {
                        $computedStat = 'UNPAID';
                        $nextUnpaidInst = $i;
                        break;
                    }
                }

                // Penentuan Status Akhir Cicilan
                if ($computedStat === 'DITOLAK_TRAVEL') {
                    $stat = 'DITOLAK_TRAVEL';
                } elseif ($tahapLunas === count($insts)) {
                    $stat = 'SUCCESS';
                } elseif ($computedStat === 'UNPAID' && $tahapLunas > 0) {
                    $stat = 'PARTIAL'; 
                } else {
                    $stat = $computedStat;
                }
                
                $trx['pending_installment'] = $pendingInst;
                $trx['next_unpaid_installment'] = $nextUnpaidInst;
                $trx['tahap_lunas'] = $tahapLunas;
                $trx['total_tahap'] = count($insts);
                $trx['installments'] = $insts;
            } else {
                if ($ev === 'REJECTED_IMAGE' || $stat === 'FAILED') $stat = 'DITOLAK_TRAVEL';
            }
            
            $trx['computed_status'] = $stat; 
            
            if ($stat === 'PENDING') $countPending++;
            elseif ($stat === 'PARTIAL') $countCicilan++; // 👈 Tambah badge Cicilan
            elseif (in_array($stat, ['PAID', 'LUNAS', 'SUCCESS', 'DONE', 'COMPLETED'])) $countLunas++;
            elseif (in_array($stat, ['CANCELLED', 'FAILED', 'BATAL', 'DITOLAK_TRAVEL'])) $countBatal++;
            
            $pesananData[] = $trx;
        }
        $pesanan = $pesananData;

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
                                <button class="tab-btn active group relative px-2 py-3 text-sm font-bold text-orange-600 transition-all" onclick="filterOrder('all', this)">
                                    Semua Pesanan
                                    @if ($countSemua > 0)
                                        <span class="ml-1.5 bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countSemua }}</span>
                                    @endif
                                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></span>
                                </button>
                                <button class="tab-btn group relative px-2 py-3 text-sm font-medium text-slate-500 hover:text-slate-800 transition-all" onclick="filterOrder('verifikasi', this)">
                                    Perlu Verifikasi
                                    @if ($countPending > 0)
                                        <span class="ml-1.5 bg-red-100 text-red-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countPending }}</span>
                                    @endif
                                    <span class="hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></span>
                                </button>
                                @if ($countCicilan > 0)
                                <!-- 👇 INI TAB CICILAN BERJALAN YANG BARU 👇 -->
                                <button class="tab-btn group relative px-2 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 transition-all" onclick="filterOrder('cicilan', this)">
                                    Cicilan Berjalan
                                    <span class="ml-1.5 bg-indigo-100 text-indigo-700 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countCicilan }}</span>
                                    <span class="hidden absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600 rounded-t-full transition-all"></span>
                                </button>
                                @endif
                                <button class="tab-btn group relative px-2 py-3 text-sm font-medium text-slate-500 hover:text-slate-800 transition-all" onclick="filterOrder('lunas', this)">
                                    Lunas / Siap Berangkat
                                    @if ($countLunas > 0)
                                        <span class="ml-1.5 bg-blue-100 text-blue-700 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countLunas }}</span>
                                    @endif
                                    <span class="hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></span>
                                </button>
                                @if ($countBatal > 0)
                                    <button class="tab-btn group relative px-2 py-3 text-sm font-medium text-slate-500 hover:text-red-600 transition-all" onclick="filterOrder('batal', this)">
                                        Dibatalkan
                                        <span class="ml-1.5 bg-red-100 text-red-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countBatal }}</span>
                                        <span class="hidden absolute bottom-0 left-0 w-full h-0.5 bg-red-600 rounded-t-full transition-all"></span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        {{-- <div style="background: #1e1e1e; color: #00ff00; padding: 20px; margin-bottom: 20px; border-radius: 10px; overflow-x: auto; font-family: monospace; font-size: 12px;">
                            <strong>X-RAY DATA PESANAN (INDEX 0):</strong><br>
                            <pre>{{ json_encode($pesanan[0] ?? 'Data Pesanan Kosong', JSON_PRETTY_PxRINT) }}</pre>
                        </div> --}}

                        <div class="space-y-6" id="order-container">
                            @foreach($pesanan as $item)
                            @php
                                $statusAPI = $item['computed_status'] ?? 'UNPAID';
                                $isInstallment = strtoupper($item['payment_type'] ?? 'FULL') === 'INSTALLMENT';
                                $pendingInstallment = $item['pending_installment'] ?? null;
                                $nextUnpaidInst = $item['next_unpaid_installment'] ?? null;
                                $tahapLunas = $item['tahap_lunas'] ?? 0;
                                
                                $tglOrder = isset($item['created_at']) ? \Carbon\Carbon::parse($item['created_at'])->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : 'Tanggal tidak diketahui';
                                $totalHarga = number_format($item['total_price'] ?? 0, 0, ',', '.');
                                $invoice = $item['transaction_no'] ?? 'INV/UMR/' . str_pad($item['id'] ?? 0, 4, '0', STR_PAD_LEFT);

                                // DEFAULT MAPPING: UNPAID
                                $dataStatus = 'unpaid';
                                $bgCard = 'bg-white hover:border-slate-300 hover:shadow-slate-500/10';
                                $borderCard = 'border-slate-200';
                                $badgeColor = 'bg-slate-50 border-slate-200 text-slate-500';
                                $headerBg = 'bg-slate-50/50';
                                $badgeIcon = 'ph-duotone ph-clock';
                                $badgeText = 'Belum Dibayar';

                                if ($statusAPI === 'PENDING') {
                                    $dataStatus = 'verifikasi';
                                    $bgCard = 'bg-white hover:border-orange-300 hover:shadow-orange-500/10';
                                    $borderCard = 'border-orange-100';
                                    $badgeColor = 'bg-orange-50 border-orange-200 text-orange-700';
                                    $headerBg = 'bg-orange-50/50';
                                    $badgeIcon = 'w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse ring-2 ring-orange-200';
                                    $badgeText = $isInstallment && $pendingInstallment ? 'Verifikasi Tahap ' . $pendingInstallment['installment_number'] : 'Menunggu Verifikasi';
                                } elseif ($statusAPI === 'PARTIAL') { // 👈 CARD UNTUK CICILAN BERJALAN
                                    $dataStatus = 'cicilan';
                                    $bgCard = 'bg-white hover:border-indigo-300 hover:shadow-indigo-500/10';
                                    $borderCard = 'border-indigo-100';
                                    $badgeColor = 'bg-indigo-50 border-indigo-200 text-indigo-700';
                                    $headerBg = 'bg-indigo-50/50';
                                    $badgeIcon = 'ph-duotone ph-arrows-clockwise';
                                    $badgeText = 'Cicilan Tahap ' . ($nextUnpaidInst['installment_number'] ?? ($tahapLunas + 1));
                                } elseif (in_array($statusAPI, ['PAID', 'LUNAS', 'SUCCESS'])) {
                                    $dataStatus = 'lunas';
                                    $bgCard = 'bg-white hover:border-blue-300 hover:shadow-blue-500/10';
                                    $borderCard = 'border-blue-100';
                                    $badgeColor = 'bg-blue-50 border-blue-200 text-blue-700';
                                    $headerBg = 'bg-blue-50/50';
                                    $badgeIcon = 'ph-fill ph-check-circle text-sm';
                                    $badgeText = 'Pembayaran Lunas';
                                } elseif (in_array($statusAPI, ['DONE', 'COMPLETED', 'SELESAI'])) {
                                    $dataStatus = 'selesai';
                                    $bgCard = 'bg-white hover:border-emerald-300 hover:shadow-emerald-500/10';
                                    $borderCard = 'border-emerald-100';
                                    $badgeColor = 'bg-emerald-50 border-emerald-200 text-emerald-700';
                                    $headerBg = 'bg-emerald-50/50';
                                    $badgeIcon = 'ph-fill ph-check-square-offset text-sm';
                                    $badgeText = 'Selesai';
                                } elseif (in_array($statusAPI, ['CANCELLED', 'FAILED', 'BATAL', 'DITOLAK_TRAVEL'])) {
                                    $dataStatus = 'batal';
                                    $bgCard = 'bg-white hover:border-red-300 hover:shadow-red-500/10';
                                    $borderCard = 'border-red-100';
                                    $badgeColor = 'bg-red-50 border-red-200 text-red-700';
                                    $headerBg = 'bg-red-50/50';
                                    $badgeIcon = 'ph-fill ph-x-circle text-sm';
                                    // 🌟 TEKS BADGE DINAMIS: Bedakan teks untuk produk cicilan vs produk biasa
                                    $badgeText = ($isInstallment && $statusAPI === 'DITOLAK_TRAVEL') ? 'Cicilan Ditolak' : 'Dibatalkan';
                                }

                                // LOGIKA DETAIL PRODUK
                                $detail = $item['details'][0] ?? [];
                                $namaProduk = $detail['product_name'] ?? 'Paket Umroh';
                                $fotoProduk = $detail['thumbnail_url'] ?? ($detail['thumbnail_product'] ?? '/assets/img/marketplace/produk-dummy.png');
                                if ( $fotoProduk && !str_starts_with($fotoProduk, 'http') && $fotoProduk !== '/assets/img/marketplace/produk-dummy.png' ) {
                                    $fotoProduk = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/' . ltrim($fotoProduk, '/');
                                }

                                $travelSnap = json_decode($detail['travel_snapshot'] ?? '{}', true);
                                $namaTravelInvoice = $travelSnap['fullname'] ?? ($travelSnap['name'] ?? $namaTravel);
                                $hotelsSnap = json_decode($detail['hotels_snapshot'] ?? '[]', true);
                                $flightsSnap = json_decode($detail['flights_snapshot'] ?? '[]', true);
                                $hotelMakkahName = 'TBA'; $hotelMakkahRating = 5;
                                $hotelMadinahName = 'TBA'; $hotelMadinahRating = 5;

                                foreach ($hotelsSnap as $htl) {
                                    if ( stripos(strtolower($htl['city'] ?? ''), 'mekkah') !== false || stripos(strtolower($htl['city'] ?? ''), 'makkah') !== false ) {
                                        $hotelMakkahName = $htl['name'] ?? 'TBA'; $hotelMakkahRating = $htl['rating'] ?? 5;
                                    }
                                    if (stripos(strtolower($htl['city'] ?? ''), 'madinah') !== false) {
                                        $hotelMadinahName = $htl['name'] ?? 'TBA'; $hotelMadinahRating = $htl['rating'] ?? 5;
                                    }
                                }

                                $totalQty = 0;
                                $kamarTerinci = [];
                                $detailsArray = is_array($item['details']) ? $item['details'] : [];
                                foreach ($detailsArray as $det) {
                                    $room = $det['room_types'] ?? 'Standar';
                                    $qty = $det['quantity'] ?? 1;
                                    $totalQty += $qty;
                                    if (isset($kamarTerinci[$room])) { $kamarTerinci[$room] += $qty; } else { $kamarTerinci[$room] = $qty; }
                                }

                                $rincianCetakArr = [];
                                foreach ($kamarTerinci as $tipe => $jumlah) { $rincianCetakArr[] = $tipe . ': ' . $jumlah; }
                                $rincianCetakStr = implode(', ', $rincianCetakArr);

                                $jamaah = $item['user'] ?? [];
                                $namaJamaah = $jamaah['fullname'] ?? ($jamaah['username'] ?? 'Jamaah Tidak Diketahui');
                                $emailJamaah = $jamaah['email'] ?? '-';
                                $waJamaah = $jamaah['no_wa'] ?? $jamaah['no_hp'] ?? $jamaah['whatsapp'] ?? $jamaah['telepon'] ?? $jamaah['phone'] ?? ($jamaah['profile']['no_wa'] ?? null) ?? ($jamaah['profile']['telepon'] ?? null) ?? ($jamaah['profile']['no_hp'] ?? null) ?? $item['no_wa'] ?? $item['customer_phone'] ?? '-';

                                $fotoJamaahAsli = $jamaah['image'] ?? ($jamaah['avatar'] ?? null);
                                if (!empty($fotoJamaahAsli)) {
                                    $fotoJamaah = str_starts_with($fotoJamaahAsli, 'http') ? $fotoJamaahAsli : 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/profiles/' . rawurlencode(ltrim($fotoJamaahAsli, '/'));
                                } else {
                                    $fotoJamaah = 'https://ui-avatars.com/api/?name=' . urlencode($namaJamaah) . '&background=random';
                                }

                                // 👇 LOGIKA PARSING REKENING UNTUK TRAVEL ADMIN 👇
                                $paySelect = $item['rekening_snapshot'] ?? $item['payment_selection'] ?? $detail['payment_selection'] ?? null;
                                if (is_string($paySelect)) $paySelect = json_decode($paySelect, true) ?? [];

                                $rekType = strtoupper($paySelect['type'] ?? 'MARKETPLACE');
                                $rekBank = 'BCA / BSI';
                                $rekNo = 'Virtual Account';
                                $rekName = 'PT Kolaborasi Para Sahabat';

                                // 🕵️ SUPER SAPU JAGAT: Tangkap BCA/BSI apapun bentuk JSON-nya
                                $trxRawStr = strtoupper(json_encode($item));

                                // Jika Marketplace ATAU ditemukan nomor rekening khusus pusat di dalam pesanan
                                if ($rekType === 'MARKETPLACE' || strpos($trxRawStr, '7215671498') !== false || strpos($trxRawStr, '7131720452') !== false) {
                                    $rekType = 'MARKETPLACE';
                                    
                                    // Lacak BSI
                                    if (strpos($trxRawStr, '7215671498') !== false || strpos($trxRawStr, '"BANK":"BSI"') !== false || strpos($trxRawStr, '"BANK_CODE":"BSI"') !== false) {
                                        $rekBank = 'BSI';
                                        $rekNo = '7215671498';
                                        $rekName = 'PT Kolaborasi Para Sahabat';
                                    } 
                                    // Lacak BCA
                                    elseif (strpos($trxRawStr, '7131720452') !== false || strpos($trxRawStr, '"BANK":"BCA"') !== false || strpos($trxRawStr, '"BANK_CODE":"BCA"') !== false) {
                                        $rekBank = 'BCA';
                                        $rekNo = '7131720452';
                                        $rekName = 'PT Kolaborasi Para Sahabat';
                                    }
                                } elseif ($rekType === 'MANDIRI') {
                                    $rekBank = strtoupper($paySelect['nama_bank'] ?? $paySelect['bank'] ?? 'Bank Travel');
                                    $rekNo = $paySelect['no_rekening'] ?? '-';
                                    $rekName = $paySelect['atas_nama'] ?? $paySelect['bank_owner'] ?? 'Mitra Travel';
                                }

                            @endphp

                            <div class="order-card searchable-item group rounded-2xl border border-slate-200 overflow-hidden shadow-sm {{ $bgCard }} transition-all duration-300 relative" data-status="{{ $dataStatus }}" data-search="{{ strtolower($invoice . ' ' . $namaJamaah . ' ' . $namaProduk) }}">
                            <!-- HEADER INVOICE -->
                            <div class="{{ $headerBg }} backdrop-blur-sm px-4 sm:px-5 py-3 sm:py-3.5 border-b {{ $borderCard }} flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <div class="flex items-center gap-1.5 sm:gap-2 border {{ $badgeColor }} text-[9px] sm:text-[10px] font-bold px-2.5 sm:px-3 py-1 rounded-md uppercase tracking-wider shadow-sm">
                                        @if(str_contains($badgeIcon, 'w-1.5'))
                                            <span class="{{ $badgeIcon }}"></span>
                                        @else
                                            <i class="{{ $badgeIcon }} text-xs sm:text-sm"></i>
                                        @endif
                                        {{ $badgeText }}
                                    </div>
                                    <span class="text-[10px] sm:text-xs text-slate-500 font-semibold flex items-center gap-1 sm:gap-1.5">
                                        <i class="ph-duotone ph-calendar-blank text-xs sm:text-sm"></i> {{ $tglOrder }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1.5 sm:gap-2 text-xs sm:text-sm text-slate-600 bg-white/80 px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-lg border {{ $borderCard }} shadow-sm">
                                    <span class="font-medium text-slate-500 text-[10px] sm:text-xs uppercase tracking-wider">Inv:</span>
                                    <span class="font-bold font-mono tracking-wide text-slate-900 select-all">{{ $invoice }}</span>
                                    <button onclick="copyToClipboard('{{ $invoice }}')" class="ml-0.5 text-slate-400 hover:text-orange-600 transition" title="Salin Invoice">
                                        <i class="ph-bold ph-copy text-sm sm:text-base"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- BODY CARD (RESPONSIVE SPLIT) -->
                            <div class="p-4 sm:p-6 flex flex-col lg:flex-row gap-5 lg:gap-8 items-stretch">
                                
                                <!-- BAGIAN KIRI: FOTO & DETAIL PAKET -->
                                <div class="flex-grow flex flex-col sm:flex-row gap-4 sm:gap-5 lg:gap-6">
                                    <!-- Foto Produk (FIXED VERTIKAL DI MOBILE) -->
                                    <div class="w-full sm:w-44 lg:w-56 flex-shrink-0 flex flex-col">
                                        <!-- 👇 aspect-[4/5] bikin gambar poster proporsional berdiri di HP 👇 -->
                                        <div class="w-full aspect-[4/5] sm:aspect-auto sm:h-full min-h-[220px] sm:min-h-[180px] rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shadow-sm relative group-hover:shadow-md transition duration-300">
                                            <img src="{{ $fotoProduk }}" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition-transform duration-700 cursor-pointer" onerror="this.onerror=null; this.src='/assets/img/marketplace/produk-dummy.png';" title="Klik untuk perbesar" onclick="openImageLightbox(this.src)">
                                        </div>
                                    </div>

                                    <!-- Detail Paket -->
                                    <div class="flex-grow flex flex-col justify-center py-1">
                                        <h3 class="text-base sm:text-xl font-bold text-slate-900 leading-tight mb-2 group-hover:text-orange-600 transition line-clamp-2">
                                            {{ $namaProduk }}
                                        </h3>
                                        <div class="flex items-center gap-1.5 mb-4 sm:mb-5 w-fit px-2 sm:px-2.5 py-1 rounded-md bg-slate-50 border border-slate-200 text-[10px] sm:text-xs font-semibold text-slate-600 shadow-sm">
                                            <i class="ph-duotone ph-calendar-blank text-orange-500 text-sm sm:text-[15px]"></i>
                                            <span>Berangkat: {{ \Carbon\Carbon::parse($detail['departure_date'] ?? now())->translatedFormat('d F Y') }}</span>
                                        </div>

                                        <!-- Grid 2x2 Detail (Ikon dan Teks Dikecilkan di Mobile) -->
                                        <div class="grid grid-cols-2 gap-x-3 gap-y-4 sm:gap-x-4 sm:gap-y-5">
                                            <!-- Hotel Makkah -->
                                            <div class="flex items-start gap-2 sm:gap-3">
                                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0 text-orange-500 ring-1 ring-orange-100/50">
                                                    <i class="ph-duotone ph-buildings text-base sm:text-xl"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Makkah</p>
                                                    <p class="text-[11px] sm:text-xs font-bold text-slate-700 truncate" title="{{ $hotelMakkahName }}">{{ $hotelMakkahName }}</p>
                                                    <p class="text-[9px] sm:text-[10px] text-yellow-500 font-bold mt-0.5 tracking-widest">
                                                        {{ str_repeat('★', $hotelMakkahRating) }}<span class="text-slate-200">{{ str_repeat('★', 5 - $hotelMakkahRating) }}</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Hotel Madinah -->
                                            <div class="flex items-start gap-2 sm:gap-3">
                                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0 text-orange-500 ring-1 ring-orange-100/50">
                                                    <i class="ph-duotone ph-buildings text-base sm:text-xl"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Madinah</p>
                                                    <p class="text-[11px] sm:text-xs font-bold text-slate-700 truncate" title="{{ $hotelMadinahName }}">{{ $hotelMadinahName }}</p>
                                                    <p class="text-[9px] sm:text-[10px] text-yellow-500 font-bold mt-0.5 tracking-widest">
                                                        {{ str_repeat('★', $hotelMadinahRating) }}<span class="text-slate-200">{{ str_repeat('★', 5 - $hotelMadinahRating) }}</span>
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Maskapai -->
                                            <div class="flex items-start gap-2 sm:gap-3">
                                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0 text-blue-500 ring-1 ring-blue-100/50">
                                                    <i class="ph-duotone ph-airplane-tilt text-base sm:text-xl"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Maskapai</p>
                                                    <p class="text-[11px] sm:text-xs font-bold text-slate-700 truncate">{{ $flightsSnap[0]['airline_name'] ?? 'TBA' }}</p>
                                                </div>
                                            </div>

                                            <!-- Pesanan Pax -->
                                            <div class="flex items-start gap-2 sm:gap-3">
                                                <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0 text-emerald-500 ring-1 ring-emerald-100/50">
                                                    <i class="ph-duotone ph-users text-base sm:text-xl"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Pesanan</p>
                                                    <p class="text-[11px] sm:text-xs font-bold text-slate-700 truncate">{{ $totalQty }} Pax</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- BAGIAN KANAN: PEMESAN & AKSI (Fixed Width on Desktop) -->
                                <div class="lg:w-64 flex-shrink-0 flex flex-col justify-between border-t lg:border-t-0 lg:border-l border-slate-100 pt-4 sm:pt-5 lg:pt-0 lg:pl-6">
                                    
                                    <!-- Kotak Data Jamaah -->
                                    <div class="mb-4 sm:mb-5">
                                        <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2.5 sm:mb-3 flex items-center gap-1.5">
                                            <i class="ph-bold ph-user-circle text-xs sm:text-sm"></i> Informasi Jamaah
                                        </p>
                                        <div class="bg-slate-50 p-2.5 sm:p-3 rounded-xl border border-slate-100 flex items-center gap-2.5 sm:gap-3">
                                            @php
                                                // 👇 LOGIKA FOTO PROFIL 👇
                                                $fotoJamaahAsli = $jamaah['profile']['image'] ?? $jamaah['image'] ?? null;
                                                $fotoJamaah = 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $namaJamaah) . '&background=F97316&color=fff';
                                                if (!empty($fotoJamaahAsli)) {
                                                    $fotoJamaah = str_starts_with($fotoJamaahAsli, 'http') ? $fotoJamaahAsli : 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/profiles/' . ltrim($fotoJamaahAsli, '/');
                                                }
                                                
                                                // 🌟 LOGIKA TEMPLATE PESAN WHATSAPP (BARU) 🌟
                                                $waLink = '#';
                                                if ($waJamaah) {
                                                    $waNumber = preg_replace('/^0/', '62', $waJamaah);
                                                    // Draft pesan profesional, otomatis narik variabel Invoice, Nama Paket, dan Nama Travel
                                                    $waText = "Assalamu'alaikum Bapak/Ibu *" . $namaJamaah . "*.\n\nKami dari admin *" . $namaTravel . "* menginformasikan terkait pesanan Anda untuk paket *" . $namaProduk . "* dengan nomor Invoice *" . $invoice . "*.\n\nAda informasi yang ingin kami sampaikan terkait status pesanan/pembayaran Bapak/Ibu. Mohon waktunya sebentar ya. Terima kasih 🙏";
                                                    
                                                    // rawurlencode mengubah spasi dan enter menjadi format link WA yang sah
                                                    $waLink = "https://wa.me/" . $waNumber . "?text=" . rawurlencode($waText);
                                                }
                                            @endphp

                                            <!-- FOTO PROFIL JAMAAH -->
                                            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-slate-200 border border-slate-200 p-0.5 flex-shrink-0 shadow-sm overflow-hidden">
                                                <img src="{{ $fotoJamaah }}" class="w-full h-full rounded-full object-cover">
                                            </div>
                                            
                                            <!-- NAMA & TOMBOL WA -->
                                            <div class="min-w-0 flex-grow">
                                                <p class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ $namaJamaah }}</p>
                                                @if ($waJamaah)
                                                    <a href="{{ $waLink }}" target="_blank" class="inline-flex items-center gap-1 text-[9px] sm:text-[10px] font-bold text-emerald-700 bg-emerald-100/80 px-2 py-0.5 sm:py-1 rounded-md hover:bg-emerald-200 transition mt-1 sm:mt-1.5" title="Chat Jamaah via WhatsApp">
                                                        <i class="ph-fill ph-whatsapp-logo text-emerald-600 text-xs"></i> Hubungi Jamaah
                                                    </a>
                                                @else
                                                    <p class="text-[9px] sm:text-[10px] text-slate-500 truncate mt-1">{{ $emailJamaah }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kotak Tagihan & Tombol -->
                                    <div class="mt-auto flex flex-col">
                                        <div class="flex flex-row lg:flex-col justify-between items-center lg:items-end mb-3 sm:mb-4 bg-orange-50/50 p-2.5 sm:p-3.5 rounded-xl border border-orange-100/50">
                                            <p class="text-[9px] sm:text-[10px] text-slate-500 font-bold uppercase tracking-wider lg:mb-1 w-full text-left lg:text-right"> Total Tagihan</p>
                                            <p class="text-base sm:text-xl font-black text-orange-600 w-full text-right"> Rp {{ $totalHarga }}</p>
                                        </div>

                                        <div class="w-full space-y-2 sm:space-y-2.5">
                                            <!-- BARIS 1: LIHAT DATA JAMAAH (SELALU ADA) -->
                                            <button onclick="openJamaahModal('{{ $item['id'] }}')" class="w-full h-10 sm:h-11 bg-white border border-slate-200 hover:border-orange-500 hover:bg-orange-50 text-slate-700 hover:text-orange-600 text-[11px] sm:text-sm font-bold rounded-xl shadow-sm transition-all active:scale-95 flex items-center justify-center gap-1.5 sm:gap-2">
                                                <i class="ph-bold ph-users-three text-base sm:text-lg"></i> Lihat Data Jamaah
                                            </button>

                                            @php
                                                $urlBukti = '';
                                                $rawEvidenceName = $item['evidence_url'] ?? '';
                                                if (!empty($rawEvidenceName)) {
                                                    $urlBukti = str_starts_with($rawEvidenceName, 'http') ? $rawEvidenceName : 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/transactions/' . rawurlencode(ltrim($rawEvidenceName, '/'));
                                                }
                                                $jsonInstallmentAman = $isInstallment ? base64_encode(json_encode($item['installments'] ?? [])) : '';
                                            @endphp

                                            <!-- BARIS 2: ACTION BUTTONS (SAMA TINGGI SEMUA: h-10 sm:h-11) -->
                                            @if ($dataStatus == 'verifikasi')
                                                @if ($isInstallment && $pendingInstallment)
                                                    @php
                                                        $urlBuktiInst = $pendingInstallment['evidence_url'] ?? '';
                                                        if (!empty($urlBuktiInst) && !str_starts_with($urlBuktiInst, 'http')) {
                                                            $urlBuktiInst = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/transactions/' . rawurlencode(ltrim($urlBuktiInst, '/'));
                                                        }
                                                    @endphp
                                                    <button onclick="lihatBuktiBayar('{{ $urlBuktiInst }}', '{{ $pendingInstallment['id'] }}', '{{ $pendingInstallment['evidence_url'] ?? '' }}', 'INSTALLMENT', '{{ $pendingInstallment['installment_number'] }}', '{{ $rekType }}', '{{ $rekBank }}', '{{ $rekNo }}')" class="w-full h-10 sm:h-11 bg-slate-800 hover:bg-slate-900 text-white text-[11px] sm:text-sm font-bold rounded-xl shadow-lg shadow-slate-300 transition-all active:scale-95 flex items-center justify-center gap-1.5 sm:gap-2">
                                                        <i class="ph-bold ph-check-circle text-base sm:text-lg"></i> Verif Tahap {{ $pendingInstallment['installment_number'] }}
                                                    </button>
                                                @else
                                                    <button onclick="lihatBuktiBayar('{{ $urlBukti }}', '{{ $item['id'] }}', '{{ $rawEvidenceName }}', 'FULL', '', '{{ $rekType }}', '{{ $rekBank }}', '{{ $rekNo }}')" class="w-full h-10 sm:h-11 bg-slate-800 hover:bg-slate-900 text-white text-[11px] sm:text-sm font-bold rounded-xl shadow-lg shadow-slate-300 transition-all active:scale-95 flex items-center justify-center gap-1.5 sm:gap-2">
                                                        <i class="ph-bold ph-check-circle text-base sm:text-lg"></i> Verifikasi Bayar
                                                    </button>
                                                @endif

                                            @elseif ($dataStatus == 'cicilan')
                                                <div class="grid grid-cols-2 gap-2 sm:gap-2.5">
                                                    <button disabled class="w-full h-10 sm:h-11 px-1 bg-slate-50 text-slate-400 text-[9px] sm:text-[11px] font-bold rounded-xl border border-slate-200 cursor-not-allowed flex items-center justify-center gap-1 text-center leading-tight">
                                                        <i class="ph-duotone ph-hourglass-low text-sm sm:text-base flex-shrink-0"></i> Tunggu Tahap {{ $nextUnpaidInst['installment_number'] ?? ($tahapLunas + 1) }}
                                                    </button>
                                                    <button onclick="cetakInvoice('{{ $invoice }}', '{{ addslashes($namaJamaah) }}', '{{ addslashes($emailJamaah) }}', '{{ addslashes($waJamaah) }}', '{{ addslashes($namaTravelInvoice) }}', '{{ addslashes($namaProduk) }}', '{{ $totalQty }}', '{{ $rincianCetakStr }}', '{{ $totalHarga }}', '{{ $tglOrder }}', '{{ $isInstallment ? 1 : 0 }}', '{{ $jsonInstallmentAman }}', '{{ $statusAPI }}', '{{ $rekType }}', '{{ $rekBank }}', '{{ $rekNo }}', '{{ addslashes($rekName) }}')" class="w-full h-10 sm:h-11 px-1 bg-blue-600 hover:bg-blue-700 text-white text-[10px] sm:text-xs font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 flex items-center justify-center gap-1 sm:gap-1.5">
                                                        <i class="ph-bold ph-file-pdf text-sm sm:text-base flex-shrink-0"></i> Invoice
                                                    </button>
                                                </div>

                                            @elseif(in_array($statusAPI, ['PAID', 'LUNAS', 'SUCCESS', 'DONE', 'COMPLETED']))
                                                <div class="grid grid-cols-2 gap-2 sm:gap-2.5">
                                                    @if($isInstallment)
                                                        <button onclick="lihatSemuaBuktiCicilan('{{ $jsonInstallmentAman }}')" class="w-full h-10 sm:h-11 px-1 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 text-emerald-700 text-[10px] sm:text-xs font-bold rounded-xl shadow-sm transition-all active:scale-95 flex items-center justify-center gap-1 sm:gap-1.5">
                                                            <i class="ph-bold ph-images text-sm sm:text-base flex-shrink-0"></i> Bukti Cicilan
                                                        </button>
                                                    @else
                                                        <button onclick="{{ !empty($urlBukti) ? "openImageLightbox('$urlBukti')" : "Swal.fire('Informasi', 'Bukti transfer tidak tersedia/diunggah.', 'info')" }}" class="w-full h-10 sm:h-11 px-1 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 text-emerald-700 text-[10px] sm:text-xs font-bold rounded-xl shadow-sm transition-all active:scale-95 flex items-center justify-center gap-1 sm:gap-1.5">
                                                            <i class="ph-bold ph-image text-sm sm:text-base flex-shrink-0"></i> Bukti Bayar
                                                        </button>
                                                    @endif
                                                    <button onclick="cetakInvoice('{{ $invoice }}', '{{ addslashes($namaJamaah) }}', '{{ addslashes($emailJamaah) }}', '{{ addslashes($waJamaah) }}', '{{ addslashes($namaTravelInvoice) }}', '{{ addslashes($namaProduk) }}', '{{ $totalQty }}', '{{ $rincianCetakStr }}', '{{ $totalHarga }}', '{{ $tglOrder }}', '{{ $isInstallment ? 1 : 0 }}', '{{ $jsonInstallmentAman }}', '{{ $statusAPI }}', '{{ $rekType }}', '{{ $rekBank }}', '{{ $rekNo }}', '{{ addslashes($rekName) }}')" class="w-full h-10 sm:h-11 px-1 bg-blue-600 hover:bg-blue-700 text-white text-[10px] sm:text-xs font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all active:scale-95 flex items-center justify-center gap-1 sm:gap-1.5">
                                                        <i class="ph-bold ph-file-pdf text-sm sm:text-base flex-shrink-0"></i> Invoice
                                                    </button>
                                                </div>

                                            @elseif($dataStatus == 'unpaid')
                                                <button disabled class="w-full h-10 sm:h-11 bg-slate-50 text-slate-400 text-[11px] sm:text-sm font-bold rounded-xl border border-slate-200 cursor-not-allowed flex items-center justify-center gap-1.5 sm:gap-2">
                                                    <i class="ph-duotone ph-clock text-base sm:text-lg flex-shrink-0"></i> Menunggu Bayar
                                                </button>
                                            @elseif($dataStatus == 'batal')
                                                <button disabled class="w-full h-10 sm:h-11 bg-red-50 text-red-400 text-[11px] sm:text-sm font-bold rounded-xl border border-red-100 cursor-not-allowed flex items-center justify-center gap-1.5 sm:gap-2">
                                                    <i class="ph-fill ph-x-circle text-base sm:text-lg flex-shrink-0"></i> Dibatalkan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                           @endforeach
                            <!-- 👇 EMPTY STATE SEKARANG DI LUAR LOOP 👇 -->
                            <div id="empty-state" class="{{ count($pesanan) > 0 ? 'hidden' : 'flex' }} flex-col items-center justify-center py-24 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-5 ring-8 ring-slate-50/50">
                                    <i id="empty-icon" class="ph-duotone ph-inbox text-5xl text-slate-300"></i>
                                </div>
                                <h3 id="empty-title" class="text-xl font-bold text-slate-900">Belum Ada Pesanan Masuk</h3>
                                <p id="empty-desc" class="text-slate-500 text-sm mt-2 mb-6 max-w-sm mx-auto">
                                    Saat ini belum ada riwayat transaksi atau pesanan jamaah untuk paket perjalanan Anda.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- 👇 MODAL DATA JAMAAH (VIEW ONLY UNTUK TRAVEL) 👇 -->
        @foreach($pesanan as $trx)
        @php
            $invoice = $trx['transaction_no'] ?? 'TRX-XXX';
            $totalPax = 0;
            $detailsArrayModal = is_array($trx['details'] ?? null) ? $trx['details'] : [];
            $roomTypesMapped = [];

            foreach ($detailsArrayModal as $det) {
                $qty = (int)($det['quantity'] ?? 1);
                $room = $det['room_types'] ?? 'Standar';
                $totalPax += $qty;
                for ($k = 0; $k < $qty; $k++) {
                    $roomTypesMapped[] = $room;
                }
            }
            if ($totalPax == 0) $totalPax = 1;
            
            $listJamaah = is_array($trx['jamaah'] ?? null) ? $trx['jamaah'] : [];
            $totalLengkap = count($listJamaah);
        @endphp

        <div id="modal-jamaah-{{ $trx['id'] }}" class="fixed inset-0 z-[110] bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0" onclick="if(event.target === this) closeJamaahModal('{{ $trx['id'] }}')">
            <div class="bg-slate-50 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[95vh] flex flex-col transform scale-95 transition-transform duration-300 overflow-hidden">
                
                <!-- Header -->
                <div class="px-5 sm:px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-white relative z-10 shadow-sm">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="w-10 h-10 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-500 shrink-0">
                            <i class="ph-duotone ph-users-three text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">Detail Data Jamaah</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Pesanan: <span class="font-bold text-slate-700">{{ $totalPax }} Pax</span> • {{ $invoice }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="hidden sm:block text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Kelengkapan</p>
                            <p class="text-sm font-black text-orange-600">{{ $totalLengkap }} / {{ $totalPax }} Mengisi</p>
                        </div>
                        <button onclick="closeJamaahModal('{{ $trx['id'] }}')" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:text-red-500 hover:bg-red-50 transition outline-none">
                            <i class="ph-bold ph-x text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Body / Accordion -->
                <div class="p-4 sm:p-6 overflow-y-auto custom-scrollbar flex-1 space-y-4">
                    @for ($i = 1; $i <= $totalPax; $i++)
                        @php
                            $dataJamaah = $listJamaah[$i - 1] ?? null;
                            $isLengkap = $dataJamaah ? true : false;
                            $cardBorder = $isLengkap ? 'border-emerald-200' : 'border-slate-200';
                            $iconBg = $isLengkap ? 'bg-emerald-100 border-emerald-200 text-emerald-600' : 'bg-slate-100 border-slate-200 text-slate-500';
                        @endphp
                        <div class="bg-white rounded-xl border {{ $cardBorder }} shadow-sm overflow-hidden transition-all duration-300">
                            <!-- Header Accordion -->
                            <button type="button" class="w-full px-5 py-4 flex items-center justify-between hover:bg-slate-50 transition outline-none" onclick="toggleJamaah('{{ $trx['id'] }}', {{ $i }})">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full {{ $iconBg }} flex items-center justify-center font-black shrink-0">
                                        {!! $isLengkap ? '<i class="ph-bold ph-check text-lg"></i>' : $i !!}
                                    </div>
                                    <div class="text-left">
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm sm:text-base font-bold text-slate-800">Jamaah {{ $i }}</h4>
                                            <span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                {{ $roomTypesMapped[$i - 1] ?? 'Standar' }}
                                            </span>
                                        </div>
                                        <p class="text-xs {{ $isLengkap ? 'text-slate-500' : 'text-orange-600 font-medium' }}">
                                            {{ $isLengkap ? $dataJamaah['fullname'] : 'Belum melengkapi data' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 sm:gap-4">
                                    @if($isLengkap)
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase rounded-md border border-emerald-200">Lengkap</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-red-50 text-red-600 text-[10px] font-bold uppercase rounded-md border border-red-100">Kosong</span>
                                    @endif
                                    <i class="ph-bold ph-caret-down text-slate-400 text-lg transition-transform duration-300" id="chevron-{{ $trx['id'] }}-{{ $i }}"></i>
                                </div>
                            </button>

                            <!-- Isi Panel View Only -->
                            <div id="content-jamaah-{{ $trx['id'] }}-{{ $i }}" class="hidden border-t border-slate-200 bg-slate-50/50 p-5 sm:p-6">
                                @if($isLengkap)
                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">

                                        <!-- Info Personal Read Only -->
                                        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
                                            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4 sm:mb-5">
                                                <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                                    <i class="ph-fill ph-user-circle text-orange-500 text-lg"></i> Informasi Personal
                                                </h4>
                                            </div>
                                            
                                            <div class="space-y-4 sm:space-y-5">
                                                <!-- Nama Lengkap (Lebar Penuh) -->
                                                <div class="min-w-0">
                                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Nama Lengkap</p>
                                                    <p class="text-sm font-bold text-slate-800 truncate" title="{{ $dataJamaah['fullname'] }}">{{ $dataJamaah['fullname'] }}</p>
                                                </div>
                                                
                                                <!-- 👇 PERBAIKAN: 1 kolom di HP, 2 kolom di Laptop, tambah min-w-0 & truncate 👇 -->
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                                                    <!-- Kolom Email -->
                                                    <div class="min-w-0">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Email</p>
                                                        <p class="text-sm font-bold text-slate-800 truncate" title="{{ $dataJamaah['email'] ?? '-' }}">
                                                            {{ $dataJamaah['email'] ?? '-' }}
                                                        </p>
                                                    </div>
                                                    
                                                    <!-- Kolom WA -->
                                                    <div class="min-w-0">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">No. WhatsApp</p>
                                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $dataJamaah['phone'] ?? '') }}" target="_blank" class="text-sm font-bold text-emerald-600 hover:underline flex items-center gap-1 w-fit max-w-full" title="{{ $dataJamaah['phone'] ?? '-' }}">
                                                            <span class="truncate">{{ $dataJamaah['phone'] ?? '-' }}</span> 
                                                            <i class="ph-bold ph-arrow-up-right text-[10px] flex-shrink-0"></i>
                                                        </a>
                                                    </div>
                                                    
                                                    <!-- Kolom Gender -->
                                                    <div class="min-w-0">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Jenis Kelamin</p>
                                                        <p class="text-sm font-bold text-slate-800 truncate">
                                                            {{ ($dataJamaah['gender'] ?? '') == 'L' ? 'Laki-laki (L)' : 'Perempuan (P)' }}
                                                        </p>
                                                    </div>
                                                    
                                                    <!-- Kolom Status -->
                                                    <div class="min-w-0">
                                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Status Pernikahan</p>
                                                        <p class="text-sm font-bold text-slate-800 capitalize truncate">
                                                            {{ $dataJamaah['status'] ?? '-' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dokumen Grid (Download/View) -->
                                        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm h-fit">
                                            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                                                <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                                    <i class="ph-fill ph-folder-open text-orange-500 text-lg"></i> Dokumen Pendukung
                                                </h4>
                                            </div>

                                            <!-- 4 Dokumen Pertama (Grid 2x2 Rapi) -->
                                            <div class="grid grid-cols-2 gap-3">
                                                @php
                                                $docs = [
                                                    ['name' => 'img_ktp', 'label' => 'KTP', 'icon' => 'ph-identification-card'],
                                                    ['name' => 'img_kk', 'label' => 'Kartu Keluarga', 'icon' => 'ph-users'],
                                                    ['name' => 'img_passpor', 'label' => 'Paspor', 'icon' => 'ph-book-bookmark'],
                                                    ['name' => 'img_diri', 'label' => 'Pas Foto', 'icon' => 'ph-camera'],
                                                ];
                                                @endphp
                                                @foreach($docs as $doc)
                                                    @if(!empty($dataJamaah[$doc['name']]))
                                                        <a href="https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/transactions/jamaah/{{ $dataJamaah[$doc['name']] }}" target="_blank" class="flex flex-col items-center justify-center p-3 rounded-xl border border-blue-100 bg-blue-50/50 hover:bg-blue-100 hover:border-blue-300 transition group cursor-pointer text-center">
                                                            <i class="ph-duotone {{ $doc['icon'] }} text-2xl text-blue-500 mb-1.5 group-hover:scale-110 transition"></i>
                                                            <span class="text-[10px] font-bold text-blue-700 leading-tight">{{ $doc['label'] }}</span>
                                                            <span class="text-[9px] text-blue-500 mt-1 flex items-center gap-0.5"><i class="ph-bold ph-eye"></i> Lihat</span>
                                                        </a>
                                                    @else
                                                        <div class="flex flex-col items-center justify-center p-3 rounded-xl border border-slate-100 bg-slate-50 opacity-70 text-center">
                                                            <i class="ph-duotone {{ $doc['icon'] }} text-2xl text-slate-400 mb-1.5"></i>
                                                            <span class="text-[10px] font-bold text-slate-500 leading-tight">{{ $doc['label'] }}</span>
                                                            <span class="text-[9px] text-slate-400 mt-1">Belum Upload</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>

                                            <!-- Dokumen Ke-5: Akta Kelahiran (Full Width Horizontal Card) -->
                                            @php
                                                $aktaUrl = !empty($dataJamaah['img_akta_kelahiran']) ? 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/transactions/jamaah/' . $dataJamaah['img_akta_kelahiran'] : '';
                                            @endphp
                                            <div class="mt-3">
                                                @if($aktaUrl)
                                                    <!-- 👇 Ditambahkan justify-center di sini 👇 -->
                                                    <a href="{{ $aktaUrl }}" target="_blank" class="flex items-center justify-center p-3.5 rounded-xl border border-blue-100 bg-blue-50/50 hover:bg-blue-100 hover:border-blue-300 transition group cursor-pointer gap-3.5 shadow-sm">
                                                        <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-500 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition">
                                                            <i class="ph-duotone ph-file-text text-2xl"></i>
                                                        </div>
                                                        <div class="flex flex-col text-left">
                                                            <span class="text-xs font-bold text-blue-700 leading-tight">Akta Kelahiran</span>
                                                            <span class="text-[10px] text-blue-500 mt-0.5 flex items-center gap-1 font-medium"><i class="ph-bold ph-eye"></i> Lihat Dokumen</span>
                                                        </div>
                                                    </a>
                                                @else
                                                    <!-- 👇 Dan ditambahkan justify-center di sini 👇 -->
                                                    <div class="flex items-center justify-center p-3.5 rounded-xl border border-slate-100 bg-slate-50 opacity-70 gap-3.5">
                                                        <div class="w-10 h-10 rounded-lg bg-slate-200 text-slate-400 flex items-center justify-center flex-shrink-0">
                                                            <i class="ph-duotone ph-file-text text-2xl"></i>
                                                        </div>
                                                        <div class="flex flex-col text-left">
                                                            <span class="text-xs font-bold text-slate-500 leading-tight">Akta Kelahiran</span>
                                                            <span class="text-[10px] text-slate-400 mt-0.5">Belum Upload</span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                @else
                                    <div class="text-center py-10">
                                        <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                            <i class="ph-duotone ph-file-dashed text-3xl text-red-400"></i>
                                        </div>
                                        <h4 class="text-base font-bold text-slate-800">Menunggu Input Jamaah</h4>
                                        <p class="text-sm text-slate-500 max-w-sm mx-auto mt-1">Pemesan belum melengkapi data biodata maupun mengunggah dokumen untuk jamaah ini.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
        @endforeach
        <!-- 👆 SELESAI MODAL DATA JAMAAH 👆 -->

        <div id="image-lightbox" class="fixed inset-0 z-[9999] bg-black/95 hidden flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" onclick="closeImageLightbox()"> 
            <!-- Tombol Close --> 
            <button class="absolute top-4 right-4 md:top-6 md:right-6 text-white/70 hover:text-orange-500 transition outline-none"> 
                <i class="ph-bold ph-x text-3xl md:text-4xl"></i> 
            </button> 
            <!-- Gambar yang akan diperbesar --> 
            <img id="lightbox-img-element" src="" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()"> 
        </div>

    </main>

    </main>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
    AOS.init({ duration: 800, once: true });

        // --- FITUR PENCARIAN & FILTER (DIPERBARUI) ---
        function searchOrders(keyword) {
            keyword = keyword.toLowerCase();
            const cards = document.querySelectorAll('.searchable-item');
            let visibleCount = 0;

            const activeTab = document.querySelector('.tab-btn.active').innerText.trim();
            let currentStatus = 'all';
            if (activeTab.includes('Verifikasi')) currentStatus = 'verifikasi';
            if (activeTab.includes('Cicilan')) currentStatus = 'cicilan';
            if (activeTab.includes('Lunas')) currentStatus = 'lunas';
            if (activeTab.includes('Selesai')) currentStatus = 'selesai';
            if (activeTab.includes('Dibatalkan')) currentStatus = 'batal';

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

            checkEmptyState(visibleCount, currentStatus, keyword);
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
            const keyword = searchInput ? searchInput.value.toLowerCase() : '';
            const cards = document.querySelectorAll('.order-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const matchStatus = (status === 'all' || card.getAttribute('data-status') === status);
                const matchSearch = card.getAttribute('data-search').includes(keyword);

                if (matchStatus && matchSearch) {
                    card.style.display = 'block';
                    card.classList.remove('aos-animate');
                    setTimeout(() => card.classList.add('aos-animate'), 50);
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            checkEmptyState(visibleCount, status, keyword);
        }

        function checkEmptyState(count, status, keyword = '') {
            const emptyState = document.getElementById('empty-state');
            const icon = document.getElementById('empty-icon');
            const title = document.getElementById('empty-title');
            const desc = document.getElementById('empty-desc');

            if (count === 0) {
                emptyState.classList.remove('hidden');
                emptyState.classList.add('flex');

                // Logika ganti teks dinamis
                if (keyword.trim() !== '') {
                    icon.className = "ph-duotone ph-magnifying-glass text-5xl text-slate-300";
                    title.innerText = "Pencarian Tidak Ditemukan";
                    desc.innerText = `Tidak ada data pesanan jamaah yang cocok dengan kata kunci "${keyword}".`;
                } else if (status === 'verifikasi') {
                    icon.className = "ph-duotone ph-clipboard-text text-5xl text-orange-400";
                    title.innerText = "Verifikasi Selesai";
                    desc.innerText = "Bagus! Saat ini tidak ada pesanan masuk yang menunggu proses validasi pembayaran dari Anda.";
                } else if (status === 'lunas') {
                    icon.className = "ph-duotone ph-check-circle text-5xl text-blue-400";
                    title.innerText = "Belum Ada Pesanan Lunas";
                    desc.innerText = "Saat ini belum ada riwayat pesanan jamaah yang telah dikonfirmasi dan berstatus lunas.";
                } else if (status === 'batal') {
                    icon.className = "ph-duotone ph-x-circle text-5xl text-red-400";
                    title.innerText = "Tidak Ada Pesanan Dibatalkan";
                    desc.innerText = "Syukurlah, tidak ada transaksi yang dibatalkan atau ditolak saat ini.";                    
                } else {
                    icon.className = "ph-duotone ph-inbox text-5xl text-slate-300";
                    title.innerText = "Belum Ada Pesanan Masuk";
                    desc.innerText = "Saat ini belum ada riwayat transaksi atau pesanan jamaah untuk paket perjalanan Anda.";
                }
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

        // --- FITUR VERIFIKASI & REJECT PEMBAYARAN ---
        function lihatBuktiBayar(imgUrl, idTarget, rawEvidence, type = 'FULL', tahap = '', rekType = '', rekBank = '', rekNo = '') {
            if (!imgUrl || imgUrl === '' || imgUrl === 'null' || imgUrl.includes('dummy')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Bukti Belum Ada',
                    text: 'Jamaah ini belum mengunggah bukti pembayaran.',
                    confirmButtonColor: '#ea580c',
                    customClass: { confirmButton: 'rounded-xl px-6 py-2.5 font-bold' }
                });
                return;
            }

            let titleText = type === 'INSTALLMENT' ? `Verifikasi Cicilan Tahap ${tahap}` : 'Verifikasi Pembayaran';

            // Bikin Info Badge Bank jadi lebih modern ala FinTech
            let bankInfoHtml = '';
            if (rekType === 'MARKETPLACE') {
                let bankColor = rekBank.includes('BSI') ? 'text-teal-700 bg-teal-50 border-teal-200' : 'text-blue-700 bg-blue-50 border-blue-200';
                bankInfoHtml = `
                <div class="mt-4 p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex flex-col text-left">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Tujuan Transfer</span>
                        <span class="text-sm font-black text-slate-800 uppercase">${rekBank} <span class="font-mono text-slate-600 font-bold ml-1 tracking-wide">${rekNo}</span></span>
                    </div>
                    <div class="px-2 py-1 rounded-md border ${bankColor} font-bold text-[10px] uppercase tracking-wide flex-shrink-0">
                        Pusat
                    </div>
                </div>`;
            } else if (rekType === 'MANDIRI') {
                bankInfoHtml = `
                <div class="mt-4 p-3.5 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between shadow-sm">
                    <div class="flex flex-col text-left">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Tujuan Transfer</span>
                        <span class="text-sm font-black text-slate-800 uppercase">${rekBank} <span class="font-mono text-slate-600 font-bold ml-1 tracking-wide">${rekNo}</span></span>
                    </div>
                    <div class="px-2 py-1 rounded-md border border-orange-200 bg-orange-50 text-orange-700 font-bold text-[10px] uppercase tracking-wide flex-shrink-0">
                        Travel
                    </div>
                </div>`;
            }

            // Desain Container Gambar biar gak meleber dan bisa di-klik untuk full screen
            let contentHtml = `
            <div class="flex flex-col">
                <div class="w-full bg-slate-100 rounded-2xl p-2.5 border border-slate-200 relative group overflow-hidden shadow-inner">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none z-10 rounded-2xl">
                        <span class="text-white text-xs font-bold flex items-center gap-1.5 px-3 py-1.5 bg-black/50 backdrop-blur-sm rounded-lg"><i class="ph-bold ph-arrows-out-simple"></i> Perbesar</span>
                    </div>
                    <img src="${imgUrl}" class="w-full h-48 sm:h-56 object-contain rounded-xl bg-white cursor-pointer transition-transform duration-300 group-hover:scale-105" onclick="openImageLightbox('${imgUrl}')" title="Klik untuk perbesar gambar">
                </div>
                ${bankInfoHtml}
            </div>
            `;

            Swal.fire({
                title: `<div class="flex items-center gap-3 justify-start text-slate-900 border-b border-slate-100 pb-3"><div class="w-10 h-10 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600"><i class="ph-duotone ph-shield-check text-2xl"></i></div><div><h3 class="text-base font-extrabold text-slate-900 leading-tight">${titleText}</h3><p class="text-[11px] font-normal text-slate-500 mt-0.5">Cek mutasi dan pastikan nominal sesuai</p></div></div>`,
                html: contentHtml,
                showCancelButton: true,
                showDenyButton: true,
                buttonsStyling: false, // Mamatikan style bawaan SweetAlert agar Tailwind bisa full jalan
                confirmButtonText: '<i class="ph-bold ph-check-circle text-lg"></i> <span>ACC</span>',
                denyButtonText: '<i class="ph-bold ph-x-circle text-lg"></i> <span>Tolak</span>',
                cancelButtonText: 'Tutup',
                footer: '<div class="w-full text-center py-1"><p class="text-[11px] text-slate-500 flex items-center justify-center gap-1"><i class="ph-fill ph-info text-blue-500 text-sm"></i> Pastikan dana masuk sebelum klik ACC.</p></div>',
                customClass: {
                    popup: 'rounded-3xl p-5 sm:p-6 shadow-2xl border border-slate-100',
                    title: 'p-0 text-left',
                    htmlContainer: 'm-0 pt-4',
                    actions: 'flex flex-row flex-wrap justify-between gap-2.5 mt-5 w-full p-0',
                    confirmButton: 'flex-1 inline-flex items-center justify-center gap-1.5 py-3 px-4 m-0 rounded-xl text-sm font-extrabold text-white bg-emerald-600 hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 active:scale-95 transition-all outline-none',
                    denyButton: 'flex-1 inline-flex items-center justify-center gap-1.5 py-3 px-4 m-0 rounded-xl text-sm font-extrabold text-white bg-red-600 hover:bg-red-700 shadow-lg shadow-red-500/30 active:scale-95 transition-all outline-none',
                    cancelButton: 'w-full inline-flex items-center justify-center py-3 px-4 m-0 rounded-xl text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 active:scale-95 transition-all outline-none'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Yakin data sudah valid?',
                        text: "Setelah ACC, status tidak dapat diubah lagi.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#16a34a',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, ACC Sekarang!',
                        customClass: { confirmButton: 'rounded-xl font-bold', cancelButton: 'rounded-xl font-bold' }
                    }).then((accResult) => {
                        if (accResult.isConfirmed) prosesVerifikasi(idTarget, rawEvidence, 'PAID', type);
                    });
                } else if (result.isDenied) {
                    Swal.fire({
                        title: 'Tolak Bukti Bayar?',
                        text: "Jamaah harus melakukan upload ulang bukti transfer.",
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#64748b',
                        confirmButtonText: 'Ya, Tolak',
                        customClass: { confirmButton: 'rounded-xl font-bold', cancelButton: 'rounded-xl font-bold' }
                    }).then((rejectResult) => {
                        if (rejectResult.isConfirmed) prosesVerifikasi(idTarget, rawEvidence, 'FAILED', type);
                    });
                }
            });
        }

        // --- JAVASCRIPT: PROSES AJAX ---
        function prosesVerifikasi(idTarget, rawEvidence, targetStatus, type) {
            Swal.fire({ title: 'Memproses...', text: 'Sedang menghubungi server...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });

            let urlApi = `/marketplace/travel/pesanan-masuk/${idTarget}/verifikasi`;
            let formData = new FormData();
            formData.append('_method', 'PUT'); // Dummy method (Di Controller diconvert)
            formData.append('target_status', targetStatus);
            formData.append('evidence_url', rawEvidence || '');
            formData.append('type', type); // Kirim tipe FULL / INSTALLMENT
            formData.append('_token', '{{ csrf_token() }}');

            fetch(urlApi, { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire('Berhasil!', data.message, 'success').then(() => window.location.reload());
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                }).catch(error => { Swal.fire('Error Sistem!', 'Terjadi kesalahan jaringan atau koneksi.', 'error'); });
        }

        // =====================================================================
        // 🌟 2. FUNGSI INVOICE DOKUMEN CETAK PDF (KHUSUS TRAVEL) 🌟
        // =====================================================================
        function cetakInvoice(invoice, namaJamaah, emailJamaah, waJamaah, namaTravel, paket, qty, rincianKamar, total, tanggal, isInstallment, instDataB64, statusTrx, rekType, rekBank, rekNo, rekName) {
            const printWindow = window.open('', '_blank', 'width=900,height=900');
            const now = new Date();
            const options = { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
            const waktuCetak = now.toLocaleDateString('id-ID', options).replace('pukul', ',') + ' WIB';
            const baseUrl = window.location.origin;

            const teksWa = (waJamaah && waJamaah !== 'null' && waJamaah !== 'undefined' && waJamaah !== '-' && waJamaah.trim() !== '') ? waJamaah : 'Tidak dicantumkan';
            const teksEmail = (emailJamaah && emailJamaah !== 'null' && emailJamaah !== 'undefined' && emailJamaah !== '-' && emailJamaah.trim() !== '') ? emailJamaah : 'Tidak dicantumkan';
            const badgesHtml = rincianKamar.split(', ').map(r => `<span class="badge">${r}</span>`).join('');

            let statusUpper = statusTrx.toUpperCase();
            let isLunas = ['PAID', 'LUNAS', 'SUCCESS', 'DONE', 'COMPLETED'].includes(statusUpper);
            let isPartial = statusUpper === 'PARTIAL';
            let statusText = isLunas ? 'LUNAS / PAID' : (isPartial ? 'CICILAN BERJALAN' : 'MENUNGGU PEMBAYARAN');
            let statusColor = isLunas ? '#10b981' : (isPartial ? '#3b82f6' : '#ea580c');
            let stempelPdfHtml = isLunas ? `<img src="${baseUrl}/assets/img/marketplace/stempel-lunas.png" class="stempel-lunas-pdf" alt="Stempel Lunas">` : '';

            let rekeningPdfHtml = '';
            if (rekType === 'MARKETPLACE') {
                if (rekBank.includes('/')) {
                    // FALLBACK: JIKA DI DATABASE GAK ADA NAMA BANK SPESIFIK 
                    // Maka terpaksa munculkan dua-duanya karena kita gak tau jamaah transfer kemana
                    rekeningPdfHtml = `
                        <h3>PEMBAYARAN (PUSAT)</h3>
                        <p style="margin-bottom: 2px;"><strong>BCA:</strong> 7131720452</p>
                        <p style="margin-bottom: 2px;"><strong>BSI:</strong> 7215671498</p>
                        <p style="margin-top: 4px; font-size: 11px;">a.n PT Kolaborasi Para Sahabat</p>
                    `;
                } else {
                    // NORMAL: Menampilkan HANYA BSI atau HANYA BCA sesuai yang dipilih jamaah
                    rekeningPdfHtml = `
                        <h3>PEMBAYARAN (PUSAT)</h3>
                        <p style="margin-bottom: 4px; font-weight: bold; font-size: 13px;">${rekBank}</p>
                        <p style="margin-bottom: 2px; font-size: 16px; font-family: monospace; color: var(--text-main); font-weight: 800;">${rekNo}</p>
                        <p style="margin-top: 4px; font-size: 11px;">a.n PT Kolaborasi Para Sahabat</p>
                    `;
                }
            } else {
                rekeningPdfHtml = `
                    <h3>PEMBAYARAN (TRAVEL)</h3>
                    <p style="margin-bottom: 4px; font-weight: bold; font-size: 13px;">${rekBank}</p>
                    <p style="margin-bottom: 2px; font-size: 16px; font-family: monospace; color: var(--text-main); font-weight: 800;">${rekNo}</p>
                    <p style="margin-top: 4px; font-size: 11px;">a.n ${rekName}</p>
                `;
            }

            let riwayatPembayaranHtml = '';
            if (isInstallment == '1' && instDataB64) {
                let insts = JSON.parse(atob(instDataB64));
                insts.sort((a, b) => a.installment_number - b.installment_number);
                let rows = '';
                insts.forEach(inst => {
                    let nominal = parseInt(inst.amount).toLocaleString('id-ID');
                    let tLabel = inst.installment_number == 1 ? 'Tahap 1 (DP)' : 'Tahap ' + inst.installment_number;
                    let st = (inst.status || 'UNPAID').toUpperCase();
                    let stLabel = ['PAID', 'SUCCESS'].includes(st) 
                        ? '<span style="color:#10b981; font-weight:800; background-color:#ecfdf5; padding: 4px 10px; border-radius: 4px; font-size:11px;">LUNAS</span>' 
                        : '<span style="color:#64748b; font-weight:600; font-size:11px;">Belum Lunas</span>';

                    rows += `
                    <tr>
                        <td style="padding: 12px 16px; border-bottom: 1px solid var(--border-color); font-weight:600;">${tLabel}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid var(--border-color); text-align: center;">${stLabel}</td>
                        <td style="padding: 12px 16px; border-bottom: 1px solid var(--border-color); text-align: right; font-weight: 700;">Rp ${nominal}</td>
                    </tr>
                    `;
                });

                riwayatPembayaranHtml = `
                <h3 style="font-size: 13px; color: var(--text-main); font-weight: 800; margin-bottom: 12px; margin-top: 10px;">Rincian Skema Pembayaran</h3>
                <table style="margin-bottom: 40px; border-color: #cbd5e1;">
                    <thead style="background-color: #f1f5f9;">
                        <tr>
                            <th style="padding: 12px 16px;">Tahap Cicilan</th>
                            <th class="text-center" style="width: 25%; padding: 12px 16px;">Status Verifikasi</th>
                            <th class="text-right" style="width: 25%; padding: 12px 16px;">Nominal Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${rows}
                    </tbody>
                </table>
                `;
            }

            // Gak pake tulisan <script> atau @import langsung biar gak crash di Laravel!
            const htmlContent = `
            <!DOCTYPE html>
            <html lang="id">
            <head>
                <meta charset="UTF-8">
                <title>INVOICE - ${invoice}</title>
                <style>
                    ` + '@' + `import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
                    ` + '@' + `page { size: A4; margin: 15mm; }
                    :root { --primary: #ea580c; --primary-light: #fff7ed; --text-main: #0f172a; --text-muted: #64748b; --border-color: #e2e8f0; --bg-muted: #f8fafc; }
                    body { font-family: 'Plus Jakarta Sans', sans-serif; padding: 40px; color: var(--text-main); line-height: 1.5; max-width: 850px; margin: 0 auto; background: #fff; -webkit-font-smoothing: antialiased; }
                    .header-top { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid var(--primary); padding-bottom: 25px; margin-bottom: 35px; }
                    .brand h1 { color: var(--text-main); margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px; }
                    .brand p { margin: 4px 0 0 0; color: var(--text-muted); font-size: 13px; font-weight: 500; }
                    .invoice-title { text-align: right; }
                    .invoice-title h2 { margin: 0; color: var(--primary); font-size: 32px; font-weight: 800; letter-spacing: 1px; }
                    .invoice-title .inv-number { font-family: monospace; font-size: 14px; color: var(--text-muted); font-weight: 600; margin-top: 4px; }
                    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px; }
                    .info-box { background: var(--bg-muted); padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); }
                    .info-box h3 { font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin: 0 0 12px 0; font-weight: 700; }
                    .info-box strong { font-size: 16px; color: var(--text-main); display: block; margin-bottom: 8px; }
                    .info-box p { margin: 4px 0; font-size: 13px; color: var(--text-muted); }
                    table { width: 100%; border-collapse: separate; border-spacing: 0; margin-bottom: 30px; border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; }
                    th { background-color: var(--bg-muted); color: var(--text-muted); font-size: 12px; text-transform: uppercase; letter-spacing: 1px; text-align: left; padding: 16px; font-weight: 700; border-bottom: 1px solid var(--border-color); }
                    td { padding: 20px 16px; font-size: 14px; color: var(--text-main); border-bottom: 1px solid var(--border-color); vertical-align: top; }
                    tr:last-child td { border-bottom: none; }
                    th.text-center, td.text-center { text-align: center; }
                    th.text-right, td.text-right { text-align: right; }
                    .product-name { font-weight: 700; font-size: 15px; color: var(--text-main); margin-bottom: 8px; display: block; }
                    .badge-container { margin-top: 8px; display: flex; flex-wrap: wrap; gap: 6px; }
                    .badge { background-color: var(--primary-light); color: var(--primary); border: 1px solid #ffd8b5; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; }
                    .summary-wrapper { display: flex; justify-content: flex-end; margin-bottom: 40px; position: relative; }
                    .summary-box { width: 350px; position: relative; z-index: 10; background: white; }
                    .summary-row { display: flex; justify-content: space-between; padding: 12px 16px; font-size: 14px; color: var(--text-muted); border-bottom: 1px solid var(--bg-muted); }
                    .summary-row.total { background-color: var(--primary); color: white; font-size: 18px; font-weight: 800; border-radius: 8px; padding: 16px; margin-top: 12px; border: none; }
                    .status-stamp { display: inline-block; color: ${statusColor}; border: 2px solid ${statusColor}; padding: 6px 16px; font-size: 14px; font-weight: 800; border-radius: 6px; margin-top: 10px; letter-spacing: 1px; text-transform: uppercase; }
                    .footer { text-align: center; font-size: 12px; color: var(--text-muted); border-top: 1px dashed var(--border-color); padding-top: 30px; }
                    .stempel-lunas-pdf { position: absolute; right: 100px; top: -10px; width: 190px; opacity: 0.7; mix-blend-mode: multiply; transform: rotate(-12deg); pointer-events: none; z-index: 50; }
                    ` + '@' + `media print {
                        body { padding: 0; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                        .summary-row.total { background-color: var(--primary) !important; color: white !important; }
                        .badge { background-color: var(--primary-light) !important; border-color: #ffd8b5 !important; }
                        .stempel-lunas-pdf { mix-blend-mode: multiply !important; opacity: 0.7 !important; }
                        .status-stamp { color: ${statusColor} !important; border-color: ${statusColor} !important; }
                    }
                </style>
            </head>
            <body>
                <div class="header-top">
                    <div class="brand">
                        <h1>${namaTravel}</h1>
                        <p>Mitra Resmi Pengenumroh Marketplace</p>
                    </div>
                    <div class="invoice-title">
                        <h2>INVOICE</h2>
                        <div class="inv-number">#${invoice}</div>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-box">
                        <h3>DITAGIHKAN KEPADA:</h3>
                        <strong>${namaJamaah}</strong>
                        <p>WA / Telp: ${teksWa}</p>
                        <p>Email: ${teksEmail}</p>
                    </div>
                    <div class="info-box">
                        <h3>INFORMASI PEMBAYARAN:</h3>
                        <p style="margin-bottom: 2px;">Waktu Order: <strong style="color: var(--text-main);">${tanggal}</strong></p>
                        <p style="margin-bottom: 2px;">Waktu Cetak: <strong style="color: var(--text-main);">${waktuCetak}</strong></p>
                        <div class="status-stamp">${statusText}</div>
                    </div>
                </div>
                
                <div style="margin-bottom: 40px; padding-bottom: 20px; border-bottom: 1px dashed var(--border-color);">
                    ${rekeningPdfHtml}
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Detail Paket & Akomodasi</th>
                            <th class="text-center" style="width: 15%;">Total Pax</th>
                            <th class="text-right" style="width: 25%;">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <span class="product-name">${paket}</span>
                                <span style="font-size: 12px; color: var(--text-muted);">Rincian Kamar:</span>
                                <div class="badge-container">
                                    ${badgesHtml}
                                </div>
                            </td>
                            <td class="text-center" style="font-weight: 700;">${qty} Pax</td>
                            <td class="text-right" style="font-weight: 700;">Rp ${total}</td>
                        </tr>
                    </tbody>
                </table>

                ${riwayatPembayaranHtml}

                <div class="summary-wrapper">
                    ${stempelPdfHtml}
                    <div class="summary-box">
                        <div class="summary-row">
                            <span>Subtotal Harga</span>
                            <span style="font-weight: 600; color: var(--text-main);">Rp ${total}</span>
                        </div>
                        <div class="summary-row total">
                            <span>TOTAL KESELURUHAN</span>
                            <span>Rp ${total}</span>
                        </div>
                    </div>
                </div>

                <div class="footer">
                    <p>Terima kasih telah mempercayakan perjalanan ibadah Anda bersama <strong>${namaTravel}</strong>.</p>
                    <p>Dokumen ini sah dan diterbitkan secara elektronik oleh sistem Pengenumroh. Tidak memerlukan tanda tangan basah.</p>
                </div>
            </body>
            </html>
            `;

            printWindow.document.write(htmlContent);
            // Ini trick aman biar <script> gak dibaca error sama browser utama
            printWindow.document.write('<scr' + 'ipt>window.onload = function() { setTimeout(() => { window.print(); }, 800); }</scr' + 'ipt>');
            printWindow.document.close();
        }
        
</script>

<script>
    // --- FITUR LIGHTBOX GAMBAR POSTER ---
    function openImageLightbox(src) {
        const lightbox = document.getElementById('image-lightbox');
        const img = document.getElementById('lightbox-img-element');
        
        // Pasang link gambar dari card yang diklik ke modal
        img.src = src;

        // Munculkan elemen (hapus hidden)
        lightbox.classList.remove('hidden');
        
        // Trigger efek transisi (delay mikro)
        setTimeout(() => {
            lightbox.classList.remove('opacity-0');
            img.classList.remove('scale-95');
        }, 10);
    }

    function closeImageLightbox() {
        const lightbox = document.getElementById('image-lightbox');
        const img = document.getElementById('lightbox-img-element');
        
        // Mulai animasi menghilang (fade out & scale down)
        lightbox.classList.add('opacity-0');
        img.classList.add('scale-95');
        
        // Sembunyikan elemen sepenuhnya setelah animasi selesai (300ms)
        setTimeout(() => {
            lightbox.classList.add('hidden');
            img.src = ''; // Bersihkan gambar agar tidak berbayang saat buka gambar lain
        }, 300);
    }
</script>

<script>
    // --- FITUR MODAL DATA JAMAAH (TRAVEL VIEW) ---
    function openJamaahModal(trxId) {
        const modal = document.getElementById(`modal-jamaah-${trxId}`);
        if(modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('div').classList.remove('scale-95');
            }, 10);
        }
    }

    function closeJamaahModal(trxId) {
        const modal = document.getElementById(`modal-jamaah-${trxId}`);
        if(modal) {
            modal.classList.add('opacity-0');
            modal.querySelector('div').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
    }

    function toggleJamaah(trxId, index) {
        const content = document.getElementById(`content-jamaah-${trxId}-${index}`);
        const chevron = document.getElementById(`chevron-${trxId}-${index}`);
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            chevron.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            chevron.classList.remove('rotate-180');
        }
    }
</script>

<script>

    function lihatSemuaBuktiCicilan(instDataB64) {
    if (!instDataB64) {
        Swal.fire({
            icon: 'info',
            title: 'Informasi',
            text: 'Data tahapan cicilan tidak ditemukan.',
            confirmButtonColor: '#f97316',
            confirmButtonClass: 'rounded-xl'
        });
        return;
    }

    let insts = JSON.parse(atob(instDataB64));
    insts.sort((a, b) => a.installment_number - b.installment_number);

    // Hitung total lunas untuk progress header
    let totalTahap = insts.length;
    let lunasCount = insts.filter(i => ['PAID', 'SUCCESS'].includes((i.status || '').toUpperCase())).length;
    let progressPersen = totalTahap > 0 ? Math.round((lunasCount / totalTahap) * 100) : 0;

    let htmlContent = `
    <div class="space-y-4 text-left">
        <!-- 🌟 KARTU PROGRESS RINGKASAN CICILAN 🌟 -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-4 text-white shadow-md relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-orange-500/20 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex justify-between items-center mb-2 relative z-10">
                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">Status Pelunasan</span>
                <span class="px-2 py-0.5 bg-orange-500/20 border border-orange-400/30 text-orange-400 text-[10px] font-black rounded-full">${lunasCount} dari ${totalTahap} Tahap Lunas</span>
            </div>
            <div class="w-full bg-slate-700/80 rounded-full h-2 mb-1 overflow-hidden relative z-10">
                <div class="bg-gradient-to-r from-orange-500 to-amber-400 h-2 rounded-full transition-all duration-1000" style="width: ${progressPersen}%"></div>
            </div>
        </div>

        <!-- 🌟 LIST KARTU TAHAPAN 🌟 -->
        <div class="flex flex-col gap-3 max-h-[55vh] overflow-y-auto custom-scrollbar pr-1">
    `;

    insts.forEach(inst => {
        let namaTahap = inst.installment_number == 1 ? 'Tahap 1 (DP Awal)' : 'Tahap ' + inst.installment_number;
        let nominal = 'Rp ' + parseInt(inst.amount).toLocaleString('id-ID');
        let status = (inst.status || 'UNPAID').toUpperCase();
        let isPaid = ['PAID', 'SUCCESS'].includes(status);
        let isPending = status === 'PENDING';
        
        // Desain Badge Status Modern & Estetik
        let badgeStatus = isPaid 
            ? `<span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 text-[10px] font-extrabold px-2.5 py-1 rounded-lg border border-emerald-200 shadow-2xs"><i class="ph-fill ph-check-circle text-emerald-600 text-xs"></i> LUNAS</span>` 
            : (isPending 
                ? `<span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 text-[10px] font-extrabold px-2.5 py-1 rounded-lg border border-yellow-200 shadow-2xs"><i class="ph-bold ph-hourglass-high text-yellow-600 text-xs animate-spin-slow"></i> VERIFIKASI</span>`
                : `<span class="inline-flex items-center gap-1 bg-slate-100 text-slate-500 text-[10px] font-bold px-2.5 py-1 rounded-lg border border-slate-200 shadow-2xs"><i class="ph-bold ph-clock text-xs"></i> BELUM DIBAYAR</span>`);

        let evUrl = inst.evidence_url;
        let btnHtml = '';

        if (evUrl && evUrl !== 'null' && evUrl !== '') {
            let fullUrl = evUrl.startsWith('http') ? evUrl : 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/transactions/' + evUrl.replace(/^\/+/, '');
            btnHtml = `
                <button onclick="openImageLightbox('${fullUrl}')" class="px-3.5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm shadow-blue-500/20 active:scale-95 flex items-center gap-1.5 flex-shrink-0 cursor-pointer">
                    <i class="ph-bold ph-eye text-sm"></i> Lihat Bukti
                </button>
            `;
        } else {
            btnHtml = `
                <div class="px-3.5 py-2.5 bg-slate-100 text-slate-400 rounded-xl text-xs font-semibold border border-slate-200 flex items-center gap-1.5 cursor-not-allowed">
                    <i class="ph-bold ph-image-broken text-sm"></i> Kosong
                </div>
            `;
        }

        htmlContent += `
        <div class="p-4 border ${isPaid ? 'border-emerald-200/80 bg-emerald-50/20' : 'border-slate-200 bg-white'} rounded-2xl hover:border-orange-300 hover:shadow-lg hover:shadow-orange-500/5 transition-all duration-300 flex items-center justify-between gap-4">
            <div class="flex flex-col gap-1 min-w-0">
                <div class="flex items-center gap-2">
                    <h4 class="text-sm font-black text-slate-900 tracking-tight">${namaTahap}</h4>
                </div>
                <div class="mt-0.5">${badgeStatus}</div>
                <p class="text-sm font-black text-orange-600 mt-1">${nominal}</p>
            </div>
            <div class="flex-shrink-0">
                ${btnHtml}
            </div>
        </div>
        `;
    });

    htmlContent += '</div></div>';

    // Konfigurasi SweetAlert dengan Tampilan Premium
    Swal.fire({
        title: '<div class="flex items-center gap-2.5 justify-start text-slate-900 border-b border-slate-100 pb-3"><div class="w-10 h-10 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-600"><i class="ph-duotone ph-receipt text-2xl"></i></div><div><h3 class="text-base font-extrabold text-slate-900 leading-tight">Bukti & Riwayat Cicilan</h3><p class="text-[11px] font-normal text-slate-500">Rincian status per tahap angsuran jamaah</p></div></div>',
        html: htmlContent,
        showConfirmButton: true,
        confirmButtonText: 'Tutup',
        confirmButtonColor: '#0f172a',
        width: 520,
        background: '#ffffff',
        customClass: {
            container: 'backdrop-blur-xs',
            popup: 'rounded-3xl p-5 sm:p-6 shadow-2xl border border-slate-100',
            title: 'p-0 text-left',
            htmlContainer: 'm-0 pt-3 text-left',
            confirmButton: 'w-full rounded-xl py-3 text-sm font-bold shadow-lg shadow-slate-900/10 hover:bg-slate-800 transition-colors mt-3'
        }
    });
}
    
</script>

</body>

</html>
