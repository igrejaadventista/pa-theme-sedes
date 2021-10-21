<?php

namespace Fields;

use WordPlate\Acf\ConditionalLogic;
use WordPlate\Acf\Fields\Link;
use WordPlate\Acf\Fields\TrueFalse;

class MoreContent {

	public static function make() {
		return [
			TrueFalse::make(__('More content', 'iasd'), 'enable_link')
				->stylisedUi(__('Enable', 'iasd'), __('Disable', 'iasd')),
			Link::make('Link', 'link')
				->conditionalLogic([
					ConditionalLogic::if('enable_link')->equals(1)
				]),
		];
	}

}
