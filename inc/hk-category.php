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
		if (false) : //working on this!
			$sticky_posts = get_option( 'sticky_posts' );

			// get not sticky
			if ($sticky_posts) :
				print_r($sticky_posts);	
				$args = array( 'posts_per_page' => -1, 'post_in' => $sticky_posts);
				
				if ($tag == "") {
					$args["post_type"] = array('post');
				}
				else {
					$args["post_type"] = array('post','attachment');
				}
				$args['post_status'] = 'publish';
				
				if ( !empty($cat) ) {
					$args["category__and"] = array($cat);
				}
				if ( !empty($tag_array) ) {
					if ($_REQUEST["tag_logic"] == "and") {
						$args["tag_slug__and"] = $tag_array;
					} else {
						$args["tag_slug__in"] = $tag_array;
					}
				}
				print_r($args);
				query_posts( $args );
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					echo 'tesst';
					get_template_part( 'content', get_post_type() );
					$shownPosts[] = get_the_ID();
				endwhile; endif;
				echo "<span class='hidden debug'>sticky from this category . <br>".print_r($args,true)."</span>";
				wp_reset_query(); // Reset Query
			endif;
			
			
			// get not sticky
			$args = array( 'posts_per_page' => $posts_per_page);
			$args['post__not_in'] = $shownPosts;
			if ($paged) {
				$args["paged"] = $paged;
			}
			if ($tag == "") {
				$args["post_type"] = array('post');
			}
			else {
				$args["post_type"] = array('post','attachment');
			}
			$args['post_status'] = 'publish';
			
			if ( !empty($cat) ) {
				$args["category__and"] = array($cat);
			}
			if ( !empty($tag_array) ) {
				if ($_REQUEST["tag_logic"] == "and") {
					$args["tag_slug__and"] = $tag_array;
				} else {
					$args["tag_slug__in"] = $tag_array;
				}
			}
			query_posts( $args );
			if ( have_posts() ) : while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_type() );
				$shownPosts[] = get_the_ID();
			endwhile; endif;
			echo "<span class='hidden debug'>all from this category . <br>".print_r($args,true)."</span>";

			wp_reset_query(); // Reset Query
		
		elseif ($_REQUEST["orderby"] == "") :
			$posts_per_page = get_option('posts_per_page');
			
			/* Get category id */
			$cat = get_query_var("cat");
			$tag = get_query_var("tag");
			$tag_array = array();
			if ($tag != "")
				$tag_array = split(",", $tag);

			if ( $cat != "" || $tag != "") :
				/* Get all sticky posts from this category */
				$sticky = get_option( 'sticky_posts' );
					
				if ( !empty($sticky) ) {
					/* Query sticky posts */
					$args = array( 'post__in' => $sticky, 'posts_per_page' => -1);
					if ($tag == "") {
						$args["post_type"] = array('post');
					}
					else {
						$args["post_type"] = array('post','attachment');
					}
					$args['post_status'] = 'publish';		
					
					if ( !empty($cat) ) {
						$args["category__and"] = array($cat);
					}
					if ( !empty($tag_array) ) {
						if ($_REQUEST["tag_logic"] == "and") {
							$args["tag_slug__and"] = $tag_array;
						} else {
							$args["tag_slug__in"] = $tag_array;
						}
					}
					query_posts( $args );
					if ( have_posts() ) : while ( have_posts() ) : the_post();
						get_template_part( 'content', get_post_type() );
						$shownPosts[] = get_the_ID();
					endwhile; endif;
					echo "<span class='hidden debug'>sticky from this category . <br>".print_r($args,true)."</span>";

				}
				wp_reset_query(); // Reset Query
				

				/* Get all NOT sticky posts from this category */

				$args = array( 'posts_per_page' => -1 );

				if ($tag == "") {
					$args["post_type"] = array('post');
				}
				else {
					$args["post_type"] = array('post','attachment');
				}
				$args['post_status'] = 'publish';		

				if ( !empty($sticky) || !empty($shownPosts)) {
					$args['post__not_in'] = array_merge($sticky,$shownPosts);
				}
				if ( !empty($cat) ) {
					$args["category__and"] = array($cat);
				}
				if ( !empty($tag_array) ) {
					if ($_REQUEST["tag_logic"] == "and") {
						$args["tag_slug__and"] = $tag_array;
					} else {
						$args["tag_slug__in"] = $tag_array;
					}
				}
				
				query_posts( $args );
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_type() );
					$shownPosts[] = get_the_ID();
				endwhile; endif;
				wp_reset_query(); // Reset Query
				echo "<span class='hidden debug'>not sticky from this category . <br>".print_r($args,true)."</span>";

				
				/* Get posts from children of this category */
				if ($tag != "") : // show from children when tag is selected
				
					
					
					/* Get all sticky posts children of this category */
					
					$no_top_space = (count($shownPosts) == 0)?" no-top-space":"";
					echo "<div class='more-from-heading" . $no_top_space ."'><span>Mer från underkategorier</span></div>";
					$args = array( 'posts_per_page' => -1 );
					$children = array();
					if ( $cat != "" ) {
						$children =  hk_getChildrenIdArray($cat);
						if ( !empty($children) ) {
							$args['category__in'] = $children;
						}
					}
					
					if ($cat != "" && !empty($children)) {
						if (!empty($sticky)) {
							if ($tag == "") {
								$args["post_type"] = array('post');
							}
							else {
								$args["post_type"] = array('post','attachment');
							}
							$args['post_status'] = 'publish';		
							$args['post__in'] = $sticky;
							if ( !empty($tag_array) ) {
								if ($_REQUEST["tag_logic"] == "and") {
									$args["tag_slug__and"] = $tag_array;
								} else {
									$args["tag_slug__in"] = $tag_array;
								}
							}
							if (!empty($shownPosts)) {
								$args['post__not_in'] = $shownPosts;
							}
							query_posts( $args );
							if ( have_posts() ) : while ( have_posts() ) : the_post();
								get_template_part( 'content', get_post_type());
								$shownPosts[] = get_the_ID();
							endwhile; endif;
							wp_reset_query(); // Reset Query
							echo "<span class='hidden debug'>sticky from children category . <br>".print_r($args,true)."</span>";
						}
						
						/* Get all NOT sticky posts children of this category */
						$args = array( 'category__in' => $children);
						if ($tag == "") {
							$args['posts_per_page'] = $posts_per_page;
							$args["post_type"] = array('post');
						}
						else {
							$args["post_type"] = array('post','attachment');
							$args['posts_per_page'] = -1;
						}
						$args['post_status'] = 'publish';
						if ( !empty($sticky) || !empty($shownPosts)) {
							$args['post__not_in'] = array_merge($sticky,$shownPosts);
						}
						if ( !empty($tag_array) ) {
							if ($_REQUEST["tag_logic"] == "and") {
								$args["tag_slug__and"] = $tag_array;
							} else {
								$args["tag_slug__in"] = $tag_array;
							}
						}
						query_posts( $args );
						if ( have_posts() ) : while ( have_posts() ) : the_post();
							get_template_part( 'content', get_post_type() );
							$shownPosts[] = get_the_ID();
						endwhile; endif;
						wp_reset_query(); // Reset Query
						echo "<span class='hidden debug'>not sticky from children category . <br>".print_r($args,true)."</span>";
					}
				
				endif; 
			endif;
			/****Default order END***/

		else :

			/* otherwise start standard Loop if orderby is set */ 
			while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_type() );
				$shownPosts[] = get_the_ID();
			endwhile;
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

		//hk_content_nav( 'nav-below' );
		//print_r($wp_query);

		/* help text if nothing is found */
		if (empty($shownPosts)) {
			hk_empty_navigation();
		} ?>

	</div><!-- #content -->

	<?php
	/* help text anyway if something is found */
	if (!empty($shownPosts)) {
		//hk_category_help_navigation(); 
	}
	?>
	
</div><!-- #primary -->