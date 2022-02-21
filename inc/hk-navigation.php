<?php


/**
 * Description: Echo post count
 *  */

function hk_postcount() {
	global $wp_query, $paged, $default_settings;
	if ($wp_query->post_count > 1 || $wp_query->max_num_pages > 1) {

		if ($wp_query->max_num_pages > $paged && $wp_query->max_num_pages > 1) {
			$url = next_posts(0,false);
			$class = "";
		}
		else {
			$url = "";
			$class = "nolink";
		}
		if ($default_settings["hide_articles_in_subsubcat"] != 1  || !is_sub_sub_category_firstpage()) :
			echo "<span class='postcount $class float--right' href='$url'>Visar <span class='count'>" . $wp_query->post_count . "</span>";
			if ($wp_query->max_num_pages > 1) {
				echo " av " . $wp_query->found_posts;
			}
			if ($wp_query->post_count <= 1 && $wp_query->max_num_pages == 1)
				echo " artikel";
			else
				echo " artiklar";
			if ($wp_query->max_num_pages > 1) {
				if ($paged == 0) { $p = 1; } else { $p = $paged; }
				echo "<span class='pagecountinfo'> | Sida " . $p . " av " . $wp_query->max_num_pages . "</span>";
			}
			echo "</span>";
		endif;
	}
}


/**
 * Description: Echo navigation
 **/

