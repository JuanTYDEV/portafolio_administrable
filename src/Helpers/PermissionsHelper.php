<?php

namespace App\Helpers;

use Core\Session;

class PermissionsHelper
{
    /**
     * Verifica si el usuario actual tiene cierto permiso sobre una ruta
     * Acciones: 'ver', 'crear', 'editar', 'eliminar'
     */
    public static function tienePermiso(string $ruta, string $accion = 'ver'): bool
    {
        // Si el usuario es el "SuperAdmin" absoluto (ej. rol_id = 1), le puedes dar pase libre siempre:
        // if (Session::get('admin_rol_id') === 1) return true;

        $permisos = Session::get('permisos_rutas', []);

        // Si la ruta existe en su lista y la acción específica es true
        if (isset($permisos[$ruta]) && !empty($permisos[$ruta][$accion])) {
            return true;
        }

        return false;
    }
}
