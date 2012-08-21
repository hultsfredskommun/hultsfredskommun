<?php

/* 
 * Description: Add Contact widget and contact post_type
 *  */


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

	register_post_type( 'hk_kontakter',
		array(
			'labels' => array(
				'name' => __( 'Kontakter' ),
				'singular_name' => __( 'Kontakt' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'kontakt')
		)
	);
	add_post_type_support( "hk_kontakter", "title" );
	add_post_type_support( "hk_kontakter", "editor" );
	add_post_type_support( "hk_kontakter", "author" );
	add_post_type_support( "hk_kontakter", "thumbnail" );
	//add_post_type_support( "hk_kontakter", "excerpt" );
	//add_post_type_support( "hk_kontakter", "trackbacks" );
	//add_post_type_support( "hk_kontakter", "custom-fields" );
	add_post_type_support( "hk_kontakter", "revisions" );

	register_taxonomy_for_object_type( "category", "hk_kontakter" );
	//register_taxonomy_for_object_type( "post_tag", "hk_kontakter" );

}


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
 	if ( is_home() )
 	{
 		$hk_options = get_option("hk_theme");
 		$category_in[] = $hk_options["startpage_cat"];
 	}
 	else if (get_query_var("cat") != "") {
		$category_in[] = get_query_var("cat");
  	}

  	// skip if no category
  	if (count($category_in) <= 0)
  		return "no selected category";

	$args = array(
		'posts_per_page' => 3,
		'paged' => 1,
		'more' => $more = 0,
		'post_type' => 'hk_kontakter',
		'category__in' => $category_in,
		'order' => 'ASC', /* TODO: is this needed, is default most viewed if not suppress_filters? */
		'suppress_filters' => 1 /* TODO: is this needed? */
	);

 	if ($args != "")
  	{
		// search in all posts (ignore filters)
		$the_query = new WP_Query( $args );

		if ($the_query->have_posts())
		{ 
  	        $retValue .= "<aside class='widget hk_kontakter'>";
	      	//$retValue .= "<h3 class='widget-title'>Kontakter</h3>";
	      	
	      	// The Loop
	   		while ( $the_query->have_posts() ) : $the_query->the_post();
				/*
				$retValue .= "<div class='contact-wrapper'><div class='img-wrapper'>" . get_the_post_thumbnail(get_the_ID(),"contact-image") . "</div>";
				$retValue .= "<div class='iconset'></div>";
				$retValue .= "<div id='contact-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
				$retValue .= "<h4>" . get_the_title() . "</h4>";
				$retValue .= "<div class='text'>" . str_replace("\n","<br>",get_the_content()). "</div>";
				$retValue .= "<a class='permalink' href='" . get_permalink() . "'>Mer information</a></div></div>";
				*/
				$retValue .= "<div class='contact-wrapper'>";//<div class='img-wrapper'>" . get_the_post_thumbnail(get_the_ID(),"contact-image") . "</div>";
				$retValue .= "<div class='icon'>&nbsp;</div>";
				$retValue .= "<div id='contact-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
				$retValue .= "<div class='text'><h4>" . get_the_title() . "</h4>";
				$retValue .= "" . str_replace("\n","<br>",get_the_content()). "</div>";
				//$retValue .= "<a class='permalink' href='" . get_permalink() . "'>Mer information</a></div>";
				$retValue .= "</div>";
	    	endwhile;
	    	// Reset Post Data
	    	wp_reset_postdata();
			$retValue .= "</aside>";
		}
	}

	return $retValue;

}
?>

