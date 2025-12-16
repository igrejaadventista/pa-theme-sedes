<?php 

class PaAcfHelpers {

	public function __construct(){
		add_filter('acf/settings/show_admin', [$this, 'acfShowAdmin']);
		add_filter('wp_kses_allowed_html', [self::class, 'allowSvgTags'], 10, 2);
	}

	/**
	 * Permite tags SVG no HTML permitido para campos ACF.
	 */
	public static function allowSvgTags($allowed, $context) {
		if ($context === 'post') {
			$allowed['svg'] = [
        'class' => true,
        'aria-hidden' => true,
        'aria-labelledby' => true,
        'role' => true,
        'xmlns' => true,
        'width' => true,
        'height' => true,
        'viewBox' => true,
        'fill' => true,
      ];

      $allowed['g'] = [
        'transform' => true,
        'fill' => true,
      ];

      $allowed['path'] = [
        'd' => true,
        'fill' => true,
        'transform' => true,
      ];

      $allowed['title'] = [];
		}
		return $allowed;
	}

	function acfSaveJson(){
		return get_stylesheet_directory() . '/acf-json';
	}

	function acfLoadJson($paths){
		if(is_child_theme()) {
			$paths[] = get_template_directory() . '/acf-json';
		}
		return $paths;
	}

	function acfShowAdmin() {
		return true;
	}
}
$PaAcfHelpers = new PaAcfHelpers();
