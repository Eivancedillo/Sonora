@php
    $principal = [
        ['texto' => 'Inicio', 'icono' => 'home', 'href' => route('inicio'), 'activo' => request()->routeIs('inicio')],
        ['texto' => 'Buscar', 'icono' => 'search', 'href' => route('buscar'), 'activo' => request()->routeIs('buscar')],
    ];

    $playlists = \App\Support\Catalogo::playlists();
@endphp

<nav aria-label="Principal"
    class="flex flex-wrap items-center gap-1 border-b border-line bg-surface-raised px-4 py-2 md:flex-col md:flex-nowrap md:items-stretch md:gap-2 md:overflow-y-auto md:border-b-0 md:py-6">
    <x-logo class="mr-auto md:mb-6 md:mr-0" />

    @foreach ($principal as $enlace)
        <a href="{{ $enlace['href'] }}" @if ($enlace['activo']) aria-current="page" @endif
            class="flex items-center gap-3 rounded-md p-3 text-sm font-bold text-ink-muted transition hover:bg-surface-high aria-[current=page]:bg-surface-high aria-[current=page]:text-ink">
            <x-icon :name="$enlace['icono']" />
            <span class="sr-only md:not-sr-only">{{ $enlace['texto'] }}</span>
        </a>
    @endforeach

    <p id="titulo-biblioteca" class="mt-6 hidden items-center gap-3 px-3 text-caption uppercase text-ink-muted md:flex">
        <x-icon name="library" />
        Tu biblioteca
    </p>

    <div role="group" aria-labelledby="titulo-biblioteca" class="hidden flex-col gap-1 md:flex">
        @foreach ($playlists as $lista)
            <a href="{{ route('playlist', $lista['slug']) }}"
                @if (request()->routeIs('playlist') && request()->route('slug') === $lista['slug']) aria-current="page" @endif
                class="block truncate rounded-md px-3 py-2 text-body-sm text-ink-muted transition hover:bg-surface-high aria-[current=page]:bg-surface-high aria-[current=page]:text-ink">
                {{ $lista['titulo'] }}
            </a>
        @endforeach
    </div>

    <x-theme-toggle class="md:mt-auto md:self-start" />
</nav>
