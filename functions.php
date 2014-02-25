<?php
/**
 * Hultsfredskommun functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 */


/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 584;

/* help variable */	
$s_when_https = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '');
/* get hk_hk_options */
$hk_options = get_option('hk_theme');
	
	
/* SET DEFAULT SETTINGS */
if ( ! isset( $default_settings ) ) {
	$default_settings = array(	'thumbnail-image' => array(270, 153, true),
								'featured-image' => array(532, 311, true), /* array(660, 396, true) */
								'slideshow-image' => array(980, 551, true),
								'wide-image' => array(1138, 326, true),
								'contact-image' => array(150, 190, true),
								'startpage_cat' => $hk_options["startpage_cat"],
								'news_tag' => $hk_options["news_tag"],
								'hidden_cat' => $hk_options["hidden_cat"],
								'protocol_cat' => $hk_options["protocol_cat"],
								'num_levels_in_menu' => (!isset($hk_options["num_levels_in_menu"]) || $hk_options["num_levels_in_menu"] == "")?2:$hk_options["num_levels_in_menu"],
								'show_tags' => (!isset($hk_options["show_tags"]) || $hk_options["show_tags"] == "")?1:$hk_options["show_tags"],
								'allow_cookies' => $_COOKIE['allow_cookies'] || $hk_options["cookie_accept_enable"] == "",
								'allow_google_analytics' => $_COOKIE['allow_cookies'] || $hk_options["cookie_accept_enable"] == "" || $hk_options['google_analytics_disable_if_no_cookies'] != "1",
								'sticky_number' => 1000,
								);
								
	/* browser check */
	$ua = $_SERVER["HTTP_USER_AGENT"];
	$default_settings["msie"] = (strpos($ua, 'MSIE') === true) ? true : false; // All Internet Explorer
	$default_settings["msie_6"] = (strpos($ua, 'MSIE 6.0') === true) ? true : false; // Internet Explorer 6
	$default_settings["msie_7"] = (strpos($ua, 'MSIE 7.0') === true) ? true : false; // Internet Explorer 7
	$default_settings["msie_8"] = (strpos($ua, 'MSIE 8.0') === true) ? true : false; // Internet Explorer 8

}



// Grab hk option page.
require( get_template_directory() . '/inc/hk-option-page.php' );

// Grab hk dynamic widgets
require( get_template_directory() . '/inc/hk-dynamic-widgets.php' );

// Grab hk text widget.
//require( get_template_directory() . '/inc/hk-text-widget.php' );

// Grab hk slideshow.
require( get_template_directory() . '/inc/hk-slideshow.php' );

// Grab hk contacts.
require( get_template_directory() . '/inc/hk-contacts.php' );

// Grab hk related.
require( get_template_directory() . '/inc/hk-related.php' );

// Grab hk push.
//require( get_template_directory() . '/inc/hk-push.php' );

// Grab hk events.
//require( get_template_directory() . '/inc/hk-events.php' );

// Grab hk menu widget.
require( get_template_directory() . '/inc/hk-navigation.php' );

// Grab hk sort-order function
require( get_template_directory() . '/inc/hk-sort-order.php' );

// Grab hk admin-page to alter admin/edit pages
require( get_template_directory() . '/inc/hk-admin-pages.php' );

// Grab cron jobs
require( get_template_directory() . '/inc/hk-cron.php' );

// Grab hk sort-order function
require( get_template_directory() . '/inc/hk-acf-fields.php' );

// Grab hk widgets function containing general widgets
require( get_template_directory() . '/inc/hk-widgets.php' );

// shortcodes
/*
 * shortcode [categorytree], show category tree
 */
function hk_category_tree_func( $atts ){
	global $default_settings;
	$retValue = "";

	// full category tree
	$retValue .= "<div id='categorytree' class='shortcode'>";
	$retValue .= wp_list_categories( 
		array(
			'show_option_all'    => '',
			'style'              => 'list',
			'show_count'         => 1,
			'hide_empty'         => 0,
			'use_desc_for_title' => 1,
			'child_of'           => 0,
			'feed'               => '',
			'feed_type'          => '',
			'feed_image'         => '',
			'exclude'            => $default_settings["hidden_cat"],
			'exclude_tree'       => '',
			'include'            => '',
			'hierarchical'       => 1,
			'title_li'           => '',
			'show_option_none'   => __('No categories'),
			'number'             => null,
			'echo'               => 0,
			'depth'              => 0,
			'current_category'   => 0,
			'pad_counts'         => 0,
			'taxonomy'           => 'category',
			'walker'             => null
	) );
	$retValue .= "</div>";

	return $retValue;
}
add_shortcode( 'categorytree', 'hk_category_tree_func' );


