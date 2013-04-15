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
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky  post  summary":"post  summary"); ?>>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<div class="article-border-wrapper">
		<div class="article-wrapper">
			<div class="content-wrapper">
				<div class="summary-content">
					<?php hk_the_contact(array(
						'image' => true,
						'name' => false,
						'title' => true,
						'workplace' => true,
						'phone' => true,
						'email' => true,
						'description' => true,
						'address' => false,
						'visit_hours' => false,
						'map' => false,
						'title_link' => false)); ?>
				</div><!-- .summary-content -->

			</div><!-- .content-wrapper -->
			<?php require("inc/single_footer_content.php"); ?>
		</div>
		</div>
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</article><!-- #post-<?php the_ID(); ?> -->
