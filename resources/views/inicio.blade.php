@extends('layouts.panel')

@section('titulo', 'Inicio · Sonora')

@section('principal')
    <div class="mb-6 flex flex-wrap gap-2" role="group" aria-label="Filtrar por tipo" data-chips>
        <x-chip :activo="true">Todo</x-chip>
        <x-chip>Música</x-chip>
        <x-chip>Podcasts</x-chip>
    </div>

    <h1 class="mb-4 text-title">Tu música</h1>

    <section aria-labelledby="titulo-mezclas">
        <h2 id="titulo-mezclas" class="mb-4 text-heading">Tus mezclas</h2>
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            @foreach ($playlists as $playlist)
                <x-media-card :href="route('playlist', $playlist['slug'])" :titulo="$playlist['titulo']" :artista="$playlist['artista']" :duracion="$playlist['duracion']" :barras="$playlist['barras']" />
            @endforeach
        </div>
    </section>

    <section class="mt-8" aria-labelledby="titulo-cola">
        <h2 id="titulo-cola" class="mb-4 text-heading">En cola</h2>
        <div class="max-w-md rounded-md bg-surface-raised p-2">
            @foreach (array_slice($cola, 0, 5, true) as $i => $pista)
                <x-song-row :indice="$i" :pista="$pista" :actual="$i === 0" />
            @endforeach
        </div>
    </section>
@endsection
