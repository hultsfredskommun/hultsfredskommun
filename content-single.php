<?php
/**
 * The default template for displaying single content
 */
?>
	<!--googleon: all-->
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky single full":"single full"); ?>>
		<div class="article-border-wrapper">
		<div class="article-wrapper">
			<div class="single-content content-wrapper">
				<?php 
					if (get_post_type() == "hk_kontakter") {
						require("inc/hk-article-header.php");
						
						hk_the_contact(array(
							'image' => true,
							'name' => true,
							'title' => true,
							'workplace' => true,
							'phone' => true,
							'email' => true,
							'description' => true,
							'address' => true,
							'visit_hours' => true,
							'map' => true,
							'title_link' => false)); 
						
						//require("inc/hk-aside-content.php");
						require("inc/single_footer_content.php");
					}
					else {
						require("inc/single_content.php"); 
					}
				?>
				
			</div><!-- .single-content .content-wrapper -->
			<?php //require("inc/hk-aside-content.php"); ?>
			<?php //require("inc/single_footer_content.php"); ?>
		</div>
		</div>
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</article><!-- #post-<?php the_ID(); ?> -->
	<!--googleoff: all-->