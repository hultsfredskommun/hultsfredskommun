<?php

/**
 * Description: Add related post_type and related widget showing attachment and hk_related posts from visited category. 
 * Create an ACF with these fields.
 *  1. Name hk_related_post_link with Type "Page Link" and Post Type "Post"
 *  2. Name hk_related_link_url with Type Text
 *  3. Name hk_related_description with Type Wysiwyg Editor
 * And location rules Post Type is equal to hk_related
 **/


/* WIDGET */
class Hk_Related extends WP_Widget {

        public function __construct() {
		parent::__construct(
	 		'hk_Related', // Base ID
			'Hk_related', // Name
			array( 'description' => __( 'Related Widget to display Related from selected category', 'text_domain' ), ) // Args
		);
	}

 	public function form( $instance ) {

	}

	public function update( $new_instance, $old_instance ) {
		return $old_instance;
	}

	public function widget( $args, $instance ) {
	       	extract( $args );
			echo hk_Related_generate_cache();
	}

}

add_action( 'widgets_init', create_function( '', 'register_widget( "Hk_Related" );' ) );





/* REGISTER post_type hk_related */

add_action('init', hk_related_init);
function hk_related_init() {

	register_post_type( 'hk_related',
		array(
			'labels' => array(
				'name' => __( 'Relaterade' ),
				'singular_name' => __( 'Relaterad' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'related')
		)
	);
	add_post_type_support( "hk_related", array("title","author","revisions") );

	register_taxonomy_for_object_type( "category", "hk_related" );
}

// generates the output of the content to the widget
function hk_related_generate_cache() {

	if (!function_exists("get_field"))
		return "You need to install ACF and create the fields found in readme.txt to get this widget to work.";

	$retValue = "";

	$cat = get_query_var("cat");
 	
 	$category_in = array($cat);

	/* only return related if in category */ 
	if (empty($category_in))
		return "";


	$args = array(
			'post_type' => array('attachment', 'hk_related'),
			'post_status'=>'all',
			'category__in' => $category_in
			);

	
 	if ($args != "")
  	{
		// search in all posts (ignore filters)
       	$the_query = new WP_Query( $args );

		if ($the_query->have_posts())
		{ 
			$retValue .= "<aside class='widget hk_related'>";
			$retValue .= "<h3 class='widget-title'>Relaterat</h3>";

		    // The Loop
       		while ( $the_query->have_posts() ) : $the_query->the_post();
	      		//$retValue .= wp_get_attachment_link($attachId); 
       			$title = get_the_title();
       			if (get_post_type() == "attachment") {
					$url = wp_get_attachment_url(get_the_ID());
					$ext = substr(strrchr($url, '.'), 1);
				} else if (get_post_type() == "hk_related") {
					$url = get_field("hk_related_post_link");
					$ext = "internal link";
					if ($url == "")
					{
						$url = get_field("hk_related_link_url");
						$ext = "external link";
					}
				}
				if ($url != "") {	
	       			$retValue .= "<div class='related-wrapper'>";
	       			$retValue .= "<div class='icon $ext'>&nbsp;</div>";
					$retValue .= "<div id='related-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
					$retValue .= "<h4><a class='permalink' href='$url' target='_blank'>$title</a></h4>";//<a class='related-link' href='$url' title='$title'>$title</a>";
					$retValue .= "<div class='content'>" . get_the_content() . "</div>";
					$retValue .= "</div></div>";
				}		
				//$retValue .= "<h4>" . get_the_title() . "</h4>";
				//$retValue .= str_replace("\n","<br>",get_the_content());
        	endwhile;

        	// Reset Post Data
        	wp_reset_postdata();
			$retValue .= "</aside>";
		}
	}

	return $retValue;

}



?>