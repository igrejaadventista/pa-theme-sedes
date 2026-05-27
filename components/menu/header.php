<?php
$sede = getSiteInfo();
$menu_global = PaThemeHelpers::getGlobalMenu('global-header');
$languages = [];
$current_language = null;
$current_language_index = 0;
$language_icon_src = function ($url) {
  if (strpos($url, 'data:image/svg+xml') === 0) {
    return esc_attr($url);
  }

  return esc_url($url);
};
$language_flag_icon_url = function ($code) {
  $code = strtolower($code);
  $code = $code === 'pt' ? 'br' : $code;

  if (!preg_match('/^[a-z0-9-]+$/', $code)) {
    return '';
  }

  return 'https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.5.0/flags/4x3/' . $code . '.svg';
};
$default_language_icons = [
  'br' => $language_flag_icon_url('br'),
  'es' => $language_flag_icon_url('es'),
];
$default_languages = [
  [
    'name' => 'PT',
    'url' => '/pt',
    'icon_url' => $default_language_icons['br'],
    'icon_alt' => 'PT',
    'path' => '/pt/',
  ],
  [
    'name' => 'ES',
    'url' => '/es',
    'icon_url' => $default_language_icons['es'],
    'icon_alt' => 'ES',
    'path' => '/es/',
  ],
];

if (class_exists('\IASD\Core\Settings\Modules') && \IASD\Core\Settings\Modules::isActiveModule('language_selector')) {
  $language_settings = get_field('ct_languages', 'pa_settings');
  $current_path = wp_parse_url(wp_unslash($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH) ?: '/';
  $current_path = trailingslashit($current_path);

  foreach (($language_settings ?: []) as $language) {
    $icon = $language['icon'] ?? [];
    $icon_url = is_array($icon) ? ($icon['url'] ?? '') : '';
    $icon_alt = is_array($icon) ? ($icon['alt'] ?? '') : '';
    $language_name = $language['name'] ?? '';
    $language_url = $language['url'] ?? '';
    $language_path = wp_parse_url($language_url, PHP_URL_PATH) ?: $language_url;
    $language_path = trailingslashit('/' . ltrim($language_path, '/'));
    $default_icon_key = strtolower(is_string($icon) ? $icon : $language_name);
    $default_icon_key = $default_icon_key === 'pt' ? 'br' : $default_icon_key;
    $icon_url = $icon_url ?: ($default_language_icons[$default_icon_key] ?? $language_flag_icon_url($default_icon_key));

    if (empty($language_name) || empty($language_url) || empty($icon_url)) {
      continue;
    }

    $languages[] = [
      'name' => $language_name,
      'url' => $language_url,
      'icon_url' => $icon_url,
      'icon_alt' => $icon_alt ?: $language_name,
      'path' => $language_path,
    ];
  }

  if (empty($languages)) {
    $languages = $default_languages;
  }

  foreach ($languages as $index => $language) {
    if (strpos($current_path, $language['path']) === 0) {
      $current_language_index = $index;
      break;
    }
  }

  $current_language = $languages[$current_language_index] ?? null;
}

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

            <?php if (!empty($current_language) && !empty($languages)) { ?>
              <li class="nav-item dropdown pa-menu-lang">
                <a class="nav-link dropdown-toggle pa-search" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <img class="pa-menu-lang-icon me-2" src="<?= $language_icon_src($current_language['icon_url']); ?>" alt="<?= esc_attr($current_language['icon_alt']); ?>">
                  <?= esc_html($current_language['name']); ?>
                </a>
                <ul class="dropdown-menu p-0">
                  <?php foreach ($languages as $language) : ?>
                    <li><a class="dropdown-item" href="<?= esc_url($language['url']); ?>"><img class="pa-menu-lang-icon me-2" src="<?= $language_icon_src($language['icon_url']); ?>" alt="<?= esc_attr($language['icon_alt']); ?>"> <?= esc_html($language['name']); ?></a></li>
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
        <i class="fas fa-bars fa-2x" aria-hidden="true" onclick="window.Menus.pa_action_menu()"></i>
      </div>

      <div class="menu" id="pa_menu">
        <ul class="menu_sub">
          <?php if (!empty($current_language) && !empty($languages)) { ?>
            <li class="pa-dropdown">
              <a href="#" onclick="event.preventDefault();"><img class="pa-menu-lang-icon" src="<?= $language_icon_src($current_language['icon_url']); ?>" alt="<?= esc_attr($current_language['icon_alt']); ?>"> <?= esc_html($current_language['name']); ?></a>
              <div class="pa-sub-dropdown">
                <ul>
                  <?php
                  foreach ($languages as $index => $language) :
                    if ($index === $current_language_index) continue;
                  ?>
                    <li><a href="<?= esc_url($language['url']); ?>"><img class="pa-menu-lang-icon" src="<?= $language_icon_src($language['icon_url']); ?>" alt="<?= esc_attr($language['icon_alt']); ?>"> <?= esc_html($language['name']); ?></a></li>
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
