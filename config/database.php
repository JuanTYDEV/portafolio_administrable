<?php
// config/database.php
if (!defined('APP_RUNNING')) die("Acceso denegado.");

return [
    'host'     => $_ENV['DB_HOST'] ?? 'localhost',
    'dbname'   => $_ENV['DB_NAME'] ?? 'porfolio_db',
    'username' => $_ENV['DB_USER'] ?? 'root',
    'password' => $_ENV['DB_PASS'] ?? ''
];
    