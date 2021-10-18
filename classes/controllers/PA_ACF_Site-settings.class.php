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
            'page_title' 	=> __('IASD Site - Custom Settings', 'iasd'),
            'menu_title'	=> __('IASD Site - Custom Settings', 'iasd'),
            'menu_slug'     => 'iasd_custom_settings_network',
            'parent_slug'	=> 'themes.php',
        ));

		acf_add_options_sub_page(array(
            'page_title' 	=> __('IASD Site - Custom Settings', 'iasd'),
            'menu_title'	=> __('IASD Site - Custom Settings', 'iasd'),
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
				Taxonomy::make(__('Headquarter', 'iasd'), "ct_headquarter{$network}")
					->taxonomy('xtt-pa-sedes')
					->appearance('select') // checkbox, multi_select, radio or select
					->addTerm(false) // Allow new terms to be created whilst editing (true or false)
					->returnFormat('object'), // object or id (default)
				Textarea::make(__('Address', 'iasd'), "ct_adress{$network}")
					->newLines('br') // br or wpautop
					->characterLimit(200)
					->rows(4),
				Text::make(__('Telephone', 'iasd'), "ct_telephone{$network}"),
			Tab::make(__('Social Networks', 'iasd')),
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
            'title' => __('Site settings', 'iasd'),
			'key' => "site_settings_contact{$network}",
            'style' => 'default',
            'fields' => array_merge(
				empty($network) ?
				[
					TrueFalse::make(__('Rewrite global settings', 'iasd'), 'overwrite_global_settings')
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
