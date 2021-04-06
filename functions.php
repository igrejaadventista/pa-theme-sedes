<?php 

use \Blocks\PACarouselFeature\PACarouselFeature;

if(file_exists($composer = __DIR__. '/vendor/autoload.php'))
	require_once $composer;

require_once (dirname(__FILE__) . '/classes/controllers/PA_Theme_Helpers.class.php');
require_once (dirname(__FILE__) . '/classes/controllers/PA_ACF_Helpers.class.php');
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

	return $document->saveHTML();
}

add_filter('the_content', 'add_responsive_class');



function Register_Owner() {
	$labels = array(
		'name'                => __( 'Sedes Proprietárias', 'iasd'),
		'singular_name'       => __( 'Sede Proprietária', 'iasd'),
		'search_items'        => __( 'Buscar Sede', 'iasd'),
		'all_items'           => __( 'Todas Sedes', 'iasd'),
		'parent_item'         => __( 'Sede', 'iasd'),
		'parent_item_colon'   => __( 'Sede', 'iasd'),
		'edit_item'           => __( 'Editar Sede', 'iasd' ),
		'update_item'         => __( 'Atualizar Sede', 'iasd'),
		'add_new_item'        => __( 'Adicionar Nova Sede', 'iasd'),
		'new_item_name'       => __( 'Nome do Sede', 'iasd'),
		'menu_name'           => __( 'Sede Proprietária', 'iasd')
	);

	$args = array(
		'hierarchical'        => true,
		'labels'              => $labels,
		'show_ui'             => true,
		'show_admin_column'   => false,
		'query_var'           => true,
		'show_in_rest'        => true,
		'rewrite'             => array( 'slug' => __('proprietario', 'iasd') ),
		'public'              => false,
		// 'capabilities'        => TaxonomyPermissions()
	);

	$post_types = 'post';

	register_taxonomy( 'xtt-pa-owner', $post_types, $args );
}

add_action( 'init', 'Register_Owner', 0 );

if (!\function_exists('block')) {
    /**
     * Render blade templates.
     *
     * @param string $view
     * @param array $data
     * @param bool $data
     *
     * @return string
     */
    function block(string $view, array $data = [], bool $echo = false): string {
        return blade($view, $data, $echo);
    }
}

add_filter('acf_gutenblocks/blocks', function(array $blocks): array {
    $new_blocks = [
        PACarouselFeature::class,
    ];

    return array_merge($blocks, $new_blocks);
});

add_filter('acf_gutenblocks/blade_engine_callable', function(string $callable): string {
    return 'block';
});

add_filter('blade/view/paths', function ($paths) {
    $paths = (array) $paths;
    $paths[0] = get_template_directory();

    return $paths;
});

add_filter('acf_gutenblocks/render_block_frontend_path', function(string $path): string {
    return str_replace('.blade.php', '', strstr($path, 'Blocks'));
});