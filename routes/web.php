<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SongController;

Route::get('/upload', [SongController::class, 'uploadForm'])->name('upload.form');
Route::post('/upload', [SongController::class, 'upload'])->name('upload.song');

Route::get('/', [SongController::class, 'home'])->name('home');

Route::get('/upload', [SongController::class, 'uploadForm'])->name('upload.form');
Route::post('/upload', [SongController::class, 'upload'])->name('upload.song');
Route::get('/library', [SongController::class, 'library']);
Route::get('/songs/{id}/edit', [SongController::class, 'edit'])->name('songs.edit');
Route::put('/songs/{id}', [SongController::class, 'update'])->name('songs.update');
Route::delete('/songs/{id}', [SongController::class, 'destroy'])->name('songs.destroy');