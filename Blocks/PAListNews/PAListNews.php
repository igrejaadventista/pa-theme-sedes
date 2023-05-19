<?php

namespace Blocks\PAListNews;

use Blocks\Block;
use ExtendedLocal\LocalData;
use ExtendedLocal\RemoteData;
use Fields\MoreContent;
use Fields\Source;
use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;

/**
 * Class PAListNews
 * @package Blocks\PAListNews
 */
class PAListNews extends Block
{

  public function __construct()
  {
    // Set block settings
    parent::__construct([
      'title'     => __('IASD - News - List', 'iasd'),
      'description' => __('Block to show news content in list format.', 'iasd'),
      'category'     => 'pa-adventista',
      'keywords'     => ['list', 'news'],
      'icon'       => 'megaphone',
    ]);
  }

  /**
   * setFields Register ACF fields with WordPlate/Acf lib
   *
   * @return array Fields array
   */
  protected function setFields(): array
  {

    $api = "https://" . API_PA . "/noticias/" . LANG . "/posts";

    return array_merge(
      [
        Select::make(__('Format', 'iasd'), 'block_format')
          ->choices([
            '1/3' => '1/3',
            '2/3' => '2/3',
          ])
          ->defaultValue('2/3')
          ->wrapper([
            'width' => 50,
          ]),
        Source::make()
          ->wrapper([
            'width' => 50,
          ]),

        Text::make(__('Title', 'iasd'), 'title')
          ->defaultValue(__('IASD - News - List', 'iasd')),

        RemoteData::make(__('Itens', 'iasd'), 'items_remote')
          ->endpoints([
            $api . ' > Posts',

            // 'https://api.adventistas.org/noticias/pt/posts > Posts',
          ])
          ->initialLimit(4)
          ->getFields([
            'featured_media_url',
            'excerpt',
            'terms'
          ])
          ->manualFields([
            Text::make(__('Post format', 'iasd'), 'post_format')
              ->wrapper([
                'width' => 50,
              ]),
            Text::make('Editorial', 'editorial')
              ->wrapper([
                'width' => 50,
              ]),
          ])
          ->filterTaxonomies([
            'xtt-pa-sedes',
            'xtt-pa-editorias',
            'xtt-pa-departamentos',
            'xtt-pa-projetos',
          ])
          ->conditionalLogic([
            ConditionalLogic::where('source', '==', 'remote')
          ]),
        LocalData::make(__('Itens', 'iasd'), 'items_local')
          ->initialLimit(4)
          ->postTypes(['post'])
          ->manualFields([
            Text::make(__('Post format', 'iasd'), 'post_format')
              ->wrapper([
                'width' => 50,
              ]),
            Text::make(__('Editorial', 'iasd'), 'editorial')
              ->wrapper([
                'width' => 50,
              ]),
          ])
          ->conditionalLogic([
            ConditionalLogic::where('source', '==', 'local')
          ]),
      ],
      MoreContent::make()
    );
  }

  /**
   * with Inject fields values into template
   *
   * @return array
   */
  public function with(): array
  {
    return [
      'block_format'  => get_field('block_format'),
      'title'         => get_field('title'),
      'items'         => get_field('source') == 'remote' ? get_field('items_remote')['data'] : get_field('items_local')['data'],
      'enable_link'   => get_field('enable_link'),
      'link'          => get_field('link'),
    ];
  }
}
