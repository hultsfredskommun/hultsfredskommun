<?php
/**
 * The template for displaying Category Archive pages.
 *
 */

get_header(); 

if ($default_settings["show_articles"]) : // show articles (can be set to false in hk_quick (mellanstartsida) )
?>


	<?php if ( get_query_var("tag") != "" ) : ?>
		<?php hk_navigation(); ?>
		<?php require("inc/hk-tag.php"); ?>			
	<?php elseif ( !is_sub_category_firstpage() ) : ?>
		<?php hk_navigation(); ?>
		<?php require("inc/hk-category.php"); ?>
	<?php else : ?>
		<?php require("inc/hk-sub-category-firstpage.php"); ?>
	<?php endif;  /* END ELSE is_sub_category_firstpage */ ?>
	

<?php 
endif; // end if show_articles
get_footer(); ?>
