<?php

define('API_PA', 'api.adventistas.dev');
define('API_7CAST', 'api.adv.st');
define('API_F7P', 'api.feliz7play.com');

if (file_exists($composer = __DIR__ . '/vendor/autoload.php'))
	require_once $composer;

if (is_multisite()) {
	require_once(dirname(__FILE__) . '/vendor/lordealeister/acf-multisite-options/acf-multisite-options.php');
}

require_once(dirname(__FILE__) . '/classes/controllers/PA_AdminUser.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Theme_Helpers.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_Helpers.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_ACF_Site-settings.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Menu_Walker.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Menu_Mobile.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Image_Check.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Image_Thumbs.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Register_Sidebars.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_REST-Cleanup.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Sedes_Infos.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Header_Title.class.php');
require_once(dirname(__FILE__) . '/Fields/TaxonomyTerms.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_SearchPage.class.php');
require_once(dirname(__FILE__) . '/classes/controllers/PA_Strong_Passwords.php');


// CORE INSTALL
require_once(dirname(__FILE__) . '/core/PA_Theme_Sedes_Install.php');

\add_filter('blade/cache/path', function ($path) {
	$uploadDir = wp_upload_dir();
	return $uploadDir['basedir'] . '/.bladecache/';
});

$Blocks = new Blocks\Blocks;

if (file_exists(get_stylesheet_directory() . '/classes/PA_Directives.php'))
	require_once(get_stylesheet_directory() . '/classes/PA_Directives.php');
