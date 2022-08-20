<?php



/*
 * MELLANSTARTSIDA CONTENT WIDGET
 */
 class HK_mellanstartsida extends WP_Widget {
	protected $vars = array();

	public function __construct() {
		parent::__construct(
	 		'HK_mellanstartsida', // Base ID
			'HK mellanstartsida', // Name
			array( 'description' => "Widget som mellanstartsida från aktiv kategori" ) // Args
		);
	}

 	public function form( $instance ) {
		echo "<p><i>Inga inst&auml;llningsm&ouml;jligheter just nu.</i></p>";
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();

		return $instance;
	}

	public function widget( $args, $instance ) {
		if (function_exists('hk_view_quick_links')) {
			echo "<div class='quick-posts-widget-wrapper'>";
			echo hk_view_quick_links();
			echo "</div>";
		} else {
			echo "Det finns ingen funktion för mellanstartsida p&aring; webbplatsen. Kontakta administrat&ouml;ren!";
		}
	}
}
/* add the widget  */
add_action( 'widgets_init', function() { register_widget( "HK_mellanstartsida" ); } );



/*
 * FIRSTPAGE CONTENT WIDGET
 */
 class HK_firstpagecontent extends WP_Widget {
	protected $vars = array();

	public function __construct() {
		parent::__construct(
	 		'HK_firstpagecontent', // Base ID
			'HK f&ouml;rstasidans inneh&aring;ll', // Name
			array( 'description' => "Widget som visar huvudinneh&aring; som aktuellt och nyheter kopplat till aktiv kategori" ) // Args
		);
		$this->vars["num_aktuellt"] = "4";
		$this->vars["num_news"] = "10";
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ];
		} else { $title = ""; }

		if ( isset( $instance[ 'num_aktuellt' ] ) ) { $num_aktuellt = $instance[ 'num_aktuellt' ];
		} else { $num_aktuellt = $this->vars['num_aktuellt']; }

		if ( isset( $instance[ 'num_news' ] ) ) { $num_news = $instance[ 'num_news' ];
		} else { $num_news = $this->vars['num_news']; }

		if ( isset( $instance[ 'content_type' ] ) ) { $content_type = $instance[ 'content_type' ];
		} else { $content_type = ''; }

		if ( isset( $instance[ 'hide_more_news' ] ) ) { $hide_more_news = $instance[ 'hide_more_news' ];
		} else { $hide_more_news = ''; }

		if ( isset( $instance[ 'rss_link_text' ] ) ) { $rss_link_text = $instance[ 'rss_link_text' ];
		} else { $rss_link_text = ''; }
		if ( isset( $instance[ 'rss_link_url' ] ) ) { $rss_link_url = $instance[ 'rss_link_url' ];
		} else { $rss_link_url = ''; }

		if ( isset( $instance[ 'thumb_size' ] ) ) { $thumb_size = $instance[ 'thumb_size' ];
		} else { $thumb_size = ''; }
		if ( isset( $instance[ 'css_wrapper' ] ) ) { $css_wrapper = $instance[ 'css_wrapper' ];
		} else { $css_wrapper = ''; }


		// $options = get_option('hk_theme');

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Rubrik.</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'num_aktuellt' ); ?>">Antal inl&auml;gg i aktuellt (5 om tom).</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'num_aktuellt' ); ?>" name="<?php echo $this->get_field_name( 'num_aktuellt' ); ?>" type="text" value="<?php echo esc_attr( $num_aktuellt); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'num_news' ); ?>">Antal i nyhetslistan (10 om tom).</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'num_news' ); ?>" name="<?php echo $this->get_field_name( 'num_news' ); ?>" type="text" value="<?php echo esc_attr( $num_news); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'content_type' ); ?>">Aktuellt typ (news som standard).</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'content_type' ); ?>" name="<?php echo $this->get_field_name( 'content_type' ); ?>" type="text" value="<?php echo esc_attr( $content_type); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'hide_more_news' ); ?>">Göm nyhetslistan, och visa en "Visa fler"-länk istället (ange namnet på länken).</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'hide_more_news' ); ?>" name="<?php echo $this->get_field_name( 'hide_more_news' ); ?>" type="text" value="<?php echo esc_attr( $hide_more_news); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'rss_link_text' ); ?>">Visa en "RSS"-länk (ange namnet på länken).</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'rss_link_text' ); ?>" name="<?php echo $this->get_field_name( 'rss_link_text' ); ?>" type="text" value="<?php echo esc_attr( $rss_link_text); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'rss_link_url' ); ?>">Visa en "RSS"-länk (ange URL till flöde).</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'rss_link_url' ); ?>" name="<?php echo $this->get_field_name( 'rss_link_url' ); ?>" type="text" value="<?php echo esc_attr( $rss_link_url); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'thumb_size' ); ?>">Tumnagelstorlek (standard thumbnail-image).</label>
		<select id="<?php echo $this->get_field_id( 'thumb_size' ); ?>" name="<?php echo $this->get_field_name( 'thumb_size' ); ?>">
		<option value=''>V&auml;lj storlek</option>";
		<option <?php echo (("none" == $thumb_size)?"selected":""); ?> value='<?php echo "none" ?>'><?php echo "Ingen bild"; ?></option>
		<?php foreach (hk_get_image_sizes() as $key => $value) { ?>
			<option <?php echo (($key == $thumb_size)?"selected":""); ?> value='<?php echo $key; ?>'><?php echo $key; ?></option>
		<?php } ?>
		</select>
		<p>
		<input id="<?php echo $this->get_field_id( 'box-list' ); ?>" name="<?php echo $this->get_field_name( 'box-list' ); ?>" type="checkbox" <?php echo ($instance["box-list"] != "")?"checked":""; ?> />
		<label for="<?php echo $this->get_field_id( 'box-list' ); ?>">Visa i kolumner (2 som standard)</label>
		</p>
		<p>
		<input id="<?php echo $this->get_field_id( 'box-list-4-columns' ); ?>" name="<?php echo $this->get_field_name( 'box-list-4-columns' ); ?>" type="checkbox" <?php echo ($instance["box-list-4-columns"] != "")?"checked":""; ?> />
		<label for="<?php echo $this->get_field_id( 'box-list-4-columns' ); ?>">Visa i 4 kolumner (f&ouml;reg&aring;nde inst&auml;llning m&aring;ste vara satt p&aring; kolumner)</label>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'css_wrapper' ); ?>">Css på wrapper-element.</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'css_wrapper' ); ?>" name="<?php echo $this->get_field_name( 'css_wrapper' ); ?>" type="text" value="<?php echo esc_attr( $css_wrapper); ?>" />
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = $new_instance['title'];
		$instance['num_aktuellt'] = strip_tags( $new_instance['num_aktuellt'] );
		$instance['num_news'] = strip_tags( $new_instance['num_news'] );
		$instance['num_days_new'] = strip_tags( $new_instance['num_days_new'] );
		$instance['content_type'] = strip_tags( $new_instance['content_type'] );
		$instance['hide_more_news'] = strip_tags( $new_instance['hide_more_news'] );
		$instance['rss_link_text'] = $new_instance['rss_link_text'];
		$instance['rss_link_url'] = strip_tags( $new_instance['rss_link_url'] );
		$instance['thumb_size'] = strip_tags( $new_instance['thumb_size'] );
		$instance['box-list'] = strip_tags( $new_instance['box-list'] );
		$instance['box-list-4-columns'] = strip_tags( $new_instance['box-list-4-columns'] );
		$instance['css_wrapper'] = strip_tags( $new_instance['css_wrapper'] );


		return $instance;
	}

	public function widget( $args, $instance ) {
		global $thumb_size;
	    extract( $args );
		global $default_settings;
		// $options = get_option('hk_theme');
		if (isset($instance["title"])) $title = "<h2 class='widget-title'>" . $instance["title"] . "</h2>";
		else $title = "";
		if (isset($instance["num_aktuellt"])) $num_aktuellt = $instance["num_aktuellt"];
		else $num_aktuellt = 5;
		if (isset($instance["num_news"])) $num_news = $instance["num_news"];
		else $num_news = 10;
		if (isset($instance["content_type"])) $content_type = $instance["content_type"];
		else $content_type = "";
		if (isset($instance["hide_more_news"])) $hide_more_news = $instance["hide_more_news"];
		else $hide_more_news = "";
		if (isset($instance["rss_link_text"])) $rss_link_text = $instance["rss_link_text"];
		else $rss_link_text = "";
		if (isset($instance["rss_link_url"])) $rss_link_url = $instance["rss_link_url"];
		else $rss_link_url = "";
		if (isset($instance["thumb_size"])) $thumb_size = $instance["thumb_size"];
		else $thumb_size = "";
		if (isset($instance["css_wrapper"])) $css_wrapper = $instance["css_wrapper"];
		else $css_wrapper = "";

		$boxclass = "";
		$num_news_row = 0;
		if (isset($instance['box-list']) && $instance['box-list'] != "") {
			$boxclass = "box-list ";
			$num_news_row = 2;
			if (isset($instance['box-list-4-columns']) && $instance['box-list-4-columns'] != "") {
				$boxclass .= "cols-4 ";
				$num_news_row = 4;
			}
		}
		/* get all sub categories to use in queries */
		$cat = get_query_var("cat");
		$all_categories = hk_getChildrenIdArray($cat);
		$all_categories[] = $cat;
	?>

	<div id="content" class="newscontent-wrapper" role="main" style="<?php echo $css_wrapper; ?>">
		<?php echo $title; ?>
		<div id="newscontent" class="<?php echo $boxclass; ?>newscontent">
			<?php
				/* Query all posts with selected startpage category */
				$cat = get_query_var("cat");
				$query = array( 'posts_per_page' => $num_aktuellt,
								'category__and' => $cat,
								'tag__and' => $default_settings["news_tag"],
								'suppress_filters' => 'true',
								'orderby' => 'date',
								'order' => 'desc' );
				query_posts( $query );

				$shownposts = array();
				$countrows = 0;
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					$shownposts[] = get_the_ID();
					get_template_part( 'content', 'news' );
					if (++$countrows%$num_news_row == 0) {
						echo "<div style='clear:both' class='one-whole'></div>";
					}
				endwhile; endif;
				// Reset Query
				wp_reset_query();
			?>


			<?php
				$hiddenclass = "";
				$after_newslist = "";
				$after_newslist2 = "";

				if ($hide_more_news == "") {
					$after_newslist .= '<span class="read-more-link inline"><a class="gtm-fpcw-news-archive-link" href="' . get_tag_link($default_settings["news_tag"]) . '">Nyhetsarkiv<span class="right-icon"></span></a></span>';
				}
				else if ($hide_more_news != "") {
					$hiddenclass = "hidden";
					$after_newslist2 = '<span class="read-more-link inline"><a class="gtm-fpcw-news-archive-link" href="' . get_tag_link($default_settings["news_tag"]) . '">Nyhetsarkiv<span class="right-icon"></span></a></span>';
					$after_newslist .= "<a href='#' class='gtm-fpcw-show-more-news-link read-more-link read-more inline js-read-more-link'>$hide_more_news<span class='dropdown-icon'></span></a>";
				}
				if ($rss_link_url != "" && $rss_link_text != "") {
					$after_newslist .= "<a href='$rss_link_url' class='gtm-fpcw-rss-link read-more-link rss inline float--right'>$rss_link_text</a>";
				}

				/* Query all posts with news tag */
				if ($default_settings["news_tag"] != "" && $default_settings["news_tag"] != "0" && $num_news != 0) {
					$query = array( 'posts_per_page' => $num_news,
									'category__in' => $all_categories,
									'post__not_in' => $shownposts,
									'tag__and' => $default_settings["news_tag"],
									'suppress_filters' => 'true',
									'orderby' => 'date',
									'order' => 'desc'  );

					query_posts( $query );

					if ( have_posts() ) :
					?>
					<div id='news' class="widget read-more-widget js-read-more-widget <?php echo $hiddenclass; ?>">
						<?php if ($hide_more_news == "") { ?><h2 class='entry-title'>Fler nyheter</h2><?php } ?>
						<?php while ( have_posts() ) : the_post(); ?>
						<div class="entry-wrapper">
						<?php the_date("","<span class='time'>","</span>"); ?> <a class="gtm-fpcw-more-news-link" href="<?php the_permalink(); ?>" title="<?php the_excerpt_rss() ?>"><?php the_title(); ?></a>
						</div>
						<?php
						endwhile;
						echo $after_newslist2;
						?>
					</div>
					<?php
						echo $after_newslist;
					endif;
					?>

					<?php // Reset Query
					wp_reset_query();
				}
				if ($num_news == 0) {
					echo $after_newslist;
				}
			?>


		</div>




	</div><!-- #content -->
<?php
	}
}
/* add the widget  */
add_action( 'widgets_init', function() { register_widget( "HK_firstpagecontent" ); } );





