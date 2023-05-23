<?php

namespace Blocks\PAListDownloads;

use Blocks\Block;
use ExtendedLocal\RemoteData;
use Fields\MoreContent;
use Extended\ACF\Fields\Text;

/**
 * Class PAListDownloads
 * @package Blocks\PAListDownloads
 */
class PAListDownloads extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => __('IASD - Downloads - List', 'iasd'),
            'description' => __('Block to show downloads contents in list format.', 'iasd'),
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
				Text::make(__('Title', 'iasd'), 'title')
					->defaultValue(__('IASD - Downloads - Buttons', 'iasd')),

				RemoteData::make(__('Itens', 'iasd'), 'items')
					->endpoints([
						$api .' > Posts',
						
						// 'https://api.adventistas.org/downloads/pt/posts > Posts',
						// 'https://api.adventistas.org/downloads/pt/kits > Kits',
					])
					->initialLimit(5)
					->getFields(['featured_media_url'])
					->hideFields(['excerpt'])
					->manualFields([
						Text::make(__('File format', 'iasd'), 'file_format')
							->placeholder('PDF'),
						Text::make(__('File size', 'iasd'), 'file_size')
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
    public function with(): array
	{
		$title = get_field('title');
		$items = null;
		$items_field = get_field('items');
	
		if ($items_field !== null) {
			$items = $items_field['data'];
		}
	
		$enable_link = get_field('enable_link');
		$link = get_field('link');
	
		return [
			'title'        => $title,
			'items'        => $items,
			'enable_link'  => $enable_link,
			'link'         => $link,
		];
	}
	
}
