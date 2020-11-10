<?php 

function check_immg($id, $size){

	$url = esc_url(get_the_post_thumbnail_url($id, $size));
	return $url ? $url : "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNjAwIiBoZWlnaHQ9IjkwMCIgdmlld0JveD0iMCAwIDE2MDAgOTAwIj4KICA8cmVjdCBpZD0iUmV0w6JuZ3Vsb18xIiBkYXRhLW5hbWU9IlJldMOibmd1bG8gMSIgd2lkdGg9IjE2MDAiIGhlaWdodD0iOTAwIiBmaWxsPSIjOTA5MDkwIi8+Cjwvc3ZnPg==";
}


function misha_pagination( $query ) {  
 
	$args = array(
		'total' => $query->max_num_pages, // total amount of pages
		'current' => ( ( $query->query_vars['paged'] ) ? $query->query_vars['paged'] : 1 ), // current page number
		'show_all' => false, // set to true if you want to show all pages at once
		'mid_size' => 2, // how much page numbers to show on the each side of the current page
		'end_size' => 2, // how much page numbers to show at the beginning and at the end of the list
		'prev_next' => true, // if you set this to false, the previous and the next post links will be removed
		'prev_text' => '«', // «
		'next_text' => '»' // »
	);

	// do not return anything if there are not enough posts
	if( $args['total'] <= 1 ){
		return false;
	} 
		
 
	return '<div class="navigation">
		<span class="pages">Page ' . $args['current'] . ' of ' . $args['total'] . '</span>'
		. paginate_links( $args ) .  
		'</div>';   
 
}

