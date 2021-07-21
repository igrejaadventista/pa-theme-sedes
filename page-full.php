<?php
	
	/* Template name: Page - Full width */

	get_header(); 
?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-widgets pt-5">
        <div class="container">
            <div class="pa-content">
                <?php the_content(); ?>
            </div>
        </div>
	</div>

<?php get_footer();?>
