<?php get_header(); ?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-widgets pt-5">
		<div class="container">
			<div class="row row-cols-auto">
				<?php 
					require(get_template_directory() . '/components/widgets/pa-carousel-ministry.php');
					require(get_template_directory() . '/components/widgets/pa-list-buttons.php');

					$tamanho = '2/3';
					require(get_template_directory() . '/components/widgets/pa-list-videos.php');
					require(get_template_directory() . '/components/widgets/pa-carousel-feature.php');
					require(get_template_directory() . '/components/widgets/pa-list-downloads.php');

				?>
			</div>
		</div>
	</div>

<?php get_footer();?>
