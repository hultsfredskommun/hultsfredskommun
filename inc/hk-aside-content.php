
<aside class="side-content">
	<?php $count = 0; ?>
	<?php if( function_exists("get_field") && get_field('hk_contacts',get_the_ID()) ) : // related contacts ?>
	<div class="box top contacts summary">
		<?php while( has_sub_field('hk_contacts',get_the_ID()) ): ?>
			<div class="contact-wrapper <?php echo ($count++ < 2)?"summary":"full"; ?>">
				<?php $value = get_sub_field('hk_contact',get_the_ID()); ?>
				<a title="Kontaktinformation"><div class="icon"><img src="<?php hk_icon_path(); ?>/user-4.svg" alt="Kontaktinformation" /></div></a><div class="contact-<?php echo $value->ID; ?>"><a class="contactlink" href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a>
				
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
	<?php //print_r($post); ?>
	<?php if ( get_post_type() == "attachment" ) : // if view of attachment ?>
	<div class="box related <?php echo ($count == 0)?"top":""; ?> <?php echo ($count < 2)?"summary":"full"; ?>">
		<ul class="related-wrapper <?php echo ($count < 2)?"summary":"full"; ?><?php echo (get_field('hk_contacts'))?" top-margin":""; ?>">
			<li class="related_file <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="Ladda ner dokument"><div class="icon"><img src="<?php hk_icon_path(); ?>/inbox.svg" alt="Ladda ner dokument" /></div></a>
				<a target="_blank" href="<?php echo wp_get_attachment_url(get_the_ID()); ?>" title="Direktl&auml;nk till filen<?php //echo get_the_content(); ?>"><?php the_title(); ?></a>
			</li>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ( function_exists("get_field") && get_field('hk_related') ) : // related docs and links ?>
	<div class="box related <?php echo ($count == 0)?"top":""; ?> <?php echo ($count < 2)?"summary":"full"; ?>">
		<ul class="related-wrapper <?php echo ($count < 2)?"summary":"full"; ?><?php echo (get_field('hk_contacts'))?" top-margin":""; ?>">
		<?php while ( has_sub_field('hk_related') ) : ?>
			<?php if (!$summary || $count++ < 2) : ?>
				<?php if ( get_row_layout() == 'hk_related_posts' ) : ?>
					<li class="related_page <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="Relaterat inl&auml;gg"><div class="icon"><img src="<?php hk_icon_path(); ?>/paragraph-justify-2.svg" alt="Relaterat inl&auml;gg" /></div></a>
						<?php $value = get_sub_field('hk_related_post');?>
						<a href="<?php echo get_permalink($value->ID); ?>" title="<?php echo get_sub_field('hk_related_post_description'); ?>"><?php echo $value->post_title; ?></a>
					</li>			 
				<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
					<li class="related_link <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="L&auml;nk till annan webbsida"><div class="icon"><img src="<?php hk_icon_path(); ?>/outgoing.svg" alt="L&auml;nk till annan webbsida" /></div></a>
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
					<li class="related_file <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="Ladda ner dokument"><div class="icon"><img src="<?php hk_icon_path(); ?>/inbox.svg" alt="Ladda ner dokument" /></div></a>
						<a target="_blank" href="<?php echo $link; ?>" title="<?php echo get_sub_field('hk_related_file_description'); ?>"><?php echo $link_name; ?></a>
					</li>			 
				<?php endif; ?> 
			<?php endif; ?> 
			
		<?php endwhile; ?>
		</ul>
	</div>
	
	<?php if (function_exists("get_field")) { $contact_position = get_field("hk_position"); } ?>
	<?php // position
		if (!empty($contact_position) && $contact_position["coordinates"] != "") : ?>
			<div class='box map full'><div class='map_canvas'>[Karta <span class='coordinates'><?php echo $contact_position["coordinates"]; ?></span> <span class='address'><?php echo $contact_position["address"]; ?></span>]</div></div>
	<?php endif; ?>

	<?php endif; ?>	
	<div class="box tools">
		<?php edit_post_link( "Redigera inl&auml;gg", "<div class='editlink tool-line full'><div class='icon'><img src='" . hk_get_icon_path() . "/pencil.svg' alt='Editera' /></div>", "</div>" ); ?>
		<div class="print tool-line full"><div class="icon"><img src="<?php hk_icon_path(); ?>/print.svg" alt="Skriv ut" /></div><a class="print" target="_blank" href="<?php the_permalink(); ?>?print=1" title="Funktionen kommer senare">Skriv ut</a></div>
		<div class="read tool-line full"><div class="icon"><img src="<?php hk_icon_path(); ?>/audio-high.svg" alt="L&auml;s upp artikel" /></div><a class="read" title="Funktionen kommer senare">L&auml;s upp artikel</a></div>
		<div class="friend tool-line full"><div class="icon"><img src="<?php hk_icon_path(); ?>/speech-bubble-left-4.svg" alt="Tipsa en v&auml;n" /></div><a class="read" title="Funktionen kommer senare">Tipsa</a></div>
		<div class="helpus tool-line full"><div class="icon"><img src="<?php hk_icon_path(); ?>/settings-3.svg" alt="Hj&auml;lp oss bli b&auml;ttre" /></div><?php comments_popup_link('Hj&auml;lp oss!','Hj&auml;lp oss!','Hj&auml;lp oss!','','Hj&auml;lp oss!'); ?></div>
	</div>
	

</aside>

