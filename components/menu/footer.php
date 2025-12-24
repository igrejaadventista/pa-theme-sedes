<?php

$sede = getSiteInfo();

$campo = $sede['ct_headquarter'];
$adress = $sede['ct_adress'];
$telephone = $sede['ct_telephone'];
$facebook = $sede['sn_facebook'];
$twitter = $sede['sn_twitter'];
$youtube = $sede['sn_youtube'];
$instagram = $sede['sn_instagram'];
$menus = PaThemeHelpers::getGlobalMenu('global-footer');
?>

<footer class="pa-footer pt-5">
  <div class="container pb-5">
    <div class="row">
      <div class="col d-flex flex-column justify-content-xl-between">
        <div class="d-flex flex-column align-items-center align-items-xl-start px-5 px-xl-0">
          <?php if(!empty($campo) && !is_wp_error($campo)): ?>
            <div class="pa-brand">
              <a href="/" title="<?= !empty($campo->name) ? $campo->name : '' ?>" class="d-flex flex-column justify-content-center"><img src="<?= get_template_directory_uri() . "/assets/sedes/" . LANG . "/logo-iasd-vertical.svg" ?>" alt="<?= $campo->name ?>" title="<?= $campo->name ?>" class="img-fluid"></a>
              <span class="d-block mt-4 text-center pa-brand-name"><?= !empty($campo->name) ? str_replace('-', '&#8209;', $campo->name) : '' ?></span>          </div>
            <hr class="mt-4 mb-4">
          <?php endif; ?>
          
          <div class="pa-contact">
            <?php if ($adress) {
            ?><span class="pa-adress d-block text-center text-md-start lh-lg"><?= $adress ?></span><?php
                                                                                                  } ?>
            <?php if ($telephone) {
            ?><span class="pa-telephone d-block text-center text-md-start mt-4"><?= $telephone ?></span><?php
                                                                                                      } ?>
          </div>
        </div>
        <?php if ($facebook || $twitter || $youtube || $instagram) { ?>
          <div class="pa-social-network align-items-end d-none d-xl-block">
            <span><?= _e('Our social networks', 'iasd'); ?></span>
            <div class="icons mt-3">
              <?php if ($facebook) {
              ?><a href="<?= $facebook ?>" title="Facebook"><i class="fab fa-facebook-f me-4"></i></a><?php
                                                                                                    } ?>
              <?php if ($twitter) {
              ?><a href="<?= $twitter ?>" title="Twitter"><i class="fab fa-twitter me-4"></i></a><?php
                                                                                                } ?>
              <?php if ($youtube) {
              ?><a href="<?= $youtube ?>" title="Youtube"><i class="fab fa-youtube me-4"></i></a><?php
                                                                                                } ?>
              <?php if ($instagram) {
              ?><a href="<?= $instagram ?>" title="Instagram"><i class="fab fa-instagram-square"></i></a><?php
                                                                                                        } ?>
            </div>
          </div>

        <?php } ?>
      </div>
      <div class="col-9 d-none d-xl-block">
        <?php if (is_array($menus) && !empty($menus)) : ?>
          <?php foreach ($menus as $menu) : ?>
            <?php if (isset($menu->itens) && !empty($menu->itens)) : ?>
              <div class="pa-menu pb-4 mb-4">
                <?php if (!empty($menu->name)) : ?>
                  <h2><?= $menu->name ?></h2>
                <?php endif; ?>

                <ul class="list-unstyled pa-split-column-3">
                  <?php foreach ($menu->itens as $item) : ?>
                    <li class="item-menu">
                      <a href="<?= $item->url ?>" title="<?= $item->title ?>" target="<?= !empty($item->target) ? $item->target : '_self' ?>"><?= $item->title ?></a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="pa-copyright">
    <div class="container">
      <div class="row">
        <div class="py-2 d-flex flex-xl-row justify-content-xl-between flex-column align-items-center">
          <span class="py-2"><?= _e('Seventh-day Adventist Church', 'iasd'); ?></span>
          <span class="py-2">Copyright © 2013-<?= date("Y") ?></span>
        </div>
        <div class="col mb-5 mt-3 text-center pa-go-back-top d-xl-none">
          <a href="#topo" class="btn btn-sm"><i class="fas fa-arrow-up me-2"></i><?= _e('Go to top', 'iasd'); ?></a>
        </div>
      </div>
    </div>
  </div>
</footer>
