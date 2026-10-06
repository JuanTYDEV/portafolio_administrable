<?php

namespace App\Models\Admin;

use App\Models\ModelBase;

if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

class MenuModel extends ModelBase
{
    // No necesitamos definir $table ni $primaryKey porque esta clase solo hará consultas complejas personalizadas

    /**
     * Obtiene y formatea el menú jerárquico según el rol del usuario
     */
    public function obtenerMenuPorRol($rol_id)
    {
        $sql = "SELECT 
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
                ORDER BY mp.orden, m.orden";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['rol_id' => $rol_id]);
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $menu_sidebar = [];

        foreach ($resultados as $fila) {
            // Si el módulo no tiene padre, lo asignamos al índice 0
            $padre_id = $fila['padre_id'] ?? 0;

            // Si el padre aún no existe en nuestro array formateado, lo creamos
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

            // Insertamos el módulo hijo dentro de su padre correspondiente
            $menu_sidebar[$padre_id]['modulos'][] = [
                'modulo_id' => $fila['modulo_id'],
                'nombre'    => $fila['modulo_nombre'],
                'ruta'      => $fila['ruta'],
                'icono'     => $fila['icono'],
                // Guardamos los permisos granulares en sesión por si quieres usarlos para ocultar botones de "Crear" o "Eliminar" en las vistas
                'crear'     => $fila['permiso_crear'],
                'editar'    => $fila['permiso_editar'],
                'eliminar'  => $fila['permiso_eliminar']
            ];
        }

        return $menu_sidebar;
    }

    public function obtenerModulosBrutosPorRol($rol_id)
    {
        $sql = "SELECT mp.id AS padre_id, mp.nombre AS padre_nombre, mp.icono AS padre_icono, 
                       m.id AS modulo_id, m.nombre AS modulo_nombre, m.ruta, m.icono, 
                       p.permiso_crear, p.permiso_editar, p.permiso_eliminar 
                FROM permisos p
                JOIN modulos m ON p.modulo_id = m.id
                LEFT JOIN modulo_padre mp ON m.modulo_padre_id = mp.id
                WHERE p.rol_id = :rol_id AND p.permiso_ver = 1
                ORDER BY mp.orden, m.orden";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['rol_id' => $rol_id]);

        // Retorna un arreglo plano, sin lógica extra
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
