@extends('layouts.app')

@section('titulo', 'Reproduciendo · Sonora')

@section('contenido')
    <div class="grid min-h-dvh grid-cols-1 md:h-dvh md:grid-cols-[1fr_320px]">
        <main class="flex flex-col p-4 md:min-h-0 md:overflow-y-auto md:p-8">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <x-button variant="ghost" :href="route('inicio')">Volver al inicio</x-button>
                <x-theme-toggle />
            </div>

            <section aria-label="Reproduciendo"
                class="mx-auto my-auto flex w-full max-w-[420px] flex-col items-center gap-4 py-8">
                <x-cover tamano="lg" :barras="$pista['barras']" class="w-full max-w-80" data-reproductor="portada" />

                <div class="text-center">
                    <h1 data-reproductor="titulo" class="text-title">{{ $pista['titulo'] }}</h1>
                    <p class="mt-1 text-body-sm text-ink-muted">
                        <span data-reproductor="artista">{{ $pista['artista'] }}</span>
                        ·
                        <span data-reproductor="album">{{ $pista['album'] }}</span>
                    </p>
                </div>

                <x-progress :valor="0" actual="00:00" :total="$pista['duracion']" />

                <div class="flex items-center gap-4">
                    <x-icon-button icono="shuffle" etiqueta="Aleatorio" aria-pressed="false" data-accion="aleatorio" />
                    <x-icon-button icono="prev" etiqueta="Anterior" data-accion="anterior" />
                    <x-play-button tamano="lg" />
                    <x-icon-button icono="next" etiqueta="Siguiente" data-accion="siguiente" />
                    <x-icon-button icono="heart" etiqueta="Me gusta" aria-pressed="false" data-accion="me-gusta" />
                </div>
            </section>
        </main>

        <aside aria-labelledby="titulo-cola" class="bg-surface-raised px-4 py-6 md:min-h-0 md:overflow-y-auto">
            <h2 id="titulo-cola" class="mb-4 text-heading">En cola</h2>
            @foreach ($cola as $i => $item)
                <x-song-row :indice="$i" :pista="$item" :actual="$i === 0" />
            @endforeach
        </aside>
    </div>
@endsection
