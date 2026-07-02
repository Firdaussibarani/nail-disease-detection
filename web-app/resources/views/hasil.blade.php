@extends('layouts.app')
@section('title', 'Hasil Klasifikasi — ' . $disease['name'])

@section('styles')
<style>
    .hasil-hero {
        background: linear-gradient(135deg, #6C63FF 0%, #FF6B9D 100%);
        padding: 3rem 0 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .hasil-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 80% 50%, rgba(255,255,255,0.1) 0%, transparent 60%);
    }

    /* ── Main result card ── */
    .result-card {
        background: #fff;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(108,99,255,0.12);
        margin-bottom: 1.5rem;
    }

    .result-header {
        padding: 2rem;
        color: #fff;
        background: linear-gradient(135deg, #2D3142, #3d3d60); /* overridden by JS */
    }

    /* ── Big level icon ── */
    .level-icon-big {
        width: 96px; height: 96px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        background: rgba(255,255,255,0.15); /* overridden by JS */
        flex-shrink: 0;
        border: 3px solid rgba(255,255,255,0.25);
    }

    /* ── Danger dots ── */
    .res-dots .dot {
        display: inline-block;
        width: 13px; height: 13px;
        border-radius: 50%;
        margin-right: 4px;
    }

    .res-dots .dot.filled { background: #fff; }
    .res-dots .dot.empty  { background: rgba(255,255,255,0.2); }

    /* ── Confidence bar ── */
    .conf-track {
        height: 16px;
        border-radius: 8px;
        background: rgba(255,255,255,0.15);
        overflow: hidden;
    }

    .conf-fill {
        height: 100%;
        border-radius: 8px;
        width: 0;
        transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
        background: linear-gradient(90deg, #fff, rgba(255,255,255,0.7)); /* overridden by JS */
    }

    /* ── Prob mini bars ── */
    .prob-row {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.55rem;
        font-size: 0.8rem;
    }

    .prob-label {
        width: 185px;
        flex-shrink: 0;
        color: rgba(255,255,255,0.75);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .prob-track {
        flex: 1;
        height: 5px;
        border-radius: 3px;
        background: rgba(255,255,255,0.12);
        overflow: hidden;
    }

    .prob-fill {
        height: 100%;
        border-radius: 3px;
        width: 0;
        transition: width 0.9s ease-out;
        background: rgba(255,255,255,0.45);
    }

    .prob-fill.is-winner {
        background: #fff; /* overridden by JS with level color */
    }

    .prob-val {
        width: 42px;
        text-align: right;
        color: rgba(255,255,255,0.8);
        font-weight: 600;
        flex-shrink: 0;
    }

    /* ── Content card ── */
    .content-card {
        background: #fff;
        border-radius: 18px;
        padding: 1.75rem 2rem;
        box-shadow: 0 10px 40px rgba(108,99,255,0.08);
        margin-bottom: 1.5rem;
    }

    .content-card-title {
        font-weight: 700;
        font-size: 1rem;
        color: #2D3142;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .ct-icon { color: #6C63FF; /* overridden by JS */ }

    .symptom-item {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.9rem;
        color: #4a5568;
        line-height: 1.5;
    }

    .symptom-item:last-child { border-bottom: none; }

    .sym-dot {
        font-size: 0.65rem;
        margin-top: 0.3rem;
        flex-shrink: 0;
        color: #6C63FF; /* overridden by JS */
    }

    /* ── Rec card ── */
    .rec-card {
        background: #fff;
        border-radius: 18px;
        padding: 1.75rem 2rem;
        box-shadow: 0 10px 40px rgba(108,99,255,0.08);
        border-left: 5px solid #00D9A6; /* overridden by JS */
        margin-bottom: 1.5rem;
    }

    .rec-grid-item {
        display: flex;
        align-items: flex-start;
        gap: 0.6rem;
        padding: 0.65rem 0.85rem;
        border-radius: 12px;
        background: rgba(0,217,166,0.06); /* overridden by JS */
        font-size: 0.87rem;
        color: #2D3142;
        line-height: 1.5;
    }

    .rec-circle {
        width: 22px; height: 22px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.6rem;
        flex-shrink: 0;
        margin-top: 0.1rem;
        background: rgba(0,217,166,0.15); /* overridden by JS */
    }

    .rec-circle i { color: #00D9A6; /* overridden by JS */ }

    /* Static classes for elements near Blade expressions */
    .level-icon-i    { font-size: 2.6rem; color: #fff; }
    .danger-badge-pill {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 50px;
        padding: 0.3em 0.9em;
        font-size: 0.8rem;
        font-weight: 700;
        color: #fff;
    }
</style>
@endsection

@section('content')

@php
    $lc   = \App\Data\DiseaseData::levelConfig($disease['danger_level']);
    arsort($all_probs);
    $winnerKey = $disease['key'];

    $headerGrads = [
        0 => 'linear-gradient(135deg,#00b894,#00D9A6)',
        1 => 'linear-gradient(135deg,#4a9ded,#6BB6FF)',
        2 => 'linear-gradient(135deg,#00b4b4,#4ECDC4)',
        3 => 'linear-gradient(135deg,#e6a800,#FFB800)',
        4 => 'linear-gradient(135deg,#e05a00,#FF8C42)',
        5 => 'linear-gradient(135deg,#c0392b,#FF4757)',
    ];
    $headerGrad = $headerGrads[$disease['danger_level']] ?? $headerGrads[0];
@endphp

{{-- ── Hero ── --}}
<section class="hasil-hero">
    <div class="container text-center position-relative" style="z-index:1;">
        <div class="mb-2">
            <span style="background:rgba(255,255,255,0.2);color:#fff;border-radius:50px;padding:0.3rem 1rem;font-size:0.8rem;font-weight:600;border:1px solid rgba(255,255,255,0.3);">
                <i class="fa-solid fa-circle-check me-1"></i>Klasifikasi Selesai
            </span>
        </div>
        <h1 class="fw-800 text-white mb-1" style="font-size:clamp(1.6rem,4vw,2.2rem);">
            Hasil Klasifikasi Model
        </h1>
        <p class="mb-0" style="color:rgba(255,255,255,0.75);font-size:0.9rem;">
            Berikut hasil klasifikasi kondisi kuku Anda oleh EfficientNetB2.
        </p>
    </div>
</section>

<section class="py-5" style="background:var(--bg);">
    <div class="container">

        {{-- ════ CARD HASIL UTAMA ════ --}}
        {{-- Dynamic color data injected as JSON to avoid CSS linter false-positives --}}
        <script type="application/json" id="result-cfg">
        {
            "hex":    "{{ $lc['hex'] }}",
            "light":  "{{ $lc['light'] }}",
            "grad":   "{{ addslashes($headerGrad) }}",
            "conf":   {{ $confidence }},
            "winner": "{{ $winnerKey }}"
        }
        </script>

        <div class="result-card">

            <div class="result-header">
                <div class="row g-4 align-items-center">

                    {{-- Kiri: icon + nama + badge --}}
                    <div class="col-lg-5">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="level-icon-big">
                                <i class="fa-solid {{ $lc['icon'] }} level-icon-i"></i>
                            </div>
                            <div>
                                <p style="font-size:0.72rem;color:rgba(255,255,255,0.55);margin-bottom:0.15rem;text-transform:uppercase;letter-spacing:0.08em;">
                                    Kondisi Terdeteksi
                                </p>
                                <h2 class="fw-800 mb-1" style="font-size:clamp(1.1rem,2.5vw,1.5rem);line-height:1.2;">
                                    {{ $disease['name'] }}
                                </h2>
                                <div class="res-dots mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <span class="dot {{ $i <= $disease['danger_level'] ? 'filled' : 'empty' }}"></span>
                                    @endfor
                                </div>
                                <span class="danger-badge-pill">
                                    <i class="fa-solid {{ $lc['icon'] }} me-1"></i>
                                    @if($disease['danger_level'] > 0)
                                        Level {{ $disease['danger_level'] }}/5 —
                                    @endif
                                    {{ $disease['danger_label'] }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Kanan: confidence + all probs --}}
                    <div class="col-lg-7">
                        <div style="background:rgba(0,0,0,0.12);border-radius:16px;padding:1.4rem;border:1px solid rgba(255,255,255,0.1);">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size:0.78rem;color:rgba(255,255,255,0.6);">
                                    <i class="fa-solid fa-gauge-high me-1"></i>Kepercayaan Model
                                </span>
                                <span class="fw-800" style="font-size:1.5rem;color:#fff;" id="conf-label">
                                    {{ number_format($confidence, 1) }}%
                                </span>
                            </div>
                            <div class="conf-track mb-4">
                                <div class="conf-fill" id="conf-fill"></div>
                            </div>

                            <p style="font-size:0.7rem;color:rgba(255,255,255,0.45);margin-bottom:0.6rem;text-transform:uppercase;letter-spacing:0.07em;">
                                Distribusi Probabilitas Semua Kelas
                            </p>
                            @foreach($all_probs as $cls => $prob)
                            <div class="prob-row">
                                <span class="prob-label" title="{{ $cls }}">
                                    {{ str_replace('_', ' ', $cls) }}
                                </span>
                                <div class="prob-track">
                                    <div class="prob-fill {{ $cls === $winnerKey ? 'is-winner' : '' }}"
                                         data-target="{{ $prob }}"></div>
                                </div>
                                <span class="prob-val">{{ number_format($prob, 1) }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════ PENJELASAN ════ --}}
        <div class="content-card">
            <p class="content-card-title">
                <i class="fa-solid fa-book-medical ct-icon"></i>
                Tentang {{ $disease['name'] }}
            </p>
            <p style="font-size:0.95rem;color:#4a5568;line-height:1.75;margin-bottom:1.5rem;">
                {{ $disease['description'] }}
            </p>

            <p class="content-card-title">
                <i class="fa-solid fa-stethoscope ct-icon"></i>
                Gejala yang Perlu Diwaspadai
            </p>
            @foreach($disease['symptoms'] as $symptom)
            <div class="symptom-item">
                <i class="fa-solid fa-circle-dot sym-dot"></i>
                {{ $symptom }}
            </div>
            @endforeach
        </div>

        {{-- ════ REKOMENDASI ════ --}}
        <div class="rec-card">
            <p class="content-card-title" style="border-bottom-color:#f0f0f0;">
                <i class="fa-solid fa-clipboard-check ct-icon"></i>
                Rekomendasi Tindakan
            </p>

            @if($disease['danger_level'] >= 4)
            <div class="d-flex gap-2 mb-3 p-3" style="background:rgba(255,71,87,0.07);border-radius:12px;font-size:0.87rem;">
                <i class="fa-solid fa-triangle-exclamation fs-5 flex-shrink-0" style="color:#FF4757;"></i>
                <span><strong>Perhatian!</strong> Kondisi ini tergolong <strong>{{ $disease['danger_label'] }}</strong>. Segera lakukan tindakan yang disarankan di bawah ini.</span>
            </div>
            @elseif($disease['danger_level'] >= 3)
            <div class="d-flex gap-2 mb-3 p-3" style="background:rgba(255,184,0,0.08);border-radius:12px;font-size:0.87rem;">
                <i class="fa-solid fa-circle-exclamation fs-5 flex-shrink-0" style="color:#FFB800;"></i>
                <span>Kondisi ini memerlukan pemeriksaan lebih lanjut. Ikuti rekomendasi berikut.</span>
            </div>
            @elseif($disease['danger_level'] >= 1)
            <div class="d-flex gap-2 mb-3 p-3" style="background:rgba(78,205,196,0.08);border-radius:12px;font-size:0.87rem;">
                <i class="fa-solid fa-circle-info fs-5 flex-shrink-0" style="color:#4ECDC4;"></i>
                <span>Kondisi ini perlu perhatian. Ikuti langkah-langkah berikut untuk penanganan yang tepat.</span>
            </div>
            @else
            <div class="d-flex gap-2 mb-3 p-3" style="background:rgba(0,217,166,0.08);border-radius:12px;font-size:0.87rem;">
                <i class="fa-solid fa-shield-heart fs-5 flex-shrink-0" style="color:#00D9A6;"></i>
                <span><strong>Kuku Anda sehat!</strong> Pertahankan kebiasaan baik berikut ini.</span>
            </div>
            @endif

            <div class="row g-2">
                @foreach($disease['recommendations'] as $rec)
                <div class="col-md-6">
                    <div class="rec-grid-item">
                        <div class="rec-circle">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <span>{{ $rec }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- ════ TOMBOL AKSI ════ --}}
        <div class="d-flex flex-wrap gap-3 justify-content-center mt-2">
            <a href="{{ route('deteksi') }}"
               style="background:linear-gradient(135deg,#6C63FF,#FF6B9D);color:#fff;border-radius:50px;padding:0.75rem 2rem;font-weight:700;font-size:0.97rem;text-decoration:none;display:inline-flex;align-items:center;gap:0.5rem;box-shadow:0 6px 20px rgba(108,99,255,0.3);">
                <i class="fa-solid fa-rotate-left"></i>Deteksi Lagi
            </a>
            <a href="{{ route('edukasi') }}#{{ $disease['key'] }}"
               style="background:#fff;color:#6C63FF;border:2px solid #6C63FF;border-radius:50px;padding:0.73rem 2rem;font-weight:700;font-size:0.97rem;text-decoration:none;display:inline-flex;align-items:center;gap:0.5rem;">
                <i class="fa-solid fa-book-open"></i>Pelajari Lebih Lanjut
            </a>
        </div>

    </div>
</section>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var cfgEl = document.getElementById('result-cfg');
    if (!cfgEl) return;
    var cfg = JSON.parse(cfgEl.textContent);

    var hex   = cfg.hex;
    var light = cfg.light;
    var grad  = cfg.grad;
    var conf  = parseFloat(cfg.conf);
    var winner = cfg.winner;
    var card  = document.querySelector('.result-card');

    // Header gradient
    card.querySelector('.result-header').style.background = grad;

    // Level icon bg
    var iconBig = card.querySelector('.level-icon-big');
    if (iconBig) iconBig.style.background = 'rgba(255,255,255,0.15)';

    // Animate confidence bar
    var confFill = document.getElementById('conf-fill');
    if (confFill) {
        confFill.style.background = 'linear-gradient(90deg,' + hex + ', rgba(255,255,255,0.85))';
        setTimeout(function () { confFill.style.width = conf + '%'; }, 150);
    }

    // Animate prob mini bars; highlight winner
    document.querySelectorAll('.prob-fill').forEach(function (el) {
        var t = parseFloat(el.dataset.target);
        if (el.classList.contains('is-winner')) {
            el.style.background = '#fff';
        }
        setTimeout(function () { el.style.width = t + '%'; }, 250);
    });

    // Content card icons + sym dots
    document.querySelectorAll('.ct-icon').forEach(function (el) { el.style.color = hex; });
    document.querySelectorAll('.sym-dot').forEach(function (el) { el.style.color = hex; });

    // Rec card border + items
    var recCard = document.querySelector('.rec-card');
    if (recCard) recCard.style.borderLeftColor = hex;

    document.querySelectorAll('.rec-grid-item').forEach(function (el) {
        el.style.background = light.replace('0.13)', '0.06)');
    });

    document.querySelectorAll('.rec-circle').forEach(function (el) {
        el.style.background = light;
    });

    document.querySelectorAll('.rec-circle i').forEach(function (el) {
        el.style.color = hex;
    });
});
</script>
@endsection
