<footer class="bg-slate-900 text-slate-300 pt-20 pb-10 border-t border-slate-800 relative overflow-hidden">
    <!-- Efek Glow Atas -->
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-3xl h-1 bg-gradient-to-r from-transparent via-orange-500 to-transparent opacity-50 shadow-[0_0_20px_rgba(249,115,22,0.5)]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <!-- Grid Layout Diperbarui: 1 Kolom (Mobile) -> 2 Kolom (Tablet) -> 12 Kolom Custom (Desktop) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-12">
            
            <!-- Kolom 1: Tentang Kami & Sosmed -->
            <div class="lg:col-span-5 flex flex-col items-center md:items-start text-center md:text-left space-y-6">
                <a href="/" class="block">
                    <img src="/assets/img/marketplace/logo-putih.png" alt="Logo PengenUmroh" class="h-10 w-auto object-contain">
                </a>
                <p class="text-slate-400 text-sm leading-relaxed md:pr-10 lg:pr-12">
                    Marketplace Umroh & Haji Khusus No. 1 di Indonesia. Kami menghubungkan Anda dengan ribuan paket dari travel berizin resmi Kemenag untuk ibadah yang aman dan nyaman.
                </p>
                <!-- Ikon Sosial Media -->
                <div class="flex justify-center md:justify-start gap-3 w-full">
                    <a href="https://www.instagram.com/pengenumrohofficial/" class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center hover:bg-orange-600 hover:border-orange-600 hover:text-white transition-all duration-300 group"><i class="ph-fill ph-instagram-logo text-xl group-hover:scale-110 transition"></i></a>
                    <a href="https://www.facebook.com/profile.php?id=100091980984911" class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center hover:bg-blue-600 hover:border-blue-600 hover:text-white transition-all duration-300 group"><i class="ph-fill ph-facebook-logo text-xl group-hover:scale-110 transition"></i></a>
                    <a href="https://api.whatsapp.com/send?phone=62811917988" class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center hover:bg-green-600 hover:border-slate-500 hover:text-white transition-all duration-300 group"><i class="ph-fill ph-whatsapp-logo text-xl group-hover:scale-110 transition"></i></a>
                    <a href="https://www.youtube.com/@Pengenumrohofficial" class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center hover:bg-red-600 hover:border-red-600 hover:text-white transition-all duration-300 group"><i class="ph-fill ph-youtube-logo text-xl group-hover:scale-110 transition"></i></a>
                </div>
            </div>

            <!-- Kolom 2: Perusahaan -->
            <div class="lg:col-span-3 lg:justify-self-center flex flex-col items-center md:items-start text-center md:text-left">
                <h4 class="text-white font-bold mb-6 relative inline-block">
                    Perusahaan 
                    <!-- Garis bawah rata tengah di mobile, rata kiri di tablet/desktop -->
                    <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 md:left-0 md:translate-x-0 w-8 h-1 bg-orange-500 rounded-full"></span>
                </h4>
                <ul class="space-y-3 text-sm w-full">
                    <li><a href="{{ route('company.beranda') }}" class="hover:text-orange-500 transition-all duration-300 hover:pl-2 block">Tentang Kami</a></li>
                    <li>
                        <a href="https://karir.pengenumroh.com/" class="hover:text-orange-500 transition-all duration-300 hover:pl-2 flex items-center justify-center md:justify-start">
                            Karir 
                            <span class="text-[10px] bg-orange-500 text-white px-1.5 py-0.5 rounded ml-2">Hiring</span>
                        </a>
                    </li>
                    <li><a href="/marketplace/#mitra" class="hover:text-orange-500 transition-all duration-300 hover:pl-2 block">Mitra Travel</a></li>
                    <li><a href="/#artikel" class="hover:text-orange-500 transition-all duration-300 hover:pl-2 block">Blog & Artikel</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Hubungi Kami -->
            <div class="md:col-span-2 lg:col-span-4 flex flex-col items-center md:items-start text-center md:text-left space-y-6">
                <div class="w-full">
                    <h4 class="text-white font-bold mb-6 relative inline-block">
                        Hubungi Kami 
                        <!-- Garis bawah rata tengah di mobile, rata kiri di tablet/desktop -->
                        <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 md:left-0 md:translate-x-0 w-8 h-1 bg-orange-500 rounded-full"></span>
                    </h4>
                    <ul class="space-y-5 md:space-y-4 text-sm">
                        <!-- Format Ikon & Teks: Di Mobile ikon di atas, di Desktop ikon di samping -->
                        <li class="flex flex-col md:flex-row items-center md:items-start gap-2 md:gap-3">
                            <div class="bg-slate-800 p-1.5 rounded text-orange-500 md:mt-1 flex-shrink-0"><i class="ph-fill ph-map-pin"></i></div>
                            <span class="leading-relaxed">Wisma Haramain, Jl. Mahoni Raya No.13, Kec. Sukmajaya, Kota Depok, Jawa Barat</span>
                        </li>
                        <li class="flex flex-col md:flex-row items-center md:items-start gap-2 md:gap-3">
                            <div class="bg-slate-800 p-1.5 rounded text-orange-500 flex-shrink-0"><i class="ph-fill ph-whatsapp-logo"></i></div>
                            <span class="font-semibold text-white tracking-wide">0811-917-988</span>
                        </li>
                        <li class="flex flex-col md:flex-row items-center md:items-start gap-2 md:gap-3">
                            <div class="bg-slate-800 p-1.5 rounded text-orange-500 flex-shrink-0"><i class="ph-fill ph-envelope"></i></div>
                            <span>cs@pengenumroh.com</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Copyright Bottom -->
        <div class="border-t border-slate-800 pt-8">
            <div class="flex justify-center items-center w-full">
                <p class="text-xs text-slate-500 text-center">
                    &copy; <span id="year">2024</span> <span class="text-slate-300 font-semibold">pengenumroh.com</span>. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

<script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
</script>