<?php

/**
 * Description: Add related post_type and related widget showing attachment and hk_related posts from visited category. 
 * Create an ACF with these fields.
 *  1. Name hk_related_post_link with Type "Page Link" and Post Type "Post"
 *  2. Name hk_related_link_url with Type Text
 * And location rules Post Type is equal to hk_related
 **/



/* REGISTER post_type hk_related */

add_action('init', hk_related_init);
function hk_related_init() {
	// only if in admin and is administrator
    //if (is_admin() && current_user_can("administrator")) {

		register_post_type( 'hk_related',
			array(
				'labels' => array(
					'name' => __( 'Hitta snabbt' ),
					'singular_name' => __( 'Hitta snabbt' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'related')
			)
		);
		add_post_type_support( "hk_related", array("title","revisions") );
		remove_post_type_support( "hk_related", "editor" );

		register_taxonomy_for_object_type( "category", "hk_related" );
	//}
}

// generates the output of the content to the widget
function hk_related_output($wrapping_li = true, $the_cat = "", $a_class = "") {

	if (!function_exists("get_field"))
		return "You need to install ACF to get this widget to work, read more in readme.txt.";

	$retValue = "";

	if ($the_cat == "")
		$cat = get_query_var("cat");
	else
		$cat = $the_cat;
 	
 	$category_in = array($cat);


 	// return current page related content if in_single
	/* only return related if in category */ 
	if (empty($category_in))
		return "";


	$args = array(
			'post_type' => array('hk_related'),
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
			if ($wrapping_li) {
				$retValue .= "<li class='related-menu menu-item'><a class='' title='Hitta snabbt' href='#'>Hitta snabbt<span class='dropdown-icon'></span></a>";
			}
			$retValue .= "<ul class='hk_related sub-menu'>";
			// The Loop
       		while ($the_query->have_posts()) : $the_query->the_post();
	      		//$retValue .= wp_get_attachment_link($attachId); 
		    	$title = get_the_title();
				if (get_field('hk_related')) :
					while (has_sub_field('hk_related')) : 
						if ( get_row_layout() == 'hk_related_posts' ) : 
							$retValue .= "<li class='related_page'>";
							$value = get_sub_field('hk_related_post');
							$retValue .= "<a class='$a_class $a_class-post' href='" . get_permalink($value->ID) . "'";
							$retValue .= " title='" . get_sub_field('hk_related_post_description') . "'>" . $value->post_title . "</a>";
							$retValue .= "</li>";
						elseif ( get_row_layout() == 'hk_related_links' ) : 
							$retValue .= "<li class='related_link'>";
							// prepend http:// if not there already
							$relate_link_url = get_sub_field('hk_relate_link_url');
							if ($relate_link_url != "" && substr_compare($relate_link_url, 'http', 0, 4) != 0) {
								$relate_link_url = 'http://' . $relate_link_url;
							}
							$retValue .= "<a class='$a_class $a_class-link'  target='_blank'";
							$retValue .= " href='" . $relate_link_url . "' title='" . get_sub_field('hk_related_link_description') . "'>" . get_sub_field('hk_related_link_name') . "</a>";
							$retValue .= "</li>";
						elseif ( get_row_layout() == 'hk_related_files' ) :
							$link =  wp_get_attachment_url(get_sub_field('hk_related_file')); 
							$link_name = get_the_title(get_sub_field('hk_related_file'));
							$retValue .= "<li class='related_file'>";
							$retValue .= "<a class='$a_class $a_class-file'  target='_blank'";
							$retValue .= " href='" . $link . "' title='" . get_sub_field('hk_related_file_description') . "'>" . $link_name . "</a>";
							$retValue .= "</li>";
						endif;

			 		endwhile;
		 		endif;
        	endwhile;

        	// Reset Post Data
        	wp_reset_postdata();
			$retValue .= "</ul>";
			if ($wrapping_li) {
				$retValue .= "</li>";
			}
		}
	}

	return $retValue;

}



?>