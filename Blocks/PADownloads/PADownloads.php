<?php

namespace Blocks\PADownloads;

use Blocks\Block;
use Blocks\Extended\RemoteData;
use Blocks\Fields\MoreContent;
use WordPlate\Acf\Fields\Select;
use WordPlate\Acf\Fields\Text;

/**
 * Class PADownloads
 * @package Blocks\PADownloads
 */
class PADownloads extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'IASD - Downloads',
            'description' => 'Lista de arquivos para download',
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
		return array_merge(
			[
				Select::make('Formato', 'block_format')
					->choices([
						'1/3' => '1/3',
						'full' => 'full',
					])
					->defaultValue('full'),

				Text::make('Título', 'title')
					->defaultValue('IASD - Downloads'),

				RemoteData::make('Itens', 'items')
					->endpoints([
						'https://api.adventistas.org/downloads/pt/posts > Posts',
						// 'https://api.adventistas.org/downloads/pt/kits > Kits',
					])
					->initialLimit(4)
					->getFields([
						'featured_media_url',
						'excerpt',
					])
					->manualFields([
						Text::make('Formato de arquivo', 'file_format'),
						Text::make('Tamanho de arquivo', 'file_size'),
					])
					->filterTaxonomies([
						'xtt-pa-sedes',
						'xtt-pa-departamentos',
						'xtt-pa-projetos',
						'xtt-pa-kits',
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
            'title' => field('title'),
            'items' => field('items'),
        ];
    }
}