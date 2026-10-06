<?php if (!defined('APP_RUNNING')) die("Acceso denegado."); ?>
<div class="main-header">
    <div class="main-header-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>

            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>

        </div>
        <!-- End Logo Header -->
    </div>

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">

        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">

                <?php
                $text = Core\Session::get('admin_nombre', "Sin usuario");
                $btnClose = "#";
                $image = "https://ionicframework.com/docs/img/demos/avatar.svg";
                $mail = Core\Session::get('admin_email', null);

                ?>

                <li class="nav-item topbar-user dropdown hidden-caret">
                    <!--Imagen y nombre del usuario -->
                    <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="<?php echo htmlspecialchars(strpos($image, 'http') === 0 ? $image : App\Helpers\UrlHelper::base_url(str_replace('./', '', $image))); ?>" alt="..." class="avatar-img rounded-circle">
                        </div>
                        <span class="profile-username">
                            <span class="op-7">Hola,</span> <span class="fw-bold"><?= htmlspecialchars($text); ?></span>
                        </span>
                    </a>
                    <!-- Lista de opciones para los usuarios -->
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <div class="user-box">
                                    <div class="avatar-lg">
                                        <img src="<?php echo htmlspecialchars(strpos($image, 'http') === 0 ? $image : App\Helpers\UrlHelper::base_url(str_replace('./', '', $image))); ?>" alt="image profile" class="avatar-img rounded">
                                    </div>
                                    <div class="u-text">
                                        <h4><?= htmlspecialchars($text); ?></h4>
                                        <p class="text-muted"><?php echo htmlspecialchars($mail ?? "Sin correo registrado"); ?></p>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-divider"></div>
                                <a
                                    class="dropdown-item"
                                    href="<?php echo App\Helpers\UrlHelper::base_url('/panel/logout'); ?>"
                                    id="btn-logout">
                                    Logout
                                </a>

                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>