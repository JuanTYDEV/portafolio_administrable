<?php
namespace App\Controllers\Admin;

use App\Controllers\ControllerBase;
use App\Models\UsuarioModel;

if (!defined('APP_RUNNING')) die("Acceso denegado.");

class UsuariosController extends ControllerBase
{
    // Procesa el registro por fetch (POST)
    public function registrar()
    {
        $nombre = $this->input('nombre');
        $email = $this->input('email');
        $passwordPlana = $this->input('password');

        if (!$nombre || !$email || !$passwordPlana) {
            return $this->json(['exito' => false, 'mensaje' => 'Faltan datos.'], 400);
        }

        $usuarioModel = new UsuarioModel();

        // Verificar si el correo ya existe
        if ($usuarioModel->buscarPorEmail($email)) {
            return $this->json(['exito' => false, 'mensaje' => 'El correo ya está registrado.'], 400);
        }

        // ENCRIPTACIÓN DE CONTRASEÑA (El paso más importante)
        $passwordHash = password_hash($passwordPlana, PASSWORD_BCRYPT, ['cost' => 12]);

        $usuarioModel->create([
            'nombre' => $nombre,
            'email' => $email,
            'password' => $passwordHash,
            'rol' => 'admin'
        ]);

        return $this->json(['exito' => true, 'mensaje' => 'Usuario administrador creado correctamente.'], 201);
    }
}