@extends('layouts.app')
@section('title', 'Edukasi Kondisi Kuku')

@section('styles')
<style>
    .edu-hero {
        background: linear-gradient(135deg, #6C63FF 0%, #FF6B9D 100%);
        padding: 4rem 0 3rem;
        position: relative;
        overflow: hidden;
    }

    .edu-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 80% 50%, rgba(255,255,255,0.1) 0%, transparent 60%);
    }

    /* ── Quick Nav ── */
    .quick-nav {
        background: rgba(253,252,255,0.97);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(108,99,255,0.1);
        position: sticky;
        top: 63px;
        z-index: 99;
        padding: 0.6rem 0;
        box-shadow: 0 4px 16px rgba(108,99,255,0.06);
    }

    .quick-nav-scroll {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding-bottom: 2px;
        scrollbar-width: none;
    }

    .quick-nav-scroll::-webkit-scrollbar { display: none; }

    .qnav-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.32rem 0.85rem;
        border-radius: 50px;
        border: 1.5px solid #e0d9ff;
        color: #6C63FF;
        font-size: 0.76rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .qnav-chip:hover {
        background: linear-gradient(135deg, #6C63FF, #FF6B9D);
        color: #fff;
        border-color: transparent;
        transform: translateY(-1px);
    }

    /* ── Disease Card ── */
    .edu-card {
        background: #fff;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(108,99,255,0.10);
        margin-bottom: 2rem;
        transition: box-shadow 0.3s;
    }

    .edu-card:hover { box-shadow: 0 20px 60px rgba(108,99,255,0.16); }

    .edu-card-header {
        padding: 1.75rem 2rem 1.5rem;
        color: #fff;
        background: linear-gradient(135deg, #6C63FF, #FF6B9D); /* overridden by JS */
    }

    .header-icon-circle {
        width: 90px; height: 90px;
        border-radius: 50%;
        background: rgba(255,255,255,0.15);
        display: flex; align-items: center; justify-content: center;
        font-size: 2.5rem;
        flex-shrink: 0;
        border: 2px solid rgba(255,255,255,0.25);
    }

    .level-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 0.3em 0.85em;
        border-radius: 50px;
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        font-size: 0.8rem;
        font-weight: 600;
        color: #fff;
    }

    .header-dots .dot {
        display: inline-block;
        width: 11px; height: 11px;
        border-radius: 50%;
        margin-right: 4px;
        background: rgba(255,255,255,0.25); /* overridden by JS */
    }

    .header-dots .dot.filled {
        background: #fff;
    }

    .edu-card-body { padding: 2rem; }

    .content-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.09em;
        color: #6C63FF;
        margin-bottom: 0.5rem;
    }

    .content-block-title {
        font-weight: 700;
        font-size: 0.97rem;
        color: #2D3142;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .content-block-title .cb-icon {
        color: #6C63FF; /* overridden by JS */
    }

    .symptom-row {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        padding: 0.45rem 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.88rem;
        color: #4a5568;
        line-height: 1.5;
    }

    .symptom-row:last-child { border-bottom: none; }

    .symptom-dot {
        font-size: 0.65rem;
        margin-top: 0.3rem;
        flex-shrink: 0;
        color: #6C63FF; /* overridden by JS */
    }

    .rec-panel {
        border-radius: 16px;
        padding: 1.5rem;
        border-left: 5px solid #6C63FF; /* overridden by JS */
        background: rgba(108,99,255,0.07); /* overridden by JS */
    }

    .rec-item {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        padding: 0.6rem 0.8rem;
        border-radius: 10px;
        background: rgba(108,99,255,0.05); /* overridden by JS */
        font-size: 0.86rem;
        color: #2D3142;
        line-height: 1.5;
        margin-bottom: 0.5rem;
    }

    .rec-check {
        width: 20px; height: 20px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.65rem;
        flex-shrink: 0;
        margin-top: 0.1rem;
        background: rgba(108,99,255,0.15); /* overridden by JS */
    }

    .rec-check i {
        color: #6C63FF; /* overridden by JS */
    }

    .level-panel-box {
        background: rgba(255,255,255,0.1);
        border-radius: 16px;
        padding: 1rem 1.25rem;
        border: 1.5px solid rgba(255,255,255,0.25);
        text-align: center;
    }
