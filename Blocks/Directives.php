<?php

use Illuminate\Support\Str;

blade_directive('notempty', function($expression) {
	if(Str::contains($expression, ',')) {
		$expression = collect(explode(',', $expression, PHP_INT_MAX))
			->map(function ($item) {
				return trim($item);
			});

		return "<?php if (! empty({$expression->get(0)})) : ?>" .
			   "<?php echo {$expression->get(1)}; ?>" .
			   "<?php endif; ?>";
	}

	return "<?php if (! empty({$expression})) : ?>";
});

blade_directive('endnotempty', function() {
	return "<?php endif; ?>";
});