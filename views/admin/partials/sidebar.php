<?php
if (!defined('APP_RUNNING')) {
	http_response_code(404);
	exit;
}

// Importamos la clase (El autoloader la buscará automáticamente)
use App\Helpers\MenuHelper;
use App\Helpers\UrlHelper;
use Core\Session;

$menuSidebar = Session::get('menu_sidebar', []);
$rutaActual = UrlHelper::current_path();
?>

<div class="sidebar" data-background-color="dark">
	<div class="sidebar-logo">
		<div class="logo-header" data-background-color="dark">
			<a href="<?php echo UrlHelper::base_url('/panel'); ?>" class="logo">
				<!-- <img src="<?php echo UrlHelper::asset_url('assets/images/assets_index/svg/logo.svg'); ?>" alt="navbar brand" class="navbar-brand" height="20"> -->
			</a>
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
	</div>

	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			<ul class="nav nav-secondary" tool="<?php echo $rutaActual ?>">

				<?php echo MenuHelper::generar($menuSidebar, $rutaActual); ?>

			</ul>
		</div>
	</div>
</div>