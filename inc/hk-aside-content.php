
<aside class="side-content">
	<?php
	$options = get_option("hk_theme"); ?>
	<?php if (function_exists("get_field") && get_field('hk_optional_text2', get_the_ID())){ ?>
		<div class="box optional-text2"><?php echo get_field('hk_optional_text2', get_the_ID()); ?></div>
	<?php } ?>
	<?php if (function_exists("get_field") && get_field('hk_optional_text', get_the_ID())){ ?>
		<div class="box optional-text"><?php echo get_field('hk_optional_text', get_the_ID()); ?></div>
	<?php } ?>

	<?php if( function_exists("get_field") && get_field('hk_contacts', get_the_ID()) ) : // related contacts ?>

		<?php
		$has_contacts = false;
		while( has_sub_field('hk_contacts', get_the_ID()) ):
			$value = get_sub_field('hk_contact', get_the_ID());
			if (!empty($value)) {
				$has_contacts = true;
			}
		endwhile;
		reset_rows();

		if ($has_contacts) :
		?>
	<ul class="box top contacts">
		<a name="quick-contact-<?php the_ID(); ?>"></a>
		<li class="contact_title title">
			<span class="contact-icon"></span><span>Kontakt</span>
		</li>

		<?php while( has_sub_field('hk_contacts', get_the_ID()) ): ?>
			<?php $value = get_sub_field('hk_contact', get_the_ID());
			if (!empty($value)) { ?>
				<li class="aside-list-item contact-wrapper">
					<div class="contact-<?php echo $value->ID; ?>"><a class="js-contact-link" href="<?php echo get_permalink($value->ID); ?>" title='Mer kontaktinformation f&ouml;r <?php echo $value->post_title; ?>'><?php echo $value->post_title; ?></a>

					<?php $alt_title = get_sub_field('hk_contact_extra', get_the_ID());
					if (!empty($alt_title)) : ?>
					<span class="title-content">
						<?php echo $alt_title; ?>
					</span>
					<?php else : ?>
					<?php if (!empty($value) && function_exists("get_field") && get_field('hk_contact_titel', $value->ID)) : ?>
					<span class="title-content">
						<?php echo get_field('hk_contact_titel', $value->ID); ?>
					</span>
					<?php endif; endif; ?>
				<?php if (!empty($value)) { ?>
					<span class="rs_skip contact_id hidden"><?php echo $value->ID; ?></span>
				<?php } ?>
				</div></li>
			<?php } ?>
		<?php endwhile; ?>
	</ul>
<?php endif; // end if $has_contacts ?>
	<?php endif; ?>
	<?php //print_r($post); ?>
	<?php if ( get_post_type() == "attachment" ) : // if view of attachment ?>
	<ul class="box related">
		<li class="aside-list-item related_file">
			<a target="_blank" href="<?php echo wp_get_attachment_url(get_the_ID()); ?>" title="Direktl&auml;nk till filen<?php //echo get_the_content(); ?>"><?php the_title(); ?></a>
		</li>
	</ul>
	<?php endif; ?>

	<?php if ( function_exists("get_field") && get_field('hk_related') ) : // related docs and links ?>
	<ul class="box related">


		<?php
			$first_sub_field = true;
			$first_title_field = true;
			$relate_post_title = ""
		?>
		<?php while ( has_sub_field('hk_related') ) : ?>
			<?php if ( $first_sub_field && (get_row_layout() != 'hk_related_titles' ) ) : ?>
				<li class="related_title title full">
					<a name="quick-related-<?php the_ID(); ?>"></a>
					<span class="related-icon"></span><span>Se &auml;ven</span>
				</li>
			<?php endif; ?>
			<?php //if (!$summary || $count++ < 2) : ?>
				<?php if ( get_row_layout() == 'hk_related_posts' ) : ?>
					<li class="aside-list-item related_page">
						<?php $value = get_sub_field('hk_related_post');

						$relate_post_title = get_sub_field('hk_related_post_description');
						if ($relate_post_title == "") {
							if (!empty($value->ID)) {
								$relate_post_title = "L&auml;nk till " . get_permalink($value->ID);
							}
						}
						if (!empty($value) && !empty($value->ID) && !empty($value->post_title)) {
						?>
						<a href="<?php echo get_permalink($value->ID); ?>" title="<?php echo $relate_post_title; ?>"><?php echo $value->post_title; ?></a>
						<?php } ?>
					</li>
				<?php elseif ( get_row_layout() == 'hk_related_links' ) : ?>
					<li class="aside-list-item related_link">
						<?php
							// prepend http:// if not there already
							$relate_link_url = get_sub_field('hk_relate_link_url');
							if ($relate_link_url != "" && substr_compare($relate_link_url, "http", 0, 4) != 0) {
								$relate_link_url = "http://" . $relate_link_url;
							}
							$relate_link_title = get_sub_field('hk_related_link_description');
							if ($relate_link_title == "") {
								$relate_link_title = "L&auml;nk till " . $relate_link_url;
							}
						?>
						<a target="_blank" href="<?php echo $relate_link_url; ?>" title="<?php echo $relate_link_title ?>"><?php echo get_sub_field('hk_related_link_name'); ?></a>
					</li>
				<?php elseif ( get_row_layout() == 'hk_related_files' ) : ?>
					<?php $link =  wp_get_attachment_url(get_sub_field('hk_related_file'));
						$link_name = get_the_title(get_sub_field('hk_related_file'));
						$relate_file_title = get_sub_field('hk_related_file_description');
						if ($relate_file_title == "") {
							$relate_file_title = "L&auml;nk till " . $link;
						}
