<?php
    $campo = get_info_sedes();
    $lang = get_info_lang();
	$menu_global = PaThemeHelpers::getGlobalMenu('global-header');
?>

<header class="pa-menu" id="topo">
    <div class="pa-menu-desktop container d-none d-xl-block">
        <div class="row g-0 h-100">
            <div class="col-auto d-flex align-items-center">
                <a href="<?= get_home_url(); ?>" class="py-3 w-auto h-100">
                    <img src="<?= get_template_directory_uri() . "/assets/sedes/" . $lang . "/" . $campo->slug . ".svg" ?>" alt="<?= !empty($campo->name) ? $campo->name : '' ?>" title="<?= !empty($campo->name) ? $campo->name : '' ?>" class="h-100 w-auto">
                </a>
            </div>
            <div class="col d-flex flex-column justify-content-between">
				<nav class="pa-menu-global navbar navbar-expand-lg justify-content-end">
					<ul class="navbar-nav">
						<?php if(!empty($menu_global) && property_exists($menu_global, 'itens') && !empty($menu_global->itens)): ?>
							<?php foreach($menu_global->itens as $item): ?>
								<li class="nav-item">
									<a class="nav-link" href="<?= $item->url ?>" title="<?= $item->title ?>" target="<?= !empty($item->target) ? $item->target : '_self' ?>"><?= $item->title ?></a>
								</li>
							<?php endforeach; ?>
						<?php endif; ?>
						
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								PT
							</a>
							<ul class="dropdown-menu p-0">
								<li class=""><a class="dropdown-item" href="#">PT</a></li>
								<li class=""><a class="dropdown-item" href="#">ES</a></li>
							</ul>
						</li>
					</ul>
				</nav>

                <?php
                    wp_nav_menu(
                        array (
                            'theme_location'    => 'pa-menu-default',
                            'container_class'   => 'pa-menu-default',
                            'container'         => 'nav',
                            'container_id'      => false,
                            'menu_class'        => 'nav justify-content-end',
                            'menu_id'           => false,
                            'depth'             => 0,
                            'walker'            => new PaMenuWalker()
                        )
                    );
                    ?>
            </div>
        </div>
    </div>

    <!-- div Mobile -->
    <div class="pa-menu-mobile container-fluid d-xl-none">

        <div class="row g-0 pt-3 pb-3">
            <div class="col-6">
                <img src="<?= get_template_directory_uri() . "/assets/sedes/" . $lang . "/" . $campo->slug . ".svg" ?>" alt="<?= $campo->name ?>" title="<?= $campo->name ?>" class="">
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
    </div>
</header>