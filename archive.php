<?php get_header(); ?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-content py-5">
		<div class="container">
			<div class="row row-cols-auto">
				<article class="col-12 col-md-8">
					<div class="pa-blog-feature">
						<h2 class="mb-4">Destaque</h2>
						<a href="" class="">
							<div class="ratio ratio-16x9">
								<figure class="figure m-xl-0 w-100">
									<img src="https://picsum.photos/960/540.webp?random=1" class="figure-img img-fluid m-0 rounded" alt="...">
									<figcaption class="figure-caption position-absolute w-100 p-3 rounded-bottom">
										<span class="pa-tag rounded-sm mb-2">Revista - PDF</span>
										<h3 class="h4 pt-2">Ação Jovem - Segundo trimestre 2020</h3>
									</figcaption>
								</figure>
							</div>
						</a>
					</div>
					<div class="pa-blog-itens mt-5">
						<h2 class="mb-4">Últimas Postagens</h2>
						<div class="pa-blog-item mb-5 mb-xl-4 border-0">
							<a href="">
								<div class="row">
									<div class="col-5">
									<figure class="figure position-relative m-xl-0">
										<img src="https://picsum.photos/480/270.webp?random=1" class="figure-img img-fluid rounded m-0" alt="...">
										<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right">Bíblia</figcaption>
									</figure>	
									</div>
									<div class="col-7">
										<div class="card-body p-0">
											<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">Notícia</span>
											<h3 class="font-weight-bold h5 mt-xl-2">Voluntários avançam na missão mesmo em meio à pandemia</h3>
											<p class="d-none d-xl-block">Programa oficial da Igreja Adventista está há 13 anos na América do Sul e oferece oportunidades de serviço voluntário em diversos países do mundo.</p>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="pa-blog-item mb-5 mb-xl-4 border-0">
							<a href="">
								<div class="row">
									<div class="col-5">
									<figure class="figure position-relative m-xl-0">
										<img src="https://picsum.photos/480/270.webp?random=2" class="figure-img img-fluid rounded m-0" alt="...">
										<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right">Bíblia</figcaption>
									</figure>	
									</div>
									<div class="col-7">
										<div class="card-body p-0">
											<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">Notícia</span>
											<h3 class="font-weight-bold h5 mt-xl-2">Voluntários avançam na missão mesmo em meio à pandemia</h3>
											<p class="d-none d-xl-block">Programa oficial da Igreja Adventista está há 13 anos na América do Sul e oferece oportunidades de serviço voluntário em diversos países do mundo.</p>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="pa-blog-item mb-5 mb-xl-4 border-0">
							<a href="">
								<div class="row">
									<div class="col-5">
									<figure class="figure position-relative m-xl-0">
										<img src="https://picsum.photos/480/270.webp?random=3" class="figure-img img-fluid rounded m-0" alt="...">
										<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right">Bíblia</figcaption>
									</figure>	
									</div>
									<div class="col-7">
										<div class="card-body p-0">
											<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">Notícia</span>
											<h3 class="font-weight-bold h5 mt-xl-2">Voluntários avançam na missão mesmo em meio à pandemia</h3>
											<p class="d-none d-xl-block">Programa oficial da Igreja Adventista está há 13 anos na América do Sul e oferece oportunidades de serviço voluntário em diversos países do mundo.</p>
										</div>
									</div>
								</div>
							</a>
						</div>
						<div class="pa-blog-item mb-5 mb-xl-4 border-0">
							<a href="">
								<div class="row">
									<div class="col-5">
									<figure class="figure position-relative m-xl-0">
										<img src="https://picsum.photos/480/270.webp?random=6" class="figure-img img-fluid rounded m-0" alt="...">
										<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right">Bíblia</figcaption>
									</figure>	
									</div>
									<div class="col-7">
										<div class="card-body p-0">
											<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">Notícia</span>
											<h3 class="font-weight-bold h5 mt-xl-2">Voluntários avançam na missão mesmo em meio à pandemia</h3>
											<p class="d-none d-xl-block">Programa oficial da Igreja Adventista está há 13 anos na América do Sul e oferece oportunidades de serviço voluntário em diversos países do mundo.</p>
										</div>
									</div>
								</div>
							</a>
						</div>

						<div class="">
							<div>16x9</div>
						</div>
					</div>
				</article>
				<aside class="col-md-4 d-none d-xl-block">
				<?php 
					$icon = true;
					require(get_template_directory() . '/components/widgets/pa-list-buttons.php');
					require(get_template_directory() . '/components/widgets/pa-list-videos.php');
					require(get_template_directory() . '/components/widgets/pa-list-downloads.php');	
				?>
				</aside>
			</div>
		</div>
	</div>

<?php get_footer();?>
