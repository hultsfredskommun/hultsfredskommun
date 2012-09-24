<?php if ( is_active_sidebar("firstpage-top-content") || is_active_sidebar("firstpage-top-content-right") ) : ?>
	<div id="firstpage-top-content">
		<div class="leftcontent">
			<?php dynamic_sidebar('firstpage-top-content'); ?>
		</div>
		<div class="rightcontent">
			<?php dynamic_sidebar('firstpage-top-content-right'); ?>
		</div>
		<div class="clear"></div>
	</div><!-- #firstpage-top-sidebar -->
<?php endif; ?>

<div id="primary">
	<div id="content" role="main">
		<ul class="post_tabs_title">
			<li title="Aktuellt"><a href="#newscontent">Aktuellt</a></li>
			<li title="Protokoll"><a href="#protocolcontent">Protokoll, kallelser och handlingar</a></li>
			<li title="Mest besökta"><a href="#mostvisited">Mest bes&ouml;kta</a></li>
		</ul>
		<div id="newscontent">
			<div class="leftcontent">
			<?php 
				/* Query all posts with selected startpage category */
				$cat = get_query_var("cat");
				if ($default_settings["startpage_cat"] != "") {
					$query = array( 'posts_per_page' => '-1', 
									'category__and' => $cat,
									'tax_query' => array(
										array(
											'taxonomy' => 'special_category',
											'field' => 'id',
											'terms' => $default_settings["startpage_cat"]
										)
									) );
					
					query_posts( $query );
			
					if ( have_posts() ) : while ( have_posts() ) : the_post(); 
						get_template_part( 'content' ); 
					endwhile; endif; 
					// Reset Query
					wp_reset_query(); 
				}
				else {
					echo "Du m&aring;ste s&auml;tta egenskapen <i>Startsidans kategori</i> under Utseende -> Inst&auml;llningar.";	
				}
			?>

			</div><div class="rightcontent">
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
				if ($default_settings["news_cat"] != "") { ?>
					<div id='news'>
						<span class='entry-title'>Nyheter</span>
					<?php
					$query = array( 'posts_per_page' => '10', 
									'category__and' => $cat,
									'tax_query' => array(
										array(
											'taxonomy' => 'special_category',
											'field' => 'id',
											'terms' => $default_settings["news_cat"]
										)
									) );

					query_posts( $query );		
					if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="entry-wrapper">
						<a post_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</div>
					<?php endwhile; endif; 
					?> 
						<span class="read-more-link"><a href="<?php echo get_category_link($default_settings["news_cat"]); ?>">Fler nyheter</a></span>
					</div>
					<?php // Reset Query
					wp_reset_query(); 
				}
				else {
					echo "Du m&aring;ste s&auml;tta egenskapen <i>Nyheternas kategori</i> under Utseende -> Inst&auml;llningar.";	
				}
			?>
		
			</div>
			<div class="clear"></div>
		</div>


		<div id="protocolcontent">
			<div class="leftcontent">
			<?php 
				/* Query all posts with selected startpage category */
				if ($default_settings["protocol_cat"] != "") {
					$query = array( 'posts_per_page' => '-1', 
									'tax_query' => array(
										array(
											'taxonomy' => 'special_category',
											'field' => 'id',
											'terms' => $default_settings["protocol_cat"]
										)
									) );
					
					query_posts( $query );
			
					if ( have_posts() ) : while ( have_posts() ) : the_post(); 
						get_template_part( 'content' ); 
					endwhile; endif; 
					// Reset Query
					wp_reset_query(); 
				}
				else {
					echo "Du m&aring;ste s&auml;tta egenskapen <i>Protokoll kategori</i> under Utseende -> Inst&auml;llningar.";	
				}
			?>

			</div><div class="rightcontent">
				<div class="entry-title">Visa protokoll</div>
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
					'taxonomy'           => 'special_category',
					);
					wp_list_categories($args);	
					?>			
			</div>
			<div class="clear"></div>
		</div>	


		<div id="mostvisited">
			<div class="leftcontent">
			<?php
				/* Query all posts */
				$query = array( 'posts_per_page' => '4', 
								'category__and' => $cat,
								'ignore_sticky_posts' => 'true'
								) ;
				
				query_posts( $query );
				$shownposts = array();
				if ( have_posts() ) : while ( have_posts() ) : the_post();
					$shownposts[] = get_the_ID(); 
					get_template_part( 'content' ); 
				endwhile; endif; 
				// Reset Query
				wp_reset_query(); 				
			?>				
			</div>
			<div class="rightcontent">
			<?php
				/* Query all posts */
				$query = array( 'posts_per_page' => '10', 
								'category__and' => $cat,
								'ignore_sticky_posts' => 'true',
								'post__not_in' => $shownposts
								) ;
				
				query_posts( $query );
				if ( have_posts() ) : ?> 
					<div class="entry-title">Fler v&auml;lbes&ouml;kta</div>
					<?php while ( have_posts() ) : the_post(); ?>
					<div class="entry-wrapper">
						<a post_id="<?php the_ID(); ?>" href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</div>
				<?php
				endwhile; endif; 
				// Reset Query
				wp_reset_query(); 
			?>
			</div>
			<div class="clear"></div>
		</div>
	</div><!-- #content -->
	<?php dynamic_sidebar('firstpage-content'); ?>
</div><!-- #primary -->
<div id="firstpage-sidebar">
	<?php dynamic_sidebar('firstpage-sidebar'); ?>
</div>
