<?php
get_header();
global $wp_query;
require(get_template_directory() . '/components/parent/header.php');
?>

<style>
    @media (max-width: 768px) {
        .card {
            max-width: 100%;
        }

        .responsive-iframe-container {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            /* Aspect ratio 16:9 */
            overflow: hidden;
        }

        .responsive-iframe-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }
    }
</style>

<div class="pa-content-container py-5">
    <div class="container">
        <div class="row justify-content-md-center">
            <article class="col-12 col-md-8">
                <?php
                while (have_posts()) : the_post();
                ?>
                    <div class="post-info container-fluid px-0" style="font-family: var(--pa-font-secondary);">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6">
                                    <h2 class="post-info__title border-0 p-0 mb-4 fw-bold m-0"><?php the_title(); ?></h2> 
                                    <div class="row align-items-center justify-content-between">
                                        <div class="pa-post-meta mb-2">
                                            <span><i class="far fa-user me-2" aria-hidden="true"></i><?php the_author(); ?></span>
                                            <em class="pa-pipe">|</em>
                                            <span><i class="far fa-calendar me-2" aria-hidden="true"></i><?php the_date(); ?></span>
                                        </div>

                                        <hr class="my-45">


                                        <div class="d-flex justify-content-between">
                                            <div class="pa-share">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item d-none d-md-inline-block">Compartilhar:</li>
                                                    <li class="list-inline-item"><a rel="canonical" target="_blank" href="#" onclick="window.Share.pa_share(event, 'https://twitter.com/intent/tweet?text=Em+um+mundo+polarizado%2C+saber+analisar+informa%C3%A7%C3%B5es+e+buscar+as+fontes+corretas+s%C3%A3o+a+chave+para+encontrar+a+verdade&amp;via=iasd&amp;url=https%3A%2F%2Fnoticias.adventistas.org%2Fpt%2Fcoluna%2Fdiego.barreto%2Fa-verdade-como-oxigenio-em-um-mundo-intoxicado%2F' )"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                                    <li class="list-inline-item"><a rel="canonical" target="_blank" href="#" onclick="window.Share.pa_share(event, 'https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fnoticias.adventistas.org%2Fpt%2Fcoluna%2Fdiego.barreto%2Fa-verdade-como-oxigenio-em-um-mundo-intoxicado%2F&amp;display=popup&amp;ref=plugin&amp;ref=plugin&amp;kid_directed_site=0' )"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                                                    <li class="list-inline-item"><a rel="noopener" target="_blank" href="mailto:?subject=Not%C3%ADcias%20Adventistas%20-%20A%20verdade%20como%20oxig%C3%AAnio%20em%20um%20mundo%20intoxicado&amp;body=A verdade como oxigênio em um mundo intoxicado%0D%0A%0D%0AEm um mundo polarizado, saber analisar informações e buscar as fontes corretas são a chave para encontrar a verdade%0D%0A%0D%0ALeia%20na%20íntegra:%20https://noticias.adventistas.org/pt/coluna/diego.barreto/a-verdade-como-oxigenio-em-um-mundo-intoxicado/"><i class="fas fa-envelope" aria-hidden="true"></i></a></li>
                                                    <li class="list-inline-item"><a rel="canonical" target="_blank" href="#" onclick="window.Share.pa_share(event, 'https://api.whatsapp.com/send?text=A+verdade+como+oxig%C3%AAnio+em+um+mundo+intoxicado%20-%20Notícias Adventistas%20-%20https%3A%2F%2Fnoticias.adventistas.org%2Fpt%2Fcoluna%2Fdiego.barreto%2Fa-verdade-como-oxigenio-em-um-mundo-intoxicado%2F' )"><i class="fab fa-whatsapp" aria-hidden="true"></i></a></li>
                                                </ul>
                                            </div>
                                            <div class="pa-accessibility">
                                                <ul class="list-inline">
                                                    <li class="pa-text-dec list-inline-item"><a href="#" class="rounded p-2" onclick="window.TextSize.pa_diminui_texto(event)">-A</a></li>
                                                    <li class="pa-text-inc list-inline-item"><a href="#" class="rounded p-2" onclick="window.TextSize.pa_aumenta_texto(event)">+A</a></li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="pa-content my-4">
                                        <?php the_content(); ?>
                                    </div>

                                    <div class="card">
                                        <?php
                                        $embed_code = get_field('embed_code');
                                        if ($embed_code) :
                                            echo '<div class="responsive-iframe-container">' . $embed_code . '</div>';
                                        endif;
                                        ?>
                                    </div>

                                    <div class="pa-magazine-download my-4">
                                        <?php
                                        $download_url = get_field('download_file');
                                        if ($download_url) :
                                        ?>
                                            <div class="pa-downloads-table__fit py-3 px-0 px-lg-3 fw-bold">
                                                <a class="text-decoration-none d-flex align-items-center" href="<?php echo esc_url($download_url); ?>" download="" target="_blank">
                                                    <i class="fas fa-download me-2" aria-hidden="true"></i>
                                                    <span class="d-none d-lg-inline-block"><?php _e('Baixar', 'iasd'); ?></span>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <?php
                        if (comments_open() || get_comments_number()) {
                            comments_template();
                        }
                        ?>
                    </div>
                <?php endwhile; ?>
            </article>
            <?php if (is_active_sidebar('single')) { ?>
                <aside class="col-md-4 d-none d-xl-block">
                    <?php dynamic_sidebar('single'); ?>
                </aside>
            <?php } ?>
        </div>
    </div>
</div>

<footer>
    <?php get_footer(); ?>
</footer>