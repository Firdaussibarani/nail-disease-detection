@extends('layouts.app')
@section('title', 'Beranda')

@section('styles')
<style>
    /* ── Hero ── */
    .hero-home {
        background: linear-gradient(135deg, #6C63FF 0%, #FF6B9D 100%);
        min-height: 92vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-shape {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        pointer-events: none;
    }

    .shape-1 { width:520px;height:520px; top:-180px;right:-160px; animation:float-s 9s ease-in-out infinite; }
    .shape-2 { width:320px;height:320px; bottom:-100px;left:-80px; background:rgba(255,255,255,0.06); animation:float-s 7s ease-in-out infinite reverse; }
    .shape-3 { width:140px;height:140px; top:45%;left:28%; background:rgba(255,255,255,0.05); animation:float-s 11s ease-in-out infinite 2s; }
    .shape-4 { width:60px;height:60px;   top:20%;right:30%; background:rgba(255,255,255,0.1); animation:float-s 5s ease-in-out infinite 1s; }

    @keyframes float-s {
        0%,100% { transform: translateY(0) rotate(0deg); }
        50%      { transform: translateY(-28px) rotate(8deg); }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 50px;
        padding: 0.3rem 1rem;
        font-size: 0.8rem;
        color: rgba(255,255,255,0.9);
        margin-bottom: 1.5rem;
        backdrop-filter: blur(4px);
    }

    .hero-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 800;
        line-height: 1.12;
        color: #fff;
    }

    .hero-highlight {
        background: rgba(255,255,255,0.25);
        border-radius: 8px;
        padding: 0 8px;
    }

    /* ── Preview card (right side of hero) ── */
    .preview-card {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .preview-topbar {
        background: rgba(0,0,0,0.15);
        padding: 0.65rem 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .preview-dot { width:10px;height:10px;border-radius:50%; }

    .preview-body { padding: 1.25rem 1.5rem 1.5rem; }

    .prev-icon-circle {
        width: 52px; height: 52px;
        border-radius: 50%;
        background: rgba(0,217,166,0.2);
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .mini-bar-wrap { flex: 1; height: 5px; border-radius: 3px; background: rgba(255,255,255,0.15); overflow: hidden; }
    .mini-bar-fill { height: 100%; border-radius: 3px; }

    /* ── How it works ── */
    .step-card {
        background: #fff;
        border-radius: 20px;
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: var(--shadow);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        position: relative;
    }

    .step-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-hover); }

    .step-icon-wrap {
        width: 72px; height: 72px;
        border-radius: 20px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.75rem;
        margin: 0 auto 1.2rem;
    }

    .step-num {
        position: absolute;
        top: -12px; right: -12px;
        width: 30px; height: 30px;
        border-radius: 50%;
        background: var(--gradient);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px rgba(108,99,255,0.35);
    }

    /* ── Disease cards ── */
    .disease-home-card {
        background: #fff;
        border-radius: 20px;
        padding: 1.6rem;
        box-shadow: var(--shadow);
        transition: transform 0.3s, box-shadow 0.3s;
        height: 100%;
        display: flex;
        flex-direction: column;
        border-top: 6px solid transparent;
    }

    .disease-home-card:hover {
        transform: translateY(-8px) scale(1.01);
        box-shadow: var(--shadow-hover);
    }

    .dis-icon-wrap {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 0.85rem;
        flex-shrink: 0;
    }

    .btn-card-link {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-top: auto;
        padding-top: 0.75rem;
        transition: gap 0.2s;
    }

    .btn-card-link:hover { gap: 8px; color: var(--secondary); }

    /* ── Why section ── */
    .why-card {
        background: #fff;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow);
        transition: transform 0.3s;
        height: 100%;
        text-align: center;
    }

    .why-card:hover { transform: translateY(-6px); box-shadow: var(--shadow-hover); }

    .why-icon-wrap {
        width: 64px; height: 64px;
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem;
        margin: 0 auto 1rem;
    }

    /* ── CTA bottom ── */
    .cta-section {
        background: linear-gradient(135deg, #6C63FF 0%, #FF6B9D 100%);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 80% 50%, rgba(255,255,255,0.12) 0%, transparent 60%);
    }
</style>
@endsection

@section('content')

{{-- ════════════ HERO ════════════ --}}
<section class="hero-home">
    <div class="hero-shape shape-1"></div>
    <div class="hero-shape shape-2"></div>
    <div class="hero-shape shape-3"></div>
    <div class="hero-shape shape-4"></div>

    <div class="container position-relative py-5" style="z-index:1;">
        <div class="row align-items-center gy-5">
            {{-- Kiri: teks --}}
            <div class="col-lg-6">
                <div class="hero-badge">
                    <i class="fa-solid fa-microchip"></i>
                    Transfer Learning EfficientNetB2
                </div>

                <h1 class="hero-title mb-3">
                    Klasifikasi Citra Kuku<br>
                    dengan <span class="hero-highlight">EfficientNetB2</span>
                </h1>

                <p style="font-size:1.05rem; color:rgba(255,255,255,0.8); max-width:480px; margin-bottom:2rem; line-height:1.7;">
                    Upload foto kuku dan dapatkan hasil klasifikasi model untuk 6 kondisi kuku
                    secara instan, lengkap dengan penjelasan dan rekomendasi tindakan.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('deteksi') }}" class="btn-gradient">
                        <i class="fa-solid fa-microscope"></i>Mulai Deteksi
                    </a>
                    <a href="{{ route('edukasi') }}"
                       style="background:rgba(255,255,255,0.15);backdrop-filter:blur(4px);border:2px solid rgba(255,255,255,0.4);color:#fff;border-radius:50px;padding:0.7rem 1.8rem;font-weight:700;font-size:0.95rem;text-decoration:none;transition:all 0.25s;display:inline-flex;align-items:center;gap:0.4rem;"
                       onmouseover="this.style.background='rgba(255,255,255,0.25)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.15)'">
                        <i class="fa-solid fa-book-medical"></i>Pelajari Kondisi Kuku
                    </a>
                </div>

                <div class="d-flex gap-4 mt-4">
                    <div>
                        <div style="font-size:1.6rem;font-weight:800;color:#fff;">6</div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.6);">Kondisi Kuku</div>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,0.2);"></div>
                    <div>
                        <div style="font-size:1.6rem;font-weight:800;color:#fff;">B2</div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.6);">EfficientNet</div>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,0.2);"></div>
                    <div>
                        <div style="font-size:1.6rem;font-weight:800;color:#fff;">260px</div>
                        <div style="font-size:0.75rem;color:rgba(255,255,255,0.6);">Input Citra</div>
                    </div>
                </div>
            </div>

            {{-- Kanan: preview card --}}
            <div class="col-lg-5 offset-lg-1">
                <div class="preview-card">
                    <div class="preview-topbar">
                        <div class="preview-dot" style="background:#FF4757;"></div>
                        <div class="preview-dot" style="background:#FFB800;"></div>
                        <div class="preview-dot" style="background:#00D9A6;"></div>
                        <span class="ms-2" style="font-size:0.75rem;color:rgba(255,255,255,0.55);">
                            Contoh Hasil Klasifikasi Model
                        </span>
                    </div>
                    <div class="preview-body">
                        {{-- Result item --}}
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="prev-icon-circle">
                                <i class="fa-solid fa-hand-sparkles" style="color:#00D9A6;font-size:1.3rem;"></i>
                            </div>
                            <div>
                                <div class="fw-700 text-white" style="font-size:1rem;">Kuku Sehat</div>
                                <span style="background:rgba(0,217,166,0.2);color:#00D9A6;border-radius:50px;font-size:0.72rem;font-weight:600;padding:0.15em 0.7em;">
                                    <i class="fa-solid fa-shield-heart me-1"></i>Kondisi Baik
                                </span>
                            </div>
                        </div>

                        {{-- Confidence --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size:0.72rem;color:rgba(255,255,255,0.55);">Kepercayaan Model</span>
                                <span style="font-size:1rem;font-weight:800;color:#00D9A6;">94.2%</span>
                            </div>
                            <div style="height:8px;border-radius:4px;background:rgba(255,255,255,0.1);">
                                <div style="height:100%;width:94.2%;border-radius:4px;background:linear-gradient(90deg,#00D9A6,#6C63FF);"></div>
                            </div>
                        </div>

                        {{-- Mini prob list --}}
                        <p style="font-size:0.7rem;color:rgba(255,255,255,0.4);margin-bottom:0.5rem;text-transform:uppercase;letter-spacing:0.07em;">
                            Distribusi Probabilitas
                        </p>
                        @php
                        $mockProbs = [
                            ['label'=>'Kuku Sehat','w'=>'94%','color'=>'#00D9A6'],
                            ['label'=>'Nail Pitting','w'=>'3%','color'=>'rgba(255,255,255,0.4)'],
                            ['label'=>'Blue Finger','w'=>'2%','color'=>'rgba(255,255,255,0.4)'],
                            ['label'=>'Clubbing','w'=>'1%','color'=>'rgba(255,255,255,0.4)'],
                        ];
                        @endphp
                        @foreach($mockProbs as $mp)
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span style="font-size:0.7rem;width:95px;color:rgba(255,255,255,0.6);flex-shrink:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $mp['label'] }}</span>
                            <div class="mini-bar-wrap">
                                <div class="mini-bar-fill" style="width:{{ $mp['w'] }};background:{{ $mp['color'] }};"></div>
                            </div>
                            <span style="font-size:0.7rem;color:rgba(255,255,255,0.55);width:28px;text-align:right;flex-shrink:0;">{{ $mp['w'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════ CARA KERJA ════════════ --}}
<section class="py-5 py-lg-6 bg-dots" style="background-color:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="accent-bar d-block mx-auto"></span>
            <h2 class="section-title">Cara Kerja NailCheck</h2>
            <p class="section-subtitle">3 langkah mudah untuk mendapatkan hasil klasifikasi kondisi kuku</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="step-card position-relative">
                    <span class="step-num">1</span>
                    <div class="step-icon-wrap" style="background:rgba(108,99,255,0.1);">
                        <i class="fa-solid fa-camera-retro" style="color:var(--primary);"></i>
                    </div>
                    <h5 class="fw-700 mb-2">Upload Foto Kuku</h5>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Ambil foto kuku yang jelas dengan pencahayaan merata. Pastikan kuku terlihat penuh dalam frame.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card position-relative">
                    <span class="step-num">2</span>
                    <div class="step-icon-wrap" style="background:rgba(255,107,157,0.1);">
                        <i class="fa-solid fa-network-wired" style="color:var(--secondary);"></i>
                    </div>
                    <h5 class="fw-700 mb-2">Klasifikasi Model</h5>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Model EfficientNetB2 hasil transfer learning mengklasifikasikan citra kuku ke salah satu dari 6 kelas kondisi kuku.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="step-card position-relative">
                    <span class="step-num">3</span>
                    <div class="step-icon-wrap" style="background:rgba(0,217,166,0.1);">
                        <i class="fa-solid fa-clipboard-list" style="color:var(--mint);"></i>
                    </div>
                    <h5 class="fw-700 mb-2">Hasil & Rekomendasi</h5>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Dapatkan laporan lengkap: probabilitas prediksi, penjelasan kondisi, dan rekomendasi tindakan konkret.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════ 6 KONDISI KUKU ════════════ --}}
<section class="py-5 py-lg-6" style="background:var(--bg);">
    <div class="container">
        <div class="text-center mb-5">
            <span class="accent-bar d-block mx-auto"></span>
            <h2 class="section-title">6 Kondisi Kuku yang Dapat Dideteksi</h2>
            <p class="section-subtitle">Dari kuku sehat hingga kondisi yang memerlukan perhatian segera</p>
        </div>
        <div class="row g-4">
            @foreach($diseases as $key => $disease)
            @php $lc = \App\Data\DiseaseData::levelConfig($disease['danger_level']); @endphp
            <div class="col-sm-6 col-lg-4">
                <div class="disease-home-card hc-card"
                     data-hc-hex="{{ $lc['hex'] }}"
                     data-hc-light="{{ $lc['light'] }}">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <div class="dis-icon-wrap hc-icon-bg">
                            <i class="fa-solid {{ $disease['icon'] }} hc-icon-color"></i>
                        </div>
                        <div>
                            <div class="fw-700" style="font-size:0.95rem;color:var(--text);line-height:1.2;">{{ $disease['name'] }}</div>
                            <span class="hc-text-color" style="font-size:0.72rem;font-weight:600;">
                                <i class="fa-solid {{ $lc['icon'] }} me-1"></i>{{ $lc['sublabel'] }}
                            </span>
                        </div>
                    </div>
                    <p class="text-muted mb-0" style="font-size:0.83rem;line-height:1.55;flex:1;">
                        {{ Str::limit($disease['description'], 105) }}
                    </p>
                    <a href="{{ route('edukasi') }}#{{ $key }}" class="btn-card-link">
                        Selengkapnya <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('edukasi') }}" class="btn-gradient">
                <i class="fa-solid fa-book-open"></i>Pelajari Semua Kondisi
            </a>
        </div>
    </div>
