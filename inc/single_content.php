<?php
		/**
		 * Single content, used in content.php (if is_single) and in post_load.php for dynamic load of post
		 */

		// featured image
		the_post_thumbnail('featured-image'); ?>
		
		<div class="single-content">
            <header class="entry-header">
                <h1 class="entry-title">
                    <?php echo get_the_title(); ?>
                </h1>
            </header>
        
			<div class="misc-ctrl">
				<div class="default">
					<ul>
						<li><a href="<?php get_permalink(); ?>">G&aring; till artikel</a></li>
						<li><a class="print-post" elem-id="#post-<?php echo $id ?>" href="#Print">Skriv ut</a></li>
						<li><a class="scroll-to-postFooter" elem-id="#post-<?php echo $id ?>" href="#Scroll">Till artikelfoten &#x2193;</a></li>
					</ul>
				</div>
				<div class="optional">
					<?php
						$optionaltext = get_post_custom_values('optional-text');
						if ($optionaltext) : foreach ($optionaltext as $value) {
							echo "<div class='optional-area'>" . $value . "<br></div>";
						} endif;
					?>
			</div><!-- .optional -->
			</div><!-- .misc-ctrl -->
		
			<div class="content">
				<?php
					$more = 1;       // Set (inside the loop) to display all content, including text below more. 
					the_content(); 
				?>
			</div><!-- .content -->
		</div><!-- .single-content -->
		
		<footer class="entry-meta">
			<?php $show_sep = false; ?>
			<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );
				if ( $categories_list ):
			?>
			<span class="cat-links">
				<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
				$show_sep = true; ?>
			</span>
			<?php endif; // End if categories ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'twentyeleven' ) );
				if ( $tags_list ):
				if ( $show_sep ) : ?>
			<span class="sep"> | </span>
				<?php endif; // End if $show_sep ?>
			<span class="tag-links">
				<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
				$show_sep = true; ?>
			</span>
			<?php endif; // End if $tags_list ?>
			<?php endif; // End if 'post' == get_post_type() ?>

			<?php if ( comments_open() ) : ?>
			<?php if ( $show_sep ) : ?>
			<span class="sep"> | </span>
			<?php endif; // End if $show_sep ?>
			<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentyeleven' ) . '</span>', __( '<b>1</b> Reply', 'twentyeleven' ), __( '<b>%</b> Replies', 'twentyeleven' ) ); ?></span>
			<?php endif; // End if comments_open() ?>

			<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
			
			<?php if ( $show_sep ) : ?>
			<span class="sep"> | </span>
			<?php endif; // End if $show_sep ?>
			
			<a class="scroll-to-postTop" elem-id="#post-<?php echo $id ?>" href="#Scroll">Till toppen &#x2191;</a>
			
			<?php if ( $show_sep ) : ?>
			<span class="sep"> | </span>
			<?php endif; // End if $show_sep ?>
			
			<?php if(function_exists('the_views')) { the_views(); } ?>

			<?php
				// get connected documents
				$optionaldoc = get_post_custom_values('optional-docs');
				if ($optionaldoc) : foreach ($optionaldoc as $value) {
					echo "<div class='optional-area'><b>Dokument</b><br>";
					if (is_array($value) && !empty($value)) : foreach (unserialize($value) as $docpage) {
						$doc = get_page($docpage);
						echo "<a href='#'>" . $doc->post_title . "</a><br>";
					} endif;
					echo "</div>";
				} endif; 

				// get connected contacts
				$optionalcontacts = get_post_custom_values('optional-contacts');
				if ($optionalcontacts) : foreach ($optionalcontacts as $value) {
					echo "<div class='optional-area'><b>Kontakter</b><br>";
						if (is_array($value) && !empty($value)) : 
							foreach (unserialize($value) as $docpage) {
								$doc = get_page($docpage);
								echo "<a href='#'>" . $doc->post_title . "</a><br>";
							}
						endif;
					echo "</div>";
				} endif; ?>
		</footer><!-- .entry-meta -->
		
<?php 
/* version 1.4 snippet
			<header class="entry-header">
				<?php if ( is_sticky() ) : ?>
					<hgroup>
						<h2 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<h3 class="entry-format"><?php _e( 'Featured', 'twentyeleven' ); ?></h3>
					</hgroup>
				<?php else : ?>
				<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'twentyeleven' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<?php endif; ?>

				<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php twentyeleven_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php endif; ?>

				<?php if ( comments_open() && ! post_password_required() ) : ?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( 'Reply', 'twentyeleven' ) . '</span>', _x( '1', 'comments number', 'twentyeleven' ), _x( '%', 'comments number', 'twentyeleven' ) ); ?>
				</div>
				<?php endif; ?>
			</header><!-- .entry-header -->

			<?php if ( is_search() ) : // Only display Excerpts for Search ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<?php else : ?>
			<div class="entry-content">
				<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) ); ?>
				<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'twentyeleven' ) . '</span>', 'after' => '</div>' ) ); ?>
			</div><!-- .entry-content -->
			<?php endif; ?>

			<footer class="entry-meta">
				<?php $show_sep = false; ?>
				<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
				<?php
					// translators: used between list items, there is a space after the comma 
					$categories_list = get_the_category_list( __( ', ', 'twentyeleven' ) );
					if ( $categories_list ):
				?>
				<span class="cat-links">
					<?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
					$show_sep = true; ?>
				</span>
				<?php endif; // End if categories ?>
				<?php
					// translators: used between list items, there is a space after the comma 
					$tags_list = get_the_tag_list( '', __( ', ', 'twentyeleven' ) );
					if ( $tags_list ):
					if ( $show_sep ) : ?>
				<span class="sep"> | </span>
					<?php endif; // End if $show_sep ?>
				<span class="tag-links">
					<?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'twentyeleven' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
					$show_sep = true; ?>
				</span>
				<?php endif; // End if $tags_list ?>
				<?php endif; // End if 'post' == get_post_type() ?>

				<?php if ( comments_open() ) : ?>
				<?php if ( $show_sep ) : ?>
				<span class="sep"> | </span>
				<?php endif; // End if $show_sep ?>
				<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentyeleven' ) . '</span>', __( '<b>1</b> Reply', 'twentyeleven' ), __( '<b>%</b> Replies', 'twentyeleven' ) ); ?></span>
				<?php endif; // End if comments_open() ?>

				<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- #entry-meta -->
			*/
?>