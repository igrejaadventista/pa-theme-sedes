<?php

namespace Blocks\PACarouselFeature;

use Itineris\AcfGutenblocks\AbstractBladeBlock;

use WordPlate\Acf\FieldGroup;
use WordPlate\Acf\Fields\Accordion;
use WordPlate\Acf\Location;

use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Repeater;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;

/**
 * PACarouselFeature Carousel feature block
 */
class PACarouselFeature extends AbstractBladeBlock {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'Carousel - Feature',
            'description' => 'Carrossel de destaques',
            'category' 	  => 'widgets',
            'post_types'  => ['post', 'page'],
			'keywords' 	  => ['carousel', 'slider'],
			'icon' 		  => '<svg id="Icons" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">
								.st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
								</style><polyline class="st0" points="25,11 27,13 25,15 "/><polyline class="st0" points="7,11 5,13 7,15 "/><path class="st0" d="M29,23H3c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h26c1.1,0,2,0.9,2,2v16C31,22.1,30.1,23,29,23z"/><circle class="st0" cx="16" cy="28" r="1"/><circle class="st0" cx="10" cy="28" r="1"/><circle class="st0" cx="22" cy="28" r="1"/></svg>',
            // Other valid acf_register_block() settings
        ]);
    }
	
	/**
	 * registerFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function registerFields(): array {
		return (new FieldGroup([
			'title' => $this->title,
			'fields' => [
				Text::make('Título', 'carousel_feature_title'),
				Accordion::make('<span class="dashicons dashicons-admin-page"></span> Slides', 'carousel_feature_slides_accordion'),
                Repeater::make('', 'carousel_feature_slides')
                    ->fields([
                        Image::make('Thumbnail', 'thumbnail'),
                        Text::make('Título', 'title'),
                        Textarea::make('Resumo', 'excerpt'),
                        Link::make('Link', 'link')
                    ])
                    ->min(1)
                    ->max(4)
                    ->buttonLabel('Adicionar slide')
                    ->collapsed('title')
                    ->layout('block')
			],
			'location' => [
				Location::if('block', 'acf/p-a-carousel-feature') // Set fields on this block
			],
		]))->toArray();
	}
	    
    /**
     * with Inject fields values into template
     *
     * @return array
     */
    public function with(): array {
        return [
            'title'  => field('carousel_feature_title'),
			'slides' => field('carousel_feature_slides'),
        ];
    }
}