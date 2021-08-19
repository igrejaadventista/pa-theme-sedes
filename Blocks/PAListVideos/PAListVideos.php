<?php

namespace Blocks\PAListVideos;

use Blocks\Block;
use Blocks\Extended\RemoteData;
use Blocks\Fields\MoreContent;
use WordPlate\Acf\Fields\Number;
use WordPlate\Acf\Fields\Select;
use WordPlate\Acf\Fields\Text;

/**
 * Class PAListVideos
 * @package Blocks\PAListVideos
 */
class PAListVideos extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'IASD - Lista de vídeos',
            'description' => 'Lista de vídeos',
            'category' 	  => 'pa-adventista',
			'keywords' 	  => ['list', 'video'],
			'icon' 		  => 'playlist-video',
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
				Select::make('Formato', 'block_format')
					->choices([
						'1/3' => '1/3',
						'2/3' => '2/3',
					])
					->defaultValue('2/3'),

				Text::make('Título', 'title')
					->defaultValue('IASD - Lista de vídeos'),

				RemoteData::make('Itens', 'items')
					->endpoints([
						'https://api.adventistas.org/videos/pt/posts',
					])
					->initialLimit(5)
					->getFields([
						'featured_media_url',
						'excerpt',
					])
					->manualFields([
						Number::make('Tempo (em segundos)', 'time'),
					])
					->filterTaxonomies([
						'xtt-pa-sedes',
						'xtt-pa-departamentos',
						'xtt-pa-projetos',
					]),
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
			'block_format' => get_field('block_format'),
            'title'  	   => get_field('title'),
			'items' 	   => get_field('items')['data'],
			'enable_link'  => get_field('enable_link'),
			'link'    	   => get_field('link'),
        ];
    }
}