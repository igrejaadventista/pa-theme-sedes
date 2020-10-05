<?php
	
	/* Template name: Page - Widgets */

	get_header(); 
?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-widgets pt-5">
		<div class="container">
			<div class="row row-cols-auto">
				<?php 
					foreach (glob(get_template_directory() . "/components/widgets/*.php") as $filename){
						require($filename);
					}
				?>
			</div>
		</div>
	</div>

<?php get_footer();?>
