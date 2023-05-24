<?php

namespace IASD\Core;

use Extended\ACF\Fields\Tab;
use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Location;

class Modules {

  private $key = 'iasd_modules';
  
  public function __construct() {
    add_action('after_setup_theme', [$this, 'createPage']);
    add_action('after_setup_theme', [$this, 'createFields'], 11);
  }

  function createPage(): void {
    acf_add_options_sub_page(array(
      'post_id'     => $this->key,
      'page_title'  => __('Modules', 'iasd'),
      'menu_title'  => __('Modules', 'iasd'),
      'menu_slug'   => $this->key,
      'parent_slug' => 'themes.php',
      'capability'  => 'manage_options',
    ));
  }

  function createFields() {
    $fields = [
      Tab::make(__('Blocks', 'iasd')),

      TrueFalse::make(__('All blocks', 'iasd'), 'module_blocks')
        ->stylisedUi()
        ->defaultValue(true),

      TrueFalse::make(__('IASD - Feature - Carousel', 'iasd'), 'module_block_PACarouselFeature')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Twitter', 'iasd'), 'module_block_PATwitter')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Facebook', 'iasd'), 'module_block_PAFacebook')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Icons - List', 'iasd'), 'module_block_PAListIcons')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Itens - List', 'iasd'), 'module_block_PAListItems')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Apps', 'iasd'), 'module_block_PAApps')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Magazines', 'iasd'), 'module_block_PAMagazines')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Button - List', 'iasd'), 'module_block_PAListButtons')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Feature Slider - Ministry', 'iasd'), 'module_block_PACarouselMinistry')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - 7Cast', 'iasd'), 'module_block_PASevenCast')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),

      TrueFalse::make(__('IASD - Row', 'iasd'), 'module_block_PARow')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Downloads - List', 'iasd'), 'module_block_PAListDownloads')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Downloads - Carousel', 'iasd'), 'module_block_PACarouselDownloads')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - News - List', 'iasd'), 'module_block_PAListNews')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Feliz7Play', 'iasd'), 'module_block_PAFeliz7Play')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Videos - List(A)', 'iasd'), 'module_block_PAListVideos')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Image', 'iasd'), 'module_block_PAImage')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Find church', 'iasd'), 'module_block_PAFindChurch')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Kits - Carousel', 'iasd'), 'module_block_PACarouselKits')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
        
      TrueFalse::make(__('IASD - Quero vida e saúde', 'iasd'), 'module_block_PAQueroVidaSaude')
        ->stylisedUi()
        ->defaultValue(true)
        ->wrapper([
          'width' => 20,
        ])
        ->conditionalLogic([ConditionalLogic::where('module_blocks', '==', 1)]),
    ];

    register_extended_field_group([
      'title'    => ' ',
      'key'      => 'iasd_modules',
      'style'    => 'default',
      'fields'   => $fields,
      'location' => [
        Location::where('options_page', '==', $this->key),
      ],
    ]);
  }
  
}

new Modules();
