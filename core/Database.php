<?php
// core/Database.php

namespace Core;

use PDO;
use PDOException;

if (!defined('APP_RUNNING')) die("Acceso denegado.");

class Database
{
    private static $conexion = null;

    private function __construct() {}

    public static function getConnection()
    {
        if (self::$conexion === null) {
            $config = require __DIR__ . '/../config/database.php';

            try {
                $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'] . ";charset=utf8mb4";

                self::$conexion = new PDO($dsn, $config['username'], $config['password']);

                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                // Opcional: Define el modo de retorno por defecto como Objetos o Arrays Asociativos
                self::$conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                // 1. Guardamos el error real en los logs internos del servidor
                error_log("Error crítico de Base de Datos: " . $e->getMessage());

                // 2. Le mostramos un mensaje genérico al mundo
                http_response_code(500);
                die("Error 500: Servicio temporalmente no disponible.");
            }
        }

        return self::$conexion;
    }
}
