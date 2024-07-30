<?php 
get_header(); 
global $wp_query;
?>
<?php require(get_template_directory() . '/components/parent/header.php'); ?>


<div class="pa-content py-6" style="font-family: var(--pa-font-secondary);">
    <div class="container">
        <div class="row justify-content-md-center">
            <section class="col-12 ml-10">
                <?php if ($wp_query->have_posts()): ?>
                    <?php 
                    // Agrupando postagens por ano
                    $posts_by_year = [];
                    while ($wp_query->have_posts()): $wp_query->the_post();
                        $year = get_the_date('Y');
                        if (!isset($posts_by_year[$year])) {
                            $posts_by_year[$year] = [];
                        }
                        $posts_by_year[$year][] = $post;
                    endwhile;
                    ?>

                    <div class="pa-blog-items my-5">
                        <?php foreach ($posts_by_year as $year => $posts): ?>
                            <div class="pa-year-posts">
                                <h3 class="pa-year-title">
                                    <i class="far fa-calendar me-2" aria-hidden="true"></i>
                                    <?= $year ?>
                                </h3>
                                <div class="row">
                                    <?php foreach ($posts as $post): ?>
                                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                            <?php get_template_part('template-parts/global/magazine-card-post', 'magazine-card-post', [
                                                'post'     => $post,
                                                'category' => $categories = get_the_category() ? $categories[0]->name : '',
                                            ]); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="pa-pg-numbers row">
                    <?php PaThemeHelpers::pageNumbers(); ?>
                </div>
            </section>
            
            <?php if (is_active_sidebar('archive')): ?>
                <aside class="col-md-4 d-none d-xl-block">
                    <?php dynamic_sidebar('archive'); ?>
                </aside>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
