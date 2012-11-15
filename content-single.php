<?php
/**
 * The default template for displaying single content
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky single full":"single full"); ?>>
		<div class="single-content content-wrapper">
			<?php require("inc/single_content.php"); ?>
			<?php include("inc/hk-aside-content.php"); ?>
		</div><!-- .single-content -->
		<span class='hidden post_id'><?php the_ID(); ?></span>
	</article><!-- #post-<?php the_ID(); ?> -->
