<?php


/* REGISTER post_type hk_forum */
add_action('init', 'hk_forum_init');
function hk_forum_init() {
	// only if in admin and is administrator
    //if (is_admin() && current_user_can("administrator")) {

		register_post_type( 'hk_forum',
			array(
				'labels' => array(
					'name' => __( 'Debattforum' ),
					'singular_name' => __( 'Debattforum' ),
					'description' => 'L&auml;gg till ett foruminlägg.'
				),
				'public' => true,
				'has_archive' => true,
				'rewrite' => array('slug' => 'forum'),
				'show_ui' => true,
				'show_in_menu' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'publicly_queryable' => true,
				'query_var' => true,
				'supports' => array('title','revisions','author','custom-fields'),
				'taxonomies' => array(),
				// there are a lot more available arguments, but the above is plenty for now
			));

	//}
}

function hk_forum() {
    $debatt_query = new WP_Query( array(
        'post_type' => 'hk_forum',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
        'post_status' => 'publish',
        'ignore_sticky_posts' => true,
        'paged' => get_query_var('paged')
    ) );

    if ( $debatt_query->have_posts() ) :
        $ret = '<style>
	details.forum_expand { transition: all .3s ease-in-out;box-shadow: 1px 2px 20px 7px rgb(20 20 30 / 7%);border: 0px solid #ccc;border-radius: 4px;padding: 12px 12px 6px;margin-bottom: 24px }
    details.forum_expand:hover { box-shadow: 1px 2px 20px 7px rgb(5 5 10 / 10%);}
	details.forum_expand[open] { padding-bottom: 12px; }
	/*details.forum_expand summary { margin-bottom:8px; font-weight:600; cursor:pointer; list-style-type: disclosure-closed; }*/
    details.forum_expand summary { margin-bottom:4px; font-weight:600; cursor:pointer; }
    details.forum_expand[open] summary { padding-bottom: 12px; }
    details.forum_expand summary h3 { display: inline; }
	details.forum_expand[open] summary { list-style-type: disclosure-open; }
	
	details.forum_expand[open] p:last-child { margin-bottom: 0px; }
	/*details.forum_expand summary:first-of-type { display: list-item; counter-increment: list-item 0;  }

	details.forum_expand summary::marker {
		unicode-bidi: isolate;
		font-variant-numeric: tabular-nums;
		text-transform: none;
		text-indent: 0px !important;
		text-align: start !important;
		text-align-last: start !important;
	}*/
	details.forum_expand .date {
        font-weight: 600;
    }
    details.forum_expand hr {
        border: 0;
        border-top: 1px solid #ccc;
    }
	</style>';
        while ( $debatt_query->have_posts() ) : $debatt_query->the_post();
            $ret .= '<details class="forum_expand">';

            // fråga
            $fraga = get_the_title();
            $fraga_text = get_field('fraga');
            $datum = get_field('inkom_datum');
            $datum = ($datum) ? "Inkom den <time>$datum</time>" : "";
            $underskrift = get_field('underskrift');
            // $underskrift = ($underskrift) ? "av $underskrift" : "";
            $ret .= "<summary><h3>$fraga</h3></summary>";
            $ret .= "<p class='date'>$datum</p>";
            $ret .= $fraga_text;
            $ret .= "<p class='meta'>$underskrift</p>";
            
            // svar
            
            if (have_rows('svar')) :
                while (have_rows('svar')) : the_row();

                    // $retValue .= "<div class='quick-post  $imagesize  $column_layout  $cssclass quick-puff'><div style='$style'>";
                    $content_layout = get_row_layout();
                     
                    $svar = get_sub_field('svar');
                    $datum = get_sub_field('datum');
                    $datum = ($datum) ? "Svar den <time>$datum</time>" : "";
                    $underskrift = get_sub_field('underskrift');
                    // $underskrift = ($underskrift) ? "av $underskrift" : "";
                    $ret .= '<hr />';
                    $ret .= "<p class='date'>$datum</p>";
                    $ret .= "$svar";
                    $ret .= "<p class='meta'>$underskrift</p>";
                endwhile;
            else:
               $ret .= "<hr>Inga svar ännu."; 
            endif;
            $ret .= '</details>';

        endwhile;
        wp_reset_postdata();
        return $ret;
    else :
        return "Inga inlägg hittades.";
    endif;
}