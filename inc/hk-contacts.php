<?php

/*
 * Description: Add Contact widget and contact post_type
 *
 * Use post name as contact name, content as more contact information and featured image to show thumbnail of contact
 **/





/* REGISTER post_type hk_kontakter */
add_action('init', 'hk_contacts_init');
function hk_contacts_init() {
	// only if in admin and is administrator
    //if (is_admin() && current_user_can("administrator")) {

		register_post_type( 'hk_kontakter',
			array(
				'labels' => array(
					'name' => __( 'Kontakter' ),
					'singular_name' => __( 'Kontakt' ),
					'description' => 'L&auml;gg till en kontakt i kontaktbanken.'
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'kontakt'),
				'show_ui' => true,
				'show_in_menu' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'publicly_queryable' => true,
				'query_var' => true,
				'supports' => array('title','editor','comments','revisions','author','custom-fields'),
				'taxonomies' => array('category'),
				// there are a lot more available arguments, but the above is plenty for now
			));

	//}
}

// rewrites custom post type name
global $wp_rewrite;
$option = get_option('hk_theme');
$permalink = $option['permalinkstructure'];
if ($permalink == "") $permalink = '/artikel/kontakt';
$projects_structure = $permalink . '/%hk_kontakter%/';
$wp_rewrite->add_rewrite_tag("%hk_kontakter%", '([^/]+)', "kontakt=");
$wp_rewrite->add_permastruct('kontakt', $projects_structure, false);




// [kontakt id="kontakt_id"]
function hk_contact_shortcode_func( $atts ) {
	$default = array(
		'echo_args' => '', // to echo help texts
		'id' => '-1',
		'kontaktnamn' => '',
		'kategori' => '',
		'kategorinamn' => '',
		'bild' => true,
		'namn' => true,
		'titel' => true,
		'arbetsplats' => true,
		'telefon' => true,
		'epost' => true,
		'beskrivning' => false,
		'adress' => false,
		'besokstid' => false,
		'karta' => false);
	$atts = shortcode_atts( $default, $atts );

	if (!empty($atts["echo_args"]) && $atts["echo_args"] != "") {
		return "<p>[kontakt ".$atts["echo_args"] . "]</p>";
	}

	// translate from swedish to variables
	$translate = array(
		'echo_args' => 'echo_args', 
		'id' => 'id',
		'kontaktnamn' => 'contactslug',
		'kategori' => 'cat',
		'kategorinamn' => 'cat_slug',
		'bild' => 'image',
		'namn' => 'name',
		'titel' => 'title',
		'arbetsplats' => 'workplace',
		'telefon' => 'phone',
		'epost' => 'email',
		'beskrivning' => 'description',
		'adress' => 'address',
		'besokstid' => 'visit_hours',
		'karta' => 'map');
	$translated_atts = array();
	foreach ($atts as $key => $value) {
		$translated_atts[$translate[$key]] = $value;
	}
	$translated_atts["heading_element"] = "h3";
	/* if id is set */
	if ($translated_atts["id"] > 0) {
		return hk_get_contact_by_id($translated_atts["id"], $translated_atts);
	}
	/* if contact slug or slugs */
	if ($translated_atts["contactslug"] != "") {
		return hk_get_contact_by_name($translated_atts["contactslug"], $translated_atts);
	}
	/* if category id or ids */
	if ($translated_atts["cat"] != "") {
		return hk_get_contact_by_cat($translated_atts["cat"], $translated_atts);
	}
	/* if category slug or slugs */
	if ($translated_atts["cat_slug"] != "") {
		return hk_get_contact_by_cat_slug($translated_atts["cat_slug"], $translated_atts);
	}
	if ($retValue == "") {
		return "<p>Hittade ingen kontakt.</p>";
	}
}
add_shortcode( 'kontakt', 'hk_contact_shortcode_func' );



