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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }

        /* Custom Input Style for focused ring color */
        .form-input:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
        }

        /* itenary */

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
                            <p class="text-xs font-bold text-slate-700">Rahmat Rio</p>
                            <p class="text-[10px] text-slate-500">Biro Travel</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                            <img id="nav-avatar"
                                src="https://ui-avatars.com/api/?name=Rakha+Rizki&background=F97316&color=fff"
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

    <main class="pt-28 pb-5 min-h-screen bg-slate-50/50">
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
                                <img id="sidebar-avatar"
                                    src="https://ui-avatars.com/api/?name=Rakha+Rizki&background=F97316&color=fff"
                                    class="w-full h-full object-cover">
                            </div>
                            <h2 class="text-lg font-bold text-slate-900">Rahmat Rio</h2>
                            <p class="text-sm text-slate-500">Travel Agent Resmi</p>
                            <div class="mt-4 text-left">
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="font-semibold text-slate-600">Kelengkapan Data</span>
                                    <span class="font-bold text-emerald-600">100%</span>
                                </div>

                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="bg-emerald-500 h-2 rounded-full transition-all duration-1000 w-full">
                                    </div>
                                </div>

                                <p
                                    class="text-[11px] text-emerald-700 mt-2 flex items-center gap-1 font-medium bg-emerald-50 py-1 px-2 rounded-lg">
                                    <i class="ph-fill ph-check-circle text-emerald-600"></i>
                                    Data Anda sudah lengkap.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
                        <nav class="flex flex-col">
                            <a href="{{ route('marketplace.travel.profil') }}"
                                class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition border-l-4 border-transparent">
                                <i class="ph-bold ph-user text-xl"></i> Profil
                            </a>
                            <a href="{{ route('marketplace.travel.pesanan-masuk') }}"
                                class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition border-l-4 border-transparent">
                                <i class="ph-bold ph-receipt text-xl"></i> Pesanan Masuk
                            </a>
                            <a href="{{ route('marketplace.travel.upload-produk') }}"
                                class="flex items-center gap-3 px-5 py-4 bg-orange-50 text-orange-700 font-bold border-l-4 border-orange-600">
                                <i class="ph-bold ph-upload text-xl"></i> Upload Produk
                            </a>
                            <a href="{{ route('marketplace.travel.kelola-produk') }}"
                                class="flex items-center gap-3 px-5 py-4 text-slate-600 hover:bg-slate-50 hover:text-slate-900 font-medium transition border-l-4 border-transparent">
                                <i class="ph-bold ph-package text-xl"></i> Kelola Produk
                            </a>
                        </nav>
                        <!-- <div class="mt-auto border-t border-slate-100 p-2 bg-slate-50">
                            <button onclick="confirmLogout()"
                                class="flex w-full items-center justify-center gap-2 px-5 py-3 text-red-600 hover:bg-red-100/50 hover:text-red-700 font-bold transition rounded-xl text-sm">
                                <i class="ph-bold ph-sign-out text-lg"></i> Keluar Akun
                            </button>
                        </div> -->
                    </div>
                </div>

                <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="100">
                    <form id="productForm" onsubmit="uploadProduct(event)">

                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                            <div>
                                <h1 class="text-2xl font-bold text-slate-900">Upload Produk Baru</h1>
                                <p class="text-slate-500 text-sm mt-1">Buat penawaran paket Umroh/Hajj menarik untuk
                                    jamaah.
                                </p>
                            </div>
                            <div class="hidden md:flex gap-3">
                                <a href="javascript:void(0)" onclick="handleDraft()"
                                    class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition flex items-center justify-center text-sm">
                                    Simpan Draft
                                </a>

                                <a href="javascript:void(0)" onclick="handlePublish()"
                                    class="px-6 py-2.5 rounded-xl bg-orange-600 text-white font-bold hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition flex items-center justify-center gap-2 text-sm">
                                    <i class="ph-bold ph-paper-plane-right"></i> Terbitkan
                                </a>
                            </div>
                        </div>

                        <div class="space-y-6">

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                                    <i class="ph-duotone ph-image text-orange-500 text-xl"></i> Foto Produk
                                </h3>

                                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-8 text-center hover:bg-slate-50 hover:border-orange-400 transition cursor-pointer group"
                                    onclick="document.getElementById('product-images').click()">
                                    <div
                                        class="w-16 h-16 bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition">
                                        <i class="ph-bold ph-upload-simple text-3xl"></i>
                                    </div>
                                    <h4 class="text-sm font-bold text-slate-900">Klik untuk upload atau drag & drop</h4>
                                    <p class="text-xs text-slate-500 mt-1">PNG, JPG atau WEBP (Maks. 5MB per foto)</p>
                                    <input type="file" id="product-images" class="hidden" multiple accept="image/*">
                                </div>

                                <div class="flex gap-4 mt-4 overflow-x-auto pb-2">
                                    <div
                                        class="relative w-24 h-24 rounded-lg overflow-hidden border border-slate-200 flex-shrink-0">
                                        <img src="/assets/img/marketplace/produk-dummy.png"
                                            class="w-full h-full object-cover">
                                        <button type="button"
                                            class="absolute top-1 right-1 bg-white/80 p-1 rounded-full text-red-500 hover:text-red-700">
                                            <i class="ph-bold ph-x text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-info text-blue-500 text-xl"></i> Informasi Paket
                                </h3>

                                <div class="space-y-8">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="text-sm font-bold text-slate-700">Nama Paket</label>
                                            <input type="text"
                                                placeholder="Contoh: Umroh Awal Ramadhan 9 Hari - Hotel Bintang 5"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>

                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-slate-700">Kategori</label>
                                            <div class="relative">
                                                <i
                                                    class="ph-bold ph-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                <select
                                                    class="w-full pl-11 pr-10 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition appearance-none bg-white">
                                                    <option value="" disabled selected>Pilih Kategori</option>
                                                    <option value="Reguler">Umroh Reguler 9 Hari</option>
                                                    <option value="VIP">Umroh Reguler 12 Hari</option>
                                                    <option value="Haji">Umroh Plus Wisata</option>
                                                    <option value="Tour">Umroh Ramadhan</option>
                                                    <option value="Tour">Haji Khusus</option>
                                                </select>
                                                <i
                                                    class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                            </div>
                                        </div>

                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-slate-700">Jumlah Kuota (Pax)</label>
                                            <div class="relative">
                                                <i
                                                    class="ph-bold ph-users absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                <input type="number" placeholder="45"
                                                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="border-slate-100">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                        <div class="space-y-3">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                                <i class="ph-fill ph-check-circle text-green-500"></i> Fasilitas
                                                Termasuk
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="text" id="input-included"
                                                    placeholder="Ketik lalu Enter (Misal: Visa Umroh)"
                                                    class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-green-500 transition"
                                                    onkeypress="handleEnter(event, 'included')">
                                                <button type="button" onclick="addItem('included')"
                                                    class="bg-green-100 text-green-700 p-2.5 rounded-xl hover:bg-green-200 transition">
                                                    <i class="ph-bold ph-plus"></i>
                                                </button>
                                            </div>
                                            <ul id="list-included" class="space-y-2">
                                                <li
                                                    class="flex justify-between items-center bg-green-50 px-3 py-2 rounded-lg border border-green-100">
                                                    <span class="text-sm text-green-800 font-medium">Tiket Pesawat
                                                        Internasional</span>
                                                    <button onclick="this.parentElement.remove()"
                                                        class="text-green-400 hover:text-red-500 transition"><i
                                                            class="ph-bold ph-x"></i></button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="space-y-3">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                                <i class="ph-fill ph-x-circle text-red-500"></i> Tidak Termasuk
                                            </label>
                                            <div class="flex gap-2">
                                                <input type="text" id="input-excluded"
                                                    placeholder="Ketik lalu Enter (Misal: Paspor)"
                                                    class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-red-500 transition"
                                                    onkeypress="handleEnter(event, 'excluded')">
                                                <button type="button" onclick="addItem('excluded')"
                                                    class="bg-red-100 text-red-700 p-2.5 rounded-xl hover:bg-red-200 transition">
                                                    <i class="ph-bold ph-plus"></i>
                                                </button>
                                            </div>
                                            <ul id="list-excluded" class="space-y-2">
                                                <li
                                                    class="flex justify-between items-center bg-red-50 px-3 py-2 rounded-lg border border-red-100">
                                                    <span class="text-sm text-red-800 font-medium">Pembuatan
                                                        Paspor</span>
                                                    <button onclick="this.parentElement.remove()"
                                                        class="text-red-400 hover:text-red-600 transition"><i
                                                            class="ph-bold ph-x"></i></button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <hr class="border-slate-100">

                                    <div class="space-y-4">
                                        <div class="flex justify-between items-end">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                                <i class="ph-duotone ph-path text-orange-500 text-lg"></i> Rencana
                                                Perjalanan (Itinerary)
                                            </label>
                                        </div>

                                        <div id="itinerary-container"
                                            class="space-y-0 relative pl-4 border-l-2 border-slate-100 ml-2">
                                            <div class="relative pl-6 pb-8 itinerary-item">
                                                <div
                                                    class="absolute -left-[21px] top-0 w-10 h-10 bg-white border-2 border-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold text-xs shadow-sm z-10">
                                                    H1
                                                </div>
                                                <div
                                                    class="bg-slate-50 border border-slate-200 rounded-xl p-4 group hover:border-orange-200 transition">
                                                    <div class="flex justify-between mb-2">
                                                        <input type="text"
                                                            placeholder="Judul (Misal: Keberangkatan Jakarta - Jeddah)"
                                                            class="w-full bg-transparent font-bold text-slate-800 text-sm focus:outline-none placeholder:text-slate-400">
                                                        <button type="button" onclick="removeDay(this)"
                                                            class="text-slate-400 hover:text-red-500 hidden group-hover:block transition"
                                                            title="Hapus Hari">
                                                            <i class="ph-bold ph-trash"></i>
                                                        </button>
                                                    </div>
                                                    <textarea rows="2" placeholder="Deskripsi kegiatan hari ini..."
                                                        class="w-full bg-white px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 transition resize-none"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="button" onclick="addItineraryDay()"
                                            class="w-full py-3 border-2 border-dashed border-slate-200 text-slate-500 rounded-xl font-bold text-sm hover:border-orange-400 hover:text-orange-600 hover:bg-orange-50 transition flex items-center justify-center gap-2">
                                            <i class="ph-bold ph-plus-circle"></i> Tambah Hari Perjalanan
                                        </button>
                                    </div>

                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-airplane-tilt text-purple-500 text-xl"></i> Jadwal &
                                    Penerbangan
                                </h3>

                                <div class="space-y-6">

                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-slate-700">Tanggal
                                                Keberangkatan</label>
                                            <input type="date"
                                                class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-slate-700">Durasi (Hari)</label>
                                            <div class="relative">
                                                <input type="number" placeholder="9"
                                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                                <span
                                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Hari</span>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-slate-700">Keberangkatan</label>
                                            <div class="relative">
                                                <i
                                                    class="ph-bold ph-map-pin absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                <input type="text" placeholder="Jakarta (CGK)"
                                                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="p-5 bg-slate-50 rounded-xl border border-slate-100 transition-all duration-300">

                                        <div class="flex items-center justify-between mb-4">
                                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                                <div class="relative">
                                                    <input type="checkbox" id="sameAirlineToggle" class="sr-only peer"
                                                        checked onchange="toggleReturnAirline()">
                                                    <div
                                                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500">
                                                    </div>
                                                </div>
                                                <span class="text-sm font-semibold text-slate-700">Maskapai Pulang Pergi
                                                    sama</span>
                                            </label>
                                            <span class="text-xs text-slate-400 italic hidden sm:block">*Matikan jika
                                                maskapai berbeda</span>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                            <div class="space-y-2 transition-all duration-300 md:col-span-2"
                                                id="departureContainer">
                                                <label class="text-sm font-bold text-slate-700" id="departureLabel">Nama
                                                    Maskapai</label>
                                                <div class="relative">
                                                    <i
                                                        class="ph-bold ph-airplane-tilt absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                    <input type="text" placeholder="Contoh: Garuda Indonesia"
                                                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                                </div>
                                            </div>

                                            <div class="space-y-2 hidden" id="returnContainer">
                                                <label class="text-sm font-bold text-slate-700">Maskapai
                                                    Kepulangan</label>
                                                <div class="relative">
                                                    <i
                                                        class="ph-bold ph-airplane-landing absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                    <input type="text" placeholder="Contoh: Saudia Airlines"
                                                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition bg-white">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-buildings text-yellow-500 text-xl"></i> Akomodasi Hotel
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <div
                                        class="space-y-4 p-5 bg-slate-50 rounded-xl border border-slate-100 group hover:border-orange-200 transition duration-300">
                                        <div
                                            class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2">
                                            <p class="font-bold text-slate-700">Hotel Makkah</p>
                                            <i class="ph-fill ph-kaaba text-slate-400"></i>
                                        </div>

                                        <div
                                            class="relative h-32 w-full rounded-xl border-2 border-dashed border-slate-300 bg-white hover:bg-orange-50 hover:border-orange-400 transition cursor-pointer flex flex-col items-center justify-center group/upload overflow-hidden">
                                            <input type="file" accept="image/*"
                                                class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                                onchange="previewHotelImg(event, 'preview-makkah')">
                                            <div class="text-center p-2" id="placeholder-makkah">
                                                <i
                                                    class="ph-bold ph-image text-2xl text-slate-300 group-hover/upload:text-orange-500 transition mb-1"></i>
                                                <p
                                                    class="text-xs font-bold text-slate-400 group-hover/upload:text-orange-600 transition">
                                                    Foto Hotel
                                                </p>
                                            </div>
                                            <img id="preview-makkah"
                                                class="absolute inset-0 w-full h-full object-cover hidden pointer-events-none">
                                        </div>

                                        <div class="space-y-3">
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Nama Hotel</label>
                                                <input type="text" placeholder="Contoh: Pullman Zamzam"
                                                    class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                            </div>

                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Bintang</label>
                                                <div class="relative">
                                                    <select
                                                        class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white appearance-none transition shadow-sm focus:shadow-md">
                                                        <option value="5">⭐⭐⭐⭐⭐ (Bintang 5)</option>
                                                        <option value="4">⭐⭐⭐⭐ (Bintang 4)</option>
                                                        <option value="3">⭐⭐⭐ (Bintang 3)</option>
                                                        <option value="2">⭐⭐ (Bintang 2)</option>
                                                        <option value="1">⭐ (Bintang 1)</option>
                                                    </select>
                                                    <i
                                                        class="ph-bold ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                                </div>
                                            </div>

                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Jarak ke Masjidil
                                                    Haram</label>
                                                <div class="relative">
                                                    <i
                                                        class="ph-bold ph-person-simple-walk absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                    <input type="text" placeholder="Contoh: 50m (Pelataran)"
                                                        class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                                </div>
                                            </div>

                                            <div class="space-y-1.5 pt-1">
                                                <label class="text-xs font-semibold text-slate-500">Fasilitas
                                                    Hotel</label>
                                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                    <label class="cursor-pointer group">
                                                        <input type="checkbox" class="peer sr-only" checked>
                                                        <div
                                                            class="px-2 py-2 rounded-lg border border-slate-200 bg-white text-slate-500 text-[11px] font-bold text-center transition-all peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 hover:border-orange-300">
                                                            Restoran
                                                        </div>
                                                    </label>
                                                    <label class="cursor-pointer group">
                                                        <input type="checkbox" class="peer sr-only" checked>
                                                        <div
                                                            class="px-2 py-2 rounded-lg border border-slate-200 bg-white text-slate-500 text-[11px] font-bold text-center transition-all peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 hover:border-orange-300">
                                                            Free WiFi
                                                        </div>
                                                    </label>
                                                    <label class="cursor-pointer group">
                                                        <input type="checkbox" class="peer sr-only">
                                                        <div
                                                            class="px-2 py-2 rounded-lg border border-slate-200 bg-white text-slate-500 text-[11px] font-bold text-center transition-all peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 hover:border-orange-300">
                                                            Shuttle Bus
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="space-y-4 p-5 bg-slate-50 rounded-xl border border-slate-100 group hover:border-orange-200 transition duration-300">
                                        <div
                                            class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2">
                                            <p class="font-bold text-slate-700">Hotel Madinah</p>
                                        </div>

                                        <div
                                            class="relative h-32 w-full rounded-xl border-2 border-dashed border-slate-300 bg-white hover:bg-orange-50 hover:border-orange-400 transition cursor-pointer flex flex-col items-center justify-center group/upload overflow-hidden">
                                            <input type="file" accept="image/*"
                                                class="absolute inset-0 opacity-0 cursor-pointer z-10"
                                                onchange="previewHotelImg(event, 'preview-madinah')">
                                            <div class="text-center p-2" id="placeholder-madinah">
                                                <i
                                                    class="ph-bold ph-image text-2xl text-slate-300 group-hover/upload:text-orange-500 transition mb-1"></i>
                                                <p
                                                    class="text-xs font-bold text-slate-400 group-hover/upload:text-orange-600 transition">
                                                    Foto Hotel
                                                </p>
                                            </div>
                                            <img id="preview-madinah"
                                                class="absolute inset-0 w-full h-full object-cover hidden pointer-events-none">
                                        </div>

                                        <div class="space-y-3">
                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Nama Hotel</label>
                                                <input type="text" placeholder="Contoh: Anwar Al Madinah"
                                                    class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                            </div>

                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Bintang</label>
                                                <div class="relative">
                                                    <select
                                                        class="w-full px-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white appearance-none transition shadow-sm focus:shadow-md">
                                                        <option value="5">⭐⭐⭐⭐⭐ (Bintang 5)</option>
                                                        <option value="4">⭐⭐⭐⭐ (Bintang 4)</option>
                                                        <option value="3">⭐⭐⭐ (Bintang 3)</option>
                                                        <option value="2">⭐⭐ (Bintang 2)</option>
                                                        <option value="1">⭐ (Bintang 1)</option>
                                                    </select>
                                                    <i
                                                        class="ph-bold ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                                                </div>
                                            </div>

                                            <div class="space-y-1.5">
                                                <label class="text-xs font-semibold text-slate-500">Jarak ke Masjid
                                                    Nabawi</label>
                                                <div class="relative">
                                                    <i
                                                        class="ph-bold ph-person-simple-walk absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                                    <input type="text" placeholder="Contoh: 100m (Pintu 338)"
                                                        class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 bg-white transition shadow-sm focus:shadow-md">
                                                </div>
                                            </div>

                                            <div class="space-y-1.5 pt-1">
                                                <label class="text-xs font-semibold text-slate-500">Fasilitas
                                                    Hotel</label>
                                                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                                    <label class="cursor-pointer group">
                                                        <input type="checkbox" class="peer sr-only" checked>
                                                        <div
                                                            class="px-2 py-2 rounded-lg border border-slate-200 bg-white text-slate-500 text-[11px] font-bold text-center transition-all peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 hover:border-orange-300">
                                                            Restoran
                                                        </div>
                                                    </label>
                                                    <label class="cursor-pointer group">
                                                        <input type="checkbox" class="peer sr-only" checked>
                                                        <div
                                                            class="px-2 py-2 rounded-lg border border-slate-200 bg-white text-slate-500 text-[11px] font-bold text-center transition-all peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 hover:border-orange-300">
                                                            Free WiFi
                                                        </div>
                                                    </label>
                                                    <label class="cursor-pointer group">
                                                        <input type="checkbox" class="peer sr-only">
                                                        <div
                                                            class="px-2 py-2 rounded-lg border border-slate-200 bg-white text-slate-500 text-[11px] font-bold text-center transition-all peer-checked:border-orange-500 peer-checked:bg-orange-50 peer-checked:text-orange-700 hover:border-orange-300">
                                                            Lift
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-money text-green-600 text-xl"></i> Harga Paket
                                </h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <label class="text-sm font-bold text-slate-700">Harga Quad</label>
                                        </div>
                                        <div class="relative">
                                            <span
                                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                            <input type="text" placeholder="30.000.000" oninput="formatCurrency(this)"
                                                class="currency-input w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-lg font-bold focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <label class="text-sm font-bold text-slate-700">Harga Triple</label>
                                        </div>
                                        <div class="relative">
                                            <span
                                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                            <input type="text" placeholder="32.500.000" oninput="formatCurrency(this)"
                                                class="currency-input w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-lg font-bold focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                    </div>

                                    <div class="space-y-2 md:col-span-2">
                                        <div class="flex justify-between">
                                            <label class="text-sm font-bold text-slate-700">Harga Double</label>
                                        </div>
                                        <div class="relative">
                                            <span
                                                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold">Rp</span>
                                            <input type="text" placeholder="35.000.000" oninput="formatCurrency(this)"
                                                class="currency-input w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-lg font-bold focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-shield-check text-orange-500 text-xl"></i> Syarat &
                                    Ketentuan
                                </h3>

                                <div class="space-y-4">

                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700 block">
                                            Daftar Poin
                                        </label>
                                        <div class="flex gap-2">
                                            <input type="text" id="input-syarat"
                                                placeholder="Ketik syarat lalu tekan Enter (Misal: Paspor)"
                                                class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-orange-500 transition"
                                                onkeypress="handleEnter(event, 'syarat')">
                                            <button type="button" onclick="addItem('syarat')"
                                                class="bg-orange-100 text-orange-700 p-2.5 rounded-xl hover:bg-orange-200 transition">
                                                <i class="ph-bold ph-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <ul id="list-syarat" class="space-y-2">
                                        <li
                                            class="flex justify-between items-center bg-orange-50 px-3 py-2 rounded-lg border border-orange-100">
                                            <span class="text-sm text-orange-800 font-medium">Paspor</span>
                                            <button onclick="this.parentElement.remove()"
                                                class="text-orange-400 hover:text-red-500 transition">
                                                <i class="ph-bold ph-x"></i>
                                            </button>
                                        </li>
                                        <li
                                            class="flex justify-between items-center bg-orange-50 px-3 py-2 rounded-lg border border-orange-100">
                                            <span class="text-sm text-orange-800 font-medium">KTP</span>
                                            <button onclick="this.parentElement.remove()"
                                                class="text-orange-400 hover:text-red-500 transition">
                                                <i class="ph-bold ph-x"></i>
                                            </button>
                                        </li>
                                        <li
                                            class="flex justify-between items-center bg-orange-50 px-3 py-2 rounded-lg border border-orange-100">
                                            <span class="text-sm text-orange-800 font-medium">Pas Foto (Latar
                                                Putih)</span>
                                            <button onclick="this.parentElement.remove()"
                                                class="text-orange-400 hover:text-red-500 transition">
                                                <i class="ph-bold ph-x"></i>
                                            </button>
                                        </li>
                                    </ul>

                                </div>
                            </div>

                            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                                <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                                    <i class="ph-duotone ph-notebook text-orange-500 text-xl"></i> Catatan & Deskripsi
                                </h3>

                                <div class="space-y-8">

                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700 block">
                                            Tentang Paket / Deskripsi Singkat
                                        </label>
                                        <p class="text-xs text-slate-500 mb-2">Jelaskan keunggulan atau ringkasan paket
                                            ini.</p>
                                        <textarea rows="5"
                                            placeholder="Contoh: Paket Umrah Easy ini dirancang khusus untuk jamaah yang menginginkan kenyamanan dengan harga terjangkau..."
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition resize-none leading-relaxed"></textarea>
                                    </div>

                                    <hr class="border-slate-100">

                                    <div class="space-y-3">
                                        <div class="flex justify-between items-end">
                                            <label class="text-sm font-bold text-slate-700 flex items-center gap-2">
                                                <i class="ph-fill ph-warning-circle text-orange-500"></i> Poin Catatan
                                                Penting
                                            </label>
                                        </div>

                                        <div class="flex gap-2">
                                            <input type="text" id="input-catatan"
                                                placeholder="Ketik poin catatan lalu Enter (Misal: Harga dapat berubah sewaktu-waktu)"
                                                class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:border-orange-500 transition"
                                                onkeypress="handleEnter(event, 'catatan')">
                                            <button type="button" onclick="addItem('catatan')"
                                                class="bg-orange-100 text-orange-700 p-2.5 rounded-xl hover:bg-orange-200 transition">
                                                <i class="ph-bold ph-plus"></i>
                                            </button>
                                        </div>

                                        <ul id="list-catatan" class="space-y-2">
                                            <li
                                                class="flex justify-between items-center bg-orange-50 px-3 py-2 rounded-lg border border-orange-100">
                                                <span class="text-sm text-orange-800 font-medium">Harga dapat berubah
                                                    sewaktu-waktu</span>
                                                <button onclick="this.parentElement.remove()"
                                                    class="text-orange-400 hover:text-red-500 transition">
                                                    <i class="ph-bold ph-x"></i>
                                                </button>
                                            </li>
                                            <li
                                                class="flex justify-between items-center bg-orange-50 px-3 py-2 rounded-lg border border-orange-100">
                                                <span class="text-sm text-orange-800 font-medium">Pelunasan maksimal
                                                    H-30 keberangkatan</span>
                                                <button onclick="this.parentElement.remove()"
                                                    class="text-orange-400 hover:text-red-500 transition">
                                                    <i class="ph-bold ph-x"></i>
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>

                            <div class="md:hidden pt-4 pb-8 space-y-3">
                                <button type="submit"
                                    class="w-full py-3.5 rounded-xl bg-orange-600 text-white font-bold hover:bg-orange-700 shadow-lg shadow-orange-500/20 transition flex items-center justify-center gap-2">
                                    <i class="ph-bold ph-paper-plane-right"></i> Terbitkan Paket
                                </button>
                                <button type="button"
                                    class="w-full py-3.5 rounded-xl border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition">
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <script>
        AOS.init({ duration: 800, once: true });

        // 1. Logic untuk Fasilitas (Termasuk / Tidak Termasuk)
        function addItem(type) {
            const input = document.getElementById(`input-${type}`);
            const list = document.getElementById(`list-${type}`);
            const value = input.value.trim();

            if (value) {
                const li = document.createElement('li');
                const colorClass = type === 'included' ? 'bg-green-50 border-green-100 text-green-800' : 'bg-red-50 border-red-100 text-red-800';
                const btnColor = type === 'included' ? 'text-green-400' : 'text-red-400';

                li.className = `flex justify-between items-center ${colorClass} px-3 py-2 rounded-lg border animate-fade-in-down`;
                li.innerHTML = `
                <span class="text-sm font-medium">${value}</span>
                <button type="button" onclick="this.parentElement.remove()" class="${btnColor} hover:text-red-500 transition"><i class="ph-bold ph-x"></i></button>
            `;

                list.appendChild(li);
                input.value = ''; // Reset input
                input.focus();
            }
        }

        // Handle Enter Key untuk Fasilitas
        function handleEnter(event, type) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Mencegah submit form
                addItem(type);
            }
        }

        // 2. Logic untuk Itinerary (Tambah Hari)
        function addItineraryDay() {
            const container = document.getElementById('itinerary-container');
            const dayCount = container.children.length + 1; // Hitung hari ke berapa

            const div = document.createElement('div');
            div.className = 'relative pl-6 pb-8 itinerary-item';
            div.innerHTML = `
            <div class="absolute -left-[21px] top-0 w-10 h-10 bg-white border-2 border-orange-100 rounded-full flex items-center justify-center text-orange-600 font-bold text-xs shadow-sm z-10">
                H${dayCount}
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 group hover:border-orange-200 transition">
                <div class="flex justify-between mb-2">
                    <input type="text" placeholder="Judul Kegiatan (Misal: City Tour Makkah)" 
                        class="w-full bg-transparent font-bold text-slate-800 text-sm focus:outline-none placeholder:text-slate-400">
                    <button type="button" onclick="removeDay(this)" class="text-slate-400 hover:text-red-500 transition" title="Hapus Hari">
                        <i class="ph-bold ph-trash"></i>
                    </button>
                </div>
                <textarea rows="2" placeholder="Deskripsi kegiatan hari ini..." 
                    class="w-full bg-white px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:border-orange-500 transition resize-none"></textarea>
            </div>
        `;
            container.appendChild(div);
        }

        // Hapus Hari & Re-order nomor hari
        function removeDay(btn) {
            const item = btn.closest('.itinerary-item');
            item.remove();

            // Re-calculate Day Numbers (H1, H2, H3...)
            const items = document.querySelectorAll('.itinerary-item');
            items.forEach((el, index) => {
                const badge = el.querySelector('.absolute');
                badge.innerText = `H${index + 1}`;
            });
        }

        // Penerbangan
        function toggleReturnAirline() {
            const isChecked = document.getElementById('sameAirlineToggle').checked;
            const departureContainer = document.getElementById('departureContainer');
            const returnContainer = document.getElementById('returnContainer');
            const departureLabel = document.getElementById('departureLabel');
            const departureIcon = departureContainer.querySelector('i');

            if (isChecked) {
                // Mode: Maskapai Sama (PP)
                returnContainer.classList.add('hidden');
                departureContainer.classList.remove('md:col-span-1');
                departureContainer.classList.add('md:col-span-2'); // Full width
                departureLabel.innerText = "Nama Maskapai (PP)";
                departureIcon.classList.replace('ph-airplane-takeoff', 'ph-airplane-tilt');
            } else {
                // Mode: Maskapai Beda
                returnContainer.classList.remove('hidden');
                departureContainer.classList.remove('md:col-span-2');
                departureContainer.classList.add('md:col-span-1'); // Half width
                departureLabel.innerText = "Maskapai Keberangkatan";
                departureIcon.classList.replace('ph-airplane-tilt', 'ph-airplane-takeoff');
            }
        }

        // Akomodasi Hotel
        function previewHotelImg(event, previewId) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.getElementById(previewId);
                    img.src = e.target.result;
                    img.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // --- UX FUNCTION: Logout Confirmation ---
        function confirmLogout() {
            Swal.fire({
                title: 'Keluar dari Akun?',
                text: "Anda harus masuk kembali untuk mengakses Profil & Pesanan Masuk",
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
        function formatCurrency(input) {
            // 1. Ambil value asli dan hapus karakter selain angka
            let value = input.value.replace(/\D/g, '');

            // 2. Format angka dengan titik sebagai pemisah ribuan
            if (value !== '') {
                value = new Intl.NumberFormat('id-ID').format(value);
            }

            // 3. Kembalikan value yang sudah diformat ke input
            input.value = value;
        }
    </script>

    <script>
        // --- 1. Logic Simpan Draft (Simple Toast) ---
        function handleDraft() {
            // Tampilkan Loading sebentar (Simulasi proses simpan)
            let timerInterval;
            Swal.fire({
                title: 'Menyimpan Draft...',
                html: 'Mohon tunggu sebentar.',
                timer: 1000, // 1 detik loading
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                // Setelah loading selesai, tampilkan notifikasi sukses
                Swal.fire({
                    icon: 'info',
                    title: 'Draft Disimpan',
                    text: 'Produk telah masuk ke daftar arsip.',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Redirect ke halaman kelola produk
                    window.location.href = "/marketplace/travel/kelola-produk/";
                });
            });
        }

        // --- 2. Logic Terbitkan (Confirmation Modal) ---
        function handlePublish() {
            Swal.fire({
                title: 'Terbitkan Paket?',
                text: "Paket akan langsung tampil di halaman pencarian jamaah.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ea580c', // Warna Orange
                cancelButtonColor: '#64748b',  // Warna Slate
                confirmButtonText: 'Ya, Terbitkan!',
                cancelButtonText: 'Batal, cek lagi'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user klik Ya
                    Swal.fire({
                        title: 'Berhasil Diterbitkan!',
                        text: 'Paket Anda kini sudah Terbit.',
                        icon: 'success',
                        confirmButtonColor: '#ea580c'
                    }).then(() => {
                        // Redirect ke halaman kelola produk
                        window.location.href = "/marketplace/travel/kelola-produk/";
                    });
                }
            });
        }
    </script>

</body>

</html>