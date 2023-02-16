	<?php
		/*
		 * if not is sub start page
		 */

		global $default_settings;
        $category_as_filter = $default_settings["category_as_filter"];
        $category_show_children = $default_settings["category_show_children"];


        // if filter is enabled on category (ACF in category)
        if ($category_as_filter) {
            echo "Kategorifilter &auml;r p&aring; (fungerar inte &auml;n)." . $category_as_filter . " (visa underliggande kategorier: " . $category_show_children . ")";
        }

		if (!is_sub_category_firstpage()) {

			if ($cat != "") {
                // get query args for category
                $args = hk_getCatQueryArgs($cat, $paged, $category_show_children, (!empty($_REQUEST["orderby"]))?$_REQUEST["orderby"]:'', "", (!empty($_REQUEST["current-category-filter"]))?$_REQUEST["current-category-filter"]:'');
                query_posts( $args );

            } // end if cat is set

			?>
			<div id="breadcrumb" class="<?php echo ($wp_query->post_count <= 1 && $wp_query->max_num_pages == 1)?"one_article ":""; ?>breadcrumb"><?php hk_breadcrumb(); ?><?php hk_postcount() ?></div>


			<?php
        } // end if !is_sub_category_firstpage ?>

	<div id="primary" class="primary">

        <div id="content" role="main">

        <?php
            /* show if not is sub_sub */
            if (!is_sub_sub_category_firstpage()) {
                $countposts = 0;
                $shownPosts = array();
                if ($cat != "") {
                    if ( have_posts() ) {
                        while ( have_posts() ) {
                            the_post();
                            if (!in_array(get_the_ID(), $shownPosts)) {
                                if ($wp_query->post_count == 1 && $wp_query->max_num_pages == 1) {
                                    get_template_part( 'content', 'single' );
                                }
                                else {
                                    get_template_part( 'content', get_post_type() );
                                }
                                $shownPosts[] = get_the_ID();
                            }
                        }
                    }
                }

                echo "<div id='shownposts' class='hidden' data-shownposts='" . implode(",", $shownPosts) . "'></div>";
                hk_content_nav( 'nav-below' );

                /* help text if nothing is found */
                if (empty($shownPosts)) {
                    hk_empty_navigation();
                }
            }
        ?>

	</div><!-- #content -->



</div><!-- #primary -->
