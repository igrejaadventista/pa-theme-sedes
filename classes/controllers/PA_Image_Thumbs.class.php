<?php 

class PA_Image_Thumbs {
	public function __construct(){
		add_action('after_setup_theme', [$this, 'createThumbs' ]);
	}

	function createThumbs(){
		add_image_size( 'lider-thumb', 250, 250, true );
	}
}
new PA_Image_Thumbs();

