<?php 

/* 
 * QUICK MENUS AND MOST VISITED 
 */ 
class HK_quickmenu extends WP_Widget {
	protected $vars = array();

	public function __construct() {
		parent::__construct(
	 		'HK_quickmenu', // Base ID
			'HK genv&auml;g widget', // Name
			array( 'description' => "Widget som visar snabbmeny, senaste och mest bes&oumlt;kt fr&aring;n aktiv kategori i flikar" ) // Args
		);

		$this->vars['posts_per_page'] = '10';
	}

 	public function form( $instance ) {
		global $default_settings;
		if ( isset( $instance[ 'posts_per_page' ] ) ) {
			$posts_per_page = $instance[ 'posts_per_page' ];
		} else {
			$posts_per_page = $this->vars['posts_per_page'];
		}
		if ( isset( $instance[ 'show_tags' ] ) ) {
			$show_tags = $instance[ 'show_tags' ];
		} else {
			$show_tags = 1;
		}
		if ( isset( $instance[ 'show_widget_in_cat' ] ) ) {
			$show_widget_in_cat = $instance[ 'show_widget_in_cat' ];
		} else {
			$show_widget_in_cat = "";
		}

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>">Antal poster i senaste och mest bes&ouml;kta:</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page); ?>" />
		</p>
		<?php if ($default_settings["show_tags"] != 0) : ?>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_tags' ); ?>">Visa etiketter som flik:</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_tags' ); ?>" name="<?php echo $this->get_field_name( 'show_tags' ); ?>" type="text" value="<?php echo esc_attr( $show_tags); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_wp_feed' ); ?>">Visa bara i kategori (i formen 23,42,19)</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_widget_in_cat' ); ?>" name="<?php echo $this->get_field_name( 'show_widget_in_cat' ); ?>" type="text" value="<?php echo esc_attr( $show_widget_in_cat); ?>" />
		</p>

		<?php endif; ?>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
		$instance['show_tags'] = strip_tags( $new_instance['show_tags'] );
		$instance['show_widget_in_cat'] = strip_tags( $new_instance['show_widget_in_cat'] );
		
		return $instance;
	}

	public function widget( $args, $instance ) {
		global $default_settings;
	    extract( $args );
		if  ($instance["show_widget_in_cat"] == "" || in_array(get_query_var("cat"), split(",",$instance["show_widget_in_cat"]))) {

			/* get all sub categories to use in queries */
			$cat = get_query_var("cat");
			$all_categories = hk_getChildrenIdArray($cat);
			$all_categories[] = $cat;

			// set number of posts
			if (isset($instance['posts_per_page']))
				$this->vars['posts_per_page'] = $instance['posts_per_page'];
			if (isset($instance['show_tags']))
				$show_tags = $instance['show_tags'];
			else
				$show_tags = $default_settings["show_tags"];
			
			// get quickmenu
			$quickmenu = hk_related_output(false);
			?>
		<div id="quickmenus" class="widget  js-tabs  hidden">
			<ul class="post_tabs_title">
				<?php if ($quickmenu != "") : ?>
				<li title="Hitta snabbt"><a href="#quickmenu">Hitta snabbt</a></li>
				<?php endif; ?>
				<?php if (function_exists( 'views_orderby' )) : ?>
				<li title="Popul&auml;ra" class="hide--palm"><a href="#mostvisited">Popul&auml;ra</a></li>
				<?php endif; ?>
				<li title="Senaste" class="hide--palm  hide--lap"><a href="#latest">Senaste</a></li>
				<?php if ($default_settings["show_tags"] != 0 && $show_tags != 0) : ?>
				<li title="Visa bara"><a href="#onlytag">Visa bara</a></li>
				<?php endif; ?>
			</ul>
			<?php 
			if ($quickmenu != "") :
				echo "<div id='quickmenu'>";
				echo $quickmenu;
				echo "</div>";
			endif;
			?>
			
			<?php if ($default_settings["show_tags"] != 0 && $show_tags != 0) : ?>
			<div id="onlytag">
				<?php
				displayTagFilter(false);
				?>				
			</div>
			<?php endif; ?>
			
			<?php if (function_exists( 'views_orderby' )) : ?>
			<div id="mostvisited">
				<?php
				if ($all_categories != "") {
					/* Query all posts */
					$query = array( 'posts_per_page' => $this->vars['posts_per_page'], 
									'category__in' => $all_categories,
									'ignore_sticky_posts' => 'true',
									'meta_key' => 'views', 
									'orderby' => 'meta_value_num',
									'order' => 'DESC',
									) ;
					
					query_posts( $query );
					if ( have_posts() ) : ?>
					<ul>
						<?php while ( have_posts() ) : the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>" title="<?php the_excerpt_rss(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endwhile; ?>
					</ul>
					<?php endif;
					// Reset Query
					wp_reset_query(); 				
				}
				?>				
			</div>

			<?php endif; ?>
			
			<div id="latest">
				<?php
				if ($all_categories != "") {
					/* Query all posts */
					$query = array( 'posts_per_page' => $this->vars['posts_per_page'], 
									'category__in' => $all_categories,
									'ignore_sticky_posts' => 'true',
									'suppress_filters' => 'true'
									) ;
					
					query_posts( $query );
					if ( have_posts() ) : ?>
					<ul>
						<?php while ( have_posts() ) : the_post(); ?>
						<li>
							<a href="<?php the_permalink(); ?>" title="<?php the_excerpt_rss(); ?>"><?php the_title(); ?></a>
						</li>
					<?php endwhile; ?>
					</ul>
					<?php endif;
					// Reset Query
					wp_reset_query();
				} 				
				?>				
			</div>
			
		</div>
	<?php
		} //end if show in category
	} //end widget()
}
/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_quickmenu" );' ) );







