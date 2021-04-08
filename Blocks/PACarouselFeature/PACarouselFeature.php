<?php

namespace Blocks\PACarouselFeature;

use Blocks\Block;
use Blocks\Fields\Source;

use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\Accordion;
use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Relationship;
use WordPlate\Acf\Fields\Repeater;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;

/**
 * PACarouselFeature Carousel feature block
 */
class PACarouselFeature extends Block {

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
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return 
			[
				Source::make(),
				Text::make('Título', 'title'),
				
				Accordion::make('<span class="dashicons dashicons-admin-page"></span> Slides', 'slides_accordion'),
				
				Relationship::make('', 'slides')
					->min(1)
                    ->max(4)
					->conditionalLogic([
						ConditionalLogic::if('source')->equals('local')
					]),
                
				Repeater::make('', 'custom_slides')
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
					->conditionalLogic([
						ConditionalLogic::if('source')->equals('custom')
					]),
			];
	}
	    
    /**
     * with Inject fields values into template
     *
     * @return array
     */
    public function with(): array {
		$slides = [];

		if(field('source') == 'custom'):
			$slides = field('custom_slides');
		else:
			$posts = field('slides');

			if(!empty($posts)):
				foreach($posts as $post):
					$thumbnail = \get_post_thumbnail_id($post->ID);
					$slide = [
						'title' => $post->post_title,
						'excerpt' => \get_the_excerpt($post->ID),
						'link' => [
							'url' => \get_permalink($post->ID),
							'target' => '_self',
						],
					];

					if(!empty($thumbnail)):
						$slide['thumbnail'] = [
							'url' => \wp_get_attachment_url($thumbnail),
							'alt' => \get_post_meta($thumbnail, '_wp_attachment_image_alt', true),
						];
					endif;

					$slides[] = $slide;
				endforeach;
			endif;
		endif;

        return [
            'title'  => field('title'),
			'slides' => $slides,
        ];
    }
}