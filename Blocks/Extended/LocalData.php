<?php

namespace Blocks\Extended;

use WordPlate\Acf\Fields\Field;
use WordPlate\Acf\Fields\Attributes\ConditionalLogic;
use WordPlate\Acf\Fields\Attributes\Instructions;
use WordPlate\Acf\Fields\Attributes\Wrapper;

/**
 * Register new local data field
 */
class LocalData extends Field {

    use ConditionalLogic;
    use Instructions;
    use Wrapper;

    protected $type = 'localposts_data';

	/**
	 * initialLimit Initial number of items to be returned
	 *
	 * @param  int $value Items limit
	 * @return self
	 */
	public function initialLimit(int $value): self {
        $this->config->set('limit', $value);

        return $this;
    }

	/**
	 * manualFields Post types to query
	 *
	 * @param  array $values Post types array
	 * @return self
	 */
	public function postTypes(array $values): self {
        $this->config->set('post_type', $values);

        return $this;
    }

	/**
	 * manualFields Additional manual fields
	 *
	 * @param  array $values Fields array
	 * @return self
	 */
	public function manualFields(array $values): self {
        $this->config->set('sub_fields', $values);

        return $this;
    }

}
