<?php

class PaThemeHelpers
{

  public function __construct()
  {
    add_action('wp_head', [$this, 'generate_datalayer_meta'] );
    add_action('after_setup_theme', [$this, 'themeSupport']);
    add_action('wp_enqueue_scripts', [$this, 'registerAssets']);
    add_action('admin_enqueue_scripts', [$this, 'registerAssetsAdmin']);
    add_filter('nav_menu_css_class', [$this, 'specialNavClass'], 10, 2);
    add_filter('after_setup_theme', [$this, 'getInfoLang'], 10, 2);
    add_filter('body_class', [$this, 'bodyClass']);
    add_action('PA-update_menu_global', [$this, 'setGlobalMenu']);
    add_action('PA-update_banner_global', [$this, 'setGlobalBanner']);
    add_action('rest_api_init', [$this, 'adding_collection_meta_rest']);
    add_action( 'customize_register', [$this, 'customizer_custom_logo_label'], 20 );

    if (!wp_next_scheduled('PA-update_menu_global')) {
      wp_schedule_event(time(), 'daily', 'PA-update_menu_global');
    }

    if (!wp_next_scheduled('PA-update_banner_global')) {
      wp_schedule_event(time(), 'daily', 'PA-update_banner_global');
    }

    add_action('init', 'wp_rest_headless_boot_plugin', 9 );
    add_filter('wp_headless_rest__disable_front_end', '__return_false');
    add_filter('run_wptexturize', '__return_false');

    define('LANG', $this->getInfoLang());
  }

  function themeSupport()
  {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('custom-logo', array(
      // 'height'      => 109,  
      // 'width'       => 204,  
      'flex-height' => false,
      'flex-width'  => false,
      'crop'        => true  
    ));;

    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    load_theme_textdomain('iasd', get_template_directory() . '/language/');

    // Remove from TinyMCE
    // add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );

    global $content_width;
    if (!isset($content_width)) {
      $content_width = 856;
    }
  }

  function registerAssets()
  {
    wp_enqueue_style('bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', null, null);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap', null, null);
    wp_enqueue_style('pa-theme-sedes-style', get_template_directory_uri() . '/style.css', null, null);
    wp_enqueue_style('pa-theme-sedes-print', get_template_directory_uri() . '/print.css', null, null);

    wp_enqueue_script('fontawesome-js', 'https://kit.fontawesome.com/c992dc3e78.js', array(), false, false);
    wp_enqueue_script('scripts', get_template_directory_uri() . '/assets/js/script.js', array(), false, true);
  }

  function registerAssetsAdmin()
  {
    wp_enqueue_script('scripts-admin', get_template_directory_uri() . '/assets/scripts/script_admin.js', array(), false, true);
  }

  function specialNavClass($classes)
  {
    if (in_array('current-menu-item', $classes)) {
      $classes[] = 'active ';
    }
    return $classes;
  }

  function getInfoLang()
  {
    if (defined('WPLANG')) {
      $lang = WPLANG;
    } elseif (get_locale()) {
      $lang = get_locale();
    }
    $lang = substr($lang, 0, 2);
 
    return $lang;
  }

  function adding_collection_meta_rest()
  {
    register_rest_field(
      'post',
      'featured_media_url',
      array(
        'get_callback' => function ($post) {
          $img_id = get_post_thumbnail_id($post['id']);

          return array(
            'full' => wp_get_attachment_image_src($img_id, '')[0],
            'medium' => wp_get_attachment_image_src($img_id, 'medium_large')[0],
            'small' => wp_get_attachment_image_src($img_id, 'thumbnail')[0],
            'pa-block-preview' => wp_get_attachment_image_src($img_id, 'thumbnail')[0],
            'pa-block-render' => wp_get_attachment_image_src($img_id, 'medium')[0]
          );
        },
        'update_callback'   => null,
        'schema'            => null,
      )
    );
  }

  /**
   * getGlobalMenu Get global menu by name
   *
   * @param  string $name The menu name
   * @return mixed Menu data or null
   */
  static function getGlobalMenu(string $name)
  {

    if (empty($name)) {
      return null;
    }

    if (!get_option('menu_' . $name)) {
      self::setGlobalMenu();
    }

    return get_option('menu_' . $name);
  }

