<?php
	define('WP_USE_THEMES', false);
	require('../../../../wp-blog-header.php');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	
	$filter = $_POST['filter'];
	$filter = stripslashes($filter);
	$filter = json_decode($filter);

	/* get filter variables */
	$orderby = $filter->orderby;
	$search = $filter->search;
	$cat = $filter->cat;
	$tags = $filter->tags;
	$tag_array = "";
	if ($tags != "")
		$tag_array = split(",", $tags);
	$pageNum = $_POST['pageNum'];
	$dyn_query = new WP_Query();
	$posts_per_page = get_option('posts_per_page');
	/* get new posts */
	$query = array( 'category__in' => $cat,
					'posts_per_page' => $posts_per_page,
					'paged' => $pageNum);
	
	// add search to query
	if ($search != "") {
		$query["s"] = $search;
	}

	$dyn_query->query($query);

	/* Start the Loop */
	while ( $dyn_query->have_posts() ) : $dyn_query->the_post();

		get_template_part( 'content');

	endwhile;
?>