<?php 
get_header(); 
if(have_posts())
		the_post();
?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<div class="pa-content-container py-5">
		<div class="container">
			<div class="row row-cols-auto">
				<article class="col-12 col-md-8">
					<header class="mb-4">
						<h1 class="font-weight-bold mb-3"><?php single_post_title(); ?></h1>
						<h2 class="mb-3"><?php the_excerpt(); ?></h3>
						<div class="pa-post-meta">Por Maycon Santos | <?php the_date(); ?></div>
						<hr class="my-4">
						<div class="d-flex justify-content-between">
							<div class="pa-share">
								<ul class="list-inline">
									<li class="list-inline-item">Compartilhar: </li>
									<li class="list-inline-item"><a href=""><i class="fab fa-twitter"></i></a></li>
									<li class="list-inline-item"><a href=""><i class="fab fa-facebook-f"></i></a></li>
									<li class="list-inline-item"><a href=""><i class="fas fa-envelope"></i></a></li>
									<li class="list-inline-item"><a href=""><i class="fab fa-whatsapp"></i></a></li>
								</ul>
							</div>
							<div class="">
								<ul class="pa-accessibility list-inline">
									<li class="pa-text-dec list-inline-item"><a href="">-A</a></li>
									<li class="pa-text-inc list-inline-item"><a href="">+A</a></li>
									<li class="pa-text-listen list-inline-item"><a href="" class="rounded p-2"><i class="fas fa-volume-up"></i> Ouvir Texto</a></li>
								</ul>
							</div>
						</div>
					</header>
					<div class="pa-content">
						<?php the_content('tste'); ?>
					</div>
					<footer>
						<div class="pa-navigation d-flex justify-content-between">
							<a href=""><i class="fas fa-arrow-left"></i> Artigo anterior</a>
							<div class="pa-share">
								<ul class="list-inline">
									<li class="list-inline-item">Compartilhar: </li>
									<li class="list-inline-item"><a href=""><i class="fab fa-twitter"></i></a></li>
									<li class="list-inline-item"><a href=""><i class="fab fa-facebook-f"></i></a></li>
									<li class="list-inline-item"><a href=""><i class="fas fa-envelope"></i></a></li>
									<li class="list-inline-item"><a href=""><i class="fab fa-whatsapp"></i></a></li>
								</ul>
							</div>
							<a href="">Próximo artigo <i class="fas fa-arrow-right"></i></a>
						</div>
						<div class="pa-comments">Comentários</div>
					</footer>
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
