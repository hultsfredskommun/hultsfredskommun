<?php

/** 
 * Description: Echo navigation
 *  */

function hk_breadcrumb() {
	$search = get_query_var("s");
	$cat = get_query_var("cat");

	if (!is_home() ) {
		if ($cat != "")
			echo get_category_parents($cat, TRUE, ' &raquo; ');
	}
	//$categories_list = get_the_category();
	
	/*if (!empty($categories_list)) : foreach ( $categories_list as $list):
		$retValue .= "<a href='".get_category_link($list->term_id)."'>" . $list->name . "</a> | ";
	endforeach; endif; // End if categories
	*/
	/*$tags_list = get_the_terms(get_the_ID(),"post_tag");
	if (!empty($tags_list)) : foreach ( $tags_list as $list):
		$retValue .= "<a href='".get_tag_link($list->term_id)."'>" . $list->name . "</a> | ";
	endforeach; endif; // End if tags
	*/

}

function hk_404() { 
	$options = get_option('hk_theme'); 
	$title = "Hittade du inte den information du s&ouml;kte?";
	$message = "Du kan forts&auml;tta genom att &auml;ndra i ditt urval eller s&ouml;ka fritt i s&ouml;krutan ovan.";
	$message2 = "";
	if ($options["404title"] != "")
		$title = $options["404title"];
	if ($options["404message"] != "")
		$message = $options["404message"];
	if ($options["404message2"] != "")
		$message2 = $options["404message2"];
	?>
		<article id="post-nothing">
			<div class="content-wrapper">
			<div class="summary-content">
				<div class="entry-wrapper">
					<h1 class="entry-title"><?php echo $title; ?></h1>
					<div class="entry-content">
						<p><?php echo $message; ?></p>
						
						<?php if($message2 != "" && function_exists('get_most_viewed')) : ?>
						<p><?php echo $message2; ?></p>
						<ul><?php get_most_viewed('post'); ?></ul>
						<?php endif; ?>
						
					</div>
				</div>
				
			</div><!-- .summary-content -->

			</div>
		</article><!-- #post-0 -->
<?php
}
function hk_empty_navigation() { 
	$options = get_option('hk_theme'); 
	$title = "Hittade du inte den information du s&ouml;kte?";
	$message = "Du kan forts&auml;tta genom att &auml;ndra i ditt urval eller s&ouml;ka fritt i s&ouml;krutan ovan.";
	$message2 = "";
	if ($options["emptytitle"] != "")
		$title = $options["emptytitle"];
	if ($options["emptymessage"] != "")
		$message = $options["emptymessage"];
	if ($options["emptymessage2"] != "")
		$message2 = $options["emptymessage2"];
	?>
		<article id="post-nothing">
			<div class="content-wrapper">
			<div class="summary-content">
				<div class="entry-wrapper">
					<h1 class="entry-title"><?php echo $title; ?></h1>
					<div class="entry-content">
						<p><?php echo $message; ?></p>
						
						<?php if($message2 != "" && function_exists('get_most_viewed')) : ?>
						<p><?php echo $message2; ?></p>
						<ul><?php get_most_viewed('post'); ?></ul>
						<?php endif; ?>
						
					</div>
				</div>
				
			</div><!-- .summary-content -->

			</div>
		</article><!-- #post-0 -->
<?php
}


function hk_navigation() {
	global $post, $default_settings;
	
	$search = get_query_var("s");
	$cat = get_query_var("cat");
	$tags = get_query_var("tag");

	echo "<aside id='nav' class='category-navigation' role='navigation'><nav>";
	if ($search != "") {
		echo "Du s&ouml;kte p&aring; " . $search . ".";
	}
	
	if (is_single()) {
		/* get post first parents */
		$menu_name = "primary";
		$all_categories_object = get_the_category(get_the_ID());
		$all_categories = array();
		foreach ($all_categories_object as $item) { $all_categories[] = $item->cat_ID; }
		$category_hierarchy = hk_get_parent_categories_from_id(get_the_ID(), $menu_name);
		$nav_menu_top_parent = hk_getNavMenuId($category_hierarchy[0], $menu_name);
		$nav_menu_sub_parent = hk_getNavMenuId($category_hierarchy[1], $menu_name);
		$top_parent = $category_hierarchy[0];
		$sub_parent = $category_hierarchy[1];
		$category = $category_hierarchy[2];
		$rest_categories = array();
		if (!empty($all_categories) && !empty($category_hierarchy)) {
			$rest_categories = array_diff($all_categories, $category_hierarchy);
		}
		
		$hk_cat_walker = new hk_Category_Walker();
		$args = array(
			'orderby'            => 'name',
			'order'              => 'ASC',
			'style'              => 'list',
			'hide_empty'         => 0,
			'use_desc_for_title' => 1,
			'child_of'           => $sub_parent,
			'hierarchical'       => true,
			'title_li'           => '',
			'show_option_none'   => '',
			'echo'               => 1,
			'depth'              => 3,
			'taxonomy'           => 'category',
			'walker'			 => $hk_cat_walker,
			'current_category'	 => $category
		);
		//echo "<a class='dropdown-nav'>" . get_the_category_by_ID($category) . "</a>";
		echo "<ul class='parent'>"; 
		wp_list_categories( $args );
		echo "</ul>"; 
		//print_r($all_categories);
		//print_r($category_hierarchy);
		//print_r($rest_categories);
		
		if (!empty($rest_categories)) {
			echo "<ul class='more-navigation'>";
			echo "<li class='heading cat-item current-cat-parent cat-has-children'><a href='#' class='icon-left'><i class='i' data-icon='&#xF09B;'></i></a><a href='#'>Artikeln ing&aring;r &auml;ven i kategorierna</a></li>";
				foreach($rest_categories as $item) {
					$cat = get_term( $item, "category");
					if (!empty($cat)) {
						echo "<li class='cat-item cat-item-" . $cat->term_id . "'><a href='" .
						get_category_link( $cat->term_id ) . "' title='Visa allt om ".
						$cat->name. "'>".
						$cat->name. "</a></li>";
					}
				}
			echo "</ul>"; 
		}
	}


	// if in category
	else if ($cat != "") {

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
			
			//echo "<a class='dropdown-nav'>" . get_the_category_by_ID($parentCat) . "</a>";

			echo "<ul class='parent'>"; 
			$currentcat = '';
			if ($parentCat == $cat) {
				$currentcat = 'current-cat';
			}
			echo "<li class='heading cat-item $currentcat current-cat-parent cat-has-children'><a href='#' class='icon-left'><i class='i' data-icon='&#xF09B;'></i></a><a href='".get_category_link($parentCat)."'>".get_the_category_by_ID($parentCat)."</a></li>";
			wp_list_categories( $args );
			echo "</ul>"; 

			if( function_exists('displayTagFilter') ){
				displayTagFilter();
			}
	
		}
		
	}
	
	
	// if in tag
	else if ($tags != "") {
		//echo "<a class='dropdown-nav'>Etiketter</a>";

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
			'depth'              => 2,
			'taxonomy'           => 'category',
			'exclude'			 => $default_settings["hidden_cat"],
			'walker'			 => $hk_cat_walker
		);
		echo "<ul class='parent'>"; 
		wp_list_categories( $args );
		echo "</ul>";
		
		if( function_exists('displayTagFilter') ){
			displayTagFilter();
		}
	}
	
	echo "&nbsp;</nav></aside>";
}
	

