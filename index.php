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
<div id="slideshow-sidebar" style="display:none">
	<?php dynamic_sidebar('slideshow-sidebar'); ?>
</div><!-- #slideshow-sidebar -->

<div id="firstpage-top-content">
		<?php dynamic_sidebar('firstpage-top-content'); ?>
</div><!-- #firstpage-top-sidebar -->

<div id="primary">
	<div id="content" role="main">
		<?php 
			/* Get all sticky posts */
			$sticky = get_option( 'sticky_posts' );
			
			if( isset($sticky) ) :
				echo '<div id="sticky-posts">';
				
				/* Sort the stickies with the newest ones at the top */
				rsort( $sticky );
				
				/* Get the 5 newest stickies (change 5 for a different number) */
				$sticky = array_slice( $sticky, 0, 5 );

				/* Query sticky posts */
				query_posts( array( 'post__in' => $sticky, /*'cat__in' => ,*/ 'caller_get_posts' => 1 ) );
		
				if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					get_template_part( 'content', get_post_format() ); 
				endwhile; endif; 
				// Reset Query
				wp_reset_query(); 
			
				echo '</div><!-- #sticky-posts -->';
			endif;
		?>
		
		<?php dynamic_sidebar('firstpage-content'); ?>
	</div><!-- #content -->
</div><!-- #primary -->

<div id="firstpage-sidebar">
	<?php dynamic_sidebar('firstpage-sidebar'); ?>
</div>

<?php// get_sidebar(); ?>		
<?php get_footer(); ?>