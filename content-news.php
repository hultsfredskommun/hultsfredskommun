<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
global $thumb_size;
if (empty($thumb_size)) {
	$thumb_size = 'thumbnail-image';
}
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky news summary":"news summary"); ?>>
		<div class="article-border-wrapper">
		<div class="article-wrapper">
			<div class="content-wrapper">
				<div class="summary-content">
					<?php
					if ($thumb_size != "none") :
					$thumb = hk_get_the_post_thumbnail(get_the_ID(),$thumb_size, false, false);
					if ($thumb) :
						echo $thumb;
					else : /* else default thumb; */
						$options = get_option("hk_theme");
						$src = $options["default_thumbnail_image"];
						if (!empty($src)) :
						?>
						<div class="img-wrapper "><div><img class="slide" src="<?php echo $src; ?>" alt="" role="presentation"></div></div>
					<?php endif; /*end empty */ endif; /* end else default thumb */ endif; /* end thumb_size != none */ ?>
					<?php
					$externalclass = "";
					$jstoggle = " js-toggle-article";
					if (function_exists("get_field")) {
						$href = get_field('hk_external_link_url');
						$name = get_field('hk_external_link_name');
						if (!empty($href))
						{
							$jstoggle = "";
							$externalclass = " js-external-link";
							$title = "Extern länk till " . the_title_attribute( 'echo=0' );
						}
					}
					if (empty($href)) {
						$href = get_permalink();
						$title = "Länk till " . the_title_attribute( 'echo=0' );
					}
					$externalclass = "class='gtm-cn-news-link$externalclass$jstoggle'"

					?>
					<div class="content-text-wrapper">
					<h5 class="entry-title"><a <?php echo $externalclass; ?> href="<?php echo $href; ?>" title="<?php echo $title; ?>" rel="bookmark"><?php the_title(); ?></a></h5>
					<?php
						// if news
						if (!empty($default_settings["news_tag"]) && has_tag($default_settings["news_tag"])) {
							echo "<time>" . get_the_date("Y-m-d") . "</time> ";
						}
					?>
					<div class="entry-content">
						<?php the_excerpt();
						if (!empty($href) && !empty($name))
						{
							echo "<a class='gtm-cn-news-button button' href='$href' title='$name'>$name</a>";
						}
						?>
					</div>
					</div>

				</div><!-- .summary-content -->

			</div><!-- .content-wrapper -->
			<span class='hidden article_id'><?php the_ID(); ?></span>
		</div>
		</div>
	</article><!-- #post-<?php the_ID(); ?> -->
