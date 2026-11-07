@props(['indice', 'pista', 'actual' => false])

<button type="button" @isset($pista['id']) data-pista="{{ $pista['id'] }}" @endisset
    @if ($actual) aria-current="true" @endif
    {{ $attributes->merge(['class' => 'group grid w-full grid-cols-[24px_1fr_auto] items-center gap-3 rounded-md px-2 py-3 text-left transition hover:bg-surface-high aria-[current=true]:bg-surface-high']) }}>
    <span
        class="font-mono text-xs text-ink-muted group-aria-[current=true]:text-accent">{{ str_pad($indice + 1, 2, '0', STR_PAD_LEFT) }}</span>
    <span class="min-w-0">
        <span class="block truncate text-sm font-bold">{{ $pista['titulo'] }}</span>
        <span class="block truncate text-xs font-medium text-ink-muted">{{ $pista['artista'] }}</span>
    </span>
    <span
        class="whitespace-nowrap font-mono text-xs text-ink-muted">{{ sprintf('%02d:%02d', intdiv($pista['dur'], 60), $pista['dur'] % 60) }}</span>
</button>
