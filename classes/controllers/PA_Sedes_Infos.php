<?php

function get_info_sedes() {
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_sede = get_field("ct_headquarter{$network}", 'option');

	return $sedes_sede;
}

function get_info_adress(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_adress = get_field("ct_adress{$network}", 'option');

	return $sedes_adress;
}

function get_info_telephone(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_telephone = get_field("ct_telephone{$network}", 'option');

	return $sedes_telephone;
}


function get_info_facebook(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_facebook = get_field("sn_facebook{$network}", 'option');

	return $sedes_facebook;
}

function get_info_twitter(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_twitter = get_field("sn_twitter{$network}", 'option');

	return $sedes_twitter;
}

function get_info_youtube(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_youtube = get_field("sn_youtube{$network}", 'option');

	return $sedes_youtube;
}

function get_info_instagram(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	$sedes_instagram = get_field("sn_instagram{$network}", 'option');

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
