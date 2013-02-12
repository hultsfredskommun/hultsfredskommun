<?php
/**
 * The default template for displaying single content
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky single full":"single full"); ?>>
		<h1 class="entry-title">
			<?php echo get_the_title(); ?>
		</h1>
		<div class="article-border-wrapper">
		<div class="article-wrapper">
			<div class="single-content content-wrapper">
				<?php require("inc/single_content.php"); ?>
			</div><!-- .single-content .content-wrapper -->
			<?php require("inc/hk-aside-content.php"); ?>
			<?php require("inc/single_footer_content.php"); ?>
		</div>
		</div>
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</article><!-- #post-<?php the_ID(); ?> -->
