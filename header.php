<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
<?php 
	$banner = PaThemeHelpers::getGlobalBanner();

	if ($banner->enable){
		$link = $banner->link;
		$source = parse_url(get_site_url(), PHP_URL_HOST);
?>
	<div class="pa-banner-global" style=" display: block; background-color: <?= $banner->color; ?>;">
		<div class="container">
			<div class="row"> 
				<div class="col-12 text-center">
					<a href="<?php echo $link ."?utm_source=". $source ."&utm_medium=BannerGlobal&utm_campaign=". urlencode($banner->title); ?>" target="_blank" onClick="ga('adventistasGeral.send', 'event', 'Banner - <?= $banner->title; ?>', 'click', 'Banner - <?= $source; ?>');"  target="_blank" rel="noopener">
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

