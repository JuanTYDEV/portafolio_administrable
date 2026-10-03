<?php

namespace Core;

if (!defined('APP_RUNNING')) die("Acceso denegado.");

class Router
{
    protected array $routes = [];

    // Registrar rutas GET
    public function get(string $route, array|callable $callback, array $middlewares = [])
    {
        $this->routes['GET'][$route] = [
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    // Registrar rutas POST
    public function post(string $route, array|callable $callback, array $middlewares = [])
    {
        $this->routes['POST'][$route] = [
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    // Agrega estos métodos debajo de tus funciones get() y post()
    public function put(string $route, array|callable $callback, array $middlewares = [])
    {
        $this->routes['PUT'][$route] = [
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    public function patch(string $route, array|callable $callback, array $middlewares = [])
    {
        $this->routes['PATCH'][$route] = [
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    public function delete(string $route, array|callable $callback, array $middlewares = [])
    {
        $this->routes['DELETE'][$route] = [
            'callback' => $callback,
            'middlewares' => $middlewares
        ];
    }

    // El cerebro: lee la URL y busca coincidencias
    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Obtenemos la URL actual y le quitamos variables (ej. ?page=2)
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // --- LA MAGIA PARA ENTORNOS CON SUBCARPETAS ---
        // 1. Obtenemos el directorio real de ejecución (ej. /porfolio_completo/public o /)
        $basePath = dirname($_SERVER['SCRIPT_NAME']);

        // 2. Reemplazamos barras invertidas por normales (por si estás en Windows)
        $basePath = str_replace('\\', '/', $basePath);

        // 3. Si el basePath termina en '/public', sabemos que estamos usando el truco del .htaccess
        // Así que le quitamos el '/public' para obtener la carpeta raíz real del proyecto
        if (basename($basePath) === 'public') {
            $basePath = dirname($basePath);
        }

        // 4. Limpiamos las barras finales para hacer la comparación
        $basePath = rtrim($basePath, '/');

        // 5. Si la URI actual empieza con el nombre de la carpeta base, se lo quitamos
        if ($basePath !== '' && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        // ----------------------------------------------

        // Aseguramos que la URL siempre empiece con '/' y no tenga '/' al final
        $uri = '/' . trim($uri, '/');
        if ($uri === '//') $uri = '/';

        error_log("Resolviendo ruta limpia: $method $uri");
        // error_log("Rutas registradas: " . print_r($this->routes, true));

        // Buscamos si la ruta existe
        foreach ($this->routes[$method] ?? [] as $route => $routeData) {

            // Extraemos los datos registrados
            $callback = $routeData['callback'];
            $middlewares = $routeData['middlewares'];

            // Convertimos la ruta registrada (ej. /proyectos/{id}) en una expresión regular
            $routeRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $route);
            $routeRegex = "#^" . $routeRegex . "$#";

            if (preg_match($routeRegex, $uri, $matches)) {
                array_shift($matches); // Quitamos la coincidencia completa, dejamos solo las variables

                foreach ($middlewares as $middleware) {
                    $instancia = new $middleware();
                    $instancia->handle();
                }

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
