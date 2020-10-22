<?php 

require_once (dirname(__FILE__) . '/classes/controllers/PA_Theme_Helpers.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_ACF_Helpers.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Menu_Walker.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Menu_Mobile.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Image_Check.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Image_Thumbs.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Loop_Archive.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Register_Sidebars.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_Header_Title.class.php');

require_once (dirname(__FILE__) . '/classes/widgets/PA_Widget_Apps.class.php');

function pa_wp_custom_menus() {
	register_nav_menu('pa-menu-default', __( 'PA - Menu - Default' ));
}
add_action( 'init', 'pa_wp_custom_menus' );



//Função auxiliar para imprimir no console o print_r.
function pconsole($var) {

	$s = json_encode($var);
	echo "<script>console.log(". $s . ");</script>";
	return;
}
// Função auxiliar para imprimir no console o echo.
function cconsole($var) {

	echo "<script>console.log('" . $var . "');</script>";
	return;
}


function add_responsive_class($content){

	$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
	$document = new DOMDocument();
	libxml_use_internal_errors(true);
	$document->loadHTML(utf8_decode($content));

	$imgs = $document->getElementsByTagName('img');
	foreach ($imgs as $img) {
	   $img->setAttribute('class','img-fluid');
	}

	$html = $document->saveHTML();
	return $html;
}

add_filter('the_content', 'add_responsive_class');