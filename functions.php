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
define("HK_VERSION", "7.3");

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
								'use_dynamic_posts_load_in_category' => (!empty($hk_options["use_dynamic_posts_load_in_category"]))?$hk_options["use_dynamic_posts_load_in_category"]:'',
								'hide_articles_in_subsubcat' => (!empty($hk_options["hide_articles_in_subsubcat"]))?$hk_options["hide_articles_in_subsubcat"]:'',
								'category_slideshow_thumbnail_size' => $hk_options["category_slideshow_thumbnail_size"],
								'show_articles' => true,
								'video_thumbnail_image' => $hk_options["video_thumbnail_image"],
								'new_mobile_menu' => (!empty($hk_options["new_mobile_menu"])) ? $hk_options["new_mobile_menu"] : '',

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
    		//	'walker' 	     => new Walker_Category_Posts()
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

	//if (is_user_logged_in()) {
		//die("Sidan håller på att flyttas, försök om någon timme igen.");
	//}
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
	add_filter('wp_mail_content_type',function() {return "text/html";});

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
function hk_acf_init() {
	$hk_options = get_option("hk_theme");
	if (isset($hk_options['googlemapskey']) && $hk_options['googlemapskey'] != "") {
		acf_update_setting('google_api_key', $hk_options['googlemapskey']);
	}
}
add_action('acf/init', 'hk_acf_init');

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
			//$readspeaker_url = '//cdn1.readspeaker.com/script/'.$hk_options['readspeaker_id'].'/ReadSpeaker.js?pids=embhl&skin=ReadSpeakerCompactSkin';
			$readspeaker_url = '//cdn1.readspeaker.com/script/'.$hk_options['readspeaker_id'].'/webReader/webReader.js?pids=wr';

			wp_enqueue_script(
				'readspeaker_js',
				$readspeaker_url,
				array(),
				'1.0',
				true
			);
		}

		if (isset($hk_options['googlemapskey']) && $hk_options['googlemapskey'] != "") {
			wp_enqueue_script(
				'google_map_js',
				'//maps.google.com/maps/api/js?sensor=false&key='.$hk_options['googlemapskey'],
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
		}

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
	$paged = get_query_var("paged");
	$filter = array("cat" => $cat, "paged" => $paged, "orderby" => $orderby, "category_as_filter" => (!empty($default_settings["category_as_filter"])) ? $default_settings["category_as_filter"] : '', "category_show_children" => (!empty($default_settings["category_show_children"])) ? $default_settings["category_show_children"] : '');
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
			'admin_ajax_url' => '/wp-admin/admin-ajax.php',
			'addthis_pubid_admin' => $hk_options['addthis_pubid_admin'],
			'cookie_accept_enable' => (!empty($hk_options['cookie_accept_enable'])) ? $hk_options['cookie_accept_enable'] : '',
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

add_action('wp_head', 'add_jsonld_head', 1);
function add_jsonld_head() {
		//$post_ID = get_the_id();

		?>
		<script type="application/ld+json">
			{
			  "@context": "https://www.schema.org",
<?php
				$posttags = get_the_tags();
				$postcats = get_the_category();
				$type_array = array();
				$is_news_article = false;
				if ( is_single() ) {
					$og_image = hk_get_the_post_thumbnail_og_image(get_the_ID());
				}
				if ($posttags) {
					foreach($posttags as $tag) {
						if ($tag->name == "Nyheter") {
							$is_news_article = true;
						}
			  		$type_array[] = $tag->slug;
					}
				}
				if ($postcats) {
					foreach($postcats as $cat) {
						$parentcats = hk_get_parent_categories_from_cat($cat->cat_ID);
						$catname = get_category($parentcats[0])->slug;
						if ($catname != "" && !in_array($catname,$type_array) ) { $type_array[] = $catname; }
						$catname = get_category($parentcats[1])->slug;
						if ($catname != "" && !in_array($catname,$type_array) ) { $type_array[] = $catname; }
			  		$catname = $cat->slug;
						if ($catname != "" && !in_array($catname,$type_array) ) { $type_array[] = $catname; }
					}
				}

				if ($type_array) {

					$type_count = 0;
					foreach($type_array as $type_item) {
						$type_count++;
						$end_sign = ',';
						if (count($type_array) == $type_count && !$is_news_article) {
							$end_sign = '';
						}
						?>
  					"post_type_<?php echo $type_count; ?>" : { "@type": "<?php echo $type_item; ?>" }<?php echo $end_sign."\n";
			 		}//end foreach type_array
				}//end if type_array
				if ($is_news_article) {
					?>
					"news": { "@type": "NewsArticle",
						"headline": "<?php the_title(); ?>",
						"image": [
							"<?php echo $og_image; ?>"
					 	] }
<?php
				}
			?>
			}
		</script>
		<?php if ( !empty($og_image) ) { ?>
				<meta property="og:image" content="<?php echo $og_image; ?>">
		<?php	} // end if og_image
}



/*
 * Make shortcodes work in widgets
 */
add_filter('widget_text', 'do_shortcode');



/**
 * Remove the gallery inline css
 */
add_filter('gallery_style', 'hk_remove_inline_css');
function hk_remove_inline_css ($css) {
		return preg_replace("#<style type=\'text/css\'>(.*?)</style>#s", "", $css);
}
/*
 * Alter excerpt - add link on three first words
 */

add_filter('the_excerpt', 'hk_excerpt');
function hk_excerpt($content) {
	if (is_search()) {
        return $content;
    }
    /*else if ($_REQUEST["action"] == "hk_search" && $_REQUEST["searchstring"] != "") {
        relevanssi_the_excerpt(); // not showing same as search excerpt
        $content = apply_filters(‘relevanssi_excerpt_content’, $content, $post, $query);
        return $content;
    }*/


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

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() ) {
		$classes[] = 'single-author';
	}
	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) ) {
		$classes[] = 'singular';
	}
	if ( is_singular() ) {
		$current_cat = get_the_category();
		$cat_string = "";
		foreach ($current_cat as $value) {
			$parent_cat = get_category($value->category_parent);
			$cat_string .= $value->slug;
			$cat_string .= $parent_cat->slug;
		}
		if ( strpos($cat_string,"lattlast") !== false ) {
				$classes[] = "lattlast";
		}
	}

	if ( is_category() ) {
		$current_cat = get_query_var('cat');
		if ($current_cat > 0 ) {
			$current_cat = get_category($current_cat);
			$parent_cat = get_category($current_cat->category_parent);
			if ( (!empty($current_cat) && strpos($current_cat->slug,"lattlast") !== false) ||
					 (!empty($parent_cat) && strpos($parent_cat->slug,"lattlast") !== false) ) {
	 				$classes[] = "lattlast";
			}
		}
	}
	$classes[] = "bodytest";
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

