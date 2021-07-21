<?php

namespace Blocks\PAListButtons;

use Blocks\Block;
use Blocks\Extended\LocalData;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\TrueFalse;

/**
 * Class PAListButtons
 * @package Blocks\PAListButtons
 */
class PAListButtons extends Block {

	public function __construct() {
		// Set block settings
		parent::__construct( [
			'title'       => 'IASD - Lista em botões',
			'description' => 'Box contendo lista de links',
			'category'    => 'pa-adventista',
			'post_types'  => [ 'post', 'page' ],
			'keywords'    => [ 'list', 'link' ],
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
		] );
	}

	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return [
			Text::make('Título', 'title')
				->defaultValue('IASD - Lista em botões'),
			LocalData::make('Itens', 'items')
				->postTypes(['projetos'])
				->initialLimit(4)
				->hideFields(['content', 'featured_media_url']),
			
			TrueFalse::make('Mais conteúdo', 'enable_link')
				->stylisedUi('Habilitado', 'Desabilitado')
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
			'title'       => field('title'),
			'items'       => field('items')['data'],
			'enable_link' => field('enable_link'),
			'link'    	  => field('link'),
		];
	}
}