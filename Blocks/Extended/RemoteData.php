<?php

namespace Blocks\Extended;

use WordPlate\Acf\Fields\Field;
use WordPlate\Acf\Fields\Attributes\ConditionalLogic;
use WordPlate\Acf\Fields\Attributes\Instructions;
use WordPlate\Acf\Fields\Attributes\Wrapper;

/**
 * Register new remote data field
 */
class RemoteData extends Field {

    use ConditionalLogic;
    use Instructions;
    use Wrapper;

    protected $type = 'remote_data';
	
	/**
	 * endpoint Set the endpoint where information will be fetched
	 *
	 * @param  string $value Endpoint url
	 * @return self
	 */
	public function endpoint(string $value): self {
        $this->config->set('endpoint', $value);

        return $this;
    }
	
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
	 * getFields Set which fields should be returned from the endpoint. The id and title fields are already returned automatically
	 *
	 * @param  array $values Fields keys
	 * @return self
	 */
	public function getFields(array $values): self {
        $this->config->set('fields', $values);

        return $this;
    }
	
	/**
	 * filterTaxonomies Set which taxonomies will be available in filters
	 *
	 * @param  array $values Taxonomies slugs
	 * @return self
	 */
	public function filterTaxonomies(array $values): self {
        $this->config->set('taxonomies', $values);

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
