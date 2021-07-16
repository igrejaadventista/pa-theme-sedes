<?php 

class PaThemeHelpers {

	public function __construct(){
		add_action( 'after_setup_theme', [$this, 'themeSupport'] );
		add_filter( 'the_content', [$this, 'addResponsiveCssClass'] );
		add_action( 'wp_enqueue_scripts', [$this, 'registerAssets'] );
		add_action( 'admin_enqueue_scripts', [$this, 'registerAssetsAdmin'] );
		add_action( 'init', [$this, 'unregisterTaxonomy'] );
	}

	function themeSupport() {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio') );
		
		remove_action('wp_head', 'wp_generator');
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		
		
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

	function addResponsiveCssClass($content){

		$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
		$document = new DOMDocument();
		libxml_use_internal_errors(true);
		if ($content){
			$document->loadHTML(utf8_decode($content));
		}

		$imgs = $document->getElementsByTagName('img');
		foreach ($imgs as $img) {
			$img->setAttribute('class','img-fluid');
		}

		return $document->saveHTML();
	}

	function registerAssets() {
		wp_enqueue_style( 'bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css', null, null);
		wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap', null, null);
		wp_enqueue_style( 'pa-theme-sedes-style', get_template_directory_uri(). '/style.css', null, null);
		wp_enqueue_style( 'pa-theme-sedes-print', get_template_directory_uri() . '/print.css', null, null);
	
		wp_enqueue_script( 'fontawesome-js', 'https://kit.fontawesome.com/c992dc3e78.js', array(), false, false );
		wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/script.js', array(), false, true );
	}
	
	function registerAssetsAdmin() {
		wp_enqueue_script( 'scripts-admin', get_template_directory_uri() . '/assets/scripts/script_admin.js', array(), false, true );
	}
	
}
$PaThemeHelpers = new PaThemeHelpers();