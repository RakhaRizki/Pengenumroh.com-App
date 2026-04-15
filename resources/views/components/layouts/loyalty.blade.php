<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pengenumroh - Your Trusted Umroh And Hajj Marketplace</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.webp') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&family=Poppins:wght@100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link href="{{ asset('assets/css/company.css') }}" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest" defer></script>

    <style>
        /* Import Font */
        :root {
            --primary-color: #D9232D;
            /* Warna merah dari tombol */
            --secondary-color: #FF5E62;
            --dark-color: #1a202c;
            --gray-color: #6c757d;
            --light-gray-color: #f8f9fa;
            --border-color-soft: #e9ecef;
            --border-radius-xl: 1rem;
            --border-radius-lg: 0.75rem;
            --shadow-sm: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 15px 30px -5px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray-color);
            color: var(--dark-color);
        }

        /* Helper Classes */
        .text-gradient {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-fill-color: transparent;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        /* Section Styling */
        section {
            padding: 80px 0;
        }

        /* Hero Section */
        .hero-prioritas {
            background-color: #ffffff;
            padding-top: 100px;
            padding-bottom: 100px;
            overflow: hidden;
        }

        .hero-content h1 {
            line-height: 1.3;
        }

        .hero-image-wrapper {
            position: relative;
        }

        .hero-image-wrapper img {
            border-radius: var(--border-radius-xl);
            transform: translateY(0);
            /* lurus */
            transition: transform 0.4s ease;
            animation: floating 3s ease-in-out infinite;
        }

        .hero-image-wrapper:hover img {
            transform: scale(1.05);
            /* tetap bisa zoom saat hover */
        }

        /* Floating Animation */
        @keyframes floating {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #b81c25;
            border-color: #b81c25;
        }

        /* Features Section */
        .features-section {
            background-color: var(--light-gray-color);
        }

        .feature-card {
            background: #fff;
            padding: 40px;
            border-radius: var(--border-radius-xl);
            text-align: center;
            border: 1px solid var(--border-color-soft);
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-color);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        /* ============================================== */
        /* TIMELINE SECTION - DESAIN ULANG "WINDING PATH" */
        /* ============================================== */

        /* === Manfaat Section (Timeline Layout) - PERBAIKAN Z-INDEX === */
        .timeline-section {
            padding: 6rem 0;
        }

        .timeline {
            position: relative;
            max-width: 900px;
            margin: 0 auto;
        }

        .timeline::after {
            content: '';
            position: absolute;
            width: 4px;
            background-color: #FFCDD2;
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -2px;
            z-index: 1;
            /* Atur z-index garis di lapisan bawah */
        }

        .timeline-item {
            padding: 10px 40px;
            position: relative;
            background-color: inherit;
            width: 50%;
            z-index: 2;
            /* Atur z-index item di lapisan atas */
        }

        .timeline-item::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            right: -10px;
            background-color: white;
            border: 4px solid #D32F2F;
            top: 25px;
            border-radius: 50%;
            z-index: 3;
            /* Pastikan titik di atas segalanya */
        }

        .timeline-item.left {
            left: 0;
        }

        .timeline-item.right {
            left: 50%;
        }

        .timeline-item.right::after {
            left: -10px;
        }

        .timeline-content {
            padding: 20px 30px;
            background-color: white;
            position: relative;
            border-radius: 1rem;
            border: 1px solid #e9ecef;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        /* Responsive Timeline */
        @media screen and (max-width: 768px) {
            .timeline::after {
                left: 20px;
            }

            .timeline-item {
                width: 100%;
                padding-left: 60px;
                padding-right: 15px;
            }

            .timeline-item.left,
            .timeline-item.right {
                left: 0%;
            }

            .timeline-item::after {
                left: 11px;
            }

            .timeline-item.right::after {
                left: 11px;
            }
        }

        /* =========================== */
        /* RESPONSIVE SECTION     */
        /* =========================== */

        @media screen and (max-width: 991px) {
            .hero-prioritas {
                padding-top: 60px;
                padding-bottom: 60px;
            }

            .hero-image-wrapper img {
                transform: rotate(0);
                margin-top: 40px;
            }
        }

        @media screen and (max-width: 991px) {
            .hero-prioritas {
                padding-top: 60px;
                padding-bottom: 60px;
            }
        }

        /* ======================================= */
        /* PENYESUAIAN JARAK UNTUK TAMPILAN MOBILE (Optimasi Hero) */
        /* ======================================= */

        /* Target: Layar HP (di bawah 767px) */
        @media screen and (max-width: 767px) {

            section {
                padding: 50px 0;
                /* Mengurangi padding section secara umum */
            }

            /* Optimasi Jarak di Hero Section */
            .hero-prioritas {
                padding-top: 30px;
                /* Padding atas lebih kecil */
                padding-bottom: 40px;
                /* Padding bawah lebih kecil */
            }

            /* Merapikan wrapper gambar kartu */
            .hero-image-wrapper {
                padding: 10px !important;
                /* Mengurangi padding di sekitar kartu */
                margin-bottom: 0rem !important;
            }

            /* Mengurangi margin bawah judul besar */
            .hero-content h1.mb-4 {
                margin-bottom: 0.75rem !important;
                /* Jarak antar judul dan subjudul dirapatkan */
                font-size: 2rem;
            }

            /* Mengurangi margin bawah subjudul/deskripsi */
            .hero-content p.lead.mb-5 {
                margin-bottom: 1.5rem !important;
                /* Jarak antara deskripsi dan tombol dirapatkan */
                font-size: 1rem;
            }

            /* Mengatur tombol agar sejajar vertikal dan memiliki padding yang proporsional */
            .hero-content .btn-lg {
                width: 100%;
                /* Tombol full width di mobile */
                padding: 0.75rem 1.25rem;
                font-size: 1rem;
            }

            /* Memastikan jarak vertikal antar tombol tetap ada jika layout tumpuk */
            .hero-content .gap-3 {
                gap: 0.75rem !important;
            }

            /* Menghapus margin atas pada gambar di mobile (jika ada margin-top besar sebelumnya) */
            .hero-image-wrapper img {
                margin-top: 0 !important;
            }
        }

        /* =================================== */
        /* MEMBER TO MEMBER SECTION STYLING    */
        /* =================================== */

        /* 1. Styling Kartu (Cards) */
        .custom-hover-card {
            border-radius: 1.5rem;
            /* Sudut lebih bulat */
            border: 1px solid rgba(0, 0, 0, 0.04) !important;
            /* Border tipis samar */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            /* Bayangan default sangat halus */
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            /* Transisi smooth */
        }

        .custom-hover-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(217, 35, 45, 0.1);
            /* Bayangan merah tipis saat hover */
            border-color: rgba(217, 35, 45, 0.2) !important;
        }

        /* 2. Styling Icon Box */
        .icon-box {
            width: 90px;
            height: 90px;
            background: #FFF5F5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            position: relative;
        }

        .icon-box::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 2px solid #D9232D;
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.3s ease;
        }

        .custom-hover-card:hover .icon-box {
            background: #fff;
            color: #D9232D;
        }

        .custom-hover-card:hover .icon-box::after {
            opacity: 0.1;
            transform: scale(1.2);
        }

        /* 3. CTA Box Styling (Gradient & Shapes) */
        .cta-box {
            background: linear-gradient(120deg, #B71C1C 0%, #D9232D 100%);
        }

        .cta-bg-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: -50px;
        }

        /* 4. Button Hover Effect */
        .hover-scale {
            transition: transform 0.2s ease;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .letter-spacing-1 {
            letter-spacing: 1px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .member-section {
                padding: 60px 0;
            }

            .cta-box {
                padding: 2rem !important;
            }

            .display-5 {
                font-size: 2rem;
            }
        }

        /* ========================================= */
        /* MODERN CTA BOX STYLING                    */
        /* ========================================= */

        .modern-cta-box {
            background: linear-gradient(135deg, #B71C1C 0%, #E53935 50%, #D9232D 100%);
            border-radius: 2rem;
            /* Sudut melengkung modern */
            box-shadow: 0 20px 40px -10px rgba(183, 28, 28, 0.5);
            /* Bayangan merah glowing */
            transition: transform 0.3s ease;
        }

        .modern-cta-box:hover {
            transform: translateY(-5px);
            /* Efek naik dikit saat hover */
        }

        /* Watermark Background Icons */
        .bg-decoration-icon {
            position: absolute;
            color: #fff;
            opacity: 0.06;
            /* Sangat transparan */
            pointer-events: none;
            z-index: 1;
        }

        .icon-left {
            font-size: 12rem;
            left: -3rem;
            bottom: -3rem;
            transform: rotate(15deg);
        }

        .icon-right {
            font-size: 10rem;
            right: -2rem;
            top: -2rem;
            transform: rotate(-15deg);
        }

        /* Tombol Utama (Putih) */
        .btn-white-action {
            background-color: #ffffff;
            color: #D9232D;
            border: 2px solid #ffffff;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-white-action:hover {
            background-color: #f8f9fa;
            color: #a50e17;
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        /* Tombol Kedua (Outline) */
        .btn-outline-light-action {
            background-color: transparent;
            color: #ffffff;
            border: 2px solid rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(4px);
        }

        .btn-outline-light-action:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: #ffffff;
            color: #ffffff;
            transform: scale(1.02);
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .modern-cta-box {
                border-radius: 1.5rem;
            }

            /* Agar tombol full width di HP tapi tidak gepeng */
            .w-sm-auto {
                width: 100% !important;
            }

            .display-6 {
                font-size: 1.75rem;
            }
        }
    </style>

</head>

<body class="index-page">

    <x-loyalty.navbar />

    <main class="main">
        {{ $slot }}
    </main>

    <x-loyalty.footer />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/company.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });
    </script>
</body>

</html>
