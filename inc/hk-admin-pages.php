<?php
/*
 * Add unfiltered_html capabilities to administrator, editor and author
 */
function change_role_caps() {
	$role = get_role( 'administrator' ); 
	$role->add_cap( 'unfiltered_html' ); 
	$role->remove_cap('manage_links');

	$role = get_role( 'editor' ); 
	$role->add_cap( 'unfiltered_html' );
	$role->remove_cap('manage_categories');
	$role->remove_cap('manage_links');
	

	$role = get_role( 'author' ); 
	$role->add_cap( 'unfiltered_html' );	 
	$role->remove_cap('manage_links');

}
add_action( 'admin_init', 'change_role_caps');


// generate cache on save_post
add_action('save_post', hk_save_post);
function hk_save_post($postID) {

}


/*
 * Add reviews functionality
 * hk_reviewed - checkbox to set "now post is reviewed" (not saved)
 * hk_last_reviewed - date last time post reviewed
 * hk_next_review - date next time post should be reviewed
 * hk_review_timespan - selectable list 4 alternatives of time span to next review date (used to set hk_next_review)
 */
function hk_add_review_metabox() {
    add_meta_box( 'custom-metabox', "Granska", 'hk_review_metabox', 'post', 'side', 'high' );
}

function hk_review_metabox() {
    global $post;
    $hk_reviewed = get_post_meta( $post->ID, 'hk_reviewed', true );
    $date = get_post_meta( $post->ID, 'hk_last_reviewed', true );
    $nextdate = get_post_meta( $post->ID, 'hk_next_review', true );
    $timespan = get_post_meta( $post->ID, 'hk_review_timespan', true );
    if ($timespan == "") $timespan = "threemonths" 
    ?>
	<?php if ($date == "") : ?>
	    <p><?php echo "Granskades senast $date och ska granskas igen $nextdate."; ?></p>
	<?php else : ?>
	    <p><?php echo "Inlägget har aldrig granskats."; ?></p>
	<?php endif; ?>
    <p><label for="hk_reviewed"> 
        <input type="checkbox" id="hk_reviewed" name="hk_reviewed">&nbsp;Jag har granskat inlägget</input></label></p>
    <p><label for="hk_review_timespan">Tid till nästa granskning 
        <select type="checkbox" id="hk_review_timespan" name="hk_review_timespan">
	        <option value="week" <?php echo ($timespan == "week") ? "selected":""; ?>>Nästa vecka</option>
			<option value="month" <?php echo ($timespan == "month") ? "selected":""; ?>>Nästa månad</option>
			<option value="threemonths" <?php echo ($timespan == "threemonths") ? "selected":""; ?>>Tre månader</option>
			<option value="sixmonths" <?php echo ($timespan == "sixmonths") ? "selected":""; ?>>Sex månader</option>
			<option value="year" <?php echo ($timespan == "year") ? "selected":""; ?>>Nästa år</option>
		</select></label></p>
<?php
}

function hk_save_review_details( $post_ID ) {
    global $post;   
    if( $_POST ) {
    	if ($_POST["hk_reviewed"]) {
	    	$date = Date("Y-m-d", strtotime('now'));
	    	$timespan = "+3 months";
	    	switch($_POST["hk_review_timespan"]) {
		    	case "week": $timespan = "+1 week"; break;
		    	case "month": $timespan = "+1 month"; break;
		    	case "threemonths": $timespan = "+3 months"; break;
		    	case "sixmonths": $timespan = "+6 months"; break;
		    	case "year": $timespan = "+1 year"; break;
			}
	    	$nextdate = Date("Y-m-d", strtotime($timespan));
	        add_post_meta( $post->ID, 'hk_last_reviewed', $date, true ) || update_post_meta( $post->ID, 'hk_last_reviewed', $date );
	        add_post_meta( $post->ID, 'hk_next_review', $nextdate, true ) || update_post_meta( $post->ID, 'hk_next_review', $nextdate );
	        add_post_meta( $post->ID, 'hk_review_timespan', $_POST["hk_review_timespan"], true ) || update_post_meta( $post->ID, 'hk_review_timespan', $_POST["hk_review_timespan"] );
    	}
	}
}

add_action( 'admin_init', 'hk_add_review_metabox' );
add_action( 'save_post', 'hk_save_review_details' );




/* 
 * Media Library and images
 */

