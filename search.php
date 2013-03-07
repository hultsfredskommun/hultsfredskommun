<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>
		<?php hk_navigation(); ?>
		
		<div id="primary" class="primary  searchresult">
			<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<?php 
						if( function_exists('displaySortOrderButtons') ){
							displaySortOrderButtons();
						} 
					?>
					
					<ul class="view-tools">
						<li class="menu-item view-mode"><a class="viewmode_summary js-view-summary hide" title="Listvisning" href="#">Sammanfattning</a>
						<a class="viewmode_titles js-view-titles" title="Rubrikvisning" href="#">Bara rubriker</a></li>
					</ul>
				</header>

				<?php /* hook to be able to add other search result */ 
				do_action('hk_pre_search', get_query_var("s")); ?>
				
				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php //hk_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<?php hk_nothing_found_navigation(); ?>
				
			<?php endif; ?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>