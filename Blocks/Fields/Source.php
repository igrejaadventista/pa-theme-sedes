<?php

namespace Blocks\Fields;

use WordPlate\Acf\Fields\ButtonGroup;

class Source {

	public static function make() {
		return 
			ButtonGroup::make('Fonte de conteúdos', 'source')
				->instructions('Selecione de onde o conteúdo será trazido')
				->choices([
					'remote' => 'Remoto',
					'local'  => 'Local',
				])
				->defaultValue('remote')
				->required();
	}

}