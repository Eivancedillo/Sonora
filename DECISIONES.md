# Decisiones de diseño y código

## Componentes reutilizados

- `x-icon` (10 iconos del sistema): usado en la barra lateral, la barra del reproductor, los controles y la búsqueda.
- `x-button` (primario, secundario y fantasma, como botón o enlace) y `x-icon-button` (botones de solo icono con etiqueta obligatoria).
- `x-cover` en tres tamaños: tarjetas, cabecera de playlist, reproductor y barra inferior.
- `x-media-card`: Inicio y Buscar. `x-song-row`: Inicio, Playlist, Reproductor y Buscar.
- `x-progress`: la misma pieza sirve para el progreso de la canción y para el volumen.
- `x-play-button`: dos tamaños y dos variantes (ámbar y neutra).
- `x-chip`, `x-logo`, `x-sidebar`, `x-player-bar`, `x-search-field` y `x-theme-toggle`.

## Decisiones

- Los tokens son variables CSS conectadas a Tailwind con `@theme inline`; el tema cambia con `data-theme` sin duplicar clases. La escala tipográfica también está como tokens.
- El anillo de enfoque es una regla global, para que ningún control se quede sin él.
- Un solo botón primario ámbar por vista: las vistas con botón propio (Playlist) avisan con una bandera y el botón de la barra inferior pasa a la variante neutra.
- Los datos de ejemplo viven en una clase (`App\Support\Catalogo`), sin base de datos, porque el alcance era solo la interfaz.
- La reproducción simulada usa atributos `data-*` en lugar de `id`, para que los mismos componentes funcionen en varias pantallas a la vez. El estado se guarda en `sessionStorage`, así la canción sigue al cambiar de pantalla.
- Un solo punto de quiebre (`md`, 768px) y diseño pensado primero para móvil.
- La búsqueda filtra en el navegador e ignora mayúsculas y acentos.
- El botón de tema es de texto porque el conjunto de iconos del sistema no tiene uno de tema.
- En móvil se oculta el control de volumen, porque se maneja con los botones del teléfono.

## Qué cambiaríamos

- Pasar las canciones a una base de datos (modelo, migración y seeder) y las pantallas a controladores, como propone la fase opcional del brief.
- Conectar audio real con un elemento `<audio>`.
- Usar portadas reales en lugar de los marcadores.
- Hacer que los chips de Inicio filtren contenido cuando existan podcasts.
- Guardar "me gusta" y playlists guardadas de forma permanente; hoy solo duran mientras la pestaña esté abierta.
- Añadir un historial real al modo aleatorio y pruebas automáticas de accesibilidad.
