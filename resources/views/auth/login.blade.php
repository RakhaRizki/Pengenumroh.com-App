<!doctype html>
<html lang="id">

<head>
    <title>Masuk - Pengenumroh.com</title>
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
                class="w-full h-full overflow-y-auto no-scrollbar flex flex-col items-center justify-center relative z-10">

                <div class="w-full max-w-md px-6 py-20 sm:px-10" data-aos="fade-right">

                    <div class="text-center mb-8">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100 mb-5 shadow-sm border border-slate-200 p-3">
                            <img src="/assets/img/marketplace/favicon.png" alt="Logo"
                                class="w-full h-full object-contain">
                        </div>
                        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h2>
                        <p class="text-slate-500 mt-2 text-sm">Masuk untuk mengelola rencana ibadah Anda.</p>
                    </div>

                    <form id="loginForm" class="space-y-5" onsubmit="handleLogin(event)">

                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-700 ml-1 uppercase tracking-wide">Email atau
                                WhatsApp</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="ph-duotone ph-user-circle text-slate-400 text-xl group-focus-within:text-orange-500 transition-colors"></i>
                                </div>
                                <input type="text" required
                                    class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition-all text-sm font-medium"
                                    placeholder="nama@email.com / 0812...">
                            </div>
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex justify-between items-center ml-1">
                                <label class="text-xs font-bold text-slate-700 uppercase tracking-wide">Kata
                                    Sandi</label>
                            </div>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i
                                        class="ph-duotone ph-key text-slate-400 text-xl group-focus-within:text-orange-500 transition-colors"></i>
                                </div>
                                <input type="password" id="password" required
                                    class="block w-full pl-11 pr-12 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-orange-100 focus:border-orange-500 transition-all text-sm font-medium"
                                    placeholder="Masukkan kata sandi">
                                <button type="button" onclick="togglePassword('password', this)"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none transition-colors cursor-pointer z-10">
                                    <i class="ph-bold ph-eye-slash text-xl"></i>
                                </button>
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between bg-slate-50 p-3 rounded-lg border border-slate-100">
                            <div class="flex items-center">
                                <input id="remember-me" type="checkbox"
                                    class="w-4 h-4 border-slate-300 rounded text-orange-600 focus:ring-orange-500 custom-checkbox cursor-pointer transition-all">
                                <label for="remember-me"
                                    class="ml-2 block text-xs font-medium text-slate-600 cursor-pointer select-none">
                                    Ingat Saya
                                </label>
                            </div>
                            <div class="text-xs">
                                <a href="#"
                                    class="font-bold text-orange-600 hover:text-orange-700 hover:underline">
                                    Lupa Kata Sandi?
                                </a>
                            </div>
                        </div>

                        <button type="submit" id="loginBtn"
                            class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 rounded-xl shadow-lg shadow-slate-900/20 transition-all duration-300 transform active:scale-[0.98] flex items-center justify-center gap-2 mt-4">
                            <span>Masuk Sekarang</span>
                            <i class="ph-bold ph-sign-in"></i>
                        </button>

                    </form>

                    <p class="text-center text-sm text-slate-500 mt-8">
                        Belum memiliki akun?
                        <a href="{{ route('register') }}"
                            class="text-orange-600 font-bold hover:underline transition-all">Daftar
                            sekarang</a>
                    </p>
                </div>
            </div>

            <div class="lg:hidden absolute bottom-4 text-[10px] text-slate-400 z-10">
                &copy; 2025 pengenumroh.com
            </div>
        </div>

        <div class="hidden lg:flex lg:w-1/2 bg-slate-900 relative overflow-hidden items-end justify-center">

            <img src="/assets/img/marketplace/login.png" class="absolute inset-0 w-full h-full object-cover opacity-80"
                alt="Madinah"
                onerror="this.src='https://images.unsplash.com/photo-1537181534458-29a674431002?q=80&w=1600&auto=format&fit=crop'">

            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-slate-900/10"></div>

            <div class="relative z-10 w-full max-w-md mb-12 px-8" data-aos="fade-up" data-aos-delay="200">
                <div
                    class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl shadow-2xl hover:bg-white/15 transition-all cursor-default">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-orange-500/20 rounded-xl text-orange-400 border border-orange-500/30">
                            <i class="ph-fill ph-quotes text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-white text-lg font-medium leading-relaxed italic">
                                "Satu umrah ke umrah lainnya adalah penghapus dosa"
                            </p>
                            <div class="mt-4 flex items-center gap-3">
                                <div class="h-0.5 w-8 bg-orange-500 rounded-full"></div>
                                <span class="text-sm text-slate-300 font-light tracking-wide uppercase">HR. Bukhari &
                                    Muslim</span>
                            </div>
                        </div>
                    </div>
                </div>
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

        function handleLogin(e) {
            e.preventDefault();
            const btn = document.getElementById('loginBtn');
            const originalContent = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = `<i class="ph-bold ph-spinner animate-spin text-xl"></i> Memuat...`;
            btn.classList.add('opacity-90', 'cursor-not-allowed');

            setTimeout(() => {
                Swal.fire({
                    title: 'Berhasil Masuk!',
                    text: 'Selamat datang kembali.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false,
                    background: '#fff',
                    customClass: {
                        popup: 'rounded-2xl',
                        title: 'text-slate-900 font-bold'
                    },
                    // TAMBAHKAN DUA BARIS INI:
                    heightAuto: false, // Mencegah perubahan tinggi body/html
                    scrollbarPadding: false // Mencegah penambahan padding kanan
                }).then(() => {
                    window.location.href = '/marketplace/';
                });
                btn.disabled = false;
                btn.innerHTML = originalContent;
                btn.classList.remove('opacity-90', 'cursor-not-allowed');
            }, 1500);
        }
    </script>
</body>

</html>
