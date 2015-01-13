<?php

/* REGISTER post_type hk_quick */

add_action('init', hk_quick_init);
function hk_quick_init() {
	// only if in admin and is administrator
	register_post_type( 'hk_quick',
		array(
			'labels' => array(
				'name' => __( 'Ing&aring;ngsl&auml;nkar' ),
				'singular_name' => __( 'Ing&aring;ngsl&auml;nk' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'quick')
		)
	);
	add_post_type_support( "hk_quick", array("title","revisions") );
	remove_post_type_support( "hk_quick", "editor" );

	register_taxonomy_for_object_type( "category", "hk_quick" );

}


function hk_view_quick_links() {
	global $cat;
	$args = array(
			'post_type' => array('hk_quick'),
			'post_status' => 'publish',
			'category__in' => $cat,
			'suppress_filters' => 1
			);
	
	// search in all posts (ignore filters)
	$the_query = new WP_Query( $args );
	if ($the_query->have_posts())
	{ 
		$retValue .= "<div class='quick-posts-wrapper'>";
		$retValue .= "<div class='quick-posts'>";
		$a_class = "q";
		
		// The Loop
		while ($the_query->have_posts()) : $the_query->the_post();
			//$retValue .= wp_get_attachment_link($attachId); 
			$title = get_the_title();
			if (get_field('hk_quick')) :
				while (has_sub_field('hk_quick')) : 
					$imagediv = "";
					$image = get_sub_field('hk_quick_image');
					if ($image != "") :
						$src = $image["sizes"]["thumbnail-image"];
						$alt = $image["alt"];
						$imagediv .= "<div class='slide'>";
						$imagediv .= "<img src='$src' alt='$alt' title='$alt' />";
						$imagediv .= "</div>";
					else : /* else default thumb; */
						$options = get_option("hk_theme");
						$src = $options["default_thumbnail_image"]; 
						if (!empty($src)) :
						$imagediv .= "<div class='img-wrapper '><div><img class='slide' src='$src' alt='Standardbild' title='Standardbild'></div></div>";
					endif; endif;

					if ( get_row_layout() == 'hk_quick_posts' ) : 
						$retValue .= "<div class='quick-post'>";
						$value = get_sub_field('hk_quick_post');
						$retValue .= "<a class='$a_class $a_class-post' href='" . get_permalink($value->ID) . "'";
						$retValue .= " title='" . get_sub_field('hk_quick_post_description') . "'>";
						$retValue .= $imagediv;
						$retValue .= $value->post_title . "</a>";
						$retValue .= "</div>";
					elseif ( get_row_layout() == 'hk_quick_links' ) : 
						$retValue .= "<div class='quick-post'>";
						// prepend http:// if not there already
						$quick_link_url = get_sub_field('hk_quick_link_url');
						if (substr_compare($quick_link_url, 'http', 0, 4) != 0) {
							$quick_link_url = 'http://' . $quick_link_url;
						}
						$retValue .= "<a class='$a_class $a_class-link'  target='_blank'";
						$retValue .= " href='" . $quick_link_url . "' title='" . get_sub_field('hk_quick_link_description') . "'>";
						$retValue .= $imagediv;
						$retValue .= get_sub_field('hk_quick_link_name') . "</a>";
						$retValue .= "</div>";
					elseif ( get_row_layout() == 'hk_quick_files' ) :
						$link =  wp_get_attachment_url(get_sub_field('hk_quick_file')); 
						$link_name = get_the_title(get_sub_field('hk_quick_file'));
						$retValue .= "<div class='quick-post'>";
						$retValue .= "<a class='$a_class $a_class-file'  target='_blank'";
						$retValue .= " href='" . $link . "' title='" . get_sub_field('hk_quick_file_description') . "'>";
						$retValue .= $imagediv;
						$retValue .= $link_name . "</a>";
						$retValue .= "</div>";
					endif;

				endwhile;
			endif;
		endwhile;

		// Reset Post Data
		wp_reset_postdata();
		
		$retValue .= "</div></div>";
		
		return $retValue;
	}

}
?>