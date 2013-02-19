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

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Antal poster i senaste och mest bes&ouml;kta:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" type="text" value="<?php echo esc_attr( $posts_per_page); ?>" />
		</p>
		<?php if ($default_settings["show_tags"] != 0) : ?>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_tags' ); ?>"><?php _e( 'Visa etiketter som flik:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_tags' ); ?>" name="<?php echo $this->get_field_name( 'show_tags' ); ?>" type="text" value="<?php echo esc_attr( $show_tags); ?>" />
		</p>		
		<?php endif; ?>

		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['posts_per_page'] = strip_tags( $new_instance['posts_per_page'] );
		$instance['show_tags'] = strip_tags( $new_instance['show_tags'] );
		return $instance;
	}

	public function widget( $args, $instance ) {
		global $default_settings;
	    extract( $args );

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
		?>
	<div id="quickmenus" class="widget">
		<ul class="post_tabs_title">
			<?php if (($locations = get_nav_menu_locations()) && isset( $locations['quickmenu'] ) && $locations['quickmenu'] > 0 ) : ?>
			<li title="Genv&auml;g"><a href="#quickmenu">Genv&auml;g</a></li>
			<?php endif; ?>
			<?php if ($default_settings["show_tags"] != 0 && $show_tags != 0) : ?>
			<li title="Visa bara"><a href="#onlytag">Visa bara</a></li>
			<?php endif; ?>
			<?php if (function_exists( 'views_orderby' )) : ?>
			<li title="Mest bes&ouml;kta"><a href="#mostvisited">Mest bes&ouml;kta</a></li>
			<?php endif; ?>
			<li title="Senaste"><a href="#latest">Senaste</a></li>
		</ul>
		<?php 
		if (($locations = get_nav_menu_locations()) && isset( $locations['quickmenu'] ) && $locations['quickmenu'] > 0 ) :
			echo "<div id='quickmenu'>";
			wp_nav_menu( array(
				'theme_location' => 'quickmenu', 
				'container' 	=> '',							
				'items_wrap'	=> '<ul>%3$s</ul>',
				'depth' 		=> 1,
				'echo' 			=> true
			)); 
			echo "</div>";
		endif;
		?>
		
		<?php if ($default_settings["show_tags"] != 0 && $show_tags != 0) : ?>
		<div id="onlytag">
			<?php
			displayTagFilter("dropdown", false);			
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
								'ignore_sticky_posts' => 'true'
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
						<a href="<?php the_permalink(); ?>" title="<?php the_excerpt_rss(); ?>"><?php the_title(); ?></a> <?php echo get_the_date("","<span class='time'>","</span>"); ?>
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
	}
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
			array( 'description' => "Widget som visar kontakter kopplade till aktiv kategori" ) // Args
		);

	}

 	public function form( $instance ) {
	}

	public function update( $new_instance, $old_instance ) {
	}

	public function widget( $args, $instance ) {
	    extract( $args );
?>
	<div class="contact-area">
		<?php hk_contact_firstpage(); ?>
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
			array( 'description' => "Widget som visar huvudinneh&aring; som aktuellt och nyheter kopplat till aktiv kategori samt protokoll i flikar" ) // Args
		);
		$this->vars["show_protocol"] = "";
		$this->vars["num_aktuellt"] = "4";
		$this->vars["num_news"] = "10";
		$this->vars["num_protocol"] = "4";
	}

 	public function form( $instance ) {		
		if ( isset( $instance[ 'show_protocol' ] ) ) {	$show_protocol = $instance[ 'show_protocol' ];
		} else {$show_protocol = $this->vars['show_protocol']; }
		
		if ( isset( $instance[ 'num_aktuellt' ] ) ) { $num_aktuellt = $instance[ 'num_aktuellt' ];
		} else { $num_aktuellt = $this->vars['num_aktuellt']; }

		if ( isset( $instance[ 'num_news' ] ) ) { $num_news = $instance[ 'num_news' ];
		} else { $num_news = $this->vars['num_news']; }

		if ( isset( $instance[ 'num_protocol' ] ) ) { $num_protocol = $instance[ 'num_protocol' ];
		} else { $num_protocol = $this->vars['num_protocol']; }


		$options = get_option('hk_theme');

		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'show_protocol' ); ?>">Visa protokollflik i kategorier (exempel 23,42,19).</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'show_protocol' ); ?>" name="<?php echo $this->get_field_name( 'show_protocol' ); ?>" type="text" value="<?php echo esc_attr( $show_protocol); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'num_aktuellt' ); ?>">Antal inl&auml;gg i aktuellt.</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'num_aktuellt' ); ?>" name="<?php echo $this->get_field_name( 'num_aktuellt' ); ?>" type="text" value="<?php echo esc_attr( $num_aktuellt); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'num_news' ); ?>">Antal i nyhetslistan.</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'num_news' ); ?>" name="<?php echo $this->get_field_name( 'num_news' ); ?>" type="text" value="<?php echo esc_attr( $num_news); ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'num_protocol' ); ?>">Antal protokoll.</label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'num_protocol' ); ?>" name="<?php echo $this->get_field_name( 'num_protocol' ); ?>" type="text" value="<?php echo esc_attr( $num_protocol); ?>" />
		</p>
		
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['show_protocol'] = strip_tags( $new_instance['show_protocol'] );
		$instance['num_aktuellt'] = strip_tags( $new_instance['num_aktuellt'] );
		$instance['num_news'] = strip_tags( $new_instance['num_news'] );
		$instance['num_protocol'] = strip_tags( $new_instance['num_protocol'] );
		$instance['num_days_new'] = strip_tags( $new_instance['num_days_new'] );
		
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
		$showprotocol = $default_settings["protocol_cat"] != "" && $default_settings["protocol_cat"] != "0" && in_array(get_query_var("cat"), split(",",$instance["show_protocol"]));
		?>

	<div id="content" role="main">
		<?php if ($showprotocol) : ?>
		<ul class="post_tabs_title">
			<li title="Aktuellt"><a href="#newscontent">Aktuellt</a></li>
			<?php if ($showprotocol) : ?>
			<li title="Protokoll"><a href="#protocolcontent">Protokoll, kallelser &amp; handlingar</a></li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
		<div id="newscontent">
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
					get_template_part( 'content', 'news' ); 
				endwhile; endif; 
				// Reset Query
				wp_reset_query(); 
			?>
			<!--div id='wrapper-sHys'>
				<span id='h2-sHys'><a id='url-sHys' href="http://www.vackertvader.se/hultsfred"> Hultsfred</a></span>
				<div id='load-sHys'></div>
				<a id='url_detail-sHys' href="http://www.vackertvader.se/hultsfred">Detaljerad prognos</a>
			</div>
			<script type="text/javascript" 
					src="http://widget.vackertvader.se/widgetv3/widget_request/2704398?bgcolor=ffffff&border=none&days=1&key=-sHys&lang=&maxtemp=no&size=x120&textcolor=363636&wind=no" 
					charset="utf-8">
			</script-->

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
						<span class="read-more-link"><a href="<?php echo get_tag_link($default_settings["news_tag"]); ?>">Fler nyheter</a></span>
					</div>					
					<?php endif; ?> 
					<?php // Reset Query
					wp_reset_query(); 
				}
			?>
		
			
		</div>


		<?php if ($showprotocol) : ?>
		<div id="protocolcontent">
			<?php 
				/* Query all posts with selected startpage category */
					$children =  hk_getChildrenIdArray($default_settings["protocol_cat"]);
					$children[] =  $default_settings["protocol_cat"];
					$query = array( 'posts_per_page' => $instance["num_protocol"], 
									'category__in' => $children,
									'orderby' => 'date',
									'order' => 'desc'  );
					
					query_posts( $query );
			
					if ( have_posts() ) : while ( have_posts() ) : the_post(); 
						get_template_part( 'content' ); 
					endwhile; endif; 
					// Reset Query
					wp_reset_query(); 
			?>
				<div id="protocolcategories">
					<div class="entry-title">Visa protokoll fr&aring;n</div><ul>
					<?php 
					 $args = array(
						'hide_empty'         => 0,
						'orderby'            => 'name',
						'order'              => 'ASC',
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
			
		</div>	
		<?php endif; ?>
		
	</div><!-- #content -->
<?php
	}
}
/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_firstpagecontent" );' ) );







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
		$instance['icon'] = strip_tags( $new_instance['icon'] );
		$instance['menu'] = strip_tags( $new_instance['menu'] );
		
		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );
		
		
		if ( isset($instance["menu"]) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			
			echo $before_widget;
			if ( ! empty( $title ) ) {
				echo $before_title . "<i class='i' data-icon='" . $instance['icon'] . "'></i>" . $title . $after_title;
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
		
		
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['icon'] = strip_tags( $new_instance['icon'] );
		$instance['text'] =  $new_instance['text'];
		
		return $instance;
	}

	public function widget( $args, $instance ) {
	    extract( $args );
		
		
		if ( isset($instance["text"]) ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			
			echo $before_widget;
			if ( ! empty( $title ) ) {
				echo $before_title . "<i class='i' data-icon='" . $instance['icon'] . "'></i>" . $title . $after_title;
			}
			
			echo "<div class='content'>" . $instance["text"] . "</div>";
			echo $after_widget;
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
?>
	<div class="content-area">
		H&auml;r ska det visas evenemang.
	</div>

<?php
	}
}
/* add the widget  */
add_action( 'widgets_init', create_function( '', 'register_widget( "HK_event_rss_widget" );' ) );


?>