/*
 * PROTOCOL WIDGET
 */
 class HK_protocol extends WP_Widget {
	protected $vars = array();

	public function __construct() {
		parent::__construct(
	 		'HK_protocol', // Base ID
			'HK protokoll', // Name
			array( 'description' => "Widget som visar protokoll" ) // Args
		);
		$this->vars["show_protocol"] = "";
		$this->vars["num_protocol"] = "4";
		$this->vars["title"] = "Protokoll";
	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {	$title = $instance[ 'title' ];
		} else {$title = $this->vars['title']; }

		if ( isset( $instance[ 'show_protocol' ] ) ) {	$show_protocol = $instance[ 'show_protocol' ];
		} else {$show_protocol = $this->vars['show_protocol']; }

		if ( isset( $instance[ 'num_protocol' ] ) ) { $num_protocol = $instance[ 'num_protocol' ];
		} else { $num_protocol = $this->vars['num_protocol']; }

		if ( isset( $instance[ 'show_more_link' ] ) ) { $show_more_link = $instance[ 'show_more_link' ];
		} else { $show_more_link = ""; }

		if ( isset( $instance[ 'show_time_link_url' ] ) ) { $show_time_link_url = $instance[ 'show_time_link_url' ];
		} else { $show_time_link_url = ""; }

		if ( isset( $instance[ 'show_time_link' ] ) ) { $show_time_link = $instance[ 'show_time_link' ];
		} else { $show_time_link = ""; }

		if ( isset( $instance[ 'show_all_categories' ] ) ) { $show_all_categories = $instance[ 'show_all_categories' ];
		} else { $show_all_categories = ""; }

		// $options = get_option('hk_theme');

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Rubrik i widgeten.</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_protocol' ); ?>">Visa protokollflik i kategorier (exempel 23,42,19).</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_protocol' ); ?>" name="<?php echo $this->get_field_name( 'show_protocol' ); ?>" type="text" value="<?php echo esc_attr( $show_protocol); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'num_protocol' ); ?>">Antal protokoll.</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'num_protocol' ); ?>" name="<?php echo $this->get_field_name( 'num_protocol' ); ?>" type="text" value="<?php echo esc_attr( $num_protocol); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_more_link' ); ?>">"Visa mer"-länk, ange text för vad det ska stå i länken.</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_more_link' ); ?>" name="<?php echo $this->get_field_name( 'show_more_link' ); ?>" type="text" value="<?php echo esc_attr( $show_more_link); ?>" />
		</p>
		<label for="<?php echo $this->get_field_id( 'show_time_link' ); ?>">Länknamn till sammantr&auml;destider-l&auml;nken.</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_time_link' ); ?>" name="<?php echo $this->get_field_name( 'show_time_link' ); ?>" type="text" value="<?php echo esc_attr( $show_time_link); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_time_link_url' ); ?>">Länk till sammantr&auml;destider.</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_time_link_url' ); ?>" name="<?php echo $this->get_field_name( 'show_time_link_url' ); ?>" type="text" value="<?php echo esc_attr( $show_time_link_url); ?>" />
		</p>		<p>
		<label for="<?php echo $this->get_field_id( 'show_all_categories' ); ?>">"Visa protokoll från"-lista, ange text för vad som ska stå som rubrik .</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_all_categories' ); ?>" name="<?php echo $this->get_field_name( 'show_all_categories' ); ?>" type="text" value="<?php echo esc_attr( $show_all_categories); ?>" />
		</p>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = $new_instance['title'];
		$instance['show_protocol'] = strip_tags( $new_instance['show_protocol'] );
		$instance['num_protocol'] = strip_tags( $new_instance['num_protocol'] );
		$instance['show_more_link'] = $new_instance['show_more_link'];
		$instance['show_time_link'] = $new_instance['show_time_link'];
		$instance['show_time_link_url'] = $new_instance['show_time_link_url'];
		$instance['show_all_categories'] = strip_tags( $new_instance['show_all_categories'] );
		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );
		global $default_settings;
		// $options = get_option('hk_theme');
		if ( isset( $instance[ 'title' ] ) ) { $title = $instance[ 'title' ];
		} else {$title = $this->vars['title']; }
		if ( isset( $instance[ 'show_all_categories' ] ) ) { $show_all_categories = $instance[ 'show_all_categories' ];
		} else {$show_all_categories = ""; }
		if ( isset( $instance[ 'show_more_link' ] ) ) { $show_more_link = $instance[ 'show_more_link' ];
		} else {$show_more_link = ""; }
		if ( isset( $instance[ 'show_time_link' ] ) ) { $show_time_link = $instance[ 'show_time_link' ];
		} else {$show_time_link = ""; }
		if ( isset( $instance[ 'show_time_link_url' ] ) ) { $show_time_link_url = $instance[ 'show_time_link_url' ];
		} else {$show_time_link_url = ""; }

		/* get all sub categories to use in queries */
		$showprotocol = $default_settings["protocol_cat"] != "" && $default_settings["protocol_cat"] != "0" && (!isset($instance["show_protocol"]) || $instance["show_protocol"] == "" || in_array(get_query_var("cat"), explode(",",$instance["show_protocol"])));
		?>

		<?php if ($showprotocol) : ?>

			<?php echo $before_widget; ?>
			<?php echo $before_title . $title . $after_title; ?>
			<div id="protocolwidget" class="protocolwidget">
				<ul>
				<?php
					/* Query all posts with selected startpage category */
						$children =  hk_getChildrenIdArray($default_settings["protocol_cat"]);
						$children[] =  $default_settings["protocol_cat"];
						$query = array( 'posts_per_page' => $instance["num_protocol"],
										'category__in' => $children,
										'orderby' => 'date',
										'order' => 'desc',
										'suppress_filters' => 1);

						query_posts( $query );

						if ( have_posts() ) :  while ( have_posts() ) : the_post();
							$title = get_the_title();
							$date = substr($title,strrpos($title, " ")+1);
							$datearr = explode("-",$date);
							$subtitle = "";
							if (checkdate($datearr[1],$datearr[2],$datearr[0])) {
								$title = substr($title, 0, strrpos($title, " "));
								$subtitle = "M&ouml;tesdatum " . $date;
							}
							?>
							<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<a href="<?php the_permalink(); ?>" class="gtm-protocol-link link" title="<?php echo get_the_excerpt(); // printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
							<?php
								echo $title;
								if ($subtitle != "") {
									echo "<span class='subtitle'>$subtitle</span>";
								} ?>
							</a>
							<span class='hidden article_id'><?php the_ID(); ?></span>
							</li><!-- #post-<?php the_ID(); ?> -->

							<?php //get_template_part( 'content', 'single-line' );
						endwhile; endif;
						// Reset Query
						wp_reset_query();
				?>
				<?php if ($show_more_link != "") :
					$cat_link = esc_url(get_category_link($default_settings["protocol_cat"]));

					?>
					<li id="protocollink">
						<?php echo "<a class='gtm-protocol-more-link' href='$cat_link' title='".strip_tags($show_more_link)."'>$show_more_link</a>"; ?>
					</li>
				<?php endif; ?>
				<?php if ($show_time_link != "" && $show_time_link_url != "") :
					?>
					<li id="protocoltimelink">
						<?php echo "<a class='gtm-protocol-time-link' href='$show_time_link_url' title='".strip_tags($show_time_link)."'>$show_time_link</a>"; ?>
					</li>
				<?php endif; ?>
				</ul>
				<?php if ($show_all_categories != "") : ?>
					<div id="protocolcategories">
						<div class="entry-title"><?php echo $instance["show_all_categories"]; ?></div><ul>
						<?php
						 $args = array(
							'hide_empty'         => 0,
							'orderby'            => 'name',
							'order'              => 'asc',
							'style'              => 'list',
							'child_of'           => $default_settings["protocol_cat"],
							'hierarchical'       => true,
							'title_li'           => "",
							'echo'               => 1,
							'taxonomy'           => 'category',
							);
							wp_list_categories($args);
						?>
						</ul>
					</div>
				<?php endif; ?>

			</div>
			<?php echo $after_widget; ?>
		<?php endif; ?>
