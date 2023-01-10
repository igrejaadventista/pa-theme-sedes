<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>

  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/imgs/favicon.png">

  <?php require_once(get_template_directory() . '/components/parent/datalayer.php'); ?>

  <!-- Google Tag Manager -->
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-MHJLVQL');
  </script>
  <!-- End Google Tag Manager -->
</head>

<body <?php body_class(get_field('departamento', 'pa_settings')); ?>>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MHJLVQL" height="0" width="0" style="display:none;visibility:hidden" title="Google Tag Manager"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <?php
  $banner = PaThemeHelpers::getGlobalBanner();


  if ($banner && $banner->enable) {
    $link = $banner->link;
    $source = parse_url(get_site_url(), PHP_URL_HOST);
  ?>
    <div class="pa-banner-global" style=" display: block; background-color: <?= $banner->color; ?>;">
      <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <a href="<?php echo $link . "?utm_source=" . $source . "&utm_medium=BannerGlobal&utm_campaign=" . urlencode($banner->title); ?>" target="_blank" onClick="ga('adventistasGeral.send', 'event', 'Banner - <?= $banner->title; ?>', 'click', 'Banner - <?= $source; ?>');" target="_blank" rel="noopener">
              <picture>
                <source media="(min-width:650px)" srcset="<?= $banner->image_large; ?>">
                <source media="(min-width:465px)" srcset="<?= $banner->image_medium; ?>">
                <img src="<?= $banner->image_small; ?>" title="<?= $banner->title; ?>" alt="<?= $banner->title; ?>">
              </picture>
            </a>
          </div>
        </div>
      </div>
    </div>
  <?php
    // Finaliza a chamada do banner global

  }
  ?>
  <div class="pa-creation-grid d-flex">
    <div class="pa-content-column flex-grow-1 d-block">
      <?php
      require(get_template_directory() . '/components/menu/header.php');
      ?>
