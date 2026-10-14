<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Wishlist - Pengenumroh</title>
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

        @keyframes move-stripes {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 40px 0;
            }
        }

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
            background-color: #ff782e;
            background-image: linear-gradient(45deg,
                    rgba(255, 255, 255, 0.4) 25%, transparent 25%, transparent 50%,
                    rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.4) 75%,
                    transparent 75%, transparent);
            background-size: 40px 40px;
            animation: move-stripes 0.8s linear infinite, glow-pulse 2s ease-in-out infinite;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

    {{-- Form Logout Aman --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <nav class="fixed w-full z-50 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('marketplace.beranda') }}" class="flex items-center gap-2 group">
                    <img src="/assets/img/marketplace/logo.png" alt="Logo PengenUmroh"
                        class="h-10 w-auto object-contain">
                </a>

                <div class="hidden lg:flex items-center gap-4">
                    <a href="{{ route('marketplace.beranda') }}"
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
                    <a href="{{ route('marketplace.beranda') }}" class="text-slate-700 hover:text-orange-600">
                        <i class="ph-bold ph-house text-2xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-28 pb-8 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                {{-- SIDEBAR --}}
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
                                    <span class="font-bold text-orange-600">{{ $userProfile['kelengkapan'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <!-- 3. Panjang bar pakai inline CSS (style="width: ...%") biar bisa baca angka dari Laravel -->
                                    <div class="bg-orange-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $userProfile['kelengkapan'] ?? 0 }}%;"></div>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1 italic">*Lengkapi data untuk kemudahan Umroh.</p>
                            </div>

                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <nav class="flex flex-col">
                            <a href="{{ route('marketplace.profil.index') }}"
                                class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-bold transition border-l-4 border-transparent">
                                <i class="ph-bold ph-user text-xl"></i> Profil
                            </a>
                            <a href="{{ route('marketplace.profil.pesanan') }}"
                                class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-bold transition border-l-4 border-transparent">
                                <i class="ph-bold ph-ticket text-xl"></i> Pesanan
                            </a>
                            <a href="{{ route('marketplace.profil.wishlist') }}"
                                class="flex items-center gap-3 px-5 py-4 bg-orange-50 text-orange-700 font-bold border-l-4 border-orange-600">
                                <i class="ph-bold ph-heart text-xl"></i> Wishlist
                            </a>
                        </nav>
                        {{-- <div class="mt-auto border-t border-slate-100 p-2 bg-slate-50">
                            <button onclick="confirmLogout()"
                                class="flex w-full items-center justify-center gap-2 px-5 py-3 text-red-600 hover:bg-red-100/50 hover:text-red-700 font-bold transition rounded-xl text-sm border border-transparent hover:border-red-100">
                                <i class="ph-bold ph-sign-out text-lg"></i> Keluar Akun
                            </button>
                        </div> --}}
                    </div>
                </div>

                {{-- KONTEN UTAMA --}}
                <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8 min-h-[600px]">

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">Wishlist</h1>
                                <p class="text-slate-500 text-sm mt-1">Paket impian yang Anda simpan.</p>
                            </div>

                            {{-- Counter Dinamis --}}
                            <div class="flex items-center gap-4">
                                <span id="wishlist-count"
                                    class="bg-orange-50 text-orange-600 font-bold px-4 py-2 rounded-xl text-sm border border-orange-100 w-max">
                                    {{ count($wishlistData ?? []) }} Paket Disimpan
                                </span>
                            </div>
                        </div>

                        {{-- CONTAINER WISHLIST --}}
                        @if (isset($wishlistData) && count($wishlistData) > 0)
                            <!-- 👇 Grid diubah jadi 2 kolom di mobile biar mirip beranda 👇 -->
                            <div id="wishlist-container" class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
                                @foreach ($wishlistData as $row)
                                    {{-- MAPPING DATA API --}}
                                    @php
                                        $item = isset($row['product']) ? $row['product'] : $row;
                                        $idProduk = $item['id'] ?? $loop->index;
                                        $nama = $item['nama_produk'] ?? 'Nama Paket Umroh';
                                        $gambar = !empty($item['thumbnail_url']) ? 'https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/' . rawurlencode($item['thumbnail_url']) : 'https://images.unsplash.com/photo-1591604129939-f1efa4d9f7fa?w=600&q=80';
                                        
                                        $hotelMakkah = $item['hotels'][0]['name'] ?? '-';
                                        $hotelMadinah = $item['hotels'][1]['name'] ?? '-';
                                        $maskapai = $item['flights'][0]['airline_name'] ?? '-';
                                        $tglKeberangkatan = !empty($item['tgl_keberangkatan']) ? \Carbon\Carbon::parse($item['tgl_keberangkatan'])->translatedFormat('d M Y') : '-';
                                        
                                        $pricesData = is_string($item['prices'] ?? null) ? json_decode($item['prices'], true) : ($item['prices'] ?? []);
                                        $harga = $pricesData[0]['harga'] ?? ($pricesData[0]['price'] ?? ($item['price'] ?? 0));
                                        
                                        $kuotaDariPrices = collect($pricesData)->sum('quota');
                                        if ($kuotaDariPrices > 0) {
                                            $kuota = $kuotaDariPrices;
                                        } else {
                                            $kuota = intval($item['total_quota'] ?? $item['quota'] ?? $item['stok'] ?? $item['sisa_seat'] ?? 0);
                                        }
                                        
                                        $maxSeat = $kuota > 45 ? 100 : 45;
                                        $persenSeat = $maxSeat > 0 ? round(($kuota / $maxSeat) * 100) : 0;
                                        if ($persenSeat > 100) $persenSeat = 100;
                                    @endphp

                                    <div class="wishlist-item product-card group bg-white rounded-xl md:rounded-2xl border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col h-full hover:-translate-y-1" id="wishlist-{{ $idProduk }}">
                                        
                                        <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                                            <img src="{{ $gambar }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700 cursor-pointer" alt="{{ $nama }}" onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($nama) }}&background=F97316&color=fff'" onclick="openBerandaLightbox(this.src); event.stopPropagation();" title="Perbesar Gambar">
                                            
                                            <!-- Indikator Zoom Gambar -->
                                            <div class="absolute bottom-2 left-2 md:bottom-3 md:left-3 z-10 flex gap-2 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300 pointer-events-none">
                                                <div class="px-2 py-1 md:px-2.5 md:py-1.5 rounded-lg bg-black/40 backdrop-blur-md flex items-center gap-1.5 text-white/90 shadow-sm border border-white/20">
                                                    <i class="ph-bold ph-arrows-out-simple text-[10px] md:text-xs"></i>
                                                    <span class="text-[8px] md:text-[10px] font-bold uppercase tracking-wider">Perbesar</span>
                                                </div>
                                            </div>

                                            <!-- Tombol Hapus Wishlist -->
                                            <div class="absolute top-2 right-2 md:top-3 md:right-3 z-10 flex gap-1.5 md:gap-2">
                                                <button onclick="removeItem(this, '{{ $idProduk }}'); event.stopPropagation();" class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-white/90 backdrop-blur-md text-red-500 shadow-md flex items-center justify-center hover:bg-red-50 hover:text-red-600 transition border border-white/30" title="Hapus dari Wishlist">
                                                    <i class="ph-fill ph-heart text-xs md:text-lg"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="p-3 md:p-5 flex flex-col flex-grow cursor-pointer hover:bg-slate-50/50 transition-colors" onclick="window.location.href='{{ route('marketplace.produk.detail', $idProduk) }}'" title="Lihat Detail Paket">
                                            
                                            <div class="min-h-[2.5rem] md:min-h-[3.5rem] mb-1 md:mb-0">
                                                <h3 class="text-[11px] sm:text-xs md:text-base font-bold text-slate-900 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                                    {{ $nama }}
                                                </h3>
                                            </div>
                                            
                                            <div class="flex-grow space-y-1.5 md:space-y-3 mb-4 md:mb-6 mt-1">
                                                <div class="flex items-center gap-1.5 md:gap-3">
                                                    <i class="ph-duotone ph-buildings text-orange-500 text-sm md:text-xl flex-shrink-0"></i>
                                                    <p class="text-[9px] md:text-sm font-semibold text-slate-600 truncate">Makkah: {{ $hotelMakkah }}</p>
                                                </div>
                                                <div class="flex items-center gap-1.5 md:gap-3">
                                                    <i class="ph-duotone ph-buildings text-orange-500 text-sm md:text-xl flex-shrink-0"></i>
                                                    <p class="text-[9px] md:text-sm font-semibold text-slate-600 truncate">Madinah: {{ $hotelMadinah }}</p>
                                                </div>
                                                <div class="flex items-center gap-1.5 md:gap-3">
                                                    <i class="ph-duotone ph-airplane-tilt text-blue-500 text-sm md:text-xl flex-shrink-0"></i>
                                                    <p class="text-[9px] md:text-sm font-semibold text-slate-600 truncate">{{ $maskapai }}</p>
                                                </div>
                                                <div class="flex items-center gap-1.5 md:gap-3">
                                                    <i class="ph-duotone ph-calendar-blank text-green-500 text-sm md:text-xl flex-shrink-0"></i>
                                                    <p class="text-[9px] md:text-sm font-semibold text-slate-600">{{ $tglKeberangkatan }}</p>
                                                </div>

                                                <div class="pt-1.5 md:pt-2">
                                                    <div class="flex justify-between text-[8px] md:text-[11px] mb-1 font-bold">
                                                        <span class="text-slate-500 uppercase tracking-tighter">Seat Sisa</span>
                                                        <span class="text-[#ff782e] font-black">{{ $kuota }} Seat</span>
                                                    </div>
                                                    <div class="w-full bg-slate-200 h-2 md:h-3.5 rounded-full overflow-hidden shadow-inner p-[1px]">
                                                        <div class="progress-orange-animated h-full rounded-full transition-all duration-700" style="width: {{ $persenSeat }}%; min-width: 5%;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="pt-2 md:pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                                <div>
                                                    <p class="text-[8px] md:text-[10px] text-slate-400 uppercase font-black tracking-wider">Mulai</p>
                                                    <p class="text-xs sm:text-sm md:text-xl font-black text-slate-900">
                                                        @if ($harga > 0)
                                                            Rp {{ number_format($harga / 1000000, 1, ',', '.') }} <span class="text-[8px] md:text-sm">Jt</span>
                                                        @else
                                                            <span class="text-[10px] md:text-sm">Hubungi Kami</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="w-7 h-7 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-orange-600 transition shadow-lg hover:shadow-orange-500/30 flex-shrink-0">
                                                    <i class="ph-bold ph-arrow-right text-xs md:text-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Tampilan Kosong --}}
                        <div id="empty-state"
                            class="{{ !isset($wishlistData) || count($wishlistData) == 0 ? 'flex' : 'hidden' }} flex-col items-center justify-center py-20 text-center h-full">
                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                <i class="ph-duotone ph-heart-break text-5xl text-slate-300"></i>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">Wishlist Kosong</h3>
                            <p class="text-slate-500 text-sm mt-1 mb-6 max-w-xs">Anda belum menyimpan paket impian
                                apapun.</p>
                            <a href="{{ route('marketplace.produk.index') }}"
                                class="px-6 py-2.5 bg-orange-600 hover:bg-orange-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-orange-500/30 transition">
                                Cari Paket Umroh
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- 👇 MODAL LIGHTBOX IMAGE WISHLIST 👇 --}}
        <div id="beranda-lightbox" class="fixed inset-0 z-[100] bg-black/95 items-center justify-center hidden p-4 transition-opacity duration-300 opacity-0" onclick="closeBerandaLightbox()">
            <button class="absolute top-4 right-4 md:top-6 md:right-6 text-white hover:text-orange-500 transition focus:outline-none z-50 bg-white/10 hover:bg-red-500 p-2 md:p-3 rounded-full backdrop-blur-sm border border-white/20">
                <i class="ph-bold ph-x text-xl md:text-2xl"></i>
            </button>
            <div class="relative w-full h-full flex items-center justify-center pointer-events-none p-4">
                <img id="beranda-lightbox-img" src="" class="max-h-[95vh] w-auto max-w-full object-contain rounded-xl shadow-2xl transform scale-95 transition-transform duration-300 pointer-events-auto" onclick="event.stopPropagation()">
            </div>
        </div>

    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

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
                if (result.isConfirmed) document.getElementById('logout-form').submit();
            });
        }

        // --- FUNGSI HAPUS WISHLIST BESERTA UPDATE COUNTER ---
        function removeItem(button, productId) {
            Swal.fire({
                title: 'Hapus dari Wishlist?',
                text: "Paket ini akan dihapus dari daftar simpan Anda.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ea580c',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Munculin Loading Biar User Tau Lagi Proses
                    Swal.fire({
                        title: 'Menghapus...',
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Tembak API
                    fetch('{{ route('marketplace.profil.wishlist.toggle') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        })
                        .then(async response => {
                            const data = await response.json();
                            // Kalau respon dari Laravel BUKAN success/200, lempar error!
                            if (!response.ok) throw new Error(data.message ||
                                'Gagal terhubung ke database');
                            return data;
                        })
                        .then(data => {
                            const card = button.closest('.wishlist-item');

                            // Animasi card hilang
                            card.style.transition = "all 0.3s ease";
                            card.style.opacity = "0";
                            card.style.transform = "scale(0.9)";

                            setTimeout(() => {
                                card.remove(); // Hapus element dari HTML
                                updateCounter(); // Jalankan fungsi update text angka

                                // Show toast sukses
                                Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                }).fire({
                                    icon: 'success',
                                    title: 'Dihapus dari wishlist'
                                });
                            }, 300);
                        })
                        .catch(err => {
                            console.error(err);
                            // Kalau gagal, layar GAK BAKAL ngehapus kartu, tapi muncul error ini:
                            Swal.fire('Gagal Menghapus', 'Pesan Error: ' + err.message, 'error');
                        });
                }
            });
        }

        // --- FUNGSI UPDATE TEXT ANGKA & CEK KOSONG ---
        function updateCounter() {
            const container = document.getElementById('wishlist-container');
            const emptyState = document.getElementById('empty-state');
            const badgeCounter = document.getElementById('wishlist-count');

            if (container) {
                // Hitung sisa kartu yang ada di layar
                const remaining = container.querySelectorAll('.wishlist-item').length;

                // Ubah text di pojok kanan atas
                if (badgeCounter) {
                    badgeCounter.innerText = remaining + " Paket Disimpan";
                }

                // Munculin layar kosong kalau habis
                if (remaining === 0) {
                    container.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                    emptyState.classList.add('flex');
                }
            }
        }   
    </script>

    <script>
       function openBerandaLightbox(src) {
            const lightbox = document.getElementById('beranda-lightbox');
            const img = document.getElementById('beranda-lightbox-img');
            img.src = src;
            lightbox.classList.remove('hidden');
            lightbox.classList.add('flex');
            // Timeout biar animasinya jalan
            setTimeout(() => {
                lightbox.classList.remove('opacity-0');
                img.classList.remove('scale-95');
                img.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        }
        function closeBerandaLightbox() {
            const lightbox = document.getElementById('beranda-lightbox');
            const img = document.getElementById('beranda-lightbox-img');
            lightbox.classList.add('opacity-0');
            img.classList.remove('scale-100');
            img.classList.add('scale-95');
            setTimeout(() => {
                lightbox.classList.add('hidden');
                lightbox.classList.remove('flex');
                img.src = '';
                document.body.style.overflow = 'auto';
            }, 300);
        }
    </script>

</body>

</html>