/* 
 * FIRSTPAGE CONTACT WIDGET 
 */ 
 class HK_firstpagecontact extends WP_Widget {
	protected $vars = array();

	public function __construct() {
		parent::__construct(
	 		'HK_firstpagecontact', // Base ID
			'HK f&ouml;rstasidans kontakt', // Name
			array( 'description' => "Widget som visar kontakt kopplad till aktiv kategori p&aring; startsidan." ) // Args
		);

	}

 	
 	public function form( $instance ) {
	
		?>
		<h3>Direktl&auml;nk 1</h3>
		<p>
		<label for="<?php echo $this->get_field_id( 'direct_link1_title' ); ?>">Namn</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'direct_link1_title' ); ?>" name="<?php echo $this->get_field_name( 'direct_link1_title' ); ?>" type="text" value="<?php echo esc_attr( $instance["direct_link1_title"]); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'direct_link1_url' ); ?>">L&auml;nk</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'direct_link1_url' ); ?>" name="<?php echo $this->get_field_name( 'direct_link1_url' ); ?>" type="text" value="<?php echo esc_attr( $instance["direct_link1_url"]); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'direct_link1_icon' ); ?>">Ikon</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'direct_link1_icon' ); ?>" name="<?php echo $this->get_field_name( 'direct_link1_icon' ); ?>" type="text" value="<?php echo esc_attr( $instance["direct_link1_icon"]); ?>" />
		</p>

		<h3>Direktl&auml;nk 2</h3>
		<p>
		<label for="<?php echo $this->get_field_id( 'direct_link2_title' ); ?>">Namn</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'direct_link2_title' ); ?>" name="<?php echo $this->get_field_name( 'direct_link2_title' ); ?>" type="text" value="<?php echo esc_attr( $instance["direct_link2_title"]); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'direct_link2_url' ); ?>">L&auml;nk</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'direct_link2_url' ); ?>" name="<?php echo $this->get_field_name( 'direct_link2_url' ); ?>" type="text" value="<?php echo esc_attr( $instance["direct_link2_url"]); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'direct_link2_icon' ); ?>">Ikon</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'direct_link2_icon' ); ?>" name="<?php echo $this->get_field_name( 'direct_link2_icon' ); ?>" type="text" value="<?php echo esc_attr( $instance["direct_link2_icon"]); ?>" />
		</p>

		<h3>Direktl&auml;nk 3</h3>
		<p>
		<label for="<?php echo $this->get_field_id( 'direct_link3_title' ); ?>">Namn</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'direct_link3_title' ); ?>" name="<?php echo $this->get_field_name( 'direct_link3_title' ); ?>" type="text" value="<?php echo esc_attr( $instance["direct_link3_title"]); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'direct_link3_url' ); ?>">L&auml;nk</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'direct_link3_url' ); ?>" name="<?php echo $this->get_field_name( 'direct_link3_url' ); ?>" type="text" value="<?php echo esc_attr( $instance["direct_link3_url"]); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'direct_link3_icon' ); ?>">Ikon</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'direct_link3_icon' ); ?>" name="<?php echo $this->get_field_name( 'direct_link3_icon' ); ?>" type="text" value="<?php echo esc_attr( $instance["direct_link3_icon"]); ?>" />
		</p>
		
	<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['direct_link1_url'] = strip_tags( $new_instance['direct_link1_url'] );
		$instance['direct_link1_title'] = strip_tags( $new_instance['direct_link1_title'] );
		$instance['direct_link1_icon'] = $new_instance['direct_link1_icon'];
		$instance['direct_link2_url'] = strip_tags( $new_instance['direct_link2_url'] );
		$instance['direct_link2_title'] = strip_tags( $new_instance['direct_link2_title'] );
		$instance['direct_link2_icon'] = $new_instance['direct_link2_icon'];
		$instance['direct_link3_url'] = strip_tags( $new_instance['direct_link3_url'] );
		$instance['direct_link3_title'] = strip_tags( $new_instance['direct_link3_title'] );
		$instance['direct_link3_icon'] = $new_instance['direct_link3_icon'];
		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );
