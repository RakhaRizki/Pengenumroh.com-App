<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pengenumroh - Your Trusted Umroh And Hajj Marketplace</title>

    <meta name="description"
        content="PengenUmroh merupakan marketplace Umroh dan Haji Khusus yang membantu Anda menemukan travel Amanah dan terpercaya dengan pelayanan terbaik.">
    <meta name="keywords"
        content="umroh, haji khusus, marketplace umroh, travel umroh terpercaya, paket umroh, travel haji amanah, daftar umroh online, pengen umroh">
    <meta name="author" content="PengenUmroh.com">

    <!-- Preconnect Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Favicons -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/company/favicon.webp') }}">

    <!-- Icon Fonts (gunakan salah satu versi terbaru saja) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- AOS (Animate On Scroll) CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/company.css') }}" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest" defer></script>

</head>

<body class="index-page">

    <x-company.navbar />

    <main class="main">
        {{ $slot }}
    </main>

    <x-company.footer />

    <div id="preloader"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/js/company.js') }}"></script>

    <script>
        // Fungsi global untuk toggle widget
        function toggleContactWidget() {
            const content = document.getElementById('contactContent');
            if (content) {
                content.classList.toggle('active');
            }
        }

        // Semua kode yang butuh DOM siap, masukkan ke sini HANYA 1 KALI
        document.addEventListener("DOMContentLoaded", function() {

            // 1. Inisialisasi Ikon Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // 2. Inisialisasi Animasi AOS
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    once: true
                });
            }

            // 3. Inisialisasi Swiper Hero (Diberi pengecekan agar tidak error di halaman yang tidak punya slider)
            const heroSwiperElement = document.querySelector('.hero-swiper');
            if (heroSwiperElement) {
                new Swiper('.hero-swiper', {
                    loop: true,
                    effect: 'fade',
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                });
            }

            // 4. Logika Toggle Artikel Tambahan
            const toggleBtn = document.getElementById("showAllBtn");
            const extraArticles = document.querySelectorAll(".extra-article");

            if (toggleBtn) {
                let isShown = false;
                toggleBtn.addEventListener("click", function() {
                    isShown = !isShown;
                    extraArticles.forEach(function(item) {
                        item.classList.toggle("d-none", !isShown);
                        item.classList.toggle("fade-in", isShown);
                    });
                    toggleBtn.textContent = isShown ? "Sembunyikan Artikel Tambahan" :
                        "Tampilkan Semua Artikel";
                });
            }

            // 5. Tutup otomatis widget kontak jika kursor menjauh
            const contactWidget = document.querySelector(".contact-widget");
            if (contactWidget) {
                contactWidget.addEventListener("mouseleave", () => {
                    const contactContent = document.getElementById("contactContent");
                    if (contactContent) {
                        contactContent.classList.remove("active");
                    }
                });
            }

        });
    </script>

    @stack('scripts')

</body>

</html>

</html>
