<?php

namespace Core;

use PDO;
use PDOException;

if (!defined('APP_RUNNING')) die("Acceso denegado.");

class Database
{
    // Esta propiedad estática guardará la conexión a PDO
    private static $conexion = null;

    // Constructor privado: evita que se instancie la clase múltiples veces
    private function __construct() {}

    // Método para obtener la conexión
    public static function getConnection()
    {
        // Si la conexión AÚN NO existe, nos conectamos
        if (self::$conexion === null) {

            // Traemos el array de credenciales de tu archivo de config
            $config = require __DIR__ . '/../config/database.php';

            try {
                // Armamos el string de conexión (DSN)
                $dsn = "mysql:host=" . $config['server'] . ";dbname=" . $config['name_database'] . ";charset=utf8mb4";

                // Creamos la instancia de PDO y la guardamos en la propiedad estática
                self::$conexion = new PDO($dsn, $config['name'], $config['password']);

                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                // Si la base de datos se cae, detenemos la app de forma controlada
                die("Error crítico: No se pudo conectar a la base de datos. " . $e->getMessage());
            }
        }

        // Retornamos la conexión (ya sea la nueva o la que ya estaba abierta)
        return self::$conexion;
    }
}
