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
function cron_add_week( $schedules ) {
 	$schedules['hk_weekly'] = array(
 		'interval' => 604800,
 		'display' => __( 'Every week' )
 	);
 	return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_week' );
function cron_add_month( $schedules ) {
 	$schedules['hk_monthly'] = array(
 		'interval' => 2592000,
 		'display' => __( 'Every month' )
 	);
 	return $schedules;
}
add_filter( 'cron_schedules', 'cron_add_month' );


/*
 * Cron job to check which posts to be reviewed and send mail to remind author
 */
function hk_review_mail() {
	$options = get_option('hk_theme');
	$hk_review_mail_check_time = time();
	$options["hk_review_mail_check_time"] = $hk_review_mail_check_time;

	//define arguments for WP_Query()
	$qargs = array(
		'post_type' => array('post','hk_kontakter','hk_faq'),
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
		foreach ( explode(",",$options["no_reviews_to_cat"]) as $c ) {
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

	$hk_review_mail_time = time();
	$options["hk_review_mail_time"] = $hk_review_mail_time;

	update_option("hk_theme", $options);
}
add_action("hk_review_mail_event","hk_review_mail");





/*
 * Cron job to normalize views
 */
if (function_exists( 'views_orderby' )) : // if plugin WP-PostViews is enabled
// normalize view count
function hk_normalize_count($returnlog = false) {
	global $default_settings;

	if (!function_exists( 'views_orderby' )) // don't do if plugin WP-PostViews not is enabled
		return;

	$log .= "Normaliserar view count " . date("Y-m-d H:i:s", strtotime("now")) . "\n";
	//define arguments for WP_Query()
	$paged = 1;
	$qargs = array(
		'paged' => $paged,
		'post_type' => array("post","hk_kontakter","hk_faq"),
		'posts_per_page' => 10,
		'post_status' => 'publish',
		'suppress_filters' => true);

	$q = new WP_Query();
	//remove_action( 'pre_get_posts', 'hk_exclude_category' );
	$q->query($qargs);
	//add_action( 'pre_get_posts', 'hk_exclude_category' );
	$count = $q->post_count;
	$totalcount = 0;
	while ($count > 0) :
		// execute the WP loop

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
		endwhile; // endwhile have_posts

		// get next page
		$paged++;
		$qargs["paged"] = $paged;
		$q->query($qargs);
		$totalcount += $count;
		$count = $q->post_count;

	endwhile; // endwhile count

	$log .= "Normaliserade $totalcount artiklar (paged: ". ($paged - 1) . ") " . date("Y-m-d H:i:s", strtotime("now"));

	$options = get_option('hk_theme');
	$hk_normalize_count_time = time();
	$options["hk_normalize_count_time"] = $hk_normalize_count_time;
	if ($log != "")
		$options["hk_normalize_count_log"] = $log;
	update_option("hk_theme", $options);

	if ($returnlog)
		return $log;

	return;
}
add_action("hk_normalize_count_event", "hk_normalize_count");


endif; // endif (function_exists( 'views_orderby' ))




/*
 * Cron job to check which posts to be reviewed and send mail to remind author
 */
function hk_stop_publish_job() {
	$options = get_option('hk_theme');
	if ($options["hidden_cat"] == "" || $options["hidden_cat"] == "0")
		return;

	$hk_stop_publish_check_time = time();
	$options["hk_stop_publish_check_time"] = $hk_stop_publish_check_time;

	//define arguments for WP_Query()
	$qargs = array(
		'posts_per_page' => -1,
		'category__not_in' => array($options["hidden_cat"]),
        'post_status' => 'publish',
		'post_type' => 'post',
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
	$count = $counttrue = 0;
	while ($q->have_posts()) : $q->the_post();
		if (get_field("hk_stop_publish_date") != "") {
			$count++;
			if (
					get_field("hk_stop_publish_date") < date("Ymd",current_time('timestamp',0)) ||
					(
						( get_field("hk_stop_publish_date") == date("Ymd",current_time('timestamp',0) ) ) &&
						( get_field("hk_stop_publish_hour") < date("G",current_time('timestamp',0) ) )
					)
				) {
				$counttrue++;
				$arr = wp_get_post_categories(get_the_ID());
				$arr[] = $options["hidden_cat"];
				$ret = wp_set_post_categories( get_the_ID(), $arr );

				$log .= "Post " . get_the_ID() . " " . get_the_title() . " is set to hidden_cat : ".print_r($ret,true) . "\n";
			}


		} // end if not empty date
	endwhile;

	$log .= "$count som har sluta publicera datum satt.\n$counttrue som har slutat publiceras nu.\n" . date("Y-m-d H:i:s", strtotime("now"));
	$options["hk_stop_publish_log"] = $log;
	$hk_stop_publish_time = time();
	$options["hk_stop_publish_time"] = $hk_stop_publish_time;

	update_option("hk_theme", $options);
}
add_action("hk_stop_publish_event","hk_stop_publish_job");

?>
