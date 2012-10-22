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
$projects_structure = '/artikel/kontakt/%hk_kontakter%/';
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

 	// return current page related contact if in_single
  	if (false) //TODO what to do if single (is_single())
  	{ 
		if( get_field('hk_contacts') ) : 
	        $retValue .= "<aside class='widget hk_kontakter'>";
	      	$retValue .= "<h3 class='widget-title'>Kontakta oss</h3>";
			if( get_field('hk_contacts') ) : 
				while( has_sub_field('hk_contacts') ) :
					$value = get_sub_field('hk_contact');
					$retValue .= "<div class='contact-wrapper'>";
					$retValue .= "<div class='icon'>&nbsp;</div>";
					$retValue .= "<div class='img-wrapper' style='display:none'>" . get_the_post_thumbnail($value->ID,"contact-image") . "</div>";
					$retValue .= "<div id='contact-" . $value->ID . "' class='" . implode(" ",get_post_class("hk_kontakter")) . "'>";
					$retValue .= "<a class='permalink' href='". $value->guid . "'>" . $value->post_title . "</a>";
					$retValue .= "<div class='content'>" . str_replace("\n","<br>",$value->post_content) . "</div>";
					$retValue .= "</div></div>";
		    	endwhile;
		 	endif; 
			$retValue .= "</aside>";
		endif;
		echo $retValue;	
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
	      	$retValue .= "<h3 class='widget-title'>Kontakta oss</h3>";
	      	
	      	// The Loop
	   		while ( $the_query->have_posts() ) : $the_query->the_post();

				$retValue .= "<div class='contact-wrapper'>";// . get_the_ID();
				$retValue .= "<div class='icon'>&nbsp;</div>";
				$retValue .= "<div class='img-wrapper' style='display:none'>" . hk_get_the_post_thumbnail(get_the_ID(),"contact-image",true,false) . "</div>";
				$retValue .= "<div id='contact-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
				$retValue .= "<a class='permalink' href='". get_permalink(get_the_ID()) . "'>" . get_the_title() . "</a>";
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
			$retValue .= "</aside>";
		}
	}

	return $retValue;

}
?>

