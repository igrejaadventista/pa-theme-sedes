<?php

namespace Blocks\Plugins\LocalData;

// exit if accessed directly
if (!defined('ABSPATH'))
  exit;

// check if class already exists
if (!class_exists('LocalData')) :

  /**
   * Class LocalData
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
    function __construct()
    {
      $this->name = 'localposts_data';
      $this->label = __('Local data', 'acf-local-data');
      $this->category = 'relational';
      $this->defaults = array(
        'sub_fields'    => [],
        'post_type'      => [],
        'filters'      => ['post_type'],
        'manual_items'  => 1,
        'search_filter' => 1,
        'limit_filter'  => 1,
        'can_sticky'  => 1,
      );
      $this->have_rows = 'single';

      \add_action('wp_ajax_acf/fields/localposts_data/query',   array($this, 'queryAjax'));
      \add_action('wp_ajax_acf/fields/localposts_data/search', array($this, 'searchAjax'));
      \add_action('wp_ajax_acf/fields/localposts_data/modal',   array($this, 'modalAjax'));

      \acf_add_filter_variations('acf/fields/localposts_data/query', array('name', 'key'), 1);

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
      \wp_enqueue_style('acf-local-data-css', \get_template_directory_uri() . '/Blocks/Plugins/LocalData/Assets/local-data.css', false);
      \wp_enqueue_script('acf-local-data.js', \get_template_directory_uri() . '/Blocks/Plugins/LocalData/Assets/local-data.js', ['jquery'], null, true);
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
      $field['limit'] = empty($field['limit']) ? '' : $field['limit'];

      \acf_render_field_setting($field, array(
        'label'      => __('Quantity', 'acf'),
        'instructions'  => 'Number of items to be returned.',
        'type'      => 'number',
        'name'      => 'limit',
        'min'      => 1,
        'max'      => 100,
        'step'      => 1,
        'required'      => 1,
      ));

      // filter (by post types)
      \acf_render_field_setting($field, array(
        'label'      => __('Filter by Post Type', 'acf'),
        'instructions'  => '',
        'type'      => 'select',
        'name'      => 'post_type',
        'choices'    => \acf_get_pretty_post_types(),
        'multiple'    => 1,
        'ui'      => 1,
        'allow_null'  => 1,
        'placeholder'  => __("All post types", 'acf'),
      ));

      $taxonomies = \get_taxonomies(['_builtin' => false], 'objects');
      $choices = [];

      foreach ($taxonomies as $taxonomy)
        $choices[$taxonomy->name] = $taxonomy->label;

      \acf_render_field_setting($field, array(
        'label'      => __('Taxonomias', 'acf'),
        'instructions'  => 'Defina quais taxonomias estarão disponíveis nos filtros',
        'type'      => 'select',
        'name'      => 'taxonomies',
        'choices'    => $choices,
        'multiple'    => 1,
        'ui'      => 1,
        'allow_null'  => 0,
        'placeholder'  => __('Select taxonomies', 'acf'),
      ));

      \acf_render_field_setting($field, array(
        'label'      => __('Enable: Search?', 'acf'),
        'type'      => 'true_false',
        'name'      => 'search_filter',
        'ui'      => 1,
        'default_value'  => 1,
      ));

      \acf_render_field_setting($field, array(
        'label'      => __('Enable: Number of items?', 'acf'),
        'type'      => 'true_false',
        'name'      => 'limit_filter',
        'ui'      => 1,
        'default_value'  => 1,
      ));

      \acf_render_field_setting($field, array(
        'label'      => __('Enable: Sticky itens?', 'acf'),
        'type'      => 'true_false',
        'name'      => 'can_sticky',
        'ui'      => 1,
        'default_value'  => 1,
      ));

      \acf_render_field_setting($field, array(
        'label'      => __('Enable: Manual content?', 'acf'),
        'type'      => 'true_false',
        'name'      => 'manual_items',
        'ui'      => 1,
        'default_value'  => 1,
      ));

      // vars
      $args = array(
        'fields'  => $field['sub_fields'],
        'parent'  => $field['ID']
      );

?>
      <tr class="acf-field acf-field-setting-sub_fields" data-setting="group" data-name="sub_fields">
        <td class="acf-label">
          <label><?= __('Manual content fields', 'acf'); ?></label>
        </td>
        <td class="acf-input">
          <?php \acf_get_view('field-group-fields', $args); ?>
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
      if (in_array('post_type', $filters)) :
        $filter_post_type_choices = array(
          ''  => 'Todos'
        ) + acf_get_pretty_post_types($post_type);
      endif;

      // div attributes
      $atts = array(
        'id'        => $field['id'],
        'class'        => "acf-local-data acf-relationship {$field['class']}",
        'data-s'      => '',
        'data-post_type'  => '',
        'data-can_sticky'  => $field['can_sticky'],
      );
    ?>
      <div <?php acf_esc_attr_e($atts); ?>>
        <?php acf_hidden_input(array('name' => $field['name'] . "[manual]", 'value' => isset($values['manual']) ? $values['manual'] : '', 'data-manual' => '')); ?>
        <?php acf_hidden_input(array('name' => $field['name'] . "[sticky]", 'value' => isset($values['sticky']) ? $values['sticky'] : '', 'data-sticky' => '')); ?>

        <div class="action-toolbar">
          <?php if (!empty($field['manual_items'])) : ?>
            <button type="button" class="buttonAddManualPost disabled acf-js-tooltip" data-action="manual-new-post" title="<?= _e('Add manual itens', 'iasd'); ?>" disabled><?= _e('Add manual itens', 'iasd'); ?></button>
          <?php endif; ?>

          <button type="button" class="buttonUpdateTaxonomies acf-js-tooltip" data-action="refresh" title="<?= _e('Refresh', 'iasd'); ?>" aria-label="<?= _e('Refresh', 'iasd'); ?>">
            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" aria-hidden="true" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="23 4 23 10 17 10"></polyline>
              <polyline points="1 20 1 14 7 14"></polyline>
              <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg>
          </button>
        </div>

        <div class="filters -f3">
          <?php if (!empty($field['search_filter'])) : ?>
            <div class="filter -search">
              <?php /* search filters */
              acf_text_input(array('placeholder' => __('Search...', 'iasd'), 'data-filter' => 's')); ?>
              <i class="acf-loading"></i>
              <a href="#" class="button-clear acf-icon -cancel acf-js-tooltip" data-action="clear" title="Limpar"></a>
            </div>
          <?php endif; ?>

          <?php if (!empty($field['limit_filter'])) : ?>
            <div class="filter -limit">
              <label>
                <span class="acf-js-tooltip" title="<?= _e('Number of items to be displayed.', 'iasd'); ?>"><?= _e('Quantity', 'iasd'); ?></span>
                <?php acf_text_input(array('name' => $field['name'] . "[limit]", 'value' => isset($values['limit']) ? $values['limit'] : $field['limit'], 'type' => 'number', 'step' => 1, 'min' => 1, 'max' => 100, 'data-limit' => '', 'data-filter' => 'limit')); ?>
              </label>
            </div>
          <?php else : ?>
            <?php acf_hidden_input(array('name' => $field['name'] . "[limit]", 'value' => $field['limit'], 'data-limit' => '')); ?>
          <?php endif; ?>

          <?php if (
            in_array('post_type', $filters)
            && count($filter_post_type_choices) > 2
          ) : ?>
            <div class="filter -post_type filter__post_type acf-js-tooltip" title="<?= _e('Filter by post type.<br />Obs: Fixed items are not affected by this filter.', 'iasd'); ?>">
              <?php
              acf_select_input(
                array(
                  'name' => $field['name'] . "[post_type_filter]",
                  'choices' => $filter_post_type_choices,
                  'value' => isset($values['post_type_filter']) ? $values['post_type_filter'] : '',
                  'data-filter' => 'post_type',
                )
              );
              ?>
            </div>
          <?php endif; ?>

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
              'taxonomy'    => $tax,
              'hide_empty' => false,
            ));

            if (is_wp_error($terms))
              continue;

            foreach ($terms as $term)
              $taxonomies[$tax]['terms'][$term->slug] = $term->name;
          endforeach;
        ?>

          <div class="taxonomies-selection" data-taxonomies='<?= json_encode($taxonomies) ?>'>

            <?php acf_text_input(array('name' => $field['name'] . "[taxonomies]", 'value' => isset($values['taxonomies']) ? $values['taxonomies'] : '', 'type' => 'hidden', 'data-taxonomies-value' => '')); ?>
            <?php acf_text_input(array('name' => $field['name'] . "[terms]", 'value' => isset($values['terms']) ? $values['terms'] : '', 'type' => 'hidden', 'data-terms-value' => '')); ?>

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


              $values['taxonomies'] = is_array($values['taxonomies']) ? $values['taxonomies'] : json_decode($values['taxonomies']);
              $values['terms'] = is_array($values['terms']) ? $values['terms'] : json_decode($values['terms']);

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
            <div class="list-tile">
              <span><?= _e('Results', ''); ?></span>
            </div>

            <ul class="acf-bl list local-list choices-list"></ul>
          </div>
          <div class="values">
            <ul class="acf-bl list sticky-list"></ul>

            <div class="list-tile">
              <span><?= _e('Sticky', ''); ?></span>
            </div>

            <div class="list-tile">
              <span><?= _e('Recents', ''); ?></span>
            </div>

            <ul class="acf-bl list values-list"></ul>
          </div>
        </div>

        <?php if (!empty($field['manual_items'])) : ?>
          <div class="widgets-acf-modal -fields">
            <div class="widgets-acf-modal-wrapper">
              <div class="widgets-acf-modal-content">
                <div class="acf-notice-render"></div>
              </div>
            </div>
          </div>
        <?php endif; ?>
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

      if ($sub_fields)
        $field['sub_fields'] = $sub_fields;

      return $field;
    }

    function format_value($value, $post_id, $field)
    {
      if (!is_array($value))
        $value = array();

      $value['post_type'] = array_key_exists('post_type', $field) ? acf_get_array($field['post_type']) : acf_get_array(['post']);
      $manual = array_key_exists('manual', $value) ? json_decode($value['manual'], true) : [];
      $value['data'] = array();

      if (!is_admin()) :
        $stickys = explode(',', isset($value['sticky']) ? $value['sticky'] : '');

        $args = [
          'limit' => isset($value['limit']) ? $value['limit'] : $field['limit'],
          'sticky' => isset($value['sticky']) ? $value['sticky'] : '',
          'field_key' => $field['key'],
          'post_type' => !empty($value['post_type_filter']) ? $value['post_type_filter'] : $value['post_type'],
        ];

        if (isset($value['taxonomies']) && isset($value['terms'])) :
          if (!empty($value['taxonomies']) && !empty($value['terms'])) :
            $value['taxonomies'] = is_array($value['taxonomies']) ? $value['taxonomies'] : json_decode($value['taxonomies']);
            $value['terms'] =  is_array($value['terms']) ? $value['terms'] : json_decode($value['terms']);

            $args['taxonomies'] = $value['taxonomies'];
            $args['terms'] = $value['terms'];
          endif;
        endif;

        $data = $this->getData($args);

        $posts = empty($manual) ? $data['results'] : array_merge($manual, $data['results']);

        if (!empty($stickys)) :
          foreach ($stickys as $sticky) :
            $key = array_search($sticky, array_column(json_decode(json_encode($posts), TRUE), 'id'));

            if (is_numeric($key) && $key >= 0 && array_key_exists($key, $posts))
              $value['data'][] = $posts[$key];
          endforeach;
        endif;

        foreach ($value['data'] as $key => $postValue)
          unset($posts[$key]);

        $value['data'] = array_merge($value['data'], $posts);
      endif;

      return $value;
    }

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

    function queryAjax()
    {
      // validate
      if (!acf_verify_ajax())
        die();

      $response = $this->getData($_POST);
      acf_send_ajax_results($response);
    }

    /**
     *  parsePost
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
    function parsePost($post)
    {
      return array(
        'id'           => $post->ID,
        'date'           => $post->post_date,
        'title'         => array(
          'rendered'       => $post->post_title,
        ),
        'cpt_label'        => array(
          'rendered'      => \get_post_type_object(\get_post_type($post->ID))->labels->singular_name,
        ),
        'featured_media_url'   => array(
          'pa_block_render'   => \get_the_post_thumbnail_url($post->ID, 'large'),
        ),
        'excerpt'         => array(
          'rendered'       => $post->post_excerpt,
        ),
      );
    }

    /**
     * getData
     *
     * @param  mixed $options
     * @return void
     */
    function getData($options = array())
    {
      // defaults
      $options = wp_parse_args($options, array(
        'sticky'    => '',
        'post_id'    => 0,
        'field_key'    => '',
        'paged'      => 1,
        'post_type'    => '',
      ));

      // load field
      $field = acf_get_field($options['field_key']);

      if (!$field)
        return false;

      // vars
      $results = [];
      $args = [];

      // paged
      $args['paged'] = intval($options['paged']);

      $sticky = isset($options['sticky']) ? $options['sticky'] : 0;
      $stickyItems = !empty($sticky) ? explode(',', $sticky) : [];

      $stickyItemsFilter = array_filter($stickyItems, function ($v) {
        return substr($v, 0, 1) !== 'm';
      });

      $limit = isset($options['limit']) ? $options['limit'] : $field['limit'];
      $args['posts_per_page'] = (int)$limit;
      $args['posts_per_page'] = $args['posts_per_page'] - (count($stickyItems) - count($stickyItemsFilter));

      // filter by post types
      if (!empty($options['post_type']))
        // selected
        $args['post_type'] = acf_get_array($options['post_type']);
      elseif (!empty($field['post_type']))
        // default
        $args['post_type'] = acf_get_array($field['post_type']);
      else
        $args['post_type'] = acf_get_post_types();


      $stickedArr = [];
      if (!empty($stickyItemsFilter)) :
        // get array of values from sticky posts
        $stickyIds = array_values($stickyItemsFilter);

        // exclude sticked posts from query
        $args['post__not_in'] = $stickyIds;

        // return only sticked array items
        $stickedPosts = get_posts(array(
          'include'  => $stickyIds,
          'post_type'  => get_post_types(),
        ));

        foreach ($stickedPosts as $post)
          //  push data into $results
          $stickedArr[] = $this->parsePost($post);

        // remove sticked posts from results...
        $args['posts_per_page'] = $args['posts_per_page'] - count($stickedArr);
      endif;

      if (isset($options['taxonomies']) && isset($options['terms'])) :
        $args['tax_query'] = array(
          'relation' => 'AND',
        );

        foreach ($options['taxonomies'] as $key => $taxonomy) :
          if (!array_key_exists($key, $options['terms']))
            continue;

          $args['tax_query'][] = array(
            'taxonomy' => $taxonomy,
            'field'    => 'slug',
            'terms'    => $options['terms'][$key],
          );
        endforeach;
      endif;

      // filters
      $args['post_status'] = 'publish';
      $args = \apply_filters('acf/fields/localposts_data/query', $args, $field, $options['post_id']);

      if ($args['posts_per_page'] > 0) :
        // get queried posts
        $query = new \WP_Query($args);

        if (!empty($query->found_posts)) :
          foreach ($query->posts as $post)
            //  push data into $results
            $results[] = $this->parsePost($post);
        endif;
      endif;

      $mergedResults = array_merge($stickedArr, $results);

      // vars
      return array(
        'results'  => $mergedResults,
        'limit'    => $args['posts_per_page'],
        'data'    => json_encode($mergedResults),
      );
    }

    function modalAjax()
    {
      // validate
      if (!acf_verify_ajax())
        die();

      $this->getSubfields($_POST);

      wp_die();
    }

    function getSubfields($options)
    {
      $field = acf_get_field($options['field_key']);

      $fixedFields = array();
      $fixedFields[] = array(
        'key' => $options['field_key'] . '_title',
        'label' => __('Title', 'iasd'),
        'name' => 'title',
        'type' => 'text',
        'required' => 1,
      );
      $fixedFields[] = array(
        'key' => $options['field_key'] . '_link',
        'label' => __('Link', 'iasd'),
        'name' => 'link',
        'type' => 'link',
        'required' => 1,
        'wrapper' => array(
          'width' => 50,
        )
      );

      if (empty($field['hide_fields']) || !in_array('featured_media_url', $field['hide_fields'])) :
        $fixedFields[] = array(
          'key' => $options['field_key'] . '_thumbnail',
          'label' => __('Thumbnail', 'iasd'),
          'name' => 'featured_media_url',
          'type' => 'image',
          'required' => 1,
          'wrapper' => array(
            'width' => 50,
          )
        );
      endif;

      if (empty($field['hide_fields']) || !in_array('excerpt', $field['hide_fields'])) :
        $fixedFields[] = array(
          'key' => $options['field_key'] . '_excerpt',
          'label' => __('Excerpt', 'iasd'),
          'name' => 'excerpt',
          'type' => 'textarea',
          'rows' => 3,
          'required' => 0,
        );
      endif;

      for ($i = count($fixedFields) - 1; $i > -1; --$i)
        array_unshift($field['sub_fields'], $fixedFields[$i]);

      // load values
      if (isset($options['data'])) :
        foreach ($field['sub_fields'] as &$sub_field) :
          if (isset($options['data'][$sub_field['name']])) :
            if ($sub_field['name'] == 'title' || $sub_field['name'] == 'excerpt')
              $sub_field['value'] = $options['data'][$sub_field['name']]['rendered'];
            elseif ($sub_field['name'] == 'featured_media_url')
              $sub_field['value'] = $options['data'][$sub_field['name']]['id'];
            else
              $sub_field['value'] = $options['data'][$sub_field['name']];
          endif;
        endforeach;
        unset($sub_field);
      endif;

      echo '<div class="acf-fields -top -border">';
      foreach ($field['sub_fields'] as &$sub_field) :
        acf_render_field_wrap($sub_field);
      endforeach;
      unset($sub_field);
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

    function searchAjax()
    {
      // validate
      if (!acf_verify_ajax())
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

    function getSearchData($options = array())
    {
      // defaults
      $options = wp_parse_args($options, array(
        'field_key'  => '',
        's'      => '',
        'limit'     => -1,
      ));

      // load field
      $field = acf_get_field($options['field_key']);
      if (!$field)
        return false;

      $results = array();
      $queryArgs = array();

      $sticky = isset($options['sticky']) ? $options['sticky'] : 0;

      if (!empty($sticky) || isset($options['exclude'])) :
        $queryArgs['post__not_in'] = [];

        if (isset($options['exclude']))
          $queryArgs['post__not_in'] = array_merge($queryArgs['post__not_in'], $options['exclude']);
        if (!empty($sticky))
          $queryArgs['post__not_in'] = array_merge($queryArgs['post__not_in'], explode(',', $sticky));
      endif;

      // search
      if (!empty($options['s']))
        // strip slashes (search may be integer)
        $queryArgs['s'] = wp_unslash(strval($options['s']));

      if (!empty($options['limit']))
        $queryArgs['posts_per_page'] = wp_unslash(strval($options['limit']));

      $queryArgs['post_type'] = $field['post_type'];

      $query = (new \WP_Query($queryArgs));

      if (!empty($query->posts)) :

        foreach ($query->posts as $post) :

          //  push data into $results
          $results[] = $this->parsePost($post);
        endforeach;
      endif;

      // vars	
      return array(
        'results'  => $results,
        'data'    => json_encode($results),
      );
    }

     /**
		 * Apply basic formatting to prepare the value for default REST output.
		 *
		 * @param mixed      $value
		 * @param string|int $post_id
		 * @param array      $field
		 * @return mixed
		 */
		public function format_value_for_rest($value, $post_id, array $field) {
      $data = $this->format_value($value, $post_id, $field);

      if(!is_array($data) || !array_key_exists('sticky', $data) || !array_key_exists('data', $data))
        return $value;

      $ids = explode(',', $data['sticky']);

      $values = array_filter($data['data'], function($post) use($ids) {
        return in_array($post['id'], $ids);
      });

      $values = array_map(function($post) {
        $post['link'] = get_permalink($post['id']);

        return $post;
      }, $values);

			return $values;
		}

  }

  // initialize
  $initializeLocalData = new LocalData();
  acf_register_field_type($initializeLocalData);

// class_exists check
endif;
