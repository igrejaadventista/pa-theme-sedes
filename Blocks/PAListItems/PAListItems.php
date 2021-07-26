<?php

namespace Blocks\PAListItems;

use Blocks\Block;
use Blocks\Extended\LocalData;
use Blocks\Fields\MoreContent;
use WordPlate\Acf\Fields\Text;

/**
 * Class PAListItems
 * @package Blocks\PAListItems
 */
class PAListItems extends Block {

	public function __construct() {
		// Set block settings
		parent::__construct( [
			'title'       => 'IASD - Lista itens',
			'description' => 'Lista de itens',
			'category'    => 'pa-adventista',
			'post_types'  => [ 'post', 'page' ],
			'keywords'    => [ 'list', 'slider' ],
			'icon'        => '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" 
								width="32px" height="32px" viewBox="0 0 490.1 490.1" style="enable-background:new 0 0 490.1 490.1;" xml:space="preserve">
								<g>
									<g>
										<path d="M32.1,141.15h76.7c17.7,0,32.1-14.4,32.1-32.1v-76.7c0-17.7-14.4-32.1-32.1-32.1H32.1C14.4,0.25,0,14.65,0,32.35v76.7
											C0,126.75,14.4,141.15,32.1,141.15z M24.5,32.35c0-4.2,3.4-7.6,7.6-7.6h76.7c4.2,0,7.6,3.4,7.6,7.6v76.7c0,4.2-3.4,7.6-7.6,7.6
											H32.1c-4.2,0-7.6-3.4-7.6-7.6V32.35z"/>
										<path d="M0,283.45c0,17.7,14.4,32.1,32.1,32.1h76.7c17.7,0,32.1-14.4,32.1-32.1v-76.7c0-17.7-14.4-32.1-32.1-32.1H32.1
											c-17.7,0-32.1,14.4-32.1,32.1V283.45z M24.5,206.65c0-4.2,3.4-7.6,7.6-7.6h76.7c4.2,0,7.6,3.4,7.6,7.6v76.7c0,4.2-3.4,7.6-7.6,7.6
											H32.1c-4.2,0-7.6-3.4-7.6-7.6V206.65z"/>
										<path d="M0,457.75c0,17.7,14.4,32.1,32.1,32.1h76.7c17.7,0,32.1-14.4,32.1-32.1v-76.7c0-17.7-14.4-32.1-32.1-32.1H32.1
											c-17.7,0-32.1,14.4-32.1,32.1V457.75z M24.5,381.05c0-4.2,3.4-7.6,7.6-7.6h76.7c4.2,0,7.6,3.4,7.6,7.6v76.7c0,4.2-3.4,7.6-7.6,7.6
											H32.1c-4.2,0-7.6-3.4-7.6-7.6V381.05z"/>
										<path d="M477.8,31.75H202.3c-6.8,0-12.3,5.5-12.3,12.3c0,6.8,5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3
											C490.1,37.25,484.6,31.75,477.8,31.75z"/>
										<path d="M477.8,85.15H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3
											C490,90.65,484.6,85.15,477.8,85.15z"/>
										<path d="M477.8,206.05H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3
											C490,211.55,484.6,206.05,477.8,206.05z"/>
										<path d="M477.8,259.55H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3
											C490,265.05,484.6,259.55,477.8,259.55z"/>
										<path d="M477.8,380.45H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5c6.8,0,12.3-5.5,12.3-12.3
											C490,385.95,484.6,380.45,477.8,380.45z"/>
										<path d="M490,446.15c0-6.8-5.5-12.3-12.3-12.3H202.3c-6.8,0-12.3,5.5-12.3,12.3s5.5,12.3,12.3,12.3h275.5
											C484.6,458.35,490,452.85,490,446.15z"/>
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
		return array_merge(
			[
				Text::make('Título', 'title')
					->defaultValue('IASD - Lista itens'),

				LocalData::make('Itens', 'items')
				->postTypes(['post', 'projetos'])
				->initialLimit(3)
				->hideFields(['content']),
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
			'title'       => field('title'),
			'items'       => field('items')['data'],
			'enable_link' => field('enable_link'),
			'link'    	  => field('link'),
		];
	}
}