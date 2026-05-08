<x-layouts.marketplace>
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        html { scroll-behavior: smooth; scroll-padding-top: 100px; }
    </style>

    <div class="bg-gray-50 text-gray-800 min-h-screen">
        <div class="pt-28 pb-12 lg:pt-32 container mx-auto px-4 max-w-7xl">

            {{-- HEADER NAVIGATION --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mb-10 bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                <a href="/marketplace/produk" class="flex items-center gap-3 text-gray-500 hover:text-teal-700 font-medium transition-colors group">
                    <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-teal-50 group-hover:text-teal-600 transition-colors border border-gray-100">
                        <i class="fas fa-arrow-left text-sm group-hover:-translate-x-0.5 transition-transform"></i>
                    </div>
                    <span class="text-sm">Kembali ke Katalog</span>
                </a>

                <div class="text-center hidden sm:block">
                    <h2 class="text-xl font-bold text-gray-900 tracking-tight">Perbandingan Paket</h2>
                    <div id="product-counter-container" class="flex items-center justify-center gap-2 mt-1 transition-all duration-300">
                        @if(count($produkPerbandingan) > 0)
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            <p id="product-counter-text" class="text-xs text-gray-500 font-medium">{{ count($produkPerbandingan) }} Produk dipilih</p>
                        @else
                            <p class="text-xs text-red-500 font-bold">Tidak ada produk</p>
                        @endif
                    </div>
                </div>

                @if(count($produkPerbandingan) > 0)
                    <button onclick="clearComparison()" class="flex items-center gap-2 text-red-500 hover:text-white hover:bg-red-500 border border-red-100 hover:border-red-500 font-medium text-sm transition-all px-5 py-2.5 rounded-xl shadow-sm cursor-pointer">
                        <i class="fas fa-trash-alt text-xs"></i>
                        <span>Hapus Semua</span>
                    </button>
                @else
                    <div class="w-32 hidden sm:block"></div> {{-- Spacer biar rata tengah --}}
                @endif
            </div>

            <div class="relative">
                @if(count($produkPerbandingan) == 0)
                    {{-- EMPTY STATE KOSONG --}}
                    <div class="w-full flex flex-col items-center justify-center py-16 text-center animate-[fadeIn_0.5s_ease-in-out] bg-white rounded-3xl border border-gray-100 shadow-sm">
                        <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mb-6 ring-4 ring-white shadow-sm">
                            <i class="fas fa-box-open text-4xl text-slate-300"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Perbandingan Kosong</h3>
                        <p class="text-slate-500 mb-8 max-w-md leading-relaxed">
                            Anda belum memilih paket apapun. Silakan cari paket umroh terbaik untuk dibandingkan fasilitasnya.
                        </p>
                        <a href="{{ route('marketplace.produk.index') }}" class="px-8 py-3.5 bg-teal-600 hover:bg-teal-700 text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-teal-200 hover:-translate-y-1">
                            <i class="ph-bold ph-magnifying-glass mr-2"></i> Cari Paket Umroh
                        </a>
                    </div>
                @else
                    {{-- GRID PERBANDINGAN --}}
                    <div id="comparison-grid" class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-14 items-stretch transition-all duration-500">
                        
                        @foreach($produkPerbandingan as $produk)
                            @php
                                // PARSING DATA API
                                $tanggalBerangkat = \Carbon\Carbon::parse($produk['tgl_keberangkatan'] ?? now());
                                $hargaMulai = $produk['prices'][0]['harga'] ?? ($produk['prices'][0]['price'] ?? 0);
                                $gambarUtama = isset($produk['thumbnail_url']) ? "https://mediumspringgreen-meerkat-585223.hostingersite.com/assets/img/products/thumbnails/" . rawurlencode($produk['thumbnail_url']) : "/assets/img/marketplace/produk-dummy.png";
                                $maskapai = count($produk['flights'] ?? []) > 0 ? $produk['flights'][0]['airline_name'] : 'TBA';
                                $biroTravel = $produk['creator']['fullname'] ?? 'Biro Travel';
                                
                                // Parse Hotel
                                $hotelMakkah = 'TBA'; $jarakMakkah = '-';
                                $hotelMadinah = 'TBA'; $jarakMadinah = '-';
                                foreach($produk['hotels'] ?? [] as $htl) {
                                    if(stripos(strtolower($htl['city']), 'mekkah') !== false || stripos(strtolower($htl['city']), 'makkah') !== false) {
                                        $hotelMakkah = $htl['name'];
                                        $jarakMakkah = $htl['jarak'] ?? '-';
                                    }
                                    if(stripos(strtolower($htl['city']), 'madinah') !== false) {
                                        $hotelMadinah = $htl['name'];
                                        $jarakMadinah = $htl['jarak'] ?? '-';
                                    }
                                }

                                // Parse Fasilitas Include & Exclude
                                $includeFacilities = [];
                                $excludeFacilities = [];
                                foreach($produk['facility'] ?? [] as $fac) {
                                    if(strtoupper($fac['type']) === 'INCLUDE') {
                                        $includeFacilities[] = $fac['facility'];
                                    } elseif(strtoupper($fac['type']) === 'EXCLUDE') {
                                        $excludeFacilities[] = $fac['facility'];
                                    }
                                }
                            @endphp

                            <div class="product-card group relative flex flex-col h-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-teal-300 hover:shadow-[0_8px_30px_rgb(13,148,136,0.15)] transition-all duration-300 overflow-hidden" data-id="{{ $produk['id'] }}">

                                <button onclick="removeSingleCompare('{{ $produk['id'] }}')" class="cursor-pointer absolute top-4 right-4 z-30 w-9 h-9 bg-white/30 backdrop-blur-md hover:bg-red-500 border border-white/50 rounded-full flex items-center justify-center text-white hover:text-white transition-all duration-200 shadow-lg group-hover:scale-110" title="Hapus produk ini">
                                    <i class="fas fa-times text-sm drop-shadow-md"></i>
                                </button>

                                <div class="relative h-64 overflow-hidden cursor-pointer bg-slate-200" onclick="openModal(this.querySelector('img').src)">
                                    <img src="{{ $gambarUtama }}" onerror="this.src='https://images.unsplash.com/photo-1565552684305-7e8d5eb09539?q=80&w=1000&auto=format&fit=crop'" alt="{{ $produk['nama_produk'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center z-20">
                                        <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white border border-white/30 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-6 px-6 pb-2 flex flex-col items-center text-center">
                                    <div class="mb-3">
                                        <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-md bg-teal-50 text-teal-700 text-[11px] font-bold tracking-wider uppercase shadow-sm">
                                            <i class="ph-fill ph-seal-check text-teal-500 text-xs"></i>
                                            {{ $biroTravel }}
                                        </span>
                                    </div>
                                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 leading-snug group-hover:text-teal-600 transition-colors line-clamp-2">
                                        {{ $produk['nama_produk'] }}
                                    </h3>
                                </div>

                                <div class="px-6 py-4 flex justify-center items-center border-b border-dashed border-gray-100">
                                    <div class="text-center">
                                        <p class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Mulai Dari</p>
                                        <div class="flex items-baseline justify-center gap-1">
                                            <span class="text-sm font-bold text-teal-600">Rp</span>
                                            <span class="text-3xl font-extrabold text-teal-700 tracking-tight">
                                                @if($hargaMulai > 0)
                                                    {{ number_format($hargaMulai / 1000000, 1, ',', '.') }}<span class="text-lg">jt</span>
                                                @else
                                                    <span class="text-xl">Hubungi Kami</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 flex-grow flex flex-col gap-6">
                                    <div class="grid grid-cols-3 gap-3">
                                        <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Durasi</p>
                                            <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                                <i class="ph-duotone ph-clock text-orange-500 text-base"></i> {{ $produk['duration'] ?? '-' }} Hari
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Tanggal</p>
                                            <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                                <i class="ph-duotone ph-calendar-blank text-orange-500 text-base"></i> {{ $tanggalBerangkat->translatedFormat('d M Y') }}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Maskapai</p>
                                            <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1 line-clamp-1" title="{{ $maskapai }}">
                                                <i class="ph-duotone ph-airplane-takeoff text-orange-500 text-base"></i>{{ $maskapai }}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Keberangkatan</p>
                                            <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1">
                                                <i class="ph-duotone ph-airplane-takeoff text-orange-500 text-base"></i>{{ $produk['tmp_keberangkatan'] ?? 'CGK' }}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Hotel Makkah</p>
                                            <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1 line-clamp-1" title="{{ $hotelMakkah }}">
                                                <i class="ph-duotone ph-buildings text-orange-500 text-base"></i> {{ $hotelMakkah }}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Jarak Makkah</p>
                                            <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1 line-clamp-1">
                                                <i class="ph-duotone ph-map-pin text-orange-500 text-base"></i> {{ $jarakMakkah }}
                                            </p>
                                        </div>
                                        <div class="col-start-2 col-span-1 bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Hotel Madinah</p>
                                            <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1 line-clamp-1" title="{{ $hotelMadinah }}">
                                                <i class="ph-duotone ph-buildings text-orange-500 text-base"></i> {{ $hotelMadinah }}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 rounded-xl p-2.5 text-center border border-gray-100">
                                            <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wide mb-1">Jarak Madinah</p>
                                            <p class="font-bold text-gray-800 text-sm flex items-center justify-center gap-1 line-clamp-1">
                                                <i class="ph-duotone ph-map-pin text-orange-500 text-base"></i> {{ $jarakMadinah }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="border border-gray-100 rounded-2xl p-4 bg-white relative overflow-hidden flex-grow">
                                        <div class="absolute top-0 right-0 w-16 h-16 bg-teal-50 rounded-bl-full -mr-8 -mt-8 z-0"></div>
                                        <p class="text-[10px] font-bold text-teal-800 uppercase mb-3 flex items-center gap-2 relative z-10">
                                            <i class="fas fa-box-open text-teal-500"></i> Fasilitas Termasuk
                                        </p>
                                        <div class="grid grid-cols-2 gap-y-2 gap-x-2 relative z-10">
                                            @forelse($includeFacilities as $item)
                                                <div class="flex items-start gap-2">
                                                    <i class="ph-duotone ph-check-circle text-teal-500 text-[14px] mt-0.5 shrink-0"></i>
                                                    <span class="text-[10px] text-gray-600 font-medium leading-tight">{{ $item }}</span>
                                                </div>
                                            @empty
                                                <span class="text-[10px] text-gray-400 italic">Belum ada data rincian fasilitas.</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="bg-white rounded-xl p-3 border border-gray-100 shadow-sm mt-auto">
                                        <h5 class="text-[10px] font-bold text-red-600 uppercase mb-2 flex items-center gap-1.5">
                                            <i class="fas fa-times-circle text-red-500"></i> Tidak Termasuk
                                        </h5>
                                        <ul class="space-y-1.5">
                                            @forelse($excludeFacilities as $item)
                                                <li class="text-[10px] text-gray-500 flex items-start gap-1.5 leading-tight">
                                                    <span class="w-1 h-1 rounded-full bg-red-300 mt-1.5 shrink-0"></span>
                                                    {{ $item }}
                                                </li>
                                            @empty
                                                <li class="text-[10px] text-gray-400 italic">Belum ada rincian tidak termasuk.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>

                                <div class="p-5 bg-gray-50 border-t border-gray-100">
                                    <a href="{{ route('marketplace.produk.detail', $produk['id']) }}" class="w-full py-3.5 bg-white border-2 border-teal-600 text-teal-700 font-bold rounded-xl hover:bg-teal-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-lg hover:-translate-y-0.5 flex justify-center items-center gap-2 group decoration-0">
                                        Pilih Paket Ini
                                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL LIGHTBOX GAMBAR --}}
    <div id="imageModal" class="fixed inset-0 z-[100] hidden items-center justify-center transition-all duration-300 opacity-0" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-gray-900/90 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
        <button onclick="closeModal()" class="absolute top-5 right-5 z-[110] w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-all hover:rotate-90 hover:scale-110 focus:outline-none">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="relative z-[110] p-4 max-w-5xl w-full h-full flex items-center justify-center">
            <img id="modalImage" src="" alt="Preview" class="max-h-[90vh] max-w-full object-contain rounded-xl shadow-2xl transform scale-95 transition-transform duration-300 select-none">
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 bg-black/50 backdrop-blur-md px-4 py-2 rounded-full text-white text-sm font-medium border border-white/10">
                Tekan ESC untuk menutup
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        // --- AUTO SYNC LOCALSTORAGE & URL (PERBAIKAN BUG) ---
        // Script ini akan berjalan otomatis pas halaman perbandingan dibuka
        document.addEventListener('DOMContentLoaded', function() {
            let compareList = JSON.parse(localStorage.getItem('compareList')) || [];
            const urlParams = new URLSearchParams(window.location.search);
            const idsInUrl = urlParams.get('ids');

            // Kasus 1: User buka halaman /bandingkan polos (dari navbar), tapi di memori masih ada isinya
            if (compareList.length > 0 && !idsInUrl) {
                // Langsung redirect paksa bawa ID yang ada di memori
                window.location.replace(`/marketplace/bandingkan?ids=${compareList.join(',')}`);
            }
            // Kasus 2: User buka link hasil share temen (?ids=x,y), kita timpa memorinya biar sinkron
            else if (idsInUrl) {
                let urlIdsArray = idsInUrl.split(',').filter(id => id.trim() !== '');
                localStorage.setItem('compareList', JSON.stringify(urlIdsArray));
            }
        });

        // Modal Gambar
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');

        function openModal(src) {
            modalImg.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalImg.classList.remove('scale-95');
                modalImg.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.classList.add('opacity-0');
            modalImg.classList.remove('scale-100');
            modalImg.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modalImg.src = '';
            }, 300);
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape" && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // 1. FUNGSI HAPUS 1 PRODUK
        function removeSingleCompare(idToRemove) {
            Swal.fire({
                title: 'Hapus dari Perbandingan?',
                text: "Paket ini akan dihapus dari daftar perbandingan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let compareList = JSON.parse(localStorage.getItem('compareList')) || [];
                    compareList = compareList.filter(id => String(id) !== String(idToRemove));
                    
                    // Simpan sisa produk ke memori
                    localStorage.setItem('compareList', JSON.stringify(compareList));

                    // Reload page agar API nangkep ID yang baru
                    if (compareList.length > 0) {
                        window.location.href = `/marketplace/bandingkan?ids=${compareList.join(',')}`;
                    } else {
                        window.location.href = `/marketplace/bandingkan`;
                    }
                }
            });
        }

        // 2. FUNGSI HAPUS SEMUA PRODUK
        function clearComparison() {
            Swal.fire({
                title: 'Kosongkan Semua?',
                text: "Daftar perbandingan Anda akan direset ulang.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#cbd5e1',
                confirmButtonText: 'Ya, Kosongkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kosongin memori
                    localStorage.removeItem('compareList');
                    // Balik ke halaman polos
                    window.location.href = `/marketplace/bandingkan`;
                }
            })
        }
    </script>
    
</x-layouts.marketplace>