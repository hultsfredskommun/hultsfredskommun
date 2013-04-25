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
		<?php if ( function_exists("get_field") ) : // related docs and links ?>
		<aside class="content-area">
			<ul>
				<?php $count = 0; while ( has_sub_field('hk_related') ) : ?>
					<?php if ($count++ < 2) : ?>
						<?php if ( get_row_layout() == 'hk_related_posts' ) : ?>
							<li class="related_page <?php echo ($count++ < 2)?"summary":"full"; ?>">
								<?php $value = get_sub_field('hk_related_post');?>
								<a href="<?php echo get_permalink($value->ID); ?>" title="Relaterat inl&auml;gg" class="icon-left"><i class='i' data-icon='&#xF143;'></i></a>
								<a href="<?php echo get_permalink($value->ID); ?>" class="icon-right" title="<?php echo get_sub_field('hk_related_post_description'); ?>"><?php echo $value->post_title; ?></a>
							</li>			 
						<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
							<li class="related_link <?php echo ($count++ < 2)?"summary":"full"; ?>">
								<?php 
									// prepend http:// if not there already
									$relate_link_url = get_sub_field('hk_relate_link_url');
									if ($relate_link_url != "" && substr_compare($relate_link_url, "http", 0, 4) != 0) {
										$relate_link_url = "http://" . $relate_link_url;
									}
								?>
								<a target="_blank" href="<?php echo $relate_link_url; ?>" class="icon-left" title="L&auml;nk till annan webbsida"><i class='i' data-icon='&#xF143;'></i></a>
								<a target="_blank" href="<?php echo $relate_link_url; ?>" class="icon-right" title="<?php echo get_sub_field('hk_related_link_description'); ?>"><?php echo get_sub_field('hk_related_link_name'); ?></a>
							</li>
						<?php elseif ( get_row_layout() == 'hk_related_files' ) : ?>
							<?php $link =  wp_get_attachment_url(get_sub_field('hk_related_file')); 
								$link_name = get_the_title(get_sub_field('hk_related_file')); ?>
							<li class="related_file <?php echo ($count++ < 2)?"summary":"full"; ?>">
								<a target="_blank" href="<?php echo $link; ?>" class="icon-left" title="Ladda ner dokument"><i class='i' data-icon='&#xF019;'></i></a>
								<a target="_blank" href="<?php echo $link; ?>" class="icon-right" title="<?php echo get_sub_field('hk_related_file_description'); ?>"><?php echo $link_name; ?></a>
							</li>			 
						<?php endif; ?> 
					<?php endif; ?> 
					
				<?php endwhile; ?>
				<li class="perma_link">
					<a href="<?php the_permalink(); ?>" title="L&auml;nk till annan artikel" class="icon-left"><i class='i' data-icon='&#xF143;'></i></a><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">Direktl&auml;nk till artikeln</a>
				</li>
			</ul>
		</aside>
		<?php endif; ?> 
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</li><!-- #post-<?php the_ID(); ?> -->
