<?php

namespace App\Controllers\Admin;

use App\Controllers\ControllerBase;
use App\Models\UsuarioModel;
use Core\Session;

if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

class AuthController extends ControllerBase
{
    public function login()
    {
        // Aquí puedes agregar la lógica para mostrar el formulario de inicio de sesión
        // Por ejemplo, podrías verificar si el usuario ya está autenticado y redirigirlo al panel de administración
        if (Session::get('admin_id')) {
            return $this->redirect('/panel');
        }
        // Renderizamos la vista usando tu motor basado en ob_start()
        $this->render('admin/auth/login', ['titulo' => 'Iniciar Sesión'], 'admin/layout/auth');
    }
    // Procesa la petición fetch (POST)
    public function procesarLogin()
    {
        $email = $this->input('email');
        $password = $this->input('password');

        if (!$email || !$password) {
            return $this->json(['exito' => false, 'mensaje' => 'Todos los campos son obligatorios.'], 400);
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->buscarPorEmail($email);

        // En AuthController o AuthMiddleware
        $rolModel = new \App\Models\RolModel();
        $timestamp_rol = $rolModel->obtenerFechaActualizacion($usuario['rol_id']);

        // Verificamos si existe el correo y si la contraseña coincide con el Hash
        if ($usuario && password_verify($password, $usuario['password_hash'])) {

            // Verificamos que la cuenta no esté desactivada (tu columna 'activo')
            if ($usuario['activo'] != 1) {
                return $this->json(['exito' => false, 'mensaje' => 'Tu cuenta ha sido desactivada.'], 403);
            }

            // Táctica contra Session Fixation: Regeneramos el ID de la sesión
            Session::regenerate();

            // Guardamos los datos en la sesión
            Session::set('admin_id', $usuario['id']);
            Session::set('admin_nombre', $usuario['nombre']);
            Session::set('admin_email', $usuario['email']);
            Session::set('admin_rol_id', $usuario['rol_id']);
            Session::set('admin_rol_timestamp', $timestamp_rol);

            $menuModel = new \App\Models\Admin\MenuModel();
            $datosMenuPermisosPlanos = $menuModel->obtenerModulosBrutosPorRol($usuario['rol_id']);

            $datosMenuPermisosContruidos = \App\Services\Admin\MenuServices::construirArbol($datosMenuPermisosPlanos);
            $arbolMenu = $datosMenuPermisosContruidos['arbol'];
            $arbolPermisos = $datosMenuPermisosContruidos['planos'];

            Session::set('menu_sidebar', $arbolMenu);
            Session::set('permisos_rutas', $arbolPermisos);

            return $this->json(['exito' => true, 'mensaje' => 'Bienvenido', 'redirect' => 'panel']);
        }

        // Falso positivo de seguridad: No le decimos si falló el correo o la contraseña
        return $this->json(['exito' => false, 'mensaje' => 'Credenciales incorrectas.'], 401);
    }

    // Cierra la sesión
    public function logout()
    {
        Session::destroy();
        return $this->redirect('/panel/login');
    }
}
