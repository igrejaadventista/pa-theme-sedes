<?php 

class PaThemeHelpers {

	public function __construct(){
		add_action('after_setup_theme', [$this, 'themeSupport'] );
		add_action('wp_enqueue_scripts', [$this, 'registerAssets'] );
		add_action('admin_enqueue_scripts', [$this, 'registerAssetsAdmin'] );
		add_filter('nav_menu_css_class' , [$this, 'specialNavClass'], 10 , 2);
		add_filter('after_setup_theme' , [$this, 'getInfoLang'], 10 , 2);
		add_filter('body_class', [$this, 'bodyClass'] );
		add_action('init', [$this, 'unregisterTaxonomy'] );
		add_action('PA-update_menu_global', [$this, 'setGlobalMenu']);
		add_action('PA-update_banner_global', [$this, 'setGlobalBanner']);

		if ( ! wp_next_scheduled( 'PA-update_menu_global' ) ) {
			wp_schedule_event( time(), 'hourly', 'PA-update_menu_global' );
		}

		if ( ! wp_next_scheduled( 'PA-update_banner_global' ) ) {
			wp_schedule_event( time(), 'hourly', 'PA-update_banner_global' );
		}

		define( 'LANG', $this->getInfoLang() );
	}

	function themeSupport() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio') );
		
		remove_action( 'wp_head', 'wp_generator');
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		load_theme_textdomain('iasd', get_template_directory() . '/language/');

		// Remove from TinyMCE
		// add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 856;
		}
	}

	function unregisterTaxonomy() {
		global $wp_taxonomies;
		$taxonomy = array('category', 'post_tag');
		foreach ($taxonomy as &$value) {
			if ( taxonomy_exists($value) ){
				unset( $wp_taxonomies[$value] );
			}
		}
	}

	function registerAssets() {
		wp_enqueue_style( 'bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css', null, null);
		wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap', null, null);
		wp_enqueue_style( 'pa-theme-sedes-style', get_template_directory_uri(). '/style.css', null, null);
		wp_enqueue_style( 'pa-theme-sedes-print', get_template_directory_uri() . '/print.css', null, null);
	
		wp_enqueue_script( 'fontawesome-js', 'https://kit.fontawesome.com/c992dc3e78.js', array(), false, false );
		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/script.js', array(), false, true );
	}
	
	function registerAssetsAdmin() {
		wp_enqueue_script( 'scripts-admin', get_template_directory_uri() . '/assets/scripts/script_admin.js', array(), false, true );
	}

	function specialNavClass($classes){
		if( in_array('current-menu-item', $classes) ){
				$classes[] = 'active ';
		}
		return $classes;
	}

	function getInfoLang(){	
		if(defined('WPLANG')){
			$lang = WPLANG;
		} elseif (get_locale()){
			$lang = get_locale();
		}
		$lang = substr($lang, 0,2);

		return $lang;
	}

	/**
	 * getGlobalMenu Get global menu by name
	 *
	 * @param  string $name The menu name
	 * @return mixed Menu data or null
	 */
	static function getGlobalMenu(string $name) {
		if(empty($name)){
			return null;
		}
			
		if (!get_option('menu_'.$name)){
			// $this->setGlobalMenu();
		}

		return get_option('menu_'.$name);
	}

	function setGlobalMenu() {
		$menus = ['global-header', 'global-footer'];

		foreach($menus as $name) {
			$json = file_get_contents( "https://". API_PA ."/tax/". LANG ."/menus/{$name}");
			$json_content = json_decode($json);
			add_option('menu_'.$name, $json_content, '', 'yes');
		}
	}

	static function getGlobalBanner() {
		if (!get_option('banner_global')){
			// $this->setGlobalMenu();
		}

		return get_option('banner_global');
	}

	function setGlobalBanner() {
		$json = file_get_contents( "https://". API_PA ."/tax/". LANG ."/banner");
		$json_content = json_decode($json);
		add_option('banner_global', $json_content, '', 'yes');
	}
	
	function bodyClass( $classes ) {

		if (get_field('departamento', 'option')){
			$classes[] = get_field('departamento', 'option');
		}

		$classes[] = LANG;
		
		return $classes;	
	}
}
$PaThemeHelpers = new PaThemeHelpers();