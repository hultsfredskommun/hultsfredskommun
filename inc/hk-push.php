<?php

/**
 * Description: Add push post_type and push widget showing attachment and hk_push posts from visited category. 
 * Create an ACF with these fields.
 *  1. Name hk_push_post_link with Type "Page Link" and Post Type "Post"
 *  2. Name hk_push_link_url with Type Text
 * And location rules Post Type is equal to hk_push
 **/


/* WIDGET */
class Hk_push extends WP_Widget {

        public function __construct() {
		parent::__construct(
	 		'hk_push', // Base ID
			'Hk_push', // Name
			array( 'description' => __( 'push Widget to display push from selected category', 'text_domain' ), ) // Args
		);
	}

 	public function form( $instance ) {

	}

	public function update( $new_instance, $old_instance ) {
		return $old_instance;
	}

	public function widget( $args, $instance ) {
	       	extract( $args );
			echo hk_push_output();
	}

}

add_action( 'widgets_init', create_function( '', 'register_widget( "Hk_push" );' ) );





/* REGISTER post_type hk_push */

add_action('init', hk_push_init);
function hk_push_init() {
	// only if in admin and is administrator
    //if (is_admin() && current_user_can("administrator")) {

		register_post_type( 'hk_push',
			array(
				'labels' => array(
					'name' => __( 'Kategoripuffar' ),
					'singular_name' => __( 'Kategoripuff' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'push')
			)
		);
		add_post_type_support( "hk_push", array("title","revisions") );
		remove_post_type_support( "hk_push", "editor" );

		register_taxonomy_for_object_type( "category", "hk_push" );
	//}
}

// generates the output of the content to the widget
function hk_push_output() {

	if (!function_exists("get_field"))
		return "You need to install ACF to get this widget to work, read more in readme.txt.";

	$retValue = "";

	$cat = get_query_var("cat");
 	
 	$category_in = array($cat);


 	// return current page push content if in_single
	/* only return push if in category */ 
	if (empty($category_in))
		return "";


	$args = array(
			'post_type' => array('hk_push'),
			'post_status' => 'publish',
			'category__in' => $category_in,
			'suppress_filters' => 1
			);
	
 	if ($args != "")
  	{
		// search in all posts (ignore filters)
       	$the_query = new WP_Query( $args );
		if ($the_query->have_posts())
		{ 
			$retValue .= "<ul class='hk_push sub-menu'>";
			// The Loop
       		while ($the_query->have_posts()) : $the_query->the_post();
	      		//$retValue .= wp_get_attachment_link($attachId); 
		    	$title = get_the_title();
				if (get_field('hk_push')) :
					while (has_sub_field('hk_push')) : 
						if ( get_row_layout() == 'hk_push_posts' ) : 
							$retValue .= "<li class='push_page'>";
							$value = get_sub_field('hk_push_post');
							$retValue .= "<a href='" . get_permalink($value->ID) . "'";
							$retValue .= " title='" . get_sub_field('hk_push_post_description') . "'>" . $value->post_title . "</a>";
							$retValue .= "</li>";		 
						elseif ( get_row_layout() == 'hk_push_links' ) : 
							$retValue .= "<li class='push_link'>";
							// prepend http:// if not there already
							$relate_link_url = get_sub_field('hk_relate_link_url');
							if (substr_compare($relate_link_url, 'http', 0, 4) != 0) {
								$relate_link_url = 'http://' . $relate_link_url;
							}
							$retValue .= "<a target='_blank'";
							$retValue .= " href='" . $relate_link_url . "' title='" . get_sub_field('hk_push_link_description') . "'>" . get_sub_field('hk_push_link_name') . "</a>";
							$retValue .= "</li>";
						elseif ( get_row_layout() == 'hk_push_files' ) :
							$link =  wp_get_attachment_url(get_sub_field('hk_push_file')); 
							$link_name = get_the_title(get_sub_field('hk_push_file'));
							$retValue .= "<li class='push_file'>";
							$retValue .= "<a target='_blank'";
							$retValue .= " href='" . $link . "' title='" . get_sub_field('hk_push_file_description') . "'>" . $link_name . "</a>";
							$retValue .= "</li>";
						endif;

			 		endwhile;
		 		endif;
        	endwhile;

        	// Reset Post Data
        	wp_reset_postdata();
			$retValue .= "</ul>";
		}
	}

	return $retValue;

}



?>