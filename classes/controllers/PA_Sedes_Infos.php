<?php

function get_info_sedes() {
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	return get_field("ct_headquarter{$network}", 'option');
}

function get_info_adress(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
  return  get_field("ct_adress{$network}", 'option');
}

function get_info_telephone(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	return get_field("ct_telephone{$network}", 'option');
}


function get_info_facebook(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	return get_field("sn_facebook{$network}", 'option');
}

function get_info_twitter(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	return  get_field("sn_twitter{$network}", 'option');

}

function get_info_youtube(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	return get_field("sn_youtube{$network}", 'option');
}

function get_info_instagram(){
	$network = empty(get_field('overwrite_global_settings', 'option')) ? '_network' : '';
	return get_field("sn_instagram{$network}", 'option');
}
