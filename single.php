<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

					<?php comments_template( '', true ); ?>
					<?php
						// get category and tags from post to query related posts later.. 
						$categories = get_the_category();
						$cat_array = array();
						if ($categories) { foreach ($categories as $value) {
							$cat_array[] = $value->term_id;	
						} } 
						
						$tags = get_the_tags(); 
						$tag_array = array();
						if ($tags) { foreach ($tags as $value) {
							$tag_array[] = $value->term_id;	
						} } 
						
						$ort = get_the_terms(get_the_ID(), "ort"); 					
						$ort_array = array();
						if ($ort) { foreach ($ort as $value) {
							$ort_array[] = $value->term_id;	
						} } 

						$vem = get_the_terms(get_the_ID(), "vem"); 					
						$vem_array = array();
						if ($vem) { foreach ($vem as $value) {
							$vem_array[] = $value->term_id;	
						} } 
					?>
				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		<?php 
		// check for all taxonomies in this query
		$query = array( 'category__in' => $cat_array,
						'post__not_in' => array(get_the_ID())
					 	//'tag__in' => $tag_array
						);
		/*
		if (count($vem_array) > 0 && count($ort_array) > 0) {
			$query['tax_query'] = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'vem',
					'field' => 'id',
					'terms' => $vem_array )
				,
				array(
					'taxonomy' => 'ort',
					'field' => 'id',
					'terms' => $ort_array
				)
			);
		}						 	
		else if (count($vem_array) > 0) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'vem',
					'field' => 'id',
					'terms' => $vem_array )
			);
		}						 	
		else if (count($ort_array) > 0) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'ort',
					'field' => 'id',
					'terms' => $ort_array )
			);
		}

		*/
		// loop all posts to get all taxonomies used 
		$wpq = new WP_Query($query);
		if ($wpq->have_posts()) : 
			echo "<aside id='related_posts'>";
			echo "<header><h2>Relaterade sidor</h2></header>";
			while ($wpq->have_posts()) : $wpq->the_post();
				get_template_part( 'content' );
			endwhile;
			echo "</aside>";
		endif;

		$filter = array("cat" => implode(",",$cat_array));/*, "tags" => $tag_array, "vem_tags" => $vem_array, "ort_tags" => $ort_array);*/
		
		//print_r($wpq);
		echo "<script type='text/javascript'>setSingleSettings = function () { \n";
		echo "settings[\"maxPages\"] = " . $wpq->max_num_pages . ";\n";  
		echo "settings[\"numPages\"] = 0;\n";
		echo "hultsfred_object[\"currentFilter\"] = \"" . addslashes(json_encode($filter)) . "\";\n";
  
		echo "}\n</script>";
		?>

		<div id="dyn-posts-placeholder-2" class="dyn-posts-placeholder"></div>
		<p id="dyn-posts-load-posts"><a href="#">Ladda fler sidor</a></p>

		</div><!-- #primary -->

<?php get_footer(); ?>