<?php

namespace App\Data;

class DiseaseData
{
    public static function all(): array
    {
        return [
            'Acral_Lentiginous_Melanoma' => self::acralLentiginousMelanoma(),
            'blue_finger'                => self::blueFinger(),
            'clubbing'                   => self::clubbing(),
            'Healthy_Nail'               => self::healthyNail(),
            'Onychogryphosis'            => self::onychogryphosis(),
            'pitting'                    => self::pitting(),
        ];
    }

    public static function find(string $key): ?array
    {
        return self::all()[$key] ?? null;
    }

    public static function levelConfig(int $level): array
    {
        $map = [
            0 => ['hex' => '#00D9A6', 'light' => 'rgba(0,217,166,0.13)',    'icon' => 'fa-shield-heart',          'sublabel' => 'Kondisi Baik'],
            1 => ['hex' => '#6BB6FF', 'light' => 'rgba(107,182,255,0.13)',  'icon' => 'fa-circle-question',       'sublabel' => 'Perhatikan Perkembangan'],
            2 => ['hex' => '#4ECDC4', 'light' => 'rgba(78,205,196,0.13)',   'icon' => 'fa-circle-info',           'sublabel' => 'Perlu Dipantau'],
            3 => ['hex' => '#FFB800', 'light' => 'rgba(255,184,0,0.13)',    'icon' => 'fa-circle-exclamation',    'sublabel' => 'Perlu Pemeriksaan'],
            4 => ['hex' => '#FF8C42', 'light' => 'rgba(255,140,66,0.13)',   'icon' => 'fa-triangle-exclamation',  'sublabel' => 'Perlu Tindakan Cepat'],
            5 => ['hex' => '#FF4757', 'light' => 'rgba(255,71,87,0.13)',    'icon' => 'fa-skull-crossbones',      'sublabel' => 'Butuh Perhatian Segera'],
        ];
        return $map[$level] ?? $map[0];
    }

    // ------------------------------------------------------------------ //

    private static function acralLentiginousMelanoma(): array
    {
        return [
            'key'          => 'Acral_Lentiginous_Melanoma',
            'icon'         => 'fa-virus',
            'name'         => 'Acral Lentiginous Melanoma (ALM)',
            'danger_level' => 5,
            'danger_label' => 'Sangat Berbahaya',
            'danger_color' => 'danger',
            'description'  => 'Kanker kulit melanoma yang tumbuh di bawah kuku (subungual), telapak tangan, atau telapak kaki. Jenis melanoma paling umum pada populasi Asia. Sering terlambat terdiagnosis karena lokasinya tersembunyi dan sering disangka memar biasa.',
            'symptoms'     => [
                'Noda gelap/hitam di bawah kuku yang tidak hilang',
                'Garis pigmen gelap memanjang dari dasar kuku (melanonychia longitudinal >3mm)',
                'Perubahan warna asimetris dan meluas',
                'Kuku pecah/rusak tanpa sebab',
                'Pigmen menyebar ke kulit sekitar kuku (tanda Hutchinson)',
                'Nyeri atau perdarahan',
            ],
            'recommendations' => [
                'Segera lakukan pemeriksaan ke dokter spesialis kulit (dermatologis) atau onkologis DALAM 1-2 MINGGU KE DEPAN — jangan menunda karena deteksi dini sangat menentukan tingkat kesembuhan',
                'Jangan mencoba memotong, mengorek, atau melepas kuku sendiri',
                'Foto perkembangan noda/pigmen setiap minggu untuk membantu dokter melihat perubahan',
                'Hindari paparan sinar matahari langsung pada area kuku, gunakan tabir surya',
                'Siapkan riwayat kesehatan keluarga (khususnya kanker kulit) untuk dibawa ke dokter',
                'Catat semua gejala penyerta seperti nyeri, perdarahan, atau perubahan bentuk kuku',
            ],
        ];
    }

