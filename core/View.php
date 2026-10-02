<?php

namespace Core;

class View
{
    /**
     * Renderiza una vista dentro de un layout.
     * 
     * @param string $vista  Ruta de la vista (ej. 'admin/pages/clientes/lista')
     * @param array  $datos  Variables a pasar a la vista
     * @param string $layout Ruta del layout (ej. 'admin/layouts/dashboard')
     */
    public static function render($vista = 'web/pages/inicio', $datos = [], $layout = 'web/layout/app')
    {         // 1. Extraemos el array para que las claves se conviertan en variables (ej.$titulo)
        extract($datos);

        // 2. Encendemos el búfer de salida (impide que se imprima HTML en el navegador todavía)
        ob_start();

        error_log("Renderizando vista: $vista con layout: $layout");
        
        // 3. Requerimos el archivo de la vista específica. Su HTML se guarda en la memoria.
        require __DIR__ . "/../views/{$vista}.php";
        
        // 4. Limpiamos la memoria y guardamos ese HTML en la variable $contenido
        $contenido = ob_get_clean();
        
        // 5. Finalmente, requerimos el layout base, el cual ya podrá hacer `echo $contenido;`
        require __DIR__ . "/../views/{$layout}.php";

    }
}
