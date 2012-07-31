<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */

get_header(); ?>

<div id="primary">
	<div id="firstpage-top-content">
		<?php dynamic_sidebar('firstpage-top-content'); ?>
	</div>
	
	<div id="content" role="main">
		<div id="sticky-posts">
			<?php 
				/* Get all sticky posts */
				$sticky = get_option( 'sticky_posts' );
				
				/* Sort the stickies with the newest ones at the top */
				rsort( $sticky );
				
				/* Get the 2 newest stickies (change 2 for a different number) */
				$sticky = array_slice( $sticky, 0, 2 );

				/* Query sticky posts */
				query_posts( array( 'post__in' => $sticky, /*'cat__in' => ,*/ 'caller_get_posts' => 1 ) );
			?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>			
				<div <?php post_class(); ?>>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<?php the_content(); ?>
				</div>
			<?php endwhile; else: ?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php endif; 
				// Reset Query
				wp_reset_query(); 
			?>
		</div><!-- #sticky-posts -->
		
		<?php dynamic_sidebar('firstpage-content'); ?>
	</div><!-- #content -->
	
	<div id="firstpage-sidebar">
		<?php dynamic_sidebar('firstpage-sidebar'); ?>
	</div>
</div><!-- #primary -->

<?php// get_sidebar(); ?>		
<?php get_footer(); ?>