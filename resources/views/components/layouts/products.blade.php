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

        /* Custom Checkbox Style */
        .checkbox-wrapper input:checked+div {
            background-color: #ea580c;
            border-color: #ea580c;
        }

        .checkbox-wrapper input:checked+div svg {
            display: block;
        }

        /* Hide scrollbar for clean look */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
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

    <x-products.navbar />

    <main class="main">
        {{ $slot }}
    </main>

    <x-products.footer />

    <!-- CDN SCRIPT -->

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <!-- JS SCRIPT -->

        <script>
            document.getElementById('year').textContent = new Date().getFullYear();
        </script>

</body>

</html>
