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
				$posts_per_page = get_option('posts_per_page');
				
				/* Get category id */
				$cat = get_query_var("cat");
				
				if ( $cat != "" ) :
					/* Get all sticky posts from this category */
					$sticky = get_option( 'sticky_posts' );
						
					if ( !empty($sticky) ) {
						/* Query sticky posts */
						query_posts( array( 'category__in' => $cat, 'post__in' => $sticky, 'posts_per_page' => -1) );
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							get_template_part( 'content', get_post_format() );
						endwhile; endif;
					}
					wp_reset_query(); // Reset Query
					

					/* Get all NOT sticky posts from this category */
					$args = array( 'category__and' => $cat, 'posts_per_page' => -1 );
					if ( !empty($sticky) ) {
						$args['post__not_in'] = $sticky;
					}
					query_posts( $args );
					if ( have_posts() ) : while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() );
					endwhile; endif;
					wp_reset_query(); // Reset Query
					
					
					/* Get posts from children of this category */
					$children =  hk_getChildrenIdArray($cat);
					if ( !empty($children) ) {
						/* Get all sticky posts children of this category */
						echo "<span class='morefrom'>Mer från underkategorier</span>";
						$args = array( 'category__in' => $children, 'posts_per_page' => -1 );
						if (!empty($sticky)) {
							$args['post__in'] = $sticky;
							query_posts( $args );
							if ( have_posts() ) : while ( have_posts() ) : the_post();
								get_template_part( 'content', get_post_format());
							endwhile; endif;
							wp_reset_query(); // Reset Query
						}
						
						/* Get all NOT sticky posts children of this category */
						$args = array( 'category__in' => $children, 'posts_per_page' => $posts_per_page );
						if (!empty($sticky)) {
							$args['post__not_in'] = $sticky;
						}
						query_posts( $args );
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							get_template_part( 'content', get_post_format() );
						endwhile; endif;
						wp_reset_query(); // Reset Query
					}
					
				endif;
			/****Default order END***/

			else :

			/* otherwise start standard Loop if orderby is set */ 
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