/* 
 * Set startpage to startpage_cat
 */
function hk_pre_get_posts( $query ) {
	global $default_settings, $wp_query;
	$options = get_option("hk_theme");
	$not_in_cat = array();
	$not_in_tag = array();
	$in_tag = array();
    if ( !is_admin() && !empty($default_settings["hidden_cat"]) && $default_settings["hidden_cat"] > 0) {
		$not_in_cat[] = $default_settings["hidden_cat"];
    }
    if ( !is_admin() && !empty($_REQUEST["ignore_cat"]) && $_REQUEST["ignore_cat"] > 0) {
		$not_in_cat[] = $_REQUEST["ignore_cat"];
    }
    if ( !is_admin() && !empty($_REQUEST["ignore_tag"]) && $_REQUEST["ignore_tag"] > 0) {
		$not_in_tag[] = $_REQUEST["ignore_tag"];
    }
    if ( !is_admin() && !empty($_REQUEST["include_tag"]) && $_REQUEST["include_tag"] > 0) {
		$in_tag[] = $_REQUEST["include_tag"];
    }
	if ( !empty($not_in_cat) ) {
		$query->set( 'category__not_in', $not_in_cat);
	}
	if ( !empty($not_in_tag) ) {
		$query->set( 'tag__not_in', $not_in_tag);
	}
	if ( !empty($in_tag) ) {
		$query->set( 'tag__in', $in_tag);
	}
	
	if ($wp_query->is_home()) {
		$cat = $options["startpage_cat"];
		if ($cat != "" && $cat != "0" ) {
			$wp_query->set( 'cat', $cat);
		}
    }
}
add_action( 'pre_get_posts', 'hk_pre_get_posts' );


/**
 * Tell WordPress to run hk_setup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'hk_setup' );

if ( ! function_exists( 'hk_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override hk_setup() in a child theme, add your own hk_setup to your child theme's
 * functions.php file.
 *
 */
