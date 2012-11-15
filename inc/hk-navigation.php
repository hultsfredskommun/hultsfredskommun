<?php

/** 
 * Description: Echo navigation
 *  */

function hk_breadcrumb() {
	$search = get_query_var("s");
	
	$categories_list = get_the_category();
	$retValue = "";
/*	if (!empty($categories_list)) : foreach ( $categories_list as $list):
		$retValue .= "<a href='".get_category_link($list->term_id)."'>" . $list->name . "</a> | ";
	endforeach; endif; // End if categories

	$tags_list = get_the_terms(get_the_ID(),"post_tag");
	if (!empty($tags_list)) : foreach ( $tags_list as $list):
		$retValue .= "<a href='".get_tag_link($list->term_id)."'>" . $list->name . "</a> | ";
	endforeach; endif; // End if tags
*/
	echo rtrim($retValue," |");
}
function hk_navigation() {
	global $post, $default_settings;
	
	$search = get_query_var("s");
	$cat = get_query_var("cat");
	$tags = get_query_var("tag");

	echo "<aside id='nav'><nav>";
	if ($search != "") {
		echo "Du s&ouml;kte p&aring; " . $search . ".";
	}

	// if in tag and no category
	if ($tags != "" && $cat == "") {
		$hk_cat_walker = new hk_Category_Walker();
		$parentCat = hk_getMenuParent($cat);
		$args = array(
			'orderby'            => 'name',
			'order'              => 'ASC',
			'style'              => 'list',
			'hide_empty'         => 0,
			'use_desc_for_title' => 1,
			'hierarchical'       => true,
			'title_li'           => '',
			'show_option_none'   => '',
			'echo'               => 1,
			'depth'              => 2,
			'taxonomy'           => 'category',
			'exclude'			 => $default_settings["hidden_cat"],
			'walker'			 => $hk_cat_walker
		);
		echo "<ul>"; 
		wp_list_categories( $args );
		echo "</ul>";
	}

	// if in category
	if ($cat != "") {

		if (is_sub_category()) {
			$children =  get_categories(array('child_of' => $cat, 'hide_empty' => false));
			$currentparent = $cat;
			
			$hk_cat_walker = new hk_Category_Walker();
			$parentCat = hk_getMenuParent($cat);
			$args = array(
				'orderby'            => 'name',
				'order'              => 'ASC',
				'style'              => 'list',
				'hide_empty'         => 0,
				'use_desc_for_title' => 1,
				'child_of'           => $parentCat,
				'hierarchical'       => true,
				'title_li'           => '',
				'show_option_none'   => '',
				'echo'               => 1,
				'depth'              => 3,
				'taxonomy'           => 'category',
				'walker'			 => $hk_cat_walker
			);
			echo "<ul class='parent'>"; 
			wp_list_categories( $args );
			echo "</ul>"; 

			if ($default_settings["show_tags"] != 0) :

			$hk_tag_walker = new hk_Tag_Walker();
			$args = array(
				'orderby'            => 'name',
				'order'              => 'ASC',
				'style'              => 'list',
				'hide_empty'         => 0,
				'use_desc_for_title' => 1,
				'title_li'           => '',
				'show_option_none'   => '',
				'echo'               => 1,
				'taxonomy'           => 'post_tag',
				'walker'			 => $hk_tag_walker
			);
		
			echo "<ul class='tags'>"; 
			wp_list_categories( $args );
			echo "</ul>";
			
			endif;
		}
	}
	
	if (is_single())
	{
		echo '<div id="selected"><ul id="selected_filter">';
		$categories_list = get_the_category();
		$pre_parent = 0;
		if (!empty($categories_list)) : foreach ( $categories_list as $list):
			if ($pre_parent == $list->category_parent) { $class = "children"; }
			else { $class = "";}
			echo "<li class='link cat $class'>";
				echo "<a href='".get_category_link($list->term_id)."'>" . $list->name . "</a>";
			echo "</li>";
			$pre_parent = $list->term_id;
		endforeach; endif; // End if categories

		$tags_list = get_the_terms(get_the_ID(),"post_tag");
		if (!empty($tags_list)) : foreach ( $tags_list as $list):
			echo "<li class='link tag'><a href='".get_tag_link($list->term_id)."'>" . $list->name . "</a></li>";
		endforeach; endif; // End if tags
	
		echo "</ul></div>";
	}
	echo "</nav></aside>";
}
	