function hk_breadcrumb() {
	global $default_settings;
	if ($default_settings["category_as_filter"]) {
		return;
	}
	$search = get_query_var("s");
	$cat = get_query_var("cat");
	$tag = get_query_var("tag");

	if (!is_home() ) {
		if ($cat != "") {
			$cats_str = get_category_parents($cat, false, '%#%', true);
			$cats_array = explode('%#%', $cats_str);
			$tag_link = "";
			if ($tag != "") {
				$tag_link = "?tag=".$tag;
				echo "<a href='" . get_site_url() . $tag_link . "'>Hela webbplatsen</a> &raquo; ";
			}
			foreach  ($cats_array as $c) {
				if ($c != "") {
					$c = get_category_by_slug($c);
					if ($c instanceof WP_Term) {
						echo "<a href='" . get_category_link($c->term_id) . $tag_link . "'>" . $c->name . "</a> &raquo; ";
					}
				}
			}
			//echo get_category_parents($cat, TRUE, ' &raquo; ');
		}
		else {
			if ($tag != "") {
				$tag_link = "?tag=".$tag;
				echo "<a href='" . get_site_url() . $tag_link . "'>Hela webbplatsen</a> &raquo; ";
			}

		}
		/*if ($tag != "") {
			echo '<br>Typ av information: ';
			foreach (explode(',',$tag) as $t) {
				$t = get_term_by( 'slug', $t, 'post_tag');
				echo "<a href='" . get_tag_link($t->term_id) . "'>" . $t->name . "</a> | ";
			}
			echo "<a class='important-text' href='" . get_category_link($cat) . "'>Rensa alla</a>";
		}*/
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
function hk_empty_search() {
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
function hk_empty_navigation() {
	$options = get_option('hk_theme');
	$title = "H&auml;r finns inga artiklar.";
	$message = "Du kan forts&auml;tta genom att v&auml;lja en underkategori eller s&ouml;ka fritt i s&ouml;krutan ovan.";
	$message2 = "";
	$message3 = "";
	if ($options["emptycattitle"] != "")
		$title = $options["emptycattitle"];
	if ($options["emptycatmessage"] != "")
		$message = $options["emptycatmessage"];
	if ($options["emptycatmessage2"] != "")
		$message2 = $options["emptycatmessage2"];
	if ($options["emptycatmessage3"] != "")
		$message3 = $options["emptycatmessage3"];
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

						<?php if($message3 != "" && get_query_var("cat") != "") : ?>
						<p><?php echo $message3; ?></p>
						<ul><?php wp_list_categories(array(
										'title_li' => "", 'child_of' => get_query_var("cat"))); ?></ul>
						<?php endif; ?>

					</div>
				</div>

			</div><!-- .summary-content -->

			</div>
		</article><!-- #post-0 -->
<?php
}



function hk_mobile_navmenu_navigation($menu_name, $cat, $menu_class, $mainmenu_class) {
	global $args, $hk_options, $default_settings;

	// get nav_menu_parent id
	if (is_single()) {
		$category_hierarchy = hk_get_parent_categories_from_id(get_the_ID(), $menu_name);
	} else if ($cat != "") {
		$category_hierarchy = hk_get_parent_categories_from_cat($cat);
	}

	$nav_menu_top_parent = (!empty($category_hierarchy[0]))?hk_getNavMenuId($category_hierarchy[0], $menu_name):'';
	$nav_menu_sub_parent = (!empty($category_hierarchy[1]))?hk_getNavMenuId($category_hierarchy[1], $menu_name):'';
	$top_parent = (!empty($category_hierarchy[0]))?$category_hierarchy[0]:'';
	$sub_parent = (!empty($category_hierarchy[1]))?$category_hierarchy[1]:'';
	$category = (!empty($category_hierarchy[2]))?$category_hierarchy[2]:'';

	if (!(($locations = get_nav_menu_locations()) && isset( $locations[$menu_name] ) && $locations[$menu_name] > 0 )) {
		return;
	}

	/* TOP MENU */
	$newtopwalker = new hk_newtopmenu_walker_nav_menu();
	echo "<ul class='hultsfred-menu $menu_class'>";
    /* show top level selection */
    echo "<li class='toplevelselect'><a class='js-expand-who'>Vem &auml;r du? <i>".get_cat_name($top_parent)."</i></a><ul>";
    $args = array(
		'theme_location'	=> $menu_name,
		'container' 		=> '',
		'items_wrap' 		=> '%3$s',
		'before' 			=> '',
		'after'				=> '',
		'depth' 			=> 1, //$default_settings['num_levels_in_menu'],
		'echo' 				=> true,
		'walker'			=> $newtopwalker,
		'current_category'  => $top_parent
	);
    wp_nav_menu( $args );
    echo "</ul></li>";
    /* end top level selection */
    $args = array(
		'theme_location'	=> $menu_name,
		'container' 		=> '',
		'items_wrap' 		=> '%3$s',
		'before' 			=> '',
		'after'				=> '',
		'depth' 			=> 3, //$default_settings['num_levels_in_menu'],
		'echo' 				=> true,
		'walker'			=> $newtopwalker
	);
	if ($top_parent > 0) {
		$args["current_category"] = $top_parent;
	}

	wp_nav_menu( $args );
	echo "</ul>";

	$parent = hk_getParent($cat);

	$top_name = get_cat_name($top_parent);
	$sub_name = get_cat_name($sub_parent);
	$cat_name = get_cat_name($category);
	if ($sub_name == $cat_name)
		$cat_name = "";
	if ($top_name == $sub_name)
		$sub_name = "";

	if ($cat_name != "")
		$cat_title = $cat_name;
	if ($sub_name != "")
		$sub_title = $sub_name;
	else if ($top_name != "")
		$sub_title = $top_name;
	else if (get_query_var("s") != "")
		$sub_title = "Du s&ouml;kte p&aring; " . get_query_var("s");
	else
		$sub_title = "";



	/*
	REMOVED OLD SUB-MENU
	echo "<div class='responsive-sub-menu $menu_class'>";
	if ($sub_parent > 0 && $parent > 0) {
		//echo "<a class='menu-up' href='" . get_category_link($parent) . "'><span class='menu-icon up'></span></a>";
	}

	echo "<a class='js-show-main-sub-menu menu'><span class='menu-icon'></span>";
	echo "<span class='title'>Meny</span>";//<span class='dropdown-icon'></span>";

	echo "</a>";
	echo "</div>";

	if ($nav_menu_sub_parent > 0) {

		if ($default_settings['num_levels_in_menu'] > 1) {
			echo "<ul class='main-sub-menu $menu_class $mainmenu_class'>";
			$submenu = new hk_submenu_walker_nav_menu();
			$args = array(
				'theme_location'	=> $menu_name,
				'container' 		=> '',
				'items_wrap' 		=> '%3$s',
				'before' 			=> '',
				'after'				=> '',
				'depth' 			=> $default_settings['num_levels_in_menu'],
				'echo' 				=> true,
				'walker'			=> $submenu,
				'nav_menu_parent'	=> $nav_menu_top_parent
			);

			if ($sub_parent > 0) {
				$args["current_category"] = $sub_parent;
			}
			wp_nav_menu( $args );
			if ( is_active_sidebar( 'right-main-sub-menu-item-sidebar' ) ) {
				dynamic_sidebar( 'right-main-sub-menu-item-sidebar' );
			}
			echo "</ul>";
		}
	}
	else {
		echo "<ul class='main-sub-menu'><li class='menu-item one-whole'><a>&nbsp;</a></li></ul>";
	}
	*/

}
function hk_navmenu_old_navigation($menu_name, $cat, $menu_class) {
	global $args, $hk_options, $default_settings;

	// get nav_menu_parent id
	if (is_single()) {
		$category_hierarchy = hk_get_parent_categories_from_id(get_the_ID(), $menu_name);
	} else if ($cat != "") {
		$category_hierarchy = hk_get_parent_categories_from_cat($cat);
	}

	$nav_menu_top_parent = (!empty($category_hierarchy[0]))?hk_getNavMenuId($category_hierarchy[0], $menu_name):'';
	$nav_menu_sub_parent = (!empty($category_hierarchy[1]))?hk_getNavMenuId($category_hierarchy[1], $menu_name):'';
	$top_parent = (!empty($category_hierarchy[0]))?$category_hierarchy[0]:'';
	$sub_parent = (!empty($category_hierarchy[1]))?$category_hierarchy[1]:'';
	$category = (!empty($category_hierarchy[2]))?$category_hierarchy[2]:'';

	if (!(($locations = get_nav_menu_locations()) && isset( $locations[$menu_name] ) && $locations[$menu_name] > 0 )) {
		return;
	}


	$topwalker = new hk_topmenu_walker_nav_menu();
	$args = array(
		'theme_location'	=> $menu_name,
		'container' 		=> '',
		'items_wrap' 		=> '%3$s',
		'before' 			=> '',
		'after'				=> '',
		'depth' 			=> 1, //$default_settings['num_levels_in_menu'],
		'echo' 				=> true,
		'walker'			=> $topwalker
	);
	if ($top_parent > 0) {
		$args["current_category"] = $top_parent;
	}

	echo "<ul class='main-menu $menu_class'>";
	wp_nav_menu( $args );
	echo "</ul>";

	echo "<div class='responsive-sub-menu $menu_class'>";
	$parent = hk_getParent($cat);

	$top_name = get_cat_name($top_parent);
	$sub_name = get_cat_name($sub_parent);
	$cat_name = get_cat_name($category);
	if ($sub_name == $cat_name)
		$cat_name = "";
	if ($top_name == $sub_name)
		$sub_name = "";

	if ($cat_name != "")
		$cat_title = $cat_name;
	if ($sub_name != "")
		$sub_title = $sub_name;
	else if ($top_name != "")
		$sub_title = $top_name;
	else if (get_query_var("s") != "")
		$sub_title = "Du s&ouml;kte p&aring; " . get_query_var("s");
	else
		$sub_title = "";

	if ($sub_parent > 0 && $parent > 0) {
		echo "<a class='menu-up' href='" . get_category_link($parent) . "'><span class='menu-icon up'></span></a>";
	}

	echo "<a class='js-show-main-sub-menu menu'><span class='menu-icon'></span>";
	echo "<span class='title'>Meny</span>";//<span class='dropdown-icon'></span>";

	echo "</a>";
	echo "</div>";

	if ($nav_menu_sub_parent > 0) {

		if ($default_settings['num_levels_in_menu'] > 1) {
			echo "<ul class='main-sub-menu $menu_class'>";
			$submenu = new hk_submenu_walker_nav_menu();
			$args = array(
				'theme_location'	=> $menu_name,
				'container' 		=> '',
				'items_wrap' 		=> '%3$s',
				'before' 			=> '',
				'after'				=> '',
				'depth' 			=> $default_settings['num_levels_in_menu'],
				'echo' 				=> true,
				'walker'			=> $submenu,
				'nav_menu_parent'	=> $nav_menu_top_parent
			);
			if ($sub_parent > 0) {
				$args["current_category"] = $sub_parent;
			}
			wp_nav_menu( $args );
			if ( is_active_sidebar( 'right-main-sub-menu-item-sidebar' ) ) {
				dynamic_sidebar( 'right-main-sub-menu-item-sidebar' );
			}
			echo "</ul>";
		}
	}
	else {
		echo "<ul class='main-sub-menu'><li class='menu-item one-whole'><a>&nbsp;</a></li></ul>";
	}

}
/*
 * Main navigation-function showing category menu navigation
 */
function hk_navigation() {
	global $default_settings;
	$options = get_option('hk_theme');
	$category_as_filter = $default_settings["category_as_filter"];
	$search = get_query_var("s");

	// hide menu if hide_leftmenu is set
	if (!empty($options['hide_leftmenu']) && $options['hide_leftmenu'] == 1) return;

	// else show menu
	echo "<aside id='nav' class='category-navigation' role='navigation'><nav>";
	if ($search != "") {
		echo "Du s&ouml;kte p&aring; " . $search . ".";
	}

	// show filter or normal menu
	if ($category_as_filter) {
		hk_filter_navigation();
	}
	else {
		hk_menu_navigation();
	}

	echo "&nbsp;</nav></aside>";

}


/* menu when filtering selected */
function hk_filter_navigation() {
	global $post, $default_settings;

	$options = get_option('hk_theme');

	$cat = get_query_var("cat");
	$tags = get_query_var("tag");
	$all_categories = array($cat);


	// if in category (filter not available in single or in tag)
	if ($cat != "") {
		$currentcat = '';
		echo "<form method='get'>";

		$usedParentIDs = array();
		foreach ($all_categories as $cat) {
			$children =  get_categories(array('child_of' => $cat, 'hide_empty' => false));
			$currentparent = $cat;
			$walker = new hk_Category_Filter_Walker();
			$parentCat = hk_getMenuParent($cat);
			if (!in_array($parentCat,$usedParentIDs)) {
				$usedParentIDs[] = $parentCat;
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
					'exclude'			 => $default_settings["hidden_cat"],
					'walker'			 => $walker,
					'current_category'	 => $cat
				);

				//echo "<a class='dropdown-nav'>" . get_the_category_by_ID($parentCat) . "</a>";
				echo "<ul class='parent'>";
				if ($parentCat == $cat) {
					$currentcat = 'current-cat';
				}

				echo "<li class='heading $currentcat current-cat-parent cat-has-children'><a href='#' class='cat-icon'><a href='".get_category_link($parentCat)."'>".get_the_category_by_ID($parentCat)."</a></li>";
				wp_list_categories( $args );
				echo "</ul>";
			}

			//hk_displayFilterTagFilter(false);

			echo "<input type='submit' value='Filtrera' />";
			echo "</form>";

		}
	}
}

// Walker class: Show which category and tag is selected
class hk_Category_Filter_Walker extends Walker_Category {
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        extract($args);
		$current_category_filter = $_REQUEST["current-category-filter"];

		$tags_filter = get_query_var("tag");
		if (!empty($tags_filter)) {
			$tags_filter = "?tag=$tags_filter";
		}
		//$tags_filter = "";
        $cat_name = esc_attr( $category->name);


		// set classes
		$haschildclass = "";
		if (count(get_term_children($category->term_id,"category")) > 0)
			$haschildclass = " cat-has-children";
        if ( isset($current_category) && $current_category )
            $current_category_object = get_category( $current_category );
		$class = 'cat-item cat-item-'.$category->term_id.$haschildclass;
		if ( isset($current_category) && $current_category && ($category->term_id == $current_category) )
			$class .=  ' current-cat';
		elseif ( isset($current_category_object) && $current_category_object && ($category->term_id == $current_category_object->parent) )
			$class .=  ' current-cat-parent';
		elseif ( hk_isParentOf($current_category_object->term_id, $category->term_id) )
			$class .=  ' current-cat-parent current-cat-grandparent';


		$selected = "";
		if (!empty($current_category_filter) && in_array($category->term_id, $current_category_filter)) {
			$selected = "checked";
		}
        $link = '<span><input type="checkbox" name="current-category-filter[]" value="' . $category->term_id . '" ' . $selected;
        $cat_name = apply_filters( 'list_cats', $cat_name, $category );
        $link .= '>';

        $link .= $cat_name . '</span>';


        if ( isset($show_count) && $show_count )
            $link .= ' (' . intval($category->count) . ')';

        if ( isset($show_date) && $show_date ) {
            $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
        }

        if ( 'list' == $args['style'] ) {


            $output .= "\t<li";

            $output .=  ' class="'.$class.'"';
            $output .= ">$link\n";
        } else {
            $output .= "\t$link<br />\n";
        }
	}

}



/* menu when normal category and tag view */
function hk_menu_navigation() {
	global $post, $default_settings;

	$options = get_option('hk_theme');

	$cat = get_query_var("cat");
	$tags = get_query_var("tag");
	$all_categories = array($cat);
	$currentcat = '';

	if (is_single()) {
		/* get post first parents */
		$menu_name = "primary";
		$all_categories_object = get_the_category(get_the_ID());
		$all_categories = array();
		foreach ($all_categories_object as $item) { $all_categories[] = $item->cat_ID; }
	}


	// if in category
	if ($cat != "" || is_single()) {


		if ($tags == ""){
			$usedParentIDs = array();
			foreach ($all_categories as $cat) {
				$children =  get_categories(array('child_of' => $cat, 'hide_empty' => false));
				$currentparent = $cat;
				$walker = new hk_Category_Walker();
				$parentCat = hk_getMenuParent($cat);
				if (!in_array($parentCat,$usedParentIDs)) {
					$usedParentIDs[] = $parentCat;
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
						'exclude'			 => $default_settings["hidden_cat"],
						'walker'			 => $walker,
						'current_category'	 => $cat
					);

					//echo "<a class='dropdown-nav'>" . get_the_category_by_ID($parentCat) . "</a>";

					echo "<ul class='parent'>";
					if ($parentCat == $cat) {
						$currentcat = 'current-cat';
					}
					echo "<li class='heading $currentcat current-cat-parent cat-has-children'><a href='#' class='cat-icon'><a href='".get_category_link($parentCat)."'>".get_the_category_by_ID($parentCat)."</a></li>";
					wp_list_categories( $args );
					echo "</ul>";
				}
			}

			hk_displayTagFilter();
		}
	}


	// if in tag
	if ($tags != "") {

		//echo "<a class='dropdown-nav'>Etiketter</a>";
		$walker = new hk_Category_Walker();
		$parentCat = hk_getMenuParent($cat);
		if (!empty($parentCat)) {
			$parentName = get_the_category_by_ID($parentCat);
			$parentUrl = get_category_link($parentCat) . "?tag=$tags";
		}
		else {
			$parentName = "Hela webbplatsen";
			$parentUrl = get_site_url() . "?tag=$tags";
		}
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
			'walker'			 => $walker
		);
		echo "<ul class='parent'>";
		echo "<li class='heading $currentcat current-cat-parent cat-has-children'><a href='#' class='cat-icon'></a><a href='$parentUrl'>$parentName</a></li>";
		wp_list_categories( $args );
		echo "</ul>";

		hk_displayTagFilter();

	}

}


