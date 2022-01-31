<?php

/* REGISTER post_type hk_quick */

add_action('init', 'hk_quick_init');
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
			'rewrite' => array('slug' => 'quick'),
			'capability_type' => 'page',
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
//add_shortcode( 'mellanstartsida', 'hk_view_quick_links' );

function hk_view_quick_links() {
	global $cat, $tag, $default_settings;
	$retValue = '';
	/* don't show anything if not in category */
	if ($cat == "") return;
	if ($tag != "" && strpos($tag, 'is_') === false) return;
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
		//$retValue .= "<style type='text/css'>.main.hk-quick { max-width: 1138px; }</style>";
		$retValue .= "<div class='quick-posts-wrapper'>";
		$retValue .= "<div class='quick-posts'>";
		$a_class = "q";

		// The Loop
		while ($the_query->have_posts()) : $the_query->the_post();
			$retValue .= "<!-- BEGIN WHILE QUICK POST " . get_the_ID() . "-->";
			if (empty(get_field('hk_quick_show_articles'))) {
				$default_settings["show_articles"] = false;
			}
			//$retValue .= wp_get_attachment_link($attachId);
			$title = get_the_title();
			$row_width = 0;

			if (get_field('hk_quick_link')) :
				while (has_sub_field('hk_quick_link')) :
					if(get_row_layout() == "lagg_till_rekai"):
						if (!get_sub_field('inactive')) :

							/* get layout */
							$layout = get_sub_field('layout');
							switch($layout) {
								case 'one-whole': $row_width += 100; break;
								case 'one-half':
								case 'two-quarters': $row_width += 50; break;
								case 'one-third': $row_width += 33; break;
								case 'two-thirds': $row_width += 67; break;
								case 'one-quarter': $row_width += 25; break;
								case 'three-quarters': $row_width += 75; break;
								case 'one-fifth': $row_width += 20; break;
								case 'two-fifths': $row_width += 40; break;
								case 'three-fifths': $row_width += 60; break;
								case 'four-fifths': $row_width += 80; break;
							}

							$retValue .= "<div class='quick-post $layout quick-rekai'><div>";

							/* rekai */
							$css_wrapper = get_sub_field('css-wrapper');
							$category = get_term(get_query_var("cat"), 'category');
							$category_slug = ($category && !is_wp_error( $category )) ? $category->slug : "";
							$retValue .= "<style>$css_wrapper</style>";
							$title = get_sub_field('title');
							if (!empty($title)) {
								$retValue .= "<h2>$title</h2>";
							}

							$retValue .= "<div class='rek-prediction' data-renderstyle='list' data-listcols='1' data-addstripes='false' data-nrofhits='7' data-pagetype='$category_slug' data-notpagetype='NewsArticle'></div>";


							$retValue .= "</div></div>";
						endif; // if not inactive

					elseif(get_row_layout() == "lagg_till_news"):
						if (!get_sub_field('inactive')) :

							/* get layout */
							$layout = get_sub_field('layout');
							switch($layout) {
								case 'one-whole': $row_width += 100; break;
								case 'one-half':
								case 'two-quarters': $row_width += 50; break;
								case 'one-third': $row_width += 33; break;
								case 'two-thirds': $row_width += 67; break;
								case 'one-quarter': $row_width += 25; break;
								case 'three-quarters': $row_width += 75; break;
								case 'one-fifth': $row_width += 20; break;
								case 'two-fifths': $row_width += 40; break;
								case 'three-fifths': $row_width += 60; break;
								case 'four-fifths': $row_width += 80; break;
							}

							$retValue .= "<div class='quick-post $layout quick-news'><div>";

							/* NEWS */
							$css_wrapper = get_sub_field('css-wrapper');

							$quick_news_args =
								array("title" => "Nyheter",
											"num_aktuellt" => 5,
											"num_news" => 10,
											"content_type" => "",
											"rss_link_text" => "<span class='rss-icon'></span> RSS",
											"rss_link_url" => "/feed/?tag=nyheter",
											"thumb_size" => "",
											"css_wrapper" => $css_wrapper,
											"num_news_cols" => 5);
								$retValue .= "<!-- FÖRE NYHETER -->";
								$retValue .= get_quick_news( $quick_news_args );
								$retValue .= "<!-- EFTER NYHETER -->";

								/* reset data to current query */
								$the_query->reset_postdata();

							/* END NEWS */
							$retValue .= "</div></div>";
						endif; // if not inactive

					elseif(get_row_layout() == "lagg_till_code"):
						if (!get_sub_field('inactive')) :

							/* get layout */
							$layout = get_sub_field('layout');
							switch($layout) {
								case 'one-whole': $row_width += 100; break;
								case 'one-half':
								case 'two-quarters': $row_width += 50; break;
								case 'one-third': $row_width += 33; break;
								case 'two-thirds': $row_width += 67; break;
								case 'one-quarter': $row_width += 25; break;
								case 'three-quarters': $row_width += 75; break;
								case 'one-fifth': $row_width += 20; break;
								case 'two-fifths': $row_width += 40; break;
								case 'three-fifths': $row_width += 60; break;
								case 'four-fifths': $row_width += 80; break;
							}

							$retValue .= "<div class='quick-post $layout quick-code'><div>";
							$retValue .= get_sub_field('code');
							$retValue .= "</div></div>";
						endif; // if not inactive


					elseif(get_row_layout() == "lagg_till_puff"):
						if (!get_sub_field('inactive')) :
							/* get video */
							$videourl = get_sub_field('video');
							$videoimageoverlay = "";
							/* get css */
							$videocssclass = "";
							if (!empty($videourl)) {
								$videocssclass = "js-video-popup";
								$videourl = "data-video-url='$videourl'";
								$videoimagesrc = $default_settings["video_thumbnail_image"];

								if (!empty($videoimagesrc)) {
									$videoimageoverlay = "<img class='overlay-img slide' src='$videoimagesrc' alt='Play' title='Play'>";
								}
							}
							$cssclass = get_sub_field('css-class');

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
								$imagediv .= "<span class='$videocssclass $imagesize slide' $videourl>";
								$imagediv .= $videoimageoverlay;
								$imagediv .= "<img src='$src' alt='$alt' title='$alt' />";
								$imagediv .= "</span>";
							else : /* else default thumb; */
								/*$options = get_option("hk_theme");
								$src = $options["default_thumbnail_image"];
								if (!empty($src)) :
									$imagediv .= "<div class='img-wrapper '><div><img class='slide' src='$src' alt=''></div></div>";
								endif;*/
							endif;

							/* get description */
							$title = get_sub_field('title');
							if (!empty($title)) {
								$title = "<h2>$title</h2>";
							}
							$button = get_sub_field('button');
							$description = get_sub_field('description');
							$description_div = "";
							if (!empty($description)) {
								$description_div = "<div class='q-description'>$description</div>";
							}

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
							switch($layout) {
								case 'one-whole': $row_width += 100; break;
								case 'one-half':
								case 'two-quarters': $row_width += 50; break;
								case 'one-third': $row_width += 33; break;
								case 'two-thirds': $row_width += 67; break;
								case 'one-quarter': $row_width += 25; break;
								case 'three-quarters': $row_width += 75; break;
								case 'one-fifth': $row_width += 20; break;
								case 'two-fifths': $row_width += 40; break;
								case 'three-fifths': $row_width += 60; break;
								case 'four-fifths': $row_width += 80; break;
							}

							/* get target */
							$target = get_sub_field('target');

							if (!empty($target) && $target != "top") {
								$target = "target='_$target'";
							}
							else {
								$target = "";
							}

							/* get link to content */
							if (get_sub_field('content')) :
								while (has_sub_field('content')) :

									$retValue .= "<div class='quick-post  $imagesize  $layout  $cssclass quick-puff'><div style='$style'>";
									if ( get_row_layout() == 'inlagg' ) {
										$value = get_sub_field('post');
										$url = get_permalink($value->ID);
									}
									elseif ( get_row_layout() == 'extern' ) {
										// prepend http:// if not there already
										$url = get_sub_field('extern');
										if ((substr_compare($url, '/', 0, 1) != 0) && (substr_compare($url, 'http', 0, 4) != 0)) {
											$url = 'https://' . $url;
										}
									}
									elseif ( get_row_layout() == 'fil' ) {
										$value = get_sub_field('file');
										if (!empty($value)) {
											if (empty($description)) {
												$description = $value["description"];
											}
											$url = $value["url"];
										}
									}

									if (!empty($button) && !empty($imagediv)) {
										$button = "<a class='gtm-quick-button quick-button $videocssclass' href='$url' title='$button'>$button</a>";
									}
									else {
										$button = "";
									}

									$retValue .= "<a $target style='$text_align $text_color' class='gtm-quick-link $a_class $a_class-post' href='$url' title='$description'>$imagediv$title$description_div$button</a>";

									$retValue .= "</div></div>";

								endwhile;
							else :
								$retValue .= "<div class='quick-post $imagesize $layout  $cssclass'><div style='$style'>$imagediv$title$description_div$button</div></div>";
							endif; // end if content

						endif; // end if not inactive
					endif; // end row layout lagg_till_code

					// add row break
					if ($row_width > 90) {
						$row_width = 0;
						$retValue .= "<div class='quick-post line-break'></div>";
					}
				endwhile;
			endif; // end if quick links
			$retValue .= "<!-- END WHILE QUICK POST " . get_the_ID() . "-->";

		endwhile; // end while have_posts

		// Reset Post Data
		wp_reset_postdata();

		$retValue .= "</div></div>";

		return $retValue;
	}

}


