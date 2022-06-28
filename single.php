<?php 
get_header(); 


global $post; 
if(have_posts()){
	the_post();
}
$next_post = get_next_post();
$prev_post = get_previous_post();

?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-content-container py-5">
		<div class="container">
			<div class="row justify-content-md-center">
				<article class="col-12 col-md-8">
					<header class="mb-4">
						<h1 class="fw-bold mb-3"><?php single_post_title(); ?></h1>
						<h2 class="mb-3 pb-3"><?php the_excerpt(); ?></h3>
						<div class="pa-post-meta"><?= _e('By', 'iasd'); ?> <?= get_the_author(); ?> | <?php the_date(); ?></div>

						<hr class="my-45">
		
						<div class="d-flex justify-content-between">
              <?php 
                require(get_template_directory() . '/components/parts/share.php');
              ?>
							<div class="pa-accessibility">
								<ul class="list-inline">
									<li class="pa-text-dec list-inline-item"><a href="#" class="rounded p-2" onclick="window.TextSize.pa_diminui_texto(event)" >-A</a></li>
									<li class="pa-text-inc list-inline-item"><a href="#" class="rounded p-2" onclick="window.TextSize.pa_aumenta_texto(event)" >+A</a></li>
									<?php if(get_post_meta(get_the_ID(), 'amazon_polly_enable', true)){ ?><li class="pa-text-listen list-inline-item"><a href="#" class="rounded p-2" onclick="pa_play(event, this)" alt="<?= _e('Hear text', 'iasd'); ?>" title="<?= _e('Hear text', 'iasd'); ?>"><i class="fas fa-volume-up"></i> <?= _e('Hear text', 'iasd'); ?></a><audio id="pa-accessibility-player" src="<?= get_post_meta( get_the_ID(), 'amazon_polly_audio_link_location', true) ?>" controls></audio></li><?php } ?>
								</ul>
							</div>
						</div>
					</header>
					<div class="pa-content">
						<?php the_content(); ?>
					</div>
					<div class="pa-break d-block my-5 py-2"></div>
					<footer class="mb-5">
						<div class="pa-post-navigation row mt-4">
							<div class="col-12 col-xl-6 order-xl-2 text-center mb-3">
								<?php 
									require(get_template_directory() . '/components/parts/share.php');
								?>
							</div>
							<div class="pa-post-prev col-6 col-xl-3 order-xl-1 text-left">
								<a href=""><i class="fas fa-arrow-left"></i><?=  _e('Previous article', 'iasd'); ?></a>
							</div>
							<div class="pa-post-next col-6 col-xl-3 order-xl-3 text-right">
								<a href=""><?= _e('Next article', 'iasd'); ?><i class="fas fa-arrow-right"></i></a>
							</div>
						</div>
						<?php 
							if(comments_open()){ 
								comments_template();
							} 
						?>
					</footer>
				</article>
				<?php if ( is_active_sidebar( 'single' ) ) { ?>
				<aside class="col-md-4 d-none d-xl-block">
				<?php dynamic_sidebar( 'single');?>
				</aside>
				<?php } ?>
			</div>
		</div>
	</div>

<?php get_footer();?>