// show all tag filter list
function hk_displayAllTagFilter($show_title = true, $ul_class="more-navigation", $echo = true, $a_class = "", $cat = "", $skip_ul_wrapper = false) {
	global $default_settings;
	$retValue = "";//cat: $cat " . get_query_var("cat");
	if ($default_settings["show_tags"] != 0) :

		$tags = get_tags();
    $tags_filter = get_query_var("tag");

		if (!empty($tags) || !empty($tags_filter)) :
            if (!$skip_ul_wrapper) {
                $retValue .= "<ul class='$ul_class'>";
            }
            /* show tag title */
			if ($show_title) {
				$retValue .= "<li class='heading'><a href='#' class='tag-icon'></a><a class='js-show-tag-menu-li' href='#'>Visa bara<span class='expand-icon'>+</span></a></li>";
			}

			/* helper to remember if all tag-filter-items has been seen */
			if (!empty($tags_filter)) {
				$tags_selected_and_visible = array();
				$tag_array = explode(",",$tags_filter);
				foreach( $tag_array as $tagslug) {
					$tags_selected_and_visible[$tagslug] = false;
				}
			}

			/* show tag list */
			foreach( $tags as $tagitem) {
				$tags_selected_and_visible[$tagitem->tag_slug] = true;
				$tagitem = (object)array("tag_ID" => $tagitem->term_id, "tag_name" => $tagitem->name, "tag_slug" => $tagitem->slug );

				$retValue .= hk_generateTagLink($tagitem, $a_class, $cat);
			}


			if (!$skip_ul_wrapper) {
			 $retValue .= "</ul>";
            }
		endif; // endif tags available
		if ($echo) {
			echo $retValue;
		} else {
			return $retValue;
		}
	endif;
}

