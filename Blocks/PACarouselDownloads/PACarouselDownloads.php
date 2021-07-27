<?php

namespace Blocks\PACarouselDownloads;

use Blocks\Block;
use Blocks\Extended\RemoteData;
use WordPlate\Acf\Fields\Text;

/**
 * Class PACarouselDownloads
 * @package Blocks\PACarouselDownloads
 */
class PACarouselDownloads extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'IASD - Carrossel de downloads',
            'description' => 'Carrossel de arquivos para download',
            'category' 	  => 'pa-adventista',
            'post_types'  => ['post', 'page'],
			'keywords' 	  => ['app', 'download'],
			'icon' 		  => 'download',
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
				->defaultValue('IASD - Carrossel de downloads'),

			RemoteData::make('Itens', 'items')
				->endpoints([
					'https://api.adventistas.org/downloads/pt/posts > Posts',
					// 'https://api.adventistas.org/downloads/pt/kits > Kits',
				])
				->initialLimit(5)
				->getFields(['featured_media_url'])
				->hideFields(['excerpt'])
				->manualFields([
					Text::make('Formato de arquivo', 'file_format')
						->placeholder('PDF'),
					Text::make('Tamanho de arquivo', 'file_size')
						->placeholder('5mb'),
				])
				->filterTaxonomies([
					'xtt-pa-sedes',
					'xtt-pa-departamentos',
					'xtt-pa-projetos',
					'xtt-pa-kits',
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
            'title' => field('title'),
            'items' => field('items')['data'],
        ];
    }
}