<?php

require_once(dirname(__FILE__) . '/PA_RestAPI_Tax.php');


class PAServiceTaxonomy
{
    static function getTaxonomies()
    {
        add_action('init', 'PA_Registre_Taxonomy');
    }

    function PA_Registre_Taxonomy()
    {


        /**
         * 
         * Register taxonomys 
         * 
         */

        $restAPIService = new PARestAPITax();
        $resultService = $restAPIService->CallAPI('GET', 'xtt-pa-owner?per_page=100');

        // print_r();
        // print_r($restAPIService->CallAPI('GET', 'xtt-pa-owner?per_page=100'));

        // $labels = array(
        //     'name'              => _x('Sedes Proprietárias', 'nome da taxonomia'),
        //     'singular_name'     => _x('Sede Proprietária', 'nome da taxonomia no singular'),
        //     'search_items'      => __('Procurar Sedes Proprietárias'),
        //     'all_items'         => __('Todas as Sedes'),
        //     'parent_item'       => __('Subse'),
        //     'parent_item_colon' => __('Parent Course:'),
        //     'edit_item'         => __('Editar Sede Proprietária'),
        //     'update_item'       => __('Editar Sede Proprietária'),
        //     'add_new_item'      => __('Add Nova Sede Proprietária'),
        //     'new_item_name'     => __('Nova Sede Proprietária'),
        //     'menu_name'         => __('Sedes Proprietárias'),
        // );
        // $args   = array(
        //     'hierarchical'      => true, // make it hierarchical (like categories)
        //     'labels'            => $labels,
        //     'show_ui'           => true,
        //     'show_admin_column' => true,
        //     'query_var'         => true,
        //     'rewrite'           => ['slug' => 'xtt-pa-owner'],
        // );
        // register_taxonomy('xtt-pa-owner', ['post'], $args);
    }
}
