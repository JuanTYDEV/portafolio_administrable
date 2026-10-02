<?php

namespace App\Controllers\Admin;

use Core\View;

class PanelController
{
    public function index()
    {
        // Aquí puedes agregar la lógica para la página de inicio del panel de administración
        // Por ejemplo, podrías cargar datos desde un modelo y pasarlos a la vista

        // Renderizamos la vista usando tu motor basado en ob_start()
        View::render('admin/pages/inicio', [], 'admin/layout/app');
    }
}
