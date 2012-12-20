<div id="primary">

	<div id="content" role="main">


		<header class="page-header">
			<?php 
				if( function_exists('displaySortOrderButtons') ){
					displaySortOrderButtons();
				} 
			?>
			
			

			<?php 
				if( function_exists('displayTagFilter') ){
					displayTagFilter();
				}
			?>
			
			<div id="viewmode">
				<a id="viewmode_summary" title="Listvisning" href="#">Sammanfattning</a>
				<a id="viewmode_titles" title="Rubrikvisning" href="#">Rubriker</a>
			</div>
			<div class="clear"></div>
		</header>
		
	<?php if ( have_posts() ) : ?>

		<?php
			/**
			 * Default order in orderby no set
			 */

			if ($_REQUEST["orderby"] == "") :
				$posts_per_page = get_option('posts_per_page');
				
				/* Get category id */
				$cat = get_query_var("cat");
				$tag = get_query_var("tag");
				$shownPosts = array();
				$tag_array = array();
				if ($tag != "")
					$tag_array = split(",", $tag);

				if ( $cat != "" || $tag != "") :
					/* Get all sticky posts from this category */
					$sticky = get_option( 'sticky_posts' );
						
					if ( !empty($sticky) ) {
						/* Query sticky posts */
						$args = array( 'post__in' => $sticky, 'posts_per_page' => -1);
						if ( !empty($cat) ) {
							$args["category__and"] = $cat;
						}
						if ( !empty($tag_array) ) {
							$args["tag_slug__and"] = $tag_array;
						}
						query_posts( $args );
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							get_template_part( 'content', get_post_format() );
							$shownPosts[] = get_the_ID();
						endwhile; endif;
					}
					wp_reset_query(); // Reset Query
					

					/* Get all NOT sticky posts from this category */

					$args = array( 'posts_per_page' => -1 );
					if ( !empty($sticky) || !empty($shownPosts)) {
						$args['post__not_in'] = array_merge($sticky,$shownPosts);
					}
					if ( !empty($cat) ) {
						$args["category__and"] = $cat;
					}
					if ( !empty($tag_array) ) {
						$args["tag_slug__and"] = $tag_array;
					}
					
					query_posts( $args );
					if ( have_posts() ) : while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_format() );
						$shownPosts[] = get_the_ID();
					endwhile; endif;
					wp_reset_query(); // Reset Query
					
					
					/* Get posts from children of this category */
					if ($cat != "") {
						$children =  hk_getChildrenIdArray($cat);
						if ( !empty($children) ) {
							/* Get all sticky posts children of this category */
							
							$no_top_space = (count($shownPosts) == 0)?" no-top-space":"";
							echo "<div class='more-from-heading" . $no_top_space ."'><span>Mer från underkategorier</span></div>";
							$args = array( 'category__in' => $children, 'posts_per_page' => -1 );
							if (!empty($sticky)) {
								$args['post__in'] = $sticky;
								if ( !empty($tag_array) ) {
									$args["tag_slug__and"] = $tag_array;
								}
								if (!empty($shownPosts)) {
									$args['post__not_in'] = $shownPosts;
								}
								query_posts( $args );
								if ( have_posts() ) : while ( have_posts() ) : the_post();
									get_template_part( 'content', get_post_format());
									$shownPosts[] = get_the_ID();
								endwhile; endif;
								wp_reset_query(); // Reset Query
							}
							
							/* Get all NOT sticky posts children of this category */
							$args = array( 'category__in' => $children, 'posts_per_page' => $posts_per_page );
							if ( !empty($sticky) || !empty($shownPosts)) {
								$args['post__not_in'] = array_merge($sticky,$shownPosts);
							}
							if ( !empty($tag_array) ) {
								$args["tag_slug__and"] = $tag_array;
							}
							query_posts( $args );
							if ( have_posts() ) : while ( have_posts() ) : the_post();
								get_template_part( 'content', get_post_format() );
							endwhile; endif;
							wp_reset_query(); // Reset Query
						}
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

		<article id="post-nothing">
		<div class="content-wrapper">
		<div class="summary-content">
			<div class="entry-wrapper">
				<h1 class="entry-title">Här finns ingenting</h1>
				<div class="entry-content">
					<p>Ändra ditt urval eller använd sökrutan för att hitta.</p>
					<?php if(function_exists('get_most_viewed')) { ?>
					<p>Eller välj bland de mest besökta sidorna. </p>
					<ul><?php get_most_viewed('post'); } ?></ul>
					
				</div>
			</div>
			
		</div><!-- .summary-content -->

		</div>
	</article><!-- #post-0 -->

	<?php endif; ?>

	</div><!-- #content -->
		
</div><!-- #primary -->