// Show which category and tag is selected
class hk_Category_Walker extends Walker_Category {
	function start_el(&$output, $category, $depth, $args) { 
        extract($args); 
		$tags_filter = get_query_var("tag");
		if (!empty($tags_filter)) {
			$tags_filter = "?tag=$tags_filter";
		}
        $cat_name = esc_attr( $category->name); 
        $link = '<a href="' . get_category_link( $category->term_id ) . $tags_filter . '" '; 
        $cat_name = apply_filters( 'list_cats', $cat_name, $category ); 
        if ( $use_desc_for_title == 0 || empty($category->description) ) 
            $link .= 'title="' . sprintf(__( 'View all posts filed under %s' ), $cat_name) . '"'; 
        else 
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"'; 
        $link .= '>'; 

        $link .= $cat_name . '</a>'; 
        if ( (! empty($feed_image)) || (! empty($feed)) ) { 
            $link .= ' '; 
            if ( empty($feed_image) ) 
                $link .= '('; 
            $link .= '<a href="' . get_category_feed_link($category->term_id, $feed_type) . $tags_filter . '"'; 
            if ( empty($feed) ) 
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"'; 
            else { 
                $title = ' title="' . $feed . '"'; 
                $alt = ' alt="' . $feed . '"'; 
                $name = $feed; 
                $link .= $title; 
            } 

            $link .= '>'; 
            if ( empty($feed_image) ) 
                $link .= $name; 
            else 
                $link .= "<img src='$feed_image'$alt$title" . ' />'; 
            $link .= '</a>'; 
            if ( empty($feed_image) ) 
                $link .= ')'; 
        } 

        if ( isset($show_count) && $show_count ) 
            $link .= ' (' . intval($category->count) . ')'; 
 
        if ( isset($show_date) && $show_date ) { 
            $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp); 
        } 

        if ( isset($current_category) && $current_category ) 
            $_current_category = get_category( $current_category ); 

        if ( 'list' == $args['style'] ) { 
            $output .= "\t<li"; 
            $class = 'cat-item cat-item-'.$category->term_id; 
            if ( isset($current_category) && $current_category && ($category->term_id == $current_category) ) 
                $class .=  ' current-cat'; 
            elseif ( isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent) ) 
                $class .=  ' current-cat-parent'; 
            $output .=  ' class="'.$class.'"'; 
            $output .= ">$link\n"; 
        } else { 
            $output .= "\t$link<br />\n"; 
        } 
	} 

}
class hk_Tag_Walker extends Walker_Category {
	function start_el(&$output, $tag, $depth, $args) { 
        extract($args);
		$currtagslug = $tag->slug;
		$tags_filter = get_query_var("tag");
		$term_id = get_query_var("cat");

		if (!empty($tags_filter))
			$tag_array = explode(",",$tags_filter);
		
		// check if tag i selected, 
		if(!empty($tag_array) && in_array($currtagslug, $tag_array)) {
			$current_tag = true;
			$tag_array = array_values(array_diff($tag_array, array($currtagslug)));
		}
		else { 
			$tag_array[] = $currtagslug;
		}

		if (count($tag_array) == 1) {
			$tags_filter = $tag_array[0];
		}
		else if (count($tag_array) > 1) {
			$tags_filter = implode(",",$tag_array);
		}
		else {
			$tags_filter = "";
		}

		if (!empty($tags_filter)) {
			$tags_filter = "?tag=" . $tags_filter;
		}
		else {
			$tags_filter = "?tag=";
		}
        $cat_name = esc_attr( $tag->name); 
        $link = '<a href="' . get_category_link( $term_id ) . $tags_filter . '" '; 
        $cat_name = apply_filters( 'list_cats', $cat_name, $tag ); 
        if ( $use_desc_for_title == 0 || empty($tag->description) ) 
            $link .= 'title="Filtrera med nyckelordet ' .  $cat_name . '"'; 
        else 
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $tag->description, $tag ) ) ) . '"'; 
        $link .= '>'; 

        $link .= $cat_name . '</a>'; 
        if ( (! empty($feed_image)) || (! empty($feed)) ) { 
            $link .= ' '; 
            if ( empty($feed_image) ) 
                $link .= '('; 
            $link .= '<a href="' . get_category_feed_link($term_id, $feed_type) . $tags_filter . '"'; 
            if ( empty($feed) ) 
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"'; 
            else { 
                $title = ' title="' . $feed . '"'; 
                $alt = ' alt="' . $feed . '"'; 
                $name = $feed; 
                $link .= $title; 
            } 

            $link .= '>'; 
            if ( empty($feed_image) ) 
                $link .= $name; 
            else 
                $link .= "<img src='$feed_image'$alt$title" . ' />'; 
            $link .= '</a>'; 
            if ( empty($feed_image) ) 
                $link .= ')'; 
        } 

        if ( isset($show_count) && $show_count ) 
            $link .= ' (' . intval($tag->count) . ')'; 
 
        if ( isset($show_date) && $show_date ) { 
            $link .= ' ' . gmdate('Y-m-d', $tag->last_update_timestamp); 
        } 

        if ( 'list' == $args['style'] ) { 
			$output .= "\t<li"; 
            $class = 'tag-item tag-item-'.$tag->term_id; 
			
            if ( isset($current_tag) && $current_tag && ($tag->term_id == $current_tag) ) 
                $class .=  ' current-tag'; 
            $output .=  ' class="'.$class.'"'; 
            $output .= ">$link\n"; 
        } else { 
            $output .= "\t$link<br />\n"; 
        } 
	} 

}
?>