<?php get_header(); ?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 
	?>
	<div class="pa-content py-5">
		<div class="container">
			<div class="row row-cols-auto">
				<article class="col-12 col-md-8">
					<div class="pa-blog-feature">
						<h2 class="mb-4">Destaque</h2>
						<a href="" class="">
							<div class="ratio ratio-16x9">
								<figure class="figure m-xl-0 w-100">
									<img src="https://picsum.photos/960/540.webp?random=1" class="figure-img img-fluid m-0 rounded" alt="...">
									<figcaption class="figure-caption position-absolute w-100 p-3 rounded-bottom">
										<span class="pa-tag rounded-sm mb-2">Revista - PDF</span>
										<h3 class="h4 pt-2">Ação Jovem - Segundo trimestre 2020</h3>
									</figcaption>
								</figure>
							</div>
						</a>
					</div>
					<div class="pa-blog-itens mt-5">
						<h2 class="mb-4">Últimas Postagens</h2>

						<?php if (have_posts()) : while (have_posts()) : the_post();  ?>

							<div class="pa-blog-item mb-5 mb-xl-4 border-0">
								<a href="<?= the_permalink(); ?>">
									<div class="row">
										<div class="col-5">
										<div class="ratio ratio-16x9">
											<figure class="figure m-xl-0">
												<img src="<?= check_immg(get_the_ID(), 'full'); ?>" class="figure-img img-fluid rounded m-0 h-100 w-100" alt="...">
												<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right">Bíblia</figcaption>
											</figure>	
										</div>
										</div>
										<div class="col-7">
											<div class="card-body p-0">
												<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">Notícia</span>
												<h3 class="font-weight-bold h5 mt-xl-2"><?= the_title_attribute(); ?></h3>
												<p class="d-none d-xl-block">Programa oficial da Igreja Adventista está há 13 anos na América do Sul e oferece oportunidades de serviço voluntário em diversos países do mundo.</p>
											</div>
										</div>
									</div>
								</a>
							</div>

						<?php  endwhile; ?>

						<nav class="mt-5" aria-label="Page navigation example">
							<ul class="pagination justify-content-center">
								<li class="page-item">
									<a class="page-link" href="<?= esc_url(get_previous_posts_page_link()); ?>" aria-label="Previous">
										<span aria-hidden="true">&laquo;</span>
									</a>
								</li>
								<li class="page-item"><a class="page-link" href="#">1</a></li>
								<li class="page-item"><a class="page-link" href="#">2</a></li>
								<li class="page-item"><a class="page-link" href="#">3</a></li>
								<li class="page-item">
									<a class="page-link" href="<?= esc_url(get_next_posts_page_link()); ?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
							</ul>
						</nav>

						<nav class="mt-5" aria-label="Page navigation example">
							<ul class="pagination justify-content-center">
											
						 

							<?php 

								global $wp_query;
								
								$big = 999999999; // need an unlikely integer
								
								echo paginate_links( array(
									'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									'format' => '?paged=%#%',
									'current' => max( 1, get_query_var('paged') ),
									'total' => $wp_query->max_num_pages,
									'before_page_number' => '<li class="page-item">',
									'after_page_numbe' => '</li>',
									'prev_text' => '<span aria-hidden="true">&laquo;</span>',
									'next_text' => '<span aria-hidden="true">&raquo;</span>',
								
								) );

							?>

						</ul>
					</nav>

				<?php

										
									
					
					endif; ?>
					
					
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
