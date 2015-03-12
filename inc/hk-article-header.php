<?php global $options; ?>
<div class="content-header">
	<ul class="header-tools">

		<?php if (isset($options['readspeaker_id'])) : ?>
		<li class="readspeaker-item item">
			<a class="toggle-tool js-toggle-dropdown"><span class="readspeaker-icon"></span>Lyssna</a>
			<ul class="dropdown">			 
				<li class="readspeaker">
				<div id="readspeaker_button1" class="readspeaker_toolbox rs_skip rsbtn rs_preserve rsbtn_compactskin">
					<a class="rsbtn_play" accesskey="L" title="Lyssna p&aring; artikel" href="http://app.eu.readspeaker.com/cgi-bin/rsent?customerid=<?php echo $options['readspeaker_id']; ?>&amp;lang=sv_se&amp;readid=content-<?php the_ID(); ?>&amp;url=<?php the_permalink(); ?>">
					<span class="rsbtn_left rsimg rspart"><span class="rsbtn_text"><span>Lyssna</span></span></span>
					<span class="rsbtn_right rsimg rsplay rspart"></span></a>
				</div>
				</li>
			</ul>
		</li>
		
		<?php endif; ?>
		<?php if ($options['addthis_pubid'] != "") : // TODO when cookies work && ($_REQUEST["cookies"] == "true" || $default_settings['allow_cookies'])) : ?>
		<li class="addthis-item item">
			<a class="toggle-tool js-toggle-dropdown"><span class="addthis-icon"></span>Dela</a>
			<ul class="dropdown">
				<li class="addthis">
					<div class="addthis_toolbox addthis_32x32_style" addthis:url="<?php echo the_permalink(); ?>" addthis:title="<?php the_title(); ?>" addthis:description="Kolla den h&auml;r sidan.">
						<a class="addthis_button_facebook"></a>
						<a class="addthis_button_twitter"></a>
						<a class="addthis_button_google_plusone_share"></a>
						<a class="addthis_button_email"></a>
						<a class="addthis_button_print"></a>
						<a class="addthis_button_compact"></a>
						<!--a class="addthis_counter addthis_bubble_style"></a-->
					</div>
				</li>
			</ul>
		</li>
		<?php endif; ?>
		
		<?php edit_post_link( "<span class='tool-icon'></span>Redigera inl&auml;gg", "<li class='edit-post aside-list-item item'>", "</li>" ); ?>
		
		<li class="close-button-item item"></li>
	</ul>
</div>