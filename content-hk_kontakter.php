<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
global $default_settings;
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky":""); ?>>
		<div class="summary-content">
			<?php require("inc/hk_kontakter_content.php"); ?>
		</div><!-- .summary-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
