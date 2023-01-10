<?php if (isset($args['post']) && !empty($args['post'])) : ?>
  <div class="pa-blog-itens mb-5 pa-widget">
    <h2 class="mb-4"><?= _e('Featured', 'iasd') ?></h2>

    <div class="pa-blog-feature">
      <a href="<?= get_the_permalink($args['post']->ID) ?>" title="<?php get_the_title($args['post']->ID) ?>">
        <div class="ratio ratio-16x9">
          <figure class="figure m-xl-0 w-100">
            <img src="<?= check_immg($args['post']->ID, 'full') ?>" class="figure-img img-fluid m-0 rounded w-100 h-100 object-cover" alt="<?= get_the_title($args['post']->ID) ?>">

            <figcaption class="figure-caption position-absolute w-100 p-3 rounded-bottom">
              <?php if (isset($args['tag']) && !empty($args['tag'])) : ?>
                <span class="pa-tag rounded-1 text-uppercase mb-2 d-none d-md-table-cell px-2"><?= $args['tag']; ?></span>
              <?php endif; ?>

              <h3 class="h5 pt-2 pa-truncate-2"><?= get_the_title($args['post']->ID) ?></h3>
            </figcaption>
          </figure>
        </div>
      </a>
    </div>
  </div>
<?php endif; ?>
