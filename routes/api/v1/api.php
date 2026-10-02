<?php
// routes/api/v1/api.php
if (!defined('APP_RUNNING')) {
    // routes/api/v1/api.php
    http_response_code(404);
    exit;
}

/** @var \Core\Router $router */
use App\Controllers\Api\PaymentController;
use App\Controllers\Api\ComentariosController;

// Las rutas de API normalmente llevan el prefijo /api/v1/ para versionarlas
/* $router->post('/api/v1/mercadopago/webhook', [PaymentController::class, 'webhook']);
$router->post('/api/v1/comentarios/nuevo', [ComentariosController::class, 'crear']);
$router->get('/api/v1/clientes/buscar', [ComentariosController::class, 'buscarClienteAjax']); */