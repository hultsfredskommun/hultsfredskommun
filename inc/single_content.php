<?php
		/**
		 * Single content, used in content.php (if is_single) and in post_load.php for dynamic load of post
		 */

		// featured image ?>


			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

			<?php //the_post_thumbnail('featured-image'); 
				echo hk_get_the_post_thumbnail(get_the_ID(),'featured-image');
			?>
		
			<?php
			if (function_exists("get_field")) { $optionaltext = get_field('hk_optional_text'); }
			if (isset($optionaltext) && $optionaltext != "") : ?>
				<div class="misc-ctrl">
					<div class='optional-area'><?php echo $optionaltext; ?></div>
				</div><!-- .misc-ctrl -->
			<?php endif; ?>
		
			<div id="content-<?php the_ID(); ?>" class="content">
				<?php
					$more = 1;       // Set (inside the loop) to display all content, including text below more. 
					if ( get_post_type() != "attachment" ) : // if not an attachment
					the_content();
					endif;
				?>
			</div><!-- .content -->
			

			<?php //require("hk-aside-content.php"); ?>
			
			<?php //require("single_footer_content.php"); ?>