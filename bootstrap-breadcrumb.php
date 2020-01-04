<?php
/**
 * Plugin Name: Bootstrap breadcrumb
 * Plugin URI: https://github.com/SylvainMarty/wordpress-bootstrap-breadcrumb
 * Description: Display a bootstrap breadcrumb automaticaly
 * Version: 1.0
 * Author: SylvainMarty
 * Author URI: https://github.com/SylvainMarty
 * License: MIT License
 */

$defaults = array(
	'before_items' => '',
	'breadcrumb_classes' => '',
	'custom_home_icon' => false, // Insert html tag (like Fontawesome <i class="fa fa-xx"></li>)
	'custom_post_types' => false, // Prevent custom post types with hierarchical structure
	'do_not_show_on_index' => true,
	'item_classes' => '',
	'show_post_type' => true
);

/**
 * Display the breadcrumb automaticaly
 */
function bootstrap_breadcrumb($options) {
	wp_reset_query();
	global $post, $defaults;

	$config = array_merge($defaults, $options);
	$is_custom_post = $config['custom_post_types'] ? is_singular( $config['custom_post_types'] ) : false;
	
	if (!$config['do_not_show_on_index'] || (!is_front_page() && !is_home())) {
		echo '<ol class="breadcrumb ' . $config['breadcrumb_classes'] . '">';
		if ($config['before_items'] !== '')
			echo $config['before_items'];
		echo '<li class="breadcrumb-item ' . $config['item_classes'] . ' ' . (is_front_page() || is_home() ? 'active' : '') . '">';
		if (!is_front_page() && !is_home())
			echo '<a href="' . get_option('home') . '">';
		if( $config['custom_home_icon'] )
			echo $config['custom_home_icon'];
			else
				bloginfo('name');
		if (!is_front_page() && !is_home())
			echo "</a>";
		echo "</li>";
		if ( has_category() ) {
			echo '<li class="breadcrumb-item ' . $config['item_classes'] . ' active"><a href="'.esc_url( get_permalink( get_page( get_the_category($post->ID) ) ) ).'">';
			the_category(', ');
			echo '</a></li>';
		}
		if ( is_category() || is_single() || $is_custom_post ) {
			if ( is_category() )
				echo '<li class="breadcrumb-item ' . $config['item_classes'] . ' active"><a href="'.esc_url( get_permalink( get_page( get_the_category($post->ID) ) ) ).'">'.get_the_category($post->ID)[0]->name.'</a></li>';
			if ( $is_custom_post ) {
				if ($config['show_post_type'])
					echo '<li class="breadcrumb-item ' . $config['item_classes'] . ' active"><a href="'.get_option('home').'/'.get_post_type_object( get_post_type($post) )->name.'">'.get_post_type_object( get_post_type($post) )->label.'</a></li>';
				if ( $post->post_parent ) {
					$home = get_page(get_option('page_on_front'));
					for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
						if (($home->ID) != ($post->ancestors[$i])) {
							echo '<li class="breadcrumb-item ' . $config['item_classes'] . '"><a href="';
							echo get_permalink($post->ancestors[$i]); 
							echo '">';
							echo get_the_title($post->ancestors[$i]);
							echo "</a></li>";
						}
					}
				}
			}
			if ( is_single() || is_page() )
				echo '<li class="breadcrumb-item ' . $config['item_classes'] . ' active">'.get_the_title($post->ID).'</li>';
		} elseif ( is_page() && $post->post_parent ) {
			$home = get_page(get_option('page_on_front'));
			for ($i = count($post->ancestors)-1; $i >= 0; $i--) {
				if (($home->ID) != ($post->ancestors[$i])) {
					echo '<li class="breadcrumb-item ' . $config['item_classes'] . '"><a href="';
					echo get_permalink($post->ancestors[$i]); 
					echo '">';
					echo get_the_title($post->ancestors[$i]);
					echo "</a></li>";
				}
			}
			echo '<li class="breadcrumb-item ' . $config['item_classes'] . ' active">'.get_the_title($post->ID).'</li>';
		} elseif (is_page()) {
			echo '<li class="breadcrumb-item ' . $config['item_classes'] . ' active">'.get_the_title($post->ID).'</li>';
		} elseif (is_404()) {
			echo '<li class="breadcrumb-item ' . $config['item_classes'] . ' active">404</li>';
		}
		echo '</ol>';
	}
}
