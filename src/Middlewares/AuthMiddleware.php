<?php

namespace App\Middlewares;

use Core\Session;
use Core\View;
use App\Helpers\UrlHelper;

class AuthMiddleware
{
    /* public static function handle()
    {
        Session::start();
        if (!Session::get('admin_id')) {

            // TÁCTICA NINJA: Fingir que la página no existe
            http_response_code(404);
            View::render('errors/404', ['titulo' => 'Página no encontrada'], 'web/layout/app');
            exit();
        }
    } */

    public static function handle()
    {
        if (!Session::get('admin_id')) {
            http_response_code(404);
            View::render('errors/404');
            exit();
        }

        // --- MAGIA: ACTUALIZACIÓN EN TIEMPO REAL ---
        $rol_id = Session::get('admin_rol_id');

        // Consulta ultra ligera, solo trae una fecha
        // En AuthController o AuthMiddleware
        $rolModel = new \App\Models\RolModel();
        $timestamp_rol = $rolModel->obtenerFechaActualizacion($rol_id);

        // Si la fecha de la BD cambió, recargamos el menú sin cerrar su sesión
        if ($timestamp_rol !== Session::get('admin_rol_timestamp')) {
            $menuModel = new \App\Models\Admin\MenuModel();
            $datosMenuPermisosPlanos = $menuModel->obtenerModulosBrutosPorRol($rol_id);
            // $nuevoMenu = \App\Services\Admin\MenuServices::construirArbol($datosMenuPlanos);

            $datosMenuPermisosContruidos = \App\Services\Admin\MenuServices::construirArbol($datosMenuPermisosPlanos);
            $arbolMenu = $datosMenuPermisosContruidos['arbol'];
            $arbolPermisos = $datosMenuPermisosContruidos['planos'];

            Session::set('menu_sidebar', $arbolMenu);
            Session::set('permisos_rutas', $arbolPermisos);
            Session::set('admin_rol_timestamp', $timestamp_rol);
        }
    }
}
