<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>pengenumroh - Your Trusted Umroh And Hajj Marketplace</title>
    <meta name="description" content="Wujudkan niat ibadah suci Anda bersama PengenUmroh.com. Kami menyediakan pilihan paket Umroh reguler, Umroh plus wisata halal, dan Haji khusus dengan layanan travel yang terpercaya, amanah, dan fasilitas nyaman.">
    <meta name="keywords" content="travel umroh, paket umroh, umroh murah, travel umroh terpercaya, umroh reguler, umroh plus wisata halal, haji khusus, biaya umroh, agen umroh resmi, pengen umroh">
    <meta name="author" content="PengenUmroh.com">

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Favicons -->
    <!-- 👇 FIX: Dibungkus dengan asset() 👇 -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/company/favicon.webp') }}">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/css/glightbox.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />

    <!-- Main CSS File -->
    <!-- 👇 FIX UTAMA: Hapus '/public' karena aset harus diakses langsung dari nama foldernya, dan bungkus dengan asset() 👇 -->
    <link href="{{ asset('assets/css/company.css') }}" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                <!-- 👇 FIX: Dibungkus dengan asset() 👇 -->
                <img src="{{ asset('assets/img/company/logo.webp') }}" alt="Logo Pengenumroh">
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}" class="active">Beranda</a></li>
                    <li><a href="{{ url('/#tentang') }}">Tentang</a></li>
                    <li><a href="{{ url('/#produk') }}">Produk</a></li>
                    <li><a href="{{ url('/#testimoni') }}">Testimoni</a></li>
                    <li><a href="{{ url('/#artikel') }}">Artikel</a></li>
                    <li><a href="{{ url('/#faq') }}">FAQ</a></li>
                    <li class="action-item">
                        <a href="https://agen.pengenumroh.com/" class="btn-action"> Agen </a>
                    </li>
                    <li class="action-item">
                        <a href="https://produk.pengenumroh.com/" class="btn-action"> Cari Paket Umroh </a>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">

        <!-- Section Detail Artikel -->
        <section class="py-5 bg-light" id="detail-artikel">
            <div class="container">
                <div class="row justify-content-center">

                    <!-- Konten Artikel -->
                    <div class="col-lg-10">
                        <div class="card shadow rounded-4 border-0 overflow-hidden">

                            <!-- Gambar Artikel -->
                            <img src="{{ asset('assets/img/company/artikel/artikel2.webp') }}" class="img-fluid w-100" alt="Judul Artikel">

                            <!-- Isi Artikel -->
                            <div class="card-body p-4 p-md-5">

                                <!-- Judul dan Tanggal -->
                                <h2 class="fw-bold mb-3">Tips Memilih Travel Umroh yang Terpercaya dan Aman</h2>
                                <p class="text-muted mb-4">
                                    <i class="fa-regular fa-calendar me-2"></i>25 Juli 2025
                                </p>

                                <!-- Deskripsi -->
                                <p class="fs-5 lh-lg text-justify">
                                    Bingung pilih travel Umroh yang terpercaya? Cek tips penting ini sebelum daftar.
                                    Pastikan perjalanan ibadah kamu
                                    aman dan sesuai syariat bersama pengenumroh.com.
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    Udah niat Umroh, udah nabung bertahun-tahun, tapi... Pas cari travel, malah makin
                                    pusing: yang satu murah banget,
                                    yang satu gak jelas izin Kemenagnya, yang lain katanya pernah "bermasalah".
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    Faktanya, gak semua travel Umroh punya komitmen dan kejelasan dalam memberangkatkan
                                    jamaah. Dan kamu gak mau ibadah
                                    sakral kayak gini malah jadi pengalaman yang nyesek, kan?
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    Memilih travel Umroh itu bukan soal harga termurah, tapi soal aman, nyaman, dan
                                    jelas jalurnya. Berikut ini 5 tips
                                    memilih travel Umroh yang bisa kamu jadikan panduan biar gak salah langkah:
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    <strong>1. Pastikan Terdaftar di Kementerian Agama (Kemenag)</strong><br>
                                    Travel resmi pasti punya izin PPIU (Penyelenggara Perjalanan Ibadah Umroh) yang bisa
                                    dicek langsung di situs
                                    Kemenag. Cek, jangan asal percaya brosur!
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    <strong>2. Cek Transparansi Jadwal & Fasilitas</strong><br>
                                    Itinerary jelas, tanggal keberangkatan fix, rincian hotel dan maskapai diumumkan
                                    dari awal—ini ciri travel yang
                                    serius.
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    <strong>3. Ada Bimbingan Manasik yang Terstruktur</strong><br>
                                    Travel profesional gak cuma antar, tapi juga bimbing. Cek apakah mereka rutin
                                    mengadakan manasik dan menyediakan
                                    pembimbing ibadah yang paham syariat.
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    <strong>4. Testimoni Real dari Jamaah Sebelumnya</strong><br>
                                    Cari ulasan di Google Maps, media sosial, atau tanya langsung ke jamaah yang sudah
                                    pernah berangkat.
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    <strong>5. Layanan Pelanggan yang Responsif dan Bisa
                                        Dipertanggungjawabkan</strong><br>
                                    Travel yang bisa dipercaya pasti punya customer service yang jelas, aktif menjawab
                                    pertanyaan, dan terbuka dengan
                                    semua biaya serta kebijakan.
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    Gak mau gambling sama perjalanan ibadah? pengenumroh.com bukan sekadar platform
                                    pencari travel Umroh—kami hadir
                                    sebagai marketplace terpercaya yang menghubungkan kamu dengan travel resmi yang
                                    terdaftar di Kementerian Agama dan
                                    tergabung dalam asosiasi penyelenggara Umroh & Haji.
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    Kami juga bantu persiapan kamu dari A sampai Z:
                                    <br>✅ Layanan pembuatan paspor
                                    <br>✅ Antar-jemput dokumen
                                    <br>✅ Pengantaran perlengkapan ibadah
                                    <br>✅ Support customer service yang responsif
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    Jadi kamu bisa fokus ke niat dan ibadah, tanpa stres urus hal teknis. Yuk, mulai
                                    langkah pertamamu ke Tanah Suci
                                    dengan tenang!
                                </p>
                                <p class="fs-5 lh-lg text-justify">
                                    <strong>Umroh & Haji Lebih Mudah Bersama pengenumroh.com</strong><br>
                                    Temukan travel Umroh terpercaya yang terdaftar resmi di Kemenag melalui satu
                                    platform. Dapatkan konsultasi gratis,
                                    bantuan pengurusan paspor, antar-jemput dokumen, dan perlengkapan ibadah—semua dalam
                                    satu layanan terpadu.
                                </p>

                                <!-- Tombol Kembali -->
                                <div class="text-end mt-5">
                                    <a href="/#artikel" class="btn btn-danger btn-lg rounded-pill px-4 shadow-sm">
                                        <i class="fa-solid fa-arrow-left me-2"></i>Kembali ke Beranda
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- End Section Detail Artikel -->

        <!-- Floating Section -->
        
        <div class="contact-widget">
            <div class="contact-icon" onclick="toggleContactWidget()">
                <!-- 👇 FIX: Dibungkus dengan asset() 👇 -->
                <img src="{{ asset('assets/img/company/floating-icon.webp') }}" alt="Contact Icon" loading="lazy">
            </div>
            <div class="contact-content" id="contactContent">
                <button class="close-btn" onclick="toggleContactWidget()">×</button>
                <h4>Hubungi Kami</h4>
                <div class="contact-cards">
                    <a href="#kontak" class="contact-card">
                        <div class="icon">📧</div>
                        <div class="info">
                            <div class="label">Email</div>
                            <div class="value">cs@pengenumroh.com</div>
                        </div>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=62811917988&text=Assalamu%27alaikum.%20Saya%20ingin%20berkonsultasi%20mengenai%20layanan%2Fproduk%20yang%20ditawarkan.%20Mohon%20bantuan%20dan%20informasinya.%20Terima%20kasih." target="_blank" class="contact-card">
                        <div class="icon">📱</div>
                        <div class="info">
                            <div class="label">WhatsApp</div>
                            <div class="value">+62 811-917-988</div>
                        </div>
                    </a>
                    <a href="https://www.instagram.com/pengenumrohofficial/" target="_blank" class="contact-card">
                        <div class="icon">📸</div>
                        <div class="info">
                            <div class="label">Instagram</div>
                            <div class="value">@pengenumrohofficial</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
    </main>

    <!-- Footer -->
    <div class="container-fluid footer py-5 text-white" style="background-color: #B71C1C;">
        <div class="container">
            <div class="row g-5 align-items-center text-center text-lg-start">
                <div class="col-lg-4">
                    <!-- 👇 FIX: Dibungkus dengan asset() 👇 -->
                    <img src="{{ asset('assets/img/company/logo-putih.webp') }}" alt="Logo MCSCorp" class="img-fluid mb-3" style="max-height: 50px;">
                    <p class="mb-1">
                        Pengenumroh merupakan marketplace umroh dan haji khusus yang membantu anda menemukan dan mendapatkan pelayanan dari travel-travel amanah dan terpercaya.
                    </p>
                    <div class="d-flex justify-content-center justify-content-lg-start gap-3 mt-3 flex-wrap">
                        <a href="https://www.instagram.com/pengenumrohofficial/" target="_blank" class="social-circle text-white">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://api.whatsapp.com/send?phone=62811917988&text=Assalamu%27alaikum.%20Saya%20ingin%20berkonsultasi%20mengenai%20layanan%2Fproduk%20yang%20ditawarkan.%20Mohon%20bantuan%20dan%20informasinya.%20Terima%20kasih." target="_blank" class="social-circle text-white">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.youtube.com/@Pengenumrohofficial" target="_blank" class="social-circle text-white">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="https://www.facebook.com/share/17PAvPTFrQ/" target="_blank" class="social-circle text-white">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="footer-item">
                        <h4 class="mb-4 text-white">Info Kontak</h4>
                        <div class="d-flex flex-column flex-lg-row align-items-center align-items-lg-start text-center text-lg-start mb-3">
                            <i class="fas fa-map-marker-alt text-white me-lg-3 mb-2 mb-lg-0"></i>
                            <div>
                                <h6 class="mb-1 text-white">Alamat</h6>
                                <p class="mb-0 text-white">
                                    <strong>Wisma Haramain, Jl. Mahoni Raya No.13, Kel. Baktijaya, Kec. Sukmajaya, Kota Depok</strong>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex flex-column flex-lg-row align-items-center align-items-lg-start text-center text-lg-start">
                            <i class="fa fa-phone-alt text-white me-lg-3 mb-2 mb-lg-0"></i>
                            <div>
                                <h6 class="mb-1 text-white">Telepon</h6>
                                <p class="mb-0 text-white"><strong>0811-917-988</strong></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- 👇 FIX: Dibungkus dengan asset() 👇 -->
                    <img src="{{ asset('assets/img/company/footer-foto.webp') }}" alt="Pengenumroh.com" class="img-fluid rounded mx-auto d-block" style="max-height: 250px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/gh/bootstrapmade/php-email-form/validate.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/js/glightbox.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/imagesloaded@5.0.0/imagesloaded.pkgd.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/isotope-layout@3.0.6/dist/isotope.pkgd.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

    <!-- Main JS File -->
    <!-- 👇 FIX: Dibungkus dengan asset() 👇 -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        function toggleContactWidget() {
            const content = document.getElementById('contactContent');
            content.classList.toggle('active');
        }

        // Tutup otomatis kalau kursor keluar dari widget
        const contactWidget = document.querySelector(".contact-widget");
        contactWidget.addEventListener("mouseleave", () => {
            const contactContent = document.getElementById("contactContent");
            contactContent.classList.remove("active");
        });

        lucide.createIcons();
    </script>
</body>
</html>