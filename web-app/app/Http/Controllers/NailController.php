<?php

namespace App\Http\Controllers;

use App\Data\DiseaseData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NailController extends Controller
{
    private const FLASK_URL = 'https://daus0920-nail-disease-api.hf.space/predict';

    public function home()
    {
        $diseases = DiseaseData::all();
        return view('home', compact('diseases'));
    }

    public function edukasi()
    {
        $diseases = DiseaseData::all();
        return view('edukasi', compact('diseases'));
    }

    public function deteksi()
    {
        return view('deteksi');
    }

    public function predict(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ], [
            'image.required' => 'Silakan pilih foto kuku terlebih dahulu.',
            'image.image'    => 'File harus berupa gambar (jpg, png, jpeg, gif, webp).',
            'image.max'      => 'Ukuran gambar tidak boleh lebih dari 5MB.',
        ]);

        $file = $request->file('image');

        try {
            $response = Http::timeout(120)
                ->attach('image', file_get_contents($file->getRealPath()), $file->getClientOriginalName())
                ->post(self::FLASK_URL);

            if ($response->failed()) {
                $errorBody = $response->json('error', 'Terjadi kesalahan pada server. Coba beberapa saat lagi.');
                return back()->withErrors(['api' => $errorBody]);
            }

            $result   = $response->json();
            $label    = $result['label'];
            $disease  = DiseaseData::find($label);

            if (! $disease) {
                return back()->withErrors(['api' => 'Label hasil deteksi tidak dikenal: ' . $label]);
            }

            return view('hasil', [
                'disease'    => $disease,
                'confidence' => $result['confidence'],
                'all_probs'  => $result['all_probs'],
            ]);

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return back()->withErrors([
                'api' => 'Tidak dapat terhubung ke server. Pastikan Hugging Face Space sudah aktif dan coba lagi.',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'api' => 'Terjadi kesalahan tidak terduga: ' . $e->getMessage(),
            ]);
        }
    }
}
