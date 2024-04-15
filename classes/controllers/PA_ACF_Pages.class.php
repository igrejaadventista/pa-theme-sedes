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
  
  public function __construct()
  {
    add_action('after_setup_theme', [$this, 'createFields']);
  }

  private function generalFields(): array
  {
    return [
      TrueFalse::make( '', self::$prefix . 'seventhcolumn' )
               ->instructions( 'Sobrescreve a opção da sétima coluna definida no TEMA nesta página' )
               ->stylisedUi( 'Sim', 'Não' )
               ->defaultValue( false ),
    ];
  }

  private function createFields(): void
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
}

$PaAcfPages = new PaAcfPages();
