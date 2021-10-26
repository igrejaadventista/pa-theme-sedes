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
    add_action('after_setup_theme', array($this, 'installRoutines'));
	add_action('admin_enqueue_scripts', array($this, 'enqueueAssets'));
	add_filter('manage_posts_columns', array($this, 'addFakeColumn'));
	add_filter('manage_edit-post_columns', array($this, 'removeFakeColumn'));
	add_action('quick_edit_custom_box', array($this, 'addQuickEdit'));
	add_action('save_post', array($this, 'saveQuickEdit'));
	add_filter('post_row_actions', array($this, 'linkQuickEdit'), 10, 2);
  }

  function installRoutines()
  {
    /**
     * 
     * SEDES PROPRIETÁRIAS
     * 
     */

    $labelsOwners = array(
      'name'              => __('Headquarter - Owner', 'iasd'),
      'singular_name'     => __('Headquarter - Owner', 'iasd'),
      'search_items'      => __('Search', 'iasd'),
      'all_items'         => __('All itens', 'iasd'),
      'parent_item'       => __('Headquarter - Owner, father', 'iasd'),
      'parent_item_colon' => __('Headquarter - Owner, father', 'iasd'),
      'edit_item'         => __('Edit', 'iasd'),
      'update_item'       => __('Update', 'iasd'),
      'add_new_item'      => __('Add new', 'iasd'),
      'new_item_name'     => __('New', 'iasd'),
      'menu_name'         => __('Headquarter - Owner', 'iasd'),
    );
    $argsOwners   = array(
		'hierarchical'       => true, // make it hierarchical (like categories)
		'labels'             => $labelsOwners,
		'show_ui'            => true,
		'show_admin_column'  => true,
		'show_in_quick_edit' => false,
		'query_var'          => true,
		'show_in_rest'       => true, // add support for Gutenberg editor
		'rewrite'            => ['slug' => 'xtt-pa-owner'],
		'capabilities' 		  => array(
			'edit_terms' 	  => false,
			'delete_terms'    => false,
		),
    );
    register_taxonomy('xtt-pa-owner', ['post'], $argsOwners);

    /**
     * 
     * COLEÇÕES
     * 
     */

    $labelsColecoes = array(
      'name'              => __('Collection', 'iasd'),
      'singular_name'     => __('Collection', 'iasd'),
      'search_items'      => __('Search', 'iasd'),
      'all_items'         => __('All itens', 'iasd'),
      'parent_item'       => __('Collection, father', 'iasd'),
      'parent_item_colon' => __('Collection, father', 'iasd'),
      'edit_item'         => __('Edit', 'iasd'),
      'update_item'       => __('Update', 'iasd'),
      'add_new_item'      => __('Add new', 'iasd'),
      'new_item_name'     => __('New', 'iasd'),
      'menu_name'         => __('Collection', 'iasd'),
    );
    $argsColecoes   = array(
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labelsColecoes,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'show_in_rest'      => true, // add support for Gutenberg editor
		'rewrite'           => ['slug' => 'xtt-pa-colecoes'],
		'capabilities' 		  => array(
			'edit_terms' 	  => false,
			'delete_terms'    => false,
		),
    );
    register_taxonomy('xtt-pa-colecoes', ['post'], $argsColecoes);


	/**
     * 
     * EDITORIAS
     * 
     */

    $labelsEditorias = array(
			'name'                	=> __('Editorial', 'iasd'),
			'singular_name'       	=> __('Editorial', 'iasd'),
			'search_items'      	=> __('Search', 'iasd'),
			'all_items'         	=> __('All itens', 'iasd'),
			'parent_item'       	=> __('Editorial, father', 'iasd'),
			'parent_item_colon' 	=> __('Editorial, father', 'iasd'),
			'edit_item'         	=> __('Edit', 'iasd'),
			'update_item'       	=> __('Update', 'iasd'),
			'add_new_item'      	=> __('Add new', 'iasd'),
			'new_item_name'     	=> __('New', 'iasd'),
			'menu_name'           	=> __('Editorial', 'iasd')
		);

		$argsEditorias = array(
			'hierarchical'        => true,
			'labels'              => $labelsEditorias,
			'show_ui'             => true,
			'show_admin_column'   => true,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __('editorial', 'iasd') ),
			'public'              => true,
      		'show_in_rest'        => true, // add support for Gutenberg editor
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
		);
    register_taxonomy('xtt-pa-editorias', ['post'], $argsEditorias);


    /**
     * 
     * Departamentos
     * 
     */

    $labelsDepartamentos = array(
			'name'              => __('Ministry', 'iasd'),
			'singular_name'     => __('Ministry', 'iasd'),
			'search_items'     	=> __('Search', 'iasd'),
			'all_items'         => __('All itens', 'iasd'),
			'parent_item'       => __('Ministry, father', 'iasd'),
			'parent_item_colon' => __('Ministry, father', 'iasd'),
			'edit_item'         => __('Edit', 'iasd'),
			'update_item'       => __('Update', 'iasd'),
			'add_new_item'      => __('Add new', 'iasd'),
			'new_item_name'     => __('New', 'iasd'),
			'menu_name'         => __('Ministry', 'iasd')
		);

		$argsDepartamentos = array(
			'hierarchical'        => true,
			'labels'              => $labelsDepartamentos,
			'show_ui'             => true,
			'show_admin_column'   => false,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __('departamento', 'iasd') ),
			'public'              => true,
      		'show_in_rest'        => true, // add support for Gutenberg editor
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
		);
    register_taxonomy('xtt-pa-departamentos', ['post'], $argsDepartamentos);


    /**
     * 
     * Projetos
     * 
     */

    $labelsProjetos = array(
			'name'              => __('Projects', 'iasd'),
			'singular_name'     => __('Projects', 'iasd'),
			'search_items'      => __('Search', 'iasd'),
			'all_items'         => __('All itens', 'iasd'),
			'parent_item'       => __('Projects, father', 'iasd'),
			'parent_item_colon' => __('Projects, father', 'iasd'),
			'edit_item'         => __('Edit', 'iasd'),
			'update_item'       => __('Update', 'iasd'),
			'add_new_item'      => __('Add new', 'iasd'),
			'new_item_name'     => __('New', 'iasd'),
			'menu_name'         => __('Projects', 'iasd')
		);

		$argsProjetos = array(
			'hierarchical'        => true,
			'labels'              => $labelsProjetos,
			'show_ui'             => true,
			'show_admin_column'   => false,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => __('projeto', 'iasd') ),
			'public'              => true,
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
      'show_in_rest'        => true, // add support for Gutenberg editor
    );
    register_taxonomy('xtt-pa-projetos', ['post'], $argsProjetos);

	
    /**
     * 
     * Sedes Regionais
     * 
     */

    $labelsSedes = array(
			'name'              => __('Regional Headquarter', 'iasd'),
			'singular_name'     => __('Regional Headquarter', 'iasd'),
			'search_items'      => __('Search', 'iasd'),
			'all_items'         => __('All itens', 'iasd'),
			'parent_item'       => __('Regional Headquarter, father', 'iasd'),
			'parent_item_colon' => __('Regional Headquarter, father', 'iasd'),
			'edit_item'         => __('Edit', 'iasd'),
			'update_item'       => __('Update', 'iasd'),
			'add_new_item'      => __('Add new', 'iasd'),
			'new_item_name'     => __('New', 'iasd'),
			'menu_name'         => __('Regional Headquarter', 'iasd')
		);

		$argsSedes = array(
			'hierarchical'        => true,
			'labels'              => $labelsSedes,
			'show_ui'             => true,
			'show_admin_column'   => true,
			'query_var'           => true,
			'rewrite'             => true,
			'public'              => true,
      		'show_in_rest'        => true, // add support for Gutenberg editor
			'capabilities' 		  => array(
				'edit_terms' 	  => false,
				'delete_terms'    => false,
			),
		);
    register_taxonomy('xtt-pa-sedes', ['post'], $argsSedes);


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
