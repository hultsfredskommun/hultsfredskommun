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
	if ($cat != "") {
		$children =  hk_getChildrenIdArray($cat);
	} else {
		$children = array();
	}
	$tags = $filter->tags;
	$tag_array = "";
	if ($tags != "")
		$tag_array = explode(",", $tags);
	$shownPosts = explode(",",$_POST['shownPosts']);
	$dyn_query = new WP_Query();
	$posts_per_page = -1;//get_option('posts_per_page');
	
	if ($orderby == "") {

		if ( $cat != "" ) :
			/* Get posts from children of this category */
			$children =  hk_getChildrenIdArray($cat);
			if ( !empty($children) ) {
				/* Get all NOT sticky posts children of this category */
				$args = array( 'category__in' => $children, 'posts_per_page' => $posts_per_page );
				$sticky = get_option( 'sticky_posts' );
				if (!empty($sticky)) {
					$args['post__not_in'] = $sticky;
				}
				if (!empty($tag_array)) {
					$args['tag_slug__and'] = $tag_array;
				}				
				// add search to query
				if ($search != "") {
					$args["s"] = $search;
				}
				if (!empty($shownPosts)) {
					$args['post__not_in'] = $shownPosts;
				}
				query_posts( $args );
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_type() );
				endwhile; endif;
				wp_reset_query(); // Reset Query
			}
		endif;
	}
	
	/* do standard query if orderby is set */
	else {
		$args = array( 'posts_per_page' => $posts_per_page);
		
		if ($cat != "") {
			$children[] = $cat;
		}
		if (!empty($children)) {
			$args['category__in'] = $children;
		}
		if (!empty($tag_array)) {
			$args['tag_slug__and'] = $tag_array;
		}
		if (!empty($shownPosts)) {
			$args['post__not_in'] = $shownPosts;
		}
		
		// add search to query
		if ($search != "") {
			$args["s"] = $search;
		}

		$dyn_query->query($args);

		/* Start the Loop */
		while ( $dyn_query->have_posts() ) : $dyn_query->the_post();
			get_template_part( 'content', get_post_type());

		endwhile;
	}
?>