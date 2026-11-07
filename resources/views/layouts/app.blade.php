<!doctype html>
<html lang="es" data-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Sonora')</title>
    <script>
        try {
            const tema = localStorage.getItem('sonora:tema');
            if (tema === 'light' || tema === 'dark') document.documentElement.dataset.theme = tema;
        } catch (_) {}
    </script>
    <script>
        window.sonora = {
            pistas: @json(\App\Support\Catalogo::pistas())
        };
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @yield('contenido')
</body>

</html>
