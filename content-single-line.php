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
	<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a href="<?php the_permalink(); ?>" class="link" title="<?php echo get_the_excerpt(); // printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
		<span class="tag_related_icons">
		<?php if ( function_exists("get_field") && get_field('hk_related') ) : // related docs and links ?>
			<?php while ( has_sub_field('hk_related') ) : ?>
				<?php if ( get_row_layout() == 'hk_related_posts' ) : ?>
					<?php $value = get_sub_field('hk_related_post');?>
					<!--a href="<?php echo get_permalink($value->ID); ?>" class="icon related-post-icon" title="<?php echo $value->post_title; ?>"></a-->
				<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
					<?php 
						// prepend http:// if not there already
						$relate_link_url = get_sub_field('hk_relate_link_url');
						if ($relate_link_url != "" && substr_compare($relate_link_url, "http", 0, 4) != 0) {
							$relate_link_url = "http://" . $relate_link_url;
						}
					?>
					<!--a target="_blank" href="<?php echo $relate_link_url; ?>" class="icon related-link-icon" title="<?php echo get_sub_field('hk_related_link_name'); ?>"></a-->
				<?php elseif ( get_row_layout() == 'hk_related_files' ) : ?>
					<?php $link =  wp_get_attachment_url(get_sub_field('hk_related_file')); 
						$link_name = get_the_title(get_sub_field('hk_related_file')); ?>
						<a target="_blank" href="<?php echo $link; ?>" class="icon related-file-icon" title="<?php echo $link_name; ?>"></a>
				<?php endif; ?> 
				
			<?php endwhile; ?>
		<?php endif; ?> 
		</span>
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</li><!-- #post-<?php the_ID(); ?> -->
