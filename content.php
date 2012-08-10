<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky":""); ?>>
		<div class="summary-content">
			<?php /*if (has_post_thumbnail()) : */ ?>
			<?php $thumb = get_the_post_thumbnail(get_the_ID(),'thumbnail-image'); 
			if ($thumb) : ?>
				<div class="img-wrapper">
					<?php 					
						echo $thumb;
					//the_post_thumbnail('thumbnail-image'); ?>
				</div>
			<?php endif;/*endif;*/ ?>
			
			<div class="entry-wrapper">
				<h1 class="entry-title"><a post_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div>
			</div>
			<footer>
				<?php
					$categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );
					if ( $categories_list ):
					?>
					<span class="cat-links">
						<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list ); ?>
					</span>
				<?php endif; // End if categories ?>
				<?php if(function_exists('the_views')) { echo "<span class='views'>"; the_views(); echo "</span>"; } ?>
				<span class="modified-date"><?php the_modified_date(); ?></span>
			</footer>
			<!--<div class="readMoreFadeBottom"></div>-->
		</div><!-- .summary-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
