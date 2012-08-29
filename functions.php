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
								'news_cat' => $options["news_cat"]);
}

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

	// Grab hk sort-order function
	require( get_template_directory() . '/inc/hk-acf-fields.php' );

	// Registers taxonomy add-on for Advanced Custom Fields
	if (function_exists("register_field")) {
		register_field('Tax_field', dirname(__File__) . '/inc/acf-tax.php');
	}

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Primary Menu', 'twentyeleven' ) );
	
	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );
	
	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );
}
endif; // hk_setup



/*
 * Add unfiltered_html capabilities to administrator, editor and author
 */
function add_theme_caps() {
	$role = get_role( 'administrator' ); 
	$role->add_cap( 'unfiltered_html' ); 
	$role = get_role( 'editor' ); 
	$role->add_cap( 'unfiltered_html' );
	$role = get_role( 'author' ); 
	$role->add_cap( 'unfiltered_html' );	 
}
add_action( 'admin_init', 'add_theme_caps');


/*
 * Change the WYSIWYG editor buttons
 */
function hk_formatTinyMCE($in)
{
//	$in['remove_linebreaks']=false;
//	$in['gecko_spellcheck']=false;
//	$in['keep_styles']=false;
//	$in['accessibility_focus']=true;
//	$in['tabfocus_elements']='major-publishing-actions';
//	$in['media_strict']=false;
//	$in['paste_remove_styles']=true;
//	$in['paste_remove_spans']=true;
//	$in['paste_strip_class_attributes']='none';
//	$in['paste_text_use_dialog']=true;
//	$in['wpeditimage_disable_captions']=true;
//	$in['plugins']='inlinepopups,tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen';
//	$in['content_css']=get_template_directory_uri() . "/editor-style.css";
//	$in['wpautop']=true;
//	$in['apply_source_formatting']=false;
	$in['theme_advanced_buttons1']='formatselect,removeformat,|,bold,italic,|,bullist,numlist,blockquote,|,link,unlink,|,charmap,|,spellchecker,|,undo,redo,|,wp_fullscreen';
	$in['theme_advanced_buttons2']='';
	$in['theme_advanced_buttons3']='';
	$in['theme_advanced_buttons4']='';
	return $in;
}
add_filter('tiny_mce_before_init', 'hk_formatTinyMCE' );



/* 
 * Media Library and images
 */

// add custom "mime types" (file supertypes)
function filterPostMimeTypes($post_mime_types) {
    $post_mime_types['application'] = array('Document', 'Hantera documents', _n_noop('Dokument <span class="count">(%s)</span>', 'Dokument <span class="count">(%s)</span>'));
    $post_mime_types['audio'] = array('Audio', 'Hantera ljud', _n_noop('Ljud <span class="count">(%s)</span>', 'Ljud <span class="count">(%s)</span>'));
    $post_mime_types['video'] = array('Video', 'Hantera video', _n_noop('Video <span class="count">(%s)</span>', 'Video <span class="count">(%s)</span>'));
    return $post_mime_types;
}
add_filter('post_mime_types', 'filterPostMimeTypes');

// Add Hultsfredskommun custom image sizes.
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'thumbnail-image',  $default_settings['thumbnail-image'][0], $default_settings['thumbnail-image'][1], $default_settings['thumbnail-image'][2] );
	add_image_size( 'featured-image',  $default_settings['featured-image'][0], $default_settings['featured-image'][1], $default_settings['featured-image'][2] );
	add_image_size( 'slideshow-image',  $default_settings['slideshow-image'][0], $default_settings['slideshow-image'][1], $default_settings['slideshow-image'][2] );
	add_image_size( 'contact-image',  $default_settings['contact-image'][0], $default_settings['contact-image'][1], $default_settings['contact-image'][2] );
}

