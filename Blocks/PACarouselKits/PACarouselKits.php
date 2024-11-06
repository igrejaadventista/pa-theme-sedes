<?php

namespace Blocks\PACarouselKits;

use Blocks\Block;
use ExtendedLocal\RemoteData;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Select;

/**
 * Class PACarouselKits
 * @package Blocks\PACarouselKits
 */
class PACarouselKits extends Block
{

  public function __construct()
  {
    // Set block settings
    parent::__construct([
      'title'     => __('IASD - Kits - Carousel', 'iasd'),
      'description' => __('Block from kits content on carousel format.', 'iasd'),
      'category'     => 'pa-adventista',
      'keywords'     => ['app', 'kit'],
      'icon'       => 'download',
    ]);
  }

  /**
   * setFields Register ACF fields with WordPlate/Acf lib
   *
   * @return array Fields array
   */
  protected function setFields(): array
  {

    $api = "https://" . API_PA . "/downloads/" . LANG . "/kit";

    return [
      Text::make( __( 'Title', 'iasd' ), 'title' )
          ->defaultValue( __( 'IASD - Kits - Carousel', 'iasd' ) ),

      Select::make( __( 'Posição das Setas de Nevagação', 'iasd' ), 'nav_position' )
        ->choices(
          [
            '0' => 'Ao lado dos cards',
            '1' => 'A baixo dos cards',
            '2' => 'Sem setas de navegação'
          ]
        )
        ->returnFormat( 'value' )
        ->defaultValue( 'A baixo dos cards' ),

      Select::make( __( 'Formato de exibição dos Cards', 'iasd' ), 'display_format' )
        ->choices(
          [
            '0' => 'Completos',
            '1' => 'Parciais',
          ]
        )
        ->returnFormat( 'value' )
        ->defaultValue( 'Cards visiveis completamente' ),

      Select::make( __( 'Ativar Autoplay', 'iasd' ), 'active_autoplay' )
        ->choices(
          [
            '0' => 'Não',
            '1' => 'Sim',
          ]
        ),

      RemoteData::make( __( 'Itens', 'iasd' ), 'items' )
        ->endpoints(
          [
            $api . ' > Posts',
          ]
        )
        ->initialLimit( 5 )
        ->getFields(
          [
            'featured_media_url',
            'acf'
          ]
        )
        ->hideFields( [ 'excerpt' ] )
        ->filterTaxonomies(
          [
            'xtt-pa-departamentos',
            'xtt-pa-projetos',
          ]
        ),
    ];
  }

  /**
   * with Inject fields values into template
   *
   * @return array
   */
  public function with(): array
  {
    if ( ! is_admin() ) 
    {
      $kits            = get_field( 'items' )[ 'data' ];
      $nav_position    = get_field( 'nav_position' ) == '0' ? 'pa-arrows-up' : 
                         ( get_field( 'nav_position' ) == 1 ? '' : NULL ) ;
      $display_format  = get_field( 'display_format' ) == '0' ? '0' : '100';
      $active_autoplay = get_field( 'active_autoplay' ) == '0' ? FALSE : '2500';

      if ( empty( $kits ) ) 
      {
        $kits = array();
      }

      $items = array_filter( $kits, function ( $item ) 
      {
        return substr( $item[ 'id' ], 0, 1 ) === "m";
      });

      array_map(
        function ( $item ) use ( &$items ) 
        {
          if ( array_key_exists( 'acf', $item ) && array_key_exists( 'downloads_kits', $item[ 'acf' ] ) )
          {
            $items = array_merge( $items, $item[ 'acf' ][ 'downloads_kits' ] );
          }
        }, $kits
      );

      return [
        'title'           => get_field( 'title' ),
        'nav_position'    => $nav_position,
        'display_format'  => $display_format,
        'active_autoplay' => $active_autoplay,
        'items'           => $items,
      ];
    } 
    else 
    {
      return array();
    }
  }
}
