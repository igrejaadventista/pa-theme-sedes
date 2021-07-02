<?php

namespace Blocks\Plugins\LocalData;

// exit if accessed directly
if (!defined('ABSPATH')) exit;

// check if class already exists
if (!class_exists('LocalData')) :

	/**
	 * Class acf_field_rest
	 */
	class LocalData extends \acf_field
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
		function __construct() {
			// name (string) Single word, no spaces. Underscores allowed
			$this->name = 'localposts_data';
			// label (string) Multiple words, can include spaces, visible when selecting a field type
			$this->label = __('Local data', 'acf-rest');
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

			add_action('wp_ajax_acf/fields/localposts_data/modal',				array($this, 'modalAjax'));

			// Admin Scripts
			\add_action('admin_enqueue_scripts', function () {
				\wp_enqueue_script('acf-local-fields.js', get_template_directory_uri() . '/Blocks/Plugins/LocalData/Assets/local-fields.js', ['jquery'], null, true);
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
		function input_admin_enqueue_scripts() {
			\wp_enqueue_style('acf-local-data-css', get_template_directory_uri() . '/Blocks/Plugins/LocalData/Assets/local-data.css', false);
			\wp_enqueue_script('acf-local-data.js', get_template_directory_uri() . '/Blocks/Plugins/LocalData/Assets/local-data.js', ['jquery'], null, true);
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

			acf_render_field_setting($field, array(
				'label'			=> __('Quantidade', 'acf'),
				'instructions'	=> 'Quantidade de itens a ser retornado',
				'type'			=> 'number',
				'name'			=> 'limit',
				'min'			=> 1,
				'max'			=> 100,
				'step'			=> 1,
				'required'	    => 1,
			));

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

			// min
			// acf_render_field_setting($field, array(
			// 	'label'			=> __('Minimum posts', 'acf'),
			// 	'instructions'	=> '',
			// 	'type'			=> 'number',
			// 	'name'			=> 'min',
			// 	'value'			=> 1,
			// 	'min'			=> 1
			// ));


			// // max
			// acf_render_field_setting($field, array(
			// 	'label'			=> __('Maximum posts', 'acf'),
			// 	'instructions'	=> '',
			// 	'type'			=> 'number',
			// 	'name'			=> 'max',
			// ));

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
					// ''	=> __('Select post type', 'acf')
					''	=> 'Filtros'
				) + acf_get_pretty_post_types($post_type);
			}

			// div attributes
			$atts = array(
				'id'				=> $field['id'],
				'class'				=> "acf-local-data acf-relationship {$field['class']}",
				'min' 				=> $field['min'],
				'max' 				=> $field['max'],
				'data-s'			=> '',
				'data-paged'		=> 1,
				'data-post_type'	=> '',
			);
		?>
			<div <?php acf_esc_attr_e($atts); ?>>
				<?php acf_hidden_input(array('name' => $field['name'] . "[manual]", 'value' => isset($values['manual']) ? $values['manual'] : '', 'data-manual' => '')); ?>
				<?php acf_hidden_input(array('name' => $field['name'] . "[sticky]", 'value' => isset($values['sticky']) ? $values['sticky'] : '', 'data-sticky' => '')); ?>

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

					<div class="filter -limit">
						<label>
							<span class="acf-js-tooltip" title="Quantidade de itens a ser exibido.">Quantidade</span>
							<?php acf_text_input(array('name' => $field['name'] . "[limit]", 'value' => isset($values['limit']) ? $values['limit'] : $field['limit'], 'type' => 'number', 'step' => 1, 'min' => 1, 'max' => 100, 'data-limit' => '', 'data-filter' => 'limit')); ?>
						</label>
					</div>

					<?php if (
						in_array('post_type', $filters)
						&& count($filter_post_type_choices) > 2
					) : ?>
						<div class="filter -post_type filter__post_type">
							<?php 
							acf_select_input(
								array(
									'name' => $field['name'] . "[post_type_filter]",
									'choices' => $filter_post_type_choices,
									'value' => isset($values['post_type_filter']) ? $values['post_type_filter'] : '',
									'data-filter' => 'post_type'
								)
							);
							?>
						</div>
					<?php endif ?>

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

				<div class="widgets-acf-modal -fields">
					<div class="widgets-acf-modal-wrapper">
						<div class="widgets-acf-modal-content">
							<div class="acf-notice-render"></div>
							<?php //$this->getSubfields($field); ?>
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

		function format_value($value, $post_id, $field) {
			$value['post_type'] = acf_get_array($field['post_type']);

			$data = $this->getData([
				'limit' => $value['limit'],
				'sticky' => $value['sticky'],
				'post_type' => !empty($value['post_type_filter']) ? $value['post_type_filter'] : $value['post_type'],
			]);

			$value['data'] = $data['results'];

			return $value;
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
			$response = $this->getData($_POST);

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
		function get_post_result($id, $date, $img, $title, $cpt, $excerpt, $url = null)
		{
			// vars
			$result = array(
				'id' 					=> $id,
				'date' 					=> $date,
				'title' 				=> array(
					'rendered' 			=> $title
				),
				'cpt_label'				=> array(
					'rendered'			=> $cpt
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
		 * getData
		 *
		 * @param  mixed $options
		 * @return void
		 */
		function getData($options = array()) {
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
			
			if(!$field) 
				return false;

			// vars
			$results = [];
			$args = [];
			$s = false;
			$is_search = false;

			// paged
			$args['paged'] = intval($options['paged']);

			// search
			if ($options['s'] !== ''):
				// strip slashes (search may be integer)
				$s = wp_unslash(strval($options['s']));

				// update vars
				$args['s'] = $s;
				$is_search = true;
			endif;

			$sticky = isset($options['sticky']) ? $options['sticky'] : 0;
			$stickyItems = !empty($sticky) ? explode(',', $sticky) : [];

			$stickyItemsFilter = array_filter($stickyItems, function ($v) {
				return substr($v, 0, 1) !== 'm';
			});

			$limit = isset($options['limit']) ? $options['limit'] : $field['limit'];
			$args['posts_per_page'] = (int)$limit;
			$args['posts_per_page'] = $args['posts_per_page'] - (count($stickyItems) - count($stickyItemsFilter));

			// filter by post types
			if(!empty($options['post_type']))
				// selected
				$args['post_type'] = acf_get_array($options['post_type']);
			elseif (!empty($field['post_type']))
				// default
				$args['post_type'] = acf_get_array($field['post_type']);
			else
				$args['post_type'] = acf_get_post_types();

			// perform search query
			if($is_search && empty($args['orderby']) && isset($args['s']))
				$args['s'] = $s;

			$stickedArr = [];
			if(!empty($stickyItemsFilter)):
				// get array of values from sticky posts
				$stickyIds = array_values($stickyItemsFilter);

				// exclude sticked posts from query
				$args['exclude'] = $stickyIds;

				// return only sticked array items
				$stickedPosts = get_posts(array(
					'include'	=> $stickyIds,
					'post_type'	=> get_post_types(),
				));

				foreach($stickedPosts as $post):
					//  push data into $results
					$stickedArr[] = $this->get_post_result(
						$post->ID,
						$post->post_date,
						get_the_post_thumbnail_url($post->ID, 'medium'),
						$post->post_title,
						get_post_type_object(get_post_type($post->ID))->labels->singular_name,
						$post->post_content
						// $url
					);
				endforeach;

				// remove sticked posts from results...
				$args['posts_per_page'] = $args['posts_per_page'] - count($stickedArr);
			endif;

			// get queried posts
			$posts = get_posts($args);
			if(!empty($posts)):
				foreach($posts as $post):
					//  push data into $results
					$results[] = $this->get_post_result(
						$post->ID,
						$post->post_date,
						get_the_post_thumbnail_url($post->ID, 'medium'),
						$post->post_title,
						get_post_type_object(get_post_type($post->ID))->labels->singular_name,
						$post->post_content
						// $url
					);
				endforeach;
			endif;

			// clean on limit reach
			if($limit <= count($stickyItems))
				$results = array(json_encode(0));

			$mergedResults = array_merge($stickedArr, $results);

			// vars
			$response = array(
				'results'	=> $mergedResults,
				'limit'		=> $args['posts_per_page'],
				'data'		=> json_encode($mergedResults),
			);

			// return
			return $response;
		}

		function modalAjax() {
			// validate
			if (!acf_verify_ajax())
				die();

			// get choices
			$this->getSubfields($_POST);

			// return
			// acf_send_ajax_results($response);
			wp_die();
		}

		function getSubfields($options) {
			$field = acf_get_field($options['field_key']);

			array_unshift(
				$field['sub_fields'],
				array(
					'key' => $options['field_key'] . '_title',
					'label' => 'Título',
					'name' => 'title',
					'type' => 'text',
					'required' => 1,
				),
				array(
					'key' => $options['field_key'] . '_thumbnail',
					'label' => 'Thumbnail',
					'name' => 'featured_media_url',
					'type' => 'image',
					'required' => 1,
				),
				array(
					'key' => $options['field_key'] . '_content',
					'label' => 'Resumo',
					'name' => 'content',
					'type' => 'textarea',
					'rows' => 3,
					'required' => 0,
				),
				array(
					'key' => $options['field_key'] . '_link',
					'label' => 'Link',
					'name' => 'link',
					'type' => 'link',
					'required' => 0,
				)
			);
	
			// load values
			if(isset($options['data'])):
				foreach($field['sub_fields'] as &$sub_field):
					if(isset($options['data'][$sub_field['name']])):
						if($sub_field['name'] == 'title' || $sub_field['name'] == 'content')
							$sub_field['value'] = $options['data'][$sub_field['name']]['rendered'];
						elseif($sub_field['name'] == 'featured_media_url')
							$sub_field['value'] = $options['data'][$sub_field['name']]['id'];
						else
							$sub_field['value'] = $options['data'][$sub_field['name']];
					endif;
					// add value
					// if(isset($field['value'][$sub_field['key']]))
					// 	// this is a normal value
					// 	$sub_field['value'] = $field['value'][$sub_field['key']];
					// elseif(isset($sub_field['default_value']))
					// 	// no value, but this sub field has a default value
					// 	$sub_field['value'] = $sub_field['default_value'];
		
					// // update prefix to allow for nested values
					// $sub_field['prefix'] = $field['name'];
		
					// // restore required
					// if($field['required'])
					// 	$sub_field['required'] = 0;
				endforeach;
			endif;
	
			echo '<div class="acf-fields -top -border">';
				foreach($field['sub_fields'] as &$sub_field):
					acf_render_field_wrap($sub_field);
				endforeach;
			echo '</div>';
		}

	}

	// initialize
	new LocalData();

// class_exists check
endif;
