<?php
class PaMenuMobile
{
  function __construct($menu, $menu_global = [])
  {
    $menu = self::getMenuArray(self::getDefaultMenu($menu));
    echo '<ul class="menu_inf">';
    self::getMenuGlobal($menu_global);
    foreach ($menu as $m) {
      echo '<li class="' . (empty($m['children']) ? "" : "pa-dropdown") . '"><a href="' . ($m['url'] != "" ? $m['url'] : "#") . '">' . $m['title'] . '</a>';
      self::getMenuChild($m['children']);
      echo '</li>';
    }
    echo "</ul>";
  }

  static function getMenuArray($current_menu)
  {

    $menu_array = wp_get_nav_menu_items($current_menu);

    $menu = array();

    function populate_children($menu_array, $menu_item)
    {
      $children = array();
      if (!empty($menu_array)) {
        foreach ($menu_array as $k => $m) {
          if ($m->menu_item_parent == $menu_item->ID) {
            $children[$m->ID] = array();
            $children[$m->ID]['ID'] = $m->ID;
            $children[$m->ID]['title'] = $m->title;
            $children[$m->ID]['url'] = $m->url;
            unset($menu_array[$k]);
            $children[$m->ID]['children'] = populate_children($menu_array, $m);
          }
        }
      }
      return $children;
    }

    if (!empty($menu_array)) {
      foreach ($menu_array as $m) {
        if (empty($m->menu_item_parent)) {
          $menu[$m->ID] = array();
          $menu[$m->ID]['ID'] = $m->ID;
          $menu[$m->ID]['title'] = $m->title;
          $menu[$m->ID]['url'] = $m->url;
          $menu[$m->ID]['children'] = populate_children($menu_array, $m);
        }
      }
    }

    return $menu;
  }

  static function getDefaultMenu($wp_menu)
  {
    $menuLocations = get_nav_menu_locations();
    return $menuLocations[$wp_menu];
  }

  static function getMenuChild($child)
  {
    if (!empty($child)) {
      echo '<div class="pa-sub-dropdown"><ul>';
      foreach ($child as $m2) {
        echo '<li><a href="' . $m2['url'] . '">' . $m2['title'] . '</a></li>';
      }
      echo '</ul></div>';
    }
  }

  static function getMenuGlobal($menu_global)
  {

    if (!empty($menu_global) && isset($menu_global->itens) && !empty($menu_global->itens)) : ?>

      <li class="pa-dropdown">
        <a href="#">Adventistas.org</a>
        <div class="pa-sub-dropdown">
          <ul>
            <?php foreach ($menu_global->itens as $item) : ?>
              <li>
                <a href="<?= $item->url ?>" target="<?= !empty($item->target) ? $item->target : '_self' ?>" title="<?= $item->title ?>"><?= $item->title ?></a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </li>
<?php endif;
  }
}
