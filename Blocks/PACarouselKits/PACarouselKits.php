<?php

namespace Blocks\PACarouselKits;

use Blocks\Block;
use ExtendedLocal\RemoteData;
use Extended\ACF\Fields\Text;

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
    if (!is_admin()) {
      $kits = get_field('items')['data'];

      if (empty($kits)) {
        $kits = array();
      }

      $items = array_filter($kits, function ($item) {
        return substr($item['id'], 0, 1) === "m";
      });

      array_map(function ($item) use (&$items) {
        if (array_key_exists('acf', $item) && array_key_exists('downloads_kits', $item['acf']))
          $items = array_merge($items, $item['acf']['downloads_kits']);
      }, $kits);

      return [
        'title' => get_field('title'),
        'items' => $items,
      ];
    } else {
      return array();
    }
  }
}