// show normal tag filter list
function hk_displayTagFilter($show_title = true, $ul_class="more-navigation", $echo = true, $a_class = "", $cat = "", $skip_ul_wrapper = false) {
	global $default_settings;
	$retValue = "";//cat: $cat " . get_query_var("cat");
	if ($default_settings["show_tags"] != 0) :

		if ($cat != "") {
            $tags = hk_getCategoryTags($cat);
        } else {
            $tags = hk_getCategoryTags(get_query_var("cat"));
        }
        $tags_filter = get_query_var("tag");

		if (!empty($tags) || !empty($tags_filter)) :
            if (!$skip_ul_wrapper) {
                $retValue .= "<ul class='$ul_class'>";
            }
            /* show tag title */
			if ($show_title) {
				$retValue .= "<li class='heading'><a href='#' class='tag-icon'></a><a class='js-show-tag-menu-li' href='#'>Visa bara<span class='expand-icon'>+</span></a></li>";
			}

			/* helper to remember if all tag-filter-items has been seen */
			if (!empty($tags_filter)) {
				$tags_selected_and_visible = array();
				$tag_array = explode(",",$tags_filter);
				foreach( $tag_array as $tagslug) {
					$tags_selected_and_visible[$tagslug] = false;
				}
			}

			/* show tag list */
			foreach( $tags as $tagitem) {
				$tags_selected_and_visible[$tagitem->tag_slug] = true;
				$retValue .= hk_generateTagLink($tagitem, $a_class, $cat);
			}

			/* print if tag not exist in cat (check helper variable) */
			foreach( $tags_selected_and_visible as $key => $value) {
				if (!$value) {
					$item = get_term_by("slug",$key,"post_tag", "OBJECT");
					if ($item instanceof WP_Term) {
						$tagitem = (object)array("tag_ID" => $item->term_id, "tag_name" => $item->name, "tag_slug" => $item->slug );
						$retValue .= hk_generateTagLink($tagitem, $a_class);
					}
					//$retValue .= hk_generateTagLink($key, $a_class);
				}
			}

			if (!$skip_ul_wrapper) {
			 $retValue .= "</ul>";
            }
		endif; // endif tags available
		if ($echo) {
			echo $retValue;
		} else {
			return $retValue;
		}
	endif;
}

