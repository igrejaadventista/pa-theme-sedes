<?php

class PAFunctions
{
  public static function add_update_term_tax($tax, $resultService)
  {
    $tempParents = [];

    foreach ($resultService as $result) {

      $optionMap = get_option('tax_' . $tax . '_map');

      /**
       * 
       * TODO:
       * - Verify if exist term in option and table terms!
       * 
       */

      // If exist this id remote in option, verify update!
      if (isset($optionMap[$result->id])) {

        $term = get_term($optionMap[$result->id]);

        //Change local nome if remote name is different
        if ($term->name != $result->name) {
          wp_update_term($optionMap[$result->id], $tax, array(
            'name' => $result->name,
            'description' => $result->description,
            'slug' => $result->slug
          ));
        }
      } else {

        // Dosn't exist id! Create now....
        if ($result->parent == 0) {
          $tempParents[$result->id] = [
            'name' => $result->name
          ];
          /**
           * Adding father id
           */

          $taxC = wp_insert_term(
            $result->name, // the term 
            $tax, // the taxonomy
            array(
              'description' => $result->description,
              'slug' => $result->slug
            )
          );

          if (!is_wp_error($taxC)) {
            /**
             * Saves remote id for future updates
             */
            $tampMapTaxOption[$result->id] = $taxC['term_id'];
          }
        } else {

          /**
           * Adding child tax
           */

          if (isset($tempParents[$result->parent])) {
            $parent_term = term_exists($tempParents[$result->parent]['name'], $tax); // array is returned if taxonomy is given
            $parent_term_id = $parent_term['term_id']; // get numeric term id

            if (isset($parent_term_id)) {
              $taxC = wp_insert_term(
                $result->name, // the term 
                $tax, // the taxonomy
                array(
                  'description' => $result->description,
                  'slug' => $result->slug,
                  'parent' => $parent_term_id  // get numeric term id
                )
              );

              if (!is_wp_error($taxC)) {
                /**
                 * Saves remote id for future updates
                 */
                $tampMapTaxOption[$result->id] = $taxC['term_id'];
              }
            }
          }
        }
        update_option('tax_' . $tax . '_map', $tampMapTaxOption);
      }
    }
  }
}
