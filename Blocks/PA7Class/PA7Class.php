<?php

namespace Blocks\PA7Class;

use Blocks\Block;
use ExtendedLocal\RemoteData;
use Fields\MoreContent;
use Extended\ACF\Fields\Text;

/**
 * Class PA7Class
 * @package Blocks\PA7Class
 */
class PA7Class extends Block {

    public function __construct() {
		  // Set block settings
      parent::__construct([
        'title' 	  => __('IASD - 7Class', 'iasd'),
        'description' => __('Block to show contents from 7Class.', 'iasd'),
        'category' 	  => 'pa-adventista',
        'keywords' 	  => ['news'],
        'icon' 		  => 'admin-links',
      ]);
    }

	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		$api = "https://" . API_PA . "/7class/" . LANG;

		return array_merge(
			[
				Text::make(__('Title', 'iasd'), 'title')
					->defaultValue(__('IASD - 7Class', 'iasd')),

				RemoteData::make(__('Itens', 'iasd'), 'items')
					->endpoints([
						$api .' > Posts',
					])
					->initialLimit(5)
					->getFields(['featured_media_url', 'terms'])
					->hideFields(['excerpt'])
			],
			MoreContent::make()
		);
	}

    /**
     * with Inject fields values into template
     *
     * @return array
     */
    public function with(): array {
      return [
        'title' 	  => get_field('title'),
        'items' 	  => get_field('items')['data'],
        'enable_link' => get_field('enable_link'),
        'link'    	  => get_field('link'),
      ];
    }
}
