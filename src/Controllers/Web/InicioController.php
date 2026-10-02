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
                'assets/web/css/portafolio.css' // Se procesará por tu UrlHelper
            ],
            'scripts_adicionales' => [
                'assets/web/js/data.js', // Se procesará por tu UrlHelper
                'assets/web/js/main.js', // Se procesará por tu UrlHelper
                'assets/web/js/i18n.js' // Se procesará por tu UrlHelper
            ]
        ];

        // Renderizamos la vista usando tu motor basado en ob_start()
        View::render('web/pages/inicio', $datos, 'web/layout/app');
    }
}
