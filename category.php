<?php
/**
 * The template for displaying Category Archive pages.
 *
 */

get_header(); 

?>
		<?php if ( !is_sub_category_firstpage()) : // || get_query_var("tag") != "" ) : ?>
			<?php hk_navigation(); ?>
			<?php require("inc/hk-category.php"); ?>
		<?php else : ?>
			<?php require("inc/hk-sub-category-firstpage.php"); ?>
		<?php endif;  /* END ELSE is_sub_category_firstpage */ ?>
		

<?php get_footer(); ?>
