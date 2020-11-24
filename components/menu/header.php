<?php
	$campo = get_info_sedes();
	$lang = get_info_lang();
?>

<section class="pa-header-menu" id="topo">
	<header class="pa-menu-desktop container d-none d-xl-block">
		<div class="row g-0 h-100">
			<div class="col-auto d-flex align-items-center">
				<a href="<?= get_home_url(); ?>" class=""><img src="<?= get_template_directory_uri() . "/assets/sedes/" . $campo->slug . "/" . $lang . "/logo-iasd.svg" ?>" alt="<?= $campo->name ?>" title="<?= $campo->name ?>" class="img-fluid"></a>
			</div>
			<div class="col d-flex flex-column justify-content-between">
				<nav class="pa-menu-global ">
					<ul class="nav justify-content-end">
						<li class="nav-item">
							<a class="nav-link active" aria-current="page" href="#">Adventistas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Institucional</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Notícias</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Vídeos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Downloads</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Buscar</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">PT</a>
							<ul class="dropdown-menu">
								<li class="py-2"><a class="dropdown-item" href="#">PT</a></li>
								<li class="py-2"><a class="dropdown-item" href="#">ES</a></li>
							</ul>
						</li>
					</ul>              
				</nav>

				<?php
					wp_nav_menu(
						array (
							'theme_location'	=> 'pa-menu-default',
							'container_class'	=> 'pa-menu-default',
							'container'			=> 'nav',
							'container_id'		=> FALSE,
							'menu_class'		=> 'nav justify-content-end', 
							'menu_id'			=> FALSE,
							'depth'				=> 0,
							'walker'			=> new PaMenuWalker
						)
					);
				?>
			</div>
		</div>
	</header>

	<!-- Header Mobile -->
	<header class="pa-menu-mobile container-fluid d-xl-none">

		<div class="row g-0 pt-3 pb-3">
			<div class="col-6">
				<img src="<?= get_template_directory_uri() . "/assets/sedes/" . $campo->slug . "/". $lang . "/logo-iasd.svg" ?>" alt="<?= $campo->name ?>" title="<?= $campo->name ?>" class="img-fluid">
			</div>
			<div class="col d-flex flex-row-reverse align-items-center">
				<i class="fa fa-bars fa-2x" aria-hidden="true" onclick="pa_action_menu()" ></i>
			</div>

			<div class="menu" id="pa_menu">
				<ul class="menu_sub">
					<li class="pa-dropdown">
						<a href="#pt" class="pt">PT</a>
						<div class="pa-sub-dropdown">
							<ul>
								<li><a href="#es" class="es">ES</a></li>
							</ul>
						</div>
					</li>
					<li><img src="<?= get_template_directory_uri() . "/assets/imgs/close.svg" ?>" alt="" onclick="pa_action_menu()">
					</li>
				</ul>
				<?php 
					$PA_Menu_Mobile = new PaMenuMobile('pa-menu-default');
				?>
			</div>
			<div class="mask"></div>
	</header>
</section>