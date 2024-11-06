<?php

namespace Blocks;

use Blocks\PAApps\PAApps;
use Blocks\PACarouselDownloads\PACarouselDownloads;
use Blocks\PAListButtons\PAListButtons;
use Blocks\PAMagazines\PAMagazines;
use Blocks\PACarouselFeature\PACarouselFeature;
use Blocks\PACarouselKits\PACarouselKits;
use Blocks\PAListIcons\PAListIcons;
use Blocks\PAFacebook\PAFacebook;
use Blocks\PAListItems\PAListItems;
use Blocks\PATwitter\PATwitter;
use Blocks\PACarouselMinistry\PACarouselMinistry;
use Blocks\PAFeliz7Play\PAFeliz7Play;
use Blocks\PAFindChurch\PAFindChurch;
use Blocks\PAImage\PAImage;
use Blocks\PAListDownloads\PAListDownloads;
use Blocks\PAListNews\PAListNews;
use Blocks\PAListVideos\PAListVideos;
use Blocks\PAQueroVidaSaude\PAQueroVidaSaude;
use Blocks\PA7Class\PA7Class;
use Blocks\PARow\PARow;
use Blocks\PASevenCast\PASevenCast;
use Blocks\Plugins\RemoteData\RemoteData;
use IASD\Core\Settings\Modules;
use stdClass;

/**
 * Blocks Register blocks and manage settings
 */
class Blocks
{

    public function __construct()
    {
        \add_filter('acf_gutenblocks/blocks', [$this, 'registerBlocks']);
        \add_filter('acf_gutenblocks/render_block_frontend_path', [$this, 'blocksFrontendPath']);
        \add_filter('acf_gutenblocks/blade_engine_callable', [$this, 'bladeEngineCallable']);

        \add_filter('blade/view/paths', [$this, 'bladeViewPaths']);

        \add_action('acf/include_field_types', array($this, 'registerPlugins'));
        \add_action('enqueue_block_editor_assets', array($this, 'enqueueAssets'));
        \add_filter('block_categories_all', array($this, 'addCategory'));

        require_once('Directives.php');

        \add_filter('cron_schedules', array($this, 'cronAdd'));

        if (!\wp_next_scheduled('PA-update_remote_data')) {
            \wp_schedule_event(time(), 'thirty_minutes', 'PA-update_remote_data');
        }

        \add_action('PA-update_remote_data', array($this, 'UpdateRemoteData'));
        \add_action('wp_ajax_blocks/update_remote_data', array($this, 'UpdateRemoteData'));
    }

    /**
     * registerBlocks Import and register new blocks
     *
     * @param  array $blocks Registered blocks
     * @return array All registered blocks
     */
    public function registerBlocks(array $blocks): array
    {
      if(!Modules::isActiveModule('blocks'))
        return $blocks;

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
            PAListDownloads::class,
            PACarouselDownloads::class,
            PAListNews::class,
            PAFeliz7Play::class,
            PAListVideos::class,
            PAImage::class,
            PAFindChurch::class,
            PACarouselKits::class,
            PAQueroVidaSaude::class,
            PA7Class::class,
        ];

        $newBlocks = array_filter($newBlocks, function ($block) {
          $name = explode('\\', $block);
          $name = last($name);

          return Modules::isActiveModule("block_{$name}");
        });

        if(!in_array('Blocks\PARow\PARow', $blocks))
          $newBlocks[] = PARow::class;

        // Merge registered blocks with new blocks
        return array_merge($blocks, $newBlocks);
    }

    /**
     * blocksFrontendPath Set blocks view path
     *
     * @param  string $path Original path
     * @return string Modified path to view
     */
    public function blocksFrontendPath(string $path): string
    {
        // Remove file extension and unnecessary part of path
        return str_replace('.blade.php', '', strstr($path, 'Blocks'));
    }

    /**
     * bladeEngineCallable Set callable to render blade templates
     *
     * @return string Callable name
     */
    public function bladeEngineCallable(): string
    {
        return '\Blocks\block';
    }

    /**
     * bladeViewPaths Set base path to blade views
     *
     * @return string New path to blade views
     */
    public function bladeViewPaths($paths): array
    {

        $paths = (array) $paths;
        $paths[] = \get_template_directory();
        $paths[] = \get_stylesheet_directory();
        return $paths;
    }

    public function registerPlugins()
    {
      if(!Modules::isActiveModule('blocks'))
        return;

        include_once('Plugins/LocalData/LocalData.php');
        include_once('Plugins/RemoteData/RemoteData.php');
    }

    function enqueueAssets()
    {
      if(!Modules::isActiveModule('blocks'))
        return;

        wp_enqueue_style('blocks-stylesheet', get_template_directory_uri() . '/Blocks/assets/styles/blocks.css', array(), \wp_get_theme()->get('Version'), 'all');
        wp_enqueue_script('blocks-script', get_template_directory_uri() . '/Blocks/assets/scripts/blocks.js', array('wp-hooks', 'wp-blocks', 'wp-dom-ready'));
    }

    function addCategory($categories)
    {
      if(!Modules::isActiveModule('blocks'))
        return;

        return array_merge(
            array(
                array(
                    'slug' => 'pa-adventista',
                    'title' => __('Adventist', 'iasd'),
                ),
            ),
            $categories
        );
    }

    function UpdateRemoteData()
    {
      if(!Modules::isActiveModule('blocks'))
        return;

        $ids = \get_posts([
            'fields'          => 'ids', // Only get post IDs
            'post_type'       => 'page',
            'posts_per_page'  => -1,
        ]);

        if (!empty($ids)) :
            foreach ($ids as &$id) {
                $this->parsePage($id);
            }
        endif;
    }

    function parsePage($id)
    {
        if (empty($id)) {
            return;
        }

        $content = \get_post_field('post_content', $id);
        $hasUpdate = false;

        if (!\has_blocks($content)) {
            return;
        }

        $blocks = \parse_blocks($content);
        foreach ($blocks as &$block) :
            if ($block['blockName'] != 'acf/p-a-row') {
                continue;
            }

            foreach ($block['innerBlocks'] as &$innerBlock) :
                $fields = array_filter(\acf_get_block_fields($innerBlock['attrs']), function ($field) {
                    return $field['type'] == 'remote_data';
                });

                if (empty($fields)) {
                    continue;
                }

                $hasUpdate = true;

                foreach ($fields as &$field) :
                    $values = $innerBlock['attrs']['data'][$field['name']];
                    $values['field_key'] = $field['key'];
                    $innerBlock['attrs']['data'][$field['name']]['data'] = RemoteData::getData($values)['results'];
                endforeach;
            endforeach;
        endforeach;

        $updatedContent = \serialize_blocks($blocks);

        $args = new stdClass();
        $args->ID = $id;
        $args->post_content = $updatedContent;

        if(!empty($hasUpdate))
            \wp_update_post($args);
    }

    function cronAdd($schedules)
    {
        $schedules['thirty_minutes'] = [
            'interval' => 30 * 60,
            'display' => 'Thirty Minutes',
        ];

        return $schedules;
    }
}

if (!\function_exists('block')) {
    /**
     * Render blade templates
     *
     * @param string $view Template path
     * @param array $data Data injected into template
     *
     * @return string Template content
     */
    function block(string $view, array $data = []): string
    {
        return blade($view, $data, false);
    }
}
