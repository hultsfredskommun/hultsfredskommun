<?php

/** 
 * Description: Add Menu widget and remove Menu category from loop
 *  */

/* WIDGET */
class HK_Menu_Widget extends WP_Widget {

        public function __construct() {
		parent::__construct(
	 		'hk_menu_widget', // Base ID
			'Hk_Menu_Widget', // Name
			array( 'description' => __( 'Menu Widget to display menus from relevant categories', 'text_domain' ), ) // Args
		);
	}

 	public function form( $instance ) {
		// outputs the options form on admin
		if ( isset( $instance[ 'category' ] ) ) {
			$title = $instance[ 'category' ];
		}
		else {
			$title = "";
		}
		?>
		<p>
		<p><?php _e( 'No function added to this setting!' ); ?></p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php //_e( 'Menu category:' ); ?></label> 
		</p>
		<?php 
		$args = array(
			'orderby'            => 'ID', 
			'order'              => 'ASC',
			'echo'               => 1,
			'selected'           => esc_attr( $title ),
			'hierarchical'       => 1, 
			'show_option_none'   => "Visa underkategorier",
			'name'               => $this->get_field_name( 'category' ),
			'id'                 => $this->get_field_id( 'category' ),
			'depth'              => 0,
			'taxonomy'           => 'category',
			'show_count'           => true,
			'hide_empty'      => false,
			'hide_if_empty'      => false );  
			//wp_dropdown_categories( $args ); 

	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		$instance = array();
		$instance['category'] = strip_tags( $new_instance['category'] );

		// set option
		$option_name = 'hk_menu_category';
		$newvalue = $instance['category'];

		if ( get_option( $option_name ) != $newvalue ) 
		{
			update_option( $option_name, $newvalue );
		} 
		else 
		{
			$deprecated = ' ';
	    	$autoload = 'no';
			add_option( $option_name, $newvalue, $deprecated, $autoload );
		}
		return $instance;
	}

	public function widget( $args, $instance ) {
	    global $post;
	    extract( $args );
		echo "<aside id='nav'><nav>";
		if (is_single())
		{
			$this->hk_single_page_menu();
		}
		else {
			echo '<div id="selected">';
				$this->hk_selected();
			echo '</div>';
			echo '<div id="filters">';
				$this->hk_tag_filters();
			echo '</div>';
		}
		//echo "<div style='clear:both;'>&nbsp;</div>";
		echo "</nav></aside>";
	}


	function hk_single_page_menu() {
		echo "En sida är vald.";
	}



	/* echo the tags and categories that currently are selected */
	function hk_selected() {

		$search = get_query_var("s");
		$cat = get_query_var("cat");
		$tags = get_query_var("tag");
		$vem_tags = get_query_var("vem");
		$ort_tags = get_query_var("ort");
		
		
		// check if any tag or cat is set
		if ($cat != "" || $tags != "" || $ort_tags != "" || $vem_tags != "" || $search != "") :

			// javascript to be used for dynamic effects
			?>
			<script type="text/javascript">
				(function($) {
					$(document).ready(function(){
				
					});
				})(jQuery);
			</script>
			<span class='heading'>Du har valt:</span>
					
			<ul id="selected_filter">
			<?php 

			// initialize caturl
			if ($cat != "")
				$caturl = get_category_link( $value->parent );
			else
				$caturl = get_bloginfo("wpurl");

			$selected_array = array();

	    	// show selected search
	    	if ($search != "") {
				$taglink= "?tag=" . $tags;
				$vemlink= "&vem=" . $vem_tags;
				$ortlink= "&ort=" . $ort_tags;
				$selected_array[] = array("name" => "S&ouml;k: $search", "url" => $caturl . $taglink . $vemlink . $ortlink, "noselect" => "", "tag" => "search" );
			}

			// show selected categories
			if ($cat != "") {
				
				// get category parents
				$parents = $this->hk_getParents($cat);

				// init tag links
				$taglink= "?tag=" . $tags;
				$vemlink= "&vem=" . $vem_tags;
				$ortlink= "&ort=" . $ort_tags;
				
				// add category parents to selected_array set noselect if there are a selected child
				if (count($parents) > 0) {
					$prev_parent = $parents[0]->parent;
					$parent_count = 1;

					foreach ($parents as $value) {
						if (count($parents) == $parent_count) {
							if ($value->parent != 0)
								$parent_link = get_category_link( $value->parent );
							else
								$parent_link = get_bloginfo("wpurl");

							$selected_array[] = array("name" => $value->name, "url" => $parent_link . $taglink . $vemlink . $ortlink, "noselect" => "", "tag" => "cat" );
							
						}
						else {
							$selected_array[] = array("name" => $value->name, "url" => "", "noselect" => "noselect", "tag" => "cat" );
						}
						$parent_count++;
					}
				}
	        }

	        // get selected tags and add to selected_array
	    	$tag_array = array("tag","vem","ort");
	    	$tags = array();

	    	// show selected tags
	    	foreach ($tag_array as $tag) {
	    		// reset tags array
				$tags["tag"] = get_query_var("tag");
				$tags["vem"] = get_query_var("vem");
				$tags["ort"] = get_query_var("ort");

				// check if some tags selected
				if ($tags[$tag] != "") {
					$selected_tags = explode(",", $tags[$tag]);
					foreach ($selected_tags as $value) {
						// add name and url to remove the $value tag
						$tags[$tag] = get_query_var($tag);
						$tags[$tag] = str_replace($value, "", $tags[$tag]);
						$tags[$tag] = str_replace(",,",",",trim($tags[$tag],","));
						$taglink= "?tag=" . $tags["tag"];
						$vemlink= "&vem=" . $tags["vem"];
						$ortlink= "&ort=" . $tags["ort"];
						$searchlink= "&s=" . $search;
						$selected_array[] = array("name" => $value, "url" => $caturl . $taglink . $vemlink . $ortlink . $searchlink, "noselect" => "", "tag" => $tag );
					}
				}
			}


			// print selected_array
			$selected_ids = array();
			if (count($selected_array) == 1)
			{
				echo "<li class='noselect " . $selected_array[0]["tag"] . "'><a>" . $selected_array[0]["name"] . "</a></li>";
			}
			else if (count($selected_array) > 0) {
				foreach ($selected_array as $value) {
					echo "<li class='" . $value["noselect"] . " " . $value["tag"] . "'><a href='" . $value["url"] . "'>" . $value["name"] . "</a></li>";
				}
			}
			?>
			</ul>
				
		<?php endif; 
	}


