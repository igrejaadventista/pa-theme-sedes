<?php

namespace Blocks\PAFacebook;

use Blocks\Block;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Url;

/**
 * Class PAFacebook
 * @package Blocks\PAFacebook
 */
class PAFacebook extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => __('IASD - Facebook', 'iasd'),
            'description' => __('IASD Facebok block.', 'iasd'),
            'category' 	  => 'pa-adventista',
			'keywords' 	  => ['facebook', 'embeded'],
			'icon' 		  => 'facebook-alt',
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
					->defaultValue(__('IASD - Facebook', 'iasd')),
                Url::make('Url', 'url')
					->instructions(__('Facebook page URL.', 'iasd')),
			];
	}
	    
    /**
     * with Inject fields values into template
     *
     * @return array
     */
    public function with(): array {
		wp_enqueue_script('facebook', 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v10.0', []);

        return [
            'title'  => get_field('title'),
			'url' => get_field('url')
        ];
    }
}
