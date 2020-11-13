<?php
require_once(dirname(__FILE__) . '/utils/PA_Schedule_Custom.php');
require_once(dirname(__FILE__) . '/utils/PA_Service_Taxonomy.php');

function routineTaxonomies()
{
    $PAServiceTaxonomy = new PAServiceTaxonomy();
    $PAServiceTaxonomy->getTaxonomies();
}

add_action('PARoutineTaxonomies', 'routineTaxonomies');
