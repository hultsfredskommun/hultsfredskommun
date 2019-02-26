<?php


    $query_categories = $_GET['cat'];

    $category = get_category_by_slug( get_the_category()[0]->slug );

    $args = array(
        'type'                     => 'post',
        'child_of'                 => $category->term_id,
        'orderby'                  => 'name',
        'order'                    => 'ASC',
        'hide_empty'               => FALSE,
        'hierarchical'             => 1,
        'taxonomy'                 => 'category',
    );
    $child_categories = get_categories( $args );

    $category_list = array();
    $category_list[] = $category->term_id;

    $filter_category_list = array();

    // All categories which are going to be displayed in the filter
    if ( !empty ( $child_categories ) ){
        foreach ( $child_categories as $child_category ){

            // Puts category in array if the category is a top level category
            if ($category->term_id === $child_category->category_parent) {
                $filter_category_list[] = hk_get_child_categories($child_category, $query_categories);
            }

        }
    }

    // The categories to display in the feed
    if ( !empty ( $child_categories ) ){
        foreach ( $child_categories as $child_category ){

            if (!empty($query_categories)) {
                foreach ($query_categories as $query_category) {
                    if ($child_category->term_id = $query_category) {
                        $category_list[] = $child_category->term_id;
                    }
                }
            } else {
                $category_list[] = $child_category->term_id;
            }

        }
    }

?>

