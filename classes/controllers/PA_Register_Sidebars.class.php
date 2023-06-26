<?php

use IASD\Core\Settings\Modules;

class PaRegisterSidebars {
	public function __construct(){
		add_action('widgets_init', [$this, 'registerSidebars']);
	}

	function registerSidebars(){
    if(!Modules::isActiveModule('sidebars'))
      return;

		// Page - Front Page
		register_sidebar( array(
			'name'	=> __('Front Page', 'iasd'),
			'id'	=> 'front-page',
			'before_widget' => '<div class="pa-widget %2$s col">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		) );

		// Index
		register_sidebar( array(
			'name'	=> __('Index', 'iasd'),
			'id'	=> 'index',
			'before_widget' => '<div class="pa-widget %2$s col">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		) );

		// Archive
		register_sidebar( array(
			'name'	=> __('Archive', 'iasd'),
			'id'	=> 'archive',
			'before_widget' => '<div class="pa-widget %2$s col">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		) );

		// Single
		register_sidebar( array(
			'name'	=> __('Single', 'iasd'),
			'id'	=> 'single',
			'before_widget' => '<div class="pa-widget %2$s col">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2>',
		) );
	}
}

$PaRegisterSidebars = new PaRegisterSidebars();
