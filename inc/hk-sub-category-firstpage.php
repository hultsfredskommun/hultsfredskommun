<?php if ( is_active_sidebar("firstpage-top-content") ) : ?>
	<div id="firstpage-top-content">
		<?php dynamic_sidebar('firstpage-top-content'); ?>
	</div><!-- #firstpage-top-sidebar -->
<?php endif; ?>


<?php
	/* get all sub categories to use in queries */
	$all_categories = hk_getChildrenIdArray($cat);
	$all_categories[] = $cat;
?>


<div id="firstpage-sidebar">
	<?php /* CONTACT */ ?>
	<div class="contact-area">
		<?php hk_contact_firstpage(); ?>
		<div class="clear"></div>
	</div>

	<?php /* QUICK MENUS AND MOST VISITED */ ?>
	<div id="quickmenus" class="widget">
		<ul class="post_tabs_title">
			<?php if (($locations = get_nav_menu_locations()) && isset( $locations['quickmenu'] ) && $locations['quickmenu'] > 0 ) : ?>
			<li title="Genv&auml;g"><a href="#quickmenu">Genv&auml;g</a></li>
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
		
		<?php if (function_exists( 'views_orderby' )) : ?>

		<div id="mostvisited">
			<?php
				/* Query all posts */
				$query = array( 'posts_per_page' => '10', 
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
			?>				
			<div class="clear"></div>
		</div>

		<?php endif; ?>
		
		<div id="latest">
			<?php
				/* Query all posts */
				$query = array( 'posts_per_page' => '10', 
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
			?>				
			<div class="clear"></div>
		</div>

	</div>

	<?php /* DYNAMIC WIDGET CONTENT */ ?>	
	<?php dynamic_sidebar('firstpage-sidebar'); ?>
	
</div>


<div id="primary">

	<div id="content" role="main">
		<ul class="post_tabs_title">
			<li title="Aktuellt"><a href="#newscontent">Aktuellt</a></li>
			<?php if ($default_settings["protocol_cat"] != "" && $default_settings["protocol_cat"] != "0") : ?>
			<li title="Protokoll"><a href="#protocolcontent">Protokoll, kallelser &amp; handlingar</a></li>
			<?php endif; ?>
			<li title="Driftinformation"><a href="#driftcontent">Driftinformation</a></li>
		</ul>
		<div id="newscontent">
			<?php 
				/* Query all posts with selected startpage category */
				$cat = get_query_var("cat");
				$query = array( 'posts_per_page' => '-1', 
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
				/* Query all posts with news category */
				if ($default_settings["news_tag"] != "") { ?>
					<div id='news'>
						<span class='entry-title'>Fler nyheter</span>
					<?php
					$query = array( 'posts_per_page' => '10', 
									'category__in' => $all_categories,
									'post__not_in' => $shownposts,
									'tag__and' => $default_settings["news_tag"],
									'suppress_filters' => 'true',
									'orderby' => 'date',
									'order' => 'desc'  );

					query_posts( $query );		
					if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="entry-wrapper">
						<?php the_date("","<span>","</span>"); ?><a post_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php the_excerpt_rss() ?>"><?php the_title(); ?></a>
					</div>
					<?php endwhile; endif; 
					?> 
						<span class="read-more-link"><a href="<?php echo get_tag_link($default_settings["news_tag"]); ?>">Fler nyheter</a></span>
					</div>
					<?php // Reset Query
					wp_reset_query(); 
				}
				else {
					echo "Du m&aring;ste s&auml;tta egenskapen <i>Nyheternas kategori</i> under Utseende -> Inst&auml;llningar.";	
				}
			?>
		
			<div class="clear"></div>
		</div>


		<?php if ($default_settings["protocol_cat"] != "" && $default_settings["protocol_cat"] != "0") : ?>
		<div id="protocolcontent">
			<?php 
				/* Query all posts with selected startpage category */
					$children =  hk_getChildrenIdArray($default_settings["protocol_cat"]);
					$children[] =  $default_settings["protocol_cat"];
					$query = array( 'posts_per_page' => '-1', 
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
				<div class="entry-title">Visa protokoll</div><ul>
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
			<div class="clear"></div>
		</div>	
		<?php endif; ?>
		<div id="driftcontent">
			H&auml;r kommer driftinformation.
		</div>
		
	</div><!-- #content -->
	<?php dynamic_sidebar('firstpage-content'); ?>
</div><!-- #primary -->

<?php if (is_active_sidebar('firstpage-pre-footer-sidebar')) : ?>
<div id="firstpage-pre-footer-sidebar">
<?php dynamic_sidebar('firstpage-pre-footer-sidebar'); ?>
</div>
<?php endif; ?>