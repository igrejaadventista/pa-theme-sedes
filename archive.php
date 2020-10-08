<?php get_header(); ?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 
	?>
	<div class="pa-content py-5">
		<div class="container">
			<div class="row row-cols-auto">
				<article class="col-12 col-md-8">

					<?php 

					$paged = get_query_var('paged');
					$stickys = get_option('sticky_posts');
					$category = get_queried_object();

					if($paged < 1){
						$args = array(
							'post_type'      => 'post',
							'cat'            =>  $category->term_id,
							'posts_per_page' => 1,
							'post__in'  => $stickys,
							'ignore_sticky_posts' => 1,
							);
						
						$firstPosts = pa_blog_feature($args);

					}

					?>

					<div class="pa-blog-itens mt-5">
						<h2 class="mb-4">Últimas Postagens</h2>

						<?php 
						
						 if(!empty(array_diff($stickys, $firstPosts))){

								$args = array(
									'post_type'     => 'post',
									'cat'           =>  $category->term_id,
									'post__in'  	=> array_diff($stickys, $firstPosts),
									'post__not_in' 	=>  $firstPosts,
									'ignore_sticky_posts' => 1,
									'paged' => $paged 
									);

								$firstPosts = pa_blog_itens($args);

							}
				

							$args = array(
								'post_type'     => 'post',
								'cat'           =>  $category->term_id,
								'post__not_in' 	=>  (!empty($stickys) ? $stickys : $firstPosts),
								'paged' => $paged 
								);

							pa_blog_itens($args);
							
						?>

			
						<nav class="mt-5" aria-label="Page navigation example">
							<ul class="pagination justify-content-center">
								<li class="page-item">
									<a class="page-link" href="<?= esc_url(get_previous_posts_page_link()); ?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
								</li>
								
								<li class="page-item">
									<a class="page-link" href="<?= esc_url(get_next_posts_page_link()); ?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
							</ul>
						</nav>

				</div>

				</article>
				<aside class="col-md-4 d-none d-xl-block">
				<?php 
					$icon = true;
					require(get_template_directory() . '/components/widgets/pa-list-buttons.php');
					require(get_template_directory() . '/components/widgets/pa-list-videos.php');
					require(get_template_directory() . '/components/widgets/pa-list-downloads.php');	
				?>
				</aside>
			</div>
		</div>
	</div>

<?php get_footer();?>
