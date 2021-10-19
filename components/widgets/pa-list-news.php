<!-- 

ATENÇÃO
Caso queira utilizar em 2/3, alterar as seguintes classes:
pa-widget 'col-md-8''
row 'row-cols-md-2'

Caso queira utilizar em 1/3, alterar as seguintes classes:
pa-widget 'col-md-4'
row row-cols-md-1

 -->


 <?php 

if ( !isset( $size ) ) {
	$size = "1/3";
} 


if($size == "2/3"){
		$col_md = "col-md-8";
		$row_cols_md = "row-cols-md-2";
		$d_xl_block = "d-xl-block pa-truncate-3";
		$class_title = "fw-bold";	
} else {
		$col_md = "col-md-4";
		$row_cols_md = "row-cols-md-1";
		$d_xl_block = "";
		$class_title = "h6";
}
?>

<div class="pa-widget pa-w-list-news col <?= $col_md ?> mb-5">
	<h2><?php echo $title ? $title : 'Widget - List - News'; ?></h2>

	<div class="mt-4">	
		<div class="card mb-5 mb-xl-4 border-0">
			<a href="">
				<div class="row">
					<div class="col-12 col-md-5">
					<div class="ratio ratio-16x9">
						<figure class="figure m-xl-0">
							<img src="https://picsum.photos/480/270.webp?random=1" class="figure-img img-fluid rounded m-0" alt="...">
							<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right d-none <?= $d_xl_block ?>">Bíblia</figcaption>
						</figure>	
					</div>
					</div>
					<div class="col-12 col-md-7">
						<div class="card-body p-0">
							<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">Notícia</span>
							<h3 class="card-title <?= $class_title; ?> h5 mt-xl-2">Voluntários avançam na missão mesmo em meio à pandemia</h3>
							<p class="card-text d-none <?= $d_xl_block ?> ">Programa oficial da Igreja Adventista está há 13 anos na América do Sul e oferece oportunidades de serviço voluntário em diversos países do mundo.</p>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="card mb-5 mb-xl-4 border-0">
			<a href="">
				<div class="row">
					<div class="col-12 col-md-5">
						<div class="ratio ratio-16x9">
							<figure class="figure m-xl-0">
								<img src="https://picsum.photos/480/270.webp?random=2" class="figure-img img-fluid rounded m-0" alt="...">
								<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right d-none <?= $d_xl_block ?>">Mundo</figcaption>
							</figure>	
						</div>
					</div>
					<div class="col-12 col-md-7">
						<div class="card-body p-0">
							<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">Esportes</span>
							<h3 class="card-title <?= $class_title; ?> h5 mt-xl-2">Voluntários avançam na missão mesmo em meio à pandemia</h3>
							<p class="card-text d-none <?= $d_xl_block ?>">Programa oficial da Igreja Adventista está há 13 anos na América do Sul e oferece oportunidades de serviço voluntário em diversos países do mundo.</p>
						</div>
					</div>
				</div>
			</a>
		</div>

		<div class="card mb-5 mb-xl-4 border-0">
			<a href="">
			<div class="row">
				<div class="col-12 col-md-5">
				<div class="ratio ratio-16x9">
					<figure class="figure m-xl-0">
						<img src="https://picsum.photos/480/270.webp?random=3" class="figure-img img-fluid rounded m-0" alt="...">
						<figcaption class="pa-img-tag figure-caption text-uppercase rounded-right d-none <?= $d_xl_block ?>">Religião</figcaption>
					</figure>	
				</div>
				</div>
				<div class="col-12 col-md-7">
					<div class="card-body p-0">
						<span class="pa-tag text-uppercase d-none d-xl-table-cell rounded">Notícia</span>
						<h3 class="card-title <?= $class_title; ?> h5 mt-xl-2">Voluntários avançam na missão mesmo em meio à pandemia</h3>
						<p class="card-text d-none <?= $d_xl_block ?>">Programa oficial da Igreja Adventista está há 13 anos na América do Sul e oferece oportunidades de serviço voluntário em diversos países do mundo.</p>
					</div>
				</div>
			</div>
			</a>
		</div>
	</div>
	<a href="" class="pa-all-content">Ver todas as notícias</a>
</div>
