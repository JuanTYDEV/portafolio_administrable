<?php

namespace App\Models;

use Core\Database;
use PDO;

if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

abstract class ModelBase
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct()
    {
        // Instancia la conexión a PDO mediante el patrón Singleton
        $this->db = Database::getConnection();
    }

    /**
     * Obtiene todos los registros de la tabla.
     */
    public function findAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Busca un registro específico por su llave primaria.
     */
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Inserta un nuevo registro armando dinámicamente los placeholders.
     * 
     * @param array $data Array asociativo ['columna' => 'valor']
     * @return string|false El ID insertado o false
     */
    public function create(array $data)
    {
        $columnas = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ({$columnas}) VALUES ({$placeholders})";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return $this->db->lastInsertId();
    }

    /**
     * Actualiza un registro existente dinámicamente.
     */
    public function update($id, array $data)
    {
        $campos = '';
        foreach ($data as $key => $value) {
            $campos .= "{$key} = :{$key}, ";
        }
        $campos = rtrim($campos, ', ');

        $sql = "UPDATE {$this->table} SET {$campos} WHERE {$this->primaryKey} = :pk_id";

        // Agregamos el ID al array de datos con un nombre seguro para evitar choques
        $data['pk_id'] = $id;

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * Elimina un registro.
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
