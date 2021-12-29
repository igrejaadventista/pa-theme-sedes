<div class="pa-share">
<?php
  global $post;

  $url = get_permalink();
  $titulo = $post->post_title;
  $site = get_bloginfo('name');
  $via = "iasd";
  $subject = $site . " - " . $titulo;
  $body = $titulo . "%0D%0A%0D%0A" . get_the_excerpt() . "%0D%0A%0D%0ALeia%20na%20íntegra:%20" . $url;


  $link_twitter = "https://twitter.com/intent/tweet?text=" . urlencode(wp_html_excerpt(get_the_excerpt(), (247 - strlen($via)), '...')) . "&via=" . $via . "&url=" . urlencode($url);
  $link_facebook = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($url) . "&display=popup&ref=plugin&ref=plugin&kid_directed_site=0";
  $link_whatsapp = "https://api.whatsapp.com/send?text=" . urlencode($titulo) . "%20-%20" . $site . "%20-%20" . urlencode($url);
  $link_email = "mailto:?subject=" . rawurlencode($subject) . "&body=" . $body;
?>	
	<ul class="list-inline">
		<li class="list-inline-item d-none d-md-inline-block"><?= _e('Share:', 'iasd' ); ?></li>
		<li class="list-inline-item"><a rel="canonical" target="_blank" href="#" onclick="window.Share.pa_share(event, '<?= $link_twitter  ?>' )" ><i class="fab fa-twitter"></i></a></li>
		<li class="list-inline-item"><a rel="canonical" target="_blank" href="#" onclick="window.Share.pa_share(event, '<?= $link_facebook ?>' )" ><i class="fab fa-facebook-f"></i></a></li>
		<li class="list-inline-item"><a rel="noopener"  target="_blank" href="<?= $link_email ?>"><i class="fas fa-envelope"></i></a></li>
		<li class="list-inline-item"><a rel="canonical" target="_blank" href="#" onclick="window.Share.pa_share(event, '<?= $link_whatsapp ?>' )" ><i class="fab fa-whatsapp"></i></a></li>
		
	</ul>
</div>
