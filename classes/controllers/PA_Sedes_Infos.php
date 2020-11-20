<?php

function get_info_sedes(){
	
	$blog_id = get_main_site_id();
	switch_to_blog($blog_id);
	$sedes_info = get_field('ct_headquarter', 'option') ?: (object)['name' => "Default", 'slug'=> 'default'];
	restore_current_blog();

	return $sedes_info;
}