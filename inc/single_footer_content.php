	<footer class="entry-meta">
		<ul class="footer-wrapper">
			<?php
			$categories_list = get_the_category_list( ' | ' );
			if ( $categories_list && $categories_list != "Okategoriserade" ): ?>
			<li class="tag-cloud">Tillh&ouml;r:
				<span class="cat-links">
					<?php echo $categories_list; ?>
				</span>
			</li>
			<?php endif; // End if categories ?>
			<?php
			$tags_list = get_the_term_list(get_the_ID(), "post_tag",'',' | ','');
			if ( $tags_list ):  ?>
				<li class="tag-cloud">Visa bara: 
					<span class="tag-links">
					<?php echo $tags_list; ?>
					</span>
				</li>
			<?php endif; // End if $tags_list ?>
			<li class="editor vcard author"><span class="fn">Sidansvarig: <a class="gtm-footer-email-link" href="mailto:<?php the_author_meta('user_email',$post->post_author); ?>" title="E-post till <?php the_author_meta('display_name',$post->post_author); ?>"><?php the_author_meta('display_name',$post->post_author); ?></a>
</span> <?php edit_post_link( "Redigera inl&auml;gg", " [", "]" ); ?></li>
			<li class="reviewed"><?php echo get_the_reviewed_date(get_the_ID()); ?></li>
			<?php /*if (function_exists("get_field") && get_field("hk_synonym") != "") : ?>
			<li class="synonym">Synonymer: <?php echo get_field("hk_synonym"); ?></a></li>
			<?php endif;*/ ?>
			<li class="permalink">Direktl&auml;nk: <a href="<?php echo get_permalink(); ?>" title='Direktl&auml;nk till artikel'><?php echo get_permalink(); ?></a></li>

		</ul>
		<?php comments_template( '', true ); ?>
	</footer><!-- .entry-meta -->

