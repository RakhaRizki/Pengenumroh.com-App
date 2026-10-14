<!doctype html>
<html lang="id" class="scroll-smooth">

<head>

    <title>Upload Produk - Pengenumroh</title>
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

        .form-input:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.2s ease-out;
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

    <main class="pt-28 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <div class="lg:col-span-1 space-y-6" data-aos="fade-right">
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-orange-100 to-orange-50"></div>
                        <div class="relative z-10">
                            <div class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow-md overflow-hidden bg-slate-100 mb-3">
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
                                    <div class="bg-emerald-500 h-2 rounded-full w-full"></div>
                                </div>
                                <p class="text-[11px] text-emerald-700 mt-2 flex items-center gap-1 font-medium bg-emerald-50 py-1 px-2 rounded-lg">
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
                                <div class="flex items-center gap-3"><i class="ph-bold ph-receipt text-xl"></i> Pesanan Masuk</div>
                                @if ($countPending > 0)
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">{{ $countPending }}</span>
                                @endif
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
                    <form id="productForm" onsubmit="handlePublish(event)">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">Upload Produk Baru</h1>
                                <p class="text-slate-500 text-sm mt-1">Buat penawaran paket Umroh/Hajj menarik untuk jamaah.</p>
                            </div>
                            <div class="hidden md:flex gap-3">
                                <button type="button" onclick="handleDraft()"
                                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition flex items-center justify-center text-sm">
                                    Simpan Draft
                                </button>
                                <button type="submit"
                                    class="px-6 py-2.5 rounded-xl bg-orange-600 text-white font-bold hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition flex items-center justify-center gap-2 text-sm">
                                    <i class="ph-bold ph-paper-plane-right"></i> Terbitkan
                                </button>
                            </div>
                        </div>
                        <div class="space-y-6">

                            <!-- Foto Produk -->
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <i class="ph-duotone ph-image text-orange-500 text-xl"></i> Foto Produk
                                </h3>
                                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:bg-slate-50 hover:border-orange-400 transition cursor-pointer group"
                                    onclick="document.getElementById('thumbnail_product').click()">
                                    <div class="w-16 h-16 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                        <i class="ph-bold ph-upload-simple text-3xl"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900">Klik untuk upload atau drag & drop</h4>
                                    <p class="text-xs text-slate-500 mt-1">PNG, JPG atau WEBP (Maks. 5MB per foto)</p>
                                    <input type="file" id="thumbnail_product" name="thumbnail_product" class="hidden" accept="image/*" onchange="previewMainImg(event)">
                                </div>
                                <div class="mt-4 flex justify-center">
                                    <img id="preview-thumbnail" class="h-48 w-auto rounded-lg object-cover hidden shadow-md border border-slate-200">
                                </div>
                            </div>
                            
                            <!-- Informasi Paket -->
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-info text-blue-500 text-xl"></i> Informasi Paket
                                </h3>
                                <div class="space-y-8">
                               <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    
                                        <!-- Nama Paket -->
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="text-sm font-bold text-slate-700">Nama Paket</label>
                                            <input type="text" id="product_name" required placeholder="Contoh: Umroh Awal Ramadhan 9 Hari - Hotel Bintang 5" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                        
                                        <!-- Kategori -->
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="text-sm font-bold text-slate-700">Kategori</label>
                                            <div class="relative">
                                                <i class="ph-bold ph-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                <select id="category" required onchange="handleCategoryChange(this)" class="w-full pl-11 pr-10 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition appearance-none bg-white">
                                                    <option value="" disabled selected>Pilih Kategori</option>
                                                    <option value="1">Umroh Reguler 9 Hari</option>
                                                    <option value="2">Umroh Reguler 12 Hari</option>
                                                    <option value="3">Umroh Plus Tour</option>
                                                    <option value="4">Umroh Ramadhan</option>
                                                    <option value="5">Haji Khusus</option>
                                                </select>
                                                <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                            </div>
                                        </div>

                                        <!-- 👇 BAGIAN KUOTA YANG BARU (DIPECAH 3) 👇 -->
                                        <div class="space-y-3 md:col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-100">
                                            <label class="text-sm font-bold text-slate-700">Jumlah Kuota per Tipe Kamar (Pax)</label>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                
                                                <!-- Quad -->
                                                <div class="space-y-1.5">
                                                    <span class="text-xs font-semibold text-slate-500">Kamar Quad</span>
                                                    <div class="relative">
                                                        <i class="ph-bold ph-users-four absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                        <input type="number" id="quota_quad" min="0" required placeholder="0" class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                                    </div>
                                                </div>
                                                
                                                <!-- Double -->
                                                <div class="space-y-1.5">
                                                    <span class="text-xs font-semibold text-slate-500">Kamar Double</span>
                                                    <div class="relative">
                                                        <i class="ph-bold ph-users absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                        <input type="number" id="quota_double" min="0" required placeholder="0" class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                                    </div>
                                                </div>
                                                
                                                <!-- Triple -->
                                                <div class="space-y-1.5">
                                                    <span class="text-xs font-semibold text-slate-500">Kamar Triple</span>
                                                    <div class="relative">
                                                        <i class="ph-bold ph-users-three absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                        <input type="number" id="quota_triple" min="0" required placeholder="0" class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                    <hr class="border-slate-100">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                        <div class="space-y-3">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                                <i class="ph-fill ph-check-circle text-green-500"></i> Fasilitas Termasuk
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="text" id="input-included" placeholder="Ketik lalu Enter (Misal: Visa Umroh)" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-green-500 transition" onkeypress="handleEnter(event, 'included')">
                                                <button type="button" onclick="addItem('included')" class="bg-green-100 text-green-700 p-2.5 rounded-xl hover:bg-green-200 transition"><i class="ph-bold ph-plus"></i></button>
                                            </div>
                                            <ul id="list-included" class="space-y-2"></ul>
                                        </div>
                                        <div class="space-y-3">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                                <i class="ph-fill ph-x-circle text-red-500"></i> Tidak Termasuk
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="text" id="input-excluded" placeholder="Ketik lalu Enter (Misal: Paspor)" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-red-500 transition" onkeypress="handleEnter(event, 'excluded')">
                                                <button type="button" onclick="addItem('excluded')" class="bg-red-100 text-red-700 p-2.5 rounded-xl hover:bg-red-200 transition"><i class="ph-bold ph-plus"></i></button>
                                            </div>
                                            <ul id="list-excluded" class="space-y-2"></ul>
                                        </div>
                                    </div>
                                    <hr class="border-slate-100">
                                    <div class="space-y-4">
                                        <div class="flex justify-between items-end">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                                <i class="ph-duotone ph-path text-orange-500 text-lg"></i> Rencana Perjalanan (Itinerary)
                                            </label>
                                        </div>
                                        <div id="itinerary-container" class="space-y-0 relative pl-4 border-l-2 border-slate-100 ml-2"></div>
                                        <button type="button" onclick="addItineraryDay()" class="w-full py-3 border-2 border-dashed border-slate-200 text-slate-500 rounded-xl font-bold text-sm hover:border-orange-400 hover:text-orange-600 hover:bg-orange-50 transition flex items-center justify-center gap-2">
                                            <i class="ph-bold ph-plus-circle"></i> Tambah Hari Perjalanan
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Jadwal & Penerbangan -->
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-airplane-tilt text-purple-500 text-xl"></i> Jadwal & Penerbangan
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700">Tanggal Keberangkatan</label>
                                        <input type="date" id="departure_date" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700">Durasi (Hari)</label>
                                        <div class="relative">
                                            <input type="number" id="duration" required placeholder="9" onchange="adjustItinerary(this.value)" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Hari</span>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700">Keberangkatan</label>
                                        <div class="relative">
                                            <i class="ph-bold ph-map-pin absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                            <select id="departure_from" required class="w-full pl-11 pr-10 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition appearance-none bg-white">
                                                <option value="" disabled selected>Pilih Kota Keberangkatan</option>
                                                <option value="Jakarta">Jakarta (CGK)</option>
                                                <option value="Surabaya">Surabaya (SUB)</option>
                                                <option value="Medan">Medan (KNO)</option>
                                                <option value="Makassar">Makassar (UPG)</option>
                                                <option value="Jeddah">Jeddah (Langsung)</option>
                                            </select>
                                            <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-5 bg-slate-50 rounded-xl border border-slate-100 transition-all duration-300">
                                    <div class="flex items-center justify-between mb-4">
                                        <label class="flex items-center gap-2 cursor-pointer select-none">
                                            <div class="relative">
                                                <input type="checkbox" id="sameAirlineToggle" class="sr-only peer" checked onchange="toggleReturnAirline()">
                                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500"></div>
                                            </div>
                                            <span class="text-sm font-semibold text-slate-700">Maskapai Pulang Pergi sama</span>
                                        </label>
                                        <span class="text-xs text-slate-400 italic hidden sm:block">*Matikan jika maskapai berbeda</span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2 transition-all duration-300 md:col-span-2" id="departureContainer">
                                            <label class="text-sm font-bold text-slate-700" id="departureLabel">Nama Maskapai (PP)</label>
                                            <div class="relative">
                                                <i class="ph-bold ph-airplane-tilt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                <input type="text" id="flight_departure" required placeholder="Contoh: Garuda Indonesia" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                            </div>
                                        </div>
                                        <div class="space-y-2 hidden" id="returnContainer">
                                            <label class="text-sm font-bold text-slate-700">Maskapai Kepulangan</label>
                                            <div class="relative">
                                                <i class="ph-bold ph-airplane-landing absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                <input type="text" id="flight_return" placeholder="Contoh: Saudia Airlines" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Akomodasi Hotel -->
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-buildings text-yellow-500 text-xl"></i> Akomodasi Hotel
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Hotel Makkah -->
                                    <div class="space-y-4 p-5 bg-slate-50 rounded-xl border border-slate-100 group hover:border-orange-200 transition duration-300">
                                        <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2">
                                            <p class="font-bold text-slate-700">Hotel Makkah</p>
                                            <i class="ph-fill ph-kaaba text-slate-400"></i>
                                        </div>
                                        <div class="relative h-32 w-full rounded-xl border-2 border-dashed border-slate-300 bg-white hover:bg-orange-50 hover:border-orange-400 transition cursor-pointer flex flex-col items-center justify-center group/upload overflow-hidden" onclick="document.getElementById('img_makkah').click()">
                                            <input type="file" id="img_makkah" accept="image/*" class="hidden" onchange="previewHotelImg(event, 'preview-makkah', 'placeholder-makkah')">
                                            <div class="text-center p-2" id="placeholder-makkah">
                                                <i class="ph-bold ph-image text-2xl text-slate-300 group-hover/upload:text-orange-500 transition mb-1"></i>
                                                <p class="text-xs font-bold text-slate-400 group-hover/upload:text-orange-600 transition">Foto Hotel</p>
                                            </div>
                                            <img id="preview-makkah" class="absolute inset-0 w-full h-full object-cover hidden pointer-events-none">
                                        </div>
                                        <div class="space-y-3">
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Nama Hotel</label>
                                                <input type="text" id="makkah_name" required placeholder="Contoh: Pullman Zamzam" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Bintang</label>
                                                <div class="relative">
                                                    <select id="makkah_rating" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white appearance-none transition shadow-sm focus:shadow-md">
                                                        <option value="5">⭐⭐⭐⭐⭐ (Bintang 5)</option>
                                                        <option value="4">⭐⭐⭐⭐ (Bintang 4)</option>
                                                        <option value="3">⭐⭐⭐ (Bintang 3)</option>
                                                        <option value="2">⭐⭐ (Bintang 2)</option>
                                                        <option value="1">⭐ (Bintang 1)</option>
                                                    </select>
                                                    <i class="ph-bold ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                                </div>
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Jarak ke Masjidil Haram</label>
                                                <div class="relative">
                                                    <i class="ph-bold ph-person-simple-walk absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                    <input type="text" id="makkah_distance" placeholder="Contoh: 50m (Pelataran)" class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                                </div>
                                            </div>
                                            <div class="space-y-1.5 pt-2">
                                                <label class="text-xs font-semibold text-slate-500">Fasilitas Hotel</label>
                                                <div class="flex gap-2 mb-2">
                                                    <input type="text" id="input-fasilitas_makkah" placeholder="Ketik (Misal: WiFi) lalu Enter" class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-orange-500 bg-white shadow-sm" onkeypress="handleEnter(event, 'fasilitas_makkah')">
                                                    <button type="button" onclick="addItem('fasilitas_makkah')" class="bg-orange-100 text-orange-700 px-3 rounded-lg hover:bg-orange-200 transition"><i class="ph-bold ph-plus"></i></button>
                                                </div>
                                                <ul id="list-fasilitas_makkah" class="space-y-1.5 flex flex-wrap gap-2"></ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Hotel Madinah -->
                                    <div class="space-y-4 p-5 bg-slate-50 rounded-xl border border-slate-100 group hover:border-orange-200 transition duration-300">
                                        <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2">
                                            <p class="font-bold text-slate-700">Hotel Madinah</p>
                                        </div>
                                        <div class="relative h-32 w-full rounded-xl border-2 border-dashed border-slate-300 bg-white hover:bg-orange-50 hover:border-orange-400 transition cursor-pointer flex flex-col items-center justify-center group/upload overflow-hidden" onclick="document.getElementById('img_madinah').click()">
                                            <input type="file" id="img_madinah" accept="image/*" class="hidden" onchange="previewHotelImg(event, 'preview-madinah', 'placeholder-madinah')">
                                            <div class="text-center p-2" id="placeholder-madinah">
                                                <i class="ph-bold ph-image text-2xl text-slate-300 group-hover/upload:text-orange-500 transition mb-1"></i>
                                                <p class="text-xs font-bold text-slate-400 group-hover/upload:text-orange-600 transition">Foto Hotel</p>
                                            </div>
                                            <img id="preview-madinah" class="absolute inset-0 w-full h-full object-cover hidden pointer-events-none">
                                        </div>
                                        <div class="space-y-3">
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Nama Hotel</label>
                                                <input type="text" id="madinah_name" required placeholder="Contoh: Anwar Al Madinah" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Bintang</label>
                                                <div class="relative">
                                                    <select id="madinah_rating" class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white appearance-none transition shadow-sm focus:shadow-md">
                                                        <option value="5">⭐⭐⭐⭐⭐ (Bintang 5)</option>
                                                        <option value="4">⭐⭐⭐⭐ (Bintang 4)</option>
                                                        <option value="3">⭐⭐⭐ (Bintang 3)</option>
                                                        <option value="2">⭐⭐ (Bintang 2)</option>
                                                        <option value="1">⭐ (Bintang 1)</option>
                                                    </select>
                                                    <i class="ph-bold ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                                </div>
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Jarak ke Masjid Nabawi</label>
                                                <div class="relative">
                                                    <i class="ph-bold ph-person-simple-walk absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                    <input type="text" id="madinah_distance" placeholder="Contoh: 100m (Pintu 338)" class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                                </div>
                                            </div>
                                            <div class="space-y-1.5 pt-2">
                                                <label class="text-xs font-semibold text-slate-500">Fasilitas Hotel</label>
                                                <div class="flex gap-2 mb-2">
                                                    <input type="text" id="input-fasilitas_madinah" placeholder="Ketik (Misal: AC) lalu Enter" class="flex-1 px-3 py-2 rounded-lg border border-slate-200 text-xs focus:outline-none focus:border-orange-500 bg-white shadow-sm" onkeypress="handleEnter(event, 'fasilitas_madinah')">
                                                    <button type="button" onclick="addItem('fasilitas_madinah')" class="bg-orange-100 text-orange-700 px-3 rounded-lg hover:bg-orange-200 transition"><i class="ph-bold ph-plus"></i></button>
                                                </div>
                                                <ul id="list-fasilitas_madinah" class="space-y-1.5 flex flex-wrap gap-2"></ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Harga Paket -->
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-money text-green-600 text-xl"></i> Harga Paket
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <div class="flex justify-between"><label class="text-sm font-bold text-slate-700">Harga Quad (Sekamar Ber-4) *</label></div>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                            <input type="text" id="price_quad" required placeholder="30.000.000" oninput="formatCurrency(this)" class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-lg font-bold focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex justify-between"><label class="text-sm font-bold text-slate-700">Harga Triple (Sekamar Ber-3) *</label></div>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                            <input type="text" id="price_triple" required placeholder="32.500.000" oninput="formatCurrency(this)" class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-lg font-bold focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <div class="flex justify-between"><label class="text-sm font-bold text-slate-700">Harga Double (Sekamar Ber-2) *</label></div>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                            <input type="text" id="price_double" required placeholder="35.000.000" oninput="formatCurrency(this)" class="w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-lg font-bold focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Syarat & Deskripsi -->
                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-notebook text-orange-500 text-xl"></i> Syarat & Deskripsi
                                </h3>
                                <div class="space-y-8">
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700 block">Tentang Paket / Deskripsi Singkat</label>
                                        <p class="text-xs text-slate-500 mb-2">Jelaskan keunggulan atau ringkasan paket ini.</p>
                                        <textarea id="description" rows="5" placeholder="Contoh: Paket Umrah Easy ini dirancang khusus untuk jamaah..." class="w-full px-4 py-3 rounded-xl border border-slate-200 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition resize-none leading-relaxed"></textarea>
                                    </div>
                                    <hr class="border-slate-100">
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-end">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                                <i class="ph-fill ph-shield-check text-orange-500"></i> Syarat Pendaftaran
                                            </label>
                                        </div>
                                        <div class="flex gap-2">
                                            <input type="text" id="input-syarat" placeholder="Ketik syarat lalu tekan Enter (Misal: Paspor)" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-orange-500 transition" onkeypress="handleEnter(event, 'syarat')">
                                            <button type="button" onclick="addItem('syarat')" class="bg-orange-100 text-orange-700 p-2.5 rounded-xl hover:bg-orange-200 transition"><i class="ph-bold ph-plus"></i></button>
                                        </div>
                                        <ul id="list-syarat" class="space-y-2"></ul>
                                    </div>
                                    <hr class="border-slate-100">
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-end">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                                <i class="ph-fill ph-warning-circle text-orange-500"></i> Poin Catatan Penting
                                            </label>
                                        </div>
                                        <div class="flex gap-2">
                                            <input type="text" id="input-catatan" placeholder="Ketik poin catatan lalu Enter" class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-orange-500 transition" onkeypress="handleEnter(event, 'catatan')">
                                            <button type="button" onclick="addItem('catatan')" class="bg-orange-100 text-orange-700 p-2.5 rounded-xl hover:bg-orange-200 transition"><i class="ph-bold ph-plus"></i></button>
                                        </div>
                                        <ul id="list-catatan" class="space-y-2"></ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tombol Mobile -->
                            <div class="md:hidden pt-4 pb-8 space-y-3">
                                <input type="hidden" name="status" id="inputStatus" value="publish">
                                <button type="submit" class="w-full py-3.5 rounded-xl bg-orange-600 text-white font-bold hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition flex items-center justify-center gap-2">
                                    <i class="ph-bold ph-paper-plane-right"></i> Terbitkan Paket
                                </button>
                                <button type="button" onclick="handleDraft()" class="w-full py-3.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition">
                                    Simpan Draft
                                </button>
                            </div>
                        </div>
                    </form>
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

        // 👇 TAMBAHAN: FITUR CERDAS AUTO-DURASI & AUTO-ITINERARY 👇
        function handleCategoryChange(select) {
            const durationInput = document.getElementById('duration');
            // Ambil teks dari dropdown yang diplih (Misal: "Umroh Reguler 12 Hari")
            const selectedText = select.options[select.selectedIndex].text;
            
            // Logika Cerdas: Otomatis nyari angka di dalam teks pakai Regex
            const match = selectedText.match(/(\d+)\s*Hari/i);
            
            if (match) {
                const jumlahHari = match[1];
                durationInput.value = jumlahHari; // 1. Auto isi input durasi
                adjustItinerary(jumlahHari);      // 2. Auto nambahin/ngurangin kolom Itinerary
                
                // 3. Kasih notif manis di pojokan biar UX-nya kerasa premium
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'info',
                    title: `Durasi diatur otomatis ke ${jumlahHari} Hari`,
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            }
        }

        function adjustItinerary(targetDays) {
            targetDays = parseInt(targetDays);
            if (!targetDays || targetDays <= 0) return;

            const container = document.getElementById('itinerary-container');
            const currentDays = container.children.length;
            
            // Kalau kolom itinerary kurang, tambahin otomatis
            if (currentDays < targetDays) {
                for (let i = currentDays; i < targetDays; i++) {
                    addItineraryDay();
                }
            } 
            // Kalau kolom itinerary kelebihan, hapus dari yang paling bawah otomatis
            else if (currentDays > targetDays) {
                for (let i = currentDays; i > targetDays; i--) {
                    container.lastElementChild.remove();
                }
            }
        }
        // 👆 SELESAI TAMBAHAN FITUR CERDAS 👆

        function formatCurrency(input) {
            let value = input.value.replace(/\D/g, '');
            if (value !== '') {
                value = new Intl.NumberFormat('id-ID').format(value);
            }
            input.value = value;
        }

        function getRawNumber(formattedString) {
            return formattedString.replace(/\D/g, '');
        }

        function addItem(type) {
            const input = document.getElementById(`input-${type}`);
            const list = document.getElementById(`list-${type}`);
            const value = input.value.trim();
            if (value) {
                const li = document.createElement('li');
                let colorClass = 'bg-orange-50 border-orange-100 text-orange-800';
                let btnColor = 'text-orange-400 hover:text-red-500';
                if (type === 'included') {
                    colorClass = 'bg-green-50 border-green-100 text-green-800';
                    btnColor = 'text-green-400 hover:text-red-500';
                }
                if (type === 'excluded') {
                    colorClass = 'bg-red-50 border-red-100 text-red-800';
                    btnColor = 'text-red-400 hover:text-red-500';
                }
                li.className = `flex justify-between items-center ${colorClass} px-3 py-2 rounded-lg border animate-fade-in-down list-item-${type}`;
                li.innerHTML = `<span class="text-sm font-medium item-text">${value}</span><button type="button" onclick="this.parentElement.remove()" class="${btnColor} transition"><i class="ph-bold ph-x"></i></button>`;
                list.appendChild(li);
                input.value = '';
                input.focus();
            }
        }

        function handleEnter(event, type) {
            if (event.key === 'Enter') {
                event.preventDefault();
                addItem(type);
            }
        }

        window.onload = function() {    
            addItineraryDay();
        };

        function addItineraryDay() { 
            const container = document.getElementById('itinerary-container'); 
            const dayCount = container.children.length + 1; 
            const div = document.createElement('div'); 
            div.className = 'relative pl-6 pb-8 itinerary-item'; 
            div.innerHTML = ` 
                <div class="absolute -left-[21px] top-0 w-10 h-10 bg-white border-2 border-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold text-xs shadow-sm z-10">H<span class="day-num">${dayCount}</span></div> 
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 group hover:border-orange-200 transition"> 
                    <div class="flex justify-between mb-2"> 
                        <input type="text" required class="itinerary-title w-full bg-transparent font-bold text-slate-800 text-sm focus:outline-none placeholder:text-slate-400" placeholder="Judul Kegiatan (Wajib diisi, Misal: City Tour Makkah)"> 
                        <button type="button" onclick="removeDay(this)" class="text-slate-400 hover:text-red-500 transition"><i class="ph-bold ph-trash"></i></button> 
                    </div> 
                    <textarea rows="2" required class="itinerary-desc w-full bg-white px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-orange-500 resize-none" placeholder="Deskripsi kegiatan... (Wajib diisi)"></textarea> 
                </div>`; 
            container.appendChild(div); 
        }

        function removeDay(btn) {
            btn.closest('.itinerary-item').remove();
            document.querySelectorAll('.itinerary-item').forEach((el, index) => {
                el.querySelector('.day-num').innerText = index + 1;
            });
        }

        function toggleReturnAirline() {
            const isChecked = document.getElementById('sameAirlineToggle').checked;
            document.getElementById('returnContainer').classList.toggle('hidden', isChecked);
            document.getElementById('departureContainer').classList.toggle('md:col-span-2', isChecked);
            document.getElementById('departureLabel').innerText = isChecked ? "Nama Maskapai (PP)" : "Maskapai Keberangkatan";
        }

        function previewMainImg(event) {
            if (event.target.files[0]) {
                document.getElementById('preview-thumbnail').src = URL.createObjectURL(event.target.files[0]);
                document.getElementById('preview-thumbnail').classList.remove('hidden');
            }
        }

        function previewHotelImg(event, imgId, placeholderId) {
            if (event.target.files[0]) {
                document.getElementById(imgId).src = URL.createObjectURL(event.target.files[0]);
                document.getElementById(imgId).classList.remove('hidden');
                document.getElementById(placeholderId).classList.add('hidden');
            }
        }

        function handleDraft() {
            let inputStatus = document.getElementById('inputStatus');
            if (inputStatus) {
                inputStatus.value = 'draft';
            }
            let form = document.querySelector('form');
            if (form) {
                form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
            } else {
                Swal.fire('Error', 'Form tidak ditemukan!', 'error');
            }
        }

        async function handlePublish(e) {
            e.preventDefault();
            const getListArray = (type) => Array.from(document.querySelectorAll(`.list-item-${type} .item-text`)).map(el => el.innerText);
            const itineraryData = Array.from(document.querySelectorAll('.itinerary-item')).map((el, i) => ({
                day: i + 1,
                title: el.querySelector('.itinerary-title').value,
                description: el.querySelector('.itinerary-desc').value
            }));
            
            const formData = new FormData();
            formData.append('product_name', document.getElementById('product_name').value);
            formData.append('category', document.getElementById('category').value);
            formData.append('quota_quad', document.getElementById('quota_quad').value || 0);
            formData.append('quota_double', document.getElementById('quota_double').value || 0);
            formData.append('quota_triple', document.getElementById('quota_triple').value || 0);
            formData.append('departure_date', document.getElementById('departure_date').value);
            formData.append('duration', document.getElementById('duration').value);
            formData.append('departure_from', document.getElementById('departure_from').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('price_quad', getRawNumber(document.getElementById('price_quad').value));
            formData.append('price_triple', getRawNumber(document.getElementById('price_triple').value));
            formData.append('price_double', getRawNumber(document.getElementById('price_double').value));
            
            // 👇 INI TAMBAHAN PENTING: Ngirim status publish/draft ke Laravel
            const statusValue = document.getElementById('inputStatus').value;
            formData.append('status', statusValue);
            
            const isSameAirline = document.getElementById('sameAirlineToggle').checked;
            const flightDep = document.getElementById('flight_departure').value;
            formData.append('flight_departure', flightDep);
            formData.append('flight_return', isSameAirline ? flightDep : document.getElementById('flight_return').value);
            formData.append('hotel_makkah', JSON.stringify({
                name: document.getElementById('makkah_name').value,
                rating: document.getElementById('makkah_rating').value,
                distance: document.getElementById('makkah_distance').value,
                facilities: getListArray('fasilitas_makkah')
            }));
            formData.append('hotel_madinah', JSON.stringify({
                name: document.getElementById('madinah_name').value,
                rating: document.getElementById('madinah_rating').value,
                distance: document.getElementById('madinah_distance').value,
                facilities: getListArray('fasilitas_madinah')
            }));
            formData.append('included_facilities', JSON.stringify(getListArray('included')));
            formData.append('excluded_facilities', JSON.stringify(getListArray('excluded')));
            formData.append('terms', JSON.stringify(getListArray('syarat')));
            formData.append('notes', JSON.stringify(getListArray('catatan')));
            formData.append('itinerary', JSON.stringify(itineraryData));
            
            const imgMain = document.getElementById('thumbnail_product').files[0];
            const imgMakkah = document.getElementById('img_makkah').files[0];
            const imgMadinah = document.getElementById('img_madinah').files[0];
            
            if (imgMain) formData.append('thumbnail', imgMain);
            if (imgMakkah) formData.append('image_makkah', imgMakkah);
            if (imgMadinah) formData.append('image_madinah', imgMadinah);
            
            const submitUrl = "{{ route('marketplace.travel.produk.store') }}";
            
            Swal.fire({
                title: 'Memproses Data...',
                text: 'Mohon tunggu, jangan tutup halaman ini.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });
            
            try {
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    // 👇 PESAN SUCCESS DINAMIS SESUAI STATUS
                    Swal.fire({
                        title: statusValue === 'draft' ? 'Draft Disimpan!' : 'Berhasil Diterbitkan!',
                        text: statusValue === 'draft' ? 'Paket umroh Anda disimpan ke arsip.' : 'Paket umroh Anda kini tampil di pencarian jamaah.',
                        icon: 'success',
                        confirmButtonColor: '#ea580c'
                    }).then(() => {
                        window.location.href = "{{ route('marketplace.travel.kelola-produk') }}";
                    });
                } else {
                    Swal.fire('Gagal Upload!', result.message || 'Terjadi kesalahan dari sisi server.', 'error');
                }
            } catch (error) {
                console.error(error);
                Swal.fire('Error Sistem', 'Tidak dapat terhubung ke server internal.', 'error');
            }
        }
    </script>

</body>

</html>