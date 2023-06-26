<?php


use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Textarea;
use Extended\ACF\Fields\Taxonomy;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Fields\Url;
use Extended\ACF\Location;


class PaAcfSiteSettings
{
  public function __construct()
  {
    add_action('after_setup_theme', [$this, 'addPageSettings']);
  }

  function addPageSettings()
  {
    if (is_multisite()) {
      acf_add_options_sub_page(array(
        'network' => true,
        'post_id' => 'pa_network_settings',
        'page_title'   => __('IASD Site - Custom Settings', 'iasd'),
        'menu_title'  => __('IASD Site - Custom Settings', 'iasd'),
        'menu_slug'     => 'iasd_custom_settings_network',
        'parent_slug'  => 'themes.php',
      ));

      $this->createAcfFields(true);
    }

    acf_add_options_sub_page(array(
      'post_id' => 'pa_settings',
      'page_title'   => __('IASD Site - Custom Settings', 'iasd'),
      'menu_title'  => __('IASD Site - Custom Settings', 'iasd'),
      'menu_slug'     => 'iasd_custom_settings',
      'parent_slug'  => 'themes.php',
      'capability' => 'manage_options'
    ));


    $this->createAcfFields();
  }

  function createAcfFields($network = false)
  {
    $network = $network ? '_network' : '';

    $fields = [
      Tab::make('Contact'),
      Taxonomy::make(__('Headquarter', 'iasd'), "ct_headquarter")
        ->taxonomy('xtt-pa-sedes')
        ->appearance('select') // checkbox, multi_select, radio or select
        ->addTerm(false) // Allow new terms to be created whilst editing (true or false)
        ->returnFormat('object'), // object or id (default)
      Textarea::make(__('Address', 'iasd'), "ct_adress")
        ->newLines('br') // br or wpautop
        ->characterLimit(200)
        ->rows(4),
      Text::make(__('Telephone', 'iasd'), "ct_telephone"),
      Tab::make(__('Social Networks', 'iasd')),
      Url::make('Facebook', "sn_facebook"),
      Url::make('Twitter', "sn_twitter"),
      Url::make('Youtube', "sn_youtube"),
      Url::make('Instagram', "sn_instagram"),
    ];

    if (is_multisite()) {
      if (empty($network)) :
        foreach ($fields as &$field)
          $field->conditionalLogic([ConditionalLogic::where('overwrite_global_settings', '==', 1)]);
      endif;
    }


    register_extended_field_group([
      'title' => __('Site settings', 'iasd'),
      'key' => "site_settings_contact{$network}",
      'style' => 'default',
      'fields' => array_merge(
        is_multisite() && empty($network) ?
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
        Location::where('options_page', '==', "iasd_custom_settings{$network}"),
      ],
    ]);
  }
}
$PaAcfSiteSettings = new PaAcfSiteSettings();
