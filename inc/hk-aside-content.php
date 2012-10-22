<?php if( get_field('hk_contacts') || get_field('hk_related') ) : ?>
<aside class="side-content">
	<div class="box">
	<?php if( get_field('hk_contacts') ) : ?>
		<div>Kontakta oss</div>
		<ul>
		<?php if( get_field('hk_contacts') ): ?>
			<?php while( has_sub_field('hk_contacts') ): ?>
				<li class="related_contact">
					<?php $value = get_sub_field('hk_contact'); ?>
					<a href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a>
				</li>			 
			<?php endwhile; ?>			 
		<?php endif; ?> 
		</ul>
	<?php endif; ?>
	
	<?php if ( get_field('hk_related') ) : ?>
		<div>Relaterad information</div>
		<ul>
		<?php while ( has_sub_field('hk_related') ) : ?>
			<?php if ( get_row_layout() == 'hk_related_posts' ) : ?>
				<li class="related_page">
					<?php $value = get_sub_field('hk_related_post');?>
					<a href="<?php echo get_permalink($value->ID); ?>" title="<?php echo get_sub_field('hk_related_post_description'); ?>"><?php echo $value->post_title; ?></a>
				</li>			 
			<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
				<li class="related_link">
					<a href="<?php echo get_sub_field('hk_relate_link_url'); ?>" title="<?php echo get_sub_field('hk_related_link_description'); ?>"><?php echo get_sub_field('hk_related_link_name'); ?></a>
				</li>
			<?php elseif ( get_row_layout() == 'hk_related_files' ) : ?>
				<?php $link = wp_get_attachment_link(get_sub_field('hk_related_file')); ?>
				<li class="related_file">
					<?php echo str_replace("<a ", "<a title='" . get_sub_field('hk_related_file_description') . "' ", $link); ?>
				</li>			 
			<?php endif; ?> 
		<?php endwhile; ?>
		</ul>
	<?php endif; ?>

	</div>
</aside>
<?php endif; ?>		