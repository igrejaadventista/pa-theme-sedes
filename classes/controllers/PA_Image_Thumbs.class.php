<?php 

class PaImageThumbs {
	public function __construct(){
		add_action('after_setup_theme', [$this, 'createThumbs' ]);
	}

	function createThumbs(){
		add_image_size( 'lider-thumb', 250, 250, true );
		add_image_size( 'large', 960, 540, true );
		add_image_size( 'medium', 480, 270, true );
		add_image_size( 'thumbnail', 240, 135, true );

	}
}
$PaImageThumbs = new PaImageThumbs();

