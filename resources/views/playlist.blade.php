@extends('layouts.panel')

@section('titulo', $playlist['titulo'] . ' · Sonora')
@section('accion-principal', 'si')

@section('principal')
    <header class="mb-8 flex flex-col items-start gap-6 md:flex-row md:items-end">
        <x-cover tamano="lg" :barras="$playlist['barras']" class="w-48 shrink-0 md:w-56" />

        <div class="min-w-0">
            <p class="text-caption uppercase text-ink-muted">{{ $playlist['artista'] }}</p>
            <h1 class="mt-1 text-title">{{ $playlist['titulo'] }}</h1>
            <p class="mt-2 text-sm font-medium text-ink-muted">
                <span class="font-mono">{{ count($playlist['pistas']) }}</span> canciones ·
                <span class="font-mono">{{ $playlist['duracion'] }}</span>
            </p>

            <div class="mt-6 flex flex-wrap items-center gap-4">
                <x-button data-accion="reproducir-lista"
                    data-inicio="{{ $playlist['pistas'][0]['id'] }}">Reproducir</x-button>
                <x-button variant="secondary" aria-pressed="false" data-accion="guardar" data-slug="{{ $playlist['slug'] }}"
                    class="aria-pressed:bg-surface-high">Guardar en tu biblioteca</x-button>
                <p role="status" data-estado="guardado" class="text-body-sm text-success"></p>
            </div>
        </div>
    </header>

    <section aria-labelledby="titulo-canciones">
        <h2 id="titulo-canciones" class="mb-4 text-heading">Canciones</h2>
        <div class="max-w-2xl rounded-md bg-surface-raised p-2">
            @foreach ($playlist['pistas'] as $i => $pista)
                <x-song-row :indice="$i" :pista="$pista" />
            @endforeach
        </div>
    </section>
@endsection
