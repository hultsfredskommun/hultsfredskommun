<?php
	/**
	 * Sort-order function:
	 * adds function for displaying sort-order buttons
	 * adds filter for sort-order
	 * orderby == popular depends on the plugin WP-PostViews by Lester 'GaMerZ' Chan 
	 */

	function displaySortOrderButtons() { 
		$options = get_option("hk_theme");?>
		<ul class="sort-order">
			<?php
				//init
				$tags = get_query_var("tag");
				$search = get_query_var("s");
				
				if($tags != ''){ $tags = "&amp;tag=".$tags; }
				if($search != ''){ $search = "&amp;s=".$search; }
			?>
			<?php 
				$orderby = $_REQUEST["orderby"];
				if ($orderby == "") {
					if (function_exists( 'views_orderby' ))
						$orderby = "popular";
					else
						$orderby = "latest";
				}
			?>
			<li><a class="nolink">Sortera p&aring;: </a></li>
			<?php if (function_exists( 'views_orderby' )) : ?>
			<?php $force_date = (get_query_var("cat") != "" && in_array(get_query_var("cat"), split(",",$options["order_by_date"])) ); ?>

			<?php if ($_REQUEST["orderby"] == "popular" || ($_REQUEST["orderby"] == "" && !$force_date)) { ?>
				<li class='current-menu-item'><a class="active">Popul&auml;ra</a></li>
			<?php } else { ?>
				<li><a href="?orderby=popular<?php echo $tags.$search; ?>">Popul&auml;ra</a></li>
			<?php } ?>
			<?php endif; ?>
			
			<?php if ($_REQUEST["orderby"] == "latest" || $_REQUEST["orderby"] == "oldest" || ($_REQUEST["orderby"] == "" && $force_date)) {
				$active_class = "class='active'";
				} else {
				$hidden = "hidden ";
			} ?>
			<?php if ($_REQUEST["orderby"] == "latest" || ($_REQUEST["orderby"] == "" && $force_date)) { ?>
				<li class="asc"><a <?php echo $active_class; ?> href="?orderby=oldest&amp;<?php echo $tags.$search; ?>">Datum <span class="<?php echo $hidden; ?>dropdown-icon"></span></a></li>
			<?php } else { ?>
				<li <?php echo ($_REQUEST["orderby"] == "oldest")?"class='desc'":""; ?>><a <?php echo $active_class; ?> href="?orderby=latest&amp;<?php echo $tags.$search; ?>">Datum <span class="<?php echo $hidden; ?>dropdown-icon up"></span></a></li>
			<?php } ?>

			<?php if (false) : // removed alpha sorting ?>
			<?php if ($_REQUEST["orderby"] == "alpha") { ?>
				<li class="desc"><a href="?orderby=alpha_desc<?php echo $tags.$search; ?>">A - &Ouml; <span class="<?php echo $hidden; ?>dropdown-icon"></span></a></li>
			<?php } else { ?>
				<li <?php echo ($_REQUEST["orderby"] == "alpha_desc")?"class='asc'":""; ?>><a href="?orderby=alpha<?php echo $tags.$search; ?>">A - &Ouml; <span class="<?php echo $hidden; ?>dropdown-icon up"></span></a></li>
			<?php } ?>
			<?php endif; ?>

		</ul>

	<?php }
	
	// code from WP-PostViews process_postviews to count views when viewing posts dynamically
	function hk_process_postviews() {
		global $user_ID, $post;
		if(is_int($post)) {
			$post = get_post($post);
		}
		if(!wp_is_post_revision($post)) {
			//REMOVED FROM ORIGINAL if(is_single() || is_page()) {
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
					if(defined('WP_CACHE') && WP_CACHE) {
						echo "\n".'<!-- Start Of Script Generated By WP-PostViews -->'."\n";
						wp_print_scripts('jquery');					
						echo '<script type="text/javascript">'."\n";
						echo '/* <![CDATA[ */'."\n";
						echo "jQuery.ajax({type:'GET',url:'".admin_url('admin-ajax.php', (is_ssl() ? 'https' : 'http'))."',data:'postviews_id=".$id."&action=postviews',cache:false});";
						echo '/* ]]> */'."\n";
						echo '</script>'."\n";						
						echo '<!-- End Of Script Generated By WP-PostViews -->'."\n";
					} else {
						if(!update_post_meta($id, 'views', ($post_views+1))) {
							add_post_meta($id, 'views', 1, true);
						}
					}
				}
			//REMOVED FROM ORIGINAL }
		}
	}


	if( function_exists( 'views_orderby' )) {
		function hk_add_views_fields($post_ID) {
			global $wpdb;

			if ( get_post_meta($post_ID, 'views', true) == "" ) {
				add_post_meta($post_ID, 'views', 0, true);
			}
		}
		function hk_delete_views_fields($post_ID) {
			global $wpdb;
			delete_post_meta($post_ID, 'views');
		}

		add_action('add_attachment', 'hk_add_views_fields');
		add_action('edit_attachment', 'hk_add_views_fields');
		add_action('delete_attachment', 'hk_delete_views_fields');
		add_action('add_post', 'hk_add_views_fields');
		add_action('edit_post', 'hk_add_views_fields');
		add_action('delete_post', 'hk_delete_views_fields');
	}

?>