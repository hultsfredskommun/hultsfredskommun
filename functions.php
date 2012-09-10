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

	/* SET DEFAULT SETTINGS */
if ( ! isset( $default_settings ) ) {
	$options = get_option('hk_theme');
	$default_settings = array(	'thumbnail-image' => array(272, 153, true),
								'featured-image' => array(720, 405, true), /* array(660, 396, true) */
								'slideshow-image' => array(1000, 250, true),
								'contact-image' => array(150, 150, true),
								'startpage_cat' => $options["startpage_cat"],
								'news_cat' => $options["news_cat"],
								'hidden_cat' => $options["hidden_cat"],
								'protocol_cat' => $options["protocol_cat"]
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
require( get_template_directory() . '/inc/hk-related.php' );

// Grab hk events.
require( get_template_directory() . '/inc/hk-events.php' );

// Grab hk menu widget.
require( get_template_directory() . '/inc/hk-menu-widget.php' );

// Grab hk sort-order function
require( get_template_directory() . '/inc/hk-sort-order.php' );

// Grab hk admin-page to alter admin/edit pages
require( get_template_directory() . '/inc/hk-admin-pages.php' );

// Grab hk sort-order function
require( get_template_directory() . '/inc/hk-acf-fields.php' );

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

	// Registers taxonomy add-on for Advanced Custom Fields
	if (function_exists("register_field")) {
		register_field('Tax_field', dirname(__File__) . '/inc/acf-tax.php');
	}

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentyeleven' ) );
	
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
		'cycle_lite_js',
		//get_stylesheet_directory_uri() . '/js/jquery.cycle.lite.js',
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
	global $wp_query;
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
	$vem_tags = get_query_var("vem");
	$ort_tags = get_query_var("ort");
	$search = get_query_var("s");
	$filter = array("cat" => $cat, "tags" => $tags, "vem_tags" => $vem_tags, "ort_tags" => $ort_tags, "s" => $search);
	
	// Add some parameters for the dynamic load more posts JS.
	wp_localize_script(
		'hultsfred_js',
		'hultsfred_object',
		array(
			'startPage' => 1,
			'maxPages' => $max,
			'nextLink' => str_replace(curBaseURL(), "", next_posts($max, false)),
			'templateDir' => get_stylesheet_directory_uri(),
			'blogId' => $blog_id,
			'currPageUrl' => curPageURL(), //window.location.protocol + "//" + window.location.host + window.location.pathname
			'currentFilter' => json_encode($filter)
		)
	);
}
add_action('wp_head', 'setup_javascript_settings');







/**
 * Sets the post excerpt length to 40 words.
 */
function hk_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'hk_excerpt_length' );

/**
 * Returns no link for excerpts
 */
function hk_continue_reading_link() {
	return ''; 
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and hk_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function hk_auto_excerpt_more( $more ) {
	return ' &hellip;' . hk_continue_reading_link();
}
add_filter( 'excerpt_more', 'hk_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function hk_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= hk_continue_reading_link();
	}
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

if ( ! function_exists( 'twentyeleven_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyeleven_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_comment( $comment, $args, $depth ) {
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




/* help function to render custom thumbnail functionality */
function hk_get_the_post_thumbnail($id, $thumbsize, $showAll=true) {
	global $default_settings;
	$retValue = "";
	$first = true;
	if( get_field('hk_featured_images') ) :
		if ($showAll) { $slideshowclass = "slideshow"; }
		$retValue .= "<div class='img-wrapper $slideshowclass'>";
		while( has_sub_field('hk_featured_images') && ($showAll || $first)) : // only once if not showAll
			$image = get_sub_field('hk_featured_image');
			$src = $image["sizes"][$thumbsize];
			$title = $image["title"];
			$description = $image["description"];
			
			if (strpos($src,$default_settings[$thumbsize][0] . "x" . $default_settings[$thumbsize][1])) {
				if (!$first) {
					$style = "style='display: none;'";
				}
				if (!empty($src)) {
					$retValue .= "<img class='slide' $style src='$src' alt='$description' title='$description'/>";
				}
				$first = false;
			}
    	endwhile;
		if ($showAll) {
			$retValue .= "<img class='slideshow_bg' src='" . get_stylesheet_directory_uri() . "/image.php?w=".$default_settings[$thumbsize][0]."&h=".$default_settings[$thumbsize][1]."'/>";
		}
		$retValue .= "</div>"; 
 	endif; 
 	echo $retValue;
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
	if($days>0) $duration .= "$days dagar ";  
	//if($hours>0) $duration .= "$hours timmar ";  
	//if($mins>0) $duration .= "$mins minuter ";  
	//if($secs>0) $duration .= "$secs seconds ";  

	$duration = trim($duration);  
	if($duration==null) $duration = 'nu';  

	if ($neg)
		$duration = "<b>för $duration sedan</b>";
	else
		$duration = "om $duration";
	return $duration;  
}  