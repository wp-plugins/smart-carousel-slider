<?php 

// register custom post
add_action( 'init', 'tp_carousel_slider_post_type' );
function tp_carousel_slider_post_type() {
	register_post_type( 'tp-slider-items',
		array(
			'labels' => array(
				'name' => __( 'Smart Sliders' ),
				'singular_name' => __( 'Smart Slider' ),
				'add_new_item' => __( 'Add New Slider' )
			),
			'public' => true,
			'supports' => array('thumbnail', 'title', 'editor'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'slider-items'),
		)
	);	
}

//Register Taxonomy for custom post.
function tp_carousel_slider_taxonomy() {
	register_taxonomy(
		'tpslider_cat',  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
		'tp-slider-items',                  // ur custom post type name
		array(
			'hierarchical'          => true,
			'label'                 => 'Slider Category',  //Display name
			'query_var'             => true,
			'hierarchical'     	 	=> true,
			'show_ui'          	 	=> true,
			'show_admin_column' 	=> true,
			'rewrite'               => array(
				'slug'              => 'slider-category', // This controls the base slug that will display before each term
				'with_front'    => true // Don't display the category base before
				)
			)
	);
}
add_action( 'init', 'tp_carousel_slider_taxonomy');  