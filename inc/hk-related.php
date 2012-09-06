<?php

/**
 * Description: Add related post_type and related widget showing attachment and hk_related posts from visited category. 
 * Create an ACF with these fields.
 *  1. Name hk_related_post_link with Type "Page Link" and Post Type "Post"
 *  2. Name hk_related_link_url with Type Text
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
	// only if in admin and is administrator
    if (is_admin() && current_user_can("administrator")) {

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
		add_post_type_support( "hk_related", array("title","revisions") );
		remove_post_type_support( "hk_related", "editor" );

		register_taxonomy_for_object_type( "category", "hk_related" );
	}
}

// generates the output of the content to the widget
function hk_related_generate_cache() {

	if (!function_exists("get_field"))
		return "You need to install ACF to get this widget to work, read more in readme.txt.";

	$retValue = "";

	$cat = get_query_var("cat");
 	
 	$category_in = array($cat);


 	// return current page related content if in_single
  	if (is_single())
  	{ 
		if (get_field('hk_related') ) :
			while (has_sub_field('hk_related')) : 
		        $retValue .= "<aside class='widget hk_related'>";
		      	$retValue .= "<h3 class='widget-title'>Relaterat</h3>";
				if (get_row_layout() == 'hk_related_posts') : 
						$ext = "internal link";
						$value = get_sub_field('hk_related_post');
						$retValue .= "<div class='related-wrapper'>";
		       			$retValue .= "<div class='icon $ext'>&nbsp;</div>";
						$retValue .= "<div id='related-" . $value->ID . "' class='" . implode(" ",get_post_class("hk_related")) . "'>";
						$retValue .= "<h4><a class='permalink' href='". $value->guid . "'>" . $value->post_title . "</a></h4>";
						$retValue .= "<div class='content'>" . get_sub_field('hk_related_post_description') . "</div>";
						$retValue .= "</div></div>";
				elseif (get_row_layout() == 'hk_related_links') : 
						$ext = "external link";
						$retValue .= "<div class='related-wrapper'>";
		       			$retValue .= "<div class='icon $ext'>&nbsp;</div>";
						$retValue .= "<div class='" . implode(" ",get_post_class("hk_related")) . "'>";
						$retValue .= "<h4><a class='permalink' href='". get_sub_field('hk_related_link_url') . "'>" . get_sub_field('hk_related_link_name'). "</a></h4>";
						$retValue .= "<div class='content'>" . get_sub_field('hk_related_link_description') . "</div>";
						$retValue .= "</div></div>";
				elseif (get_row_layout() == 'hk_related_files') :
						$ext = "external link";
						$retValue .= "<div class='related-wrapper'>";
		       			$retValue .= "<div class='icon $ext'>&nbsp;</div>";
						$link = wp_get_attachment_link(get_sub_field('hk_related_file'));
						$retValue .= "<div class='" . implode(" ",get_post_class("hk_related")) . "'>";
						$retValue .= str_replace("<a ", "<a class='permalink' ", $link);
						$retValue .= "<div class='content'>" . get_sub_field('hk_related_file_description') . "</div>";
						$retValue .= "</div></div>";
				endif; 

				$retValue .= "</aside>";
			endwhile;
		endif;
		echo $retValue;	
		return;
	}


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
       		while ($the_query->have_posts()) : $the_query->the_post();
	      		//$retValue .= wp_get_attachment_link($attachId); 
       			$title = get_the_title();
				if (get_field('hk_related')) :

					while (has_sub_field('hk_related')) : 
						if (get_row_layout() == 'hk_related_posts') : 
								$ext = "internal link";
								$value = get_sub_field('hk_related_post');
								$retValue .= "<div class='related-wrapper'>";
				       			$retValue .= "<div class='icon $ext'>&nbsp;</div>";
								$retValue .= "<div id='related-" . $value->ID . "' class='" . implode(" ",get_post_class("hk_related")) . "'>";
								$retValue .= "<h4><a class='permalink' href='". $value->guid . "'>" . $value->post_title . "</a></h4>";
								$retValue .= "<div class='content'>" . get_sub_field('hk_related_post_description') . "</div>";
								$retValue .= "</div></div>";
						elseif (get_row_layout() == 'hk_related_links') : 
								$ext = "external link";
								$retValue .= "<div class='related-wrapper'>";
				       			$retValue .= "<div class='icon $ext'>&nbsp;</div>";
								$retValue .= "<div class='" . implode(" ",get_post_class("hk_related")) . "'>";
								$retValue .= "<h4><a class='permalink' href='". get_sub_field('hk_related_link_url') . "'>" . get_sub_field('hk_related_link_name'). "</a></h4>";
								$retValue .= "<div class='content'>" . get_sub_field('hk_related_link_description') . "</div>";
								$retValue .= "</div></div>";
						elseif (get_row_layout() == 'hk_related_files') :
								$ext = "external link";
								$retValue .= "<div class='related-wrapper'>";
				       			$retValue .= "<div class='icon $ext'>&nbsp;</div>";
								$link = wp_get_attachment_link(get_sub_field('hk_related_file'));
								$retValue .= "<div class='" . implode(" ",get_post_class("hk_related")) . "'>";
								$retValue .= str_replace("<a ", "<a class='permalink' ", $link);
								$retValue .= "<div class='content'>" . get_sub_field('hk_related_file_description') . "</div>";
								$retValue .= "</div></div>";
						endif; 
			 		endwhile;
		 		endif;
        	endwhile;

        	// Reset Post Data
        	wp_reset_postdata();
			$retValue .= "</aside>";
		}
	}

	return $retValue;

}



?>