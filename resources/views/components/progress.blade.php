@props([
    'valor' => 0,
    'actual' => '00:00',
    'total' => '00:00',
    'etiqueta' => 'Progreso',
    'tiempos' => true,
    'tipo' => 'progreso',
])

@php
    $texto = $tiempos ? "$actual de $total" : "$valor%";
@endphp

<div data-slider="{{ $tipo }}"
    {{ $attributes->merge(['class' => 'flex w-full items-center gap-2 font-mono text-xs text-ink-muted']) }}>
    @if ($tiempos)
        <span data-progreso="tiempo">{{ $actual }}</span>
    @endif

    <div role="slider" tabindex="0" data-progreso="barra" aria-label="{{ $etiqueta }}" aria-valuemin="0"
        aria-valuemax="100" aria-valuenow="{{ $valor }}" aria-valuetext="{{ $texto }}"
        class="flex h-6 flex-1 cursor-pointer items-center">
        <div class="h-1 w-full rounded-pill bg-surface-high">
            <div data-progreso="relleno" class="h-1 rounded-pill bg-accent" style="width: {{ $valor }}%"></div>
        </div>
    </div>

    @if ($tiempos)
        <span data-progreso="total">{{ $total }}</span>
    @endif
</div>
