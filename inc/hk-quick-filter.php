<?php 

    $query_categories = $_GET['cat'];

    $category_slug = get_the_category_by_id( get_query_var("cat"));
    $category = get_category_by_slug($category_slug);

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


    // All categories which are going to be displayed in the filter
    if ( !empty ( $child_categories ) ){
        foreach ( $child_categories as $child_category ){

            // Puts category in array if the category is a top level category
            if ($category->term_id === $child_category->category_parent) {
                $filter_category_list[] = hk_get_child_categories($child_category);
            }

        }
    }

    // The categories to display in the feed
    if ( !empty ( $child_categories ) ){
        foreach ( $child_categories as $child_category ){
            $category_list[] = $child_category->term_id;
        }
    }
    

    $wp_api_settings_array = [
        'root' => esc_url_raw( rest_url() ),
        'assetUrl' => get_bloginfo( 'template_url' ) . '/assets/',
        'nonce' => wp_create_nonce( 'wp_rest' ),
        'category' => $category,
        'categoryChildren' => $filter_category_list
    ];

    wp_localize_script( 'hultsfred_js', 'WP_API_ENV', $wp_api_settings_array );


?>

<div id="quick-vue-wrapper" class="cf" v-cloak>

    <div class="quick-filter cf">

        <?php if(!empty($filter_category_list)) : ?>

            <h3 class="quick-filter__title"><?php echo $category->name ?>:</h3>
            
            <div class="quick-filter__filter-wrapper">
                
                <button class="quick-filter__shape quick-filter__button" @click="toggleFilterDropdown($event)">
                    
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

                <div class="quick-filter-dropdown" :class="{'quick-filter-dropdown--visible': filterDropdownOpen}" @click="$event.stopPropagation()">

                    <ul class="quick-filter-dropdown__list">

                        <?php 
                            
                            foreach ($filter_category_list as $filter_category) :

                                $category_json = [
                                    'name' => $filter_category->name,
                                    'id' => $filter_category->term_id
                                ];

                                if (!empty($filter_category->child_categories)) {
                                    $category_json['children'] = $filter_category->child_categories;
                                }
                                
                                $category_json = json_encode($category_json);
                        ?>

                                <li>
                                
                                    <div class="cf quick-filter-dropdown__button <?php echo 'quick-filter-dropdown__button--' . $filter_category->term_id ?>"
                                        role="button"
                                        tabindex="0"
                                        @click="toggleCategoryFilter($event, <?php echo htmlspecialchars($category_json) ?>)"
                                        @keypress.enter="toggleCategoryFilter($event, <?php echo htmlspecialchars($category_json); ?>)"
                                        aria-selected="false"
                                    >
                                        <span class="quick-filter-dropdown__text"><?php echo $filter_category->name ?></span>
                                        <?php if (!empty($filter_category->child_categories)) : ?>
                                            <button class="quick-filter-dropdown__expand" @click="toggleDropdown($event)"></button>
                                            <span class="quick-filter-dropdown__checkbox"></span>
                                        <?php else: ?>
                                            <span class="quick-filter-dropdown__checkbox"></span>
                                        <?php endif; ?>
                                    </div>



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

                    <button class="quick-filter-dropdown__close" @click="toggleFilterDropdown($event)">Stäng</button>

                </div>
                
            </div>

            <span v-for="category in filter" class="quick-filter__shape quick-filter__tag">
                {{ category.name }}
                <button @click="toggleCategoryFilter($event, category)" class="quick-filter__remove-tag"><svg width="10" height="10" viewBox="0 0 10 10" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="Canvas" transform="translate(-1282 458)"><g id="close"><g id="Vector"><use xlink:href="#close_stroke" transform="translate(1284 -456)"/></g><g id="Vector"><use xlink:href="#close2_stroke" transform="translate(1284 -456)"/></g></g></g><defs><path id="close_stroke" d="M 0.53033 -0.53033L -9.53674e-09 -1.06066L -1.06066 -9.53674e-09L -0.53033 0.53033L 0.53033 -0.53033ZM 5.46967 6.53033L 6 7.06066L 7.06066 6L 6.53033 5.46967L 5.46967 6.53033ZM -0.53033 0.53033L 5.46967 6.53033L 6.53033 5.46967L 0.53033 -0.53033L -0.53033 0.53033Z"/><path id="close2_stroke" d="M -0.53033 5.46967L -1.06066 6L -9.53674e-09 7.06066L 0.53033 6.53033L -0.53033 5.46967ZM 6.53033 0.53033L 7.06066 -9.53674e-09L 6 -1.06066L 5.46967 -0.53033L 6.53033 0.53033ZM 0.53033 6.53033L 6.53033 0.53033L 5.46967 -0.53033L -0.53033 5.46967L 0.53033 6.53033Z"/></defs></svg></button>
            </span>
 
        <?php else: ?>

            <h2 class="quick-filter__title quick-filter__title--large"><?php echo $category->name ?></h2>

        <?php endif; ?>

    </div>


    <div class="quick-posts-wrapper quick-filter-article">

        <div class="quick-posts">
    
            <div v-if="filteredPosts.length > 0">
                <a v-for="post in filteredPosts" :href="post.permalink" class="quick-filter-article quick-post one-third">
                    <div class="featured-image slide">
                        <img :src="post.image_url" alt="">
                    </div>
                    <h2 class="quick-filter-article__title">{{ post.post_title }}</h2>
                    <p class="quick-filter-article__excerpt">{{ post.post_content.substr(0, 100) }}</p>
                </a>
            </div>

            <div v-else>

                <h2 v-if="filter.length > 0" class="quick-filter-article__no-posts">Det finns tyvärr inga artiklar som matchar med den nuvarande filtreringen.</h2>

                <a v-else v-for="post in posts" :href="post.permalink" class="quick-filter-article quick-post one-third">
                    <div class="featured-image slide">
                        <img :src="post.image_url" alt="">
                    </div>
                    <h2 class="quick-filter-article__title">{{ post.post_title }}</h2>
                    <p class="quick-filter-article__excerpt">{{ post.post_content.substr(0, 100) }}</p>
                </a>
            
            </div>

            <h2 v-if="posts.length < 0" class="quick-filter-article__no-posts">Det finns tyvärr inga artiklar som matchar med den nuvarande filtreringen.</h2>

        </div>

    </div>

