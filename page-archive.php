<?php
get_header();
global $wp_query, $queryFeatured;

$wpb_all_query = new WP_Query(array('post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => -1));
$idExclude = ""


?>
<?php require(get_template_directory() . '/components/parent/header.php'); ?>

<div class="pa-content py-5">
  <div class="container">
    <div class="row justify-content-md-center">
      <section class="col-12 col-xl-8">


        <?php
        if (get_query_var('paged') < 1 && $wpb_all_query->found_posts > 0) :
          get_template_part('template-parts/global/feature', 'feature', [
            'post' => $wpb_all_query->posts[0],
            'tag'  => $format = get_post_format($wpb_all_query->posts[0]) ?: __('News', 'iasd'),
          ]);

          $idExclude = $wpb_all_query->posts[0]->ID;
        endif;
        ?>


        <?php //if ($wpb_all_query->have_posts()) : 
        ?>
        <?php if ($wpb_all_query->found_posts >= 1) : ?>


          <div class="pa-blog-itens my-5">
            <?php

            while ($wpb_all_query->have_posts()) {
              $wpb_all_query->the_post();
              $post  = get_post();

              if ($post->ID == $idExclude) {
                continue;
              }





              get_template_part('template-parts/global/card-post', 'card-post', [
                'post'     => $post,
                'category' => '',
                'format'   => get_post_format($post) ?: __('News', 'iasd'),
              ]);
            }
            ?>
          </div>
        <?php endif; ?>

        <div class="pa-pg-numbers row">
          <?php PaThemeHelpers::pageNumbers(); ?>
        </div>
      </section>

      <?php if (is_active_sidebar('archive')) : ?>
        <aside class="col-md-4 d-none d-xl-block">
          <?php dynamic_sidebar('archive'); ?>
        </aside>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php get_footer(); ?>
