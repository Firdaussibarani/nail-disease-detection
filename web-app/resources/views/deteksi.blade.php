@extends('layouts.app')
@section('title', 'Deteksi Kondisi Kuku')

@section('styles')
<style>
    .det-hero {
        background: linear-gradient(135deg, #6C63FF 0%, #FF6B9D 100%);
        padding: 3.5rem 0 2.5rem;
        position: relative;
        overflow: hidden;
    }

    .det-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse at 80% 50%, rgba(255,255,255,0.1) 0%, transparent 60%);
    }

    /* ── Upload card ── */
    .upload-card {
        background: #fff;
        border-radius: 22px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(108,99,255,0.10);
        border: none;
    }

    /* ── Dropzone ── */
    .dropzone-area {
        border: 2.5px dashed #d4ccff;
        border-radius: 18px;
        padding: 3rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.25s, background 0.25s;
        background: #fbfaff;
        min-height: 260px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .dropzone-area:hover,
    .dropzone-area.drag-over {
        border-color: #6C63FF;
        background: rgba(108,99,255,0.04);
    }

    .dropzone-icon {
        width: 82px; height: 82px;
        background: rgba(108,99,255,0.08);
        border-radius: 22px;
        display: flex; align-items: center; justify-content: center;
        font-size: 2rem;
        color: #6C63FF;
        margin: 0 auto 1rem;
        transition: transform 0.25s;
    }

    .dropzone-area:hover .dropzone-icon { transform: scale(1.07); }

    #preview-container { display: none; position: relative; }

    #preview-img {
        max-height: 280px;
        max-width: 100%;
        border-radius: 14px;
        object-fit: contain;
        box-shadow: 0 6px 24px rgba(108,99,255,0.15);
    }

    .preview-remove {
        position: absolute;
        top: -10px; right: -10px;
        width: 30px; height: 30px;
        border-radius: 50%;
        background: #FF4757;
        color: #fff;
        border: none;
        font-size: 0.8rem;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 3px 10px rgba(255,71,87,0.4);
        transition: transform 0.2s;
    }

    .preview-remove:hover { transform: scale(1.1); }

    /* ── Submit button ── */
    .btn-submit {
        background: linear-gradient(135deg, #6C63FF, #FF6B9D);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 0.8rem 2.5rem;
        font-weight: 700;
        font-size: 1rem;
        width: 100%;
        transition: all 0.25s;
        box-shadow: 0 6px 20px rgba(108,99,255,0.3);
    }

    .btn-submit:hover:not(:disabled) {
        background: linear-gradient(135deg, #FF6B9D, #6C63FF);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 10px 28px rgba(108,99,255,0.4);
    }

    .btn-submit:disabled { opacity: 0.65; cursor: not-allowed; }

    /* ── Sidebar cards ── */
    .sidebar-card {
        background: #fff;
        border-radius: 18px;
        padding: 1.4rem 1.5rem;
        box-shadow: 0 10px 40px rgba(108,99,255,0.08);
        border: none;
        margin-bottom: 1.25rem;
    }

    .sidebar-title {
        font-weight: 700;
        font-size: 0.88rem;
        color: #2D3142;
        margin-bottom: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* ── Level legend ── */
    .level-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.38rem 0;
        font-size: 0.79rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .level-row:last-child { border-bottom: none; }

    .level-dots span {
        display: inline-block;
        width: 8px; height: 8px;
        border-radius: 50%;
        margin-right: 2px;
    }

    /* ── Disease list in sidebar ── */
    .dis-row {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.45rem 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 0.82rem;
        color: #4a5568;
    }

    .dis-row:last-child { border-bottom: none; }

    .dis-icon-sm {
        width: 28px; height: 28px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .tips-list li {
        font-size: 0.82rem;
        color: #4a5568;
        padding: 0.25rem 0;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    /* Dot colors for danger level legend — no inline style needed */
    .dot-lv-0 { background: #00D9A6; }
    .dot-lv-2 { background: #4ECDC4; }
    .dot-lv-3 { background: #FFB800; }
    .dot-lv-4 { background: #FF8C42; }
    .dot-lv-5 { background: #FF4757; }
    .dot-empty { background: #e9ecef; }
</style>
@endsection

@section('content')

{{-- ── Hero ── --}}
<section class="det-hero">
    <div class="container text-center position-relative" style="z-index:1;">
        <div class="mb-3">
            <span style="background:rgba(255,255,255,0.2);color:#fff;border-radius:50px;padding:0.3rem 1rem;font-size:0.8rem;font-weight:600;border:1px solid rgba(255,255,255,0.3);">
                <i class="fa-solid fa-microchip me-1"></i>Model EfficientNetB2
            </span>
        </div>
        <h1 class="fw-800 text-white mb-2" style="font-size:clamp(1.8rem,4vw,2.4rem);">
            Klasifikasi Citra Kuku
        </h1>
        <p class="mb-0" style="color:rgba(255,255,255,0.75);max-width:480px;margin:0 auto;font-size:0.95rem;">
            Upload foto kuku dan dapatkan hasil klasifikasi model dalam hitungan detik.
        </p>
    </div>
</section>

{{-- ── Main Content ── --}}
<section class="py-5" style="background:var(--bg);">
    <div class="container">

        @if($errors->any())
        <div class="alert d-flex align-items-center gap-2 mb-4"
             style="border-radius:14px;background:#fff0f2;border:1.5px solid #FF4757;color:#c0392b;">
            <i class="fa-solid fa-circle-xmark fs-5" style="color:#FF4757;"></i>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="row g-4 justify-content-center">

            {{-- ── Upload Card (Kiri) ── --}}
            <div class="col-lg-7">
                <div class="upload-card">
                    <h5 class="fw-700 mb-1" style="color:#2D3142;">
                        <i class="fa-solid fa-upload me-2" style="color:#6C63FF;"></i>Upload Foto Kuku
                    </h5>
                    <p class="text-muted mb-4" style="font-size:0.84rem;">
                        Pilih atau drag & drop foto kuku Anda (JPG/PNG/JPEG/WEBP, maks 5MB)
                    </p>

                    <form method="POST" action="{{ route('predict') }}" enctype="multipart/form-data" id="detect-form">
                        @csrf

                        <div class="dropzone-area" id="dropzone"
                             onclick="document.getElementById('image-input').click()">
                            <div id="dropzone-placeholder">
                                <div class="dropzone-icon">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                </div>
                                <p class="fw-600 mb-1" style="color:#2D3142;font-size:1rem;">
                                    Klik atau drag foto ke sini
                                </p>
                                <p class="text-muted mb-0" style="font-size:0.82rem;">
                                    Format: JPG, JPEG, PNG, WEBP &bull; Maks 5MB
                                </p>
                            </div>
                            <div id="preview-container">
                                <img id="preview-img" src="" alt="Preview kuku">
                                <button type="button" class="preview-remove" id="remove-preview" title="Hapus foto">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                                <p class="mt-2 mb-0 text-muted" style="font-size:0.78rem;" id="file-name-label"></p>
                            </div>
                        </div>

                        <input type="file" id="image-input" name="image" accept="image/*" class="d-none" required>

                        <div class="alert alert-info mt-3 mb-4" style="border-radius:12px;font-size:0.84rem;border:none;background:rgba(78,205,196,0.1);color:#2D3142;border-left:4px solid #4ECDC4;">
                            <p class="fw-700 mb-1" style="color:#4ECDC4;">
                                <i class="fa-solid fa-lightbulb me-1"></i>Tips Foto yang Baik
                            </p>
                            <ul class="tips-list list-unstyled mb-0">
                                <li><i class="fa-solid fa-check" style="color:#4ECDC4;margin-top:3px;flex-shrink:0;"></i>Kuku terlihat jelas dan tidak buram</li>
                                <li><i class="fa-solid fa-check" style="color:#4ECDC4;margin-top:3px;flex-shrink:0;"></i>Pencahayaan cukup dan merata</li>
                                <li><i class="fa-solid fa-check" style="color:#4ECDC4;margin-top:3px;flex-shrink:0;"></i>Foto jarak dekat sehingga kuku mengisi sebagian besar frame</li>
                                <li><i class="fa-solid fa-check" style="color:#4ECDC4;margin-top:3px;flex-shrink:0;"></i>Bersihkan kuku dari kotoran atau kuteks sebelum foto</li>
                                <li><i class="fa-solid fa-check" style="color:#4ECDC4;margin-top:3px;flex-shrink:0;"></i>Gunakan latar belakang polos/netral untuk hasil terbaik</li>
                            </ul>
                        </div>

                        <div class="mb-3" style="padding:0.75rem 1rem;border-radius:12px;background:rgba(108,99,255,0.07);border-left:3px solid #6C63FF;font-size:0.8rem;color:#4a5568;">
                            <i class="fa-solid fa-circle-info me-1" style="color:#6C63FF;"></i>
                            Proses klasifikasi berlangsung <strong>10–30 detik</strong>.
                            Jika model baru aktif setelah idle, bisa memakan hingga <strong>60–90 detik</strong> — harap tunggu.
                        </div>

                        <button type="submit" class="btn-submit" id="submit-btn">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>Klasifikasi Sekarang
                        </button>
                    </form>
                </div>
            </div>

            {{-- ── Sidebar (Kanan) ── --}}
            <div class="col-lg-4">

                {{-- Kelas yang Dideteksi --}}
                <div class="sidebar-card">
                    <p class="sidebar-title">
                        <i class="fa-solid fa-list-check" style="color:#6C63FF;"></i>
                        6 Kelas yang Dideteksi
                    </p>
                    @foreach(\App\Data\DiseaseData::all() as $key => $disease)
                    @php $lc = \App\Data\DiseaseData::levelConfig($disease['danger_level']); @endphp
                    <div class="dis-row">
                        <div class="dis-icon-sm dis-icon-js"
                             data-bg="{{ $lc['light'] }}"
                             data-color="{{ $lc['hex'] }}">
                            <i class="fa-solid {{ $disease['icon'] }} dis-icon-i"></i>
                        </div>
                        <div class="flex-grow-1" style="min-width:0;">
                            <div class="fw-600" style="font-size:0.8rem;line-height:1.2;color:#2D3142;">
                                {{ $disease['name'] }}
                            </div>
                        </div>
                        <span class="fw-600 dis-lv" style="font-size:0.7rem;white-space:nowrap;">
                            @if($disease['danger_level'] === 0) Sehat
                            @else L{{ $disease['danger_level'] }}
                            @endif
                        </span>
                    </div>
                    @endforeach
                </div>

                {{-- Legenda Level ── --}}
                <div class="sidebar-card">
                    <p class="sidebar-title">
                        <i class="fa-solid fa-shield-halved" style="color:#FF4757;"></i>
                        Legenda Tingkat Bahaya
                    </p>
                    @php
                    $levels = [
                        [0, 'Sehat',           '#00D9A6', [1,0,0,0,0]],
                        [2, 'Perlu Perhatian', '#4ECDC4', [1,1,0,0,0]],
                        [3, 'Cukup Berbahaya', '#FFB800', [1,1,1,0,0]],
                        [4, 'Berbahaya',       '#FF8C42', [1,1,1,1,0]],
                        [5, 'Sangat Berbahaya','#FF4757', [1,1,1,1,1]],
                    ];
                    @endphp
                    @foreach($levels as [$lvl, $lbl, $col, $dots])
                    <div class="level-row">
                        <span class="fw-600" style="font-size:0.78rem;">{{ $lbl }}</span>
                        <span class="level-dots">
                            @foreach($dots as $filled)
                                <span class="{{ $filled ? 'dot-lv-'.$lvl : 'dot-empty' }}"></span>
                            @endforeach
                        </span>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
(function () {
    // Apply dynamic colors to disease icons and level labels in sidebar
    document.querySelectorAll('.dis-icon-js').forEach(function (el) {
        el.style.background = el.dataset.bg;
        var icon = el.querySelector('.dis-icon-i');
        if (icon) icon.style.color = el.dataset.color;
        // Apply same color to the level badge in the same row
        var row = el.closest('.dis-row');
        if (row) {
            var lv = row.querySelector('.dis-lv');
            if (lv) lv.style.color = el.dataset.color;
        }
    });

    // ── Dropzone & preview ──
    var input      = document.getElementById('image-input');
    var dropzone   = document.getElementById('dropzone');
    var placeholder = document.getElementById('dropzone-placeholder');
    var previewCon  = document.getElementById('preview-container');
    var previewImg  = document.getElementById('preview-img');
    var fileLabel   = document.getElementById('file-name-label');
    var removeBtn   = document.getElementById('remove-preview');
    var submitBtn   = document.getElementById('submit-btn');
    var form        = document.getElementById('detect-form');

    function showPreview(file) {
        if (!file || !file.type.startsWith('image/')) return;
        var reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            fileLabel.textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
            placeholder.style.display = 'none';
            previewCon.style.display  = 'block';
        };
        reader.readAsDataURL(file);
    }

    function clearPreview() {
        input.value = '';
        previewImg.src = '';
        previewCon.style.display  = 'none';
        placeholder.style.display = 'block';
    }

    input.addEventListener('change', function () {
        if (input.files[0]) showPreview(input.files[0]);
    });

    removeBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        clearPreview();
    });

    dropzone.addEventListener('dragover', function (e) {
        e.preventDefault();
        dropzone.classList.add('drag-over');
    });

    dropzone.addEventListener('dragleave', function () {
        dropzone.classList.remove('drag-over');
    });

    dropzone.addEventListener('drop', function (e) {
        e.preventDefault();
        dropzone.classList.remove('drag-over');
        var file = e.dataTransfer.files[0];
        if (file) {
            var dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            showPreview(file);
        }
    });

    form.addEventListener('submit', function (e) {
        if (!input.files[0]) {
            e.preventDefault();
            alert('Silakan pilih foto kuku terlebih dahulu.');
            return;
        }
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Mengklasifikasikan... (tunggu hingga 90 detik)';
    });
})();
</script>
@endsection
