<?php
// public/index.php

// 1. Constante de seguridad: Impide que otros archivos sean accedidos directamente por URL
define('APP_RUNNING', true);

// 2. Definir rutas absolutas base para facilitar las inclusiones
define('BASE_PATH', dirname(__DIR__));

// Mostrar errores (Solo para desarrollo, en producción debe ser 0)
ini_set('display_errors', 1);
error_reporting(E_ALL);

//3. Cargar dependencias de Composer si existen
if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require_once BASE_PATH . '/vendor/autoload.php';
}

// 4. Cargar y registrar tu Autoloader manual
require_once BASE_PATH . '/core/Autoloader.php';
Core\Autoloader::register();

// 5. Iniciar el enrutador
$router = new \Core\Router();

// 6. Cargar el archivo de rutas
require_once BASE_PATH . '/routes/web.php';
// require_once BASE_PATH . '/routes/admin.php';
// require_once BASE_PATH . '/routes/api/v1/api.php';


$router->resolve();
