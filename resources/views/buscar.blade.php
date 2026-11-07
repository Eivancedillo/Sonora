@extends('layouts.panel')

@section('titulo', 'Buscar · Sonora')

@section('principal')
    <h1 class="mb-4 text-title">Buscar</h1>

    <div class="mb-6 max-w-xl">
        <x-search-field data-campo-busqueda />
    </div>

    <p role="status" data-sin-resultados class="mb-8 text-body-sm text-ink-muted"></p>

    <section data-seccion aria-labelledby="titulo-canciones" class="mb-8">
        <h2 id="titulo-canciones" class="mb-4 text-heading">Canciones</h2>
        <div class="max-w-2xl rounded-md bg-surface-raised p-2">
            @foreach ($pistas as $i => $pista)
                <x-song-row :indice="$i" :pista="$pista" :data-busqueda="$pista['titulo'] . ' ' . $pista['artista'] . ' ' . $pista['album']" />
            @endforeach
        </div>
    </section>

    <section data-seccion aria-labelledby="titulo-playlists">
        <h2 id="titulo-playlists" class="mb-4 text-heading">Playlists</h2>
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach ($playlists as $playlist)
                <x-media-card :href="route('playlist', $playlist['slug'])" :titulo="$playlist['titulo']" :artista="$playlist['artista']" :duracion="$playlist['duracion']" :barras="$playlist['barras']"
                    :data-busqueda="$playlist['titulo'] . ' ' . $playlist['artista']" />
            @endforeach
        </div>
    </section>
@endsection
