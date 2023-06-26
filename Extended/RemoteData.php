<?php

namespace ExtendedLocal;

use Extended\ACF\Fields\Field;
use Extended\ACF\Fields\Settings\ConditionalLogic;
use Extended\ACF\Fields\Settings\Instructions;
use Extended\ACF\Fields\Settings\Wrapper;

/**
 * Register new remote data field
 */
class RemoteData extends Field {

    use ConditionalLogic;
    use Instructions;
    use Wrapper;

    protected null|string $type = 'remote_data';

	/**
	 * endpoints Set the endpoints where information will be fetched
	 *
	 * @param  array $values Endpoints urls
	 * @return self
	 */
	public function endpoints(array $values): self {
        
        $this->withSettings(array('endpoints' => $values));
        
        return $this;
    }

	/**
	 * initialLimit Initial number of items to be returned
	 *
	 * @param  int $value Items limit
	 * @return self
	 */
	public function initialLimit(int $value): self {
    $this->withSettings(array('limit' => $value));
        
    return $this;
    }

	/**
	 * getFields Set which fields should be returned from the endpoint. The id and title fields are already returned automatically
	 *
	 * @param  array $values Fields keys
	 * @return self
	 */
	public function getFields(array $values): self {
    $this->withSettings(array('fields' => $values));
    return $this;
    }

	/**
	 * filterTaxonomies Set which taxonomies will be available in filters
	 *
	 * @param  array $values Taxonomies slugs
	 * @return self
	 */
	public function filterTaxonomies(array $values): self {
    $this->withSettings(array('taxonomies' => $values));
        return $this;
    }

	/**
	 * manualFields Additional manual fields
	 *
	 * @param  array $values Fields array
	 * @return self
	 */
	public function manualFields(array $values): self {
    $this->withSettings(array('sub_fieldsRemote' => $values));
        return $this;
    }

	/**
	 * ManualItems Additional manual fields
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function manualItems(bool $value): self {
    $this->withSettings(array('manual_items' => intval($value)));
        return $this;
    }

	/**
	 * searchFilter Enable/disable search
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function searchFilter(bool $value): self {
        $this->withSettings(array('search_filter' => intval($value)));
        return $this;
    }

	/**
	 * limitFilter Enable/disable limit
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function limitFilter(bool $value): self {
    $this->withSettings(array('limit_filter' => intval($value)));

        return $this;
    }

	/**
	 * canSticky Enable/disable sticky button
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function canSticky(bool $value): self {
    $this->withSettings(array('can_sticky' => intval($value)));
        return $this;
    }

	/**
	 * filterFields Enable/disable filter fields returned by api
	 *
	 * @param  bool $value Status
	 * @return self
	 */
	public function filterFields(bool $value): self {
    $this->withSettings(array('filter_fields' => intval($value)));
        return $this;
    }

	/**
	 * hideFields Hide fixed fields, except title and link
	 *
	 * @param  array $values Fields array
	 * @return self
	 */
	public function hideFields(array $values): self {
    $this->withSettings(array('hide_fields' => $values));
        return $this;
    }

}
