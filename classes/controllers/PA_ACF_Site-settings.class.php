<?php


use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Select;
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
    add_filter('acf/prepare_field/name=ct_languages', [$this, 'prepareLanguageSelectorField']);
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
    $this->createBannerAutoplaySettings();
    $this->createLanguageSelectorSettings();
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

  function createBannerAutoplaySettings($network = false)
  {
    $network = $network ? '_network' : '';

    register_extended_field_group([
      'title' => __('Banner Autoplay Settings', 'iasd'),
      'key' => 'banner_autoplay_settings',
      'style' => 'default',
      'fields' => [
        TrueFalse::make(__('Auto Play Banner', 'iasd'), 'ct_banner_autoplay')
          ->defaultValue(false)
          ->stylisedUi()
      ],
      'location' => [
        Location::where('options_page', '==', "iasd_custom_settings{$network}"),
      ],
    ]);
  }

  function createLanguageSelectorSettings()
  {
    register_extended_field_group([
      'title' => __('Language Selector Settings', 'iasd'),
      'key' => 'language_selector_settings',
      'style' => 'default',
      'fields' => [
        Tab::make(__('Languages', 'iasd')),
        Repeater::make(__('Languages', 'iasd'), 'ct_languages')
          ->instructions(__('Add the languages available in the header selector.', 'iasd'))
          ->layout('row')
          ->buttonLabel(__('Add language', 'iasd'))
          ->collapsed('name')
          ->fields([
            Text::make(__('Language name', 'iasd'), 'name')
              ->instructions(__('Name displayed in the selector, for example PT or ES.', 'iasd'))
              ->required()
              ->wrapper([
                'width' => 30,
              ]),
            Url::make(__('Redirect URL', 'iasd'), 'url')
              ->required()
              ->wrapper([
                'width' => 40,
              ]),
            Select::make(__('Flag/Icon', 'iasd'), 'icon')
              ->instructions(__('Select one of the available flag icons.', 'iasd'))
              ->choices($this->getFlagIconChoices())
              ->defaultValue('br')
              ->stylisedUi()
              ->required()
              ->wrapper([
                'width' => 30,
              ]),
          ]),
      ],
      'location' => [
        Location::where('options_page', '==', 'iasd_custom_settings'),
      ],
    ]);
  }

  function prepareLanguageSelectorField($field)
  {
    if (class_exists('\IASD\Core\Settings\Modules') && !\IASD\Core\Settings\Modules::isActiveModule('language_selector')) {
      return false;
    }

    return $field;
  }

  function getFlagIconChoices()
  {
    $fallback = [
      'br' => __('Brazil', 'iasd') . ' - BR',
      'es' => __('Spain', 'iasd') . ' - ES',
    ];

    $choices = get_transient('pa_language_flag_icon_choices');

    if (is_array($choices) && !empty($choices)) {
      return $choices;
    }

    if (!is_admin()) {
      return $fallback;
    }

    $response = wp_remote_get('https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.5.0/country.json');

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
      return $fallback;
    }

    $countries = json_decode(wp_remote_retrieve_body($response), true);

    if (!is_array($countries)) {
      return $fallback;
    }

    $choices = [];

    foreach ($countries as $country) {
      if (empty($country['iso']) || empty($country['code']) || empty($country['name'])) {
        continue;
      }

      $code = sanitize_key($country['code']);
      $choices[$code] = $country['name'] . ' - ' . strtoupper($code);
    }

    if (empty($choices)) {
      return $fallback;
    }

    set_transient('pa_language_flag_icon_choices', $choices, WEEK_IN_SECONDS);

    return $choices;
  }
}
$PaAcfSiteSettings = new PaAcfSiteSettings();
