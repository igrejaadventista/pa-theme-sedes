<?php

class PAFunctions
{

	public static function add_update_term_tax($tax, $resultService)
	{
		$ids_child_remote_fetched = [];
		try {

			/*

			EXPLAIN ACTIONS
			1 - adding and updating parents
			2 - adding and updating childs
			3 - deleting parents and childs
			*/
			foreach ($resultService as $result) {

				/** 
					Adding/updating parents
				*/
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
					
					// die(print_r([
					// 	'remote slug'=> $result->slug, 
					// 	'remote id' => $result->id, 
					// 	'tax'=> $tax, 
					// 	'local term'=> $verify_term
					// ]));

					if ($verify_term == null) {

						// verify if exist old taxs
						$verifyLocaly = get_term_by('slug', $result->slug, $tax);
						if ($verifyLocaly == null) {
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
								// print("ADDING TERM REMOTE PARENT: \n");
								// print(' - Term ID ' . $tax_parent['term_id'] . "\n");
								// print(' - Remote ID ' . $result->id . "\n");
								// print("--------------------\n");
								print("\e[31mADDING TERM REMOTE PARENT \e[39mTax:". $tax .", Term ID " . $tax_parent['term_id'] . ", Remote ID " . $result->id . "\n");
								add_term_meta($tax_parent['term_id'], 'pa_tax_id_remote', $result->id, true);
							} else {
								print_r("------ errorr add meta in child! \n");
								print_r($result->name);
							}
						} else {
							$tax_child_update = wp_update_term($verifyLocaly->term_id, $tax, array(
								'name' => $result->name,
								'slug' => $result->slug
							));
						}
					} else {
						// Updating
						// print("UPDATING PARENT: \n");
						// print('Tax: '. $tax .', Local ID: '. $verify_term[0]->term_id .', Remote ID: '. $result->id ."\n");
						// print("--------------------\n");

						print("\e[34mUPDATING PARENT \e[39mTax: ". $tax .", Local ID: ". $verify_term[0]->term_id .", Remote ID: ". $result->id ."\n");
						$tax_child_update = wp_update_term($verify_term[0]->term_id, $tax, array(
							'name' => $result->name,
							'slug' => $result->slug
						));
					}
				}

				/** 
					Adding/updating childs
				*/
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

					// die(print_r([
					// 	'remote slug'=> $result->slug, 
					// 	'remote id' => $result->id, 
					// 	'tax'=> $tax, 
					// 	'local term'=> $verify_term,
					// 	'args' => $args
					// ]));

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

							// verify if exist old taxs
							$verifyLocaly = get_term_by('slug', $result->slug, $tax);
							if ($verifyLocaly == null) {
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

									// print("ADDING TERM REMOTE CHILD: \n");
									// print("- Term ID " . $tax_child['term_id'] . "\n");
									// print(' - Remote ID ' . $result->id . "\n");
									// print("--------------------\n");
									print("\e[31mADDING TERM REMOTE CHILD \e[39mTax:". $tax .", Term ID " . $tax_child['term_id'] . ", Remote ID " . $result->id . "\n");
									add_term_meta($tax_child['term_id'], 'pa_tax_id_remote', $result->id, true);
								} else {
									print_r("------ errorr add meta in child! \n");
									print_r($result->name);
								}
							} else {
								$tax_child_update = wp_update_term($verifyLocaly->term_id, $tax, array(
									'name' => $result->name,
									'slug' => $result->slug
								));
							}
						} else {
							// Updating
							// print("\e[39mUPDATING CHILD: \n");
							// print("Tax: ". $tax .", Local ID: ". $verify_child_term[0]->term_id .", Remote ID: ". $result->id ."\n");
							// print("--------------------\n");
							print("\e[33mUPDATING CHILD \e[39mTax: ". $tax .", Local ID: ". $verify_child_term[0]->term_id .", Remote ID: ". $result->id ."\n");
							$tax_child_update = wp_update_term($verify_child_term[0]->term_id, $tax, array(
								'name' => $result->name,
								'slug' => $result->slug
							));
						}
					}
					// break;
					// die;
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
				break;
				die;

				$delete = true;

				foreach ($resultService as $result) {
					if ($vd->meta['pa_tax_id_remote'][0] == $result->id) {
						$delete = false;
					}
				}

				if ($delete) {
					print("DELETING TERM REMOTE CHILD: \n");
					print("\e[31mTax: ". $tax .", Local ID: ". $vd->term_id ."\n");
					print("\e[39m--------------------\n");
					// wp_delete_term($vd->term_id, $tax);
					die;
				}
			}
		} catch (\Throwable $th) {
			throw $th;
		}
	}
}
