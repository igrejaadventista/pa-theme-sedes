<?php

namespace Blocks\PAListDownloads;

use Blocks\Block;
use Blocks\Extended\RemoteData;
use Blocks\Fields\MoreContent;
use WordPlate\Acf\Fields\Text;

/**
 * Class PAListDownloads
 * @package Blocks\PAListDownloads
 */
class PAListDownloads extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'IASD - Lista de downloads',
            'description' => 'Lista de arquivos para download',
            'category' 	  => 'pa-adventista',
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

		$api = "https://". API_PA ."/downloads/". LANG ."/posts";

		return array_merge(
			[
				Text::make('Título', 'title')
					->defaultValue('IASD - Lista de downloads'),

				RemoteData::make('Itens', 'items')
					->endpoints([
						$api .' > Posts',
						
						// 'https://api.adventistas.org/downloads/pt/posts > Posts',
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
            'title' 	  => get_field('title'),
            'items' 	  => get_field('items')['data'],
			'enable_link' => get_field('enable_link'),
			'link'    	  => get_field('link'),
        ];
    }
}