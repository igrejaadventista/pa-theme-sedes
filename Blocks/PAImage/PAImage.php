<?php

namespace Blocks\PAImage;

use Blocks\Block;
use Extended\ACF\Fields\Image;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Select;

/**
 * Class PAImage
 * @package Blocks\PAImage
 */
class PAImage extends Block {

  public function __construct() {
    // Set block settings
    parent::__construct([
      'title'       => __('IASD - Image', 'iasd'),
      'description' => __('Block to show a image.', 'iasd'),
      'category'    => 'pa-adventista',
      'keywords'    => ['image'],
      'icon'        => 'format-image',
    ]);
  }

  /**
   * setFields Register ACF fields with WordPlate/Acf lib
   *
   * @return array Fields array
   */
  protected function setFields(): array {
    return [
      Select::make(__('Format', 'iasd'), 'block_format')
        ->choices([
          '1/3'  => '1/3',
          '2/3'  => '2/3',
          'full' => '100%',
        ])
        ->defaultValue('1/3'),
      Image::make(__('Image', 'iasd'), 'image')
          ->returnFormat('id')
          ->wrapper([
            'width' => 50,
          ]),
      Link::make(__('Link', 'iasd'), 'link')
        ->wrapper([
          'width' => 50,
        ])
    ];
  }

  /**
   * with Inject fields values into template
   *
   * @return array
   */
  public function with(): array {
    return [
      'block_format' => get_field('block_format'),
      'image'        => get_field('image'),
      'link'         => get_field('link'),
    ];
  }
}
