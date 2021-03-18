<?php

namespace Blocks\PACarouselFeature;

use Itineris\AcfGutenblocks\AbstractBlock;

class PACarouselFeature extends AbstractBlock {

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
		return [
			'key' => 'group_carousel_feature',
			'fields' => [
				[
					'key' => 'carousel_feature_title',
					'name' => 'carousel_feature_title',
					'label' => 'Título',
					'type' => 'text'
				],
			],
			'location' => [
				[
					[
						'param' => 'block',
						'operator' => '==',
						'value' => 'acf/p-a-carousel-feature'
					]
				],
			]
		];
	}

    /**
     * Make $items available to your template
     */
    public function with(): array {
        return [
            'title' => get_field('carousel_feature_title'),
        ];
    }
}