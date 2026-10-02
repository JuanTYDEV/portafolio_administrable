<?php
// views/admin/layout/auth.php
if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

use App\Helpers\UrlHelper;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="<?php echo UrlHelper::asset_url('assets/admin/css/auth/style.css'); ?>">
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <h2>Bienvenido</h2>
            <p>Por favor, ingresa tus datos para continuar.</p>

            <?php echo $contenido ?? ""; ?>

        </div>
    </div>
</body>

</html>