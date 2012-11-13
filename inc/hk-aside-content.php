<?php if( get_field('hk_contacts') || get_field('hk_related') ) : ?>
<?php $count = 0; ?>
<aside class="side-content">
	<div class="box">
	<?php if( get_field('hk_contacts',get_the_ID()) ) : // related contacts ?>
		<?php while( has_sub_field('hk_contacts',get_the_ID()) ): ?>
			<div class="contact-wrapper <?php echo ($count++ < 2)?"summary":"full"; ?>">
				<?php $value = get_sub_field('hk_contact',get_the_ID()); ?>
				<div class="icon"></div><div id="contact-<?php echo $value->ID; ?>"><a post_id="<?php echo $value->ID; ?>" href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a>
				
				<?php $alt_title = get_sub_field('hk_contact_extra',get_the_ID());
				if (!empty($alt_title)) : ?>
				<div class="content">
					<?php echo $alt_title; ?>
				</div>
				<?php else : ?>
				<div class="content">
					<?php echo get_field('hk_contact_titel',$value->ID); ?>
				</div>
				<?php endif; ?>
			</div></div>
		<?php endwhile; ?>			 
	<?php endif; ?>
	<?php  ?>
	<?php if ( get_field('hk_related') ) : // related docs and links ?>
		<ul class="related-wrapper <?php echo ($count < 2)?"summary":"full"; ?><?php echo (get_field('hk_contacts'))?" top-margin":""; ?>">
		<?php while ( has_sub_field('hk_related') ) : ?>
			<?php if (!$summary || $count++ < 2) : ?>
				<?php if ( get_row_layout() == 'hk_related_posts' ) : ?>
					<li class="related_page <?php echo ($count++ < 2)?"summary":"full"; ?>"><div class="icon"></div>
						<?php $value = get_sub_field('hk_related_post');?>
						<a href="<?php echo get_permalink($value->ID); ?>" title="<?php echo get_sub_field('hk_related_post_description'); ?>"><?php echo $value->post_title; ?></a>
					</li>			 
				<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
					<li class="related_link <?php echo ($count++ < 2)?"summary":"full"; ?>"><div class="icon"></div>
						<?php 
							// prepend http:// if not there already
							$relate_link_url = get_sub_field('hk_relate_link_url');
							if (substr_compare($relate_link_url, "http", 0, 4) != 0) {
								$relate_link_url = "http://" . $relate_link_url;
							}
						?>
						<a target="_blank" href="<?php echo $relate_link_url; ?>" title="<?php echo get_sub_field('hk_related_link_description'); ?>"><?php echo get_sub_field('hk_related_link_name'); ?></a>
					</li>
				<?php elseif ( get_row_layout() == 'hk_related_files' ) : ?>
					<?php $link = wp_get_attachment_link(get_sub_field('hk_related_file')); ?>
					<li class="related_file <?php echo ($count++ < 2)?"summary":"full"; ?>"><div class="icon"></div>
						<?php echo str_replace("<a ", "<a target='_blank' title='" . get_sub_field('hk_related_file_description') . "' ", $link); ?>
					</li>			 
				<?php endif; ?> 
			<?php endif; ?> 
		<?php endwhile; ?>
		</ul>
	<?php endif; ?>
	<?php if ($count >= 2) : // show more related arrow ?>
	<div class='flow-more-side'></div>
	<?php endif; ?>

	</div>

</aside>
<div class='flow-left'></div>
<?php endif; ?>		