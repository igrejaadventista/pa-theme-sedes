<?php

require_once(dirname(__FILE__) . '/PA_RestAPI_Tax.php');
require_once(dirname(__FILE__) . '/PA_Functions.php');


function Service_Taxonomy()
{
    /**
     * 
     * Adding terms
     * 
     */
    $restAPIService = new PARestAPITax();
    $resultOwners = $restAPIService->CallAPI('GET', 'xtt-pa-owner?per_page=100&filter[parent]=0&order=desc');
    PAFunctions::add_term_tax('xtt-pa-owner', $resultOwners);
}
add_action('Service_Taxonomy_Schedule', 'Service_Taxonomy');