function hk_setup() {


	/* Make Twenty Eleven available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Eleven, use a find and replace
	 * to change 'twentyeleven' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'twentyeleven', get_template_directory() . '/languages' );

	remove_action( 'wp_head', 'feed_links', 2 ); 
	add_action('wp_head', 'addBackPostFeed');
	function addBackPostFeed() {
		global $default_settings;
		if (empty($default_settings["news_tag"])) return;
		
		$url = get_tag_link($default_settings["news_tag"]) . "feed/";
		echo '<link rel="alternate" type="application/rss+xml" title="Nyhetsflöde" href="'.$url.'" />'; 
	}
	
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// send email in html
	add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array('primary' => 'Huvudmenu',
							'topmenu' => 'Toppmeny',
							'quickmenu' => 'Snabbgenv&auml;gar'
							));	
	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

}
endif; // hk_setup



/**
 * add theme javascript file and needed jquery 
 */
if (!is_admin()) {
	
	/*
	 * Loads special google font CSS file.
	 */
	
	if ($hk_options['google_font'] != "") {
		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => $hk_options['google_font'],
			'subset' => '',
		);
		wp_enqueue_style( 'hk-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}
	
	if ($hk_options['typekit_url'] != "") {
	//  //use.typekit.net/xpx0dap.js
		wp_enqueue_script(
			'typekit_js',
			'http'.$s_when_https.'://'.$hk_options['typekit_url'],
			array(),
			'1.0',
			true
		);
	}
	if ($hk_options['addthis_pubid'] != "" && $default_settings['allow_cookies']) {
		wp_enqueue_script(
			'addthis_js',
			'http'.$s_when_https.'://s7.addthis.com/js/300/addthis_widget.js#pubid='.$hk_options['addthis_pubid'],
			array(),
			'1.0',
			true
		);
	}
	if ($hk_options['readspeaker_id'] != "") {
		if ($hk_options['readspeaker_id'] == "6595") // to run without ios special script, special for Hultsfreds kommun
			$readspeaker_url = get_template_directory_uri() . '/js/ReadSpeaker/ReadSpeaker.js?pids=embhl';
		else
			$readspeaker_url = 'http'.$s_when_https.'://f1.eu.readspeaker.com/script/'.$hk_options['readspeaker_id'].'/ReadSpeaker.js?pids=embhl&skin=ReadSpeakerCompactSkin';

		wp_enqueue_script(
			'readspeaker_js',
			$readspeaker_url,
			array(),
			'1.0',
			true
		);
	}
	
	wp_enqueue_script(
		'google_map_js',
		'http'.$s_when_https.'://maps.google.com/maps/api/js?sensor=false',
		array('jquery'),
		'1.0',
		true
	);
	wp_enqueue_script(
		'jquery_ui_map_js',
		get_template_directory_uri() . '/js/jquery.ui.map.min.js',
		array('jquery'),
		'1.0',
		true
	);

	/*
	wp_enqueue_script(
		'google_maps_js',
		'https://maps.googleapis.com/maps/api/js?key=AIzaSyBwAFyJDPO82hjRyCAmt-8-if6r6rrzlcE&sensor=false',
		array('jquery'),
		'1.0',
		true
	);*/
	/*
	wp_enqueue_script(
		'history_js',
		get_template_directory_uri() . '/js/native.history.js',
		array('jquery'),
		'1.0',
		true
	);
	*/
	wp_enqueue_script(
		'hultsfred_js',
		get_template_directory_uri() . '/js/hultsfred.js',
		array('jquery','jquery-ui-core','jquery-ui-widget','jquery-ui-tabs'),
		'1.0',
		true
	);
	wp_enqueue_script(
		'cycle_all_js',
		get_template_directory_uri() . '/js/jquery.cycle.all.js',
		array('jquery'),
		'1.0',
		true
	);
} 
/* only in admin */
else {
	wp_enqueue_script(
		'hk_admin_js',
		get_template_directory_uri() . '/js/hultsfred-admin.js',
		array('jquery'),
		'1.0',
		true
	);
	wp_enqueue_script(
		'hk_editor_js',
		get_template_directory_uri() . '/editor-style.css'
	);

}

/**
 * Settings to be available in javascript
 */
function curPageURL() {
	$pageURL = 'http';
	$uri = str_replace("?".$_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']);
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
			$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"] . $uri;
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"] . $uri;
	}

	return $pageURL;
}
function curBaseURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"];
	}
	return $pageURL;
}
function setup_javascript_settings() {
	global $wp_query, $hk_options, $default_settings, $blog_id;
	// What page are we on? And what is the pages limit?
	if (is_home()) {
		$max = 0;
	}
	else {
		$max = $wp_query->max_num_pages;
	}
	// get filter selection to use with dynamic load of posts
	$cat = get_query_var("cat");
	$tags = get_query_var("tag");
	$search = get_query_var("s");
	$orderby = get_query_var("orderby");
	$filter = array("cat" => $cat, "tags" => $tags, "s" => $search, "orderby" => $orderby);
	//id 381 blog_id 2
	// Add some parameters for the dynamic load more posts JS.
	$hultsfred_array = array(
			//'startPage' => 1,
			//'maxPages' => $max,
			//'nextLink' => str_replace(curBaseURL(), "", next_posts($max, false)),
			'templateDir' => get_template_directory_uri(),
			'blogId' => $blog_id,
			'currPageUrl' => curPageURL(), //window.location.protocol + "//" + window.location.host + window.location.pathname
			'currentFilter' => json_encode($filter),
			'allow_google_analytics' => $default_settings['allow_google_analytics'],
			'google_analytics' => $hk_options['google_analytics'],
			'google_analytics_domain' => $hk_options['google_analytics_domain'],
			'mobile_rewrite' => $hk_options["mobile_rewrite"],
			'admin_ajax_url' => str_replace("https://","http://",admin_url('admin-ajax.php')),
		);
	wp_localize_script(
		'hultsfred_js',
		'hultsfred_object',
		$hultsfred_array
	);
}
add_action('wp_head', 'setup_javascript_settings');




