<?php

namespace App\Controllers;

use Core\View;
use App\Helpers\UrlHelper;

if (!defined('APP_RUNNING')) die("Acceso denegado.");

abstract class ControllerBase
{
    // Almacenará el body JSON decodificado para no parsearlo múltiples veces
    private $jsonPayload = null;
    private $jsonParsed = false;

    /**
     * Lee y decodifica el body de fetch() de forma "perezosa" (solo cuando se necesita)
     */
    private function getJsonPayload()
    {
        if (!$this->jsonParsed) {
            $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                // php://input captura la petición cruda (PUT, PATCH, DELETE, POST con JSON)
                $rawBody = file_get_contents('php://input');
                $this->jsonPayload = json_decode($rawBody, true);
            }
            $this->jsonParsed = true;
        }
        return $this->jsonPayload;
    }

    /**
     * Renderiza una vista pasando los datos. Es un atajo a Core\View.
     * 
     * @param string $vista Ruta de la vista
     * @param array $datos Variables a inyectar
     * @param string $layout Cascarón a utilizar
     */
    protected function render(string $vista, array $datos = [], string $layout = 'web/layout/app')
    {
        View::render($vista, $datos, $layout);
    }

    /**
     * Retorna una respuesta en formato JSON (Ideal para APIs, Webhooks de MercadoPago o AJAX)
     * 
     * @param mixed $datos Información a devolver (arrays u objetos)
     * @param int $codigo HTTP Status Code (200 OK, 400 Bad Request, etc.)
     */
    protected function json($datos, int $codigo = 200)
    {
        http_response_code($codigo);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
        exit(); // Detenemos la ejecución porque ya respondimos
    }

    /**
     * Redirige a una ruta interna de la aplicación de forma segura
     * 
     * @param string $ruta Ruta relativa (ej. '/panel/dashboard')
     */
    protected function redirect(string $ruta)
    {
        header("Location: " . UrlHelper::base_url($ruta));
        exit();
    }

    /**
     * Obtiene y sanitiza un valor enviado por fetch (JSON), POST o GET.
     * Obtiene y sanitiza un valor enviado por POST o GET.
     * Evita ataques XSS básicos limpiando las etiquetas HTML.
     * 
     * @param string $clave Nombre del campo (ej. 'email')
     * @param mixed $default Valor a retornar si no existe el campo
     */
    protected function input(string $clave, $default = null)
    {
        // 1. Buscamos primero en el payload JSON de fetch()
        $json = $this->getJsonPayload();
        if (is_array($json) && isset($json[$clave])) {
            $valor = $json[$clave];
            return is_string($valor) ? htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8') : $valor;
        }

        // 2. Si no es JSON, buscamos en el POST tradicional
        if (isset($_POST[$clave])) {
            $valor = $_POST[$clave];
            return is_string($valor) ? htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8') : $valor;
        }

        // 3. Por último, buscamos en los parámetros de la URL (GET)
        if (isset($_GET[$clave])) {
            $valor = $_GET[$clave];
            return is_string($valor) ? htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8') : $valor;
        }

        return $default;
    }
}
