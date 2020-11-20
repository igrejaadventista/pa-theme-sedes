<?php get_header(); ?>
	<div class="pa-404 py-5">
		<div class="container">
			<div class="row row-cols-auto py-md-5">
				<div class="col-12 col-md-6 d-flex align-items-center justify-content-center">
					<div class="px-5">
						<img src="<?= get_template_directory_uri() . "/assets/imgs/404.svg" ?>" alt="<?php _e('Desculpe-nos, página não encontrada.', 'iasd'); ?>" title="<?php _e('Desculpe-nos, página não encontrada.', 'iasd'); ?>" class="img-fluid">
					</div>
				</div>
				<div class="col-12 col-md-6 text-center text-md-left">
					<div class="px-5 pt-5 pt-md-0 ">
						<h1 class="fw-bold">Erro 404</h1>
						<h2 class="fw-bold"><?php _e('Desculpe-nos, página não encontrada :(', 'iasd'); ?></h2>
						<p><?php _e('A página que você está procurando não existe ou não foi econtrada no Portal Adventista.', 'iasd'); ?></p>
						<form class="pt-4 pt-xl-3 d-flex flex-column align-items-stretch">
							<div class="mb-3">
								<label for="pa-search-input" class="form-label mb-4"><?php _e('Deseja fazer uma nova busca?', 'iasd'); ?></label>
								<input type="text" class="form-control" id="pa-search-input" aria-describedby="searchInput" placeholder="<?php _e('Pesquisar no Portal Adventista', 'iasd'); ?>">
							</div>
							<button type="submit" class="btn btn-primary align-self-xl-start "><?php _e('Pesquisar', 'iasd'); ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php get_footer();?>