</section>

{{-- ════════════ KENAPA NAILCHECK ════════════ --}}
<section class="py-5 py-lg-6 bg-dots" style="background-color:#fff;">
    <div class="container">
        <div class="text-center mb-5">
            <span class="accent-bar d-block mx-auto"></span>
            <h2 class="section-title">Kenapa NailCheck?</h2>
            <p class="section-subtitle">Dirancang untuk deteksi awal dan edukasi kondisi kuku secara mudah</p>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="why-card">
                    <div class="why-icon-wrap" style="background:rgba(108,99,255,0.1);">
                        <i class="fa-solid fa-bullseye" style="color:var(--primary);"></i>
                    </div>
                    <h5 class="fw-700 mb-2">Akurat</h5>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Menggunakan arsitektur EfficientNetB2 dengan transfer learning yang dilatih khusus untuk klasifikasi kondisi kuku.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-card">
                    <div class="why-icon-wrap" style="background:rgba(0,217,166,0.1);">
                        <i class="fa-solid fa-bolt" style="color:var(--mint);"></i>
                    </div>
                    <h5 class="fw-700 mb-2">Cepat</h5>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Hasil klasifikasi tersedia dalam hitungan detik setelah foto diunggah — tanpa antrian, tanpa proses manual.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="why-card">
                    <div class="why-icon-wrap" style="background:rgba(255,107,157,0.1);">
                        <i class="fa-solid fa-graduation-cap" style="color:var(--secondary);"></i>
                    </div>
                    <h5 class="fw-700 mb-2">Edukatif</h5>
                    <p class="text-muted mb-0" style="font-size:0.9rem;">
                        Setiap hasil dilengkapi penjelasan lengkap tiap kondisi, deskripsi gejala, dan rekomendasi tindakan konkret yang dapat langsung dilakukan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ════════════ CTA BAWAH ════════════ --}}
