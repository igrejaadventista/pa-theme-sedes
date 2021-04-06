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

class PACarouselFeature extends AbstractBladeBlock {

    public function __construct() {
        parent::__construct([
            'title' => 'Carousel - Feature',
            'description' => 'Carrossel de destaques',
            'category' => 'formatting',
            'post_types' => ['post', 'page'],
            // Other valid acf_register_block() settings
        ]);
    }

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
				Location::if('block', 'acf/p-a-carousel-feature')
			],
		]))->toArray();
	}

    /**
     * Make $items available to your template
     */
    public function with(): array {
        return [
            'title'  => field('carousel_feature_title'),
			'slides' => field('carousel_feature_slides'),
        ];
    }
}