function get_quick_news( $args ) {
	global $thumb_size;
	global $default_settings;

	$options = get_option('hk_theme');
	if (isset($args["title"])) $title = "<h2 class='widget-title'>" . $args["title"] . "</h2>";
	else $title = "";
	if (isset($args["num_aktuellt"])) $num_aktuellt = $args["num_aktuellt"];
	else $num_aktuellt = 4;
	if (isset($args["num_news"])) $num_news = $args["num_news"];
	else $num_news = 10;
	if (isset($args["content_type"])) $content_type = $args["content_type"];
	else $content_type = "";
	if (isset($args["rss_link_text"])) $rss_link_text = $args["rss_link_text"];
	else $rss_link_text = "";
	if (isset($args["rss_link_url"])) $rss_link_url = $args["rss_link_url"];
	else $rss_link_url = "";
	if (isset($args["thumb_size"])) $thumb_size = $args["thumb_size"];
	else $thumb_size = "";
	if (isset($args["css_wrapper"])) $css_wrapper = $args["css_wrapper"];
	else $css_wrapper = "";
	if (isset($args["num_news_cols"])) $num_news_cols = $args["num_news_cols"];
	else $num_news_cols = "";
	$boxclass = "box-list cols-$num_news_cols ";

	/* get all sub categories to use in queries */
	$cat = get_query_var("cat");
	$all_categories = hk_getChildrenIdArray($cat);
	$all_categories[] = $cat;


	$retString = '<div class="newscontent-wrapper" role="main" style="'.$css_wrapper.'">';
	$retString .= $title;
	$retString .= '<div id="newscontent" class="' . $boxclass . 'newscontent">';

	/* Query all posts with selected startpage category */
	$cat = get_query_var("cat");
	$query = array( 'posts_per_page' => $num_aktuellt,
					'category__and' => $cat,
					'tag__and' => $default_settings["news_tag"],
					'suppress_filters' => 'true',
					'orderby' => 'date',
					'order' => 'desc' );

	$quick_new_loop = new WP_Query( $query );

	$shownposts = array();
	$countrows = 0;
	if ( $quick_new_loop->have_posts() ) :

	 	while ( $quick_new_loop->have_posts() ) :
			$quick_new_loop->the_post();
			$shownposts[] = get_the_ID();
			$retString .= "<!-- " . get_the_ID() . " -->";
			//get_template_part( 'content', 'news' );
			$retString .= load_content_news();

			if (++$countrows%$num_news_cols == 0) {
					$retString .= "<div style='clear:both' class='one-whole'></div>";
			}
		endwhile;
		//$quick_new_loop->reset_postdata();
	endif;
	// Reset Query

	//wp_reset_query();
	//wp_reset_postdata();
	//rewind_posts();



	$hiddenclass = "";
	$after_newslist = "";
	$after_newslist2 = "";

	$after_newslist .= '<span class="read-more-link inline"><a class="gtm-fpcw-news-archive-link" href="' . get_tag_link($default_settings["news_tag"]) . '">Nyhetsarkiv<span class="right-icon"></span></a></span>';

	if ($rss_link_url != "" && $rss_link_text != "") {
		$after_newslist .= "<a href='$rss_link_url' class='gtm-fpcw-rss-link read-more-link rss inline float--right'>$rss_link_text</a>";
	}

	$retString .= $after_newslist;


	$retString .= "</div><!-- END #newscontent --></div><!-- END .newscontent-wrapper -->";

	return $retString;
}

