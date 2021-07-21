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
			'icon' 		  => 'megaphone',
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
				->manualFields([
					Text::make('Formato de post', 'post_format')
						->wrapper([
							'width' => 50,
						]),
					Text::make('Editoria', 'editorial')
						->wrapper([
							'width' => 50,
						]),
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
				->manualFields([
					Text::make('Formato de post', 'post_format')
						->wrapper([
							'width' => 50,
						]),
					Text::make('Editoria', 'editorial')
						->wrapper([
							'width' => 50,
						]),
				])
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
			'block_format' => field('block_format'),
            'title'  	   => field('title'),
			'items' 	   => field('source') == 'remote' ? field('items_remote')['data'] : field('items_local')['data'],
			'enable_link'  => field('enable_link'),
			'link'    	   => field('link'),
        ];
    }

}