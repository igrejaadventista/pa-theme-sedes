<?php

namespace IASD\Core;

use IASD\Core\Settings\Modules;

class PATaxonomiesSync {
  
  /**
   * taxonomies All taxononomies to sync
   *
   * @var array
   */
  protected $taxonomies = [
    'xtt-pa-colecoes', 
    'xtt-pa-sedes', 
    'xtt-pa-editorias', 
    'xtt-pa-departamentos', 
    'xtt-pa-projetos', 
    'xtt-pa-owner',
  ];
  
  /**
   * baseURL URL to request API
   *
   * @var string
   */
  protected $baseURL = 'https://' . API_PA . '/tax/' . LANG . '/';

  public function __construct() {
    if(!Modules::isActiveModule('taxonomiessync'))
      return;

    if(!wp_next_scheduled('PA-Service_Taxonomy_Schedule'))
      wp_schedule_event(time(), 'daily', 'PA-Service_Taxonomy_Schedule'); // Register cron schedule event

    add_action('PA-Service_Taxonomy_Schedule', array($this, 'sync')); // Register cron
    add_action('wp_ajax_sync/taxonomies', array($this, 'sync')); // Register ajax handler
  }
  
  /**
   * sync Starts the sync process
   *
   * @return void
   */
  public function sync(): void {
    foreach($this->taxonomies as $taxonomy):
      $response = $this->request("$taxonomy?per_page=300&filter[parent]=0&order=desc"); // Request taxonomies API

      if(is_array($response))
        $this->parse($taxonomy, $response); // Parse response
    endforeach;
  }
  
  /**
   * request Make the API request
   *
   * @param  string $route Custom route to fetch
   * 
   * @return mixed The API response
   */
  protected function request(string $route): array {
    $curl = curl_init();
    $url  = $this->baseURL . $route;

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);

    $result = curl_exec($curl);
    
    curl_close($curl);

    return json_decode($result);
  }
  
  /**
   * parse Parse data from response
   *
   * @param  string $taxonomy The taxonomy name
   * @param  array  $terms    The terms list
   * 
   * @return void
   */
  protected function parse(string $taxonomy, array $terms): void {
    // Filter parent terms
    $parents = array_filter($terms, function($term) {
      return $term->parent == 0;
    });

    // Filter child terms
    $childs = array_filter($terms, function($term) {
      return $term->parent != 0;
    });

    $parent_ids = [];
    $child_ids  = [];

    // Update/Insert parent terms
    foreach($parents as $term)
      $parent_ids[$term->id] = $this->updateTerm($taxonomy, $term);

    // Update/Insert child terms
    foreach($childs as $term)
      $child_ids[$term->id] = $this->updateTerm($taxonomy, $term, $parent_ids);

    // Delete terms
    // $term_ids = array_merge($parent_ids, $child_ids);
    // $this->deleteTerms($taxonomy, $term_ids);
  }
  
  /**
   * updateTerm Update or insert term
   *
   * @param  string $taxonomy The term taxonomy
   * @param  object $term     The term data
   * @param  array $parents   List of parent terms
   * 
   * @return int The term ID
   */
  protected function updateTerm(string $taxonomy, object $term, array $parents = []): int {
    $updated_term = [];

    // Get term by sync meta key
    $args = array(
      'taxonomy'   => $taxonomy,
      'hide_empty' => false,
      'meta_query' => array(
        array(
          'key'     => 'pa_tax_id_remote',
          'value'   => $term->id,
          'compare' => '=',
        )
      )
    );

    $local_term = get_terms($args);

    // Try to find term by slug
    if(empty($local_term) || is_wp_error($local_term))
      $local_term = get_term_by('slug', $term->slug, $taxonomy);
    else
      $local_term = $local_term[0];

    // If term not found, create and add sync id
    if(empty($local_term) || is_wp_error($local_term)):
      $updated_term = wp_insert_term(
        $term->name, 
        $taxonomy,
        array(
          'name'   => $term->name,
          'slug'   => $term->slug,
          'parent' => $parents[$term->parent] ?? 0,
        )
      );
    // Else update the term
    else:
      $updated_term = wp_update_term(
        $local_term->term_id, 
        $taxonomy, 
        array(
          'name'   => $term->name,
          'slug'   => $term->slug,
          'parent' => $parents[$term->parent] ?? 0,
        )
      );
    endif;

    if(!is_wp_error($updated_term)):
      add_term_meta($updated_term['term_id'], 'pa_tax_id_remote', $term->id, true);

      return $updated_term['term_id']; // Return the updated term id
    endif;

    return 0;
	}
  
  /**
   * deleteTerms Delete terms not synchronized
   *
   * @param  string $taxonomy Taxonomy name
   * @param  array $exclude   List of existing terms to be ignored
   * 
   * @return void
   */
  protected function deleteTerms(string $taxonomy, array $exclude = []): void {
    $terms = get_terms(
      array(
        'taxonomy'   => $taxonomy,
        'hide_empty' => false,
        'exclude'    => $exclude,
      )
    );

    foreach($terms as $term)
      wp_delete_term($term->term_id, $taxonomy);
  }

}

add_action('init', function() {
  new PATaxonomiesSync;
});
