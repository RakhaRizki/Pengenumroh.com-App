<!doctype html>
<html lang="id" class="scroll-smooth">

<head>

    <title>Pengenumroh - Marketplace Umroh & Haji Terpercaya</title>
    <link rel="icon" type="image/png" href="/assets/img/marketplace/favicon.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
        }

        /* Hide Scrollbar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseSlow {

            0%,
            100% {
                transform: scale(1.05);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .animate-pulse-slow {
            animation: pulseSlow 20s infinite ease-in-out;
        }

        /* Flatpickr Override */
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.selected.inRange,
        .flatpickr-day.startRange.inRange,
        .flatpickr-day.endRange.inRange,
        .flatpickr-day.selected:focus,
        .flatpickr-day.startRange:focus,
        .flatpickr-day.endRange:focus,
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: #ea580c !important;
            border-color: #ea580c !important;
        }

        /* Select Styling */
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: none;
        }

        /* seat bar */
        @keyframes move-stripes {
            from {
                background-position: 0 0;
            }

            to {
                background-position: 40px 0;
            }
        }

        /* Animasi tambahan agar bar terlihat berdenyut cahayanya */
        @keyframes glow-pulse {

            0%,
            100% {
                filter: brightness(1);
                box-shadow: 0 0 5px rgba(255, 120, 46, 0.4);
            }

            50% {
                filter: brightness(1.15);
                box-shadow: 0 0 15px rgba(255, 120, 46, 0.8);
            }
        }

        .progress-orange-animated {
            /* Warna Dasar Oranye Terang (Lebih Vibrant) */
            background-color: #ff782e;

            /* Lapisan Garis Putih dengan Opacity yang disesuaikan agar tidak membuat kusam */
            background-image: linear-gradient(45deg,
                    rgba(255, 255, 255, 0.4) 25%,
                    transparent 25%,
                    transparent 50%,
                    rgba(255, 255, 255, 0.4) 50%,
                    rgba(255, 255, 255, 0.4) 75%,
                    transparent 75%,
                    transparent);
            background-size: 40px 40px;

            /* Menggabungkan animasi jalan dan animasi berdenyut */
            animation: move-stripes 0.8s linear infinite, glow-pulse 2s ease-in-out infinite;

            /* Memberikan efek glossy/licin */
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>

</head>

<body class="text-slate-800 antialiased selection:bg-orange-500 selection:text-white">

    <x-marketplace.navbar />

    <main class="main">
        {{ $slot }}
    </main>

    <x-marketplace.footer />

    <!-- CDN SCRIPT -->

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <!-- JS SCRIPT -->

    <script>
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>

<script>
    // --- FLATPICKR ---
    const datePicker = flatpickr("#input-date", {
        locale: "id",
        altInput: true,
        altFormat: "F Y",
        dateFormat: "Y-m", 
        minDate: "today",
        disableMobile: "true",
        theme: "airbnb",
        onChange: function(selectedDates, dateStr, instance) {
            instance.input.classList.add('text-orange-600');
            setTimeout(() => instance.input.classList.remove('text-orange-600'), 300);
        }
    });

    // --- LOGIKA FILTER KATEGORI (ATAS & BAWAH) ---
    let kategoriAktif = 'all';

    function filterKategori(idKategori) {
        kategoriAktif = idKategori;

        // [BARU] RESET FORM SEARCH SETIAP KALI TOMBOL KATEGORI DIKLIK
        document.getElementById('input-departure').value = "";
        document.getElementById('input-budget').value = "all";
        if (typeof datePicker !== 'undefined' && datePicker) {
            datePicker.clear(); // Bersihin tanggal di Flatpickr
        } else {
            document.getElementById('input-date').value = "";
        }

        // 1. KEMBALIKAN SEMUA TOMBOL KE WARNA DEFAULT
        document.querySelectorAll('.kategori-btn').forEach(btn => {
            btn.className = "kategori-btn px-4 py-2 rounded-full text-xs md:text-sm font-medium text-slate-200 hover:text-white hover:bg-white/10 transition-all duration-300 whitespace-nowrap";
        });
        
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.className = "filter-btn px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-300 whitespace-nowrap border bg-white text-slate-600 border-slate-200 hover:bg-slate-100 md:bg-transparent md:border-transparent";
        });

        // 2. WARNAIN OREN KHUSUS TOMBOL YANG DIKLIK
        let tombolDipilih = document.querySelectorAll(`[onclick="filterKategori('${idKategori}')"], [data-filter="${idKategori}"]`);
        tombolDipilih.forEach(btn => {
            if (btn.classList.contains('kategori-btn')) {
                btn.className = "kategori-btn active px-4 py-2 rounded-full text-xs md:text-sm font-bold text-white bg-orange-600 shadow-md transition-all duration-300 whitespace-nowrap hover:bg-orange-700";
            } else {
                btn.className = "filter-btn active px-5 py-2.5 rounded-full text-sm font-bold transition-all duration-300 whitespace-nowrap border bg-orange-600 text-white border-transparent shadow-md hover:bg-orange-700";
            }
        });

        // Langsung filter tanpa popup loading
        jalankanPencarian(false); 
    }

    // --- SEARCH HANDLER (TOMBOL CARI) ---
    function handleSearch(event) {
        event.preventDefault(); 
        
        const btnSearch = document.getElementById('btn-search');
        const originalContent = btnSearch.innerHTML;
        
        btnSearch.innerHTML = '<i class="ph-bold ph-spinner animate-spin text-xl"></i>';
        btnSearch.disabled = true;
        btnSearch.classList.add('opacity-75', 'cursor-not-allowed');

        setTimeout(() => {
            btnSearch.innerHTML = originalContent;
            btnSearch.disabled = false;
            btnSearch.classList.remove('opacity-75', 'cursor-not-allowed');

            jalankanPencarian(true); 
        }, 800); 
    }

    // --- MESIN UTAMA PENCARIAN ---
    function jalankanPencarian(tampilkanPopup = false) {
        let kotaBerangkat = document.getElementById('input-departure').value.toLowerCase();
        let tglBerangkat = document.getElementById('input-date').value; 
        let budget = document.getElementById('input-budget').value;

        let daftarCard = document.querySelectorAll('.product-card');
        let jumlahDitemukan = 0; 

        daftarCard.forEach(card => {
            let tampilkan = true;

            // [BARU] Pake OR (|| '') buat nahan error kalau data API kosong
            let cardKategori = card.getAttribute('data-category') || '';
            let cardKota = (card.getAttribute('data-kota') || '').toLowerCase();
            let cardTanggal = card.getAttribute('data-tanggal') || ''; 
            let cardHarga = parseInt(card.getAttribute('data-harga')) || 0;

            // A. Filter Kategori 
            if (kategoriAktif !== 'all' && cardKategori !== String(kategoriAktif)) tampilkan = false;
            
            // B. Filter Kota 
            if (kotaBerangkat !== '' && !cardKota.includes(kotaBerangkat)) tampilkan = false;
            
            // C. Filter Tanggal
            if (tglBerangkat !== '' && !cardTanggal.startsWith(tglBerangkat)) tampilkan = false;

            // D. Filter Budget
            if (budget !== 'all') {
                if (budget === 'hemat' && cardHarga >= 28000000) tampilkan = false;
                if (budget === 'reguler' && (cardHarga < 28000000 || cardHarga > 35000000)) tampilkan = false;
                if (budget === 'vip' && cardHarga <= 35000000) tampilkan = false;
            }

            // Eksekusi
            if (tampilkan) {
                card.style.display = 'flex';
                jumlahDitemukan++;
            } else {
                card.style.display = 'none';
            }
        });

        // Popup Alert
        if (tampilkanPopup) {
            Swal.fire({
                icon: jumlahDitemukan > 0 ? 'success' : 'warning',
                title: jumlahDitemukan > 0 ? 'Pencarian Selesai!' : 'Oops!',
                text: jumlahDitemukan > 0 ? `Ditemukan ${jumlahDitemukan} paket yang sesuai kriteria.` : 'Maaf, tidak ada paket yang sesuai dengan filter Anda.',
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#ea580c'
            }).then(() => {
                document.getElementById('produk').scrollIntoView({ behavior: 'smooth' });
            });
        }
    }
