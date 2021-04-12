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

            /*
            *  name (string) Single word, no spaces. Underscores allowed
            */
            $this->name = 'remote_data';

            /*
            *  label (string) Multiple words, can include spaces, visible when selecting a field type
            */
            $this->label = __('Remote data', 'acf-rest');

            /*
            *  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
            */
            $this->category = 'choice';

            /*
            *  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
            */
            $this->defaults = array(
                'endpoint'	=> '',
            );

            /*
            *  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
            *  var message = acf._e('rest', 'error');
            */
            $this->l10n = array(
                'error'	=> __('Error! Please enter a higher value', 'acf-rest'),
            );

            /**
             * Admin Scripts
             */
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
            /*
            *  acf_render_field_setting
            *
            *  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
            *  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
            *
            *  More than one setting can be added by copy/paste the above code.
            *  Please note that you must also have a matching $defaults value for the field name
            */

			$field['limit'] = empty($field['limit']) ? '' : $field['limit'];

			// acf_render_field_setting($field, array(
			// 	'label'			=> 'teste',
			// 	'instructions'	=> '',
			// 	'type'			=> 'text',
			// 	'name'			=> 'teste',
			// 	'default_value'			=> 0,
			// 	// 'wrapper' => [
			// 	// 	'style' => 'display: none;'
			// 	// ],
			// ));

			acf_hidden_input(array('type' => 'hidden', 'name' => $field['prefix'] . '[sticky]', 'value' => '0'));
			
			acf_render_field_setting($field, array(
				'label'			=> __('Count', 'acf-rest'),
				'instructions'	=> '',
				'type'			=> 'number',
				'name'			=> 'limit',
				'min'			=> 0,
				'step'			=> 1,
			));

            $choices = [];
            foreach($field['fields'] as $value)
                $choices[$value] = $value;

            acf_render_field_setting($field, array(
                'label'			=> __('Fields', 'acf-rest'),
                'instructions'	=> '',
                'type'			=> 'select',
                'name'			=> 'fields',
                'choices'		=> $choices,
                'multiple'		=> 1,
                'ui'			=> 1,
                'allow_null'	=> 0,
                'placeholder'	=> __("All user roles",'acf'),
            ));

            acf_render_field_setting($field, array(
                'label' => __('Endpoint', 'acf-rest'),
                'instructions' => __('Choose the endpoint from which the choices for the rest dropdown will be retrieved', 'acf-rest'),
                'type' => 'text',
                'name' => 'endpoint'
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
            $url = $field['endpoint'];
            $url .= (empty($field['limit']) ? '' : '?per_page=' . $field['limit']);
            $url .= (empty($field['limit']) ? '?' : '&') . '_fields=';

			if(!empty($field['fields'])):
				foreach($field['fields'] as $_field)
					$url .= "{$_field},";
			endif;

            if(!is_array($field['fields']) || is_array($field['fields']) && !in_array('id', $field['fields']))
                $url .= "id,";
            if(!is_array($field['fields']) || is_array($field['fields']) && !in_array('title', $field['fields']))
                $url .= "title,";

            $url = rtrim($url, ',');

            $response = \wp_remote_get($url);
            $response_code = \wp_remote_retrieve_response_code($response);
            $responseData = \wp_remote_retrieve_body($response);

			$options = [];
            if($this->responseSuccess($response_code))
                $options = json_decode($responseData, true);

			// div attributes
			$atts = array(
				'id'				=> $field['id'],
				'class'				=> "acf-remote-data acf-relationship {$field['class']}",
				'data-s'			=> '',
				'data-paged'		=> 1,
			);
            
            ?>

			<div <?php acf_esc_attr_e($atts); ?>>

			<?php acf_hidden_input(array('name' => $field['name'] . "[data]", 'value' => $responseData)); ?>
			<?php acf_hidden_input(array('name' => $field['name'] . "[sticky]", 'value' => $field['sticky'])); ?>

			<div class="filters -f2">
				<div class="filter -search">
					<?php acf_text_input( array('placeholder' => __("Search...",'acf'), 'data-filter' => 's') ); ?>
				</div>	
				<div class="filter -limit">
					<?php acf_text_input(array('name' => $field['name'] . "[limit]", 'value' => $field['limit'], 'type' => 'number', 'step' => 1, 'min' => 0)); ?>
				</div>
			</div>

			<div class="selection">
				<!-- <div class="choices">
					<ul class="acf-bl list choices-list"></ul>
				</div> -->
				<div class="values">
					<ul class="acf-bl list values-list">
						<?php foreach($options as $option): ?>
							<li>
								<?php 
                                // acf_hidden_input(array('name' => $field['name'].'[]', 'value' => $option['id'])); 
                                ?>
								<span data-id="<?php echo esc_attr($option['id']); ?>" class="acf-rel-item">
									<?php echo acf_esc_html($option['title']['rendered']); ?>
									<a href="#" class="acf-icon -pin small dark" data-name="remove_item"></a>
								</span>
							</li>
						<?php endforeach; ?>
					</ul>
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

        public function load_value($value, $post_id, $field) {
            return json_decode($value['data'], true);
        }

    }

    // initialize
    new RemoteData();

// class_exists check
endif;