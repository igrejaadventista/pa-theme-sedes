<?php $sede = getSiteInfo(); ?>
<?php $custom_logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' ); ?>
<?php $default_logo = isset($sede['ct_headquarter']->slug) ? get_template_directory_uri() . "/assets/sedes/" . LANG . "/" . $sede['ct_headquarter']->slug . ".svg" : '' ?>

<div class="col-auto d-flex align-items-center pa-header-logo">
  <a href="<?= get_home_url(); ?>" class="w-auto align-middle">
    <img src="<?= $custom_logo ? $custom_logo[0] : $default_logo ?>" 
         alt="<?= !empty($sede['ct_headquarter']->name) ? $sede['ct_headquarter']->name : '' ?>" 
         title="<?= !empty($sede['ct_headquarter']->name) ? $sede['ct_headquarter']->name : '' ?>" 
         class="h-100 w-auto pa-logo-iasd">
  </a>
</div>