?>
	<div class="contact-area">
		<?php hk_contact_firstpage(array('direct_link1_url' => $instance["direct_link1_url"], 
										'direct_link1_title' => $instance["direct_link1_title"],
										'direct_link1_icon' => $instance["direct_link1_icon"],
										'direct_link2_url' => $instance["direct_link2_url"],
										'direct_link2_title' => $instance["direct_link2_title"],
										'direct_link2_icon' => $instance["direct_link2_icon"],
										'direct_link3_url' => $instance["direct_link3_url"],
										'direct_link3_title' => $instance["direct_link3_title"],
										'direct_link3_icon' => $instance["direct_link3_icon"])); ?>
	</div>

<?php
	}
}
/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_firstpagecontact" );' ) );






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
		if ( isset( $instance[ 'num_aktuellt' ] ) ) { $num_aktuellt = $instance[ 'num_aktuellt' ];
		} else { $num_aktuellt = $this->vars['num_aktuellt']; }

		if ( isset( $instance[ 'num_news' ] ) ) { $num_news = $instance[ 'num_news' ];
		} else { $num_news = $this->vars['num_news']; }

		if ( isset( $instance[ 'content_type' ] ) ) { $content_type = $instance[ 'content_type' ];
		} else { $content_type = ''; }


		$options = get_option('hk_theme');

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'num_aktuellt' ); ?>">Antal inl&auml;gg i aktuellt.</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'num_aktuellt' ); ?>" name="<?php echo $this->get_field_name( 'num_aktuellt' ); ?>" type="text" value="<?php echo esc_attr( $num_aktuellt); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'num_news' ); ?>">Antal i nyhetslistan.</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'num_news' ); ?>" name="<?php echo $this->get_field_name( 'num_news' ); ?>" type="text" value="<?php echo esc_attr( $num_news); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'content_type' ); ?>">Aktuellt typ (news som standard).</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'content_type' ); ?>" name="<?php echo $this->get_field_name( 'content_type' ); ?>" type="text" value="<?php echo esc_attr( $content_type); ?>" />
		</p>
		
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['num_aktuellt'] = strip_tags( $new_instance['num_aktuellt'] );
		$instance['num_news'] = strip_tags( $new_instance['num_news'] );
		$instance['num_days_new'] = strip_tags( $new_instance['num_days_new'] );
		$instance['content_type'] = strip_tags( $new_instance['content_type'] );
		
		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );
		global $default_settings;
		$options = get_option('hk_theme');
		
		/* get all sub categories to use in queries */
		$cat = get_query_var("cat");
		$all_categories = hk_getChildrenIdArray($cat);
		$all_categories[] = $cat;
		?>

	<div id="content" role="main">
		
		<div id="newscontent" class="newscontent">
			<?php 
				/* Query all posts with selected startpage category */
				$cat = get_query_var("cat");
				$query = array( 'posts_per_page' => $instance["num_aktuellt"], 
								'category__and' => $cat,
								'tag__and' => $default_settings["news_tag"],
								'suppress_filters' => 'true',
								'orderby' => 'date',
								'order' => 'desc' );
				query_posts( $query );
				
				$shownposts = array();
				if ( have_posts() ) : while ( have_posts() ) : the_post(); 
					$shownposts[] = get_the_ID(); 
					if ($instance["content_type"] != "")
						get_template_part( 'content', $instance["content_type"] ); 
					else
						get_template_part( 'content', 'news' ); 
				endwhile; endif; 
				// Reset Query
				wp_reset_query(); 
			?>
			

			<?php
				/* Query all posts with news tag */
				if ($default_settings["news_tag"] != "" && $default_settings["news_tag"] != "0") {
					$query = array( 'posts_per_page' => $instance["num_news"], 
									'category__in' => $all_categories,
									'post__not_in' => $shownposts,
									'tag__and' => $default_settings["news_tag"],
									'suppress_filters' => 'true',
									'orderby' => 'date',
									'order' => 'desc'  );

					query_posts( $query );		

					if ( have_posts() ) : ?>
					<div id='news' class="widget">
						<h1 class='entry-title'>Fler nyheter</h1>

						<?php while ( have_posts() ) : the_post(); ?>
						<div class="entry-wrapper">
						<?php the_date("","<span class='time'>","</span>"); ?> <a href="<?php the_permalink(); ?>" title="<?php the_excerpt_rss() ?>"><?php the_title(); ?></a>
						</div>
						<?php endwhile; ?>
						<span class="read-more-link"><a href="<?php echo get_tag_link($default_settings["news_tag"]); ?>">Nyhetsarkiv</a></span>
					</div>					
					<?php endif; ?> 
					<?php // Reset Query
					wp_reset_query(); 
				}
			?>
		
			
		</div>


		
		
	</div><!-- #content -->
