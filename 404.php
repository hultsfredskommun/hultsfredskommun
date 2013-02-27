<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>
	<div id="top-nav-sidebar">
		<?php dynamic_sidebar('nav-sidebar'); ?>
	</div>
	<aside id='nav' class=' category-navigation' role='navigation'>&nbsp;</aside>

	<div id="primary" class="primary">
		<div id="content" role="main">

		<?php hk_nothing_found_navigation(); ?>


		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>