/* return description if one is set, otherwise return the normal category link */
function hk_getCategoryLink( $cat ) {
	return ($cat->description != "") ? $cat->description : get_category_link( $cat->term_id );
}

/* Generate tag link in tag navigation (wrapped in <li>) */
function hk_generateTagLink($tagitem, $a_class = "", $term_id = "") {
	$currtagslug = $tagitem->tag_slug;
	$tags_filter = get_query_var("tag");
	$current_tag = false;

    if ($term_id == "") {
        $term_id = get_query_var("cat"); // get current cat
	   //$term_id = hk_getMenuParent(get_query_var("cat")); // get closes menu parent
    }

	$orderby = (isset($_REQUEST["orderby"]))?$_REQUEST["orderby"]:"";
	if ($orderby != "") {
		$orderby = "&orderby=$orderby";
	}
	if (!empty($tags_filter))
		$tag_array = explode(",",$tags_filter);

	if(!empty($tag_array) && in_array($currtagslug, $tag_array)) {
		$current_tag = true;
		$tags_filter = "?tag=";
	}
	else {
		$tags_filter = "?tag=".$currtagslug;
	}


	// generate tag link
	if (empty($term_id)) {
		$href = get_site_url() . $tags_filter. $orderby;
	}
	else {
		$href = get_category_link( $term_id ) . $tags_filter. $orderby;
	}

	if ($a_class != "") {
		$a_class = "class='$a_class'";
	}

	$link = '<a ' . $a_class . ' href="' . $href  . '" ';
	$tag_name = $tagitem->tag_name;
	$link .= "title='Filtrera med nyckelordet $tag_name'";
	$link .= '>';
	$link .= "$tag_name</a>";

	$output = "\t<li";
	$class = 'atag-item tag-item-'.$tagitem->tag_ID;
	$icon = "";
	if ($current_tag) {
		$class .=  ' current-tag';
		$icon = "<a href='$href' class='delete-icon'></a>";
	}
	$output .=  ' class="'.$class.'"';
	$output .= ">$icon$link</li>\n";
	return $output;
}



