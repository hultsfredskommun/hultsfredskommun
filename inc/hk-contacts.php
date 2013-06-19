<?php

/* 
 * Description: Add Contact widget and contact post_type
 *
 * Use post name as contact name, content as more contact information and featured image to show thumbnail of contact
 **/





/* REGISTER post_type hk_kontakter */
add_action('init', hk_contacts_init);
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
				'capability_type' => 'page',
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
	
	if ($atts["echo_args"] != "") {
		return "<p>[kontakt ".$atts["echo_args"] . "]</p>";
	}
	
	// translate from swedish to variables
	$translate = array(
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

// get contact by id
function hk_get_contact_by_id($contact_id, $args) {
	global $post;
	$org_post = $post;
	if (empty($contact_id)) {
		return "<div class='contact-area'>Hittade ingen kontakt.</div>";
	}
	// query arguments
	$query_args = array(
		'posts_per_page' => -1,
		'paged' => 1,
		'more' => $more = 0,
		'post__in' => preg_split("/[\s,]+/",$contact_id,NULL,PREG_SPLIT_NO_EMPTY),
		'post_type' => 'hk_kontakter',
		'order' => 'ASC', 
		'suppress_filters' => 1
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


// outputs the content of first page contact
function hk_contact_firstpage($contactargs) {
	global $post, $default_settings;
	$org_post = $post;

	$retValue = "";
	
	// set startpage category if on startpage
	$category_in = array();
	if (get_query_var("cat") != "") {

		// query arguments
		$args = array(
			'posts_per_page' => -1,
			'paged' => 1,
			'more' => $more = 0,
			'post_type' => 'hk_kontakter',
			'order' => 'ASC', 
			'suppress_filters' => 1
		);
			
		$args['category__and'] = get_query_var("cat");

		// search in all posts (ignore filters)
		$the_query = new WP_Query( $args );

		if ($the_query->have_posts())
		{ 
		
		
		
/*
<div class='contact-wrapper'>
	<a class='contactlink' href='/artikel/kontakt/hultsfreds-kommun/'>Kontakta Hultsfreds kommun</a>

		<div class='left-content'>
			<ul>
				<li><a href="#">kommunen@hultsfred.se</a></li>
				<li><a href="#">0495-24 00 01</a><i>(talstyrd telefonist)</i></li>
				<li><a href="#">0495-24 00 00</a><i>(växel)</i></li>
			</ul>
		</div> <!-- End of left-content -->
		<div class='right-content'>
			<ul>
				<li><a href="#">Prenumerera på nyheter</a><i>(RSS)</i></li>
				<li><a href="#">Synpunkter</a></li>
				<li><a href="#">Felanmälan</a></li>
			</ul>
		</div> <!-- End of right-content -->

	<img class='contacts-image' src="panorama.png">
</div> <!-- End of contact-wrapper -->*/
			
			$retValue .= "<aside class='hk_kontakter widget'><div class='contact-wrapper'>";
			$retValue .= "<img alt='Platsh&aring;llare f&ouml;r bildspel' class='slideshow_bg' src='" . get_template_directory_uri() . "/image.php?w=".$default_settings['featured-image'][0]."&amp;h=".($default_settings['featured-image'][1])."'/>";
			$retValue .= "<div class='content-wrapper'>";
				
			// The Loop
			while ( $the_query->have_posts() ) : $the_query->the_post();
				
				$rightcontent = false;
				if (($contactargs['direct_link1_url'] != "" && $contactargs['direct_link1_title'] != "") ||
					($contactargs['direct_link2_url'] != "" && $contactargs['direct_link2_title'] != "") ||
					($contactargs['direct_link3_url'] != "" && $contactargs['direct_link3_title'] != "")
					) :
					$rightcontent = true;
					$halfcss = "two";
				endif;
				// add link and title
				$retValue .= "<h1 class='entry-title'>";
				$retValue .= "<a class='contactlink  js-contact-link' href='" . get_permalink(get_the_ID()) . "'><span class='contact-icon'></span>Kontakta "; 
				$retValue .= get_the_title();
				$retValue .= "</a>"; 
				$retValue .= "<span class='hidden contact_id'>" . get_the_ID() . "</span>";
				$retValue .= "</h1>";
				
				$retValue .= "<ul class='left-content  $halfcss'>";
				
				// email
				if( get_field('hk_contact_emails') ): while( has_sub_field('hk_contact_emails') ):
					$retValue .= "<li class='hk_contact_emails'><a href='mailto:" . get_sub_field('hk_contact_email') . "'>" . get_sub_field('hk_contact_email') . "</a></li>";
				endwhile; endif;

				// phone
				if( get_field('hk_contact_phones') ): while( has_sub_field('hk_contact_phones') ): 
					$number = get_sub_field('number');
					$link = explode('[',$number,2);
					if (count($link) > 0) {
						$link = str_replace(" ","",$link[0]);
					} else {
						$link = $number;
					}
					$number = str_replace("[","<span class='complement-italic-text'>(", $number);
					$number = str_replace("]",")</span>", $number);

					$retValue .= "<li class='hk_contact_phones'><a href='tel:$link'></i>";
					$retValue .= (get_row_layout() == "hk_contact_fax")?"Fax: ":"";
					$retValue .= $number . "</a></li>";
				endwhile; endif;				
				$retValue .= "<li class='contactlink  js-contact-link'><a href='" . get_permalink(get_the_ID()) . "'></i>";
				$retValue .= "Fler kontaktuppgifter...</a></li>";

				$retValue .= "</ul>";
				if ($rightcontent) :

					$retValue .= "<ul class='right-content  $halfcss'>";
					
					if ($contactargs['direct_link1_url'] != "" && $contactargs['direct_link1_title'] != "") :
						$retValue .= "<li class='direct_link direct_link1'>";
						$retValue .= "<a href='" . $contactargs['direct_link1_url'] . "'>";
						if ($contactargs['direct_link1_icon'] != "") : $retValue .= $contactargs['direct_link1_icon']; endif;
						$title = $contactargs['direct_link1_title'];
						$title = str_replace("[","<span class='complement-italic-text'>(", $title);
						$title = str_replace("]",")</span>", $title);
						$retValue .= $title . "</a></li>";
					endif;
					if ($contactargs['direct_link2_url'] != "" && $contactargs['direct_link2_title'] != "") :
						$retValue .= "<li class='direct_link direct_link2'>";
						$retValue .= "<a href='" . $contactargs['direct_link2_url'] . "'>";
						if ($contactargs['direct_link2_icon'] != "") : $retValue .=  $contactargs['direct_link2_icon']; endif;
						$title = $contactargs['direct_link2_title'];
						$title = str_replace("[","<span class='complement-italic-text'>(", $title);
						$title = str_replace("]",")</span>", $title);
						$retValue .= $title . "</a></li>";
					endif;
					if ($contactargs['direct_link3_url'] != "" && $contactargs['direct_link3_title'] != "") :
						$retValue .= "<li class='direct_link direct_link3'>";
						$retValue .= "<a href='" . $contactargs['direct_link3_url'] . "'>";
						if ($contactargs['direct_link3_icon'] != "") : $retValue .= $contactargs['direct_link3_icon']; endif;
						$title = $contactargs['direct_link3_title'];
						$title = str_replace("[","<span class='complement-italic-text'>(", $title);
						$title = str_replace("]",")</span>", $title);
						$retValue .= $title . "</a></li>";
					endif;
				
				
					$retValue .= "</ul>";
				endif;
			endwhile;
			
			$retValue .= "</div></div></aside>";
		}
		
		// Reset Post Data
		wp_reset_postdata();
		wp_reset_query();
		$post = $org_post;
		

	}
		
	echo $retValue;

}
function hk_the_contact($args = array()) {
	echo hk_get_the_contact($args);
}
function hk_get_the_contact($args = array()) {
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
		'heading_element' => "h1"
		);

	if (isset($args)) {
		$default =  $args + $default;
	}

	foreach($default as $key => $value) {
		$hidden[$key] = ($value)?"visible":"hidden";
	}
	if (!function_exists("get_field")) 
		return "You need the Advanced Custom Field plugin for the contact to work properly.";
	
	$contact_position = get_field("hk_contact_position");
	if ($hidden["map"] == "visible" && !empty($contact_position) && $contact_position["coordinates"] != "") {
		$mapclass = "hasmap";
	}
		
	$retValue = "<div id='content-" . get_the_ID() ."' class='entry-wrapper contact-wrapper $mapclass'>";
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
				$retValue .= "<span class='hidden contact_id'>" . get_the_ID() . "</span>";
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
					$retValue .= "<div class='hk_contact_phones " . $hidden['phone'] . "'>";
					$retValue .= (get_row_layout() == "hk_contact_fax")?"Fax: ":"";
					$number = get_sub_field('number');
					$number = str_replace("[","<span class='complement-italic-text'>(", $number);
					$number = str_replace("]",")</span>", $number);
					$retValue .= $number . " </div>";
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
		if (!empty($contact_position) && $contact_position["coordinates"] != "") :
			$retValue .= "<div class='side-map " . $hidden['map'] . "'><div class='map_canvas'>[Karta <span class='coordinates'>" . $contact_position["coordinates"] . "</span> <span class='address'>" . $contact_position["address"] . "</span>]</div></div>";
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
