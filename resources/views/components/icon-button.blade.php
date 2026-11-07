@props(['icono', 'etiqueta'])

<button type="button" aria-label="{{ $etiqueta }}"
    {{ $attributes->merge(['class' => 'flex size-10 items-center justify-center rounded-pill text-ink transition hover:bg-surface-high aria-pressed:text-accent']) }}>
    <x-icon :name="$icono" />
</button>
