			<div class="entry-wrapper">
				<?php echo hk_get_the_post_thumbnail(get_the_ID(),"contact-image",true,false); ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="entry-content">
				
					<div id='contact-<?php echo get_the_ID(); ?>' class='<?php echo implode(" ",get_post_class()); ?>'>
						<div class='content'><?php echo get_field("hk_contact_titel"); ?></div>
						
						<?php // workplace
						if( get_field('hk_contact_workplaces') ): while( has_sub_field('hk_contact_workplaces') ): ?>
							<p><?php echo get_sub_field('hk_contact_workplace'); ?></p>
						<?php endwhile; endif; ?>
						
						<?php // phone
						if( get_field('hk_contact_phones') ): while( has_sub_field('hk_contact_phones') ): ?>
							<p>
							<?php echo (get_row_layout() == "hk_contact_fax")?"fax ":""; ?>
							<?php echo get_sub_field('number'); ?></p>
						<?php endwhile; endif; ?>
						
						<?php // email
						if( get_field('hk_contact_emails') ): while( has_sub_field('hk_contact_emails') ): ?>
							<p><a href='mailto:<?php echo get_sub_field('hk_contact_email'); ?>'><?php echo get_sub_field('hk_contact_email'); ?></a></p>
						<?php endwhile; endif; ?>
						
						<?php // description ?>
						<p><?php echo get_field("hk_contact_description"); ?></p>
						
						<?php // address ?>
						<p><?php echo get_field("hk_contact_address"); ?></p>
						
						<?php // visit hours ?>
						<p><?php echo get_field("hk_contact_visit_hours"); ?></p>
						
						<?php // position ?>
						<?php $contact_position = get_field("hk_contact_position");
						if (!empty($contact_position) && $contact_position["coordinates"] != "") : ?>
							<div id="map_canvas">[Karta <span class="coordinates"><?php echo $contact_position["coordinates"]; ?></span> <span class="address"><?php echo $contact_position["address"]; ?></span>]</div>
						<?php endif; ?>
						
					</div>
					<div class="summary-footer">
						
						<?php
							$categories_list = get_the_category_list(', ');
							if ( $categories_list ):
							?>
							<span class="cat-links">
								<?php echo $categories_list; ?>
							</span>
						<?php endif; // End if categories ?>
						
						<?php
							$list = get_the_term_list(get_the_ID(), "post_tag"); 					
							if ( $list ):
							?>
							<span class="tag-links">
								<?php echo $list; ?>
							</span>
							<?php endif; ?>

						
						<div class="modified-date">Senast uppdaterad <?php the_modified_date(); ?></div>
					</div>
				</div>
			</div>