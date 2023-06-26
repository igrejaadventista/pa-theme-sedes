<?php

namespace Fields;

use Extended\ACF\ConditionalLogic;
use Extended\ACF\Fields\Link;
use Extended\ACF\Fields\TrueFalse;

class MoreContent {

	public static function make() {
		return [
			TrueFalse::make(__('More content', 'iasd'), 'enable_link')
				->stylisedUi(__('Enable', 'iasd'), __('Disable', 'iasd')),
			Link::make('Link', 'link')
				->conditionalLogic([
					ConditionalLogic::where('enable_link', '==', 1)
				]),
		];
	}

}