// Walker class: Show which category and tag is selected
class hk_Category_Walker extends Walker_Category {
	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
        extract($args);

		$tags_filter = get_query_var("tag");
		if (!empty($tags_filter)) {
			$tags_filter = "?tag=$tags_filter";
		}
		//$tags_filter = "";
        $cat_name = esc_attr( $category->name);


		// set classes
		$haschildclass = "";
		if (count(get_term_children($category->term_id,"category")) > 0)
			$haschildclass = " cat-has-children";
      if ( isset($current_category) && $current_category ) {
        $_current_category = get_category( $current_category );
			}
		$class = 'cat-item cat-item-'.$category->term_id.$haschildclass;
		if ( isset($current_category) && $current_category && ($category->term_id == $current_category) ) {
			$class .=  ' current-cat';
		}
		elseif ( isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent) ) {
			$class .=  ' current-cat-parent';
		}
		elseif ( isset($_current_category) && hk_isParentOf($_current_category->term_id, $category->term_id) ) {
			$class .=  ' current-cat-parent current-cat-grandparent';
		}


		// set expandable icon
		$icon = "";
		if (count(get_term_children($category->term_id,"category")) > 0) {
			if (!strstr($class,"current-cat")) {//count(get_term_children(,"category")) > 0) {
				$icon = " +";
			}
		}
		if (!empty($category->description)) {
			$icon .= "<span class='icon'></span>";
		}
        $link = '<a href="' . hk_getCategoryLink( $category ) . $tags_filter . '" ';
        $cat_name = apply_filters( 'list_cats', $cat_name, $category );
        if ( $use_desc_for_title == 0 || empty($category->description) )
            $link .= 'title="Visa allt om ' . $cat_name . '"';
        else
            $link .= 'class="external" title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        $link .= '>';

        $link .= $cat_name . $icon . '</a>';


        if ( isset($show_count) && $show_count )
            $link .= ' (' . intval($category->count) . ')';

        if ( isset($show_date) && $show_date ) {
            $link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
        }

        if ( 'list' == $args['style'] ) {


            $output .= "\t<li";

            $output .=  ' class="'.$class.'"';
            $output .= ">$link\n";
        } else {
            $output .= "\t$link<br />\n";
        }
	}

}

