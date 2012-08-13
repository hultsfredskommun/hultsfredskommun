<?php
	define('WP_USE_THEMES', false);
	require('../../../../wp-blog-header.php');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	
	$id = $_POST['id'];
	$post = get_post($id);

	if ($post) : 
		setup_postdata($post);
		
		//inc view-count
		if( function_exists('hk_process_postviews') ){
			hk_process_postviews();
		}
		
		// load the content of post	
		require("../inc/single_content.php");

	endif; 
?>