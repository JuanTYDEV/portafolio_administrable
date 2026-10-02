<?php
// UrlHelper.php

namespace App\Helpers;

if (!defined('APP_RUNNING')) die("Acceso denegado.");

class UrlHelper
{
    /**
     * Genera la URL completa para un asset (CSS, JS, imágenes, etc.) con versión basada en la fecha de modificación.
     *
     * @param string $ruta Ruta relativa del asset (ej. 'css/estilos.css')
     * @return string URL completa del asset con versión
     */
    public static function asset_url($ruta)
    {
        // Obtenemos la ruta física del archivo
        $ruta_fisica = __DIR__ . '/../../public/' . ltrim($ruta, '/');

        // Verificamos si el archivo existe y obtenemos su fecha de modificación
        $version = file_exists($ruta_fisica) ? filemtime($ruta_fisica) : time();

        // Retornamos la URL completa con la versión como query string
        return self::base_url($ruta) . '?v=' . $version;
    }

    /**
     * Base de la aplicación sobre el dominio, SIN barra final.
     * Ej.: '' si la app es la raíz del vhost, '/dashboard_kdamin' en subcarpeta.
     */
    public static function url_base(): string
    {
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/');
        return rtrim(dirname($script), '/');
    }

    /**
     * URL absoluta desde la base de la app. base_url('assets/css/x.css').
     */
    public static function base_url(string $ruta = ''): string
    {
        $base = self::url_base();
        $limpia = '/' . ltrim($ruta, '/');
        while (strpos($limpia, '//') !== false) {
            $limpia = str_replace('//', '/', $limpia);
        }
        return $base . $limpia;
    }
}
