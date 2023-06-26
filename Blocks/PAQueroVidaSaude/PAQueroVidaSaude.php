<?php

namespace Blocks\PAQueroVidaSaude;

use Blocks\Block;
use ExtendedLocal\RemoteData;
use Fields\MoreContent;
use Extended\ACF\Fields\Text;

/**
 * Class PAQueroVidaSaude
 * @package Blocks\PAQueroVidaSaude
 */
class PAQueroVidaSaude extends Block {

    public function __construct() {
		  // Set block settings
      parent::__construct([
        'title' 	  => __('IASD - Quero vida e saúde', 'iasd'),
        'description' => __('Block to show contents from https://querovidaesaude.com/.', 'iasd'),
        'category' 	  => 'pa-adventista',
        'keywords' 	  => ['news'],
        'icon' 		  => 'admin-links',
      ]);
    }
	
	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {

		$api = "https://". API_PA ."/qvs/". LANG ."/posts";

		return array_merge(
			[
				Text::make(__('Title', 'iasd'), 'title')
					->defaultValue(__('IASD - Quero vida e saúde', 'iasd')),

				RemoteData::make(__('Itens', 'iasd'), 'items')
					->endpoints([
						$api .' > Posts',
					])
					->initialLimit(5)
					->getFields(['featured_media_url', 'terms'])
					->hideFields(['excerpt'])
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
