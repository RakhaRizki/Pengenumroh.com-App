<!DOCTYPE html>
<html lang="id">
<head>
    <title>Halaman Tidak Ditemukan - Pengenumroh</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    
    <!-- Library CSS & Font -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
        }
    </style>
</head>
<!-- Tambahan overscroll-none untuk mematikan efek bounce/tarik-ulur bawaan mobile browser -->
<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white bg-orange-50 relative overscroll-none">

    <!-- 👇 1. BACKGROUND GRADASI 👇 -->
    <div class="fixed inset-0 bg-gradient-to-br from-white via-orange-50/50 to-orange-100 z-0 pointer-events-none"></div>

    <!-- 👇 2. ORNAMEN BLUR 👇 -->
    <div class="fixed top-0 right-0 -mr-20 -mt-20 w-[300px] h-[300px] md:w-[500px] md:h-[500px] bg-orange-300/30 rounded-full blur-[60px] md:blur-[80px] z-0 pointer-events-none"></div>
    <div class="fixed bottom-0 left-0 -ml-20 -mb-20 w-[250px] h-[250px] md:w-[400px] md:h-[400px] bg-teal-300/10 rounded-full blur-[60px] md:blur-[80px] z-0 pointer-events-none"></div>

    <!-- 👇 3. WADAH KONTEN UTAMA 👇 -->
    <!-- Menggunakan h-[100dvh] dan overflow-hidden agar halaman mutlak tidak bisa di-scroll -->
    <div class="relative z-10 h-[100dvh] w-full flex flex-col items-center justify-center px-5 sm:p-6 overflow-hidden">
        
        <!-- 👇 HEADER MINIMALIS (LOGO BRAND) 👇 -->
        <div class="absolute top-0 left-0 w-full p-5 sm:p-8 flex justify-center sm:justify-start z-20">
            <a href="/marketplace/" class="hover:opacity-80 transition-opacity drop-shadow-sm flex items-center gap-2">
                <img src="/assets/img/marketplace/logo.png" 
                     alt="Logo PengenUmroh" 
                     class="h-8 sm:h-10 w-auto object-contain" 
                     onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');">
                <span class="text-xl sm:text-2xl font-bold text-orange-600 hidden">Pengenumroh</span>
            </a>
        </div>
        
        <!-- Tambahan mt-12 di mobile agar tidak menabrak logo saat dilayar pendek, sm:mt-0 untuk desktop -->
        <main class="w-full max-w-lg text-center flex flex-col items-center justify-center mt-12 sm:mt-0">
            
            <!-- ILUSTRASI GAMBAR -->
            <!-- Mengurangi sedikit margin bottom (mb-4) agar muat di layar HP pendek -->
            <div class="w-full flex justify-center mb-4 sm:mb-8">
                <img src="/assets/img/marketplace/404.png" 
                     alt="Ilustrasi Tidak Ditemukan" 
                     class="w-[75%] max-w-[220px] sm:max-w-[320px] md:max-w-[360px] h-auto object-contain drop-shadow-xl"
                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=404&background=F97316&color=fff&size=400';">
            </div>

            <!-- TIPOGRAFI & TEKS -->
            <h2 class="text-[22px] sm:text-3xl md:text-4xl font-extrabold text-slate-900 mb-2 sm:mb-4 tracking-tight leading-snug px-2">
                Qadarullah, tujuanmu nggak ada!
            </h2>
            <p class="text-slate-500 text-sm sm:text-base mb-6 sm:mb-10 max-w-[95%] sm:max-w-md mx-auto leading-relaxed">
                Mungkin kamu salah jalan atau halaman yang kamu cari sudah dihapus. Yuk, kembali ke jalan yang benar dan temukan paket umroh terbaikmu.
            </p>

            <!-- TOMBOL AKSI -->
            <div class="flex flex-col-reverse sm:flex-row items-center justify-center gap-3 sm:gap-4 w-full sm:w-auto px-2 sm:px-0">
                
                <!-- Tombol Secondary (Kembali) -->
                <button onclick="window.history.back()" class="w-full sm:w-auto px-6 md:px-8 py-3 sm:py-3.5 rounded-xl bg-white border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 hover:border-slate-300 hover:text-slate-900 transition-all shadow-sm flex items-center justify-center gap-2 active:scale-95 group">
                    <i class="ph-bold ph-arrow-left text-lg group-hover:-translate-x-1 transition-transform"></i> Kembali
                </button>

                <!-- Tombol Primary (Ke Beranda) -->
                {{-- <a href="/marketplace/" class="w-full sm:w-auto px-6 md:px-8 py-3 sm:py-3.5 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold hover:from-orange-600 hover:to-orange-700 shadow-xl shadow-orange-500/30 border border-orange-400/50 transition-all flex items-center justify-center gap-2 active:scale-95 group">
                    <i class="ph-bold ph-house text-lg group-hover:scale-110 transition-transform"></i> Ke Beranda
                </a> --}}
                
            </div>

        </main>
    </div>

</body>
</html>