<?php

namespace Fields;

use WordPlate\Acf\Fields\ButtonGroup;

class Source {

	public static function make() {
		return 
			ButtonGroup::make(__('Content source', 'iasd'), 'source')
				->instructions(__('Select where the content will be brought from.', 'iasd'))
				->choices([
					'remote' => __('Remote', 'iasd'),
					'local'  => __('Local', 'iasd'),
				])
				->defaultValue('remote');
	}

}
