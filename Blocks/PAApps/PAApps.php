<?php

namespace Blocks\PAApps;

use Blocks\Block;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\Text;
use WordPlate\Acf\Fields\Textarea;

/**
 * Class PAApps
 * @package Blocks\PAApps
 */
class PAApps extends Block {

    public function __construct() {
		// Set block settings
        parent::__construct([
            'title' 	  => 'IASD - Apps',
            'description' => 'App',
            'category' 	  => 'pa-adventista',
            'post_types'  => ['post', 'page'],
			'keywords' 	  => ['app', 'download'],
			'icon' 		  => '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								width="32px" height="32px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
							<g>
								<g>
									<path d="M371.093,0H149.227c-18.773,0-34.133,15.36-34.133,34.133v443.733c0,18.773,15.36,34.133,34.133,34.133h221.867
										c18.773,0,34.133-15.36,34.133-34.133V34.133C405.227,15.36,389.867,0,371.093,0z M388.16,477.867
										c0,9.387-7.68,17.067-17.067,17.067H149.227c-9.387,0-17.067-7.68-17.067-17.067V34.133c0-9.387,7.68-17.067,17.067-17.067
										h221.867c9.387,0,17.067,7.68,17.067,17.067V477.867z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M115.093,51.2v392.533h290.133V51.2H115.093z M388.16,426.667h-256v-358.4h256V426.667z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M294.293,25.6h-42.667c-5.12,0-8.533,3.413-8.533,8.533c0,5.12,3.413,8.533,8.533,8.533h42.667
										c5.12,0,8.533-3.413,8.533-8.533C302.827,29.013,299.413,25.6,294.293,25.6z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M226.027,25.6h-8.533c-5.12,0-8.533,3.413-8.533,8.533c0,5.12,3.413,8.533,8.533,8.533h8.533
										c5.12,0,8.533-3.413,8.533-8.533C234.56,29.013,231.147,25.6,226.027,25.6z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M115.093,76.8c-5.12,0-8.533,3.413-8.533,8.533v8.533c0,5.12,3.413,8.533,8.533,8.533c5.12,0,8.533-3.413,8.533-8.533
										v-8.533C123.627,80.213,120.213,76.8,115.093,76.8z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M115.093,110.933c-5.12,0-8.533,3.413-8.533,8.533V128c0,5.12,3.413,8.533,8.533,8.533c5.12,0,8.533-3.413,8.533-8.533
										v-8.533C123.627,114.347,120.213,110.933,115.093,110.933z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M115.093,145.067c-5.12,0-8.533,3.413-8.533,8.533v8.533c0,5.12,3.413,8.533,8.533,8.533c5.12,0,8.533-3.413,8.533-8.533
										V153.6C123.627,148.48,120.213,145.067,115.093,145.067z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M260.16,435.2c-18.773,0-34.133,15.36-34.133,34.133c0,18.773,15.36,34.133,34.133,34.133s34.133-15.36,34.133-34.133
										C294.293,450.56,278.933,435.2,260.16,435.2z M260.16,486.4c-9.387,0-17.067-7.68-17.067-17.067s7.68-17.067,17.067-17.067
										s17.067,7.68,17.067,17.067S269.547,486.4,260.16,486.4z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M208.96,102.4h-34.133c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533v-34.133C217.493,105.813,214.08,102.4,208.96,102.4z M200.427,136.533H183.36v-17.067h17.067
										V136.533z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M277.227,102.4h-34.133c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533v-34.133C285.76,105.813,282.347,102.4,277.227,102.4z M268.693,136.533h-17.067v-17.067h17.067
										V136.533z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M208.96,170.667h-34.133c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533V179.2C217.493,174.08,214.08,170.667,208.96,170.667z M200.427,204.8H183.36v-17.067h17.067
										V204.8z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M277.227,170.667h-34.133c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533V179.2C285.76,174.08,282.347,170.667,277.227,170.667z M268.693,204.8h-17.067v-17.067h17.067
										V204.8z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M345.493,170.667H311.36c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533V179.2C354.027,174.08,350.613,170.667,345.493,170.667z M336.96,204.8h-17.067v-17.067h17.067
										V204.8z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M345.493,102.4H311.36c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533v-34.133C354.027,105.813,350.613,102.4,345.493,102.4z M336.96,136.533h-17.067v-17.067h17.067
										V136.533z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M208.96,238.933h-34.133c-5.12,0-8.533,3.413-8.533,8.533V281.6c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533v-34.133C217.493,242.347,214.08,238.933,208.96,238.933z M200.427,273.067H183.36V256h17.067
										V273.067z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M277.227,238.933h-34.133c-5.12,0-8.533,3.413-8.533,8.533V281.6c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533v-34.133C285.76,242.347,282.347,238.933,277.227,238.933z M268.693,273.067h-17.067V256h17.067
										V273.067z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M208.96,307.2h-34.133c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533v-34.133C217.493,310.613,214.08,307.2,208.96,307.2z M200.427,341.333H183.36v-17.067h17.067
										V341.333z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M277.227,307.2h-34.133c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533v-34.133C285.76,310.613,282.347,307.2,277.227,307.2z M268.693,341.333h-17.067v-17.067h17.067
										V341.333z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M345.493,307.2H311.36c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533v-34.133C354.027,310.613,350.613,307.2,345.493,307.2z M336.96,341.333h-17.067v-17.067h17.067
										V341.333z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M345.493,238.933H311.36c-5.12,0-8.533,3.413-8.533,8.533V281.6c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533v-34.133C354.027,242.347,350.613,238.933,345.493,238.933z M336.96,273.067h-17.067V256h17.067
										V273.067z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M345.493,384H174.827c-5.12,0-8.533,3.413-8.533,8.533c0,5.12,3.413,8.533,8.533,8.533h170.667
										c5.12,0,8.533-3.413,8.533-8.533C354.027,387.413,350.613,384,345.493,384z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M80.96,34.133c-14.507,0-25.6-11.093-25.6-25.6c0-11.093-17.067-11.093-17.067,0c0,14.507-11.093,25.6-25.6,25.6
										C1.6,34.133,1.6,51.2,12.693,51.2c14.507,0,25.6,11.093,25.6,25.6c0,11.093,17.067,11.093,17.067,0
										c0-14.507,11.093-25.6,25.6-25.6C92.053,51.2,92.053,34.133,80.96,34.133z M46.827,51.2c-2.56-3.413-5.12-5.973-8.533-8.533
										c3.413-2.56,5.973-5.12,8.533-8.533c2.56,3.413,5.12,5.973,8.533,8.533C51.947,45.227,49.387,47.787,46.827,51.2z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M464.96,119.467c-5.12,0-8.533,3.413-8.533,8.533v34.133c0,5.12,3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533V128
										C473.493,122.88,470.08,119.467,464.96,119.467z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M482.027,136.533h-34.133c-5.12,0-8.533,3.413-8.533,8.533c0,5.12,3.413,8.533,8.533,8.533h34.133
										c5.12,0,8.533-3.413,8.533-8.533C490.56,139.947,487.147,136.533,482.027,136.533z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M63.893,366.933c-5.12,0-8.533,3.413-8.533,8.533S58.773,384,63.893,384s8.533-3.413,8.533-8.533
										S69.013,366.933,63.893,366.933z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M21.227,213.333c-5.12,0-8.533,3.413-8.533,8.533s3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533
										S26.347,213.333,21.227,213.333z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M439.36,298.667c-5.12,0-8.533,3.413-8.533,8.533s3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533
										S444.48,298.667,439.36,298.667z"/>
								</g>
							</g>
							<g>
								<g>
									<path d="M499.093,477.867c-5.12,0-8.533,3.413-8.533,8.533s3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533
										S504.213,477.867,499.093,477.867z"/>
								</g>
							</g>
							</svg>',
        ]);
    }
	
	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return [
			Text::make('Título', 'title')
				->defaultValue('IASD - Apps'),
			Textarea::make('Descrição', 'description'),
			Link::make('Botão', 'link'),
		];
	}
	    
    /**
     * with Inject fields values into template
     *
     * @return array
     */
    public function with(): array {
        return [
            'title'  	  => field('title'),
			'description' => field('description'),
			'link' 		  => field('link'),
        ];
    }
}