// get contact by categories
function hk_get_contact_by_cat_slug($cat, $args) {
	$cat_array = array();
	foreach(preg_split("/[\s,]+/",$cat ,NULL ,PREG_SPLIT_NO_EMPTY) as $value) {
		$post = get_category_by_slug($value);
		if ($post) {
			$cat_array[] = $post->term_id;
		}
	}
	return hk_get_contact_by_cat(implode(",",$cat_array), $args);

}
function hk_get_contact_by_cat($cat, $args) {
	global $post;
	$org_post = $post;
	if (empty($cat)) {
		return "<div class='contact-area'>Hittade ingen kategori att h&auml;mta kontakter ifr&aring;n.</div>";
	}

	$cat_array = preg_split("/[\s,]+/",$cat,NULL,PREG_SPLIT_NO_EMPTY);

	// query arguments
	$query_args = array(
		'posts_per_page' => -1,
		'paged' => 1,
		'more' => $more = 0,
		'post_type' => 'hk_kontakter',
		'order' => 'ASC',
		'suppress_filters' => 1,
		'category__in' => $cat_array
	);

	// search in all posts (ignore filters)
	$the_query = new WP_Query( $query_args );
	$retValue = "";

	// The Loop
	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$retValue .= "<div class='contact-area'>";
			$retValue .= hk_get_the_contact($args);
			$retValue .= "</div>";
		endwhile;
	endif;

	// Reset Post Data
	wp_reset_postdata();
	wp_reset_query();
	$post = $org_post;
	return $retValue;

}

