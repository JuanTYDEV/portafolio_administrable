<?php
// routes/web.php
if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

/** @var \Core\Router $router */

use App\Controllers\Web\InicioController;


// Rutas de clientes que ven la página principal
$router->get('/', [InicioController::class, 'index']);
$router->get('/inicio', [InicioController::class, 'index']);
$router->get('/portafolio', [InicioController::class, 'portafolio']);
$router->get('/contacto', [InicioController::class, 'contacto']);
