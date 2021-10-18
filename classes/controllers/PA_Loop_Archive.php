<?php 

function pa_blog_feature($args){

	$query = new WP_Query($args);
	if ($query->have_posts()):  while($query->have_posts()): $query->the_post(); 
	$format = get_post_format() ? : __('News', 'iasd');
	?>
		
		<div class="pa-blog-feature">
			<a href="<?= the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<div class="ratio ratio-16x9">
					<figure class="figure m-xl-0 w-100">
						<img src="<?= check_immg(get_the_ID(), 'full'); ?>" class="figure-img img-fluid m-0 rounded w-100 h-100" alt="...">
						<figcaption class="figure-caption position-absolute w-100 p-3 rounded-bottom">
							<span class="pa-tag rounded-1 text-uppercase mb-2 d-none d-md-table-cell px-2"><?= $format; ?></span>
							<h3 class="h5 pt-2 pa-truncate-2"><?= get_the_title(); ?></h3>
						</figcaption>
					</figure>
				</div>
			</a>
		</div>

		<?php endwhile; wp_reset_postdata(); endif;  
	 }


function pa_blog_itens($args){

	$query = new WP_Query($args);

	if ($query->have_posts()):  while($query->have_posts()): $query->the_post();
	
	$categories = get_the_category();
	$format = get_post_format() ? : __('News', 'iasd');
	
	?>

		<div class="pa-blog-item mb-4 mb-md-4 border-0">
			<a href="<?= the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<div class="row">

					<?php if(has_post_thumbnail()) : ?>

						<div class="col-5 col-md-4">
							<div class="ratio ratio-16x9">
								<figure class="figure m-xl-0">
									<img src="<?= check_immg(get_the_ID(), 'full'); ?>" class="figure-img img-fluid rounded m-0 h-100 w-100" alt="...">
									<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right d-none d-md-table-cell"><?= esc_html( $categories[0]->name ); ?></figcaption>
								</figure>	
							</div>
						</div>

					<?php endif; ?>

					<div class="col">
						<div class="card-body p-0 <?= has_post_thumbnail() ?: 'pl-4 py-4 border-left border-5 pa-border'?>">
							<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded"><?= $format; ?></span>
							<h3 class="fw-bold h6 mt-xl-2 pa-truncate-4"><?= get_the_title(); ?></h3>
							<p class="d-none d-xl-block"><?= wp_trim_words(get_the_excerpt(), 30)  ?></p>
						</div>
					</div>
				</div>
			</a>
		</div>

		<?php endwhile; wp_reset_postdata(); endif;

}
