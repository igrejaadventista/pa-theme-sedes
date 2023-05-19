<?php

namespace Blocks\PACarouselDownloads;

use Blocks\Block;
use ExtendedLocal\RemoteData;
use Extended\ACF\Fields\Text;

/**
 * Class PACarouselDownloads
 * @package Blocks\PACarouselDownloads
 */
class PACarouselDownloads extends Block
{

  public function __construct()
  {
    // Set block settings
    parent::__construct([
      'title'     => __('IASD - Downloads - Carousel', 'iasd'),
      'description' => __('Block from downloads content on carousel format.', 'iasd'),
      'category'     => 'pa-adventista',
      'keywords'     => ['app', 'download'],
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

    $api = "https://" . API_PA . "/downloads/" . LANG . "/posts";

    return [
      Text::make(__('Title', 'iasd'), 'title')
        ->defaultValue(__('IASD - Downloads - Carousel', 'iasd')),

      RemoteData::make(__('Itens', 'iasd'), 'items')
        ->endpoints([
          $api . ' > Posts',

          // 'https://api.adventistas.org/downloads/pt/posts > Posts',
          // 'https://api.adventistas.org/downloads/pt/kits > Kits',
        ])
        ->initialLimit(5)
        ->getFields([
          'featured_media_url',
          'acf'
        ])
        ->hideFields(['excerpt'])
        ->manualFields([
          Text::make(__('File format', 'iasd'), 'file_format')
            ->placeholder('PDF'),
          Text::make(__('File size', 'iasd'), 'file_size')
            ->placeholder('5mb'),
        ])
        ->filterTaxonomies([
          'xtt-pa-sedes',
          'xtt-pa-departamentos',
          'xtt-pa-projetos',
          'xtt-pa-kits',
        ]),
    ];
  }

  /**
   * with Inject fields values into template
   *
   * @return array
   */
  public function with(): array
  {
    return [
      'title' => get_field('title'),
      'items' => get_field('items')['data'],
    ];
  }
}