// add custom "mime types" (file supertypes)
function filterPostMimeTypes($post_mime_types) {
    $post_mime_types['application'] = array('Document', 'Hantera documents', _n_noop('Dokument <span class="count">(%s)</span>', 'Dokument <span class="count">(%s)</span>'));
    $post_mime_types['audio'] = array('Audio', 'Hantera ljud', _n_noop('Ljud <span class="count">(%s)</span>', 'Ljud <span class="count">(%s)</span>'));
    $post_mime_types['video'] = array('Video', 'Hantera video', _n_noop('Video <span class="count">(%s)</span>', 'Video <span class="count">(%s)</span>'));
    return $post_mime_types;
}
add_filter('post_mime_types', 'filterPostMimeTypes');

// Add Hultsfredskommun custom image sizes.
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'thumbnail-image',  $default_settings['thumbnail-image'][0], $default_settings['thumbnail-image'][1], $default_settings['thumbnail-image'][2] );
	add_image_size( 'featured-image',  $default_settings['featured-image'][0], $default_settings['featured-image'][1], $default_settings['featured-image'][2] );
	add_image_size( 'slideshow-image',  $default_settings['slideshow-image'][0], $default_settings['slideshow-image'][1], $default_settings['slideshow-image'][2] );
	add_image_size( 'contact-image',  $default_settings['contact-image'][0], $default_settings['contact-image'][1], $default_settings['contact-image'][2] );
}

// remove width and height attr on img tags
function remove_thumbnail_dimensions( $html ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );




/**
 * Alter the default admin menus, settings and looks.
 * Change name of menus in admin 
 */



// Change the WYSIWYG editor buttons
function hk_formatTinyMCE($in)
{
//	$in['remove_linebreaks']=false;
//	$in['gecko_spellcheck']=false;
//	$in['keep_styles']=false;
//	$in['accessibility_focus']=true;
//	$in['tabfocus_elements']='major-publishing-actions';
//	$in['media_strict']=false;
//	$in['paste_remove_styles']=true;
//	$in['paste_remove_spans']=true;
//	$in['paste_strip_class_attributes']='none';
//	$in['paste_text_use_dialog']=true;
//	$in['wpeditimage_disable_captions']=true;
//	$in['plugins']='inlinepopups,tabfocus,paste,media,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpfullscreen';
//	$in['content_css']=get_template_directory_uri() . "/editor-style.css";
//	$in['wpautop']=true;
//	$in['apply_source_formatting']=false;
	$in['theme_advanced_buttons1']='formatselect,removeformat,|,bold,italic,|,bullist,numlist,blockquote,|,link,unlink,|,charmap,|,spellchecker,|,undo,redo,|,wp_fullscreen';
	$in['theme_advanced_buttons2']='';
	$in['theme_advanced_buttons3']='';
	$in['theme_advanced_buttons4']='';
	return $in;
}
add_filter('tiny_mce_before_init', 'hk_formatTinyMCE' );




// remove links/menus from the admin bar 
function hk_admin_bar_render() { 
	global $wp_admin_bar; 

} 
add_action( 'wp_before_admin_bar_render', 'hk_admin_bar_render' ); 


/* change names in admin menus */
function change_post_menu_label() {
    global $menu;
	global $submenu;

    // hide tag divs if not administrator
    if (!current_user_can("administrator")) {
        // hide tools menu
	    unset($menu[75]);
	}
}

function hk_change_meta_boxes () {
    // hide meta tag boxes in edit
    // hide tag divs if not administrator
 	//remove_meta_box("tagsdiv-post_tag","post",'side');
	//remove_meta_box("tagsdiv-vem","post",'side');
	//remove_meta_box("tagsdiv-ort","post",'side');

    // hide tag divs if not administrator
    if (!current_user_can("administrator")) {
		remove_meta_box("special_categorydiv","post","side");
	}
    echo '';
}


/* change names in admin pages */
function change_post_object_label() {
    global $wp_post_types;
    $labels = &$wp_post_types['page']->labels;
    $labels->name = 'Special';
    $labels->singular_name = 'Special';
    $labels->add_new = 'L&auml;gg till';
    $labels->add_new_item = 'L&auml;gg till';
    $labels->edit_item = '&Auml;ndra';
    $labels->new_item = 'Ny';
    $labels->view_item = 'Visa';
    $labels->search_items = 'S&ouml;k';
    $labels->not_found = 'Hittade inga';
    $labels->not_found_in_trash = 'Hittade inga i papperskorgen';
}
if (is_admin()) {
	add_action( 'init', 'change_post_object_label' );
	add_action( 'add_meta_boxes', 'hk_change_meta_boxes' );
	add_action( 'admin_menu', 'change_post_menu_label' );
}
/* remove unwanted fields from media library items */
function remove_media_upload_fields( $form_fields, $post ) {
    //unset( $form_fields['image-size'] );
    unset( $form_fields['post_excerpt'] );
    unset( $form_fields['image_alt'] );
    //unset( $form_fields['post_content'] );
    //unset( $form_fields['url'] );
    //unset( $form_fields['image_url'] );
    //unset( $form_fields['align'] );
    
    return $form_fields;
}
add_filter('attachment_fields_to_edit', 'remove_media_upload_fields', null, 2);


