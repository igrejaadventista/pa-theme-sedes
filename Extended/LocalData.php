<?php

namespace ExtendedLocal;

use Extended\ACF\Fields\Field;
use Extended\ACF\Fields\Settings\ConditionalLogic;
use Extended\ACF\Fields\Settings\Wrapper;
use Extended\ACF\Fields\Settings\Instructions;
/**
 * Register new local data field
 */
class LocalData extends Field {

    use ConditionalLogic;
    use Instructions;
    use Wrapper;

    protected null|string $type = 'localposts_data';

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
	 * postTypes Post types to query
	 *
	 * @param  array $values Post types array
	 * @return self
	 */
	public function postTypes(array $values): self {
    $this->withSettings(array('post_type' => $values));

        return $this;
    }

	/**
	 * manualFields Additional manual fields
	 *
	 * @param  array $values Fields array
	 * @return self
	 */
	public function manualFields(array $values): self {
        $this->withSettings(array('sub_fieldsLocal' => $values));
 
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

	/**
	 * ManualItems Enable/disable manual items
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
	 * filterTaxonomies Set which taxonomies will be available in filters
	 *
	 * @param  array $values Taxonomies slugs
	 * @return self
	 */
	public function filterTaxonomies(array $values): self {
    $this->config->set('taxonomies', $values);

    return $this;
  }

}
