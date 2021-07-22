<?php 

use Blocks\Blocks;

if(file_exists($composer = __DIR__. '/vendor/autoload.php'))
	require_once $composer;

new Blocks;

require_once (dirname(__FILE__) . '/classes/controllers/PA_Theme_Helpers.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_ACF_Helpers.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_ACF_Site-settings.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Menu_Walker.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Menu_Mobile.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Image_Check.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Image_Thumbs.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Loop_Archive.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Page_Numbers.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Register_Sidebars.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Header_Title.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Sedes_Infos.php');

require_once (dirname(__FILE__) . '/classes/widgets/PA_Widget_Apps.class.php');

// CORE INSTALL
require_once (dirname(__FILE__) . '/core/PA_Theme_Sedes_Install.php');

function pa_wp_custom_menus() {
	register_nav_menu('pa-menu-default', __( 'PA - Menu - Default' ));
}
add_action( 'init', 'pa_wp_custom_menus' );



//Função auxiliar para imprimir no console o print_r.
// function pconsole($var) {

// 	$s = json_encode($var);
// 	echo "<script>console.log(". $s . ");</script>";
// 	return;
// }
// Função auxiliar para imprimir no console o echo.
// function cconsole($var) {

// 	echo "<script>console.log('" . $var . "');</script>";
// 	return;
// }