<?php
	}
}
/* add the widget  */
add_action( 'widgets_init', function() { register_widget( "HK_protocol" ); } );





/*
 * MENU IN WIDGET
 */
//  class HK_menuwidget extends WP_Widget {
// 	protected $vars = array();

// 	public function __construct() {
// 		parent::__construct(
// 	 		'HK_menuwidget', // Base ID
// 			'HK meny i widget', // Name
// 			array( 'description' => "Widget som vald meny" ) // Args
// 		);


// 	}

//  	public function form( $instance ) {
// 		if ( isset( $instance[ 'title' ] ) ) {	$title = $instance[ 'title' ];
// 		} else { $title = ""; }
// 		if ( isset( $instance[ 'icon' ] ) ) {	$icon = $instance[ 'icon' ];
// 		} else { $icon = ""; }
// 		if ( isset( $instance[ 'menu' ] ) ) {	$menu = $instance[ 'menu' ];
// 		} else {$menu = ""; }

/*		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Meny rubrik</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'icon' ); ?>">Meny ikon</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>" type="text" value="<?php echo esc_attr( $icon); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'menu' ); ?>">V&auml;lj menu.</label>
		<?php $locations = wp_get_nav_menus(); ?>
		<select class="widefat" id="<?php echo $this->get_field_id( 'menu' ); ?>" name="<?php echo $this->get_field_name( 'menu' ); ?>">
		<?php foreach($locations as $key => $value) : ?>
			<option <?php echo ($value->name == $menu)?"selected='selected'":""; ?>><?php echo $value->name; ?></option>
		<?php endforeach; ?>
		</select>
		</p>


		<?php */
