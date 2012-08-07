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
	<?php if ( $hk_options["logo_footer_image"] && is_active_sidebar( 'footer-sidebar' ) ) : ?>
	<footer id="colophon" role="contentinfo">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				if ( ! is_404() )
					get_sidebar( 'footer' );
				if ( $hk_options["logo_footer_image"] ) :
			?>
				<div id="logo_footer_image"><img src="<?php echo $hk_options["logo_footer_image"]; ?>" /></div>
			<?php endif; ?>					
	</footer><!-- #colophon -->
	<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
<div id="log">mylog</div>
</body>
</html>