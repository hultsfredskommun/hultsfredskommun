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
		$tag_array = split(",", $tags);
	$pageNum = $_POST['pageNum'];
	$dyn_query = new WP_Query();
	$posts_per_page = get_option('posts_per_page');
	
	if ($orderby == "") {

		if ( $cat != "" ) :
			/* Get posts from children of this category */
			$children =  hk_getChildrenIdArray($cat);
			if ( !empty($children) ) {
				/* Get all NOT sticky posts children of this category */
				$args = array( 'category__in' => $children, 'posts_per_page' => $posts_per_page, 'paged' => $pageNum );
				$sticky = get_option( 'sticky_posts' );
				if (!empty($sticky)) {
					$args['post__not_in'] = $sticky;
				}
				if (!empty($tag_array)) {
					$query['tags__in'] = $tag_array;
				}				
				// add search to query
				if ($search != "") {
					$query["s"] = $search;
				}
				query_posts( $args );
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_format() );
				endwhile; endif;
				wp_reset_query(); // Reset Query
			}
		endif;
	}
	
	/* do standard query if orderby is set */
	else {
		$query = array( 'posts_per_page' => $posts_per_page,
						'paged' => $pageNum);
		
		if ($cat != "") {
			$children[] = $cat;
		}
		if (!empty($children)) {
			$query['category__in'] = $children;
		}
		if (!empty($tag_array)) {
			$query['tags__in'] = $tag_array;
		}
		
		// add search to query
		if ($search != "") {
			$query["s"] = $search;
		}

		$dyn_query->query($query);

		/* Start the Loop */
		while ( $dyn_query->have_posts() ) : $dyn_query->the_post();
			get_template_part( 'content', get_post_format());

		endwhile;
	}
?>