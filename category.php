<?php
/**
 * The template for displaying Category Archive pages.
 *
 */

get_header(); 


if ($default_settings["show_articles"]) { // show articles (can be set to false in hk_quick (mellanstartsida) )	

	if ( get_query_var("tag") != "" ) {
		hk_navigation();
		require("inc/hk-tag.php");
	} elseif (get_field('hk_quick_show_article_filter', "category_" . get_query_var("cat"))) {
		get_template_part('./inc/hk-quick-filter');		
	} elseif ( !is_sub_category_firstpage() ) {
		hk_navigation();
		require("inc/hk-category.php");
	} else {
		require("inc/hk-sub-category-firstpage.php");
	}  /* END ELSE is_sub_category_firstpage */
	

}

get_footer(); 

?>
