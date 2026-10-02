<?php

namespace App\Controllers\Admin;

use Core\View;

class AuthController
{
    public function login()
    {
        // Aquí puedes agregar la lógica para mostrar el formulario de inicio de sesión
        // Por ejemplo, podrías verificar si el usuario ya está autenticado y redirigirlo al panel de administración

        // Renderizamos la vista usando tu motor basado en ob_start()
        View::render('admin/auth/login', [], 'admin/layout/auth');
    }

    public function procesarLogin()
    {
        // Aquí puedes agregar la lógica para procesar el inicio de sesión
        // Por ejemplo, podrías validar las credenciales del usuario y establecer la sesión

        // Redirigimos al panel de administración después del inicio de sesión exitoso
        header('Location: ' . \App\Helpers\UrlHelper::base_url('/panel/dashboard'));
        exit;
    }
}
