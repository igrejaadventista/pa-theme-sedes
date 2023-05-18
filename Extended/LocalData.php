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

  use Wrapper;
  use Instructions;
  use ConditionalLogic;

  protected null|string $type = 'localposts_data';

  /**
   * Set the initial limit of items to be returned.
   *
   * @param int $value Items limit
   * @return self
   */
  public function initialLimit(int $value): self {
    $this->withSettings(['limit' => $value]);

    return $this;
  }

  /**
   * Set the post types to query.
   *
   * @param array $values Post types array
   * @return self
   */
  public function postTypes(array $values): self {
    $this->withSettings(['post_type' => $values]);

    return $this;
  }

  /**
   * Set additional manual fields.
   *
   * @param array $values Fields array
   * @return self
   */
  public function manualFields(array $values): self {
    $this->withSettings(['sub_fields' => $values]);

    return $this;
  }

  /**
   * Hide fixed fields, except title and link.
   *
   * @param array $values Fields array
   * @return self
   */
  public function hideFields(array $values): self {
    $this->withSettings(['hide_fields' => $values]);

    return $this;
  }

  /**
   * Enable/disable manual items.
   *
   * @param bool $value Status
   * @return self
   */
  public function manualItems(bool $value): self {
    $this->withSettings(['manual_items' => intval($value)]);

    return $this;
  }

  /**
   * Enable/disable search filter.
   *
   * @param bool $value Status
   * @return self
   */
  public function searchFilter(bool $value): self {
    $this->withSettings(['search_filter' => intval($value)]);

    return $this;
  }

  /**
   * Enable/disable limit filter.
   *
   * @param bool $value Status
   * @return self
   */
  public function limitFilter(bool $value): self {
    $this->withSettings(['limit_filter' => intval($value)]);

    return $this;
  }

  /**
   * Enable/disable sticky button.
   *
   * @param bool $value Status
   * @return self
   */
  public function canSticky(bool $value): self {
    $this->withSettings(['can_sticky' => intval($value)]);

    return $this;
  }

  /**
   * Set which taxonomies will be available in filters.
   *
   * @param array $values Taxonomies slugs
   * @return self
   */
  public function filterTaxonomies(array $values): self {
    $this->withSettings(['taxonomies' => $values]);

    return $this;
  }
}