// 	}

// 	public function update( $new_instance, $old_instance ) {
// 		$instance = array();
// 		$instance['title'] = strip_tags( $new_instance['title'] );
// 		$instance['icon'] = $new_instance['icon'];
// 		$instance['menu'] = strip_tags( $new_instance['menu'] );

// 		return $instance;
// 	}

// 	public function widget( $args, $instance ) {
// 	    extract( $args );


// 		if ( isset($instance["menu"]) ) {
// 			$title = apply_filters( 'widget_title', $instance['title'] );
// 			echo $before_widget;
// 			if ( ! empty( $title ) ) {
// 				echo $before_title . $instance['icon'] . $title . $after_title;
// 			}

// 			wp_nav_menu( array(
// 				'menu' => $instance["menu"],
// 				'container' 	=> '',
// 				'items_wrap'	=> '<ul>%3$s</ul>',
// 				'depth' 		=> -1,
// 				'echo' 			=> true
// 			));
// 			echo $after_widget;
// 		}

// 	}
// }
// /* add the widget  */
// add_action( 'widgets_init', function() { register_widget( "HK_menuwidget" ); } );



/*
 * TEXT IN WIDGET
 */
 class HK_textwidget extends WP_Widget {
	protected $vars = array();

	public function __construct() {
		parent::__construct(
	 		'HK_textwidget', // Base ID
			'HK text i widget', // Name
			array( 'description' => "Widget med fri text och html" ) // Args
		);


	}

 	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {	$title = $instance[ 'title' ];
		} else { $title = ""; }
		if ( isset( $instance[ 'image' ] ) ) {	$image = $instance[ 'image' ];
		} else { $image = ""; }
		if ( isset( $instance[ 'background' ] ) ) {	$background = $instance[ 'background' ];
		} else { $background = ""; }
		if ( isset( $instance[ 'color' ] ) ) {	$color = $instance[ 'color' ];
		} else { $color = ""; }
		if ( isset( $instance[ 'text' ] ) ) {	$text = $instance[ 'text' ];
		} else {$text = ""; }
		if ( isset( $instance[ 'popuptext' ] ) ) {	$popuptext = $instance[ 'popuptext' ];
		} else {$popuptext = ""; }
		if ( isset( $instance[ 'href' ] ) ) {	$href = $instance[ 'href' ];
		} else {$href = ""; }
		if ( isset( $instance[ 'show_widget_in_cat' ] ) ) {	$show_widget_in_cat = $instance[ 'show_widget_in_cat' ];
		} else { $show_widget_in_cat = ""; }
		if ( isset( $instance[ 'alt' ] ) ) {	$alt = $instance[ 'alt' ];
		} else { $alt = ""; }

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Rubrik</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'image' ); ?>">Bild</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" type="text" value="<?php echo esc_attr( $image); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'alt' ); ?>">Alternativtext till bild, s&auml;tts annars till "L&auml;nk till &lt;url&gt;"</label>
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'alt' ); ?>" name="<?php echo $this->get_field_name( 'alt' ); ?>"><?php echo $alt; ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'background' ); ?>">Bakgrundsf&auml;rg</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'background' ); ?>" name="<?php echo $this->get_field_name( 'background' ); ?>" type="text" value="<?php echo esc_attr( $background); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'color' ); ?>">Textf&auml;rg</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'color' ); ?>" name="<?php echo $this->get_field_name( 'color' ); ?>" type="text" value="<?php echo esc_attr( $color); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'text' ); ?>">Text</label>
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'popuptext' ); ?>">Text som popar upp vid klick</label>
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'popuptext' ); ?>" name="<?php echo $this->get_field_name( 'popuptext' ); ?>"><?php echo $popuptext; ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'href' ); ?>">L&auml;nk</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'href' ); ?>" name="<?php echo $this->get_field_name( 'href' ); ?>" type="test" value="<?php echo esc_attr($href); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_wp_feed' ); ?>">Visa bara i kategori (i formen 23,42,19)</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_widget_in_cat' ); ?>" name="<?php echo $this->get_field_name( 'show_widget_in_cat' ); ?>" type="text" value="<?php echo esc_attr( $show_widget_in_cat); ?>" />
		</p>


		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = $new_instance['title'];
		$instance['image'] = $new_instance['image'];
		$instance['background'] = $new_instance['background'];
		$instance['color'] = $new_instance['color'];
		$instance['text'] =  $new_instance['text'];
		$instance['popuptext'] =  $new_instance['popuptext'];
		$instance['href'] =  $new_instance['href'];
		$instance['show_widget_in_cat'] = strip_tags( $new_instance['show_widget_in_cat'] );
		$instance['alt'] = strip_tags( $new_instance['alt'] );

		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );
      $image_style = '';
		if  ($instance["show_widget_in_cat"] == "" || in_array(get_query_var("cat"), explode(",",$instance["show_widget_in_cat"]))) { /* IF SHOW IN CAT*/
			echo $before_widget;
			$alt = $instance["alt"];
			if ($alt == "") {
				$alt = $instance["alt"];
			}
			if ($alt == "") {
				if ($instance["href"] != "") {
					$alt = "L&auml;nk till " . $instance["href"];
				}
				else {
					$alt = "Widgetbild";
				}
			}

			if ($instance["popuptext"] != "") {
				$popupclass = "class='gtm-text-widget-popup gtm-text-widget-link js-text-widget-popup'";
			} else {
				$popupclass = "class='gtm-text-widget-link'";
			}
			if ( $instance["title"] == "" && $instance["text"] == "" && $instance["href"] != "" && $instance["image"] != "" ) {
				echo "<a $popupclass style='max-width: 100%; color: $color;' href='".$instance["href"]."'>";
				echo "<img class='image' src='" .$instance["image"]. "' alt='$alt' title='$alt' />";
				echo "</a>";
			}
			else if ( $instance["text"] != "" || $instance["title"] != "" ) {
				$title = $instance['title'];
				$background = $instance["background"];
				$color = $instance["color"];


				if ($instance["image"] != "") {
					$image_style = "background-image: url(" . $instance["image"] . ");";
				}
				echo "<div class='inner-wrapper' style='background-color: $background; color: $color;$image_style'>";
				if ( ! empty( $title ) ) {
					if ($instance["popuptext"] != "" || $instance["href"] != "") {
						echo "<a $popupclass style='color: $color;' href='".$instance["href"]."'>";;
					}
					echo $before_title . $title . $after_title;
					if ($instance["popuptext"] != "" || $instance["href"] != "") {
						echo "</a>";
					}
				}

				echo "<div class='content'>";
				if ($instance["popuptext"] != "" || $instance["href"] != "") {
					echo "<a $popupclass style='color: $color;' href='".$instance["href"]."'>";
				}
				echo do_shortcode($instance["text"]);
				if ($instance["popuptext"] != "" || $instance["href"] != "") {
					echo "</a>";
				}
				echo "</div>";


				echo "</div>";

			}

			if ($instance["popuptext"] != "") {
				echo "<div class='hidden overlay form-popup popuptext'>";
					echo "<div class='box form-popup'>";
						echo "<div class='close-contact close-popup'></div>";
						echo "<div class='entry-wrapper'>";
							echo "<div class='entry-content'>";
								echo do_shortcode($instance["popuptext"]);
				echo "</div></div></div></div>";
			}

			echo $after_widget;
		}

	}
}
/* add the widget  */
add_action( 'widgets_init', function() { register_widget( "HK_textwidget" ); } );




