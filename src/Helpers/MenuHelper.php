<?php
// src/Helpers/MenuHelper.php

namespace App\Helpers;



if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

use App\Helpers\UrlHelper;
class MenuHelper
{
    /**
     * Genera el menú HTML dinámicamente basado en la sesión (que viene de la BD)
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

        // 2. Renderizar los menús desplegables (padres) y sus hijos
        foreach ($menu_sidebar as $padre_id => $padre) {
            if ($padre_id == 0) continue; // Saltamos el 0 porque ya lo renderizamos arriba

            // Solo dibujamos el padre si tiene módulos hijos asignados
            if (!empty($padre['modulos'])) {
                $html .= self::generarMenuItemPadre($padre_id, $padre, $pagina_actual);
            }
        }

        // 3. Agregar botón de Salir al final
        $html .= '
        <li class="nav-item">
            <a href="' . UrlHelper::base_url('/logout') . '">
                <i class="fas fa-power-off"></i>
                <p>Salir</p>
            </a>
        </li>';

        return $html;
    }

    /**
     * Genera un item de menú normal (Sin hijos)
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
                <p>' . htmlspecialchars($item['nombre']) . '</p>
            </a>
        </li>';
    }

    /**
     * Genera un item de menú padre con sus hijos
     */
    private static function generarMenuItemPadre(int $padre_id, array $padre, string $pagina_actual): string
    {
        $tiene_hijo_activo = false;

        // Verificar si algún hijo es la página actual para expandir el menú
        foreach ($padre['modulos'] as $hijo) {
            if ($pagina_actual == $hijo['ruta']) {
                $tiene_hijo_activo = true;
                break;
            }
        }

        $icono = $padre['icono'] ?: 'fas fa-folder';
        $expandido = $tiene_hijo_activo ? '' : 'collapsed';
        $expanded = $tiene_hijo_activo ? 'true' : 'false';
        $show_class = $tiene_hijo_activo ? 'show' : '';
        $padre_active = $tiene_hijo_activo ? 'active' : ''; // Opcional: marcar el padre como activo

        $html = '
        <li class="nav-item ' . $padre_active . '">
            <a data-bs-toggle="collapse" href="#menu-' . $padre_id . '" class="' . $expandido . '" aria-expanded="' . $expanded . '">
                <i class="' . $icono . '"></i>
                <p>' . htmlspecialchars($padre['nombre']) . '</p>
                <span class="caret"></span>
            </a>
            <div class="collapse ' . $show_class . '" id="menu-' . $padre_id . '">
                <ul class="nav nav-collapse">';

        // Generar los <li> de los hijos
        foreach ($padre['modulos'] as $hijo) {
            $active = ($pagina_actual == $hijo['ruta']) ? 'active' : '';

            $html .= '
                    <li class="' . $active . '">
                        <a href="' . UrlHelper::base_url($hijo['ruta']) . '">
                            <span class="sub-item">' . htmlspecialchars($hijo['nombre']) . '</span>
                        </a>
                    </li>';
        }

        $html .= '
                </ul>
            </div>
        </li>';

        return $html;
    }
}

/* Consulta a usar para obtener el menú dinámico desde la base de datos:

SELECT 
    mp.id AS padre_id, 
    mp.nombre AS padre_nombre, 
    mp.icono AS padre_icono, 
    m.id AS modulo_id, 
    m.nombre AS modulo_nombre, 
    m.ruta, 
    m.icono, 
    p.permiso_crear, 
    p.permiso_editar, 
    p.permiso_eliminar 
FROM permisos p
JOIN modulos m ON p.modulo_id = m.id
LEFT JOIN modulo_padre mp ON m.modulo_padre_id = mp.id
WHERE p.rol_id = :rol_id 
  AND p.permiso_ver = 1
ORDER BY mp.orden, m.orden;

*/