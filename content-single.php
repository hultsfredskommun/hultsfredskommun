<?php
/**
 * The default template for displaying single content
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky single full":"single full"); ?>>
		<div class="single-content content-wrapper">
			<?php require("inc/single_content.php"); ?>
		</div><!-- .single-content .content-wrapper -->
		<?php include("inc/hk-aside-content.php"); ?>
		<span class='hidden article_id'><?php the_ID(); ?></span>
		<div class="clear"></div>
	</article><!-- #post-<?php the_ID(); ?> -->
