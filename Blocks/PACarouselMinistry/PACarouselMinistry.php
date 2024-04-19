<?php

namespace Blocks\PACarouselMinistry;

use Blocks\Block;
use ExtendedLocal\LocalData;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Select;

/**
 * Class PACarouselMinistry
 * @package Blocks\PACarouselMinistry
 */
class PACarouselMinistry extends Block
{

  public function __construct()
  {
    parent::__construct([
      'title'     => __('IASD - Feature Slider - Ministry', 'iasd'),
      'description' => __('Block to feature content in slider format.', 'iasd'),
      'category'     => 'pa-adventista',
      'keywords'     => ['spotlight', 'carousel', 'slider'],
      'icon'       => '<svg id="Icons" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">
								.st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
								</style><polyline class="st0" points="25,11 27,13 25,15 "/><polyline class="st0" points="7,11 5,13 7,15 "/><path class="st0" d="M29,23H3c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h26c1.1,0,2,0.9,2,2v16C31,22.1,30.1,23,29,23z"/><circle class="st0" cx="16" cy="28" r="1"/><circle class="st0" cx="10" cy="28" r="1"/><circle class="st0" cx="22" cy="28" r="1"/></svg>',
    ]);
  }

  /**
   * setFields Register ACF fields with WordPlate/Acf lib
   *
   * @return array Fields array
   */
  protected function setFields(): array
  {
    return [
      Text::make( __( 'Title', 'iasd' ), 'title' )
        ->defaultValue( __( 'IASD - Feature Slider - Ministry', 'iasd' ) ),

      Select::make( __( 'Ativar Autoplay', 'iasd' ), 'active_autoplay' )
        ->choices(
          [
            '0' => 'Não',
            '1' => 'Sim',
          ]
        )
        ->returnFormat( 'value' )
        ->defaultValue( 'Não' ),

      LocalData::make( __( 'Itens', 'iasd' ), 'items' )
        ->postTypes( [ 'page', 'post', 'projects' ] )
        ->hideFields( [ 'content' ] )
        ->manualFields(
          [
            Text::make( __( 'Tag', 'iasd' ), 'tag' )
          ]
        )
        ->initialLimit( 4 ),
    ];
  }

  /**
   * with Inject fields values into template
   *
   * @return array
   */
  public function with(): array
  {
    $active_autoplay = get_field('active_autoplay') == '0' ? FALSE : '2500';
    
    return [
      'title'    => get_field( 'title' ),
      'items'    => get_field( 'items' )[ 'data' ],
      'autoplay' => $active_autoplay,
    ];
  }
}
