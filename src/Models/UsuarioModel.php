<?php
namespace App\Models;

if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

class UsuarioModel extends ModelBase
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario'; // Cambia si tu ID se llama diferente

    // Aquí puedes agregar métodos específicos que no sean CRUD básico
    public function buscarPorEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

}