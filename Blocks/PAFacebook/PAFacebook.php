<?php

namespace Blocks\PAFacebook;

use Blocks\Block;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Url;

/**
 * Class PAFacebook
 * @package Blocks\PAFacebook
 */
class PAFacebook extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'IASD - Facebook',
            'description' => 'Incorpore componentes de uma Página do Facebook',
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
				Text::make('Título', 'title')
					->defaultValue('IASD - Facebook'),
                Url::make('Url', 'url')
					->instructions('URL da página do Facebook'),
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
            'title'  => field('title'),
			'url' => field('url')
        ];
    }
}