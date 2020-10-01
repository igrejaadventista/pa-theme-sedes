<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= get_stylesheet_directory_uri() . "/style.css"?>" >
	<script src="https://kit.fontawesome.com/c992dc3e78.js" crossorigin="anonymous"></script>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">



	<title>Hello, world!</title>

	<?php //wp_head(); ?>
</head>

<body <?php //body_class(); ?>>
	<div class="pa-creation-grid d-flex">
		<div class="pa-content-column flex-grow-1 d-block">
			<?php 
				require(get_template_directory() . '/components/menu/header.php'); 
				require(get_template_directory() . '/components/front-page/slider.php'); 
				
			?>
