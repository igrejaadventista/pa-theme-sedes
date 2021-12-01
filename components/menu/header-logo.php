<?php $sede = getSiteInfo(); ?>

<div class="col-auto d-flex align-items-center pa-header-logo">
  <a href="<?= get_home_url(); ?>" class="w-auto h-100">
    <img src="<?= get_template_directory_uri() . "/assets/sedes/" . LANG . "/" . $sede['ct_headquarter']->slug . ".svg" ?>" alt="<?= !empty($sede['ct_headquarter']->name) ? $sede['ct_headquarter']->name : '' ?>" title="<?= !empty($sede['ct_headquarter']->name) ? $sede['ct_headquarter']->name : '' ?>" class="h-100 w-auto pa-logo-iasd">
  </a>
</div>
