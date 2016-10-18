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
  * Define HK_VERSION, will be set as version of style.css and hultsfred.js
  */
define("HK_VERSION", "4.3");

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
								'featured-image' => array(605, 353, true), /* array(660, 396, true) */
								'slideshow-image' => array(980, 551, true),
								'wide-image' => array(1138, 326, true),
								'contact-image' => array(150, 190, true),
								'thumbnail-news-image' => array(510, 289, true),
								'startpage_cat' => $hk_options["startpage_cat"],
								'news_tag' => $hk_options["news_tag"],
								'hidden_cat' => $hk_options["hidden_cat"],
								'protocol_cat' => $hk_options["protocol_cat"],
								'num_levels_in_menu' => (!isset($hk_options["num_levels_in_menu"]) || $hk_options["num_levels_in_menu"] == "")?2:$hk_options["num_levels_in_menu"],
								'show_tags' => (!isset($hk_options["show_tags"]) || $hk_options["show_tags"] == "")?1:$hk_options["show_tags"],
								'sticky_number' => 1000,
								'show_most_viewed_in_subsubcat' => $hk_options["show_most_viewed_in_subsubcat"],
								'show_quick_links_in_subsubcat' => $hk_options["show_quick_links_in_subsubcat"],
								'hide_articles_in_subsubcat' => $hk_options["hide_articles_in_subsubcat"],
								'category_slideshow_thumbnail_size' => $hk_options["category_slideshow_thumbnail_size"],
								'show_articles' => true);

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

// Grab hk slideshow.
require( get_template_directory() . '/inc/hk-slideshow.php' );

// Grab hk contacts.
require( get_template_directory() . '/inc/hk-contacts.php' );

// Grab hk FAQ.
//require( get_template_directory() . '/inc/hk-faq.php' );

// Grab hk related.
require( get_template_directory() . '/inc/hk-related.php' );

// Grab hk quick.
require( get_template_directory() . '/inc/hk-quick.php' );

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
 * shortcode [filtersearch], show filter function
 */
 /*
function hk_filter_search_func( $atts ){
	global $default_settings;
	$atts = shortcode_atts(
		array(
			'parent_class' => '',
			'parent_element' => '',
			'always_show_firstrow' => '',
			'text' => '',
		), $atts, 'filtersearch' );
	$retValue = "";

	// full category tree
	$retValue .= "<p id='filtersearch' class='filtersearch' data-text='" . $atts["text"] . "' data-filter-class='" . $atts["parent_class"] . "' data-filter-element='" . $atts["parent_element"] . "' data-show-firstrow='" . $atts["always_show_firstrow"] . "'>";
	$retValue .= "";
	$retValue .= "</p>";

	return $retValue;
}
add_shortcode( 'filtersearch', 'hk_filter_search_func' );
*/

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
							'quickmenu' => 'Snabbgenv&auml;gar',
							));	
	// Add default posts and comments RSS feed links to <head>.
	//add_theme_support( 'automatic-feed-links' );
}
endif; // hk_setup


/* remove comment feed, but keep other feeds */
function remove_comment_feeds( $for_comments ){
    if( $for_comments ){
        remove_action( 'do_feed', 'do_feed_rss2', 10, 1 );
        remove_action( 'do_feed_rdf', 'do_feed_rss2', 10, 1 );
		remove_action( 'do_feed_rss', 'do_feed_rss2', 10, 1 );
		remove_action( 'do_feed_rss2', 'do_feed_rss2', 10, 1 );
        remove_action( 'do_feed_atom', 'do_feed_atom', 10, 1 );
    }
}
add_action( 'do_feed', 'remove_comment_feeds', 9, 1 );
add_action( 'do_feed_rdf', 'remove_comment_feeds', 9, 1 );
add_action( 'do_feed_rss', 'remove_comment_feeds', 9, 1 );
add_action( 'do_feed_rss2', 'remove_comment_feeds', 9, 1 );
add_action( 'do_feed_atom', 'remove_comment_feeds', 9, 1 );

/**
 * add theme javascript file and needed jquery 
 */
