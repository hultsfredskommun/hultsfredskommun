<?php
	define('WP_USE_THEMES', false);
	require('../../../../wp-blog-header.php');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	$searchstring = $_REQUEST['searchstring'];
	$options = get_option("hk_theme");
	
	if ($searchstring != "") :
	
		$retString = "";
		
		/* hook to be able to add other search result */ 
		do_action('hk_pre_ajax_search', $searchstring);
		
		/* hook to be able to add other search result */ 
		do_action('hk_post_ajax_search', $searchstring);
		
	endif;
?>
