<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/* get hk_options */
	$hk_options = get_option('hk_theme');


	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );


	/* Some style generated by settings in hk-options-page */
	?><style type="text/css">
		<?php if ($hk_options["top_image"]) : ?>
		#page {
			background-image: url('<?php echo $hk_options["top_image"]; ?>');
			background-repeat: no-repeat;
			background-position: top center;
		}
		<?php endif; if ($hk_options["footer_image"]) : ?>
		body {
			background-image: url('<?php echo $hk_options["footer_image"]; ?>');
			background-repeat: no-repeat;
			background-position: bottom center;
			background-size: 100%;
		}
		<?php endif; if ($hk_options["primary_width"]) : ?>
		#primary {
			width: <?php echo $hk_options["primary_width"]; ?>;
		}
		<?php endif; if ($hk_options["sidebar_width"]) : ?>
		#sidebar-wrapper, #firstpage-sidebar {
			width: <?php echo $hk_options["sidebar_width"]; ?>;
		}
		<?php endif; ?>

	</style><?php

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed">
	<header id="branding" role="banner">
		<hgroup>
			<h1 id="logo"><span><a href="<?php echo site_url('/'); ?>"><img src="<?php echo $hk_options["logo_image"]; ?>" alt="<?php bloginfo( 'name' ); ?>" /></a></span></h1>
			
			
			<!--div id='wrapper-sHys'>
				<span id='h2-sHys'><a id='url-sHys' href="http://www.vackertvader.se/hultsfred"> Hultsfred</a></span>
				<div id='load-sHys'></div>
				<a id='url_detail-sHys' href="http://www.vackertvader.se/hultsfred">Detaljerad prognos</a>
			</div>
			<script type="text/javascript" 
					src="http://widget.vackertvader.se/widgetv3/widget_request/2704398?bgcolor=ffffff&border=none&days=2&key=-sHys&lang=&maxtemp=no&size=x120&textcolor=363636&wind=no" 
					charset="utf-8">
			</script-->
			
			
		</hgroup>
		<?php 
			if ($hk_options["topmenu"]) {
				echo "<aside id='topmenu'><nav>";
				wp_nav_menu( array(
					'menu' 			=> $hk_options["topmenu"], 
					'container' 	=> '',							
					'items_wrap'	=> '<ul>%3$s</ul>',
					'depth' 		=> 1,
					'echo' 			=> true
				)); 
				echo "</nav></aside>";
			}
		?>
		
		<div id="searchnavigation">			
			<?php get_search_form(); ?>
		</div>
		
		<nav id="menu" role="navigation">
			<a id="dropdown-menu">Meny<img id="dropdown-image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/downarrow.png" /></a>
			<?php 
				wp_nav_menu( array(
					'theme_location'	=> 'primary', 
					'container' 		=> '',							
					'items_wrap' 		=> '<ul>%3$s</ul>',
					'before' 			=> '',
					'after'				=> '',
					'depth' 			=> 1,
					'echo' 				=> true
				)); 
			?>
			<div class="clear"></div>
		</nav><!-- #access -->

		<div id="blog_id" style="display:none"><?php global $blog_id; echo $blog_id; ?></div>
		
	</header><!-- #branding -->


	<div id="main">
