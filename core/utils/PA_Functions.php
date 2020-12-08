<?php

class PAFunctions
{
    public static function add_term_tax($tax, $resultService)
    {

        $tempParents = [];
        $tampMapTaxOption = get_option('tax_xtt_pa_owner_map');

        foreach ($resultService as $result) {

            if ($result->parent == 0) {
                $tempParents[$result->id] = [
                    'name' => $result->name
                ];
                /**
                 * Adding father id
                 */
                print_r($result->name);
                $taxC = wp_insert_term(
                    $result->name, // the term 
                    $tax, // the taxonomy
                    array(
                        'term_id' => $result->id,
                        'description' => $result->description,
                        'slug' => $result->slug
                    )
                );

                if (!is_wp_error($taxC)) {
                    /**
                     * Saves remote id for future updates
                     */
                    $tampMapTaxOption[$taxC['term_id']] = $result->id;
                }
            } else {

                /**
                 * Adding child tax
                 */

                if (isset($tempParents[$result->parent])) {
                    echo '<br>';
                    $parent_term = term_exists($tempParents[$result->parent]['name'], $tax); // array is returned if taxonomy is given
                    $parent_term_id = $parent_term['term_id']; // get numeric term id

                    if (isset($parent_term_id)) {
                        $taxC = wp_insert_term(
                            $result->name, // the term 
                            $tax, // the taxonomy
                            array(
                                'term_id' => $result->id,
                                'description' => $result->description,
                                'slug' => $result->slug,
                                'parent' => $parent_term_id  // get numeric term id
                            )
                        );

                        if (!is_wp_error($taxC)) {
                            /**
                             * Saves remote id for future updates
                             */
                            $tampMapTaxOption[$taxC['term_id']] = $result->id;
                        }
                    }
                }
            }
        }

        update_option('tax_' . $tax . '_map', $tampMapTaxOption);
    }
}