/*
 * Make shortcodes work in widgets
 */
add_filter('widget_text', 'do_shortcode');



/**
 * Remove the gallery inline css
 */
add_filter('gallery_style', 
	create_function(
		'$css', 
		'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'
		)
	);

/*
 * Alter excerpt - add link on three first words
 */
add_filter('the_excerpt', 'hk_excerpt');
function hk_excerpt($content) {
	if (is_search())
		return $content;
		
	$content = strip_tags($content);
	$content_array = explode(" ",$content);
	$content = "<span class='introwords'>";
	$count = 1;
	
	foreach ($content_array as $c) {
		
		if ($count++ == 3)
			$content .= $c . "</span> ";
		else
			$content .= $c . " ";
	}
	if ($count < 4)
		$content .= "</span>";
		
    return $content;
}

/**
 * Sets the post excerpt length to 30 words.
 */
function hk_excerpt_length( $length ) {
	return 10;
}
add_filter( 'excerpt_length', 'hk_excerpt_length' );

/**
 * Returns no link for excerpts
 */
function hk_continue_reading_link() {
	return "";
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis.
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function hk_auto_excerpt_more( $more ) {
	return '&hellip; ';
}
add_filter( 'excerpt_more', 'hk_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function hk_custom_excerpt_more( $output ) {
	//if ( has_excerpt() && ! is_attachment() ) {
		$output .= hk_continue_reading_link();
	//}
	return $output;
}
add_filter( 'get_the_excerpt', 'hk_custom_excerpt_more' );



if ( ! function_exists( 'hk_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function hk_content_nav( $nav_id ) {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav class='pagenav' id="<?php echo $nav_id; ?>">
			<?php $big = 999999999; // need an unlikely integer

			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages
			) ); ?>

			<div class="nav-previous"><?php //next_posts_link( __( 'Fler <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php //previous_posts_link( __( '<span class="meta-nav">&larr;</span> Tillbaka', 'twentyeleven' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // hk_content_nav

if ( ! function_exists( 'hk_url_grabber' ) ) :
/**
 * Return the URL for the first link found in the post content.
 */
function hk_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}
endif;

if ( ! function_exists( 'hk_comment' ) ) :
/**
 * Template for comments and pingbacks.
 * Used as a callback by wp_list_comments() for displaying the comments.
 */
function hk_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyeleven' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 68;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 39;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'twentyeleven' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'twentyeleven' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyeleven' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'twentyeleven' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for twentyeleven_comment()

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 */
function hk_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'hk_body_classes' );


 
/**
 * Adds a filter that replaces the w3 validate error rel="category tag" with rel="tag"
 */
function replace_cat_tag ( $text ) {
	$text = str_replace('rel="category tag"', 'rel="tag"', $text); return $text;
}
add_filter( 'the_category', 'replace_cat_tag' );

function strip_tags_from_excerpt ( $text ) {
	$text = strip_tags($text); return $text;
}
add_filter( 'the_excerpt_rss', 'strip_tags_from_excerpt' );


/* help function to render custom thumbnail functionality */
function hk_get_the_post_thumbnail($id, $thumbsize, $showAll=true, $echo=true, $class="") {
	global $default_settings;
	$retValue = "";

	if( function_exists("get_field") && get_field('hk_featured_images') ) :
		if ($showAll) { $slideshowclass = "slideshow"; }
		$countSlides = 0;
		$retValue .= "<div class='img-wrapper ".$class."'><div class='$slideshowclass'>";
		while( has_sub_field('hk_featured_images') && ($showAll || $countSlides == 0)) : // only once if not showAll
			$image = get_sub_field('hk_featured_image');
			$src = $image["sizes"][$thumbsize];
			$title = $image["title"];
			$alt = $image["alt"];
			$caption = get_field("source",$image["id"]);
			
			if ($alt == "") {
				$alt = $title;
			}
			
			if ($default_settings[$thumbsize][0] == $image["sizes"][$thumbsize . "-width"] && $default_settings[$thumbsize][1] == $image["sizes"][$thumbsize . "-height"]) {
				if (!empty($src)) {
					if ($countSlides > 0) {
						$style = "style='display: none;'";
					}
					$src = str_replace("http://" . $_SERVER['SERVER_NAME'], "", $src);
					$retValue .= "<div class='slide' $style>";
					$retValue .= "<img src='$src' alt='$alt' />";
					if ($caption != "") {
						$retValue .= "<span class='image-caption'>Foto: $caption</span>";
					}
					$retValue .= "</div>";
					$countSlides++;
				}
			}
    	endwhile;
		if ($showAll && $countSlides > 1) {
			$retValue .= "<img alt='Platsh&aring;llare f&ouml;r bildspel' class='slideshow_bg' src='" . get_template_directory_uri() . "/image.php?w=".$default_settings[$thumbsize][0]."&amp&h=".$default_settings[$thumbsize][1]."'/>";
			$retValue .= "<span class='prevslide'></span><span class='nextslide'></span>";
		}
		$retValue .= "</div></div>"; 
 	endif; 
	if ($echo) {
		echo $retValue;
	}
	else {
		return $retValue;
	}
}


