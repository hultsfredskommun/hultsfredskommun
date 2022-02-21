<?php
		/**
		 * Single content, used in content.php (if is_single) and in post_load.php for dynamic load of post
		 */

		// featured image ?>
		<?php
			$options = get_option("hk_theme");

			//$externalclass = "js-toggle-article";
			$externalclass = "";
			if (function_exists("get_field")) {
				$href = get_field('hk_external_link_url');
				$name = get_field('hk_external_link_name');
				if (!empty($href))
				{
					$externalclass = "js-external-link";
					$title = "Extern länk till " . the_title_attribute( 'echo=0' );
				}
			}
			if (empty($href)) {
				$href = get_permalink();
				$title = "Länk till " . the_title_attribute( 'echo=0' );
			}

			require("hk-article-header.php");
			?>
			<?php /*
			<div class="quick-links">
				<span class="contact quick-link js-quick-link force-hidden">
					<a class="contact-small-icon icon" href="#quick-contact-<?php the_ID(); ?>" title='G&aring; direkt till kontaktinformation'></a>
				</span>
				<span class="related quick-link js-quick-link force-hidden">
					<a class="related-small-icon icon" href="#quick-related-<?php the_ID(); ?>" title='G&aring; direkt till relaterad information'></a>
				</span>
			</div>
			*/ ?>
			<h1 class="entry-title"><span><?php the_title(); ?></span></h1>
			<!-- LOCAL SCRIPT //-->
			<?php
        /* local script */
        /*if (function_exists("get_field")) {
            $localscript = get_field('hk_local_script');
						if (!empty($localscript)) {
            	echo "\n" . str_replace( '&lt;', '<', str_replace( '&gt;', '>', str_replace( '&amp;', '&', str_replace('[[', '<', str_replace(']]', '>', $localscript)))));
						}
        }*/
        /* OLD local script meta data */
				/*if (empty($localscript) && get_post_meta( get_the_ID(), "local_script", true ) != "") {
					echo get_post_meta( get_the_ID(), "local_script", true );
				}*/
			?>
			<!-- END LOCAL SCRIPT //-->
			<?php //the_post_thumbnail('featured-image');
				echo hk_get_the_post_thumbnail(get_the_ID(),'featured-image');
			?>



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


			<?php require("hk-aside-content.php"); ?>

			<?php require("single_footer_content.php"); ?>
