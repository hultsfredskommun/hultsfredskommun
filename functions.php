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
/* get hk_options */
$hk_options = get_option('hk_theme');
	
/* set allow cookie */
if ($_REQUEST["cookies"] && $hk_options["cookie_accept_enable"] == "1") {
	// allow cookies for 10 years
	setcookie("allow_cookies", "true", time()+3600*24*3650, "/");
}
	
/* SET DEFAULT SETTINGS */
if ( ! isset( $default_settings ) ) {
	$options = get_option('hk_theme');
	$default_settings = array(	'thumbnail-image' => array(200, 113, true),
								'featured-image' => array(532, 311, true), /* array(660, 396, true) */
								'slideshow-image' => array(980, 551, true),
								'contact-image' => array(150, 150, true),
								'startpage_cat' => $options["startpage_cat"],
								'news_tag' => $options["news_tag"],
								'hidden_cat' => $options["hidden_cat"],
								'protocol_cat' => $options["protocol_cat"],
								'num_levels_in_menu' => (!isset($options["num_levels_in_menu"]))?2:$options["num_levels_in_menu"],
								'show_tags' => (!isset($options["show_tags"]))?0:$options["show_tags"],
								'allow_cookies' => $_REQUEST["cookies"] || $_COOKIE['allow_cookies'] || $hk_options["cookie_accept_enable"] == "",
								'allow_google_analytics' => $_REQUEST["cookies"] || $_COOKIE['allow_cookies'] || $hk_options["cookie_accept_enable"] == "" || $hk_options['google_analytics_disable_if_no_cookies'] != "1",
								);
}



// Grab hk option page.
require( get_template_directory() . '/inc/hk-option-page.php' );

// Grab hk dynamic widgets
require( get_template_directory() . '/inc/hk-dynamic-widgets.php' );

// Grab hk text widget.
require( get_template_directory() . '/inc/hk-text-widget.php' );

// Grab hk slideshow.
require( get_template_directory() . '/inc/hk-slideshow.php' );

// Grab hk contacts.
require( get_template_directory() . '/inc/hk-contacts.php' );

// Grab hk related.
//require( get_template_directory() . '/inc/hk-related.php' );

// Grab hk events.
require( get_template_directory() . '/inc/hk-events.php' );

// Grab hk menu widget.
require( get_template_directory() . '/inc/hk-navigation.php' );

// Grab hk sort-order function
require( get_template_directory() . '/inc/hk-sort-order.php' );

// Grab hk admin-page to alter admin/edit pages
require( get_template_directory() . '/inc/hk-admin-pages.php' );

// Grab hk sort-order function
require( get_template_directory() . '/inc/hk-acf-fields.php' );

// Grab hk widgets function containing general widgets
require( get_template_directory() . '/inc/hk-widgets.php' );

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


function hk_exclude_category( $query ) {
	global $default_settings;
    if ( !is_admin() ) {
        $query->set( 'category__not_in', $default_settings["hidden_cat"] );
    }
}
add_action( 'pre_get_posts', 'hk_exclude_category' );


/**
 * add theme javascript file and needed jquery 
 */
if (!is_admin()) {

	wp_enqueue_script(
		'google_map_js',
		'http'.$s_when_https.'://maps.google.com/maps/api/js?sensor=false',
		array('jquery'),
		'1.0',
		true
	);
	wp_enqueue_script(
		'jquery_ui_map_js',
		get_stylesheet_directory_uri() . '/js/jquery.ui.map.min.js',
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
	wp_enqueue_script(
		'history_js',
		get_stylesheet_directory_uri() . '/js/native.history.js',
		array('jquery'),
		'1.0',
		true
	);
	wp_enqueue_script(
		'hultsfred_js',
		get_stylesheet_directory_uri() . '/js/hultsfred.js',
		array('jquery','jquery-ui-core','history_js','jquery-ui-widget','jquery-ui-tabs'),
		'1.0',
		true
	);
	wp_enqueue_script(
		'cycle_all_js',
		get_stylesheet_directory_uri() . '/js/jquery.cycle.all.js',
		array('jquery'),
		'1.0',
		true
	);
} 
/* only in admin */
else {
	wp_enqueue_script(
		'hk_admin_js',
		get_stylesheet_directory_uri() . '/js/hultsfred-admin.js',
		array('jquery'),
		'1.0',
		true
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
	global $wp_query, $hk_options, $default_settings;
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
	
	// Add some parameters for the dynamic load more posts JS.
	$hultsfred_array = array(
			'startPage' => 1,
			'maxPages' => $max,
			'nextLink' => str_replace(curBaseURL(), "", next_posts($max, false)),
			'templateDir' => get_stylesheet_directory_uri(),
			'blogId' => $blog_id,
			'currPageUrl' => curPageURL(), //window.location.protocol + "//" + window.location.host + window.location.pathname
			'currentFilter' => json_encode($filter),
			'allow_google_analytics' => $default_settings['allow_google_analytics'],
			'google_analytics' => $hk_options['google_analytics'],
			'google_analytics_domain' => $hk_options['google_analytics_domain'],
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


/*
 * Make the_permalink links relative instead of static.
 */
function hk_relative_permalinks($input) {
    return preg_replace('!http(s)?://' . $_SERVER['SERVER_NAME'] . '/!', '/', $input);
}
add_filter( 'post_link', 'hk_relative_permalinks' );
//add_filter( 'the_permalink', 'hk_relative_permalinks' );
add_filter( 'post_type_link', 'hk_relative_permalinks' );



/**
 * Remove the gallery inline css
 */
add_filter('gallery_style', 
	create_function(
		'$css', 
		'return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);'
		)
	);

/**
 * Sets the post excerpt length to 30 words.
 */
function hk_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'hk_excerpt_length' );

/**
 * Returns no link for excerpts
 */
function hk_continue_reading_link() {
	return "";//' <a href="' . get_permalink() . '" class="togglearticle">Visa hela</a> '; 
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
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'twentyeleven' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?></div>
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
			if ($alt == "") {
				$alt = $title;
			}
			
			if (strpos($src,$default_settings[$thumbsize][0] . "x" . $default_settings[$thumbsize][1])) {
				if (!empty($src)) {
					if ($countSlides > 0) {
						$style = "style='display: none;'";
					}
					$src = str_replace("http://" . $_SERVER['SERVER_NAME'], "", $src);
					$retValue .= "<img class='slide' $style src='$src' alt='$alt' title='$alt' />";
					$countSlides++;
				}
			}
    	endwhile;
		if ($showAll && $countSlides > 1) {
			$retValue .= "<img alt='Platsh&aring;llare f&ouml;r bildspel' class='slideshow_bg' src='" . get_stylesheet_directory_uri() . "/image.php?w=".$default_settings[$thumbsize][0]."&amp&h=".$default_settings[$thumbsize][1]."'/>";
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


// add filter to get ACF field stop publish to work
function filter_where( $where = '' ) {
    //$where .= " AND hk_stop_publish < '" . strtotime("now") . "'";
    return $where;
}
add_filter( 'posts_where', 'filter_where' );


// help function to display when next review date is
function get_the_reviewed_date($id) {
	global $post;

	$time = get_post_meta( $id, 'hk_last_reviewed', true );
	if (isset($time)) {
		$time = "Granskad: " . hk_nicedate($time);
	}
	else 
	{
		$time = "Inte granskad";
	}
	return $time;
}
function hk_nicedate($time) {
	$time = date("j F Y" , $time);
	$mo = array('januari' => 'January',
			'februari' => 'February',
			'mars' => 'March',
			'april' => 'Aprli',
			'maj' => 'Mey',
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
?>