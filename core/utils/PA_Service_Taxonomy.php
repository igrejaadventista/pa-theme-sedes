<?php

require_once(dirname(__FILE__) . '/PA_RestAPI_Tax.php');
require_once(dirname(__FILE__) . '/PA_Functions.php');


const TAXS_PA = ['xtt-pa-colecoes', 'xtt-pa-sedes', 'xtt-pa-editorias', 'xtt-pa-departamentos', 'xtt-pa-projetos', 'xtt-pa-owner'];

// ADDING META RETURN IN GET_TERM
add_filter('get_term', function ($term) {
	$term->meta = get_term_meta($term->term_id); // all metadata
	return $term;
});

function Service_Taxonomy()
{
	/**
	 * 
	 * Adding terms
	 * 
	 */

	$restAPIService = new PARestAPITax();

	foreach (TAXS_PA as $tax) {
		/**
		 * TODO!!!!
		 * 
		 * REVIEW PAGINATE (API LIMITED UNTIL 100 PER PAGE)
		 * 
		 * FIRST MOMENT, IT`S NECESSARY CHECK IF EXIST SOMETHING IN NEXT PAGE (DARK PERFORMANCE).
		 * IDEAL IDEA: API RETURN EVERYTHING WITHOUT PAGINATE.
		 */
		$resultAPI = $restAPIService->CallAPI('GET', "$tax?per_page=300&filter[parent]=0&order=desc");
		PAFunctions::add_update_term_tax($tax, $resultAPI);
	}
}
add_action('Service_Taxonomy_Schedule', 'Service_Taxonomy');
