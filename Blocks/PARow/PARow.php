<?php

namespace Blocks\PARow;

use Blocks\Block;

/**
 * Class PAApps
 * @package Blocks\PAApps
 */
class PARow extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => __('IASD - Row', 'iasd'),
            'description' => __('Block to group IASD blocks.', 'iasd'),
            'category' 	  => 'pa-adventista',
			'keywords' 	  => ['app', 'download'],
			'icon' 		  => '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><path d="M19 6H6c-1.1 0-2 .9-2 2v9c0 1.1.9 2 2 2h13c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-4.1 1.5v10H10v-10h4.9zM5.5 17V8c0-.3.2-.5.5-.5h2.5v10H6c-.3 0-.5-.2-.5-.5zm14 0c0 .3-.2.5-.5.5h-2.6v-10H19c.3 0 .5.2.5.5v9z"></path></svg>',
        ]);
    }
	
	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return [];
	}

	protected function setAllowedBlocks(): array {
		return [
			'acf/p-a-apps',
			'acf/p-a-carousel-feature',
			'acf/p-a-carousel-ministry',
			'acf/p-a-facebook',
			'acf/p-a-list-buttons',
			'acf/p-a-list-icons',
			'acf/p-a-list-items',
			'acf/p-a-magazines',
			'acf/p-a-seven-cast',
			'acf/p-a-twitter',
		];
	}

	public function with(): array {
		return [];
	}
	    
}