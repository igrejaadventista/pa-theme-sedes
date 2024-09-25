<?php

namespace Blocks\PA7Class;

use Blocks\Block;
// use ExtendedLocal\RemoteData;
use Fields\MoreContent;
use Extended\ACF\Fields\Text;
use Extended\ACF\Fields\Select;

/**
 * Class PA7Class
 * @package Blocks\PA7Class
 */
class PA7Class extends Block {

    public function __construct() {
		  // Set block settings
      parent::__construct([
        'title' 	  => __('IASD - 7Class', 'iasd'),
        'description' => __('Block to show contents from 7Class.', 'iasd'),
        'category' 	  => 'pa-adventista',
        'keywords' 	  => ['news'],
        'icon' 		  => 'admin-links',
      ]);
    }

	/**
	 * setFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {

		$response = wp_remote_get('https://api.adventistas.dev/7class/pt');

		if (is_array($response) && !is_wp_error($response)) {
			$json_text = html_entity_decode($response['body']);
			$classes = json_decode($json_text, true);
			$classes = $classes[0]['acf']['classes'];
			// echo '<pre>';
			// var_dump($classes);
			// echo '</pre>';
		}

		$choices = [];
		foreach ($classes as $key => $class) {
			$choices[sanitize_title($class['curso']) . '_' . $key] = $class['curso'];
		}

		// var_dump(['forest_green' => 'Forest Green', 'sky_blue' => 'Sky Blue']);
		// var_dump($choices);

		return array_merge(
			[
				Text::make(__('Title', 'iasd'), 'title')
					->defaultValue(__('IASD - 7 Class', 'iasd')),
				Select::make('Cursos')
					->choices($choices)
					// ->format('value')
					// ->default('forest_green')
					// ->multiple()
					// ->stylized()
					// ->lazyLoad(),
			],
			MoreContent::make()
		);
	}

    /**
     * with Inject fields values into template
     *
     * @return array
     */
    public function with(): array {
      return [
        'title' 	  => get_field('title'),
        'items' 	  => get_field('items')['data'],
        'enable_link' => get_field('enable_link'),
        'link'    	  => get_field('link'),
      ];
    }
}
