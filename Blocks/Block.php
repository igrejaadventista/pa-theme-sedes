<?php

namespace Blocks;

use Itineris\AcfGutenblocks\AbstractBladeBlock;

use WordPlate\Acf\FieldGroup;
use WordPlate\Acf\Location;

/**
 * Block Base block class
 */
class Block extends AbstractBladeBlock
{

  public function __construct(array $settings)
  {
    \add_filter('acf/register_block_type_args', array($this, 'additionalArgs'));

    parent::__construct($settings);
  }

  /**
   * registerFields Register ACF fields with WordPlate/Acf lib
   *
   * @return array Fields array
   */
  protected function registerFields(): array
  {
    return (new FieldGroup([
      'key' => $this->name,
      'title' => $this->title,
      'fields' => $this->setFields(),
      'location' => [
        Location::if('block', "acf/{$this->name}") // Set fields on this block
      ],
    ]))->toArray();
  }

  function additionalArgs(array $args)
  {
    if ($args['name'] == "acf/$this->name") {
      $args['example']  = $this->setExample();
      $args['supports'] = array(
        'align' => true,
        'mode' => $args['name'] == "acf/p-a-row" ? false : 'auto',
        'jsx' => true
      );

      if (!empty($this->setAllowedBlocks()))
        $args['allowed_blocks'] = $this->setAllowedBlocks();

      if ($args['name'] != "acf/p-a-row")
        $args['parent'] = ['acf/p-a-row'];
    }

    return $args;
  }

  /**
   * setFields Set fields to be used on registerFields
   *
   * @return array Fields array
   */
  protected function setFields(): array
  {
    return [];
  }

  /**
   * setExample Set example data to be used on preview
   *
   * @return array Example data array
   */
  protected function setExample(): array
  {
    return [];
  }

  protected function setAllowedBlocks(): array
  {
    return [];
  }
}