// Walker class: Show which tags available to selected
class hk_Tag_Walker extends Walker_Category {
	function start_el(&$output, $tag, $depth = 0, $args = array(), $id = 0 ) {
        extract($args);
		$currtagslug = $tag->slug;
		$tags_filter = get_query_var("tag");

		$term_id = hk_getMenuParent(get_query_var("cat")); // get closes menu parent
		//$term_id = get_query_var("cat");

		$orderby = $_REQUEST["orderby"];
		if ($orderby != "") {
			$orderby = "&orderby=$orderby";
		}
		if (!empty($tags_filter))
			$tag_array = explode(",",$tags_filter);

		if(!empty($tag_array) && in_array($currtagslug, $tag_array)) {
			$current_tag = true;
			$tags_filter = "?tag=";
		}
		else {
			$tags_filter = "?tag=".$currtagslug;
		}


		// generate tag link
        $cat_name = esc_attr( $tag->name);
		if (empty($term_id)) {
			$href = get_site_url() . $tags_filter. $orderby;
		}
		else {
			$href = get_category_link( $term_id ) . $tags_filter. $orderby;
		}

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
            if ( empty($feed) ) {
                $title = ' title="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
                $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
			}
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
			$class = 'atag-item tag-item-'.$tag->term_id;
			$icon = "";
			if ($current_tag) {
				$class .=  ' current-tag';
				$icon = "<a href='$href' class='delete-icon'></a>";
			}
			$output .=  ' class="'.$class.'"';
			$output .= ">$icon$link\n";
		} else {
			$output .= "\t$link\n";
		}

	}

}


