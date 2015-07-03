<?php

/*
Plugin Name: Smart Carousel Slider
Plugin URI:  http://wppluginarea.com/smart-carousel-slider/
Description: In this Smart Carousel Slider you will get various style and feature with dynamic multiple shortcode. WP Smart Carousel it's supper easy to use.
Author: Wp Plugin Area
Author URI: http://wppluginarea.com
Version: 2.1
*/

/* Adding Latest jQuery from Wordpress */
function tp_smart_carousel_slider_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'tp_smart_carousel_slider_latest_jquery');

/*Some Set-up*/
define('TP_SMART_CAROUSEL_SLIDER', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

function tp_smart_slider_files(){
	/* Adding Plugin javascript file */
	wp_enqueue_script('tp-slider-plugin-js', TP_SMART_CAROUSEL_SLIDER.'js/owl.carousel.min.js', array('jquery'), '2.1', false);

	/* Adding Plugin owl carousel css file */
	wp_enqueue_style('tp-owl-slider-css', TP_SMART_CAROUSEL_SLIDER.'css/owl.carousel.css', array(), '2.1', false);
	
	/* Adding Plugin owl carousel Transition css file */
	wp_enqueue_style('tp-slider-transition-css', TP_SMART_CAROUSEL_SLIDER.'css/owl.transitions.css', array(), '2.1', false);
	
	/* Adding Plugin tp carousel theme css file */
	wp_enqueue_style('tp-slider-theme-css', TP_SMART_CAROUSEL_SLIDER.'css/tp-slider-style.css', array(), '2.1', false);
}
add_action( 'wp_enqueue_scripts', 'tp_smart_slider_files' );


// Hooks your functions into the correct filters
function tp_slider_mce_button() {
	// check user permissions
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'tp_slider_tinymce_plugin' );
		add_filter( 'mce_buttons', 'tp_slider_register_mce_button' );
	}
}
add_action('admin_head', 'tp_slider_mce_button');

// Declare script for new button
function tp_slider_tinymce_plugin( $plugin_array ) {
	$plugin_array['tp_slider_button'] = plugins_url('js/mce-button.js', __FILE__);
	return $plugin_array;
}

// Register new button in the editor
function tp_slider_register_mce_button( $buttons ) {
	array_push( $buttons, 'tp_slider_button' );
	return $buttons;
}

//Tinymc css load functions

function tp_slider_mce_css() {
	wp_enqueue_style('tp_shortcode_extra', plugins_url('/inc/tp-mce-style.css', __FILE__) );
}
add_action( 'admin_enqueue_scripts', 'tp_slider_mce_css' );


//includes files
include_once('inc/tp-custom.php');

//filter files
add_filter('widget_text', 'do_shortcode');

add_theme_support( 'post-thumbnails', array( 'post', 'tp-slider-items' ) );
add_image_size( 'slider-thumb', 1024, 450, true );

function tp_custom_slider_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'tp_custom_slider_excerpt_length', 999 );

/* Add Plugin Loop Code */
function tp_carousel_slider_shortcode($atts){
	extract( shortcode_atts( array(
		'id' => 'demo',
		'count' => '8',
		'navigation' => 'false',
		'autoplay' => 'true',
		'post_type' => 'tp-slider-items',
		'post_category' => '',
		'custom_category' => '',
		'effect' => 'fade',
		'pagination' => 'true',
		'contentstyle' => 'block'
	), $atts, 'projects' ) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => $post_type, 'tpslider_cat' => $custom_category, 'category_name' => $post_category, )
        );		

	$list = '
	<style type="text/css">
    div.owl-carousel .item img{
        display: block;
        width: 100%;
        height: auto;
    }
	</style>
	<script type="text/javascript">
		jQuery(document).ready(function() {
		  var owl = jQuery("#tpslider'.$id.'"); 
				  owl.owlCarousel({
					navigation : '.$navigation.',
					singleItem : true,
					autoPlay : '.$autoplay.',					
					pagination : '.$pagination.',
					navigationText: ["",""],	
					theme: "tp-slider-css",					
					transitionStyle : "'.$effect.'"
				  });	
		}); 
	</script>

	<div id="tpslider'.$id.'" class="owl-carousel">'; 
		while($q->have_posts()) : $q->the_post();
			$idd = get_the_ID();
			$img= get_the_post_thumbnail( $post->ID, 'slider-thumb');
			$list .= '
				<div class="item">'.$img.'
					<div class="tp_slider_up" style="display:'.$contentstyle.';">
						<div class="tp_slider_inner">							
							<h1>'.get_the_title().'</h1>
							<p>'.get_the_excerpt().'</p>			
							<div class="tp_read_more"><a href="'.get_the_permalink().'">Read More</a></div>	
							<div class="tp_slider_opacity"></div>							
						</div>					
					</div>
				</div>
				';        
		endwhile;
		$list.= '</div>';
		wp_reset_query();
		return $list;
}
add_shortcode('tp_slider', 'tp_carousel_slider_shortcode');	


?>