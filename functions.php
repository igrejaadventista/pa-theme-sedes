<?php 


function pa_theme_support() {
	add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'pa_theme_support' );