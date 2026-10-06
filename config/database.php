<?php
// config/database.php
if (!defined('APP_RUNNING')) die("Acceso denegado.");

return [
    'host'     => $_ENV['DB_HOST'] ?? 'database',
    'dbname'   => $_ENV['DB_NAME'] ?? 'portafolio',
    'username' => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASSWORD'] ?? ''
];
    