/* help function to get og:image thumbnail */
function hk_get_the_post_thumbnail_og_image($id, $thumbsize = 'featured-image') {
	/* check if ACF is enabled and if field hk_featured_images exists */
	if( function_exists("get_field") && get_field('hk_featured_images', $id) ) :
		while( has_sub_field('hk_featured_images', $id) ) : // only once if not showAll
			$image = get_sub_field('hk_featured_image');
			$src = (!empty($image["sizes"]) && !empty($image["sizes"][$thumbsize])) ? $image["sizes"][$thumbsize] : "";

			if (!empty($src)) {
				reset_rows();
				return $src;
			}
			reset_rows();
			return '';
  	endwhile;
 	endif;
}

/* help function to render custom thumbnail functionality */
function hk_get_the_post_thumbnail($id, $thumbsize, $showAll=true, $echo=true, $class="", $only_img=false) {
	global $default_settings;
	$retValue = "";
	$slideshowclass = '';
	/* check if ACF is enabled and if field hk_featured_images exists */
	if( function_exists("get_field") && get_field('hk_featured_images', $id) ) :
		if ($showAll) { $slideshowclass = "slideshow"; }
		$countSlides = 0;
		if (!$only_img) {
			$retValue .= "<div class='img-wrapper ".$class."'><div class='$slideshowclass'>";
		}
		while( has_sub_field('hk_featured_images', $id) && ($showAll || $countSlides == 0)) : // only once if not showAll
			$image = get_sub_field('hk_featured_image');
			$src = (!empty($image["sizes"]) && !empty($image["sizes"][$thumbsize])) ? $image["sizes"][$thumbsize] : "";
			$caption = $image["caption"];
			$title = $image["title"];
			$alt = $image["alt"];
			$source = get_field("source",$image["id"]);
			$style = '';
			if ($alt == "") {
				$alt = $title;
			}

			if (!empty($src)) {
				if ($default_settings[$thumbsize][0] == $image["sizes"][$thumbsize . "-width"] && $default_settings[$thumbsize][1] == $image["sizes"][$thumbsize . "-height"]) {
					if ($countSlides > 0) {
						$style = "style='display: none;'";
					}
					$src = str_replace("http://", "", $src);
					$src = str_replace("https://", "", $src);
					$src = str_replace($_SERVER['SERVER_NAME'], "", $src);
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
				$retValue .= "<img alt='' title='' role='presentation' class='slideshow_bg' src='" . get_template_directory_uri() . "/image.php?w=".$default_settings[$thumbsize][0]."&amp&h=".$default_settings[$thumbsize][1]."'/>";
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
				$alt = $title = (!empty($image->Description)) ? $image->Description : '';
				$style = '';
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
	$children = get_term_children($cat, 'category');
    return $children;
    //OLD $children = get_categories(array('child_of' => $cat, 'hide_empty' => false));
    //print_r($children);
	//$retArray = array();
	//foreach($children as $child) {
	//	$retArray[] = $child->term_id;
	//}
	//return $retArray;
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

// new topmenu walker to get second row of top menu
class hk_newtopmenu_walker_nav_menu extends Walker_Nav_Menu {

	// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}
	function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
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
		$cat_class = (!empty($item->object) && !empty($item->object_id) && !empty($args->current_category) &&
		 							$item->object == "category" && $item->object_id == $args->current_category) ? "current-menu-item" : "";

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
		//echo "<br>";
		//print_r($item);

		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

		// add categories
		if ($depth == 1) {
			//$output .= "<ul data-depth='depth-$depth-".$item->object_id."'><li>";
			$output .= hk_newtop_categories($item->object_id);
			//$output .= "</li></ul>";
		}
	}
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>";
	}
}
function hk_newtop_categories($currentcat) {
	global $post, $default_settings;

	$output = "";

	// get category
    $cat = get_query_var("cat");
    $hk_mobilemenu_walker = new hk_mobilemenu_walker();
	$args = array(
		'orderby'            => 'name',
		'order'              => 'ASC',
		'style'              => 'list',
		'hide_empty'         => 0,
		'use_desc_for_title' => 1,
		'child_of'           => $currentcat,
		'hierarchical'       => true,
		'title_li'           => '',
		'show_option_none'   => '',
		'echo'               => 0,
		'depth'              => 3,
		'taxonomy'           => 'category',
		'exclude'			 => $default_settings["hidden_cat"],
		'walker'			 => $hk_mobilemenu_walker,
		'current_category'	 => $cat
	);

	//echo "<a class='dropdown-nav'>" . get_the_category_by_ID($parentCat) . "</a>";

	$output .= /*"cat: $cat - $currentcat - $parentCat - */"<ul class='parent'>";
	/*if ($parentCat == $cat) {
		$currentcatclass = 'current-cat';
	}*/
	//$output .= "<ul><li class='heading $currentcatclass current-cat-parent cat-has-children'>";//<a href='#' class='cat-icon'><a href='".get_category_link($currentcat)."'>".get_the_category_by_ID($currentcat)."</a></li></ul></li>";
	$output .= wp_list_categories( $args );
	//$output .= "</li></ul>";

    /* show tags */
	// TODO - handle tags if more than one category!!
	$output .= hk_displayAllTagFilter(false, "more-navigation", false, "", $currentcat, true);

	$output .= "</ul>";



	return $output;

}




// mobile menu walker
class hk_mobilemenu_walker extends Walker_Category {

    public $parent_cat = [];

	/**
	 * What the class handles.
	 *
	 * @since 2.1.0
	 * @access public
	 * @var string
	 *
	 * @see Walker::$tree_type
	 */
	public $tree_type = 'category';

	/**
	 * Database fields to use.
	 *
	 * @since 2.1.0
	 * @access public
	 * @var array
	 *
	 * @see Walker::$db_fields
	 * @todo Decouple this
	 */
	public $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	/**
	 * Starts the list before the elements are added.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Used to append additional content. Passed by reference.
	 * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
	 * @param array  $args   Optional. An array of arguments. Will only append content if style argument
	 *                       value is 'list'. See wp_list_categories(). Default empty array.
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Used to append additional content. Passed by reference.
	 * @param int    $depth  Optional. Depth of category. Used for tab indentation. Default 0.
	 * @param array  $args   Optional. An array of arguments. Will only append content if style argument
	 *                       value is 'list'. See wp_list_categories(). Default empty array.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
        if (!empty($this->parent_cat[$depth+1])) {
            //$output .= "$indent<li>as fd " . $this->parent_cat . "</li>";
            $output .= hk_displayAllTagFilter(false, "more-navigation", false, "", $this->parent_cat[$depth+1], true);
        }

		$output .= "$indent</ul>\n";
	}

	/**
	 * Starts the element output.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output   Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int    $depth    Optional. Depth of category in reference to parents. Default 0.
	 * @param array  $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
	 * @param int    $id       Optional. ID of the current category. Default 0.
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters(
			'list_cats',
			esc_attr( $category->name ),
			$category
		);

		// Don't generate an element if the category name is empty.
		if ( ! $cat_name ) {
			return;
		}

		$link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
		if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
			/**
			 * Filter the category description for display.
			 *
			 * @since 1.2.0
			 *
			 * @param string $description Category description.
			 * @param object $category    Category object.
			 */
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		}

		$link .= '>';
		$link .= $cat_name . '</a>';

		if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
			$link .= ' ';

			if ( empty( $args['feed_image'] ) ) {
				$link .= '(';
			}

			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

			if ( empty( $args['feed'] ) ) {
				$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
			} else {
				$alt = ' alt="' . $args['feed'] . '"';
				$name = $args['feed'];
				$link .= empty( $args['title'] ) ? '' : $args['title'];
			}

			$link .= '>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= $name;
			} else {
				$link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
			}
			$link .= '</a>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= ')';
			}
		}

		if ( ! empty( $args['show_count'] ) ) {
			$link .= ' (' . number_format_i18n( $category->count ) . ')';
		}
		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$css_classes = array(
				'cat-item',
				'cat-item-' . $category->term_id,
			);

			if ( ! empty( $args['current_category'] ) ) {
				// 'current_category' can be an array, so we use `get_terms()`.
				$_current_terms = get_terms( $category->taxonomy, array(
					'include' => $args['current_category'],
					'hide_empty' => false,
				) );

				foreach ( $_current_terms as $_current_term ) {
					if ( $category->term_id == $_current_term->term_id ) {
						$css_classes[] = 'current-cat';
					} elseif ( $category->term_id == $_current_term->parent ) {
						$css_classes[] = 'current-cat-parent';
					}
					while ( $_current_term->parent ) {
						if ( $category->term_id == $_current_term->parent ) {
							$css_classes[] =  'current-cat-ancestor';
							break;
						}
						$_current_term = get_term( $_current_term->parent, $category->taxonomy );
					}
				}
			}

			/**
			 * Filter the list of CSS classes to include with each category in the list.
			 *
			 * @since 4.2.0
			 *
			 * @see wp_list_categories()
			 *
			 * @param array  $css_classes An array of CSS classes to be applied to each list item.
			 * @param object $category    Category data object.
			 * @param int    $depth       Depth of page, used for padding.
			 * @param array  $args        An array of wp_list_categories() arguments.
			 */
			$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

			$output .=  ' class="' . $css_classes . '"';
			$output .= ">$link\n";
		} elseif ( isset( $args['separator'] ) ) {
			$output .= "\t$link" . $args['separator'] . "\n";
		} else {
			$output .= "\t$link<br />\n";
		}
        //save current parent
        $this->parent_cat[$depth] = $category->category_parent;
        //$output .= $category->cat_ID;
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page   Not used.
	 * @param int    $depth  Optional. Depth of category. Not used.
	 * @param array  $args   Optional. An array of arguments. Only uses 'list' for whether should append
	 *                       to output. See wp_list_categories(). Default empty array.
	 */
	public function end_el( &$output, $page, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$output .= "</li>\n";
	}
}


