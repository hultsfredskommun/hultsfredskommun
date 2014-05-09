
<aside class="side-content">
	<?php $count = 1; 
	$options = get_option("hk_theme"); ?>
	<?php if (get_field('hk_optional_text',get_the_ID())){ ?>
		<div class="box optional-text full"><?php echo get_field('hk_optional_text',get_the_ID()); ?></div>
	<?php } ?>
	
	<?php if( function_exists("get_field") && get_field('hk_contacts',get_the_ID()) ) : // related contacts ?>
	<ul class="box top contacts summary">
		<li class="title full">
			<span>Kontakt</span>
		</li>			 

		<?php while( has_sub_field('hk_contacts',get_the_ID()) ): ?>
			<li class="contact-wrapper <?php echo ($count++ < 2)?"summary":"full"; ?>">
				<?php $value = get_sub_field('hk_contact',get_the_ID()); ?>
				<a title="Kontaktinformation" class="icon-left contact-icon"></a><div class="icon-right  contact-<?php echo $value->ID; ?>"><a class="js-contact-link" href="<?php echo get_permalink($value->ID); ?>"><?php echo $value->post_title; ?></a>
				
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
		<?php if ($count > 2) {
			echo "<a class='more-contacts hide_full summary js-toggle-article'>se fler kontakter</a>";
		} ?>
	</ul>
	<?php endif; ?>
	<?php //print_r($post); ?>
	<?php if ( get_post_type() == "attachment" ) : // if view of attachment ?>
	<div class="box related <?php echo ($count == 0)?"top":""; ?> <?php echo "full"; //TEMP REMOVED echo ($count < 2)?"summary":"full"; ?>">
		<ul class="related-wrapper <?php echo "full"; //TEMP REMOVED echo ($count < 2)?"summary":"full"; ?><?php echo (get_field('hk_contacts'))?" top-margin":""; ?>">
			<li class="related_file <?php echo "full"; //TEMP REMOVED echo ($count++ < 2)?"summary":"full"; ?>">
				<a title="Ladda ner dokument" class="icon-left related-file-icon"></a>
				<a target="_blank" href="<?php echo wp_get_attachment_url(get_the_ID()); ?>" class="icon-right" title="Direktl&auml;nk till filen<?php //echo get_the_content(); ?>"><?php the_title(); ?></a>
			</li>
		</ul>
	</div>
	<?php endif; ?>

	<?php if ( function_exists("get_field") && get_field('hk_related') ) : // related docs and links ?>
	<div class="box related <?php echo ($count == 0)?"top":""; ?> <?php echo "full"; //TEMP REMOVED echo ($count < 2)?"summary":"full"; ?>">
		<ul class="related-wrapper <?php echo "full"; //TEMP REMOVED echo ($count < 2)?"summary":"full"; ?><?php echo (get_field('hk_contacts'))?" top-margin":""; ?>">


		<?php $first_sub_field = true; ?>
		<?php while ( has_sub_field('hk_related') ) : ?>
			<?php if ( $first_sub_field && (get_row_layout() != 'hk_related_titles' ) ) : ?>
				<li class="related_title title full">
					<span>Se &auml;ven</span>
				</li>
			<?php endif; ?>
			<?php $first_sub_field = false;	?>
			<?php if (!$summary || $count++ < 2) : ?>
				<?php if ( get_row_layout() == 'hk_related_posts' ) : ?>
					<li class="related_page <?php echo "full"; //TEMP REMOVED echo ($count++ < 2)?"summary":"full"; ?>">
						<?php $value = get_sub_field('hk_related_post');?>
						<a href="<?php echo get_permalink($value->ID); ?>" class="icon-left related-post-icon" title="Relaterat inl&auml;gg"></a>
						<a href="<?php echo get_permalink($value->ID); ?>" class="icon-right" title="<?php echo get_sub_field('hk_related_post_description'); ?>"><?php echo $value->post_title; ?></a>
					</li>			 
				<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
					<li class="related_link <?php echo "full"; //TEMP REMOVED echo ($count++ < 2)?"summary":"full"; ?>">
						<?php 
							// prepend http:// if not there already
							$relate_link_url = get_sub_field('hk_relate_link_url');
							if ($relate_link_url != "" && substr_compare($relate_link_url, "http", 0, 4) != 0) {
								$relate_link_url = "http://" . $relate_link_url;
							}
						?>
						<a target="_blank" href="<?php echo $relate_link_url; ?>" class="icon-left related-link-icon" title="L&auml;nk till annan webbsida"></a>
						<a target="_blank" href="<?php echo $relate_link_url; ?>" class="icon-right" title="<?php echo get_sub_field('hk_related_link_description'); ?>"><?php echo get_sub_field('hk_related_link_name'); ?></a>
					</li>
				<?php elseif ( get_row_layout() == 'hk_related_files' ) : ?>
					<?php $link =  wp_get_attachment_url(get_sub_field('hk_related_file')); 
						$link_name = get_the_title(get_sub_field('hk_related_file')); ?>
					<li class="related_file <?php echo "full"; //TEMP REMOVED echo ($count++ < 2)?"summary":"full"; ?>">
						<a target="_blank" href="<?php echo $link; ?>" class="icon-left related-file-icon" title="Ladda ner dokument"></a>
						<a target="_blank" href="<?php echo $link; ?>" class="icon-right" title="<?php echo get_sub_field('hk_related_file_description'); ?>"><?php echo $link_name; ?></a>
					</li>			 
				<?php elseif ( get_row_layout() == 'hk_related_titles' ) : ?>
					<?php $title = get_sub_field('hk_related_title'); 
						$title = str_replace("-"," ",ucwords($title));
					?>
					<li class="related_title title full">
						<span><?php echo $title; ?></span>
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
	<ul class="box tools full">
		<?php edit_post_link( "Redigera inl&auml;gg", "<li class='edit-post'><a title='Redigera inl&auml;gg' class='icon-left edit-icon editlink tool-line full icon-left'></a>", "</li>" ); ?>
		<?php if (isset($options['readspeaker_id'])) : ?>
		<li class="title">
			<span>Lyssna</span>
		</li>			 
		<li class="readspeaker">
		<div id="readspeaker_button1" class="readspeaker_toolbox rs_skip rsbtn rs_preserve">
			<a class="rsbtn_play" accesskey="L" title="Lyssna p&aring; artikel" href="http://app.eu.readspeaker.com/cgi-bin/rsent?customerid=<?php echo $options['readspeaker_id']; ?>&amp;lang=sv_se&amp;readid=content-<?php the_ID(); ?>&amp;url=<?php the_permalink(); ?>">
			<span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span></span></span></span>
			<span class="rsbtn_right rsimg rsplay rspart"></span></a>
		</div>
		</li>
		
		<?php endif; ?>
		<?php if ($options['addthis_pubid'] != "") : // TODO when cookies work && ($_REQUEST["cookies"] == "true" || $default_settings['allow_cookies'])) : ?>
		<li class="title">
			<span>Dela</span>
		</li>			 
		<li class="addthis">
			<div class="addthis_toolbox addthis_32x32_style" addthis:url="<?php echo the_permalink(); ?>" addthis:title="<?php the_title(); ?>" addthis:description="Kolla den h&auml;r sidan.">
				<a class="addthis_button_facebook"></a>
				<a class="addthis_button_twitter"></a>
				<a class="addthis_button_google_plusone_badge"></a>
				<a class="addthis_button_email"></a>
				<a class="addthis_button_print"></a>
				<a class="addthis_button_compact"></a>
				<!--a class="addthis_counter addthis_bubble_style"></a-->
			</div>
		</li>
		<?php endif; ?>
	</ul>
	

</aside>

