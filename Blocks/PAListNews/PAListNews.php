<?php

namespace Blocks\PAListNews;

use Blocks\Block;
use Blocks\Extended\LocalData;
use Blocks\Extended\RemoteData;
use Blocks\Fields\Source;
use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Select;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\TrueFalse;

/**
 * Class PAListNews
 * @package Blocks\PAListNews
 */
class PAListNews extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'IASD - Lista notícias',
            'description' => 'Lista de Notícias',
            'category' 	  => 'pa-adventista',
            'post_types'  => ['post', 'page'],
			'keywords' 	  => ['list', 'news'],
			'icon' 		  => '<svg id="Icons" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">
								.st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
								</style><polyline class="st0" points="25,11 27,13 25,15 "/><polyline class="st0" points="7,11 5,13 7,15 "/><path class="st0" d="M29,23H3c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h26c1.1,0,2,0.9,2,2v16C31,22.1,30.1,23,29,23z"/><circle class="st0" cx="16" cy="28" r="1"/><circle class="st0" cx="10" cy="28" r="1"/><circle class="st0" cx="22" cy="28" r="1"/></svg>',
        ]);
    }
	
	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return [
			Select::make('Formato', 'block_format')
				->choices([
					'1/3' => '1/3',
					'2/3' => '2/3',
				])
				->defaultValue('2/3')
				->wrapper([
					'width' => 50,
				]),
			Source::make()
				->wrapper([
					'width' => 50,
				]),

			Text::make('Título', 'title')
				->defaultValue('IASD - Lista notícias'),

			RemoteData::make('Itens', 'items_remote')
				->endpoints([
					'https://api.adventistas.org/noticias/pt/posts > Posts',
				])
				->initialLimit(4)
				->getFields([
					'featured_media_url',
					'excerpt',
				])
				->filterTaxonomies([
					'xtt-pa-sedes',
					'xtt-pa-editorias',
					'xtt-pa-departamentos',
					'xtt-pa-projetos',
				])
				->conditionalLogic([
					ConditionalLogic::if('source')->equals('remote')
				]),
			LocalData::make('Itens', 'items_local')
				->initialLimit(4)
				->postTypes(['post'])
				->conditionalLogic([
					ConditionalLogic::if('source')->equals('local')
				]),

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
			'block_type'  => field('block_type'),
            'title'  	  => field('title'),
			'items' 	  => field('source') == 'remote' ? field('items_remote')['data'] : field('items_local')['data'],
			'enable_link' => field('enable_link'),
			'link'    	  => field('link'),
        ];
    }

}