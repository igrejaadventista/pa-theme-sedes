<?php

namespace IASD\Core;

use IASD\Core\Settings\Modules;

// echo __('App', 'iasd');
// die;

class Taxonomies
{

  /**
   * List of taxonomies
   *
   * @var array
   */
  public static $taxonomies = [];



  public function __construct()
  {
    add_action('init',            [$this, 'register'], 8);
    add_filter('rest_post_query', [$this, 'filterQuery'], 10, 2);

    // Desativar o delete default de terms do WP
    add_filter('pre_delete_term', [$this, 'delete']);

    // Inserindo Filtros de Lixeira e Ativos
    add_filter('get_terms', [$this, 'get']);

    // Action Restaurar
    add_filter('tag_row_actions', [$this, 'filterActions'], 10, 2);
    add_action('admin_init',      [$this, 'restore']);

    add_action('admin_head', [$this, 'styles']);

    add_action('after_setup_theme', [$this, 'setTaxonomiesInfo'], 11);
  }


  /**
   * Define as configurações das taxonomias personalizadas.
   *
   * @return void
   */
  function setTaxonomiesInfo()
  {
    self::$taxonomies = [
      'xtt-pa-colecoes'      => [
        'name'              => __('Collections', 'iasd'),
        'singular_name'     => __('Collection', 'iasd'),
        'description'       => __('Collections taxonomy', 'iasd'),
        'show_admin_column' => false
      ],
      'xtt-pa-editorias'     => [
        'name'              => __('Editorials', 'iasd'),
        'singular_name'     => __('Editorial', 'iasd'),
        'description'       => __('Editorials taxonomy', 'iasd'),
        'show_admin_column' => true
      ],
      'xtt-pa-departamentos' => [
        'name'              => __('Ministries', 'iasd'),
        'singular_name'     => __('Ministry', 'iasd'),
        'description'       => __('Ministries taxonomy', 'iasd'),
        'show_admin_column' => false
      ],
      'xtt-pa-projetos'      => [
        'name'              => __('Projects', 'iasd'),
        'singular_name'     => __('Project', 'iasd'),
        'description'       => __('Projects taxonomy', 'iasd'),
        'show_admin_column' => false
      ],
      'xtt-pa-regiao'        => [
        'name'              => __('Regions', 'iasd'),
        'singular_name'     => __('Region', 'iasd'),
        'description'       => __('Regions taxonomy', 'iasd'),
        'show_admin_column' => false
      ],
      'xtt-pa-sedes'         => [
        'name'              => __('Regional Headquarters', 'iasd'),
        'singular_name'     => __('Regional Headquarter', 'iasd'),
        'description'       => __('Regional Headquarters taxonomy', 'iasd'),
        'show_admin_column' => true
      ],
      'xtt-pa-owner'         => [
        'name'              => __('Owner Headquarters', 'iasd'),
        'singular_name'     => __('Owner Headquarter', 'iasd'),
        'description'       => __('Owner Headquarters taxonomy', 'iasd'),
        'show_admin_column' => true
      ],
      'xtt-pa-materiais'     => [
        'name'              => __('File types', 'iasd'),
        'singular_name'     => __('File type', 'iasd'),
        'description'       => __('File types taxonomy', 'iasd'),
        'show_admin_column' => false
      ],
    ];
  }

  /**
   * Add custom styles
   *
   * @return void
   */
  function styles(): void
  {
    if (!Modules::isActiveModule('taxonomies'))
      return;

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
  function register(): void
  {


    if (!Modules::isActiveModule('taxonomies'))
      return;

    foreach (self::$taxonomies as $key => $value) :
      if (!Modules::isActiveModule('taxonomy_' . $key))
        continue;

      $labels = array(
        'name'              => $value['name'],
        'singular_name'     => $value['singular_name'],
        'search_items'      => __('Search', 'iasd'),
        'all_items'         => __('All itens', 'iasd'),
        'parent_item'       => $value['singular_name'] . ', father',
        'parent_item_colon' => $value['singular_name'] . ', father',
        'edit_item'         => __('Edit', 'iasd'),
        'update_item'       => __('Update', 'iasd'),
        'add_new_item'      => __('Add new', 'iasd'),
        'new_item_name'     => __('New', 'iasd'),
        'menu_name'         => $value['singular_name'],
      );

      $args   = array(
        'description'         => $value['description'],
        'hierarchical'        => true, // make it hierarchical (like categories)
        'labels'              => $labels,
        'show_ui'             => true,
        'show_in_menu'        => current_user_can('administrator'),
        'show_admin_column'   => $value['show_admin_column'],
        'query_var'           => true,
        'rewrite'             => array('slug' => sanitize_title($value['singular_name'])),
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
  function filterQuery(array $args, \WP_REST_Request $request): array
  {
    if (!Modules::isActiveModule('taxonomies'))
      return $args;

    $params = $request->get_params();

    foreach (self::$taxonomies as $key => $value) :
      if (isset($params["{$key}-tax"])) :
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
  function delete(int $term_id): void
  {
    if (!Modules::isActiveModule('taxonomies'))
      return;

    $term_trash = get_term_meta($term_id, 'term_trash', true);
    $user       = wp_get_current_user();
    $roles      = (array) $user->roles;

    if (!$term_trash || ($term_trash && $roles[0] != 'administrator'))
      wp_die(add_term_meta($term_id, 'term_trash', true));
  }

  /**
   * Get terms
   *
   * @param  array $terms Array of found terms
   * 
   * @return array Modified terms
   */
  function get(array $terms): array
  {
    if (!Modules::isActiveModule('taxonomies'))
      return $terms;

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
  function filterActions(array $actions, \WP_Term $tag): array
  {
    if (!Modules::isActiveModule('taxonomies'))
      return $actions;

    $term_id = $tag->term_id;

    if (isset($_GET['terms_trashed'])) {
      $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      $actual_link = str_replace('&restore_term=' . $term_id, '', $actual_link);

      $actions['restore'] = '<a href="' . $actual_link . '&restore_term=' . $term_id . '">Restaurar</a>';
    } else
      $actions['delete'] = str_replace('Excluir', 'Lixeira', $actions['delete']);

    return $actions;
  }

  /**
   * Restore term from trash
   *
   * @return void
   */
  function restore(): void
  {
    if (!Modules::isActiveModule('taxonomies'))
      return;

    if (!isset($_GET['restore_term']))
      return;

    $term_id = $_GET['restore_term'];

    update_term_meta($term_id, 'term_trash', false);

    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $actual_link = str_replace('&restore_term=' . $term_id, '', $actual_link);

    wp_redirect($actual_link);
  }
}

new Taxonomies();