</style>
@endsection

@section('content')

{{-- ── Hero ── --}}
<section class="edu-hero">
    <div class="container text-center position-relative" style="z-index:1;">
        <div class="mb-3">
            <span style="background:rgba(255,255,255,0.2);color:#fff;border-radius:50px;padding:0.3rem 1rem;font-size:0.8rem;font-weight:600;border:1px solid rgba(255,255,255,0.3);">
                <i class="fa-solid fa-book-medical me-1"></i>Panduan Kondisi Kuku
            </span>
        </div>
        <h1 class="fw-800 text-white mb-2" style="font-size:clamp(1.8rem,4vw,2.5rem);">
            Edukasi Kondisi Kuku
        </h1>
        <p class="mb-0" style="color:rgba(255,255,255,0.75);max-width:500px;margin:0 auto;font-size:0.95rem;">
            Kenali 6 kondisi kuku yang dapat diklasifikasikan oleh NailCheck —
            mulai dari kuku sehat hingga kondisi yang memerlukan penanganan segera.
        </p>
    </div>
</section>

{{-- ── Quick Nav ── --}}
<div class="quick-nav">
    <div class="container">
        <div class="quick-nav-scroll">
            @foreach($diseases as $key => $disease)
            @php $lc = \App\Data\DiseaseData::levelConfig($disease['danger_level']); @endphp
            <a href="#{{ $key }}" class="qnav-chip" data-chip-hex="{{ $lc['hex'] }}">
                <i class="fa-solid {{ $disease['icon'] }}"></i>
                {{ Str::words($disease['name'], 2, '') }}
            </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ── Daftar Penyakit ── --}}
