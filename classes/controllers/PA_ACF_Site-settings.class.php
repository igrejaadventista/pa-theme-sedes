<?php

use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\Tab;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;
use WordPlate\Acf\Fields\Taxonomy;
use WordPlate\Acf\Fields\TrueFalse;
use WordPlate\Acf\Fields\Url;
use WordPlate\Acf\Location;


class PaAcfSiteSettings {
	public function __construct(){
		add_action('after_setup_theme', [$this, 'addPageSettings' ]);
	}

	function addPageSettings() {
		acf_add_options_sub_page(array(
			'network' => true,
            'page_title' 	=> 'IASD Site - Custom Settings',
            'menu_title'	=> 'IASD Site - Custom Settings',
            'menu_slug'     => 'iasd_custom_settings_network',
            'parent_slug'	=> 'themes.php',
        ));

		acf_add_options_sub_page(array(
            'page_title' 	=> 'IASD Site - Custom Settings',
            'menu_title'	=> 'IASD Site - Custom Settings',
            'menu_slug'     => 'iasd_custom_settings',
            'parent_slug'	=> 'themes.php',
        ));

		$this->createAcfFields(true);
		$this->createAcfFields();
	}

    function createAcfFields($network = false) {
		$network = $network ? '_network' : '';

		$fields = [
			Tab::make('Contact'),
				Taxonomy::make('Headquarter', "ct_headquarter{$network}")
					->taxonomy('xtt-pa-sedes')
					->appearance('select') // checkbox, multi_select, radio or select
					->addTerm(false) // Allow new terms to be created whilst editing (true or false)
					->returnFormat('object'), // object or id (default)
				Textarea::make('Adress', "ct_adress{$network}")
					->newLines('br') // br or wpautop
					->characterLimit(200)
					->rows(4),
				Text::make('Telephone', "ct_telephone{$network}"),
			Tab::make('Social Networks'),
				Url::make('Facebook', "sn_facebook{$network}"),
				Url::make('Twitter', "sn_twitter{$network}"),
				Url::make('Youtube', "sn_youtube{$network}"),
				Url::make('Instagram', "sn_instagram{$network}"),
		];

		if(empty($network)):
			foreach($fields as &$field)
				$field->conditionalLogic([ConditionalLogic::if('overwrite_global_settings')->equals(1)]);
		endif;

        register_extended_field_group([
            'title' => 'Site settings',
			'key' => "site_settings_contact{$network}",
            'style' => 'default',
            'fields' => array_merge(
				empty($network) ?
				[
					TrueFalse::make('Sobrescrever configurações globais', 'overwrite_global_settings')
						->defaultValue(false)
						->stylisedUi(),
				]
				:
				[],
				$fields
			),
            'location' => [
                Location::if('options_page', "iasd_custom_settings{$network}"),
            ],
        ]);
    }
}
$PaAcfSiteSettings = new PaAcfSiteSettings();
