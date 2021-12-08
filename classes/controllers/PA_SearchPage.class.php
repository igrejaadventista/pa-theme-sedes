<?php

class IASD_SearchPage
{
  public function __construct()
  {
    add_filter('init', array($this, 'IASD_SearchPageFilter'));
  }

  public static function IASD_SearchPageFilter()
  {
    $page = "/busca/";
    $page = get_page_by_path($page);

    if (!$page) {
      
      $new_page = array(
        'post_content'   => '',
        'post_name'      => 'busca',
        'post_title'     => 'Busca',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'post_author'    => get_current_user_id(),
        'page_template'  => 'page-busca.php'
      );
      $page_id = wp_insert_post($new_page);
    }
  }
}

$IASD_SearchPage = new IASD_SearchPage();
