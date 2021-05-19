<?php

namespace Blocks;

use Itineris\AcfGutenblocks\AbstractBladeBlock;

use WordPlate\Acf\FieldGroup;
use WordPlate\Acf\Location;

/**
 * Block Base block class
 */
class Block extends AbstractBladeBlock {

	public function __construct(array $settings) {
		\add_filter('acf/register_block_type_args', array($this, 'additionalArgs'));

		parent::__construct($settings);
	}

	/**
	 * registerFields Register ACF fields with WordPlate/Acf lib
	 *
	 * @return array Fields array
	 */
	protected function registerFields(): array {
		return (new FieldGroup([
			'title' => $this->title,
			'fields' => $this->setFields(),
			'location' => [
				Location::if('block', "acf/{$this->name}") // Set fields on this block
			],
		]))->toArray();
	}

	function additionalArgs(array $args)
	{
		if ($args['name'] == "acf/$this->name") :
			$args['example'] = $this->setExample();
			$args['parent'] = ['core/column'];
		endif;

		return $args;
	}

	/**
	 * setFields Set fields to be used on registerFields
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return [];
	}
	
	/**
	 * setExample Set example data to be used on preview
	 *
	 * @return array Example data array
	 */
	protected function setExample(): array {
		return [];
	}

}
