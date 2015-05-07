<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

if (isset($_GET["only_content"])) {
	$options = get_option("hk_theme");
	echo "<style type='text/css'>" . $options["if_only_content"] . "</style>";
	echo $options["if_only_content_js"];
}

if (!isset($_GET["only_content"])) :
get_header(); 
?>

	<?php hk_navigation(); ?>
	
	<div id="primary" class="primary">
		<div id="content" role="main">
<?php endif; ?>
			<?php if ( have_posts() ) : the_post(); ?>
				<?php
					$cat_array = array();
					$from_string = "" ;
					// get category from post to query related posts later.. 
					$categories = get_the_category();
					if ($categories) { foreach ($categories as $value) {
						$cat_array[] = $value->term_id;	
						$from_string .= "<a href='" . get_category_link( $value->term_id ) . "' title='L&auml;nk till kategorien " . $value->name . "'>" . $value->name . "</a>, ";
					} } 
					$from_string = rtrim($from_string, ", ");
					// get post type
					$post_type = get_post_type();
				?>
				<?php get_template_part( 'content', 'single' ); ?>

			<?php endif; // end of the loop. ?>
			
			<?php /* show related posts */
			
			if (empty($_REQUEST["print"]) && !isset($_GET["only_content"]) && !empty($cat_array)) : ?>
			
				<?php 
				
				// check for all taxonomies in this query
				$query = array( 'category__in' => $cat_array,
								'post__not_in' => array(get_the_ID()),
								'posts_per_page' => 5,
								);
				
				// loop related posts  
				$wpq = new WP_Query($query);
				if ($wpq->have_posts()) : 
					echo "<div class='more-from-heading'><span>Se mer fr&aring;n kategorierna " . $from_string . "</span></div>";
					echo "<aside id='related_posts'>";
					while ($wpq->have_posts()) : $wpq->the_post();
						get_template_part( 'content' , get_post_type());
					endwhile;
					
					// removed dynamic load more
					if (false) { 
					$filter = array("cat" => implode(",",$cat_array));
					
					echo "<script type='text/javascript'>setSingleSettings = function () { \n";
					echo "settings[\"maxPages\"] = " . $wpq->max_num_pages . ";\n";  
					echo "settings[\"numPages\"] = 0;\n";
					echo "hultsfred_object[\"currentFilter\"] = \"" . addslashes(json_encode($filter)) . "\";\n";
					echo "}\n</script>";

					echo '<div id="dyn-posts-placeholder-2" class="dyn-posts-placeholder"></div>';
					echo '<p id="dyn-posts-load-posts"><a href="#">Ladda fler sidor</a></p>';
					}
					echo "</aside>";
				endif; 
				

				
				?>
				<?php wp_reset_query(); ?>
			<?php endif;  ?>
<?php if (!isset($_GET["only_content"])) : ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
<?php endif; ?>