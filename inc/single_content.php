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
				if (function_exists("get_field")) { $optionaltext = get_field('hk_optional_text'); }
				if (isset($optionaltext) && $optionaltext != "") : ?>
					<div class="misc-ctrl">
						<div class='optional-area'><?php echo $optionaltext; ?></div>
					</div><!-- .misc-ctrl -->
				<?php endif; ?>
			
				<div class="content">
					<?php
						$more = 1;       // Set (inside the loop) to display all content, including text below more. 
						if ( get_post_type() != "attachment" ) : // if not an attachment
						the_content();
						endif;
						
						//embedded video
						/*$embeddedvideo = get_post_custom_values('embedded_code');
						if (isset($embeddedvideo)) : foreach ($embeddedvideo as $value) {
							echo "<div class='video-container'>" . $value . "<br></div>";
						} endif;*/
					?>
				</div><!-- .content -->
			
			</div><!-- .entry-wrapper -->			

			<?php require("hk-aside-content.php"); ?>
			
			<?php require("single_footer_content.php"); ?>