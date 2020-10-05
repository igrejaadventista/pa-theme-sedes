<?php 
class PA_Menu_Mobile {
	function __construct($menu){
		$menu = self::getMenuArray(self::getDefaultMenu($menu));
		echo '<ul class="menu_inf">';
		self::getMenuGlobal();
		foreach ($menu as $m){
			echo '<li class="'. (empty($m['children']) ? "" : "pa-dropdown") .'"><a href="#">'. $m['title'] .'</a>';
			self::getMenuChild($m['children']);
			echo '</li>';
		}
		echo "</ul>";
	}

	function getMenuArray($current_menu) {

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
	
	function getDefaultMenu($wp_menu){
		$menuLocations = get_nav_menu_locations();
		$menuID = $menuLocations[$wp_menu];
		return $menuID;
	}
	
	function getMenuChild($child){
		if (!empty($child)) {
			echo '<div class="pa-sub-dropdown"><ul>';
			foreach($child as $m2){
				echo '<li><a href="'. $m2['url'].'">'. $m2['title'] .'</a></li>';
			}
			echo '</ul></div>';
		}
	}
	
	function getMenuGlobal(){
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
}