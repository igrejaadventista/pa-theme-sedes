<?php 
	get_header(); 
	global $wp_query;
?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 
	?>
	<div class="pa-content py-5">
		<div class="container">
			<div class="row row-cols-auto">
				<article class="col-12 col-md-8">

					<?php 
						$sticks = get_option( 'sticky_posts' );
						if(get_query_var('paged') < 1):
					?>

					<div class="pa-blog-itens mb-5">
					<h2 class="mb-4">Destaque</h2>
						<?php 
							$args = array(
								'posts_per_page'=> 1,
								'post_status'	=> 'publish',
								'post__in' => $sticks,
								'ignore_sticky_posts' => 1,
							);	
							pa_blog_feature($args);
						?>
					</div>
					<?php endif; ?>

					<div class="pa-blog-itens my-5">
						<h2 class="mb-4">Últimas postagens</h2>
						<?php 
							$args = array(
								'post_status'	=> 'publish',
								'post__not_in' => array($sticks[0]),
								'ignore_sticky_posts' => 1,
								'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
							);
							pa_blog_itens($args);
						?>
					</div>
					
					<div class="pa-pg-numbers row">
						<?php 
							$PaPageNumbers = new PaPageNumbers();
						?>
					</div>

				</article>
				<aside class="col-md-4 d-none d-xl-block">
				<?php 
					if ( is_active_sidebar( 'archive' ) ) {
						dynamic_sidebar( 'archive');
					}
				?>
				</aside>
			</div>
		</div>
	</div>

<?php get_footer();?>