</script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });

        // Mobile Menu Logic
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        function toggleMobileMenu() {
            mobileMenu.classList.toggle('hidden');
        }

        menuBtn.addEventListener('click', toggleMobileMenu);

        // Sticky Navbar Effect
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('py-0');
            } else {
                navbar.classList.remove('py-0');
            }
        });

        // --- AUTH SIMULATION LOGIC ---
        let isLoggedIn = true;

        function toggleAuth(status) {
            isLoggedIn = status;
            renderAuth();
        }

        function renderAuth() {
            const guestEl = document.getElementById('desktop-guest');
            const userEl = document.getElementById('desktop-user');
            const mobileGuest = document.getElementById('mobile-guest-actions');
            const mobileUser = document.getElementById('mobile-user-actions');
            const mobileProfile = document.getElementById('mobile-profile-section');
            const mobileUserIcon = document.getElementById('mobile-user-icon');

            if (isLoggedIn) {
                // Desktop
                if (guestEl) guestEl.classList.add('hidden');
                if (userEl) userEl.classList.remove('hidden');
                // Mobile
                if (mobileGuest) mobileGuest.classList.add('hidden');
                if (mobileUser) mobileUser.classList.remove('hidden');
                if (mobileProfile) mobileProfile.classList.remove('hidden');
                if (mobileUserIcon) {
                    mobileUserIcon.classList.remove('hidden');
                    mobileUserIcon.classList.add('block');
                }
            } else {
                // Desktop
                if (guestEl) guestEl.classList.remove('hidden');
                if (userEl) userEl.classList.add('hidden');
                // Mobile
                if (mobileGuest) mobileGuest.classList.remove('hidden');
                if (mobileUser) mobileUser.classList.add('hidden');
                if (mobileProfile) mobileProfile.classList.add('hidden');
                if (mobileUserIcon) {
                    mobileUserIcon.classList.add('hidden');
                    mobileUserIcon.classList.remove('block');
                }
            }
        }
        renderAuth();

        // --- FILTER PRODUCT LOGIC ---
        const filterBtns = document.querySelectorAll('.filter-btn');
        const productCards = document.querySelectorAll('.product-card');
        const activeClasses = ['bg-orange-600', 'text-white', 'border-transparent', 'shadow-md', 'font-bold',
            'hover:bg-orange-700'
        ];
        const inactiveClasses = ['bg-white', 'text-slate-600', 'border-slate-200', 'hover:bg-slate-100',
            'md:bg-transparent', 'md:border-transparent', 'font-semibold'
        ];

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Reset styling
                filterBtns.forEach(b => {
                    b.classList.remove(...activeClasses);
                    b.classList.add(...inactiveClasses);
                });
                // Activate clicked button
                btn.classList.remove(...inactiveClasses);
                btn.classList.add(...activeClasses);

                const filterValue = btn.getAttribute('data-filter');

                productCards.forEach(card => {
                    if (filterValue === 'all' || card.getAttribute('data-category') ===
                        filterValue) {
                        // FIX: Use hidden class instead of style.display to maintain Grid layout
                        card.classList.remove('hidden');
                        setTimeout(() => {
                            card.classList.remove('opacity-0', 'scale-95');
                            card.classList.add('opacity-100', 'scale-100');
                        }, 50);
                    } else {
                        card.classList.add('opacity-0', 'scale-95');
                        card.classList.remove('opacity-100', 'scale-100');
                        setTimeout(() => {
                            card.classList.add('hidden');
                        }, 300); // Wait for animation
                    }
                });
            });
        });

        // --- WISHLIST BUTTON LOGIC ---
        document.querySelectorAll('.wishlist-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault(); // Mencegah klik tembus ke card
                e.stopPropagation(); // Mencegah event bubbling

                btn.classList.toggle('is-liked');

                // Definisi Toast (Bisa dipakai berulang)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                if (btn.classList.contains('is-liked')) {
                    // State: LIKED
                    btn.classList.remove('text-white', 'bg-white/20', 'backdrop-blur-md');
                    btn.classList.add('text-red-500', 'bg-white', 'shadow-md', 'scale-110');

                    // Notifikasi Sukses
                    Toast.fire({
                        icon: 'success',
                        title: 'Ditambahkan ke Wishlist'
                    });

                } else {
                    // State: UNLIKED (Kembali ke default HTML)
                    btn.classList.remove('text-red-500', 'bg-white', 'shadow-md', 'scale-110');
                    btn.classList.add('text-white', 'bg-white/20', 'backdrop-blur-md');

                    // Notifikasi Hapus (BAGIAN INI YANG DITAMBAHKAN)
                    Toast.fire({
                        icon: 'info', // Menggunakan icon info agar beda dengan sukses
                        title: 'Dihapus dari Wishlist'
                    });
                }
            });
        });

        // --- LIGHTBOX LOGIC ---
        const lightboxModal = document.getElementById('lightbox-modal');
        const lightboxImage = document.getElementById('lightbox-image');
        const lightboxCaption = document.getElementById('lightbox-caption');

        function openLightbox(element) {
            const img = element.querySelector('img');
            lightboxImage.src = img.src;
            lightboxCaption.textContent = img.getAttribute('alt');
            lightboxModal.classList.remove('hidden');
            setTimeout(() => {
                lightboxModal.classList.remove('opacity-0');
                lightboxImage.classList.remove('scale-95');
                lightboxImage.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightboxModal.classList.add('opacity-0');
            lightboxImage.classList.remove('scale-100');
            lightboxImage.classList.add('scale-95');
            setTimeout(() => {
                lightboxModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === "Escape") closeLightbox();
        });

        // --- TOGGLE MITRA ---
        // const toggleBtn = document.getElementById('toggle-mitra-btn');
        // const hiddenItems = document.querySelectorAll('.hidden-mitra');
        // const btnText = document.getElementById('toggle-btn-text');
        // const btnIcon = document.getElementById('toggle-btn-icon');

        // toggleBtn.addEventListener('click', (e) => {
        //     e.preventDefault();
        //     let isExpanded = false;

        //     hiddenItems.forEach(item => {
        //         if (item.classList.contains('hidden')) {
        //             item.classList.remove('hidden');
        //             item.classList.add('flex'); // Fix layout
        //             item.style.animation = "fadeInUp 0.5s ease-out forwards";
        //             isExpanded = true;
        //         } else {
        //             item.classList.add('hidden');
        //             item.classList.remove('flex');
        //             isExpanded = false;
        //         }
        //     });

        //     if (isExpanded) {
        //         btnText.textContent = "Sembunyikan";
        //         btnIcon.classList.replace('ph-arrow-right', 'ph-caret-up');
        //     } else {
        //         btnText.textContent = "Lihat Semua Mitra";
        //         btnIcon.classList.replace('ph-caret-up', 'ph-arrow-right');
        //     }
        // });

        function addToCompare(button) {
            // Mencegah event bubbling (agar tidak men-trigger klik gambar jika ada)
            event.stopPropagation();

            // Efek visual pada tombol (Ganti warna jadi aktif)
            // Cek apakah tombol sudah aktif atau belum
            const isActive = button.classList.contains('bg-teal-600');

            if (!isActive) {
                // -- LOGIKA MENAMBAHKAN --

                // Ubah style tombol jadi "Aktif"
                button.classList.remove('bg-white/20', 'text-white');
                button.classList.add('bg-teal-600', 'text-white', 'border-teal-600');

                // Tampilkan Notifikasi SweetAlert (Toast Kecil di Pojok)
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Ditambahkan ke perbandingan'
                });

            } else {
                // -- LOGIKA MENGHAPUS (Opsional: Jika diklik lagi) --

                // Kembalikan style tombol ke awal
                button.classList.add('bg-white/20', 'text-white');
                button.classList.remove('bg-teal-600', 'text-white', 'border-teal-600');

                // Tampilkan Notifikasi Hapus
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000
                });

                Toast.fire({
                    icon: 'info',
                    title: 'Dihapus dari perbandingan'
                });
            }
        }
    </script>

</body>

</html>
