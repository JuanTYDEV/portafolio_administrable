<?php
namespace Core;

if (!defined('APP_RUNNING')) die("Acceso denegado.");

class Autoloader {
    public static function register() {
        spl_autoload_register(function ($class) {
            // Mapa de prefijos de namespace apuntando a sus carpetas físicas
            $prefixes = [
                'Core\\' => __DIR__ . '/',           // Las clases Core\ van en tu_proyecto/core/
                'App\\'  => __DIR__ . '/../src/'     // Las clases App\ van en tu_proyecto/src/
            ];

            foreach ($prefixes as $prefix => $base_dir) {
                // Compara si la clase solicitada empieza con el prefijo actual
                $len = strlen($prefix);
                if (strncmp($prefix, $class, $len) !== 0) {
                    continue; // Si no coincide, pasa al siguiente prefijo
                }

                // Obtiene el nombre de la clase sin el prefijo (ej: Controllers\VentasController)
                $relative_class = substr($class, $len);

                // Reemplaza las barras invertidas del namespace por las del sistema de archivos
                $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

                // Si el archivo existe, lo carga y termina la función
                if (file_exists($file)) {
                    require_once $file;
                    return;
                }
            }
        });
    }
}