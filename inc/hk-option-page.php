<?php
/**
 * Hultsfredskommun theme options page
 */

add_action('admin_init', 'hk_theme_options_init' );
add_action('admin_menu', 'hk_theme_options_add_page');

// Init plugin options to white list our options
function hk_theme_options_init(){
	register_setting( 'hk_theme_options_options', 'hk_theme', 'hk_theme_options_validate' );
}

// Add menu page
function hk_theme_options_add_page() {
	add_theme_page('Inst&auml;llningar', 'Inst&auml;llningar', 'manage_options', 'hk_theme_options', 'hk_theme_options_do_page');
}

// Draw the menu page itself
function hk_theme_options_do_page() {
	?>
	<div class="wrap">
		<h1>Inställningar för temat Hultsfredskommun</h1>
		<form id="form_hk_options" method="post" action="options.php">
			<?php settings_fields('hk_theme_options_options'); ?>
			<?php $options = get_option('hk_theme'); ?>



			<a href="#sidhuvud">Sidhuvud</a>
			<a href="#meddelande">Meddelande</a>
			<a href="#kategorier">Kategorier</a>
			<a href="#kontakta-oss">Kontakta-oss</a>
			<a href="#permalänkar">Permalänkar</a>
			<a href="#tillagg">Tillägg</a>
			<a href="#statistik">Statistik och cookies</a>
			<a href="#cron">Cron</a>
			<a href="#sidfot">Sidfot</a>
			<a href="#barntema">Barntema</a>
			<a href="#info">Standardinställningar</a>
			<a href="#debug">debug</a>


			<a name="sidhuvud"></a>
			<hr/><h2>Sidhuvud</h2>
			<h3>Logga</h3>
			<p><label for="hk_theme[logo_image]">Logga</label><br/>
				<img width='150' src="<?php echo $options["logo_image"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo_image]" value="<?php echo $options["logo_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo_image_svg]">Logga (svg)</label><br/>
				<img width='150' src="<?php echo $options["logo_image_svg"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo_image_svg]" value="<?php echo $options["logo_image_svg"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo_mobile_image]">Logga mobil</label><br/>
				<img width='150' src="<?php echo $options["logo_mobile_image"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo_mobile_image]" value="<?php echo $options["logo_mobile_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo_mobile_image_svg]">Logga mobil (svg)</label><br/>
				<img width='150' src="<?php echo $options["logo_mobile_image_svg"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo_mobile_image_svg]" value="<?php echo $options["logo_mobile_image_svg"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo_link_alt]">ALT-text p&aring; loggan:</label><br/><input size="80" type="text" name="hk_theme[logo_link_alt]" value="<?php echo $options['logo_link_alt']; ?>" /></p>
			<p><label for="hk_theme[logo_link]">URL som loggan ska peka p&aring;:</label><br/><input size="80" type="text" name="hk_theme[logo_link]" value="<?php echo $options['logo_link']; ?>" /></p>

			<h3>S&ouml;k och meny</h3>
			<p><label for="hk_theme[search_watermark]">Vattenst&auml;mpel i s&ouml;k</label><br/><input size="80" type="text" name="hk_theme[search_watermark]" value="<?php echo $options['search_watermark']; ?>" /></p>
			<p><input type="checkbox" name="hk_theme[topmenu_google_translate]" value="1"<?php checked( 1 == $options['topmenu_google_translate'] ); ?> /> <label for="hk_theme[topmenu_google_translate]">Visa Google translate i toppmeny.</label></p>

			<?php submit_button(); ?>

			<hr/><h2>Meddelande</h2>
			<a name="meddelande"></a>
			<h3>Google search description</h3>
			<p><label for="hk_theme[meta_description]">Meta description</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[meta_description]"><?php echo $options['meta_description']; ?></textarea></p>

			<h3>Meddelande vid 404</h3>
			<p><label for="hk_theme[404title]">Titel</label><br/><input size="80" type="text" name="hk_theme[404title]" value="<?php echo $options['404title']; ?>" /></p>
			<p><label for="hk_theme[404message]">Meddelande</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[404message]"><?php echo $options['404message']; ?></textarea></p>
			<?php if(function_exists('get_most_viewed')) { ?>
			<p><label for="hk_theme[404message2]">Meddelande2 (innan mest bes&ouml;kta)</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[404message2]"><?php echo $options['404message2']; ?></textarea></p>
			<?php } ?>

			<h3>Meddelande vid tom s&ouml;kning</h3>
			<p><label for="hk_theme[emptytitle]">Titel</label><br/><input size="80" type="text" name="hk_theme[emptytitle]" value="<?php echo $options['emptytitle']; ?>" /></p>
			<p><label for="hk_theme[emptymessage]">Meddelande</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[emptymessage]"><?php echo $options['emptymessage']; ?></textarea></p>
			<?php if(function_exists('get_most_viewed')) { ?>
			<p><label for="hk_theme[emptymessage2]">Meddelande2 (innan mest bes&ouml;kta)</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[emptymessage2]"><?php echo $options['emptymessage2']; ?></textarea></p>
			<?php } ?>

			<h3>Meddelande vid tom kategorilistning</h3>
			<p><label for="hk_theme[emptycattitle]">Titel</label><br/><input size="80" type="text" name="hk_theme[emptycattitle]" value="<?php echo $options['emptycattitle']; ?>" /></p>
			<p><label for="hk_theme[emptycatmessage]">Meddelande</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[emptycatmessage]"><?php echo $options['emptycatmessage']; ?></textarea></p>
			<?php if(function_exists('get_most_viewed')) { ?>
			<p><label for="hk_theme[emptycatmessage2]">Meddelande2 (innan mest bes&ouml;kta)</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[emptycatmessage2]"><?php echo $options['emptycatmessage2']; ?></textarea></p>
			<?php } ?>
			<p><label for="hk_theme[emptycatmessage3]">Meddelande3 (innan listning av underkategori)</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[emptycatmessage3]"><?php echo $options['emptycatmessage3']; ?></textarea></p>

			<?php submit_button(); ?>


			<a name="kategorier"></a>
			<hr/><h2>Kategorier, fl&ouml;de och menyer</h2>
			<p><label for="hk_theme[default_thumbnail_image]">Defaulttumnagel som visas om artikel inte har någon utvald bild (bör ha storlek 177x100px)</label><br/>
				<img width=150 src="<?php echo $options["default_thumbnail_image"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[default_thumbnail_image]" value="<?php echo $options["default_thumbnail_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>

			<p><label for="hk_theme[video_thumbnail_image]">Bild som visas om över artikeltumnagel om video är vald (på mellanstardsida)</label><br/>
				<img width=150 src="<?php echo $options["video_thumbnail_image"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[video_thumbnail_image]" value="<?php echo $options["video_thumbnail_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>

			<p><input type="checkbox" name="hk_theme[hide_articles_in_subsubcat]" value="1"<?php checked( 1 == $options['hide_articles_in_subsubcat'] ); ?> /> <label for="hk_theme[hide_articles_in_subsubcat]">Dölj artiklar p&aring; ing&aring;ngssidor.</label></p>
			<p><input type="checkbox" name="hk_theme[hide_leftmenu]" value="1"<?php checked( 1 == $options['hide_leftmenu'] ); ?> /> <label for="hk_theme[hide_leftmenu]">Dölj v&auml;nstermeny.</label></p>
			<p><input type="checkbox" name="hk_theme[use_dynamic_posts_load_in_category]" value="1"<?php checked( 1 == $options['use_dynamic_posts_load_in_category'] ); ?> /> <label for="hk_theme[use_dynamic_posts_load_in_category]">Anv&auml;nd dynamisk laddning (infinite scroll) av inl&auml;gg p&aring; kategorilistning.</label></p>

			<p><label for="hk_theme[startpage_cat]">Välj kategori som är startsida.</label><br/>
							<?php
				$args = array(
					'orderby'            => 'ID',
					'order'              => 'ASC',
					'echo'               => 1,
					'selected'           => esc_attr( $options["startpage_cat"] ),
					'hierarchical'       => 1,
					'name'               => 'hk_theme[startpage_cat]',
					'depth'              => 0,
					'taxonomy'           => 'category',
					'show_count'         => true,
					'hide_empty'         => false,
					'hide_if_empty'      => false,
					'show_option_all' => 'Ingen' );
				wp_dropdown_categories( $args );
			?>
			</p>


			<p><label for="hk_theme[news_tag]">Välj den etikett som innehåller <b>nyheter</b>.</label><br/>
							<?php
				$args = array(
					'orderby'            => 'ID',
					'order'              => 'ASC',
					'echo'               => 1,
					'selected'           => esc_attr( $options["news_tag"] ),
					'hierarchical'       => 1,
					'name'               => 'hk_theme[news_tag]',
					'depth'              => 0,
					'taxonomy'           => 'post_tag',
					'show_count'         => true,
					'hide_empty'         => false,
					'hide_if_empty'      => false,
					'show_option_all' => 'Ingen' );
				wp_dropdown_categories( $args );
			?>
			</p>

			<p><label for="hk_theme[show_taglist_as_newslist]">Etiketter ska visas som nyhetslistning. (kommaseparerad lista med etikett-slug-namn) </label><br/><input type="text" name="hk_theme[show_taglist_as_newslist]" value="<?php echo $options["show_taglist_as_newslist"]; ?>" /></p>

			<p><label for="hk_theme[show_categorylist_lattlast]">Kategorier ska visas som l&auml;ttl&auml;st. (kommaseparerad lista med kategori-slug-namn) </label><br/><input type="text" name="hk_theme[show_categorylist_lattlast]" value="<?php echo $options["show_categorylist_lattlast"]; ?>" /></p>

			<p><label for="hk_theme[hidden_cat]">Välj kategori som innehåller <b>ej synliga poster</b>.</label><br/>
							<?php
				$args = array(
					'orderby'            => 'ID',
					'order'              => 'ASC',
					'echo'               => 1,
					'selected'           => esc_attr( $options["hidden_cat"] ),
					'hierarchical'       => 1,
					'name'               => 'hk_theme[hidden_cat]',
					'depth'              => 0,
					'taxonomy'           => 'category',
					'show_count'         => true,
					'hide_empty'         => false,
					'hide_if_empty'      => false,
					'show_option_all' => 'Ingen' );
				wp_dropdown_categories( $args );
			?>
			</p>

			<p><label for="hk_theme[protocol_cat]">Välj kategori som innehåller <b>protokoll</b>.</label><br/>
							<?php
				$args = array(
					'orderby'            => 'ID',
					'order'              => 'ASC',
					'echo'               => 1,
					'selected'           => esc_attr( $options["protocol_cat"] ),
					'hierarchical'       => 1,
					'name'               => 'hk_theme[protocol_cat]',
					'depth'              => 0,
					'taxonomy'           => 'category',
					'show_count'         => true,
					'hide_empty'         => false,
					'hide_if_empty'      => false,
					'show_option_all' => 'Ingen');
				wp_dropdown_categories( $args );
			?>
			</p>

			<p><label for="hk_theme[num_levels_in_menu]">Antal nivåer i huvudmeny. (default: 2)</label><br/><input size="8" type="text" name="hk_theme[num_levels_in_menu]" value="<?php echo (!isset($options["num_levels_in_menu"]) || $options["num_levels_in_menu"] == "")?2:$options['num_levels_in_menu']; ?>" /></p>
			<p><label for="hk_theme[show_tags]">Visa etiketter i vänstermeny. (default: 1) </label><br/><input type="text" name="hk_theme[show_tags]" value="<?php echo (!isset($options["show_tags"]) || $options["show_tags"] == "")?1:$options['show_tags']; ?>" /></p>
			<p><label for="hk_theme[category_slideshow_thumbnail_size]">Tumnagelstorlek för bildspel i kategorilista. (default: wide-image)</label><br/><input size="8" type="text" name="hk_theme[category_slideshow_thumbnail_size]" value="<?php echo (!isset($options["category_slideshow_thumbnail_size"]) || $options["category_slideshow_thumbnail_size"] == "")?'wide-image':$options['category_slideshow_thumbnail_size']; ?>" /></p>

			<?php submit_button(); ?>

			<a name="kontakta-oss"></a>
			<hr/><h2>Kontakta-oss flikar - l&auml;nkar</h2>
			<p><label for="hk_theme[comment_side_link]">Kontakta-oss-l&auml;nk</label><br/><input size="80" type="text" name="hk_theme[contact_side_link]" value="<?php echo $options['contact_side_link']; ?>" /></p>
			<p><label for="hk_theme[comment_side_link]">Hjälp-oss-l&auml;nk</label><br/><input size="80" type="text" name="hk_theme[comment_side_link]" value="<?php echo $options['comment_side_link']; ?>" /></p>
			<?php submit_button(); ?>

			<a name="permalänkar"></a>
			<hr/><h2>Permal&auml;nkar</h2>
			<p><label for="hk_theme[permalinkstructure]">Permal&auml;nkstruktur f&ouml;r kontakter, om n&aring;gon fast struktur under Inst&auml;llningar -&gt; Permal&auml;nkar &auml;r satt (ex. om anpassad struktur &auml;r <b>/artikel/</b>%postname%/, s&aring; s&auml;tt <b>/artikel/</b>kontakter i denna inst&auml;llning).</label><br/><input type="text" name="hk_theme[permalinkstructure]" value="<?php echo $options['permalinkstructure']; ?>" /></p>
			<?php echo "<i>Flushing rewrite rules.</i> ";
			flush_rewrite_rules();
			echo "<i>Done.</i>";?>
			<?php submit_button(); ?>


			<a name="tillagg"></a>
			<hr/><h2>Till&auml;gg</h2>
			<p><input type="checkbox" name="hk_theme[gcse_ajax]" value="1"<?php checked( 1 == $options['gcse_ajax'] ); ?> /> <label for="hk_theme[gcse_ajax]">Använd AJAX-sökning.</label></p>
			<p><input type="checkbox" name="hk_theme[gcse_enable_faq_search]" value="1"<?php checked( 1 == $options['gcse_enable_faq_search'] ); ?> /> <label for="hk_theme[gcse_enable_faq_search]">Sök specifikt i vanliga fr&aring;gor, visas i en kolumn bredvid vanliga s&ouml;ktr&auml;ffarna.</label></p>
			<p><label for="hk_theme[faq_search_ignore_words]">Ord som ska nerprioriteras vid sökning i 'Vanliga fr&aring;gor'.</label><br/><input type="text" size="80" name="hk_theme[faq_search_ignore_words]" value="<?php echo $options['faq_search_ignore_words']; ?>" /></p>

			<p><label for="hk_theme[readspeaker_id]">Readspeaker id. L&auml;gger till Lyssna i artikel.</label><br/><input type="text" size="80" name="hk_theme[readspeaker_id]" value="<?php echo $options['readspeaker_id']; ?>" /></p>
			<p><label for="hk_theme[googlemapskey]">Google Maps key.</label><br/><input type="text" size="80" name="hk_theme[googlemapskey]" value="<?php echo $options['googlemapskey']; ?>" /></p>
			<p><label for="hk_theme[in_head_section]">script or other in &lt;head&gt;-section</label><br/><textarea cols="100" rows="5" type="text" name="hk_theme[in_head_section]"><?php echo $options['in_head_section']; ?></textarea></p>
			<p><label for="hk_theme[in_topbody_section]">script or other in top of &lt;body&gt;-section</label><br/><textarea cols="100" rows="5" type="text" name="hk_theme[in_topbody_section]"><?php echo $options['in_topbody_section']; ?></textarea></p>
			<h3>only_content mode (add ?only_content to url to use)</h3>
			<p><label for="hk_theme[if_only_content]">style - style-tag is wrapped around content</label><br/><textarea cols="100" rows="5" type="text" name="hk_theme[if_only_content]"><?php echo $options['if_only_content']; ?></textarea></p>
			<p><label for="hk_theme[if_only_content_js]">js or other - nothing is wrapped around this content</label><br/><textarea cols="100" rows="5" type="text" name="hk_theme[if_only_content_js]"><?php echo $options['if_only_content_js']; ?></textarea></p>

			<?php submit_button(); ?>

			<a name="statistik"></a>
			<hr/><h2>Statistik och cookies</h2>
			<p><input type="checkbox" name="hk_theme[cookie_accept_enable]" value="1"<?php checked( 1 == $options['cookie_accept_enable'] ); ?> /> <label for="hk_theme[cookie_accept_enable]">St&auml;ll fr&aring;ga om cookies f&aring;r anv&auml;ndas.</label></p>
			<p><label for="hk_theme[cookie_text]">Förklarande text för att godkänna cookies. </label><br/><input size="80" type="text" name="hk_theme[cookie_text]" value="<?php echo $options['cookie_text']; ?>" /></p>
			<p><label for="hk_theme[cookie_button_text]">Text på godkänn cookies knapp. </label><br/><input size="80" type="text" name="hk_theme[cookie_button_text]" value="<?php echo $options['cookie_button_text']; ?>" /></p>
			<p><label for="hk_theme[cookie_link_text]">Länktext till mer information om cookies. </label><br/><input size="80" type="text" name="hk_theme[cookie_link_text]" value="<?php echo $options['cookie_link_text']; ?>" /></p>
			<p><label for="hk_theme[cookie_link]">Länk till mer information om cookies. </label><br/><input size="80" type="text" name="hk_theme[cookie_link]" value="<?php echo $options['cookie_link']; ?>" /></p>
			<?php submit_button(); ?>

			<a name="cron"></a>
			<hr/><h2>Cron</h2>

			<?php if(function_exists("register_field_group")) : // if acf plugin enabled ?>
			<h3>Sluta publicera</h3>
			<?php if ($options["hidden_cat"] == "" || $options["hidden_cat"] == "0") : ?>
			<b>Ej synlig kategori måste sättas för att sluta publicera ska fungera.</b>
			<?php else: ?>

			<p><input type="checkbox" name="hk_theme[enable_cron_stop_publish]" <?php echo ($options['enable_cron_stop_publish'])?"checked":""; ?> />
			<label for="hk_theme[enable_cron_stop_publish]">Aktivera sluta publicera.</label> <?php echo (wp_next_scheduled( 'hk_stop_publish_event' ))?"Aktiverat.":"Inaktiverat."; ?></p>
			<?php
			if ($options['enable_cron_stop_publish']) {
				if ( !wp_next_scheduled( 'hk_stop_publish_event' ) ) {
					wp_schedule_event( time(), 'hk_five_minutes', 'hk_stop_publish_event');
				}
			}
			else
			{
				if ( wp_next_scheduled( 'hk_stop_publish_event' ) ) {
					wp_clear_scheduled_hook('hk_stop_publish_event');
				}
			}
			?>
			Kollar "sluta publicera" <b><?php echo Date("Y-m-d H:i:s",wp_next_scheduled( 'hk_stop_publish_event' )); ?></b> nästa gång. <br>
			Kördes senast <b><?php echo Date("Y-m-d H:i:s",$options["hk_stop_publish_time"]); ?></b><br>
			LOG: <br><textarea cols=100 rows=5><?php echo $options["hk_stop_publish_log"]; ?></textarea>
			<?php endif; // hidden_cat ?>
			<?php endif; ?>

			<h3>Granskningsmail</h3>
			<p><input type="checkbox" name="hk_theme[enable_cron_review_mail]" <?php echo ($options['enable_cron_review_mail'])?"checked":""; ?> />
			<label for="hk_theme[enable_cron_review_mail]">Aktivera granskningsmail.</label> <?php echo (wp_next_scheduled( 'hk_review_mail_event' ))?"Aktiverat.":"Inaktiverat."; ?></p>
			<p><label for="hk_theme[no_reviews_to_cat]">Skicka inte granskningsmail om inlägget tillhör dessa kategorier.</label><br/><input size="40" type="text" name="hk_theme[no_reviews_to_cat]" value="<?php echo $options['no_reviews_to_cat']; ?>" /></p>
			<p><label for="hk_theme[review_send_only_mail_to]">Skicka bara e-post till denna adress.</label>
			<br/><input size=40 type="text" name="hk_theme[review_send_only_mail_to]" value="<?php echo $options['review_send_only_mail_to']; ?>" /></p>
			<?php
			// review mail
			if ($options['enable_cron_review_mail']) {
				if ( !wp_next_scheduled( 'hk_review_mail_event' ) ) {
					wp_schedule_event( time(), 'hk_weekly', 'hk_review_mail_event');
				}
			}
			else
			{
				if ( wp_next_scheduled( 'hk_review_mail_event' ) ) {
					wp_clear_scheduled_hook('hk_review_mail_event');
				}
			}
			?>

			Skickar granska mail <b><?php echo Date("Y-m-d H:i:s",wp_next_scheduled( 'hk_review_mail_event' )); ?></b> nästa gång. <br>
			Kördes senast <b><?php echo Date("Y-m-d H:i:s",$options["hk_review_mail_time"]); ?></b><br>
			LOG: <br><textarea name="hk_theme[hk_review_mail_log]" cols=100 rows=5><?php echo $options["hk_review_mail_log"]; ?></textarea>


			<?php
			if (function_exists( 'views_orderby' )) : // if plugin WP-PostViews is enabled
			?>

			<h3>Normalisera klickräknare</h3>
			<p><input type="checkbox" name="hk_theme[enable_cron_normalize]" <?php echo ($options['enable_cron_normalize'])?"checked":""; ?> />
			<label for="hk_theme[enable_cron_normalize]">Aktivera normalisera räknare.</label> <?php echo (wp_next_scheduled( 'hk_normalize_count_event' ))?"Aktiverat.":"Inaktiverat."; ?>
			<p><input type="checkbox" name="hk_theme[force_normalize]" value="1" /> <label for="hk_theme[force_normalize]">Tvinga normalisera!</label> </p>
			<p>Normalisering körs <b><?php echo  Date("Y-m-d H:i:s",wp_next_scheduled( 'hk_normalize_count_event' )); ?></b> nästa gång.<br/>
			Kördes senast <b><?php echo Date("Y-m-d H:i:s",$options["hk_normalize_count_time"]); ?></b><br>
			<?php
				if ($options["enable_cron_normalize"]) {
					if ( !wp_next_scheduled( 'hk_normalize_count_event' ) ) {
						wp_schedule_event( time(), 'hk_monthly', 'hk_normalize_count_event');
					}
				}
				else {
					if ( wp_next_scheduled( 'hk_normalize_count_event' ) ) {
						wp_clear_scheduled_hook( 'hk_normalize_count_event');
					}
				}
				if ($options["force_normalize"] == "1") {
					echo "<br/><b>Tvingar normalisera visningar. Uppdatera sidan efter&aring;t f&ouml;r att se r&auml;tt log.</b> <br/><br/>";
					$log = hk_normalize_count(true);
					$opt = get_option("hk_theme");
					$opt["hk_normalize_count_log"] = $log;
					$opt["force_normalize"] = 0;
					update_option("hk_theme", $opt);
				}
			?>
			LOG:<br> <textarea name="hk_theme[hk_normalize_count_log]" cols=100 rows=5><?php echo $options["hk_normalize_count_log"]; ?></textarea> </p>
			<?php endif; // endif (function_exists( 'views_orderby' ))?>
			<?php submit_button(); ?>

			<a name="sidfot"></a>
			<hr/><h2>Sidfot</h2>
			<p><label for="hk_theme[footer_image]">Sidfot</label><br/>
				<img width=150 src="<?php echo $options["footer_image"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[footer_image]" value="<?php echo $options["footer_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo_footer_image]">Logga i sidfot</label><br/>
				<img width=150  src="<?php echo $options["logo_footer_image"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo_footer_image]" value="<?php echo $options["logo_footer_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<?php submit_button(); ?>

			<?php /* hook to be able to add options from child theme */ ?>

			<a name="barntema"></a>
			<hr/><h2>Extra inst&auml;llningar fr&aring;n barntema</h2>
			<?php echo do_action('hk_options_hook', $options); ?>
			<?php submit_button(); ?>

			<a name="info"></a>
			<hr/><h2>Information om standardinställningar</h2>
			date_default_timezone_get() : <?php echo date_default_timezone_get(); ?><br>
			dag och tid (current_time): <?php echo date("Y-m-d H:i:s",current_time('timestamp',0)); ?><br>
			dag och tid (standard php date): <?php echo date("Y-m-d H:i:s"); ?><br>


			<?php submit_button(); ?>

		</form>
	</div>
	<?php
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function hk_theme_options_validate($input) {
	// Our first value is either 0 or 1
	//$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our second option must be safe text with no HTML tags
	//$input['sometext'] =  wp_filter_nohtml_kses($input['sometext']);

	return $input;
}



/* make media upload work */
function my_admin_scripts() {
	if (!empty($_REQUEST["page"]) && $_REQUEST["page"] == "hk_theme_options") {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('my-upload', get_template_directory_uri() . '/js/hk-option-page.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('my-upload');
	}
}

function my_admin_styles() {
	wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');

?>
