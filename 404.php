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
	<aside id='nav' role='navigation'>&nbsp;</aside>

	<div id="primary">
		<div id="content" role="main">

			<article id="post-0" class="post error404 not-found">
			<div class="content-wrapper">
			<div class="summary-content">
				<div class="entry-wrapper">
				<?php hk_nothing_found_navigation(); ?>

				</div>
			</div><!-- .summary-content -->
			</div>
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>