<?php
	
	/* Template name: Page - Front Page */

	get_header(); 
	require(get_template_directory() . '/components/front-page/slider.php'); 
?>
			<section class="pa-content pb-5">
				<div class="pa-widgets">
					<div class="container">
						<div class="row row-cols-auto">
						<?php 
							if ( is_active_sidebar( 'front-page' ) ) {
						
								dynamic_sidebar( 'front-page' );
								
							}
						?>
						</div>
					</div>
				</div>
			</section>
			<?php get_footer();?>