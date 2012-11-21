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
		$this->vars['thumbnail-size'] = 'featured-image';//'slideshow-image';
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'thumbnail-size' ] ) ) {
			$thumbnailsize = $instance[ 'thumbnail-size' ];
		} else {
			$thumbnailsize = $this->vars['thumbnail-size'];
		}

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'thumbnail-size' ); ?>"><?php _e( 'Bildformat:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'thumbnail-size' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail-size' ); ?>" type="text" value="<?php echo esc_attr( $thumbnailsize); ?>" />
		</p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['thumbnail-size'] = strip_tags( $new_instance['thumbnail-size'] );
		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );

		if (isset($instance['thumbnail-size']))
			$this->vars['thumbnail-size'] = $instance['thumbnail-size'];

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
	global $default_settings;
	
	$retValue = "";
	$selected_categories = get_query_var("cat");
 	
	
	if ( !empty($selected_categories) )
	{
		// query arguments
	   	$args = array(
	   	   	'posts_per_page' => $vars["posts_per_page"], 
			'post_type'	 => 'hk_slideshow',
			'suppress_filters' => 'true',
		);
		if ( !empty($selected_categories) ) {
	 	    $args['category__and'] = array($selected_categories);
		}
		$meta_query = new WP_Query($args);
		if ($meta_query->have_posts()) {
			$retValue .= "<div class='img-wrapper'><div class='slideshow'><img class='slideshow_bg' src='" . get_stylesheet_directory_uri() . "/image.php?w=".$default_settings[$vars["thumbnail-size"]][0]."&amp;h=".($default_settings[$vars["thumbnail-size"]][1])."'/>";
			
       		// The Loop
			$first = true;
	   		while ( $meta_query->have_posts() ) : $meta_query->the_post();
				if( get_field('hk_featured_images') ) :
					while( has_sub_field('hk_featured_images') ) : 
						$image = get_sub_field('hk_featured_image');
						$src = $image["sizes"][$vars["thumbnail-size"]];
						$title = $image["title"];
						$alt = $image["alt"];
						if ($alt == "") {
							$alt = $title;
						}
	
						if (strpos($src,$default_settings[$vars["thumbnail-size"]][0] . "x" . $default_settings[$vars["thumbnail-size"]][1])) {
							$retValue .= "<article id='post-" . get_the_ID() . "' class='slide ";
							if ($first){ $retValue .= 'first '; }
							else { $retValue .= 'img_left '; }
							$retValue .= implode(" ",get_post_class()) . "'>";
							$retValue .= 	"<img src='$src' class='attachment-slideshow-image wp-post-image' alt='$alt' title='$alt' />";
							if (get_the_content() != "") {
								$retValue .= 	"<div class='text-area'>";
								$retValue .= 		"<div class='text-content'>";
								$retValue .= 			"<div class='transp-background'></div>";
								$retValue .= 			"<a href='". get_permalink(get_the_id()) ."' title='Länk till sida ". get_the_title()  ."' rel='bookmark'>" . get_the_content() . "</a>";
								$retValue .=		"</div>";
								$retValue .= 	"</div>";
							}
							$retValue .= "</article>";
						}
					endwhile;
				endif;
        	endwhile;
			$retValue .= "<span class='prevslide'></span><span class='nextslide'></span>";
			$retValue .= "</div></div>";

		}
		
	}
	return $retValue;

}


/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_slideshow" );' ) );



/* REGISTER post_type hk_slideshow */
add_action('init', hk_slideshow_init);
function hk_slideshow_init() {
	// only if in admin and is administrator
    if (is_admin() && current_user_can("administrator")) {

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
		//add_post_type_support( "hk_slideshow", "thumbnail" );
		//add_post_type_support( "hk_slideshow", "excerpt" );
		//add_post_type_support( "hk_slideshow", "trackbacks" );
		//add_post_type_support( "hk_slideshow", "custom-fields" );
		add_post_type_support( "hk_slideshow", "revisions" );

		register_taxonomy_for_object_type( "category", "hk_slideshow" );
	}
}

?>