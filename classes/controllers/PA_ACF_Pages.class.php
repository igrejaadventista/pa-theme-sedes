<?php

use Extended\ACF\Fields\TrueFalse;
use Extended\ACF\Location;

class PaAcfPages
{
  /**
   * The prefix for page field
   *
   * @var string
   */
  private static string $prefix = 'page_';

  /**
   * The posttype for page
   *
   * @var string
   */
  private static string $post_type = 'page';
  
  
  public function __construct()
  {
    add_action('after_setup_theme', [$this, 'createFields']);
  }

  function generalFields(): array
  {
    return [
      TrueFalse::make( '', self::$prefix . 'seventhcolumn' )
               ->instructions( 'Sobrescreve a opção da sétima coluna definida no TEMA nesta página' )
               ->stylisedUi( 'Sim', 'Não' )
               ->defaultValue( false ),
    ];
  }

  function createFields(): void
  {
    $fields = array_merge(
      $this->generalFields(),
    );

    register_extended_field_group(
      [
        'title'    => 'Opções da Página',
        'style'    => 'seamless',
        'fields'   => $fields,
        'location' => [
          Location::where( 'post_type', 'page' ),
        ],
      ]
    );
  }

//  function register_meta_box()
//  {
//    add_meta_box( 
//      self::$group[ 'key' ], 
//      'Sétima Coluna', 
//      [ $this, 'render_meta_box' ], 
//      self::$post_type, 
//      'side', 
//      'high' );
//  }
//
//  function render_meta_box( $post )
//  {
//    acf_form(
//      array(
//        'form'    => false,
//        'post_id' => $post->ID
//      )
//    );
//  }
}

$PaAcfPages = new PaAcfPages();
