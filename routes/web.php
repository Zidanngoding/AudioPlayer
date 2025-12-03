<?php

use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SongController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SongController::class, 'home'])->name('home');

Route::get('/search', [SongController::class, 'search'])->name('songs.search');
Route::get('/songs/{song}/play', [SongController::class, 'playMeta'])->name('songs.play');

Route::get('/upload', [SongController::class, 'uploadForm'])->name('upload.form');
Route::post('/upload', [SongController::class, 'upload'])->name('upload.song');

Route::get('/library', [SongController::class, 'library'])->name('library');
Route::get('/songs/{song}/edit', [SongController::class, 'edit'])->name('songs.edit');
Route::put('/songs/{song}', [SongController::class, 'update'])->name('songs.update');
Route::delete('/songs/{song}', [SongController::class, 'destroy'])->name('songs.destroy');

Route::get('/playlist', [PlaylistController::class, 'index'])->name('playlist.index');
Route::post('/playlist/{song}', [PlaylistController::class, 'store'])->name('playlist.store');
Route::delete('/playlist/{song}', [PlaylistController::class, 'destroy'])->name('playlist.destroy');
