<?php

require_once(dirname(__FILE__) . '/PATaxonomiesSync.php');
require_once(dirname(__FILE__) . '/Taxonomies.php');
require_once(dirname(__FILE__) . '/settings/Modules.php');
require_once(dirname(__FILE__) . '/settings/Synchronization.php');
require_once(dirname(__FILE__) . '/utils/PA_Schedule_Custom.php');

/**
 * 
 * Bootloader Install
 * 
 */

class PACoreInstall
{
  public function __construct()
  {
    add_action('admin_enqueue_scripts', array($this, 'enqueueAssets'));
    // add_filter('manage_posts_columns', array($this, 'addFakeColumn'));
    // add_filter('manage_edit-post_columns', array($this, 'removeFakeColumn'));
    // add_filter('manage_edit-kit_columns', array($this, 'removeFakeColumn'));
    add_action('quick_edit_custom_box', array($this, 'addQuickEdit'));
    add_action('save_post', array($this, 'saveQuickEdit'));
    add_filter('post_row_actions', array($this, 'linkQuickEdit'), 10, 2);
    add_action('init', array($this, 'pa_wp_custom_menus'));
    add_action('pre_get_posts', array($this, 'modifyCategoryQuery'));
    add_action('rest_api_init', array($this, 'restApi'));
    add_action('send_headers', 'send_frame_options_header', 10, 0);
  }

  function enqueueAssets()
  {
    wp_enqueue_script(
      'adventistas-admin',
      get_template_directory_uri() . '/assets/scripts/admin.js',
      array('wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post', 'lodash'),
      null,
      false
    );
  }

  function addFakeColumn($posts_columns)
  {
    $posts_columns['fake'] = 'Fake Column (Invisible)';

    return $posts_columns;
  }

  function removeFakeColumn($posts_columns)
  {
    unset($posts_columns['fake']);

    return $posts_columns;
  }

  function addQuickEdit($column_name)
  {
    if ($column_name == 'taxonomy-xtt-pa-owner') : ?>
      <fieldset class="inline-edit-col-left">
        <div class="inline-edit-col">
          <span class="title"><?= __('Headquarter - Owner', 'iasd') ?></span>

          <input type="hidden" name="xtt-pa-owner-noncename" id="xtt-pa-owner-noncename" value="" />

          <?php $terms = get_terms(array('taxonomy' => 'xtt-pa-owner', 'hide_empty' => false)); ?>

          <select name='terms-xtt-pa-owner' id='terms-xtt-pa-owner'>
            <?php foreach ($terms as $term) : ?>
              <option class="xtt-pa-owner-option" value="<?= $term->name ?>"><?= $term->name ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </fieldset>
<?php endif;
  }

  function saveQuickEdit($postID)
  {
    if ((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || !isset($_POST['post_type']) || ('post' != $_POST['post_type']) || !current_user_can('edit_page', $postID))
      return $postID;

    $postType = get_post_type($postID);

    if (isset($_POST['terms-xtt-pa-owner']) && ($postType != 'revision')) :
      $selectedTerm = esc_attr($_POST['terms-xtt-pa-owner']);
      $term = term_exists($selectedTerm, 'xtt-pa-owner');

      if ($term !== 0 && $term !== null)
        wp_set_object_terms($postID, $selectedTerm, 'xtt-pa-owner');
    endif;
  }

  function linkQuickEdit($actions, $post)
  {
    if ($post->post_type != 'post')
      return $actions;

    $nonce = wp_create_nonce('xtt-pa-owner-sexuality_' . $post->ID);
    $term = wp_get_post_terms($post->ID, 'xtt-pa-owner', array('fields' => 'all'));

    if (!is_wp_error($term) && !empty($term)) {
      $actions['inline hide-if-no-js'] = '<a href="#" class="editinline"';
      $actions['inline hide-if-no-js'] .= !empty($term) ? " onclick=\"set_inline__tt_pa_owner(event, '{$term[0]->name}', '{$nonce}')\">" : ">";
      $actions['inline hide-if-no-js'] .= __('Quick&nbsp;Edit');
      $actions['inline hide-if-no-js'] .= '</a>';
    }

    return $actions;
  }

  function pa_wp_custom_menus()
  {
    register_nav_menu('pa-menu-default', __('PA - Menu - Default', 'iasd'));
  }

  function modifyCategoryQuery($query)
  {
    if (is_admin() || !is_tax() || !$query->is_main_query() || is_tax('xtt-pa-region'))
      return $query;

    //pconsole($query);


    global $queryFeatured;
    $object = get_queried_object();

    $queryFeatured = new WP_Query(
      array(
        'posts_per_page' => 1,
        'post_status'     => 'publish',
        'post__in'       => get_option('sticky_posts'),
        'tax_query'      => array(
          array(
            'taxonomy' => $object->taxonomy,
            'terms'    => array($object->term_id),
          ),
        ),
      )
    );

    if (empty($queryFeatured->found_posts)) :
      $queryFeatured = new WP_Query(
        array(
          'posts_per_page'      => 1,
          'post_status'        => 'publish',
          'ignore_sticky_posts ' => true,
          'tax_query'            => array(
            array(
              'taxonomy' => $object->taxonomy,
              'terms'    => array($object->term_id),
            ),
          ),
        )
      );
    endif;

    $query->set('posts_per_page', 15);
    $query->set('ignore_sticky_posts', true);
    $query->set('post__not_in', !empty($queryFeatured->found_posts) ? array($queryFeatured->posts[0]->ID) : null);

    return $query;
  }

  function restApi()
  {
    register_rest_field(
      array('post', 'press'),
      'featured_media_url',
      array(
        'get_callback'    => array($this, 'featured_media_url_callback'),
        'update_callback' => null,
        'schema'          => null,
      )
    );
  }

  function featured_media_url_callback($post)
  {
    $img_id = get_post_thumbnail_id($post['id']);

    $img_scr = array(
      'full'             => !empty($full    = wp_get_attachment_image_src($img_id, ''))             ? $full[0]    : '',
      'medium'           => !empty($medium  = wp_get_attachment_image_src($img_id, 'medium_large')) ? $medium[0]  : '',
      'small'            => !empty($small   = wp_get_attachment_image_src($img_id, 'thumbnail'))    ? $small[0]   : '',
      'pa-block-preview' => !empty($preview = wp_get_attachment_image_src($img_id, 'thumbnail')) ? $preview[0] : '',
      'pa-block-render'  => !empty($render  = wp_get_attachment_image_src($img_id, 'medium')) ? $render[0]  : '',
    );

    return $img_scr;
  }
}

$PACoreInstall = new PACoreInstall();
