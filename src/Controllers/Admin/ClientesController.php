<?php

namespace App\Controllers\Admin;

use App\Models\ClientesModel;
use App\Controllers\ControllerBase;

if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

class ClientesController extends ControllerBase
{
    private $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClientesModel();
    }

    // GET /api/v1/clientes
    public function index()
    {
        $clientes = $this->clienteModel->findAll();
        return $this->json($clientes);
    }

    // POST /api/v1/clientes
    public function store()
    {
        $datos = [
            'nombre' => $this->input('nombre'),
            'email'  => $this->input('email'),
            'telefono' => $this->input('telefono')
        ];

        $id = $this->clienteModel->create($datos);

        return $this->json(['mensaje' => 'Cliente creado', 'id' => $id], 201);
    }

    // PUT /api/v1/clientes/{id}
    public function update($id)
    {
        $datos = [
            'nombre' => $this->input('nombre')
        ];

        $this->clienteModel->update($id, $datos);

        return $this->json(['mensaje' => 'Cliente actualizado correctamente']);
    }

    // DELETE /api/v1/clientes/{id}
    public function destroy($id)
    {
        $this->clienteModel->delete($id);
        return $this->json(['mensaje' => 'Cliente eliminado']);
    }
}
