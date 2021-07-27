<?php

require_once(dirname(__FILE__) . '/PA_RestAPI_Tax.php');
require_once(dirname(__FILE__) . '/PA_Functions.php');


const TAXS_PA = ['xtt-pa-owner', 'xtt-pa-colecoes', 'xtt-pa-editorias', 'xtt-pa-departamentos', 'xtt-pa-projetos', 'xtt-pa-sedes'];

function Service_Taxonomy()
{
  /**
   * 
   * Adding terms
   * 
   */

  $restAPIService = new PARestAPITax();

  foreach (TAXS_PA as $tax) {
    $resultAPI = $restAPIService->CallAPI('GET', "$tax?per_page=100&filter[parent]=0&order=desc");
    PAFunctions::add_update_term_tax($tax, $resultAPI);
  }
  
}
add_action('Service_Taxonomy_Schedule', 'Service_Taxonomy');
