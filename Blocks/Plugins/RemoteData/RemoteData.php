<?php

namespace Blocks\Plugins\RemoteData;

// exit if accessed directly
if(! defined('ABSPATH')) exit;


// check if class already exists
if(!class_exists('RemoteData')):

    /**
     * Class acf_field_rest
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
			// name (string) Single word, no spaces. Underscores allowed
            $this->name = 'remote_data';
			// label (string) Multiple words, can include spaces, visible when selecting a field type
            $this->label = __('Remote data', 'acf-rest');
            // category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
            $this->category = 'choice';
            // defaults (array) Array of default settings which are merged into the field object. These are used later in settings
            $this->defaults = array('endpoint' => '');

            add_action('wp_ajax_acf/fields/remote_data/query',			array($this, 'ajax_query'));
		    add_action('wp_ajax_nopriv_acf/fields/remote_data/query',	array($this, 'ajax_query'));

			add_action('wp_ajax_acf/fields/remote_data/search',			array($this, 'ajax_search'));
		    add_action('wp_ajax_nopriv_acf/fields/remote_data/search',	array($this, 'ajax_search'));

            // Admin Scripts
            \add_action('admin_enqueue_scripts', function() {
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

			acf_hidden_input(array('type' => 'hidden', 'name' => $field['prefix'] . '[sticky]', 'value' => '0'));
			
			acf_render_field_setting($field, array(
				'label'			=> __('Quantidade', 'acf-rest'),
				'instructions'	=> 'Quantidade de itens a ser retornado pela API',
				'type'			=> 'number',
				'name'			=> 'limit',
				'min'			=> 1,
				'max'			=> 100,
				'step'			=> 1,
			));

            $choices = [];
			if(!empty($field['fields'])):
				foreach($field['fields'] as $value)
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

            acf_render_field_setting($field, array(
                'label'		   => __('Endpoint', 'acf-rest'),
                'instructions' => __('Defina o endpoint de onde as informações serão buscadas', 'acf-rest'),
                'type' 		   => 'url',
                'name' 		   => 'endpoint',
				'placeholder'  => 'https://website.com/wp-json/wp/v2/posts'
            ));
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
			<?php acf_hidden_input(array('name' => $field['name'] . "[sticky]", 'value' => isset($values['sticky']) ? $values['sticky'] : 0, 'data-sticky' => '')); ?>

			<div class="filters -f2">
				<div class="filter -search">
					<?php acf_text_input( array('placeholder' => __("Search...",'acf'), 'data-filter' => 's') ); ?>
					<i class="acf-loading"></i>
					<a href="#" class="button-clear acf-icon -cancel acf-js-tooltip" data-action="clear" title="Limpar"></a>
				</div>	
				<div class="filter -limit">
					<label>
						<span class="acf-js-tooltip" title="Quantidade de itens a ser exibido. De 1 a 100">Quantidade</span>
						<?php acf_text_input(array('name' => $field['name'] . "[limit]", 'value' => isset($values['limit']) ? $values['limit'] : $field['limit'], 'type' => 'number', 'step' => 1, 'min' => 1, 'max' => 100, 'data-limit' => '', 'data-filter' => 'limit')); ?>
					</label>
				</div>

				<a href="#" class="button-update acf-icon -sync dark acf-js-tooltip" data-action="refresh" title="Atualizar"></a>
			</div>

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
        private function responseSuccess($response_code) {
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
		
		function ajax_query() {
			// validate
			if(!acf_verify_ajax()) 
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
		
		function get_ajax_query($options = array()) {
			// defaults
			$options = wp_parse_args($options, array(
				'endpoint'		=> '',
				'field_key'		=> '',
				'sticky'		=> '',
			));
			
			// load field
			$field = acf_get_field($options['field_key']);
			if(!$field) 
				return false;
			
			$results = [];
			$url = $field['endpoint'];
			$queryArgs = ['_fields' => 'id,title,date'];
	
			$sticky = isset($options['sticky']) ? $options['sticky'] : 0;
			$stickyItems = !empty($sticky) ? explode(',', $sticky) : [];

			$limit = isset($options['limit']) ? $options['limit'] : $field['limit'];
			$limit = !empty($limit) && $limit > 0 ? $limit : 1;
			$limit = $limit <= 100 ? $limit : 100;
			$queryArgs['per_page'] = $limit;
	
			if(!empty($field['fields']))
				$queryArgs['_fields'] .= ',' . implode(',', $field['fields']);

			if(!empty($sticky)):
				$response = \wp_remote_get(\add_query_arg(array_merge($queryArgs, ['include' => $sticky, 'orderby' => 'include']), $url));
				$responseCode = \wp_remote_retrieve_response_code($response);
				$responseData = \wp_remote_retrieve_body($response);

				if($this->responseSuccess($responseCode))
					$results = json_decode($responseData, true);
			endif;

			if($limit > count($stickyItems)):
				$queryArgs['per_page'] =  count($stickyItems) <= $limit ? $limit - count($stickyItems) : $limit;

				$response = \wp_remote_get(\add_query_arg(array_merge($queryArgs, ['exclude' => $sticky, 'orderby' => 'date']), $url));
				$responseCode = \wp_remote_retrieve_response_code($response);
				$responseData = \wp_remote_retrieve_body($response);

				if($this->responseSuccess($responseCode))
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
		
		function ajax_search() {
			// validate
			if(!acf_verify_ajax()) 
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
		
		function get_ajax_search($options = array()) {
			// defaults
			$options = wp_parse_args($options, array(
				'endpoint'		=> '',
				'field_key'		=> '',
				's'				=> '',
			));
			
			// load field
			$field = acf_get_field($options['field_key']);
			if(!$field) 
				return false;
			
			$results = [];
			$url = $field['endpoint'];
			$queryArgs = ['_fields' => 'id,title'];
			$queryArgs['per_page'] = 100;
	
			if(!empty($field['fields']))
				$queryArgs['_fields'] .= ',' . implode(',', $field['fields']);

			// search
			if(!empty($options['s']))
				// strip slashes (search may be integer)
				$queryArgs['search'] = wp_unslash(strval($options['s']));

			$response = \wp_remote_get(\add_query_arg($queryArgs, $url));
			$responseCode = \wp_remote_retrieve_response_code($response);
			$responseData = \wp_remote_retrieve_body($response);

			if($this->responseSuccess($responseCode))
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