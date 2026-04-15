<header id="header" class="header d-flex align-items-center">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <a href="/" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/company/logo.webp') }}" alt="Logo Pengenumroh">
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#beranda" class="active">Beranda</a></li>
                <li><a href="#tentang">Tentang</a></li>
                <li><a href="#produk">Produk</a></li>
                <li><a href="#testimoni">Testimoni</a></li>
                <li><a href="#artikel">Artikel</a></li>
                <li><a href="#faq">FAQ</a></li>

                <li class="action-item">
                    <a href="https://agen.pengenumroh.com/" class="btn-action">
                        Agen
                    </a>
                </li>

                <li class="action-item">
                    <a href="{{ route('company.loyalty') }}" class="btn-action">Loyalty Card</a>
                </li>

            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>
