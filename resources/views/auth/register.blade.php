<!doctype html>
<html lang="id">

<head>
    <title>Daftar Akun - Pengenumroh.com</title>
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }

        /* Hilangkan Scrollbar tapi tetap bisa scroll */
        .no-scrollbar::-webkit-scrollbar {
            width: 0px;
            background: transparent;
        }

        /* Custom Checkbox */
        .custom-checkbox:checked {
            background-color: #F97316;
            border-color: #F97316;
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        }
    </style>
</head>

<body class="antialiased text-slate-800 h-screen overflow-hidden">

    <div class="flex w-full h-full">

        <div class="hidden lg:flex lg:w-1/2 bg-slate-900 relative items-center justify-center">
            <img src="/assets/img/marketplace/register.png"
                class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay" alt="Background"
                onerror="this.src='https://images.unsplash.com/photo-1565552629477-cd014b78f566?q=80&w=1600&auto=format&fit=crop'">

            <div class="absolute inset-0 z-0 opacity-20"
                style="background-image: radial-gradient(#F97316 1px, transparent 1px); background-size: 30px 30px;">
            </div>

            <div class="relative z-10 max-w-md text-center text-white px-10" data-aos="fade-up">
                <div class="mb-6 flex justify-center">
                    <div
                        class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-2xl p-3">
                        <img src="/assets/img/marketplace/favicon.png" alt="Logo"
                            class="w-full h-full object-contain">
                    </div>
                </div>
                <h2 class="text-4xl font-bold mb-4">Langkah Mudah <br>Menuju Baitullah</h2>
                <p class="text-slate-300 text-lg font-light leading-relaxed">
                    "Solusi perjalanan Umroh & Haji yang pasti, aman, dan terpercaya"
                </p>
            </div>

            <div class="absolute bottom-6 text-xs text-slate-500">
                &copy; 2025 pengenumroh.com
            </div>
        </div>

        <div
            class="w-full lg:w-1/2 bg-white h-full relative flex flex-col justify-center items-center z-10 overflow-hidden">

            <div
                class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-orange-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-pulse">
            </div>
            <div
                class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50">
            </div>

            <div class="absolute top-0 left-0 w-full p-6 z-20 flex justify-between items-center pointer-events-none">
                <a href="/marketplace/"
                    class="pointer-events-auto group flex items-center gap-2 bg-white/80 backdrop-blur-sm p-2 rounded-xl border border-slate-100 shadow-sm hover:border-orange-200 transition-all">
                    <div
                        class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-500 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <i class="ph-bold ph-arrow-left"></i>
                    </div>
                    <span
                        class="text-sm font-semibold text-slate-600 group-hover:text-orange-600 pr-2 hidden sm:block">Kembali</span>
                </a>
            </div>

            <div
                class="w-full h-full overflow-y-auto no-scrollbar flex flex-col items-center justify-start md:justify-center pt-1 md:pt-0 pb-1 relative z-10">

                <div class="w-full max-w-md px-6 py-12 lg:py-24 sm:px-10" data-aos="fade-left">

                    <div class="lg:hidden flex justify-center mb-2">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 shadow-sm border border-slate-200 p-3">
                            <img src="/assets/img/marketplace/favicon.png" alt="Logo"
                                class="w-full h-full object-contain">
                        </div>
                    </div>

                    <div class="text-center mb-6 lg:mb-8">
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Buat Akun Baru
                        </h2>
                        <p class="text-slate-500 mt-2 text-sm">Pilih jenis akun dan lengkapi data diri Anda.</p>
                    </div>

                    <!-- TAMPILAN ERROR / SUCCESS -->
                    @if (session('error'))
                        <div
                            class="bg-red-50 text-red-600 border border-red-200 p-4 rounded-xl text-sm font-bold flex items-center gap-2 mb-5">
                            <i class="ph-fill ph-warning-circle text-lg"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div
                            class="bg-green-50 text-green-600 border border-green-200 p-4 rounded-xl text-sm font-bold flex items-center gap-2 mb-5">
                            <i class="ph-fill ph-check-circle text-lg"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- FORM DIUBAH KE ROUTE REGISTER -->
                    <form id="registerForm" class="space-y-5" action="{{ route('register.proses') }}" method="POST"
                        onsubmit="handleRegister()">

                        <!-- WAJIB CSRF -->
                        @csrf

                        <input type="hidden" name="role" id="roleInput" value="jamaah">

                        <div
                            class="grid grid-cols-2 gap-1 p-1.5 bg-slate-100/80 border border-slate-200 rounded-2xl mb-6 relative">
                            <button type="button" onclick="switchRole('3')" id="btn-jamaah"
                                class="relative z-10 flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-bold transition-all duration-300 bg-white text-orange-600 shadow-sm ring-1 ring-slate-200">
                                <i class="ph-bold ph-user"></i>
                                Jamaah
                            </button>

                            <button type="button" onclick="switchRole('4')" id="btn-travel"
                                class="relative z-10 flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-bold transition-all duration-300 text-slate-500 hover:text-slate-700 hover:bg-slate-200/50">
                                <i class="ph-bold ph-airplane-tilt"></i>
                                Travel
                            </button>
                        </div>

                        <div class="space-y-1.5">
                            <label id="label-name"
                                class="text-xs font-bold text-slate-700 ml-1 uppercase tracking-wide">
                                Nama Lengkap
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i id="icon-name"
                                        class="ph-duotone ph-user text-slate-400 text-xl group-focus-within:text-orange-500 transition-colors"></i>
                                </div>
                                <!-- Tambah name="name" -->
                                <input type="text" id="input-name" name="name" required
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition-all text-sm font-medium"
                                    placeholder="Contoh: Budi Santoso">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="space-y-1.5">
                                <label
                                    class="text-xs font-bold text-slate-700 ml-1 uppercase tracking-wide">Email</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i
                                            class="ph-duotone ph-envelope text-slate-400 text-xl group-focus-within:text-orange-500 transition-colors"></i>
                                    </div>
                                    <!-- Tambah name="email" -->
                                    <input type="email" name="email" required
                                        class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition-all text-sm font-medium"
                                        placeholder="nama@email.com">
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-slate-700 ml-1 uppercase tracking-wide">No.
                                    WhatsApp</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i
                                            class="ph-duotone ph-whatsapp-logo text-slate-400 text-xl group-focus-within:text-orange-500 transition-colors"></i>
                                    </div>
                                    <!-- Tambah name="no_hp" -->
                                    <input type="number" name="no_hp" required
                                        class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition-all text-sm font-medium appearance-none"
                                        placeholder="0812xxx">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 ml-1 uppercase tracking-wide">Kata
                                Sandi</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="ph-duotone ph-lock-key text-slate-400 text-xl group-focus-within:text-orange-500 transition-colors"></i>
                                </div>
                                <!-- Tambah name="password" -->
                                <input type="password" id="password" name="password" required
                                    class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition-all text-sm font-medium"
                                    placeholder="Minimal 8 karakter">
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors cursor-pointer z-10">
                                    <i class="ph-bold ph-eye-slash text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" id="submitBtn"
                            class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-slate-900/20 transition-all duration-300 transform active:scale-[0.98] flex items-center justify-center gap-2 mt-4">
                            <span id="submitText">Daftar Sekarang</span>
                            <i class="ph-bold ph-arrow-right"></i>
                        </button>

                    </form>

                    <p class="text-center text-sm text-slate-500 mt-8 mb-8 lg:mb-0">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="text-orange-600 font-bold hover:underline transition-all">Masuk di
                            sini</a>
                    </p>

                </div>
            </div>

            <div class="lg:hidden absolute bottom-4 text-[10px] text-slate-400 z-10">
                &copy; 2025 pengenumroh.com
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === "password") {
                input.type = "text";
                icon.classList.replace('ph-eye-slash', 'ph-eye');
            } else {
                input.type = "password";
                icon.classList.replace('ph-eye', 'ph-eye-slash');
            }
        }

        // Script sudah dibersihkan dari preventDefault agar bisa ngepost ke Controller
        function handleRegister() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = `<i class="ph-bold ph-spinner animate-spin text-xl"></i> Memproses...`;
            btn.classList.add('opacity-75', 'cursor-not-allowed');
        }
    </script>

    <script>
        function switchRole(role) {
            // 1. Update Hidden Input
            document.getElementById('roleInput').value = role;

            // 2. Ambil Element
            const btnJamaah = document.getElementById('btn-jamaah');
            const btnTravel = document.getElementById('btn-travel');
            const labelName = document.getElementById('label-name');
            const inputName = document.getElementById('input-name');
            const iconName = document.getElementById('icon-name');

            // Class untuk tombol Aktif & Non-Aktif
            const activeClass = ['bg-white', 'text-orange-600', 'shadow-sm', 'ring-1', 'ring-slate-200'];
            const inactiveClass = ['text-slate-500', 'hover:text-slate-700', 'hover:bg-slate-200/50'];

            // 3. Logika Perubahan Tampilan
            if (role === '3') {
                btnJamaah.classList.add(...activeClass);
                btnJamaah.classList.remove(...inactiveClass);

                btnTravel.classList.remove(...activeClass);
                btnTravel.classList.add(...inactiveClass);

                labelName.textContent = "Nama Lengkap";
                inputName.placeholder = "Contoh: Budi Santoso";

                iconName.className =
                    "ph-duotone ph-user text-slate-400 text-xl group-focus-within:text-orange-500 transition-colors";

            } else if (role === '4') {
                btnTravel.classList.add(...activeClass);
                btnTravel.classList.remove(...inactiveClass);

                btnJamaah.classList.remove(...activeClass);
                btnJamaah.classList.add(...inactiveClass);

                labelName.textContent = "Nama Travel / Biro";
                inputName.placeholder = "Contoh: PT Berkah Mulia Travel";

                iconName.className =
                    "ph-duotone ph-buildings text-slate-400 text-xl group-focus-within:text-orange-500 transition-colors";
            }
        }
    </script>

</body>

</html>