// get contact by name
function hk_search_and_print_contacts_by_name($search, $args, $count, $echo_title = false) {
	global $wpdb;
	//$search = mb_convert_encoding($search, "ISO-8859-1");
	$id_array = array();
	$title_text = "";
	$extra_pre_search_text = "";
	$extra_post_search_text = "";

	// check if phone number in string
	preg_match('/([0-9 -]+)/', $search, $matches);

	if (count($matches) > 0 && $matches[0] != "") {
		$match = trim($matches[0]," ");
		$searchmatch = trim($match," ");
		if ($searchmatch != "") {
			$postid = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT $wpdb->posts.ID FROM $wpdb->posts, $wpdb->postmeta
				WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->posts.post_type = 'hk_kontakter'
				AND ($wpdb->posts.post_title LIKE '%%%s%%' OR $wpdb->postmeta.meta_value LIKE '%%%s%%') LIMIT 0,".($count + 1), $searchmatch, $searchmatch ));
			$id_array = array_merge($id_array, $postid);
			if (count($postid) > 0) {
				$search = str_replace($match, "", $search);
			}
		}
	}

	// check if two words (firstname lastname)
	preg_match('/([a-zA-Z]+)[ ]+([a-zA-Z]+)/', $search, $matches);
	if (count($matches) > 1 && $matches[0] != "") {
		$firstname = trim($matches[1]," ");
		$lastname = trim($matches[2]," ");
		if ($firstname != "" && $lastname != "") {
			$postid = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT $wpdb->posts.ID FROM $wpdb->posts, $wpdb->postmeta
				WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->posts.post_type = 'hk_kontakter'
				AND ($wpdb->posts.post_title LIKE '%%%s%%') LIMIT 0,".($count + 1), "$firstname $lastname" ));

			$id_array = array_merge($id_array, $postid);
			if (count($postid) > 0) {
				$search = str_replace(trim($matches[0]), "", $search);
			}
		}
	}

	foreach(preg_split("/[\s,]+/", $search, NULL, PREG_SPLIT_NO_EMPTY) as $value) {
		$value = hk_checkAndConvertSpecialValue($value); // check if special phone number
		if (count($value) == 2) {
			//$extra_pre_search_text .= "S&ouml;ker &auml;ven efter " . $value[1] . ".<br>";
		}
		foreach($value as $val) {
			$postid = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT $wpdb->posts.ID FROM $wpdb->posts, $wpdb->postmeta
			WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id AND $wpdb->posts.post_type = 'hk_kontakter'
			AND ($wpdb->posts.post_title LIKE '%%%s%%' OR $wpdb->postmeta.meta_value LIKE '%%%s%%') LIMIT 0,".($count + 1), $val, $val ));
			$id_array = array_merge($id_array, $postid);
		}
	}

	$id_array = make_unique_sorted_by_frequence($id_array, $count + 1);

	// return empty if no hits
	if (count($id_array) <= 0) {
		return "";
	}


	if (count($id_array) > $count) {
		$num_text = " ( &gt; $count)";
		unset($id_array[count($id_array)-1]); // unset the extra in array, added just for this count
		$extra_post_search_text .= "<div class='search-item'><a href='/?s=$search&numtele=1000'>Visa fler tr&auml;ffar...</a></div>";

	}
	else {
		$num_text = " (" . count($id_array) . ")";
	}


	if ($echo_title) {
		$title_text = "<h3 class='search-title js-toggle-search-hook'>Kontakter$num_text</h3>";
	}
	if ($extra_pre_search_text != "") {
		$extra_pre_search_text = "<div class='contact-area'><div class='complement-italic-text search-item'>$extra_pre_search_text</div></div>";
	}
	if ($extra_post_search_text != "") {
		$extra_post_search_text = "<div class='contact-area'>$extra_post_search_text</div>";
	}

	$contacts = hk_get_contact_by_id(implode(",",$id_array), $args);

	return "<div class='js-toggle-search-wrapper'>" . $title_text . $extra_pre_search_text . $contacts . $extra_post_search_text . "</div>";
}
/* helper to check if value is or could be a phone number */
function hk_checkAndConvertSpecialValue($value) {
	$new_value = "";
	$match_string = "/^[0-9\-]*$/";
	if (preg_match($match_string,$value)) {
		$new_value = preg_replace('/\D/', '', $value);
		if(strlen($value) == 10) {
			if (substr($value,0,3) == "070") {
				$new_value = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{2})([0-9]{2})/", "$1-$2 $3 $4", $value);
			}
			elseif (substr($value,0,4) == "0495") {
				$new_value = preg_replace("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})/", "$1-$2 $3 $4", $value);
			}
		}
		elseif(strlen($value) == 6) {
			$new_value = preg_replace("/([0-9]{2})([0-9]{2})([0-9]{2})/", "$1 $2 $3", $value);
		}
		elseif(strlen($value) == 5) {
			$new_value = preg_replace("/([0-9]{1})([0-9]{2})([0-9]{2})/", "$1 $2 $3", $value);
		}
		elseif(strlen($value) == 4) {
			$new_value = preg_replace("/([0-9]{2})([0-9]{2})/", "$1 $2", $value);
		}
		else {
			$new_value = "";
		}
	}
	if ($new_value != "") {
		return array($value,$new_value);
	}
	return array($value);
}
function hk_checkIfSpecialValue($value) {
	$new_value = "";
	$match_string = "/^[0-9\-]*$/";
	if (preg_match($match_string,$value)) {
		$new_value = preg_replace('/\D/', '', $value);
		if(strlen($value) == 10) {
			if (substr($value,0,3) == "070") {
				$new_value = preg_replace("/([0-9]{3})-([0-9]{3}) ([0-9]{2}) ([0-9]{2})/", "$1-$2 $3 $4", $value);
			}
			elseif (substr($value,0,4) == "0495") {
				$new_value = preg_replace("/([0-9]{4})-([0-9]{2}) ([0-9]{2}) ([0-9]{2})/", "$1-$2 $3 $4", $value);
			}
		}
		elseif(strlen($value) == 6) {
			$new_value = preg_replace("/([0-9]{2}) ([0-9]{2}) ([0-9]{2})/", "$1 $2 $3", $value);
		}
		elseif(strlen($value) == 5) {
			$new_value = preg_replace("/([0-9]{1}) ([0-9]{2}) ([0-9]{2})/", "$1 $2 $3", $value);
		}
		elseif(strlen($value) == 4) {
			$new_value = preg_replace("/([0-9]{2}) ([0-9]{2})/", "$1 $2", $value);
		}
		else {
			$new_value = "";
		}
	}
	if ($new_value != "") {
		return array($value,$new_value);
	}
	return array($value);
}
/* helper to sort and filter array by most frequent used id */
function make_unique_sorted_by_frequence($array, $max_return = 100)
{
	$new_array = array();
    foreach($array as $item)
    {
        if(array_key_exists($item, $new_array))
        {
			$new_array[$item]++;
		}
		else {
			$new_array[$item] = 1;
		}
    }
	arsort($new_array);
	$ret_array = array();
	$num = 0;
    foreach($new_array as $key => $value)
    {
		if (++$num > $max_return) break;
		$ret_array[] = $key;
    }

    return $ret_array;
}

// get contact by name
function hk_get_contact_by_name($post_slug, $args) {
	$id_array = array();
	foreach(preg_split("/[\s,]+/",$post_slug,NULL,PREG_SPLIT_NO_EMPTY) as $value) {
		$get_post_args =array(
			'name' => $value,
			'post_type' => 'hk_kontakter',
			'post_status' => 'publish',
			'numberposts' => 1
		);
		$post = get_posts($get_post_args );
		if ($post) {
			$id_array[] = $post[0]->ID;
		}
	}
	return hk_get_contact_by_id(implode(",",$id_array), $args);
}