<section class="cta-section py-5">
    <div class="container text-center position-relative" style="z-index:1;">
        <h2 class="fw-800 text-white mb-2" style="font-size:clamp(1.6rem,4vw,2rem);">
            Siap Klasifikasi Kondisi Kuku Anda?
        </h2>
        <p class="mb-4" style="color:rgba(255,255,255,0.75);font-size:0.95rem;">
            Gratis, cepat, dan langsung — tidak perlu registrasi.
        </p>
        <a href="{{ route('deteksi') }}"
           style="background:#fff;color:var(--primary);border-radius:50px;padding:0.75rem 2.2rem;font-weight:700;font-size:0.97rem;text-decoration:none;display:inline-flex;align-items:center;gap:0.5rem;box-shadow:0 8px 24px rgba(0,0,0,0.15);transition:all 0.25s;"
           onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 14px 32px rgba(0,0,0,0.2)'"
           onmouseout="this.style.transform='';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.15)'">
            <i class="fa-solid fa-microscope"></i>Mulai Deteksi Sekarang
        </a>
    </div>
</section>

@endsection

@section('scripts')
<script>
document.querySelectorAll('.hc-card').forEach(function(card) {
    var hex   = card.dataset.hcHex;
    var light = card.dataset.hcLight;
    card.style.borderTopColor = hex;
    var bg = card.querySelector('.hc-icon-bg');
    if (bg) bg.style.background = light;
    card.querySelectorAll('.hc-icon-color').forEach(function(el) { el.style.color = hex; });
    card.querySelectorAll('.hc-text-color').forEach(function(el) { el.style.color = hex; });
});
</script>
@endsection