    private static function blueFinger(): array
    {
        return [
            'key'          => 'blue_finger',
            'icon'         => 'fa-droplet',
            'name'         => 'Blue Finger (Sianosis Perifer)',
            'danger_level' => 4,
            'danger_label' => 'Berbahaya',
            'danger_color' => 'warning',
            'description'  => 'Kondisi kebiruan pada jari dan kuku akibat oksigenasi darah rendah atau gangguan sirkulasi darah ke jari. Bisa menjadi tanda penyakit jantung, PPOK, emboli paru, gagal jantung, atau Raynaud\'s phenomenon.',
            'symptoms'     => [
                'Warna kebiruan/keunguan pada ujung jari dan bantalan kuku',
                'Jari terasa dingin',
                'Mati rasa atau kesemutan',
                'Memburuk pada cuaca dingin atau saat stres',
                'Capillary refill memanjang (>2 detik)',
                'Pada kasus akut dapat disertai sesak napas',
            ],
            'recommendations' => [
                'Jika muncul tiba-tiba disertai sesak napas, nyeri dada, atau pingsan — SEGERA ke IGD rumah sakit terdekat (bisa jadi kegawatdaruratan medis)',
                'Untuk kondisi kronis, lakukan pemeriksaan ke dokter spesialis jantung atau paru dalam 1 minggu ke depan',
                'Berhenti merokok segera dan hindari asap rokok',
                'Hindari paparan dingin — pakai sarung tangan hangat saat udara dingin atau saat membuka kulkas',
                'Catat kapan kebiruan muncul dan pemicunya untuk diinformasikan ke dokter',
                'Kurangi konsumsi kafein karena dapat mempersempit pembuluh darah',
                'Lakukan pemanasan tangan dengan air hangat (bukan panas) saat kebiruan muncul',
            ],
        ];
    }

    private static function onychogryphosis(): array
    {
        return [
            'key'          => 'Onychogryphosis',
            'icon'         => 'fa-hand-back-fist',
            'name'         => 'Onychogryphosis (Kuku Tanduk)',
            'danger_level' => 2,
            'danger_label' => 'Cukup Berbahaya',
            'danger_color' => 'info',
            'description'  => 'Penebalan dan pemanjangan kuku yang abnormal sehingga menyerupai tanduk atau cakar ("ram\'s horn nail"). Umumnya terjadi pada kuku jari kaki lansia. Penyebabnya bisa karena trauma berulang, alas kaki tidak sesuai, gangguan sirkulasi, atau kurangnya perawatan kuku.',
            'symptoms'     => [
                'Kuku sangat tebal dan keras',
                'Melengkung ke atas atau samping seperti tanduk',
                'Warna kuning-kecoklatan',
                'Sulit dipotong dengan gunting kuku biasa',
                'Nyeri saat berjalan atau memakai sepatu',
                'Bau tidak sedap bila ada infeksi jamur',
            ],
            'recommendations' => [
                'Lakukan pemeriksaan ke podiatris (dokter spesialis kaki) atau dermatologis dalam 2-4 minggu ke depan',
                'Rendam kuku dalam air hangat 15-20 menit setiap hari untuk melunakkan',
                'Ganti sepatu dengan yang lebih lebar dan nyaman (hindari sepatu sempit atau hak tinggi)',
                'Jangan mencoba memotong kuku sendiri karena berisiko luka dan infeksi',
                'Jaga kebersihan kaki dan keringkan dengan baik terutama di sela-sela jari',
                'Bagi penderita diabetes, WAJIB rutin ke podiatris karena berisiko komplikasi luka',
                'Gunakan pelembap kaki untuk mencegah kulit sekitar kuku pecah-pecah',
            ],
        ];
    }

    private static function clubbing(): array
    {
        return [
            'key'          => 'clubbing',
            'icon'         => 'fa-hand-point-up',
            'name'         => 'Clubbing (Jari Tabuh)',
            'danger_level' => 3,
            'danger_label' => 'Cukup Berbahaya',
            'danger_color' => 'warning',
            'description'  => 'Perubahan bentuk ujung jari yang membulat dan melebar, dengan kuku melengkung ke bawah menyerupai sendok terbalik. Clubbing HAMPIR SELALU merupakan TANDA penyakit sistemik serius seperti kanker paru, fibrosis paru, penyakit jantung bawaan, atau penyakit gastrointestinal — bukan penyakit tersendiri.',
            'symptoms'     => [
                'Ujung jari membulat dan membesar (drumstick appearance)',
                'Kuku melengkung ke bawah',
                'Dasar kuku terasa lunak/spongy saat ditekan',
                'Sudut normal antara kuku dan kulit hilang (>180 derajat)',
                'Tanda Schamroth positif (celah berbentuk berlian hilang saat dua jari saling dirapatkan)',
            ],
            'recommendations' => [
                'Segera lakukan pemeriksaan ke dokter penyakit dalam DALAM 1-2 MINGGU untuk mencari penyakit yang mendasari',
                'Berhenti merokok segera — clubbing sering dikaitkan dengan kanker paru',
                'Catat gejala penyerta (batuk lama, sesak, penurunan berat badan, demam) untuk disampaikan ke dokter',
                'Siapkan riwayat penyakit paru, jantung, dan pencernaan (termasuk riwayat keluarga)',
                'Jangan panik — banyak juga kasus clubbing yang bersifat herediter (turunan) dan tidak berbahaya',
                'Perhatikan pola pernapasan dan catat bila ada perubahan',
                'Hindari paparan polusi udara dan zat kimia berbahaya',
            ],
        ];
    }

