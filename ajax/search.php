<?php
	define('WP_USE_THEMES', false);
	require('../../../../wp-blog-header.php');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	$searchstring = $_POST['searchstring'];
	if ($searchstring != "") :
		/* get new posts */
		//$query = array(	'posts_per_page' => get_option('posts_per_page') );
		$query = array(	'posts_per_page' => 15 );
	
		// add search to query
		$query["s"] = $searchstring;
		$dyn_query = new WP_Query();
		$dyn_query->query($query);

		$retArray = array();

		/* Start the Loop */
		$retString = "<ul>";
		$retString .= "<li><a href='" . get_stylesheet_directory_uri() . "/search.php?s=" . $searchstring . "'>S&ouml;k efter " . $searchstring . "</a></li>";
		while ( $dyn_query->have_posts() ) : $dyn_query->the_post();
			$retString .= "<li><a href='" . get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a></li>";
		endwhile;
		$retString .= "</ul>";
		echo $retString;

	endif;
?>