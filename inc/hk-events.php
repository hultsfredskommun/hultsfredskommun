<?php

/* 
 * Description: Add events widget 
 **/



// events widget
class HK_events extends WP_Widget {
	var $option_cache_name = 'HK_events_cache';
	protected $vars = array();

        public function __construct() {
		parent::__construct(
	 		'HK_events', // Base ID
			'HK_events', // Name
			array( 'description' => "Widget som visar bildspel från besökt kategori" ) // Args
		);

		$this->vars['divclass'] = 'events';
		$this->vars['posts_per_page'] = '-1';
		$this->vars['thumbnail-size'] = 'contact-image';
	}

 	public function form( $instance ) {
		// outputs the options form on admin
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		return $new_instance;
	}

	public function widget( $args, $instance ) {
	       	extract( $args );

		echo hk_events_generate_output($this->vars);
		// TODO?? generate output on post_save
		//$cache = get_option( $this->option_cache_name );
		if ($cache != "") {
		   	//echo $cache;
		}
		else
		{
			//echo "not cached";
		}
	}
}

// outputs the content of the widget
function hk_events_generate_output($vars) {

	$retValue = "";
	
	// set startpage category if on startpage
	$category_in = array();
	$category_in[] = get_query_var("cat");

  	// skip if no category
  	if (empty($category_in))
  		return "";

	$args = array(
		'posts_per_page' => 3,
		'paged' => 1,
		'more' => $more = 0,
		'post_type' => 'hk_events',
		'category__in' => $category_in,
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
  	        $retValue .= "<aside class='widget hk_events'>";
	      	$retValue .= "<h3 class='widget-title'>Evenemang</h3>";
	      	
	      	// The Loop
	   		while ( $the_query->have_posts() ) : $the_query->the_post();

				$retValue .= "<div class='events-wrapper'>";
				$retValue .= "<div class='icon'>&nbsp;</div>";
				$retValue .= "<div class='img-wrapper' style='display:none'>" . get_the_post_thumbnail(get_the_ID(),"events-image") . "</div>";
				$retValue .= "<div id='events-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
				$retValue .= "<a class='permalink' href='". get_permalink() . "'>" . get_the_title() . "</a>";
				$retValue .= "<div class='content'>" . str_replace("\n","<br>",get_the_content()) . "</div>";
				$retValue .= "</div></div>";
	    	endwhile;
	    	// Reset Post Data
	    	wp_reset_postdata();
			$retValue .= "</aside>";
		}
	}

	return $retValue;
}


/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_events" );' ) );



/* REGISTER post_type hk_events */
add_action('init', hk_events_init);
function hk_events_init() {
	// only if in admin and is administrator
    if (is_admin() && current_user_can("administrator")) {

		register_post_type( 'hk_events',
			array(
				'labels' => array(
					'name' => __( 'Evenemang' ),
					'singular_name' => __( 'Evenemang' )
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'events')
			)
		);
		add_post_type_support( "hk_events", "title" );
		add_post_type_support( "hk_events", "editor" );
		add_post_type_support( "hk_events", "author" );
		add_post_type_support( "hk_events", "thumbnail" );
		//add_post_type_support( "hk_events", "excerpt" );
		//add_post_type_support( "hk_events", "trackbacks" );
		//add_post_type_support( "hk_events", "custom-fields" );
		add_post_type_support( "hk_events", "revisions" );

		register_taxonomy_for_object_type( "category", "hk_events" );
	}
}

?>