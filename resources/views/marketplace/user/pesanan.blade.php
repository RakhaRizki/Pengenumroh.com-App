<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Pesanan - Pengenumroh</title>
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
                            <p class="text-xs font-bold text-slate-700">{{ $userProfile['nama'] ?? 'Jamaah' }}</p>
                            <p class="text-[10px] text-slate-500">Jamaah</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                            <img src="{{ $userProfile['avatar'] ?? 'https://ui-avatars.com/api/?name=User' }}"
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
                                <img src="{{ $userProfile['avatar'] ?? 'https://ui-avatars.com/api/?name=User' }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <h2 class="text-lg font-bold text-slate-900 line-clamp-1">
                                {{ $userProfile['nama'] ?? 'Nama User' }}</h2>
                            <p class="text-sm text-slate-500">Bergabung sejak
                                {{ $userProfile['bergabung'] ?? '2024' }} </p>
                            <div class="mt-4 text-left">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-600">Kelengkapan Data</span>
                                    <span
                                        class="font-bold text-orange-600">{{ $userProfile['kelengkapan'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="bg-orange-500 h-2 rounded-full transition-all duration-1000"
                                        style="width: {{ $userProfile['kelengkapan'] ?? 0 }}%;"></div>
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
                                <i class="ph-bold ph-user text-xl"></i>
                                Profil
                            </a>
                            <a href="{{ route('marketplace.profil.pesanan') }}"
                                class="flex items-center gap-3 px-5 py-4 bg-orange-50 text-orange-700 font-bold border-l-4 border-orange-600">
                                <i class="ph-bold ph-ticket text-xl"></i>
                                Pesanan
                            </a>
                            <a href="{{ route('marketplace.profil.wishlist') }}"
                                class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition border-l-4 border-transparent">
                                <i class="ph-bold ph-heart text-xl"></i>
                                Wishlist
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 min-h-[600px]">

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">Pesanan</h1>
                                <p class="text-slate-500 text-sm mt-1">Riwayat dan status perjalanan ibadah Anda.</p>
                            </div>
                            <div class="relative w-full md:w-64">
                                <i
                                    class="ph-bold ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                               <input type="text" id="search-booking" placeholder="Cari Kode Booking atau Nama Paket..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-1 focus:ring-orange-500 transition">
                            </div>
                        </div>

                        @php
                            $countAll = count($transactions);
                            $countUnpaid = 0;
                            $countVerif = 0;
                            $countLunas = 0;

                            foreach ($transactions as $t) {
                                $stat = strtoupper($t['status'] ?? '');
                                if ($stat == 'UNPAID') {
                                    $countUnpaid++;
                                } elseif ($stat == 'PENDING') {
                                    $countVerif++;
                                } elseif ($stat == 'SUCCESS') {
                                    $countLunas++;
                                }
                            }
                        @endphp

                        <div class="mb-6 overflow-x-auto no-scrollbar">
                            <div class="flex gap-2 min-w-max border-b border-slate-100 pb-1">
                                <button
                                    class="tab-btn active relative px-4 py-3 text-sm font-bold text-orange-600 transition-colors flex items-center gap-2"
                                    onclick="filterOrder('all', this)">
                                    Semua Pesanan <span
                                        class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countAll }}</span>
                                    <div
                                        class="tab-underline absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full">
                                    </div>
                                </button>
                                <button
                                    class="tab-btn relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-orange-600 transition-colors flex items-center gap-2"
                                    onclick="filterOrder('unpaid', this)">
                                    Menunggu Pembayaran
                                    @if ($countUnpaid > 0)
                                        <span
                                            class="bg-orange-100 text-orange-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countUnpaid }}</span>
                                    @endif
                                    <div
                                        class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full">
                                    </div>
                                </button>
                                <button id="tab-verification"
                                    class="tab-btn group relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-orange-600 transition-colors flex items-center gap-2"
                                    onclick="filterOrder('verification', this)">
                                    Verifikasi Pembayaran
                                    @if ($countVerif > 0)
                                        <span
                                            class="bg-yellow-100 text-yellow-600 text-[10px] px-2 py-0.5 rounded-full font-bold animate-pulse">{{ $countVerif }}</span>
                                    @endif
                                    <div
                                        class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all">
                                    </div>
                                </button>
                                <button
                                    class="tab-btn relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-orange-600 transition-colors flex items-center gap-2"
                                    onclick="filterOrder('upcoming', this)">
                                    Lunas
                                    @if ($countLunas > 0)
                                        <span
                                            class="bg-blue-100 text-blue-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countLunas }}</span>
                                    @endif
                                    <div
                                        class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full">
                                    </div>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-6" id="order-container">
                            @forelse($transactions as $trx)
                                @php
                                    // 1. MAPING STATUS API
                                    $statusBackend = strtoupper($trx['status'] ?? 'UNPAID');
                                    $uiStatus = 'unpaid';
                                    $uiWarna = 'orange';
                                    $uiTeks = 'Menunggu Pembayaran';

                                    if ($statusBackend == 'UNPAID') {
                                        $uiStatus = 'unpaid';
                                        $uiWarna = 'orange';
                                        $uiTeks = 'Menunggu Pembayaran';
                                    } elseif ($statusBackend == 'PENDING') {
                                        $uiStatus = 'verification';
                                        $uiWarna = 'yellow';
                                        $uiTeks = 'Verifikasi Pembayaran';
                                    } elseif ($statusBackend == 'SUCCESS') {
                                        $uiStatus = 'upcoming';
                                        $uiWarna = 'blue';
                                        $uiTeks = 'Lunas';
                                    }

                                    // 2. DATA TRANSAKSI UTAMA
                                    $invoice = $trx['transaction_no'] ?? 'TRX-XXX';

                                    // FIX ZONA WAKTU: Ubah otomatis ke zona waktu Indonesia (WIB)
                                    $tanggalTrx = isset($trx['created_at'])
                                        ? \Carbon\Carbon::parse($trx['created_at'])
                                                ->timezone('Asia/Jakarta')
                                                ->translatedFormat('d M Y, H:i') . ' WIB'
                                        : '-';

                                    // Buat jaga-jaga kalau nanti butuh tanggal lunas (dari waktu update backend)
                                    $tanggalLunas = isset($trx['updated_at'])
                                        ? \Carbon\Carbon::parse($trx['updated_at'])
                                                ->timezone('Asia/Jakarta')
                                                ->translatedFormat('d M Y, H:i') . ' WIB'
                                        : $tanggalTrx;

                                    $totalHarga = $trx['total_price'] ?? 0;

                                    // 3. DETAIL PRODUK & LOGIKA GAMBAR DINAMIS
                                    $detailUtama = $trx['details'][0] ?? [];
                                    $namaPaket = $detailUtama['product_name'] ?? 'Paket Umroh';
                                    $tglBerangkat = isset($detailUtama['departure_date'])
                                        ? date('d M Y', strtotime($detailUtama['departure_date']))
                                        : '-';

                                    // Bongkar Snapshot untuk Modal
                                    $travelSnap = json_decode($detailUtama['travel_snapshot'] ?? '{}', true);
                                    $hotelsSnap = json_decode($detailUtama['hotels_snapshot'] ?? '[]', true);
                                    $flightsSnap = json_decode($detailUtama['flights_snapshot'] ?? '[]', true);

                                    // Cari mana yg Mekkah, mana yg Madinah beserta Ratingnya
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

                                    // 4. GROUPING KAMAR (BIAR QTY DIGABUNG JADI SATU BILA KAMARNYA SAMA)
                                    $groupedRooms = [];
                                    $detailsArray = is_array($trx['details']) ? $trx['details'] : [];

                                    foreach ($detailsArray as $det) {
                                        $room = $det['room_types'] ?? 'Standar';
                                        $qty = $det['quantity'] ?? 1;
                                        $price = $det['price'] ?? 0;

                                        // Kalau kamarnya udah ada di array, tambahin qty dan harganya
                                        if (isset($groupedRooms[$room])) {
                                            $groupedRooms[$room]['qty'] += $qty;
                                            $groupedRooms[$room]['total_price'] += $price * $qty;
                                        } else {
                                            // Kalau belum ada, bikin baru
                                            $groupedRooms[$room] = [
                                                'qty' => $qty,
                                                'total_price' => $price * $qty,
                                            ];
                                        }
                                    }

                                    // 5. SIAPKAN HTML UNTUK MODAL DETAIL & INVOICE
                                    $rincianHtml = '';
                                    $invoiceTableHtml = '';

                                    foreach ($groupedRooms as $room => $data) {
                                        $qty = $data['qty'];
                                        $priceStr = number_format($data['total_price'], 0, ',', '.');

                                        // Buat HTML modal rincian (Detail Pesanan)
                                        $rincianHtml .=
                                            '<div class="flex justify-between items-center text-slate-600 mb-2">' .
                                            '<div class="flex items-center gap-2">' .
                                            '<span class="bg-slate-200 text-slate-700 text-[10px] px-1.5 py-0.5 rounded font-bold uppercase">' .
                                            $qty .
                                            'x</span>' .
                                            '<span class="font-medium">Pax ' .
                                            $room .
                                            '</span>' .
                                            '</div>' .
                                            '<span class="font-semibold text-slate-800">Rp ' .
                                            $priceStr .
                                            '</span>' .
                                            '</div>';

                                        // Buat baris tabel untuk modal Invoice
                                        $invoiceTableHtml .=
                                            '<tr><td class="py-3 px-3"><p class="text-xs font-bold text-slate-800 line-clamp-2">' .
                                            addslashes($namaPaket) .
                                            '</p><p class="text-[10px] text-slate-500 mt-0.5">Paket: ' .
                                            $room .
                                            '</p></td><td class="py-3 px-3 text-xs font-medium text-slate-600 text-center">' .
                                            $qty .
                                            '</td><td class="py-3 px-3 text-xs font-bold text-slate-800 text-right whitespace-nowrap">Rp ' .
                                            $priceStr .
                                            '</td></tr>';
                                    }

                                    // BIKIN FORMAT PESAN WHATSAPP OTOMATIS
                                    $waMessage =
                                        "Assalamu'alaikum CS pengenumroh.com. Saya ingin bertanya mengenai pesanan saya dengan Invoice *" .
                                        $invoice .
                                        '* untuk paket *' .
                                        $namaPaket .
                                        '*.';
                                    $waLinkUrl = 'https://wa.me/62811917988?text=' . rawurlencode($waMessage);

                                @endphp

                                <div class="order-card group bg-white rounded-xl border border-slate-200 overflow-hidden hover:border-{{ $uiWarna }}-300 hover:shadow-md transition-all duration-300"
                                    data-status="{{ $uiStatus }}">

                                    <div
                                        class="bg-{{ $uiStatus == 'verification' ? 'yellow-50/70' : 'slate-50' }} px-5 py-3 border-b border-{{ $uiStatus == 'verification' ? 'yellow-100' : 'slate-100' }} flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="bg-{{ $uiWarna }}-100 text-{{ $uiWarna }}-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider flex items-center gap-1">
                                                @if ($uiStatus == 'verification')
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-yellow-600 animate-pulse"></span>
                                                @elseif($uiStatus == 'upcoming')
                                                    <i class="ph-fill ph-check-circle"></i>
                                                @endif
                                                {{ $uiTeks }}
                                            </span>
                                            <span
                                                class="text-xs text-slate-400 font-medium">{{ $tanggalTrx }}</span>
                                        </div>
                                        <div class="flex items-center gap-2 text-sm text-slate-600">
                                            <span class="font-medium">Kode:</span>
                                            <span
                                                class="font-bold font-mono tracking-wide select-all text-slate-900">{{ $invoice }}</span>
                                            @if ($uiStatus == 'unpaid')
                                                <button onclick="copyToClipboard('{{ $invoice }}')"
                                                    class="text-orange-600 hover:bg-orange-50 p-1 rounded transition">
                                                    <i class="ph-bold ph-copy"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="p-4 sm:p-5 flex flex-col md:flex-row gap-5 md:gap-6">
                                        <div
                                            class="w-full md:w-36 h-40 md:h-auto flex-shrink-0 rounded-xl overflow-hidden bg-slate-200 relative shadow-sm border border-slate-100">
                                            <img src="{{ $trx['gambar_paket_final'] ?? '/assets/img/marketplace/produk-dummy.png' }}"
                                                alt="{{ $namaPaket }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                                onerror="this.src='/assets/img/marketplace/produk-dummy.png'">

                                            <div
                                                class="absolute top-2 left-2 md:hidden bg-white/90 backdrop-blur-sm text-{{ $uiWarna }}-600 text-[10px] font-bold px-2 py-1 rounded shadow-sm flex items-center gap-1">
                                                @if ($uiStatus == 'verification')
                                                    <span
                                                        class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                                @elseif($uiStatus == 'upcoming')
                                                    <i class="ph-fill ph-check-circle"></i>
                                                @endif
                                                {{ $uiTeks }}
                                            </div>
                                        </div>

                                        <div class="flex-grow flex flex-col justify-between py-1">
                                            <div class="mb-3">
                                                <h3
                                                    class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-{{ $uiWarna }}-600 transition leading-snug line-clamp-2">
                                                    {{ $namaPaket }}
                                                </h3>
                                                <div
                                                    class="flex items-center gap-2 mt-1 text-[11px] font-medium text-slate-500">
                                                    <i
                                                        class="ph-duotone ph-calendar-blank text-orange-500 text-sm"></i>
                                                    <span>Berangkat:
                                                        {{ \Carbon\Carbon::parse($detailUtama['departure_date'] ?? now())->translatedFormat('d F Y') }}</span>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2.5 mt-auto">
                                                <div class="flex items-start gap-2">
                                                    <i
                                                        class="ph-duotone ph-buildings text-orange-500 text-lg flex-shrink-0 mt-0.5"></i>
                                                    <div class="min-w-0">
                                                        <p
                                                            class="text-[10px] text-slate-400 font-medium uppercase tracking-wide leading-none">
                                                            Makkah</p>
                                                        <p class="text-xs font-semibold text-slate-700 truncate mt-0.5"
                                                            title="{{ $hotelMakkahName }}">{{ $hotelMakkahName }}
                                                            <span
                                                                class="text-yellow-400">⭐{{ $hotelMakkahRating }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-start gap-2">
                                                    <i
                                                        class="ph-duotone ph-buildings text-orange-500 text-lg flex-shrink-0 mt-0.5"></i>
                                                    <div class="min-w-0">
                                                        <p
                                                            class="text-[10px] text-slate-400 font-medium uppercase tracking-wide leading-none">
                                                            Madinah</p>
                                                        <p class="text-xs font-semibold text-slate-700 truncate mt-0.5"
                                                            title="{{ $hotelMadinahName }}">{{ $hotelMadinahName }}
                                                            <span
                                                                class="text-yellow-400">⭐{{ $hotelMadinahRating }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="flex items-start gap-2">
                                                    <i
                                                        class="ph-duotone ph-airplane-tilt text-blue-500 text-lg flex-shrink-0 mt-0.5"></i>
                                                    <div class="min-w-0">
                                                        <p
                                                            class="text-[10px] text-slate-400 font-medium uppercase tracking-wide leading-none">
                                                            Maskapai</p>
                                                        <p
                                                            class="text-xs font-semibold text-slate-700 truncate mt-0.5">
                                                            {{ $flightsSnap[0]['airline_name'] ?? 'TBA' }}</p>
                                                    </div>
                                                </div>
                                                <div class="flex items-start gap-2">
                                                    <i
                                                        class="ph-duotone ph-users-three text-slate-400 text-lg flex-shrink-0 mt-0.5"></i>
                                                    <div class="min-w-0">
                                                        <p
                                                            class="text-[10px] text-slate-400 font-medium uppercase tracking-wide leading-none">
                                                            Travel</p>
                                                        <p
                                                            class="text-xs font-semibold text-slate-600 truncate mt-0.5">
                                                            {{ $travelSnap['fullname'] ?? 'TBA' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="flex flex-col justify-end items-end md:w-48 flex-shrink-0 border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6 mt-2 md:mt-0">
                                            @if ($uiStatus != 'verification')
                                                <div class="text-right w-full mb-4">
                                                    <p
                                                        class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-0.5">
                                                        Total Tagihan</p>
                                                    <p class="text-lg md:text-xl font-extrabold text-orange-600">Rp
                                                        {{ number_format($totalHarga, 0, ',', '.') }}</p>
                                                </div>
                                            @endif

                                            <div class="w-full space-y-2 mt-auto">
                                                @if ($uiStatus == 'unpaid')
                                                    <button
                                                        onclick="openPaymentModal('{{ $trx['id'] }}', '{{ $invoice }}', '{{ number_format($totalHarga, 0, ',', '.') }}')"
                                                        class="w-full py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-[11px] sm:text-xs font-bold rounded-xl shadow-md shadow-orange-500/25 transition active:scale-95 flex items-center justify-center gap-1.5">
                                                        <i class="ph-bold ph-upload-simple text-sm"></i> Upload Bukti
                                                    </button>

                                                    <div class="grid grid-cols-2 gap-2">
                                                        <button type="button" data-tabel="{{ $invoiceTableHtml }}"
                                                            data-nama="{{ $userProfile['nama'] ?? 'Jamaah' }}"
                                                            data-email="{{ $userProfile['email'] ?? 'Belum ada email' }}"
                                                            onclick="showInvoiceModal(this, '{{ $invoice }}', '{{ number_format($totalHarga, 0, ',', '.') }}', '{{ $tanggalTrx }}', 'UNPAID')"
                                                            class="w-full py-2 border border-orange-200 bg-orange-50 hover:bg-orange-100 text-orange-700 text-[10px] sm:text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5">
                                                            <i class="ph-bold ph-receipt text-sm"></i> Invoice
                                                        </button>
                                                        <button
                                                            onclick="showOrderDetail('{{ $invoice }}', '{{ addslashes($namaPaket) }}', '{{ $tanggalTrx }}', '{{ addslashes($rincianHtml) }}', '{{ number_format($totalHarga, 0, ',', '.') }}', '{{ $trx['gambar_paket_final'] ?? '' }}', '{{ addslashes($waLinkUrl) }}')"
                                                            class="w-full py-2 border border-slate-200 hover:bg-slate-50 text-slate-600 text-[10px] sm:text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5">
                                                            Detail
                                                        </button>
                                                    </div>
                                                @elseif($uiStatus == 'verification')
                                                    <button
                                                        class="w-full py-2 bg-yellow-50 border border-yellow-200 text-yellow-600 text-xs font-bold rounded-lg cursor-not-allowed flex justify-center items-center gap-2"
                                                        disabled>
                                                        <i class="ph-bold ph-hourglass-high animate-spin-slow"></i>
                                                        Menunggu Verifikasi
                                                    </button>
                                                    <!-- TOMBOL INVOICE DI STATUS VERIFIKASI -->
                                                    <button type="button" data-tabel="{{ $invoiceTableHtml }}"
                                                        data-nama="{{ $userProfile['nama'] ?? 'Jamaah' }}"
                                                        data-email="{{ $userProfile['email'] ?? 'Belum ada email' }}"
                                                        onclick="showInvoiceModal(this, '{{ $invoice }}', '{{ number_format($totalHarga, 0, ',', '.') }}', '{{ $tanggalTrx }}', 'PENDING')"
                                                        class="w-full py-2 border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold rounded-lg transition flex items-center justify-center gap-2">
                                                        <i class="ph-bold ph-receipt"></i> Lihat Invoice
                                                    </button>
                                                    <button
                                                        onclick="showVerificationDetail('{{ $invoice }}', '{{ addslashes($namaPaket) }}', '{{ $tanggalTrx }}', '{{ addslashes($rincianHtml) }}', '{{ number_format($totalHarga, 0, ',', '.') }}', '{{ $trx['gambar_paket_final'] ?? '' }}', '{{ addslashes($waLinkUrl) }}')"
                                                        class="w-full py-2 border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold rounded-lg transition">
                                                        Detail Pesanan</button>
                                                @elseif($uiStatus == 'upcoming')
                                                    <!-- TOMBOL INVOICE DI STATUS LUNAS -->
                                                    <button type="button" data-tabel="{{ $invoiceTableHtml }}"
                                                        data-nama="{{ $userProfile['nama'] ?? 'Jamaah' }}"
                                                        data-email="{{ $userProfile['email'] ?? 'Belum ada email' }}"
                                                        onclick="showInvoiceModal(this, '{{ $invoice }}', '{{ number_format($totalHarga, 0, ',', '.') }}', '{{ $tanggalTrx }}', 'SUCCESS')"
                                                        class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-md shadow-blue-500/20 transition active:scale-95 flex items-center justify-center gap-2">
                                                        <i class="ph-bold ph-receipt"></i> Lihat Invoice
                                                    </button>
                                                    <button
                                                        onclick="showPaidOrderDetail('{{ $invoice }}', '{{ addslashes($namaPaket) }}', '{{ $tanggalTrx }}', '{{ $tanggalLunas ?? $tanggalTrx }}', '{{ addslashes($rincianHtml) }}', '{{ number_format($totalHarga, 0, ',', '.') }}', '{{ $trx['gambar_paket_final'] ?? '' }}', '{{ $trx['evidence_url'] ?? '' }}', '{{ addslashes($waLinkUrl) }}')"
                                                        class="w-full py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-600 text-[11px] sm:text-xs font-bold rounded-xl transition flex items-center justify-center gap-1.5">
                                                        Detail Pesanan</button>
                                                @endif
                                                <a href="{{ $waLinkUrl }}" target="_blank"
                                                    class="w-full py-2 bg-green-50 hover:bg-green-100 border border-green-200 text-green-700 text-[10px] font-bold rounded-lg transition flex items-center justify-center gap-1.5 mt-2">
                                                    <i class="ph-fill ph-whatsapp-logo text-sm"></i> Butuh Bantuan?
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @empty
                                <div id="empty-state"
                                    class="flex flex-col items-center justify-center py-20 text-center">
                                    <div
                                        class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <i class="ph-duotone ph-receipt text-5xl text-slate-300"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900">Belum ada pesanan</h3>
                                    <p class="text-slate-500 text-sm mt-1 mb-6 max-w-xs">Anda belum melakukan pemesanan
                                        paket apapun.</p>
                                    <a href="/marketplace/#produk"
                                        class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/30 transition">
                                        Cari Paket Umroh
                                    </a>
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
        
        // 1. Logika Filter Berdasarkan Tab Status
        // Kita simpan status aktif saat ini di variabel global agar pencarian dan tab sinkron
        let currentActiveStatus = 'all';

        function filterOrder(status, btn) {
            currentActiveStatus = status; // Simpan status yang dipilih
            
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(b => {
                b.classList.remove('active', 'text-orange-600', 'font-bold');
                b.classList.add('text-slate-500', 'font-medium');
                b.querySelector('.tab-underline').classList.add('hidden');
            });

            btn.classList.add('active', 'text-orange-600', 'font-bold');
            btn.classList.remove('text-slate-500', 'font-medium');
            btn.querySelector('.tab-underline').classList.remove('hidden');

            // Jalankan fungsi filter gabungan (Tab + Search)
            applyCombinedFilter();
        }

        // 2. Fitur Utama Pencarian Profesional (Real-time Combined Filter)
        document.getElementById('search-booking').addEventListener('input', function() {
            applyCombinedFilter();
        });

        function applyCombinedFilter() {
            const searchKeyword = document.getElementById('search-booking').value.toLowerCase().trim();
            const cards = document.querySelectorAll('.order-card');
            let visibleCount = 0;

            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status');
                
                // Ambil data teks di dalam card untuk dicocokkan
                const invoiceCode = card.querySelector('.font-mono').innerText.toLowerCase();
                const packageName = card.querySelector('h3').innerText.toLowerCase();

                // Cek kecocokan Tab Status
                const matchStatus = (currentActiveStatus === 'all' || cardStatus === currentActiveStatus);
                
                // Cek kecocokan Kata Kunci (Bisa cari berdasarkan Kode Invoice ATAU Nama Paket)
                const matchKeyword = (invoiceCode.includes(searchKeyword) || packageName.includes(searchKeyword));

                // Jika status tab COCOK dan kata kunci COCOK, tampilkan card
                if (matchStatus && matchKeyword) {
                    card.style.display = 'block';
                    // Reset animasi AOS agar halus saat muncul kembali
                    card.classList.remove('aos-animate');
                    setTimeout(() => card.classList.add('aos-animate'), 50);
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // Tampilkan empty state jika hasil filter kosong semisal data tidak ditemukan
            const emptyState = document.getElementById('empty-state');
            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                } else {
                    emptyState.classList.add('hidden');
                    emptyState.classList.remove('flex');
                }
            }
        }

    </script>

    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Filter Logic
        function filterOrder(status, btn) {
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(b => {
                b.classList.remove('active', 'text-orange-600', 'font-bold');
                b.classList.add('text-slate-500', 'font-medium');
                b.querySelector('.tab-underline').classList.add('hidden');
            });

            btn.classList.add('active', 'text-orange-600', 'font-bold');
            btn.classList.remove('text-slate-500', 'font-medium');
            btn.querySelector('.tab-underline').classList.remove('hidden');

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

            const emptyState = document.getElementById('empty-state');
            if (emptyState) {
                if (visibleCount === 0) {
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                } else {
                    emptyState.classList.add('hidden');
                    emptyState.classList.remove('flex');
                }
            }
        }

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
        function openPaymentModal(trxId, invoiceId, totalAmount) {
            Swal.fire({
                title: '<span class="text-lg font-bold text-slate-900">Upload Bukti Transfer</span>',
                html: `
            <div class="text-left space-y-4">
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <p class="text-xs text-slate-500 mb-1">Silakan transfer ke rekening berikut:</p>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-bold text-slate-800">BCA - PT Pengen Umroh</p>
                            <p class="text-lg font-mono font-bold text-blue-700 tracking-wide">883-098-7721</p>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-bold text-slate-700 block mb-2">Foto Bukti Transfer</label>
                    <input type="file" id="proof-file" accept="image/*" class="hidden">
                    <div id="upload-placeholder" class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 hover:border-orange-400 transition cursor-pointer" onclick="document.getElementById('proof-file').click()">
                        <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-3"><i class="ph-bold ph-upload-simple text-2xl"></i></div>
                        <p class="text-xs font-bold text-slate-600">Klik untuk upload foto</p>
                    </div>
                    <div id="upload-preview" class="hidden relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50">
                        <img id="preview-img" src="" class="w-full h-48 object-contain bg-black/5">
                    </div>
                </div>
            </div>
        `,
                didOpen: () => {
                    // Pas modal kebuka, kita pasang event listener manual
                    document.getElementById('proof-file').addEventListener('change', function(e) {
                        if (this.files && this.files[0]) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('preview-img').src = e.target.result;
                                document.getElementById('upload-placeholder').classList.add(
                                    'hidden');
                                document.getElementById('upload-preview').classList.remove(
                                    'hidden');
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
                        Swal.showValidationMessage('Mohon pilih file foto terlebih dahulu');
                        return false;
                    }
                    return fileInput.files[0];
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const file = result.value;
                    const formData = new FormData();
                    formData.append('bukti_bayar', file);
                    formData.append('id_transaksi', trxId);
                    formData.append('_token', '{{ csrf_token() }}');

                    // Lanjut ke proses fetch upload lu tadi...
                    // (Copy sisa kode fetch/ajax lu dari sini ke bawah)
                    sendUploadAjax(formData);
                }
            });
        }

        function sendUploadAjax(formData) {
            Swal.fire({
                title: 'Mengirim Bukti...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            fetch('{{ route('marketplace.profil.upload_bukti') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            confirmButtonColor: '#ea580c'
                        }).then(() => window.location.reload());
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message
                        });
                    }
                });
        }
    </script>

    <script>
        // --- UX FUNGSI BARU: MODAL INVOICE (DINAMIS SEMUA STATUS) ---
        function showInvoiceModal(btnElement, invoiceNo, totalAmount, dateStr, statusTrx) {
            const tableHtml = btnElement.getAttribute('data-tabel');
            const userName = btnElement.getAttribute('data-nama');
            const userEmail = btnElement.getAttribute('data-email');

            // Logika warna & teks badge sesuai status
            let badgeClass = 'bg-slate-100 text-slate-700 print:border-slate-500';
            let badgeText = 'TIDAK DIKETAHUI';

            if (statusTrx === 'UNPAID') {
                badgeClass = 'bg-orange-100 text-orange-700 print:border-orange-500';
                badgeText = 'MENUNGGU PEMBAYARAN';
            } else if (statusTrx === 'PENDING') {
                badgeClass = 'bg-yellow-100 text-yellow-700 print:border-yellow-500';
                badgeText = 'PROSES VERIFIKASI';
            } else if (statusTrx === 'SUCCESS') {
                badgeClass = 'bg-blue-100 text-blue-700 print:border-blue-500';
                badgeText = 'LUNAS / BERHASIL';
            }

            Swal.fire({
                title: '',
                html: `
            <div class="text-left font-sans print:p-0">
                <!-- Header Invoice -->
                <div class="flex justify-between items-start mb-6 border-b border-slate-200 pb-4">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">INVOICE</h2>
                        <p class="text-sm font-bold text-slate-800 mt-1 uppercase">#INV-${invoiceNo.replace('TRX-', '')}</p>
                        <p class="text-[10px] text-slate-500 mt-0.5">Tanggal: ${dateStr}</p>
                    </div>
                    <div class="text-right flex flex-col items-end">
                        <img src="/assets/img/marketplace/logo.png" alt="Logo" class="h-8 w-auto mb-2 opacity-90">
                        <span class="${badgeClass} text-[10px] font-bold px-2.5 py-1 rounded uppercase tracking-wider print:border">${badgeText}</span>
                    </div>
                </div>

                <!-- Info Detail -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Ditagihkan Kepada:</p>
                        <p class="text-sm font-bold text-slate-800">${userName}</p>
                        <p class="text-xs text-slate-500">${userEmail}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Metode Pembayaran:</p>
                        <p class="text-xs font-bold text-slate-800">Bank Central Asia (BCA)</p>
                        <p class="text-sm text-slate-800 font-mono font-bold my-0.5">713-172-0452</p>
                        <p class="text-[10px] text-slate-500">PT. Kolaborasi Para Sahabat</p>
                    </div>
                </div>

                <!-- Tabel Item -->
                <div class="overflow-hidden rounded-xl border border-slate-200 mb-6">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="py-2.5 px-3 text-[10px] font-bold text-slate-500 uppercase">Nama Produk</th>
                                <th class="py-2.5 px-3 text-[10px] font-bold text-slate-500 uppercase text-center">Qty</th>
                                <th class="py-2.5 px-3 text-[10px] font-bold text-slate-500 uppercase text-right">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 px-3">
                            ${tableHtml}
                        </tbody>
                    </table>
                </div>

                <!-- Total -->
                <div class="flex justify-end items-center mb-8 border-b border-slate-100 pb-6">
                    <div class="text-right w-1/2">
                        <p class="text-xs font-bold text-slate-500 uppercase mb-1">Total Akhir</p>
                        <p class="text-2xl font-black text-orange-600">Rp ${totalAmount}</p>
                    </div>
                </div>

                <!-- Tombol Action -->
                <div class="flex gap-3 print:hidden">
                    <button onclick="window.print()" class="w-full py-2.5 bg-slate-50 border border-slate-200 hover:bg-slate-100 text-slate-700 text-sm font-bold rounded-xl transition flex items-center justify-center gap-2">
                        <i class="ph-bold ph-printer"></i> Cetak Invoice
                    </button>
                    <button onclick="Swal.close()" class="w-full py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/20 transition flex items-center justify-center gap-2">
                        Tutup
                    </button>
                </div>
            </div>
        `,
                showConfirmButton: false,
                showCloseButton: false,
                width: '550px',
                customClass: {
                    popup: 'rounded-3xl p-6 sm:p-8'
                }
            });
        }
    </script>

    <script>
        // --- 2. MODAL DETAIL STATUS: MENUNGGU PEMBAYARAN ---
        function showOrderDetail(invoiceId, productName, dateStr, roomHtml, totalStr, imageUrl, waUrl) {
            Swal.fire({
                title: '',
                html: `
                    <div class="text-left">
                        <div class="flex justify-between items-start mb-6 border-b border-slate-100 pb-4 mt-10">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">No. Invoice</p>
                                <p class="text-lg font-mono font-bold text-slate-900 tracking-wide select-all">${invoiceId}</p>
                            </div>
                            <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                                Menunggu Pembayaran
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
                                    <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-orange-500 ring-4 ring-white animate-pulse"></div>
                                    <p class="text-xs font-bold text-orange-600">Menunggu Pembayaran</p>
                                    <p class="text-[10px] text-slate-500">Mohon segera lakukan transfer.</p>
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
</body>

</html>
