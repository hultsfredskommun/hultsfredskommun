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

		<?php
			/**
			 * Default order in orderby no set
			 */
			if ($_REQUEST["orderby"] == "") :
				/* Get category id */
				$thiscat = get_query_var("cat");
				
				if ( $thiscat != "" ) :
					/* Get all sticky posts from this category */
					$sticky = get_option( 'sticky_posts' );
						
					if ( !empty($sticky) ) {
						/* Query sticky posts */
						query_posts( array( 'category__in' => $thiscat, 'post__in' => $sticky) );
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							get_template_part( 'content', get_post_format() );
						endwhile; endif;
					}
					wp_reset_query(); // Reset Query


					/* Get all NOT sticky posts from this category */
					$args = array( 'category__and' => $thiscat );
					if ( !empty($sticky) ) {
						$args['post__not_in'] = $sticky;
					}
					query_posts( $args );
					if ( have_posts() ) : while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() );
					endwhile; endif;
					wp_reset_query(); // Reset Query
					
					
					/* Get posts from children of this category */
					$children =  hk_getChildrenIdArray($thiscat);
					if ( !empty($children) ) {
						/* Get all sticky posts children of this category */
						echo "<span class='morefrom'>Mer från underkategorier</span>";
						$args = array( 'category__in' => $children );
						if (!empty($sticky)) {
							$args['post__in'] = $sticky;
							query_posts( $args );
							if ( have_posts() ) : while ( have_posts() ) : the_post();
								get_template_part( 'content', get_post_format() );
							endwhile; endif;
							wp_reset_query(); // Reset Query
						}
					
						/* Get all NOT sticky posts children of this category */
						$args = array( 'category__in' => $children );
						if (!empty($sticky)) {
							$args['post__not_in'] = $sticky;
						}
						query_posts( $args );
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							get_template_part( 'content', get_post_format() );
						endwhile; endif;
						wp_reset_query(); // Reset Query
					}
					
					
					
					// query_posts( array( 'category_slug__in' => hk_getParentsSlugArray($catID), 'post__in' => $sticky, 'ignore_sticky_posts' => 0 ) );
				endif;
			/****Default order END***/

			else :

			/* Start standard the Loop */ 
			while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;
		endif;
		
		hk_content_nav( 'nav-below' );

	else : ?>

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