</div>


<?php 

    $all_posts = array();

    function hk_get_child_categories($category) {

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


        $posts_args = array(
            'posts_per_page'        => 99,
            'cat'                   => $category->term_id,
            'post_type'             => 'post',
            'post_status'           => 'publish',
            'suppress_filters'      => true
        );

        $posts = get_posts( $posts_args );

        foreach ($posts as $post) {
            // $post->category = $category->term_id;
            $post_categories = get_the_category($post->ID);

            $post->categories = [];
            
            foreach ($post_categories as $post_category) {
                $post->categories[] = $post_category->term_id;
            }

            $post->image_url = get_field('hk_featured_images', $post->ID)[0]['hk_featured_image']['sizes']['thumbnail-image'];
            $post->permalink = get_permalink($post->ID);

            $regex = '#(<h([1-6])[^>]*>)\s?(.*)?\s?(<\/h\2>)#';
            $post->post_content = preg_replace( $regex, '', $post->post_content );
            $post->post_content = preg_replace('/&nbsp;/', '', $post->post_content);
            $post->post_content = trim($post->post_content);
        }

        $category->posts = $posts;


        if (empty($child_categories)) return $category;        

        $category->child_categories = array();

        foreach ($child_categories as $child_category) {
            if ($category->term_id === $child_category->category_parent) {
                $category->child_categories[] = hk_get_child_categories($child_category);
            }
        }

        return $category;
    }

    function hk_display_child_categories($category) {

        $child_categories = $category->child_categories;


        $category_json = [
            'name' => $category->name,
            'id' => $category->term_id
        ];

        if (!empty($child_categories)) {
            $category_json['children'] = $child_categories;
        }
        
        $category_json = json_encode($category_json);


        $return_string = '';

        $return_string .= '
                <li>
                    <div class="cf quick-filter-dropdown__button quick-filter-dropdown__button--' . $category->term_id . '"
                    role="button" 
                    tabindex="0" 
                    @click="toggleCategoryFilter($event, ' . htmlspecialchars($category_json) . ')"
                    @keypress.enter="toggleCategoryFilter($event, ' . htmlspecialchars($category_json) . ')"
                    aria-selected="false">
                        <span class="quick-filter-dropdown__text">' . $category->name . '</span>';
        
        if ( !empty($child_categories) ) {
            $return_string .= '<button class="quick-filter-dropdown__expand" @click="toggleDropdown($event)"></button>';
            $return_string .= '<span class="quick-filter-dropdown__checkbox"></span>';
        } else {
            $return_string .= '<span class="quick-filter-dropdown__checkbox"></span>';    
        }

        $return_string .= '</div>';

        if ( !empty($child_categories) ) {
            $return_string .= '<ul class="quick-filter-dropdown__sub-list">';
        }

        if (!empty($child_categories)) {
            foreach ($child_categories as $child_category) {
                $return_string .= hk_display_child_categories($child_category);
            }
        }

        $return_string .= '</li>';

        if ( !empty($child_categories) ) {
            $return_string .= '</ul>';
        }
        
        return $return_string;

    }

?>