<?php
/**
 * Alternate template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky news summary":"news summary"); ?>>
		<?php /*<div class="time"><?php echo get_the_date(); ?></div>*/ ?>
		<div class="article-border-wrapper">
		<div class="article-wrapper">
			<div class="content-wrapper">
				<div class="summary-content">
					<?php $thumb = hk_get_the_post_thumbnail(get_the_ID(),'thumbnail-image', false); 
					if ($thumb) : ?>
							<?php 					
								echo $thumb;
							//the_post_thumbnail('thumbnail-image'); ?>
					<?php endif;/*endif;*/ ?>

										<?php 
					$externalclass = "";
					if (function_exists("get_field")) { 
						$href = get_field('hk_external_link_url'); 
						$name = get_field('hk_external_link_name'); 
						if (!empty($href))
						{
							$externalclass = "class='externallink'";
							$title = "Extern länk till " . the_title_attribute( 'echo=0' );
						}
					}
					if (empty($href)) {
						$href = get_permalink(); 
						$title = "Länk till " . the_title_attribute( 'echo=0' );
					}
					
					?>
					<h1 class="entry-title"><a <?php echo $externalclass; ?> href="<?php echo $href; ?>" title="<?php echo $title; ?>" rel="bookmark"><?php the_title(); ?></a></h1>					
					<div class="entry-wrapper">
						<div class="entry-content">
							<?php the_excerpt(); ?>
						</div><!-- .entry-content -->
					</div><!-- .entry-wrapper -->
					
				</div><!-- .summary-content -->

			</div><!-- .content-wrapper -->
			<span class='hidden article_id'><?php the_ID(); ?></span>
		</div>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
