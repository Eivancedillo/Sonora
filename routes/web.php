<?php

use App\Support\Catalogo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio', [
        'playlists' => Catalogo::playlists(),
        'cola' => Catalogo::pistas(),
    ]);
})->name('inicio');

Route::get('/buscar', function () {
    return view('buscar', [
        'pistas' => Catalogo::pistas(),
        'playlists' => Catalogo::playlists(),
    ]);
})->name('buscar');

Route::get('/playlist/{slug}', function (string $slug) {
    $playlist = Catalogo::playlist($slug);

    abort_if($playlist === null, 404);

    return view('playlist', ['playlist' => $playlist]);
})->name('playlist');

Route::get('/reproductor', function () {
    $cola = Catalogo::pistas();

    return view('reproductor', ['pista' => $cola[0], 'cola' => $cola]);
})->name('reproductor');
