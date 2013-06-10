
	<div id="breadcrumb" class="breadcrumb"><?php hk_breadcrumb(); ?></div>

	<div id="primary" class="primary">

	<div id="content" class="tag-listing" role="main">

	<?php
		/**
		 * Default order in orderby no set
		 */
		$shownPosts = array();
		if ($tag != "") : 
			if ($cat != "") {
				$top_cat_arr = array($cat);
				$cat_title = "kategorin <strong>" . single_tag_title("",false) . "</strong>";
			}
			else {
				foreach(get_categories(array('parent' => 0, 'hide_empty' => true)) as $c) :
					$top_cat_arr[] = $c->cat_ID;
				endforeach;
				$cat_title = "<strong>hela webbplatsen</strong>";
				
			}
			?>
			<header class="page-header">
				
				<ul class="num-posts">
					<?php
						echo "<li><a class='nolink'>Inneh&aring;ll av typen <b>" . $tag . "</b> i " . $cat_title . "</a></li>";
					?>
					<?php //print_r($wp_query); ?>
				</ul>


			</header>
			<?php

			foreach($top_cat_arr as $cat) :
				
				$children =  get_categories(array('child_of' => $cat, 'hide_empty' => true));
				
				$args = array( 'posts_per_page' => -1,
				'ignore_sticky_posts' => 1);
				if ($cat != "")
					$args["category__and"] = array($cat);
				if ($tag != "")
					$args["tag_slug__in"] = split(",",$tag);
					
				//echo "<h1>Inneh&aring;ll fr&aring;n " . $tag . " i kategorin " . single_tag_title("",false) . "</h1>";
				?>
			<?php
				$catarr = array();
				if ($cat != "") :
					$cslug = &get_category($cat);
					$catarr[] = $cslug->slug;
					query_posts( $args ); ?>
					<h1><?php echo get_cat_name($cat) ?></h1>
					<?php if ( have_posts() ) : ?>
						<ul>
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'content', 'single-line' ); ?>
							<?php $shownPosts[] = get_the_ID(); ?>
						<?php endwhile; ?>
						</ul>
					<?php endif;
					wp_reset_query(); // Reset Query 
				endif; 
				?>
				

				<?php // get category child posts
				
				foreach ($children as $childcat) :
					$args = array( 'posts_per_page' => -1,
					'ignore_sticky_posts' => 1);
					if ($childcat->cat_ID != "")
						$args["category__and"] = array($childcat->cat_ID);
					if ($tag != "")
						$args["tag_slug__in"] = split(",",$tag);
					
					query_posts( $args );
					//print_r($childcat);
					if ( have_posts() ) : 
						$catarr[] = $childcat->slug;
						
						foreach(hk_getParentsSlugArray($childcat->cat_ID) as $slug) :
							if (!in_array($slug,$catarr)) :
								$catarr[] = $slug;
								$c = get_category_by_slug($slug);
								$sub = hk_countParents($c->cat_ID); 
								echo "<h$sub class='indent$sub'>" . $c->name . "</h$sub>";
							endif;
							
						endforeach;
						
						$sub = hk_countParents($childcat->cat_ID); 
						echo "<h$sub class='indent$sub'>" . $childcat->name . "</h$sub><ul class='indent$sub'>";
						while ( have_posts() ) : the_post();
							get_template_part( 'content', 'single-line' );
							$shownPosts[] = get_the_ID();
						endwhile;
						endif;
					echo "</ul>";

					wp_reset_query(); // Reset Query

				endforeach;
				
			endforeach;
			
		endif; /* end if has tag */
		
		
		
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

		//hk_content_nav( 'nav-below' );

		/* help text if nothing is found */
		if (empty($shownPosts)) {
			hk_empty_navigation();
		} ?>

	</div><!-- #content -->

	
	
</div><!-- #primary -->