// class HK_tags_widget extends WP_Widget {
// 	protected $vars = array();

// 	public function __construct() {
// 		parent::__construct(
// 	 		'HK_tags_widget', // Base ID
// 			'HK etikett widget', // Name
// 			array( 'description' => "Widget som visar etiketter" ) // Args
// 		);
// 	}

//  	public function form( $instance ) {
// 		global $default_settings;
/*	?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Rubrik</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance["title"]); ?>" />
		</p>
		<p>
		<input id="<?php echo $this->get_field_id( 'horizontal-list' ); ?>" name="<?php echo $this->get_field_name( 'horizontal-list' ); ?>" type="checkbox" <?php echo ($instance["horizontal-list"] != "")?"checked":""; ?> />
		<label for="<?php echo $this->get_field_id( 'horizontal-list' ); ?>">Horisontell lista</label>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_widget_in_cat' ); ?>">Visa bara i kategori (i formen 23,42,19)</label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_widget_in_cat' ); ?>" name="<?php echo $this->get_field_name( 'show_widget_in_cat' ); ?>" type="text" value="<?php echo esc_attr( $show_widget_in_cat); ?>" />
		</p>

	<?php */
// 	}

// 	public function update( $new_instance, $old_instance ) {
// 		$instance = array();
// 		$instance['title'] = $new_instance['title'];
// 		$instance['horizontal-list'] = $new_instance['horizontal-list'];
// 		$instance['show_widget_in_cat'] = $new_instance['show_widget_in_cat'];
// 		return $instance;
// 	}

