	<footer class="entry-meta">
		<ul class="footer-wrapper">
			<li class="tag-cloud">Tillh&ouml;r: 
				<?php
					$categories_list = get_the_category_list( ' | ' );
					if ( $categories_list ):
				?>
				<span class="cat-links">
					<?php echo $categories_list; ?>
				</span>
				<?php endif; // End if categories ?>
				<?php
					$tags_list = get_the_term_list(get_the_ID(), "post_tag",'',' | ','');
					if ( $tags_list ): 
						if ($categories_list ) {
							echo " | ";
						} ?>

				<span class="tag-links">
					<?php echo $tags_list; ?>
				</span>

				<?php endif; // End if $tags_list ?>

			</li>

			<li class="editor">Sidansvarig: <?php comments_popup_link(get_the_author(),get_the_author(),get_the_author(),'',get_the_author()); ?><?php edit_post_link( "Redigera inl&auml;gg", " [", "]" ); ?></li>
			<li class="reviewed"><?php echo get_the_reviewed_date(get_the_ID()); ?></li>

			<li class="permalink">Direktl&auml;nk: <a href="http://<?php echo $_SERVER['SERVER_NAME'] . get_permalink(); ?>">http://<?php echo $_SERVER['SERVER_NAME'] . get_permalink(); ?></a></li>


		</ul>
	</footer><!-- .entry-meta -->
