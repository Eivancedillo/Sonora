# Sonora

Aplicación web de música (solo interfaz) construida con Laravel, Blade y Tailwind CSS v4, siguiendo el sistema de diseño Sonora. No hay backend ni base de datos: las canciones y playlists son datos de ejemplo inventados y la reproducción es simulada.

## Pantallas

- **Inicio** (`/`): mezclas, canciones en cola y filtros.
- **Buscar** (`/buscar`): filtra canciones y playlists mientras escribes.
- **Playlist** (`/playlist/{slug}`): portada, datos y lista de canciones.
- **Reproductor** (`/reproductor`): reproducción a pantalla completa con la cola.

Además: tema oscuro y claro (se guarda en el navegador) y versión móvil desde 390px de ancho.

## Requisitos

- PHP y Composer (los incluye [Laravel Herd](https://herd.laravel.com)).
- Node.js y npm.

## Cómo ejecutarlo

```bash
composer install
cp .env.example .env        # en Windows PowerShell: Copy-Item .env.example .env
php artisan key:generate
npm install
npm run dev
```

Con Laravel Herd, coloca la carpeta del proyecto dentro de la carpeta de sitios de Herd y ábrela en `http://<nombre-de-la-carpeta>.test`. Sin Herd, en otra terminal ejecuta `php artisan serve` y abre `http://localhost:8000`.

Para compilar sin servidor de desarrollo: `npm run build`.

## Estructura

- `resources/css/app.css`: tokens de diseño (colores oscuro y claro, tipografía, radios, sombra, movimiento).
- `resources/views/components/`: componentes Blade reutilizables (botón, chip, portada, tarjeta, fila de canción, progreso, etc.).
- `resources/views/layouts/`: `app` (base) y `panel` (barra lateral y reproductor).
- `resources/js/app.js`: reproducción simulada, tema y búsqueda.
- `app/Support/Catalogo.php`: datos de ejemplo.

## Datos de ejemplo

Todos los nombres de artistas, canciones y playlists son inventados. Las portadas son marcadores generados con barras, sin imágenes de terceros.

## Accesibilidad

Anillo de enfoque visible en todos los controles, uso completo con teclado (incluidas las barras de progreso y volumen con flechas), etiquetas en los botones que solo llevan icono y estados anunciados con `role="status"`.
