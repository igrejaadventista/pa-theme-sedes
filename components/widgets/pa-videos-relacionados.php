<div class="pa-widget pa-w-list-posts col col-md-8 mb-5">
	<h2><?php echo $title ? $title : 'Widget - Relacionados - Videos'; ?></h2>
	<div class="row mt-4">

		<?php for($i = 1; $i <= $n_intes; $i++){ ?>

			<div class="col-4">
				<div class="card mb-2 mb-xl-4 border-0">
					<a href="">				
						<figure class="figure position-relative">
							<img src="https://picsum.photos/480/270.webp?random=<?= $i ?>" class="figure-img img-fluid rounded m-0" alt="...">
						</figure>	
						<div class="card-body p-0">
							<h3 class="card-title h6">Missão Calebe Curitiba no programa ”É de Casa” </h3>
						</div>
					</a>
				</div>
			</div>

		<?php } ?>

	</div>
	<a href="" class="pa-all-content">Ver todas as notícias</a>
</div>