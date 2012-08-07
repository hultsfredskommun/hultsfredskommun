<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

/* get hk_options */
$hk_options = get_option('hk_theme');

?>
	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>
			<div id="logo_footer_image"><img src="<?php echo $hk_options["logo_footer_image"]; ?>" /></div>
						
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<div id="log">mylog</div>
</body>
</html>