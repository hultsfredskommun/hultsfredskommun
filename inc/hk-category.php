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
			$shownPosts = array();
			if ($_REQUEST["orderby"] == "") :
				$posts_per_page = get_option('posts_per_page');
				
				/* Get category id */
				$cat = get_query_var("cat");
				$tag = get_query_var("tag");

				if ( $cat != "" || $tag != "") :
					/* Get all sticky posts from this category */
					$sticky = get_option( 'sticky_posts' );
						
					if ( !empty($sticky) ) {
						/* Query sticky posts */
						$args = array( 'post__in' => $sticky, 'posts_per_page' => -1);
						if ( !empty($cat) ) {
							$args["category__and"] = $cat;
						}
						if ( !empty($tag) ) {
							$args["tag_slug__and"] = $tag;
						}
						query_posts( $args );
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							$shownPosts[] = get_the_ID();
							get_template_part( 'content', get_post_format() );
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
					if ( !empty($tag) ) {
						$args["tag_slug__and"] = $tag;
					}
					query_posts( $args );
					if ( have_posts() ) : while ( have_posts() ) : the_post();
						$shownPosts[] = get_the_ID();
						get_template_part( 'content', get_post_format() );
					endwhile; endif;
					wp_reset_query(); // Reset Query
					
					
					/* Get posts from children of this category */
					if ($cat != "") {
						$children =  hk_getChildrenIdArray($cat);
						if ( !empty($children) ) {
							/* Get all sticky posts children of this category */
							echo "<span class='morefrom'>Mer från underkategorier</span>";
							$args = array( 'category__in' => $children, 'posts_per_page' => -1 );
							if (!empty($sticky)) {
								$args['post__in'] = $sticky;
								if ( !empty($tag) ) {
									$args["tag_slug__and"] = $tag;
								}
								if (!empty($shownPosts)) {
									$args['post__not_in'] = $shownPosts;
								}
								query_posts( $args );
								if ( have_posts() ) : while ( have_posts() ) : the_post();
									$shownPosts[] = get_the_ID();
									get_template_part( 'content', get_post_format());
								endwhile; endif;
								wp_reset_query(); // Reset Query
							}
							
							/* Get all NOT sticky posts children of this category */
							$args = array( 'category__in' => $children, 'posts_per_page' => $posts_per_page );
							if ( !empty($sticky) || !empty($shownPosts)) {
								$args['post__not_in'] = array_merge($sticky,$shownPosts);
							}
							if ( !empty($tag) ) {
								$args["tag_slug__and"] = $tag;
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

		<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky())?"sticky":""); ?>>
		<div class="content-wrapper">
		<div class="summary-content">
			<?php $thumb = hk_get_the_post_thumbnail(get_the_ID(),'thumbnail-image', false); 
			if ($thumb) : ?>
					<?php 					
						echo $thumb;
					//the_post_thumbnail('thumbnail-image'); ?>
			<?php endif;/*endif;*/ ?>
			
			<div class="entry-wrapper">
				<h1 class="entry-title">Här finns ingenting</h1>
				<div class="entry-content">
					<p>Ändra ditt urval eller använd sökrutan för att hitta.</p>
					<p>Eller välj bland de mest besökta sidorna. </p>
					<?php if(function_exists('get_most_viewed')) { get_most_viewed('both',20,200); } ?>
					
				</div>
			</div>
			
		</div><!-- .summary-content -->
		<?php //include("inc/hk-aside-content.php"); ?>

		</div>
	</article><!-- #post-0 -->

	<?php endif; ?>

	</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>