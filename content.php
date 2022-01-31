<?php
/**
 * The default template for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

global $blog_id, $external_blog;
$classes = "summary";
$classes .= (is_sticky())?" sticky":"";
$classes .= ($external_blog)?" externalblog":"";
 ?>

	<article id="post-<?php the_ID(); ?>" <?php echo "class='post gtm-dyn-article ".str_replace("hentry", "", implode(" ",get_post_class($classes)))." '"; ?>>
		<div class="article-border-wrapper">
		<div class="article-wrapper">
			<div class="content-wrapper">
				<div class="summary-content">
					<?php $thumb = hk_get_the_post_thumbnail(get_the_ID(),'thumbnail-image', false, false);
					if ($thumb != "") :
						echo $thumb;
					else : /* else default thumb; */
						$options = get_option("hk_theme");
						$src = $options["default_thumbnail_image"];
						if (!empty($src)) :
						?>
						<div class="img-wrapper "><div><img class="slide" src="<?php echo $src; ?>" alt="" role="presentation"></div></div>
					<?php endif; endif;/*endif;*/ ?>
					<?php
					$externalclass = "";
					$jstoggle = "js-toggle-article";
					if ($external_blog) {
						$jstoggle = "";
						$href = get_permalink();
						$title = "Länk till annan webbplats " . the_title_attribute( 'echo=0' );
					}
					else {
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
					}
					?>
					<h1 class="entry-title"><a class="<?php echo $externalclass.$jstoggle; ?>" href="<?php echo $href; ?>" title="<?php echo $title; ?>" rel="bookmark"><?php the_title(); ?></a><span class="spinner"></span></h1>
					<div class="entry-content">
                        <?php
                        if (!empty($_REQUEST["action"]) && $_REQUEST["action"] == "hk_search" &&
                            !empty($_REQUEST["searchstring"]) && $_REQUEST["searchstring"] != "" && function_exists('relevanssi_do_query')) {
                            //relevanssi_the_excerpt(); // not showing same as search excerpt
                            //$content = apply_filters(‘relevanssi_excerpt_content’, get_the_content());//, $post, $query);
                            //print_r($post);
                            $excerpt = relevanssi_do_excerpt($post, $_REQUEST["searchstring"]);
                            //$excerpt = relevanssi_highlight_terms($excerpt, $_REQUEST["searchstring"]);
                            //echo '<a class="' . $externalclass.$jstoggle . '" href="' . $href . '" title="' . $title . '" rel="bookmark">';
                            echo $excerpt;

                            $u_modified_time = get_the_modified_time('U');
                            if ($u_modified_time) {
                            echo "<p style='font-size: 90%; font-style: italic;'>Senast uppdaterad ";
                            the_modified_time('j F, Y');
                            echo " vid ";
                            the_modified_time();
                            echo "</p> ";
                            }
                            //echo "</a>";
                        }
                        else {
                            the_excerpt();
                        }
                        ?>
					</div>

				</div><!-- .summary-content -->

			</div><!-- .content-wrapper -->
			<?php //require("inc/hk-aside-content.php"); ?>
			<?php //require("inc/single_footer_content.php"); ?>
		</div>
		</div>
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</article><!-- #post-<?php the_ID(); ?> -->
