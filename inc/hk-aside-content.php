
<aside class="side-content">
	<?php $count = 0; 
	$options = get_option("hk_theme"); ?>
	<?php if( function_exists("get_field") && get_field('hk_contacts',get_the_ID()) ) : // related contacts ?>
	<ul class="box top contacts summary">
		<?php while( has_sub_field('hk_contacts',get_the_ID()) ): ?>
			<li class="contact-wrapper <?php echo ($count++ < 2)?"summary":"full"; ?>">
				<?php $value = get_sub_field('hk_contact',get_the_ID()); ?>
				<a title="Kontaktinformation" class="aside-icon-left"><i class='i' data-icon='&#xF170;'></i></a><div class="aside-icon-right  contact-<?php echo $value->ID; ?>"><a class="contactlink" href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a>
				
				<?php $alt_title = get_sub_field('hk_contact_extra',get_the_ID());
				if (!empty($alt_title)) : ?>
				<div class="content">
					<?php echo $alt_title; ?>
				</div>
				<?php else : ?>
				<?php if (get_field('hk_contact_titel',$value->ID)) : ?>
				<div class="content">
					<?php echo get_field('hk_contact_titel',$value->ID); ?>
				</div>
				<?php endif; /*
				if( get_field('hk_contact_phones',$value->ID) ): while( has_sub_field('hk_contact_phones',$value->ID) ): 
					echo "<div class='phone full'>";
					echo (get_row_layout() == "hk_contact_fax")?"Fax: ":"";
					echo get_sub_field('number') . " </div>";
				endwhile; endif;*/				
				?>
				<?php endif; ?>
			<span class="contact_id hidden"><?php echo $value->ID; ?></span></div></li>
		<?php endwhile; ?>			 
	</ul>
	<?php endif; ?>
	<?php //print_r($post); ?>
	<?php if ( get_post_type() == "attachment" ) : // if view of attachment ?>
	<div class="box related <?php echo ($count == 0)?"top":""; ?> <?php echo ($count < 2)?"summary":"full"; ?>">
		<ul class="related-wrapper <?php echo ($count < 2)?"summary":"full"; ?><?php echo (get_field('hk_contacts'))?" top-margin":""; ?>">
			<li class="related_file <?php echo ($count++ < 2)?"summary":"full"; ?>">
				<a title="Ladda ner dokument" class="aside-icon-left"><i class='i' data-icon='&#xF170;'></i></a>
				<a target="_blank" href="<?php echo wp_get_attachment_url(get_the_ID()); ?>" class="aside-icon-right" title="Direktl&auml;nk till filen<?php //echo get_the_content(); ?>"><?php the_title(); ?></a>
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
					<li class="related_page <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="Relaterat inl&auml;gg" class="aside-icon-left"><i class='i' data-icon='&#xF170;'></i></a>
						<?php $value = get_sub_field('hk_related_post');?>
						<a href="<?php echo get_permalink($value->ID); ?>" class="aside-icon-right" title="<?php echo get_sub_field('hk_related_post_description'); ?>"><?php echo $value->post_title; ?></a>
					</li>			 
				<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
					<li class="related_link <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="L&auml;nk till annan webbsida" class="aside-icon-left"><i class='i' data-icon='&#xF170;'></i></a>
						<?php 
							// prepend http:// if not there already
							$relate_link_url = get_sub_field('hk_relate_link_url');
							if (substr_compare($relate_link_url, "http", 0, 4) != 0) {
								$relate_link_url = "http://" . $relate_link_url;
							}
						?>
						<a target="_blank" class="aside-icon-right" href="<?php echo $relate_link_url; ?>" title="<?php echo get_sub_field('hk_related_link_description'); ?>"><?php echo get_sub_field('hk_related_link_name'); ?></a>
					</li>
				<?php elseif ( get_row_layout() == 'hk_related_files' ) : ?>
					<?php $link =  wp_get_attachment_url(get_sub_field('hk_related_file')); 
						$link_name = get_the_title(get_sub_field('hk_related_file')); ?>
					<li class="related_file <?php echo ($count++ < 2)?"summary":"full"; ?>"><a title="Ladda ner dokument" class="aside-icon-left"><i class='i' data-icon='&#xF170;'></i></a>
						<a target="_blank" class="aside-icon-right" href="<?php echo $link; ?>" title="<?php echo get_sub_field('hk_related_file_description'); ?>"><?php echo $link_name; ?></a>
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
	<ul class="box tools">
		<?php edit_post_link( "Redigera inl&auml;gg", "<li><a title='Redigera inl&auml;gg' class='aside-icon-left  editlink tool-line full' class='aside-icon-left'><i class='i' data-icon='&#xF170;'></i></a><span>", "</span></li>" ); ?>
		<li class="print tool-line full"><a title='Skriv ut' class='aside-icon-left'><i class='i' data-icon='&#xF170;'></i></a><a class="print  aside-icon-right" target="_blank" href="<?php the_permalink(); ?>?print=1" title="Funktionen kommer senare">Skriv ut</a></li>
		<li class="read tool-line full"><a title='L&auml;s upp' class='aside-icon-left'><i class='i' data-icon='&#xF170;'></i></a><a class="read" title="Funktionen kommer senare">L&auml;s upp artikel</a></li>
		<?php if ($options['addthis_pubid'] != "") : ?>
		<li class="friend tool-line full"><a title='Redigera inl&auml;gg' class='aside-icon-left'><i class='i' data-icon='&#xF170;'></i></a><a class="friend" href="#" title="Tipsa n&aring;gon om denna sida">Tipsa</a></li>
		<li class="addthis full">
			<div class="addthis_toolbox" addthis:url="http://<?php echo $_SERVER['SERVER_NAME'] . get_permalink(); ?>" addthis:title="<?php the_title(); ?>" addthis:description="Kolla den h&auml;r sidan.">
				<a class="addthis_button_email"></a>
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_compact"></a>
			</div>
		</li>
		<?php endif; ?>
	</ul>
	

</aside>

