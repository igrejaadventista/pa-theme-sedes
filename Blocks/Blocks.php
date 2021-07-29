<?php

namespace Blocks;

use Blocks\PAApps\PAApps;
use Blocks\PACarouselDownloads\PACarouselDownloads;
use Blocks\PAListButtons\PAListButtons;
use Blocks\PAMagazines\PAMagazines;
use Blocks\PACarouselFeature\PACarouselFeature;
use Blocks\PAListIcons\PAListIcons;
use Blocks\PAFacebook\PAFacebook;
use Blocks\PAListItems\PAListItems;
use Blocks\PATwitter\PATwitter;
use Blocks\PACarouselMinistry\PACarouselMinistry;
use Blocks\PAFeliz7Play\PAFeliz7Play;
use Blocks\PAListDownloads\PAListDownloads;
use Blocks\PAListNews\PAListNews;
use Blocks\PAListVideos\PAListVideos;
use Blocks\PARow\PARow;
use Blocks\PASevenCast\PASevenCast;
use Blocks\Plugins\RemoteData\RemoteData;

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
		\add_filter('block_categories_all', array($this, 'addCategory'));

		require_once('Directives.php');

		\add_action('acf/init', function() {
			if(!is_admin())
				$this->parsePage(558);
		});
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
			PAListDownloads::class,
			PACarouselDownloads::class,
			PAListNews::class,
			PAFeliz7Play::class,
			PAListVideos::class,
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

	// function parsePage($id) {
	// 	if(empty($id))
	// 		return;

	// 	$content = get_post_field('post_content', $id);
	// 	$updatedContent = $content;

	// 	if(!has_blocks($content))
	// 		return;

	// 	$blocks = array();
	// 	foreach(parse_blocks($content) as &$block):
	// 		if($block['blockName'] == 'acf/p-a-row')
	// 			$blocks = array_merge($blocks, $block['innerBlocks']);
	// 	endforeach;

	// 	foreach($blocks as &$block):
	// 		$originalBlock = serialize_block($block);
	// 		var_dump($originalBlock);
	// 		// \acf_setup_meta($block['attrs']['data'], $block['attrs']['id'], true);
    //         // \acf_reset_meta($block['attrs']['id']);

			

	// 		// var_dump($block);
	// 		// $fields = acf_get_block_fields($block['attrs']);
	// 		$fields = array_filter(acf_get_block_fields($block['attrs']), function ($field) {
	// 			return $field['type'] == 'remote_data';
	// 		});

	// 		if(empty($fields))
	// 			continue;

	// 		foreach($fields as &$field):
	// 			// var_dump($field);
	// 			$values = $block['attrs']['data'][$field['name']];
	// 			$values['field_key'] = $field['key'];
	// 			$block['attrs']['data'][$field['name']]['data'] = RemoteData::getData($values)['data'];
				
	// 			// var_dump(RemoteData::getData($values)['data']);
	// 		endforeach;

			
	// 		$updatedBlock = acf_parse_save_blocks(serialize_block($block));
	// 		// var_dump($originalBlock);

	// 		// var_dump(serialize_block($block));
	// 		$updatedContent = str_replace($originalBlock, $updatedBlock, $content);
	// 		// var_dump($updatedContent);
	// 	endforeach;

	// 	if($content != $updatedContent):
	// 		var_dump(123);
	// 		// var_dump(
	// 		// wp_update_post([
	// 		// 	'ID' 		   => $id,
	// 		// 	'post_content' => $updatedContent,
	// 		// ]));
	// 	endif;
	// }

	function parsePage($id) {
		if(empty($id))
			return;

		$content = get_post_field('post_content', $id);
		$hasUpdate = false;

		if(!has_blocks($content))
			return;

		$blocks = parse_blocks($content);
		foreach($blocks as &$block):
			if($block['blockName'] != 'acf/p-a-row')
				continue;

			foreach($block['innerBlocks'] as &$innerBlock):
				$fields = array_filter(acf_get_block_fields($innerBlock['attrs']), function ($field) {
					return $field['type'] == 'remote_data';
				});
	
				if(empty($fields))
					continue;

				$hasUpdate = true;
	
				foreach($fields as &$field):
					$values = $innerBlock['attrs']['data'][$field['name']];
					$values['field_key'] = $field['key'];
					$innerBlock['attrs']['data'][$field['name']]['data'] = RemoteData::getData($values)['results'];
					// $innerBlock['attrs']['data'][$field['name']]['data'] = str_replace("\"", "\\\"", $innerBlock['attrs']['data'][$field['name']]['data']);
					// $innerBlock['attrs']['data'][$field['name']]['data'] = str_replace("/", "\\/", $innerBlock['attrs']['data'][$field['name']]['data']);
					// $innerBlock['attrs']['data'][$field['name']]['data'] = str_replace("[…]", "[&hellip;]", $innerBlock['attrs']['data'][$field['name']]['data']);
					// var_dump($innerBlock['attrs']['data'][$field['name']]['data']);
					// var_dump(strpos($content, $innerBlock['attrs']['data'][$field['name']]['data']));
					// $content = str_replace($innerBlock['attrs']['data'][$field['name']]['data'], RemoteData::getData($values)['data'], $content);
				endforeach;
			endforeach;
		endforeach;

		$updatedContent = serialize_blocks($blocks);
		$replacedString = preg_replace("/u([0-9abcdef]{4})/", "&#x$1;", $updatedContent);
		$unicodeString = mb_convert_encoding($replacedString, 'UTF-8', 'HTML-ENTITIES');
		$unicodeString = str_replace('\n', '\\\n', $unicodeString);
		// var_dump($unicodeString);

		if(!empty($hasUpdate)):
			wp_update_post([
				'ID' 		   => $id,
				'post_content' => $unicodeString,
			]);
		endif;
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
