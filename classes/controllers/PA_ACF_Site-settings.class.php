<?php

use WordPlate\Acf\Fields\Tab;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;
use WordPlate\Acf\Fields\Taxonomy;
use WordPlate\Acf\Fields\Url;
use WordPlate\Acf\Location;


class PaAcfSiteSettings {
	public function __construct(){
		add_action('after_setup_theme', [$this, 'addPageSettings' ]);
        add_action('init', [$this, 'createAcfFields' ]);
	}

	function addPageSettings(){
		acf_add_options_sub_page(array(
            'page_title' 	=> 'IASD Site - Custom Settings',
            'menu_title'	=> 'IASD Site - Custom Settings',
            'menu_slug'     => 'iasd_custom_settings',
            'parent_slug'	=> 'themes.php',
        ));
	}

    function createAcfFields(){
        register_extended_field_group([
            'title' => 'Site settings',
            'style' => 'default',
            'fields' => [
                Tab::make('Contact'),
                    Taxonomy::make('Headquarter', 'ct_headquarter')
                        ->taxonomy('xtt-pa-owner')
                        ->appearance('select') // checkbox, multi_select, radio or select
                        ->addTerm(false) // Allow new terms to be created whilst editing (true or false)
                        ->returnFormat('object'), // object or id (default)
                    Textarea::make('Adress', 'ct_adress')
                        ->newLines('br') // br or wpautop
                        ->characterLimit(200)
                        ->rows(4),
                    Text::make('Telephone', 'ct_telephone'),
                Tab::make('Social Networks'),
                    Url::make('Facebooks', 'sn_facebook'),
                    Url::make('Twitter', 'sn_twitter'),
                    Url::make('Youtube', 'sn_youtube'),
                    Url::make('Instagram', 'sn_instagram'),
            ],
            'location' => [
                Location::if('options_page', 'iasd_custom_settings'),
            ],
        ]);
    }
}
$PaAcfSiteSettings = new PaAcfSiteSettings();