/*
 * Get tags available in $varcat category or one of the children
 * https://wordpress.org/support/topic/get-tags-specific-to-category
 */
function hk_getCategoryTags($varcat = "") {
	global $wpdb, $default_settings;

	//$cat_ids = array($varcat);
	//$cat_ids = hk_getChildrenIdArray(hk_getMenuParent($varcat)); // get closes menu parent
	$transient_name = 'hk_getcategorytags_' . $varcat;
	if ( false === ( $category_tags = get_transient( $transient_name ) ) ) {
		// Use the data like you would have normally...
		$cat_ids = hk_getChildrenIdArray($varcat); // get child ids
		$cat_ids[] = $varcat; // add current id
		$varcat_where_or = "";
		if ($varcat != "") {
			$varcat_where_or = "(1 = 0 \n";
			foreach($cat_ids as $cat_id) :
				$varcat_where_or .= "OR terms1.term_ID = '$cat_id' \n";
			endforeach;
			$varcat_where_or .= " ) AND ";
		}
		$hidden_cat = $hidden_cat1 = $hidden_cat2 = "";
		if ($default_settings["hidden_cat"] != "") {
			$hidden_cat = $default_settings["hidden_cat"];
		}

		$query = "SELECT DISTINCT
			terms2.term_id as tag_ID,
			terms2.name as tag_name,
			terms2.slug as tag_slug
			FROM
				$wpdb->posts as p1
				LEFT JOIN $wpdb->term_relationships as r1 ON p1.ID = r1.object_ID AND p1.post_status = 'publish' AND p1.post_type = 'post'
				LEFT JOIN $wpdb->term_taxonomy as t1 ON r1.term_taxonomy_id = t1.term_taxonomy_id AND t1.taxonomy = 'category'
				LEFT JOIN $wpdb->terms as terms1 ON t1.term_id = terms1.term_id,

				$wpdb->posts as p2
				LEFT JOIN $wpdb->term_relationships as r2 ON p2.ID = r2.object_ID AND p2.post_status = 'publish' AND p2.post_type = 'post'
				LEFT JOIN $wpdb->term_taxonomy as t2 ON r2.term_taxonomy_id = t2.term_taxonomy_id AND t2.taxonomy = 'post_tag'
				LEFT JOIN $wpdb->terms as terms2 ON t2.term_id = terms2.term_id
			WHERE (
				$varcat_where_or
				terms2.term_id IS NOT NULL AND
				p1.ID = p2.ID AND
				p1.ID NOT IN (SELECT p3.ID FROM $wpdb->posts as p3
					LEFT JOIN $wpdb->term_relationships as r3 ON p3.ID = r3.object_ID AND p3.post_status = 'publish'
					WHERE r3.term_taxonomy_ID = '$hidden_cat')      )
			ORDER BY tag_name
					";
		$category_tags = $wpdb->get_results($query);
		set_transient( $transient_name, $category_tags, 12 * HOUR_IN_SECONDS );

	}
	return $category_tags;
}






?>
