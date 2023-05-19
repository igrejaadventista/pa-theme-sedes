<?php

namespace Blocks\PAListButtons;

use Blocks\Block;
use ExtendedLocal\LocalData;
use Fields\MoreContent;
use Extended\ACF\Fields\Text;

/**
 * Class PAListButtons
 * @package Blocks\PAListButtons
 */
class PAListButtons extends Block
{

  public function __construct()
  {
    // Set block settings
    parent::__construct([
      'title'       => __('IASD - Button - List', 'iasd'),
      'description' => __('Block with links buttons.', 'iasd'),
      'category'    => 'pa-adventista',
      'keywords'    => ['list', 'link'],
      'icon'        => '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								width="32px" height="32px" viewBox="0 0 488 488" style="enable-background:new 0 0 488 488;" xml:space="preserve">
								<g>
									<g>
										<path d="M64.192,108.444h359.617c29.943,0,54.223-24.278,54.223-54.222C478.031,24.278,453.754,0,423.809,0H64.192
											C34.248,0,9.969,24.278,9.969,54.222C9.969,84.166,34.248,108.444,64.192,108.444z"/>
										<path d="M423.809,189.778H64.192c-29.944,0-54.223,24.278-54.223,54.222c0,29.943,24.278,54.223,54.223,54.223h359.617
											c29.945,0,54.223-24.279,54.223-54.223C478.031,214.056,453.754,189.778,423.809,189.778z"/>
										<path d="M423.809,379.557H64.192c-29.944,0-54.223,24.277-54.223,54.222C9.969,463.722,34.248,488,64.192,488h359.617
											c29.945,0,54.223-24.278,54.223-54.222C478.031,403.834,453.754,379.557,423.809,379.557z"/>
									</g>
								</g>
								</svg>',
    ]);
  }

  /**
   * setFields Register ACF fields with WordPlate/Acf lib
   *
   * @return array Fields array
   */
  protected function setFields(): array
  {
    return array_merge(
      [
        Text::make(__('Title', 'iasd'), 'title')
          ->defaultValue(__('IASD - Buttons - List', 'iasd')),
        LocalData::make(__('Itens', 'iasd'), 'items')
          ->postTypes(['projects'])
          ->initialLimit(4)
          ->hideFields(['content', 'featured_media_url']),
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
      'title'       => get_field('title'),
      'items'       => get_field('items')['data'],
      'enable_link' => get_field('enable_link'),
      'link'        => get_field('link'),
    ];
  }
}
