
<aside class="side-content">
	<?php $count = 0; ?>
	<?php if( get_field('hk_contacts',get_the_ID()) ) : // related contacts ?>
	<div class="box top contacts summary">
		<?php while( has_sub_field('hk_contacts',get_the_ID()) ): ?>
			<div class="contact-wrapper <?php echo ($count++ < 2)?"summary":"full"; ?>">
				<?php $value = get_sub_field('hk_contact',get_the_ID()); ?>
				<a href="#" title="Kontaktinformation"><div class="icon"></div></a><div class="contact-<?php echo $value->ID; ?>"><a href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a>
				
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
			<span class="contact_id hidden"><?php echo $value->ID; ?></span></div></div>
		<?php endwhile; ?>			 
	</div>
	<?php endif; ?>
	<?php  ?>
	<?php if ( get_field('hk_related') ) : // related docs and links ?>
	<div class="box related <?php echo ($count == 0)?"top":""; ?> <?php echo ($count < 2)?"summary":"full"; ?>">
		<ul class="related-wrapper <?php echo ($count < 2)?"summary":"full"; ?><?php echo (get_field('hk_contacts'))?" top-margin":""; ?>">
		<?php while ( has_sub_field('hk_related') ) : ?>
			<?php if (!$summary || $count++ < 2) : ?>
				<?php if ( get_row_layout() == 'hk_related_posts' ) : ?>
					<li class="related_page <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="Relaterat inl&auml;gg"><div class="icon"></div></a>
						<?php $value = get_sub_field('hk_related_post');?>
						<a href="<?php echo get_permalink($value->ID); ?>" title="<?php echo get_sub_field('hk_related_post_description'); ?>"><?php echo $value->post_title; ?></a>
					</li>			 
				<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
					<li class="related_link <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="L&auml;nk till annan webbsida"><div class="icon"></div></a>
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
					<?php $link =  wp_get_attachment_url(get_sub_field('hk_related_file')); 
						$link_name = get_the_title(get_sub_field('hk_related_file')); ?>
					<li class="related_file <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="Ladda ner dokument"><div class="icon"></div></a>
						<a target="_blank" href="<?php echo $link; ?>" title="<?php echo get_sub_field('hk_related_file_description'); ?>"><?php echo $link_name; ?></a>
					</li>			 
				<?php endif; ?> 
			<?php endif; ?> 
			
		<?php endwhile; ?>
		</ul>
	</div>
	<?php endif; ?>	
	<div class="box tools">
		<?php edit_post_link( "Redigera inl&auml;gg", "<div class='editlink tool-line summary'><div class='icon'></div>", "</div>" ); ?>
		<div class="print tool-line full"><div class="icon"></div><a class="print" target="_blank" href="<?php the_permalink(); ?>?print=1" title="Funktionen kommer senare">Skriv ut</a></div>
		<div class="read tool-line full"><div class="icon"></div><a class="read" title="Funktionen kommer senare">L&auml;s upp</a></div>
		<div class="friend tool-line full"><div class="icon"></div><a class="read" title="Funktionen kommer senare">Tipsa</a></div>
		<div class="helpus tool-line full"><div class="icon"></div><?php comments_popup_link('Hj&auml;lp oss!','Hj&auml;lp oss!','Hj&auml;lp oss!','','Hj&auml;lp oss!'); ?></div>
	</div>
	

</aside>

