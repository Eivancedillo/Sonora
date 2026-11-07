<?php

namespace App\Support;

/**
 * Datos de ejemplo de Sonora, todos inventados.
 * Sirven solo para maquetar las vistas: no hay base de datos.
 */
class Catalogo
{
    /**
     * Las 10 canciones de ejemplo.
     */
    public static function pistas(): array
    {
        $datos = [
            [1, 'Noches de lluvia', 'Mar Abierto', 'Sin prisa', 258],
            [2, 'Hora azul', 'Luz de Norte', 'Mapa de sal', 232],
            [3, 'Cuerdas', 'Estudio Cinco', 'Taller', 307],
            [4, 'Caminos', 'Mar Abierto', 'Sin prisa', 209],
            [5, 'Despacio', 'Luz de Norte', 'Mapa de sal', 284],
            [6, 'Faro lento', 'Tinta Verde', 'Orilla', 221],
            [7, 'Papel y viento', 'Tinta Verde', 'Orilla', 246],
            [8, 'Madrugada', 'Estudio Cinco', 'Taller', 198],
            [9, 'Costa vieja', 'Mar Abierto', 'Sin prisa', 267],
            [10, 'Último tren', 'Luz de Norte', 'Mapa de sal', 239],
        ];

        return array_map(fn($p) => [
            'id' => $p[0],
            'titulo' => $p[1],
            'artista' => $p[2],
            'album' => $p[3],
            'dur' => $p[4],
            'duracion' => self::formato($p[4]),
            'barras' => self::barras($p[0]),
        ], $datos);
    }

    /**
     * Las 4 playlists de ejemplo, cada una con sus canciones.
     */
    public static function playlists(): array
    {
        $pistas = collect(self::pistas())->keyBy('id');

        $datos = [
            ['mezcla-diaria-1', 'Mezcla diaria 1', 'Para ti', [1, 5, 3, 7, 2, 9]],
            ['noches-de-lluvia', 'Noches de lluvia', 'Playlist', [1, 4, 9, 10, 6]],
            ['sin-prisa', 'Sin prisa', 'Mar Abierto', [1, 4, 9]],
            ['caminos', 'Caminos', 'Playlist', [4, 6, 7, 8, 2, 10, 3]],
        ];

        return array_map(function ($d, $i) use ($pistas) {
            $lista = array_map(fn($id) => $pistas[$id], $d[3]);
            $total = array_sum(array_column($lista, 'dur'));

            return [
                'slug' => $d[0],
                'titulo' => $d[1],
                'artista' => $d[2],
                'pistas' => $lista,
                'duracion' => self::formato($total),
                'barras' => self::barras(20 + $i),
            ];
        }, $datos, array_keys($datos));
    }

    /**
     * Busca una playlist por su slug; devuelve null si no existe.
     */
    public static function playlist(string $slug): ?array
    {
        return collect(self::playlists())->firstWhere('slug', $slug);
    }

    /**
     * Segundos a texto: 03:42 o 1:12:40.
     */
    public static function formato(int $segundos): string
    {
        $horas = intdiv($segundos, 3600);
        $minutos = intdiv($segundos % 3600, 60);
        $resto = $segundos % 60;

        return $horas > 0
            ? sprintf('%d:%02d:%02d', $horas, $minutos, $resto)
            : sprintf('%02d:%02d', $minutos, $resto);
    }

    /**
     * Alturas (en %) de las 5 barras del marcador de portada.
     * Se calculan a partir de un número para que cada portada sea distinta pero estable.
     */
    private static function barras(int $semilla): array
    {
        return array_map(fn($k) => 30 + (($semilla * 7 + $k * 23) % 66), range(0, 4));
    }
}
