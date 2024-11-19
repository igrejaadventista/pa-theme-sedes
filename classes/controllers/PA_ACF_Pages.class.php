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
               ->instructions( 'Substitui a configuração da sétima coluna especificada nas opções do tema para esta página.' )
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