<?php
	}
}
/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_firstpagecontent" );' ) );





/* 
 * PROTOCOL WIDGET 
 */ 
 class HK_protocol extends WP_Widget {
	protected $vars = array();

	public function __construct() {
		parent::__construct(
	 		'HK_protocol', // Base ID
			'HK protocol', // Name
			array( 'description' => "Widget som visar protokoll" ) // Args
		);
		$this->vars["show_protocol"] = "";
		$this->vars["num_protocol"] = "4";
	}

 	public function form( $instance ) {		
		if ( isset( $instance[ 'show_protocol' ] ) ) {	$show_protocol = $instance[ 'show_protocol' ];
		} else {$show_protocol = $this->vars['show_protocol']; }
		
		if ( isset( $instance[ 'num_protocol' ] ) ) { $num_protocol = $instance[ 'num_protocol' ];
		} else { $num_protocol = $this->vars['num_protocol']; }

		if ( isset( $instance[ 'show_more_link' ] ) ) { $show_more_link = $instance[ 'show_more_link' ];
		} else { $show_more_link = ""; }

		if ( isset( $instance[ 'show_all_categories' ] ) ) { $show_all_categories = $instance[ 'show_all_categories' ];
		} else { $show_all_categories = ""; }

		$options = get_option('hk_theme');

		?>
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
		<p>
		<label for="<?php echo $this->get_field_id( 'show_all_categories' ); ?>">"Visa protokoll från"-lista, ange text för vad som ska stå som rubrik .</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_all_categories' ); ?>" name="<?php echo $this->get_field_name( 'show_all_categories' ); ?>" type="text" value="<?php echo esc_attr( $show_all_categories); ?>" />
		</p>
		
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['show_protocol'] = strip_tags( $new_instance['show_protocol'] );
		$instance['num_protocol'] = strip_tags( $new_instance['num_protocol'] );
		$instance['show_more_link'] = strip_tags( $new_instance['show_more_link'] );
		$instance['show_all_categories'] = strip_tags( $new_instance['show_all_categories'] );
		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );
		global $default_settings;
		$options = get_option('hk_theme');
		
		/* get all sub categories to use in queries */
		$showprotocol = $default_settings["protocol_cat"] != "" && $default_settings["protocol_cat"] != "0" && (!isset($instance["show_protocol"]) || in_array(get_query_var("cat"), split(",",$instance["show_protocol"])));
		?>
		
		<?php if ($showprotocol) : ?>
		
			<?php echo $before_widget; ?>
			<?php echo $before_title . "Protokoll" . $after_title; ?>
			<div id="protocolwidget" class="protocolwidget">
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
						
						if ( have_posts() ) : echo "<ul>"; while ( have_posts() ) : the_post(); 
							get_template_part( 'content', 'single-line' ); 
						endwhile; echo "</ul>"; endif; 
						// Reset Query
						wp_reset_query(); 
				?>
				<?php if (isset($instance["show_more_link"])) : 
					$cat_link = esc_url(get_category_link($default_settings["protocol_cat"]));
					$show_more_link = $instance["show_more_link"];
					?>
					<div id="protocollink">
						<?php echo "<a href='$cat_link title='$show_more_link'>$show_more_link</a>"; ?>
					</div>
				<?php endif; ?>
				
				<?php if (isset($instance["show_all_categories"])) : ?>
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
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_protocol" );' ) );





/* 
 * MENU IN WIDGET 
 */ 
 class HK_menuwidget extends WP_Widget {
	protected $vars = array();

	public function __construct() {
		parent::__construct(
	 		'HK_menuwidget', // Base ID
			'HK meny i widget', // Name
			array( 'description' => "Widget som vald meny" ) // Args
		);
		

	}

 	public function form( $instance ) {		
		if ( isset( $instance[ 'title' ] ) ) {	$title = $instance[ 'title' ];
		} else { $title = ""; }
		if ( isset( $instance[ 'icon' ] ) ) {	$icon = $instance[ 'icon' ];
		} else { $icon = ""; }
		if ( isset( $instance[ 'menu' ] ) ) {	$menu = $instance[ 'menu' ];
		} else {$menu = ""; }
		
		?>
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
		
		
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['icon'] = $new_instance['icon'];
		$instance['menu'] = strip_tags( $new_instance['menu'] );
		
		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );
		
		
		if ( isset($instance["menu"]) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $before_widget;
			if ( ! empty( $title ) ) {
				echo $before_title . $instance['icon'] . $title . $after_title;
			}
			
			wp_nav_menu( array(
				'menu' => $instance["menu"],
				'container' 	=> '',
				'items_wrap'	=> '<ul>%3$s</ul>',
				'depth' 		=> -1,
				'echo' 			=> true
			)); 
			echo $after_widget;
		}

	}
}
/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_menuwidget" );' ) );



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
		if ( isset( $instance[ 'icon' ] ) ) {	$icon = $instance[ 'icon' ];
		} else { $icon = ""; }
		if ( isset( $instance[ 'text' ] ) ) {	$text = $instance[ 'text' ];
		} else {$menu = ""; }
		if ( isset( $instance[ 'show_widget_in_cat' ] ) ) {	$show_widget_in_cat = $instance[ 'show_widget_in_cat' ];
		} else { $show_widget_in_cat = ""; }

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Rubrik</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'icon' ); ?>">Ikon</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'icon' ); ?>" name="<?php echo $this->get_field_name( 'icon' ); ?>" type="text" value="<?php echo esc_attr( $icon); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'text' ); ?>">Text</label> 
		<textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_wp_feed' ); ?>">Visa bara i kategori (i formen 23,42,19)</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_widget_in_cat' ); ?>" name="<?php echo $this->get_field_name( 'show_widget_in_cat' ); ?>" type="text" value="<?php echo esc_attr( $show_widget_in_cat); ?>" />
		</p>

		
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['icon'] = $new_instance['icon'];
		$instance['text'] =  $new_instance['text'];
		$instance['show_widget_in_cat'] = strip_tags( $new_instance['show_widget_in_cat'] );
		
		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );
		if  ($instance["show_widget_in_cat"] == "" || in_array(get_query_var("cat"), split(",",$instance["show_widget_in_cat"]))) {
		
			if ( isset($instance["text"]) ) {
				$title = apply_filters( 'widget_title', $instance['title'] );
				
				echo $before_widget;
				if ( ! empty( $title ) ) {
					echo $before_title . $instance['icon'] . $title . $after_title;
				}
				
				echo "<div class='content'>" . $instance["text"] . "</div>";
				echo $after_widget;
			}
		}

	}
}
/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_textwidget" );' ) );







/* 
 * EVENT RSS WIDGET 
 */ 
 class HK_event_rss_widget extends WP_Widget {
	protected $vars = array();

	public function __construct() {
		parent::__construct(
	 		'HK_event_rss_widget', // Base ID
			'HK evenemang', // Name
			array( 'description' => "Widget som visar evenemang" ) // Args
		);

	}

 	public function form( $instance ) {
	}

	public function update( $new_instance, $old_instance ) {
	}

	public function widget( $args, $instance ) {
	    extract( $args );
		echo $before_widget;
		echo $before_title."Evenemang".$after_title;
?>
	<div class="content-area">
		H&auml;r ska det visas evenemang.
	</div>
<?php
		echo $after_widget;
	}
}
/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_event_rss_widget" );' ) );


?>