<section class="py-5" style="background:var(--bg);">
    <div class="container">

        @foreach($diseases as $key => $disease)
        @php
            $lc = \App\Data\DiseaseData::levelConfig($disease['danger_level']);
            $grads = [
                0 => 'linear-gradient(135deg,#00b894,#00D9A6)',
                1 => 'linear-gradient(135deg,#4a9ded,#6BB6FF)',
                2 => 'linear-gradient(135deg,#00b4b4,#4ECDC4)',
                3 => 'linear-gradient(135deg,#e6a800,#FFB800)',
                4 => 'linear-gradient(135deg,#e05a00,#FF8C42)',
                5 => 'linear-gradient(135deg,#c0392b,#FF4757)',
            ];
            $grad = $grads[$disease['danger_level']] ?? $grads[0];
        @endphp

        <div class="edu-card" id="{{ $key }}"
             data-grad="{{ $grad }}"
             data-hex="{{ $lc['hex'] }}"
             data-light="{{ $lc['light'] }}"
             data-level="{{ $disease['danger_level'] }}">

            {{-- Header --}}
            <div class="edu-card-header">
                <div class="d-flex flex-wrap align-items-center gap-4">
                    <div class="header-icon-circle">
                        <i class="fa-solid {{ $disease['icon'] }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h4 class="fw-800 mb-2" style="font-size:clamp(1.1rem,2.5vw,1.45rem);">
                            {{ $disease['name'] }}
                        </h4>
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="level-badge-pill">
                                <i class="fa-solid {{ $lc['icon'] }}"></i>
                                {{ $lc['sublabel'] }}
                            </div>
                            <div class="header-dots">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="dot {{ $i <= $disease['danger_level'] ? 'filled' : '' }}"></span>
                                @endfor
                                <span style="font-size:0.75rem;color:rgba(255,255,255,0.75);margin-left:4px;">
                                    @if($disease['danger_level'] > 0)
                                        Level {{ $disease['danger_level'] }}/5
                                    @else
                                        Tidak Berbahaya
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="level-panel-box d-none d-md-block">
                        <i class="fa-solid {{ $lc['icon'] }}" style="font-size:2.2rem;color:#fff;display:block;margin-bottom:0.3rem;"></i>
                        <span style="font-size:0.7rem;color:rgba(255,255,255,0.85);font-weight:600;">
                            {{ $disease['danger_label'] }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="edu-card-body">
                <div class="row g-4">
                    {{-- Kiri: Deskripsi + Gejala --}}
                    <div class="col-lg-6">
                        <p class="content-label">
                            <i class="fa-solid fa-circle-info me-1"></i>Tentang Kondisi Ini
                        </p>
                        <p style="font-size:0.92rem;color:#4a5568;line-height:1.75;margin-bottom:1.5rem;">
                            {{ $disease['description'] }}
                        </p>
                        <div class="content-block-title">
                            <i class="fa-solid fa-stethoscope cb-icon"></i>
                            Gejala Umum
                        </div>
                        <div>
                            @foreach($disease['symptoms'] as $symptom)
                            <div class="symptom-row">
                                <i class="fa-solid fa-circle-dot symptom-dot"></i>
                                {{ $symptom }}
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Kanan: Rekomendasi --}}
                    <div class="col-lg-6">
                        <div class="rec-panel">
                            <div class="content-block-title">
                                <i class="fa-solid fa-clipboard-check cb-icon"></i>
                                Rekomendasi Tindakan
                            </div>
                            @foreach($disease['recommendations'] as $rec)
                            <div class="rec-item">
                                <div class="rec-check">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <span>{{ $rec }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</section>

{{-- ── CTA ── --}}
<section style="background:linear-gradient(135deg,#6C63FF 0%,#FF6B9D 100%);padding:3.5rem 0;position:relative;overflow:hidden;">
    <div class="container text-center position-relative" style="z-index:1;">
        <h2 class="fw-800 text-white mb-2">Ingin Cek Kondisi Kuku Anda?</h2>
        <p class="mb-4" style="color:rgba(255,255,255,0.75);font-size:0.95rem;">
            Gunakan fitur klasifikasi model untuk analisis kondisi kuku secara instan.
        </p>
        <a href="{{ route('deteksi') }}"
           style="background:#fff;color:#6C63FF;border-radius:50px;padding:0.75rem 2.2rem;font-weight:700;font-size:0.97rem;text-decoration:none;display:inline-flex;align-items:center;gap:0.5rem;box-shadow:0 8px 24px rgba(0,0,0,0.15);">
            <i class="fa-solid fa-microscope"></i>Mulai Deteksi Sekarang
        </a>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    // Apply chip colors from data attributes
    document.querySelectorAll('.qnav-chip[data-chip-hex]').forEach(function (chip) {
        var hex = chip.dataset.chipHex;
        chip.style.borderColor = hex + '33';
        chip.style.color = hex;
    });

    // Apply per-card colors from data attributes
    document.querySelectorAll('.edu-card[data-hex]').forEach(function (card) {
        var hex   = card.dataset.hex;
        var light = card.dataset.light;
        var grad  = card.dataset.grad;

        // Header gradient
        var header = card.querySelector('.edu-card-header');
        if (header) header.style.background = grad;

        // Icons inside body
        card.querySelectorAll('.cb-icon').forEach(function (el) { el.style.color = hex; });
        card.querySelectorAll('.symptom-dot').forEach(function (el) { el.style.color = hex; });

        // Rec panel bg + border
        var panel = card.querySelector('.rec-panel');
        if (panel) {
            panel.style.background = light;
            panel.style.borderLeftColor = hex;
        }

        // Rec items
        card.querySelectorAll('.rec-item').forEach(function (item) {
            item.style.background = light.replace('0.13)', '0.05)');
        });

        // Rec check circles
        card.querySelectorAll('.rec-check').forEach(function (chk) {
            chk.style.background = light;
        });
        card.querySelectorAll('.rec-check i').forEach(function (icon) {
            icon.style.color = hex;
        });
    });
})();
</script>
@endsection
