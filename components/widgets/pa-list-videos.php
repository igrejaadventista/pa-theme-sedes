<!-- 

ATENÇÃO
Caso queira utilizar em 2/3, alterar as seguintes classes:
pa-widget 'col-md-8''
row 'row-cols-md-2'

Caso queira utilizar em 1/3, alterar as seguintes classes:
pa-widget 'col-md-4'
row-cols-md-1

 -->


<?php 

if ($tamanho == '1/3') {
	$col_md = "col-md-4";
	$row_cols_md = "row-cols-md-1";
	$d_xl_block = "";
} else if ($tamanho == '2/3') {
	$col_md = "col-md-8";
	$row_cols_md = "row-cols-md-2";
	$d_xl_block = "d-xl-block";
}

?> 

 <div class="pa-widget pa-widget-feature col <?= $col_md ?> mb-5">
	<h2>Widget - List - Videos</h2>
	<div class="row row-cols-auto <?= $row_cols_md ?> mt-4">
		<div class="col">
			<div class="card mb-4 border-0">
				<a href="">
					<figure class="figure position-relative">
						<img src="https://picsum.photos/480/270.webp?random=20" class="figure-img img-fluid rounded m-0" alt="...">
						<div class="figure-caption position-absolute w-100 h-100 d-block">
							<i class="pa-play far fa-play-circle position-absolute"></i>
							<span class="pa-video-time position-absolute px-2 rounded-sm"><i class="far fa-clock mr-1"></i> 3:40</span>
						</div>
					</figure>
					<div class="card-body p-0">
						<h3 class="card-text h5 font-weight-bold pa-truncate">Desbravadores celebram Dia Mundial no modelo drive-inDia Mundial no modelo drive-in</h3>
						<p class="card-text d-none <?= $d_xl_block ?>">Cards support a wide variety of content, including images, text, list groups, links, and more. Below are examples of what’s supported.</p>
					</div>
				</a>
			</div>
		</div>
		<div class="col">
			<div class="card mb-2 mb-xl-4 border-0">
				<a href="">
					<div class="row">
						<div class="col">
							<figure class="figure position-relative m-xl-0">
								<img src="https://picsum.photos/480/270.webp?random=2" class="figure-img img-fluid rounded m-0" alt="...">
								<div class="figure-caption position-absolute w-100 h-100 d-block">
									<span class="pa-video-time position-absolute px-2 rounded-sm"><i class="far fa-clock mr-1"></i> 3:40</span>
								</div>
							</figure>	
						</div>
						<div class="col">
							<div class="card-body p-0">
								<h3 class="card-title h6">Voluntários avançam na missão mesmo em meio à pandemia</h3>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="card mb-2 mb-xl-4 border-0">
				<a href="">
					<div class="row">
						<div class="col">
							<figure class="figure position-relative m-xl-0">
								<img src="https://picsum.photos/480/270.webp?random=3" class="figure-img img-fluid rounded m-0" alt="...">
								<div class="figure-caption position-absolute w-100 h-100 d-block">
									<span class="pa-video-time position-absolute px-2 rounded-sm"><i class="far fa-clock mr-1"></i> 3:40</span>
								</div>
							</figure>	
						</div>
						<div class="col">
							<div class="card-body p-0">
								<h3 class="card-title h6">Voluntários avançam na missão mesmo em meio à pandemia</h3>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="card mb-2 mb-xl-4 border-0">
				<a href="">
					<div class="row">
						<div class="col">
							<figure class="figure position-relative m-xl-0">
								<img src="https://picsum.photos/480/270.webp?random=5" class="figure-img img-fluid rounded m-0" alt="...">
								<div class="figure-caption position-absolute w-100 h-100 d-block">
									<span class="pa-video-time position-absolute px-2 rounded-sm"><i class="far fa-clock mr-1"></i> 3:40</span>
								</div>
							</figure>	
						</div>
						<div class="col">
							<div class="card-body p-0">
								<h3 class="card-title h6">Voluntários avançam na missão mesmo em meio à pandemia</h3>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>
	</div>
	<a href="" class="pa-all-content">Ver todos os vídeos</a>
</div>