?>
					<li class="aside-list-item related_file">
						<a target="_blank" href="<?php echo $link; ?>" title="<?php echo $relate_file_title; ?>"><?php echo $link_name; ?></a>
					</li>
				<?php elseif ( get_row_layout() == 'hk_related_titles' ) : ?>
					<?php
						$title_obj = get_sub_field_object('hk_related_title');
						$title = $title_obj["value"];
						$title = $title_obj["choices"][$title];
						if (empty($title)) {
							$title = $title_obj["value"];
						}
						//$title = str_replace("-"," ",ucwords($title));
					?>
					<?php if ($first_sub_field) : ?>
						<a name="quick-related-<?php the_ID(); ?>"></a>
					<?php else : ?>
						</li></ul><ul class="box related">
					<?php endif; ?>
					<li class="related_title title">
						<span class="related-icon"></span><span><?php echo $title; ?></span>
					</li>
				<?php endif; ?>
			<?php //endif; ?>
			<?php $first_sub_field = false;	?>
		<?php endwhile; ?>
	</ul>

	<?php if (function_exists("get_field")) { $contact_position = get_field("hk_position"); } ?>
	<?php // position
		if (!empty($contact_position) && $contact_position["coordinates"] != "") : ?>
			<div class='box map'><div class='map_canvas'>[Karta <span class='coordinates'><?php echo $contact_position["coordinates"]; ?></span> <span class='address'><?php echo $contact_position["address"]; ?></span>]</div></div>
	<?php endif; ?>

	<?php endif; ?>


	<?php if( function_exists("get_field") && get_field('hk_vanliga_fragor', get_the_ID()) ) : // faq ?>

		<?php
		$has_faq = false;
		while( has_sub_field('hk_vanliga_fragor', get_the_ID()) ):
			$value = get_sub_field('fraga', get_the_ID());
			if (!empty($value)) {
				$has_faq = true;
			}
		endwhile;
		reset_rows();

		if ($has_faq) :
		?>
	<ul class="box top faq">
		<a name="quick-faq-<?php the_ID(); ?>"></a>
		<li class="faq_title title">
			<span class="faq-icon"></span><span>Artikeln svarar på f&ouml;ljande</span>
		</li>

		<?php while( has_sub_field('hk_vanliga_fragor', get_the_ID()) ): ?>
			<li class="aside-list-item faq-wrapper">
				<?php $value = get_sub_field('fraga', get_the_ID()); ?>
				<?php echo $value; ?></li>
		<?php endwhile; ?>
	</ul>
<?php endif; // end if $has_faq ?>
<?php endif; ?>



</aside>
