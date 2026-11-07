@props(['etiqueta' => 'Buscar', 'ayuda' => '¿Qué quieres escuchar?'])

<input type="search" autocomplete="off" aria-label="{{ $etiqueta }}" placeholder="{{ $ayuda }}"
    {{ $attributes->merge(['class' => 'w-full rounded-pill border-2 border-line-strong bg-surface-high px-4 py-3 text-sm text-ink placeholder:text-ink-muted']) }}>
