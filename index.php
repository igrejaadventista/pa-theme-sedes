<?php get_header(); ?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-widgets pt-5">
		<div class="container">
			<div class="row row-cols-auto">
				<?php 
					require(get_template_directory() . '/components/widgets/pa-destaque-depto.php');
					require(get_template_directory() . '/components/widgets/pa-botoes.php');

					$tamanho = '2/3';
					require(get_template_directory() . '/components/widgets/pa-videos.php');
					require(get_template_directory() . '/components/widgets/pa-destaque.php');
					require(get_template_directory() . '/components/widgets/pa-downloads.php');

				?>
			</div>
		</div>
	
	</div>
<?php get_footer();?>
