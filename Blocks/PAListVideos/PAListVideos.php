<?php

namespace Blocks\PAListVideos;

use Blocks\Block;
use ExtendedLocal\RemoteData;
use Fields\MoreContent;
use Extended\ACF\Fields\Number;
use Extended\ACF\Fields\Select;
use Extended\ACF\Fields\Text;

/**
 * Class PAListVideos
 * @package Blocks\PAListVideos
 */
class PAListVideos extends Block
{

  public function __construct()
  {
    // Set block settings
    parent::__construct([
      'title'     => __('IASD - Videos - List(A)', 'iasd'),
      'description' => __('Block to show videos content in list format.', 'iasd'),
      'category'     => 'pa-adventista',
      'keywords'     => ['list', 'video'],
      'icon'       => 'playlist-video',
    ]);
  }

  /**
   * setFields Register ACF fields with WordPlate/Acf lib
   *
   * @return array Fields array
   */
  protected function setFields(): array
  {

    $api = "https://" . API_PA . "/videos/" . LANG . "/posts";

    return array_merge(
      [
        Select::make(__('Format', 'iasd'), 'block_format')
          ->choices([
            '1/3' => '1/3',
            '2/3' => '2/3',
          ])
          ->defaultValue('2/3'),

        Text::make(__('Title', 'iasd'), 'title')
          ->defaultValue(__('IASD - Videos - List', 'iasd')),

        RemoteData::make(__('Itens', 'iasd'), 'items')
          ->endpoints([
            $api . ' > Posts',

            // 'https://api.adventistas.org/videos/pt/posts',
          ])
          ->initialLimit(5)
          ->getFields([
            'featured_media_url',
            'excerpt',
            'acf'
          ])
          ->manualFields([
            Number::make(__('Time (in seconds)', 'iasd'), 'time'),
          ])
          ->filterTaxonomies([
            'xtt-pa-sedes',
            'xtt-pa-departamentos',
            'xtt-pa-projetos',
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
    $block_format = get_field('block_format');
    $title = get_field('title');
    $items = null;
    $items_field = get_field('items');
    
    if ($items_field !== null) {
        $items = $items_field['data'];
    }
    
    $enable_link = get_field('enable_link');
    $link = get_field('link');
    
    return [
        'block_format'  => $block_format,
        'title'         => $title,
        'items'         => $items,
        'enable_link'   => $enable_link,
        'link'          => $link,
    ];
  }
}
