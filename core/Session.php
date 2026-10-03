<?php

namespace Core;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            // Configuraciones de seguridad ANTES de iniciar la sesión
            ini_set('session.use_only_cookies', 1);
            ini_set('session.use_strict_mode', 1);

            session_set_cookie_params([
                'lifetime' => 14400, // 4 horas
                'path' => '/',
                'domain' => '', // Tu dominio
                'secure' => isset($_SERVER['HTTPS']), // Solo por HTTPS si está disponible
                'httponly' => true, // Inmune a XSS vía JavaScript
                'samesite' => 'Lax' // Previene ataques CSRF en redirecciones cruzadas
            ]);

            session_start();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function destroy()
    {
        self::start();
        $_SESSION = [];
        session_destroy();

        // Borrar la cookie del navegador
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Vital para evitar ataques de Session Fixation cuando alguien inicia sesión
    public static function regenerate()
    {
        session_regenerate_id(true);
    }
}
