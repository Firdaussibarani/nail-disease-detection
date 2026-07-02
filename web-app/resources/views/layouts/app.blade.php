<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'NailCheck') — Klasifikasi Citra Kuku EfficientNetB2</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary:   #6C63FF;
            --secondary: #FF6B9D;
            --mint:      #00D9A6;
            --gold:      #FFB800;
            --red:       #FF4757;
            --orange:    #FF8C42;
            --teal:      #4ECDC4;
            --bg:        #FDFCFF;
            --text:      #2D3142;
            --gradient:  linear-gradient(135deg, #6C63FF 0%, #FF6B9D 100%);
            --card-radius: 20px;
            --shadow:      0 10px 40px rgba(108,99,255,0.10);
            --shadow-hover: 0 20px 60px rgba(108,99,255,0.18);
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main { flex: 1; }

        /* ──────────── NAVBAR ──────────── */
        .navbar-nailcheck {
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(108,99,255,0.1);
            padding: 0.65rem 0;
            box-shadow: 0 2px 20px rgba(108,99,255,0.07);
        }

        .brand-icon-wrap {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: var(--gradient);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .brand-text {
            font-weight: 800;
            font-size: 1.35rem;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.3px;
        }

        .navbar-nailcheck .nav-link {
            color: var(--text) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.4rem 0.85rem !important;
            position: relative;
            transition: color 0.2s;
        }

        .navbar-nailcheck .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0; left: 0.85rem; right: 0.85rem;
            height: 2.5px;
            background: var(--gradient);
            border-radius: 2px;
            transform: scaleX(0);
            transition: transform 0.25s;
            transform-origin: left;
        }

        .navbar-nailcheck .nav-link:hover { color: var(--primary) !important; }
        .navbar-nailcheck .nav-link:hover::after,
        .navbar-nailcheck .nav-link.active::after { transform: scaleX(1); }
        .navbar-nailcheck .nav-link.active { color: var(--primary) !important; font-weight: 600; }

        .btn-nav-cta {
            background: var(--gradient) !important;
            color: #fff !important;
            border-radius: 50px !important;
            padding: 0.45rem 1.3rem !important;
            font-weight: 700 !important;
            font-size: 0.88rem !important;
            box-shadow: 0 4px 15px rgba(108,99,255,0.3);
            transition: all 0.25s !important;
        }

        .btn-nav-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108,99,255,0.4) !important;
        }

        .btn-nav-cta::after { display: none !important; }

        .navbar-toggler { border-color: rgba(108,99,255,0.25); }
        .navbar-toggler:focus { box-shadow: 0 0 0 3px rgba(108,99,255,0.2); }

        /* ──────────── GLOBAL BUTTONS ──────────── */
        .btn-gradient {
            background: var(--gradient);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 0.7rem 2rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.25s;
            box-shadow: 0 6px 20px rgba(108,99,255,0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #FF6B9D 0%, #6C63FF 100%);
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(108,99,255,0.4);
        }

        .btn-outline-primary-pill {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
            border-radius: 50px;
            padding: 0.68rem 2rem;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.25s;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-outline-primary-pill:hover {
            background: var(--gradient);
            color: #fff;
            border-color: transparent;
            transform: translateY(-3px);
        }

        /* ──────────── CARDS ──────────── */
        .card-nailcheck {
            border: none;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card-nailcheck:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        /* ──────────── SECTION HELPERS ──────────── */
        .section-title {
            font-weight: 800;
            font-size: clamp(1.5rem, 3vw, 1.9rem);
            color: var(--text);
        }

        .section-subtitle { color: #718096; font-size: 0.97rem; }

        .gradient-text {
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .accent-bar {
            display: inline-block;
            width: 48px; height: 4px;
            background: var(--gradient);
            border-radius: 2px;
            margin-bottom: 1rem;
        }

        /* Subtle dot-grid background pattern */
        .bg-dots {
            background-image: radial-gradient(rgba(108,99,255,0.07) 1.5px, transparent 1.5px);
            background-size: 28px 28px;
        }

        /* Level icon circle */
        .level-icon-circle {
            width: 80px; height: 80px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .level-icon-circle-lg {
            width: 96px; height: 96px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* Danger dots */
        .danger-dots .dot {
            display: inline-block;
            width: 10px; height: 10px;
            border-radius: 50%;
            margin-right: 3px;
        }

        /* ──────────── FOOTER ──────────── */
        .footer-nailcheck {
            background: #2D3142;
            color: rgba(255,255,255,0.65);
            padding: 1.75rem 0 1.25rem;
            margin-top: auto;
        }

        .footer-nailcheck a {
            color: rgba(255,255,255,0.55);
            text-decoration: none;
            font-size: 0.82rem;
            transition: color 0.2s;
        }

        .footer-nailcheck a:hover { color: #fff; }
    </style>

    @yield('styles')
</head>
<body>

{{-- ════════════ NAVBAR ════════════ --}}
<nav class="navbar navbar-expand-lg navbar-nailcheck sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
            <div class="brand-icon-wrap">
                <i class="fa-solid fa-hand-sparkles text-white" style="font-size:0.95rem;"></i>
            </div>
            <span class="brand-text">NailCheck</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
            <ul class="navbar-nav gap-1 align-items-lg-center mt-2 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fa-solid fa-house me-1"></i>Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('edukasi') ? 'active' : '' }}" href="{{ route('edukasi') }}">
                        <i class="fa-solid fa-book-medical me-1"></i>Edukasi
                    </a>
                </li>
                <li class="nav-item ms-lg-2">
                    <a class="nav-link btn-nav-cta {{ request()->routeIs('deteksi') ? 'active' : '' }}"
                       href="{{ route('deteksi') }}">
                        <i class="fa-solid fa-microscope me-1"></i>Deteksi Sekarang
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- ════════════ CONTENT ════════════ --}}
<main>
    @yield('content')
</main>

{{-- ════════════ FOOTER ════════════ --}}
<footer class="footer-nailcheck">
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-2">
                <div class="brand-icon-wrap" style="width:30px;height:30px;border-radius:8px;">
                    <i class="fa-solid fa-hand-sparkles text-white" style="font-size:0.8rem;"></i>
                </div>
                <div>
                    <div class="fw-700 text-white" style="font-size:0.95rem; line-height:1.1;">NailCheck</div>
                    <div style="font-size:0.72rem; color:rgba(255,255,255,0.4);">
                        Sistem Klasifikasi Citra Kuku berbasis EfficientNetB2
                    </div>
                </div>
            </div>
            <div class="d-flex gap-4">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('edukasi') }}">Edukasi</a>
                <a href="{{ route('deteksi') }}">Deteksi</a>
            </div>
        </div>
        <hr style="border-color:rgba(255,255,255,0.07); margin:1.2rem 0 0.9rem;">
        <p class="text-center mb-0" style="font-size:0.72rem; color:rgba(255,255,255,0.25);">
            &copy; {{ date('Y') }} NailCheck — Transfer Learning EfficientNetB2
        </p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
