<?php
	define('WP_USE_THEMES', false);
	require('../../../wp-blog-header.php');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	
	$id = $_POST['id'];
	$post = get_post($id);

	if ($post) : 
		setup_postdata($post);
		
		// load the content of post	
		require("inc/single_content.php");

	endif; 
?>