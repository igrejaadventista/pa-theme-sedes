<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>

	<style>
		:root {
			/* --pa-color-default: #CF702F;
			--pa-color-default-light: #F29050;
			--pa-color-default-dark: #B56229;
			--pa-color-default-aux: #bfd2e6;  */
		}
	</style>
</head>

<body <?php body_class(); ?>>
	<div class="pa-creation-grid d-flex">
		<div class="pa-content-column flex-grow-1 d-block">
			<?php 
				require(get_template_directory() . '/components/menu/header.php'); 
			?>
