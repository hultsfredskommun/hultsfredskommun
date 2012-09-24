<?php
/**
 * The template for displaying Category Archive pages.
 *
 */

get_header(); 

?>
		<?php if ( !is_sub_category_firstpage() ) : ?>
			<div id="top-nav-sidebar">
				<?php dynamic_sidebar('nav-sidebar'); ?>
			</div>
		<?php endif; ?>
		
		<?php if ( is_sub_category_firstpage() ) : ?>
			<?php require("inc/hk-sub-category-firstpage.php"); ?>
		<?php else : ?>
			<?php require("inc/hk-category.php"); ?>
		<?php endif;  /* END ELSE is_sub_category_firstpage */ ?>
		

<?php get_footer(); ?>
