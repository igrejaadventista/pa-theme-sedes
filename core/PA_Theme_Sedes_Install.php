<?php

require_once(dirname(__FILE__) . '/utils/PA_Service_Taxonomy.php');
require_once(dirname(__FILE__) . '/utils/PA_Schedule_Custom.php');
require_once(dirname(__FILE__) . '/utils/PA_RestAPI_Tax.php');
require_once(dirname(__FILE__) . '/utils/PA_Ui_Configurations.php');
// require_once(dirname(__FILE__) . '/utils/PA_Service_Slider_Home.php');

/**
 * 
 * Bootloader Install
 * 
 */

class PACoreInstall
{
  public function __construct()
  {
    add_action('after_setup_theme', array($this, 'installRoutines'));
  }

  function installRoutines()
  {
    /**
     * 
     * SEDES PROPRIETÁRIAS
     * 
     */

    $labelsOwners = array(
      'name'              => _x('Sedes Proprietárias', 'nome da taxonomia'),
      'singular_name'     => _x('Sede Proprietária', 'nome da taxonomia no singular'),
      'search_items'      => __('Procurar Sedes Proprietárias'),
      'all_items'         => __('Todas as Sedes'),
      'parent_item'       => __('Sede proprietária pai'),
      'parent_item_colon' => __('Sede proprientária pai'),
      'edit_item'         => __('Editar Sede Proprietária'),
      'update_item'       => __('Atualizar Sede Proprietária'),
      'add_new_item'      => __('Add Nova Sede Proprietária'),
      'new_item_name'     => __('Nova Sede Proprietária'),
      'menu_name'         => __('Sedes Proprietárias'),
    );
    $argsOwners   = array(
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labelsOwners,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true, // add support for Gutenberg editor
		'rewrite'           => ['slug' => 'xtt-pa-owner'],
		'capabilities' 		  => array(
			'edit_terms' 	  => false,
			'delete_terms'    => false,
		),
    );
    register_taxonomy('xtt-pa-owner', ['post'], $argsOwners);

    /**
     * 
     * COLEÇÕES
     * 
     */

    $labelsColecoes = array(
      'name'              => _x('Coleções', 'nome da taxonomia'),
      'singular_name'     => _x('Coleção', 'nome da taxonomia no singular'),
      'search_items'      => __('Procurar Coleção'),
      'all_items'         => __('Todas Coleções'),
      'parent_item'       => __('Coleção pai'),
      'parent_item_colon' => __('Sub coleção'),
      'edit_item'         => __('Editar Coleção'),
      'update_item'       => __('Atualizar Coleção'),
      'add_new_item'      => __('Add nova coleção'),
      'new_item_name'     => __('Nova Coleção'),
      'menu_name'         => __('Coleções'),
    );
    $argsColecoes   = array(
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labelsColecoes,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true, // add support for Gutenberg editor
		'rewrite'           => ['slug' => 'xtt-pa-colecoes'],
		'capabilities' 		  => array(
			'edit_terms' 	  => false,
			'delete_terms'    => false,
		),
    );
    register_taxonomy('xtt-pa-colecoes', ['post'], $argsColecoes);


	/**
     * 
     * EDITORIAS
     * 
     */

    $labelsEditorias = array(
			'name'                => __( 'Editorias', 'iasd'),
			'singular_name'       => __( 'Editoria', 'iasd'),
			'search_items'        => __( 'Buscar Editoria', 'iasd'),
			'all_items'           => __( 'Todas as Editorias', 'iasd'),
			'parent_item'         => __( 'Editoria Superior', 'iasd'),
			'parent_item_colon'   => __( 'Editoria Superior', 'iasd'),
			'edit_item'           => __( 'Editar Editoria', 'iasd' ),
			'update_item'         => __( 'Atualizar Editoria', 'iasd'),
			'add_new_item'        => __( 'Adicionar Nova Editoria', 'iasd'),
			'new_item_name'       => __( 'Nome da Editoria', 'iasd'),
			'menu_name'           => __( 'Editorias', 'iasd')
		);

		$argsEditorias = array(
			'hierarchical'        => true,
			'labels'              => $labelsEditorias,
			'show_ui'             => true,
			'show_admin_column'   => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __('editoria', 'iasd') ),
			'public'              => true,
      		'show_in_rest'        => true, // add support for Gutenberg editor
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
		);
    register_taxonomy('xtt-pa-editorias', ['post'], $argsEditorias);


