	<footer class="entry-meta">
		<div class="footer-wrapper">
			<div class="helpus"><?php comments_popup_link('Hj&auml;lp oss att bli b&auml;ttre!','Hj&auml;lp oss att bli b&auml;ttre!','Hj&auml;lp oss att bli b&auml;ttre!','','Hj&auml;lp oss att bli b&auml;ttre!'); ?></div>
			<div class="tag-cloud">Tillh&ouml;r: 
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

			</div>

			<div class="editor">Sidansvarig: <?php comments_popup_link(get_the_author(),get_the_author(),get_the_author(),'',get_the_author()); ?><?php edit_post_link( "Redigera inl&auml;gg", " [", "]" ); ?></div>
			<div class="reviewed"><?php echo get_the_reviewed_date(get_the_ID()); ?></div>

			<div class="permalink">Direktl&auml;nk: <a href="http://<?php echo $_SERVER['SERVER_NAME'] . get_permalink(); ?>">http://<?php echo $_SERVER['SERVER_NAME'] . get_permalink(); ?></a></div>


		</div>
	</footer><!-- .entry-meta -->
