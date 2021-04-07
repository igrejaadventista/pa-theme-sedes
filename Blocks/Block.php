<?php

namespace Blocks;

use Itineris\AcfGutenblocks\AbstractBladeBlock;

use WordPlate\Acf\FieldGroup;
use WordPlate\Acf\Location;

/**
 * Blocks Register blocks and manage settings
 */
class Block extends AbstractBladeBlock {

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

	/**
	 * setFields Set fields to be used on registerFields
	 *
	 * @return array Fields array
	 */
	protected function setFields(): array {
		return [];
	}

}
