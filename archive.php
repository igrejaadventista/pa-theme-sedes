<?php 
	get_header(); 
	global $wp_query, $queryFeatured;
?>
	<?php require(get_template_directory() . '/components/parent/header.php'); ?>

	<div class="pa-content py-5">
		<div class="container">
			<div class="row justify-content-md-center">
        <section class="col-12 col-xl-8">
          <?php 
            if(get_query_var('paged') < 1 && $queryFeatured->found_posts > 0):
              get_template_part('template-parts/global/feature', 'feature', [
                'post' => $queryFeatured->posts[0],
                'tag'  => $format = get_post_format($queryFeatured->posts[0]) ? : __('News', 'iasd'),
              ]); 
            endif;
          ?>

          <?php if($wp_query->found_posts >= 1): ?>
            <div class="pa-blog-itens my-5">
              <?php 
                foreach($posts as $post):
                  get_template_part('template-parts/global/card-post', 'card-post', [
                    'post'     => $post,
                    'category' => $categories = get_the_category($post->ID) ? $categories[0]->name : '',
                    'format'   => get_post_format($post) ? : __('News', 'iasd'),
                  ]); 
                endforeach; 
              ?>
            </div>
          <?php endif; ?>
					
					<div class="pa-pg-numbers row">
						<?php PaThemeHelpers::pageNumbers(); ?>
					</div>
				</section>
				
				<?php if(is_active_sidebar('archive')): ?>
          <aside class="col-md-4 d-none d-xl-block">
            <?php dynamic_sidebar('archive'); ?>
          </aside>
        <?php endif; ?>
			</div>
		</div>
	</div>

<?php get_footer();?>
