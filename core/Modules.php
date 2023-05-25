<?php

namespace IASD\Core;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Location;

class Modules {
  
  /**
   * The key modules field
   *
   * @var string
   */
  private static $key = 'iasd_modules';
  
  public function __construct() {
    add_action('after_setup_theme', [$this, 'createPage']);
    add_action('after_setup_theme', [$this, 'createFields'], 11);
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
      $this->blocksFields()
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
  function generalFields(): array {
    return [
      Tab::make(__('General', 'iasd')),

      TrueFalse::make(__('Sidebars', 'iasd'), 'module_sidebars')
        ->instructions(__('Enable/disable all IASD sidebars', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),

      TrueFalse::make(__('Search page', 'iasd'), 'module_searchpage')
        ->instructions(__('Enable/disable IASD custom search page', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),

      TrueFalse::make(__('Header title', 'iasd'), 'module_headertitle')
        ->instructions(__('Enable/disable IASD custom header title', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),

      TrueFalse::make(__('REST cleanup', 'iasd'), 'module_restcleanup')
        ->instructions(__('Enable/disable IASD REST cleanup', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ]),
    ];
  }
  
  /**
   * Create blocks modules fields
   *
   * @return array Array of fields
   */
  function blocksFields(): array {
    return [
      Tab::make(__('Blocks', 'iasd')),

      TrueFalse::make(__('All blocks', 'iasd'), 'module_blocks')
        ->instructions(__('Enable/disable all IASD blocks', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true),

      TrueFalse::make(__('IASD - Feature - Carousel', 'iasd'), 'module_block_PACarouselFeature')
        ->instructions(__('Block to feature content on carousel format.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Twitter', 'iasd'), 'module_block_PATwitter')
        ->instructions(__('IASD Twitter block.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Facebook', 'iasd'), 'module_block_PAFacebook')
        ->instructions(__('IASD Facebok block.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Icons - List', 'iasd'), 'module_block_PAListIcons')
        ->instructions(__('Block to show contents in list format with icons.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Itens - List', 'iasd'), 'module_block_PAListItems')
        ->instructions(__('Block to show contents in list format with images.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Apps', 'iasd'), 'module_block_PAApps')
        ->instructions(__('App', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Magazines', 'iasd'), 'module_block_PAMagazines')
        ->instructions(__('Block to show magazines content in carousel format.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Button - List', 'iasd'), 'module_block_PAListButtons')
        ->instructions(__('Block with links buttons.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Feature Slider - Ministry', 'iasd'), 'module_block_PACarouselMinistry')
        ->instructions(__('Block to feature content in slider format.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - 7Cast', 'iasd'), 'module_block_PASevenCast')
        ->instructions(__('Block to show 7cast content in list format.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Downloads - List', 'iasd'), 'module_block_PAListDownloads')
        ->instructions(__('Block to show downloads contents in list format.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Downloads - Carousel', 'iasd'), 'module_block_PACarouselDownloads')
        ->instructions(__('Block from downloads content on carousel format.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - News - List', 'iasd'), 'module_block_PAListNews')
        ->instructions(__('Block to show contents in list format with images.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Feliz7Play', 'iasd'), 'module_block_PAFeliz7Play')
        ->instructions(__('Feliz7Play content block.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Videos - List(A)', 'iasd'), 'module_block_PAListVideos')
        ->instructions(__('Block to show videos content in list format.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Image', 'iasd'), 'module_block_PAImage')
        ->instructions(__('Block to show a image.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Find church', 'iasd'), 'module_block_PAFindChurch')
        ->instructions(__('Block to show a box to find a church.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Kits - Carousel', 'iasd'), 'module_block_PACarouselKits')
        ->instructions(__('Block from kits content on carousel format.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Quero vida e saúde', 'iasd'), 'module_block_PAQueroVidaSaude')
        ->instructions(__('Block to show contents from https://querovidaesaude.com/.', 'iasd'))
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 50,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
    ];
  }
  
  /**
   * Check if a module is enabled
   *
   * @param  string $module The module name
   * 
   * @return bool True if the module is enabled, false otherwise
   */
  public static function isActiveModule(string $module): bool {
    if(!empty($module) && ($field = get_field($module, self::$key)) !== null)
      return !empty($field);

    return true;
  }
  
}

new Modules();
