<?php
	/**
	 * Sort-order function:
	 * adds function for displaying sort-order buttons
	 * adds filter for sort-order
	 */

	function displaySortOrderButtons(){ ?>
		<div id="sort-order">
			<?php
				//init
				$tags = get_query_var("tag");
				$vem_tags = get_query_var("vem");
				$ort_tags = get_query_var("ort");
				
				if($tags != ''){ $tags = "&tag=".$tags; }
				if($vem_tags != ''){ $vem_tags = "&vem=".$vem_tags; }
				if($ort_tags != ''){ $ort_tags = "&ort=".$ort_tags; }
			?>
			<a href="?orderby=alpha<?php echo $tags.$vem_tags.$ort_tags; ?>">A - &Ouml;</a>
			<span class="sep"> | </span>
			<a href="?orderby=alpha_desc<?php echo $tags.$vem_tags.$ort_tags; ?>">&Ouml; - A</a>
			<span class="sep"> | </span>
			<a href="?orderby=latest<?php echo $tags.$vem_tags.$ort_tags; ?>">Nyaste</a>
			<span class="sep"> | </span>
			<a href="?orderby=oldest<?php echo $tags.$vem_tags.$ort_tags; ?>">&Auml;ldsta</a>
			<?php if( function_exists('views_orderby') ) : ?>
				<span class="sep"> | </span>			
				<a href="?orderby=popular<?php echo $tags.$vem_tags.$ort_tags; ?>">Popul&auml;raste</a>
			<?php endif; ?>
		</div>

	<?php }
	
	// code from WP-PostViews process_postviews to count views when viewing posts dynamically
	function hk_process_postviews() {
		global $post;
		$id = intval($post->ID);
		$views_options = get_option('views_options');
		$post_views = get_post_custom($id);
		$post_views = intval($post_views['views'][0]);
		$should_count = false;
		switch(intval($views_options['count'])) {
			case 0:
				$should_count = true;
				break;
			case 1:
				if(empty($_COOKIE[USER_COOKIE]) && intval($user_ID) == 0) {
					$should_count = true;
				}
				break;
			case 2:
				if(intval($user_ID) > 0) {
					$should_count = true;
				}
				break;
		}
		if(intval($views_options['exclude_bots']) == 1) {
			$bots = array('Google Bot' => 'googlebot', 'Google Bot' => 'google', 'MSN' => 'msnbot', 'Alex' => 'ia_archiver', 'Lycos' => 'lycos', 'Ask Jeeves' => 'jeeves', 'Altavista' => 'scooter', 'AllTheWeb' => 'fast-webcrawler', 'Inktomi' => 'slurp@inktomi', 'Turnitin.com' => 'turnitinbot', 'Technorati' => 'technorati', 'Yahoo' => 'yahoo', 'Findexa' => 'findexa', 'NextLinks' => 'findlinks', 'Gais' => 'gaisbo', 'WiseNut' => 'zyborg', 'WhoisSource' => 'surveybot', 'Bloglines' => 'bloglines', 'BlogSearch' => 'blogsearch', 'PubSub' => 'pubsub', 'Syndic8' => 'syndic8', 'RadioUserland' => 'userland', 'Gigabot' => 'gigabot', 'Become.com' => 'become.com');
			$useragent = $_SERVER['HTTP_USER_AGENT'];
			foreach ($bots as $name => $lookfor) { 
				if (stristr($useragent, $lookfor) !== false) { 
					$should_count = false;
					break;
				} 
			}
		}
		if($should_count) {			
			if(!update_post_meta($id, 'views', ($post_views+1))) {
				add_post_meta($id, 'views', 1, true);
			}
		}
	
	}
	function hk_FilterOrder ($order = '') {
		global $wpdb;

		if (isset($_REQUEST["orderby"]))
			$orderby = $_REQUEST["orderby"];
		else if( !function_exists( 'views_orderby' ))
			$orderby = "latest"; // alphabetical to be standard if no set

		if (is_search()) {
			// wordpress standard for now
		}
		else if ($orderby == "latest") {
			// wordress blog standard
			$order = ' (' . $wpdb->posts . '.post_date ) DESC';
		}
		else if ($orderby == "oldest") {
			$order = ' (' . $wpdb->posts . '.post_date ) ASC';
		}
		else if ($orderby == "alpha") {
			$order = ' (' . $wpdb->posts . '.post_title ) ASC';
		}
		else if ($orderby == "alpha_desc") {
			$order = ' (' . $wpdb->posts . '.post_title ) DESC';
		}
		return $order;
	}
	add_filter ('posts_orderby', 'hk_FilterOrder');
	
	// Sets sort-order most viewed as default or if orderby == popular
	add_action('pre_get_posts', 'hk_views_sorting');
	function hk_views_sorting($local_wp_query) {
		if ( !isset($_REQUEST["orderby"]) or (isset($_REQUEST["orderby"]) and $_REQUEST["orderby"] == 'popular') ) {
			add_filter('posts_fields', 'views_fields');
			add_filter('posts_join', 'views_join');
			add_filter('posts_where', 'views_where');
			add_filter('posts_orderby', 'views_orderby');
		} else {
			remove_filter('posts_fields', 'views_fields');
			remove_filter('posts_join', 'views_join');
			remove_filter('posts_where', 'views_where');
			remove_filter('posts_orderby', 'views_orderby');
		}
	}
?>