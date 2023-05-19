<?php

namespace Blocks\PATwitter;

use Blocks\Block;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Url;

/**
 * Class PATwitter
 * @package Blocks\PATwitter
 */
class PATwitter extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'IASD - Twitter',
            'description' => 'IASD Twitter block.',
            'category' 	  => 'pa-adventista',
			'keywords' 	  => ['twitter', 'embeded'],
			'icon' 		  => 'twitter',
        ]);
    }

	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return 
			[
				Text::make(__('Title', 'iasd'), 'title')
					->defaultValue('IASD - Twitter'),
                Url::make('Url', 'url'),
			];
	}

    /**
     * with Inject fields values into template
     *
     * @return array
     */
    public function with(): array {
		wp_enqueue_script('twitter', 'https://platform.twitter.com/widgets.js', []);
		
        return [
            'title'  => get_field('title'),
			'url' => get_field('url')
        ];
    }
}
