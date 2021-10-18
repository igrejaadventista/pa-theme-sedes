<?php

/**
 * Create HTML list of nav menu items.
 * Replacement for the native Walker, using the description.
 *
 * @see    https://wordpress.stackexchange.com/q/14037/
 * @author fuxia
 */
class PaMenuWalker extends Walker_Nav_Menu
{
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
		
		$indent = str_repeat( "\t", $depth );
		$output .= "\n$indent<ul role=\"menu\" class=\" dropdown-menu pa-split-column-2 p-4\">\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0) {
		$args = (object) $args;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/*grab the default wp nav classes*/
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

		/*if the current item has children, append the dropdown class*/
		if ( $args->has_children ){
			$class_names .= ' dropdown';
		}
		
		/*if there aren't any class names, don't show class attribute*/
		$class_names = $class_names ? ' class="nav-item ' . esc_attr( $class_names ) . '"' : '';

		$id_before = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id_after = $id_before ? ' id="' . esc_attr( $id_before ) . '"' : '';


		$output .= $indent . '<li' . $id_after . $value . $class_names .'>';

		$atts = array();
		$atts['title']  = ! empty( $item->title )	? $item->title	: '';
		$atts['target'] = ! empty( $item->target )	? $item->target	: '';
		$atts['rel']    = ! empty( $item->xfn )		? $item->xfn	: '';


		/*if the current menu item has children and it's the parent, set the dropdown attributes*/
		if ( $args->has_children && $depth === 0 ) {
			$atts['href']   		= '#';
			$atts['data-bs-toggle']	= 'dropdown';
			$atts['class']			= 'nav-link dropdown-toggle';
			$atts['role']			= 'button';
			$atts['aria-expanded']	= 'false';
		} else {
			$atts['href'] = ! empty( $item->url ) ? $item->url : '';
		}

		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$item_output = $args->before;

		$item_output .= '<a'. $attributes .' class="nav-link text-body">';

		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

	/*	if the current menu item has children and it's the parent item, append the fa-angle-down icon*/
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

	}

	
	public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
		if ( ! $element ) {
			return false;
		}

		$id_field = $this->db_fields['id'];

		if ( is_object( $args[0] ) ){
			$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );
		}
		parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
	}
}
