<?php

namespace Blocks\PASevenCast;

use Blocks\Block;
use ExtendedLocal\RemoteData;
use Fields\MoreContent;
use Extended\ACF\Fields\Text;

/**
 * Class PASevenCast
 * @package Blocks\PASevenCast
 */
class PASevenCast extends Block {

	public function __construct() {
		// Set block settings
		parent::__construct([
			'title' 	  => 'IASD - 7Cast',
			'description' => 'Block to show 7cast content in list format.',
			'category' 	  => 'pa-adventista',
			'keywords' 	  => ['podcast', '7', 'seven'],
			'icon' 		  => 'microphone',
		]);
	}

	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {

		$api = "https://". API_7CAST ."/7cast/". LANG ."/pa-blocks";

		return array_merge(
			[
				Text::make(__('Title', 'iasd'), 'title')
					->defaultValue('IASD - 7Cast'),

				RemoteData::make(__('Itens', 'iasd'), 'items')
					->endpoints([
						$api
						
						// 'https://api.adv.st/7cast/pt/pa-blocks'
					])
					->initialLimit(4)
					->searchFilter(false)
					->canSticky(false)
					->manualItems(false)
					->filterFields(false),			
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
		$title = get_field('title');
		$items = null;
		$items_field = get_field('items');
	
		if ($items_field !== null) {
			$items = $items_field['data'];
		}
	
		$enable_link = get_field('enable_link');
		$link = get_field('link');
	
		return [
			'title'        => $title,
			'items'        => $items,
			'enable_link'  => $enable_link,
			'link'         => $link,
		];
	}
}
