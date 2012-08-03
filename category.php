<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); 

?>
		<div id="dynamic-nav-sidebar" style="display:none">
			<?php dynamic_sidebar('nav-sidebar'); ?>
		</div><!-- #dynamic-nav-sidebar -->

		<div id="slideshow-sidebar" style="display:none">
			<?php dynamic_sidebar('slideshow-sidebar'); ?>
		</div><!-- #slideshow-sidebar -->

		<section id="primary">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title"><?php
						echo 'Sidor i <span>' . single_cat_title( '', false ) . '</span>';
					?></h1>

					<?php
						$category_description = category_description();
						if ( ! empty( $category_description ) )
							echo apply_filters( 'category_archive_meta', '<div class="category-archive-meta">' . $category_description . '</div>' );
					?>

					<?php 
						if( function_exists('displaySortOrderButtons') ){
							displaySortOrderButtons();
						} 
					?>
					
					<div id="viewmode">
						<a id="viewmode_summary" title="Visa ingress" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/posts_framed.png" /></a>
						<a id="viewmode_titles" title="Visa endast rubriker" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/posts_titles.png" /></a>
					</div>
					<div class="clear"></div>
				</header>

				<div id="sticky-posts">
					<?php
						/* Get category id */
						$catID = get_query_var("cat");
					
						/* Get all sticky posts */
						$sticky = get_option( 'sticky_posts' );
						
						if (isset($sticky)):

							/* Query sticky posts */
							query_posts( array( 'category__in' => $catID, 'post__in' => $sticky ) );
							
							if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>			
								<?php get_template_part( 'content', get_post_format() ); ?>
							<?php endwhile; endif;
						endif; 
						// Reset Query
						wp_reset_query(); 
					?>
				</div><!-- #sticky-posts -->

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						//if( !is_sticky() ) {

							/* Include the Post-Format-specific template for the content.
							 * If you want to overload this in a child theme then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'content', get_post_format() );
						//}
					?>

				<?php endwhile; ?>

				<?php twentyeleven_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</div><!-- #content -->
		</section><!-- #primary -->

		<div id="sidebar-wrapper">
			<div id="nav-sidebar">
				<?php dynamic_sidebar('nav-sidebar'); ?>
			</div><!-- #nav-sidebar -->
			<div id="sidebar">
				<?php dynamic_sidebar('sidebar'); ?>
			</div><!-- #sidebar -->
		</div><!-- #sidebar-wrapper -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