// 	public function widget( $args, $instance ) {
// 		global $default_settings;
// 	    extract( $args );

// 		if  (!isset($instance["show_widget_in_cat"]) || $instance["show_widget_in_cat"] == "" || in_array(get_query_var("cat"), explode(",",$instance["show_widget_in_cat"]))) { /* if show widget in cat */

// 			$horizontal = "";
// 			if (isset($instance['horizontal-list']))
// 				$horizontal = "horizontal-list";
// 			echo "<aside class='widget HK_tags_widget $horizontal'>";

// 			if ($instance['title'] != "") {
// 				echo "<h2 class='widget-title'>" . $instance['title'] . "</h2>";
// 			}
// 			hk_displayAllTagFilter(false, "", true, "gtm-tw-taglink");
// 			echo "</aside>";

// 		} /* END if show window cat */
// 	} //end widget()
// }
// /* add the widget  */
// add_action( 'widgets_init', function() { register_widget( "HK_tags_widget" ); } );







 ### Class: WP-PostViews Widget
// if(class_exists('WP_Widget_PostViews')) { // check if plugin is enabled
// 	class hk_WP_Widget_PostViews extends WP_Widget {

// 		// Constructor
// 		function __construct() {
// 			$widget_ops = array('description' => __('hk WP-PostViews views statistics, tag-cloudified', 'wp-postviews'));
// 			parent::__construct('hk_views', __('HK Most Viewed', 'wp-postviews'), $widget_ops);
// 		}