  static function setGlobalMenu()
  {
    $menus = ['global-header', 'global-footer'];

    foreach ($menus as $name) {
     $file_path = "https://" . API_PA . "/tax/" . LANG . "/menus/{$name}";

     if (file_exists($file_path) && is_readable($file_path)) {
      $json = file_get_contents( $file_path);   
      $json_content = json_decode($json);
          update_option('menu_' . $name, $json_content, '', 'yes');
     }     
    }
  }

  static function getGlobalBanner()
  {

    if (!get_option('banner_global')) {
      self::setGlobalBanner();
    }
    return get_option('banner_global');
  }

  static function setGlobalBanner()
  {
    $file_path = "https://" . API_PA . "/tax/" . LANG . "/banner";
    
    if (file_exists($file_path) && is_readable($file_path)) {
      $json = file_get_contents($file_path);
      $json_content = json_decode($json);
      update_option('banner_global', $json_content, '', 'yes');
    }    
  }

  function bodyClass($classes)
  {

    if (get_field('departamento', 'option')) {
      $classes[] = get_field('departamento', 'option');
    }

    $classes[] = LANG;

    return $classes;
  }

  static function pageNumbers()
  {

    if (is_singular())
      return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1)
      return;

    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max   = intval($wp_query->max_num_pages);

    /** Add current page to the array */
    if ($paged >= 1)
      $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ($paged >= 3) {
      $links[] = $paged - 1;
      $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
      $links[] = $paged + 2;
      $links[] = $paged + 1;
    }

    echo '<ul class="d-flex justify-content-center">' . "\n";

    /** Previous Post Link */
    if (get_previous_posts_link())
      printf('<li class="pa-post-prev m-0">%s</li>' . "\n", get_previous_posts_link('<i class="fas fa-arrow-left"></i>'));

    /** Link to first page, plus ellipses if necessary */
    if (!in_array(1, $links)) {
      $class = 1 == $paged ? ' class="active"' : '';

      printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

      if (!in_array(2, $links))
        echo '<li class="list-inline-item">…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array) $links as $link) {
      $class = $paged == $link ? ' class="active"' : '';
      printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    }

    /** Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
      if (!in_array($max - 1, $links))
        echo '<li class="list-inline-item">…</li>' . "\n";

      $class = $paged == $max ? ' class="active"' : '';
      printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    }

    /** Next Post Link */
    if (get_next_posts_link())
      printf('<li class="pa-post-next align-self-end">%s</li>' . "\n", get_next_posts_link('<i class="fas fa-arrow-right"></i>'));

    echo '</ul>' . "\n";
  }

  function generate_datalayer_meta() {
    if (is_singular('post')) {
      $terms = [
        'xtt-pa-format' => 'pa_formato_post',
        'xtt-pa-regiao' => 'pa_regiao',
        'xtt-pa-projetos' => 'pa_projeto',
        'xtt-pa-departamentos' => 'pa_departamento',
        'xtt-pa-editorias' => 'pa_editoriais',
        'xtt-pa-owner' => 'pa_sedes_proprietarias',
        'xtt-pa-sedes' => 'pa_sedes_regionais',
      ];
      
      $data = [
        'pa_autor' => get_the_author(),
      ];
  
      foreach ($terms as $taxonomy => $name) {
        $terms_array = wp_get_object_terms(get_the_ID(), $taxonomy, ['fields' => 'names']);
        if (!is_wp_error($terms_array) && !empty($terms_array)) {
          $data[$name] = implode(", ", $terms_array);
        }
      }
  
      foreach ($data as $name => $content) {
        echo '<meta name="' . esc_attr($name) . '" content="' . esc_attr($content) . '">';
      }
    }
  }

  public function customizer_custom_logo_label( $wp_customize )
  {
    $logo_control = $wp_customize->get_control( 'custom_logo' );

    if ( ! empty( $logo_control ) ) {
      $logo_control->label = 'Logo - Tamanho recomendado 240x109';
    }
  }
}
$PaThemeHelpers = new PaThemeHelpers();
