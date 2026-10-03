<?php
// routes/admin.php
if (!defined('APP_RUNNING')) {
    // routes/admin.php
    http_response_code(404);
    exit;
}

/** @var \Core\Router $router */
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\PanelController;
use App\Middlewares\AuthMiddleware;

// Prefijo /panel para todo el sistema de administración
$router->get('/panel/login', [AuthController::class, 'login']);
$router->post('/panel/login', [AuthController::class, 'procesarLogin']);

$router->get('/panel/dashboard', [PanelController::class, 'index']);
// 2. RUTAS PROTEGIDAS DEL PANEL (Llevan el AuthMiddleware)
// Le pasamos el arreglo con los middlewares como tercer parámetro
$router->get('/panel/dashboard', [PanelController::class, 'index'], [AuthMiddleware::class]);
$router->get('/panel/usuarios', [PanelController::class, 'usuarios'], [AuthMiddleware::class]);
// $router->get('/panel/finanzas', [FinanzasController::class, 'index']);