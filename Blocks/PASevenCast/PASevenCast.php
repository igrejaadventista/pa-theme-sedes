<?php

namespace Blocks\PASevenCast;

use Blocks\Block;
use Blocks\Extended\RemoteData;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\TrueFalse;

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
		return [
			Text::make('Título', 'title')
				->defaultValue('IASD - 7Cast'),

			RemoteData::make('Itens', 'items')
				->endpoints(['https://api.adv.st/7cast/pt/pa-blocks'])
				->initialLimit(4)
				->searchFilter(false)
				->canSticky(false)
				->manualItems(false)
				->filterFields(false),

			TrueFalse::make('Mais conteúdo', 'enable_link')
				->stylisedUi('Habilitar', 'Desabilitar')
				->wrapper([
					'width' => 50,
				]),
			Link::make('Link', 'link')
				->conditionalLogic([
					ConditionalLogic::if('enable_link')->equals(1)
				])
				->wrapper([
					'width' => 50,
				]),
		];
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