// function to set enable Hultsfred style to Max mega Menu theme selection
function megamenu_add_theme_hultsfreds_kommun_1510035476($themes) {
    $themes["hultsfreds_kommun_1510035476"] = array(
        'title' => 'Hultsfreds kommun',
        'container_background_from' => 'rgb(229, 230, 231)',
        'container_background_to' => 'rgb(229, 230, 231)',
        'container_border_radius_top_left' => '2px',
        'container_border_radius_top_right' => '2px',
        'container_border_radius_bottom_left' => '2px',
        'container_border_radius_bottom_right' => '2px',
        'menu_item_background_hover_from' => 'rgb(62, 62, 63)',
        'menu_item_background_hover_to' => 'rgb(62, 62, 63)',
        'menu_item_link_font_size' => '15px',
        'menu_item_link_color' => 'rgb(62, 62, 63)',
        'menu_item_link_padding_left' => '16px',
        'menu_item_link_padding_right' => '16px',
        'menu_item_link_border_radius_top_left' => '0',
        'menu_item_link_border_radius_top_right' => '0',
        'menu_item_link_border_radius_bottom_left' => '0',
        'menu_item_link_border_radius_bottom_right' => '0',
        'panel_header_border_color' => '#555',
        'panel_font_size' => '14px',
        'panel_font_color' => '#666',
        'panel_font_family' => 'inherit',
        'panel_second_level_font_color' => '#555',
        'panel_second_level_font_color_hover' => '#555',
        'panel_second_level_text_transform' => 'uppercase',
        'panel_second_level_font' => 'inherit',
        'panel_second_level_font_size' => '16px',
        'panel_second_level_font_weight' => 'bold',
        'panel_second_level_font_weight_hover' => 'bold',
        'panel_second_level_text_decoration' => 'none',
        'panel_second_level_text_decoration_hover' => 'none',
        'panel_second_level_border_color' => '#555',
        'panel_third_level_font_color' => '#666',
        'panel_third_level_font_color_hover' => '#666',
        'panel_third_level_font' => 'inherit',
        'panel_third_level_font_size' => '14px',
        'flyout_link_size' => '14px',
        'flyout_link_color' => '#666',
        'flyout_link_color_hover' => '#666',
        'flyout_link_family' => 'inherit',
        'toggle_background_from' => '#222',
        'toggle_background_to' => '#222',
        'toggle_font_color' => 'rgb(62, 62, 63)',
        'mobile_background_from' => '#222',
        'mobile_background_to' => '#222',
        'mobile_menu_item_link_font_size' => '14px',
        'mobile_menu_item_link_color' => '#ffffff',
        'mobile_menu_item_link_text_align' => 'left',
        'custom_css' => '/** Push menu onto new line **/
#{$wrap} {
    clear: both;
}',
    );
    $themes["visit_hultsfred_1510035537"] = array(
        'title' => 'Visit hultsfred',
        'container_background_from' => 'rgb(164, 29, 48)',
        'container_background_to' => 'rgb(164, 29, 48)',
        'container_border_radius_top_left' => '2px',
        'container_border_radius_top_right' => '2px',
        'container_border_radius_bottom_left' => '2px',
        'container_border_radius_bottom_right' => '2px',
        'menu_item_background_hover_from' => 'rgba(255, 255, 255, 0.2)',
        'menu_item_background_hover_to' => 'rgba(255, 255, 255, 0.2)',
        'menu_item_link_font_size' => '15px',
        'menu_item_link_color' => 'rgb(255, 255, 255)',
        'menu_item_link_text_decoration_hover' => 'underline',
        'menu_item_link_padding_left' => '16px',
        'menu_item_link_padding_right' => '16px',
        'menu_item_link_border_radius_top_left' => '0',
        'menu_item_link_border_radius_top_right' => '0',
        'menu_item_link_border_radius_bottom_left' => '0',
        'menu_item_link_border_radius_bottom_right' => '0',
        'menu_item_divider' => 'on',
        'menu_item_divider_glow_opacity' => '0.3',
        'panel_header_border_color' => '#555',
        'panel_font_size' => '14px',
        'panel_font_color' => '#666',
        'panel_font_family' => 'inherit',
        'panel_second_level_font_color' => '#555',
        'panel_second_level_font_color_hover' => '#555',
        'panel_second_level_text_transform' => 'uppercase',
        'panel_second_level_font' => 'inherit',
        'panel_second_level_font_size' => '16px',
        'panel_second_level_font_weight' => 'bold',
        'panel_second_level_font_weight_hover' => 'bold',
        'panel_second_level_text_decoration' => 'none',
        'panel_second_level_text_decoration_hover' => 'none',
        'panel_second_level_border_color' => '#555',
        'panel_third_level_font_color' => '#666',
        'panel_third_level_font_color_hover' => '#666',
        'panel_third_level_font' => 'inherit',
        'panel_third_level_font_size' => '14px',
        'flyout_link_size' => '14px',
        'flyout_link_color' => '#666',
        'flyout_link_color_hover' => '#666',
        'flyout_link_family' => 'inherit',
        'responsive_breakpoint' => '730px',
        'toggle_background_from' => 'rgb(164, 29, 48)',
        'toggle_background_to' => 'rgb(164, 29, 48)',
        'toggle_font_color' => 'rgb(255, 255, 255)',
        'mobile_background_from' => 'rgb(164, 29, 48)',
        'mobile_background_to' => 'rgb(164, 29, 48)',
        'mobile_menu_item_link_font_size' => '14px',
        'mobile_menu_item_link_color' => '#ffffff',
        'mobile_menu_item_link_text_align' => 'left',
        'custom_css' => '
#{$wrap} {
    clear: both;
}',
    );
    return $themes;
}
add_filter("megamenu_themes", "megamenu_add_theme_hultsfreds_kommun_1510035476");


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
		$cat_class = (!empty($item->object) && !empty($item->object_id) && !empty($args->current_category) &&
									$item->object == "category" && $item->object_id == $args->current_category) ? "current-menu-item" : "";

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

