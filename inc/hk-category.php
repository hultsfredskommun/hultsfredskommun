<div id="primary">

	<div id="content" role="main">

	<?php if ( have_posts() ) : ?>

		<header class="page-header">
			<?php 
				if( function_exists('displaySortOrderButtons') ){
					displaySortOrderButtons();
				} 
			?>
			
			<div id="viewmode">
				<a id="viewmode_summary" title="Listvisning" href="#"></a>
				<a id="viewmode_titles" title="Rubrikvisning" href="#"></a>
			</div>
			<div class="clear"></div>
		</header>

		<!-- ***Sticky posts*** -->
		<?php
			/**
			 * Print stickies here only if orderby is empty
			 */
			if ($_REQUEST["orderby"] == "") :
				/* Get category id */
				$catID = get_query_var("cat");

				/* Get all sticky posts */
				$sticky = get_option( 'sticky_posts' );
				
				if ($catID != "" && !empty($sticky)):
					/* Query sticky posts */
					query_posts( array( 'category__in' => $catID, 'post__in' => $sticky ) );
					
					if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>			
						<?php get_template_part( 'content', get_post_format() ); ?>
					<?php endwhile; endif;
				endif; 
				// Reset Query
				wp_reset_query();
			endif;
		?><!-- ***Sticky posts END*** -->

		<?php /* Start the Loop */ ?>
		<?php while ( have_posts() ) : the_post(); ?>

			<?php
				/**
				 * Default: don't print stickies here
				 * If orderby is not empty: print stickies
				 */
				if( !is_sticky() or ($_REQUEST["orderby"] != "") ) {

					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				}
			?>

		<?php endwhile; ?>

		<?php hk_content_nav( 'nav-below' ); ?>

	<?php else : ?>

		<article id="post-0" class="post no-results not-found">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Nothing Found', 'twentyeleven' ); ?></h1>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
				<?php get_search_form(); ?>
			</div><!-- .entry-content -->
		</article><!-- #post-0 -->

	<?php endif; ?>

	</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>