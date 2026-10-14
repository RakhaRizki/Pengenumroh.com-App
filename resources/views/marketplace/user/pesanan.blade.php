<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Pesanan - Pengenumroh</title>
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
         .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9; 
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1; 
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; 
        }

        /* Animasi vertikal presisi tinggi (Anti-ngebug di tengah) */
        @keyframes swapTextPrecise {
            0%, 40% { transform: translateY(0%); }
            50%, 90% { transform: translateY(-50%); }
            100% { transform: translateY(0%); }
        }
        .animate-swap-text {
            /* Pake efek transisi ease-in-out biar pergerakannya elegan & mulus */
            animation: swapTextPrecise 6s ease-in-out infinite;
        }
        
        /* Animasi efek cahaya kilap di background banner */
        @keyframes shine {
            0% { left: -100%; }
            20%, 100% { left: 200%; }
        }
        .animate-shine {
            animation: shine 4s infinite;
        }

    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

    {{-- {{ dd($userProfile) }} --}}

    <nav class="fixed w-full z-50 bg-white border-b border-slate-200 shadow-sm">
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
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-700">{{ $userProfile['nama'] ?? 'Jamaah' }}</p>
                            <p class="text-[10px] text-slate-500">Jamaah</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                            <img src="{{ $userProfile['avatar'] ?? 'https://ui-avatars.com/api/?name=User' }}" class="w-full h-full object-cover">
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

    <main class="pt-28 pb-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                <!-- KIRI: SIDEBAR PROFIL -->
                <div class="lg:col-span-1 space-y-6" data-aos="fade-right">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-orange-100 to-orange-50"></div>
                        <div class="relative z-10">
                            <div class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow-md overflow-hidden bg-slate-100 mb-3">
                                <img src="{{ $userProfile['avatar'] ?? 'https://ui-avatars.com/api/?name=User' }}" class="w-full h-full object-cover">
                            </div>
                            <h2 class="text-lg font-bold text-slate-900 line-clamp-1"> {{ $userProfile['nama'] ?? 'Nama User' }}</h2>
                            <p class="text-sm text-slate-500">Bergabung sejak {{ $userProfile['bergabung'] ?? '2024' }} </p>
                            <div class="mt-4 text-left">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-600">Kelengkapan Data</span>
                                    <span class="font-bold text-orange-600">{{ $userProfile['kelengkapan'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $userProfile['kelengkapan'] ?? 0 }}%;"></div>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1 italic">*Lengkapi data untuk kemudahan Umroh. </p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <nav class="flex flex-col">
                            <a href="{{ route('marketplace.profil.index') }}" class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition border-l-4 border-transparent">
                                <i class="ph-bold ph-user text-xl"></i> Profil
                            </a>
                            <a href="{{ route('marketplace.profil.pesanan') }}" class="flex items-center gap-3 px-5 py-4 bg-orange-50 text-orange-700 font-bold border-l-4 border-orange-600">
                                <i class="ph-bold ph-ticket text-xl"></i> Pesanan
                            </a>
                            <a href="{{ route('marketplace.profil.wishlist') }}" class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition border-l-4 border-transparent">
                                <i class="ph-bold ph-heart text-xl"></i> Wishlist
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- KANAN: KONTEN PESANAN -->
                <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 min-h-[600px]">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">Pesanan</h1>
                                <p class="text-slate-500 text-sm mt-1">Riwayat dan status perjalanan ibadah Anda.</p>
                            </div>
                            <div class="relative w-full md:w-64 flex-shrink-0">
                                <i class="ph-bold ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                <input type="text" id="search-booking" placeholder="Cari Kode Booking atau Nama Paket..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-1 focus:ring-orange-500 transition">
                            </div>
                        </div>

                        @php
                        $countAll = count($transactions);
                        $countUnpaid = 0;
                        $countVerif = 0;
                        $countCicilan = 0; // 👈 Tab Baru Cicilan
                        $countLunas = 0;
                        $countBatal = 0;

                        foreach ($transactions as &$t) {
                            $stat = strtoupper($t['status'] ?? 'UNPAID');
                            $ev   = $t['evidence_url'] ?? '';
                            $payType = strtoupper($t['payment_type'] ?? 'FULL');
                            $insts = $t['installments'] ?? [];
                            $isInst = $payType === 'INSTALLMENT' && count($insts) > 0;

                            if ($isInst) {
                                $lunas = 0;
                                $adaPending = false;
                                $adaDitolak = false;
                                
                                foreach($insts as $i) {
                                    $is = strtoupper($i['status'] ?? 'UNPAID');
                                    if (in_array($is, ['PAID', 'SUCCESS'])) {
                                        $lunas++;
                                    } elseif ($is === 'PENDING') {
                                        $adaPending = true;
                                    } elseif (in_array($is, ['FAILED', 'REJECTED'])) {
                                        $adaDitolak = true;
                                    }
                                }
                                
                                // Prioritas Logika Cicilan Jamaah (Cerdas & Dinamis):
                                if ($lunas === count($insts)) {
                                    $stat = 'SUCCESS';
                                } elseif ($adaPending) {
                                    $stat = 'PENDING';
                                } elseif ($adaDitolak) {
                                    $stat = 'DITOLAK_TRAVEL';
                                } elseif ($lunas > 0) {
                                    $stat = 'PARTIAL'; // 👈 Ini yang bikin dia masuk tab Cicilan Berjalan
                                } else {
                                    $stat = 'UNPAID';
                                }
                            } else {
                                if ($ev === 'REJECTED_IMAGE' || $stat === 'FAILED') {
                                    $stat = 'DITOLAK_TRAVEL';
                                }
                            }

                            $t['computed_status'] = $stat;

                            if ($stat == 'UNPAID') $countUnpaid++;
                            elseif ($stat == 'PENDING') $countVerif++;
                            elseif ($stat == 'PARTIAL') $countCicilan++; // 👈 Dihitung ke Tab
                            elseif (in_array($stat, ['SUCCESS', 'PAID', 'LUNAS', 'COMPLETED', 'DONE'])) $countLunas++;
                            elseif (in_array($stat, ['CANCELLED', 'BATAL', 'REJECTED', 'DITOLAK_TRAVEL'])) $countBatal++;
                        }
                        unset($t);
                        @endphp

                        <!-- BANNER PENGINGAT DATA JAMAAH 👇 -->
                        @if($countUnpaid > 0 || $countVerif > 0 || $countLunas > 0)
                        <div class="mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-4 sm:p-5 flex gap-3 sm:gap-4 items-start shadow-sm relative overflow-hidden" data-aos="fade-down">
                            <!-- Efek Kilap (Shine) -->
                            <div class="absolute top-0 w-[150px] h-full bg-gradient-to-r from-transparent via-white/60 to-transparent -skew-x-12 animate-shine pointer-events-none"></div>

                            <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white flex items-center justify-center shrink-0 text-blue-600 border border-blue-200 mt-0.5 shadow-sm relative z-10">
                                <i class="ph-fill ph-warning-circle text-lg sm:text-xl"></i>
                            </div>
                            <div class="relative z-10 flex-1">
                                <h4 class="text-sm sm:text-base font-extrabold text-blue-900 mb-1">Penting: Lengkapi Identitas Jamaah!</h4>
                                <div class="text-xs sm:text-sm text-blue-800 leading-loose sm:leading-loose">
                                    Untuk kelancaran manifest tiket dan Visa, mohon siapkan dokumen (KTP, KK, Paspor) lalu klik tombol:
                                    
                                    <!-- 👇 Badge Tombol Animasi Ganti-Ganti (WARNA ORANGE) 👇 -->
                                    <span class="inline-flex items-center gap-1.5 bg-green-50 px-2 rounded-md border border-green-200 shadow-sm align-middle mx-1 mt-1 sm:mt-0 h-[26px] sm:h-[28px]">
                                        <i class="ph-bold ph-identification-card text-green-600 text-sm"></i>
                                        
                                        <!-- Jendela Pembungkus (Masking) agar animasi tidak ditarik oleh Flexbox -->
                                        <span class="block h-[26px] sm:h-[28px] overflow-hidden">
                                            <!-- Trek Animasi -->
                                            <span class="block animate-swap-text text-green-700 font-bold text-[10px] sm:text-xs">
                                                <span class="h-[26px] sm:h-[28px] flex items-center whitespace-nowrap">Data Jamaah</span>
                                                <span class="h-[26px] sm:h-[28px] flex items-center whitespace-nowrap">Data Jamaah</span>
                                            </span>
                                        </span>
                                    </span>
                                    
                                    pada kartu pesanan Anda.
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- 👆 SELESAI BANNER 👆 -->

                        <!-- TABS HEADER -->
                        <div class="mb-6 overflow-x-auto no-scrollbar">
                            <div class="flex gap-2 min-w-max border-b border-slate-100 pb-1">
                                <button class="tab-btn active relative px-4 py-3 text-sm font-bold text-orange-600 transition-colors flex items-center gap-2" onclick="filterOrder('all', this)">
                                    Semua Pesanan <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countAll }}</span>
                                    <div class="tab-underline absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full"></div>
                                </button>
                                <button class="tab-btn relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-orange-600 transition-colors flex items-center gap-2" onclick="filterOrder('unpaid', this)">
                                    Menunggu Pembayaran
                                    @if ($countUnpaid > 0)
                                        <span class="bg-orange-100 text-orange-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countUnpaid }}</span>
                                    @endif
                                    <div class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full"></div>
                                </button>
                                <button id="tab-verification" class="tab-btn group relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-orange-600 transition-colors flex items-center gap-2" onclick="filterOrder('verification', this)">
                                    Verifikasi Pembayaran
                                    @if ($countVerif > 0)
                                        <span class="bg-yellow-100 text-yellow-600 text-[10px] px-2 py-0.5 rounded-full font-bold animate-pulse">{{ $countVerif }}</span>
                                    @endif
                                    <div class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></div>
                                </button>
                                @if ($countCicilan > 0)
                                <!-- 👇 TAB BARU CICILAN 👇 -->
                                <button class="tab-btn group relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors flex items-center gap-2" onclick="filterOrder('cicilan', this)">
                                    Cicilan Berjalan
                                    <span class="bg-indigo-100 text-indigo-700 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countCicilan }}</span>
                                    <div class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-indigo-600 rounded-t-full transition-all"></div>
                                </button>
                                @endif
                                <button class="tab-btn relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-orange-600 transition-colors flex items-center gap-2" onclick="filterOrder('upcoming', this)">
                                    Lunas
                                    @if ($countLunas > 0)
                                        <span class="bg-blue-100 text-blue-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countLunas }}</span>
                                    @endif
                                    <div class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full"></div>
                                </button>
                                <button class="tab-btn relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-red-600 transition-colors flex items-center gap-2" onclick="filterOrder('cancelled', this)">
                                    Dibatalkan
                                    @if ($countBatal > 0)
                                        <span class="bg-red-100 text-red-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countBatal }}</span>
                                    @endif
                                    <div class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-red-600 rounded-t-full"></div>
                                </button>
                            </div>
                        </div>

                        <!-- DAFTAR KARTU PESANAN -->
                        <div class="space-y-5 sm:space-y-6" id="order-container">
                            @foreach($transactions as $trx)
                            @php
                            // 1. MAPING STATUS API UTAMA
                            $statusBackend = $trx['computed_status'] ?? 'UNPAID'; // 👈 Langsung percaya sama hitungan atas
                            $paymentType = strtoupper($trx['payment_type'] ?? 'FULL');
                            $installments = $trx['installments'] ?? [];
                            $isInstallment = $paymentType === 'INSTALLMENT' && count($installments) > 0;
                            
                            $buktiBayar = $trx['evidence_url'] ?? null;
                            if ($buktiBayar === 'REJECTED_IMAGE' || $statusBackend === 'FAILED') {
                                $statusBackend = 'BUKTI_DITOLAK';
                                $buktiBayar = null;
                            }

                            // 👇 LOGIKA PINTAR KHUSUS CICILAN 👇
                            $totalTahap = count($installments);
                            $tahapLunas = 0;
                            $nextTagihan = 0;
                            $tahapAktif = 1;
                            $progressPersen = 0;

                            if ($isInstallment) {
                                usort($installments, function($a, $b) { return $a['installment_number'] <=> $b['installment_number']; });
                                foreach ($installments as $inst) {
                                    $st = strtoupper($inst['status'] ?? 'UNPAID');
                                    if (in_array($st, ['PAID', 'SUCCESS'])) {
                                        $tahapLunas++;
                                    } else {
                                        if ($nextTagihan == 0) {
                                            $nextTagihan = $inst['amount'] ?? 0;
                                            $tahapAktif = $inst['installment_number'];
                                        }
                                    }
                                }
                                $progressPersen = $totalTahap > 0 ? round(($tahapLunas / $totalTahap) * 100) : 0;
                                // Jangan otak-atik statusBackend lagi di sini, udah di-handle di atas!
                            }

                            // 2. PENENTUAN UI KARTU BERDASARKAN STATUS TERAKHIR
                            $uiStatus = 'unpaid';
                            $uiWarna = 'orange';
                            $uiTeks = 'Menunggu Pembayaran';

                            if ($statusBackend === 'UNPAID') {
                                $uiStatus = 'unpaid'; $uiWarna = 'orange'; $uiTeks = 'Menunggu Pembayaran';
                            } elseif ($statusBackend === 'PENDING') {
                                $uiStatus = 'verification'; $uiWarna = 'yellow'; $uiTeks = 'Verifikasi Pembayaran';
                            } elseif ($statusBackend === 'PARTIAL') { 
                                // 👇 FIX: Styling khusus untuk kartu Cicilan Berjalan 👇
                                $uiStatus = 'cicilan'; $uiWarna = 'indigo'; $uiTeks = 'Cicilan Tahap ' . $tahapAktif;
                            } elseif (in_array($statusBackend, ['SUCCESS', 'PAID', 'LUNAS', 'COMPLETED', 'DONE'])) {
                                $uiStatus = 'upcoming'; $uiWarna = 'blue'; $uiTeks = 'Lunas';
                            } elseif (in_array($statusBackend, ['CANCELLED', 'BATAL', 'REJECTED', 'DITOLAK_TRAVEL', 'BUKTI_DITOLAK'])) {
                                $uiStatus = 'cancelled'; $uiWarna = 'red'; $uiTeks = 'Bukti Ditolak';
                            }

                                // 3. DATA TRANSAKSI UTAMA
                                $invoice = $trx['transaction_no'] ?? 'TRX-XXX';
                                    $tanggalTrx = isset($trx['created_at']) ? \Carbon\Carbon::parse($trx['created_at'])->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : '-';
                                    $tanggalLunas = isset($trx['updated_at']) ? \Carbon\Carbon::parse($trx['updated_at'])->timezone('Asia/Jakarta')->translatedFormat('d M Y, H:i') . ' WIB' : $tanggalTrx;
                                    $totalHarga = $trx['total_price'] ?? 0;

                                    // ==========================================================
                                    // 🌟 3. DETAIL PRODUK (SUPER SAPU JAGAT ANTI-BUG BACKEND) 🌟
                                    // ==========================================================
                                    $detailUtama = $trx['details'][0] ?? [];
                                    $travelSnap = json_decode($detailUtama['travel_snapshot'] ?? '{}', true);
                                    $hotelsSnap = json_decode($detailUtama['hotels_snapshot'] ?? '[]', true);
                                    $flightsSnap = json_decode($detailUtama['flights_snapshot'] ?? '[]', true);

                                    // 🚨 KUNCI FIX: PRIORITAS DATA DARI RELASI 'PRODUCT' ASLI (Bypass Bug Snapshot Backend) 🚨
                                    $namaPaket = $trx['product']['nama_produk'] ?? $detailUtama['product_name'] ?? 'Paket Umroh';
                                    $biroTravelName = $trx['product']['creator']['fullname'] ?? $trx['product']['user']['fullname'] ?? $travelSnap['fullname'] ?? $travelSnap['name'] ?? 'Mitra Biro Travel';
                                    $maskapaiName = $trx['product']['flights'][0]['airline_name'] ?? (count($flightsSnap) > 0 ? ($flightsSnap[0]['airline_name'] ?? 'TBA') : 'TBA');

                                    // Pastikan gambar produk tidak salah/tertukar ke produk lain
                                    if (!empty($trx['product']['thumbnail_url'])) {
                                        $trx['gambar_paket_final'] = 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/' . ltrim($trx['product']['thumbnail_url'], '/');
                                    }

                                    // 🌟 4. PARSING DATA REKENING PINTAR (TRIK NINJA FETCH JS) 🌟
                                    $paySelect = $trx['payment_selection'] ?? $detailUtama['payment_selection'] ?? null;
                                    if (is_string($paySelect)) { $paySelect = json_decode($paySelect, true) ?? []; }
                                    $rekType = strtoupper($paySelect['type'] ?? '');
                                    $trxStr = strtolower(json_encode($trx)); 
                                    $productId = $trx['product']['id'] ?? $detailUtama['product_id'] ?? $trx['product_id'] ?? '';

                                    // 🕵️ SAPU JAGAT MENCARI ID REKENING DENGAN REGEX 🕵️
                                    $rekIdPilihan = $paySelect['travel_rekening_id'] ?? $paySelect['rekening_id'] ?? $paySelect['id'] ?? '';
                                    if ($rekIdPilihan === '') {
                                        // Scan seluruh teks JSON kalau-kalau Darda menyembunyikannya
                                        if (preg_match('/"travel_rekening_id"\s*:\s*(\d+)/i', $trxStr, $matches)) {
                                            $rekIdPilihan = $matches[1];
                                        } elseif (preg_match('/"rekening_id"\s*:\s*(\d+)/i', $trxStr, $matches)) {
                                            $rekIdPilihan = $matches[1];
                                        }
                                    }

                                    // Penentuan Jalur Mutlak
                                    if (empty($rekType) || $rekType === 'MARKETPLACE') {
                                        if (strpos($trxStr, '"allow_marketplace":false') !== false || 
                                            strpos($trxStr, '"rekening_mode":"mandiri"') !== false || 
                                            strpos($trxStr, '"type":"mandiri"') !== false) {
                                            $rekType = 'MANDIRI';
                                        } else {
                                            $rekType = 'MARKETPLACE';
                                        }
                                    }

                                    $rekBank = 'BCA / BSI';
                                    $rekNo = 'Virtual Account';
                                    $rekName = 'PT Kolaborasi Para Sahabat';

                                    if ($rekType === 'MARKETPLACE') {
                                        // 🕵️ SUPER SAPU JAGAT: Lacak paksa BSI / BCA dari teks asli JSON
                                        $trxRawStr = strtoupper(json_encode($trx));
                                        
                                        // Cek apakah ada nomor rekening BSI (7215671498) atau kata 'BSI' spesifik di payment_selection
                                        if (strpos($trxRawStr, '7215671498') !== false || strpos(strtoupper(json_encode($paySelect)), 'BSI') !== false) {
                                            $rekBank = 'BSI';
                                            $rekNo = '7215671498';
                                            $rekName = 'PT Kolaborasi Para Sahabat';
                                        } 
                                        // Cek apakah ada nomor rekening BCA (7131720452) atau kata 'BCA'
                                        elseif (strpos($trxRawStr, '7131720452') !== false || strpos(strtoupper(json_encode($paySelect)), 'BCA') !== false) {
                                            $rekBank = 'BCA';
                                            $rekNo = '7131720452';
                                            $rekName = 'PT Kolaborasi Para Sahabat';
                                        } 
                                        else {
                                            $rekBank = 'BCA / BSI';
                                            $rekNo = 'Virtual Account';
                                            $rekName = 'PT Kolaborasi Para Sahabat';
                                        }
                                    } elseif ($rekType === 'MANDIRI') {
                                        $rekType = 'MANDIRI';
                                        // 🌟 TRIK NINJA: Titip ID Produk & ID Rekening.
                                        $rekBank = 'FETCH_DYNAMIC';
                                        $rekNo = $productId; 
                                        $rekName = ($rekIdPilihan !== '') ? $rekIdPilihan : 'KOSONG';
                                    }

                                    // 🌟 FIX HOTEL: Cek dari relasi produk asli dulu biar gak nyasar ke hotel produk lain 🌟
                                    $hotelMakkahName = 'TBA'; $hotelMakkahRating = 5;
                                    $hotelMadinahName = 'TBA'; $hotelMadinahRating = 5;

                                    $sumberHotel = !empty($trx['product']['hotels']) ? $trx['product']['hotels'] : $hotelsSnap;
                                    foreach ($sumberHotel as $htl) {
                                        if (stripos(strtolower($htl['city'] ?? ''), 'mekkah') !== false || stripos(strtolower($htl['city'] ?? ''), 'makkah') !== false) {
                                            $hotelMakkahName = $htl['name'] ?? 'TBA'; $hotelMakkahRating = $htl['rating'] ?? 5;
                                        }
                                        if (stripos(strtolower($htl['city'] ?? ''), 'madinah') !== false) {
                                            $hotelMadinahName = $htl['name'] ?? 'TBA'; $hotelMadinahRating = $htl['rating'] ?? 5;
                                        }
                                    }

                                    // 5. GROUPING KAMAR & HITUNG TOTAL PAX
                                    $groupedRooms = [];
                                    $detailsArray = is_array($trx['details']) ? $trx['details'] : [];
                                    $totalPaxTrx = 0;
                                    foreach ($detailsArray as $det) {
                                        $room = $det['room_types'] ?? 'Standar';
                                        $qty = $det['quantity'] ?? 1;
                                        $price = $det['price'] ?? 0;
                                        $totalPaxTrx += $qty;
                                        if (isset($groupedRooms[$room])) {
                                            $groupedRooms[$room]['qty'] += $qty;
                                            $groupedRooms[$room]['total_price'] += $price * $qty;
                                        } else {
                                            $groupedRooms[$room] = ['qty' => $qty, 'total_price' => $price * $qty];
                                        }
                                    }
                                    if ($totalPaxTrx == 0) $totalPaxTrx = 1;

                                    // 👇 6. LOGIKA BARU: DP & CICILAN (FULL DINAMIS DARI API) 👇
                                    $tagihanAktif = $totalHarga;
                                    if ($isInstallment && $nextTagihan > 0) {
                                        $tagihanAktif = $nextTagihan;
                                    }

                                    // 6. SIAPKAN HTML MODAL
                                    $rincianHtml = '';
                                    $invoiceTableHtml = '';
                                    foreach ($groupedRooms as $room => $data) {
                                        $qty = $data['qty'];
                                        $priceStr = number_format($data['total_price'], 0, ',', '.');
                                        $rincianHtml .= '<div class="flex justify-between items-center text-slate-600 mb-2"><div class="flex items-center gap-2"><span class="bg-slate-200 text-slate-700 text-[10px] px-1.5 py-0.5 rounded font-bold uppercase">' . $qty . 'x</span><span class="font-medium">Pax ' . $room . '</span></div><span class="font-semibold text-slate-800">Rp ' . $priceStr . '</span></div>';
                                        $invoiceTableHtml .= '<tr><td class="py-3 px-3"><p class="text-xs font-bold text-slate-800 line-clamp-2">' . addslashes($namaPaket) . '</p><p class="text-[10px] text-slate-500 mt-0.5">Paket: ' . $room . '</p></td><td class="py-3 px-3 text-xs font-medium text-slate-600 text-center">' . $qty . '</td><td class="py-3 px-3 text-xs font-bold text-slate-800 text-right whitespace-nowrap">Rp ' . $priceStr . '</td></tr>';
                                    }

                                    // 👇 INJEKSI BOX CICILAN OTOMATIS KE DALAM MODAL DETAIL & INVOICE 👇
                                    if ($isInstallment && count($installments) > 0) {
                                        $rincianHtml .= '<div class="mt-4 bg-indigo-50 border border-indigo-100 rounded-xl p-3 shadow-inner">
                                            <p class="text-[10px] font-bold text-indigo-800 uppercase mb-2 border-b border-indigo-100 pb-1">Skema Pembayaran (' . count($installments) . ' Tahap)</p>
                                            <div class="space-y-1.5 text-xs">';
                                            
                                        $invoiceTableHtml .= '
                                            <tr class="bg-slate-50 border-t-2 border-slate-200">
                                                <td colspan="2" class="py-3 px-3 text-[10px] font-bold text-slate-500 text-right uppercase tracking-wider">Total Harga Paket</td>
                                                <td class="py-3 px-3 text-sm font-black text-slate-800 text-right whitespace-nowrap">Rp '.number_format($totalHarga, 0, ',', '.').'</td>
                                            </tr>';

                                        $sortedInst = $installments;
                                        usort($sortedInst, function($a, $b) {
                                            return $a['installment_number'] <=> $b['installment_number'];
                                        });

                                        foreach ($sortedInst as $inst) {
                                            $tahapNominal = number_format($inst['amount'] ?? 0, 0, ',', '.');
                                            $tahapLabel = $inst['installment_number'] == 1 ? 'Tahap 1 (DP Awal)' : 'Tahap ' . $inst['installment_number'];
                                            $stInst = strtoupper($inst['status'] ?? 'UNPAID');
                                            
                                            $lunasBadge = in_array($stInst, ['PAID', 'SUCCESS']) 
                                                ? ' <span class="ml-2 text-[8px] text-emerald-600 bg-emerald-100 px-1.5 py-0.5 rounded shadow-sm border border-emerald-200">LUNAS</span>' 
                                                : '';

                                            $rincianHtml .= '<div class="flex justify-between items-center"><span class="text-slate-600 font-medium flex items-center">'.$tahapLabel.$lunasBadge.'</span><span class="font-bold '. (in_array($stInst, ['PAID', 'SUCCESS']) ? 'text-emerald-600' : 'text-indigo-700') .'">Rp '.$tahapNominal.'</span></div>';
                                            
                                            $invoiceTableHtml .= '
                                            <tr class="border-t border-slate-100">
                                                <td colspan="2" class="py-2 px-3 text-[10px] font-bold text-slate-500 text-right uppercase tracking-wider flex justify-end items-center">'.$tahapLabel.$lunasBadge.'</td>
                                                <td class="py-2 px-3 text-sm font-black '. (in_array($stInst, ['PAID', 'SUCCESS']) ? 'text-emerald-600' : 'text-indigo-700') .' text-right whitespace-nowrap">Rp '.$tahapNominal.'</td>
                                            </tr>';
                                        }
                                        $rincianHtml .= '</div></div>';
                                    }

                                    $waMessage = "Assalamu'alaikum CS pengenumroh.com. Saya ingin bertanya mengenai pesanan saya dengan Invoice *" . $invoice . '* untuk paket *' . $namaPaket . '*.';
                                    $waLinkUrl = 'https://wa.me/62811917988?text=' . rawurlencode($waMessage);

                                @endphp

                                <div class="order-card group bg-white rounded-xl md:rounded-2xl border border-slate-200 overflow-hidden hover:border-{{ $uiWarna }}-300 hover:shadow-lg transition-all duration-300" data-status="{{ $uiStatus }}">
                                <!-- HEADER KARTU -->
                                <div class="bg-{{ $uiStatus == 'verification' ? 'yellow-50/70' : 'slate-50' }} px-4 sm:px-5 py-3 border-b border-{{ $uiStatus == 'verification' ? 'yellow-100' : 'slate-100' }} flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                                    <div class="flex items-center justify-between sm:justify-start gap-3 w-full sm:w-auto">
                                        <span class="bg-{{ $uiWarna }}-100 text-{{ $uiWarna }}-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider flex items-center gap-1">
                                            @if ($uiStatus == 'verification')
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-600 animate-pulse"></span>
                                            @elseif($uiStatus == 'upcoming')
                                                <i class="ph-fill ph-check-circle text-xs"></i>
                                            @elseif($uiStatus == 'cicilan')
                                                <i class="ph-duotone ph-arrows-clockwise text-xs"></i>
                                            @elseif($uiStatus == 'unpaid')
                                                <i class="ph-duotone ph-clock text-xs"></i>
                                            @elseif($uiStatus == 'cancelled')
                                                <i class="ph-fill ph-x-circle text-xs"></i>
                                            @endif
                                            {{ $uiTeks }}
                                        </span>
                                        <span class="text-[11px] sm:text-xs text-slate-400 font-medium">{{ $tanggalTrx }}</span>
                                    </div>
                                    <div class="flex items-center justify-between sm:justify-end gap-2 text-xs sm:text-sm text-slate-600 min-w-0 bg-white sm:bg-transparent px-3 py-2 sm:p-0 rounded-lg sm:rounded-none border sm:border-0 border-slate-200">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-medium flex-shrink-0">Kode:</span>
                                            <span class="font-bold font-mono tracking-wide select-all text-slate-900 truncate max-w-[150px] sm:max-w-[200px]">{{ $invoice }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- BODY KARTU -->
                                <div class="p-4 sm:p-5 flex flex-col md:flex-row gap-5 md:gap-6 items-stretch">
                                    <!-- GAMBAR PRODUK -->
                                    <div class="w-full md:w-44 lg:w-48 aspect-[4/5] sm:aspect-[4/3] md:aspect-auto md:h-auto min-h-[220px] sm:min-h-[200px] flex-shrink-0 rounded-xl overflow-hidden bg-slate-200 relative shadow-sm border border-slate-100">
                                        <img src="{{ $trx['gambar_paket_final'] ?? '/assets/img/marketplace/produk-dummy.png' }}" alt="{{ $namaPaket }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700 cursor-pointer" onerror="this.src='/assets/img/marketplace/produk-dummy.png'" onclick="openImageLightbox(this.src)">
                                        <div class="absolute top-2 left-2 md:hidden bg-white/90 backdrop-blur-sm text-{{ $uiWarna }}-600 text-[10px] font-bold px-2 py-1 rounded shadow-sm flex items-center gap-1">
                                            {{ $uiTeks }}
                                        </div>
                                    </div>

                                    <!-- INFO PRODUK -->
                                    <div class="flex-grow flex flex-col justify-center py-1">
                                        <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-tight mb-2.5 group-hover:text-{{ $uiWarna }}-600 transition line-clamp-2">
                                            {{ $namaPaket }}
                                        </h3>
                                        <div class="flex items-center gap-1.5 mb-4 sm:mb-5 w-fit px-2.5 py-1.5 rounded-md bg-slate-50 border border-slate-200 text-[11px] sm:text-xs font-semibold text-slate-600 shadow-sm">
                                            <i class="ph-duotone ph-calendar-blank text-orange-500 text-sm sm:text-[15px]"></i>
                                            <span>Berangkat: {{ \Carbon\Carbon::parse($detailUtama['departure_date'] ?? now())->translatedFormat('d F Y') }}</span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-x-3 gap-y-3 sm:gap-x-4 sm:gap-y-4">
                                            <!-- Maskapai -->
                                            <div class="flex items-start gap-2.5 sm:gap-3">
                                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-blue-50 flex items-center justify-center flex-shrink-0 text-blue-500 ring-1 ring-blue-100/50">
                                                    <i class="ph-duotone ph-airplane-tilt text-lg sm:text-xl"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Maskapai</p>
                                                    <p class="text-[11px] sm:text-xs font-bold text-slate-700 truncate">{{ $maskapaiName }}</p>
                                                </div>
                                            </div>
                                            <!-- Biro Travel -->
                                            <div class="flex items-start gap-2.5 sm:gap-3">
                                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0 text-emerald-500 ring-1 ring-emerald-100/50">
                                                    <i class="ph-duotone ph-briefcase text-lg sm:text-xl"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Travel</p>
                                                    <p class="text-[11px] sm:text-xs font-bold text-slate-700 truncate">{{ $biroTravelName }}</p>
                                                </div>
                                            </div>
                                            <!-- Hotel Makkah -->
                                            <div class="flex items-start gap-2.5 sm:gap-3">
                                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0 text-orange-500 ring-1 ring-orange-100/50">
                                                    <i class="ph-duotone ph-buildings text-lg sm:text-xl"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Makkah</p>
                                                    <div class="flex items-center gap-1">
                                                        <p class="text-[11px] sm:text-xs font-bold text-slate-700 truncate">{{ $hotelMakkahName }}</p>
                                                        <span class="text-[10px] font-bold text-yellow-500 flex items-center gap-0.5 shrink-0"><i class="ph-fill ph-star"></i> {{ $hotelMakkahRating ?? 5 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Hotel Madinah -->
                                            <div class="flex items-start gap-2.5 sm:gap-3">
                                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-orange-50 flex items-center justify-center flex-shrink-0 text-orange-500 ring-1 ring-orange-100/50">
                                                    <i class="ph-duotone ph-buildings text-lg sm:text-xl"></i>
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Madinah</p>
                                                    <div class="flex items-center gap-1">
                                                        <p class="text-[11px] sm:text-xs font-bold text-slate-700 truncate">{{ $hotelMadinahName }}</p>
                                                        <span class="text-[10px] font-bold text-yellow-500 flex items-center gap-0.5 shrink-0"><i class="ph-fill ph-star"></i> {{ $hotelMadinahRating ?? 5 }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- HARGA & ACTION BUTTONS -->
                                    <div class="flex flex-col justify-between md:w-[210px] lg:w-[240px] flex-shrink-0 border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-5 mt-4 md:mt-0 relative">
                                        @php
                                            // 🌟 DETEKSI TRANSAKSI CICILAN & VARIABEL CONTROLLER 🌟
                                            $paymentType = strtoupper($trx['payment_type'] ?? 'FULL');
                                            $installments = $trx['installments'] ?? [];
                                            $isInstallment = $paymentType === 'INSTALLMENT' && count($installments) > 0;
                                            $jsonInstallmentAman = base64_encode(json_encode($installments));

                                            // Logika pemunculan tombol pendukung
                                            $showInvoice = ($uiStatus == 'unpaid' || in_array($statusBackend, ['BUKTI_DITOLAK', 'DITOLAK_TRAVEL']) || $uiStatus == 'verification' || ($uiStatus == 'cancelled' && in_array($statusBackend, ['BUKTI_DITOLAK', 'DITOLAK_TRAVEL'])));
                                            $showBatal = ($uiStatus == 'unpaid' || in_array($statusBackend, ['BUKTI_DITOLAK', 'DITOLAK_TRAVEL']));
                                        @endphp

                                        <div class="mb-auto">
                                            <!-- 👇 UI KHUSUS DP & CICILAN 👇 -->
                                            @if ($isInstallment)
                                                <div class="w-full mb-3 bg-gradient-to-br from-indigo-50 to-blue-50 p-2.5 rounded-xl border border-indigo-100 relative overflow-hidden shadow-sm">
                                                    <div class="absolute top-0 right-0 w-16 h-16 bg-blue-200/50 rounded-full blur-xl -mr-4 -mt-4"></div>
                                                    <div class="flex justify-between items-center mb-1.5 relative z-10">
                                                        <span class="text-[8px] font-bold text-indigo-600 bg-white px-1.5 py-0.5 rounded shadow-sm uppercase tracking-wider">
                                                            {{ $tahapLunas == $totalTahap ? 'LUNAS' : 'CICILAN' }}
                                                        </span>
                                                        <span class="text-[9px] font-bold text-indigo-800">
                                                            Tahap {{ min(max($tahapLunas, 1), $totalTahap) }}/{{ max(1, $totalTahap) }}
                                                        </span>
                                                    </div>
                                                    <div class="w-full bg-indigo-200/50 rounded-full h-1.5 mb-2 relative z-10 overflow-hidden">
                                                        <div class="bg-indigo-500 h-1.5 rounded-full relative transition-all duration-1000" style="width: {{ $progressPersen }}%">
                                                            @if($tahapLunas < $totalTahap)
                                                                <div class="absolute top-0 left-0 w-full h-full bg-white/30 animate-pulse"></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-col items-end relative z-10">
                                                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider mb-0.5">
                                                            {{ ($tahapLunas == $totalTahap && $totalTahap > 0) ? 'Total Dibayarkan' : 'Tagihan Tahap ' . $tahapAktif }}
                                                        </p>
                                                        <p class="text-base font-black text-indigo-700 truncate max-w-full leading-none">
                                                            Rp {{ ($tahapLunas == $totalTahap && $totalTahap > 0) ? number_format($totalHarga, 0, ',', '.') : number_format($nextTagihan, 0, ',', '.') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @elseif ($uiStatus != 'verification')
                                                <!-- UI Bayar Full Normal -->
                                                <div class="flex justify-between items-center md:items-end md:flex-col w-full mb-3 bg-orange-50/50 md:bg-transparent p-2.5 md:p-0 rounded-xl border border-orange-100/50 md:border-transparent">
                                                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-wider md:mb-1">Total Tagihan</p>
                                                    <p class="text-lg font-black text-orange-600 truncate max-w-full leading-none">Rp {{ number_format($tagihanAktif, 0, ',', '.') }}</p>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="w-full flex flex-col gap-1.5 mt-auto">
                                            <!-- 🌟 JIKA TRANSAKSI CICILAN 🌟 -->
                                            @if ($isInstallment && $statusBackend !== 'CANCELLED' && $uiStatus !== 'upcoming')
                                                @if(in_array($statusBackend, ['BUKTI_DITOLAK', 'DITOLAK_TRAVEL', 'FAILED']))
                                                    {{-- <div class="w-full py-1.5 bg-red-50 border border-red-200 text-red-600 text-[10px] font-bold rounded-lg flex items-center justify-center gap-1 text-center px-1">
                                                        <i class="ph-bold ph-warning-circle text-[13px] flex-shrink-0"></i> Ditolak, cek rincian!
                                                    </div> --}}
                                                @endif
                                                <button onclick="openInstallmentModal('{{ $trx['id'] }}', '{{ $jsonInstallmentAman }}', '{{ $rekType }}', '{{ addslashes($rekBank) }}', '{{ addslashes($rekNo) }}', '{{ addslashes($rekName) }}', {{ $totalPaxTrx }})" class="w-full py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white text-[11px] font-bold rounded-lg shadow-sm transition active:scale-95 text-center flex items-center justify-center gap-1.5">
                                                    <i class="ph-bold ph-list-numbers text-[14px]"></i> Rincian & Bayar
                                                </button>
                                            
                                            <!-- 🌟 JIKA TRANSAKSI BAYAR FULL / NORMAL 🌟 -->
                                            @elseif ($uiStatus == 'unpaid')
                                                @if(in_array($statusBackend, ['BUKTI_DITOLAK', 'DITOLAK_TRAVEL']))
                                                    <div class="w-full py-1.5 bg-red-50 border border-red-200 text-red-600 text-[10px] font-bold rounded-lg flex items-center justify-center gap-1 text-center px-1">
                                                        <i class="ph-bold ph-warning-circle text-[13px] flex-shrink-0"></i> Bukti ditolak!
                                                    </div>
                                                @endif
                                                <button onclick="openPaymentModal('{{ $trx['id'] }}', '{{ $invoice }}', '{{ number_format($tagihanAktif, 0, ',', '.') }}', {{ $totalPaxTrx }}, '{{ $rekType }}', '{{ addslashes($rekBank) }}', '{{ addslashes($rekNo) }}', '{{ addslashes($rekName) }}')" class="w-full py-2 bg-orange-600 hover:bg-orange-700 text-white text-[11px] font-bold rounded-lg shadow-sm transition active:scale-95 text-center flex items-center justify-center gap-1.5">
                                                    <i class="ph-bold ph-upload-simple text-[14px]"></i> {{ in_array($statusBackend, ['BUKTI_DITOLAK', 'DITOLAK_TRAVEL']) ? 'Upload Ulang' : 'Upload Bukti' }}
                                                </button>
                                            
                                            @elseif($uiStatus == 'verification')
                                                <div class="w-full py-2 bg-yellow-50 border border-yellow-200 text-yellow-600 text-[11px] font-bold rounded-lg flex items-center justify-center gap-1.5">
                                                    <i class="ph-bold ph-hourglass-high animate-spin-slow text-[14px]"></i> Menunggu Verifikasi
                                                </div>

                                            @elseif($uiStatus == 'upcoming')
                                                <button type="button" data-tabel="{{ $invoiceTableHtml }}" data-nama="{{ $userProfile['nama'] ?? 'Jamaah' }}" data-email="{{ $userProfile['email'] ?? 'Belum ada email' }}" data-wa="{{ $userProfile['telepon'] ?? '' }}" data-rektype="{{ $rekType }}" data-rekbank="{{ addslashes($rekBank) }}" data-rekno="{{ addslashes($rekNo) }}" data-rekname="{{ addslashes($rekName) }}" onclick="showInvoiceModal(this, '{{ $invoice }}', '{{ number_format($tagihanAktif, 0, ',', '.') }}', '{{ $tanggalTrx }}', 'SUCCESS')" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold rounded-lg shadow-sm transition active:scale-95 flex items-center justify-center gap-1.5">
                                                    <i class="ph-bold ph-receipt text-[14px]"></i> Lihat Invoice
                                                </button>
                                            
                                            @elseif($uiStatus == 'cancelled')
                                                @if(!$isInstallment && in_array($statusBackend, ['BUKTI_DITOLAK', 'DITOLAK_TRAVEL']))
                                                    <button onclick="openPaymentModal('{{ $trx['id'] }}', '{{ $invoice }}', '{{ number_format($tagihanAktif, 0, ',', '.') }}', {{ $totalPaxTrx }}, '{{ $rekType }}', '{{ addslashes($rekBank) }}', '{{ addslashes($rekNo) }}', '{{ addslashes($rekName) }}')" class="w-full py-2 bg-orange-600 hover:bg-orange-700 text-white text-[11px] font-bold rounded-lg shadow-sm transition active:scale-95 text-center flex items-center justify-center gap-1.5">
                                                        <i class="ph-bold ph-upload-simple text-[14px]"></i> Upload Ulang
                                                    </button>
                                                @else
                                                    <div class="w-full py-2 bg-red-50 border border-red-200 text-red-600 text-[11px] font-bold rounded-lg flex items-center justify-center gap-1.5">
                                                        <i class="ph-bold ph-x-circle text-[14px]"></i> Pesanan Dibatalkan
                                                    </div>
                                                @endif
                                            @endif

                                            <!-- KELOLA DATA JAMAAH -->
                                            @if (!($uiStatus == 'cancelled' && !in_array($statusBackend, ['BUKTI_DITOLAK', 'DITOLAK_TRAVEL'])))
                                                <button onclick="openJamaahModal('{{ $trx['id'] }}')" class="w-full py-2 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-lg transition flex items-center justify-center gap-1.5">
                                                    <i class="ph-bold ph-identification-card text-[14px]"></i> Data Jamaah
                                                </button>
                                            @endif

                                            <!-- 🌟 SECONDARY ACTIONS (GRID 2 KOLOM RAPI) 🌟 -->
                                            <div class="grid grid-cols-2 gap-1.5 mt-0.5">
                                                <a href="{{ $waLinkUrl }}" target="_blank" class="w-full py-1.5 bg-white border border-slate-200 hover:bg-[#25D366]/10 hover:border-[#25D366]/30 text-[#128C7E] text-[10px] font-bold rounded-lg transition flex items-center justify-center gap-1">
                                                    <i class="ph-bold ph-whatsapp-logo text-[13px]"></i> CS Bantuan
                                                </a>
                                                <button onclick="showOrderDetail('{{ $invoice }}', '{{ base64_encode($namaPaket) }}', '{{ $tanggalTrx }}', '{{ base64_encode($rincianHtml) }}', '{{ number_format($totalHarga, 0, ',', '.') }}', '{{ $trx['gambar_paket_final'] ?? '' }}', '{{ base64_encode($waLinkUrl) }}', '{{ $statusBackend }}')" class="w-full py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-[10px] font-bold rounded-lg transition flex items-center justify-center gap-1">
                                                    <i class="ph-bold ph-list-magnifying-glass text-[13px]"></i> Detail
                                                </button>

                                                @if ($showInvoice)
                                                    <button type="button" data-tabel="{{ $invoiceTableHtml }}" data-nama="{{ $userProfile['nama'] ?? 'Jamaah' }}" data-email="{{ $userProfile['email'] ?? 'Belum ada email' }}" data-wa="{{ $userProfile['telepon'] ?? '' }}" data-rektype="{{ $rekType }}" data-rekbank="{{ addslashes($rekBank) }}" data-rekno="{{ addslashes($rekNo) }}" data-rekname="{{ addslashes($rekName) }}" onclick="showInvoiceModal(this, '{{ $invoice }}', '{{ number_format($tagihanAktif, 0, ',', '.') }}', '{{ $tanggalTrx }}', '{{ $statusBackend }}')" class="w-full py-1.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-[10px] font-bold rounded-lg transition flex items-center justify-center gap-1 {{ !$showBatal ? 'col-span-2' : '' }}">
                                                        <i class="ph-bold ph-receipt text-[13px]"></i> Invoice
                                                    </button>
                                                @endif

                                                @if ($showBatal)
                                                    <button onclick="cancelOrder('{{ $trx['id'] }}', '{{ $invoice }}')" class="w-full py-1.5 bg-white border border-red-100 hover:bg-red-50 text-red-500 hover:text-red-600 text-[10px] font-bold rounded-lg transition flex items-center justify-center gap-1">
                                                        <i class="ph-bold ph-x-circle text-[13px]"></i> Batal
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            @endforeach

                            <div id="empty-state" class="{{ count($transactions) > 0 ? 'hidden' : 'flex' }} flex-col items-center justify-center py-20 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                    <i id="empty-icon" class="ph-duotone ph-receipt text-5xl text-slate-300"></i>
                                </div>
                                <h3 id="empty-title" class="text-lg font-bold text-slate-900">Belum ada pesanan</h3>
                                <p id="empty-desc" class="text-slate-500 text-sm mt-1 mb-6 max-w-xs">Anda belum melakukan pemesanan paket apapun.</p>
                                <a href="/marketplace/#produk" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/30 transition">
                                    Cari Paket Umroh
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       <!-- 👇 MODAL DATA JAMAAH (Berada di luar layout utama agar Fullscreen) 👇 -->
        @foreach($transactions as $trx)
        @php
            $invoice = $trx['transaction_no'] ?? 'TRX-XXX';
            // Kunci perhitungan Pax
            $totalPax = 0;
            $detailsArrayModal = is_array($trx['details'] ?? null) ? $trx['details'] : [];
            
            $detailIdsMapped = [];
            $roomTypesMapped = [];
            
            foreach ($detailsArrayModal as $det) {
                $qty = (int)($det['quantity'] ?? 1);
                $room = $det['room_types'] ?? 'Standar';
                $totalPax += $qty;
                for ($k = 0; $k < $qty; $k++) {
                    $detailIdsMapped[] = $det['id'] ?? null;
                    $roomTypesMapped[] = $room;
                }
            }
            
            if ($totalPax == 0) {
                $totalPax = 1;
                $detailIdsMapped[] = $detailsArrayModal[0]['id'] ?? '';
            }
            
            $listJamaah = is_array($trx['jamaah'] ?? null) ? $trx['jamaah'] : [];
            $totalLengkap = count($listJamaah);
        @endphp

        <div id="modal-jamaah-{{ $trx['id'] }}" class="fixed inset-0 z-[110] bg-slate-900/60 backdrop-blur-sm hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0" onclick="if(event.target === this) checkAndCloseJamaahModal('{{ $trx['id'] }}')">
            <div class="bg-slate-50 rounded-2xl shadow-2xl w-full max-w-5xl max-h-[95vh] flex flex-col transform scale-95 transition-transform duration-300 overflow-hidden" id="modal-jamaah-content-{{ $trx['id'] }}">
                
                <!-- Header -->
                <div class="px-5 sm:px-6 py-4 border-b border-slate-200 flex justify-between items-center bg-white relative z-10 shadow-sm">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="w-10 h-10 rounded-full bg-orange-50 border border-orange-100 flex items-center justify-center text-orange-500 shrink-0">
                            <i class="ph-duotone ph-users-three text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-tight">Kelola Data Jamaah</h3>
                            <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5">Pesanan: <span class="font-bold text-slate-700">{{ $totalPax }} Pax</span> • {{ $invoice }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="hidden sm:block text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Progress</p>
                            <p class="text-sm font-black text-orange-600"><span id="progress-count-{{ $trx['id'] }}">{{ $totalLengkap }}</span> / {{ $totalPax }} Disimpan</p>
                        </div>
                        <button onclick="checkAndCloseJamaahModal('{{ $trx['id'] }}')" class="w-8 h-8 flex items-center justify-center rounded-full text-slate-400 hover:text-red-500 hover:bg-red-50 transition outline-none">
                            <i class="ph-bold ph-x text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Body / Accordion -->
                <div class="p-4 sm:p-6 overflow-y-auto custom-scrollbar flex-1 space-y-4">
                    
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 flex gap-3 text-sm text-blue-800 mb-4">
                        <i class="ph-fill ph-info text-xl text-blue-500 shrink-0"></i>
                        <p>Silakan isi <b>Informasi Personal</b> terlebih dahulu untuk mengamankan data. Dokumen pendukung (KTP/Paspor/dll) dapat diunggah menyusul.</p>
                    </div>

                    @for ($i = 1; $i <= $totalPax; $i++)
                        @php
                            $dataJamaah = $listJamaah[$i - 1] ?? null;
                            $isLengkap = $dataJamaah ? true : false;
                            $currentDetailId = $detailIdsMapped[$i - 1] ?? ($detailsArrayModal[0]['id'] ?? '');
                            
                            $cardBorder = $isLengkap ? 'border-emerald-200' : 'border-slate-200';
                            $iconBg = $isLengkap ? 'bg-emerald-100 border-emerald-200 text-emerald-600' : 'bg-slate-100 border-slate-200 text-slate-500';
                        @endphp

                        <div class="bg-white rounded-xl border {{ $cardBorder }} shadow-sm overflow-hidden transition-all duration-300" id="card-jamaah-{{ $trx['id'] }}-{{ $i }}">
                            <!-- Header Accordion -->
                            <button type="button" class="w-full px-5 py-4 flex items-center justify-between hover:bg-slate-50 transition outline-none" onclick="toggleJamaah('{{ $trx['id'] }}', {{ $i }})">
                                <div class="flex items-center gap-3 sm:gap-4">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full {{ $iconBg }} flex items-center justify-center font-black shrink-0" id="icon-status-{{ $trx['id'] }}-{{ $i }}">
                                        {!! $isLengkap ? '<i class="ph-bold ph-check text-lg"></i>' : $i !!}
                                    </div>
                                    <div class="text-left">
                                        <div class="flex items-center gap-2">
                                            <h4 class="text-sm sm:text-base font-bold text-slate-800">Jamaah {{ $i }}</h4>
                                            <span class="bg-blue-50 text-blue-600 border border-blue-100 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                                {{ $roomTypesMapped[$i - 1] ?? 'Standar' }}
                                            </span>
                                        </div>
                                        <p class="text-xs {{ $isLengkap ? 'text-slate-500' : 'text-orange-600 font-medium' }}" id="nama-jamaah-{{ $trx['id'] }}-{{ $i }}">
                                            {{ $isLengkap ? $dataJamaah['fullname'] : 'Belum ada data' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3 sm:gap-4">
                                    @if($isLengkap)
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase rounded-md border border-emerald-200" id="badge-status-{{ $trx['id'] }}-{{ $i }}">Tersimpan</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-red-50 text-red-600 text-[10px] font-bold uppercase rounded-md border border-red-100" id="badge-status-{{ $trx['id'] }}-{{ $i }}">Belum Diisi</span>
                                    @endif
                                    <i class="ph-bold ph-caret-down text-slate-400 text-lg transition-transform duration-300" id="chevron-{{ $trx['id'] }}-{{ $i }}"></i>
                                </div>
                            </button>

                            <!-- Isi Form -->
                            <div id="content-jamaah-{{ $trx['id'] }}-{{ $i }}" class="hidden border-t border-slate-200 bg-slate-50/50">
                                <form id="form-jamaah-{{ $trx['id'] }}-{{ $i }}" class="p-5 sm:p-6" onsubmit="event.preventDefault(); submitDataJamaah('{{ $trx['id'] }}', {{ $i }}, {{ $totalPax }});">
                                    
                                    <input type="hidden" name="transaction_id" value="{{ $trx['id'] }}">
                                    <input type="hidden" name="transaction_detail_id" value="{{ $currentDetailId }}">
                                    <input type="hidden" name="id_jamaah" id="id_jamaah_{{ $trx['id'] }}_{{ $i }}" value="{{ $isLengkap ? $dataJamaah['id'] : '' }}">

                                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:gap-6">
                                        
                                        <!-- KIRI: TEKS (TETAP WAJIB / REQUIRED) -->
                                        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm h-fit">
                                            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                                                <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                                    <i class="ph-fill ph-user-circle text-orange-500 text-lg"></i> Informasi Personal
                                                </h4>
                                            </div>
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                                    <input type="text" name="fullname" value="{{ $isLengkap ? $dataJamaah['fullname'] : '' }}" required placeholder="Cth: Siti Aminah" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:border-orange-500 focus:bg-white focus:ring-4 focus:ring-orange-500/10 transition">
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Email Aktif <span class="text-red-500">*</span></label>
                                                        <input type="email" name="email" value="{{ $isLengkap ? $dataJamaah['email'] : '' }}" required placeholder="email@anda.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:border-orange-500 focus:bg-white transition">
                                                    </div>
                                                    <div>
                                                        <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">No. WhatsApp <span class="text-red-500">*</span></label>
                                                        <input type="tel" name="phone" value="{{ $isLengkap ? $dataJamaah['phone'] : '' }}" required placeholder="0812345..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:border-orange-500 focus:bg-white transition">
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-red-500">*</span></label>
                                                        <select name="gender" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:border-orange-500 focus:bg-white transition">
                                                            <option value="" disabled {{ !$isLengkap ? 'selected' : '' }}>Pilih Gender</option>
                                                            <option value="L" {{ ($isLengkap && $dataJamaah['gender'] == 'L') ? 'selected' : '' }}>Laki-laki (L)</option>
                                                            <option value="P" {{ ($isLengkap && $dataJamaah['gender'] == 'P') ? 'selected' : '' }}>Perempuan (P)</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-[11px] sm:text-xs font-bold text-slate-700 mb-1.5">Status Pernikahan <span class="text-red-500">*</span></label>
                                                        <select name="status" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:border-orange-500 focus:bg-white transition">
                                                            <option value="" disabled {{ !$isLengkap ? 'selected' : '' }}>Pilih Status</option>
                                                            <option value="belum menikah" {{ ($isLengkap && $dataJamaah['status'] == 'belum menikah') ? 'selected' : '' }}>Belum Menikah</option>
                                                            <option value="menikah" {{ ($isLengkap && $dataJamaah['status'] == 'menikah') ? 'selected' : '' }}>Menikah</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- KANAN: UPLOAD FILE (SUDAH JADI OPSIONAL) -->
                                        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm h-fit">
                                            <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                                                <h4 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                                    <i class="ph-fill ph-folder-open text-orange-500 text-lg"></i> Dokumen Pendukung
                                                </h4>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                                @php
                                                    $docs = [
                                                        ['name' => 'img_ktp', 'label' => 'KTP', 'icon' => 'ph-identification-card'],
                                                        ['name' => 'img_kk', 'label' => 'KK', 'icon' => 'ph-users'],
                                                        ['name' => 'img_passpor', 'label' => 'Paspor', 'icon' => 'ph-book-bookmark'],
                                                        ['name' => 'img_diri', 'label' => 'Pas Foto', 'icon' => 'ph-camera'],
                                                    ];
                                                @endphp
                                                
                                                @foreach($docs as $doc)
                                                    @php
                                                        $fileUrl = ($isLengkap && !empty($dataJamaah[$doc['name']])) 
                                                            ? 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/transactions/jamaah/' . $dataJamaah[$doc['name']] 
                                                            : '';
                                                    @endphp
                                                    <div class="relative group">
                                                        <!-- LABEL DIUBAH MENJADI OPSIONAL / BISA NYUSUL -->
                                                        <label class="block text-[10px] font-bold text-slate-700 mb-1">{{ $doc['label'] }} <span class="text-slate-400 font-medium">(Bisa Nyusul)</span></label>
                                                        
                                                        <div class="file-upload-wrapper border-2 {{ $fileUrl ? 'border-solid border-emerald-300 shadow-sm' : 'border-dashed border-slate-200 bg-slate-50' }} rounded-xl flex flex-col items-center justify-center text-center h-24 relative overflow-hidden group cursor-pointer transition-all">
                                                            
                                                            <!-- REQUIRED DIHAPUS DARI INPUT FILE DI BAWAH INI 👇 -->
                                                            <input type="file" name="{{ $doc['name'] }}" accept="image/*,application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20 file-input">
                                                            
                                                            <div class="placeholder-content flex flex-col items-center justify-center w-full h-full relative z-10 {{ $fileUrl ? 'hidden' : 'flex' }}">
                                                                <i class="ph-duotone {{ $doc['icon'] }} text-2xl text-slate-400 mb-1 file-icon"></i>
                                                                <p class="text-[10px] text-slate-500 font-semibold file-name truncate w-full px-2">Upload File</p>
                                                            </div>
                                                            
                                                            <img src="{{ $fileUrl }}" class="preview-img {{ $fileUrl ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover z-10 transition-transform duration-500 group-hover:scale-110">
                                                            
                                                            <div class="edit-overlay absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 {{ $fileUrl ? '' : 'hidden' }}">
                                                                <span class="text-white text-[10px] font-bold flex items-center gap-1"><i class="ph-bold ph-arrows-clockwise"></i> Ganti</span>
                                                            </div>
                                                        </div>

                                                        @if($fileUrl)
                                                            <div class="absolute -top-1.5 -right-1.5 z-30">
                                                                <a href="{{ $fileUrl }}" target="_blank" class="bg-white hover:bg-blue-50 text-blue-600 text-[9px] font-bold px-2 py-0.5 rounded-md shadow border border-blue-200 flex items-center gap-1 transition cursor-pointer">
                                                                    <i class="ph-bold ph-eye"></i> Lihat
                                                                </a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Akta Kelahiran -->
                                            @php
                                                $fileAkta = ($isLengkap && !empty($dataJamaah['img_akta_kelahiran'])) 
                                                    ? 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/transactions/jamaah/' . $dataJamaah['img_akta_kelahiran'] 
                                                    : '';
                                            @endphp
                                            <div class="mt-4 relative group">
                                                <label class="block text-[10px] font-bold text-slate-700 mb-1">Akta Kelahiran <span class="text-slate-400 font-medium">(Bisa Nyusul)</span></label>
                                                <div class="file-upload-wrapper border-2 {{ $fileAkta ? 'border-solid border-emerald-300 shadow-sm' : 'border-dashed border-slate-200 bg-slate-50' }} rounded-xl flex flex-col items-center justify-center text-center h-24 relative overflow-hidden group cursor-pointer transition-all">
                                                    
                                                    <input type="file" name="img_akta_kelahiran" accept="image/*,application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20 file-input">
                                                    
                                                    <div class="placeholder-content flex flex-col items-center justify-center w-full h-full relative z-10 {{ $fileAkta ? 'hidden' : 'flex' }}">
                                                        <i class="ph-duotone ph-file-text text-2xl text-slate-400 mb-1 file-icon"></i>
                                                        <p class="text-[10px] text-slate-500 font-semibold file-name truncate w-full px-2">Upload File</p>
                                                    </div>
                                                    
                                                    <img src="{{ $fileAkta }}" class="preview-img {{ $fileAkta ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover z-10 transition-transform duration-500 group-hover:scale-110">
                                                    
                                                    <div class="edit-overlay absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 {{ $fileAkta ? '' : 'hidden' }}">
                                                        <span class="text-white text-[10px] font-bold flex items-center gap-1"><i class="ph-bold ph-arrows-clockwise"></i> Ganti</span>
                                                    </div>
                                                </div>
                                                @if($fileAkta)
                                                    <div class="absolute -top-1.5 -right-1.5 z-30">
                                                        <a href="{{ $fileAkta }}" target="_blank" class="bg-white hover:bg-blue-50 text-blue-600 text-[9px] font-bold px-2 py-0.5 rounded-md shadow border border-blue-200 flex items-center gap-1 transition cursor-pointer">
                                                            <i class="ph-bold ph-eye"></i> Lihat
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end pt-4 border-t border-slate-200">
                                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-orange-600 hover:bg-orange-700 text-white text-[13px] font-bold shadow-md shadow-orange-500/25 transition flex items-center gap-2">
                                            <i class="ph-bold ph-floppy-disk text-base"></i> {{ $isLengkap ? 'Update' : 'Simpan' }} Data Jamaah {{ $i }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="px-4 sm:px-6 py-4 border-t border-slate-200 bg-white flex justify-end gap-3 rounded-b-2xl relative z-10">
                    <button onclick="checkAndCloseJamaahModal('{{ $trx['id'] }}')" class="px-6 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-[13px] font-bold shadow-md shadow-slate-500/25 transition flex items-center gap-2 outline-none">
                        Selesai & Tutup
                    </button>
                </div>
            </div>
        </div>
        @endforeach
        <!-- 👆 SELESAI MODAL DATA JAMAAH 👆 -->

        <!-- 👇 MODAL LIGHTBOX POSTER PRODUK 👇 -->
        <div id="image-lightbox" class="fixed inset-0 z-[100] bg-black/95 hidden flex items-center justify-center p-4 transition-opacity duration-300 opacity-0" onclick="closeImageLightbox()">
            <button class="absolute top-4 right-4 md:top-6 md:right-6 text-white/70 hover:text-orange-500 transition outline-none">
                <i class="ph-bold ph-x text-3xl md:text-4xl"></i>
            </button>
            <img id="lightbox-img-element" src="" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
        </div>
        <!-- 👆 SELESAI MODAL LIGHTBOX 👆 -->
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // --- FITUR PENCARIAN & FILTER JAMAAH (CLEAN VERSION) ---
        let currentActiveStatus = 'all';
        const searchInput = document.getElementById('search-booking');

        // Panggil fungsi utama saat ngetik di kolom pencarian
        function searchOrders(keyword) {
            runCombinedFilter();
        }
        if (searchInput) {
            searchInput.addEventListener('input', runCombinedFilter);
        }

        // Logika Tab diklik
        function filterOrder(status, btn) {
            currentActiveStatus = status;

            // Reset warna semua tab (tambah text-indigo-600 biar bekas kliknya keriset)
            document.querySelectorAll('.tab-btn').forEach(b => {
                b.classList.remove('active', 'text-orange-600', 'font-bold', 'text-red-600', 'text-indigo-600');
                b.classList.add('text-slate-500', 'font-medium');
                const underline = b.querySelector('.tab-underline');
                if (underline) underline.classList.add('hidden');
            });

            // Nyalakan warna tab yang aktif
            if (btn) {
                // 👇 Penyesuaian warna indikator Tab dinamis 👇
                let activeColor = 'text-orange-600';
                if (status === 'cancelled') activeColor = 'text-red-600';
                if (status === 'cicilan') activeColor = 'text-indigo-600'; 

                btn.classList.add('active', activeColor, 'font-bold');
                btn.classList.remove('text-slate-500', 'font-medium');
                const activeUnderline = btn.querySelector('.tab-underline');
                if (activeUnderline) activeUnderline.classList.remove('hidden');
            }

            runCombinedFilter();
        }

        // Eksekutor Filter (Gabungan Tab & Ketikan)
        function runCombinedFilter() {
            const keyword = searchInput ? searchInput.value.toLowerCase().trim() : '';
            const cards = document.querySelectorAll('.order-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status') || '';
                const monoEl = card.querySelector('.font-mono');
                const h3El = card.querySelector('h3');
                
                const invoiceCode = monoEl ? monoEl.innerText.toLowerCase() : '';
                const packageTitle = h3El ? h3El.innerText.toLowerCase() : '';
                
                const matchStatus = (currentActiveStatus === 'all' || cardStatus === currentActiveStatus);
                const matchKeyword = (invoiceCode.includes(keyword) || packageTitle.includes(keyword));
                
                if (matchStatus && matchKeyword) {
                    card.style.display = 'block';
                    // Efek animasi transisi halus
                    card.classList.remove('aos-animate');
                    setTimeout(() => card.classList.add('aos-animate'), 50);
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            checkEmptyState(visibleCount, currentActiveStatus, keyword);
        }

        function checkEmptyState(count, status, keyword = '') {
            const emptyState = document.getElementById('empty-state');
            const icon = document.getElementById('empty-icon');
            const title = document.getElementById('empty-title');
            const desc = document.getElementById('empty-desc');

            if (count === 0) {
                emptyState.classList.remove('hidden');
                emptyState.classList.add('flex');

                if (keyword.trim() !== '') {
                    icon.className = "ph-duotone ph-magnifying-glass text-5xl text-slate-300";
                    title.innerText = "Pencarian Tidak Ditemukan";
                    desc.innerText = `Tidak ada pesanan yang cocok dengan kata kunci "${keyword}".`;
                } else if (status === 'unpaid') {
                    icon.className = "ph-duotone ph-check-circle text-5xl text-emerald-300";
                    title.innerText = "Tidak Ada Tagihan";
                    desc.innerText = "Semua pesanan Anda sudah dibayar atau masuk tahap verifikasi.";
                } else if (status === 'verification') {
                    icon.className = "ph-duotone ph-hourglass-medium text-5xl text-yellow-300";
                    title.innerText = "Belum Ada Verifikasi";
                    desc.innerText = "Tidak ada pesanan yang sedang menunggu konfirmasi admin saat ini.";
                } else if (status === 'cicilan') {
                    // 👇 Pesan Kosong Khusus Tab Cicilan 👇
                    icon.className = "ph-duotone ph-arrows-clockwise text-5xl text-indigo-300";
                    title.innerText = "Belum Ada Cicilan Berjalan";
                    desc.innerText = "Anda belum memiliki pesanan dengan skema cicilan yang sedang berlangsung.";
                } else if (status === 'upcoming') {
                    icon.className = "ph-duotone ph-ticket text-5xl text-blue-300";
                    title.innerText = "Belum Ada Pesanan Lunas";
                    desc.innerText = "Segera selesaikan tagihan Anda agar pesanan masuk ke daftar Lunas.";
                } else if (status === 'cancelled') {
                    icon.className = "ph-duotone ph-check-circle text-5xl text-emerald-300";
                    title.innerText = "Tidak Ada Pesanan Batal";
                    desc.innerText = "Syukurlah, tidak ada riwayat pesanan Anda yang dibatalkan.";
                } else {
                    icon.className = "ph-duotone ph-receipt text-5xl text-slate-300";
                    title.innerText = "Belum ada pesanan";
                    desc.innerText = "Anda belum melakukan pemesanan paket apapun.";
                }
            } else {
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');
            }
        }

        // 6. Copy To Clipboard
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: "Kode Booking disalin!"
                });
            });
        }
    </script>

    <script>
    // =====================================================================
    // 🌟 1. FUNGSI UPLOAD BUKTI (REKENING DINAMIS + ANTI BUG) 🌟
    // =====================================================================
    async function openPaymentModal(trxId, invoiceId, totalAmount, totalPax, rekType, rekBank, rekNo, rekName) {
        const progressEl = document.getElementById(`progress-count-${trxId}`);
        const currentLengkap = progressEl ? parseInt(progressEl.innerText) : 0;

        if (currentLengkap < totalPax) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Belum Lengkap!',
                html: `Anda baru melengkapi <b>${currentLengkap}</b> dari <b>${totalPax}</b> data jamaah.<br><br>Harap lengkapi seluruh identitas dan dokumen jamaah terlebih dahulu.`,
                confirmButtonText: 'Lengkapi Sekarang',
                confirmButtonColor: '#10b981',
                showCancelButton: true,
                cancelButtonText: 'Tutup'
            }).then((res) => {
                if (res.isConfirmed) {
                    openJamaahModal(trxId);
                }
            });
            return;
        }

        if (rekType === 'MANDIRI' && rekBank === 'FETCH_DYNAMIC') {
            let productId = rekNo;
            let rekIdPilihan = String(rekName).trim();
            if (rekIdPilihan === 'KOSONG' || rekIdPilihan === '') {
                let cachedId = localStorage.getItem(`saved_rek_${productId}`);
                if (cachedId) rekIdPilihan = cachedId;
            }

            Swal.fire({ title: 'Memuat Data Rekening...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            try {
                let res = await fetch(`/marketplace/produk/${productId}/payment-options`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                let data = await res.json();
                let bankData = data.data || data;
                let bankList = [];

                function findBanks(obj) {
                    if (!obj) return;
                    if(Array.isArray(obj)) {
                        obj.forEach(v => findBanks(v));
                    } else if(typeof obj === 'object') {
                        if((obj.nama_bank || obj.bank_name) && (obj.no_rekening || obj.bank_account)) {
                            bankList.push(obj);
                        } else {
                            for(let k in obj) findBanks(obj[k]);
                        }
                    }
                }
                findBanks(bankData);

                let foundBank = null;
                if (rekIdPilihan !== 'KOSONG' && rekIdPilihan !== '') {
                    foundBank = bankList.find(b => (String(b.id) === rekIdPilihan || String(b.travel_rekening_id) === rekIdPilihan || String(b.rekening_id) === rekIdPilihan));
                }
                foundBank = foundBank || bankList[0];
                
                rekBank = foundBank ? (foundBank.nama_bank || foundBank.bank_name) : 'Bank Travel';
                rekNo = foundBank ? (foundBank.no_rekening || foundBank.bank_account || foundBank.nomor_rekening) : 'Sesuai Instruksi Travel';
                rekName = foundBank ? (foundBank.atas_nama || foundBank.bank_owner || foundBank.pemilik_rekening) : 'Mitra Travel';
                Swal.close();
            } catch(e) {
                Swal.close();
                rekBank = 'Rekening Travel';
                rekNo = 'Hubungi Travel';
                rekName = 'Mitra Travel';
            }
        }

        let bankHtmlCard = '';
        if (rekType === 'MARKETPLACE') {
            if (rekBank.includes('/')) {
                // FALLBACK PESANAN LAMA (BCA & BSI)
                bankHtmlCard = `
                <div class="bg-gradient-to-br from-white via-slate-50 to-blue-50/50 border border-blue-200 rounded-xl p-4 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-100/50 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="flex items-center gap-2 mb-3.5 relative z-10">
                        <i class="ph-fill ph-shield-check text-blue-600 text-lg"></i>
                        <p class="text-[11px] font-black text-slate-900 uppercase tracking-tight">Rekening Resmi PengenUmroh</p>
                        <span class="ml-auto bg-blue-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Pusat</span>
                    </div>
                    <div class="space-y-2 mb-3 relative z-10">
                        <div class="flex items-center justify-between bg-white px-3 py-2.5 rounded-lg border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="bg-[#0066AE] text-white text-[10px] font-bold py-1 w-10 text-center rounded">BCA</div>
                                <span class="text-sm font-bold text-slate-800 font-mono tracking-wider">7131720452</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between bg-white px-3 py-2.5 rounded-lg border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="bg-[#00A39D] text-white text-[10px] font-bold py-1 w-10 text-center rounded">BSI</div>
                                <span class="text-sm font-bold text-slate-800 font-mono tracking-wider">7215671498</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between px-1 relative z-10">
                        <span class="text-[10px] text-slate-500 font-medium">a.n PT Kolaborasi Para Sahabat</span>
                    </div>
                </div>
                `;
            } else {
                // UI BARU 1 BANK AJA (Sesuai Pilihan)
                let bankColor = rekBank.includes('BSI') ? 'bg-teal-600' : 'bg-[#0066AE]';
                bankHtmlCard = `
                <div class="bg-gradient-to-br from-white via-slate-50 to-blue-50/50 border border-blue-200 rounded-xl p-4 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-blue-100/50 rounded-full blur-2xl -mr-10 -mt-10"></div>
                    <div class="flex items-center gap-2 mb-3.5 relative z-10">
                        <i class="ph-fill ph-shield-check text-blue-600 text-lg"></i>
                        <p class="text-[11px] font-black text-slate-900 uppercase tracking-tight">Rekening Resmi PengenUmroh</p>
                        <span class="ml-auto bg-blue-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Pusat</span>
                    </div>
                    <div class="space-y-2 mb-3 relative z-10">
                        <div class="flex items-center justify-between bg-white px-3 py-2.5 rounded-lg border border-slate-100 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="${bankColor} text-white text-[10px] font-bold py-1 w-10 text-center rounded">${rekBank}</div>
                                <span class="text-sm font-bold text-slate-800 font-mono tracking-wider">${rekNo}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between px-1 relative z-10">
                        <span class="text-[10px] text-slate-500 font-medium">a.n PT Kolaborasi Para Sahabat</span>
                    </div>
                </div>
                `;
            }
        } else {
            // BALIKIN BANK TRAVEL YANG TADI ILANG
            bankHtmlCard = `
            <div class="bg-gradient-to-br from-white via-slate-50 to-orange-50/50 border border-orange-200 rounded-xl p-4 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-orange-100/50 rounded-full blur-2xl -mr-10 -mt-10"></div>
                <div class="flex items-center gap-2 mb-3.5 relative z-10">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    <p class="text-[11px] font-black text-slate-900 uppercase tracking-tight">Rekening Mitra Travel</p>
                    <span class="ml-auto bg-gradient-to-r from-orange-500 to-orange-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Travel</span>
                </div>
                <div class="flex items-center justify-between bg-white px-3 py-3 rounded-xl border border-slate-100 shadow-sm mb-3 relative z-10">
                    <div class="flex items-center gap-3">
                        <div class="px-2.5 h-6 bg-orange-100 text-orange-700 text-[10px] font-black rounded flex items-center justify-center tracking-wider uppercase">${rekBank}</div>
                        <span class="text-sm font-extrabold text-slate-800 font-mono tracking-wider">${rekNo}</span>
                    </div>
                </div>
                <div class="flex items-center justify-between px-1 relative z-10">
                    <span class="text-[10px] text-slate-500 font-medium truncate flex-1">a.n ${rekName}</span>
                </div>
            </div>
            `;
        }

        Swal.fire({
            title: '<span class="text-lg font-bold text-slate-900">Upload Bukti Transfer</span>',
            html: `
                <div class="text-left space-y-4 mt-2">
                    <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-5 text-center relative overflow-hidden shadow-lg">
                        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mb-1 relative z-10">Jumlah Tagihan Saat Ini</p>
                        <p class="text-3xl font-black text-white relative z-10 tracking-tight">Rp ${totalAmount}</p>
                    </div>
                    ${bankHtmlCard}
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Upload Bukti Transfer <span class="text-red-500">*</span></label>
                        <input type="file" id="proof-file" accept="image/*" class="hidden">
                        <div id="upload-placeholder" class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 hover:border-orange-400 transition cursor-pointer" onclick="document.getElementById('proof-file').click()">
                            <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-3"><i class="ph-bold ph-upload-simple text-2xl"></i></div>
                            <p class="text-xs font-bold text-slate-600">Klik untuk upload foto bukti struk</p>
                        </div>
                        <div id="upload-preview" class="hidden relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50">
                            <img id="preview-img" src="" class="w-full h-48 object-contain bg-black/5">
                        </div>
                    </div>
                </div>
            `,
            didOpen: () => {
                document.getElementById('proof-file').addEventListener('change', function(e) {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('preview-img').src = e.target.result;
                            document.getElementById('upload-placeholder').classList.add('hidden');
                            document.getElementById('upload-preview').classList.remove('hidden');
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            },
            showCancelButton: true,
            confirmButtonText: 'Kirim Bukti',
            preConfirm: () => {
                const fileInput = document.getElementById('proof-file');
                if (!fileInput.files.length) {
                    Swal.showValidationMessage('Mohon pilih file foto');
                    return false;
                }
                return fileInput.files[0];
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('bukti_bayar', result.value);
                formData.append('id_transaksi', trxId);
                formData.append('_token', '{{ csrf_token() }}');
                sendUploadAjax(formData);
            }
        });
    }
    function sendUploadAjax(formData) {
        Swal.fire({ title: 'Mengirim Bukti...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        fetch('{{ route('marketplace.profil.upload_bukti') }}', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.status === 'success') {
                    Swal.fire({
                        icon: 'success', title: 'Upload Berhasil!', text: 'Terima kasih, bukti pembayaran Anda sudah kami terima.',
                        confirmButtonText: '<i class="ph-bold ph-check-circle text-lg"></i> Baik, Mengerti',
                        confirmButtonColor: '#ea580c', customClass: { confirmButton: 'flex items-center gap-2' }
                    }).then(() => window.location.reload());
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal Mengirim', text: data.message || 'Terjadi kesalahan.', confirmButtonColor: '#dc2626' });
                }
            })
            .catch(error => {
                Swal.fire({ icon: 'error', title: 'Sistem Error', text: 'Terjadi masalah koneksi.', confirmButtonColor: '#dc2626' });
            });
    }
    // =====================================================================
    // 🌟 2. FUNGSI INVOICE DOKUMEN CETAK PDF 🌟
    // =====================================================================
    function cetakInvoiceDokumen(invoiceNo, userName, userEmail, userWa, totalAmount, dateStr, statusTrx, tableHtml, rekType, rekBank, rekNo, rekName) {
        const printWindow = window.open('', '_blank', 'width=900,height=900');
        const now = new Date();
        const options = { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit' };
        const waktuCetak = now.toLocaleDateString('id-ID', options).replace('pukul', ',') + ' WIB';
        const baseUrl = window.location.origin;

        let statusText = 'MENUNGGU PEMBAYARAN';
        let statusColor = '#ea580c';
        let stempelPdfHtml = '';
        
        // 👇 FIX LOGIKA STATUS PDF 👇
        if (statusTrx === 'PENDING') {
            statusText = 'PROSES VERIFIKASI'; statusColor = '#eab308';
        } else if (['SUCCESS', 'PAID', 'LUNAS', 'COMPLETED', 'DONE'].includes(statusTrx)) {
            statusText = 'LUNAS / PAID'; statusColor = '#10b981';
            stempelPdfHtml = `<img src="${baseUrl}/assets/img/marketplace/stempel-lunas.png" class="stempel-lunas-pdf" alt="Stempel Lunas">`;
        } else if (['BUKTI_DITOLAK', 'REJECTED', 'DITOLAK_TRAVEL', 'FAILED'].includes(statusTrx)) {
            statusText = 'BUKTI DITOLAK'; statusColor = '#dc2626';
        } else if (['CANCELLED', 'BATAL'].includes(statusTrx)) {
            statusText = 'DIBATALKAN'; statusColor = '#dc2626';
        }

        let rekeningPdfHtml = '';
        if (rekType === 'MARKETPLACE') {
            if (rekBank.includes('/')) {
                rekeningPdfHtml = `
                    <h3>PEMBAYARAN (PUSAT)</h3>
                    <p style="margin-bottom: 2px;"><strong>BCA:</strong> 7131720452</p>
                    <p style="margin-bottom: 2px;"><strong>BSI:</strong> 7215671498</p>
                    <p style="margin-top: 4px; font-size: 11px;">a.n PT Kolaborasi Para Sahabat</p>
                `;
            } else {
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

        const htmlContent = `
        <!DOCTYPE html>
        <html lang="id">
        <head>
            <meta charset="UTF-8">
            <title>Invoice_${invoiceNo.replace('TRX-', '')}</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
                @page { size: A4; margin: 15mm; }
                :root { --primary: #ea580c; --text-main: #0f172a; --text-muted: #64748b; --border-color: #e2e8f0; --bg-muted: #f8fafc; }
                body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text-main); max-width: 850px; margin: 0 auto; }
                .invoice-container { padding: 20px 40px; }
                .header-top { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid var(--primary); padding-bottom: 25px; margin-bottom: 35px; }
                .brand img { height: 45px; width: auto; margin-bottom: 6px; }
                .brand p { margin: 0; color: var(--text-muted); font-size: 13px; font-weight: 500; }
                .invoice-title { text-align: right; }
                .invoice-title h2 { margin: 0; color: var(--primary); font-size: 32px; font-weight: 800; letter-spacing: 1px; }
                .invoice-title .inv-number { font-family: monospace; font-size: 14px; color: var(--text-muted); font-weight: 600; margin-top: 4px; }
                .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px; }
                .info-box { background: var(--bg-muted); padding: 20px; border-radius: 12px; border: 1px solid var(--border-color); }
                .info-box h3 { font-size: 11px; color: var(--text-muted); text-transform: uppercase; margin: 0 0 12px 0; font-weight: 700; }
                .info-box strong { font-size: 16px; display: block; margin-bottom: 8px; }
                .info-box p { margin: 4px 0; font-size: 13px; color: var(--text-muted); }
                table { width: 100%; border-collapse: separate; border-spacing: 0; margin-bottom: 30px; border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; }
                th { background-color: var(--bg-muted); font-size: 12px; text-transform: uppercase; text-align: left; padding: 16px; font-weight: 700; border-bottom: 1px solid var(--border-color); }
                td { padding: 20px 16px; font-size: 14px; border-bottom: 1px solid var(--border-color); vertical-align: top; }
                td p:first-child { font-weight: 700; font-size: 15px; margin-bottom: 4px; }
                td p:last-child { font-size: 12px; color: var(--text-muted); font-weight: 500; }
                th.text-center, td.text-center { text-align: center; }
                th.text-right, td.text-right { text-align: right; font-weight: 800; font-size: 15px; }
                .summary-wrapper { display: flex; justify-content: flex-end; margin-bottom: 40px; position: relative; }
                .summary-box { width: 350px; z-index: 10; background: white; }
                .summary-row { display: flex; justify-content: space-between; padding: 12px 16px; font-size: 14px; color: var(--text-muted); border-bottom: 1px solid var(--bg-muted); }
                .summary-row.total { background-color: var(--primary); color: white; font-size: 18px; font-weight: 800; border-radius: 8px; padding: 16px; margin-top: 12px; border: none; }
                .status-stamp { display: inline-block; color: ${statusColor}; border: 2px solid ${statusColor}; padding: 6px 16px; font-size: 14px; font-weight: 800; border-radius: 6px; margin-top: 10px; text-transform: uppercase; }
                .stempel-lunas-pdf { position: absolute; right: 100px; top: -10px; width: 190px; opacity: 0.7; mix-blend-mode: multiply; transform: rotate(-12deg); pointer-events: none; z-index: 50; }
            </style>
        </head>
        <body>
            <div class="invoice-container">
                <div class="header-top">
                    <div class="brand">
                        <img src="${baseUrl}/assets/img/marketplace/logo.png" alt="Logo">
                        <p>Marketplace Perjalanan Umroh Terpercaya</p>
                    </div>
                    <div class="invoice-title">
                        <h2>INVOICE</h2>
                        <div class="inv-number">#INV-${invoiceNo.replace('TRX-', '')}</div>
                    </div>
                </div>
                <div class="info-grid">
                    <div class="info-box">
                        <h3>DITAGIHKAN KEPADA:</h3>
                        <strong>${userName}</strong>
                        <p>WA / Telp: ${userWa && userWa !== 'null' ? userWa : '-'}</p>
                        <p>Email: ${userEmail && userEmail !== 'null' ? userEmail : '-'}</p>
                    </div>
                    <div class="info-box">
                        ${rekeningPdfHtml}
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Detail Paket & Rincian Kamar</th>
                            <th class="text-center" style="width: 15%;">Qty</th>
                            <th class="text-right" style="width: 25%;">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableHtml}
                    </tbody>
                </table>
                <div class="summary-wrapper">
                    ${stempelPdfHtml}
                    <div class="summary-box">
                        <div class="summary-row total">
                            <span>TOTAL TAGIHAN</span>
                            <span>Rp ${totalAmount}</span>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>
        `;

        printWindow.document.write(htmlContent.replace(/\\@/g, '@'));
        printWindow.document.write('<scr' + 'ipt>window.onload = function() { setTimeout(() => { window.print(); }, 800); }</scr' + 'ipt>');
        printWindow.document.close();
    }
    // =====================================================================
    // 🌟 3. MODAL PREVIEW INVOICE WEBSITE (DINAMIS REKENING VIA FETCH) 🌟
    // =====================================================================
    async function showInvoiceModal(btnElement, invoiceNo, totalAmount, dateStr, statusTrx) {
        const tableHtml = btnElement.getAttribute('data-tabel');
        const userName = btnElement.getAttribute('data-nama');
        const userEmail = btnElement.getAttribute('data-email');
        const userWa = btnElement.getAttribute('data-wa');
        const rekType = btnElement.getAttribute('data-rektype');
        let rekBank = btnElement.getAttribute('data-rekbank');
        let rekNo = btnElement.getAttribute('data-rekno');
        let rekName = btnElement.getAttribute('data-rekname');

        if (rekType === 'MANDIRI' && rekBank === 'FETCH_DYNAMIC') {
            let productId = rekNo;
            let rekIdPilihan = String(rekName).trim();
            if (rekIdPilihan === 'KOSONG' || rekIdPilihan === '') {
                let cachedId = localStorage.getItem(`saved_rek_${productId}`);
                if (cachedId) rekIdPilihan = cachedId;
            }

            Swal.fire({ title: 'Menyiapkan Invoice...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            try {
                let res = await fetch(`/marketplace/produk/${productId}/payment-options`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                let data = await res.json();
                let bankData = data.data || data;
                let bankList = [];
                function findBanks(obj) {
                    if (!obj) return;
                    if(Array.isArray(obj)) {
                        obj.forEach(v => findBanks(v));
                    } else if(typeof obj === 'object') {
                        if((obj.nama_bank || obj.bank_name) && (obj.no_rekening || obj.bank_account)) {
                            bankList.push(obj);
                        } else {
                            for(let k in obj) findBanks(obj[k]);
                        }
                    }
                }
                findBanks(bankData);
                let foundBank = null;
                if (rekIdPilihan !== 'KOSONG' && rekIdPilihan !== '') {
                    foundBank = bankList.find(b => (String(b.id) === rekIdPilihan || String(b.travel_rekening_id) === rekIdPilihan || String(b.rekening_id) === rekIdPilihan));
                }
                foundBank = foundBank || bankList[0];
                rekBank = foundBank ? (foundBank.nama_bank || foundBank.bank_name) : 'Bank Travel';
                rekNo = foundBank ? (foundBank.no_rekening || foundBank.bank_account || foundBank.nomor_rekening) : 'Sesuai Instruksi Travel';
                rekName = foundBank ? (foundBank.atas_nama || foundBank.bank_owner || foundBank.pemilik_rekening) : 'Mitra Travel';
                Swal.close();
            } catch(e) {
                Swal.close();
                rekBank = 'Rekening Travel';
                rekNo = 'Hubungi Travel';
                rekName = 'Mitra Travel';
            }
        }

        window.executePrintPdf = () => {
            cetakInvoiceDokumen(invoiceNo, userName, userEmail, userWa, totalAmount, dateStr, statusTrx, tableHtml, rekType, rekBank, rekNo, rekName);
        };

        // 👇 FIX LOGIKA BADGE INVOICE MODAL 👇
        let badgeClass = 'bg-slate-100 text-slate-700';
        let badgeText = 'TIDAK DIKETAHUI';
        
        if (statusTrx === 'UNPAID') {
            badgeClass = 'bg-orange-100 text-orange-700'; badgeText = 'MENUNGGU PEMBAYARAN';
        } else if (statusTrx === 'PENDING') {
            badgeClass = 'bg-yellow-100 text-yellow-700'; badgeText = 'PROSES VERIFIKASI';
        } else if (['SUCCESS', 'PAID', 'LUNAS', 'COMPLETED', 'DONE'].includes(statusTrx)) {
            badgeClass = 'bg-blue-100 text-blue-700'; badgeText = 'LUNAS / BERHASIL';
        } else if (['BUKTI_DITOLAK', 'REJECTED', 'DITOLAK_TRAVEL', 'FAILED'].includes(statusTrx)) {
            badgeClass = 'bg-red-100 text-red-700'; badgeText = 'BUKTI DITOLAK';
        } else if (['CANCELLED', 'BATAL'].includes(statusTrx)) {
            badgeClass = 'bg-red-100 text-red-700'; badgeText = 'DIBATALKAN';
        }

        let htmlRekening = '';
        if (rekType === 'MARKETPLACE') {
            if (rekBank.includes('/')) {
                htmlRekening = `
                    <p class="text-[10px] font-bold text-blue-500 uppercase tracking-wider mb-1">Metode Pembayaran (Pusat):</p>
                    <p class="text-[11px] font-bold text-slate-800 mb-0.5">BCA: <span class="font-mono text-sm tracking-wide">7131720452</span></p>
                    <p class="text-[11px] font-bold text-slate-800">BSI: <span class="font-mono text-sm tracking-wide">7215671498</span></p>
                    <p class="text-[9px] font-semibold text-slate-500 mt-1 uppercase">a.n PT Kolaborasi Para Sahabat</p>
                `;
            } else {
                htmlRekening = `
                    <p class="text-[10px] font-bold text-blue-500 uppercase tracking-wider mb-1">Metode Pembayaran (Pusat):</p>
                    <p class="text-xs font-bold text-slate-800 uppercase">${rekBank}</p>
                    <p class="text-sm text-slate-800 font-mono font-black tracking-wider my-0.5">${rekNo}</p>
                    <p class="text-[9px] font-semibold text-slate-500 uppercase">a.n PT Kolaborasi Para Sahabat</p>
                `;
            }
        } else {
            htmlRekening = `
                <p class="text-[10px] font-bold text-orange-500 uppercase tracking-wider mb-1">Metode Pembayaran (Travel):</p>
                <p class="text-xs font-bold text-slate-800 uppercase">${rekBank}</p>
                <p class="text-sm text-slate-800 font-mono font-black tracking-wider my-0.5">${rekNo}</p>
                <p class="text-[9px] font-semibold text-slate-500 uppercase">a.n ${rekName}</p>
            `;
        }

        Swal.fire({
            title: '',
            html: `
            <div class="text-left font-sans relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6 border-b border-slate-200 pb-4">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900 tracking-tight">INVOICE</h2>
                            <p class="text-sm font-bold text-slate-800 mt-1 uppercase">#INV-${invoiceNo.replace('TRX-', '')}</p>
                            <p class="text-[10px] text-slate-500 mt-0.5">Tanggal: ${dateStr}</p>
                        </div>
                        <div class="text-right flex flex-col items-end">
                            <img src="/assets/img/marketplace/logo.png" alt="Logo" class="h-8 w-auto mb-2 opacity-90">
                            <span class="${badgeClass} text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider">${badgeText}</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Ditagihkan Kepada:</p>
                            <p class="text-sm font-bold text-slate-800">${userName}</p>
                            <p class="text-xs text-slate-500 mb-0.5">${userWa && userWa !== 'null' && userWa !== '' ? userWa : 'Tidak dicantumkan'}</p>
                            <p class="text-xs text-slate-500">${userEmail && userEmail !== 'null' && userEmail !== '' ? userEmail : 'Tidak dicantumkan'}</p>
                        </div>
                        <div class="text-right">
                            ${htmlRekening}
                        </div>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-slate-200 mb-6 bg-white">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="py-2.5 px-3 text-[10px] font-bold text-slate-500 uppercase">Nama Produk</th>
                                    <th class="py-2.5 px-3 text-[10px] font-bold text-slate-500 uppercase text-center w-16">Qty</th>
                                    <th class="py-2.5 px-3 text-[10px] font-bold text-slate-500 uppercase text-right w-32">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 px-3">
                                ${tableHtml}
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-center items-center mb-8 mt-4">
                        <div class="w-full bg-slate-50 rounded-2xl p-5 border border-slate-200 flex flex-col items-center justify-center text-center relative overflow-hidden shadow-sm">
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-orange-600"></div>
                            <p class="text-[11px] sm:text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Total Tagihan</p>
                            <p class="text-2xl sm:text-3xl font-black text-orange-600 tracking-tight">Rp ${totalAmount}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="window.executePrintPdf()" class="w-full py-2.5 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 text-sm font-bold rounded-xl transition flex items-center justify-center gap-2 outline-none">
                            <i class="ph-bold ph-printer"></i> Cetak / PDF
                        </button>
                        <button onclick="Swal.close()" class="w-full py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/20 transition flex items-center justify-center gap-2 outline-none">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
            `,
            showConfirmButton: false,
            showCloseButton: false,
            width: '600px',
            customClass: { popup: 'rounded-3xl p-6 sm:p-8' }
        });
    }
    </script> 

    <script>
        
        // --- 2. MODAL DETAIL STATUS DINAMIS (ANTI-BUG BASE64) ---
        function showOrderDetail(invoiceId, b64ProductName, dateStr, b64RoomHtml, totalStr, imageUrl, b64WaUrl, statusTrx = 'UNPAID') {
            const productName = decodeURIComponent(escape(atob(b64ProductName)));
            const roomHtml = decodeURIComponent(escape(atob(b64RoomHtml)));
            const waUrl = atob(b64WaUrl);
            
            // 👇 FIX LOGIKA TIMELINE DETAIL 👇
            const isBatal = ['CANCELLED', 'BATAL'].includes(statusTrx);
            const isDitolak = ['BUKTI_DITOLAK', 'REJECTED', 'DITOLAK_TRAVEL', 'FAILED'].includes(statusTrx);
            const isPartial = statusTrx === 'PARTIAL';
            const isPending = statusTrx === 'PENDING';
            const isLunas = ['SUCCESS', 'PAID', 'LUNAS', 'COMPLETED', 'DONE'].includes(statusTrx);

            let badgeHtml = '';
            let timelineHtml = '';

            if (isBatal) {
                badgeHtml = `<span class="bg-red-100 text-red-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1"><i class="ph-bold ph-x-circle"></i> Dibatalkan</span>`;
                timelineHtml = `
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-green-500 ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-slate-900">Booking Berhasil</p>
                        <p class="text-[10px] text-slate-500">${dateStr}</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-red-500 ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-red-600">Pesanan Dibatalkan</p>
                        <p class="text-[10px] text-slate-500">Transaksi ini telah dibatalkan oleh sistem/admin.</p>
                    </div>`;
            } else if (isDitolak) {
                badgeHtml = `<span class="bg-red-100 text-red-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1"><i class="ph-bold ph-x-circle"></i> Bukti Ditolak</span>`;
                timelineHtml = `
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-green-500 ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-slate-900">Booking Berhasil</p>
                        <p class="text-[10px] text-slate-500">${dateStr}</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-red-500 ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-red-600">Pembayaran Ditolak</p>
                        <p class="text-[10px] text-slate-500">Bukti transfer tidak valid. Mohon upload ulang.</p>
                    </div>`;
            } else if (isLunas) {
                badgeHtml = `<span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1"><i class="ph-fill ph-check-circle"></i> Lunas</span>`;
                timelineHtml = `
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-green-500 ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-slate-900">Booking Berhasil</p>
                        <p class="text-[10px] text-slate-500">${dateStr}</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-white animate-pulse"></div>
                        <p class="text-xs font-bold text-emerald-600">Pembayaran Lunas</p>
                        <p class="text-[10px] text-slate-500">Transaksi selesai. Persiapkan ibadah Anda.</p>
                    </div>`;
            } else if (isPartial) {
                badgeHtml = `<span class="bg-indigo-100 text-indigo-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1"><i class="ph-duotone ph-arrows-clockwise"></i> Cicilan Berjalan</span>`;
                timelineHtml = `
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-green-500 ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-slate-900">Booking Berhasil</p>
                        <p class="text-[10px] text-slate-500">${dateStr}</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-indigo-500 ring-4 ring-white animate-pulse"></div>
                        <p class="text-xs font-bold text-indigo-600">Skema Cicilan Aktif</p>
                        <p class="text-[10px] text-slate-500">Mohon selesaikan sisa tagihan tepat waktu.</p>
                    </div>`;
            } else if (isPending) {
                badgeHtml = `<span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-yellow-600 animate-pulse"></span> Verifikasi</span>`;
                timelineHtml = `
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-green-500 ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-slate-900">Booking Berhasil</p>
                        <p class="text-[10px] text-slate-500">${dateStr}</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-yellow-500 ring-4 ring-white animate-pulse"></div>
                        <p class="text-xs font-bold text-yellow-600">Verifikasi Admin</p>
                        <p class="text-[10px] text-slate-500">Admin travel sedang mengecek mutasi pembayaran.</p>
                    </div>`;
            } else {
                badgeHtml = `<span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Menunggu Pembayaran</span>`;
                timelineHtml = `
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-green-500 ring-4 ring-white"></div>
                        <p class="text-xs font-bold text-slate-900">Booking Berhasil</p>
                        <p class="text-[10px] text-slate-500">${dateStr}</p>
                    </div>
                    <div class="relative">
                        <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-orange-500 ring-4 ring-white animate-pulse"></div>
                        <p class="text-xs font-bold text-orange-600">Menunggu Pembayaran</p>
                        <p class="text-[10px] text-slate-500">Mohon segera lakukan transfer.</p>
                    </div>`;
            }

            Swal.fire({
                title: '',
                html: `
                <div class="text-left">
                    <div class="flex justify-between items-start mb-6 border-b border-slate-100 pb-4 mt-10">
                        <div>
                            <p class="text-xs text-slate-500 mb-1">No. Invoice</p>
                            <p class="text-lg font-mono font-bold text-slate-900 tracking-wide select-all">${invoiceId}</p>
                        </div>
                        ${badgeHtml}
                    </div>
                    <div class="mb-8">
                        <h4 class="text-sm font-bold text-slate-900 mb-4">Status Pesanan</h4>
                        <div class="relative flex flex-col gap-6 pl-4 border-l-2 border-slate-200 ml-2">
                            ${timelineHtml}
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 mb-6 border border-slate-100 shadow-sm">
                        <div class="flex gap-3 mb-4 border-b border-slate-200 pb-3">
                            <div class="w-12 h-12 bg-white rounded-lg overflow-hidden border border-slate-200 flex-shrink-0">
                                <img src="${imageUrl}" class="w-full h-full object-cover" onerror="this.src='/assets/img/marketplace/produk-dummy.png'" alt="Produk">
                            </div>
                            <div class="flex-1 flex items-center">
                                <p class="text-xs font-bold text-slate-900 line-clamp-2">${productName}</p>
                            </div>
                        </div>
                        <div class="space-y-3 text-xs">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rincian Kamar & Skema</p>
                            <div class="space-y-2">${roomHtml}</div>
                            <div class="flex justify-between items-center font-bold text-slate-900 pt-3 border-t border-slate-200 mt-2">
                                <span class="text-[10px] text-slate-400 font-normal uppercase leading-tight">Total Harga Paket</span>
                                <span class="text-base text-orange-600 font-extrabold block">Rp ${totalStr}</span>
                            </div>
                        </div>
                    </div>
                    <a href="${waUrl}" target="_blank" class="w-full py-3 bg-[#25D366] hover:bg-green-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-green-500/20 transition flex items-center justify-center gap-2 mb-2">
                        <i class="ph-bold ph-whatsapp-logo text-lg"></i> Hubungi CS via WhatsApp
                    </a>
                </div>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                width: '450px',
                customClass: { popup: 'rounded-2xl text-left', closeButton: 'focus:outline-none' }
            });
        }

        // --- 3. MODAL DETAIL STATUS: VERIFIKASI ---
        function showVerificationDetail(invoiceId, productName, dateStr, roomHtml, totalStr, imageUrl) {
            Swal.fire({
                title: '',
                html: `
                    <div class="text-left">
                        <div class="flex justify-between items-start mb-6 border-b border-slate-100 pb-4 mt-10">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">No. Invoice</p>
                                <p class="text-lg font-mono font-bold text-slate-900 tracking-wide select-all">${invoiceId}</p>
                            </div>
                            <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-600 animate-pulse"></span> Verifikasi
                            </span>
                        </div>
                        <div class="mb-8">
                            <h4 class="text-sm font-bold text-slate-900 mb-4">Status Pesanan</h4>
                            <div class="relative flex flex-col gap-6 pl-4 border-l-2 border-slate-200 ml-2">
                                <div class="relative">
                                    <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-green-500 ring-4 ring-white"></div>
                                    <p class="text-xs font-bold text-slate-900">Booking Berhasil</p>
                                    <p class="text-[10px] text-slate-500">${dateStr}</p>
                                </div>
                                <div class="relative">
                                    <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-yellow-500 ring-4 ring-white animate-pulse"></div>
                                    <p class="text-xs font-bold text-yellow-600">Verifikasi Pembayaran</p>
                                    <p class="text-[10px] text-slate-500">Admin sedang mengecek pembayaran Anda.</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 mb-6 border border-slate-100 shadow-sm">
                            <div class="flex gap-3 mb-4 border-b border-slate-200 pb-3">
                                <div class="w-12 h-12 bg-white rounded-lg overflow-hidden border border-slate-200 flex-shrink-0">
                                    <img src="${imageUrl}" class="w-full h-full object-cover" onerror="this.src='/assets/img/marketplace/produk-dummy.png'" alt="Produk">
                                </div>
                                <div class="flex-1 flex items-center">
                                    <p class="text-xs font-bold text-slate-900 line-clamp-2">${productName}</p>
                                </div>
                            </div>
                            <div class="space-y-3 text-xs">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rincian Kamar</p>
                                <div class="space-y-2">${roomHtml}</div>
                                <div class="flex justify-between items-center font-bold text-slate-900 pt-3 border-t border-slate-200 mt-2">
                                    <span class="text-[10px] text-slate-400 font-normal uppercase leading-tight">Total Tagihan</span>
                                    <span class="text-base text-orange-600 font-extrabold block">Rp ${totalStr}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                width: '450px',
                customClass: {
                    popup: 'rounded-2xl text-left',
                    closeButton: 'focus:outline-none'
                }
            });
        }

        // --- 4. MODAL DETAIL STATUS: LUNAS (UI KONSISTEN) ---
        function showPaidOrderDetail(invoiceId, productName, dateStr, paidDateStr, roomHtml, totalStr, imageUrl,
            evidenceUrl, waUrl) {
            Swal.fire({
                title: '',
                html: `
            <div class="text-left">
                <div class="flex justify-between items-start mb-6 border-b border-slate-100 pb-4 mt-10">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">No. Invoice</p>
                        <p class="text-lg font-mono font-bold text-slate-900 tracking-wide select-all">${invoiceId}</p>
                    </div>
                    <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider flex items-center gap-1">
                        <i class="ph-fill ph-check-circle"></i> Lunas
                    </span>
                </div>
                
                <div class="mb-8">
                    <h4 class="text-sm font-bold text-slate-900 mb-4">Status Pesanan</h4>
                    <div class="relative flex flex-col gap-6 pl-4 border-l-2 border-slate-200 ml-2">
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-green-500 ring-4 ring-white"></div>
                            <p class="text-xs font-bold text-slate-900">Booking Berhasil</p>
                            <p class="text-[10px] text-slate-500">${dateStr}</p>
                        </div>
                        <div class="relative">
                            <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-emerald-500 ring-4 ring-white animate-pulse"></div>
                            <p class="text-xs font-bold text-emerald-600">Pembayaran Berhasil</p>
                            <p class="text-[10px] text-slate-500">Kwitansi resmi Anda telah diterbitkan.</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">${paidDateStr}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-4 mb-6 border border-slate-100 shadow-sm">
                    <div class="flex gap-3 mb-4 border-b border-slate-200 pb-3">
                        <div class="w-12 h-12 bg-white rounded-lg overflow-hidden border border-slate-200 flex-shrink-0">
                            <img src="${imageUrl}" class="w-full h-full object-cover" onerror="this.src='/assets/img/marketplace/produk-dummy.png'" alt="Produk">
                        </div>
                        <div class="flex-1 flex items-center">
                            <p class="text-xs font-bold text-slate-900 line-clamp-2">${productName}</p>
                        </div>
                    </div>
                    <div class="space-y-3 text-xs">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rincian Kamar</p>
                        <div class="space-y-2">${roomHtml}</div>
                        <div class="flex justify-between items-center font-bold text-slate-900 pt-3 border-t border-slate-200 mt-2">
                            <span class="text-[10px] text-slate-400 font-normal uppercase leading-tight">Total Tagihan</span>
                            <span class="text-base text-orange-600 font-extrabold block">Rp ${totalStr}</span>
                        </div>
                    </div>
                </div>
                
                <a href="${waUrl}" target="_blank" class="w-full py-3 bg-[#25D366] hover:bg-green-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-green-500/20 transition flex items-center justify-center gap-2 mb-2">
                    <i class="ph-bold ph-whatsapp-logo text-lg"></i> Hubungi CS via WhatsApp
                </a>
            </div>
        `,
                showConfirmButton: false,
                showCloseButton: true,
                width: '450px',
                customClass: {
                    popup: 'rounded-2xl text-left',
                    closeButton: 'focus:outline-none'
                }
            });
        }

        // --- 5. MODAL DOWNLOAD KWITANSI ---
        function showReceiptModal(invoiceId, evidenceUrl) {
            Swal.fire({
                title: '',
                html: `
                    <div class="text-center pt-4">
                        <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 ring-8 ring-blue-50">
                            <i class="ph-duotone ph-receipt text-4xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">Bukti Pembayaran Terbit!</h3>
                        <p class="text-sm text-slate-500 mb-6 px-4">
                            Pembayaran Anda telah kami terima. Silakan unduh bukti bayar (kwitansi) resmi Anda di bawah ini.
                        </p>
                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-6 text-left relative overflow-hidden group hover:border-blue-300 transition cursor-pointer" onclick="downloadAction()">
                            <div class="absolute top-0 right-0 bg-blue-600 text-white text-[10px] px-2 py-1 rounded-bl-lg font-bold">PDF</div>
                            <div class="flex items-center gap-3">
                                <i class="ph-fill ph-file-text text-blue-500 text-3xl"></i>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Bukti-Bayar-${invoiceId.replace(/\//g, '-')}.pdf</p>
                                    <p class="text-[10px] text-slate-500">Dokumen Sah Pengenumroh.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-3">
                            <button onclick="downloadAction()" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition flex items-center justify-center gap-2">
                                <i class="ph-bold ph-download-simple"></i> Simpan Bukti Bayar
                            </button>
                            <button onclick="Swal.close()" class="w-full py-3 text-slate-500 text-sm font-bold hover:text-slate-700">
                                Tutup
                            </button>
                        </div>
                    </div>
                `,
                showConfirmButton: false,
                showCloseButton: false,
                width: '400px',
                customClass: {
                    popup: 'rounded-3xl'
                }
            });
        }

        // --- Simulasi Download Kwitansi ---
        // function downloadAction() {
        //     const btn = document.querySelector('.swal2-html-container button');
        //     btn.innerHTML = '<i class="ph-bold ph-spinner animate-spin"></i> Memproses...';
        //     btn.classList.add('opacity-75', 'cursor-not-allowed');
        //     setTimeout(() => {
        //         Swal.close();
        //         const Toast = Swal.mixin({
        //             toast: true,
        //             position: 'top-end',
        //             showConfirmButton: false,
        //             timer: 3000,
        //             timerProgressBar: true
        //         });
        //         Toast.fire({
        //             icon: 'success',
        //             title: 'Bukti pembayaran berhasil disimpan'
        //         });
        //     }, 1500);
        // }
    </script>

    <script>
        // --- FITUR BARU: BATALKAN PESANAN ---
        function cancelOrder(trxId, invoiceNo) {
            Swal.fire({
                title: 'Batalkan Pesanan?',
                text: `Apakah Anda yakin ingin membatalkan pesanan ${invoiceNo}? Tindakan ini tidak dapat dipulihkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Sedang membatalkan pesanan Anda.',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    // Endpoint Laravel untuk membatalkan pesanan (Pastikan route & controllernya udah dibuat)
                    fetch(`/marketplace/profil/pesanan/${trxId}/cancel`, {
                        method: 'POST', // Bisa ubah jadi PUT/PATCH tergantung API Darda
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ status: 'CANCELLED' }) // Payload status untuk backend
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Dibatalkan!',
                                text: 'Pesanan Anda berhasil dibatalkan.',
                                confirmButtonColor: '#ea580c'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Gagal!', data.message || 'Gagal membatalkan pesanan.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error Sistem!', 'Terjadi kesalahan jaringan atau koneksi.', 'error');
                    });
                }
            });
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
        // --- LOGIKA MODAL DINAMIS ---
        function openJamaahModal(trxId) {
            const modal = document.getElementById(`modal-jamaah-${trxId}`);
            const content = document.getElementById(`modal-jamaah-content-${trxId}`);
            
            modal.classList.remove('hidden');
            modal.classList.add('flex'); // Pastikan menggunakan flex untuk centering
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeJamaahModal(trxId) {
            const modal = document.getElementById(`modal-jamaah-${trxId}`);
            const content = document.getElementById(`modal-jamaah-content-${trxId}`);
            
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // --- LOGIKA ACCORDION JAMAAH ---
        function toggleJamaah(trxId, i) {
            const content = document.getElementById(`content-jamaah-${trxId}-${i}`);
            const chevron = document.getElementById(`chevron-${trxId}-${i}`);
            const card = document.getElementById(`card-jamaah-${trxId}-${i}`);
            const isHidden = content.classList.contains('hidden');

            // Tutup semua form di transaksi ini
            const allContents = document.querySelectorAll(`[id^="content-jamaah-${trxId}-"]`);
            allContents.forEach(el => {
                el.classList.add('hidden');
                const loopIdx = el.id.split('-').pop();
                document.getElementById(`chevron-${trxId}-${loopIdx}`)?.classList.replace('ph-caret-up', 'ph-caret-down');
                
                const c = document.getElementById(`card-jamaah-${trxId}-${loopIdx}`);
                if(c && !c.classList.contains('border-emerald-200')) {
                    c.classList.remove('border-orange-400', 'border-2', 'ring-4', 'ring-orange-500/10');
                    c.classList.add('border-slate-200');
                }
            });

            // Buka yang di-klik
            if (isHidden) {
                content.classList.remove('hidden');
                chevron.classList.replace('ph-caret-down', 'ph-caret-up');
                if(!card.classList.contains('border-emerald-200')) {
                    card.classList.remove('border-slate-200');
                    card.classList.add('border-orange-400', 'border-2', 'ring-4', 'ring-orange-500/10');
                }
            }
        }

        // --- LOGIKA AJAX SIMPAN DATA JAMAAH REAL ---
        async function submitDataJamaah(trxId, urutan, totalPax) {
            const form = document.getElementById(`form-jamaah-${trxId}-${urutan}`);

            // 1. Validasi Custom (Ganti bawaan HTML5 yang bentrok dengan opacity-0)
            if (!form.checkValidity()) {
                const firstInvalid = form.querySelector(':invalid');
                let pesanError = 'Harap lengkapi semua data wajib (bertanda bintang merah).';
                if (firstInvalid && firstInvalid.type === 'file') {
                    pesanError = 'Harap upload dokumen (KTP/KK/dll) yang masih kosong.';
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: pesanError,
                    confirmButtonColor: '#ea580c'
                });
                return; // Hentikan eksekusi jika tidak valid
            }

            // 2. Persiapan Data Request
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            if (!csrfMeta) {
                Swal.fire('Error', 'Meta CSRF Token tidak ditemukan di HTML.', 'error');
                return;
            }
            const csrfToken = csrfMeta.getAttribute('content');
            const formData = new FormData(form);
            const inputName = formData.get('fullname');

            Swal.fire({
                title: 'Menyimpan Data...',
                text: 'Mohon tunggu, data sedang diproses ke server.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            try {
                const response = await fetch("{{ route('marketplace.profil.pesanan.simpanJamaah') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const result = await response.json();

                if (result.status === 'success') {
                    delete dirtyForms[form.id];

                    // UI UPDATE HIDE & SHOW SUCCESS
                    document.getElementById(`nama-jamaah-${trxId}-${urutan}`).textContent = inputName;
                    
                    const badge = document.getElementById(`badge-status-${trxId}-${urutan}`);
                    badge.textContent = 'Lengkap';
                    badge.className = 'px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase rounded-md border border-emerald-200';
                    
                    const icon = document.getElementById(`icon-status-${trxId}-${urutan}`);
                    icon.innerHTML = '<i class="ph-bold ph-check text-lg"></i>';
                    icon.className = 'w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 border border-emerald-200 flex items-center justify-center text-emerald-600 shrink-0';
                    
                    const card = document.getElementById(`card-jamaah-${trxId}-${urutan}`);
                    card.className = 'bg-white rounded-xl border border-emerald-200 shadow-sm overflow-hidden transition-all duration-300 mt-4';
                    
                    // UI UPDATE: Mengubah Tombol Jadi Mode Edit/Update (Feedback Instan)
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = `<i class="ph-bold ph-check-circle text-base"></i> Update Data Jamaah ${urutan}`;
                        submitBtn.classList.remove('bg-orange-600', 'hover:bg-orange-700', 'shadow-orange-500/25');
                        submitBtn.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'shadow-emerald-500/25');
                    }

                    if (result.data && result.data.id) {
                        document.getElementById(`id_jamaah_${trxId}_${urutan}`).value = result.data.id;
                        const fileInputs = form.querySelectorAll('input[type="file"]');
                        fileInputs.forEach(input => input.removeAttribute('required'));
                    }

                    // Hitung Ulang Progress
                    let countLengkap = 0;
                    for(let i = 1; i <= totalPax; i++) {
                        if(document.getElementById(`id_jamaah_${trxId}_${i}`).value !== "") {
                            countLengkap++;
                        }
                    }
                    const progressEl = document.getElementById(`progress-count-${trxId}`);
                    if (progressEl) progressEl.textContent = countLengkap;

                    Swal.fire({
                        icon: 'success',
                        title: 'Data Tersimpan!',
                        text: `Data jamaah ke-${urutan} berhasil diamankan.`,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    // Otomatis menutup card saat ini, dan membuka card selanjutnya jika masih ada
                    if (urutan < totalPax) {
                        toggleJamaah(trxId, urutan);     // Tutup yg sekarang
                        toggleJamaah(trxId, urutan + 1); // Buka yg selanjutnya
                    } else {
                        toggleJamaah(trxId, urutan); // Jika terakhir, tutup saja
                    }

                } else {
                    // 🔥 INI YANG KURANG BANG! 🔥
                    // Kalau gagal nyimpen (misal dari Controller PHP balikin status 'error'), 
                    // Loading muter-muter harus disetop dan kasih tau pesan errornya.
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan!',
                        text: result.message || 'Terjadi kesalahan saat memproses data.',
                        confirmButtonColor: '#dc2626'
                    });
                }

            } catch (error) {
                console.error("Error API:", error);
                Swal.fire('Sistem Error', 'Terjadi kesalahan jaringan atau koneksi ke server terputus.', 'error');
            }
        }

        // --- LOGIKA PREVIEW FILE UPLOAD ---
        document.addEventListener('change', function(e) {
            if (e.target && e.target.classList.contains('file-input')) {
                const wrapper = e.target.closest('.file-upload-wrapper');
                const placeholder = wrapper.querySelector('.placeholder-content');
                const previewImg = wrapper.querySelector('.preview-img');
                const editOverlay = wrapper.querySelector('.edit-overlay');

                if (e.target.files && e.target.files.length > 0) {
                    const file = e.target.files[0];
                    
                    // Ubah gaya kotak jadi sukses (hijau)
                    wrapper.classList.remove('border-dashed', 'border-slate-200', 'bg-slate-50');
                    wrapper.classList.add('border-solid', 'border-emerald-300', 'shadow-sm');

                    if (file.type.startsWith('image/')) {
                        // Jika File Gambar
                        const reader = new FileReader();
                        reader.onload = function(eEvent) {
                            if (previewImg) {
                                previewImg.src = eEvent.target.result;
                                previewImg.classList.remove('hidden');
                            }
                            if (placeholder) {
                                placeholder.classList.add('hidden'); // Menghilangkan ikon & tulisan yang menumpuk
                                placeholder.classList.remove('flex');
                            }
                            if (editOverlay) editOverlay.classList.remove('hidden');
                        }
                        reader.readAsDataURL(file);
                    } else {
                        // Jika File PDF / Bukan Gambar
                        if (previewImg) previewImg.classList.add('hidden');
                        if (editOverlay) editOverlay.classList.add('hidden');
                        
                        if (placeholder) {
                            placeholder.classList.remove('hidden');
                            placeholder.classList.add('flex');
                            placeholder.querySelector('.file-name').textContent = file.name;
                            placeholder.querySelector('.file-name').classList.replace('text-slate-500', 'text-emerald-600');
                            placeholder.querySelector('.file-icon').className = 'ph-duotone ph-file-pdf text-2xl text-emerald-500 mb-1 file-icon';
                        }
                    }
                }
            }
        });

    </script>

    <script>

        // --- FITUR PERINGATAN DATA BELUM DISIMPAN (DIRTY FORM TRACKER) ---
        let dirtyForms = {}; // Objek untuk melacak form mana saja yang sedang diedit

        // Pantau setiap kali user mengetik sesuatu
        document.addEventListener('input', function(e) {
            const form = e.target.closest('form[id^="form-jamaah-"]');
            if (form) {
                dirtyForms[form.id] = true; // Tandai form ini "kotor" (belum disave)
            }
        });

        // Pantau setiap kali user mengubah file upload atau select dropdown
        document.addEventListener('change', function(e) {
            const form = e.target.closest('form[id^="form-jamaah-"]');
            if (form) {
                dirtyForms[form.id] = true;
            }
        });

        // Fungsi untuk mencegat tombol tutup
        function checkAndCloseJamaahModal(trxId) {
            // Cek apakah ada form di transaksi ini yang kotor
            const hasUnsavedChanges = Object.keys(dirtyForms).some(id => id.startsWith(`form-jamaah-${trxId}-`));

            if (hasUnsavedChanges) {
                Swal.fire({
                    title: 'Ada Data Belum Disimpan!',
                    text: 'Anda telah mengubah/mengisi data namun belum menekan tombol Simpan atau Update. Yakin ingin menutupnya?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626', // Warna merah peringatan
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Tutup Saja',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Bersihkan status kotor untuk transaksi ini, lalu tutup
                        Object.keys(dirtyForms).forEach(id => {
                            if (id.startsWith(`form-jamaah-${trxId}-`)) delete dirtyForms[id];
                        });
                        closeJamaahModal(trxId);
                    }
                });
            } else {
                // Kalau tidak ada yang diubah, tutup mulus seperti biasa
                closeJamaahModal(trxId);
            }
        }

        // --- LOGIKA MODAL VIEW ONLY (UNTUK STATUS LUNAS) ---
        function openJamaahViewModal(trxId) {
            const modal = document.getElementById(`modal-jamaah-view-${trxId}`);
            const content = modal.querySelector('.transform');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
            }, 10);
        }

        function closeJamaahViewModal(trxId) {
            const modal = document.getElementById(`modal-jamaah-view-${trxId}`);
            const content = modal.querySelector('.transform');
            
            modal.classList.add('opacity-0');
            content.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        function toggleJamaahView(trxId, i) {
            const content = document.getElementById(`content-jamaah-view-${trxId}-${i}`);
            const chevron = document.getElementById(`chevron-view-${trxId}-${i}`);
            const isHidden = content.classList.contains('hidden');

            // Tutup semua dropdown di modal View ini
            const allContents = document.querySelectorAll(`[id^="content-jamaah-view-${trxId}-"]`);
            allContents.forEach(el => {
                el.classList.add('hidden');
                const loopIdx = el.id.split('-').pop();
                document.getElementById(`chevron-view-${trxId}-${loopIdx}`)?.classList.replace('ph-caret-up', 'ph-caret-down');
            });

            // Buka yang di-klik
            if (isHidden) {
                content.classList.remove('hidden');
                chevron.classList.replace('ph-caret-down', 'ph-caret-up');
            }
        }

    </script>

    <script>

        // =====================================================================
        // 🌟 FUNGSI UI & UPLOAD KHUSUS SKEMA CICILAN (INSTALLMENT) 🌟
        // =====================================================================

        // =====================================================================
        // 🌟 FUNGSI UI & UPLOAD KHUSUS SKEMA CICILAN (INSTALLMENT) 🌟
        // =====================================================================
        function openInstallmentModal(trxId, installmentsStr, rekType, rekBank, rekNo, rekName, totalPax) {
            
            // 👇 TAMBAHAN VALIDASI DATA JAMAAH (WAJIB ISI DULU) 👇
            const progressEl = document.getElementById(`progress-count-${trxId}`);
            const currentLengkap = progressEl ? parseInt(progressEl.innerText) : 0;

            if (currentLengkap < totalPax) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap!',
                    html: `Anda baru melengkapi <b>${currentLengkap}</b> dari <b>${totalPax}</b> data jamaah.<br><br>Harap lengkapi seluruh identitas dan dokumen jamaah terlebih dahulu sebelum membayar cicilan.`,
                    confirmButtonText: 'Lengkapi Sekarang',
                    confirmButtonColor: '#10b981',
                    showCancelButton: true,
                    cancelButtonText: 'Tutup'
                }).then((res) => {
                    if (res.isConfirmed) {
                        openJamaahModal(trxId);
                    }
                });
                return; // Hentikan fungsi biar modal cicilan gak kebuka
            }
            // 👆 SELESAI VALIDASI 👆

            let installments = JSON.parse(atob(installmentsStr));
            // Urutkan cicilan berdasarkan nomor tahap
            installments.sort((a, b) => a.installment_number - b.installment_number);
            
            let contentHtml = '<div class="space-y-4 text-left">';
            let canPayNext = true;

            // 🔥 KUNCI UTAMA: Menahan jamaah agar bayar berurutan
            installments.forEach((inst, idx) => {
                let status = (inst.status || 'UNPAID').toUpperCase();
                let isPending = status === 'PENDING';
                let isPaid = status === 'PAID' || status === 'SUCCESS';
                let isFailed = status === 'FAILED' || status === 'REJECTED';
                
                // Format Tanggal Jatuh Tempo
                let dueDate = new Date(inst.due_date).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                let amountStr = parseInt(inst.amount).toLocaleString('id-ID');
                let tahapLabel = inst.installment_number === 1 ? 'Tahap 1 (DP Awal)' : `Tahap ${inst.installment_number} (Cicilan)`;
                
                let btnHtml = '';
                let statusBadge = '';

                if (isPaid) {
                    statusBadge = `<span class="bg-emerald-100 text-emerald-700 text-[10px] px-2 py-0.5 rounded font-bold uppercase"><i class="ph-bold ph-check-circle"></i> Lunas</span>`;
                    btnHtml = `<button disabled class="w-full mt-2 py-2 bg-slate-100 text-emerald-600 rounded-lg text-xs font-bold cursor-not-allowed border border-emerald-200"><i class="ph-bold ph-check"></i> Sudah Dibayar</button>`;
                } else if (isPending) {
                    statusBadge = `<span class="bg-yellow-100 text-yellow-700 text-[10px] px-2 py-0.5 rounded font-bold uppercase"><i class="ph-bold ph-hourglass-high animate-spin-slow"></i> Verifikasi</span>`;
                    btnHtml = `<button disabled class="w-full mt-2 py-2 bg-yellow-50 text-yellow-600 rounded-lg text-xs font-bold cursor-not-allowed border border-yellow-200">Sedang Diverifikasi Admin...</button>`;
                    canPayNext = false; // 🔥 KUNCI TAHAP BERIKUTNYA
                } else {
                    if (isFailed) {
                        statusBadge = `<span class="bg-red-100 text-red-700 text-[10px] px-2 py-0.5 rounded font-bold uppercase"><i class="ph-bold ph-x-circle"></i> Bukti Ditolak</span>`;
                    } else {
                        statusBadge = `<span class="bg-orange-100 text-orange-700 text-[10px] px-2 py-0.5 rounded font-bold uppercase">Belum Dibayar</span>`;
                    }
                    
                    if (!canPayNext) {
                        // TERKUNCI KARENA SEBELUMNYA BELUM LUNAS
                        btnHtml = `
                        <button disabled class="w-full mt-2 py-2 bg-slate-100 text-slate-400 rounded-lg text-xs font-bold cursor-not-allowed border border-slate-200">
                            <i class="ph-bold ph-lock-key"></i> Terkunci
                        </button>
                        <p class="text-[9px] text-center text-red-500 font-medium mt-1">Harap lunasi tagihan tahap sebelumnya.</p>`;
                    } else {
                        // SIAP DIBAYAR
                        btnHtml = `<button onclick="uploadCicilanModal('${inst.id}', '${amountStr}', '${rekType}', '${rekBank}', '${rekNo}', '${rekName}', '${tahapLabel}')" class="w-full mt-2 py-2 bg-orange-600 hover:bg-orange-700 text-white rounded-lg text-xs font-bold transition shadow-md shadow-orange-500/20 active:scale-95"><i class="ph-bold ph-upload-simple"></i> ${isFailed ? 'Upload Ulang Bukti' : 'Upload Bukti Bayar'}</button>`;
                    }
                    canPayNext = false; // 🔥 KUNCI TAHAP BERIKUTNYA!
                }

                contentHtml += `
                <div class="bg-white p-4 rounded-xl border ${isPaid ? 'border-emerald-200 bg-emerald-50/30' : 'border-slate-200'} shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-start mb-1">
                        <p class="text-xs font-bold text-slate-800">${tahapLabel}</p>
                        ${statusBadge}
                    </div>
                    <div class="flex justify-between items-end mt-2">
                        <div>
                            <p class="text-[9px] text-slate-500 font-medium uppercase tracking-wider mb-0.5">Jatuh Tempo</p>
                            <p class="text-xs font-bold text-slate-700 flex items-center gap-1"><i class="ph-duotone ph-calendar-blank text-orange-500"></i> ${dueDate}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] text-slate-500 font-medium uppercase tracking-wider mb-0.5">Nominal</p>
                            <p class="text-base font-black text-orange-600">Rp ${amountStr}</p>
                        </div>
                    </div>
                    ${btnHtml}
                </div>
                `;
            });
            
            contentHtml += '</div>';
            
            Swal.fire({
                title: '<span class="text-lg font-bold text-slate-900">Rincian & Bayar Cicilan</span>',
                html: contentHtml,
                showConfirmButton: false,
                showCloseButton: true,
                customClass: {
                    popup: 'rounded-3xl bg-slate-50 p-4 sm:p-6',
                    htmlContainer: 'mt-2'
                }
            });
        }

        // 🌟 FUNGSI UPLOAD AJAX SPESIFIK UNTUK CICILAN 🌟
        async function uploadCicilanModal(idInstallment, totalAmount, rekType, rekBank, rekNo, rekName, tahapLabel) {
            // Tutup popup list cicilan dulu
            Swal.close();

            // 🌟 FETCH DYNAMIC BANK IF NEEDED (MENGHINDARI BUG 'FETCH_DYNAMIC') 🌟
            if (rekType === 'MANDIRI' && rekBank === 'FETCH_DYNAMIC') {
                let productId = rekNo; // rekNo di set sebagai productId di PHP
                let rekIdPilihan = String(rekName).trim();
                if (rekIdPilihan === 'KOSONG' || rekIdPilihan === '') {
                    let cachedId = localStorage.getItem(`saved_rek_${productId}`);
                    if (cachedId) rekIdPilihan = cachedId;
                }

                Swal.fire({ title: 'Memuat Data Rekening...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
                try {
                    let res = await fetch(`/marketplace/produk/${productId}/payment-options`, {
                        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                    });
                    let data = await res.json();
                    let bankData = data.data || data;
                    let bankList = [];
                    function findBanks(obj) {
                        if (!obj) return;
                        if(Array.isArray(obj)) { obj.forEach(v => findBanks(v)); }
                        else if(typeof obj === 'object') {
                            if((obj.nama_bank || obj.bank_name) && (obj.no_rekening || obj.bank_account)) { bankList.push(obj); }
                            else { for(let k in obj) findBanks(obj[k]); }
                        }
                    }
                    findBanks(bankData);
                    let foundBank = null;
                    if (rekIdPilihan !== 'KOSONG' && rekIdPilihan !== '') {
                        foundBank = bankList.find(b => (String(b.id) === rekIdPilihan || String(b.travel_rekening_id) === rekIdPilihan || String(b.rekening_id) === rekIdPilihan));
                    }
                    foundBank = foundBank || bankList[0];
                    rekBank = foundBank ? (foundBank.nama_bank || foundBank.bank_name) : 'Bank Travel';
                    rekNo = foundBank ? (foundBank.no_rekening || foundBank.bank_account || foundBank.nomor_rekening) : 'Sesuai Instruksi Travel';
                    rekName = foundBank ? (foundBank.atas_nama || foundBank.bank_owner || foundBank.pemilik_rekening) : 'Mitra Travel';
                    Swal.close();
                } catch(e) {
                    Swal.close();
                    rekBank = 'Rekening Travel';
                    rekNo = 'Hubungi Travel';
                    rekName = 'Mitra Travel';
                }
            }

            let bankHtmlCard = '';
            if (rekType === 'MARKETPLACE') {
                if (rekBank.includes('/')) {
                    bankHtmlCard = `
                        <div class="bg-gradient-to-br from-white via-slate-50 to-blue-50/50 border border-blue-200 rounded-xl p-4 shadow-sm relative overflow-hidden">
                            <div class="flex items-center gap-2 mb-3.5 relative z-10">
                                <i class="ph-fill ph-shield-check text-blue-600 text-lg"></i>
                                <p class="text-[11px] font-black text-slate-900 uppercase tracking-tight">Rekening Resmi PengenUmroh</p>
                                <span class="ml-auto bg-blue-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Pusat</span>
                            </div>
                            <div class="space-y-2 mb-3 relative z-10">
                                <div class="flex items-center justify-between bg-white px-3 py-2.5 rounded-lg border border-slate-100 shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-[#0066AE] text-white text-[10px] font-bold py-1 w-10 text-center rounded">BCA</div>
                                        <span class="text-sm font-bold text-slate-800 font-mono tracking-wider">7131720452</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between px-1 relative z-10">
                                <span class="text-[10px] text-slate-500 font-medium">a.n PT Kolaborasi Para Sahabat</span>
                            </div>
                        </div>
                    `;
                } else {
                    let bankColor = rekBank.includes('BSI') ? 'bg-teal-600' : 'bg-[#0066AE]';
                    bankHtmlCard = `
                        <div class="bg-gradient-to-br from-white via-slate-50 to-blue-50/50 border border-blue-200 rounded-xl p-4 shadow-sm relative overflow-hidden">
                            <div class="flex items-center gap-2 mb-3.5 relative z-10">
                                <i class="ph-fill ph-shield-check text-blue-600 text-lg"></i>
                                <p class="text-[11px] font-black text-slate-900 uppercase tracking-tight">Rekening Resmi PengenUmroh</p>
                                <span class="ml-auto bg-blue-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Pusat</span>
                            </div>
                            <div class="space-y-2 mb-3 relative z-10">
                                <div class="flex items-center justify-between bg-white px-3 py-2.5 rounded-lg border border-slate-100 shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="${bankColor} text-white text-[10px] font-bold py-1 w-10 text-center rounded">${rekBank}</div>
                                        <span class="text-sm font-bold text-slate-800 font-mono tracking-wider">${rekNo}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between px-1 relative z-10">
                                <span class="text-[10px] text-slate-500 font-medium">a.n ${rekName}</span>
                            </div>
                        </div>
                    `;
                }
            } else {
                // 👇 INI YANG TADI TERHAPUS 👇
                bankHtmlCard = `
                    <div class="bg-gradient-to-br from-white via-slate-50 to-orange-50/50 border border-orange-200 rounded-xl p-4 shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-100/50 rounded-full blur-2xl -mr-10 -mt-10"></div>
                        <div class="flex items-center gap-2 mb-3.5 relative z-10">
                            <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                            <p class="text-[11px] font-black text-slate-900 uppercase tracking-tight">Rekening Mitra Travel</p>
                            <span class="ml-auto bg-gradient-to-r from-orange-500 to-orange-600 text-white text-[9px] font-bold px-2 py-0.5 rounded-md uppercase tracking-wider">Travel</span>
                        </div>
                        <div class="flex items-center justify-between bg-white px-3 py-3 rounded-xl border border-slate-100 shadow-sm mb-3 relative z-10">
                            <div class="flex items-center gap-3">
                                <div class="px-2.5 h-6 bg-orange-100 text-orange-700 text-[10px] font-black rounded flex items-center justify-center tracking-wider uppercase">${rekBank}</div>
                                <span class="text-sm font-extrabold text-slate-800 font-mono tracking-wider">${rekNo}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between px-1 relative z-10">
                            <span class="text-[10px] text-slate-500 font-medium truncate flex-1">a.n ${rekName}</span>
                        </div>
                    </div>
                `;
            }

            Swal.fire({
                title: '<span class="text-lg font-bold text-slate-900">Upload Bukti ' + tahapLabel + '</span>',
                html: `
                    <div class="text-left space-y-4 mt-2">
                        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-xl p-5 text-center relative overflow-hidden shadow-lg">
                            <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mb-1 relative z-10">Nominal Tagihan Ini</p>
                            <p class="text-3xl font-black text-white relative z-10 tracking-tight">Rp ${totalAmount}</p>
                        </div>
                        ${bankHtmlCard}
                        <div>
                            <label class="text-sm font-bold text-slate-700 block mb-2">Upload Bukti Transfer <span class="text-red-500">*</span></label>
                            <input type="file" id="proof-file-cicilan" accept="image/*" class="hidden">
                            <div id="upload-placeholder-cicilan" class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 hover:border-orange-400 transition cursor-pointer" onclick="document.getElementById('proof-file-cicilan').click()">
                                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-3"><i class="ph-bold ph-upload-simple text-2xl"></i></div>
                                <p class="text-xs font-bold text-slate-600">Klik untuk upload foto bukti struk</p>
                            </div>
                            <div id="upload-preview-cicilan" class="hidden relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50">
                                <img id="preview-img-cicilan" src="" class="w-full h-48 object-contain bg-black/5">
                            </div>
                        </div>
                    </div>
                `,
                didOpen: () => {
                    document.getElementById('proof-file-cicilan').addEventListener('change', function(e) {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('preview-img-cicilan').src = e.target.result;
                                document.getElementById('upload-placeholder-cicilan').classList.add('hidden');
                                document.getElementById('upload-preview-cicilan').classList.remove('hidden');
                            }
                            reader.readAsDataURL(this.files[0]);
                        }
                    });
                },
                showCancelButton: true, confirmButtonText: 'Kirim Bukti',
                preConfirm: () => {
                    const fileInput = document.getElementById('proof-file-cicilan');
                    if (!fileInput.files.length) { 
                        Swal.showValidationMessage('Mohon pilih file foto bukti transfer.'); 
                        return false; 
                    }
                    return fileInput.files[0];
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('bukti_bayar', result.value);
                    formData.append('_token', '{{ csrf_token() }}');
                    
                    Swal.fire({ title: 'Mengirim Bukti...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

                    // 🔥 TEMBAK ENDPOINT BARU YANG TADI DIBUAT DI CONTROLLER 🔥
                    fetch(`/marketplace/profil/pesanan/cicilan/${idInstallment}/upload`, {
                        method: 'POST', // Method POST murni (Dikonversi PUT via request di Laravel)
                        body: formData
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: data.message, confirmButtonColor: '#ea580c' }).then(() => window.location.reload());
                        } else {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: data.message, confirmButtonColor: '#dc2626' });
                        }
                    }).catch(e => {
                        Swal.fire('Error', 'Terjadi kesalahan sistem saat mengirim data.', 'error');
                    });
                }
            });
        }

    </script>

</body>

</html>
