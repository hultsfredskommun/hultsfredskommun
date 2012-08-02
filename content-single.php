<?php
/**
 * The default template for displaying single content
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky":""); ?>>
			<?php require("inc/single_content.php"); ?>
	</article><!-- #post-<?php the_ID(); ?> -->
