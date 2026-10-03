<?php
// public/index.php

// 1. Constante de seguridad: Impide que otros archivos sean accedidos directamente por URL
define('APP_RUNNING', true);

// 2. Definir rutas absolutas base para facilitar las inclusiones
define('BASE_PATH', dirname(__DIR__));


//3. Cargar dependencias de Composer si existen
if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require_once BASE_PATH . '/vendor/autoload.php';
}

// 4. Cargar Variables de Entorno (.env)
if (file_exists(BASE_PATH . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
    $dotenv->load();
}

// 5. Configurar el entorno de desarrollo o producción
$entorno = $_ENV['APP_ENV'] ?? 'production';

if ($entorno === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    // En producción, apagamos la impresión de errores en pantalla para evitar fuga de datos
    ini_set('display_errors', 0);
    error_reporting(0);
}

// 6. Cargar y registrar tu Autoloader manual
require_once BASE_PATH . '/core/Autoloader.php';
Core\Autoloader::register();

Core\Session::start();

// 7. Iniciar el enrutador
$router = new \Core\Router();

// 8. Cargar el archivo de rutas
require_once BASE_PATH . '/routes/web.php';
require_once BASE_PATH . '/routes/admin.php';
require_once BASE_PATH . '/routes/api/v1/api.php';


$router->resolve();
