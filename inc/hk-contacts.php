<?php

/* 
 * Description: Add Contact widget and contact post_type
 *
 * Use post name as contact name, content as more contact information and featured image to show thumbnail of contact
 **/


/* WIDGET */
class Hk_Contacts extends WP_Widget {

    public function __construct() {
		parent::__construct(
	 		'hk_contacts', // Base ID
			'Hk_Contacts', // Name
			array( 'description' => __( 'Contact Widget to display contacts from selected category', 'text_domain' ), ) // Args
		);
	}

 	public function form( $instance ) {

	}

	public function update( $new_instance, $old_instance ) {
		return $old_instance;
	}

	public function widget( $args, $instance ) {
	       	extract( $args );
		/* EV TODO : SOME CACHE
		$option_name = 'hk_contacts_cache';
		// output is generate on post_save
		$cache = get_option( $option_name );
		if ($cache != "") {
		   	//echo $cache;
			echo "not using cache riht now";
			echo hk_contacts_generate_cache();
		}
		else
		{
		*/
			echo hk_contacts_generate_cache();
    		//}
	}

}

add_action( 'widgets_init', create_function( '', 'register_widget( "Hk_Contacts" );' ) );





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
				'supports' => array('title','editor','comments','revisions','author'),
				'taxonomies' => array('category'),
				// there are a lot more available arguments, but the above is plenty for now
			));

	//}
}

// rewrites custom post type name
global $wp_rewrite;
$projects_structure = '/kontakt/%hk_kontakter%/';
$wp_rewrite->add_rewrite_tag("%hk_kontakter%", '([^/]+)', "kontakt=");
$wp_rewrite->add_permastruct('kontakt', $projects_structure, false);


// generate cache on save_post
add_action('save_post', hk_contacts_save);
function hk_contacts_save($postID) {

/* EV TODO
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $postID;
    }
    else
    {
	$post_type = get_post_type($postID);

	// only on hk_kontakter save
	if ($post_type == 'hk_kontakter') {
	   // set option
	   $option_name = 'hk_contacts_cache';

	   $newcache = hk_contacts_generate_cache();
	   //delete_option( $option_name);
	   update_option( $option_name, $newcache ) && add_option( $option_name, $newcache, '', 'no' );
	}
    }
*/
}

// outputs the content of the widget
function hk_contacts_generate_cache() {

	$retValue = "";
	
	// set startpage category if on startpage
	$category_in = array();
	if (get_query_var("cat") != "") {
		$category_in[] = get_query_var("cat");
  	}

  	// skip if no category
  	if (empty($category_in))
  		return "";

	// query arguments
	$args = array(
		'posts_per_page' => 3,
		'paged' => 1,
		'more' => $more = 0,
		'post_type' => 'hk_kontakter',
		'order' => 'ASC', 
		'suppress_filters' => 1
	);
	if ( !empty($category_in) ) {
 	    $args['category__and'] = $category_in;
	}

 	if ($args != "")
  	{
		// search in all posts (ignore filters)
		$the_query = new WP_Query( $args );

		if ($the_query->have_posts())
		{ 
  	        $retValue .= "<aside class='widget hk_kontakter'>";
			$retValue .= "<h3 class='widget-title'>Kontakta oss</h3><div class='content-wrapper'>";
	      	
	      	// The Loop
	   		while ( $the_query->have_posts() ) : $the_query->the_post();

				$retValue .= "<div class='contact-wrapper'>";// . get_the_ID();
				$retValue .= "<div class='icon'>&nbsp;</div>";
				$retValue .= "<div class='img-wrapper' style='display:none'>" . hk_get_the_post_thumbnail(get_the_ID(),"contact-image",true,false) . "</div>";
				$retValue .= "<div id='contact-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
				$retValue .= "<a class='permalink' href='". get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a>";
				$retValue .= "<span class='hidden contact_id'>" . get_the_ID() . "'</span>";
				$retValue .= "<div class='content'>" . get_field("hk_contact_titel") . "</div>";
				/*$retValue .= "<div class='more-content'>";
				// workplace
				if( get_field('hk_contact_workplaces') ): while( has_sub_field('hk_contact_workplaces') ): 
					$retValue .= "<p>" . get_sub_field('hk_contact_workplace') . "</p>";
				endwhile; endif;
				// phone
				if( get_field('hk_contact_phones') ): while( has_sub_field('hk_contact_phones') ): 
					$retValue .= "<p>";
					if(get_row_layout() == "hk_contact_fax"): $retValue .= "fax "; endif;
					$retValue .= get_sub_field('number') . "</p>";
				endwhile; endif; 
				// email
				if( get_field('hk_contact_emails') ): while( has_sub_field('hk_contact_emails') ): 
					$retValue .= "<p>" . get_sub_field('hk_contact_email') . "</p>";
				endwhile; endif;
				// description
				$retValue .= "<p>" . get_field("hk_contact_description") . "</p>";
				// address
				$retValue .= "<p>" . get_field("hk_contact_address") . "</p>";
				// visit hours
				$retValue .= "<p>" . get_field("hk_contact_visit_hours") . "</p>";
				// position
				$contact_position = get_field("hk_contact_position");
				if (!empty($contact_position)) :
					$retValue .= "<p>" . $contact_position["address"] . "</p>";
				endif;
				
				
				$retValue .= "</div>";*/
				$retValue .= "</div></div>";
	    	endwhile;
	    	// Reset Post Data
	    	wp_reset_postdata();
			$retValue .= "</div></aside>";
		}
	}

	return $retValue;

}


