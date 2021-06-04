<?php

namespace Blocks\PACategoryFeature;

use Blocks\Block;
use WordPlate\Acf\Fields\Checkbox;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Message;
use WordPlate\Acf\Fields\Radio;
use WordPlate\Acf\Fields\Repeater;
use WordPlate\Acf\Fields\Taxonomy;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\TrueFalse;
use WordPlate\Acf\Fields\Url;

/**
 * PACategoryFeature Carousel feature block
 */
class PACategoryFeature extends Block {

	public function __construct() {
		// Set block settings
		parent::__construct( [
			'title'       => 'IASD - Category - Feature',
			'description' => 'Categorias',
			'category'    => 'pa-adventista',
			'post_types'  => [ 'post', 'page' ],
			'keywords'    => [ 'category', 'select' ],
			'icon'        => '<svg id="Icons" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">
								.st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
								</style><polyline class="st0" points="25,11 27,13 25,15 "/><polyline class="st0" points="7,11 5,13 7,15 "/><path class="st0" d="M29,23H3c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h26c1.1,0,2,0.9,2,2v16C31,22.1,30.1,23,29,23z"/><circle class="st0" cx="16" cy="28" r="1"/><circle class="st0" cx="10" cy="28" r="1"/><circle class="st0" cx="22" cy="28" r="1"/></svg>',
			// Other valid acf_register_block() settings
		] );
	}

	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return
			[
				Text::make( 'Título do bloco', 'title' ),
				Repeater::make( 'Categorias', 'categories' )
				        ->fields( [
					        Text::make( 'Título do Item', 'itemTitle' ),
					        Url::make( 'URL Link', 'url' ),
					        TrueFalse::make( 'Opção de target do link', 'targetLink' )
						        ->defaultValue(false)
						        ->stylisedUi()
						        ->required(),
					        Text::make( 'Ícone', 'icon' ),
				        ] )
				        ->min( 1 )
				        ->collapsed( 'name' )
				        ->buttonLabel( 'Adicionar Categoria' )
				        ->layout( 'row' )
				        ->required(),
				Message::make('')
					->message('<a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free" target="_blank">Input da classe do ícone</a>'),
			];
	}

	/**
	 * with Inject fields values into template
	 *
	 * @return array
	 */
	public function with(): array {
		return [
			'title'      => field( 'title' ),
			'categories' => field( 'categories' ),
		];
	}
}