    private static function healthyNail(): array
    {
        return [
            'key'          => 'Healthy_Nail',
            'icon'         => 'fa-hand-sparkles',
            'name'         => 'Kuku Sehat',
            'danger_level' => 0,
            'danger_label' => 'Tidak Berbahaya',
            'danger_color' => 'success',
            'description'  => 'Kuku Anda terdeteksi dalam kondisi sehat dan normal. Kuku sehat memiliki warna merah muda merata, permukaan halus dan mengkilap, tidak rapuh, serta tidak ada perubahan bentuk yang abnormal. Kondisi kuku sering mencerminkan kesehatan tubuh secara umum.',
            'symptoms'     => [
                'Warna merah muda merata',
                'Permukaan halus dan mengkilap',
                'Tidak ada noda, garis, atau perubahan warna',
                'Bentuk dan ketebalan normal',
                'Kutikula utuh',
                'Tidak rapuh atau mudah patah',
            ],
            'recommendations' => [
                'Pertahankan kebiasaan perawatan kuku yang baik',
                'Lakukan pemeriksaan mandiri rutin setiap bulan untuk mendeteksi perubahan dini',
                'Potong kuku secara rutin dan rapi (jangan terlalu pendek), gunakan gunting kuku bersih',
                'Jaga kelembapan kuku dengan pelembap tangan setiap habis cuci tangan',
                'Konsumsi makanan kaya biotin (telur, kacang-kacangan), zinc, dan protein',
                'Hindari kebiasaan menggigit kuku atau mencabut kutikula',
                'Gunakan sarung tangan saat bekerja dengan bahan kimia atau detergen',
                'Batasi penggunaan kuteks dan pilih aseton yang tidak keras',
                'Konsultasi ke dokter bila muncul perubahan warna, bentuk, atau tekstur yang tidak biasa',
            ],
        ];
    }

    private static function pitting(): array
    {
        return [
            'key'          => 'pitting',
            'icon'         => 'fa-braille',
            'name'         => 'Nail Pitting (Kuku Berlubang)',
            'danger_level' => 2,
            'danger_label' => 'Perlu Perhatian',
            'danger_color' => 'primary',
            'description'  => 'Munculnya lekukan-lekukan kecil seperti tusukan jarum pada permukaan kuku. Kondisi ini paling sering dikaitkan dengan psoriasis kuku (nail psoriasis), tetapi juga dapat terjadi pada alopecia areata, dermatitis atopik, atau penyakit autoimun lainnya.',
            'symptoms'     => [
                'Lekukan kecil atau lubang-lubang di permukaan kuku (biasanya <1mm)',
                'Kuku berwarna kekuningan atau kecoklatan',
                'Kuku terpisah dari dasar kuku (onycholysis)',
                'Penebalan kuku disertai serpihan',
                'Kadang disertai ruam kulit psoriasis di tempat lain',
            ],
            'recommendations' => [
                'Lakukan pemeriksaan ke dokter spesialis kulit (dermatologis) dalam 2-4 minggu ke depan',
                'Perhatikan apakah ada ruam merah bersisik di kulit (siku, lutut, kulit kepala) — bisa jadi tanda psoriasis',
                'Catat riwayat penyakit kulit di keluarga untuk disampaikan ke dokter',
                'Jaga kuku tetap pendek dan bersih untuk mencegah infeksi sekunder',
                'Gunakan pelembap kuku dan kutikula secara rutin',
                'Hindari trauma pada kuku (mengetuk, menggigit, menggunakan kuku sebagai alat)',
                'Kelola stres karena stres dapat memicu kekambuhan psoriasis',
                'Hindari penggunaan kuku palsu dan kuteks yang keras',
                'Jangan mengorek atau memaksa membersihkan bagian bawah kuku',
            ],
        ];
    }
}
