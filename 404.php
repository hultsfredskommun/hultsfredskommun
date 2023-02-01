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

	<div id="primary" class="primary" style='width: 100%'>
		<div id="content" role="main">
		<?php if (function_exists("hk_404")) hk_404(); ?>

		<style>
		.rek-prediction__list.rekai-pills  {
			display: block!important;
			margin-left: 12px;
		}		

		.rek-prediction__item.rekai-pill  {
			/* color: #ed553b;
			border-radius: 200px; */
			margin-bottom: 8px;
			display: block;
			border: 0;
		}
		.rek-prediction__item.rekai-pill a {
			/* color: #000;
			text-decoration: none;
			background: #e5e6e7; */
			padding: 0;
		}
		</style>
		<div class="rek-prediction" data-renderstyle="pills" data-nrofhits="10" data-titlemaxlength="60"></div>


		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>