// help function to display when next review date is
function get_the_reviewed_date($id) {
	global $post;

	$time = get_post_meta( $id, 'hk_last_reviewed', true );
	if (isset($time) && $time != "") {
		$time = "Granskad: " . hk_nicedate($time);
	}
	return $time;
}
if (!function_exists("hk_nicedate")) {
	function hk_nicedate($time) {
		$time = date("j F Y" , $time);
		$mo = array('januari' => 'January',
				'februari' => 'February',
				'mars' => 'March',
				'april' => 'April',
				'maj' => 'May',
				'juni' => 'June',
				'juli' => 'July',
				'augusti' => 'August',
				'september' => 'September',
				'oktober' => 'October',
				'november' => 'November',
				'december' => 'December');
				
		foreach ($mo as $swe => $eng)
		$time = preg_replace('/\b'.$eng.'\b/', $swe, $time);
		return $time;
	}
}
function get_the_next_review_date($id) {
	global $post;
	$time = get_post_meta( $id, 'hk_next_review', true );

	return duration(strtotime("now"),$time);
}
function duration($start,$end) {  
	$neg = false;
	$seconds = $end - $start;  

	if ($seconds < 0) {
		$seconds = -$seconds;
		$neg = true;
	}

	$days = floor($seconds/60/60/24);  
	$hours = $seconds/60/60%24;  
	$mins = $seconds/60%60;  
	$secs = $seconds%60;  

	$duration='';  
	if($days>0) {
		if ($neg)
			$duration = "<b>för $days dagar sedan</b>";
		else
			$duration = "om $days dagar";
	}
	else {
		$duration = 'nu';
	}
	
	return $duration;  
}  

