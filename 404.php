<?php get_header(); ?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<section class="pa-404 py-5">
		<div class="container">
			<div class="row row-cols-auto py-md-5">
				<div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
					<div class="px-5">
						<img src="<?= get_template_directory_uri() . "/assets/imgs/404.svg" ?>" alt="<?= _e("I'm sorry! Content not found! :(", "iasd"); ?>" title="<?= _e("I'm sorry! Content not found! :(", "iasd"); ?>" class="img-fluid">
					</div>
				</div>
				<div class="col-12 col-md-6 text-center text-md-start">
					<div class="px-5 pt-5 pt-md-0 ">
						<h1 class="fw-bold">Erro 404</h1>
						<h2 class="fw-bold"><?= _e("I'm sorry! Content not found! :(", "iasd"); ?></h2>
						<p><?= _e("The content which you are looking don't exist and don't be found.", 'iasd'); ?></p>
						<form class="pt-4 pt-xl-3 d-flex flex-column align-items-stretch">
							<div class="mb-3">
								<label for="pa-search-input" class="form-label mb-4"><?= _e('Do you want to do a new search?', 'iasd'); ?></label>
								<input type="text" class="form-control" id="pa-search-input" aria-describedby="searchInput" placeholder="<?= _e('New search', 'iasd'); ?>">
							</div>
							<button type="submit" class="btn btn-primary align-self-xl-start "><?= _e('Search', 'iasd'); ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

<?php get_footer();?>
