<?php

namespace Blocks\PACarouselKits;

use Blocks\Block;
use Extended\RemoteData;
use WordPlate\Acf\Fields\Text;

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
      Text::make(__('Title', 'iasd'), 'title')
        ->defaultValue(__('IASD - Kits - Carousel', 'iasd')),

      RemoteData::make(__('Itens', 'iasd'), 'items')
        ->endpoints([
          $api . ' > Posts',
        ])
        ->initialLimit(5)
        ->getFields([
          'featured_media_url',
          'acf'
        ])
        ->hideFields(['excerpt'])
        ->filterTaxonomies([
          'xtt-pa-departamentos',
          'xtt-pa-projetos',
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
