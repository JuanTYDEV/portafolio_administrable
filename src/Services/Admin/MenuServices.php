<?php

namespace App\Services\Admin;

class MenuServices
{
    /**
     * Transforma el resultado plano de la BD en un árbol multidimensional
     * @param array $modulosBrutos Resultado plano de la BD
     * @return array Árbol multidimensional del menú
     */
    public static function construirArbol($modulosBrutos)
    {
        $menu_sidebar = [];
        $permisos_rutas = []; // NUEVO: Diccionario rápido de permisos

        foreach ($modulosBrutos as $fila) {
            $padre_id = $fila['padre_id'] ?? 0;

            if (!isset($menu_sidebar[$padre_id])) {
                if ($padre_id == 0) {
                    $menu_sidebar[0] = ['modulos' => []];
                } else {
                    $menu_sidebar[$padre_id] = [
                        'nombre'  => $fila['padre_nombre'],
                        'icono'   => $fila['padre_icono'],
                        'modulos' => []
                    ];
                }
            }

            $menu_sidebar[$padre_id]['modulos'][] = [
                'modulo_id' => $fila['modulo_id'],
                'nombre'    => $fila['modulo_nombre'],
                'ruta'      => $fila['ruta'],
                'icono'     => $fila['icono'],
                'crear'     => $fila['permiso_crear'],
                'editar'    => $fila['permiso_editar'],
                'eliminar'  => $fila['permiso_eliminar']
            ];

            // NUEVO: Guardamos la ruta como llave para búsquedas ultra rápidas O(1)
            $permisos_rutas[$fila['ruta']] = [
                'ver'      => true, // Si llegó aquí, es porque permiso_ver = 1 en la consulta SQL
                'crear'    => (bool) $fila['permiso_crear'],
                'editar'   => (bool) $fila['permiso_editar'],
                'eliminar' => (bool) $fila['permiso_eliminar']
            ];
        }

        return [
            'arbol' => $menu_sidebar,
            'planos' => $permisos_rutas
        ];
    }
}
