<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <title>Profil - Pengenumroh</title>
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
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }

        /* Custom Input Style for focused ring color */
        .form-input:focus {
            border-color: #ea580c;
            box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
        }
    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

    {{-- Form Tersembunyi untuk Logout Aman (Wajib ada @csrf) --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>

    <nav class="fixed w-full z-50 bg-white border-b border-slate-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('marketplace.beranda') }}" class="flex items-center gap-2 group">
                    <img src="/assets/img/marketplace/logo.png" alt="Logo PengenUmroh" class="h-10 w-auto object-contain">
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
                            <img id="nav-avatar"
                                src="{{ $userProfile['avatar'] }}"
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

    <main class="pt-28 pb-10 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <div class="lg:col-span-1 space-y-6" data-aos="fade-right">

                    <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center shadow-sm relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-20 bg-gradient-to-r from-orange-100 to-orange-50"></div>
                        <div class="relative z-10">
                            <div class="w-24 h-24 mx-auto rounded-full border-4 border-white shadow-md overflow-hidden bg-slate-100 mb-3">
                                <img id="sidebar-avatar"
                                    src="{{ $userProfile['avatar'] }}"
                                    class="w-full h-full object-cover">
                            </div>

                            <h2 class="text-lg font-bold text-slate-900 line-clamp-1">{{ $userProfile['nama'] ?? 'Nama User' }}</h2>

<!-- 1. Tanggal bergabung otomatis ngambil dari Controller -->
<p class="text-sm text-slate-500">Bergabung sejak {{ $userProfile['bergabung'] ?? 'Baru bergabung' }}</p>

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
                            {{-- LOGIKA ACTIVE MENU DENGAN FOLDER BARU --}}
                            <a href="{{ route('marketplace.profil.index') }}"
                                class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.profil.index') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                                <i class="ph-bold ph-user text-xl"></i> Profil
                            </a>

                            <a href="{{ route('marketplace.profil.pesanan') }}"
                                class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.profil.pesanan') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                                <i class="ph-bold ph-ticket text-xl"></i> Pesanan
                            </a>

                            <a href="{{ route('marketplace.profil.wishlist') }}"
                                class="flex items-center gap-3 px-5 py-4 font-bold transition border-l-4 {{ request()->routeIs('marketplace.profil.wishlist') ? 'bg-orange-50 text-orange-700 border-orange-600' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 border-transparent' }}">
                                <i class="ph-bold ph-heart text-xl"></i> Wishlist
                            </a>
                        </nav>

                        <div class="mt-auto border-t border-slate-100 p-2 bg-slate-50">
                            <button onclick="confirmLogout()"
                                class="flex w-full items-center justify-center gap-2 px-5 py-3 text-red-600 hover:bg-red-100/50 hover:text-red-700 font-bold transition rounded-xl text-sm border border-transparent hover:border-red-100">
                                <i class="ph-bold ph-sign-out text-lg"></i> Keluar Akun
                            </button>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-3" data-aos="fade-up" data-aos-delay="100">

                 {{-- 1. Tambahkan blok alert di atas form --}}
@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
        <i class="ph-bold ph-check-circle text-xl"></i>
        <p class="font-bold text-sm">{{ session('success') }}</p>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3">
        <i class="ph-bold ph-warning-circle text-xl"></i>
        <p class="font-bold text-sm">{{ session('error') }}</p>
    </div>
@endif

{{-- 2. Tambahkan enctype di tag form --}}
<form id="profileForm" action="{{ route('marketplace.profil.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 md:p-8">

        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Profil</h1>
                <p class="text-slate-500 text-sm mt-1">Perbarui informasi data diri Anda.</p>
            </div>
            <button type="submit" id="btn-save-desktop"
                class="hidden md:flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-orange-500/20 transition transform active:scale-95">
                <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>

        <div class="flex items-center gap-6 mb-8 pb-8 border-b border-slate-100">
            <div class="relative group cursor-pointer">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-slate-100 border-2 border-slate-200 group-hover:border-orange-500 transition">
                    <img id="preview-avatar"
                        src="{{ $userProfile['avatar'] }}"
                        class="w-full h-full object-cover">
                </div>
                <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                    <i class="ph-bold ph-camera text-white text-2xl"></i>
                </div>
                {{-- Tambahkan name="avatar" supaya bisa ditangkap di Controller nanti --}}
                <input type="file" name="avatar" id="file-input" class="absolute inset-0 opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(event)">
            </div>
            <div>
                <h3 class="font-bold text-slate-900">Foto Profil</h3>
                <p class="text-xs text-slate-500 mb-3">Format: JPG, PNG. Maksimal 2MB.</p>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('file-input').click()"
                        class="text-sm font-bold text-orange-600 hover:bg-orange-50 px-3 py-1.5 rounded-lg transition">Ubah Foto</button>
                    <button type="button" onclick="resetAvatar()"
                        class="text-sm font-medium text-slate-400 hover:text-red-500 hover:bg-red-50 px-3 py-1.5 rounded-lg transition">Hapus</button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Field Nama Lengkap --}}
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Nama Lengkap (Sesuai KTP)</label>
                <div class="relative">
                    <i class="ph-bold ph-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                    <input type="text" value="{{ $userProfile['nama'] ?? '' }}" name="nama"
                        class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition"
                        placeholder="Nama Lengkap">
                </div>
            </div>

            {{-- Field NIK --}}
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">NIK (Nomor KTP)</label>
                <div class="relative">
                    <i class="ph-bold ph-identification-card absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                    <input type="number" name="no_nik" value="{{ $userProfile['no_nik'] ?? '' }}"
                        class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition"
                        placeholder="16 Digit NIK">
                </div>
            </div>

            {{-- Field Email --}}
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Email</label>
                <div class="relative">
                    <i class="ph-bold ph-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                    <input type="email" value="{{ $userProfile['email'] ?? '' }}" disabled
                        class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition bg-slate-50 cursor-not-allowed">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold">Terverifikasi</span>
                </div>
            </div>

            {{-- Field Telepon --}}
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Nomor Telepon (WhatsApp)</label>
                <div class="relative">
                    <i class="ph-bold ph-whatsapp-logo absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                    <input type="tel" value="{{ $userProfile['telepon'] ?? '' }}" name="telepon"
                        class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition"
                        placeholder="08...">
                </div>
            </div>

            {{-- Field JK --}}
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-700">Jenis Kelamin</label>
                <div class="relative">
                    <i class="ph-bold ph-gender-intersex absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                    <select name="jk"
                        class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition appearance-none bg-white">
                        <option value="LK" {{ (isset($userProfile['jk']) && $userProfile['jk'] == 'LK') ? 'selected' : '' }}>Laki-laki</option>
                        <option value="PR" {{ (isset($userProfile['jk']) && $userProfile['jk'] == 'PR') ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <i class="ph-bold ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="space-y-2 md:col-span-2">
                <label class="text-sm font-bold text-slate-700">Alamat Lengkap</label>
                <div class="relative">
                    <textarea rows="3" name="address"
                        class="form-input w-full p-4 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition resize-none"
                        placeholder="Masukkan alamat lengkap">{{ $userProfile['address'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section Paspor --}}
        <div class="border rounded-xl p-5 bg-slate-50 border-slate-200 mb-6">
            <div class="flex items-center justify-between cursor-pointer" onclick="togglePassportSection()">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                        <i class="ph-fill ph-passport text-lg"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm">Data Paspor</h4>
                        <p class="text-xs text-slate-500">Diperlukan untuk booking tiket & visa</p>
                    </div>
                </div>
                <i id="passport-icon" class="ph-bold ph-caret-down text-slate-400 transition-transform duration-300"></i>
            </div>

            <div id="passport-form" class="hidden mt-5 pt-5 border-t border-slate-200 grid grid-cols-1 md:grid-cols-2 gap-6 transition-all">
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Nomor Paspor</label>
                    <input type="text" name="no_paspor" value="{{ $userProfile['no_paspor'] ?? '' }}"
                        class="form-input w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition"
                        placeholder="Contoh: X1234567">
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Nama di Paspor</label>
                    <input type="text" name="nama_paspor" value="{{ $userProfile['nama_paspor'] ?? '' }}"
                        class="form-input w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm font-medium focus:outline-none transition"
                        placeholder="Sesuai Paspor">
                </div>
            </div>
        </div>

        <div class="md:hidden mt-6">
            <button type="submit" id="btn-save-mobile"
                class="w-full flex items-center justify-center gap-2 bg-orange-600 hover:bg-orange-700 text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-orange-500/20 transition active:scale-95">
                <i class="ph-bold ph-floppy-disk"></i> Simpan Perubahan
            </button>
        </div>

    </div>
</form>

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
        <button type="button" onclick="togglePasswordForm()" id="btn-toggle-password"
            class="mt-4 sm:mt-0 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 text-sm font-bold rounded-lg transition border border-slate-200">
            Ubah Password
        </button>
    </div>

    <div id="password-form-container" class="hidden">
        {{-- Form khusus untuk ubah password (Action-nya beda) --}}
        <form action="{{ route('marketplace.profil.password') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Password Lama --}}
                <div class="space-y-2 md:col-span-2">
                    <label class="text-sm font-bold text-slate-700">Password Saat Ini</label>
                    <div class="relative">
                        <i class="ph-bold ph-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                        <input type="password" name="current_password" required
                            class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-orange-500 transition"
                            placeholder="Masukkan password saat ini">
                    </div>
                </div>

                {{-- Password Baru --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Password Baru</label>
                    <div class="relative">
                        <i class="ph-bold ph-key absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                        <input type="password" name="new_password" required minlength="6"
                            class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-orange-500 transition"
                            placeholder="Minimal 6 karakter">
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="space-y-2">
                    <label class="text-sm font-bold text-slate-700">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <i class="ph-bold ph-check-circle absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                        <input type="password" name="new_password_confirmation" required minlength="6"
                            class="form-input w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:outline-none focus:border-orange-500 transition"
                            placeholder="Ulangi password baru">
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                    class="flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white px-6 py-2.5 rounded-xl font-bold shadow-md transition">
                    <i class="ph-bold ph-check"></i> Simpan Password Baru
                </button>
            </div>
        </form>
    </div>
</div>

                </div>

            </div>
        </div>
    </main>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <script>
       AOS.init({
            duration: 800,
            once: true
        });

        // Date Picker flatpickr
        flatpickr("#birth-date", {
            locale: "id",
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            disableMobile: true,
            theme: "airbnb",
            defaultDate: "{{ $userProfile['tanggal_lahir'] ?? '' }}"
        });

        // Fungsi untuk buka-tutup form password
        function togglePasswordForm() {
            const form = document.getElementById('password-form-container');
            const btn = document.getElementById('btn-toggle-password');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                form.classList.add('block');
                btn.innerHTML = 'Batal Ubah';
                btn.classList.add('bg-red-50', 'text-red-600', 'border-red-100');
            } else {
                form.classList.add('hidden');
                form.classList.remove('block');
                btn.innerHTML = 'Ubah Password';
                btn.classList.remove('bg-red-50', 'text-red-600', 'border-red-100');
            }
        }

        // Image Preview (Visual Doang, pas di-submit file tetep kekirim via form)
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                // Validasi ukuran max 2MB di frontend
                if (input.files[0].size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Maksimal ukuran foto adalah 2MB.',
                        confirmButtonColor: '#ea580c'
                    });
                    input.value = ''; // Reset pilihan
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-avatar').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Reset Avatar
        function resetAvatar() {
            const defaultAvatar = "{{ $userProfile['avatar'] }}";
            document.getElementById('preview-avatar').src = defaultAvatar;
            document.getElementById('file-input').value = "";
        }

        // Toggle Passport Section
        function togglePassportSection() {
            const form = document.getElementById('passport-form');
            const icon = document.getElementById('passport-icon');
            if (form.classList.contains('hidden')) {
                form.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                form.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // Fungsi Simulasi Loading pas Submit (Biar Kelihatan Keren tapi tetep ke-submit)
        document.getElementById('profileForm').addEventListener('submit', function() {
            const btnDesktop = document.getElementById('btn-save-desktop');
            const btnMobile = document.getElementById('btn-save-mobile');
            const loadingContent = '<i class="ph-bold ph-spinner animate-spin"></i> Menyimpan...';
            
            if (window.innerWidth >= 768) {
                btnDesktop.innerHTML = loadingContent;
                btnDesktop.classList.add('opacity-75', 'cursor-not-allowed');
            } else {
                btnMobile.innerHTML = loadingContent;
                btnMobile.classList.add('opacity-75', 'cursor-not-allowed');
            }
        });

        // Logika Logout
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
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>