<?php
		/**
		 * Single content, used in content.php (if is_single) and in post_load.php for dynamic load of post
		 */

		// featured image ?>


		<?php //the_post_thumbnail('featured-image'); 
			echo hk_get_the_post_thumbnail(get_the_ID(),'featured-image');
		?>
		
			<div class="entry-wrapper content">
				<h1 class="entry-title">
					<?php echo get_the_title(); ?>
				</h1>
			
				<?php
				$optionaltext = get_field('hk_optional_text');
				if (isset($optionaltext) && $optionaltext != "") : ?>
					<div class="misc-ctrl">
						<div class='optional-area'><?php echo $optionaltext; ?></div>
					</div><!-- .misc-ctrl -->
				<?php endif; ?>
			
				<div class="content">
					<?php
						$more = 1;       // Set (inside the loop) to display all content, including text below more. 
						the_content();
						
						//embedded video
						/*$embeddedvideo = get_post_custom_values('embedded_code');
						if (isset($embeddedvideo)) : foreach ($embeddedvideo as $value) {
							echo "<div class='video-container'>" . $value . "<br></div>";
						} endif;*/
					?>
				</div><!-- .content -->
			
				<footer class="entry-meta">
			
					<div class="helpus"><?php comments_popup_link('Hj&auml;lp oss att bli b&auml;ttre!','Hj&auml;lp oss att bli b&auml;ttre!','Hj&auml;lp oss att bli b&auml;ttre!','','Hj&auml;lp oss att bli b&auml;ttre!'); ?></div>
					<div class="tag-cloud">Tillh&ouml;r: 
						<?php
							$categories_list = get_the_category_list( ' | ' );
							if ( $categories_list ):
						?>
						<span class="cat-links">
							<?php echo $categories_list; ?>
						</span>
						<?php endif; // End if categories ?>
						<?php
							$tags_list = get_the_term_list(get_the_ID(), "post_tag",'',' | ','');
							if ( $tags_list ): 
								if ($categories_list ) {
									echo " | ";
								} ?>

						<span class="tag-links">
							<?php echo $tags_list; ?>
						</span>

						<?php endif; // End if $tags_list ?>

					</div>

					<div class="editor">Sidansvarig: <?php comments_popup_link(get_the_author(),get_the_author(),get_the_author(),'',get_the_author()); ?><?php edit_post_link( "Redigera inl&auml;gg", " [", "]" ); ?></div>
					<div class="reviewed"><?php echo get_the_reviewed_date(get_the_ID()); ?></div>

					<div class="permalink">Direktl&auml;nk: <a href="http://<?php echo $_SERVER['SERVER_NAME'] . get_permalink(); ?>">http://<?php echo $_SERVER['SERVER_NAME'] . get_permalink(); ?></a></div>


					
				</footer><!-- .entry-meta -->
			</div><!-- .entry-wrapper -->			
