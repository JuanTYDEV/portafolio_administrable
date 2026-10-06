<?php

namespace App\Models;

if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

class RolModel extends ModelBase
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';

    public function obtenerFechaActualizacion($id)
    {
        $stmt = $this->db->prepare("SELECT permisos_actualizados FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }
}
