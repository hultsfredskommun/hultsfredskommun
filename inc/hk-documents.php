<?php

/**
 * Description: Add document widget and document post_type. 
 * Create an ACF with these fields.
 *  1. Name hk_document_attach with type File
 *  2. Name hk_post_connect with type Post Object
 *  3. Name hk_document_description with type Wysiwyg Editor
 * And location rules Post Type is equal to hk_dokument
 *  */


/* WIDGET */
class Hk_Documents extends WP_Widget {

        public function __construct() {
		parent::__construct(
	 		'hk_documents', // Base ID
			'Hk_Documents', // Name
			array( 'description' => __( 'Document Widget to display documents from selected category', 'text_domain' ), ) // Args
		);
	}

 	public function form( $instance ) {

	}

	public function update( $new_instance, $old_instance ) {
		return $old_instance;
	}

	public function widget( $args, $instance ) {
	       	extract( $args );
			echo hk_documents_generate_cache();
	}

}

add_action( 'widgets_init', create_function( '', 'register_widget( "Hk_Documents" );' ) );





/* REGISTER post_type hk_kontakter */

add_action('init', hk_documents_init);
function hk_documents_init() {

	register_post_type( 'hk_dokument',
		array(
			'labels' => array(
				'name' => __( 'Dokument' ),
				'singular_name' => __( 'Dokument' )
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'dokument')
		)
	);
	add_post_type_support( "hk_dokument", array("title","author","thumbnail","custom-fields","revisions") );
	remove_post_type_support( "hk_dokument", "editor" );

	register_taxonomy_for_object_type( "category", "hk_dokument" );
	register_taxonomy_for_object_type( "post_tag", "hk_dokument" );

}


function hk_documents_generate_cache() {

	$retValue = "";
	// outputs the content of the widget


	$cat = get_query_var("cat");
 	$tag = get_query_var("tag");
 	//echo $tag . " - " . $cat;

 	if ($cat != "") {
 		$category_in = array($cat);
 		if ($tag != "") {
			$tag_in = array();

    		foreach(split(",", $tag) as $tag)
    		{
				$tag_slug_in[] = $tag;
			}
		}
 	}
	else if ($tag != "")
	{
		$tag_slug_in = array($tag);
	}
	else
	{
		$category_in = array();
    	foreach(get_the_category() as $cat)
    	{
			$category_in[] = $cat->term_id;
		}

		$tag_in = array();
    	foreach(get_the_tags() as $tag)
    	{
			$tag_in[] = $tag->term_id;
		}

	}

	$args = array(
		    'posts_per_page' => 3,
			'paged' => 1,
			'more' => $more = 0,
			'post_type' => 'hk_dokument',
			'order' => 'ASC',
			'suppress_filters' => 1
			);


	if (count($category_in) > 0)
		$args['category__in'] = $category_in;
	if (count($tag_in) > 0)
		$args['tag__in'] = $tag_in;
	if (count($tag_slug_in) > 0)
		$args['tag_slug__in'] = $tag_slug_in;

	//print_r($args);
 	if ($args != "")
  	{
		// search in all posts (ignore filters)
       	$the_query = new WP_Query( $args );

		if ($the_query->have_posts())
		{ 
			$retValue .= "<aside class='widget hk_dokument'>";
			$retValue .= "<h3 class='widget-title'>Dokument</h3>";				    // The Loop
       		while ( $the_query->have_posts() ) : $the_query->the_post();
				$retValue .= "<div id='document-" . get_the_ID() . "' class='" . implode(" ",get_post_class()) . "'>";
		      	$retValue .= get_the_post_thumbnail(get_the_ID(),"document-image");
		      	$attachId = get_post_meta(get_the_ID(), "hk_document_attach", true);
		      	if ($attachId != "" && $attachId > 0) {
					//$retValue .= wp_get_attachment_link($attachId); 
					$title = get_the_title();
					$url = wp_get_attachment_url($attachId);
					$ext = substr(strrchr($url, '.'), 1);
					$retValue .= "<div class='icon $ext'>&nbsp;</div><a class='document-link' href='$url' title='$title'>$title</a>";
					if (isset( $GLOBALS['wp_scripts']->registered[ 'jquery' ] )) {
						$desc = get_post_meta(get_the_ID(), "hk_document_description", true);
						if ($desc != "") {
						}
							$retValue .= " <a href='#' class='more-link' onclick=\"jQuery('#document-desc-$attachId').toggle('fast');return false;\">&rarr;</a><div id='document-desc-$attachId' class='description' style='display: none'>$desc</div>";
					}
				}
				//$retValue .= "<h4>" . get_the_title() . "</h4>";
				//$retValue .= str_replace("\n","<br>",get_the_content());
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