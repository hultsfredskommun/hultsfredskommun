<?php
		/**
		 * Single content, used in content.php (if is_single) and in post_load.php for dynamic load of post
		 */

		// featured image ?>
		<div class="img-wrapper">
			<?php the_post_thumbnail('featured-image'); ?>
		</div>
		
		<div class="single-content">
            <header class="entry-header">
                <h1 class="entry-title">
                    <?php echo get_the_title(); ?>
                </h1>
            </header>
        
			<div class="misc-ctrl">
				<div class="default">
					<ul>
						<li><a class="print-post" elem-id="#post-<?php echo $id ?>" href="#Print">Skriv ut</a></li>
						<li><a class="scroll-to-postFooter" elem-id="#post-<?php echo $id ?>" href="#Scroll">Till artikelfoten &#x2193;</a></li>
					</ul>
				</div>
				<div class="optional">
					<?php
						$optionaltext = get_post_custom_values('optional-text');
						if (isset($optionaltext)) : foreach ($optionaltext as $value) {
							echo "<div class='optional-area'>" . $value . "<br></div>";
						} endif;
					?>
				</div><!-- .optional -->
			</div><!-- .misc-ctrl -->
		
			<div class="content">
				<?php
					$more = 1;       // Set (inside the loop) to display all content, including text below more. 
					the_content();
					
					//embedded video
					$embeddedvideo = get_post_custom_values('embedded_code');
					if (isset($embeddedvideo)) : foreach ($embeddedvideo as $value) {
						echo "<div class='video-container'>" . $value . "<br></div>";
					} endif;
				?>
			</div><!-- .content -->
		</div><!-- .single-content -->
		
		<footer class="entry-meta">
			<div class="tag-cloud">
				<?php
					$categories_list = get_the_category_list( ' ' );
					if ( $categories_list ):
				?>
				<span class="cat-links">
					<?php echo $categories_list; ?>
				</span>
				<?php endif; // End if categories ?>
				<?php
					$tags_list = get_the_tag_list( ' ' );
					if ( $tags_list ): ?>
				<span class="tag-links">
					<?php echo $tags_list; ?>
				</span>

				<?php endif; // End if $tags_list ?>

				<?php 
					$list = get_the_term_list(get_the_ID(), "vem", " ", " ", " "); 					
					if ( $list ):
					?>
					<span class="vem-links">
						<?php echo $list; ?>
					</span>
				<?php endif; // End if vem ?>
				<?php 
					$list = get_the_term_list(get_the_ID(), "ort", " ", " ", " "); 					
					if ( $list ):
					?>
					<span class="ort-links">
						<?php echo $list; ?>
					</span>

				<?php endif; // End if ort ?>
			</div>

			<?php if( get_field('hk_related_pages') || get_field('hk_related_links') ) : ?>
				<div>Relaterad information</div>
				<ul>
				<?php if( get_field('hk_related_pages') ): ?>
					<?php while( has_sub_field('hk_related_pages') ): ?>
						<li class="related_page">
							<?php $value = get_sub_field('hk_related_page'); ?>
							<a href="<?php echo $value->guid; ?>" title="<?php echo get_sub_field('hk_related_page_description'); ?>"><?php echo $value->post_title; ?></a>
						</li>			 
					<?php endwhile; ?>			 
				<?php endif; ?> 

				<?php if( get_field('hk_related_links') ): ?>
					<?php while( has_sub_field('hk_related_links') ): ?>
						<li class="related_link">
							<a href="<?php echo get_sub_field('hk_related_link_url'); ?>" title="<?php echo get_sub_field('hk_related_link_description'); ?>"><?php echo get_sub_field('hk_related_link_name'); ?></a>
						</li>			 
					<?php endwhile; ?>			 
				<?php endif; ?> 
				</ul>
			<?php endif; ?>

			<?php if( get_field('hk_contacts') ) : ?>
				<div>Kontakta oss</div>
				<ul>
				<?php if( get_field('hk_contacts') ): ?>
					<?php while( has_sub_field('hk_contacts') ): ?>
						<li class="related_contact">
							<?php $value = get_sub_field('hk_contact'); ?>
							<a href="<?php echo $value->guid; ?>"><?php echo $value->post_title; ?></a>
						</li>			 
					<?php endwhile; ?>			 
				<?php endif; ?> 
				</ul>
			<?php endif; ?>

			<div class="editor">Sidansvarig: <?php the_author(); ?></div>

			<?php if ( comments_open() ) : ?>
			
			<span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'twentyeleven' ) . '</span>', __( '<b>1</b> Reply', 'twentyeleven' ), __( '<b>%</b> Replies', 'twentyeleven' ) ); ?></span>
			<?php endif; // End if comments_open() ?>

			<?php edit_post_link( __( 'Edit', 'twentyeleven' ), '<span class="edit-link">', '</span>' ); ?>
			
			
			<a class="scroll-to-postTop" elem-id="#post-<?php echo $id ?>" href="#Scroll">Till toppen &#x2191;</a>
			
			
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
