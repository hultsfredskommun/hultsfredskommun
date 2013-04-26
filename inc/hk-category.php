	<?php if (!is_sub_category_firstpage()) :?>
	<div id="breadcrumb" class="breadcrumb"><?php hk_breadcrumb(); ?></div>
	<?php endif; ?>

	<div id="primary" class="primary">

	<div id="content" role="main">


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
			<ul class="category-tools">
				<?php /* if (related stuff ($cat)) : */ ?>
				<?php echo hk_related_output();	?>
				<?php /* endif; */ ?>
				
			</ul>

		</header>
		
	<?php
		/**
		 * Default order in orderby no set
		 */
		$shownPosts = array();
		if ($cat != "") : 
			
			$args = array( 'posts_per_page' => -1,
			'ignore_sticky_posts' => 1);
			
			// show sticky
			$sticky = get_option( 'sticky_posts' );
			$orderby = $_REQUEST["orderby"];
			if (!empty($sticky) && ($orderby == "" || $orderby == "popular") && $paged == 0) {
				$args["post__in"] = $sticky;
				$args["category__and"] = array($cat);
				
				query_posts( $args );
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_type() );
					$shownPosts[] = get_the_ID();
				endwhile; endif;
				//echo "<span class='hidden debug'>sticky from this category . <br>".print_r($args,true)."</span>";

				wp_reset_query(); // Reset Query
			}
		

			
			
			// show all not sticky
			$args = array( 'posts_per_page' => get_option("posts_per_page"),
			paged => $paged,
			'ignore_sticky_posts' => 1);
			if (!empty($sticky)) {
				$args["post__not_in"] = $sticky;
			}
			$args["category__and"] = array($cat);
			
			query_posts( $args );
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_type() );
				$shownPosts[] = get_the_ID();
			endwhile; endif;
			//echo "<span class='hidden debug'>all from this category . <br>".print_r($args,true)."</span>";

			wp_reset_query(); // Reset Query
			
			
		endif;
		
		
		
		/* helper array to know which posts is shown if loading more dynamically */
		if (empty($sticky)) {
			$allposts = $shownPosts;
		}
		else if (empty($shownPosts)) {
			$allposts = $sticky;
		}
		else if (empty($shownPosts) && empty($sticky)) {
			$allposts = array();
		}
		else {
			$allposts = array_merge($sticky,$shownPosts);
		}
		if (!empty($allposts))
			$allposts = implode(",",$allposts);
		else
			$allposts = "";
			
		echo "<span id='shownposts' class='hidden'>" . $allposts . "</span>";

		hk_content_nav( 'nav-below' );

		/* help text if nothing is found */
		if (empty($shownPosts)) {
			hk_empty_navigation();
		} ?>

	</div><!-- #content -->

	
	
</div><!-- #primary -->