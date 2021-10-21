<?php

class PAFunctions
{

	public static function add_update_term_tax($tax, $resultService)
	{
		try {

			/*

			EXPLAIN ACTIONS
			1 - adding and updating parents
			2 - adding and updating childs
			3 - deleting parents and childs
			*/

			// Adding/updating parents 
			foreach ($resultService as $result) {

				if ($result->parent == 0) {
					$args = array(
						'taxonomy'   => $tax,
						'hide_empty' => false,
						'meta_query' => array(
							array(
								'key'       => 'pa_tax_id_remote',
								'value'     => $result->id,
								'compare'   => '='
							)
						)
					);
					$verify_term = get_terms($args);

					if ($verify_term == null) {

						$tax_parent = wp_insert_term(
							$result->name, // the term 
							$tax, // the taxonomy
							array(
								'name' => $result->name,
								'slug' => $result->slug,
								'parent' => $result->parent,
							)
						);

						if (!is_wp_error($tax_parent)) {
							print("ADDING TERM REMOTE PARENT: \n");
							print(' - Term ID ' . $tax_parent['term_id'] . "\n");
							print(' - Remote ID ' . $result->id . "\n");
							print("--------------------\n");
							add_term_meta($tax_parent['term_id'], 'pa_tax_id_remote', $result->id, true);
						} else {
							print_r("------ errorr add meta in child! \n");
							print_r($result->name);
						}
					} else {
						// Updating
						print("UPDATING PARENT: \n");
						print(' - Term ID ' . $verify_term[0]->term_id . "\n");
						print("--------------------\n");

					}
				}
			}

			// Adding/updating childs
			foreach ($resultService as $result) {

				if ($result->parent != 0) {

					$args = array(
						'taxonomy'   => $tax,
						'hide_empty' => false,
						'meta_query' => array(
							array(
								'key'       => 'pa_tax_id_remote',
								'value'     => $result->parent,
								'compare'   => '='
							)
						)
					);
					$id_tax_remote = get_terms($args);

					// Creating childs if exist a parent
					if ($id_tax_remote != null) {

						$parent_term_id = $id_tax_remote[0]->term_id; // get numeric term id

						// Verify if exist term 
						$verify_child_term = get_terms(array(
							'taxonomy'   => $tax,
							'hide_empty' => false,
							'meta_query' => array(
								array(
									'key'       => 'pa_tax_id_remote',
									'value'     => $result->id,
									'compare'   => '='
								)
							)
						));

						// Creating
						if ($verify_child_term == null) {

							$tax_child = wp_insert_term(
								$result->name, // the term 
								$tax, // the taxonomy
								array(
									'name' => $result->name,
									'slug' => $result->slug,
									'parent' => $parent_term_id  // get numeric term id
								)
							);

							if (!is_wp_error($tax_child)) {
								/**
								 * Saves remote id for future updates
								 */

								print("ADDING TERM REMOTE CHILD: \n");
								print(' - Term ID ' . $tax_child['term_id'] . "\n");
								print(' - Remote ID ' . $result->id . "\n");
								print("--------------------\n");
								add_term_meta($tax_child['term_id'], 'pa_tax_id_remote', $result->id, true);
							} else {
								print_r("------ errorr add meta in child! \n");
								print_r($result->name);
							}
						} else {
							// Updating
							print("UPDATING CHILD: \n");
							print(' - Term ID ' . $verify_child_term[0]->term_id . "\n");
							print("--------------------\n");
						
						}
					}
				}
			}


			// PREPARING TO DELETE
			$verify_delete = get_terms(array(
				'taxonomy'   => $tax,
				'hide_empty' => false,
				'meta_query' => array(
					array(
						'key'       => 'pa_tax_id_remote',
					)
				)
			));

			foreach ($verify_delete as $vd) {
				$delete = true;

				foreach ($resultService as $result) {
					if ($vd->meta['pa_tax_id_remote'][0] == $result->id) {
						$delete = false;
					}
				}

				if ($delete) {
					print("DELETING TERM REMOTE CHILD: \n");
					print(' - Term ID ' . $vd->term_id . "\n");
					print("--------------------\n");
					wp_delete_term($vd->term_id, $tax);
				}
			}
		} catch (\Throwable $th) {
			throw $th;
		}
	}
}
