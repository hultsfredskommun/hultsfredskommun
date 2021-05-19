<?php
/**
 * Register our sidebars and widgetized areas. Also register the default Epherma widget.
 *
 * @since Twenty Eleven 1.0
 */
function hk_widgets_init() {

	register_sidebar( array(
		'name' => 'Startsidans toppinneh&aring;ll',
		'id' => 'firstpage-top-content',
		'description' => 'Inneh&aring;ll h&ouml;gst upp p&aring; startsidan',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Startsidans inneh&aring;ll',
		'id' => 'firstpage-content',
		'description' => 'Inneh&aring;ll under toppinneh�ll p&aring; startsidan',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

	register_sidebar( array(
		'name' => 'Startsidans sidof&auml;lt 2 kolumner',
		'id' => 'firstpage-sidebar-2col',
		'description' => 'Startsidans sidof&auml;lt, &ouml;verst i b&aring;da kolumnerna',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title"><span>',
		'after_title' => '</span></h2>',
	) );

	register_sidebar( array(
		'name' => 'Startsidans sidof&auml;lt',
		'id' => 'firstpage-sidebar',
		'description' => 'Startsidans sidof&auml;lt',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title"><span>',
		'after_title' => '</span></h2>',
	) );

	register_sidebar( array(
		'name' => 'Startsidans sidof&auml;lt 2',
		'id' => 'firstpage-sidebar-2',
		'description' => 'Startsidans sidof&auml;lt',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title"><span>',
		'after_title' => '</span></h2>',
	) );

	register_sidebar( array(
		'name' => "Startsidan f&ouml;re sidfot",
		'id' => 'firstpage-pre-footer-sidebar',
		'description' => "Widgetyta som visas p&aring; startsidan f&ouml;re sidfoten.",
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	/* footer */
	register_sidebar( array(
		'name' => "Sidfot",
		'id' => 'footer-sidebar',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => "Sidfot 2",
		'id' => 'footer-sidebar-2',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => "Sidfot 3",
		'id' => 'footer-sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => "Sidfot 4",
		'id' => 'footer-sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	/* footer 2 */
	register_sidebar( array(
		'name' => "Andra sidfot",
		'id' => 'footer2-sidebar',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => "Andra sidfot 2",
		'id' => 'footer2-sidebar-2',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => "Andra sidfot 3",
		'id' => 'footer2-sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => "Andra sidfot 4",
		'id' => 'footer2-sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'twentyeleven' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	register_sidebar( array(
		'name' => 'Viktigt toppinneh&aring;ll',
		'id' => 'important-top-content',
		'description' => 'Inneh&aring;ll som hamnar h&ouml;gst upp p&aring; alla sidor',
		'before_widget' => '<aside id="%1$s" class="important-widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );
	
	register_sidebar( array(
		'name' => 'H&ouml;gerst&auml;lld i huvudmenyns andra niv&aring;',
		'id' => 'right-main-sub-menu-item-sidebar',
		'description' => 'Inneh&aring;ll som hamnar h&ouml;gst upp till h&ouml;ger i huvudmenyns andra niv&aring;',
		'before_widget' => '<li id="%1$s" class="right-nav-menu-item menu-item %2$s">',
		'after_widget' => "</li>",
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	) );

}
add_action( 'widgets_init', 'hk_widgets_init' );
?>
