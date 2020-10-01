		<?php get_header(); ?>
		<?php 
			require(get_template_directory() . '/components/front-page/slider.php'); 
		?>
			<section class="pa-content pb-5">

				<?php require(get_template_directory() . '/components/widgets/pa-find-church.php'); ?>
				<div class="pa-widgets">
					<div class="container">
						<div class="row row-cols-auto">
							<?php 
								require(get_template_directory() . "/components/widgets/pa-list-news.php");
								require(get_template_directory() . "/components/widgets/pa-carousel-feature.php");
							?>
						</div>
					</div>
				</div>

				<?php require(get_template_directory() . "/components/widgets/pa-feliz7play.php"); ?>
				<div class="pa-widgets">
					<div class="container">
						<div class="row row-cols-auto">
							<?php 
								$tamanho = '1/3';
								require(get_template_directory() . "/components/widgets/pa-list-videos.php");
								require(get_template_directory() . "/components/widgets/pa-list-posts.php");
								require(get_template_directory() . "/components/widgets/pa-app.php");

								$tamanho = '2/3';
								require(get_template_directory() . "/components/widgets/pa-list-videos.php");
								require(get_template_directory() . "/components/widgets/pa-list-downloads.php");

								$icon = true;
								require(get_template_directory() . "/components/widgets/pa-list-buttons.php");
								require(get_template_directory() . "/components/widgets/pa-carousel-ministry.php");
								require(get_template_directory() . "/components/widgets/pa-carousel-videos.php");
								require(get_template_directory() . "/components/widgets/pa-carousel-magazines.php");

							?>
						</div>
					</div>
				</div>
			</section>
			<?php get_footer();?>