// return true if current category has more parents than specified in num_levels_in_menu
function is_sub_category() {
	global $default_settings;
	if ( !isset($default_settings["is_sub_category"]) ) {
		$cat = get_query_var("cat");
		if ( isset($cat) && hk_countParents($cat) >= $default_settings["num_levels_in_menu"] ) {
			$default_settings["is_sub_category"] = true;
		} else {
			$default_settings["is_sub_category"] = false;
		}
	}
	return $default_settings["is_sub_category"];
}
// return true if current category is a sub firstpage, i.e. category level is one above num_levels_in_menu
function is_sub_category_firstpage() {
	global $default_settings;
	if ( !isset($default_settings["is_sub_category_firstpage"]) ) {
		$cat = get_query_var("cat");
		if ( isset($cat) && hk_countParents($cat) == $default_settings["num_levels_in_menu"]-1 ) {
			$default_settings["is_sub_category_firstpage"] = true;
		} else {
			$default_settings["is_sub_category_firstpage"] = false;
		}
	}
	return $default_settings["is_sub_category_firstpage"];
}
// return number of parents argument $cat has
function hk_countParents($cat) {
	if (empty($cat)) return 0;
	$cats_str = get_category_parents($cat, false, '%#%');
	$cats_array = explode('%#%', $cats_str);
	$cat_depth = sizeof($cats_array)-1;
	return $cat_depth;
}
function hk_isParentOf($cat,$parent) {
	if (empty($cat)) return 0;
	$child_array = hk_getChildrenIdArray($parent);
	return in_array($cat, $child_array);
}
// get parent of category
function hk_getParent($cat) {
	if (empty($cat)) return 0;
	$category = get_category($cat);
	if (!empty($category))
		return $category->parent;
	return 0;
}
// return the top parent id found in the menu
function hk_getTopMenuParent($cat) {
	global $default_settings;
	if (empty($cat)) return array();
	$cats_str = get_category_parents($cat, false, '%#%', true);
	$cats_array = explode('%#%', $cats_str);
	$cat_depth = sizeof($cats_array)-1;
	if ($cat_depth > 0) {
		return get_category_by_slug($cats_array[0])->term_id;
	}
	return $cat;
}
// return the parents of argument category $cat in slug array form
function hk_getParentsSlugArray($cat) {
	if (empty($cat)) return array();
	$cats_str = get_category_parents($cat, false, '%#%', true);
	$cats_array = explode('%#%', $cats_str);
	$cat_depth = sizeof($cats_array)-1;
	unset($cats_array[$cat_depth]);
	return $cats_array;
}
// return the first parent id found in the menu
function hk_getMenuParent($cat) {
	global $default_settings;
	if (empty($cat)) return array();
	$num_levels_in_menu = $default_settings["num_levels_in_menu"];
	$cats_str = get_category_parents($cat, false, '%#%', true);
	$cats_array = explode('%#%', $cats_str);
	$cat_depth = sizeof($cats_array)-1;
	if ($cat_depth > $num_levels_in_menu) {
		return get_category_by_slug($cats_array[$num_levels_in_menu-1])->term_id;
	}
	return $cat;
}
// return nav menu id of category
function hk_getNavMenuId($cat_id, $menu_name) {
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items($menu->term_id);

		foreach ( (array) $menu_items as $key => $menu_item ) {
			$title = $menu_item->title;
			$url = $menu_item->url;
			
			if ($menu_item->object_id == $cat_id) {
				return $menu_item->ID;
			}
		}
	} 
	return -1;
}	
// return top nav menu ids
function hk_getTopNavMenuIdArray($menu_name) {
	$menu_array = array();
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		foreach ( (array) $menu_items as $key => $menu_item ) {
			if ($menu_item->menu_item_parent == 0) {
				$menu_array[] = $menu_item->object_id;
			}
		}
	} 
	return $menu_array;
}	
// return sub nav menu ids
function hk_getSubNavMenuIdArray($topmenu, $menu_name) {
	$menu_array = array();
	if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
		$menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
		$menu_items = wp_get_nav_menu_items($menu->term_id);
		foreach ( (array) $menu_items as $key => $menu_item ) {
			if ($menu_item->menu_item_parent == $topmenu) {
				$menu_array[] = $menu_item->object_id;
			}
		}
	} 
	return $menu_array;
}	


// return the top parent id found in the menu
/*function hk_getMenuTopParent($cat) {
	global $default_settings;
	if (empty($cat)) return array();
	
	$cats_str = get_category_parents($cat, false, '%#%', true);
	$cats_array = explode('%#%', $cats_str);
	$cat_depth = sizeof($cats_array)-1;
	if ($cat_depth > 0) {
		return get_category_by_slug($cats_array[0])->term_id;
	}
	return $cat;
}*/
// return all the category children of category $cat in id array form
function hk_getChildrenIdArray($cat) {
	if (empty($cat)) return array();
	$children =  get_categories(array('child_of' => $cat, 'hide_empty' => false));
	$retArray = array();
	foreach($children as $child) {
		$retArray[] = $child->term_id;
	}
	return $retArray;
}

// get parents from post, returns array(topmenucategory, submenucategory, category)
function hk_get_parent_categories_from_id($id, $menu_name) {
	$categories_list = get_the_category($id);
	
	// get current posts top menus
	$topparentsarr = array();
	foreach($categories_list as $item) {
		$parent = hk_getTopMenuParent($item->term_id);
		if (!in_array($parent, $topparentsarr)) {
			$topparentsarr[] = $parent;
		}
	}
	
	// get the first top menu
	$parent_category = -1;
	foreach(hk_getTopNavMenuIdArray($menu_name) as $item) {
		if (in_array($item, $topparentsarr)) {
			$parent_category = $item;
			break;
		}
	}
	
	// get current posts sub menus from selected top menu
	$subparentsarr = array();
	foreach($categories_list as $item) {
		$subparent = hk_getMenuParent($item->term_id);
		if (!in_array($subparent, $subparentsarr)) {
			$subparentsarr[] = $subparent;
		}
	}

	// get first relevant sub menu
	$sub_parent_category = -1;
	foreach(hk_getSubNavMenuIdArray(hk_getNavMenuId($parent_category,$menu_name),$menu_name) as $item) {
		if (in_array($item, $subparentsarr)) {
			$sub_parent_category = $item;
			break;
		}
	}
	
	// get child category if any
	$category = -1;
	foreach($categories_list as $item) {
		if (hk_getMenuParent($item->cat_ID) == $sub_parent_category && $item->cat_ID != $sub_parent_category) {
			$category = $item->cat_ID;
			break;
		}
	}

	return array($parent_category, $sub_parent_category, $category);
}

