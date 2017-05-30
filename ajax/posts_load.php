<?php
	define('WP_USE_THEMES', false);
	require('../../../../wp-blog-header.php');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	$filter = $_POST['filter'];
	$filter = stripslashes($filter);
	$filter = json_decode($filter);
	
	/* get filter variables */
	$orderby = $filter->orderby;
	$cat = $filter->cat;
	//$paged = $filter->paged;
	$showfromchildren = $filter->showfromchildren;
	$shownposts = $filter->shownposts;
	
	$args = hk_get_cat_query_args($cat, $paged, $showfromchildren, $orderby, $shownposts);
	//print_r($args);
	query_posts($args);
     
	/* Start the Loop */
	if ( have_posts() ) { 
		//echo "<div>server: $paged</div>";
		while ( have_posts() ) {
			the_post();
			get_template_part( 'content', get_post_type());
		}
	}
?>