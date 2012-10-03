<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

	<div id="top-nav-sidebar">
		<?php dynamic_sidebar('nav-sidebar'); ?>
	</div>
	<div id="primary">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php
					// get category and tags from post to query related posts later.. 
					$categories = get_the_category();
					$cat_array = array();
					if ($categories) { foreach ($categories as $value) {
						$cat_array[] = $value->term_id;	
					} }  
					// get post type
					$post_type = get_post_type();
				?>
				<?php get_template_part( 'content', ($post_type == 'post')?'single':$post_type ); ?>

				<?php //comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
			
			<?php /* only show related if post_type is post */
			if ($post_type == "post") : ?>
			
				<?php 
				// check for all taxonomies in this query
				$query = array( 'category__in' => $cat_array,
								'post__not_in' => array(get_the_ID())
								//'tag__in' => $tag_array
								);
				
				// loop related posts  
				$wpq = new WP_Query($query);
				if ($wpq->have_posts()) : 
					echo "<aside id='related_posts'>";
					while ($wpq->have_posts()) : $wpq->the_post();
						get_template_part( 'content' );
					endwhile;

					$filter = array("cat" => implode(",",$cat_array));/*, "tags" => $tag_array, "vem_tags" => $vem_array, "ort_tags" => $ort_array);*/
					
					//print_r($wpq);
					echo "<script type='text/javascript'>setSingleSettings = function () { \n";
					echo "settings[\"maxPages\"] = " . $wpq->max_num_pages . ";\n";  
					echo "settings[\"numPages\"] = 0;\n";
					echo "hultsfred_object[\"currentFilter\"] = \"" . addslashes(json_encode($filter)) . "\";\n";
					echo "}\n</script>";

					echo '<div id="dyn-posts-placeholder-2" class="dyn-posts-placeholder"></div>';
					echo '<p id="dyn-posts-load-posts"><a href="#">Ladda fler sidor</a></p>';
				
					echo "</aside>";
				endif; ?>
				<?php wp_reset_query(); ?>
			<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>