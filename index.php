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
			/* Query all posts with selected startpage category */
			if ($default_settings["startpage_cat"] != "") {
				$query = array( 'posts_per_page' => '-1', 'category__and' => $default_settings["startpage_cat"] );
				
				query_posts( $query );
		
				if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					get_template_part( 'content', get_post_format() ); 
				endwhile; endif; 
				// Reset Query
				wp_reset_query(); 
			}
			else {
				echo "Du m&aring;ste s&auml;tta egenskapen <i>Startsidans kategori</i> under Utseende -> Inst&auml;llningar.";	
			}


			/* Query all posts with news category */
			if ($default_settings["news_cat"] != "") {
				echo "<span id='news_header'>Senaste Nytt:</span><br class='newline'/>";
				$query = array( 'posts_per_page' => '10', 'category__and' => $default_settings["news_cat"] );
						
				query_posts( $query );		
				if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					get_template_part( 'content', "news" ); 
				endwhile; endif; 
				// Reset Query
				wp_reset_query(); 
			}
			else {
				echo "Du m&aring;ste s&auml;tta egenskapen <i>Nyheternas kategori</i> under Utseende -> Inst&auml;llningar.";	
			}
		?>
		
		<?php dynamic_sidebar('firstpage-content'); ?>
	</div><!-- #content -->
</div><!-- #primary -->

<div id="firstpage-sidebar">
	<?php dynamic_sidebar('firstpage-sidebar'); ?>
</div>

<?php// get_sidebar(); ?>		
<?php get_footer(); ?>