// get parents from category, returns array(topmenucategory, submenucategory, the category)
function hk_get_parent_categories_from_cat($cat) {
	$parent_category = hk_getTopMenuParent($cat);
	$sub_parent_category = hk_getMenuParent($cat);
	return array($parent_category, $sub_parent_category, $cat);
}

function hk_getSmallWords($smallwords) {
	$smallwords = trim($smallwords);
	if (empty($smallwords)) return "";

	$arr = split("\n",$smallwords);
	if (empty($arr) || count($arr) == 0) return "";

	$count = count($arr);
	if ($count == 1) return $arr[0];

	$rand = rand(0,$count-1);
	if ($rand < 0) return "";
	return $arr[$rand];
}

// submenu walker to get second row of top menu
class hk_submenu_walker_nav_menu extends Walker_Nav_Menu {
	  
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth ) {
		// depth dependent classes
		$output .= "";
	}
	function end_lvl( &$output, $depth ) {
		$output .= "";
	}  
	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth, $args ) {
		global $wp_query;
		
		// dont show first level, and only show sublevels when right parent category
		if ($depth > 0 && $args->nav_menu_parent == $item->menu_item_parent) {
			$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
		  
			// depth dependent classes
			$depth_classes = array(
				( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
				( $depth >=2 ? 'sub-sub-menu-item' : '' ),
				( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
				'menu-item-depth-' . $depth
			);
			$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
		  
			// passed classes
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
		  
			// current category classesq
			$cat_class = ($item->object == "category" && $item->object_id == $args->current_category) ? "current-menu-item" : "";

			$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . ' ' . $cat_class . '">';
		  
			// link attributes
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
		  
			$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
				$args->before,
				$attributes,
				$args->link_before,
				apply_filters( 'the_title', $item->title, $item->ID ),
				$args->link_after,
				$args->after
			);
		  
			// build html
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
	function end_el( &$output, $item, $depth, $args ) {
		if ($depth > 0 && $args->nav_menu_parent == $item->menu_item_parent) {
			$output .= "</li>";
		}
	
	}  
}

// topmenu walker to get second row of top menu
class hk_topmenu_walker_nav_menu extends Walker_Nav_Menu {
	  
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth ) {
		// depth dependent classes
		$output .= "";
	}
	function end_lvl( &$output, $depth ) {
		$output .= "";
	}  
	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth, $args ) {
		global $wp_query;
		
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent

		// depth dependent classes
		$depth_classes = array(
			( $depth == 0 ? 'main-menu-item' : 'sub-menu-item' ),
			( $depth >=2 ? 'sub-sub-menu-item' : '' ),
			( $depth % 2 ? 'menu-item-odd' : 'menu-item-even' ),
			'menu-item-depth-' . $depth
		);
		$depth_class_names = esc_attr( implode( ' ', $depth_classes ) );
	  
		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
	  
		// current category classes
		$cat_class = ($item->object == "category" && $item->object_id == $args->current_category) ? "current-menu-item" : "";

		// build html
		$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="' . $depth_class_names . ' ' . $class_names . ' ' . $cat_class . '">';
	  
		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		$attributes .= ' class="menu-link ' . ( $depth > 0 ? 'sub-menu-link' : 'main-menu-link' ) . '"';
	  
		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);
	  
		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
	function end_el( &$output, $item, $depth, $args ) {
		$output .= "</li>";
	}  
}