// [kontakt id="kontakt_id"]
// TODO add button mce to add this shortcode. Ex. http://wordpress.org/extend/plugins/post-snippets/
// TODO check default settings and check if it works to set from shortcode
function hk_contact_shortcode_func( $atts ) {
	$default = array(
		'id' => '-1',
		'kategori' => '',
		'kategorinamn' => '',
		'bild' => true,
		'namn' => true,
		'titel' => true,
		'arbetsplats' => true,
		'telefon' => true,
		'epost' => false,
		'beskrivning' => false,
		'adress' => false,
		'besokstid' => false,
		'karta' => true);
	$atts = shortcode_atts( $default, $atts );

	$translate = array(
		'id' => 'id',
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
		
	$tranlated_atts = array();
	foreach ($atts as $key => $value) {
		$tranlated_atts[$translate[$key]] = $value;
	}

	if ($tranlated_atts["id"] > 0) {
		return hk_get_contact_by_id($tranlated_atts["id"], $tranlated_atts);
	}
	if ($tranlated_atts["cat"] != "") {
		return hk_get_contact_by_cat($tranlated_atts["cat"], $tranlated_atts, false);
	}
	if ($tranlated_atts["cat_slug"] != "") {
		return hk_get_contact_by_cat($tranlated_atts["cat_slug"], $tranlated_atts, true);
	}
	if ($retValue == "") {
		return "Hittade ingen kontakt med id $id.";
	}
}
add_shortcode( 'kontakt', 'hk_contact_shortcode_func' );



// get contact by categories
function hk_get_contact_by_cat($cat, $args, $slug = false) {
	global $post;
	$org_post = $post;
	$cat_array = split(",", $cat);
		
	// query arguments
	$query_args = array(
		'posts_per_page' => -1,
		'paged' => 1,
		'more' => $more = 0,
		'post_type' => 'hk_kontakter',
		'order' => 'ASC', 
		'suppress_filters' => 1
	);
	
	if ($slug) {
		$query_args['category_name'] = $cat;
	}
	else {
		$query_args['category__and'] = $cat_array;
	}

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

// get contact by id
function hk_get_contact_by_id($contact_id, $args) {
	global $post;
	$org_post = $post;

	// query arguments
	$query_args = array(
		'posts_per_page' => -1,
		'paged' => 1,
		'more' => $more = 0,
		'post__in' => array($contact_id),
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
function hk_contact_firstpage() {
	global $post;
	$org_post = $post;

	$retValue = "";
	$retValue .= "<aside class='hk_kontakter'><div class='contact-wrapper'>";
	
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
				// The Loop
				while ( $the_query->have_posts() ) : $the_query->the_post();
					$retValue .= hk_get_the_contact(array('image' => false,
													'name' => true,
													'title' => false,
													'workplace' => false,
													'phone' => true,
													'email' => true,
													'description' => false,
													'address' => false,
													'visit_hours' => false,
													'map' => false,
													'title_link' => true));
				endwhile;
			}
			
			// Reset Post Data
			wp_reset_postdata();
			wp_reset_query();
			$post = $org_post;

	}
		
	$retValue .= "</div></aside>";
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
		'title_link' => false
		);

	if (isset($args)) {
		$default =  $args + $default;
	}

	foreach($default as $key => $value) {
		$hidden[$key] = ($value)?"visible":"hidden";
	}
	$contact_position = get_field("hk_contact_position");
	if ($hidden["map"] == "visible" && !empty($contact_position) && $contact_position["coordinates"] != "") {
		$mapclass = "hasmap";
	}
		
	$retValue = "<div class='entry-wrapper $mapclass'>";
		$retValue .= "<div class='entry-content'>";

			$retValue .= "<h1 class='entry-title " . $hidden['name'] . "'>";
			// add link to title
			if ($default['title_link']) { 
				$retValue .= "<a class='permalink' href='" . get_permalink(get_the_ID()) . "'>"; 
			}
			// title
			$retValue .= get_the_title();
			if ($default['title_link']) { 
				$retValue .= "</a>"; 
				$retValue .= "<span class='hidden contact_id'>" . get_the_ID() . "</span>";
			}
			$retValue .= "</h1>";
			
			// image
			$retValue .= hk_get_the_post_thumbnail(get_the_ID(),"contact-image",true,false, $hidden['image']);
		
			$retValue .= "<div class='contact-" . get_the_ID() . " " . implode(" ",get_post_class()) ."'>";
				$retValue .= "<div class='content " . $hidden['title'] . "'>" . get_field("hk_contact_titel") . "</div>";
				
				// workplace
				if( (get_field('hk_contact_workplaces') && !$hidden['workplace']) || (get_field('hk_contact_phones') && !$hidden['phone']) || (get_field('hk_contact_emails') && !$hidden['email']) ) {
					$retValue .= "<p>";
				}
				if( get_field('hk_contact_workplaces') ): while( has_sub_field('hk_contact_workplaces') ):
					$retValue .= "<div class='" . $hidden['workplace'] . "'>" . get_sub_field('hk_contact_workplace') . "</div>";
				endwhile; endif;
				
				// email
				if( get_field('hk_contact_emails') ): while( has_sub_field('hk_contact_emails') ):
					$retValue .= "<div class='" . $hidden['email'] . "'><a href='mailto:" . get_sub_field('hk_contact_email') . "'>" . get_sub_field('hk_contact_email') . "</a></div>";
				endwhile; endif;

				// phone
				if( get_field('hk_contact_phones') ): while( has_sub_field('hk_contact_phones') ): 
					$retValue .= "<div class='" . $hidden['phone'] . "'>";
					$retValue .= (get_row_layout() == "hk_contact_fax")?"fax ":"";
					$retValue .= get_sub_field('number') . " </div>";
				endwhile; endif;				
				
				if( (get_field('hk_contact_workplaces') && !$hidden['workplace']) || (get_field('hk_contact_phones') && !$hidden['phone']) || (get_field('hk_contact_emails') && !$hidden['email']) ) {
					$retValue .= "</p>";
				}
				// description
				$retValue .= "<p class='" . $hidden['description'] . "'>" . get_field("hk_contact_description") . "</p>";
				
				// address
				$retValue .= "<p class='" . $hidden['address'] . "'>" . get_field("hk_contact_address") . "</p>";
				
				// visit hours
				$retValue .= "<p class='" . $hidden['visit_hours'] . "'>" . get_field("hk_contact_visit_hours") . "</p>";
								
			$retValue .= "</div>";
		$retValue .= "</div>";
	
		// position
		if (!empty($contact_position) && $contact_position["coordinates"] != "") :
			$retValue .= "<div class='side-map'><div class='map_canvas " . $hidden['map'] . "'>[Karta <span class='coordinates'>" . $contact_position["coordinates"] . "</span> <span class='address'>" . $contact_position["address"] . "</span>]</div></div>";
		endif;
		

	$retValue .= "</div>";

	return $retValue;
}

// outputs the content of the contact side tab
function hk_contact_tab() {
	global $hk_options;
	if ($hk_options["contact_side_image"] == "") {
		return "";
	}
	
	$retValue = "";
	$retValue .= "<aside id='contact-side-tab' class='hk_kontakter'>";
	$retValue .= "<img class='toggle-tab' src='" . $hk_options["contact_side_image"] . "' /><div class='content-wrapper'>";
	
	// set startpage category if on startpage
	$category_in = array();
	if (get_query_var("cat") != "") {
		$category_in = hk_getParentsSlugArray(get_query_var("cat"));
		$category_in = array_reverse($category_in);

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
			$cat = get_category_by_slug($category);
			if ($cat) {
				
				$args['category__and'] = $cat->term_id;

				// search in all posts (ignore filters)
				$the_query = new WP_Query( $args );
	
				if ($the_query->have_posts())
				{ 

					// The Loop
					while ( $the_query->have_posts() ) : $the_query->the_post();

						$retValue .= "<div class='contact-wrapper'>";
						$retValue .= "<div class='icon'>&nbsp;</div>";
						$retValue .= "<div class='contact-" . get_the_ID() . " " . implode(" ",get_post_class()) . "'>";
						$retValue .= "<a class='permalink' href='". get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a>";
						$retValue .= "<span class='hidden contact_id'>" . get_the_ID() . "</span>";
						$retValue .= "<div class='content'>" . get_field("hk_contact_titel") . "</div>";
						
						$retValue .= "</div></div>";
					endwhile;
					// Reset Post Data
					wp_reset_postdata();
				}
			}
		}

	}
	
	$retValue .= "</div></aside>";
	echo $retValue;

}
?>

