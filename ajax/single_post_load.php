<?php
	define('WP_USE_THEMES', false);
	require('../../../../wp-blog-header.php');
	//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header("HTTP/1.1 200 OK");
	
	$id = $_REQUEST['id'];
	$blog_id = $_REQUEST['blog_id'];
	global $switched;
	$switchblog = true;
	
	$switchblog = false;
	if ($blog_id != "" && get_current_blog_id() != $blog_id)
		$switchblog = true;
	
	if ($switchblog)
		switch_to_blog($blog_id);
	
	$post = get_post($id);
	if ($post) : 
		setup_postdata($post);
		
		// count views of post
		if( function_exists('hk_process_postviews') ){
			hk_process_postviews();
		}
		
		// load the content of post	
		require("../inc/single_content.php");

	endif; 
	//if ($switchblog)
	//	restore_current_blog();

?>