	/* echo the tags and categories that are available to filter result */
	function hk_tag_filters() {
		$search = get_query_var("s");
		$cat = get_query_var("cat");
		// initialize caturl
		if ($cat != "")
			$caturl = get_category_link( $cat );
		else
			$caturl = get_bloginfo("wpurl");

		// get category parents slug array to check if cat is selected
		$cat_slug_array = array();
		if ($cat != "") {
			foreach ($this->hk_getParents($cat) as $value) {
				$cat_slug_array[] = $value->slug;
			}
		}
		$tags = get_query_var("tag");
		$vem_tags = get_query_var("vem");
		$ort_tags = get_query_var("ort");

		$var = array(	"category" => $cat,
						"post_tag" => $tags,
						"vem" => $vem_tags,
						"ort" => $ort_tags);
		$link = $var;

		// set tag headings
		//$tag_heading = array('category' => "Kategorier", 'post_tag' => "Vad vill du", "vem" => "Vem är du", "ort" => "Ort" );
		
		// get an array with the current tags used as filter
		$tag_clouds = $this->hk_helper_get_tag_filters(array("category","post_tag","vem","ort"));

		// get one taxonomy at the time tag_key contain the slug, tag_cloud contain the cloud-array 
		$hasFilters = false; ?>
		<span class='heading heading-bg'>Visa bara</span>
		
		<?php
		foreach ($tag_clouds as $tag_key => $tag_cloud) {
			// set selected tags array
			if ($tag_key != "category")
				$selected_tags = explode(",", $var[$tag_key]);
			else
				$selected_tags = $cat_slug_array;

			// trim selected from tag cloud
			$set_tags = array();
			foreach ($tag_cloud as $key => $value) {
				if (!in_array($key, $selected_tags))
				{
					$set_tags[$key] = $value; 
				}
			}
			$tag_cloud = $set_tags;
			
			// echo the tags that are left in the array
			if (count($tag_cloud) > 0) : ?>
				<!--span class='heading'><?php echo $tag_heading[$tag_key]; ?> &raquo;</span-->
				<?php if ($hasFilters) : ?> 
				<hr>
				<?php endif; ?>
				<ul class="<?php echo $tag_key; ?>">
				<?php foreach ($tag_cloud as $key => $value) {
					$hasFilters = true;
					if ($var[$tag_key] == "") {
						$link[$tag_key] = $key;
					}
					else {
						$link[$tag_key] = $var[$tag_key].",".$key;
					}
					$curr_caturl = $caturl;
					
					if ($tag_key == "category")
						$curr_caturl = get_category_link(get_cat_ID($value));
					
					echo "<li><a class='$selected' href='" . $curr_caturl . 
					"?tag=" . $link["post_tag"] .
					"&vem=" . $link["vem"] . 
					"&ort=" . $link["ort"] .
					"&s=" . $search . 
					"'>" . $value . "</a></li> ";

					$link[$tag_key] = $var[$tag_key];
				} ?>
		        
		        </ul>
			<?php 
			endif; 
		}
		if (!$hasFilters) {
			echo "<ul><li>Hittade inga fler filter</li></ul>";
		}
	}