/* add modified date to feed */
add_action("do_feed_rss","wp_rss_img_do_feed",5,1);
add_action("do_feed_rss2","wp_rss_img_do_feed",5,1); 

function wp_rss_img_do_feed($for_comments){
	if(!$for_comments) {
		add_action('rss_item', 'wp_rss_img_include');
		add_action('rss2_item', 'wp_rss_img_include');
	}
}
function wp_rss_img_include (){
	if (get_the_date("YmdHis") != get_the_modified_date("YmdHis")) //check if same as pubdate
	{
		echo "\t<modDate>";
		$date = get_the_modified_date("Y-m-d H:i:s");
		$timezone = timezone_open(get_option('timezone_string'));
		$date = new DateTime($date,$timezone);
		echo $date->format(DateTime::RSS);
		echo "</modDate>\n\t";
	}
}


// show attachments in post flow
/*function hk_attachments_in_query($local_wp_query) {
	$local_wp_query->set( 'post_type', 'attachment' );
}
if (!is_admin()) {
//	add_action('pre_get_posts', 'hk_attachments_in_query');
}*/


// show 404 debug if true
if ($_REQUEST["DEBUG"] == "true") :

ini_set( 'error_reporting', -1 );
ini_set( 'display_errors', 'On' );
 
echo '<pre>';
 
add_action( 'parse_request', 'debug_404_rewrite_dump' );
function debug_404_rewrite_dump( &$wp ) {
    global $wp_rewrite;
 
    echo '<h2>rewrite rules</h2>';
    echo var_export( $wp_rewrite->wp_rewrite_rules(), true );
 
    echo '<h2>permalink structure</h2>';
    echo var_export( $wp_rewrite->permalink_structure, true );
 
    echo '<h2>page permastruct</h2>';
    echo var_export( $wp_rewrite->get_page_permastruct(), true );
 
    echo '<h2>matched rule and query</h2>';
    echo var_export( $wp->matched_rule, true );
 
    echo '<h2>matched query</h2>';
    echo var_export( $wp->matched_query, true );
 
    echo '<h2>request</h2>';
    echo var_export( $wp->request, true );
 
    global $wp_the_query;
    echo '<h2>the query</h2>';
    echo var_export( $wp_the_query, true );
}
add_action( 'template_redirect', 'debug_404_template_redirect', 99999 );
function debug_404_template_redirect() {
    global $wp_filter;
    echo '<h2>template redirect filters</h2>';
    echo var_export( $wp_filter[current_filter()], true );
}
add_filter ( 'template_include', 'debug_404_template_dump' );
function debug_404_template_dump( $template ) { 
    echo '<h2>template file selected</h2>';
    echo var_export( $template, true );
    
    echo '</pre>';
    exit();
}
endif; // debug == true



function get_client_ip() {
     $ipaddress = '';
     if (getenv('HTTP_CLIENT_IP'))
         $ipaddress = getenv('HTTP_CLIENT_IP');
     else if(getenv('HTTP_X_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
     else if(getenv('HTTP_X_FORWARDED'))
         $ipaddress = getenv('HTTP_X_FORWARDED');
     else if(getenv('HTTP_FORWARDED_FOR'))
         $ipaddress = getenv('HTTP_FORWARDED_FOR');
     else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
     else if(getenv('REMOTE_ADDR'))
         $ipaddress = getenv('REMOTE_ADDR');
     else
         $ipaddress = 'UNKNOWN';

     return $ipaddress; 
}
function hk_count_func(){
	$version = $_POST["version"];
	$browser = $_POST["browser"];
	$hk_options = get_option('hk_theme');
	$ip = $_POST["ip"] . " - " . get_client_ip();
	if ($hk_options !== false) {
		$count = $hk_options["count_version"];
		if (!is_array($count))
			$count = Array();
			
		if ($count[$version . " - " . $browser . " - " . $ip] != "")
			$count[$version . " - " . $browser . " - " . $ip]++;
		else
			$count[$version . " - " . $browser . " - " . $ip] = 1;
		$hk_options["count_version"] = $count;
		update_option("hk_theme",$hk_options);
	}
	echo "counted";
	die();
	
}
add_action('wp_ajax_hk_count', 'hk_count_func'); 
add_action('wp_ajax_nopriv_hk_count', 'hk_count_func'); 

?>