<?php get_header(); ?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 
	?>
	<div class="pa-content py-5">
		<div class="container">
			<div class="row row-cols-auto">
				<article class="col-12 col-md-8">

					<?php 

					$paged = get_query_var('paged');
					$stickys = get_option('sticky_posts');
					$category = get_queried_object();
					$showposts = get_option('posts_per_page');

					if($paged < 1){

						// Argumentos para o loop de destaque que busca preferencialmnte a primeira postagem fixa da categoria, caso não exista um post fixo nessa categoria ele vai pega no lugar um post mais recente.
						$args = array(
							'post_type'      => 'post',
							'cat'            =>  $category->term_id,
							'posts_per_page' => 1,
							'post__in'  => $stickys,
							'ignore_sticky_posts' => 1,
							);
						
						// Função que monta o HTML especifico da area de destaque archive.
						// - Retorna dois parametos:
						// -- "post_list" Array com os IDs que foi renderizado no loop
						// -- "post_count" Número de itens que foi renderizado no loop 
						$post_return = pa_blog_feature($args);
						$showposts = $showposts - $post_return['post_count'];

					}

					?>

					<div class="pa-blog-itens my-5">
						<h2 class="mb-4">Últimas Postagens</h2>

						<?php 


							// Verifica se a variavel $post_return existe, caso não atribui um array vasio.
							// - Isso é necessário pois a etapa anterior onde é tirada a váriavel com o restante dos posts fixos, é processada apenas na primeira página da archive.  
							$post_return = isset($post_return) ? $post_return : []; 

							// Verifica se existe mais posts fixos a serem renderizados				
						 	if(!empty(array_diff($stickys, $post_return['post_list']))){

								$args = array(
									'post_type'     => 'post',
									'cat'           =>  $category->term_id,
									'post__in'  	=> array_diff($stickys, $post_return['post_list']),
									'post__not_in' 	=>  $post_return['post_list'],
									'ignore_sticky_posts' => 1,
									'paged' => $paged,
									'posts_per_page' => $showposts,
									);
								
								// Função que monta o HTML da lista de post archive.
								// - Retorna dois parametos:
								// -- "post_list" Array com os IDs que foi renderizado no loop
								// -- "post_count" Número de itens que foi renderizado no loop
								$post_return = pa_blog_itens($args);
								
								//Atualiza a variavel para o número restante de posts que ainda podem ser renderizado
								$showposts = $showposts - $post_return['post_count'];

							}

						
				
							// Argumentos para o loop padrão que não traz os posts fixos
							$args = array(
								'post_type'     => 'post',
								'cat'           =>  $category->term_id,
								'post__not_in' 	=>  (!empty($stickys) ? $stickys : $post_return['post_list']),
								'paged' => $paged,
								'posts_per_page' => $showposts
								);

							// Função que monta o HTML da lista de post archive.
							// - Retorna dois parametos:
							// -- "post_list" Array com os IDs que foi renderizado no loop
							// -- "post_count" Número de itens que foi renderizado no loop
							pa_blog_itens($args);
							
						?>

					</div>

					<div class="pa-navigation row pt-5">
						<?php $PaPagination = new PaPagination(); ?>
					</div>

				</article>
				<aside class="col-md-4 d-none d-xl-block">
				<?php 
					if ( is_active_sidebar( 'archive' ) ) {
						dynamic_sidebar( 'archive');
						}
				?>
				</aside>
			</div>
		</div>
	</div>

<?php get_footer();?>
