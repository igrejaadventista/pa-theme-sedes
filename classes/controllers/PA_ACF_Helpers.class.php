<?php 

class PA_ACF_Helpers {

	public function __construct(){
		add_filter('acf/settings/save_json', [$this, 'acfSaveJson']);
		add_filter('acf/settings/load_json', [$this, 'acfLoadJson']);

		include_once(get_template_directory() . '/acf/acf.php' );

		add_filter('acf/settings/url', [$this, 'acfSettingsUrl']);
		add_filter('acf/settings/show_admin', [$this, 'acfShowAdmin']);
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

	function acfSettingsUrl( $url ) {
		return get_template_directory_uri() . '/acf/';
	}

	function acfShowAdmin( $show_admin ) {
		return true;
	}
}
new PA_ACF_Helpers();