// Walker class: Show which category and tag is selected
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
            $link .= 'title="Visa allt om ' . $cat_name . '"'; 
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
			$haschildclass = "";
			$icon = "";
			if (count(get_term_children($category->term_id,"category")) > 0) {
				$haschildclass = " cat-has-children";
				$icon = "<a href='#' class='icon-left'><i class='i' data-icon='&#xF14C;'></i></a>";
			}
            $output .= "\t<li"; 
            $class = 'cat-item cat-item-'.$category->term_id.$haschildclass; 
            if ( isset($current_category) && $current_category && ($category->term_id == $current_category) ) 
                $class .=  ' current-cat'; 
            elseif ( isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent) ) 
                $class .=  ' current-cat-parent'; 
			elseif ( hk_isParentOf($_current_category->term_id, $category->term_id) ) 
                $class .=  ' current-cat-parent current-cat-grandparent'; 
			
			// other icon if in current-cat
			if (strstr($class,"current-cat")) {
				$icon = str_replace("xF14C","xF14D", $icon);
			}
            $output .=  ' class="'.$class.'"'; 
            $output .= ">$icon$link\n"; 
        } else { 
            $output .= "\t$link<br />\n"; 
        } 
	} 

}

// Walker class: Show which tags available to selected
class hk_Tag_Walker extends Walker_Category {
	function start_el(&$output, $tag, $depth, $args) { 
        extract($args);
		$currtagslug = $tag->slug;
		$tags_filter = get_query_var("tag");
		$term_id = get_query_var("cat");
		$orderby = $_REQUEST["orderby"];
		if ($orderby != "") {
			$orderby = "&orderby=$orderby";
		}
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
		
		// set new tag filter
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
		
		// generate tag link
        $cat_name = esc_attr( $tag->name); 
		$href = get_category_link( $term_id ) . $tags_filter. $orderby;

        $link = '<a href="' . $href  . '" '; 
        $cat_name = apply_filters( 'list_cats', $cat_name, $tag ); 
        if ( $use_desc_for_title == 0 || empty($tag->description) ) 
            $link .= 'title="Filtrera med nyckelordet ' .  $cat_name . '"'; 
        else 
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $tag->description, $tag ) ) ) . '"'; 
        $link .= '>'; 
        $link .= $cat_name . '</a>'; 
		
		// if feed
        if ( (! empty($feed_image)) || (! empty($feed)) ) { 
            $link .= ' '; 
            if ( empty($feed_image) ) 
                $link .= '('; 
			$href = get_category_feed_link($term_id, $feed_type) . $tags_filter . $orderby;
            $link .= '<a href="' . $href . '"'; 
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

		// show count
        if ( isset($show_count) && $show_count ) 
            $link .= ' (' . intval($tag->count) . ')'; 
		// show date
        if ( isset($show_date) && $show_date ) { 
            $link .= ' ' . gmdate('Y-m-d', $tag->last_update_timestamp); 
        } 
		

		if ( 'list' == $args['style'] ) { 
			$output .= "\t<li"; 
			$class = 'tag-item tag-item-'.$tag->term_id; 
			$icon = "";
			if ($current_tag) {
				$class .=  ' current-tag'; 
				$icon = "<a href='$href' class='icon-left'><i class='i' data-icon='&#xF14E;'></i></a>";
			}
			$output .=  ' class="'.$class.'"'; 
			$output .= ">$icon$link</li>\n"; 
		} else { 
			$output .= "\t$link\n"; 
		} 

	} 

}


// show tag filter list
function displayTagFilter($show_title = true) {
	global $default_settings;
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

		echo "<ul class='more-navigation'>"; 
		if ($show_title) {
			echo "<li class='heading cat-item'><a href='#' class='icon-left'><i class='i' data-icon='&#xF0AD;'></i></a><a href='#'>Typ av information</a></li>";
		}
		wp_list_categories( $args );
		echo "</ul>";
	endif;
}


?>