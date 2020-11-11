<?php 

function pa_blog_feature($args){

	$firstPosts = array();
	$query = new WP_Query($args);
	$count = $query->post_count;
	if ($query->have_posts()):  while($query->have_posts()): $query->the_post(); array_push($firstPosts, get_the_ID()); ?>
		
		<div class="pa-blog-feature">
			<h2 class="mb-4">Destaque</h2>
			<a href="<?= the_permalink(); ?>" class="">
				<div class="ratio ratio-16x9">
					<figure class="figure m-xl-0 w-100">
						<img src="<?= check_immg(get_the_ID(), 'full'); ?>" class="figure-img img-fluid m-0 rounded w-100 h-100" alt="...">
						<figcaption class="figure-caption position-absolute w-100 p-3 rounded-bottom">
							<span class="pa-tag rounded-sm mb-2">Revista - PDF</span>
							<h3 class="h4 pt-2"><?= the_title_attribute() . ' - ' . get_the_ID() ?></h3>
						</figcaption>
					</figure>
				</div>
			</a>
		</div>

		<?php endwhile; wp_reset_postdata(); endif;  

	
		return array('post_list' => $firstPosts, 'post_count' => $count);
	 }


function pa_blog_itens($args){

	$firstPosts = array();
	$query = new WP_Query($args);

	// echo "Cont -> " . $query->post_count;
	// echo "</br>";
	// echo "Posts per page -> " . $query->post_count;
	//$count = intval($args["posts_per_page"]) - $query->post_count;
	$count = $query->post_count;
	if ($query->have_posts()):  while($query->have_posts()): $query->the_post(); array_push($firstPosts, get_the_ID()); 
	
	$categories = get_the_category();
	$format = get_post_format() ? : 'Notícia';
	
	?>

		<div class="pa-blog-item mb-5 mb-xl-4 border-0">
			<a href="<?= the_permalink(); ?>">
				<div class="row">

					<?php if(has_post_thumbnail()) : ?>

						<div class="col-5">
							<div class="ratio ratio-16x9">
								<figure class="figure m-xl-0">
									<img src="<?= check_immg(get_the_ID(), 'full'); ?>" class="figure-img img-fluid rounded m-0 h-100 w-100" alt="...">
									<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right"><?= esc_html( $categories[0]->name ); ?></figcaption>
								</figure>	
							</div>
						</div>

					<?php endif; ?>

					<div class="col ">
						<div class="card-body p-0 <?= has_post_thumbnail() ?: 'pl-4 py-4 border-left border-5 pa-border'?>">
							<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded"><?= $format; ?></span>
							<h3 class="font-weight-bold h5 mt-xl-2"><?= the_title_attribute() . ' - ' . get_the_ID() ?></h3>
							<p class="d-none d-xl-block"><?= wp_trim_words(get_the_excerpt(), 30)  ?></p>
						</div>
					</div>
				</div>
			</a>
		</div>

		<?php endwhile; wp_reset_postdata(); endif;

		return array('post_list' => $firstPosts, 'post_count' => $count);

}