function hk_search_func(){
  global $default_settings, $post;
	$searchstring = $_REQUEST["searchstring"];
	$hk_options = get_option('hk_theme');
	if ($searchstring != "") {

        echo "<div class='islet'>";

		// show search
        $query_args = array( 's' => esc_sql($searchstring),
                             'category__not_in' => array( $default_settings["hidden_cat"] ),
);
        $query = new WP_Query( $query_args );
        if (function_exists('relevanssi_do_query')) {
            relevanssi_do_query( $query );
        }
        if ( $query->have_posts() ) :

            while ( $query->have_posts() ) : $query->the_post();

                $external_blog = false;
								if (!empty($post->blog_id)) {
	                if (get_current_blog_id() != $post->blog_id){
	                    $external_blog = true;
	                    switch_to_blog($post->blog_id);
	                }
								}
                /* Include the Post-Format-specific template for the content.
                 * If you want to overload this in a child theme then include a file
                 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                 */
                //get_template_part( 'content', get_post_type() );
                get_template_part( 'content' );
                if ($external_blog) {
                    restore_current_blog();
                }


            endwhile;

        else :
            hk_empty_search();
        endif;
        echo "</div>";

	} // end if searchstring not empty
	die();

}
add_action('wp_ajax_hk_search', 'hk_search_func');
add_action('wp_ajax_nopriv_hk_search', 'hk_search_func');



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
				$output .= "<div class='img-wrapper '><div><img class='slide' src='$src' alt='' title='' role='presentation'></div></div>";
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
	global $wpdb, $hk_options, $default_settings;

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

	/* return values */

	/* print title */
	$retVal .= "<div class='search-wrapper'>";
	$retVal .= "<div class='search-title'>";
	$retVal .= /*"<span class='faq-icon'></span>*/"<span>Letar du efter</span>";
	$retVal .= "</div>";

	/* print $max number values */
	$count = 1;
	$max = 5;
	foreach ($id_array as $arr => $c) {
		$arr = explode("|",$arr);
		if (!empty($arr) && count($arr) == 2 && !in_category( $default_settings["hidden_cat"], $arr[0] )) { // check if valid content and not in hidden_cat
			$url = get_permalink($arr[0]); // get link
			$value = $arr[1]; // get question
			// check if in hidden_cat
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

	/* return empty if noting printed */
	if ($count == 1) {
		$retVal .= "<div class='search-item-area faq-wrapper'>Hittade inga vanliga frågor med din sökning.</div>";
	}
	$retVal .= "</div>";

	return $retVal;

}

/* AMP plugin, see info: https://github.com/Automattic/amp-wp/blob/master/readme.md */

/* AMP style */
add_action( 'amp_post_template_head', 'hk_amp_additional_css_styles' );

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
?><style amp-runtime>
	/* hide stuff */
	.hidden,
	.amp-wp-article-footer,
	footer.amp-wp-footer,
	.amp-wp-meta,
	.amp-wp-author
	{
		display:none!important;
	}

	.amp-wp-header {
		background: #3d6a98!important;
	}
	.amp-wp-article,
	.amp-wp-content.amp-wp-footer
	{
		border: 0;
		color: #353535;
		font-weight: 400;
		margin: 1.5em auto;
		max-width: 840px;
		overflow-wrap: break-word;
		word-wrap: break-word;
    }

	.amp-wp-article-content,
	.amp-wp-content.amp-wp-footer .side-content
	{
		margin: 0 16px;
	}
	/* aside stuff */
	ul {
		margin-bottom: 12px!important;
		padding: 8px 0px!important;
	}
	/*ul.contacts {
		background: #E4EDF6;
	}
	ul.faq {
		background: #E5E6E7;
	}
	ul.related {
		background: #FFF3DA;
	}*/
	.aside-list-item div {
		padding: 2px 0!important;
	}

	.side-content .title {
		font-size: 18px;
	}


	amp-img {
	    border-radius: 3px;
	}
	.amp-wp-title {
		font-family: "Segoe UI",Arial,sans-serif!important;
		font-size: 28px!important;
		font-weight: bold!important;
	}
	h2 {
		margin-bottom: 0px;
	}
	p {
		margin-bottom: 2px!important;
	}
	.amp-wp-article-content ul, .amp-wp-article-content ol {
		margin-left: 20px!important;
	}
	html, body {
		background: white!important;
		font-family: "Segoe UI",Arial,sans-serif!important;
	}
	html, p,
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
    </style><?php
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

/* helper to query wp_query category arguments, used in posts_load.php and hk-category.php */
function hk_getCatQueryArgs($cat, $paged=1, $showfromchildren = false, $orderby = "", $shownposts = "", $showonlyfromcatarr = array() /*, $showonlyfromtagarr = array()*/) {

    $options = get_option("hk_theme");
	$catarray = array();
	//$tagarray = array();

	if ($shownposts == "") {
		$shownposts = array();
	}

    /* put category-children in array */
    if ($showfromchildren) {
		$catarray = hk_getChildrenIdArray($cat);
		$catarray[] = $cat; //add current category
	}
	/* if show only from some categories */
	if (!empty($showonlyfromcatarr)) {
		$catarray = $showonlyfromcatarr;
	}
	/* if also filter of tags */
	/*if (!empty($showonlyfromtagarr)) {
		$tagarray = $showonlyfromtagarr;
	}*/


    /* check if there are posts to be hidden */
    $args = array(	'posts_per_page' => -1,
                    'meta_query' => array(
                                        array(
                                            'key' => 'hk_hide_from_category',
                                            'compare' => '=',
                                            'value' => '1'
                                        )
                                    )
            );
    if ($showfromchildren) {
        $args['category__in'] = $catarray;
    }
    else {
        $args['category__and'] = array($cat);
    }
	/* filter tags */
    /*if (!empty($tagarray)) {
        $args['tag__in'] = $tagarray;
    }*/



    $dyn_query = new WP_Query();
    $dyn_query->query($args);

    /* Start the hidden posts Loop */
    $hiddenarr = array();
    while ( $dyn_query->have_posts() ) : $dyn_query->the_post();
        $hiddenarr[] = get_the_ID();
    endwhile;
    /* END get hidden */

	/* remove already shown posts from next query */
	$hiddenarr = array_merge($hiddenarr, $shownposts);

    /* do category list query args */
    $args = array(	'paged' => $paged,
                    'post__not_in' => $hiddenarr,
                 );

    /* from wich categories */
    if ($showfromchildren) {
        $args['category__in'] = $catarray;
    }
    else {
        $args['category__and'] = array($cat);
    }
    /* filter tags */
    /*if (!empty($tagarray)) {
        $args['tag__in'] = $tagarray;
    }*/

    /* if orderby not is set, check if standard order should be date in settings */
    if ($orderby == "" && $cat != "" && in_array($cat, explode(",",$options["order_by_date"])) ) {
        //$args['suppress_filters'] = 'true';
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }
    /* if orderby not is set, check if standard order should be alpha in settings */
    else if ($orderby == "" && $cat != "" && in_array($cat, explode(",",$options["order_by_alpha"])) ) {
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
    }
    /* if orderby is set manually in url */
    else if ($orderby == "latest") {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }
    /* if orderby is set manually in url */
    else if ($orderby == "oldest") {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    }
    /* standard order if views plugin exist */
    else if (function_exists( 'views_orderby' )) {
        $args['meta_key'] = 'views';
        $args['orderby'] = 'meta_value_num';
        $args['order'] = 'DESC';
    }
    /* else fallback to order by date DESC */
    else {
        $args['orderby'] = 'date';
        $args['order'] = 'DESC';
    }
    /* END get query args */

    //print_r($args);
    return $args;
}



/* Yoast fix to eneble for specific user */
if ( defined('WPSEO_VERSION') ) {
    // Disable WordPress SEO meta box and menu for users that not is yoast enabled (ACF-setting in user form)
    function wpse_init(){
        $current_user = wp_get_current_user();
        $enable_yoast = get_field('enable_yoast', 'user_'. $current_user->ID );
        if( !$enable_yoast ){
            // Remove page analysis columns from post lists, also SEO status on post editor
            add_filter('wpseo_use_page_analysis', '__return_false');
            // Remove Yoast meta boxes
            add_action('add_meta_boxes', 'disable_seo_metabox', 100000);
            // Remove Yoast from menu
            add_action('admin_menu', 'remove_wpseo_admin_menu_links');
        }
    }
    add_action('init', 'wpse_init');
    // Remove menu link
    function remove_wpseo_admin_menu_links(){
        remove_action( 'admin_bar_menu', 'wpseo_admin_bar_menu', 95 );
        remove_menu_page( 'wpseo_dashboard' );
    }
    // Remove metaboxes
    function disable_seo_metabox(){
        remove_meta_box('wpseo_meta', 'post', 'normal');
        remove_meta_box('wpseo_meta', 'page', 'normal');
    }
}
?>
