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
	<div class="clear"></div>
	</div><!-- #main -->

	<?php hk_contact_tab(); ?>

	<?php if ( $hk_options["logo_footer_image"] || is_active_sidebar( 'footer-sidebar' ) ) : ?>
	<footer id="colophon" role="contentinfo">
		<div id="supplementary">
			<?php if ($hk_options["footer_image"] != "") : ?>
					<div id="footer-image"><img src="<?php echo $hk_options["footer_image"]; ?>"/></div>
			<?php endif; ?>
			<?php
				get_sidebar( 'footer' );

				if ( $hk_options["logo_footer_image"] ) :
			?>
				<div id="logo_footer_image"><img src="<?php echo $hk_options["logo_footer_image"]; ?>" /></div>
			<?php endif; ?>	
		</div><!-- #supplementary -->
		
	</footer><!-- #colophon -->
	<?php endif; ?>
</div><!-- #page -->

<?php wp_footer(); ?>
<?php if ($hk_options["google_analytics"] != "") : ?>
<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', '<?php echo $hk_options["google_analytics"]; ?>']); _gaq.push(['_setDomainName', '<?php echo $_SERVER['SERVER_NAME'];  ?>']);
_gaq.push(['_setAllowLinker', true]);
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