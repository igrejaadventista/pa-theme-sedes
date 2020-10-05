<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . "/assets/node_modules/bootstrap/dist/css/bootstrap.min.css"?>">
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . "/style.css"?>" >
	<script src="https://kit.fontawesome.com/c992dc3e78.js" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

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
