<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Profil Travel - Pengenumroh</title>
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .form-input:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
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

        $noWa = $userData['no_wa'] ?? '';

        $bankType = $userData['bank_type'] ?? 'pusat'; // Default rekening pusat
        $bankName = $userData['bank_name'] ?? '';
        $bankAccount = $userData['bank_account'] ?? '';
        $bankOwner = $userData['bank_owner'] ?? '';
        
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
                    <img src="/assets/img/marketplace/logo.png" alt="Logo PengenUmroh" class="h-10 w-auto object-contain">
                </a>

                <div class="hidden lg:flex items-center gap-4">
                    <a href="/marketplace/" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-600 transition bg-slate-50 px-4 py-2 rounded-full border border-slate-100 hover:bg-orange-50 hover:border-orange-100">
                        <i class="ph-bold ph-arrow-left"></i> Kembali ke Beranda
                    </a>

                    <div class="h-6 w-px bg-slate-200 mx-2"></div>

                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-700">{{ $namaTravel }}</p>
                            <p class="text-[10px] text-slate-500">Mitra Travel</p>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-slate-100 overflow-hidden border border-slate-200">
                            <img id="nav-avatar" src="{{ $avatar }}" class="w-full h-full object-cover">
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

                <!-- SIDEBAR KIRI -->
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
                                    <span class="font-bold {{ $isAktif ? 'text-emerald-600' : 'text-red-600' }}">
                                        {{ $isAktif ? 'Aktif' : 'Menunggu Verifikasi' }}
                                    </span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="{{ $isAktif ? 'bg-emerald-500' : 'bg-red-500' }} h-2 rounded-full transition-all duration-1000 w-full"></div>
                                </div>
                                <p class="text-[11px] mt-2 flex items-center gap-1 font-medium px-2 py-1 rounded-lg {{ $isAktif ? 'text-emerald-700 bg-emerald-50' : 'text-red-700 bg-red-50' }}">
                                    <i class="ph-fill {{ $isAktif ? 'ph-check-circle text-emerald-600' : 'ph-clock text-red-600' }}"></i>
                                    {{ $isAktif ? 'Mitra Travel Terverifikasi' : 'Harap Lengkapi Data' }}
                                </p>
                            </div>
                        </div>
                    </div>

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">

                <nav class="flex flex-col">
                    <!-- Menu Profil -->
                    <a href="{{ route('marketplace.travel.profil') }}" 
                    class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.profil') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <i class="ph-bold ph-user text-xl"></i> Profil
                    </a>

                    <!-- Menu Pesanan Masuk -->
                    <a href="{{ route('marketplace.travel.pesanan-masuk') }}" 
                    class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.pesanan-masuk') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <i class="ph-bold ph-receipt text-xl"></i> Pesanan Masuk
                    </a>

                    <!-- Menu Upload Produk -->
                    <a href="{{ route('marketplace.travel.upload-produk') }}" 
                    class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.upload-produk') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <i class="ph-bold ph-upload text-xl"></i> Upload Produk
                    </a>

                    <!-- Menu Kelola Produk -->
                    <a href="{{ route('marketplace.travel.kelola-produk') }}" 
                    class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.travel.kelola-produk') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                        <i class="ph-bold ph-package text-xl"></i> Kelola Produk
                    </a>
                </nav>

                        <div class="mt-auto border-t border-slate-100 p-2 bg-slate-50">
                            <form id="logout-form" action="/logout" method="POST" class="hidden">
                                @csrf
                            </form>
                            <button onclick="confirmLogout()" class="flex w-full items-center justify-center gap-2 px-5 py-3 text-red-600 hover:bg-red-100/50 hover:text-red-700 font-bold transition rounded-xl text-sm border border-transparent hover:border-red-100">
                                <i class="ph-bold ph-sign-out text-lg"></i> Keluar Akun
                            </button>
                        </div>
                    </div>
                </div>

                <!-- FORM UPDATE PROFIL -->
                <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="100">
                    
                    <!-- 👇 KOTAK 1: PROFIL UTAMA 👇 -->
                    <form id="profileForm" action="{{ route('marketplace.travel.profil.update') }}" method="POST" enctype="multipart/form-data" onsubmit="showLoading(event)">
                        @csrf
                        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">
                            <div class="flex items-center justify-between mb-8">
                                <div>
                                    <h1 class="text-2xl font-bold text-slate-900">Edit Profil Biro/Travel</h1>
                                    <p class="text-slate-500 text-sm mt-1">Perbarui informasi kontak perusahaan Anda.</p>
                                </div>
                                <button type="submit" id="btn-save-desktop" class="hidden md:flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-orange-500/20 transition transform active:scale-95">
                                    <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
                                </button>
                            </div>
                            
                            <div class="flex items-center gap-6 mb-8 pb-8 border-b border-slate-100">
                                <div class="relative group cursor-pointer">
                                    <div class="w-24 h-24 rounded-full overflow-hidden bg-slate-100 border-2 border-slate-200 group-hover:border-orange-500 transition">
                                        <img id="preview-avatar" src="{{ $avatar }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                        <i class="ph-bold ph-camera text-white text-2xl"></i>
                                    </div>
                                    <input type="file" id="file-input" name="avatar" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(event)">
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900">Logo Travel</h3>
                                    <p class="text-xs text-slate-500 mb-3">Format: JPG, PNG. Maksimal 2MB.</p>
                                    <div class="flex gap-3">
                                        <button type="button" onclick="document.getElementById('file-input').click()" class="text-sm font-bold text-orange-600 hover:bg-orange-50 px-3 py-1.5 rounded-lg transition">Ubah Foto</button>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700">Nama Travel/Biro</label>
                                    <div class="relative">
                                        <i class="ph-duotone ph-buildings absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                        <input type="text" name="fullname" value="{{ $namaTravel }}" class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition shadow-sm" placeholder="Nama Travel/Biro" required>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700">Email Utama</label>
                                    <div class="relative">
                                        <i class="ph-bold ph-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                        <input type="email" value="{{ $emailTravel }}" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-500 text-sm font-medium focus:outline-none bg-slate-50 cursor-not-allowed" readonly title="Email tidak dapat diubah">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold flex items-center gap-1">
                                            <i class="ph-bold ph-check"></i> Verified
                                        </span>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700">No Telp / WhatsApp</label>
                                    <div class="relative">
                                        <i class="ph-bold ph-whatsapp-logo absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                        {{-- 👇 PASTIKAN name="no_wa" SESUAI DATABASE 👇 --}}
                                        <input type="text" name="no_wa" value="{{ $noWa }}" class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition shadow-sm" placeholder="Contoh: 081234567890" required>
                                    </div>
                                </div>
                            </div>

                            {{-- 👇 TAMBAHAN: PENGATURAN REKENING PEMBAYARAN 👇 --}}
                            <hr class="border-slate-100 my-8">
                            <div>
                                @php
                                    $rekMode = $userData['rekening_mode'] ?? 'MARKETPLACE';
                                    // Data list rekening travel dari backend (Asumsi array)
                                    $listRekening = $userData['rekening'] ?? []; 
                                @endphp

                                <h3 class="font-bold text-slate-900 mb-1">Pengaturan Rekening Pembayaran</h3>
                                <p class="text-sm text-slate-500 mb-6">Tentukan rekening tujuan untuk menerima dana transaksi dari jamaah.</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <!-- Opsi 1: Rekening Pusat -->
                                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:border-orange-400 focus:outline-none transition-all has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50/50 has-[:checked]:ring-1 has-[:checked]:ring-orange-500">
                                        <input type="radio" name="rekening_mode" value="MARKETPLACE" class="peer sr-only" onchange="toggleRekeningAJAX('MARKETPLACE')" {{ $rekMode === 'MARKETPLACE' ? 'checked' : '' }}>
                                        <div class="flex w-full items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-orange-100 text-orange-600 peer-checked:bg-orange-500 peer-checked:text-white transition">
                                                    <i class="ph-bold ph-buildings text-xl"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-900">Rekening Pusat Platform</p>
                                                    <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5">PT Kolaborasi Para Sahabat (BCA/BSI)</p>
                                                </div>
                                            </div>
                                            <i class="ph-fill ph-check-circle text-2xl text-orange-500 opacity-0 peer-checked:opacity-100 transition"></i>
                                        </div>
                                    </label>

                                    <!-- Opsi 2: Rekening Sendiri -->
                                    <label class="relative flex cursor-pointer rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:border-orange-400 focus:outline-none transition-all has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/50 has-[:checked]:ring-1 has-[:checked]:ring-blue-500">
                                        <input type="radio" name="rekening_mode" value="MANDIRI" class="peer sr-only" onchange="toggleRekeningAJAX('MANDIRI')" {{ $rekMode === 'MANDIRI' ? 'checked' : '' }}>
                                        <div class="flex w-full items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-blue-600 peer-checked:bg-blue-500 peer-checked:text-white transition">
                                                    <i class="ph-bold ph-wallet text-xl"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-slate-900">Rekening Travel Sendiri</p>
                                                    <p class="text-[10px] sm:text-xs text-slate-500 mt-0.5">Dana langsung masuk ke rekening Anda</p>
                                                </div>
                                            </div>
                                            <i class="ph-fill ph-check-circle text-2xl text-blue-500 opacity-0 transition peer-checked:opacity-100"></i>
                                        </div>
                                    </label>
                                </div>

                                <!-- Info Rekening Pusat -->
                                <div id="pusat-bank-fields" class="mb-6 transition-all duration-300 {{ $rekMode === 'MARKETPLACE' ? 'block opacity-100' : 'hidden opacity-0' }}">
                                    <label class="text-sm font-bold text-slate-700 block mb-2">Rekening Pusat Platform</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0"><i class="ph-bold ph-bank text-lg"></i></div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-slate-800">BCA</p>
                                                <p class="text-sm font-mono font-bold text-slate-700 tracking-wide">7131720452</p>
                                                <p class="text-[11px] text-slate-500 mt-0.5 truncate">PT Kolaborasi Para Sahabat</p>
                                            </div>
                                        </div>
                                        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0"><i class="ph-bold ph-bank text-lg"></i></div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-slate-800">BSI</p>
                                                <p class="text-sm font-mono font-bold text-slate-700 tracking-wide">7215671498</p>
                                                <p class="text-[11px] text-slate-500 mt-0.5 truncate">PT Kolaborasi Para Sahabat</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Input Bank Custom (AJAX 1-by-1) -->
                                <div id="custom-bank-fields" class="transition-all duration-300 {{ $rekMode === 'MANDIRI' ? 'block opacity-100' : 'hidden opacity-0' }}">
                                    <div class="flex items-center justify-between mb-3">
                                        <label class="text-sm font-bold text-slate-700">Rekening Travel Anda</label>
                                        <button type="button" onclick="addNewBankRow()" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-200 transition active:scale-95">
                                            <i class="ph-bold ph-plus text-sm"></i> Tambah Rekening
                                        </button>
                                    </div>
                                    <div id="bank-accounts-list" class="space-y-4"></div>
                                    <p id="bank-accounts-empty" class="hidden text-xs text-slate-400 border border-dashed border-slate-200 rounded-xl p-5 text-center">
                                        Belum ada rekening. Klik "Tambah Rekening" untuk menambahkan.
                                    </p>
                                </div>

                                <!-- Template baris rekening (AJAX Edition) -->
                                <template id="bank-account-row-template">
                                    <div class="bank-account-row bg-white border border-slate-200 hover:border-blue-300 rounded-xl p-4 shadow-sm transition-all">
                                        <!-- Hidden ID -->
                                        <input type="hidden" class="rek-id-input" value="">
                                        
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                            <div class="space-y-1.5">
                                                <label class="text-[10px] font-bold text-slate-500 uppercase">Nama Bank</label>
                                                <div class="relative">
                                                    <i class="ph-bold ph-bank absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                                    <select class="rek-name-input w-full pl-9 pr-8 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition appearance-none bg-white" required>
                                                        <option value="" disabled selected>Pilih Bank</option>
                                                        <option value="BSI">BSI</option>
                                                        <option value="BCA">BCA</option>
                                                        <option value="Mandiri">Mandiri</option>
                                                        <option value="BNI">BNI</option>
                                                        <option value="BRI">BRI</option>
                                                    </select>
                                                    <i class="ph-bold ph-caret-down absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-sm"></i>
                                                </div>
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-[10px] font-bold text-slate-500 uppercase">No. Rekening</label>
                                                <div class="relative">
                                                    <i class="ph-bold ph-hash absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                                    <input type="text" inputmode="numeric" class="rek-account-input w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition" placeholder="1234567890" required>
                                                </div>
                                            </div>
                                            <div class="space-y-1.5">
                                                <label class="text-[10px] font-bold text-slate-500 uppercase">Atas Nama</label>
                                                <div class="relative">
                                                    <i class="ph-bold ph-user-circle absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
                                                    <input type="text" class="rek-owner-input w-full pl-9 pr-3 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition" placeholder="Sesuai Tabungan" required>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Aksi Button -->
                                        <div class="flex justify-end gap-2 mt-4 pt-4 border-t border-slate-100">
                                            <button type="button" onclick="deleteRekeningAJAX(this)" class="px-4 py-2 text-[11px] font-bold text-red-500 hover:bg-red-50 border border-red-100 rounded-lg transition active:scale-95">Hapus</button>
                                            <button type="button" onclick="saveRekeningAJAX(this)" class="btn-save-rek px-5 py-2 text-[11px] font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-500/20 rounded-lg transition active:scale-95 flex items-center gap-1.5"><i class="ph-bold ph-floppy-disk"></i> Simpan Rekening</button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="md:hidden mt-6">
                                <button type="submit" id="btn-save-mobile" class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/20 transition active:scale-95">
                                    <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>

                    {{-- 👇 KOTAK 2: KEAMANAN AKUN (Ubah Password) 👇 --}}
                    <div class="border rounded-2xl p-5 md:p-8 bg-white border-slate-200 mt-8 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-5 pb-5 border-b border-slate-100">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                                    <i class="ph-fill ph-lock-key text-xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">Keamanan Akun</h4>
                                    <p class="text-xs text-slate-500 mt-0.5">Ubah kata sandi secara berkala</p>
                                </div>
                            </div>
                            <button type="button" onclick="togglePasswordForm()" id="btn-toggle-password" class="mt-4 sm:mt-0 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-sm font-bold rounded-lg transition border border-slate-200">
                                Ubah Password
                            </button>
                        </div>

                        <div id="password-form-container" class="hidden mt-8 border-t border-slate-200 pt-8">
                            <form id="passwordForm" action="{{ route('marketplace.travel.profil.password') }}" method="POST">
                                @csrf
                                
                                {{-- STEP 1: Password Lama --}}
                                <div id="step-1-password" class="max-w-md">
                                    <div class="mb-5">
                                        <h3 class="text-base font-bold text-slate-800">Verifikasi Identitas</h3>
                                        <p class="text-sm text-slate-500 mt-1">Masukkan password Anda saat ini untuk melanjutkan.</p>
                                    </div>
                                    <div class="space-y-4">
                                        <div class="relative">
                                            <i class="ph-bold ph-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                            <input type="password" id="current_password" name="current_password" required class="form-input w-full pl-11 pr-12 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none transition shadow-sm" placeholder="Password saat ini">
                                            <button type="button" onclick="togglePassword('current_password', 'icon-eye-current')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-orange-500 transition focus:outline-none">
                                                <i id="icon-eye-current" class="ph-bold ph-eye text-lg"></i>
                                            </button>
                                        </div>
                                        <button type="button" id="btn-next-password" onclick="goToNextStep()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-md shadow-slate-900/10 transition active:scale-95">
                                            Lanjut <i class="ph-bold ph-arrow-right"></i>
                                        </button>
                                    </div>
                                </div>

                                {{-- STEP 2: Password Baru --}}
                                <div id="step-2-password" class="hidden opacity-0 transition-opacity duration-500 mt-8 pt-8 border-t border-dashed border-slate-200 gap-6 md:grid-cols-2">
                                    <div class="md:col-span-2 mb-1">
                                        <h3 class="text-base font-bold text-slate-800">Buat Password Baru</h3>
                                        <p class="text-sm text-slate-500 mt-1">Pastikan password baru Anda terdiri dari minimal 6 karakter.</p>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700">Password Baru</label>
                                        <div class="relative">
                                            <i class="ph-bold ph-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                            <input type="password" id="new_password" name="new_password" required minlength="6" class="form-input w-full pl-11 pr-12 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none transition shadow-sm" placeholder="Minimal 6 karakter">
                                            <button type="button" onclick="togglePassword('new_password', 'icon-eye-new')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-orange-500 transition focus:outline-none">
                                                <i id="icon-eye-new" class="ph-bold ph-eye text-lg"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm font-bold text-slate-700">Konfirmasi Password Baru</label>
                                        <div class="relative">
                                            <i class="ph-bold ph-check-circle absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                                            <input type="password" id="confirm_password" name="new_password_confirmation" required minlength="6" class="form-input w-full pl-11 pr-12 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none transition shadow-sm" placeholder="Ulangi password baru">
                                            <button type="button" onclick="togglePassword('confirm_password', 'icon-eye-confirm')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-orange-500 transition focus:outline-none">
                                                <i id="icon-eye-confirm" class="ph-bold ph-eye text-lg"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="md:col-span-2 mt-4 flex justify-start">
                                        <button type="submit" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/20 transition transform active:scale-95">
                                            <i class="ph-bold ph-floppy-disk text-lg"></i> Simpan Password Baru
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // JS untuk Preview Gambar Instan
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-avatar').src = e.target.result;
                    document.getElementById('sidebar-avatar').src = e.target.result;
                    document.getElementById('nav-avatar').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // --- SCRIPT FORM UBAH PASSWORD ---
        function togglePasswordForm() {
            const container = document.getElementById('password-form-container');
            const btn = document.getElementById('btn-toggle-password');
            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                btn.textContent = 'Batal Ubah';
                btn.classList.replace('bg-slate-50', 'bg-red-50');
                btn.classList.replace('text-slate-700', 'text-red-600');
            } else {
                container.classList.add('hidden');
                btn.textContent = 'Ubah Password';
                btn.classList.replace('bg-red-50', 'bg-slate-50');
                btn.classList.replace('text-red-600', 'text-slate-700');
                
                // Reset Form
                document.getElementById('step-2-password').classList.remove('grid');
                document.getElementById('step-2-password').classList.add('hidden', 'opacity-0');
                document.getElementById('btn-next-password').classList.remove('hidden');
                document.getElementById('current_password').disabled = false;
                document.getElementById('passwordForm').reset();
            }
        }

        function goToNextStep() {
            const currentPass = document.getElementById('current_password').value;
            
            // 1. Cek kalau kosong
            if (currentPass.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tunggu Dulu',
                    text: 'Masukkan password Anda saat ini terlebih dahulu.',
                    confirmButtonColor: '#ea580c'
                });
                return;
            }

            // 👇 2. Cek kalau kurang dari 6 karakter (VALIDASI BARU) 👇
            if (currentPass.length < 6) {
                Swal.fire({
                    icon: 'error', // Pakai icon error biar kerasa tegas
                    title: 'Password Tidak Valid!',
                    text: 'Password saat ini tidak mungkin kurang dari 6 karakter.',
                    confirmButtonColor: '#ea580c'
                });
                return;
            }
            
            // Kalau lolos validasi, kunci input dan sembunyikan tombol lanjut
            document.getElementById('current_password').disabled = true;
            
            if(!document.getElementById('hidden_current_pass')){
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.id = 'hidden_current_pass';
                hiddenInput.name = 'current_password';
                hiddenInput.value = currentPass;
                document.getElementById('passwordForm').appendChild(hiddenInput);
            } else {
                document.getElementById('hidden_current_pass').value = currentPass;
            }
            
            document.getElementById('btn-next-password').classList.add('hidden');
            
            // Munculkan form Step 2
            const step2 = document.getElementById('step-2-password');
            step2.classList.remove('hidden');
            step2.classList.add('grid');
            setTimeout(() => {
                step2.classList.remove('opacity-0');
            }, 50);
        }

        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ph-eye', 'ph-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('ph-eye-slash', 'ph-eye');
            }
        }

        // --- VALIDASI FORM UBAH PASSWORD (FRONTEND) ---
        document.getElementById('passwordForm').addEventListener('submit', function(event) {
            const newPass = document.getElementById('new_password').value;
            const confirmPass = document.getElementById('confirm_password').value;

            // Cek minimal 6 karakter
            if (newPass.length < 6) {
                event.preventDefault(); // Hentikan pengiriman form
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Terlalu Pendek!',
                    text: 'Password baru harus terdiri dari minimal 6 karakter.',
                    confirmButtonColor: '#ea580c'
                });
                return false;
            }

            // Cek kecocokan password & konfirmasi
            if (newPass !== confirmPass) {
                event.preventDefault(); // Hentikan pengiriman form
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Tidak Cocok!',
                    text: 'Konfirmasi password tidak sama dengan password baru.',
                    confirmButtonColor: '#ea580c'
                });
                return false;
            }

            // Kalau lolos semua, form otomatis lanjut submit ke server
            // Bisa tambahin animasi loading tipis-tipis di tombolnya
            const btnSubmit = this.querySelector('button[type="submit"]');
            btnSubmit.innerHTML = '<i class="ph-bold ph-spinner animate-spin text-lg"></i> Menyimpan...';
            btnSubmit.disabled = true;
            btnSubmit.classList.add('opacity-75', 'cursor-not-allowed');
        });

        // JS Animasi Tombol Submit
        function showLoading(event) {
            // 1. Tahan form biar halamannya gak langsung refresh
            if (event) event.preventDefault(); 
            
            // 2. Ubah teks tombol jadi loading
            const btnDesktop = document.getElementById('btn-save-desktop');
            const btnMobile = document.getElementById('btn-save-mobile');
            const loadingContent = '<i class="ph-bold ph-spinner animate-spin"></i> Menyimpan...';
            
            if (btnDesktop && window.innerWidth >= 768) {
                btnDesktop.innerHTML = loadingContent;
                btnDesktop.disabled = true;
                btnDesktop.classList.add('opacity-75', 'cursor-not-allowed');
            } else if (btnMobile) {
                btnMobile.innerHTML = loadingContent;
                btnMobile.disabled = true;
                btnMobile.classList.add('opacity-75', 'cursor-not-allowed');
            }

            // 3. Munculkan SweetAlert Loading
            Swal.fire({
                title: 'Menyimpan Profil...',
                text: 'Mohon tunggu sebentar, data sedang diproses.',
                allowOutsideClick: false, 
                showConfirmButton: false, 
                didOpen: () => {
                    Swal.showLoading(); 
                }
            });

            // 4. Setelah 1.2 detik, ubah jadi Centang Success, lalu submit ke Laravel
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data profil berhasil diproses.',
                    showConfirmButton: false,
                    timer: 1500 // Centang hijau muncul selama 1.5 detik
                }).then(() => {
                    // Setelah centang selesai, form aslinya baru diteruskan ke server
                    document.getElementById('profileForm').submit();
                });
            }, 1200); // 1200ms = 1.2 detik (waktu animasi loading muter)
        }

        // UX FUNCTION: Logout
        function confirmLogout() {
            Swal.fire({
                title: 'Keluar dari Akun?',
                text: "Sesi Anda sebagai Mitra Travel akan diakhiri.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Keluar Akun',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

   <!-- NOTIFIKASI DARI LARAVEL -->
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#ea580c',
            timer: 3000
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc2626'
        });
    </script>
    @endif

    <script>
    // --- 1. TOGGLE MODE MARKETPLACE VS MANDIRI ---
    function toggleRekeningAJAX(mode) {
        // Tembak API Backend
        fetch("{{ route('marketplace.travel.profil.rekening.toggle') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ mode: mode })
        }).then(res => res.json()).then(data => {
            if (data.status === 'success') {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Opsi Rekening Diubah', showConfirmButton: false, timer: 2000 });
            }
        });

        toggleRekeningUIOnly(mode);
    }

    // Fungsi khusus merubah UI (Agar saat refresh halaman tidak nembak API lagi)
    function toggleRekeningUIOnly(mode) {
        const customFields = document.getElementById('custom-bank-fields');
        const pusatFields = document.getElementById('pusat-bank-fields');
        const customInputs = customFields.querySelectorAll('select, input');

        if (mode === 'MANDIRI') {
            customFields.classList.remove('hidden');
            setTimeout(() => customFields.classList.remove('opacity-0'), 10);
            pusatFields.classList.add('opacity-0');
            setTimeout(() => pusatFields.classList.add('hidden'), 300);

            // Wajibkan form diisi kalau mode Mandiri
            customInputs.forEach(el => {
                if(!el.classList.contains('rek-id-input')) el.setAttribute('required', 'required');
            });
        } else {
            pusatFields.classList.remove('hidden');
            setTimeout(() => pusatFields.classList.remove('opacity-0'), 10);
            customFields.classList.add('opacity-0');
            setTimeout(() => customFields.classList.add('hidden'), 300);

            // Matikan wajib isi form kalau mode Pusat
            customInputs.forEach(el => el.removeAttribute('required'));
        }
    }

    // --- 2. RENDER REKENING AWAL SAAT HALAMAN DIBUKA ---
    document.addEventListener('DOMContentLoaded', function() {
        // Render list rekening dari PHP (Jika ada)
        const existingAccounts = @json($listRekening ?? []);
        if (existingAccounts.length > 0) {
            existingAccounts.forEach(acc => renderRow(acc));
        } else {
            renderRow(); // 1 baris kosong default
        }
        updateBankEmptyState();

        // Set UI awal sesuai mode yang aktif tanpa menembak API
        const currentMode = document.querySelector('input[name="rekening_mode"]:checked').value;
        toggleRekeningUIOnly(currentMode);
    });

    function renderRow(data = {}) {
        const template = document.getElementById('bank-account-row-template');
        const clone = template.content.cloneNode(true);

        if (data.id) clone.querySelector('.rek-id-input').value = data.id;

        const namaBank = data.nama_bank || data.bank_name || '';
        const noRekening = data.no_rekening || data.bank_account || '';
        const atasNama = data.atas_nama || data.bank_owner || '';

        if (namaBank) clone.querySelector('.rek-name-input').value = namaBank;
        if (noRekening) clone.querySelector('.rek-account-input').value = noRekening;
        if (atasNama) clone.querySelector('.rek-owner-input').value = atasNama;

        if (data.id) {
            const btnSave = clone.querySelector('.btn-save-rek');
            btnSave.innerHTML = '<i class="ph-bold ph-check-circle"></i> Tersimpan';
            btnSave.classList.replace('bg-blue-600', 'bg-emerald-600');
            btnSave.classList.replace('hover:bg-blue-700', 'hover:bg-emerald-700');
            btnSave.classList.replace('shadow-blue-500/20', 'shadow-emerald-500/20');
        }

        document.getElementById('bank-accounts-list').appendChild(clone);
        updateBankEmptyState();
    }

    function addNewBankRow() {
        renderRow();
    }

    function updateBankEmptyState() {
        const list = document.getElementById('bank-accounts-list');
        document.getElementById('bank-accounts-empty').classList.toggle('hidden', list.children.length > 0);
    }

    // --- 3. SIMPAN 1 REKENING (AJAX) ---
    async function saveRekeningAJAX(btn) {
        const row = btn.closest('.bank-account-row');
        const idInput = row.querySelector('.rek-id-input');
        const bankName = row.querySelector('.rek-name-input').value;
        const bankAccount = row.querySelector('.rek-account-input').value;
        const bankOwner = row.querySelector('.rek-owner-input').value;

        if (!bankName || !bankAccount || !bankOwner) {
            return Swal.fire({ icon: 'warning', title: 'Data Belum Lengkap', text: 'Pilih Bank, isi Nomor Rekening, dan Atas Nama.', confirmButtonColor: '#ea580c' });
        }

        btn.innerHTML = '<i class="ph-bold ph-spinner animate-spin"></i> Menyimpan...';
        btn.disabled = true;

        try {
            const response = await fetch("{{ route('marketplace.travel.profil.rekening.simpan') }}", {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    id: idInput.value, 
                    bank_name: bankName,
                    bank_account: bankAccount,
                    bank_owner: bankOwner
                })
            });
            
            const result = await response.json();
            
            if (result.status === 'success') {
                if(result.data && result.data.id) idInput.value = result.data.id;
                
                btn.innerHTML = '<i class="ph-bold ph-check-circle"></i> Tersimpan';
                btn.classList.replace('bg-blue-600', 'bg-emerald-600');
                btn.classList.replace('hover:bg-blue-700', 'hover:bg-emerald-700');
                btn.classList.replace('shadow-blue-500/20', 'shadow-emerald-500/20');
                row.classList.replace('border-slate-200', 'border-emerald-200');
                
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Rekening Tersimpan', showConfirmButton: false, timer: 2000 });
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            Swal.fire('Gagal!', error.message || 'Terjadi kesalahan sistem.', 'error');
            btn.innerHTML = '<i class="ph-bold ph-floppy-disk"></i> Simpan Rekening';
        } finally {
            btn.disabled = false;
        }
    }

    // --- 4. HAPUS 1 REKENING (AJAX) ---
    function deleteRekeningAJAX(btn) {
        const row = btn.closest('.bank-account-row');
        const idInput = row.querySelector('.rek-id-input').value;

        if (!idInput) {
            row.remove();
            updateBankEmptyState();
            return;
        }

        Swal.fire({
            title: 'Hapus Rekening?',
            text: "Rekening ini tidak akan bisa digunakan jamaah lagi.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                fetch(`/marketplace/travel/profil/rekening/${idInput}/hapus`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        row.remove();
                        updateBankEmptyState();
                        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Rekening dihapus', showConfirmButton: false, timer: 2000 });
                    } else {
                        Swal.fire('Gagal!', data.message, 'error');
                    }
                });
            }
        });
    }
    </script>
    </body>
    </html>