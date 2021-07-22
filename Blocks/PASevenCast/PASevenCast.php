<?php

namespace Blocks\PASevenCast;

use Blocks\Block;
use Blocks\Extended\RemoteData;
use Blocks\Fields\MoreContent;
use WordPlate\Acf\Fields\Text;

/**
 * Class PASevenCast
 * @package Blocks\PASevenCast
 */
class PASevenCast extends Block {

	public function __construct() {
		// Set block settings
		parent::__construct([
			'title' 	  => 'IASD - 7Cast',
			'description' => 'Lista de podcasts',
			'category' 	  => 'pa-adventista',
			'post_types'  => ['post', 'page'],
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
		return array_merge(
			[
				Text::make('Título', 'title')
					->defaultValue('IASD - 7Cast'),

				RemoteData::make('Itens', 'items')
					->endpoints(['https://api.adv.st/7cast/pt/pa-blocks'])
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
	public function with(): array {
		return [
			'title'			=> field('title'),
			'items'			=> field('items')['data'],
			'enable_link' 	=> field('enable_link'),
			'link'			=> field('link')
		];
	}
}
