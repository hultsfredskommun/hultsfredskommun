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
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky summary":"summary"); ?>>
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<div class="article-wrapper">
			<div class="content-wrapper">
				<div class="summary-content">
					<?php $thumb = hk_get_the_post_thumbnail(get_the_ID(),'thumbnail-image', false); 
					if ($thumb) : ?>
							<?php 					
								echo $thumb;
							//the_post_thumbnail('thumbnail-image'); ?>
					<?php endif;/*endif;*/ ?>
					
					<?php if ( get_post_type() != "attachment" ) : // if not an attachment ?>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>
					<?php endif; ?>

				</div><!-- .summary-content -->

			</div><!-- .content-wrapper -->
			<?php require("inc/hk-aside-content.php"); ?>
			<?php require("inc/single_footer_content.php"); ?>
		</div>
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</article><!-- #post-<?php the_ID(); ?> -->
