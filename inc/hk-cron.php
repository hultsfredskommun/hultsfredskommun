<?php


/* CRON SYNC JOB */
function cron_add_minute( $schedules ) {
 	$schedules['hk_minute'] = array(
 		'interval' => 60,
 		'display' => __( 'Every minute' )
 	);
 	return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_minute' );
function cron_add_five( $schedules ) {
 	$schedules['hk_five_minutes'] = array(
 		'interval' => 300,
 		'display' => __( 'Every five minutes' )
 	);
 	return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_five' );
function cron_add_quarter( $schedules ) {
 	$schedules['hk_quarter'] = array(
 		'interval' => 900,
 		'display' => __( 'Every quarter' )
 	);
 	return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_quarter' );

 
 
/*
 * Cron job to check which posts to be reviewed and send mail to remind author
 */
function hk_review_mail() {
	$options = get_option('hk_theme');
	$hk_review_mail_check_time = time();
	$options["hk_review_mail_check_time"] = $hk_review_mail_check_time;
	
	//define arguments for WP_Query()
	$qargs = array(
		'posts_per_page' => -1,
        'post_status' => 'publish', 
		'meta_key' => 'hk_next_review',  // which meta to query
		'meta_value'   => strtotime("+1 day"),  // value for comparison
		'meta_compare' => '<',          // method of comparison
		'meta_type' => 'numeric',
		'orderby' => 'meta_value',
		'order' => 'ASC',
		//'suppress_filters' => true,	
		'ignore_sticky_posts' => 1,
		);
	
	$q = new WP_Query();
	$q->query($qargs);
	
	// execute the WP loop
	$log = "";
	$maillist = Array();
	while ($q->have_posts()) : $q->the_post();
		$mail = get_the_author_email();
		// dont send mail if in no_reviews_to_cat list
		$dont_send = false;
		foreach ( split(",",$options["no_reviews_to_cat"]) as $c ) {
			if (in_category($c)) 
				$dont_send = true;
		}
		
		if ( !$dont_send ) {
			if ($mail == "") {
				$log .= "Saknar e-postadress på användare ". get_the_author() . ".<br>";

			} else
			{
				$maillist[$mail][] = array(get_the_ID(), get_the_title(), get_the_next_review_date(get_the_ID() ) );
			}
		}
		else {
			$log .= "Blocked review of post " . get_the_ID() . " " . get_the_title() . " because in 'no reviews cat'\n";
		}
	endwhile;

	$count_mail = 0;
	foreach ($maillist as $mailaddress => $value) {
		
		$subject = "Dags att granska ett inlägg på hemsidan";
		$message = "Du har följande inlägg att granska:<br>";
		$message .= "<ul>";
		foreach ($value as $editpost) {
			$message .= "<li><a href='". site_url("/") . "wp-admin/post.php?post=" . $editpost[0] . "&action=edit'>" . $editpost[1] . " " . $editpost[2] . "</a></li>";
		}
		$message .= "</ul>";
		$count_mail++;
		if ($options["review_send_only_mail_to"] != "") {
			wp_mail($options["review_send_only_mail_to"], $subject, "Should be sent to: " . $mailaddress . "\n\n" . $message);
			$log .= "Har skickat påminnelser, till " . $options["review_send_only_mail_to"] . " DEBUG: skulle skickats till $mailaddress\n";
		}
		else {
			wp_mail($mailaddress, $subject, $message);
			$log .= "Har skickat påminnelser, till $mailaddress\n";
		}
	} 
	$log .= "Skickade $count_mail påminnelser den " . date("Y-m-d H:i:s", strtotime("now"));
	$options["hk_review_mail_log"] = $log;


	update_option("hk_theme", $options);
}
add_action("hk_review_mail_event","hk_review_mail");





/*
 * Cron job to normalize views
 */
if (function_exists( 'views_orderby' )) : // if plugin WP-PostViews is enabled

// normalize view count
function hk_normalize_count($echolog = false) {
	global $default_settings;
	if (!function_exists( 'views_orderby' )) // don't do if plugin WP-PostViews not is enabled 
		return;
	

	//define arguments for WP_Query()
	$qargs = array(
		'post_type' => array("post","hk_kontakter"),
		'posts_per_page' => -1,
        'post_status' => 'published',
		'suppress_filters' => true);
	
	$q = new WP_Query();
	
	remove_action( 'pre_get_posts', 'hk_exclude_category' );
	$q->query($qargs);
	add_action( 'pre_get_posts', 'hk_exclude_category' );

	// execute the WP loop
	$log = "";
	$count = 0;
	while ($q->have_posts()) : $q->the_post();
		$count++;
		$post_id = get_the_ID();
		$views = get_post_meta($post_id, "views");
		
		$new_views = 1;
		if (empty($views)) {
			if (is_sticky()) 
				add_post_meta($post_id, "views", $default_settings["sticky_number"]);
			else
				add_post_meta($post_id, "views", 0);
		}
		else {
			$new_views = $views[0];
			if (is_sticky() && $new_views >= $default_settings["sticky_number"]) 
				$new_views -= $default_settings["sticky_number"]; // instead of sticky first in loop
			$new_views = floor(sqrt($new_views));
			if (is_sticky()) 
				$new_views += $default_settings["sticky_number"]; // instead of sticky first in loop
			
			if (count($views) > 1)
			{
				delete_post_meta($post_id, "views");
				add_post_meta($post_id, "views", $new_views); 
			}
			else {
				update_post_meta($post_id, "views", $new_views); 
			}
		}
		
		$log .= $post_id . " \told_views: " . $views[0] . " \tnew_views: " . $new_views . " \tis_sticky: " . is_sticky() . " count: " . count($views) . "\n";
		//$log .= ". ";
	endwhile;

	$log .= "Normaliserade $count artiklar " . date("Y-m-d H:i:s", strtotime("now"));
	
	$options = get_option('hk_theme');
	$hk_normalize_count_time = time();
	$options["hk_normalize_count_time"] = $hk_normalize_count_time;
	if ($log != "")
		$options["hk_normalize_count_log"] = $log;
	update_option("hk_theme", $options);
	if ($echolog)
		return $log;
	else
		return;
}
add_action("hk_normalize_count_event", "hk_normalize_count");


endif; // endif (function_exists( 'views_orderby' ))




/*
 * Cron job to check which posts to be reviewed and send mail to remind author
 */
function hk_stop_publish_job() {
	$options = get_option('hk_theme');
	$hk_stop_publish_check_time = time();
	$options["hk_stop_publish_check_time"] = $hk_stop_publish_check_time;
	
	//define arguments for WP_Query()
	$qargs = array(
		'posts_per_page' => -1,
		'category__not_in' => array($options["hidden_cat"]),
        'post_status' => 'publish', 
		'meta_key' => 'hk_stop_publish_date',  // which meta to query
		'meta_value'   => date("Ymd"),  // value for comparison
		'meta_compare' => '<=',          // method of comparison
		'meta_type' => 'numeric',
		//'suppress_filters' => true,	
		'ignore_sticky_posts' => 1,
		);
	
	$q = new WP_Query();
	$q->query($qargs);
	
	// execute the WP loop
	$log = "";
	$count = $counttoday = $counttrue = 0;
	while ($q->have_posts()) : $q->the_post();
	
		$count++;
		if (get_field("hk_stop_publish_date") <= date("Ymd")) {
			
			if (get_field("hk_stop_publish_hour") <= date("G")) {
				$counttrue++;
				$arr = wp_get_post_categories(get_the_ID());
				$arr[] = $options["hidden_cat"];
				$ret = wp_set_post_categories( get_the_ID(), $arr );

				$log .= "Post " . get_the_ID() . " " . get_the_title() . " is set to hidden_cat : ".print_r($ret,true) . "\n";
			}
			else {
				$counttoday++;
			}

		}
		
	endwhile;

	
	$log .= "$count som har sluta publicera datum satt.\n$counttoday ska sluta publiceras senare idag.\n$counttrue som har slutat publiceras nu.\n" . date("Y-m-d H:i:s", strtotime("now"));
	$options["hk_stop_publish_log"] = $log;


	update_option("hk_theme", $options);
}
add_action("hk_stop_publish_event","hk_stop_publish_job");

?>