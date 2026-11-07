@props(['titulo', 'artista', 'duracion', 'barras' => [50, 80, 60, 90, 40], 'href' => null])

@php $etiqueta = $href ? 'a' : 'div'; @endphp

<{{ $etiqueta }} @if ($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => 'block rounded-md bg-surface-raised p-4 transition hover:bg-surface-high hover:shadow-raise']) }}>
    <x-cover :barras="$barras" class="mb-4" />
    <p class="truncate text-heading">{{ $titulo }}</p>
    <p class="mt-1 truncate text-sm font-medium text-ink-muted">{{ $artista }}</p>
    <p class="mt-2 whitespace-nowrap font-mono text-xs text-ink-muted">{{ $duracion }}</p>
    </{{ $etiqueta }}>
