<?php
/**
 * The template for displaying Category Archive pages.
 *
 */

get_header();

if ($default_settings["show_articles"]) { // show articles (can be set to false in hk_quick (mellanstartsida) )
global $hk_options;

 if ( get_query_var("tag") != "" ) {
		hk_navigation();
		require("inc/hk-tag.php");
	} elseif ( $hk_options['toggle_filter_categories'] == '1' ) {
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
