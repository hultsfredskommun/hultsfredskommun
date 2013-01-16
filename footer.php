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
	<div class="clear"></div>
	</div><!-- #main -->

	<?php hk_contact_tab(); ?>

	<?php if ($hk_options["comment_side_link"] != "") : ?>
		<div id="comment-side-tab"><a href="<?php echo $hk_options["comment_side_link"]; ?>" title="Hj&auml;lp oss att bli b&auml;ttre"></a></div>
	<?php endif; ?>

	<?php if ( $hk_options["logo_footer_image"] || is_active_sidebar( 'footer-sidebar' ) || is_active_sidebar( 'footer-sidebar-2' ) || is_active_sidebar( 'footer-sidebar-3' ) || is_active_sidebar( 'footer-sidebar-4' ) ) : ?>
	<footer id="colophon" role="contentinfo">
		<div id="supplementary">
			<?php if ($hk_options["footer_image"] != "") : ?>
					<div id="footer-image"><img src="<?php echo $hk_options["footer_image"]; ?>"/></div>
			<?php endif; ?>
			<?php

			$footers = 0;
			if ( is_active_sidebar( 'footer-sidebar' ) ) { $footers++; }
			if ( is_active_sidebar( 'footer-sidebar-2' ) ) { $footers++; }
			if ( is_active_sidebar( 'footer-sidebar-3' ) ) { $footers++; }
			if ( is_active_sidebar( 'footer-sidebar-4' ) ) { $footers++; }
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
				echo "<div id='footer-sidebar' class='widget-area $footerclass'>";
				if ( is_active_sidebar( 'footer-sidebar' ) ) { 
					echo "<div class='footer-widgets first'>";
					dynamic_sidebar( 'footer-sidebar' ); 
					echo "</div>";
				}
				if ( is_active_sidebar( 'footer-sidebar-2' ) ) {  
					echo "<div class='footer-widgets second'>";
					dynamic_sidebar( 'footer-sidebar-2' ); 
					echo "</div>";
				}
				if ( is_active_sidebar( 'footer-sidebar-3' ) ) {  
					echo "<div class='footer-widgets third'>";
					dynamic_sidebar( 'footer-sidebar-3' ); 
					echo "</div>";
				}
				if ( is_active_sidebar( 'footer-sidebar-4' ) ) {  
					echo "<div class='footer-widgets fourth'>";
					dynamic_sidebar( 'footer-sidebar-4' ); 
					echo "</div>";
				}
				echo "</div>";
			endif;
				if ( $hk_options["logo_footer_image"] ) :
			?>
				<div id="logo_footer_image"><img src="<?php echo $hk_options["logo_footer_image"]; ?>" /></div>
			<?php endif; ?>	
		</div><!-- #supplementary -->
		
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

<div id="log">mylog</div>
</body>
</html>