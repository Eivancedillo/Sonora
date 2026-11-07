@extends('layouts.app')

@section('contenido')
    <div
        class="grid h-dvh grid-cols-1 grid-rows-[auto_minmax(0,1fr)_auto] md:grid-cols-[200px_1fr] md:grid-rows-[minmax(0,1fr)_80px]">
        <x-sidebar />

        <main class="min-h-0 overflow-y-auto px-4 py-4 md:px-8 md:py-6">
            @yield('principal')
        </main>

        <x-player-bar :pista="\App\Support\Catalogo::pistas()[0]" :acento="!$__env->hasSection('accion-principal')" />
    </div>
@endsection
