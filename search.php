<?php

/* Template name: Search */

get_header(); 

if(get_locale() == "pt_BR"){
	$cx = "009888215957885727210:tcwrwlw6cma";
} else {
	$cx = "006860825493368957871:dhhtt8i5dmk";
}

require(get_template_directory() . '/components/parent/header.php');
?>

<div class="pa-search">
	<div class="container">
		<div class="row">
			<div class="col">
			<header class="my-5">
				<h1 class="h2"><?php _e('Resultados para:', 'iasd'); ?> <b><?php echo $_GET['q']; ?></b></h1>
				<form method="get" action="<?php echo site_url(); ?>/busca/?" class="search_form">
					<div class="input-group">
						<input type="text" name="q" class="form-control" value="<?php echo $_GET['q']; ?>">
						<span class="input-group-btn">
						<button class="btn btn-default" type="submit"><?php _e('Buscar', 'iasd'); ?></button>
						</span>
					</div>
				</form>
			</header>
				<content>
					<script>
					(function() {
						var cx = "<?php echo $cx; ?>";
						var gcse = document.createElement('script');
						gcse.type = 'text/javascript';
						gcse.async = true;
						gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(gcse, s);
					})();
					</script>
					<gcse:searchresults-only></gcse:searchresults-only>
				</content>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>