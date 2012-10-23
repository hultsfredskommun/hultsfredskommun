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
		<div class="content-wrapper">
		<div class="summary-content">
			<?php $thumb = hk_get_the_post_thumbnail(get_the_ID(),'thumbnail-image', false); 
			if ($thumb) : ?>
					<?php 					
						echo $thumb;
					//the_post_thumbnail('thumbnail-image'); ?>
			<?php endif;/*endif;*/ ?>
			
			<div class="entry-wrapper">
				<h1 class="entry-title"><a post_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<div class="reviewed"><span class="reviewed-date"><?php echo get_the_reviewed_date(get_the_ID()); ?></span>
				<span class="reviewed-by">av <?php echo get_the_author(); ?></span></div>
				<div class="entry-content">
					<?php the_excerpt(); ?>
				</div>
			</div>
			<?php if (is_single() || !in_category($default_settings["startpage_cat"])) : ?>
						
			<div class="summary-footer">
				<?php
					$categories_list = get_the_category_list(' | ');
					if ( $categories_list ):
					?>
					<span class="cat-links">
						<?php echo $categories_list; ?>
					</span>
				<?php endif; // End if categories ?>
				
				<?php
					$list = get_the_term_list(get_the_ID(), "post_tag"); 					
					if ( $list ):
						if ($categories_list ) {
							echo " | ";
						}
					?>
					<span class="tag-links">
						<?php echo $list; ?>
					</span>
				<?php endif; // END if tags  ?>


				<?php //if(function_exists('the_views')) { echo "<span class='views'>"; the_views(); echo "</span>"; } ?>
					
				<?php if (false) { //REMOVE CONTACT AND RELATED ICONS if( get_field('hk_related') || get_field('hk_contacts') ) { ?>
					<div class="summary-icons">
					<?php if( get_field('hk_related') ) { echo "<span class='docs icon'>&nbsp;</span>"; } ?>
					
					<?php if( get_field('hk_contacts') ) { echo "<span class='contact icon'></span>"; } ?>
					</div>
				<?php } ?>
				
			</div>
			<?php endif; ?>
			<!--<div class="readMoreFadeBottom"></div>-->
		</div><!-- .summary-content -->
		<?php include("inc/hk-aside-content.php"); ?>

		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
