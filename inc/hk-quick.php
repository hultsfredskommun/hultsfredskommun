<?php
	
/* REGISTER post_type hk_quick */

add_action('init', hk_quick_init);
function hk_quick_init() {
	// only if in admin and is administrator
	register_post_type( 'hk_quick',
		array(
			'labels' => array(
				'name' => __( 'Mellanstartsida' ),
				'singular_name' => __( 'Mellanstartsida' )
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
	/* don't show anything if not in category */
	if ($cat == "") return;
	
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
			if (get_field('hk_quick_link')) :
				while (has_sub_field('hk_quick_link')) : 
				
					/* get image */
					$imagediv = "";
					$image = get_sub_field('image');
					$imagesize = get_sub_field('image-size');
					if ($imagesize == "") {
						$imagesize = "thumbnail-image";
					}
					if ($image != "") :
						if (!empty($image["sizes"][$imagesize])) {
							$src = $image["sizes"][$imagesize];
						}
						else {
							$src = $image["sizes"]["thumbnail-image"];
						}
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

					/* get description */
					$title = get_sub_field('title');
					if (!empty($title)) {
						$title = "<h2>$title</h2>";
					}
					$description = get_sub_field('description');

					/* get layout */
					$layout = get_sub_field('layout');


					/* get link to content */
					if (get_sub_field('content')) :
						while (has_sub_field('content')) : 

							if ( get_row_layout() == 'inlagg' ) : 
								$retValue .= "<div class='quick-post  $layout'>";
								$value = get_sub_field('post');
								$retValue .= "<a class='$a_class $a_class-post' href='" . get_permalink($value->ID) . "'";
								$retValue .= " title='" . $description . "'>";
								$retValue .= $imagediv;
								$retValue .= $title . $description . "</a>";
								$retValue .= "</div>";
							elseif ( get_row_layout() == 'extern' ) : 
								$retValue .= "<div class='quick-post  $layout'>";
								// prepend http:// if not there already
								$quick_link_url = get_sub_field('extern');
								if (substr_compare($quick_link_url, 'http', 0, 4) != 0) {
									$quick_link_url = 'http://' . $quick_link_url;
								}
								$retValue .= "<a class='$a_class $a_class-link'  target='_blank'";
								$retValue .= " href='" . $quick_link_url . "' title='" . $description . "'>";
								$retValue .= $imagediv;
								$retValue .= $title . $description . "</a>";
								$retValue .= "</div>";
							elseif ( get_row_layout() == 'fil' ) :
								$link =  wp_get_attachment_url(get_sub_field('file')); 
								$retValue .= "<div class='quick-post  $layout'>";
								$retValue .= "<a class='$a_class $a_class-file'  target='_blank'";
								$retValue .= " href='" . $link . "' title='" . $description . "'>";
								$retValue .= $imagediv;
								$retValue .= $title . $description . "</a>";
								$retValue .= "</div>";
							endif;

						endwhile;
					else :
						$retValue .= "<div class='quick-post  $layout'>";
						$retValue .= $imagediv;
						$retValue .= $title . $description;
						$retValue .= "</div>";
					endif; // end if content

				endwhile;
			endif; // end if quick links
			
		endwhile; // end while have_posts

		// Reset Post Data
		wp_reset_postdata();
		
		$retValue .= "</div></div>";
		
		return $retValue;
	}

}
?>