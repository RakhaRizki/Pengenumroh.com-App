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
                            <p class="text-sm text-slate-500">Bergabung sejak {{ $userProfile['bergabung'] ?? '2024' }}
                            </p>

                            <div class="mt-4 text-left">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-600">Kelengkapan Data</span>
                                    <!-- 2. Angka persentase jadi dinamis -->
                                    <span
                                        class="font-bold text-orange-600">{{ $userProfile['kelengkapan'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <!-- 3. Panjang bar pakai inline CSS (style="width: ...%") biar bisa baca angka dari Laravel -->
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
                                <i class="ph-bold ph-user text-xl"></i> Profil
                            </a>

                            <a href="{{ route('marketplace.profil.pesanan') }}"
                                class="flex items-center gap-3 px-5 py-4 bg-orange-50 text-orange-700 font-bold border-l-4 border-orange-600">
                                <i class="ph-bold ph-ticket text-xl"></i> Pesanan
                            </a>

                            <a href="{{ route('marketplace.profil.wishlist') }}"
                                class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition border-l-4 border-transparent">
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
                <h1 class="text-2xl font-bold text-slate-900">Pesanan</h1>
                <p class="text-slate-500 text-sm mt-1">Riwayat dan status perjalanan ibadah Anda.</p>
            </div>
            <div class="relative w-full md:w-64">
                <i class="ph-bold ph-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Cari Kode Booking..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:border-orange-500 focus:bg-white focus:ring-1 focus:ring-orange-500 transition">
            </div>
        </div>
        
           <!-- LOGIKA PINTAR: HITUNG JUMLAH PESANAN PER STATUS -->
        @php
            $countAll = count($transactions);
            $countUnpaid = 0;
            $countVerif = 0;
            $countLunas = 0;

            foreach($transactions as $t) {
                $stat = strtoupper($t['status'] ?? '');
                if ($stat == 'UNPAID') $countUnpaid++;
                elseif ($stat == 'PENDING') $countVerif++;
                elseif ($stat == 'SUCCESS') $countLunas++;
            }
        @endphp

        <!-- BAGIAN TAB FILTER -->
        <div class="mb-6 overflow-x-auto no-scrollbar">
            <div class="flex gap-2 min-w-max border-b border-slate-100 pb-1">
                <button class="tab-btn active relative px-4 py-3 text-sm font-bold text-orange-600 transition-colors flex items-center gap-2" onclick="filterOrder('all', this)"> 
                    Semua Pesanan 
                    <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countAll }}</span>
                    <div class="tab-underline absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full"></div>
                </button>
                <button class="tab-btn relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-orange-600 transition-colors flex items-center gap-2" onclick="filterOrder('unpaid', this)"> 
                    Menunggu Pembayaran 
                    @if($countUnpaid > 0)
                        <span class="bg-orange-100 text-orange-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countUnpaid }}</span>
                    @endif
                    <div class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full"></div>
                </button>
                <button id="tab-verification" class="tab-btn group relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-orange-600 transition-colors flex items-center gap-2" onclick="filterOrder('verification', this)"> 
                    Verifikasi Pembayaran 
                    @if($countVerif > 0)
                        <span class="bg-yellow-100 text-yellow-600 text-[10px] px-2 py-0.5 rounded-full font-bold animate-pulse">{{ $countVerif }}</span>
                    @endif
                    <div class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full transition-all"></div>
                </button>
                <button class="tab-btn relative px-4 py-3 text-sm font-medium text-slate-500 hover:text-orange-600 transition-colors flex items-center gap-2" onclick="filterOrder('upcoming', this)"> 
                    Lunas 
                    @if($countLunas > 0)
                        <span class="bg-blue-100 text-blue-600 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $countLunas }}</span>
                    @endif
                    <div class="tab-underline hidden absolute bottom-0 left-0 w-full h-0.5 bg-orange-600 rounded-t-full"></div>
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
                        $uiStatus = 'unpaid'; $uiWarna = 'orange'; $uiTeks = 'Menunggu Pembayaran';
                    } elseif ($statusBackend == 'PENDING') {
                        $uiStatus = 'verification'; $uiWarna = 'yellow'; $uiTeks = 'Verifikasi Pembayaran';
                    } elseif ($statusBackend == 'SUCCESS') {
                        $uiStatus = 'upcoming'; $uiWarna = 'blue'; $uiTeks = 'Lunas';
                    }

                    // 2. DATA TRANSAKSI UTAMA
                    $invoice = $trx['transaction_no'] ?? 'TRX-XXX';
                    $tanggalTrx = isset($trx['created_at']) ? date('d M Y, H:i', strtotime($trx['created_at'])) : '-';
                    $totalHarga = $trx['total_price'] ?? 0;

                    // 3. DETAIL PRODUK
                    $detailUtama = $trx['details'][0] ?? [];
                    $namaPaket = $detailUtama['product_name'] ?? 'Paket Umroh';
                    $tglBerangkat = isset($detailUtama['departure_date']) ? date('d M Y', strtotime($detailUtama['departure_date'])) : '-';

                    // Bongkar Snapshot untuk Modal
                    $travelSnap = json_decode($detailUtama['travel_snapshot'] ?? '{}', true);
                    $hotelsSnap = json_decode($detailUtama['hotels_snapshot'] ?? '[]', true);
                    $flightsSnap = json_decode($detailUtama['flights_snapshot'] ?? '[]', true);

                    // Cari mana yg Mekkah, mana yg Madinah
                    $hotelMekkah = '-'; $hotelMadinah = '-';
                    foreach($hotelsSnap as $htl) {
                        if(strtolower($htl['city'] ?? '') == 'mekkah') {
                            $hotelMekkah = $htl['name'];
                        }
                        if(strtolower($htl['city'] ?? '') == 'madinah') {
                            $hotelMadinah = $htl['name'];
                        }
                    }

                    // Siapkan string Rincian Kamar untuk dikirim ke Javascript
                    $rincianHtml = '';
                    foreach ($trx['details'] as $det) {
                        $rincianHtml .= '<div class="flex justify-between items-center text-slate-600 mb-2">' .
                                            '<div class="flex items-center gap-2">' .
                                                '<span class="bg-slate-200 text-slate-700 text-[10px] px-1.5 py-0.5 rounded font-bold uppercase">1x</span>' .
                                                '<span class="font-medium">Pax ' . $det['room_types'] . '</span>' .
                                            '</div>' .
                                            '<span class="font-semibold text-slate-800">Rp ' . number_format($det['price'], 0, ',', '.') . '</span>' .
                                        '</div>';
                    }
                @endphp

                <!-- CARD PESANAN DINAMIS -->
                <div class="order-card group bg-white rounded-xl border border-slate-200 overflow-hidden hover:border-{{ $uiWarna }}-300 hover:shadow-md transition-all duration-300" data-status="{{ $uiStatus }}">
                    <div class="bg-{{ $uiStatus == 'verification' ? 'yellow-50/70' : 'slate-50' }} px-5 py-3 border-b border-{{ $uiStatus == 'verification' ? 'yellow-100' : 'slate-100' }} flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <span class="bg-{{ $uiWarna }}-100 text-{{ $uiWarna }}-700 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase tracking-wider flex items-center gap-1">
                                @if ($uiStatus == 'verification')
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-600 animate-pulse"></span>
                                @elseif($uiStatus == 'upcoming')
                                    <i class="ph-fill ph-check-circle"></i>
                                @endif
                                {{ $uiTeks }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">{{ $tanggalTrx }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-600">
                            <span class="font-medium">Kode:</span>
                            <span class="font-bold font-mono tracking-wide select-all text-slate-900">{{ $invoice }}</span>
                            @if ($uiStatus == 'unpaid')
                                <button onclick="copyToClipboard('{{ $invoice }}')" class="text-orange-600 hover:bg-orange-50 p-1 rounded transition">
                                    <i class="ph-bold ph-copy"></i>
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="p-5 flex flex-col md:flex-row gap-6">
                        <div class="w-full md:w-28 h-28 flex-shrink-0 rounded-lg overflow-hidden bg-slate-200 relative">
                            <img src="/assets/img/marketplace/produk-dummy.png" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        </div>
                        <div class="flex-grow">
                            <h3 class="text-base font-bold text-slate-900 group-hover:text-{{ $uiWarna }}-600 transition mb-3">
                                {{ $namaPaket }}
                            </h3>
                            <div class="space-y-2">
                                <div class="flex items-center gap-3">
                                    <i class="ph-duotone ph-buildings text-orange-500 text-lg flex-shrink-0"></i>
                                    <p class="text-sm font-semibold text-slate-600 truncate">
                                        Mekkah: {{ $hotelMekkah }} • Madinah: {{ $hotelMadinah }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="ph-duotone ph-airplane-tilt text-blue-500 text-lg flex-shrink-0"></i>
                                    <p class="text-sm font-semibold text-slate-600 truncate">
                                        {{ $flightsSnap[0]['airline_name'] ?? 'Maskapai' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <i class="ph-duotone ph-calendar-blank text-green-500 text-lg flex-shrink-0"></i>
                                    <p class="text-sm font-semibold text-slate-600">
                                        {{ $tglBerangkat }} • {{ $travelSnap['fullname'] ?? 'Biro Travel' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col justify-between items-end min-w-[160px] border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-6">
                            @if ($uiStatus != 'verification')
                                <div class="text-right w-full mb-4">
                                    <p class="text-xs text-slate-400 mb-1">Total Tagihan</p>
                                    <p class="text-lg font-extrabold text-slate-900">Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
                                </div>
                            @endif

                            <div class="w-full space-y-2">
                                @if ($uiStatus == 'unpaid')
                                    <button onclick="openPaymentModal('{{ $invoice }}', '{{ number_format($totalHarga, 0, ',', '.') }}')" class="w-full py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-orange-500/20 transition active:scale-95 flex items-center justify-center gap-2">
                                        <i class="ph-bold ph-ticket"></i> Bayar
                                    </button>
                                    <button onclick="showOrderDetail('{{ $invoice }}', '{{ $namaPaket }}', '{{ $tanggalTrx }}', '{{ $rincianHtml }}', '{{ number_format($totalHarga, 0, ',', '.') }}')" class="w-full py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold rounded-xl transition flex items-center justify-center gap-2"> 
                                        Detail 
                                    </button>
                                
                                @elseif($uiStatus == 'verification')
                                    <button class="w-full py-2 bg-slate-50 border border-slate-200 text-slate-500 text-xs font-bold rounded-lg cursor-not-allowed" disabled> 
                                        Menunggu Konfirmasi 
                                    </button>
                                    <button onclick="showVerificationDetail('{{ $invoice }}', '{{ $namaPaket }}', '{{ $tanggalTrx }}', '{{ $rincianHtml }}', '{{ number_format($totalHarga, 0, ',', '.') }}')" class="w-full py-2 border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold rounded-lg transition"> 
                                        Detail 
                                    </button>
                                
                                @elseif($uiStatus == 'upcoming') <!-- HAPUS COMPLETED DI SINI JUGA -->
                                    <button onclick="showReceiptModal('{{ $invoice }}', '{{ $trx['evidence_url'] ?? '' }}')" class="w-full py-2 px-2 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold rounded-xl shadow-lg shadow-emerald-500/20 transition active:scale-95 flex items-center justify-center gap-1.5 whitespace-nowrap">
                                        <i class="ph-bold ph-file-pdf text-sm"></i> <span>Bukti Pembayaran</span>
                                    </button>
                                    <button onclick="showPaidOrderDetail('{{ $invoice }}', '{{ $namaPaket }}', '{{ $tanggalTrx }}', '{{ $rincianHtml }}', '{{ number_format($totalHarga, 0, ',', '.') }}')" class="w-full py-2.5 border border-slate-200 hover:bg-slate-50 text-slate-600 text-xs font-bold rounded-xl transition flex items-center justify-center gap-2"> 
                                        Detail 
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- EMPTY STATE JIKA TIDAK ADA PESANAN -->
                <div id="empty-state" class="flex flex-col items-center justify-center py-20 text-center">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                        <i class="ph-duotone ph-receipt text-5xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Belum ada pesanan</h3>
                    <p class="text-slate-500 text-sm mt-1 mb-6 max-w-xs">Anda belum melakukan pemesanan paket apapun.</p>
                    <a href="/marketplace/#produk" class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/30 transition"> 
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
        AOS.init({
            duration: 800,
            once: true
        });

       // Filter Logic
        function filterOrder(status, btn) {
            // 1. Update Tab Style
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(b => {
                b.classList.remove('active', 'text-orange-600', 'font-bold');
                b.classList.add('text-slate-500', 'font-medium');
                // PERBAIKAN: Gunakan class .tab-underline biar nggak bentrok sama angka notifikasi
                b.querySelector('.tab-underline').classList.add('hidden');
            });

            btn.classList.add('active', 'text-orange-600', 'font-bold');
            btn.classList.remove('text-slate-500', 'font-medium');
            btn.querySelector('.tab-underline').classList.remove('hidden');

            // 2. Filter Cards
            const cards = document.querySelectorAll('.order-card');
            let visibleCount = 0;
            
            cards.forEach(card => {
                if (status === 'all' || card.getAttribute('data-status') === status) {
                    card.style.display = 'block';
                    // Re-trigger animation
                    card.classList.remove('aos-animate');
                    setTimeout(() => card.classList.add('aos-animate'), 50);
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // 3. Show Empty State if no cards visible
            const emptyState = document.getElementById('empty-state');
            if (visibleCount === 0) {
                emptyState.classList.remove('hidden');
                emptyState.classList.add('flex');
            } else {
                emptyState.classList.add('hidden');
                emptyState.classList.remove('flex');
            }
        }

        // Copy Clipboard Function
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

        // --- UX FUNCTION: Logout Confirmation ---
        function confirmLogout() {
            Swal.fire({
                title: 'Keluar dari Akun?',
                text: "Anda harus masuk kembali untuk mengakses Profil & Pesanan.",
                icon: 'warning',
                iconColor: '#dc2626',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Keluar Akun',
                cancelButtonText: 'Batal',
                reverseButtons: true
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
    </script>

    <script>
        // --- 1. MODAL UPLOAD BUKTI TRANSFER ---
        function openPaymentModal(invoiceId, totalAmount) {
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
                            <button onclick="navigator.clipboard.writeText('8830987721')" class="text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-100 transition" title="Salin">
                                <i class="ph-bold ph-copy text-xl"></i>
                            </button>
                        </div>
                        <div class="mt-2 pt-2 border-t border-blue-200/60 flex justify-between items-center">
                            <span class="text-xs text-slate-500">Total Tagihan:</span>
                            <span class="text-sm font-bold text-orange-600">Rp ${totalAmount}</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-slate-700 block mb-2">Foto Bukti Transfer</label>
                        <div class="relative w-full">
                            <input type="file" id="proof-file" accept="image/*" class="hidden" onchange="handleFileSelect(this)">
                            <div id="upload-placeholder" class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 hover:border-orange-400 transition cursor-pointer group" onclick="document.getElementById('proof-file').click()">
                                <div class="w-12 h-12 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                                    <i class="ph-bold ph-upload-simple text-2xl"></i>
                                </div>
                                <p class="text-xs font-bold text-slate-600">Klik untuk upload foto</p>
                                <p class="text-[10px] text-slate-400 mt-1">JPG, PNG atau PDF (Max. 2MB)</p>
                            </div>
                            <div id="upload-preview" class="hidden relative rounded-xl overflow-hidden border border-slate-200 bg-slate-50">
                                <img id="preview-img" src="" class="w-full h-48 object-contain bg-black/5">
                                <button type="button" onclick="resetFile()" class="absolute top-2 right-2 bg-white/90 text-red-500 p-2 rounded-full shadow-md hover:bg-red-50 transition">
                                    <i class="ph-bold ph-trash"></i>
                                </button>
                                <div class="p-2 bg-white border-t border-slate-100">
                                    <p id="filename" class="text-xs font-medium text-slate-700 truncate text-center"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `,
                showCancelButton: true,
                confirmButtonText: 'Kirim Bukti',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#ea580c',
                cancelButtonColor: '#64748b',
                focusConfirm: false,
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-2xl w-full max-w-md',
                    actions: 'gap-3',
                    confirmButton: 'w-full rounded-xl py-3 text-sm font-bold shadow-lg shadow-orange-500/20',
                    cancelButton: 'w-full rounded-xl py-3 text-sm font-bold border border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                },
                preConfirm: () => {
                    const fileInput = document.getElementById('proof-file');
                    if (!fileInput.files.length) {
                        Swal.showValidationMessage('Mohon upload bukti transfer terlebih dahulu');
                        return false;
                    }
                    return fileInput.files[0];
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Mengirim Bukti...',
                        html: 'Mohon tunggu, sedang memverifikasi.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    }).then(() => {
                        return Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Terkirim!',
                            text: 'Pembayaran Anda sedang kami verifikasi.',
                            confirmButtonColor: '#ea580c',
                            confirmButtonText: 'Lihat Status Pesanan'
                        });
                    }).then(() => {
                        const verifTab = document.getElementById('tab-verification');
                        if (verifTab) {
                            filterOrder('verification', verifTab);
                            document.querySelector('.bg-white').scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                    });
                }
            });
        }

        // File Preview Logic
        function handleFileSelect(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('filename').textContent = input.files[0].name;
                    document.getElementById('upload-placeholder').classList.add('hidden');
                    document.getElementById('upload-preview').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function resetFile() {
            document.getElementById('proof-file').value = '';
            document.getElementById('upload-preview').classList.add('hidden');
            document.getElementById('upload-placeholder').classList.remove('hidden');
        }
    </script>

    <script>
        // --- 2. MODAL DETAIL STATUS: MENUNGGU PEMBAYARAN ---
        function showOrderDetail(invoiceId, productName, dateStr, roomHtml, totalStr) {
            Swal.fire({
                title: '',
                html: `
            <div class="text-left">
                <div class="flex justify-between items-start mb-6 border-b border-slate-100 pb-4 mt-10">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">No. Invoice</p>
                        <p class="text-lg font-mono font-bold text-slate-900 tracking-wide select-all">${invoiceId}</p>
                    </div>
                    <span class="bg-orange-100 text-orange-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider"> Menunggu Pembayaran </span>
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
                    <p class="text-xs font-bold text-slate-900 mb-2">${productName}</p>
                    <div class="space-y-3 text-xs border-t border-slate-200 pt-3">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rincian Kamar</p>
                        <div class="space-y-2">
                            ${roomHtml}
                        </div>
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

        // --- 3. MODAL DETAIL STATUS: VERIFIKASI ---
        function showVerificationDetail(invoiceId, productName, dateStr, roomHtml, totalStr) {
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
                    <p class="text-xs font-bold text-slate-900 mb-2">${productName}</p>
                    <div class="space-y-3 text-xs border-t border-slate-200 pt-3">
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

        // --- 4. MODAL DETAIL STATUS: LUNAS ---
        function showPaidOrderDetail(invoiceId, productName, dateStr, roomHtml, totalStr) {
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
                            <div class="absolute -left-[21px] top-1 w-3 h-3 rounded-full bg-emerald-600 ring-4 ring-white animate-pulse"></div>
                            <p class="text-xs font-bold text-emerald-600">Bukti Bayar Tersedia</p>
                            <p class="text-[10px] text-slate-500">Kwitansi resmi Anda telah diterbitkan.</p>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 mb-6 border border-slate-100 shadow-sm">
                    <p class="text-xs font-bold text-slate-900 mb-2">${productName}</p>
                    <div class="space-y-3 text-xs border-t border-slate-200 pt-3">
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
                    <button onclick="Swal.close()" class="w-full py-3 text-slate-500 text-sm font-bold hover:text-slate-700"> Tutup </button>
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
        function downloadAction() {
            const btn = document.querySelector('.swal2-html-container button');
            btn.innerHTML = '<i class="ph-bold ph-spinner animate-spin"></i> Memproses...';
            btn.classList.add('opacity-75', 'cursor-not-allowed');
            setTimeout(() => {
                Swal.close();
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                Toast.fire({
                    icon: 'success',
                    title: 'Bukti pembayaran berhasil disimpan'
                });
            }, 1500);
        }
    </script>

</body>

</html>
