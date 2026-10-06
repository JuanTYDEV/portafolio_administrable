<?php
// routes/admin.php
if (!defined('APP_RUNNING')) {
    // routes/admin.php
    http_response_code(404);
    exit;
}

/** @var \Core\Router $router */

use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\UsuariosController;
use App\Controllers\Admin\PanelController;
use App\Middlewares\AuthMiddleware;

// Prefijo /panel para todo el sistema de administración
$router->get('/panel/login', [AuthController::class, 'login']);
$router->post('/api/v1/auth/login', [AuthController::class, 'procesarLogin']);
$router->get('/panel/logout', [AuthController::class, 'logout']);



// 2. RUTAS PROTEGIDAS DEL PANEL (Llevan el AuthMiddleware)
$middlewaresAdmin = [AuthMiddleware::class];

// Le pasamos el arreglo con los middlewares como tercer parámetro
$router->get('/panel', [PanelController::class, 'index'], $middlewaresAdmin);

$router->get('/panel/usuarios', [PanelController::class, 'usuarios'], $middlewaresAdmin);
$router->get('/panel/proyectos', [PanelController::class, 'proyectos'], $middlewaresAdmin);
$router->get('/panel/settings', [PanelController::class, 'configuracion'], $middlewaresAdmin);
$router->get('/panel/permisos', [PanelController::class, 'permisos'], $middlewaresAdmin);
$router->get('/panel/datos', [PanelController::class, 'datos'], $middlewaresAdmin);
$router->get('/panel/finanzas', [PanelController::class, 'finanzas'], $middlewaresAdmin);

$router->post('/api/v1/usuarios/registrar', [UsuariosController::class, 'registrar'], $middlewaresAdmin);


// RUTA TEMPORAL (Borrar después de usar)
/* $router->get('/generar-hash', function () {
    $mi_contrasena_plana = "1234567890";
    echo password_hash($mi_contrasena_plana, PASSWORD_BCRYPT, ['cost' => 12]);
}); */