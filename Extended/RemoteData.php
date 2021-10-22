<?php

namespace Extended;

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
	 * endpoints Set the endpoints where information will be fetched
	 *
	 * @param  array $values Endpoints urls
	 * @return self
	 */
	public function endpoints(array $values): self {
        $this->config->set('endpoints', $values);

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

	/**
	 * ManualItems Additional manual fields
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function manualItems(bool $value): self {
        $this->config->set('manual_items', intval($value));

        return $this;
    }

	/**
	 * searchFilter Enable/disable search
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function searchFilter(bool $value): self {
        $this->config->set('search_filter', intval($value));

        return $this;
    }

	/**
	 * limitFilter Enable/disable limit
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function limitFilter(bool $value): self {
        $this->config->set('limit_filter', intval($value));

        return $this;
    }

	/**
	 * canSticky Enable/disable sticky button
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function canSticky(bool $value): self {
        $this->config->set('can_sticky', intval($value));

        return $this;
    }

	/**
	 * filterFields Enable/disable filter fields returned by api
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function filterFields(bool $value): self {
        $this->config->set('filter_fields', intval($value));

        return $this;
    }

	/**
	 * hideFields Hide fixed fields, except title and link
	 *
	 * @param  array $values Fields array
	 * @return self
	 */
	public function hideFields(array $values): self {
        $this->config->set('hide_fields', $values);

        return $this;
    }

}
