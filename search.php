<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>
		<?php $options = get_option("hk_theme");
			//hk_navigation(); ?>
		
		<?php /* hook to be able to add other search result */ 
		do_action('hk_pre_search', get_query_var("s")); ?>
		
		<div id="primary" class="primary  searchresult">
			<div id="content" role="main">
			

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<ul class="num-posts">
						<li><a class='nolink'>Du s&ouml;kte p&aring; <strong><?php echo get_query_var("s"); ?></strong></a></li>
					</ul>

					<ul class="view-tools">
						<li class="menu-item view-mode"> 
						<a class="viewmode_titles js-view-titles active" title="Listvisning" href="#"></a>
						<a class="viewmode_summary js-view-summary" title="Kompakt visning" href="#"></a>
						</li>
					</ul>
				</header>

				
				<?php if (function_exists('relevanssi_didyoumean')) { relevanssi_didyoumean(get_search_query(), "<div class='didyoumean'>Menade du: ", "</div>", 5);
				}?>
				
				<?php /* Start the Loop */ ?>
				
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
						$external_blog = false; 
						if ($blog_id != $post->blog_id){ 
							$external_blog = true; 
							switch_to_blog($post->blog_id);
						}
						
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_type() );
						if ($external_blog) { 
							restore_current_blog();
						}
					?>

				<?php endwhile; ?>

				<?php //hk_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php hk_empty_search(); ?>
				
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->
		
		<?php /* hook to be able to add other search result */ 
		do_action('hk_post_search', get_query_var("s")); 
		
		/* add external link search */
		if ($options["external_search_title"] != "" && $options["external_search_url"] != "")
			echo "<a class='external_more_link' href='" . $options["external_search_url"] . get_query_var("s") . " ' title='" . $options["external_search_title"] . "'>" . $options["external_search_title"] . "</a>";
		?>
		
<?php get_footer(); ?>