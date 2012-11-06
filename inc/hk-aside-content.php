<?php if( get_field('hk_contacts') || get_field('hk_related') ) : ?>
<aside class="side-content">
	<div class="box">
	<?php if( get_field('hk_contacts',get_the_ID()) ) : ?>
		<?php while( has_sub_field('hk_contacts',get_the_ID()) ): ?>
			<div class="contact-wrapper">
				<?php $value = get_sub_field('hk_contact',get_the_ID()); ?>
				<div class="icon"></div><div id="contact-<?php echo $value->ID; ?>"><a post_id="<?php echo $value->ID; ?>" href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a>
				
				<?php $alt_title = get_sub_field('hk_contact_extra',get_the_ID());
				if (!empty($alt_title)) : ?>
				<div class="content">
					<?php echo $alt_title; ?>
				</div>
				<?php endif; ?>
				<div class="content">
					<?php echo get_field('hk_contact_titel',$value->ID); ?>
				</div>
			</div></div>			 
		<?php endwhile; ?>			 
	<?php endif; ?>
	<?php  ?>
	<?php if ( get_field('hk_related') ) : ?>
		
		<ul class="related-wrapper<?php echo (get_field('hk_contacts'))?" top-margin":""; ?>">
		<?php while ( has_sub_field('hk_related') ) : ?>
			<?php if ( get_row_layout() == 'hk_related_posts' ) : ?>
				<li class="related_page"><div class="icon"></div>
					<?php $value = get_sub_field('hk_related_post');?>
					<a href="<?php echo get_permalink($value->ID); ?>" title="<?php echo get_sub_field('hk_related_post_description'); ?>"><?php echo $value->post_title; ?></a>
				</li>			 
			<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
				<li class="related_link"><div class="icon"></div>
					<a target="_blank" href="<?php echo get_sub_field('hk_relate_link_url'); ?>" title="<?php echo get_sub_field('hk_related_link_description'); ?>"><?php echo get_sub_field('hk_related_link_name'); ?></a>
				</li>
			<?php elseif ( get_row_layout() == 'hk_related_files' ) : ?>
				<?php $link = wp_get_attachment_link(get_sub_field('hk_related_file')); ?>
				<li class="related_file"><div class="icon"></div>
					<?php echo str_replace("<a ", "<a target='_blank' title='" . get_sub_field('hk_related_file_description') . "' ", $link); ?>
				</li>			 
			<?php endif; ?> 
		<?php endwhile; ?>
		</ul>
	<?php endif; ?>


	</div>
</aside>
<div class='flow-left'></div>
<?php endif; ?>		