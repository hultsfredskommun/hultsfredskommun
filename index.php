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

<?php dynamic_sidebar('slideshow-content'); ?>

<?php if ( is_active_sidebar("firstpage-top-content") ) : ?>
<div id="firstpage-top-content">
		<?php dynamic_sidebar('firstpage-top-content'); ?>
</div><!-- #firstpage-top-sidebar -->
<?php endif; ?>

<div id="primary" <?php echo (is_active_sidebar("firstpage-secondary-sidebar")) ? "class='with-secondary'" : ""; ?>>
	<div id="content" role="main">
		<?php 
			/* Query all posts with selected startpage category */
			if ($default_settings["startpage_cat"] != "") {
				$query = array( 'posts_per_page' => '-1', 
								'tax_query' => array(
									array(
										'taxonomy' => 'special_category',
										'field' => 'id',
										'terms' => $default_settings["startpage_cat"]
									)
								) );
				
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
				echo "<div id='news'>";
				echo "<span id='news_header'>Nyheter</span><hr class='newline' />";
				$query = array( 'posts_per_page' => '10', 
								'tax_query' => array(
									array(
										'taxonomy' => 'special_category',
										'field' => 'id',
										'terms' => $default_settings["news_cat"]
									)
								) );

				query_posts( $query );		
				if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					get_template_part( 'content', "news" ); 
				endwhile; endif; 
				?> 
				<span class="read-more-link"><a href="<?php echo get_category_link($default_settings["news_cat"]); ?>">Fler nyheter</a></span>
				</div>
				<?php // Reset Query
				wp_reset_query(); 
			}
			else {
				echo "Du m&aring;ste s&auml;tta egenskapen <i>Nyheternas kategori</i> under Utseende -> Inst&auml;llningar.";	
			}
		?>
		
		<?php dynamic_sidebar('firstpage-content'); ?>
	</div><!-- #content -->
</div><!-- #primary -->

<?php if (is_active_sidebar("firstpage-secondary-sidebar")) : ?>
<div id="firstpage-secondary-sidebar">
	<?php dynamic_sidebar('firstpage-secondary-sidebar'); ?>
</div>
<?php endif; ?>
<div id="firstpage-sidebar">
	<?php dynamic_sidebar('firstpage-sidebar'); ?>
</div>

<?php// get_sidebar(); ?>		
<?php get_footer(); ?>