<?php

namespace Blocks\PAListIcons;

use Blocks\Block;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\Repeater;
use Extended\ACF\Fields\Text;

/**
 * Class PAListIcons
 * @package Blocks\PAListIcons
 */
class PAListIcons extends Block
{

  public function __construct()
  {
    // Set block settings
    parent::__construct([
      'title'       => __('IASD - Icons - List', 'iasd'),
      'description' => __('Block to show contents in list format with icons.', 'iasd'),
      'category'    => 'pa-adventista',
      'keywords'    => ['category', 'select'],
      'icon'        => '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								width="32px" height="32px" viewBox="0 0 297.114 297.114" style="enable-background:new 0 0 297.114 297.114;" xml:space="preserve">
								<g>
									<path d="M247.869,56.499L193.586,2.197C192.179,0.791,190.271,0,188.282,0H54.549c-4.143,0-7.5,3.357-7.5,7.5v282.114
										c0,4.143,3.357,7.5,7.5,7.5h188.016c4.143,0,7.5-3.357,7.5-7.5V61.802C250.065,59.813,249.275,57.906,247.869,56.499z
											M224.462,54.302h-28.681v-28.69L224.462,54.302z M62.049,282.114V15h118.732v46.802c0,4.143,3.357,7.5,7.5,7.5h46.783v212.813
										H62.049z"/>
									<path d="M211.228,94.039h-78.34c-4.143,0-7.5,3.357-7.5,7.5s3.357,7.5,7.5,7.5h78.34c4.143,0,7.5-3.357,7.5-7.5
										S215.371,94.039,211.228,94.039z"/>
									<path d="M101.553,94.039h-8.167v-8.173c0-4.143-3.357-7.5-7.5-7.5s-7.5,3.357-7.5,7.5v15.673c0,4.143,3.357,7.5,7.5,7.5h15.667
										c4.143,0,7.5-3.357,7.5-7.5S105.696,94.039,101.553,94.039z"/>
									<path d="M211.228,141.057h-78.34c-4.143,0-7.5,3.357-7.5,7.5c0,4.143,3.357,7.5,7.5,7.5h78.34c4.143,0,7.5-3.357,7.5-7.5
										C218.728,144.414,215.371,141.057,211.228,141.057z"/>
									<path d="M101.553,141.057h-8.167v-8.172c0-4.143-3.357-7.5-7.5-7.5s-7.5,3.357-7.5,7.5v15.672c0,4.143,3.357,7.5,7.5,7.5h15.667
										c4.143,0,7.5-3.357,7.5-7.5C109.053,144.414,105.696,141.057,101.553,141.057z"/>
									<path d="M211.228,188.075h-78.34c-4.143,0-7.5,3.357-7.5,7.5c0,4.143,3.357,7.5,7.5,7.5h78.34c4.143,0,7.5-3.357,7.5-7.5
										C218.728,191.433,215.371,188.075,211.228,188.075z"/>
									<path d="M101.553,188.075h-8.167v-8.172c0-4.143-3.357-7.5-7.5-7.5s-7.5,3.357-7.5,7.5v15.672c0,4.143,3.357,7.5,7.5,7.5h15.667
										c4.143,0,7.5-3.357,7.5-7.5C109.053,191.433,105.696,188.075,101.553,188.075z"/>
									<path d="M211.228,235.094h-78.34c-4.143,0-7.5,3.357-7.5,7.5c0,4.143,3.357,7.5,7.5,7.5h78.34c4.143,0,7.5-3.357,7.5-7.5
										C218.728,238.451,215.371,235.094,211.228,235.094z"/>
									<path d="M101.553,235.094h-8.167v-8.173c0-4.143-3.357-7.5-7.5-7.5s-7.5,3.357-7.5,7.5v15.673c0,4.143,3.357,7.5,7.5,7.5h15.667
										c4.143,0,7.5-3.357,7.5-7.5C109.053,238.451,105.696,235.094,101.553,235.094z"/>
								</g>
								</svg>',
      // Other valid acf_register_block() settings
    ]);
  }

  /**
   * setFields Register ACF fields with WordPlate/Acf lib
   *
   * @return array Fields array
   */
  protected function setFields(): array
  {
    return [
      Text::make(__('Title', 'iasd'), 'title')
        ->defaultValue(__('IASD - Icons - List', 'iasd')),
      Repeater::make(__('Itens', 'iasd'), 'items')
        ->fields([
          Text::make(__('Icon', 'iasd'), 'icon')
            ->instructions('Access <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&s=solid&m=free" target="_blank">icon list</a>, and select an icon and insert the respective css class here.', 'iasd')
            ->placeholder('fas fa-ad')
            ->wrapper([
              'width' => 50,
            ]),
          Link::make(__('Link', 'iasd'), 'link')
            ->wrapper([
              'width' => 50,
            ]),
        ])
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
  public function with(): array
  {
    return [
      'title' => get_field('title'),
      'items' => get_field('items'),
    ];
  }
}
