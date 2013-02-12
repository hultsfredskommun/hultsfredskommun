<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

	<?php hk_navigation(); ?>
	
	<div id="primary" class="primary">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php
					$cat_array = array();
					$from_string = "" ;
					// get category from post to query related posts later.. 
					$categories = get_the_category();
					if ($categories) { foreach ($categories as $value) {
						$cat_array[] = $value->term_id;	
						$from_string .= $value->name . ", ";
					} } 
					$from_string = rtrim($from_string, ", ");
					// get post type
					$post_type = get_post_type();
				?>
				<?php get_template_part( 'content', ($post_type == 'post')?'single':$post_type ); ?>

				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
			
			<?php /* only show related if post_type is post */
			if (empty($_REQUEST["print"]) && !empty($cat_array)) : ?>
			
				<?php 
				
				// check for all taxonomies in this query
				$query = array( 'category__in' => $cat_array,
								'post__not_in' => array(get_the_ID()),
								'post_type' => $post_type
								);
				
				// loop related posts  
				$wpq = new WP_Query($query);
				if ($wpq->have_posts()) : 
					echo "<div class='more-from-heading'><span>Mer fr&aring;n " . $from_string . "</span></div>";
					echo "<aside id='related_posts'>";
					while ($wpq->have_posts()) : $wpq->the_post();
						get_template_part( 'content' , get_post_type());
					endwhile;
					/*
					$filter = array("cat" => implode(",",$cat_array));
					
					echo "<script type='text/javascript'>setSingleSettings = function () { \n";
					echo "settings[\"maxPages\"] = " . $wpq->max_num_pages . ";\n";  
					echo "settings[\"numPages\"] = 0;\n";
					echo "hultsfred_object[\"currentFilter\"] = \"" . addslashes(json_encode($filter)) . "\";\n";
					echo "}\n</script>";

					echo '<div id="dyn-posts-placeholder-2" class="dyn-posts-placeholder"></div>';
					echo '<p id="dyn-posts-load-posts"><a href="#">Ladda fler sidor</a></p>';
					*/
					echo "</aside>";
				endif; 
				
				// help navigation
				hk_category_help_navigation();
				
				?>
				<?php wp_reset_query(); ?>
			<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>