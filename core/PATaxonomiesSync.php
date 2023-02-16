<?php

// // ADDING META RETURN IN GET_TERM
// add_filter('get_term', function ($term) {
// 	$term->meta = get_term_meta($term->term_id); // all metadata
// 	return $term;
// });


// 	// 	/**
// 	// 	 * TODO!!!!
// 	// 	 * 
// 	// 	 * REVIEW PAGINATE (API LIMITED UNTIL 100 PER PAGE)
// 	// 	 * 
// 	// 	 * FIRST MOMENT, IT`S NECESSARY CHECK IF EXIST SOMETHING IN NEXT PAGE (DARK PERFORMANCE).
// 	// 	 * IDEAL IDEA: API RETURN EVERYTHING WITHOUT PAGINATE.
// 	// 	 */

// // add_action('PA-Service_Taxonomy_Schedule', 'Service_Taxonomy');

namespace Core;

class PATaxonomiesSync {

  protected $taxonomies = [
    // 'xtt-pa-colecoes', 
    // 'xtt-pa-sedes', 
    // 'xtt-pa-editorias', 
    // 'xtt-pa-departamentos', 
    // 'xtt-pa-projetos', 
    'xtt-pa-owner',
  ];

  protected $baseURL = 'https://' . API_PA . '/tax/' . LANG . '/';

  public function __construct() {
    $this->sync();
  }

  protected function sync() {
    foreach($this->taxonomies as $taxonomy):
      /**
       * TODO!!!!
       * 
       * REVIEW PAGINATE (API LIMITED UNTIL 100 PER PAGE)
       * 
       * FIRST MOMENT, IT`S NECESSARY CHECK IF EXIST SOMETHING IN NEXT PAGE (DARK PERFORMANCE).
       * IDEAL IDEA: API RETURN EVERYTHING WITHOUT PAGINATE.
       */
      $response = $this->request("$taxonomy?per_page=300&filter[parent]=0&order=desc");

      if(is_array($response))
        $this->parse($taxonomy, $response);
    endforeach;
  }

  protected function request($route) {
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

  protected function parse($taxonomy, $terms) {
    $parents = array_filter($terms, function($term) {
      return $term->parent == 0;
    });

    $childs = array_filter($terms, function($term) {
      return $term->parent != 0;
    });

    $parent_ids = [];
    $child_ids  = [];

    foreach($parents as $term)
      $parent_ids[$term->id] = $this->updateTerm($taxonomy, $term);

    foreach($childs as $term)
      $child_ids[$term->id] = $this->updateTerm($taxonomy, $term, $parent_ids);

    $term_ids = array_merge($parent_ids, $child_ids);

    $this->deleteTerms($taxonomy, $term_ids);
  }

  protected function updateTerm($taxonomy, $term, $parents = []) {
    $updated_term = [];

    $args = array(
      'taxonomy'   => $taxonomy,
      'hide_empty' => false,
      'fields'     => 'ids',
      'meta_query' => array(
        array(
          'key'     => 'pa_tax_id_remote',
          'value'   => $term->id,
          'compare' => '=',
        )
      )
    );

    $local_term = get_terms($args);

    if(empty($local_term) || is_wp_error($local_term))
      $local_term = get_term_by('slug', $term->slug, $taxonomy);
    else
      $local_term = $local_term[0];

    if(empty($local_term) || is_wp_error($local_term)):
      $updated_term = wp_insert_term(
        $term->name, 
        $taxonomy,
        array(
          'name'   => $term->name,
          'slug'   => $term->slug,
          'parent' => $parents[$term->parent] ?? $term->parent,
        )
      );

      if(!is_wp_error($updated_term)):
        add_term_meta($updated_term['term_id'], 'pa_tax_id_remote', $term->id, true);
      endif;
    else:
      $updated_term = wp_update_term(
        $local_term, 
        $taxonomy, 
        array(
          'name'   => $term->name,
          'slug'   => $term->slug,
          'parent' => $parents[$term->parent] ?? $term->parent,
        )
      );
    endif;

    return $updated_term['term_id'];
	}

  protected function deleteTerms($taxonomy, $exclude = []) {
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
