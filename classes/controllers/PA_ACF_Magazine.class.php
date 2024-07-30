<?php

use Extended\ACF\Fields\DatePicker;
use Extended\ACF\Fields\OEmbed;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Url;
use Extended\ACF\Location;



class PaCptMagazines
{
    public function __construct()
    {
        add_action('init', [$this, 'createPostType']);
        add_action('acf/init', [$this, 'createACFFields']);
    }

    public function createPostType()
    {
        $labels = array(
            'name'                  => __('Revistas', 'iasd'),
            'singular_name'         => __('Revista', 'iasd'),
            'menu_name'             => __('Revistas', 'iasd'),
            'name_admin_bar'        => __('Revistas', 'iasd'),
            'add_new'               => __('Adicionar Nova', 'iasd'),
            'add_new_item'          => __('Adicionar Nova Revista', 'iasd'),
            'new_item'              => __('Nova Revista', 'iasd'),
            'edit_item'             => __('Editar Revista', 'iasd'),
            'view_item'             => __('Ver Revista', 'iasd'),
            'all_items'             => __('Todas as Revistas', 'iasd'),
            'search_items'          => __('Procurar Revista', 'iasd'),
            'not_found'             => __('Não encontrada.', 'iasd'),
            'not_found_in_trash'    => __('Não encontrada no Lixo.', 'iasd'),
        );
        $args = array(
            'label'                 => __('Revista', 'iasd'),
            'labels'                => $labels,
            'supports'              => array('title', 'thumbnail'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => sanitize_title(__('revistas', 'iasd')),
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
            'show_in_rest'          => true,
            'rewrite'               => array('slug' => sanitize_title(__('revistas', 'iasd'))),
            'menu_icon'             => 'dashicons-book-alt',
        );
        register_post_type('magazines', $args);
    }

    public function createACFFields()
    {
        register_extended_field_group([
            'title' => 'Revistas',
            'style' => 'default',
            'fields' => [
                Text::make(__('Título', 'iasd'), 'title'),
                DatePicker::make(__('Ano de Veiculação', 'iasd'), 'ano_veiculacao')->displayFormat('Y')->returnFormat('Y'),
                Text::make(__('Período', 'iasd'), 'periodo'),
                OEmbed::make(__('Embed para visualizar a revista', 'iasd'), 'embed_code'),
                URL::make(__('Arquivo para Download', 'iasd'), 'download_file'), 
            ],
            'location' => [
                Location::where('post_type', '==', 'magazines'),
            ],
        ]);
    }
}

$PaCptMagazines = new PaCptMagazines();