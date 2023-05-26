<?php

namespace IASD\Core;

class Taxonomies {
  
  /**
   * List of taxonomies
   *
   * @var array
   */
  private $taxonomies = [];

  public function __construct() {
    $this->taxonomies = [
      'xtt-pa-colecoes'      => [__('Collections', 'webdsa'),           __('Collection', 'webdsa'),           false],
      'xtt-pa-editorias'     => [__('Editorials', 'webdsa'),            __('Editorial', 'webdsa'),            true],
      'xtt-pa-departamentos' => [__('Ministries', 'webdsa'),            __('Ministry', 'webdsa'),             false],
      'xtt-pa-projetos'      => [__('Projects', 'webdsa'),              __('Project', 'webdsa'),              false],
      'xtt-pa-regiao'        => [__('Region', 'webdsa'),                __('Regions', 'webdsa'),              false],
      'xtt-pa-sedes'         => [__('Regional Headquarters', 'webdsa'), __('Regional Headquarter', 'webdsa'), true],
      'xtt-pa-owner'         => [__('Owner Headquarter', 'webdsa'),     __('Owner Headquarter', 'webdsa'),    true],
      'xtt-pa-materiais'     => [__('File type', 'webdsa'),             __('File type', 'webdsa'),            false]
    ];

    add_action('after_setup_theme', [$this, 'register'], 8);
    add_filter('rest_post_query',   [$this, 'filterQuery'], 10, 2);

    // Desativar o delete default de terms do WP
    add_filter('pre_delete_term', [$this, 'delete']);

    // Inserindo Filtros de Lixeira e Ativos
    add_filter('get_terms', [$this, 'get']);

    // Action Restaurar
    add_filter('tag_row_actions', [$this, 'filterActions'], 10, 2);
    add_action('admin_init',      [$this, 'restore']);

    add_action('admin_head', [$this, 'styles']);
  }
  
  /**
   * Add custom styles
   *
   * @return void
   */
  function styles(): void {
    echo '<style>
            .edit-tags-php #wpbody-content .actions.bulkactions, 
            #wpbody-content .form-field.term-parent-wrap a,
            #wpbody-content .edit-tag-actions #delete-link {
              display:none;
            }
          </style>';
  }
  
  /**
   * Register taxonomies
   *
   * @return void
   */
  function register(): void {
    foreach($this->taxonomies as $key => $value):
      $labels = array(
        'name'              => $value[0],
        'singular_name'     => $value[1],
        'search_items'      => __('Search', 'webdsa'),
        'all_items'         => __('All itens', 'webdsa'),
        'parent_item'       => $value[1] . ', father',
        'parent_item_colon' => $value[1] . ', father',
        'edit_item'         => __('Edit', 'webdsa'),
        'update_item'       => __('Update', 'webdsa'),
        'add_new_item'      => __('Add new', 'webdsa'),
        'new_item_name'     => __('New', 'webdsa'),
        'menu_name'         => $value[1],
      );

      $args   = array(
        'hierarchical'        => true, // make it hierarchical (like categories)
        'labels'              => $labels,
        'show_ui'             => true,
        'show_in_menu'        => current_user_can('administrator'),
        'show_admin_column'   => $value[2],
        'query_var'           => true,
        'rewrite'             => array('slug' => sanitize_title($value[1])),
        'public'              => true,
        'show_in_rest'        => true, // add support for Gutenberg editor
      );

      register_taxonomy($key, ['post'], $args);
    endforeach;
  }
  
  /**
   * Filter query arguments 
   *
   * @param  array           $args Array of arguments for WP_Query
   * @param  WP_REST_Request $request The REST API request
   * 
   * @return array Modified arguments
   */
  function filterQuery(array $args, \WP_REST_Request $request): array {
    $params = $request->get_params();

    foreach($this->taxonomies as $key => $value):
      if(isset($params["{$key}-tax"])):
        $args['tax_query'][] = array(
          array(
            'taxonomy'         => $key,
            'field'            => 'slug',
            'terms'            => explode(',', $params["{$key}-tax"]),
            'include_children' => false
          )
        );
      endif;
    endforeach;

    return $args;
  }
  
  /**
   * Move term to trash
   *
   * @param  int $term_id Term ID
   * 
   * @return void
   */
  function delete(int $term_id): void {
    $term_trash = get_term_meta($term_id, 'term_trash', true);
    $user       = wp_get_current_user();
    $roles      = (array) $user->roles;

    if(!$term_trash || ($term_trash && $roles[0] != 'administrator'))
      wp_die(add_term_meta($term_id, 'term_trash', true));
  }
  
  /**
   * Get terms
   *
   * @param  array $terms Array of found terms
   * 
   * @return array Modified terms
   */
  function get(array $terms): array {
    if (!isset($_GET['tag_ID'])) {
      $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

      $disableds = 0;
      $enableds = 0;

      foreach ($terms as $keyt => $term) {
        if (isset($term->term_id)) {
          $term_trash = get_term_meta($term->term_id, 'term_trash', true);

          if ($term_trash) {
            $terms[$keyt]->parent = 0;
            if (!isset($_GET['terms_trashed'])) {
              unset($terms[$keyt]);
            }
            $disableds++;
          } else {
            if (isset($_GET['terms_trashed'])) {
              unset($terms[$keyt]);
            }
            $enableds++;
          }
        }
      }

      if (strpos($actual_link, 'edit-tags.php?taxonomy=')) {
        $actual_link = str_replace('&terms_trashed=true', '', $actual_link);
        echo '<a href="' . $actual_link . '" style="position: absolute;margin-top: -30px;">Ativos (' . $enableds . ')</a>';
        echo '<a href="' . $actual_link . '&terms_trashed=true" style="position: absolute;margin-top: -30px;margin-left: 100px;">Lixeira (' . $disableds . ')</a>';
      }
    }

    return $terms;
  }
  
  /**
   * Filter tags actions
   *
   * @param  array $actions An array of action links to be displayed
   * @param  WP_Term $tag Term object
   * 
   * @return array Modified actions
   */
  function filterActions(array $actions, \WP_Term $tag): array {
    $term_id = $tag->term_id;

    if(isset($_GET['terms_trashed'])) {
      $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      $actual_link = str_replace('&restore_term=' . $term_id, '', $actual_link);

      $actions['restore'] = '<a href="' . $actual_link . '&restore_term=' . $term_id . '">Restaurar</a>';
    } 
    else
      $actions['delete'] = str_replace('Excluir', 'Lixeira', $actions['delete']);

    return $actions;
  }
  
  /**
   * Restore term from trash
   *
   * @return void
   */
  function restore(): void {
    if(!isset($_GET['restore_term']))
      return;

    $term_id = $_GET['restore_term'];

    update_term_meta($term_id, 'term_trash', false);

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_link = str_replace('&restore_term=' . $term_id, '', $actual_link);

    wp_redirect($actual_link);
  }

}

new Taxonomies();
