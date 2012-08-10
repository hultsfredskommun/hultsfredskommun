<?php
	define('WP_USE_THEMES', false);
	require('../../../wp-blog-header.php');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	
	$filter = $_POST['filter'];
	$filter = stripslashes($filter);
	$filter = json_decode($filter);

	/* get filter variables */
	$search = $filter->search;
	$cat = $filter->cat;
	$tags = $filter->tags;
	$tag_array = "";
	if ($tags != "")
		$tag_array = split(",", $tags);
	$vem_tags = $filter->vem_tags;
	$vem_array = array();
	if ($vem_tags != "")
		$vem_array = split(",", $vem_tags);
	$ort_tags = $filter->ort_tags;
	$ort_array = array();
	if ($ort_tags != "")
		$ort_array = split(",", $ort_tags);

	$pageNum = $_POST['pageNum'];
	$dyn_query = new WP_Query();

	/* get new posts */
	$query = array( 'category__in' => $cat,
				 	'tag_slug__in' => $tag_array,				
					'posts_per_page' => get_option('posts_per_page'),
					'paged' => $pageNum);

	// add search to query
	if ($search != "") {
		$query["s"] = $search;
	}
	
	// add custom tags to query
	if (count($vem_array) > 0 && count($ort_array) > 0) {
		$query['tax_query'] = array(
			'relation' => 'AND',
			array(
				'taxonomy' => 'vem',
				'field' => 'slug',
				'terms' => $vem_array )
			,
			array(
				'taxonomy' => 'ort',
				'field' => 'slug',
				'terms' => $ort_array
			)
		);
	}						 	
	else if (count($vem_array) > 0) {
		$query['tax_query'] = array(
			array(
				'taxonomy' => 'vem',
				'field' => 'slug',
				'terms' => $vem_array )
		);
	}						 	
	else if (count($ort_array) > 0) {
		$query['tax_query'] = array(
			array(
				'taxonomy' => 'ort',
				'field' => 'slug',
				'terms' => $ort_array )
		);
	}
	$dyn_query->query($query);

	/* Start the Loop */
	while ( $dyn_query->have_posts() ) : $dyn_query->the_post();

		get_template_part( 'content');

	endwhile;
?>