// get contact by comma separated id list
function hk_get_contact_by_id($contact_id, $args) {
	global $post;
	$org_post = $post;
	if (empty($contact_id)) {
		return "<div class='contact-area'>Hittade ingen kontakt.</div>";
	}
	$retValue = "";

	foreach (preg_split("/[\s,]+/",$contact_id,NULL,PREG_SPLIT_NO_EMPTY) as $c_id) {

		// query arguments
		$query_args = array(
			'posts_per_page' => -1,
			'paged' => 1,
			'more' => $more = 0,
			'post__in' => array($c_id),
			'post_type' => 'hk_kontakter',
			'suppress_filters' => 1
		);

		// search in all posts (ignore filters)
		$the_query = new WP_Query( $query_args );

		// The Loop
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$retValue .= "<div class='contact-area'>";
				$retValue .= hk_get_the_contact($args);
				$retValue .= "</div>";
			endwhile;
		endif;
		wp_reset_postdata();
		wp_reset_query();
	}
	// Reset Post Data
	$post = $org_post;

	return $retValue;

}



function hk_the_contact($args = array()) {
	echo hk_get_the_contact($args);
}
function hk_get_the_contact($args = array()) {
	$mapclass = '';
	$default = array(
		'image' => false,
		'name' => true,
		'title' => true,
		'workplace' => true,
		'phone' => true,
		'email' => false,
		'description' => false,
		'address' => false,
		'visit_hours' => false,
		'map' => false,
		'title_link' => true,
		'heading_element' => "h1",
		'add_item_class' => ''
		);

	if (isset($args)) {
		$default =  $args + $default;
	}

	foreach($default as $key => $value) {
		$hidden[$key] = ($value)?"visible":"hidden rs_skip";
	}
	if (!function_exists("get_field"))
		return "You need the Advanced Custom Field plugin for the contact to work properly.";

	$contact_position = get_field("hk_contact_position",get_the_ID());
	$contact_position2 = get_field("hk_contact_position_2",get_the_ID());

	$coordinates = "";
	$contact_position_address = "";
	$contact_array = explode("|",$contact_position);

	if (isset($contact_position2) && isset($contact_position2["lat"]) && isset($contact_position2["lng"])) {
		$coordinates = $contact_position2["lat"].",".$contact_position2["lng"];
		$contact_position_address = $contact_position2["address"];
	}
	else if (isset($contact_array) && isset($contact_array[1])) {
		$coordinates = $contact_array[1];
		$contact_position_address = $contact_position[0];
	}

	if ($hidden["map"] == "visible" && $coordinates != "") {
		$mapclass = "hasmap";
	}
	$add_class = $default['add_item_class'];

	$retValue = "<div id='content-" . get_the_ID() ."' class='entry-wrapper contact-wrapper $mapclass $add_class'>";
		$retValue .= "<div class='entry-content'>";

			// image
			$retValue .= hk_get_the_post_thumbnail(get_the_ID(),"contact-image",true,false, $hidden['image']);

			$retValue .= "<" . $default["heading_element"] . " class='entry-title " . $hidden['name'] . "'>";
			// add link to title
			if ($default['title_link']) {
				$retValue .= "<a class='contactlink  js-contact-link' href='" . get_permalink(get_the_ID()) . "'>";
			}
			// title
			$retValue .= get_the_title();
			if ($default['title_link']) {
				$retValue .= "</a>";
				$retValue .= "<span class='rs_skip hidden contact_id'>" . get_the_ID() . "</span>";
			}
			$retValue .= "</".$default["heading_element"].">";


			$retValue .= "<div class='contact-" . get_the_ID() . " " . implode(" ",get_post_class()) ."'>";
				$retValue .= "<div class='hk_contact_titel " . $hidden['title'] . "'>" . get_field("hk_contact_titel") . "</div>";

				// workplace
				if( get_field('hk_contact_workplaces') ): while( has_sub_field('hk_contact_workplaces') ):
					$retValue .= "<div class='hk_contact_workplaces " . $hidden['workplace'] . "'>" . get_sub_field('hk_contact_workplace') . "</div>";
				endwhile; endif;

				if( (get_field('hk_contact_phones') && $hidden['phone'] == "visible") || (get_field('hk_contact_emails') && $hidden['email'] == "visible") ) {
					$retValue .= "<div class='topspace'>";
				}
				// email
				if( get_field('hk_contact_emails') ): while( has_sub_field('hk_contact_emails') ):
					$retValue .= "<div class='hk_contact_emails " . $hidden['email'] . "'><a href='mailto:" . get_sub_field('hk_contact_email') . "'>" . get_sub_field('hk_contact_email') . "</a></div>";
				endwhile; endif;

				// phone
				if( get_field('hk_contact_phones') ): while( has_sub_field('hk_contact_phones') ):
					$number = get_sub_field('number');
					$retValue .= "<div class='hk_contact_phones " . $hidden['phone'] . "'><a href='tel:".preg_replace('/\D/','',$number)."'>";
					$retValue .= (get_row_layout() == "hk_contact_fax")?"Fax: ":"";
					$number = str_replace("[","<span class='complement-italic-text'>(", $number);
					$number = str_replace("]",")</span>", $number);
					$retValue .= $number . "</a></div>";
				endwhile; endif;

				if( (get_field('hk_contact_phones') && $hidden['phone'] == "visible") || (get_field('hk_contact_emails') && $hidden['email'] == "visible") ) {
					$retValue .= "</div>";
				}
				// description
				if (get_field("hk_contact_description")) {
					$retValue .= "<p class='hk_contact_description " . $hidden['description'] . "'>" . get_field("hk_contact_description") . "</p>";
				}
				// address
				if (get_field("hk_contact_address")) {
					$retValue .= "<p class='hk_contact_address " . $hidden['address'] . "'>" . get_field("hk_contact_address") . "</p>";
				}

				// visit hours
				if (get_field("hk_contact_visit_hours")) {
					$retValue .= "<p class='hk_contact_visit_hours " . $hidden['visit_hours'] . "'>" . get_field("hk_contact_visit_hours") . "</p>";
				}

			$retValue .= "</div>";
		$retValue .= "</div>";

		// position
		if ($coordinates != "") :
			$retValue .= "<div class='side-map " . $hidden['map'] . "'><div class='map_canvas'>[Karta <span class='coordinates rs_skip'>" . $coordinates . "</span> <span class='address'>" . $contact_position_address . "</span>]</div></div>";
		endif;


	$retValue .= "</div>";

	return $retValue;
}

