<?php
/**
 * The default template for displaying single content
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky,single":"single"); ?>>
		<div class="single-content">
			<?php require("inc/single_content.php"); ?>
			<?php include("inc/hk-aside-content.php"); ?>
		</div><!-- .single-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
