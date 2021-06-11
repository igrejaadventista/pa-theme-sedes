<?php

namespace Blocks\Fields;

use WordPlate\Acf\Fields\ButtonGroup;

class Source {

	public static function make(bool $local = true, bool $custom = true, array $choices = []) {
		if($local)
			$choices['local'] = 'Local';
		if($local)
			$choices['custom'] = 'Manual';

		return 
			ButtonGroup::make('Fonte de conteúdos', 'source')
				->instructions('Selecione de onde o conteúdo será trazido')
				->choices($choices)
				->required();
	}

}