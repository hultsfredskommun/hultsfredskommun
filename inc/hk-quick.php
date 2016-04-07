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

// shortcodes
/*
 * shortcode [mellanstartsida], show quick links (mellanstartsida)
 */
add_shortcode( 'mellanstartsida', 'hk_view_quick_links' );

function hk_view_quick_links() {
	global $cat, $default_settings;
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
				
			if (empty(get_field('hk_quick_show_articles'))) {
				$default_settings["show_articles"] = false;
			}
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
						/*$options = get_option("hk_theme");
						$src = $options["default_thumbnail_image"]; 
						if (!empty($src)) :
							$imagediv .= "<div class='img-wrapper '><div><img class='slide' src='$src' alt='Standardbild' title='Standardbild'></div></div>";
						endif;*/ 
					endif;

					/* get description */
					$title = get_sub_field('title');
					if (!empty($title)) {
						$title = "<h2>$title</h2>";
					}
					$button = get_sub_field('button');
					$description = get_sub_field('description');


					/* get style */
					$text_color = get_sub_field('text-color');
					$background_color = get_sub_field('background-color');
					$border_color = get_sub_field('border-color');
					$border_width = get_sub_field('border-width');
					$border_radius = get_sub_field('border-radius');
					$text_align = get_sub_field('text-align');
					$padding = get_sub_field('padding');
					$margin = get_sub_field('margin');
					
					$text_color = ($text_color)?"color: $text_color;":"";
					$background_color = ($background_color)?"background: $background_color;":"";
					$border_color = ($border_color)?"border-color: $border_color;":"";
					$border_width = ($border_width)?"border-style: solid; border-width: ".$border_width.";":"";
					$border_radius = ($border_radius)?"border-radius: ".$border_radius.";":"";
					$text_align = ($text_align)?"text-align: $text_align;":"";
					$padding = ($padding)?"padding: $padding;":"";
					$margin = ($margin)?"margin: $margin;":"";
					$style = "$text_color$background_color$border_color$border_width$border_radius$text_align$padding$margin";

					/* get layout */
					$layout = get_sub_field('layout');
					$target = get_sub_field('target');
					
					if (!empty($target)) {
						$target = "target='_$target'";
					}
					else {
						$target = "";
					}

					/* get link to content */
					if (get_sub_field('content')) :
						while (has_sub_field('content')) : 

							$retValue .= "<div class='quick-post  $layout'><div style='$style'>";
							if ( get_row_layout() == 'inlagg' ) {
								$value = get_sub_field('post');
								$url = get_permalink($value->ID);
							}
							elseif ( get_row_layout() == 'extern' ) {
								// prepend http:// if not there already
								$url = get_sub_field('extern');
								if ((substr_compare($url, '/', 0, 1) != 0) && (substr_compare($url, 'http', 0, 4) != 0)) {
									$url = 'http://' . $url;
								}
							}
							elseif ( get_row_layout() == 'fil' ) {
								$url =  wp_get_attachment_url(get_sub_field('file')); 
							}
							
							if (!empty($button) && !empty($imagediv)) {
								$button = "<a class='gtm-quick-button quick-button' href='$url' title='$button'>$button</a>";
							}
							else {
								$button = "";
							}

							$retValue .= "<a $target style='$text_align $text_color' class='gtm-quick-link $a_class $a_class-post' href='$url' title='$description'>$imagediv$title$description$button</a>";

							$retValue .= "</div></div>";

						endwhile;
					else :
						$retValue .= "<div class='quick-post  $layout'><div style='$style'>$imagediv$title$description$button</div></div>";
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