<?php

namespace App\Controllers\Web;

use Core\View;

if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

class InicioController
{
    public function index()
    {
        $datos = [
            'titulo' => 'Bienvenido a mi Portafolio',
            'estilos_adicionales' => [
                // Aquí puedes agregar rutas a archivos CSS adicionales si es necesario
            ],
            'scripts_adicionales' => [
                // Aquí puedes agregar rutas a archivos JS adicionales si es necesario
            ]
        ];

        // Renderizamos la vista usando tu motor basado en ob_start()
        View::render('web/pages/inicio', $datos, 'web/layout/app');
    }
}
