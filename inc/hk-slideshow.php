<?php

/* 
 * Description: Add slideshow widget 
 **/



// Slideshow widget
class HK_slideshow extends WP_Widget {
	var $option_cache_name = 'HK_slideshow_cache';
	protected $vars = array();

        public function __construct() {
		parent::__construct(
	 		'HK_slideshow', // Base ID
			'HK_slideshow', // Name
			array( 'description' => "Widget som visar bildspel från besökt kategori" ) // Args
		);

		$this->vars['divclass'] = 'slideshow';
		$this->vars['posts_per_page'] = '-1';
		$this->vars['thumbnail-size'] = 'slideshow-image';
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

		echo hk_slideshow_generate_output($this->vars);
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
function hk_slideshow_generate_output($vars) {

	$retValue = "";
 	if ( is_home() )
 	{
 		$hk_options = get_option("hk_theme");
 		$selected_categories = $hk_options["startpage_cat"];
 	}
 	else {
	 	$selected_categories = get_query_var("cat");
 	}

	if ($selected_categories != "")
	{
		// query arguments
	   	$args = array(
	   	   	'posts_per_page' => $vars["posts_per_page"], 
			'post_type'	 => 'hk_slideshow',
	 	    'category__and' => $selected_categories
		);
		
		
		$meta_query = new WP_Query($args);
		if ($meta_query->have_posts()) {
       		// The Loop
			$counter = 0;
       		while ( $meta_query->have_posts() ) : $meta_query->the_post();
				$retValue .= '<article id="post-' . get_the_ID() . '" class="';
				if ($counter==0){ $retValue .= 'first '; }
				else { $retValue .= 'img_left '; }

				$retValue .= implode(" ",get_post_class()) . '">';
				$retValue .= 	get_the_post_thumbnail(get_the_ID(),$vars["thumbnail-size"]);
				$retValue .= 	'<div class="text-area">';
				$retValue .= 		'<div class="text-content">';
				$retValue .= 			'<div class="transp-background"></div>';
				$retValue .= 			"<header class='entry-header'><h2 class='entry-title'><a href='". get_permalink(get_the_id()) ."' title='Länk till sida ". get_the_title()  ."' rel='bookmark'>" . get_the_title() . "</a></h2></header>";
				$retValue .= 			'<div class="entry-content">';
				$retValue .= 				get_the_content();
				$retValue .=			'</div>';
				$retValue .=		'</div>';
				$retValue .= 	'</div>';
				$retValue .= "</article>";
				
				$counter++;
        	endwhile;

		}
		
	}
	return $retValue;

}


/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_slideshow" );' ) );



/* REGISTER post_type hk_slideshow */
add_action('init', hk_slideshow_init);
function hk_slideshow_init() {

	register_post_type( 'hk_slideshow',
		array(
			'labels' => array(
				'name' => __( 'Bildspel' ),
				'singular_name' => __( 'Bildspel' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'slideshow')
		)
	);
	add_post_type_support( "hk_slideshow", "title" );
	add_post_type_support( "hk_slideshow", "editor" );
	add_post_type_support( "hk_slideshow", "author" );
	add_post_type_support( "hk_slideshow", "thumbnail" );
	//add_post_type_support( "hk_slideshow", "excerpt" );
	//add_post_type_support( "hk_slideshow", "trackbacks" );
	//add_post_type_support( "hk_slideshow", "custom-fields" );
	add_post_type_support( "hk_slideshow", "revisions" );

	register_taxonomy_for_object_type( "category", "hk_slideshow" );

}

?>