// 		// Display Widget
// 		function widget($args, $instance) {
// 			extract($args);
// 			$title = apply_filters('widget_title', esc_attr($instance['title']));
// 			$mode = esc_attr($instance['mode']);
// 			$limit = intval($instance['limit']);
// 			$chars = intval($instance['chars']);
// 			$largest_count = -1;
// 			echo $before_widget.$before_title.$title.$after_title;
// 			echo '<div class="wp-views-cloud">'."\n";




// 			$most_viewed = hk_get_most_viewed($mode, $limit);

// 			if($most_viewed) {
// 				foreach ($most_viewed as $post) {
// 					$post_views = intval($post->views);
// 					if ($post_views <= 0) $post_views = 1;
// 					if ($largest_count == -1)
// 						$largest_count = $post_views;

// 					//case
// 					switch(intval($post_views*4/$largest_count)) {
// 						case 4:
// 							$class = 'large';
// 							break;
// 						case 3:
// 							$class = 'medium';
// 							break;
// 						case 2:
// 							$class = 'small';
// 							break;
// 						case 1:
// 							$class = 'mini';
// 							break;
// 						default:
// 							$class = 'tiny';
// 							break;
// 					}

// 					$post_title = get_the_title($post);
// 					if($chars > 0) {
// 						$post_title = snippet_text($post_title, $chars);
// 					}
// 					$post_excerpt = views_post_excerpt($post->post_excerpt, $post->post_content, $post->post_password, $chars);
// 					$output .= "<a class='$class views-cloud-item' href='" . get_permalink($post) . "' title='$post_excerpt'>";
// 					$output .= $post_title;
// 					$output .= "</a>";
// 				}
// 			} else {
// 				$output = 'Nothing here..';
// 			}
// 			echo $output;






// 			echo '</div>'."\n";
// 			echo $after_widget;
// 		}