	/* related tags to selected taxonomy in selected category */
	function hk_helper_get_tag_filters($taxonomies) { 
		/* get request variables */
		$search = get_query_var("s");
		$cat = get_query_var("cat");
		$tags = get_query_var("tag");
		$tag_array = "";
		if ($tags != "")
			$tag_array = split(",", $tags);
		$vem_tags = get_query_var("vem");
		$vem_array = array();
		if ($vem_tags != "")
			$vem_array = split(",", $vem_tags);
		$ort_tags = get_query_var("ort");
		$ort_array = array();
		if ($ort_tags != "")
			$ort_array = split(",", $ort_tags);

		// init arrays
		$tags_arr = array();
		$all_tags_arr = array();

		/* get the id of the selected categories children */
		$cat_children = get_categories('child_of='.$cat);
		$cat_array = array($cat);
		foreach ($cat_children as $child) {
			$cat_array[] = $child->term_id;
		}

		// check for all taxonomies in this query
		$query = array( 'category__in' => $cat_array,
					 	'tag_slug__in' => $tag_array,
						
					 	'posts_per_page' => '-1');

		if ($search != "")
			$query["s"] = $search;

		if (count($vem_array) > 0 && count($ort_array) > 0) {
			$query['tax_query'] = array(
				'relation' => 'AND',
				array(
					'taxonomy' => 'vem',
					'field' => 'slug',
					'terms' => $vem_array )
				,
				array(
					'taxonomy' => 'ort',
					'field' => 'slug',
					'terms' => $ort_array
				)
			);
		}						 	
		else if (count($vem_array) > 0) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'vem',
					'field' => 'slug',
					'terms' => $vem_array )
			);
		}						 	
		else if (count($ort_array) > 0) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'ort',
					'field' => 'slug',
					'terms' => $ort_array )
			);
		}


		// loop all posts to get all taxonomies used 
		$wpq = new WP_Query($query);
		if ($wpq->have_posts()) : while ($wpq->have_posts()) : $wpq->the_post();
			if ($taxonomies) : foreach ($taxonomies as $taxonomy) {
			    $posttags = wp_get_post_terms(get_the_ID(),$taxonomy);
				if ($posttags) : foreach($posttags as $tag) {
					// only show categories that are children to selected category
					if ($taxonomy != "category" || $this->hk_childHasParent($tag->term_id, $cat)) :
						//USING JUST $tag MAKING $all_tags_arr A MULTI-DIMENSIONAL ARRAY, WHICH DOES WORK WITH array_unique
						$all_tags_arr[$taxonomy][$tag -> slug] = $tag -> name; 
					endif;
				} endif;
			} endif;
		endwhile; endif;

		if ($taxonomies) : foreach ($taxonomies as $taxonomy) {
			//REMOVES DUPLICATES
			$tags_arr[$taxonomy] = array_unique($all_tags_arr[$taxonomy]); 
		} endif;
		
		return $tags_arr;

	}


	// check if category $child is a child of category $parent
	function hk_childHasParent($child, $parent) {
		$i = 0;
		do {
			$i++;
			$args = array(
				'type'                     => 'post',
				'include'                  => $child,
				'taxonomy'                 => 'category' );
			$getparent = get_categories( $args );

			// return true if parent is found
			if ($parent == $getparent[0]->parent)
				return true;
			// else get next parent
			$child = $getparent[0]->parent;
			
		} while($child != "0" && $i < 10);
		
		return false;
	}

	function hk_getParents($child) {
		$parent_array = array();
		$i = 0;
		do {
			$i++;
			$args = array(
				'type'                     => 'post',
				'include'                  => $child,
				'taxonomy'                 => 'category' );
			$getparent = get_categories( $args );
			$parent_array[] = $getparent[0];
			$child = $getparent[0]->parent;
		} while($child != "0" && $i < 10);
		//invert parent order
		krsort($parent_array);
		return $parent_array;
	}
}

add_action( 'widgets_init', create_function( '', 'register_widget( "Hk_Menu_Widget" );' ) );





/* REGISTER SETTING hk_menu_category */
add_action('admin_init', hk_menu_settings_init);
function hk_menu_settings_init() {
//	 register_setting( 'hk_menu_category', 'hk_menu_category');
}



/* Create a new taxonomy for extra */
function extra_tag_init() {
	register_taxonomy(
		'vem',
		'post',
	 	array(
			'hierarchical' => false,
			'label' => __( 'Vem' ),
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'vem' )
		)
	);
	register_taxonomy(
		'ort',
		'post',
	 	array(
			'hierarchical' => false,
			'label' => __( 'Var' ),
			'sort' => true,
			'args' => array( 'orderby' => 'term_order' ),
			'rewrite' => array( 'slug' => 'ort' )
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
$tag_rewrite = new Tag_Rewrite;

// SHOULD WE ENABLE THIS??
//add_action( 'init', array(&$tag_rewrite, 'flush_rewrite_rules') );
//add_action( 'generate_rewrite_rules', array(&$tag_rewrite, 'create_custom_rewrite_rules') );
//add_filter( 'query_vars', array(&$tag_rewrite, 'add_custom_page_variables') ); 
?>