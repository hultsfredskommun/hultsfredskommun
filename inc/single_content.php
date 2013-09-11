<?php
		/**
		 * Single content, used in content.php (if is_single) and in post_load.php for dynamic load of post
		 */

		// featured image ?>
		<?php
			$externalclass = "";
			if (function_exists("get_field")) { 
				$href = get_field('hk_external_link_url'); 
				$name = get_field('hk_external_link_name'); 
				if (!empty($href))
				{
					$externalclass = "js-external-link  ";
					$title = "Extern länk till " . the_title_attribute( 'echo=0' );
				}
			}
			if (empty($href)) {
				$href = get_permalink(); 
				$title = "Länk till " . the_title_attribute( 'echo=0' );
			}

			?>
			<h1 class="entry-title"><a class="<?php echo $externalclass; ?>js-toggle-article" href="<?php echo $href; ?>" title="<?php echo $title; ?>" rel="bookmark"><?php the_title(); ?></a><a class="js-toggle-article button top">st&auml;ng</a></h1>

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
					// if external link is set
					if (function_exists("get_field")) { 
						$href = get_field('hk_external_link_url'); 
						if (!empty($href)) {
							echo "<p><strong>Artikeln hänvisar till denna sida: <a href='" . $href . "'>" . $href . "</a></strong></p>"; 
						}
					}
					
					the_content();
					endif;
				?>
			</div><!-- .content -->
			

			<?php //require("hk-aside-content.php"); ?>
			
			<?php //require("single_footer_content.php"); ?>