<div class="quick-filter">

    <?php if(!empty($filter_category_list)) : ?>

        <h3 class="quick-filter__title"><?php echo $category->name ?>:</h3>

        <div class="quick-filter__filter-wrapper">

            <button class="quick-filter__shape quick-filter__button">

                Filter

                <svg width="18" height="14" viewBox="0 0 18 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Canvas" transform="translate(-1079 461)">
                        <g id="ios-settings-strong">
                            <g id="Group">
                                <g id="Vector">
                                    <use xlink:href="#path0_fill" transform="translate(1079 -450.182)" fill="#FFFFFF"/>
                                </g>
                                <g id="Vector">
                                    <use xlink:href="#path1_fill" transform="translate(1079 -455.591)" fill="#FFFFFF"/>
                                </g>
                                <g id="Vector">
                                    <use xlink:href="#path0_fill" transform="translate(1079 -461)" fill="#FFFFFF"/>
                                </g>
                            </g>
                        </g>
                    </g>
                    <defs>
                        <path id="path0_fill" d="M 0 0.954545L 11.3846 0.954545C 11.6331 0.393273 12.1995 0 12.8571 0C 13.5148 0 14.0812 0.393273 14.3297 0.954545L 18 0.954545L 18 2.22727L 14.3297 2.22727C 14.0811 2.78855 13.5148 3.18182 12.8571 3.18182C 12.1995 3.18182 11.6331 2.78855 11.3846 2.22727L 0 2.22727"/>
                        <path id="path1_fill" d="M 0 0.954545L 3.67031 0.954545C 3.91886 0.393273 4.48517 0 5.14286 0C 5.80054 0 6.3669 0.393273 6.6154 0.954545L 18 0.954545L 18 2.22727L 6.6154 2.22727C 6.36686 2.78855 5.80054 3.18182 5.14286 3.18182C 4.48517 3.18182 3.91882 2.78855 3.67031 2.22727L 0 2.22727"/>
                    </defs>
                </svg>

            </button>

            <div class="quick-filter-dropdown">

                <ul class="quick-filter-dropdown__list">

                    <?php

                        foreach ($filter_category_list as $filter_category) :

                            $is_in_query = false;

                            $query_string = '';
                            if (!empty($query_categories)) {
                                foreach ($query_categories as $query_category) {
                                    if ($query_category != $filter_category->term_taxonomy_id) $query_string .= '&cat[]=' . $query_category;
                                    else $is_in_query = true;
                                }
                            }

                            if ($is_in_query) $new_query_string = '?' . $query_string;
                            else $new_query_string = '?cat[]='. $filter_category->term_taxonomy_id . $query_string;

                            if (!empty($filter_category->child_categories)) {
                                $top_level_query_string = hk_create_top_level_query_string($filter_category, $query_categories);
                                $new_query_string .= $top_level_query_string;
                            }

                    ?>

                            <li>
                                <a class="cf" href="<?php echo $new_query_string ?>">
                                    <span class="quick-filter-dropdown__text"><?php echo $filter_category->name ?></span>
                                    <?php if (!empty($filter_category->child_categories)) : ?>
                                        <button class="quick-filter-dropdown__expand"></button>
                                    <?php else: ?>
                                        <span class="quick-filter-dropdown__checkbox <?php if($is_in_query) : echo 'quick-filter-dropdown__checkbox--checked'; endif; ?>"></span>
                                    <?php endif; ?>
                                </a>

                                <?php if (!empty($filter_category->child_categories)) : ?>
                                    <ul class="quick-filter-dropdown__sub-list">
                                    <?php

                                        foreach ($filter_category->child_categories as $filter_child_category) {

                                            echo hk_display_child_categories($filter_child_category, $query_categories);

                                        }

                                    ?>
                                    </ul>
                                <?php endif; ?>


                            </li>

                    <?php

                        endforeach;

                    ?>

                </ul>

                <button class="quick-filter-dropdown__close">Stäng</button>

            </div>

        </div>

        <div class="quick-filter__tag-wrapper">

            <?php

                if (!empty($query_categories)) :

                    foreach ($query_categories as $query_category) :

                        $tag_category = get_the_category_by_ID($query_category);

                        $query_string = '';

                        foreach ($query_categories as $query_category_2) {
                            if ($query_category != $query_category_2) $query_string .= '&cat[]=' . $query_category_2;
                        }

                        if ($query_string == '') $query_string = '?';

                ?>

                        <span class="quick-filter__shape quick-filter__tag">
                            <?php echo $tag_category ?>
                            <a href="?<?php echo $query_string ?>" class="quick-filter__remove-tag"><svg width="10" height="10" viewBox="0 0 10 10" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Canvas" transform="translate(-1282 458)"><g id="close"><g id="Vector"><use xlink:href="#close_stroke" transform="translate(1284 -456)"/></g><g id="Vector"><use xlink:href="#close2_stroke" transform="translate(1284 -456)"/></g></g></g><defs><path id="close_stroke" d="M 0.53033 -0.53033L -9.53674e-09 -1.06066L -1.06066 -9.53674e-09L -0.53033 0.53033L 0.53033 -0.53033ZM 5.46967 6.53033L 6 7.06066L 7.06066 6L 6.53033 5.46967L 5.46967 6.53033ZM -0.53033 0.53033L 5.46967 6.53033L 6.53033 5.46967L 0.53033 -0.53033L -0.53033 0.53033Z"/><path id="close2_stroke" d="M -0.53033 5.46967L -1.06066 6L -9.53674e-09 7.06066L 0.53033 6.53033L -0.53033 5.46967ZM 6.53033 0.53033L 7.06066 -9.53674e-09L 6 -1.06066L 5.46967 -0.53033L 6.53033 0.53033ZM 0.53033 6.53033L 6.53033 0.53033L 5.46967 -0.53033L -0.53033 5.46967L 0.53033 6.53033Z"/></defs></svg></a href="">
                        </span>

                <?php

                    endforeach;
                endif;
            ?>

        </div>

    <?php else: ?>

        <h2 class="quick-filter__title quick-filter__title--large"><?php echo $category->name ?></h2>

    <?php endif; ?>

</div>


