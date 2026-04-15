<header id="header" class="header d-flex align-items-center"
        style="background: radial-gradient(circle at 0% 0%, #fff6ed 0%, #ffffff 60%);">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="/" class="logo d-flex align-items-center">
                <img src="{{ asset('assets/img/company/logo.webp') }}" alt="Logo Pengenumroh" loading="lazy">
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('company.beranda') }}" class="active">Beranda</a></li>
                    <li><a href="/#tentang">Tentang</a></li>
                    <li><a href="/#produk">Produk</a></li>
                    <li><a href="/#testimoni">Testimoni</a></li>
                    <li><a href="/#artikel">Artikel</a></li>
                    <li><a href="/#faq">FAQ</a></li>

                    <li class="action-item">
                        <a href="https://agen.pengenumroh.com/" class="btn-action">
                            Agen
                        </a>
                    </li>

                    <li class="action-item">
                        <a href="{{ route('marketplace.beranda') }}" class="btn-action">Cari Paket Umroh</a>
                    </li>

                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>