<x-layouts.company>

    <!-- hero section -->

    <section id="slider">
        <div id="slider-img">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('assets/img/company/banner4.webp') }}" class="d-block w-100" alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/company/banner2.webp') }}" class="d-block w-100" alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/company/banner3.webp') }}" class="d-block w-100" alt="">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('assets/img/company/banner.webp') }}" class="d-block w-100" alt="">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- end hero section -->

    <!-- Tentang Kami Section -->

    <section class="py-1 py-md-5 bg-white position-relative overflow-hidden" id="tentang">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- Gambar di Kiri -->
                <div class="col-md-6">
                    <img src="{{ asset('assets/img/company/tentangkami-foto.webp') }}" class="img-fluid rounded-4"
                        alt="Tentang Kami" loading="lazy">
                </div>

                <!-- Konten di Kanan -->
                <div class="col-md-6 text-center text-md-start">
                    <h2 class="fw-bold mb-4" style="color: #EB2427; font-size: 2.5rem;">Tentang Kami</h2>
                    <p class="text-muted mb-3">
                        Kami, PT. Kolaborasi Para Sahabat merupakan penyedia layanan sistem penjualan produk
                        Umroh
                        dan Haji Khusus
                        dengan Brand pengenumroh.com yang diresmikan pada tahun 2022.
                    </p>
                    <p class="text-muted mb-3">
                        pengenumroh.com hadir sebagai solusi bagi Travel dan calon Jamaah untuk bertransaksi
                        dengan
                        mudah, aman,
                        dan nyaman.
                    </p>
                    <p class="text-muted mb-4">
                        Kami juga hadir mewakili Travel dalam melakukan pelayanan langsung kepada calon Jamaah
                        maupun Jamaah,
                        dengan memberikan secara gratis layanan unggulan kami, seperti konsultasi paket
                        perjalanan,
                        bantuan
                        pembuatan passport, antar-jemput dokumen maupun perlengkapan, sampai dengan penyambutan
                        kedatangan jamaah
                        saat kembali ke Indonesia.
                    </p>

                    <!-- Tombol -->
                    <div class="mt-3">
                        <a target="_blank"
                            href="https://api.whatsapp.com/send?phone=62811917988&text=Assalamu%27alaikum.%20Saya%20ingin%20berkonsultasi%20mengenai%20layanan%2Fproduk%20yang%20ditawarkan.%20Mohon%20bantuan%20dan%20informasinya.%20Terima%20kasih."
                            class="btn px-4 py-2 rounded-pill text-white fw-semibold"
                            style="background-color: #EB2427;">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bonus Spesial section -->

    <div id="bonus-spesial">
        <div id="bonus-spesial">
            <div id="carouselExampleIndicators" class="carousel slide mt-5">
                <div class="bonus-spesial">
                    <img src="{{ asset('assets/img/company/bonus-spesial.webp') }}" class="d-none d-sm-block w-100"
                        alt="Visimisi Desktop">
                    <img src="{{ asset('assets/img/company/bonus-spesial-mobile.webp') }}"
                        class="d-block d-sm-none w-100" alt="Visimisi Mobile">
                </div>
            </div>
        </div>
    </div>

    <!-- mengapamemilih Section -->

    <section class="why-section text-white d-flex align-items-center"
        style="background-image: url('{{ asset('assets/img/company/mengapamemilih.webp') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; min-height: 100vh;">
        <div class="container text-center">
            <!-- Judul -->
            <div class="mb-4">
                <h4 class="text-uppercase fw-semibold mb-1 text-white">Mengapa Memilih</h4>
                <h2 class="fw-bold display-5 text-white">pengenumroh.com</h2>
            </div>

            <div class="row g-4 justify-content-center">

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 rounded-4 shadow"
                        style="background: linear-gradient(135deg, #FFA52D 0%, #E4A73C 100%); color: #892A0C;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="bi bi-lightning-charge-fill display-4"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Proses Mudah & Cepat</h5>
                            <p class="card-text opacity-75">
                                Kami menyediakan layanan umroh yang mudah, cepat, dan transparan tanpa ribet.
                                Semua
                                bisa dilakukan
                                secara
                                online.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 rounded-4 shadow"
                        style="background: linear-gradient(135deg, #FFA52D 0%, #E4A73C 100%); color: #892A0C;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="bi bi-tags-fill display-4"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Harga Terjangkau</h5>
                            <p class="card-text opacity-75">
                                Kami menawarkan berbagai paket umroh terbaik dengan harga yang kompetitif dan
                                fasilitas lengkap untuk
                                kenyamanan Anda.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 rounded-4 shadow"
                        style="background: linear-gradient(135deg, #FFA52D 0%, #E4A73C 100%); color: #892A0C;">
                        <div class="card-body p-4 text-center">
                            <div class="mb-3">
                                <i class="bi bi-shield-check display-4"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Dipercaya Ribuan Jamaah</h5>
                            <p class="card-text opacity-75">
                                pengenumroh.com telah dipercaya oleh banyak jamaah dari seluruh Indonesia untuk
                                beribadah ke Tanah
                                Suci dengan
                                aman.
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Garansi Uang Kembali Section -->
    <section id="guarantee-section">
        <div class="container text-center px-3">

            <h2 class="text-white mb-3 animate__animated animate__fadeInUp animate__delay-0_4s">
                Garansi 100% Uang Kembali
            </h2>

            <p class="lead mb-0 text-white-50 animate__animated animate__fadeInUp animate__delay-0_6s">
                Apabila kami gagal memberangkatkan jamaah, uang Anda akan kami kembalikan sepenuhnya
                <strong class="text-white">tanpa potongan apapun</strong>.
            </p>

        </div>
    </section>

    <!-- mitrakami section -->

    <div id="mitra">
        <div id="mitra">
            <div id="carouselExampleIndicators" class="carousel slide">
                <div class="mitrakami">
                    <img src="{{ asset('assets/img/company/mitrakami.webp') }}" class="d-none d-sm-block w-100"
                        alt="Mitrakami Desktop">
                    <img src="{{ asset('assets/img/company/mitrakami-mobile.webp') }}" class="d-block d-sm-none w-100"
                        alt="Mitrakami Mobile">
                </div>
            </div>
        </div>
    </div>

    <!-- Section Produk -->

    <section class="py-5" style="background-color: #9e2e19;" id="produk">
        <div class="container text-center">
            <h2 class="text-white fw-bold mb-5" style="font-size: 2.5rem;">Produk pengenumroh.com</h2>

            <div class="row justify-content-center g-4">
                <!-- Card 1 -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('marketplace.beranda') }}" class="text-decoration-none">
                        <div class="card produk-card border-0 shadow h-100">
                            <img src="{{ asset('assets/img/company/paket1.webp') }}"
                                class="card-img-top rounded-top-4" alt="Produk 1" loading="lazy">
                        </div>
                    </a>
                </div>

                <!-- Card 2 (Highlight) -->
                <div class="col-md-6 col-lg-4 highlight-wrapper">
                    <a href="{{ route('marketplace.beranda') }}" class="text-decoration-none" id="link-produk">

                        <div
                            class="card produk-card highlight-card border-0 shadow-lg h-100 position-relative overflow-hidden">

                            <span class="shine-effect"></span>

                            <div class="card-hover-overlay d-none d-md-flex align-items-center justify-content-center">
                                <i class="fas fa-arrow-right cta-icon"></i>
                            </div>

                            <!-- <div class="mobile-cta-label">
                  <span><i class="fas fa-arrow-right me-1"></i> Lihat Detail</span>
                </div> -->

                            <img src="{{ asset('assets/img/company/paket2.webp') }}"
                                class="card-img-top rounded-top-4 img-zoom" alt="Produk 2">
                        </div>
                    </a>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('marketplace.beranda') }}" class="text-decoration-none">
                        <div class="card produk-card border-0 shadow-lg h-100">
                            <img src="{{ asset('assets/img/company/paket3.webp') }}"
                                class="card-img-top rounded-top-4" alt="Produk 3" loading="lazy">
                        </div>
                    </a>
                </div>
            </div>

            <!-- Tombol CTA -->
            <div class="mt-5">
                <a href="{{ route('marketplace.beranda') }}"
                    class="btn btn-light btn-lg px-4 rounded-pill shadow-sm fw-semibold" style="color: #EB2427;">
                    Lihat Selengkapnya
                </a>
            </div>
        </div>
    </section>

    <!-- Rancang Umroh -->

    <section id="rancang-umroh">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-md-12 text-content mb-5 mb-lg-0">
                    <div class="text-card">
                        <h2>Rancang Sendiri Umrohmu Sesuai Keinginan</h2>
                        <p>
                            Ingin perjalanan Umroh yang fleksibel dan sesuai kebutuhan? pengenumroh menghadirkan
                            layanan Umroh
                            Partial, di mana Anda
                            bisa memilih sendiri layanan yang diinginkan: mulai dari tiket pesawat grup Umroh,
                            visa
                            Umroh saja,
                            hotel di Mekkah dan
                            Madinah, transportasi lokal di Saudi, hingga jasa handling dan pendampingan di Tanah
                            Suci. Cocok untuk
                            jamaah yang ingin
                            Umroh mandiri, lebih hemat, dan tetap nyaman. Dengan sistem ini, Anda bisa menyusun
                            itinerari Umroh
                            sesuai preferensi
                            dan anggaran Anda
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 col-md-12">
                    <div class="image-grid-container image-grid-large">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="grid-item">
                                    <img src="{{ asset('assets/img/company/icon-tiketgrup.webp') }}"
                                        alt="tiket grup">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="grid-item">
                                    <img src="{{ asset('assets/img/company/icon-visa.webp') }}" alt="visa">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-0">
                            <div class="col-6">
                                <div class="grid-item">
                                    <img src="{{ asset('assets/img/company/icon-handlingsaudi.webp') }}"
                                        alt="handling saudi">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="grid-item">
                                    <img src="{{ asset('assets/img/company/icon-transportasi.webp') }}"
                                        alt="transportasi">
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mt-0 justify-content-center">
                            <div class="col-6">
                                <div class="grid-item">
                                    <img src="{{ asset('assets/img/company/icon-hotel.webp') }}" alt="hotel">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- testimoni section -->

    <section class="py-5" style="background-color: #9e2e19;" id="testimoni">
        <div class="container text-center">
            <h2 class="fw-bold text-white mb-2" style="font-size: 2.8rem; letter-spacing: -1px;">Testimoni
                Jamaah
            </h2>
            <p class="text-white-50 mb-5 fs-5 fw-light">Kisah Inspiratif dari Mereka yang Telah Berangkat
                Bersama
                pengenumroh.com</p>

            <div class="position-relative px-md-5">

                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel"
                    data-bs-interval="5000">
                    <div class="carousel-inner">

                        <div class="carousel-item active">
                            <div class="testimonial-card-modern mx-auto">
                                <div class="t-card-img-wrap">
                                    <img src="{{ asset('assets/img/company/testimoni/testimoni1.webp') }}"
                                        class="t-card-img" alt="Eko Budi Santoso">
                                </div>
                                <div class="t-card-content">
                                    <div class="t-rating mb-3">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <blockquote class="t-text mb-4">
                                        "Alhamdulillah, semua kebutuhan dari awal sampai pulang sudah dibantu.
                                        Jadi
                                        bisa fokus ibadah
                                        tanpa kepikiran hal teknis"
                                    </blockquote>
                                    <div class="t-info mt-auto">
                                        <h5 class="t-name fw-bold mb-3">Eko Budi Santoso</h5>
                                        <span class="badge badge-batch">Batch 16 Desember 2025</span>
                                    </div>
                                    <i class="bi bi-quote t-quote-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="testimonial-card-modern mx-auto">
                                <div class="t-card-img-wrap">
                                    <img src="{{ asset('assets/img/company/testimoni/testimoni2.webp') }}"
                                        class="t-card-img" alt="Hermawan Dodi Ahmad Darojat">
                                </div>
                                <div class="t-card-content">
                                    <div class="t-rating mb-3">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <blockquote class="t-text mb-4">
                                        "Prosesnya jelas dan rapi. Mulai dari dokumen sampai keberangkatan,
                                        semuanya
                                        terasa lebih mudah
                                        dan terarah"
                                    </blockquote>
                                    <div class="t-info mt-auto">
                                        <h5 class="t-name fw-bold mb-3">Hermawan Dodi Ahmad Darojat</h5>
                                        <span class="badge badge-batch">Batch 16 Desember 2025</span>
                                    </div>
                                    <i class="bi bi-quote t-quote-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="testimonial-card-modern mx-auto">
                                <div class="t-card-img-wrap">
                                    <img src="{{ asset('assets/img/company/testimoni/testimoni3.webp') }}"
                                        class="t-card-img" alt="Rachmatullah Sidik">
                                </div>
                                <div class="t-card-content">
                                    <div class="t-rating mb-3">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <blockquote class="t-text mb-4">
                                        "Fasilitas yang diberikan sangat membantu, terutama untuk jamaah pertama
                                        seperti saya. Lebih
                                        tenang selama menjalankan
                                        ibadah"
                                    </blockquote>
                                    <div class="t-info mt-auto">
                                        <h5 class="t-name fw-bold mb-3">Rachmatullah Sidik</h5>
                                        <span class="badge badge-batch">Batch 16 Desember 2025</span>
                                    </div>
                                    <i class="bi bi-quote t-quote-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="testimonial-card-modern mx-auto">
                                <div class="t-card-img-wrap">
                                    <img src="{{ asset('assets/img/company/testimoni/testimoni4.webp') }}"
                                        class="t-card-img" alt="Hans Sri Widiyastanto">
                                </div>
                                <div class="t-card-content">
                                    <div class="t-rating mb-3">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <blockquote class="t-text mb-4">
                                        "Dari awal sampai akhir, pelayanannya konsisten. Praktis, nyaman, dan
                                        membuat ibadah jadi lebih
                                        khusyuk"
                                    </blockquote>
                                    <div class="t-info mt-auto">
                                        <h5 class="t-name fw-bold mb-3">Hans Sri Widiyastanto</h5>
                                        <span class="badge badge-batch">Batch 16 Desember 2025</span>
                                    </div>
                                    <i class="bi bi-quote t-quote-icon"></i>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item">
                            <div class="testimonial-card-modern mx-auto">
                                <div class="t-card-img-wrap">
                                    <img src="{{ asset('assets/img/company/testimoni/testimoni5.webp') }}"
                                        class="t-card-img" alt="Anton">
                                </div>
                                <div class="t-card-content">
                                    <div class="t-rating mb-3">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                    </div>
                                    <blockquote class="t-text mb-4">
                                        "Pendampingannya terasa banget. Setiap tahap dijelaskan dengan baik,
                                        jadi
                                        tidak ada rasa bingung
                                        selama perjalanan"
                                    </blockquote>
                                    <div class="t-info mt-auto">
                                        <h5 class="t-name fw-bold mb-3">Anton</h5>
                                        <span class="badge badge-batch">Batch 16 Desember 2025</span>
                                    </div>
                                    <i class="bi bi-quote t-quote-icon"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="carousel-nav-wrapper">
                    <button class="custom-carousel-btn prev-btn" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="prev">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="custom-carousel-btn next-btn" type="button" data-bs-target="#testimonialCarousel"
                        data-bs-slide="next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>

            </div>
        </div>
    </section>

    <!-- Galeri section -->

    <section class="py-5" id="galeri" style="background-color: #fefefe;">
        <div class="container">
            <!-- Judul -->
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #EB2427; font-size: 2.5rem;">Galeri</h2>
                <p class="text-muted">Beberapa dokumentasi dari jamaah yang telah berangkat bersama
                    <strong>pengenumroh.com</strong>
                </p>
            </div>

            <!-- Galeri Grid -->
            <div class="row g-4">
                <!-- Galeri Item -->
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-box position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset('assets/img/company/galeri/galeri9.webp') }}"
                            class="img-fluid w-100 h-100 object-fit-cover" alt="Galeri 1" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-box position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset('assets/img/company/galeri/galeri10.webp') }}"
                            class="img-fluid w-100 h-100 object-fit-cover" alt="Galeri 2" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-box position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset('assets/img/company/galeri/galeri11.webp') }}"
                            class="img-fluid w-100 h-100 object-fit-cover" alt="Galeri 3" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-box position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset('assets/img/company/galeri/galeri1.webp') }}"
                            class="img-fluid w-100 h-100 object-fit-cover" alt="Galeri 1" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-box position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset('assets/img/company/galeri/galeri2.webp') }}"
                            class="img-fluid w-100 h-100 object-fit-cover" alt="Galeri 2" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-box position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset('assets/img/company/galeri/galeri3.webp') }}"
                            class="img-fluid w-100 h-100 object-fit-cover" alt="Galeri 3" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-box position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset('assets/img/company/galeri/galeri4.webp') }}"
                            class="img-fluid w-100 h-100 object-fit-cover" alt="Galeri 4" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-box position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset('assets/img/company/galeri/galeri5.webp') }}"
                            class="img-fluid w-100 h-100 object-fit-cover" alt="Galeri 5" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="gallery-box position-relative overflow-hidden rounded-4 shadow-sm">
                        <img src="{{ asset('assets/img/company/galeri/galeri8.webp') }}"
                            class="img-fluid w-100 h-100 object-fit-cover" alt="Galeri 6" loading="lazy">
                        <div class="overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- artikel section -->
    <section class="py-5" style="background-color: #ffffff;" id="artikel">
        <div class="container">
            <!-- Judul Section -->
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #EB2427; font-size: 2.5rem;">Artikel</h2>
                <p class="text-muted">Informasi, panduan, dan tips seputar ibadah umroh</p>
            </div>

            <!-- Artikel Cards -->
            <div class="row g-4">

                <!-- MARET -->

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel27.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Pengalaman Sahur di Tanah
                                Suci
                                yang Tidak
                                Terlupakan: Momen Spiritual yang Bikin Hati Rindu Kembali Lagi</h5>
                            <p class="card-text">Sahur di Tanah Suci bukan sekadar makan sebelum berpuasa
                            </p>
                            <a href="artikel/pengalaman-sahur-di-tanah-suci-yang-tidak-terlupakan-momen-spiritual-yang-bikin-hati-rindu-kembali-lagi.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel26.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Panduan Itinerary Umroh
                                Ramadhan Agar Ibadah
                                Tetap Nyaman dan Khusyuk</h5>
                            <p class="card-text">Menjalankan ibadah umroh di bulan Ramadhan memiliki
                                keistimewaan
                                luar biasa.Suasana
                                spiritual
                                yang lebih kuat, pahala yang berlipat-
                            </p>
                            <a href="artikel/panduan-itinerary-umroh-ramadhan-agar-ibadah-tetap-nyaman-dan-khusyuk.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel25.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Cara Memaksimalkan Doa Saat
                                Umroh di Bulan
                                Ramadhan agar Lebih Mustajab dan Penuh Keberkahan</h5>
                            <p class="card-text">Umroh di bulan Ramadhan adalah impian banyak umat Muslim
                            </p>
                            <a href="artikel/cara-memaksimalkan-doa-saat-umroh-di-bulan-ramadhan-agar-lebih-mustajab-dan-penuh-keberkahan.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- FEBRUARI -->

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel24.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Panduan Memilih Travel
                                Umroh
                                Ramadhan Terpercaya
                                Agar Tidak Tertipu: Tips Lengkap untuk Jamaah</h5>
                            <p class="card-text">Bulan Ramadhan adalah momen istimewa bagi umat Muslim untuk
                                beribadah di Tanah
                                Suci. Tidak heran jika permintaan-
                            </p>
                            <a href="artikel/panduan-memilih-travel-umroh-ramadhan-terpercaya-agar-tidak-tertipu-tips-lengkap-untuk-jamaah.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel23.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Rahasia Umroh di Bulan
                                Ramadhan
                                yang Pahalanya
                                Setara Haji — Kenapa Banyak Orang Berebut Berangkat?</h5>
                            <p class="card-text">Bulan Ramadhan selalu menjadi momen yang paling dinanti umat
                                Muslim di seluruh
                                dunia.
                            </p>
                            <a href="artikel/rahasia-umroh-di-bulan-ramadhan-yang-pahalanya-setara-haji-kenapa-banyak-orang-berebut-berangkat.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel22.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Tips Packing Praktis untuk
                                Umroh Ramadhan:
                                Ringkas, Nyaman, dan Tetap Khusyuk</h5>
                            <p class="card-text">Melaksanakan umroh di bulan Ramadhan adalah impian banyak umat
                                Muslim karena
                                suasananya lebih istimewa dan penuh
                                keberkahan.
                            </p>
                            <a href="artikel/tips-packing-praktis-untuk-umroh-ramadhan-ringkas-nyaman-dan-tetap-khusyuk.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- JANUARI -->

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel21.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Banyak Jamaah Kehilangan
                                Barang
                                Saat Umroh, Ini
                                Penyebab yang Sering
                                Diabaikan</h5>
                            <p class="card-text">Ibadah umroh adalah perjalanan suci yang diharapkan berjalan
                                dengan tenang dan
                                penuh
                                kekhusyukan.
                            </p>
                            <a href="artikel/banyak-jamaah-kehilangan-barang-saat-umroh-ini-penyebab-yang-sering-diabaikan.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel20.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Umroh Bersama Keluarga:
                                Tips
                                Nyaman untuk Anak
                                dan Orang Tua</h5>
                            <p class="card-text">Menjalankan umroh bersama keluarga adalah impian banyak
                                muslim.
                                Tidak hanya menjadi
                                ibadah
                                ke Tanah Suci,
                            </p>
                            <a href="artikel/umroh-bersama-keluarga-tips-nyaman-untuk-anak-dan-orang-tua.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel19.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Umroh Awal Tahun: Waktu
                                Terbaik
                                Memulai Ibadah
                                dengan Lebih Khusyuk</h5>
                            <p class="card-text">Awal tahun sering menjadi momen refleksi dan awal untuk
                                memperbaiki diri. Tidak
                                sedikit umat Muslim-
                            </p>
                            <a href="artikel/umroh-awal-tahun-waktu-terbaik-memulai-ibadah-dengan-lebih-khusyuk.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- DESEMBER -->

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel18.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">5 Kesalahan Kecil yang
                                Sering
                                Dilakukan Jamaah
                                Umroh dan Cara Menghindarinya</h5>
                            <p class="card-text">Pelajari 5 kesalahan kecil yang sering dilakukan jamaah umroh
                                dan
                                cara mudah
                                menghindarinya.
                            </p>
                            <a href="artikel/5-kesalahan-kecil-yang-sering-dilakukan-jamaah-umroh-dan-cara-menghindarinya.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel17.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 2" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Hal-Hal Kecil yang Cuma
                                Bisa
                                Kamu Rasakan Saat
                                Umroh, Bikin Hati Adem
                            </h5>
                            <p class="card-text">Temukan hal-hal kecil yang hanya bisa dirasakan saat umroh,
                                mulai
                                dari suasana
                                pelataran Nabawi hingga-
                            </p>
                            <a href="artikel/hal-hal-kecil-yang-cuma-bisa-kamu-rasakan-saat-umroh-bikin-hati-adem.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel16.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 1" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Cara Biar Umroh Lebih
                                Tenang:
                                Mulai dari Dokumen
                                sampai Perlengkapan
                            </h5>
                            <p class="card-text">Biar perjalanan umroh lebih tenang, kamu perlu persiapan
                                dokumen
                                dan perlengkapan
                                yang tepat.
                            </p>
                            <a href="artikel/cara-biar-umroh-lebih-tenang-mulai-dari-dokumen-sampai-perlengkapan.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- NOVEMBER -->

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel15.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Kenapa Persiapan Umroh
                                Akhir
                                Tahun Harus Dimulai
                                dari Sekarang?</h5>
                            <p class="card-text">Mulai persiapan umroh akhir tahun dari sekarang! Hindari seat
                                penuh dan proses
                                terburu-buru. Simak alasan penting kenapa
                                kamu harus merencanakan perjalanan suci-
                            </p>
                            <a href="artikel/kenapa-persiapan-umroh-akhir-tahun-harus-dimulai-dari-sekarang.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel14.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 2" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Hal-Hal Kecil Tapi Bermakna
                                yang Cuma Bisa Kamu
                                Rasakan Saat Umroh
                            </h5>
                            <p class="card-text">Umroh bukan cuma tentang thawaf dan doa — tapi juga momen
                                kecil
                                yang penuh makna.
                                Temukan hal-hal sederhana yang cuma
                                bisa kamu rasakan-
                            </p>
                            <a href="artikel/hal-hal-kecil-tapi-bermakna-yang-cuma-bisa-kamu-rasakan-saat-umroh.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel13.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 1" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Akhir Tahun Mau Umroh? Ini
                                Cara
                                Biar Perjalananmu
                                Tetap Nyaman & Lancar
                            </h5>
                            <p class="card-text">Mau umroh akhir tahun tanpa drama? Simak tips dan cara agar
                                perjalanan umroh tetap
                                nyaman, lancar, dan penuh berkah
                                bersama pengenUmroh.com.
                            </p>
                            <a href="artikel/akhir-tahun-mau-umroh-ini-cara-biar-perjalananmu-tetap-nyaman-dan-lancar.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- OKTOBER -->

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel12.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Tips & Trick Persiapan
                                Umroh
                                Akhir Tahun Agar
                                Ibadah Lebih Khusyuk</h5>
                            <p class="card-text">Persiapan umroh akhir tahun biar ibadah lebih khusyuk: mulai
                                dari
                                kesehatan,
                                mental-spiritual, hingga perlengkapan
                                wajib.
                            </p>
                            <a href="artikel/tips-trick-persiapan-umroh-akhir-tahun-biar-ibadah-lebih-khusyuk2.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel11.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 2" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Kenapa Umroh Akhir Tahun
                                Jadi
                                Pilihan Terbaik?
                                Ini Alasannya…
                            </h5>
                            <p class="card-text">Kenapa umroh akhir tahun jadi pilihan terbaik? Dari cuaca
                                sejuk,
                                waktu liburan
                                keluarga, hingga paket spesial hotel
                                dekat masjid.
                            </p>
                            <a href="artikel/kenapa-umroh-akhir-tahun-jadi-pilihan-terbaik-ini-alasannya2.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel10.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 1" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Liburan Akhir Tahun Penuh
                                Berkah: Umroh Bersama
                                Keluarga
                            </h5>
                            <p class="card-text">Liburan akhir tahun penuh berkah dengan keluarga lewat ibadah
                                umroh. Temukan alasan
                                mengapa umroh akhir tahun jadi
                                pilihan terbaik
                            </p>
                            <a href="artikel/liburan-akhir-tahun-penuh-berkah-umroh-bersama-keluarga.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- SEPTEMBER -->

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel9.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Tips & Trick Persiapan
                                Umroh
                                Akhir Tahun Biar
                                Ibadah Lebih Khusyuk</h5>
                            <p class="card-text">Persiapan umroh akhir tahun biar ibadah lebih khusyuk: mulai
                                dari
                                kesehatan,
                                mental-spiritual, hingga perlengkapan
                                wajib.
                            </p>
                            <a href="artikel/tips-trick-persiapan-umroh-akhir-tahun-biar-ibadah-lebih-khusyuk.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel8.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 2" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Keuntungan Umroh Akhir
                                Tahun:
                                Dari Cuaca Hingga
                                Suasana Ibadah
                            </h5>
                            <p class="card-text">Umroh akhir tahun punya banyak keuntungan: cuaca lebih sejuk,
                                suasana ibadah lebih
                                syahdu, hingga fasilitas premium.
                            </p>
                            <a href="artikel/keuntungan-umroh-akhir-tahun-dari-cuaca-hingga-suasana-ibadah.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel7.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 1" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Kenapa Umroh Akhir Tahun
                                Jadi
                                Pilihan Terbaik?
                                Ini Alasannya
                            </h5>
                            <p class="card-text">Umroh akhir tahun jadi pilihan terbaik bagi banyak jamaah.
                                Cari
                                tahu alasan, tips,
                                dan keuntungan melaksanakan ibadah
                                umroh
                            </p>
                            <a href="artikel/kenapa-umroh-akhir-tahun-jadi-pilihan-terbaik-ini-alasannya.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- AGUSTUS -->

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel6.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">High Season, High
                                Experience:
                                Umroh & China Halal
                                Tour Mulai 33 Jutaan Aja</h5>
                            <p class="card-text">Gabungkan ibadah dan liburan halal dalam satu perjalanan!
                                Program
                                Umroh + China
                            </p>
                            <a href="artikel/high-season-high-experience-umroh-china-halal-tour-mulai-33-jutaan-aja.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel5.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 2" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Hainan, Pulau Tropis dengan
                                Jejak Islam: Dari
                                Masjid Tua sampai Kuliner Halal
                            </h5>
                            <p class="card-text">Siapa sangka, di balik pemandangan tropis nan eksotis, Hainan
                                menyimpan sejarah
                                Islam.
                            </p>
                            <a href="artikel/hainan-pulau-tropis-dengan-jejak-islam-dari-masjid-tua-sampai-kuliner-halal.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel4.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 1" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Hainan: Surga Halal
                                Tersembunyi
                                di Tengah
                                Modernitas China
                            </h5>
                            <p class="card-text">Temukan sisi lain dari China yang jarang dibahas! Hainan,
                                pulau
                                tropis ramah Muslim
                                yang Temukan sisi lain dari China
                            </p>
                            <a href="artikel/hainan-surga-halal-tersembunyi-di-tengah-modernitas-china.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- JULI -->

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel3.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 1" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">7 Hal yang Perlu Disiapkan
                                Sebelum Berangkat
                                Umroh
                            </h5>
                            <p class="card-text">Sebelum berangkat Umroh, ada beberapa hal penting yang harus
                                kamu
                                siapkan.</p>
                            <a href="artikel/7-hal-yang-perlu-disiapkan-sebelum-berangkat-umroh.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel2.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 2" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Tips Memilih Travel Umroh
                                yang
                                Terpercaya dan
                                Aman
                            </h5>
                            <p class="card-text">Bingung pilih travel Umroh yang terpercaya? Cek tips penting
                                ini
                                sebelum daftar.
                            </p>
                            <a href="artikel/tips-memilih-travel-umroh-yang-terpercaya-dan-aman.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 extra-article d-none">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="ratio ratio-16x9">
                            <img src="{{ asset('assets/img/company/artikel/artikel1.webp') }}"
                                class="card-img-top object-fit-cover rounded-top" alt="Artikel 3" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold" style="color: #E92326;">Bingung Urus Umroh?
                                Sekarang
                                Semua Bisa Lewat
                                Satu
                                Platform!</h5>
                            <p class="card-text">Urus Umroh kini gak perlu ribet. pengenumroh.com bantu kamu
                                cari
                                travel</p>
                            <a href="artikel/bingung-urus-umroh-sekarang-semua-bisa-lewat-satu-platform.html"
                                class="btn text-white" style="background-color: #EB2427;">Selengkapnya</a>
                        </div>
                    </div>
                </div>

                <!-- Tombol Tampilkan Semua -->
                <div class="text-center mt-5">
                    <button id="showAllBtn" class="btn btn-outline-danger px-4 py-2 fw-semibold">
                        Tampilkan Semua Artikel
                    </button>
                </div>

            </div>
    </section>

    <!-- FAQ Section -->

    <section id="faq" class="py-5 bg-white">
        <div class="container px-3 px-md-5">

            <!-- Judul -->
            <div class="text-center mb-4">
                <h2 class="fw-bold" style="color: #EB2427; font-size: 2.5rem;">FAQ</h2>
                <p class="text-muted mb-5">Pertanyaan yang sering ditanyakan seputar layanan pengenumroh.com
                </p>

            </div>

            <!-- Accordion FAQ PengenUmroh -->
            <div class="accordion" id="faqAccordion">

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq1">
                            Apa itu pengenumroh?
                        </button>
                    </h2>
                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            pengenumroh.com adalah marketplace umroh dan haji khusus terpercaya di Indonesia
                            yang
                            menghubungkan
                            calon jamaah dengan
                            travel-travel resmi dan amanah dari seluruh provinsi di Indonesia.
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq2">
                            Mengapa memilih menggunakan pengenumroh?
                        </button>
                    </h2>
                    <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            <!-- Keunggulan PengenUmroh.com antara lain: -->
                            <ul class="mt-2 mb-0">
                                <li>Menyediakan jaminan keberangkatan dan garansi uang kembali 100% jika tidak
                                    bisa
                                    memberangkatkan
                                    jamaah</li>
                                <li>Mempermudah proses dengan dukungan: pembuatan paspor, antar-jemput dokumen
                                    dan
                                    perlengkapan</li>
                                <li>Travel partner memiliki izin resmi dari Kementerian Agama dan terdaftar
                                    sebagai
                                    anggota asosiasi
                                    penyelenggara umroh
                                    dan haji</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq3">
                            Apa saja jenis paket yang tersedia?
                        </button>
                    </h2>
                    <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Beberapa kategori paket yang tersedia antara lain:
                            <ul class="mt-2 mb-0">
                                <li>Umroh Reguler (umroh 9 hari dan 12 hari)</li>
                                <li>Umroh Ramadhan</li>
                                <li>Umroh Plus Wisata</li>
                                <li>Haji Khusus dengan kuota resmi pemerintah</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq4">
                            Berapa kisaran harga paket umroh?
                        </button>
                    </h2>
                    <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Harga paket yang tercantum di situs, misalnya:
                            <ul class="mt-2 mb-0">
                                <li>Paket Umroh Ekonomis pada Agustus 2025 mulai dari sekitar Rp28,9 juta,</li>
                                <li>Paket Ramadhan 2026 dimulai di kisaran Rp29,6 juta–Rp46,9 juta tergantung
                                    jenis
                                    dan lama
                                    perjalanan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq5">
                            Apakah pengenumroh menyediakan paket Haji Khusus?
                        </button>
                    </h2>
                    <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Ya, tersedia paket Haji Khusus dengan kuota resmi pemerintah—layanan eksklusif bagi
                            yang
                            ingin berangkat
                            tanpa antre
                            lama dan dengan fasilitas khusus
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq6">
                            Bagaimana proses mendaftar paket melalui pengenumroh?
                        </button>
                    </h2>
                    <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Prosedur umum:
                            <ul class="mt-2 mb-0">
                                <li>Buat akun di situs pengenumroh.com</li>
                                <li>Pilih paket sesuai kebutuhan (durasi, jenis, embarkasi, dll)</li>
                                <li>Hubungi travel partner dan selesaikan dokumen serta pembayaran</li>
                                <li>Tim akan membantu mulai dari paspor hingga keberangkatan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq7">
                            Apa saja layanan tambahan yang diberikan?
                        </button>
                    </h2>
                    <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            <ul class="mt-2 mb-0">
                                <li>Bantuan membuat paspor,</li>
                                <li>Jasa antar-jemput dokumen dan perlengkapan,</li>
                                <li>Pendampingan penuh hingga keberangkatan</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq8">
                            Apakah platform ini bisa diakses di seluruh Indonesia?
                        </button>
                    </h2>
                    <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            Ya, jangkauan layanannya mencakup seluruh Indonesia—dari Sabang hingga
                            Merauke—dengan
                            kolaborasi travel
                            dari berbagai
                            wilayah
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq9">
                            Bagaimana jika terjadi pembatalan dari pihak pengenumroh?
                        </button>
                    </h2>
                    <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            pengenumroh menjamin pengembalian dana 100% jika gagal memberangkatkan jamaah
                            seperti
                            yang dijanjikan
                        </div>
                    </div>
                </div>

                <div class="accordion-item mb-3 border-0 shadow-sm rounded">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-semibold collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq10">
                            Bagaimana cara menghubungi pengenumroh untuk informasi lebih lanjut?
                        </button>
                    </h2>
                    <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            <ul class="mt-2 mb-0">
                                <li>WhatsApp / Telp: 0811 917 988</li>
                                <li>Email: cs@pengenumroh.com</li>
                                <li>Alamat kantor pusat: Wisma Haramain, Jl. Mahoni Raya No. 13, Sukmajaya,
                                    Depok
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Agen Section  -->

    <section class="py-5 bg-white mb-3" id="agen" style="overflow-x: hidden;">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- Konten Kiri: Gambar -->
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('assets/img/company/agen.webp') }}" alt="Daftar Agen" loading="lazy"
                        class="img-fluid rounded-4 shadow w-100" style="max-width: 100%;">
                </div>

                <!-- Konten Kanan: Teks & Tombol -->
                <div class="col-lg-6">
                    <div class="text-lg-start text-center">
                        <h2 class="fw-bold mb-3" style="color: #EB2427; font-size: 2.3rem;">
                            Ingin Menjadi Agen Umroh?
                        </h2>
                        <p class="text-muted mb-4 fs-5">
                            Bergabunglah menjadi agen resmi <strong>pengenumroh.com</strong> dan mulai bantu
                            lebih
                            banyak orang
                            meraih impian ibadah ke Tanah Suci dengan cara yang mudah dan menguntungkan.
                        </p>
                        <a target="_blank" href="https://agen.pengenumroh.com/"
                            class="btn px-5 py-3 rounded-pill text-white fw-semibold"
                            style="background-color: #EB2427; font-size: 1rem; white-space: nowrap;">
                            Daftar Jadi Agen
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- End FAQ Section  -->

    <!-- Floating Section -->

    <div class="contact-widget">
        <div class="contact-icon" onclick="toggleContactWidget()">
            <img src="{{ asset('assets/img/company/floating-icon.webp') }}" alt="Contact Icon" loading="lazy">
        </div>

        <div class="contact-content" id="contactContent">
            <!-- Tombol X -->
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
                <a id="link-wa" target="_blank" class="contact-card">
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

    <!-- End Floating Section -->

</x-layouts.company>
