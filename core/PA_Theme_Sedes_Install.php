<?php

require_once(dirname(__FILE__) . '/utils/PA_Service_Taxonomy.php');
require_once(dirname(__FILE__) . '/utils/PA_Schedule_Custom.php');
require_once(dirname(__FILE__) . '/utils/PA_RestAPI_Tax.php');
require_once(dirname(__FILE__) . '/utils/PA_Ui_Configurations.php');
require_once(dirname(__FILE__) . '/utils/PA_Service_Slider_Home.php');

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
    );
    register_taxonomy('xtt-pa-owner', ['post'], $argsOwners);

    /**
     * 
     * COLEÇÕES
     * 
     */

    $labelsOwners = array(
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
    $argsOwners   = array(
      'hierarchical'      => true, // make it hierarchical (like categories)
      'labels'            => $labelsOwners,
      'show_ui'           => true,
      'show_admin_column' => true,
      'query_var'         => true,
      'show_in_rest'      => true, // add support for Gutenberg editor
      'rewrite'           => ['slug' => 'xtt-pa-colecoes'],
    );
    register_taxonomy('xtt-pa-colecoes', ['post'], $argsOwners);



    // Install routine to create or update taxonomies
    if (!wp_next_scheduled('Service_Taxonomy_Schedule')) {
      wp_schedule_event(time(), '20min', 'Service_Taxonomy_Schedule');
    }
  }
}

$PACoreInstall = new PACoreInstall();
