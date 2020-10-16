<!-- 

ATENÇÃO
Caso queira mostrar os icones, inserir a classe CSS 'pa-w-list-buttons-icons' no elemento pai 'pa-widget'

-->

<?php

$class = isset($icon) ? $icon : '' ;

?>

<div class="pa-widget pa-w-list-buttons <?= $class ?> col-12 col-md-4 mb-5">
	<h2><?php echo $title ? $title : 'Widget - List - Buttons'; ?></h2>
	<ul class="list-unstyled mt-4">
		<li class="pa-widget-button h-25 mb-4">
			<a href="#" class="d-block d-flex px-4 align-items-center rounded font-weight-bold">
				<i class="pa-icon far fa-file-alt mr-4 fa-2x"></i> 
				<span class="my-4">Artigo</span>
				<i class="fas fa-chevron-right ml-auto"></i>
			</a>
		</li>
		<li class="pa-widget-button h-25 mb-4">
			<a href="#" class="d-block d-flex px-4 align-items-center rounded font-weight-bold">
				<i class="pa-icon fas fa-book-open mr-4 fa-2x"></i> 
				<span class="my-4">Revista</span>
				<i class="fas fa-chevron-right ml-auto"></i>
			</a>
		</li>
		<li class="pa-widget-button h-25 mb-4">
			<a href="#" class="d-block d-flex px-4 align-items-center rounded font-weight-bold">
				<i class="pa-icon fas fa-file-signature mr-4 fa-2x"></i> 
				<span class="my-4">Testemunhos</span>
				<i class="fas fa-chevron-right ml-auto"></i>
			</a>
		</li>
		<li class="pa-widget-button h-25 mb-4">
			<a href="#" class="d-block d-flex px-4 align-items-center rounded font-weight-bold">
				<i class="pa-icon fas fa-bible mr-4 fa-2x"></i> 
				<span class="my-4">Bíblia</span>
				<i class="fas fa-chevron-right ml-auto"></i>
			</a>
		</li>
		<li class="pa-widget-button h-25 mb-4">
			<a href="#" class="d-block d-flex px-4 align-items-center rounded font-weight-bold">
				<i class="pa-icon fas fa-church mr-4 fa-2x"></i> 
				<span class="my-4">Igreja</span>
				<i class="fas fa-chevron-right ml-auto"></i>
			</a>
		</li>
	</ul>
	<a href="#" class="pa-all-content">Ver todos os projetos</a>
</div>