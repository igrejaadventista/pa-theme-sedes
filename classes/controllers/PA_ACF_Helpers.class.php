<?php 

class PaAcfHelpers {

	public function __construct(){
		add_filter('acf/settings/save_json', [$this, 'acfSaveJson']);
		add_filter('acf/settings/load_json', [$this, 'acfLoadJson']);

		add_filter('acf/settings/show_admin', [$this, 'acfShowAdmin']);
		add_action('acf/init', [$this, 'registerThemeSettings']);
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

	function acfShowAdmin( $show_admin ) {
		return true;
	}

	function registerThemeSettings(){
		acf_add_options_sub_page(array(
			'page_title' 	=> 'IASD Site - Custom Settings',
			'menu_title'	=> 'IASD Site - Custom Settings',
			'parent_slug'	=> 'themes.php',
		));
	}
}
$PaAcfHelpers = new PaAcfHelpers();
