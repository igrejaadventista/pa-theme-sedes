<?php

namespace Blocks;

use \Blocks\PACarouselFeature\PACarouselFeature;
use Blocks\PAFacebookFeature\PAFacebookFeature;
use Blocks\PATwitterFeature\PATwitterFeature;

/**
 * Blocks Register blocks and manage settings
 */
class Blocks {

	public function __construct() {
        \add_filter('acf_gutenblocks/blocks', [$this, 'registerBlocks']);
		\add_filter('acf_gutenblocks/render_block_frontend_path', [$this, 'blocksFrontendPath']);
		\add_filter('acf_gutenblocks/blade_engine_callable', [$this, 'bladeEngineCallable']);
		
		\add_filter('blade/view/paths', [$this, 'bladeViewPaths']);

		\add_action('acf/include_field_types', 	array($this, 'registerPlugins'));
		
		require_once('Directives.php');
    }
	
	/**
	 * registerBlocks Import and register new blocks
	 *
	 * @param  array $blocks Registered blocks
	 * @return array All registered blocks
	 */
	public function registerBlocks(array $blocks): array {
		$newBlocks = [
			PACarouselFeature::class,
			PATwitterFeature::class,
			PAFacebookFeature::class,
		];
	
		// Merge registered blocks with new blocks
		return array_merge($blocks, $newBlocks);
	}
	
	/**
	 * blocksFrontendPath Set blocks view path
	 *
	 * @param  string $path Original path
	 * @return string Modified path to view
	 */
	public function blocksFrontendPath(string $path): string {
		// Remove file extension and unnecessary part of path
		return str_replace('.blade.php', '', strstr($path, 'Blocks'));
	}
	
	/**
	 * bladeEngineCallable Set callable to render blade templates
	 *
	 * @return string Callable name
	 */
	public function bladeEngineCallable(): string {
		return '\Blocks\block';
	}
	
	/**
	 * bladeViewPaths Set base path to blade views
	 *
	 * @return string New path to blade views
	 */
	public function bladeViewPaths(): string {
		// Set theme base path
		return \get_template_directory();
	}

	public function registerPlugins() {
		include_once('Plugins/RemoteData/RemoteData.php');
	}

}

if(!\function_exists('block')) {
    /**
     * Render blade templates
     *
     * @param string $view Template path
     * @param array $data Data injected into template
     *
     * @return string Template content
     */
    function block(string $view, array $data = []): string {
        return blade($view, $data, false);
    }
}
