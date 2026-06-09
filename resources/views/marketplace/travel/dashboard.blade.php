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
        // Mengambil data user dari session
        $userData = session('user') ?? [];
        $namaTravel = $userData['fullname'] ?? $userData['username'] ?? 'Biro Travel';
        $emailTravel = $userData['email'] ?? 'Belum ada email';
        
        // Ambil URL avatar dari API (kalau ada), kalau nggak pakai UI-Avatars
        $avatar = $userData['avatar_url'] ?? session('user_avatar') ?? 'https://ui-avatars.com/api/?name=' . urlencode($namaTravel) . '&background=F97316&color=fff';
        
        // Format Tanggal Dinamis (Misal: "Maret 2024")
        $tanggalDibuat = $userData['created_at'] ?? null;
        $bergabung = $tanggalDibuat ? \Carbon\Carbon::parse($tanggalDibuat)->translatedFormat('F Y') : date('Y');

        // Status Akun Dinamis
        $statusRaw = $userData['status'] ?? 'aktif'; 
        $isAktif = strtolower($statusRaw) === 'aktif' || $statusRaw == 1;
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
                    <!-- 👇 ACTION FORM DIUBAH AGAR MENGARAH KE CONTROLLER -->
                    <form id="profileForm" action="{{ route('marketplace.travel.profil.update') }}" method="POST" enctype="multipart/form-data" onsubmit="showLoading()">
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
                                    <!-- 👇 NAMA INPUT: 'avatar' -->
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
                                        <input type="text" name="fullname" value="{{ $namaTravel }}" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition" placeholder="Nama Travel/Biro" required>
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
                            </div>

                            <div class="md:hidden mt-6">
                                <button type="submit" id="btn-save-mobile" class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/20 transition active:scale-95">
                                    <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
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

        // JS Animasi Tombol Submit
        function showLoading() {
            const btnDesktop = document.getElementById('btn-save-desktop');
            const btnMobile = document.getElementById('btn-save-mobile');
            const loadingContent = '<i class="ph-bold ph-spinner animate-spin"></i> Menyimpan...';
            
            if (window.innerWidth >= 768) {
                btnDesktop.innerHTML = loadingContent;
                btnDesktop.disabled = true;
                btnDesktop.classList.add('opacity-75', 'cursor-not-allowed');
            } else {
                btnMobile.innerHTML = loadingContent;
                btnMobile.disabled = true;
                btnMobile.classList.add('opacity-75', 'cursor-not-allowed');
            }
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
</body>
</html>