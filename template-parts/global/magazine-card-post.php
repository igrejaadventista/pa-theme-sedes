<style>
.custom-image-size {
    width: 200px;
    height: 250px; 
    object-fit: cover; /* manter proporções e cortar a imagem conforme necessário */
    object-position: center top; /* posicionamento da imagem para garantir que fique na vertical */
}

</style>
<?php if (isset($args['post']) && !empty($args['post'])) : ?>
  <div class="pa-blog-item mb-4 mb-md-4 border-0" style="font-family: var(--pa-font-secondary);">
    <a href="<?= get_the_permalink($args['post']->ID) ?>" title="<?= get_the_title($args['post']->ID) ?>">
      <div class="image-container">
        <?php if (has_post_thumbnail($args['post'])) : ?>
          <img src="<?= check_immg($args['post']->ID, 'medio') ?>" class="figure-img img-fluid rounded m-0 custom-image-size" alt="<?= get_the_title($args['post']->ID) ?>">
        <?php endif; ?>
        <h6 class="fw-bold mt-xl-2 pa-truncate-4"><?= get_the_title($args['post']->ID) ?></h6>
      </div>
    </a>
  </div>
<?php endif; ?>