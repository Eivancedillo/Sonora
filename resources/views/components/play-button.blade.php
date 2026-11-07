@props(['tamano' => 'md', 'variante' => 'acento'])

@php
    $tamanos = ['md' => 'size-10', 'lg' => 'size-14'];

    $variantes = [
        'acento' => 'bg-accent text-on-accent hover:bg-accent-hover',
        'neutro' => 'bg-ink text-surface-base hover:bg-ink-muted',
    ];
@endphp

<button type="button" data-accion="alternar" aria-label="Reproducir"
    {{ $attributes->merge(['class' => 'flex shrink-0 items-center justify-center rounded-pill transition ' . $tamanos[$tamano] . ' ' . $variantes[$variante]]) }}>
    <x-icon name="play" data-icono="play" />
    <x-icon name="pause" data-icono="pausa" class="hidden" />
</button>
