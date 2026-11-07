@props(['variant' => 'primary', 'href' => null])

@php
    $base =
        'inline-flex items-center justify-center gap-2 rounded-pill px-6 py-3 text-sm font-bold transition disabled:pointer-events-none disabled:opacity-50';

    $variantes = [
        'primary' => 'bg-accent text-on-accent hover:bg-accent-hover',
        'secondary' => 'border-2 border-line-strong text-ink hover:bg-surface-high',
        'ghost' => 'text-ink-muted hover:bg-surface-high hover:text-ink',
    ];

    $clases = $base . ' ' . $variantes[$variant];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $clases]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['type' => 'button', 'class' => $clases]) }}>{{ $slot }}</button>
@endif
