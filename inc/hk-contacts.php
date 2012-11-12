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
				$retValue .= "<a  post_id='" . get_the_ID() . "' class='permalink' href='". get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a>";
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
function hk_contact_shortcode_func( $atts ) {
	extract( shortcode_atts( array(
		'id' => '-1',
	), $atts ) );
	if ($id > 0) {
		return hk_get_contact_by_id($id);
	}
	return "Hittade ingen kontakt med id $id.";
}
add_shortcode( 'kontakt', 'hk_contact_shortcode_func' );




// outputs the content of first page contact
function hk_get_contact_by_id($contact_id) {

	
	// query arguments
	$args = array(
		'posts_per_page' => -1,
		'paged' => 1,
		'more' => $more = 0,
		'post__in' => array($contact_id),
		'post_type' => 'hk_kontakter',
		'order' => 'ASC', 
		'suppress_filters' => 1
	);

	// search in all posts (ignore filters)
	$the_query = new WP_Query( $args );
	$retValue = "";
	if ($the_query->have_posts())
	{ 

		// The Loop
		while ( $the_query->have_posts() ) : $the_query->the_post();
			$retValue .= "<div class='contact-area'>";
			$retValue .= hk_get_the_contact();
			$retValue .= "</div>";
		endwhile;
		// Reset Post Data
		wp_reset_postdata();
	}
	return $retValue;

}


// outputs the content of first page contact
function hk_contact_firstpage() {


	$retValue = "";
	$retValue .= "<aside class='hk_kontakter'><div class='content-wrapper'>";
	
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
					require("hk_kontakter_content.php");
					$retValue .= "<div class='contact-wrapper'>";
					$retValue .= "<div class='icon'>&nbsp;</div>";
					$retValue .= "<div id='contact-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
					$retValue .= "<a post_id='" . get_the_ID() . "' class='permalink' href='". get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a>";
					$retValue .= "<div class='content'>" . get_field("hk_contact_titel") . "</div>";
					
					$retValue .= "</div></div>";
				endwhile;
				// Reset Post Data
				wp_reset_postdata();
			}
		
		

	}
	
	$retValue .= "<div class='contact-wrapper'>";
	$retValue .= "<div class='icon'>&nbsp;</div>";
	$retValue .= "<div id='contact-synpunkt'>";
	$retValue .= "<a post_id='-1' class='permalink' href='". get_permalink(get_the_ID()) . "'>L&auml;mna en synpunkt</a>";
	$retValue .= "</div></div>";

	$retValue .= "<div class='contact-wrapper'>";
	$retValue .= "<div class='icon'>&nbsp;</div>";
	$retValue .= "<div id='contact-synpunkt'>";
	$retValue .= "<a post_id='-2' class='permalink' href='". get_permalink(get_the_ID()) . "'>L&auml;mna en felanm&auml;an</a>";
	$retValue .= "</div></div>";
	
	$retValue .= "</div></aside>";
	//echo $retValue;

}
function hk_the_contact() {
	echo hk_get_the_contact();
}
function hk_get_the_contact() {
	$retValue = "<div class='entry-wrapper'>";
		$retValue .= hk_get_the_post_thumbnail(get_the_ID(),"contact-image",true,false);
		$retValue .= "<h1 class='entry-title'>" . get_the_title() . "</h1>";
		$retValue .= "<div class='entry-content'>";
		
			$retValue .= "<div id='contact-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) ."'>";
				$retValue .= "<div class='content'>" . get_field("hk_contact_titel") . "</div>";
				
				// workplace
				if( get_field('hk_contact_workplaces') ): while( has_sub_field('hk_contact_workplaces') ):
					$retValue .= "<p>" . get_sub_field('hk_contact_workplace') . "</p>";
				endwhile; endif;
				
				// phone
				if( get_field('hk_contact_phones') ): while( has_sub_field('hk_contact_phones') ): 
					$retValue .= "<p>";
					$retValue .= (get_row_layout() == "hk_contact_fax")?"fax ":"";
					$retValue .= get_sub_field('number') . "</p>";
				endwhile; endif;
				
				// email
				if( get_field('hk_contact_emails') ): while( has_sub_field('hk_contact_emails') ):
					$retValue .= "<p><a href='mailto:" . get_sub_field('hk_contact_email') . "'>" . get_sub_field('hk_contact_email') . "</a></p>";
				endwhile; endif;
				
				// description
				$retValue .= "<p>" . get_field("hk_contact_description") . "</p>";
				
				// address
				$retValue .= "<p>" . get_field("hk_contact_address") . "</p>";
				
				// visit hours
				$retValue .= "<p>" . get_field("hk_contact_visit_hours") . "</p>";
				
				// position
				$contact_position = get_field("hk_contact_position");
				if (!empty($contact_position) && $contact_position["coordinates"] != "") :
					$retValue .= "<div class='map_canvas'>[Karta <span class='coordinates'>" . $contact_position["coordinates"] . "</span> <span class='address'>" . $contact_position["address"] . "</span>]</div>";
				endif;
				
			$retValue .= "</div>";
		$retValue .= "</div>";
	$retValue .= "</div>";
	return $retValue;
}

// outputs the content of the contact side tab
function hk_contact_tab() {


	$retValue = "";
	$retValue .= "<aside id='side-tab' class='hk_kontakter'>";
	$retValue .= "<h3 class='widget-title'>Kontakta oss</h3><div class='content-wrapper'>";
	
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
						$retValue .= "<div id='contact-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
						$retValue .= "<a post_id='" . get_the_ID() . "' class='permalink' href='". get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a>";
						$retValue .= "<div class='content'>" . get_field("hk_contact_titel") . "</div>";
						
						$retValue .= "</div></div>";
					endwhile;
					// Reset Post Data
					wp_reset_postdata();
				}
			}
		}

	}
	
	$retValue .= "<div class='contact-wrapper'>";
	$retValue .= "<div class='icon'>&nbsp;</div>";
	$retValue .= "<div id='contact-synpunkt'>";
	$retValue .= "<a post_id='-1' class='permalink' href='". get_permalink(get_the_ID()) . "'>L&auml;mna en synpunkt</a>";
	$retValue .= "</div></div>";

	$retValue .= "<div class='contact-wrapper'>";
	$retValue .= "<div class='icon'>&nbsp;</div>";
	$retValue .= "<div id='contact-synpunkt'>";
	$retValue .= "<a post_id='-2' class='permalink' href='". get_permalink(get_the_ID()) . "'>L&auml;mna en felanm&auml;an</a>";
	$retValue .= "</div></div>";
	
	$retValue .= "</div></aside>";
	echo $retValue;

}
?>

