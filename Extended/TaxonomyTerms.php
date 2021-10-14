<?php

namespace Extended;

use WordPlate\Acf\Fields\Field;
use WordPlate\Acf\Fields\Attributes\ConditionalLogic;
use WordPlate\Acf\Fields\Attributes\DefaultValue;
use WordPlate\Acf\Fields\Attributes\Instructions;
use WordPlate\Acf\Fields\Attributes\Nullable;
use WordPlate\Acf\Fields\Attributes\Required;
use WordPlate\Acf\Fields\Attributes\Wrapper;

/**
 * Register Taxonomy Terms field
 */
class TaxonomyTerms extends Field {

  use ConditionalLogic;
  use DefaultValue;
  use Instructions;
  use Nullable;
  use Required;
  use Wrapper;

  protected $type = 'acfe_taxonomy_terms';

	/**
	 * taxonomies Allowed terms
	 *
	 * @param  array $value Terms limit
	 * @return self
	 */
	public function allowTerms(array $value): self {
    $this->config->set('allow_terms', $value);

    return $this;
  }

  /**
	 * taxonomies Allowed taxonomies
	 *
	 * @param  array $value Taxonomies limit
	 * @return self
	 */
	public function taxonomies(array $value): self {
    $this->config->set('taxonomy', $value);

    return $this;
  }

  /**
	 * fieldType Field display type
	 *
	 * @param  string $value Type key
	 * @return self
	 */
	public function fieldType(string $value): self {
    if(!in_array($value, ['checkbox', 'radio', 'select']))
      throw new \InvalidArgumentException("Invalid argument return format [$value].");

    $this->config->set('field_type', $value);

    return $this;
  }
  
  /**
   * stylisedUi Improved field interface
   *
   * @return self
   */
  public function stylisedUi(): self {
    $this->config->set('ui', true);

    return $this;
  }
  
  /**
   * saveTerms Connects selected terms to the post object
   *
   * @param  mixed $saveTerms True to connect
   * @return self
   */
  public function saveTerms(bool $saveTerms = true): self {
    $this->config->set('save_terms', $saveTerms);

    return $this;
  }
  
  /**
   * loadTerms Loads selected terms from the post object
   *
   * @param  mixed $loadTerms True to connect
   * @return self
   */
  public function loadTerms(bool $loadTerms = true): self {
    $this->config->set('load_terms', $loadTerms);

    return $this;
  }

  /**
   * useAjax Add AJAX option
   *
   * @return self
   */
  public function useAjax(): self {
    $this->config->set('ajax', true);

    return $this;
  }

  /**
   * multiple Select multiple values
   *
   * @return self
   */
  public function multiple(): self {
    $this->config->set('multiple', true);

    return $this;
  }

  /**
   * placeholder Set placeholder
   *
   * @return self
   */
  public function placeholder(string $value): self {
    $this->config->set('placeholder', $value);

    return $this;
  }

  /**
   * @param string $format array, id, label, object, url or value
   * @throws \InvalidArgumentException
   * @return static
   */
  public function returnFormat(string $format): self {
      if(!in_array($format, ['object', 'name', 'id']))
        throw new \InvalidArgumentException("Invalid argument return format [$format].");

      $this->config->set('return_format', $format);

      return $this;
  }

}