function load_content_news() {

 $thumb_size = 'featured-image';

 	$retString = "<article id='post-" . get_the_ID() . "' class='" . join( ' ', get_post_class() ) . " " . ((is_sticky())?"sticky news summary":"news summary") . "'>";
	$retString .= '<div class="article-border-wrapper"><div class="article-wrapper">';
	$retString .= '<div class="content-wrapper"><div class="summary-content">';

		$hk_featured_repeater = get_field('hk_featured_images', get_the_ID());
		if (!empty($hk_featured_repeater) && !empty($hk_featured_repeater[0])
		&& !empty($hk_featured_repeater[0]["hk_featured_image"])
		&& !empty($hk_featured_repeater[0]["hk_featured_image"]["sizes"])
		&& !empty($hk_featured_repeater[0]["hk_featured_image"]["sizes"])
		&& !empty($hk_featured_repeater[0]["hk_featured_image"]["sizes"]["featured-image"]) ) {

			$src = $hk_featured_repeater[0]["hk_featured_image"]["sizes"]["featured-image"];
			$alt = $hk_featured_repeater[0]["hk_featured_image"]["alt"];
			$retString .=  "<img src='$src' alt='$alt' />";
		} else {
			$options = get_option("hk_theme");
			$src = $options["default_thumbnail_image"];
			if (!empty($src)) {
				$retString .=  "<img src='$src' alt='' />";
			}
		}

				 $externalclass = "";
				 $jstoggle = " js-toggle-article";
				 if (function_exists("get_field")) {
					 $href = get_field('hk_external_link_url');
					 $name = get_field('hk_external_link_name');
					 if (!empty($href))
					 {
						 $jstoggle = "";
						 $externalclass = " js-external-link";
						 $title = "Extern länk till " . the_title_attribute( 'echo=0' );
					 }
				 }
				 if (empty($href)) {
					 $href = get_permalink();
					 $title = "Länk till " . the_title_attribute( 'echo=0' );
				 }
				 $externalclass = "class='gtm-cn-news-link$externalclass$jstoggle'";


				 $retString .= '<div class="content-text-wrapper">';
				 $retString .= "<h5 class='entry-title'><a $externalclass href='$href' title='$title' rel='bookmark'>" . get_the_title() . "</a></h5>";
				 // if news
				 if (!empty($default_settings["news_tag"]) && has_tag($default_settings["news_tag"])) {
					 $retString .= "<time>" . get_the_date("Y-m-d") . "</time> ";
				 }
				 $retString .= '<div class="entry-content">';
				 $retString .= get_the_excerpt();
				 if (!empty($href) && !empty($name))
				 {
					 $retString .= "<a class='gtm-cn-news-button button' href='$href' title='$name'>$name</a>";
				 }

				 //$retString .= "</div></div>";

				 $retString .= "</div><!-- .summary-content --></div><!-- .content-wrapper -->";

			 $retString .= "<span class='hidden article_id'>" . get_the_ID() . "</span>";
		 $retString .= "</div></div></article><!-- #post-" . get_the_ID() . " -->";

		 return $retString;
}
?>
