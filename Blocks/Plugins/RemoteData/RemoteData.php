<?php

namespace Blocks\Plugins\RemoteData;

use WordPlate\Acf\Fields\Text;

// exit if accessed directly
if (!defined('ABSPATH')) exit;

// check if class already exists
if (!class_exists('RemoteData')) :

	/**
	 * Class acf_field_rest
	 */
	class RemoteData extends \acf_field
	{

		/**
		 *  __construct
		 *
		 *  This function will setup the field type data
		 *
		 *  @type	function
		 *  @date	5/03/2014
		 *  @since	5.0.0
		 *
		 *  @return	n/a
		 */
		function __construct()
		{
			// name (string) Single word, no spaces. Underscores allowed
			$this->name = 'localposts_data';
			// label (string) Multiple words, can include spaces, visible when selecting a field type
			$this->label = __('Objeto de posts Locais', 'acf-rest');
			// category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
			$this->category = 'relational';
			// defaults (array) Array of default settings which are merged into the field object. These are used later in settings
			$this->defaults = array(
				'sub_fields'		=> [],
				'post_type'			=> [],
				'min' 				=> 0,
				'max' 				=> 0,
				'filters'			=> ['post_type'],
				'return_format'		=> 'object'
			);
			$this->have_rows = 'single';

			add_action('wp_ajax_acf/fields/localposts_data/query',				array($this, 'ajax_query'));
			add_action('wp_ajax_nopriv_acf/fields/localposts_data/query',		array($this, 'ajax_query'));

			// Admin Scripts
			\add_action('admin_enqueue_scripts', function () {
				\wp_enqueue_script('acf-remote-fields.js', get_template_directory_uri() . '/Blocks/Plugins/RemoteData/Assets/remote-fields.js', ['jquery'], null, true);
			});

			// do not delete!
			parent::__construct();
		}

		/**
		 *  input_admin_enqueue_scripts
		 *
		 *  description
		 *
		 *  @type	function
		 *  @date	16/12/2015
		 *  @since	5.3.2
		 *
		 *  @param	$post_id (int)
		 *  @return	$post_id (int)
		 */
		function input_admin_enqueue_scripts()
		{
			\wp_enqueue_style('acf-remote-data-css', get_template_directory_uri() . '/Blocks/Plugins/RemoteData/Assets/remote-data.css', false);
			\wp_enqueue_script('acf-remote-data.js', get_template_directory_uri() . '/Blocks/Plugins/RemoteData/Assets/remote-data.js', ['jquery'], null, true);
		}

		/**
		 *  render_field_settings()
		 *
		 *  Create extra settings for your field. These are visible when editing a field
		 *
		 *  @type	action
		 *  @since	3.6
		 *  @date	23/01/13
		 *
		 *  @param	$field (array) the $field being edited
		 *  @return	n/a
		 */
		function render_field_settings($field)
		{

			// vars
			$field['min'] = empty($field['min']) ? '' : $field['min'];
			$field['max'] = empty($field['max']) ? '' : $field['max'];

			$field['limit'] = empty($field['limit']) ? '' : $field['limit'];

			acf_hidden_input(array('type' => 'hidden', 'name' => $field['prefix'] . '[sticky]', 'value' => '0'));

			$choices = [];
			if (!empty($field['fields'])) :
				foreach ($field['fields'] as $value)
					$choices[$value] = $value;
			endif;

			// filter (by post types)
			acf_render_field_setting($field, array(
				'label'			=> __('Filter by Post Type', 'acf'),
				'instructions'	=> '',
				'type'			=> 'select',
				'name'			=> 'post_type',
				'choices'		=> acf_get_pretty_post_types(),
				'multiple'		=> 1,
				'ui'			=> 1,
				'allow_null'	=> 1,
				'placeholder'	=> __("All post types", 'acf'),
			));

			// vars
			$args = array(
				'fields'	=> $field['sub_fields'],
				'parent'	=> $field['ID']
			);
?>
			<tr class="acf-field acf-field-setting-sub_fields" data-setting="group" data-name="sub_fields">
				<td class="acf-label">
					<label><?= __('Campos de conteúdo manual', 'acf'); ?></label>
				</td>
				<td class="acf-input">
					<?php acf_get_view('field-group-fields', $args); ?>
				</td>
			</tr>
		<?php
		}

		/**
		 *  render_field()
		 *
		 *  Create the HTML interface for your field
		 *
		 *  @param	$field (array) the $field being rendered
		 *
		 *  @type	action
		 *  @since	3.6
		 *  @date	23/01/13
		 *
		 *  @return	n/a
		 */
		function render_field($field)
		{
			$values = get_field($field['key']);

			// vars
			$post_type = acf_get_array($field['post_type']);
			$filters = acf_get_array($field['filters']);
			$filter_post_type_choices = array();

			// post_type filter
			if (in_array('post_type', $filters)) {
				$filter_post_type_choices = array(
					''	=> __('Select post type', 'acf')
				) + acf_get_pretty_post_types($post_type);
			}

			// div attributes
			$atts = array(
				'id'				=> $field['id'],
				'class'				=> "acf-local-data acf-remote-data acf-relationship {$field['class']}",
				'data-s'			=> '',
				'data-paged'		=> 1,
				'data-post_type'	=> '',
			);

		?>
			<div <?php acf_esc_attr_e($atts); ?>>
				<?php acf_hidden_input(array('name' => $field['name'] . "[manual]", 'value' => isset($values['manual']) ? $values['manual'] : '', 'data-manual' => '')); ?>
				<?php acf_hidden_input(array('name' => $field['name'] . "[sticky]", 'value' => isset($values['sticky']) ? $values['sticky'] : 0, 'data-sticky' => '')); ?>

				<div class="action-toolbar">
					<button type="button" class="buttonAddManualPost disabled" data-action="manual-new-post" disabled>Adicionar manual</button>
					<button type="button" class="buttonUpdateTaxonomies acf-js-tooltip" data-action="refresh" title="Atualizar" aria-label="Atualizar">
						<svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" aria-hidden="true" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
							<polyline points="23 4 23 10 17 10"></polyline>
							<polyline points="1 20 1 14 7 14"></polyline>
							<path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
						</svg>
					</button>
				</div>

				<div class="filters -f3">

					<div class="filter -search">
						<?php /* search filters */
						acf_text_input(array('placeholder' => __('Search...', 'acf'), 'data-filter' => 's')); ?>
						<i class="acf-loading"></i>
						<a href="#" class="button-clear acf-icon -cancel acf-js-tooltip" data-action="clear" title="Limpar"></a>
					</div>

					<?php if (
						in_array('post_type', $filters)
						&& count($filter_post_type_choices) > 2
					) : ?>
						<div class="filter -post_type">
							<?php acf_select_input(
								array(
									'choices' => $filter_post_type_choices,
									'data-filter' => 'post_type'
								)
							);
							?>
						</div>
					<?php endif ?>

					<div class="filter -limit">
						<label>
							<span class="acf-js-tooltip" title="Quantidade de itens a ser exibido. De 1 a 100">Quantidade</span>
							<?php acf_text_input(array('name' => $field['name'] . "[limit]", 'value' => isset($values['limit']) ? $values['limit'] : $field['limit'], 'type' => 'number', 'step' => 1, 'min' => 1, 'max' => 100, 'data-limit' => '', 'data-filter' => 'limit')); ?>
						</label>
					</div>

				</div>

				<div class="selection">
					<div class="choices">
						<ul class="acf-bl list local-list choices-list"></ul>
					</div>
					<div class="values">
						<ul class="acf-bl list sticky-list"></ul>
						<ul class="acf-bl list values-list"></ul>
					</div>
				</div>

				<?php
				// load values
				foreach ($field['sub_fields'] as &$sub_field) :
					// add value
					if (isset($field['value'][$sub_field['key']]))
						// this is a normal value
						$sub_field['value'] = $field['value'][$sub_field['key']];
					elseif (isset($sub_field['default_value']))
						// no value, but this sub field has a default value
						$sub_field['value'] = $sub_field['default_value'];

					// update prefix to allow for nested values
					$sub_field['prefix'] = $field['name'];

					// restore required
					if ($field['required'])
						$sub_field['required'] = 0;
				endforeach;

				?>
				<div class="widgets-acf-modal -fields">
					<div class="widgets-acf-modal-wrapper">
						<div class="widgets-acf-modal-content">
							<div class="acf-notice-render"></div>
							<?php $this->render_field_block($field); ?>
						</div>
					</div>
				</div>
			</div><!-- End: -->
<?php
		}

		/**
		 *  load_field()
		 *
		 *  This filter is appied to the $field after it is loaded from the database
		 *
		 *  @type	filter
		 *  @since	3.6
		 *  @date	23/01/13
		 *
		 *  @param	$field - the field array holding all the field options
		 *
		 *  @return	$field - the field array holding all the field options
		 */

		function load_field($field)
		{
			$sub_fields = acf_get_fields($field);

			// append
			if ($sub_fields)
				$field['sub_fields'] = $sub_fields;

			// return
			return $field;
		}

		/**
		 *  render_field_block
		 *
		 *  description
		 *
		 *  @type	function
		 *  @date	12/07/2016
		 *  @since	5.4.0
		 *
		 *  @param	$post_id (int)
		 *  @return	$post_id (int)
		 */

		function render_field_block($field)
		{
			// html
			echo '<div class="acf-fields -top -border">';

			foreach ($field['sub_fields'] as $sub_field)
				acf_render_field_wrap($sub_field);

			echo '</div>';
		}

		// public function load_value($value, $post_id, $field) {
		//     return json_decode($value['data'], true);
		// }

		/**
		 *  ajax_query
		 *
		 *  description
		 *
		 *  @type	function
		 *  @date	24/10/13
		 *  @since	5.0.0
		 *
		 *  @param	$post_id (int)
		 *  @return	$post_id (int)
		 */

		function ajax_query()
		{
			// validate
			if (!acf_verify_ajax())
				die();

			// get choices
			$response = $this->get_ajax_query($_POST);

			// return
			acf_send_ajax_results($response);
		}

		/**
		 *  get_post_result
		 *
		 *  This function will return an array containing id, text and maybe description data
		 *
		 *  @type	function
		 *  @date	7/07/2016
		 *  @since	5.4.0
		 *
		 *  @param	$id (mixed)
		 *  @param	$text (string)
		 *  @return	(array)
		 */
		function get_post_result($id, $date, $title, $img, $excerpt = null, $url = null)
		{
			// vars
			$result = array(
				'id' 					=> $id,
				'date' 					=> $date,
				'title' 				=> array(
					'rendered' 			=> $title
				),
				'featured_media_url' 	=> array(
					'pa_block_render' 	=> $img
				),
				'excerpt' 				=> array(
					'rendered' 			=> $excerpt
				),
				'url' => $url
			);

			// return
			return $result;
		}

		/**
		 *  get_ajax_query
		 *
		 *  This function will return an array of data formatted for use in a select2 AJAX response
		 *
		 *  @type	function
		 *  @date	15/10/2014
		 *  @since	5.0.9
		 *
		 *  @param	$options (array)
		 *  @return	(array)
		 */

		function get_ajax_query($options = array())
		{
			// defaults
			$options = wp_parse_args($options, array(
				'sticky'		=> '',
				'post_id'		=> 0,
				's'				=> '',
				'field_key'		=> '',
				'paged'			=> 1,
				'post_type'		=> '',
			));

			// load field
			$field = acf_get_field($options['field_key']);
			if (!$field) return false;

			// vars
			$results = [];
			$args = [];
			$s = false;
			$is_search = false;

			// paged
			$args['paged'] = intval($options['paged']);

			// search
			if ($options['s'] !== '') {
				// strip slashes (search may be integer)
				$s = wp_unslash(strval($options['s']));

				// update vars
				$args['s'] = $s;
				$is_search = true;
			}

			$sticky = isset($options['sticky']) ? $options['sticky'] : 0;
			$stickyItems = !empty($sticky) ? explode(',', $sticky) : [];

			$stickyItemsFilter = array_filter($stickyItems, function ($v) {
				return substr($v, 0, 1) !== 'm';
			});

			$limit = isset($options['limit']) ? $options['limit'] : $field['limit'];
			// $limit = !empty($limit) && $limit > 0 ? $limit : 1;
			// $limit = $limit <= 100 ? $limit : 100;
			$args['posts_per_page'] = (int)$limit;
			$args['posts_per_page'] = $args['posts_per_page'] - (count($stickyItems) - count($stickyItemsFilter));

			// die(var_dump($stickyItemsFilter));

			// post_type
			if (!empty($options['post_type'])) {
				$args['post_type'] = acf_get_array($options['post_type']);
			} elseif (!empty($field['post_type'])) {
				// default post_type
				$args['post_type'] = acf_get_array($field['post_type']);
			} else {
				$args['post_type'] = acf_get_post_types();
			}

			if ($limit <= count($stickyItems)) :
				// only manual or only local
				$args['include'] = $stickyItemsFilter ?: $stickyItems;
			endif;

			// exclude sticky items from query
			if (!empty($sticky)) :
			// $args['include'] = $stickyItemsFilter;
			// $args['orderby'] = 'include';
			endif;

			// perform search query
			if ($is_search && empty($args['orderby']) && isset($args['s'])) :
				$args['s'] = $s;
			endif;
			
			// die(print_r($args));
			// die(var_dump(get_post_type(163)));

			$posts = acf_get_posts($args);

			// get queried posts
			if (!empty($posts)) :
				foreach ($posts as $post) :
					$thumb = get_the_post_thumbnail_url($post->ID, 'full');
					//  push data into $results
					$results[] = $this->get_post_result($post->ID, $post->post_date, $post->post_title, $thumb);
				endforeach;
			endif;

			// vars
			$response = array(
				'results'	=> $results,
				'limit'		=> $args['posts_per_page'],
				'data'		=> json_encode($results),
			);

			// return
			return $response;
		}
	}

	// initialize
	new RemoteData();

// class_exists check
endif;
