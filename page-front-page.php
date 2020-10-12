<?php
	
	/* Template name: Page - Front Page */

	get_header(); 
	require(get_template_directory() . '/components/front-page/slider.php'); 
?>
			<section class="pa-content pb-5">

				<?php require(get_template_directory() . '/components/widgets/pa-find-church.php'); ?>
				<div class="pa-widgets">
					<div class="container">
						<div class="row row-cols-auto">
							<?php 
								// require(get_template_directory() . "/components/widgets/pa-list-news.php");
								// require(get_template_directory() . "/components/widgets/pa-carousel-feature.php");
							?>
						</div>
					</div>
				</div>

				<?php //require(get_template_directory() . "/components/widgets/pa-feliz7play.php"); ?>
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