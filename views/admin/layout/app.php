<?php
if (!defined('APP_RUNNING')) {
    http_response_code(404);
    exit;
}

use App\Helpers\UrlHelper;
?>
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo $titulo_pagina ?? "Mi Sitio Web"; ?></title>
    <meta
        content="width=device-width, initial-scale=1.0, shrink-to-fit=no"
        name="viewport" />
    <link rel="shortcut icon" href="<?php echo UrlHelper::asset_url('assets/images/assets_index/svg/logo_hicon.svg'); ?>" type="image/svg+xml">
    <!-- Fonts and icons -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/webfont/webfont.min.js'); ?>"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?php echo UrlHelper::asset_url('assets/admin/css/core/fonts.min.css'); ?>"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo UrlHelper::asset_url('assets/admin/css/core/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo UrlHelper::asset_url('assets/admin/css/core/plugins.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo UrlHelper::asset_url('assets/admin/css/core/kaiadmin.min.css'); ?>" />
    <?php include __DIR__ . '/../partials/styles.php'; ?>
</head>

<body>
    <div class="wrapper sidebar_minimize">
        <!-- Sidebar -->
        <?php include __DIR__ . "/../partials/sidebar.php"; ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <!-- Navbar -->
            <?php include __DIR__ . '/../partials/topbar.php'; ?>

            <div class="container">
                <div class="page-inner">
                    <?php echo $contenido ?? ""; ?>

                </div>
            </div>

            <footer class="footer">
                <!-- 
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a target="_blank" class="nav-link" href="https://proyectosjfob.com/">
                                    Soporte
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                -->
            </footer>

        </div>
    </div>

    <div class="modal fade" id="globalDynamicModal" tabindex="-1" aria-labelledby="globalDynamicModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 15px 15px 0 0;">
                <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title" id="globalDynamicModalLabel">Título Dinámico</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center p-5" id="modalContentLoader">
                        <div class="spinner-border text-primary" role="status"><span class="sr-only">Cargando...</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--   Core JS Files   -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/core/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/core/popper.min.js'); ?>"></script>
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/core/bootstrap.min.js'); ?>"></script>
    <!-- jQuery Scrollbar -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js'); ?>"></script>
    <!-- Chart JS -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/chart.js/chart.min.js'); ?>"></script>
    <!-- jQuery Sparkline -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/jquery.sparkline/jquery.sparkline.min.js'); ?>"></script>
    <!-- Chart Circle -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/chart-circle/circles.min.js'); ?>"></script>
    <!-- Datatables -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/datatables/datatables.min.js'); ?>"></script>
    <!-- Bootstrap Notify -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/bootstrap-notify/bootstrap-notify.min.js'); ?>"></script>
    <!-- jQuery Vector Maps -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/jsvectormap/jsvectormap.min.js'); ?>"></script>
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/jsvectormap/world.js'); ?>"></script>
    <!-- Sweet Alert -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/plugin/sweetalert/sweetalert.min.js'); ?>"></script>
    <!-- Kaiadmin JS -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/kaiadmin.min.js'); ?>"></script>

    <!-- Scripts adicionales -->
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/script.js'); ?>"></script>
    <script src="<?php echo UrlHelper::asset_url('assets/admin/js/modal.js'); ?>"></script>


    <?php include __DIR__ . '/../partials/scripts.php'; ?>
</body>

</html>