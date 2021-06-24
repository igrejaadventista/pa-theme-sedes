<?php

namespace Blocks\PARelatedVideosFeature;

use Blocks\Block;
use Blocks\Fields\Source;

use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\Image;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Relationship;
use WordPlate\Acf\Fields\Repeater;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;
use WordPlate\Acf\Fields\TimePicker;

/**
 * Class PAVideosFeature
 * @package Blocks\PAVideosFeature
 */
class PARelatedVideosFeature extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'IASD - Related - Videos',
            'description' => 'Ultimas Notícias',
            'category' 	  => 'pa-adventista',
            'post_types'  => ['post', 'page'],
			'keywords' 	  => ['list', 'video'],
			'icon' 		  => '<svg id="Icons" style="enable-background:new 0 0 32 32;" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">
								.st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
								</style><polyline class="st0" points="25,11 27,13 25,15 "/><polyline class="st0" points="7,11 5,13 7,15 "/><path class="st0" d="M29,23H3c-1.1,0-2-0.9-2-2V5c0-1.1,0.9-2,2-2h26c1.1,0,2,0.9,2,2v16C31,22.1,30.1,23,29,23z"/><circle class="st0" cx="16" cy="28" r="1"/><circle class="st0" cx="10" cy="28" r="1"/><circle class="st0" cx="22" cy="28" r="1"/></svg>',
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
				Relationship::make('', 'videos')
				            ->min(1)
				            ->max(4)
				            ->postTypes(['videos'])
				            ->filters([
					            'search',
					            'sedes'
				            ])
				            ->conditionalLogic([
					            ConditionalLogic::if('source')->equals('local')
				            ]),
				Repeater::make('', 'custom_videos')
                    ->fields([
                        Image::make('Thumbnail', 'thumbnail'),
                        Text::make('Título', 'title'),
                        Link::make('URL', 'link')
	                        ->wrapper([
		                        'width' => 50,
	                        ]),
	                    TimePicker::make('Time', 'time')
	                        ->displayFormat('i:s')
	                        ->returnFormat('i:s')
		                    ->wrapper([
			                    'width' => 50,
		                    ])
                    ])
                    ->min(1)
                    ->max(4)
                    ->buttonLabel('Adicionar video')
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
        return [
            'title'  => field('title'),
			'videos' => field('custom_videos'),
			'custom_videos' => field('videos'),
        ];
    }
}