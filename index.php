<?php get_header(); ?>
	<?php 
		require(get_template_directory() . '/components/parent/header.php'); 	
	?>
	<!-- <div class="pa-widgets pt-5">
		<div class="container">
			<div class="row row-cols-auto">
				<?php 
					// require(get_template_directory() . '/components/widgets/pa-carousel-ministry.php');
					// require(get_template_directory() . '/components/widgets/pa-list-buttons.php');

					// $tamanho = '2/3';
					// require(get_template_directory() . '/components/widgets/pa-list-videos.php');
					// require(get_template_directory() . '/components/widgets/pa-carousel-feature.php');
					// require(get_template_directory() . '/components/widgets/pa-list-downloads.php');

				?>
			</div>
		</div>
	</div> -->


	<?php 
	
	function wp_get_menu_array($current_menu) {
 
		$array_menu = wp_get_nav_menu_items($current_menu);
		$menu = array();
		foreach ($array_menu as $m) {
			if (empty($m->menu_item_parent)) {
				$menu[$m->ID] = array();
				$menu[$m->ID]['ID']      =   $m->ID;
				$menu[$m->ID]['title']       =   $m->title;
				$menu[$m->ID]['url']         =   $m->url;
				$menu[$m->ID]['children']    =   array();
			}
		}
		$submenu = array();
		foreach ($array_menu as $m) {
			if ($m->menu_item_parent) {
				$submenu[$m->ID] = array();
				$submenu[$m->ID]['ID']       =   $m->ID;
				$submenu[$m->ID]['title']    =   $m->title;
				$submenu[$m->ID]['url']  =   $m->url;
				$menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
			}
		}
		return $menu;	 
	}


	?>

<script>

console.log(<?php var_dump(wp_get_menu_array('default')); ?>);


</script>

<?php get_footer();?>
