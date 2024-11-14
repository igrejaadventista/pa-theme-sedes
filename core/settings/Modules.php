<?php

namespace IASD\Core\Settings;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Location;
use IASD\Core\Taxonomies;

class Modules {

  /**
   * The key modules field
   *
   * @var string
   */
  private static $key = 'iasd_modules';

  /**
   * The prefix for modules field
   *
   * @var string
   */
  private static $prefix = 'module_';

  public function __construct() {
    add_action('after_setup_theme', [$this, 'createPage'], 12);
    add_action('after_setup_theme', [$this, 'createFields'], 12);
  }

  /**
   * Create modules page options
   *
   * @return void
   */
  function createPage(): void {
    acf_add_options_sub_page(array(
      'post_id'     => self::$key,
      'page_title'  => __('Modules', 'iasd'),
      'menu_title'  => __('Modules', 'iasd'),
      'menu_slug'   => self::$key,
      'parent_slug' => 'themes.php',
      'capability'  => 'manage_options',
    ));
  }

  /**
   * Create modules fields
   *
   * @return void
   */
  function createFields(): void {
    $fields = array_merge(
      $this->generalFields(),
      $this->blocksFields(),
      $this->taxonomiesFields()
    );

    register_extended_field_group([
      'title'    => ' ',
      'key'      => 'iasd_modules',
      'style'    => 'default',
      'fields'   => $fields,
      'location' => [
        Location::where('options_page', '==', self::$key),
      ],
    ]);
  }

  /**
   * Create general modules fields
   *
   * @return array Array of fields
   */
  function generalFields(): array
  {
    return [
      Tab::make(__('General', 'iasd')),

      TrueFalse::make(__('Sidebars', 'iasd'), self::$prefix . 'sidebars')
        ->instructions(__('Enable/disable all IASD sidebars', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),

      TrueFalse::make(__('Search page', 'iasd'), self::$prefix . 'searchpage')
        ->instructions(__('Enable/disable IASD custom search page', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),

      TrueFalse::make(__('Header title', 'iasd'), self::$prefix . 'headertitle')
        ->instructions(__('Enable/disable IASD custom header title', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),

      TrueFalse::make(__('REST cleanup', 'iasd'), self::$prefix . 'restcleanup')
        ->instructions(__('Enable/disable IASD REST cleanup', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),

      TrueFalse::make(__('Seventh column', 'iasd'), self::$prefix . 'seventhcolumn')
        ->instructions(__('Enable/disable IASD seventh column', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true),
    ];
  }

  /**
   * Create blocks modules fields
   *
   * @return array Array of fields
   */
  function blocksFields(): array
  {
    return [
      Tab::make(__('Blocks', 'iasd')),

      TrueFalse::make(__('All blocks', 'iasd'), self::$prefix . 'blocks')
        ->instructions(__('Enable/disable all IASD blocks', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),

      TrueFalse::make(__('IASD - Feature - Carousel', 'iasd'), self::$prefix . 'block_PACarouselFeature')
        ->instructions(__('Block to feature content on carousel format.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Twitter', 'iasd'), self::$prefix . 'block_PATwitter')
        ->instructions(__('IASD Twitter block.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Facebook', 'iasd'), self::$prefix . 'block_PAFacebook')
        ->instructions(__('IASD Facebok block.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Icons - List', 'iasd'), self::$prefix . 'block_PAListIcons')
        ->instructions(__('Block to show contents in list format with icons.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Itens - List', 'iasd'), self::$prefix . 'block_PAListItems')
        ->instructions(__('Block to show contents in list format with images.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Apps', 'iasd'), self::$prefix . 'block_PAApps')
        ->instructions(__('App', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Magazines', 'iasd'), self::$prefix . 'block_PAMagazines')
        ->instructions(__('Block to show magazines content in carousel format.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Button - List', 'iasd'), self::$prefix . 'block_PAListButtons')
        ->instructions(__('Block with links buttons.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Feature Slider - Ministry', 'iasd'), self::$prefix . 'block_PACarouselMinistry')
        ->instructions(__('Block to feature content in slider format.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - 7Cast', 'iasd'), self::$prefix . 'block_PASevenCast')
        ->instructions(__('Block to show 7cast content in list format.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Downloads - List', 'iasd'), self::$prefix . 'block_PAListDownloads')
        ->instructions(__('Block to show downloads contents in list format.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Downloads - Carousel', 'iasd'), self::$prefix . 'block_PACarouselDownloads')
        ->instructions(__('Block from downloads content on carousel format.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - News - List', 'iasd'), self::$prefix . 'block_PAListNews')
        ->instructions(__('Block to show contents in list format with images.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Feliz7Play', 'iasd'), self::$prefix . 'block_PAFeliz7Play')
        ->instructions(__('Feliz7Play content block.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Videos - List(A)', 'iasd'), self::$prefix . 'block_PAListVideos')
        ->instructions(__('Block to show videos content in list format.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Image', 'iasd'), self::$prefix . 'block_PAImage')
        ->instructions(__('Block to show a image.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Find church', 'iasd'), self::$prefix . 'block_PAFindChurch')
        ->instructions(__('Block to show a box to find a church.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Kits - Carousel', 'iasd'), self::$prefix . 'block_PACarouselKits')
        ->instructions(__('Block from kits content on carousel format.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Quero vida e saúde', 'iasd'), self::$prefix . 'block_PAQueroVidaSaude')
        ->instructions(__('Block to show contents from https://querovidaesaude.com/.', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'blocks', '==', 1)]),
    ];
  }

  /**
   * Create taxonomies modules fields
   *
   * @return array Array of fields
   */
  function taxonomiesFields(): array
  {
    $fields = [
      Tab::make(__('Taxonomies', 'iasd')),

      TrueFalse::make(__('All taxonomies', 'iasd'), self::$prefix . 'taxonomies')
        ->instructions(__('Enable/disable all IASD taxonomies', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),

      TrueFalse::make(__('Taxonomies synchronization', 'iasd'), self::$prefix . 'taxonomiessync')
        ->instructions(__('Enable/disable IASD taxonomies synchronization', 'iasd'))
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'taxonomies', '==', 1)]),
    ];

    foreach (Taxonomies::$taxonomies as $key => $value) :
      $fields[] = TrueFalse::make($value['name'], self::$prefix . 'taxonomy_' . $key)
        ->instructions($value['description'])
        ->stylisedUi(__('Enabled', 'iasd'), __('Disabled', 'iasd'))
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where(self::$prefix . 'taxonomies', '==', 1)]);
    endforeach;

    return $fields;
  }

  /**
   * Check if a module is enabled
   *
   * @param  string $module The module name
   * 
   * @return bool True if the module is enabled, false otherwise
   */
  public static function isActiveModule(string $module): bool
  {
    $field = get_field(self::$prefix . $module, self::$key);
    
    if (!empty($module) && $field !== null)
      return !empty($field);

    return true;
  }
}

new Modules();
