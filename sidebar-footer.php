<?php
/**
 * The Footer widget areas.
 */
?>

<?php
	if ( !is_active_sidebar( 'footer-sidebar' ) )
		return;
?>
<div id="supplementary">
	<div id="footer-sidebar" class="widget-area" role="complementary">
		<?php dynamic_sidebar( 'footer-sidebar' ); ?>
	</div><!-- #footer-sidebar .widget-area -->
</div><!-- #supplementary -->