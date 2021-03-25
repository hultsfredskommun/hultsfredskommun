	<?php
		$curr_tag = get_query_var("tag");
		if ($curr_tag != "") :
			// Get term by slug $tag in Tags taxonomy.
			$tagitem = get_term_by('slug', $curr_tag, 'post_tag');

			$newstag = "";
			$news_list_arr = explode(",", str_replace(" ", "", $hk_options["show_taglist_as_newslist"])); /* get if show tag as news list */
			if ($tagitem instanceof WP_Term) {
				$is_news_list = $default_settings["news_tag"] == $tagitem->term_id || in_array($tagitem->slug, $news_list_arr);
			} else {
				$is_news_list = false;
			}
			echo '<div id="breadcrumb" class="';
			echo ($wp_query->post_count <= 1 && $wp_query->max_num_pages == 1)?"one_article ":"";
			echo 'breadcrumb">';
			echo hk_breadcrumb();
			// if news
			if ($is_news_list) {
				echo hk_postcount();
				$newstag = "news"; /* help class for news list css */
			}
			echo '</div>';
		endif;
	?>

	<div id="primary" class="primary">

	<div id="content" class="tag-listing <?php echo $newstag . " " . $curr_tag; ?>" role="main">

	<?php

		/**
		 * Default order in orderby no set
		 */
		$shownPosts = array();
		if ($curr_tag != "") :

			// get selected category if any
			if ($cat != "") {
				$top_cat_arr = array($cat);
				$cat_title = " <strong>" . single_tag_title("",false) . "</strong>";
			}
			else {
				// get all categories with parent == 0
				foreach(get_categories(array('parent' => 0, 'hide_empty' => true)) as $c) :
					$top_cat_arr[] = $c->cat_ID;
				endforeach;
				$cat_title = "<strong>hela webbplatsen</strong>";
			}
			//$tagname =

			$tag_object = get_term_by("slug", $curr_tag, "post_tag");
			$tag_name = ($tag_object instanceof WP_Term)?$tag_object->name:'';
			?>

			<!--header class="page-header">
				<ul class="num-posts">
					<?php echo "<li><a class='nolink'>Visa bara <b>" . $curr_tag . "</b> fr&aring;n " . $cat_title . "</a></li>"; ?>
				</ul>
			</header-->
			<?php echo "<h1 class='page-title'><a class='nolink'>Visa bara <b>" . $tag_name . "</b> fr&aring;n <b>" . $cat_title . "</b></a></h1>"; ?>
			<?php
			// loop top categories (one or many)


			// if news
			if ($is_news_list) {
				//echo "news;";
				//echo $cat;
				$childrenarr =  get_categories(array('child_of' => $cat, 'hide_empty' => true));
				$children = array();
				$children[] = $cat;
				foreach($childrenarr as $child) :
					//echo $child->name . "<br>";
					$children[] = $child->cat_ID;
				endforeach;

				//print_r($children);
				$args = array( 'paged' => $paged,
				//'posts_per_page' => 100,
				'ignore_sticky_posts' => 1,
				'orderby' => 'date',
				'order' => 'DESC',);

				$args["category__in"] = $children;
				$args["tag_slug__in"] = explode(",",$curr_tag);

				//print_r($args);
				query_posts( $args );
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						get_template_part( 'content', 'news' );
						$shownPosts[] = get_the_ID();

					endwhile;

				endif;
			}
			// else not news
			else {
				$lastsub = 0;
				// loop through top meny - invånare, företagare m.m.
				//foreach($top_cat_arr as $cat) :

					// get child categories and include parent cat in children array

					$childrenarr =  get_categories(array('child_of' => $cat, 'hide_empty' => true,'orderby' => 'name','order' => 'ASC'));
					$children = array();
					if (!empty($cat)) {
						$children[] = $cat;
					}
					foreach($childrenarr as $child) :
						//echo $child->name . "<br>";
						if ($child->cat_ID != 1) { // remove "ej synlig"
							$children[] = $child->cat_ID;
						}
					endforeach;


					// echo "<div style='display:none'>jonastest";
					// //echo " hk_getChildrenIdArray: ";
					// //print_r(hk_getChildrenIdArray($cat));
					// // echo " ch: ";
					// // print_r($ch);
					// echo " children: ";
					// print_r($children);


					$args = array( 'posts_per_page' => -1,
					'ignore_sticky_posts' => 1,
					'orderby' => 'title',
					'order' => 'ASC',);
					if (is_array($children)) {
						$args["category__in"] = $children;
					}
					if ($curr_tag != "") {
						$args["tag_slug__in"] = explode(",",$curr_tag);
					}
					 //print_r($args);
					//echo "</div>";

					query_posts( $args );
					//echo $childcat->cat_ID;
					//print_r($children);
					if ( have_posts() ) :
						while ( have_posts() ) : the_post();
							get_template_part( 'content', 'tag' );
							$shownPosts[] = get_the_ID();
						endwhile;

					endif;


					wp_reset_query(); // Reset Query

					// echo "</div>";











					/*
					$tags_filter = get_query_var("tag");
					if (!empty($tags_filter)) {
						$tags_filter = "?tag=$tags_filter";
					}

					//print_r($children);
					// get category child posts
					foreach ($children as $childcatid) :
						$childcat = get_category($childcatid);
						$args = array( 'posts_per_page' => -1,
						'ignore_sticky_posts' => 1,
						'orderby' => 'title',
						'order' => 'ASC',);
						if ($childcat->cat_ID != "")
							$args["category__and"] = array($childcat->cat_ID);
						if ($curr_tag != "")
							$args["tag_slug__in"] = explode(",",$curr_tag);

						query_posts( $args );
						//echo $childcat->cat_ID;
						//print_r($children);
						if ( have_posts() ) :
							$catarr[] = $childcat->slug;

							foreach(hk_getParentsSlugArray($childcat->cat_ID) as $slug) :
								if (!in_array($slug,$catarr)) :
									$catarr[] = $slug;
									$c = get_category_by_slug($slug);
									$sub = hk_countParents($c->cat_ID);
									while ($sub <= $lastsub--) {
										echo "</div>";
									}
									$lastsub = $sub;
									$pre_dimmed_link = $post_dimmed_link = "";
									if (!in_array($c->cat_ID, $children)) {
										$pre_dimmed_link = "<a class='hidden dimmed-tag' href='" . get_category_link($c->cat_ID) . $tags_filter . "'>";
										$post_dimmed_link = "</a>";
									}
									echo "<h$sub class='indent$sub'>$pre_dimmed_link" . $c->name . "$post_dimmed_link</h$sub>";
									echo "<div class='wrapper$sub wrapper'>";
								endif;

							endforeach;

							$sub = hk_countParents($childcat->cat_ID);
							while ($sub <= $lastsub--) {
								echo "</div>";
							}
							$lastsub = $sub;
							echo "<h$sub class='indent$sub'>" . $childcat->name . "</h$sub>";
							echo "<div class='wrapper$sub wrapper'>";
							echo "<div class='indent$sub'>";
							while ( have_posts() ) : the_post();
								get_template_part( 'content', 'tag' );
								$shownPosts[] = get_the_ID();
							endwhile;
							echo "</div>";

						endif;

						wp_reset_query(); // Reset Query

					endforeach;
					*/

				//endforeach;
				//while (0 < $lastsub--) {
					//echo "</div>";
				//}
			} // end not news
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

		if ($is_news_list) {
			hk_content_nav( 'nav-below' );
		}
		/* help text if nothing is found */
		if (empty($shownPosts)) {
			hk_empty_navigation();
		} ?>

	</div><!-- #content -->



</div><!-- #primary -->
