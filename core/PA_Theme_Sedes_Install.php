<?php

require_once(dirname(__FILE__) . '/utils/PA_Service_Taxonomy.php');
require_once(dirname(__FILE__) . '/utils/PA_Schedule_Custom.php');
require_once(dirname(__FILE__) . '/utils/PA_RestAPI_Tax.php');
require_once(dirname(__FILE__) . '/utils/PA_Ui_Configurations.php');

/**
 * 
 * Bootloader Install
 * 
 */

class PACoreInstall
{
  public function __construct()
  {

    if (class_exists('PARegisterTax')) {
      
  
      add_action('after_setup_theme', array($this, 'installRoutines'));
      add_action('admin_enqueue_scripts', array($this, 'enqueueAssets'));
      add_filter('manage_posts_columns', array($this, 'addFakeColumn'));
      add_filter('manage_edit-post_columns', array($this, 'removeFakeColumn'));
      add_action('quick_edit_custom_box', array($this, 'addQuickEdit'));
      add_action('save_post', array($this, 'saveQuickEdit'));
      add_filter('post_row_actions', array($this, 'linkQuickEdit'), 10, 2);
    }
  }

  function installRoutines()
  {


    // Install routine to create or update taxonomies
    if (!wp_next_scheduled('PA-Service_Taxonomy_Schedule')) {
      wp_schedule_event(time(), '20min', 'PA-Service_Taxonomy_Schedule');
    }
  }

	function enqueueAssets() {
		wp_enqueue_script(
			'adventistas-admin', 
			get_template_directory_uri() . '/assets/scripts/admin.js', 
			array('wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post', 'lodash'), 
			null, 
			false
		); 
	}

	function addFakeColumn($posts_columns) {
		$posts_columns['fake'] = 'Fake Column (Invisible)';

		return $posts_columns;
	}
	
	function removeFakeColumn($posts_columns) {
		unset($posts_columns['fake']);

		return $posts_columns;
	}

	function addQuickEdit($column_name) {
		if($column_name == 'taxonomy-xtt-pa-owner'): ?>
			<fieldset class="inline-edit-col-left">
				<div class="inline-edit-col">
					<span class="title"><?= __('Headquarter - Owner', 'iasd') ?></span>
					
					<input type="hidden" name="xtt-pa-owner-noncename" id="xtt-pa-owner-noncename" value="" />
					
					<?php $terms = get_terms(array('taxonomy' => 'xtt-pa-owner', 'hide_empty' => false)); ?>
				
					<select name='terms-xtt-pa-owner' id='terms-xtt-pa-owner'>
						<?php foreach ($terms as $term): ?>
							<option class="xtt-pa-owner-option" value="<?= $term->name ?>"><?= $term->name ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</fieldset>
		<?php endif;
	}

	function saveQuickEdit($postID) {
		if((defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || !isset($_POST['post_type']) || ('post' != $_POST['post_type']) || !current_user_can('edit_page', $postID))
			return $postID;
	 
		$postType = get_post_type($postID);
	 
		if(isset($_POST['terms-xtt-pa-owner']) && ($postType != 'revision')):
			$selectedTerm = esc_attr($_POST['terms-xtt-pa-owner']);
			$term = term_exists($selectedTerm, 'xtt-pa-owner');

			if($term !== 0 && $term !== null)
				wp_set_object_terms($postID, $selectedTerm, 'xtt-pa-owner');
		endif;
	}

	function linkQuickEdit($actions, $post) {
		if($post->post_type != 'post') 
			return $actions;
	 
		$nonce = wp_create_nonce('xtt-pa-owner-sexuality_' . $post->ID);
		$term = wp_get_post_terms($post->ID, 'xtt-pa-owner', array('fields' => 'all'));
	 
		$actions['inline hide-if-no-js'] = '<a href="#" class="editinline"';
		$actions['inline hide-if-no-js'] .= !empty($term) ? " onclick=\"set_inline__tt_pa_owner(event, '{$term[0]->name}', '{$nonce}')\">" : ">";
		$actions['inline hide-if-no-js'] .= __('Quick&nbsp;Edit');
		$actions['inline hide-if-no-js'] .= '</a>';
		
		return $actions;
	}

}

$PACoreInstall = new PACoreInstall();
