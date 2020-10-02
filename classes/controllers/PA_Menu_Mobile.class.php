<?php 

function wp_get_menu_array($current_menu) {

	$menu_array = wp_get_nav_menu_items($current_menu);

	$menu = array();

	function populate_children($menu_array, $menu_item)
	{
		$children = array();
		if (!empty($menu_array)){
			foreach ($menu_array as $k=>$m) {
				if ($m->menu_item_parent == $menu_item->ID) {
					$children[$m->ID] = array();
					$children[$m->ID]['ID'] = $m->ID;
					$children[$m->ID]['title'] = $m->title;
					$children[$m->ID]['url'] = $m->url;
					unset($menu_array[$k]);
					$children[$m->ID]['children'] = populate_children($menu_array, $m);
				}
			}
		};
		return $children;
	}

	foreach ($menu_array as $m) {
		if (empty($m->menu_item_parent)) {
			$menu[$m->ID] = array();
			$menu[$m->ID]['ID'] = $m->ID;
			$menu[$m->ID]['title'] = $m->title;
			$menu[$m->ID]['url'] = $m->url;
			$menu[$m->ID]['children'] = populate_children($menu_array, $m);
		}
	}
	return $menu;

}

function get_default_menu($wp_menu){
	$menuLocations = get_nav_menu_locations();
	$menuID = $menuLocations[$wp_menu];
	return $menuID;
}

function get_menu_child($child){
	if (!empty($child)) {
		echo '<div class="pa-sub-dropdown"><ul>';
		foreach($child as $m2){
			echo '<li><a href="'. $m2['url'].'">'. $m2['title'] .'</a></li>';
		}
		echo '</ul></div>';
	}
}

function get_menu_global(){
	echo '<li class="pa-dropdown">
	<a href="#">Adventistas.org</a>
	<div class="pa-sub-dropdown">
		<ul>
			<li><a href="#">Institucional</a></li>
			<li><a href="#">Notícias</a></li>
			<li><a href="#">Vídeos</a></li>
			<li><a href="#">Downloads</a></li>
			<li><a href="#">Apps</a></li>
		</ul>
	</div>
</li>';
}

function get_menu_father($menu){
	echo '<ul class="menu_inf">';
	get_menu_global();
	foreach ($menu as $m){
		echo '<li class="'. (empty($m['children']) ? "" : "pa-dropdown") .'"><a href="#">'. $m['title'] .'</a>';
		get_menu_child($m['children']);
		echo '</li>';
	}
	echo "</ul>";
}
