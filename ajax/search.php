<?php
	define('WP_USE_THEMES', false);
	require('../../../../wp-blog-header.php');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	$searchstring = $_POST['searchstring'];
	if ($searchstring != "") :
		$retString = "<ul>";
		$retString .= "<li><a href='" . site_url() . "/?s=" . $searchstring . "'>S&ouml;k efter " . $searchstring . "</a></li>";
		$retString = "</ul>";

		
		/* hook to be able to add other search result */ 
		do_action('hk_pre_ajax_search', $searchstring);

		
		/* get categories */
		$sql = "SELECT $wpdb->terms.name as name, $wpdb->terms.term_id as term_id ".
		"FROM $wpdb->terms, $wpdb->term_taxonomy ".
		"WHERE $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->terms.term_id ".
		"AND $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->terms.name LIKE '%" . $searchstring . "%';";
		$result = @mysql_query($sql);
		if($result && mysql_num_rows($result) > 0) {
			$retString .= "<ul class='search-category'>";
			$retString .= "<li class='search-title'>Kategori</li>";
			while($row = mysql_fetch_array($result)) {
				$name = $row["name"];
				$term_id = $row["term_id"];
				$link = get_category_link($term_id);
				if ( is_wp_error( $link ) ) {
					continue;
				}	
				$retString .= "<li><a href='$link'>$name</a></li>";
			}
			$retString .= "</ul>";
		}


		/* get post_tag */
		$sql = "SELECT $wpdb->terms.name as name, $wpdb->terms.term_id as term_id ".
		"FROM $wpdb->terms, $wpdb->term_taxonomy ".
		"WHERE $wpdb->term_taxonomy.term_taxonomy_id = $wpdb->terms.term_id ".
		"AND $wpdb->term_taxonomy.taxonomy = 'post_tag' AND $wpdb->terms.name LIKE '%" . $searchstring . "%';";
		$result = @mysql_query($sql);
		if($result && mysql_num_rows($result) > 0) {
			$retString .= "<ul class='search-tags'>";
			$retString .= "<li class='search-title'>Typ av information</li>";
			while($row = mysql_fetch_array($result)) {
				$link = "";
				$term_id = $row["term_id"];
				$name = $row["name"];
				$link = get_tag_link($term_id);
				if ( is_wp_error( $link ) ) {
					continue;
				}	
				$retString .= "<li><a href='$link'>$name</a></li>";
			}
			$retString .= "</ul>";
		}

		/* get new posts */
		//$query = array(	'posts_per_page' => get_option('posts_per_page') );
		$query = array(	'posts_per_page' => 15 );
		
		// add search to query
		$query["s"] = $searchstring;
		$dyn_query = new WP_Query();
		$dyn_query->query($query);

		$retArray = array();

		/* Start the Loop of posts search */
		if ($dyn_query->have_posts()):
			$retString .= "<ul class='search-posts'>";
			$retString .= "<li class='search-title'>Artiklar</li>";
			while ( $dyn_query->have_posts() ) : $dyn_query->the_post();
				$retString .= "<li><a href='" . get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a></li>"; //<i>" . get_the_category_list(', ') . "</i>
			endwhile;
			$retString .= "</ul>";
		endif;

		echo $retString;

	endif;
?>