<?php

function get_info_sedes() {
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_sede = get_field("ct_headquarter{$network}", 'option');

	// if(!$sedes_sede){
	// 	$blog_id = get_main_site_id();
	// 	switch_to_blog($blog_id);
	// 		$sedes_sede = get_field('ct_headquarter', 'option') ?: (object)['name' => "Default", 'slug'=> 'default'];
	// 	restore_current_blog();
	// }

	return $sedes_sede;
}

function get_info_adress(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_adress = get_field("ct_adress{$network}", 'option');

	// if(!$sedes_adress){
	// 	$blog_id = get_main_site_id();
	// 	switch_to_blog($blog_id);
	// 		$sedes_adress = get_field('ct_adress', 'option');
	// 	restore_current_blog();
	// }

	return $sedes_adress;
}

function get_info_telephone(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_telephone = get_field("ct_telephone{$network}", 'option');

	// if(!$sedes_telephone){
	// 	$blog_id = get_main_site_id();
	// 	switch_to_blog($blog_id);
	// 		$sedes_telephone = get_field('ct_telephone', 'option');
	// 	restore_current_blog();
	// }

	return $sedes_telephone;
}


function get_info_facebook(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_facebook = get_field("sn_facebook{$network}", 'option');

	// if(!$sedes_facebook){
	// 	$blog_id = get_main_site_id();
	// 	switch_to_blog($blog_id);
	// 		$sedes_facebook = get_field('sn_facebook', 'option');
	// 	restore_current_blog();
	// }

	return $sedes_facebook;
}

function get_info_twitter(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_twitter = get_field("sn_twitter{$network}", 'option');

	// if(!$sedes_twitter){
	// 	$blog_id = get_main_site_id();
	// 	switch_to_blog($blog_id);
	// 		$sedes_twitter = get_field('sn_twitter', 'option');
	// 	restore_current_blog();
	// }

	return $sedes_twitter;
}

function get_info_youtube(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_youtube = get_field("sn_youtube{$network}", 'option');

	// if(!$sedes_youtube){
	// 	$blog_id = get_main_site_id();
	// 	switch_to_blog($blog_id);
	// 		$sedes_youtube = get_field('sn_youtube', 'option');
	// 	restore_current_blog();
	// }

	return $sedes_youtube;
}

function get_info_instagram(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_instagram = get_field("sn_instagram{$network}", 'option');

	// if(!$sedes_instagram){
	// 	$blog_id = get_main_site_id();
	// 	switch_to_blog($blog_id);
	// 		$sedes_instagram = get_field('sn_instagram', 'option');
	// 	restore_current_blog();
	// }

	return $sedes_instagram;
}



function get_info_lang(){

	if(defined('WPLANG')){

		$lang = WPLANG;

	}elseif(get_locale()){
		$lang = get_locale();
	}

	$lang = substr($lang, 0,2);

	return $lang;
}
