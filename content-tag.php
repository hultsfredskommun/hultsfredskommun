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

	<article id="post-<?php the_ID(); ?>" <?php echo "class='gtm-dyn-article ".str_replace("hentry", "", implode(" ",get_post_class($classes)))." '"; ?>>
		<div class="article-border-wrapper">
		<div class="article-wrapper">
			<div class="content-wrapper">
				<div class="summary-content">
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
					<h5 class="entry-title tag single-line"><a class="<?php echo $externalclass.$jstoggle; ?>" href="<?php echo $href; ?>" title="<?php echo $title; ?>" rel="bookmark"><?php echo the_title(); ?></a><span class="spinner"></span>
          <?php /* get first related file */
          $first_file_title = "";
          $first_file_url = "";
          $first_link_title = "";
          $first_link_url = "";
          $first_post_title = "";
          $first_post_url = "";
          $link_title = "";
          $link_url = "";
          while ( has_sub_field('hk_related') ) :

				    if ( get_row_layout() == 'hk_related_files' ) {
              $link =  wp_get_attachment_url(get_sub_field('hk_related_file'));
  						$link_name = get_the_title(get_sub_field('hk_related_file'));
  						$relate_file_title = get_sub_field('hk_related_file_description');
  						if ($relate_file_title == "") {
  							$relate_file_title = "L&auml;nk till " . $link;
  						}
              if (empty($first_file_url)) {
                $first_file_title = $relate_file_title;
                $first_file_url = $link;
              }
              break;
            }
            elseif ( get_row_layout() == 'hk_related_links' ) {
              $relate_link_url = get_sub_field('hk_relate_link_url');
              if ($relate_link_url != "" && substr_compare($relate_link_url, "http", 0, 4) != 0) {
                $relate_link_url = "https://" . $relate_link_url;
              }
              $relate_link_title = get_sub_field('hk_related_link_description');
              if ($relate_link_title == "") {
                $relate_link_title = "L&auml;nk till " . $relate_link_url;
              }
              if (empty($first_link_url)) {
                $first_link_title = $relate_link_title;
                $first_link_url = $relate_link_url;
              }
              break;
            }
            elseif ( get_row_layout() == 'hk_related_posts' ) {
              $value = get_sub_field('hk_related_post');
              $relate_post_title = get_sub_field('hk_related_post_description');
              if ($relate_post_title == "") {
                if (!empty($value->ID)) {
                  $relate_post_title = "L&auml;nk till " . get_permalink($value->ID);
                }
              }
              $post_link = get_permalink($value->ID);

              if (empty($first_post_url)) {
                $first_post_title = $relate_post_title;
                $first_post_url = $post_link;
              }
              break;
            }
          endwhile;

          // find first of file, link and post
          if (!empty($first_file_url)) {
            $link_title = $first_file_title;
            $link_url = $first_file_url;
          }
          elseif (!empty($first_link_url)) {
            $title = $first_link_title;
            $link_url = $first_link_url;
          }
          elseif (!empty($first_post_url)) {
            $title = $first_post_title;
            $link_url = $first_post_url;
          }

          if (!empty($link_url)) : ?>
            <div class="single-line-icon related_file related_title">
              <a target="_blank" href="<?php echo $link_url; ?>" title="<?php echo $link_title; ?>"><span class="related-small-icon"></span><?php //echo $link_name; ?></a>
            </div>
          <?php endif; ?>
          </h5>

					<?php

           /*
					<div class="entry-content">
						<?php the_excerpt(); ?>
					</div>
					*/ ?>

				</div><!-- .summary-content -->

			</div><!-- .content-wrapper -->
			<?php //require("inc/hk-aside-content.php"); ?>
			<?php //require("inc/single_footer_content.php"); ?>
		</div>
		</div>
		<span class='hidden article_id'><?php the_ID(); ?></span>
	</article><!-- #post-<?php the_ID(); ?> -->