// remove width and height attr on img tags
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );



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
		array('jquery','jquery-ui-core','history_js'), /*,'jquery-ui-tabs'*/
		'1.0',
		true
	);
	wp_enqueue_script(
		'cycle_lite_js',
		get_stylesheet_directory_uri() . '/js/jquery.cycle.lite.js',
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
 * Alter the default admin menus, settings and looks.
 * Change name of menus in admin 
 */


// remove links/menus from the admin bar 
function hk_admin_bar_render() { 
	global $wp_admin_bar; 
    if (!current_user_can("administrator")) {
		$wp_admin_bar->remove_menu('new-content'); 
	}
} 
add_action( 'wp_before_admin_bar_render', 'hk_admin_bar_render' ); 

/* change names in admin menus */
function change_post_menu_label() {
    global $menu;
	global $submenu;

    $menu[5][0] = 'Sidor';
    $submenu['edit.php'][5][0] = 'Sidor';
    $submenu['edit.php'][10][0] = 'Skapa ny';
    //$submenu['edit.php'][15][0] = 'Status'; // Change name for categories
    //$submenu['edit.php'][16][0] = 'Labels'; // Change name for tags
    if (!current_user_can("administrator")) {
	    $menu[20][0] = 'Special';
	    $submenu['edit.php?post_type=page'][5][0] = 'Special';
	    $submenu['edit.php?post_type=page'][10][0] = 'Skapa';
	    $submenu['edit.php?post_type=page'][5][0] = 'Special';
	}

    // hide linkmanager
    unset($menu[15]);

    // hide tag divs if not administrator
    if (!current_user_can("administrator")) {
    	// hide category submenu
	    unset($submenu['edit.php'][15][0]);
    	// hide tags submenu
	    unset($submenu['edit.php'][16][0]);
	    // hide pages menu "special"
	    unset($menu[20]);
	    // hide meta tag boxes in edit
    	remove_meta_box("tagsdiv-post_tag","post");
    	remove_meta_box("tagsdiv-vem","post");
    	remove_meta_box("tagsdiv-ort","post");
	}
    echo '';
}


/* change names in admin pages */
function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Sidor';
    $labels->singular_name = 'Sida';
    $labels->add_new = 'L&auml;gg till';
    $labels->add_new_item = 'L&auml;gg till sida';
    $labels->edit_item = '&Auml;ndra sida';
    $labels->new_item = 'Sida';
    $labels->view_item = 'Visa sida';
    $labels->search_items = 'S&ouml;k';
    $labels->not_found = 'Hittade inga sidor';
    $labels->not_found_in_trash = 'Hittade inga sidor i papperskorgen';

    $labels = &$wp_post_types['page']->labels;
    $labels->name = 'Special';
    $labels->singular_name = 'Special';
    $labels->add_new = 'L&auml;gg till';
    $labels->add_new_item = 'L&auml;gg till';
    $labels->edit_item = '&Auml;ndra';
    $labels->new_item = 'Ny';
    $labels->view_item = 'Visa';
    $labels->search_items = 'S&ouml;k';
    $labels->not_found = 'Hittade inga';
    $labels->not_found_in_trash = 'Hittade inga i papperskorgen';
}
if (is_admin()) {
	add_action( 'init', 'change_post_object_label' );
	add_action( 'admin_menu', 'change_post_menu_label' );
}
/* remove unwanted fields from media library items */
function remove_media_upload_fields( $form_fields, $post ) {
    //unset( $form_fields['image-size'] );
    unset( $form_fields['post_excerpt'] );
    unset( $form_fields['image_alt'] );
    //unset( $form_fields['post_content'] );
    //unset( $form_fields['url'] );
    //unset( $form_fields['image_url'] );
    //unset( $form_fields['align'] );
    
    return $form_fields;
}
add_filter('attachment_fields_to_edit', 'remove_media_upload_fields', null, 2);



/**
 * force install plugins "direct"  
 */
add_filter( 'filesystem_method', create_function( '$a', 'return "direct";' ) );



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

/**
 * Return the URL for the first link found in the post content.
 *
 * @since Twenty Eleven 1.0
 * @return string|bool URL or false when no link is present.
 */
function twentyeleven_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) )
		return false;

	return esc_url_raw( $matches[1] );
}


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

if ( ! function_exists( 'twentyeleven_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own twentyeleven_posted_on to override in a child theme
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_posted_on() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentyeleven' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_body_classes( $classes ) {

	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
		$classes[] = 'singular';

	return $classes;
}
add_filter( 'body_class', 'twentyeleven_body_classes' );
