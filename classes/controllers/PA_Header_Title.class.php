<?php 

class PA_Header_Title {
	public function __construct($part){
		if ($part == 'title'){
			self::headerTitle();
		} else if ($part = 'tag'){
			self::headerTag();
		}
	}

	static function headerTitle(){
		if ( is_home() || is_front_page() ){
			echo get_bloginfo('name');
		} elseif ( is_post_type_archive() ) {
			echo post_type_archive_title();
		} elseif ( is_singular( 'projetos' ) ){
			$post_type_obj = get_post_type_object( get_post_type() );
			$post_type_name = apply_filters('post_type_archive_title', $post_type_obj->labels->singular_name );
			echo $post_type_name .' | '. get_the_title();
		} elseif ( is_singular( 'lideres' ) ){
			$post_type_obj = get_post_type_object( get_post_type() );
			$post_type_name = apply_filters('post_type_archive_title', $post_type_obj->labels->singular_name );
			echo $post_type_name;
		} elseif (is_page()){
			the_title();
		}

	}
	
	static function headerTag(){
		if ( !is_home() || !is_front_page() ){
			echo get_bloginfo('name');
		}
	}
}