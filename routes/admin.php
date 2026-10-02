<?php
// routes/admin.php
if (!defined('APP_RUNNING')) {
    // routes/admin.php
    http_response_code(404);
    exit;
}

/** @var \Core\Router $router */
use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\FinanzasController;

// Prefijo /panel para todo el sistema de administración
/* $router->get('/panel/login', [AuthController::class, 'login']);
$router->post('/panel/login', [AuthController::class, 'procesarLogin']);

$router->get('/panel/dashboard', [DashboardController::class, 'index']);
$router->get('/panel/finanzas', [FinanzasController::class, 'index']); */