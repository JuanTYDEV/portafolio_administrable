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
    public static function base_url(string $path = ''): string
    {
        // 1. Obtenemos el protocolo (http o https)
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";

        // 2. Obtenemos el dominio (localhost o midominio.com)
        $host = $_SERVER['HTTP_HOST'];

        // 3. Obtenemos la carpeta base dinámica (ej. /porfolio_completo/public)
        $baseDir = dirname($_SERVER['SCRIPT_NAME']);
        $baseDir = str_replace('\\', '/', $baseDir);

        // 4. EL TRUCO: Si termina en /public, se lo quitamos
        if (basename($baseDir) === 'public') {
            $baseDir = dirname($baseDir);
        }

        // Limpiamos barras finales
        $baseDir = rtrim($baseDir, '/');
        $path = '/' . ltrim($path, '/');

        // Retornamos la URL limpia y perfecta
        return $protocol . "://" . $host . $baseDir . $path;
    }

    /**
     * Obtiene la ruta actual limpia, ignorando subcarpetas de entornos de desarrollo.
     * Retorna algo como '/panel/usuarios' en lugar de '/porfolio_completo/panel/usuarios'.
     */
    public static function current_path(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        $basePath = str_replace('\\', '/', $basePath);

        if (basename($basePath) === 'public') {
            $basePath = dirname($basePath);
        }

        $basePath = rtrim($basePath, '/');

        if ($basePath !== '' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        $uri = '/' . trim($uri, '/');
        return $uri === '//' ? '/' : $uri;
    }
}
