<section class="pa-header py-3">
	<header class="container">
		<div class="row">
			<div class="col py-5">
			<?php if (!is_home() || !is_front_page()){ ?>
				<span class="pa-tag rounded-sm px-3 py-1 d-table-cell"><?php new PA_Header_Title('tag'); ?></span>
			<?php }?>
				<h1 class="mt-2"><?php new PA_Header_Title('title'); ?></h1>
			</div>
		</div>
	</header>
</section>
<?php 

	// Se NÃO for home ou front-page, mostra o breadcrumb
	if(is_home() && !is_front_page()){ 

?>
<!-- <section class="pa-breadcrumb">
	<div class="container">
		<div class="row">
			<div class="col">
				<ul class="list-inline py-2 my-1">
					<li class="list-inline-item m-0"><a href=""><i class="fas fa-home"></i></a></li>
					<li class="list-inline-item m-0"><a href="">Blog</a></li>
					<li class="list-inline-item m-0"><a href="">Semana Santa e Dia Mundial do Jovem</a></li>			 
				</ul>
			</div>
		</div>
	</div>
</section> -->
<?php } ?>