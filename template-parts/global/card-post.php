<?php if (isset($args['post']) && !empty($args['post'])) : ?>
  <div class="pa-blog-item mb-4 mb-md-4 border-0">
    <a href="<?= get_the_permalink($args['post']->ID) ?>" title="<?= get_the_title($args['post']->ID) ?>">
      <div class="row">
        <?php if (has_post_thumbnail($args['post'])) : ?>
          <div class="col-5 col-md-4">
            <div class="ratio ratio-16x9">
              <figure class="figure m-xl-0">
                <img src="<?= check_immg($args['post']->ID, 'medium') ?>" class="figure-img img-fluid rounded m-0 h-100 w-100 object-cover" alt="<?= get_the_title($args['post']->ID) ?>">

                <?php if (isset($args['category']) && !empty($args['category'])) : ?>
                  <figcaption class="pa-img-tag figure-caption text-uppercase rounded-right d-none d-md-table-cell"><?= $args['category'] ?></figcaption>
                <?php endif; ?>
              </figure>
            </div>
          </div>

        <?php endif; ?>

        <div class="col">
          <div class="card-body <?= has_post_thumbnail($args['post']) ? 'p-0' : 'ps-4 pe-0 py-4 border-start border-5 pa-border' ?>">
            <?php if (isset($args['format']) && !empty($args['format'])) : ?>
              <span class="pa-tag text-uppercase d-none d-xl-table-cell rounded"><?= $args['format'] ?></span>
            <?php endif; ?>

            <h3 class="fw-bold h6 mt-xl-2 pa-truncate-4"><?= get_the_title($args['post']->ID) ?></h3>

            <p class="d-none d-xl-block"><?= wp_trim_words(get_the_excerpt($args['post']->ID), 30) ?></p>
          </div>
        </div>
      </div>
    </a>
  </div>
<?php endif; ?>