    /**
     * 
     * Departamentos
     * 
     */

    $labelsDepartamentos = array(
			'name'                => __( 'Departamentos', 'iasd'),
			'singular_name'       => __( 'Departamento', 'iasd'),
			'search_items'        => __( 'Buscar Departamento', 'iasd'),
			'all_items'           => __( 'Todos os Departamento', 'iasd'),
			'parent_item'         => __( 'Departamento Superior', 'iasd'),
			'parent_item_colon'   => __( 'Departamento Superior', 'iasd'),
			'edit_item'           => __( 'Editar Departamento', 'iasd' ),
			'update_item'         => __( 'Atualizar Departamento', 'iasd'),
			'add_new_item'        => __( 'Adicionar Novo Departamento', 'iasd'),
			'new_item_name'       => __( 'Nome do Departamento', 'iasd'),
			'menu_name'           => __( 'Departamentos', 'iasd')
		);

		$argsDepartamentos = array(
			'hierarchical'        => true,
			'labels'              => $labelsDepartamentos,
			'show_ui'             => true,
			'show_admin_column'   => false,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __('departamento', 'iasd') ),
			'public'              => true,
      		'show_in_rest'        => true, // add support for Gutenberg editor
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
		);
    register_taxonomy('xtt-pa-departamentos', ['post'], $argsDepartamentos);


    /**
     * 
     * Projetos
     * 
     */

    $labelsProjetos = array(
			'name'                => __( 'Projetos', 'iasd'),
			'singular_name'       => __( 'Projeto', 'iasd'),
			'search_items'        => __( 'Buscar Projeto', 'iasd'),
			'all_items'           => __( 'Todos os Projetos', 'iasd'),
			'parent_item'         => __( 'Projeto Pai', 'iasd'),
			'parent_item_colon'   => __( 'Projeto Pai', 'iasd'),
			'edit_item'           => __( 'Editar Projeto', 'iasd' ),
			'update_item'         => __( 'Atualizar Projeto', 'iasd'),
			'add_new_item'        => __( 'Adicionar Novo Projeto', 'iasd'),
			'new_item_name'       => __( 'Nome do Projeto', 'iasd'),
			'menu_name'           => __( 'Projetos', 'iasd')
		);

		$argsProjetos = array(
			'hierarchical'        => true,
			'labels'              => $labelsProjetos,
			'show_ui'             => true,
			'show_admin_column'   => false,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __('projeto', 'iasd') ),
			'public'              => true,
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
      'show_in_rest'        => true, // add support for Gutenberg editor
    );
    register_taxonomy('xtt-pa-projetos', ['post'], $argsProjetos);

	
    /**
     * 
     * Sedes Regionais
     * 
     */

    $labelsSedes = array(
			'name'                => __( 'Sedes Regionais', 'iasd'),
			'singular_name'       => __( 'Sede Regional', 'iasd'),
			'search_items'        => __( 'Buscar Sede', 'iasd'),
			'all_items'           => __( 'Todas Sedes', 'iasd'),
			'parent_item'         => __( 'Sede Adminitrativa', 'iasd'),
			'parent_item_colon'   => __( 'Sede Adminitrativa', 'iasd'),
			'edit_item'           => __( 'Editar Sede', 'iasd' ),
			'update_item'         => __( 'Atualizar Sede', 'iasd'),
			'add_new_item'        => __( 'Adicionar Nova Sede', 'iasd'),
			'new_item_name'       => __( 'Nome da Sede', 'iasd'),
			'menu_name'           => __( 'Sedes Regionais', 'iasd')
		);

		$argsSedes = array(
			'hierarchical'        => true,
			'labels'              => $labelsSedes,
			'show_ui'             => true,
			'show_admin_column'   => true,
			'query_var'           => true,
			'rewrite'             => true,
			'public'              => true,
      		'show_in_rest'        => true, // add support for Gutenberg editor
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
		);
    register_taxonomy('xtt-pa-sedes', ['post'], $argsSedes);


    // Install routine to create or update taxonomies
    if (!wp_next_scheduled('PA-Service_Taxonomy_Schedule')) {
      wp_schedule_event(time(), '20min', 'PA-Service_Taxonomy_Schedule');
    }
  }
}

$PACoreInstall = new PACoreInstall();