// 		// When Widget Control Form Is Posted
// 		function update($new_instance, $old_instance) {
// 			if (!isset($new_instance['submit'])) {
// 				return false;
// 			}
// 			$instance = $old_instance;
// 			$instance['title'] = strip_tags($new_instance['title']);
// 			$instance['mode'] = strip_tags($new_instance['mode']);
// 			$instance['limit'] = intval($new_instance['limit']);
// 			$instance['chars'] = intval($new_instance['chars']);
// 			return $instance;
// 		}

// 		// DIsplay Widget Control Form
// 		function form($instance) {
// 			global $wpdb;
// 			$instance = wp_parse_args((array) $instance, array('title' => __('Views', 'wp-postviews'), 'mode' => 'both', 'limit' => 10, 'chars' => 200));
// 			$title = esc_attr($instance['title']);
// 			$mode = esc_attr($instance['mode']);
// 			$limit = intval($instance['limit']);
// 			$chars = intval($instance['chars']);
/*	?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'wp-postviews'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('mode'); ?>"><?php _e('Include Views From:', 'wp-postviews'); ?>
					<select name="<?php echo $this->get_field_name('mode'); ?>" id="<?php echo $this->get_field_id('mode'); ?>" class="widefat">
						<option value="both"<?php selected('both', $mode); ?>><?php _e('Posts &amp; Pages', 'wp-postviews'); ?></option>
						<option value="post"<?php selected('post', $mode); ?>><?php _e('Posts Only', 'wp-postviews'); ?></option>
						<option value="page"<?php selected('page', $mode); ?>><?php _e('Pages Only', 'wp-postviews'); ?></option>
					</select>
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('No. Of Records To Show:', 'wp-postviews'); ?> <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('chars'); ?>"><?php _e('Maximum Post Title Length (Characters):', 'wp-postviews'); ?> <input class="widefat" id="<?php echo $this->get_field_id('chars'); ?>" name="<?php echo $this->get_field_name('chars'); ?>" type="text" value="<?php echo $chars; ?>" /></label><br />
				<small><?php _e('<strong>0</strong> to disable.', 'wp-postviews'); ?></small>
			</p>
			<input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
	<?php */
// 		}
// 	} // end class

// 	### Function: Init HuGy WP-PostViews Widget
// 	add_action('widgets_init', 'hk_widget_views_init');
// 	function hk_widget_views_init() {
// 		register_widget('hk_WP_Widget_PostViews');
// 	}

// } // end if Class: WP-PostViews Widget

// function hk_get_most_viewed($mode, $limit) {
// 	global $wpdb, $default_settings;
// 	$where = '';
// 	$output = '';

// 	// remove hidden posts
// 	$hidden_cat = "";
// 	if ($default_settings["hidden_cat"] != "") {
// 		$hidden_cat = $default_settings["hidden_cat"];
// 	}
// 	$ignore_hidden = " NOT IN (SELECT p3.ID FROM $wpdb->posts as p3
// 		 LEFT JOIN $wpdb->term_relationships as r3 ON p3.ID = r3.object_ID AND p3.post_status = 'publish'
// 		 WHERE r3.term_taxonomy_ID = '$hidden_cat') ";
// 	//$ignore_hidden = "";
// 	// if specific mode
// 	if(!empty($mode) && $mode != 'both') {
// 		$where = "post_type = '$mode'";
// 	} else {
// 		$where = '1=1';
// 	}


// 	$largest_count = -1;
// 	//			$most_viewed = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.*, (meta_value+0) AS views FROM $wpdb->posts
// 	//LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE post_date < '".current_time('mysql')."'
// 	//AND $where AND post_status = 'publish' AND meta_key = 'views' AND post_password = '' ORDER BY views DESC LIMIT $limit");




// 	$sql = "select * from
// 		(
// 			SELECT DISTINCT p1.*, CAST(meta_value-" . $default_settings["sticky_number"] . " AS signed) as views FROM $wpdb->posts as p1, $wpdb->postmeta as pm1
// 		WHERE p1.ID = pm1.post_id
// 		AND post_date < '".current_time('mysql')."'
// 		AND meta_key='views'
// 		AND meta_value>=" . $default_settings["sticky_number"] . "
// 		AND post_status = 'publish'
// 		AND $where AND p1.ID $ignore_hidden
// 		ORDER BY views DESC LIMIT $limit ) as t1
// 		union
// 		(
// 			SELECT DISTINCT p2.*, CAST(meta_value AS signed) as views FROM  $wpdb->posts as p2, $wpdb->postmeta as pm1
// 		WHERE p2.ID = pm1.post_id
// 		AND post_date < '".current_time('mysql')."'
// 		AND meta_key='views'
// 		AND meta_value<" . $default_settings["sticky_number"] . "
// 		AND post_status = 'publish'
// 		AND $where AND p2.ID $ignore_hidden
// 		ORDER BY views DESC LIMIT $limit )
// 		ORDER BY views DESC LIMIT $limit
// 	";
// 	$most_viewed = $wpdb->get_results($sql);
// 	return $most_viewed;
// }


/* TODO cleanup old widgets
add_action( 'widgets_init', create_function( '', 'unregister_widget('HK_firstpagecontact');' ) );
*/
?>
