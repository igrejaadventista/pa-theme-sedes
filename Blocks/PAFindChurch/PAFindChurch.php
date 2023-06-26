<?php

namespace Blocks\PAFindChurch;

use Blocks\Block;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class PAFindChurch
 * @package Blocks\PAFindChurch
 */
class PAFindChurch extends Block {

  public function __construct() {
    // Set block settings
    parent::__construct([
      'title'       => __('IASD - Find church', 'iasd'),
      'description' => __('Block to show a box to find a church.', 'iasd'),
      'category'    => 'pa-adventista',
      'keywords'    => ['find'],
      'icon'        => 'search',
    ]);
  }

  /**
   * setFields Register ACF fields with WordPlate/Acf lib
   *
   * @return array Fields array
   */
  protected function setFields(): array {
    return [
      Repeater::make(__('Quick access', 'iasd'), 'quick_access')
        ->fields([
          Text::make(__('Icon', 'iasd'), 'icon')
            ->instructions('Access <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&s=solid&m=free" target="_blank">icon list</a>, and select an icon and insert the respective css class here.', 'iasd')
            ->placeholder('fas fa-bookmark')
            ->defaultValue('fas fa-bookmark')
            ->wrapper([
              'width' => 50,
            ]),
          Link::make(__('Link', 'iasd'), 'link')
            ->wrapper([
              'width' => 50,
            ]),
          Text::make(__('Title', 'iasd'), 'title'),
          Text::make(__('Description', 'description'), 'description'),
        ])
        ->min(1)
        ->max(2)
        ->collapsed('link')
        ->buttonLabel(__('Add item', 'iasd'))
        ->layout('block'),
    ];
  }

  /**
   * with Inject fields values into template
   *
   * @return array
   */
  public function with(): array {
    return [
      'quick_access' => get_field('quick_access'),
    ];
  }
}
