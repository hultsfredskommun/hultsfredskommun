<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky summary":"summary"); ?>>
		<div class="article-border-wrapper">
		<div class="article-wrapper">
			<div class="content-wrapper">
				<div class="summary-content">
					<?php $thumb = hk_get_the_post_thumbnail(get_the_ID(),'thumbnail-image', false, false); 
					if ($thumb) :  					
						echo $thumb;
					else : /* else default thumb; */
						$options = get_option("hk_theme");
						$src = $options["default_thumbnail_image"]; 
						if (!empty($src)) :
						?>
						<div class="img-wrapper "><div><img class="slide" src="<?php echo $src; ?>" alt=""></div></div>
					<?php endif; endif;/*endif;*/ ?>
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
					<h1 class="entry-title"><a class="<?php echo $externalclass; ?>js-toggle-article" href="<?php echo $href; ?>" title="<?php echo $title; ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>

				</div><!-- .summary-content -->

			</div><!-- .content-wrapper -->
			<?php require("inc/hk-aside-content.php"); ?>
			<?php require("inc/single_footer_content.php"); ?>
		</div>
		</div>
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</article><!-- #post-<?php the_ID(); ?> -->
