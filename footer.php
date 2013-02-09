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
global $default_settings;
?>

	</div><!-- .main-wrapper -->
	</div><!-- #main -->

	<?php //hk_contact_tab(); ?>
	<?php if ($hk_options["contact_side_link"] != "") : ?>
		<div id="contact-side-tab"><a href="<?php echo $hk_options["contact_side_link"]; ?>" title="L&auml;mna din synpunkt eller felanm&auml;lan"></a></div>
	<?php endif; ?>
	
	<?php if ($hk_options["comment_side_link"] != "") : ?>
		<div id="comment-side-tab"><a href="<?php echo $hk_options["comment_side_link"]; ?>" title="Hj&auml;lp oss att bli b&auml;ttre"></a></div>
	<?php endif; ?>

	<?php if ( $hk_options["logo_footer_image"] || 
			is_active_sidebar( 'footer-sidebar' ) || is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-3' ) || is_active_sidebar( 'footer-sidebar-4' ) ||
			is_active_sidebar( 'footer2-sidebar' ) || is_active_sidebar( 'footer2-sidebar-2' ) || is_active_sidebar( 'footer2-sidebar-3' ) || is_active_sidebar( 'footer2-sidebar-4' ) ) : ?>
	<footer id="colophon" class="colophon" role="contentinfo">
			<?php

			function create_footer($prefix) {
				$footers = 0;
				if ( is_active_sidebar( $prefix . '-sidebar' ) ) { $footers++; }
				if ( is_active_sidebar( $prefix . '-sidebar-2' ) ) { $footers++; }
				if ( is_active_sidebar( $prefix . '-sidebar-3' ) ) { $footers++; }
				if ( is_active_sidebar( $prefix . '-sidebar-4' ) ) { $footers++; }
				$footerclass = "";
				switch($footers) {
					case 1:
						$footerclass = "one";
						break;
					case 2:
						$footerclass = "two";
						break;
					case 3:
						$footerclass = "three";
						break;
					case 4:
						$footerclass = "four";
						break;
				}
			
				if ( $footers > 0 ) :
					echo "<div class='$prefix-wrapper  footer-widget-wrapper'><div class='gw  $prefix-sidebar  footer-widget-sidebar  widget-area  $footerclass'>";
					if ( is_active_sidebar( $prefix . '-sidebar' ) ) { 
						echo "<div class='g  footer-widgets  first'>";
						dynamic_sidebar( $prefix . '-sidebar' ); 
						echo "</div>";
					}
					if ( is_active_sidebar( $prefix . '-sidebar-2' ) ) {  
						echo "<div class='g  footer-widgets  second'>";
						dynamic_sidebar( $prefix . '-sidebar-2' ); 
						echo "</div>";
					}
					if ( is_active_sidebar( $prefix . '-sidebar-3' ) ) {  
						echo "<div class='g  footer-widgets  third'>";
						dynamic_sidebar( $prefix . '-sidebar-3' ); 
						echo "</div>";
					}
					if ( is_active_sidebar( $prefix . '-sidebar-4' ) ) {  
						echo "<div class='g  footer-widgets  fourth'>";
						dynamic_sidebar( $prefix . '-sidebar-4' ); 
						echo "</div>";
					}
					echo "</div></div>";
				endif;
			}
			/* create the two footers */
			create_footer("footer");
			create_footer("footer2");

		if (($hk_options["footer_image"] != "") || ( $hk_options["logo_footer_image"] != "")) : ?>
		<div class="footer-image-wrapper">
			<?php /* footer image */
			if ($hk_options["footer_image"] != "") : ?>
				<div class="footer-image"><img src="<?php echo $hk_options["footer_image"]; ?>" /></div>
			<?php endif;
			
			if ( $hk_options["logo_footer_image"] ) :
			?>
				<div class="logo-footer-image"><img src="<?php echo $hk_options["logo_footer_image"]; ?>" /></div>
			<?php endif; ?>	
		</div><!-- .footer-image-wrapper -->
		<?php endif; ?>	
		
	</footer><!-- #colophon -->
	<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
<?php if ($hk_options["google_analytics"] != "" && $default_settings['allow_google_analytics']) : ?>
<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo $hk_options["google_analytics"]; ?>']); 
_gaq.push(['_setDomainName', '<?php echo $hk_options['google_analytics_domain'];  ?>']);
_gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php endif; ?>
<div id="scrollTo_top" class="flush--bottom  position-fixed--bottom-right  island"><a href="#"></a></div>
<div id="log" class="flush--bottom  position-fixed--bottom-left  island">mylog</div>
</body>
</html>