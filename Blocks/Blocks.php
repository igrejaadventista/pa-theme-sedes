<?php

namespace Blocks;

use Blocks\PAApps\PAApps;
use Blocks\PAListButtons\PAListButtons;
use Blocks\PAMagazines\PAMagazines;
use Blocks\PACarouselFeature\PACarouselFeature;
use Blocks\PAListIcons\PAListIcons;
use Blocks\PAFacebook\PAFacebook;
use Blocks\PAListItems\PAListItems;
use Blocks\PATwitter\PATwitter;
use Blocks\PACarouselMinistry\PACarouselMinistry;
use Blocks\PAFeliz7Play\PAFeliz7Play;
use Blocks\PAListNews\PAListNews;
use Blocks\PARow\PARow;
use Blocks\PASevenCast\PASevenCast;

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
		\add_action('enqueue_block_editor_assets', array($this, 'enqueueAssets'));
		\add_filter('block_categories', array($this, 'addCategory'));

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
			PATwitter::class,
			PAFacebook::class,
			PAListIcons::class,
			PAListItems::class,
			PAApps::class,
			PAMagazines::class,
			PAListButtons::class,
			PACarouselMinistry::class,
			PASevenCast::class,
			PARow::class,
			PAListNews::class,
			PAFeliz7Play::Class
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
		include_once('Plugins/LocalData/LocalData.php');
		include_once('Plugins/RemoteData/RemoteData.php');
	}

	function enqueueAssets() {
		wp_enqueue_style('blocks-stylesheet', get_template_directory_uri() . '/Blocks/assets/styles/blocks.css', array(), \wp_get_theme()->get('Version'), 'all');

		wp_enqueue_script('blocks-script', get_template_directory_uri() . '/Blocks/assets/scripts/blocks.js', array('wp-hooks', 'wp-blocks', 'wp-dom-ready'));
	}

	function addCategory($categories) {
		return array_merge(
			$categories,
			array(
				array(
					'slug' => 'pa-adventista',
					'title' => 'Adventista',
				),
			)
		);
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
