<?php

namespace Blocks\Plugins\RemoteData;

// exit if accessed directly
if(!defined('ABSPATH'))
	exit;


// check if class already exists
if(!class_exists('RemoteData')):

	/**
	 * Class RemoteData
	 */
	class RemoteData extends \acf_field {

		/*
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
			$this->name = 'remote_data';
			$this->label = __('Remote data', 'acf-rest');
			$this->category = 'relational';
			$this->defaults = array(
				'sub_fields'	=> array(),
				'endpoint' 		=> '',
				'manual_items'  => 1,
				'filters'		=> ['endpoint'],
				'search_filter' => 1,
				'limit_filter'  => 1,
				'can_sticky'	=> 1,
				'filter_fields'	=> 1,
			);
			$this->have_rows = 'single';

			\add_action('wp_ajax_acf/fields/remote_data/query',	 array($this, 'queryAjax'));
			\add_action('wp_ajax_acf/fields/remote_data/search', array($this, 'searchAjax'));
			\add_action('wp_ajax_acf/fields/remote_data/modal',	 array($this, 'modalAjax'));

			// Admin Scripts
			\add_action('admin_enqueue_scripts', function () {
				\wp_enqueue_script('acf-remote-fields.js', get_template_directory_uri() . '/Blocks/Plugins/RemoteData/Assets/remote-fields.js', ['jquery'], null, true);
			});

			// do not delete!
			parent::__construct();
		}

		/*
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
			\wp_enqueue_style('acf-remote-data-css', get_template_directory_uri() . '/Blocks/Plugins/RemoteData/Assets/remote-data.css', false);
			\wp_enqueue_script('acf-remote-data.js', get_template_directory_uri() . '/Blocks/Plugins/RemoteData/Assets/remote-data.js', ['jquery'], null, true);
		}


		/*
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
		function render_field_settings($field) {
			$field['limit'] = empty($field['limit']) ? '' : $field['limit'];
			$choices = [];
			if(!empty($field['fields'])):
				foreach($field['fields'] as $value)
					$choices[$value] = $value;
			endif;

			\acf_render_field_setting($field, array(
				'label'		   => __('Endpoints', 'acf'),
				'instructions' => __('Defina os endpoints de onde as informações serão buscadas', 'acf'),
				'type' 		   => 'select',
				'name' 		   => 'endpoints',
				'placeholder'  => 'https://website.com/wp-json/wp/v2/posts',
				'multiple'	   => 1,
				'ui'		   => 1,
				'allow_null'   => 0,
				'required'	   => 1,
				'placeholder'  => __('Digite as urls', 'acf'),
			));

			\acf_render_field_setting($field, array(
				'label'			=> __('Quantidade', 'acf'),
				'instructions'	=> 'Quantidade de itens a ser retornado pela API',
				'type'			=> 'number',
				'name'			=> 'limit',
				'min'			=> 1,
				'max'			=> 100,
				'step'			=> 1,
				'required'	    => 1,
			));

			\acf_render_field_setting($field, array(
				'label'			=> __('Filtrar campos?', 'acf'),
				'type'			=> 'true_false',
				'name'			=> 'filter_fields',
				'ui'			=> 1,
				'default_value'	=> 1,
			));

			\acf_render_field_setting($field, array(
				'label'			=> __('Campos', 'acf'),
				'instructions'	=> 'Defina quais campos deverão ser retornados da API. Os campos id e title já são retornados automaticamente',
				'type'			=> 'select',
				'name'			=> 'fields',
				'choices'		=> $choices,
				'multiple'		=> 1,
				'ui'			=> 1,
				'allow_null'	=> 0,
				'placeholder'	=> __('Digite os nomes dos campos', 'acf'),
			));

			$taxonomies = \get_taxonomies(['_builtin' => false], 'objects');
			$choices = [];

			foreach($taxonomies as $taxonomy)
				$choices[$taxonomy->name] = $taxonomy->label;

			\acf_render_field_setting($field, array(
				'label'			=> __('Taxonomias', 'acf'),
				'instructions'	=> 'Defina quais taxonomias estarão disponíveis nos filtros',
				'type'			=> 'select',
				'name'			=> 'taxonomies',
				'choices'		=> $choices,
				'multiple'		=> 1,
				'ui'			=> 1,
				'allow_null'	=> 0,
				'placeholder'	=> __('Selecione as taxonomias', 'acf'),
			));

			\acf_render_field_setting($field, array(
				'label'			=> __('Habilitar Busca?', 'acf'),
				'type'			=> 'true_false',
				'name'			=> 'search_filter',
				'ui'			=> 1,
				'default_value'	=> 1,
			));

			\acf_render_field_setting($field, array(
				'label'			=> __('Habilitar quantidade de itens?', 'acf'),
				'type'			=> 'true_false',
				'name'			=> 'limit_filter',
				'ui'			=> 1,
				'default_value'	=> 1,
			));

			\acf_render_field_setting($field, array(
				'label'			=> __('Habilitar fixar itens?', 'acf'),
				'type'			=> 'true_false',
				'name'			=> 'can_sticky',
				'ui'			=> 1,
				'default_value'	=> 1,
			));

			\acf_render_field_setting($field, array(
				'label'			=> __('Habilitar conteúdo manual?', 'acf'),
				'type'			=> 'true_false',
				'name'			=> 'manual_items',
				'ui'			=> 1,
				'default_value'	=> 1,
			));

			// vars
			$args = array(
				'fields' => $field['sub_fields'],
				'parent' => $field['ID']
			);

			?>
				<tr class="acf-field acf-field-setting-sub_fields" data-setting="group" data-name="sub_fields">
					<td class="acf-label">
						<label><?= __('Campos de conteúdo manual', 'acf'); ?></label>
					</td>
					<td class="acf-input">
						<?php \acf_get_view('field-group-fields', $args); ?>
					</td>
				</tr>
			<?php
		}

		/*
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
		function render_field($field) {
			$values = get_field($field['key']);
			$endpoints = acf_get_array($field['endpoints']);
			$endpointsChoices = array();

			if(!empty($endpoints)):
				foreach($endpoints as $endpoint):
					$endpointValues = explode('>', $endpoint);
					$endpointsChoices[trim($endpointValues[0])] = trim($endpointValues[count($endpointValues) > 1 ? 1 : 0]);
				endforeach;
			endif;

			// div attributes
			$atts = array(
				'id'		 	  => $field['id'],
				'class'		 	  => "acf-remote-data acf-relationship {$field['class']}",
				'data-s'	 	  => '',
				'data-can_sticky' => $field['can_sticky'],
			);

			?>

			<div <?php acf_esc_attr_e($atts); ?>>
				<!-- API Data -->
				<?php acf_hidden_input(array('name' => $field['name'] . "[data]", 'value' => isset($values['data']) ? $values['data'] : '', 'data-values' => '')); ?>
				<!-- Manual Data -->
				<?php acf_hidden_input(array('name' => $field['name'] . "[manual]", 'value' => isset($values['manual']) ? $values['manual'] : '', 'data-manual' => '')); ?>
				<!-- Sticky IDs -->
				<?php acf_hidden_input(array('name' => $field['name'] . "[sticky]", 'value' => isset($values['sticky']) ? $values['sticky'] : '', 'data-sticky' => '')); ?>

				<div class="action-toolbar">
					<?php if(!empty($field['manual_items'])): ?>
						<button type="button" class="buttonAddManualPost disabled acf-js-tooltip" data-action="manual-new-post" title="Adicionar item de forma manual" disabled>Adicionar</button>
					<?php endif; ?>

					<button type="button" class="buttonUpdateTaxonomies acf-js-tooltip" data-action="refresh" title="Atualizar resultados" aria-label="Atualizar resultados">
						<svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" aria-hidden="true" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
							<polyline points="23 4 23 10 17 10"></polyline>
							<polyline points="1 20 1 14 7 14"></polyline>
							<path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
						</svg>
					</button>
				</div>

				<div class="filters -f3">
					<?php if(!empty($field['search_filter'])): ?>
						<div class="filter -search">
							<?php acf_text_input(array('placeholder' => __('Search...', 'acf'), 'data-filter' => 's')); ?>
							<i class="acf-loading"></i>
							<a href="#" class="button-clear acf-icon -cancel acf-js-tooltip" data-action="clear" title="Limpar"></a>
						</div>
					<?php endif; ?>

					<?php if(!empty($field['limit_filter'])): ?>
						<div class="filter -limit">
							<label>
								<span class="acf-js-tooltip" title="Quantidade de itens a ser exibido.">Quantidade</span>
								<?php acf_text_input(array('name' => $field['name'] . "[limit]", 'value' => isset($values['limit']) ? $values['limit'] : $field['limit'], 'type' => 'number', 'step' => 1, 'min' => 1, 'max' => 100, 'data-limit' => '', 'data-filter' => 'limit')); ?>
							</label>
						</div>
					<?php endif; ?>

					<?php if(count($endpointsChoices) > 1): ?>
						<div class="filter -endpoint filter__endpoint acf-js-tooltip" title="Filtrar por tipo de conteúdo.<br />Obs: itens fixados não são afetados por esse filtro.">
							<?php
								acf_select_input(
									array(
										'name' => $field['name'] . "[endpoint]",
										'choices' => $endpointsChoices,
										'value' => isset($values['endpoint']) ? $values['endpoint'] : (!empty($endpointsChoices) ? $endpointsChoices[0] : ''),
										'data-filter' => 'endpoint',
									)
								);
							?>
						</div>
					<?php endif ?>

					<?php if (!empty($field['taxonomies'])) : ?>
						<div class="filter -taxonomies">
							<button type="button" aria-expanded="false" class="components-button components-panel__body-toggle">
								Filtros
								<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="components-panel__arrow" role="img" aria-hidden="true" focusable="false">
									<path d="M17.5 11.6L12 16l-5.5-4.4.9-1.2L12 14l4.5-3.6 1 1.2z"></path>
								</svg>
							</button>
						</div>
					<?php endif; ?>
				</div>

				<?php
				if(!empty($field['taxonomies'])):
					$taxonomies = [];

					foreach($field['taxonomies'] as $tax):
						$taxonomy = get_taxonomy($tax);

						if(empty($taxonomy))
							continue;

						$taxonomies[$tax] = [];
						$taxonomies[$tax]['label'] = $taxonomy->label;
						$taxonomies[$tax]['terms'] = [];

						$terms = get_terms(array(
							'taxonomy' 	 => $tax,
							'hide_empty' => false,
						));

						if(is_wp_error($terms))
							continue;

						foreach($terms as $term)
							$taxonomies[$tax]['terms'][$term->slug] = $term->name;
					endforeach;
				?>

					<div class="taxonomies-selection" data-taxonomies='<?= json_encode($taxonomies) ?>'>
						<div class="taxonomy-row" style="display: none;">
							<label>
								<span class="acf-js-tooltip" title="Quantidade de itens a ser exibido. De 1 a 100">Taxonomia</span>
								<?php acf_select_input(array('data-taxonomy' => '')); ?>
							</label>

							<label>
								<span class="acf-js-tooltip" title="Quantidade de itens a ser exibido. De 1 a 100">Termos</span>
								<?php acf_select_input(array('placeholder' => 'Selecione os termos desejados', 'data-terms' => '', 'multiple' => '')); ?>
							</label>

							<a href="#" class="acf-icon -minus remove-taxonomy-filter acf-js-tooltip" data-action="remove-taxonomy" title="Remover taxonomia"></a>
						</div>

						<?php
						if(!empty($values['taxonomies'])) :
							$choicesTaxonomies = [];
							foreach ($taxonomies as $key => $value)
								$choicesTaxonomies[$key] = $value['label'];

							foreach ($values['taxonomies'] as $key => $taxonomy) :
						?>
								<div class="taxonomy-row">
									<label>
										<span class="acf-js-tooltip" title="Quantidade de itens a ser exibido. De 1 a 100">Taxonomia</span>
										<?php acf_select_input(array('data-taxonomy' => '', 'choices' => $choicesTaxonomies, 'value' => $taxonomy)); ?>
									</label>

									<label>
										<span class="acf-js-tooltip" title="Quantidade de itens a ser exibido. De 1 a 100">Termos</span>
										<?php acf_select_input(array('placeholder' => 'Selecione os termos desejados', 'choices' => $taxonomies[$taxonomy]['terms'], 'value' => $values['terms'][$key], 'data-terms' => '', 'multiple' => '')); ?>
									</label>

									<a href="#" class="acf-icon -minus remove-taxonomy-filter acf-js-tooltip" data-action="remove-taxonomy" title="Remover taxonomia"></a>
								</div>
						<?php
							endforeach;
						endif;
						?>

						<div class="add-container">
							<a href="#" class="acf-icon -plus dark acf-js-tooltip" data-action="add-taxonomy" title="Adicionar taxonomia"></a>
						</div>
					</div>

				<?php endif; ?>

				<div class="selection">
					<div class="choices">
						<ul class="acf-bl list remote-list choices-list"></ul>
					</div>
					<div class="values">
						<ul class="acf-bl list sticky-list"></ul>
						<ul class="acf-bl list values-list"></ul>
					</div>
				</div>

				<?php if(!empty($field['manual_items'])): ?>
					<div class="widgets-acf-modal -fields">
						<div class="widgets-acf-modal-wrapper">
							<div class="widgets-acf-modal-content">
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div><!-- End: -->
			<?php
		}

		/*
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

		function load_field($field) {
			$sub_fields = acf_get_fields($field);

			if($sub_fields)
				$field['sub_fields'] = $sub_fields;

			return $field;
		}

		function format_value($value, $post_id, $field) {
			if(is_admin())
				return $value;
				
			$manual = json_decode($value['manual'], true);
			$data = is_array($value['data']) ? $value['data'] : json_decode($value['data'], true);
			$value['data'] = array();
			$stickys = explode(',', $value['sticky']);

			$posts = empty($manual) ? $data : array_merge($manual, $data);
			
			if(!empty($stickys)):
				foreach($stickys as $sticky):
					$key = array_search($sticky, array_column(json_decode(json_encode($posts), TRUE), 'id'));

					if($key >= 0)
						$value['data'][] = $posts[$key];
				endforeach;
			endif;

			foreach($value['data'] as $key => $postValue)
				unset($posts[$key]);

			$value['data'] = array_unique(array_merge($value['data'], $data), SORT_REGULAR);

			return $value;
		}

		/**
		 * @param $response_code
		 * @return bool
		 */
		private static function responseSuccess($response_code) {
			return $response_code === 200;
		}

		/*
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

		function queryAjax() {
			// validate
			if(!acf_verify_ajax())
				die();

			$response = self::getData($_POST);
			acf_send_ajax_results($response);
		}


		/*
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
		static function getData($options = array()) {
			// load field
			$field = acf_get_field($options['field_key']);
			if(!$field)
				return false;

			$endpointValues = array();

			if(!empty($field['endpoints']))
				$endpointValues = explode('>', $field['endpoints'][0]);

			// defaults
			$options = wp_parse_args($options, array(
				'endpoint'	=> !empty($endpointValues) ? trim($endpointValues[0]) : '',
				'field_key'	=> '',
				'sticky'	=> '',
			));

			$results = [];
			$url = $options['endpoint'];
			$queryArgs = [];
			
			if(!empty($field['filter_fields']))
				$queryArgs['_fields'] = 'id,title,date,link';

			$sticky = isset($options['sticky']) ? $options['sticky'] : 0;
			$stickyItems = !empty($sticky) ? explode(',', $sticky) : [];

			// filter 'm' prefix
			$stickyItemsFilter = array_filter($stickyItems, function ($v) {
				return substr($v, 0, 1) !== 'm';
			});

			if(!empty($field['fields']) && !empty($field['filter_fields']))
				$queryArgs['_fields'] .= ',' . implode(',', $field['fields']);

			if(!empty($stickyItemsFilter)):
				$response = \wp_remote_get(\add_query_arg(array_merge($queryArgs, ['include' => implode(',', $stickyItemsFilter), 'orderby' => 'include']), $url));
				$responseCode = \wp_remote_retrieve_response_code($response);
				$responseData = \wp_remote_retrieve_body($response);

				if(self::responseSuccess($responseCode))
					$results = json_decode($responseData, true);
			endif;

			$limit = isset($options['limit']) ? $options['limit'] : $field['limit'];
			$limit = !empty($limit) && $limit > 0 ? $limit : 1;
			$limit = $limit <= 100 ? $limit : 100;
			$queryArgs['per_page'] = $limit;

			if($limit > count($stickyItems)):
				$queryArgs['per_page'] = count($stickyItems) <= $limit ? $limit - count($stickyItems) : $limit;

				if(isset($options['taxonomies']) && isset($options['terms'])):
					foreach($options['taxonomies'] as $key => $taxonomy)
						$queryArgs["$taxonomy-tax"] = implode(',', $options['terms'][$key]);
				endif;

				// Tests
				$queryArgs['xtt-pa-sedes-tax'] = 'usb';

				if(!empty($stickyItemsFilter))
					$queryArgs['exclude'] = implode(',', $stickyItemsFilter);

				// die(var_dump(\add_query_arg(array_merge($queryArgs, ['orderby' => 'date']), $url)));

				$response = \wp_remote_get(\add_query_arg(array_merge($queryArgs, ['orderby' => 'date']), $url));
				$responseCode = \wp_remote_retrieve_response_code($response);
				$responseData = \wp_remote_retrieve_body($response);

				if(self::responseSuccess($responseCode))
					$results = array_unique(array_merge($results, json_decode($responseData, true)), SORT_REGULAR);
			endif;
			
			// vars
			$response = array(
				'results' => $results,
				'data'	  => json_encode($results),
			);

			return $response;
		}

		function modalAjax() {
			// validate
			if (!acf_verify_ajax())
				die();

			$this->getSubfields($_POST);

			wp_die();
		}

		function getSubfields($options) {
			$field = acf_get_field($options['field_key']);

			$fixedFields = array();
			$fixedFields[] = array(
				'key' => $options['field_key'] . '_title',
				'label' => 'Título',
				'name' => 'title',
				'type' => 'text',
				'required' => 1,
			);
			$fixedFields[] = array(
				'key' => $options['field_key'] . '_link',
				'label' => 'Link',
				'name' => 'link',
				'type' => 'link',
				'required' => 1,
				'wrapper' => array(
					'width' => 50,
				)
			);

			if(empty($field['hide_fields']) || !in_array('featured_media_url', $field['hide_fields'])):
				$fixedFields[] = array(
					'key' => $options['field_key'] . '_thumbnail',
					'label' => 'Thumbnail',
					'name' => 'featured_media_url',
					'type' => 'image',
					'required' => 1,
					'wrapper' => array(
						'width' => 50,
					)
				);
			endif;

			if(empty($field['hide_fields']) || !in_array('content', $field['hide_fields'])):
				$fixedFields[] = array(
					'key' => $options['field_key'] . '_content',
					'label' => 'Resumo',
					'name' => 'content',
					'type' => 'textarea',
					'rows' => 3,
					'required' => 0,
				);
			endif;

			for($i = count($fixedFields) - 1; $i > -1; --$i)
				array_unshift($field['sub_fields'], $fixedFields[$i]);
	
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
				endforeach;
			endif;

			echo '<div class="acf-fields -top -border">';
				foreach($field['sub_fields'] as &$sub_field):
					acf_render_field_wrap($sub_field);
				endforeach;
			echo '</div>';
		}

		/*
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

		function searchAjax() {
			// validate
			if(!acf_verify_ajax()) 
				die();
			
			$response = $this->getSearchData($_POST);
			acf_send_ajax_results($response);	
		}

		/*
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

		function getSearchData($options = array()) {
			// load field
			$field = acf_get_field($options['field_key']);
			if(!$field)
				return false;

			$endpointValues = array();

			if(!empty($field['endpoints']))
				$endpointValues = explode('>', $field['endpoints'][0]);

			// defaults
			$options = wp_parse_args($options, array(
				'endpoint'	=> !empty($endpointValues) ? trim($endpointValues[0]) : '',
				'field_key'	=> '',
				's'			=> '',
			));

			$results = [];
			$url = $options['endpoint'];
			$queryArgs = [];

			if(!empty($field['filter_fields']))
				$queryArgs['_fields'] = 'id,title,date,link';

			$sticky = isset($options['sticky']) ? $options['sticky'] : 0;

			if(!empty($sticky) || isset($options['exclude'])):
				$queryArgs['exclude'] = [];

				if(isset($options['exclude']))
					$queryArgs['exclude'] = array_merge($queryArgs['exclude'], $options['exclude']);
				if(!empty($sticky))
					$queryArgs['exclude'] = array_merge($queryArgs['exclude'], explode(',', $sticky));

				$excludeFilter = array_filter($queryArgs['exclude'], function ($v) {
					return substr($v, 0, 1) !== 'm';
				});

				$queryArgs['exclude'] = implode(',', $excludeFilter);
			endif;

			if(!empty($field['fields']) && !empty($field['filter_fields']))
				$queryArgs['_fields'] .= ',' . implode(',', $field['fields']);

			// search
			if (!empty($options['s']))
				// strip slashes (search may be integer)
				$queryArgs['search'] = wp_unslash(strval($options['s']));

			// die(var_dump(\add_query_arg($queryArgs, $url)));

			$response = \wp_remote_get(\add_query_arg($queryArgs, $url));
			$responseCode = \wp_remote_retrieve_response_code($response);
			$responseData = \wp_remote_retrieve_body($response);

			if(self::responseSuccess($responseCode))
				$results = array_merge($results, json_decode($responseData, true));

			// vars
			$response = array(
				'results'	=> $results,
				'data'		=> json_encode($results),
			);

			return $response;
		}

	}

	// initialize
	new RemoteData();

// class_exists check
endif;
