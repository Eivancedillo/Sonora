@props(['pista', 'acento' => true])

<section aria-label="Reproductor"
    class="grid grid-cols-[1fr_auto] items-center gap-x-2 gap-y-1 border-t border-line bg-surface-raised px-4 py-2 md:col-span-2 md:grid-cols-[1fr_2fr_1fr] md:gap-4 md:py-0">
    <a href="{{ route('reproductor') }}"
        class="flex min-w-0 items-center gap-3 rounded-md p-1 transition hover:bg-surface-high">
        <span class="sr-only">Abrir el reproductor</span>
        <x-cover tamano="sm" :barras="$pista['barras']" class="shrink-0" data-reproductor="portada" />
        <div class="min-w-0">
            <p data-reproductor="titulo" class="truncate text-sm font-bold">{{ $pista['titulo'] }}</p>
            <p data-reproductor="artista" class="truncate text-xs font-medium text-ink-muted">{{ $pista['artista'] }}
            </p>
        </div>
    </a>

    <div class="contents md:flex md:flex-col md:items-center md:gap-1">
        <div class="flex items-center gap-2">
            <x-icon-button icono="prev" etiqueta="Anterior" data-accion="anterior" />
            <x-play-button :variante="$acento ? 'acento' : 'neutro'" />
            <x-icon-button icono="next" etiqueta="Siguiente" data-accion="siguiente" />
        </div>
        <x-progress :valor="0" actual="00:00" :total="$pista['duracion']" class="col-span-2 md:col-span-1 md:max-w-md" />
    </div>

    <div class="hidden items-center justify-end gap-2 text-ink-muted md:flex">
        <x-icon name="volume" />
        <div class="w-24">
            <x-progress :valor="70" :tiempos="false" etiqueta="Volumen" tipo="volumen" />
        </div>
    </div>
</section>