/**
 * Create a new taxonomies for vem, ort and special_cat
 */
function extra_tag_init() {
	register_taxonomy(
		'special_category',
		array('post','hk_slideshow'),
	 	array(
			'hierarchical' => true,
			'label' => __( 'Specialkategori' ),
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'special_category' ),
			'capabilities' => array (
	            'manage_terms' => 'administrator',
	            'edit_terms' => 'administrator',
	            'delete_terms' => 'administrator',
	            'assign_terms' => 'administrator'
            )
		)
	);
	register_taxonomy(
		'vem',
		'post',
	 	array(
			'hierarchical' => false,
			'label' => __( 'Vem' ),
			'sort' => true,
			'rewrite' => true,
			'query_var' => true,
			'capabilities' => array (
	            'manage_terms' => "manage_options", 
	            'edit_terms' => "manage_options",
	            'delete_terms' => "manage_options",
	            'assign_terms' => "edit_posts"
            )
		)
	);
	register_taxonomy(
		'ort',
		'post',
	 	array(
			'hierarchical' => false,
			'label' => __( 'Var' ),
			'sort' => true,
			'rewrite' => true,
			'query_var' => true,
			'capabilities' => array (
	            'manage_terms' => "manage_options", 
	            'edit_terms' => "manage_options",
	            'delete_terms' => "manage_options",
	            'assign_terms' => "edit_posts"
            )
		)
	);
}

add_action( 'init', 'extra_tag_init' );




class Tag_Rewrite {
	
	/**
	* Matty_Rewrite()
	* Constructor function.
	**/
	
	function Tag_Rewrite () {} // End Matty_Rewrite()

	/**
	* create_custom_rewrite_rules()
	* Creates the custom rewrite rules.
	* return array $rules.
	**/
	
	function create_custom_rewrite_rules() {
		global $wp_rewrite;
		
		//** create new rule "vem" **
		// Define custom rewrite tokens
		$rewrite_tag = '%vem%';		
		// Add the rewrite tokens
		$wp_rewrite->add_rewrite_tag( $rewrite_tag, '(.+?)', 'vem=' );			
		// Define the custom permalink structure
		$rewrite_keywords_structure = $wp_rewrite->root . "%pagename%/$rewrite_tag/";		
		// Generate the rewrite rules
		$new_rule_vem = $wp_rewrite->generate_rewrite_rules( $rewrite_keywords_structure );
		
		//** create new rule "ort" **
		// Define custom rewrite tokens
		$rewrite_tag = '%ort%';		
		// Add the rewrite tokens
		$wp_rewrite->add_rewrite_tag( $rewrite_tag, '(.+?)', 'ort=' );			
		// Define the custom permalink structure
		$rewrite_keywords_structure = $wp_rewrite->root . "%pagename%/$rewrite_tag/";		
		// Generate the rewrite rules
		$new_rule_ort = $wp_rewrite->generate_rewrite_rules( $rewrite_keywords_structure );
	 
		//** add new rules **
		$wp_rewrite->rules = $new_rule_vem + $new_rule_ort + $wp_rewrite->rules;
	
		return $wp_rewrite->rules;
	} // End create_custom_rewrite_rules()
	
	/**
	* add_custom_page_variables()
	* Add the custom token as an allowed query variable.
	* return array $public_query_vars.
	**/
	
	function add_custom_page_variables( $public_query_vars ) {
		$public_query_vars[] = 'vem';
		return $public_query_vars;
	} // End add_custom_page_variables()
	
	/**
	* flush_rewrite_rules()
	* Flush the rewrite rules, which forces the regeneration with new rules.
	* return void.
	**/
	
	function flush_rewrite_rules() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules(); 	
	} // End flush_rewrite_rules()

} // End Class

// Instantiate class.
//$tag_rewrite = new Tag_Rewrite;

// SHOULD WE ENABLE THIS??
//add_action( 'init', array(&$tag_rewrite, 'flush_rewrite_rules') );
//add_action( 'generate_rewrite_rules', array(&$tag_rewrite, 'create_custom_rewrite_rules') );
//add_filter( 'query_vars', array(&$tag_rewrite, 'add_custom_page_variables') ); 


?>