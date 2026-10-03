<?php

namespace App\Middlewares;

use Core\Session;
use Core\View;
use App\Helpers\UrlHelper;

class AuthMiddleware
{
    public static function handle()
    {
        Session::start();
        if (!Session::get('admin_id')) {

            // TÁCTICA NINJA: Fingir que la página no existe
            http_response_code(404);
            View::render('errors/404', ['titulo' => 'Página no encontrada'], 'web/layout/app');
            exit();
        }
    }
}
