<?php
	
	/* Template name: Page - Block */

	get_header(); 
?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-widgets pt-5">
		<div class="container">
			<?php the_content(); ?>
		</div>
	</div>

<?php get_footer();?>
