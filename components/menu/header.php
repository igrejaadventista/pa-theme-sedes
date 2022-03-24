<?php
$sede = getSiteInfo();
$menu_global = PaThemeHelpers::getGlobalMenu('global-header');
$relative_site = network_site_url("", "relative");
$relative_sites = [
  '/pt/' => 'PT',
  '/es/' => 'ES'
];

?>

<header class="pa-menu" id="topo">
  <div class="pa-menu-desktop container d-none d-xl-block">
    <div class="row g-0 h-100">
      <?php get_template_part('components/menu/header-logo', 'logo'); ?>
      <div class="col d-flex flex-column justify-content-between">
        <nav class="pa-menu-global navbar navbar-expand-lg justify-content-end">
          <ul class="navbar-nav">
            <?php if (!empty($menu_global) && isset($menu_global->itens) && !empty($menu_global->itens)) : ?>
              <?php foreach ($menu_global->itens as $item) : ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?= $item->url ?>" title="<?= $item->title ?>" target="<?= !empty($item->target) ? $item->target : '_self' ?>"><?= $item->title ?></a>
                </li>
              <?php endforeach; ?>
              <li class="nav-item">
                <a class="nav-link pa-search" href="<?= get_home_url(); ?>/busca" title="<?php esc_attr_e('Search', 'iasd'); ?>"><i class="fas fa-search me-1"></i><?php esc_attr_e('Search', 'iasd'); ?></a>
              </li>
            <?php endif; ?>

            <?php if (defined('PA_LANG') && PA_LANG == true) { ?>
              <li class="nav-item dropdown pa-menu-lang">
                <a class="nav-link dropdown-toggle pa-search" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="<?= strtolower($relative_sites[array_key_exists($relative_site, $relative_sites) ? $relative_site : array_key_first($relative_sites)]) ?> me-2" aria-hidden="true"></i>
                  <?= $relative_sites[array_key_exists($relative_site, $relative_sites) ? $relative_site : array_key_first($relative_sites)] ?>
                </a>
                <ul class="dropdown-menu p-0">
                  <?php foreach ($relative_sites as $key => $value) : ?>
                    <li class=""><a class="dropdown-item" href="<?= $key ?>"><i class="<?= strtolower($value) ?> me-2" aria-hidden="true"></i> <?= $value ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </li>
            <?php } ?>
          </ul>
        </nav>

        <?php
        wp_nav_menu(
          array(
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
      <?php if (!empty($sede)) : ?>
        <?php get_template_part('components/menu/header-logo', 'logo'); ?>
      <?php endif; ?>

      <div class="col-auto ms-auto d-flex flex-row-reverse align-items-center">
        <i class="fa fa-bars fa-2x" aria-hidden="true" onclick="window.Menus.pa_action_menu()"></i>
      </div>

      <div class="menu" id="pa_menu">
        <ul class="menu_sub">
          <?php if (defined('PA_LANG') && PA_LANG == true) { ?>
            <li class="pa-dropdown">
              <a href="#" onclick="event.preventDefault();" class="<?= strtolower($relative_sites[$relative_site]) ?>"><?= $relative_sites[$relative_site]  ?></a>
              <div class="pa-sub-dropdown">
                <ul>
                  <?php
                  foreach ($relative_sites as $key => $value) :
                    if ($key == $relative_site) continue;
                  ?>
                    <li><a href="<?= $key ?>" class="<?= strtolower($value) ?>"> <?= $value ?></a></li>
                  <?php
                  endforeach;
                  ?>
                </ul>
              </div>
            </li>
          <?php } ?>
          <li><img src="<?= get_template_directory_uri() . "/assets/imgs/close.svg" ?>" alt="" onclick="window.Menus.pa_action_menu()">
          </li>
        </ul>
        <?php
        $PA_Menu_Mobile = new PaMenuMobile('pa-menu-default', $menu_global);
        ?>
      </div>
      <div class="mask"></div>
    </div>
</header>
