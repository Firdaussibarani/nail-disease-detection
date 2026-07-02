<?php

use App\Http\Controllers\NailController;
use Illuminate\Support\Facades\Route;

Route::get('/', [NailController::class, 'home'])->name('home');
Route::get('/edukasi', [NailController::class, 'edukasi'])->name('edukasi');
Route::get('/deteksi', [NailController::class, 'deteksi'])->name('deteksi');
Route::post('/deteksi', [NailController::class, 'predict'])->name('predict');
