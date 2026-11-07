@props(['barras' => [50, 80, 60, 90, 40], 'tamano' => 'md'])

@php
    $tamanos = [
        'sm' => 'size-12 gap-0.5 rounded-sm p-2',
        'md' => 'aspect-square gap-1 rounded-md p-4',
        'lg' => 'aspect-square gap-2 rounded-lg p-8',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-end bg-surface-high ' . $tamanos[$tamano]]) }} aria-hidden="true">
    @foreach ($barras as $altura)
        <i class="flex-1 rounded-pill bg-accent" style="height: {{ $altura }}%"></i>
    @endforeach
</div>
