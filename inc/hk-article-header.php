<?php global $options; ?>
<div class="content-header">
	<ul class="header-tools">

		<?php if (isset($options['readspeaker_id'])) : ?>
		<li class="readspeaker-item item">
			<a class="toggle-tool js-toggle-dropdown"><span class="readspeaker-icon"></span>Lyssna</a>
			<ul class="dropdown">
				<li class="readspeaker">
				<div id="readspeaker_button1" class="readspeaker_toolbox rs_skip rsbtn rs_preserve rsbtn_compactskin">
					<a class="rsbtn_play" accesskey="L" title="Lyssna p&aring; artikel" href="https://app-eu.readspeaker.com/cgi-bin/rsent?customerid=<?php echo $options['readspeaker_id']; ?>&amp;lang=sv_se&amp;readid=content-<?php the_ID(); ?>&amp;url=<?php the_permalink(); ?>">
					<span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>Lyssna</span></span></span>
					<span class="rsbtn_right rsimg rsplay rspart"></span></a>
				</div>
				</li>
			</ul>
		</li>

		<?php endif; ?>

		<?php edit_post_link( "<span class='tool-icon'></span>Redigera inl&auml;gg", "<li class='edit-post aside-list-item item'>", "</li>" ); ?>

		<li class="close-button-item item"></li>
	</ul>
</div>
