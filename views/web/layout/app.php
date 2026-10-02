<?php if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
} ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? "Portafolio de Desarrollo Fullstack"; ?></title>
    <meta name="description" content="Portafolio de desarrollo fullstack con enfoque en backend. Proyectos, tecnologías y CV.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="assets/css/portafolio.css"> -->

    <!-- Incluimos los estilos desde un archivo separado para mantener la estructura limpia y organizada -->
    <?php include __DIR__ . '/../partials/styles.php'; ?>
</head>

<body>

    <!-- ==================== SITIO ==================== -->
    <div id="site">

        <!-- Navegación -->
        <header class="site-header" id="siteHeader">

            <!-- Incluimos la barra de navegación desde un archivo separado para mantener la estructura limpia y organizada -->
            <?php include __DIR__ . '/../partials/navbar.php'; ?>

        </header>

        <main>
            <!-- Contenido principal -->
            <?php echo $contenido ?? ""; ?>

        </main>

        <!-- Contacto / Footer -->
        <footer id="contacto" class="site-footer">
            <!-- Incluimos el footer desde un archivo separado para mantener la estructura limpia y organizada -->
            <?php include __DIR__ . '/../partials/footer.php'; ?>
        </footer>
    </div>

    <!-- ==================== CV imprimible (generado) ==================== -->
    <!-- Sección para el CV imprimible, que se genera dinámicamente y se oculta del usuario -->
    <div id="cv-print" aria-hidden="true"></div>

    <!-- ==================== SCRIPTS ==================== -->
    <?php include __DIR__ . '/../partials/scripts.php'; ?>
</body>

</html>