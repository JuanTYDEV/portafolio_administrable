<?php
// src/Helpers/MenuHelper.php

namespace App\Helpers;



if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

use App\Helpers\UrlHelper;
use Error;

class MenuHelper
{
    /**
     * Genera el menú HTML dinámicamente basado en la sesión
     */
    public static function generar(array $menu_sidebar, string $pagina_actual): string
    {
        $html = '';

        // 1. Renderizar primero los módulos que NO tienen padre (id 0)
        if (isset($menu_sidebar[0])) {
            foreach ($menu_sidebar[0]['modulos'] as $modulo) {
                $html .= self::generarMenuItem($modulo, $pagina_actual);
            }
        }

        // 2. Renderizar los Padres como "Secciones" y a sus hijos como items normales
        foreach ($menu_sidebar as $padre_id => $padre) {
            if ($padre_id == 0) continue; // Saltamos el 0 porque ya lo renderizamos arriba

            // Solo dibujamos la sección si tiene módulos hijos asignados
            if (!empty($padre['modulos'])) {

                // A) Imprimimos el título de la sección (El Padre)
                $html .= self::generarSeccionPadre($padre);

                // B) Imprimimos los hijos debajo de la sección, usando el mismo diseño normal
                foreach ($padre['modulos'] as $hijo) {
                    $html .= self::generarMenuItem($hijo, $pagina_actual);
                }
            }
        }

        // 3. Agregar botón de Salir al final
        $html .= '
        <li class="nav-item">
            <a href="' . UrlHelper::base_url('/panel/logout') . '">
                <i class="fas fa-power-off"></i>
                <p>Salir</p>
            </a>
        </li>';

        return $html;
    }

    /**
     * Genera un item de menú normal (Botón clickeable)
     */
    private static function generarMenuItem(array $item, string $pagina_actual): string
    {
        // Comparamos la ruta de la BD con la URL actual para marcarlo como activo
        $active = ($pagina_actual == $item['ruta']) ? 'active' : '';
        $icono = $item['icono'] ?: 'fas fa-circle';

        return '
        <li class="nav-item ' . $active . '">
            <a href="' . UrlHelper::base_url($item['ruta']) . '">
                <i class="' . $icono . '"></i>
                <p>' . strtoupper(htmlspecialchars($item['nombre'])) . '</p>
            </a>
        </li>';
    }

    /**
     * Genera el separador visual (Sección) para los módulos agrupados
     */
    private static function generarSeccionPadre(array $padre): string
    {
        // Si el padre no tiene icono en la BD, usamos los puntitos por defecto de la plantilla
        $icono = $padre['icono'] ?: 'fa fa-ellipsis-h';
        $nombre = strtoupper(htmlspecialchars($padre['nombre']));

        return '
        <li class="nav-section">
            <span class="sidebar-mini-icon">
                <i class="' . $icono . '"></i>
            </span>
            <h4 class="text-section">' . $nombre . '</h4>
        </li>';
    }
}
