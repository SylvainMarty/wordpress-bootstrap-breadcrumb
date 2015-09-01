<?php
/**
 * Plugin Name: Bootstrap breadcrumb
 * Plugin URI: https://github.com/SylvainMarty/wordpress-boostrap-breadcrumb
 * Description: Display a bootstrap breadcrumb automaticaly
 * Version: 1.0
 * Author: SylvainMarty
 * Author URI: https://github.com/SylvainMarty
 * License: MIT License
 */

/**
 * Display the breadcrumb automaticaly
 * @param  String $custom_home_icon  [OPTIONAL] Insert html tag (like Fontawesome <i class="fa fa-xx"></li>)
 * @param  Array $custom_post_types [OPTIONAL] Prevent custom post types with hierarchical structure
 */
function bootstrap_breadcrumb($custom_home_icon = false, $custom_post_types = false) {
	wp_reset_query();
	global $post;
	
	$is_custom_post = $custom_post_types ? is_singular( $custom_post_types ) : false;
	
	if (!is_front_page() && !is_home()) {
		echo '<ol class="breadcrumb">';
		echo '<li><a href="';
		echo get_option('home');
		echo '">';
		if( $custom_home_icon )
			echo $custom_home_icon;
			else
				bloginfo('name');
		echo "</a></li>";
		if ( is_category() || is_single() || $is_custom_post ) {
			if ( is_category() )
				echo '<li class="active"><a href="'.esc_url( get_permalink( get_page( get_the_category($post->ID) ) ) ).'">'.get_the_category($post->ID).'</a></li>';
			if ( $is_custom_post )
				echo '<li class="active"><a href="'.get_option('home').'/'.get_post_type_object( get_post_type($post) )->name.'">'.get_post_type_object( get_post_type($post) )->label.'</a></li>';
			if ( is_single() )
				echo '<li class="active">'.get_the_title($post->ID).'</li>';
		} elseif ( is_page() && $post->post_parent ) {
			$home = get_page(get_option('page_on_front'));
			for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
				if (($home->ID) != ($post->ancestors[$i])) {
					echo '<li><a href="';
					echo get_permalink($post->ancestors[$i]); 
					echo '">';
					echo get_the_title($post->ancestors[$i]);
					echo "</a></li>";
				}
			}
			echo '<li class="active">'.get_the_title($post->ID).'</li>';
		} elseif (is_page()) {
			echo '<li class="active">'.get_the_title($post->ID).'</li>';
		} elseif (is_404()) {
			echo '<li class="active">404</li>';
		}
		echo '</ol>';
	}
}