// outputs the content of the contact side tab
function hk_contact_tab() {
	global $hk_options;

	$retValue = "";
	$retValue .= "<aside id='contact-side-tab' class='hk_kontakter'>";
	$retValue .= "<a class='toggle-tab'></a><div class='content-wrapper'>";

	/*
	// set startpage category if on startpage
	$category_in = array();
	if (get_query_var("cat") != "") {
		$category_in = hk_getParentsSlugArray(get_query_var("cat"));
		$category_in = array_reverse($category_in);
		$shown = array();
		foreach($category_in as $category) {

			// query arguments
			$args = array(
				'posts_per_page' => -1,
				'paged' => 1,
				'more' => $more = 0,
				'post_type' => 'hk_kontakter',
				'order' => 'ASC',
				'suppress_filters' => 1
			);
			if (!empty($shown)) {
				$args['post__not_in'] = $shown;
			}
			$cat = get_category_by_slug($category);
			if ($cat) {

				$args['category__and'] = $cat->term_id;

				// search in all posts (ignore filters)
				$the_query = new WP_Query( $args );

				if ($the_query->have_posts())
				{

					// The Loop
					while ( $the_query->have_posts() ) : $the_query->the_post();
						$shown[] = get_the_ID();
						$retValue .= "<div class='contact-wrapper'>";
						$retValue .= "<div class='icon'>&nbsp;</div>";
						$retValue .= "<div class='contact-" . get_the_ID() . " " . implode(" ",get_post_class()) . "'>";
						$retValue .= "<a class='contactlink' href='". get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a>";
						$retValue .= "<span class='hidden contact_id'>" . get_the_ID() . "</span>";
						if (function_exists("get_field")) { $retValue .= "<div class='content'>" . get_field("hk_contact_titel") . "</div>"; }

						$retValue .= "</div></div>";
					endwhile;
					// Reset Post Data
					wp_reset_postdata();
				}
			}
		}

	}*/

	$retValue .= "</div></aside>";
	echo $retValue;

}
?>
