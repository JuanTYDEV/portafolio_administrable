<?php
namespace Core;

if (!defined('APP_RUNNING')) die("Acceso denegado.");

class Router {
    protected array $routes = [];

    // Registrar rutas GET
    public function get(string $route, array|callable $callback) {
        $this->routes['GET'][$route] = $callback;
    }

    // Registrar rutas POST
    public function post(string $route, array|callable $callback) {
        $this->routes['POST'][$route] = $callback;
    }

    // El cerebro: lee la URL y busca coincidencias
    public function resolve() {
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Obtenemos la URL actual y le quitamos variables (ej. ?page=2)
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Si tienes el proyecto en una subcarpeta (ej. localhost/porfolio/public), limpiamos ese prefijo
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/' && strpos($uri, $scriptName) === 0) {
            $uri = substr($uri, strlen($scriptName));
        }
        
        // Aseguramos que la URL siempre empiece con '/' y no tenga '/' al final
        $uri = '/' . trim($uri, '/');
        if ($uri === '//') $uri = '/';

        // Buscamos si la ruta existe
        error_log("Resolviendo ruta: $method $uri");
        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            // Convertimos la ruta registrada (ej. /proyectos/{id}) en una expresión regular
            $routeRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
            $routeRegex = "#^" . $routeRegex . "$#";

            if (preg_match($routeRegex, $uri, $matches)) {
                array_shift($matches); // Quitamos la coincidencia completa, dejamos solo las variables

                // Si pasaste un array [Controlador::class, 'metodo']
                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    $callback[0] = $controller;
                }

                // Ejecutamos el controlador y le pasamos los parámetros si existen
                return call_user_func_array($callback, $matches);
            }
        }

        // Si el bucle termina y no encontró la ruta: Error 404
        http_response_code(404);
        View::render('errors/404');
    }
}