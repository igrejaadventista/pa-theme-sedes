<?php $sede = get_info_sedes(); ?>

<div class="col-auto d-flex align-items-center pa-header-logo">
  <a href="<?= get_home_url(); ?>" class="py-3 w-auto h-100">
    <img src="<?= get_template_directory_uri() . "/assets/sedes/" . LANG . "/" . $sede->slug . ".svg" ?>" alt="<?= !empty($sede->name) ? $sede->name : '' ?>" title="<?= !empty($sede->name) ? $sede->name : '' ?>" class="h-100 w-auto pa-logo-iasd">
  </a>
</div>