<div class="quick-posts-wrapper quick-filter-article">

    <div class="quick-posts">

        <?php

            $posts_args = array(
                'posts_per_page'        => 10,
                'cat'                   => $category->term_id,
                'post_type'             => 'post',
                'post_status'           => 'publish',
                'suppress_filters'      => true
            );

            $posts = new WP_Query ( $posts_args );

            if ( $posts->have_posts() ) :

                while ( $posts->have_posts() ) :

                    $posts->the_post();
                    $category_array = array();
                    $post_categories = get_the_category ( get_the_ID() );

                    if ( !empty ( $post_categories ) ){

                        foreach ( $post_categories as $post_category ) {
                            $category_array[] = $post_category->term_id;
                        }

                    }

                    // Checks if post has an additional category
                    $result = array_diff( $category_array,  $category_list   );

                    if ( empty( $result ) ) :

                        $image = get_field('hk_featured_images', $post->id)[0]['hk_featured_image']['sizes']['thumbnail-image'];

                ?>

                        <a href="<?php echo get_permalink() ?>" class="quick-filter-article quick-post one-third">
                            <div class="featured-image slide">
                                <img src="<?php echo $image ?>" alt="">
                            </div>
                            <h2 class="quick-filter-article__title"><?php the_title(); ?></h2>
                            <p class="quick-filter-article__excerpt"><?php echo wp_trim_words($post->post_content, 10) ?></p>
                        </a>

        <?php

                    endif;
                endwhile;
            endif;

            wp_reset_postdata();

        ?>

    </div>

</div>


<?php

    function hk_get_child_categories($category, $query_categories) {

        $get_child_categories_args = array(
            'type'                     => 'post',
            'child_of'                 => $category->term_id,
            'orderby'                  => 'name',
            'order'                    => 'ASC',
            'hide_empty'               => FALSE,
            'hierarchical'             => 1,
            'taxonomy'                 => 'category',
        );

        $child_categories = get_categories( $get_child_categories_args );

        if (empty($child_categories)) return $category;

        $category->child_categories = array();

        foreach ($child_categories as $value) {

            if (!empty($query_categories)) {
                foreach ($query_categories as $query_category) {
                    if ($value->term_id == $query_category) $value->is_in_query = true;
                    // else $value->is_in_query = false;
                }
            }
            if ($category->term_id === $value->category_parent) {
                $category->child_categories[] = hk_get_child_categories($value, $query_categories);
            }

        }

        // echo '<pre>';
        // print_r($category);
        // echo '</pre>';

        return $category;
    }

    function hk_display_child_categories($category, $query_categories) {

        $child_categories = $category->child_categories;



        $is_in_query = '';

        $query_string = '';
        if (!empty($query_categories)) {
            foreach ($query_categories as $query_category) {
                if ($query_category != $category->term_id) $query_string .= '&cat[]=' . $query_category;
                else $is_in_query = true;
            }
        }

        if ($is_in_query) {
            $new_query_string = '?' . $query_string;
            $is_in_query_class = 'quick-filter-dropdown__checkbox--checked';
        }
        else $new_query_string = '?cat[]='. $category->term_id . $query_string;


        $return_string = '';

        $return_string .= '
                <li>
                    <a class="cf" href="'. $new_query_string .'">
                        <span class="quick-filter-dropdown__text">' . $category->name . '</span>';

        if ( !empty($child_categories) ) {
            $return_string .= '<button class="quick-filter-dropdown__expand"></button>';
        } else {
            $return_string .= '<span class="quick-filter-dropdown__checkbox '. $is_in_query_class .'"></span>';
        }

        $return_string .= '</a>';

        if ( !empty($child_categories) ) {
            $return_string .= '<ul class="quick-filter-dropdown__sub-list">';
        }

        if (!empty($child_categories)) {
            foreach ($child_categories as $child_category) {
                $return_string .= hk_display_child_categories($child_category, $query_categories);
            }
        }

        $return_string .= '</li>';

        if ( !empty($child_categories) ) {
            $return_string .= '</ul>';
        }

        return $return_string;

    }

    function hk_create_top_level_query_string($category, $query_categories) {

        // $query_string = '?cat[]=' . $category->term_id;
        $query_string = '';

        foreach ($category->child_categories as $child_category) {
            $query_string .= hk_add_to_query_string($child_category);
        }

        return $query_string;

    }

    function hk_add_to_query_string($category) {

        $query_string = '&cat[]=' . $category->term_id;

        if (!empty($category->child_categories)) {
            foreach ($category->child_categories as $child_category) {
                $query_string .= hk_add_to_query_string($child_category);
            }
        }

        return $query_string;

    }


    /**
     * Så fort den inte är i returnerar den false
     */
    function hk_check_if_in_query_string($category) {

    }

?>
