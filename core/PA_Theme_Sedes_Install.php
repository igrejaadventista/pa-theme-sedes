<?php

require_once(dirname(__FILE__) . '/PA_Sync_Taxonomy.php');

/**
 * 
 * Bootloader Install
 * 
 */

class PACoreInstall
{
    public function __construct()
    {
        add_action('after_setup_theme', array($this, 'installRoutines'));
    }

    function installRoutines()
    {
        // Install routine to create or update taxonomies
        if (!wp_next_scheduled('PARoutineTaxonomies')) {
            wp_schedule_event(time(), '20min', 'PARoutineTaxonomies');
        }
    }
}

$PACoreInstall = new PACoreInstall();
