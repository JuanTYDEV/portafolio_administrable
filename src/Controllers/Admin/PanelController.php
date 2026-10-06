<?php

namespace App\Controllers\Admin;

use Core\View;
use App\Helpers\PermissionsHelper;

class PanelController
{
    public function index()
    {
        /*
        $titulo = 'Panel de Administración';
        $estilos_adicionales = [
            'css/admin/custom.css',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css'
            ];
        $scripts_adicionales = [
            'js/admin/custom.js',
            'https://code.jquery.com/jquery-3.6.0.min.js'
        ];
         */
        View::render('admin/pages/inicio', [], 'admin/layout/app');
    }

    public function usuarios()
    {
        View::render('admin/pages/usuarios', [], 'admin/layout/app');
    }

    public function permisos()
    {
        View::render('admin/pages/permisos', [], 'admin/layout/app');
    }
    public function proyectos()
    {
        View::render('admin/pages/proyectos', [], 'admin/layout/app');
    }
    public function configuracion()
    {
        View::render('admin/pages/configuracion', [], 'admin/layout/app');
    }

    public function datos()
    {
        View::render('admin/pages/datos', [], 'admin/layout/app');
    }

    public function finanzas()
    {
        if (!PermissionsHelper::tienePermiso('/panel/finanzas', 'ver')) {
            // Si el usuario no tiene permiso, puedes redirigirlo o mostrar un mensaje de error
            http_response_code(403);
            View::render('errors/403', ['titulo' => 'Acceso Denegado'], 'web/layout/app');
            exit();
        }

        View::render('admin/pages/clases', [], 'admin/layout/app');
    }
}
