			
			<?php $thumb = get_the_post_thumbnail(get_the_ID(),'thumbnail-image'); 
			if ($thumb) : ?>
				<div class="img-wrapper">
					<?php 					
						echo $thumb;
					//the_post_thumbnail('thumbnail-image'); ?>
				</div>
			<?php endif; ?>
			
			<div class="entry-wrapper">
				<h1 class="entry-title"><a post_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<div class="entry-content">
				<?php
					$retValue .= "<div class='img-wrapper'>" . hk_get_the_post_thumbnail(get_the_ID(),"contact-image",true,false) . "</div>";
					$retValue .= "<div id='contact-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
					$retValue .= "<a class='permalink' href='". get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a>";
					$retValue .= "<div class='content'>" . get_field("hk_contact_titel") . "</div>";
					$retValue .= "<div class='more-content'>";
					// workplace
					if( get_field('hk_contact_workplaces') ): while( has_sub_field('hk_contact_workplaces') ): 
						$retValue .= "<p>" . get_sub_field('hk_contact_workplace') . "</p>";
					endwhile; endif;
					// phone
					if( get_field('hk_contact_phones') ): while( has_sub_field('hk_contact_phones') ): 
						$retValue .= "<p>";
						if(get_row_layout() == "hk_contact_fax"): $retValue .= "fax "; endif;
						$retValue .= get_sub_field('number') . "</p>";
					endwhile; endif; 
					// email
					if( get_field('hk_contact_emails') ): while( has_sub_field('hk_contact_emails') ): 
						$retValue .= "<p>" . get_sub_field('hk_contact_email') . "</p>";
					endwhile; endif;
					// description
					$retValue .= "<p>" . get_field("hk_contact_description") . "</p>";
					// address
					$retValue .= "<p>" . get_field("hk_contact_address") . "</p>";
					// visit hours
					$retValue .= "<p>" . get_field("hk_contact_visit_hours") . "</p>";
					// position
					$contact_position = get_field("hk_contact_position");
					if (!empty($contact_position)) :
						$retValue .= "<p>[Kommer ers&auml;ttas med karta " . $contact_position["coordinates"] . "]</p>";
					endif;
					echo $retValue;
				?>
				</div>
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

				<?php if(function_exists('the_views')) { echo "<span class='views'>"; the_views(); echo "</span>"; } ?>
				<span class="modified-date"><?php the_modified_date(); ?></span>
			</div>