function hk_enqueue_scripts() {
	$hk_options = get_option("hk_theme");
	if (!is_admin()) {
		
		wp_enqueue_style( 'hk-style', 
			get_bloginfo( 'stylesheet_url' ), 
			array(), 
			HK_VERSION 
		);
		
		/*<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>?ver=1.0.1" />*/
		/*
		 * Loads special google font CSS file.
		 */
		if (isset($hk_options['google_font']) && $hk_options['google_font'] != "") {
			$protocol = is_ssl() ? 'https' : 'http';
			$query_args = array(
				'family' => $hk_options['google_font'],
				'subset' => '',
			);
			wp_enqueue_style( 'hk-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
		}
		
		if (isset($hk_options['typekit_url']) && $hk_options['typekit_url'] != "") {
		//  //use.typekit.net/xpx0dap.js
			wp_enqueue_script(
				'typekit_js',
				$hk_options['typekit_url'],
				array(),
				'1.0'
			);
		}
		
		if (isset($hk_options['addthis_pubid']) && $hk_options['addthis_pubid'] != "") {
			wp_enqueue_script(
				'addthis_js',
				'//s7.addthis.com/js/300/addthis_widget.js#pubid='.$hk_options['addthis_pubid'],
				array(),
				'1.0'
			);
		}
		if (isset($hk_options['readspeaker_id']) && $hk_options['readspeaker_id'] != "") {
			/*if ($hk_options['readspeaker_id'] == "6595") // to run without ios special script, special for Hultsfreds kommun
				$readspeaker_url = get_template_directory_uri() . '/js/ReadSpeaker/ReadSpeaker.js?pids=embhl';
			else*/
			$readspeaker_url = '//f1.eu.readspeaker.com/script/'.$hk_options['readspeaker_id'].'/ReadSpeaker.js?pids=embhl&skin=ReadSpeakerCompactSkin';

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
			'//maps.google.com/maps/api/js?sensor=false',
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
			array('jquery','jquery-ui-core','jquery-ui-widget'),
			HK_VERSION,
			true
		);
		wp_enqueue_script(
			'cycle_all_js',
			get_template_directory_uri() . '/js/jquery.cycle.all.js',
			array('jquery'),
			'1.0',
			true
		);
		
		if (isset($hk_options['tidiochat_url']) && $hk_options['tidiochat_url'] != "") {
			wp_enqueue_script(
				'tidiochat_js',
				$hk_options['tidiochat_url'],
				array(),
				'1.0'
			);
		}	

	} 
	/* only in admin */
	else {
		wp_enqueue_script(
			'hk_admin_js',
			get_template_directory_uri() . '/js/hultsfred-admin.js',
			array('jquery'),
			HK_VERSION,
			true
		);
		wp_enqueue_script(
			'hk_editor_css',
			get_template_directory_uri() . '/editor-style.css',
			array(),
			HK_VERSION
		);

	}
}
add_action( 'wp_enqueue_scripts', 'hk_enqueue_scripts' );

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
			'gcse_id' => $hk_options['gcse_id'],
			'mobile_rewrite' => $hk_options["mobile_rewrite"],
			'admin_ajax_url' => str_replace("https://","http://",admin_url('admin-ajax.php')),
			'addthis_pubid_admin' => $hk_options['addthis_pubid_admin'],
			'cookie_accept_enable' => $hk_options['cookie_accept_enable'],
			'cookie_text' => $hk_options['cookie_text'],
			'cookie_button_text' => $hk_options['cookie_button_text'],
			'cookie_link_text' => $hk_options['cookie_link_text'],
			'cookie_link' => $hk_options['cookie_link'],
		);
	if (!is_admin()) {
		wp_localize_script(
			'hultsfred_js',
			'hultsfred_object',
			$hultsfred_array
		);
	} else {
		wp_localize_script(
			'hk_admin_js',
			'hultsfred_object',
			$hultsfred_array
		);
	}
}
add_action('wp_head', 'setup_javascript_settings');
add_action('admin_head', 'setup_javascript_settings');




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
	$content = "<span class='excerpt-wrapper'><span class='introwords'>";
	$count = 1;
	
	foreach ($content_array as $c) {
		
		if ($count++ == 3)
			$content .= $c . "</span> ";
		else
			$content .= $c . " ";
	}
	if ($count < 4)
		$content .= "</span>";
	
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
function hk_get_the_post_thumbnail($id, $thumbsize, $showAll=true, $echo=true, $class="", $only_img=false) {
	global $default_settings;
	$retValue = "";
	/* check if ACF is enabled and if field hk_featured_images exists */
	if( function_exists("get_field") && get_field('hk_featured_images', $id) ) :
		if ($showAll) { $slideshowclass = "slideshow"; }
		$countSlides = 0;
		if (!$only_img) {
			$retValue .= "<div class='img-wrapper ".$class."'><div class='$slideshowclass'>";
		}
		while( has_sub_field('hk_featured_images', $id) && ($showAll || $countSlides == 0)) : // only once if not showAll
			$image = get_sub_field('hk_featured_image');
			$src = $image["sizes"][$thumbsize];
			$caption = $image["caption"];
			$title = $image["title"];
			$alt = $image["alt"];
			$source = get_field("source",$image["id"]);
			
			if ($alt == "") {
				$alt = $title;
			}
			
			if ($default_settings[$thumbsize][0] == $image["sizes"][$thumbsize . "-width"] && $default_settings[$thumbsize][1] == $image["sizes"][$thumbsize . "-height"]) {
				if (!empty($src)) {
					if ($countSlides > 0) {
						$style = "style='display: none;'";
					}
					$src = str_replace("http://" . $_SERVER['SERVER_NAME'], "", $src);
					if (!$only_img) {
						$retValue .= "<div class='slide' $style>";
					}
					$retValue .= "<img src='$src' alt='$alt' title='$alt' />";
					if (!$only_img) {
						if ($caption != "") {
							$retValue .= "<span class='image-title'>$caption</span>";
						}
						if ($source != "") {
							$retValue .= "<span class='image-caption'>Foto: $source</span>";
						}
						$retValue .= "</div>";
					}
					$countSlides++;
				}
			}
    	endwhile;
		if (!$only_img) {
			if ($showAll && $countSlides > 1) {
				$retValue .= "<img alt='Platsh&aring;llare f&ouml;r bildspel' title='Platsh&aring;llare f&ouml;r bildspel' class='slideshow_bg' src='" . get_template_directory_uri() . "/image.php?w=".$default_settings[$thumbsize][0]."&amp&h=".$default_settings[$thumbsize][1]."'/>";
				$retValue .= "<span class='prevslide'></span><span class='nextslide'></span>";
			}
			$retValue .= "</div></div>"; 
		}
 	endif; 
	
	
	// try CBIS image if no image found yet
	if ($retValue == "") :
		$cbisimage = get_post_meta($id, "cbis_mediaobject", true);
		$cbisimages = unserialize($cbisimage);
		if ($showAll) { $slideshowclass = "slideshow"; }
		$countSlides = 0;
		$count = 0;
		$src_append = "&width=".$default_settings[$thumbsize][0]."&height=".$default_settings[$thumbsize][1]."&crop=1";
		$caption = ""; // TODO add in option
		
		/* get special thumb image if thumbnail */
		if ($thumbsize == "thumbnail-image") {
			$cbis_thumbimageurl = get_post_meta($id, "cbis_thumbimageurl", true);
			if (!empty($cbis_thumbimageurl) && $cbis_thumbimageurl != "") {
				$cbisimages = array();
				$cbisimages[] = (object)array("Url" => $cbis_thumbimageurl, "Description" => $caption);
			}
		}
		/* return image or slides if images is found */
		if (!empty($cbisimages)) {
			
			if (!$only_img) {
				$retValue .= "<div class='img-wrapper ".$class."'><div class='$slideshowclass'>";
			}
			while( $count < count($cbisimages) && ($showAll || $countSlides == 0)) : // only once if not showAll
			
				$image = $cbisimages[$count];
				$src = $image->Url;
				$alt = $title = $image->Description;
				if (!empty($src)) {
					if ($countSlides > 0) {
						$style = "style='display: none;'";
					}
					if (!$only_img) {
						$retValue .= "<div class='slide' $style>";
					}
					$retValue .= "<img src='$src$src_append' alt='$alt' title='$alt' />";
					if (!$only_img) {
						if ($caption != "") {
							$retValue .= "<span class='image-caption'>$caption</span>";
						}
						$retValue .= "</div>";
					}
					$countSlides++;
				}
				$count++;
			endwhile;
			/* print placeholder if slideshow */
			if (!$only_img) {
				if ($showAll && $countSlides > 1) {
					$retValue .= "<img alt='Platsh&aring;llare f&ouml;r bildspel' title='Platsh&aring;llare f&ouml;r bildspel' class='slideshow_bg' src='" . get_template_directory_uri() . "/image.php?w=".$default_settings[$thumbsize][0]."&amp&h=".$default_settings[$thumbsize][1]."' />";
					$retValue .= "<span class='prevslide'></span><span class='nextslide'></span>";
				}
				$retValue .= "</div></div>"; 
			}
		}
		/*
		$cbisimage = get_post_meta($id, "cbis_image_url", true);
		$src = "$cbisimage&width=".$default_settings[$thumbsize][0]."&height=".$default_settings[$thumbsize][1]."&crop=1";
		$retValue .= "<div class='img-wrapper ".$class."'>";
			$retValue .= "<div class='slide'>";
			$retValue .= "<img src='$src' alt='$alt' />";
			$retValue .= "<span class='image-caption'>K&auml;lla: visithultsfred.se </span>";
			$retValue .= "</div>";
		$retValue .= "</div>";
		*/

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
		$time = "Granskad: <time datetime='$time' class='updated created-date'>" . hk_theme_nicedate($time) . "</time>";// (skapad: <span class='created-date'>" . get_the_date() . "</span>)";
	}
	else {
		$time = "Skapad: <span class='created-date'>" . get_the_date() . "</span>";
	}
	return $time;
}
if (!function_exists("hk_theme_nicedate")) {
	function hk_theme_nicedate($time) {
		$time = date("j F, Y" , $time);
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
// return true if current category is a sub firstpage, i.e. category level is one above num_levels_in_menu
function is_sub_sub_category_firstpage() {
	global $default_settings;
	if ( !isset($default_settings["is_sub_sub_category_firstpage"]) ) {
		$cat = get_query_var("cat");
		if ( isset($cat) && hk_countParents($cat) == $default_settings["num_levels_in_menu"] ) {
			$default_settings["is_sub_sub_category_firstpage"] = true;
		} else {
			$default_settings["is_sub_sub_category_firstpage"] = false;
		}
	}
	return $default_settings["is_sub_sub_category_firstpage"];
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

/*
 * Get tags available in $varcat category or one of the children
 * https://wordpress.org/support/topic/get-tags-specific-to-category
 */
function hk_get_category_tags($varcat = "") {
	global $wpdb, $default_settings;

	//$cat_ids = array($varcat);
	//$cat_ids = hk_getChildrenIdArray(hk_getMenuParent($varcat)); // get closes menu parent
	
	$cat_ids = hk_getChildrenIdArray($varcat); // get child ids
	$cat_ids[] = $varcat; // add current id
	$varcat_where_or = "";
	if ($varcat != "") {
		$varcat_where_or = "(1 = 0 \n";
		foreach($cat_ids as $cat_id) :
			$varcat_where_or .= "OR terms1.term_ID = '$cat_id' \n";
		endforeach;
		$varcat_where_or .= " ) AND ";
	}
	$hidden_cat = $hidden_cat1 = $hidden_cat2 = "";
	if ($default_settings["hidden_cat"] != "") {
		$hidden_cat = $default_settings["hidden_cat"];
	}
	
	$query = "SELECT DISTINCT
	       terms2.term_id as tag_ID,
	       terms2.name as tag_name,
	       terms2.slug as tag_slug
	       FROM
		       $wpdb->posts as p1
		       LEFT JOIN $wpdb->term_relationships as r1 ON p1.ID = r1.object_ID AND p1.post_status = 'publish' AND p1.post_type = 'post'
		       LEFT JOIN $wpdb->term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id AND t1.taxonomy = 'category'
		       LEFT JOIN $wpdb->terms as terms1 ON t1.term_id = terms1.term_id,

		       $wpdb->posts as p2
		       LEFT JOIN $wpdb->term_relationships as r2 ON p2.ID = r2.object_ID AND p2.post_status = 'publish' AND p2.post_type = 'post'
		       LEFT JOIN $wpdb->term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id AND t2.taxonomy = 'post_tag'
		       LEFT JOIN $wpdb->terms as terms2 ON t2.term_id = terms2.term_id
	       WHERE (
		     $varcat_where_or 
			 terms2.term_id IS NOT NULL AND
		     p1.ID = p2.ID AND
		     p1.ID NOT IN (SELECT p3.ID FROM $wpdb->posts as p3 
			     LEFT JOIN $wpdb->term_relationships as r3 ON p3.ID = r3.object_ID AND p3.post_status = 'publish'
			     WHERE r3.term_taxonomy_ID = '$hidden_cat')      )
		   ORDER BY tag_name
			     ";
	$category_tags = $wpdb->get_results($query);
	return $category_tags;
}

/*
 * Generate tag link in tag navigation (wrapped in <li>)
 */
function hk_generate_tag_link($tagitem, $a_class = "") {
	$currtagslug = $tagitem->tag_slug;
	$tags_filter = get_query_var("tag");
	
	
	$term_id = get_query_var("cat"); // just current cat
	//$term_id = hk_getMenuParent(get_query_var("cat")); // get closes menu parent
	
	
	$orderby = (isset($_REQUEST["orderby"]))?$_REQUEST["orderby"]:"";
	if ($orderby != "") {
		$orderby = "&orderby=$orderby";
	}
	if (!empty($tags_filter))
		$tag_array = explode(",",$tags_filter);
	
	if(!empty($tag_array) && in_array($currtagslug, $tag_array)) {
		$current_tag = true;
		$tags_filter = "?tag=";
	}
	else { 
		$tags_filter = "?tag=".$currtagslug;
	}

	
	// generate tag link
	if (empty($term_id)) {
		$href = get_site_url() . $tags_filter. $orderby;
	}
	else {
		$href = get_category_link( $term_id ) . $tags_filter. $orderby;
	}
	
	if ($a_class != "") {
		$a_class = "class='$a_class'";
	}

	$link = '<a ' . $a_class . ' href="' . $href  . '" '; 
	$tag_name = $tagitem->tag_name; 
	$link .= "title='Filtrera med nyckelordet $tag_name'"; 
	$link .= '>'; 
	$link .= "$tag_name</a>"; 
	
	$output = "\t<li"; 
	$class = 'atag-item tag-item-'.$tagitem->tag_ID; 
	$icon = "";
	if ($current_tag) {
		$class .=  ' current-tag'; 
		$icon = "<a href='$href' class='delete-icon'></a>";
	}
	$output .=  ' class="'.$class.'"'; 
	$output .= ">$icon$link</li>\n"; 
	return $output;
}


function hk_getSmallWords($smallwords) {
	$smallwords = trim($smallwords);
	if (empty($smallwords)) return "";

	$arr = explode("\n",$smallwords);
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
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		// depth dependent classes
		$output .= "";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "";
	}  
	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
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
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if ($depth > 0 && $args->nav_menu_parent == $item->menu_item_parent) {
			$output .= "</li>";
		}
	
	}  
}

// topmenu walker to get second row of top menu
class hk_topmenu_walker_nav_menu extends Walker_Nav_Menu {
	  
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		// depth dependent classes
		$output .= "";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$output .= "";
	}  
	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
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
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
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


function hk_search_hook_func(){
	$searchstring = $_REQUEST["searchstring"];
	$hk_options = get_option('hk_theme');
	if ($searchstring != "") {
		// show faq search
		if($hk_options["gcse_enable_faq_search"] != ""):
			echo hk_search_and_print_faq($searchstring);
		endif;
		
		// show contacter search
		if($hk_options["gcse_enable_kontakter_search"] != ""):
			$count = 5;
			if (!empty($_REQUEST["numtele"]))
				$count = $_REQUEST["numtele"];

			echo hk_search_and_print_contacts_by_name($searchstring, array(
																'name' => true,
																'title' => true,
																'workplace' => true,
																'phone' => true,
																'email' => true,
																'heading_element' => "h3",
																'add_item_class' => 'search-item'
																), $count, true);
		endif;
		
		/* hook to be able to add other search result */ 
		do_action('hk_pre_ajax_search', $searchstring);
		
		/* hook to be able to add other search result */ 
		do_action('hk_post_ajax_search', $searchstring);
	}
	die();
	
}
add_action('wp_ajax_hk_search_hook', 'hk_search_hook_func'); 
add_action('wp_ajax_nopriv_hk_search_hook', 'hk_search_hook_func'); 



/* return current categories most viewed posts (only works if post count plugin is enabled) */
function hk_view_most_viewed_posts() {
	global $default_settings;
	
	/* view most viewed if is sub sub category firstpage and theme setting is set */
	$most_viewed = hk_get_most_viewed('post', $default_settings["show_most_viewed_in_subsubcat"]);

	if($most_viewed) {
		$output .= "<div class='most-viewed-posts-wrapper'>";
		$output .= "<div class='most-viewed-posts'>";
		foreach ($most_viewed as $post) {
			
			$post_title = get_the_title($post);
			if($chars > 0) {
				$post_title = snippet_text($post_title, $chars);
			}
			$post_excerpt = views_post_excerpt($post->post_excerpt, $post->post_content, $post->post_password, 30);
			
			$output .= "<div class='most-viewed-post'>";
			$thumb = hk_get_the_post_thumbnail($post->ID, 'thumbnail-image', false, false); 
			$output .= "<a class='$class views-cloud-item' href='" . get_permalink($post) . "' title='$post_excerpt'>";
			
			if ($thumb != "") :
				$output .= $thumb;
			else : /* else default thumb; */
				$options = get_option("hk_theme");
				$src = $options["default_thumbnail_image"]; 
				if (!empty($src)) :
				$output .= "<div class='img-wrapper '><div><img class='slide' src='$src' alt='Standardbild' title='Standardbild'></div></div>";
			endif; endif;

	
			$output .= $post_title;
			$output .= "</a></div>";
		}
		$output .= "</div>";
		$output .= "</div>";
	} else {
		$output = '';
	}
	return $output;
}

/*
 * get available image sizes
 */
function hk_get_image_sizes( $size = '' ) {

	global $_wp_additional_image_sizes;

	$sizes = array();
	$get_intermediate_image_sizes = get_intermediate_image_sizes();

	// Create the full array with sizes and crop info
	foreach( $get_intermediate_image_sizes as $_size ) {

			if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

					$sizes[ $_size ][0] = get_option( $_size . '_size_w' );
					$sizes[ $_size ][1] = get_option( $_size . '_size_h' );
					$sizes[ $_size ][2] = (bool) get_option( $_size . '_crop' );

			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {

					$sizes[ $_size ] = array( 
							$_wp_additional_image_sizes[ $_size ]['width'],
							$_wp_additional_image_sizes[ $_size ]['height'],
							$_wp_additional_image_sizes[ $_size ]['crop']
					);

			}

	}

	// Get only 1 size if found
	if ( $size ) {

			if( isset( $sizes[ $size ] ) ) {
					return $sizes[ $size ];
			} else {
					return false;
			}

	}

	return $sizes;
}

/*
	get faq/vanliga fragor
*/
function hk_search_and_print_faq($search) {
	global $wpdb, $hk_options;
	
	//$search = mb_convert_encoding($search, "ISO-8859-1");
	$id_array = array();
	$retVal = "";
	$search = trim($search);
	// search in faq meta with words in order
	if (!empty($search)) {
		$postarray = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT $wpdb->posts.ID, $wpdb->postmeta.meta_value  FROM $wpdb->posts, $wpdb->postmeta 
		WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->posts.post_type = 'post' 
		AND ($wpdb->postmeta.meta_key LIKE 'hk_vanliga_fragor%%' AND $wpdb->postmeta.meta_value LIKE '%%%s%%')", $search ), "ARRAY_A");
		foreach($postarray as $arr) {
			$id_array[implode("|",$arr)] = 1;
		}
	}
	
	// search in faq meta with each word, ignoring words in faq_search_ignore_words
	if (count($id_array) <= 0 && !empty($hk_options["faq_search_ignore_words"])) {
		
		foreach(preg_split("/[\s,]+/", $search, NULL, PREG_SPLIT_NO_EMPTY) as $val) {
			$val = trim($val);
			//$retVal .= print_r(explode(", ",$hk_options["faq_search_ignore_words"]),true);
			if (!empty($val) && !in_array($val, explode(", ",$hk_options["faq_search_ignore_words"]))) {
				$postarray = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT $wpdb->posts.ID, $wpdb->postmeta.meta_value  FROM $wpdb->posts, $wpdb->postmeta 
				WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->posts.post_type = 'post' 
				AND ($wpdb->postmeta.meta_key LIKE 'hk_vanliga_fragor%%' AND $wpdb->postmeta.meta_value LIKE '%%%s%%')", $val ), "ARRAY_A");
				// count if faq is found more than once
				foreach($postarray as $arr) {
					$a = implode("|",$arr);
					if (array_key_exists($a, $id_array)) {
						$id_array[$a]++;
					} else {
						$id_array[$a] = 1;
					}
				}
			}
		}
		// sort on most counted
		arsort($id_array);
	}
	
	// search in faq meta with each word
	if (count($id_array) <= 0) {
		
		foreach(preg_split("/[\s,]+/", $search, NULL, PREG_SPLIT_NO_EMPTY) as $val) {
			$val = trim($val);
			if (!empty($val)) {
				$postarray = $wpdb->get_results( $wpdb->prepare( "SELECT DISTINCT $wpdb->posts.ID, $wpdb->postmeta.meta_value  FROM $wpdb->posts, $wpdb->postmeta 
				WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->posts.post_type = 'post' 
				AND ($wpdb->postmeta.meta_key LIKE 'hk_vanliga_fragor%%' AND $wpdb->postmeta.meta_value LIKE '%%%s%%')", $val ), "ARRAY_A");
				// count if faq is found more than once
				foreach($postarray as $arr) {
					$a = implode("|",$arr);
					if (array_key_exists($a, $id_array)) {
						$id_array[$a]++;
					} else {
						$id_array[$a] = 1;
					}
				}
			}
		}
		// sort on most counted
		arsort($id_array);
	}
	
	// return empty if no hits
	if (count($id_array) <= 0) {
		return "";
	}
	// else return values
	else {
		// print title
		$retVal .= "<div class='search-wrapper'>";
		$retVal .= "<div class='search-title'>";
		$retVal .= /*"<span class='faq-icon'></span>*/"<span>Letar du efter</span>";
		$retVal .= "</div>";

		// print $max number values
		$count = 1;
		$max = 5;
		foreach ($id_array as $arr => $c) {
			$arr = explode("|",$arr);
			if (!empty($arr) && count($arr) == 2) { // check if valid content
				$url = get_permalink($arr[0]); // get link
				$value = $arr[1]; // get question
				if (!empty($value) && $url) { // check not empty content
					$retVal .= "<div class='search-item-area faq-wrapper'>";
					$retVal .= "<a href='$url' class='gtm-faq-item'>";
					$retVal .= $value;
					$retVal .= "</a></div>";
					if ($count++ >= $max) { // break when $max
						break;
					}
				}
			}
		}
		$retVal .= "</div>";

		return $retVal;
	}
}

/* AMP plugin, see info: https://github.com/Automattic/amp-wp/blob/master/readme.md */

/* AMP style */
add_action( 'amp_post_template_css', 'hk_amp_additional_css_styles' );

function hk_amp_additional_css_styles( $amp_template ) {
    // only CSS here please...
	global $hk_options;
	$logo = $hk_options["logo_mobile_image"];
	$svg_logo = $hk_options["logo_mobile_image_svg"];
	if (empty($logo)) {
		$logo = $hk_options["logo_image"];
	}
	if (empty($svg_logo)) {
		$svg_logo = $hk_options["logo_image_svg"];
	}
?>
	amp-img {
	    border-radius: 3px;
	}
	html, 
	.amp-wp-content,
	.wp-caption-text {
		font-family: "Segoe UI",Arial,sans-serif;
		color: #3e3e3f;
		font-size: 14px;
		font-size: 0.93333rem;
		line-height: 1.71429;
	}
	h1, 
	.amp-wp-title {
		font-family: Arial;
		font-size: 20px;
		font-size: 1.33333rem;
		margin: 0;
	}
	.wp-caption-text {
		padding: 0;
	}
	.amp-wp-meta {
		display: none;
	}
    nav.amp-wp-title-bar {
		margin: 0 auto;
		max-width: 605px;
        padding: 16px;
        background: #fff;
    }
	nav.amp-wp-title-bar div {
		margin: 0;
	}
    nav.amp-wp-title-bar a {
        background-image: url( '<?php echo $logo; ?>' );
        background-repeat: no-repeat;
        background-size: contain;
        display: block;
        height: 45px;
        width: 180px;
        text-indent: -9999px;
    }
	.amp-wp-footer ul {
		list-style: none;
		margin: 0;
		padding: 0;
	}
	.amp-wp-footer li.title {
		font-weight: bold;
	}
    <?php
}
/* AMP featured image */
add_action( 'pre_amp_render_post', 'hk_amp_add_custom_actions' );
function hk_amp_add_custom_actions() {
    add_filter( 'the_content', 'hk_amp_add_featured_image' );
}

function hk_amp_add_featured_image( $content ) {

	$thumb = hk_get_the_post_thumbnail(get_the_ID(),'featured-image', false, false, "", true); 
	if ($thumb != "") :
        $content = $thumb . $content;
	endif;
	
    return $content;
}

/* AMP width */
add_filter( 'amp_content_max_width', 'hk_amp_change_content_width' );

function hk_amp_change_content_width( $content_max_width ) {
    return 605;
}

add_filter( 'amp_post_template_analytics', 'hk_amp_add_custom_analytics' );
function hk_amp_add_custom_analytics( $analytics ) {
	global $hk_options;
	
    if ( ! is_array( $analytics ) ) {
        $analytics = array();
    }

	if (!empty($hk_options["amp_analytics"])) {
		// https://developers.google.com/analytics/devguides/collection/amp-analytics/
		$analytics['xyz-googleanalytics'] = array(
			'type' => 'googleanalytics',
			'attributes' => array(
				// 'data-credentials' => 'include',
			),
			'config_data' => array(
				'vars' => array(
					'account' => $hk_options["amp_analytics"]
				),
				'triggers' => array(
					'trackPageview' => array(
						'on' => 'visible',
						'request' => 'pageview',
					),
				),
			),
		);
	}

    return $analytics;
}

/* AMP meta */
add_filter( 'amp_post_template_meta_parts', 'hk_amp_remove_author_meta' );

function hk_amp_remove_author_meta( $meta_parts ) {
    //print_r($meta_parts);
	//foreach ( array_keys( $meta_parts, 'meta-author', true ) as $key ) {
        //unset( $meta_parts[ $key ] );
    //}
    return array();
}
/* AMP head and footer */
add_action( 'amp_post_template_head', 'hk_amp_add_head' );

function hk_amp_add_head( $amp_template ) {
    $post_id = $amp_template->get( 'post_id' );
    
}

add_action( 'amp_post_template_footer', 'hk_amp_add_footer' );

function hk_amp_add_footer( $amp_template ) {
    $post_id = $amp_template->get( 'post_id' );
	echo "<div class='amp-wp-content  amp-wp-footer'>";
	include("inc/hk-aside-content.php");
	echo "</div>";
}
?>