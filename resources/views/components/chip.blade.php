@props(['activo' => false])

<button type="button" aria-pressed="{{ $activo ? 'true' : 'false' }}"
    {{ $attributes->merge(['class' => 'rounded-pill bg-surface-high px-4 py-2 text-caption uppercase text-ink transition aria-pressed:bg-accent aria-pressed:text-on-accent']) }}>{{ $slot }}</button>
