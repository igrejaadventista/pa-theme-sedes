<?php

namespace Blocks\Plugins\RemoteData;

// exit if accessed directly
if (!defined('ABSPATH')) exit;


// check if class already exists
if (!class_exists('RemoteData')) :

	/**
	 * Class acf_field_rest
	 */
	class RemoteData extends \acf_field
	{

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
		function __construct()
		{
			// name (string) Single word, no spaces. Underscores allowed
			$this->name = 'remote_data';
			// label (string) Multiple words, can include spaces, visible when selecting a field type
			$this->label = __('Remote data', 'acf-rest');
			// category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
			$this->category = 'choice';
			// defaults (array) Array of default settings which are merged into the field object. These are used later in settings
			$this->defaults = array('endpoint' => '');

			add_action('wp_ajax_acf/fields/remote_data/query',				array($this, 'ajax_query'));
			add_action('wp_ajax_nopriv_acf/fields/remote_data/query',		array($this, 'ajax_query'));

			add_action('wp_ajax_acf/fields/remote_data/search',				array($this, 'ajax_search'));
			add_action('wp_ajax_nopriv_acf/fields/remote_data/search',		array($this, 'ajax_search'));

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
		function input_admin_enqueue_scripts()
		{
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
		function render_field_settings($field)
		{
			$field['limit'] = empty($field['limit']) ? '' : $field['limit'];

			acf_hidden_input(array('type' => 'hidden', 'name' => $field['prefix'] . '[sticky]', 'value' => '0'));

			acf_render_field_setting($field, array(
				'label'		   => __('Endpoint', 'acf-rest'),
				'instructions' => __('Defina o endpoint de onde as informações serão buscadas', 'acf-rest'),
				'type' 		   => 'url',
				'name' 		   => 'endpoint',
				'placeholder'  => 'https://website.com/wp-json/wp/v2/posts',
				'required'	   => 1,
			));

			acf_render_field_setting($field, array(
				'label'			=> __('Quantidade', 'acf-rest'),
				'instructions'	=> 'Quantidade de itens a ser retornado pela API',
				'type'			=> 'number',
				'name'			=> 'limit',
				'min'			=> 1,
				'max'			=> 100,
				'step'			=> 1,
				'required'	    => 1,
			));

			$choices = [];
			if (!empty($field['fields'])) :
				foreach ($field['fields'] as $value)
					$choices[$value] = $value;
			endif;

			acf_render_field_setting($field, array(
				'label'			=> __('Campos', 'acf-rest'),
				'instructions'	=> 'Defina quais campos deverão ser retornados da API. Os campos id e title já são retornados automaticamente',
				'type'			=> 'select',
				'name'			=> 'fields',
				'choices'		=> $choices,
				'multiple'		=> 1,
				'ui'			=> 1,
				'allow_null'	=> 0,
				'placeholder'	=> __('Digite os nomes dos campos', 'acf-rest'),
			));

			$taxonomies = get_taxonomies(['_builtin' => false], 'objects');
			$choices = [];

			foreach ($taxonomies as $taxonomy)
				$choices[$taxonomy->name] = $taxonomy->label;

			acf_render_field_setting($field, array(
				'label'			=> __('Taxonomias', 'acf-rest'),
				'instructions'	=> 'Defina quais taxonomias estarão disponíveis nos filtros',
				'type'			=> 'select',
				'name'			=> 'taxonomies',
				'choices'		=> $choices,
				'multiple'		=> 1,
				'ui'			=> 1,
				'allow_null'	=> 0,
				'placeholder'	=> __('Selecione as taxonomias', 'acf-rest'),
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
		function render_field($field)
		{
			$values = get_field($field['key']);

			// div attributes
			$atts = array(
				'id'				=> $field['id'],
				'class'				=> "acf-remote-data acf-relationship {$field['class']}",
				'data-s'			=> '',
				'data-paged'		=> 1,
			);

		?>
			<div <?php acf_esc_attr_e($atts); ?>>

				<?php acf_hidden_input(array('name' => $field['name'] . "[data]", 'value' => isset($values['data']) ? $values['data'] : '', 'data-values' => '')); ?>
				<?php acf_hidden_input(array('name' => $field['name'] . "[manual]", 'value' => isset($values['manual']) ? $values['manual'] : '', 'data-manual' => '')); ?>
				<?php acf_hidden_input(array('name' => $field['name'] . "[sticky]", 'value' => isset($values['sticky']) ? $values['sticky'] : 0, 'data-sticky' => '')); ?>

				<div class="action-toolbar">
					<button type="button" class="buttonAddManualPost disabled_" data-action="manual-new-post">Adicionar manual</button>

					<button type="button" class="buttonUpdateTaxonomies acf-js-tooltip" data-action="refresh" title="Atualizar" aria-label="Atualizar">
						<svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" aria-hidden="true" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
					</button>
				</div>

				<div class="filters -f3">
					<div class="filter -search">
						<?php acf_text_input(array('placeholder' => __("Search...", 'acf'), 'data-filter' => 's')); ?>
						<i class="acf-loading"></i>
						<a href="#" class="button-clear acf-icon -cancel acf-js-tooltip" data-action="clear" title="Limpar"></a>
					</div>
					<div class="filter -limit">
						<label>
							<span class="acf-js-tooltip" title="Quantidade de itens a ser exibido. De 1 a 100">Quantidade</span>
							<?php acf_text_input(array('name' => $field['name'] . "[limit]", 'value' => isset($values['limit']) ? $values['limit'] : $field['limit'], 'type' => 'number', 'step' => 1, 'min' => 1, 'max' => 100, 'data-limit' => '', 'data-filter' => 'limit')); ?>
						</label>
					</div>

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
				if (!empty($field['taxonomies'])) :
					$taxonomies = [];

					foreach ($field['taxonomies'] as $tax) :
						$taxonomy = get_taxonomy($tax);

						if (empty($taxonomy))
							continue;

						$taxonomies[$tax] = [];
						$taxonomies[$tax]['label'] = $taxonomy->label;
						$taxonomies[$tax]['terms'] = [];

						$terms = get_terms(array(
							'taxonomy' 	 => $tax,
							'hide_empty' => false,
						));

						if (is_wp_error($terms))
							continue;

						foreach ($terms as $term)
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
						if (!empty($values['taxonomies'])) :
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
						<ul class="acf-bl list choices-list"></ul>
					</div>
					<div class="values">
						<ul class="acf-bl list sticky-list"></ul>
						<ul class="acf-bl list values-list"></ul>
					</div>
				</div>
			</div>
<?php
		}

		/**
		 * @param $response_code
		 * @return bool
		 */
		private function responseSuccess($response_code)
		{
			return $response_code === 200;
		}

		// public function load_value($value, $post_id, $field) {
		//     return json_decode($value['data'], true);
		// }

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

		function get_ajax_query($options = array())
		{
			// defaults
			$options = wp_parse_args($options, array(
				'endpoint'		=> '',
				'field_key'		=> '',
				'sticky'		=> '',
			));

			// load field
			$field = acf_get_field($options['field_key']);
			if (!$field)
				return false;

			$results = [];
			$url = $field['endpoint'];
			$queryArgs = ['_fields' => 'id,title,date,featured_media_url'];

			$sticky = isset($options['sticky']) ? $options['sticky'] : 0;
			$stickyItems = !empty($sticky) ? explode(',', $sticky) : [];

			$limit = isset($options['limit']) ? $options['limit'] : $field['limit'];
			$limit = !empty($limit) && $limit > 0 ? $limit : 1;
			$limit = $limit <= 100 ? $limit : 100;
			$queryArgs['per_page'] = $limit;

			if (!empty($field['fields']))
				$queryArgs['_fields'] .= ',' . implode(',', $field['fields']);

			if (!empty($sticky)) :
				$response = \wp_remote_get(\add_query_arg(array_merge($queryArgs, ['include' => $sticky, 'orderby' => 'include']), $url));
				$responseCode = \wp_remote_retrieve_response_code($response);
				$responseData = \wp_remote_retrieve_body($response);

				if ($this->responseSuccess($responseCode))
					$results = json_decode($responseData, true);
			endif;

			if ($limit > count($stickyItems)) :
				$queryArgs['per_page'] = count($stickyItems) <= $limit ? $limit - count($stickyItems) : $limit;

				if (isset($options['taxonomies']) && isset($options['terms'])) :
					foreach ($options['taxonomies'] as $key => $taxonomy)
						$queryArgs["$taxonomy-tax"] = implode(',', $options['terms'][$key]);
				endif;

				// die(var_dump(\add_query_arg(array_merge($queryArgs, ['exclude' => $sticky, 'orderby' => 'date']), $url))); 

				$response = \wp_remote_get(\add_query_arg(array_merge($queryArgs, ['exclude' => $sticky, 'orderby' => 'date']), $url));
				$responseCode = \wp_remote_retrieve_response_code($response);
				$responseData = \wp_remote_retrieve_body($response);

				if ($this->responseSuccess($responseCode))
					$results = array_merge($results, json_decode($responseData, true));
			endif;

			// vars
			$response = array(
				'results'	=> $results,
				'data'		=> json_encode($results),
			);

			// return
			return $response;
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

		function ajax_search()
		{
			// validate
			if (!acf_verify_ajax())
				die();

			// get choices
			$response = $this->get_ajax_search($_POST);

			// return
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

		function get_ajax_search($options = array())
		{
			// defaults
			$options = wp_parse_args($options, array(
				'endpoint'		=> '',
				'field_key'		=> '',
				's'				=> '',
			));

			// load field
			$field = acf_get_field($options['field_key']);
			if (!$field)
				return false;

			$results = [];
			$url = $field['endpoint'];
			$queryArgs = ['_fields' => 'id,title,date,featured_media_url'];

			$sticky = isset($options['sticky']) ? $options['sticky'] : 0;

			if (!empty($sticky) || isset($options['exclude'])) :
				$queryArgs['exclude'] = [];

				if (isset($options['exclude']))
					$queryArgs['exclude'] = array_merge($queryArgs['exclude'], $options['exclude']);
				if (!empty($sticky))
					$queryArgs['exclude'] = array_merge($queryArgs['exclude'], explode(',', $sticky));
			endif;

			if (!empty($field['fields']))
				$queryArgs['_fields'] .= ',' . implode(',', $field['fields']);

			// search
			if (!empty($options['s']))
				// strip slashes (search may be integer)
				$queryArgs['search'] = wp_unslash(strval($options['s']));

			// die(var_dump(\add_query_arg($queryArgs, $url))); 

			$response = \wp_remote_get(\add_query_arg($queryArgs, $url));
			$responseCode = \wp_remote_retrieve_response_code($response);
			$responseData = \wp_remote_retrieve_body($response);

			if ($this->responseSuccess($responseCode))
				$results = array_merge($results, json_decode($responseData, true));

			// vars
			$response = array(
				'results'	=> $results,
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
