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
			<h3>Favicon</h3>
			<p><label for="hk_theme[favicon_image32]">Favicon 32x32</label><br/>
				<img width='32' src="<?php echo $options["favicon_image32"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[favicon_image32]" value="<?php echo $options["favicon_image32"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[favicon_image64]">Favicon 64x64</label><br/>
				<img width='64' src="<?php echo $options["favicon_image64"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[favicon_image64]" value="<?php echo $options["favicon_image64"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[favicon_image128]">Favicon 128x128</label><br/>
				<img width='128' src="<?php echo $options["favicon_image128"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[favicon_image128]" value="<?php echo $options["favicon_image128"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[favicon_image256]">Favicon 256x256</label><br/>
				<img width='256' src="<?php echo $options["favicon_image256"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[favicon_image256]" value="<?php echo $options["favicon_image256"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>

			<p><label for="hk_theme[favicon_image152]">Apple Favicon 152x152</label><br/>
				<img width='152' src="<?php echo $options["favicon_image152"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[favicon_image152]" value="<?php echo $options["favicon_image152"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[favicon_image144]">Apple Favicon 144x144</label><br/>
				<img width='144' src="<?php echo $options["favicon_image144"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[favicon_image144]" value="<?php echo $options["favicon_image144"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[favicon_image120]">Apple Favicon 120x120</label><br/>
				<img width='120' src="<?php echo $options["favicon_image120"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[favicon_image120]" value="<?php echo $options["favicon_image120"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[favicon_image114]">Apple Favicon 114x114</label><br/>
				<img width='114' src="<?php echo $options["favicon_image114"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[favicon_image114]" value="<?php echo $options["favicon_image114"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>

			<h3>S&ouml;k och meny</h3>
			<p><label for="hk_theme[search_watermark]">Vattenst&auml;mpel i s&ouml;k</label><br/><input size="80" type="text" name="hk_theme[search_watermark]" value="<?php echo $options['search_watermark']; ?>" /></p>
			<p><input type="checkbox" name="hk_theme[topmenu_google_translate]" value="1"<?php checked( 1 == $options['topmenu_google_translate'] ); ?> /> <label for="hk_theme[topmenu_google_translate]">Visa Google translate i toppmeny.</label></p>


			<h3>Extra loggor</h3>
			<p><label for="hk_theme[right_logo_html]">HTML vid eller ist&auml;llet för logo2</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[right_logo_html]"><?php echo $options['right_logo_html']; ?></textarea></p>
			<p><label for="hk_theme[logo2_image]">Logga 2 - till h&ouml;ger i huvudet</label><br/>
				<img width=150  src="<?php echo $options["logo2_image"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo2_image]" value="<?php echo $options["logo2_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo2_link]">Logga 2 l&auml;nk. </label><br/><input size="80" type="text" name="hk_theme[logo2_link]" value="<?php echo $options['logo2_link']; ?>" /></p>
			<p><label for="hk_theme[logo2_descr]">Logga 2 beskrivning. </label><br/><input size="80" type="text" name="hk_theme[logo2_descr]" value="<?php echo $options['logo2_descr']; ?>" /></p>
			<p><label for="hk_theme[logo3_image]">Logga 3 - till h&ouml;ger i huvudet</label><br/>
				<img width=150  src="<?php echo $options["logo3_image"]; ?>" alt='Vald bild' title='Vald bild' />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo3_image]" value="<?php echo $options["logo3_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo3_link]">Logga 3 l&auml;nk. </label><br/><input size="80" type="text" name="hk_theme[logo3_link]" value="<?php echo $options['logo3_link']; ?>" /></p>
			<p><label for="hk_theme[logo3_descr]">Logga 3 beskrivning. </label><br/><input size="80" type="text" name="hk_theme[logo3_descr]" value="<?php echo $options['logo3_descr']; ?>" /></p>
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

			<h3>Meddelande f&ouml;re kommentar till sidansvarig</h3>
			<p><label for="hk_theme[emptycatmessage3]">Meddelande (innan kommentarsf&auml;ltet)</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[comment_notes_before]"><?php echo $options['comment_notes_before']; ?></textarea></p>
			<?php submit_button(); ?>


			<a name="kategorier"></a>
			<hr/><h2>Kategorier, fl&ouml;de och menyer</h2>
			<p><label for="hk_theme[smallwords]">Värdeord över huvudmeny</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[smallwords]"><?php echo $options['smallwords']; ?></textarea></p>

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

			<p><label for="hk_theme[show_most_viewed_in_subsubcat]">Visa antal mest bes&ouml;kta artiklar p&aring; ing&aring;ngssidor. (Tom eller noll f&ouml;r att d&ouml;lja.)</label><br/><input type="text" name="hk_theme[show_most_viewed_in_subsubcat]" value="<?php echo (!isset($options["show_most_viewed_in_subsubcat"]) || $options["show_most_viewed_in_subsubcat"] == "")?0:$options['show_most_viewed_in_subsubcat']; ?>" /></p>
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

			<p><label for="hk_theme[order_by_date]">Välj vilka kategorier som ska sorteras på datum istället för mest besökt.</label><br/><input size="40" type="text" name="hk_theme[order_by_date]" value="<?php echo $options['order_by_date']; ?>" /></p>
			<p><label for="hk_theme[order_by_alpha]">Välj vilka kategorier som ska sorteras i bokstavsordning istället för mest besökt.</label><br/><input size="40" type="text" name="hk_theme[order_by_alpha]" value="<?php echo $options['order_by_alpha']; ?>" /></p>

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
			<p><label for="hk_theme[gcse_id]">Google Site Search ID. Låter sökrutan göra en Google Site Search istället för wordpressökning. Ex. 017163027625550103349:urmqx2nuhpg</label><br/><input type="text" size="80" name="hk_theme[gcse_id]" value="<?php echo $options['gcse_id']; ?>" /></p>
			<p><input type="checkbox" name="hk_theme[gcse_ajax]" value="1"<?php checked( 1 == $options['gcse_ajax'] ); ?> /> <label for="hk_theme[gcse_ajax]">Använd AJAX-sökning.</label></p>
			<p><input type="checkbox" name="hk_theme[gcse_enable_kontakter_search]" value="1"<?php checked( 1 == $options['gcse_enable_kontakter_search'] ); ?> /> <label for="hk_theme[gcse_enable_kontakter_search]">Sök specifikt i kontakter, visas i en kolumn bredvid vanliga s&ouml;ktr&auml;ffarna.</label></p>
			<p><input type="checkbox" name="hk_theme[gcse_enable_faq_search]" value="1"<?php checked( 1 == $options['gcse_enable_faq_search'] ); ?> /> <label for="hk_theme[gcse_enable_faq_search]">Sök specifikt i vanliga fr&aring;gor, visas i en kolumn bredvid vanliga s&ouml;ktr&auml;ffarna.</label></p>
			<p><label for="hk_theme[faq_search_ignore_words]">Ord som ska nerprioriteras vid sökning i 'Vanliga fr&aring;gor'.</label><br/><input type="text" size="80" name="hk_theme[faq_search_ignore_words]" value="<?php echo $options['faq_search_ignore_words']; ?>" /></p>

			<p><label for="hk_theme[addthis_pubid]">AddThis pubid. L&auml;gger till Dela i artikel.</label><br/><input type="text" size="80" name="hk_theme[addthis_pubid]" value="<?php echo $options['addthis_pubid']; ?>" /></p>
			<p><label for="hk_theme[addthis_pubid_admin]">AddThis pubid. L&auml;gger till dela i <b>wp-admin</b>.</label><br/><input type="text" size="80" name="hk_theme[addthis_pubid_admin]" value="<?php echo $options['addthis_pubid_admin']; ?>" /></p>
			<p><label for="hk_theme[readspeaker_id]">Readspeaker id. L&auml;gger till Lyssna i artikel.</label><br/><input type="text" size="80" name="hk_theme[readspeaker_id]" value="<?php echo $options['readspeaker_id']; ?>" /></p>
			<p><label for="hk_theme[googlemapskey]">Google Maps key.</label><br/><input type="text" size="80" name="hk_theme[googlemapskey]" value="<?php echo $options['googlemapskey']; ?>" /></p>
			<p><label for="hk_theme[typekit_url]">Typekit js url - hela js-urlen (börja med //) f&ouml;r att l&auml;gga till typsnitt.</label><br/><input type="text" size="80" name="hk_theme[typekit_url]" value="<?php echo $options['typekit_url']; ?>" /></p>
			<p><label for="hk_theme[tidiochat_url]">Tidiochat js url - hela js-url (börja med //) f&ouml;r att l&auml;gga till tidiochat.</label><br/><input type="text" size="80" name="hk_theme[tidiochat_url]" value="<?php echo $options['tidiochat_url']; ?>" /></p>
			<p><label for="hk_theme[google_font]">Load google font - ex. <i>Oxygen:300,400,700</i> f&ouml;r att l&aumlgga till typsnitt.</label><br/><input type="text" size="80" name="hk_theme[google_font]" value="<?php echo $options['google_font']; ?>" /></p>
			<p><label for="hk_theme[in_head_section]">script or other in &lt;head&gt;-section</label><br/><textarea cols="100" rows="5" type="text" name="hk_theme[in_head_section]"><?php echo $options['in_head_section']; ?></textarea></p>
			<p><label for="hk_theme[in_topbody_section]">script or other in top of &lt;body&gt;-section</label><br/><textarea cols="100" rows="5" type="text" name="hk_theme[in_topbody_section]"><?php echo $options['in_topbody_section']; ?></textarea></p>
			<h3>only_content mode (add ?only_content to url to use)</h3>
			<p><label for="hk_theme[if_only_content]">style - style-tag is wrapped around content</label><br/><textarea cols="100" rows="5" type="text" name="hk_theme[if_only_content]"><?php echo $options['if_only_content']; ?></textarea></p>
			<p><label for="hk_theme[if_only_content_js]">js or other - nothing is wrapped around this content</label><br/><textarea cols="100" rows="5" type="text" name="hk_theme[if_only_content_js]"><?php echo $options['if_only_content_js']; ?></textarea></p>

			<?php if (function_exists('relevanssi_do_query')) { ?>
			<h3>Relevanssi - Multisajt sökning</h3>
			<p><label for="hk_theme[relevanssi_multisite]">Kommaseparerad lista med ID på de sajter som ska sökas på (Relevanssi måste vara aktiverat på de sajter som ska vara sökbara). Sök bara på denna sajt genom att lämna inställningen tom.</label><br/><input type="text" size="80" name="hk_theme[relevanssi_multisite]" value="<?php echo $options['relevanssi_multisite']; ?>" /></p>
			<?php } ?>

			<h3>Extern sökning</h3>
			<p><label for="hk_theme[external_search_title]">Länktext till extern sökning</label><br/><input type="text" size="80" name="hk_theme[external_search_title]" value="<?php echo $options['external_search_title']; ?>" /></p>
			<p><label for="hk_theme[external_search_url]">URL till extern sökning (lägger till sökordet direkt efter URL)</label><br/><input type="text" size="80" name="hk_theme[external_search_url]" value="<?php echo $options['external_search_url']; ?>" /></p>

			<h3>AMP inställningar - Kräver AMP-plugin från Automatic</h3>
			<p><label for="hk_theme[amp_analytics]">Google Analytics för AMP-statistik</label><br/><input type="text" size="80" name="hk_theme[amp_analytics]" value="<?php echo $options['amp_analytics']; ?>" /></p>

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


			<a name="debug"></a>
			<hr/><h2>DEBUG</h2>
			<?php
				if (!empty($options["count_version"])) {
					echo '<h2>Vilka har anslutit?</h2><table cellspacing=4 style="margin-top:24px;border: 1px solid gray;">';
					echo "<tr><td><b>IP</b></td><td><b>Antal uppdateringar</b></td></tr>";
					foreach ($options["count_version"] as $ip => $count) {
						echo "<tr><td>" . $ip . "</td><td>" . $count . "</td></tr>";
					}
					echo '</table>';
				}
			?>

			<hr/><h2>Anv&auml;nds inte just nu:</h2>
			<table id="table-options" class="form-table" style="width:600px"><caption style="width: 100%"><strong style="float:left; margin-left: 8px; font-size: 13px;"></strong></caption>
				<tr valign="top">
					<th style="width: 120px">Namn:</td>
					<th>V&auml;rde:</td>
					<th style="width: 72px"></td>
				</tr>
				<tr id="syn_0" class="row_syn">
					<td><input type="text" name="hk_theme[syn_0][name]" value="<?php echo $options['syn_0']['name']; ?>" /></td>
					<td><input type="text" style="width:100%" name="hk_theme[syn_0][value]" value="<?php echo $options['syn_0']['value']; ?>" /></td>
					<td><button class="btn_removeRow button-secondary">Ta bort</button></td>
				</tr>
				<?php $nr = 1; while( isset($options['syn_'.$nr]) ) : ?>
				<tr id="syn_<?php echo $nr;?>" class="row_syn">
					<td><input type="text" name="hk_theme[syn_<?php echo $nr;?>][name]" value="<?php echo $options['syn_'.$nr]['name']; ?>" /></td>
					<td><input type="text" style="width:100%" name="hk_theme[syn_<?php echo $nr;?>][value]" value="<?php echo $options['syn_'.$nr]['value']; ?>" /></td>
					<td><button class="btn_removeRow button-secondary">Ta bort</button></td>
				</tr>
				<?php $nr += 1; endwhile; ?>
				<tr class="row_btn">
					<td><button id="btn_addRow" class="button-secondary">Lägg till fält</button></td>
					<td><input id="syn_nr" type="hidden" name="hk_theme[syn_nr]" value="<?php
						if(isset($options['syn_nr'])){
							echo $options['syn_nr'];
						}
						else{ echo 1; }
					?>" /></td>
					<td></td>
				</tr>
			</table>

			<?php submit_button(); ?>

		</form>
	</div>
	<script>
		(function($) {
			//prints out the html for current element
			//plus optional number of parents
			function debugHTML(el, step){
				step = typeof step !== 'undefined' ? step : 0;
				var element = el;
				var text = "$(this)";
				for(var i = 0; i <= step; i++){
					if(i > 0){
						element = $(element).parent();
						text = text+".parent()";
					}
					alert(text+": "+$(element)[0].outerHTML);
				}
				return false;
			}

			function removeRow(el){
				var currRow = $(el);
				var id = currRow.attr('id');
				var nr = parseInt(id.split('syn_')[1]);

				var i = 0;
				var nextRow = currRow.next();
				while( nextRow.is('.row_btn') == false ){
					//om denna rad inte är '.row_btn'
					//minska nummret i namnen på text-fälten med 1.
					nextRow.attr('id', 'syn_'+(nr+i));
					nextRow.find('input').each( function(index){
						if(index == 0){
							$(this).attr('name', 'hk_theme[syn_'+(nr+i)+'][name]');
						}
						else{
							$(this).attr('name', 'hk_theme[syn_'+(nr+i)+'][value]');
						}
					});
					nextRow = nextRow.next();
					i += 1;
				}
				//om currRow inte är första raden (id!=syn_0) eller
				//om currRow är första raden men det finns fler rader med synonymer.
				if(i > 0 || nr > 0){
					currRow.remove();
					$("#syn_nr").attr( 'value', parseInt($("#syn_nr").attr('value'))-1 );
				}
				else{ //annars töm värdena i text-fälten
					currRow.find('input').each( function(){
						$(this).attr('value', '');
					});
				}
				return false;
			}

			//the default field's remove-button
			$(".btn_removeRow").click( function(){
				//$(this) == <button>
				//$(this).parent().parent() == <tr>
				//debugHTML(this, 2);
				var currRow = $(this).parent().parent();
				removeRow(currRow);
				return false;
			});

			//creating and adding new field after the last one.
			$("#btn_addRow").click(function(){
				var nr = parseInt($("#syn_nr").attr('value'));

				//text-field syn_tag_name
				var input_name = $("<input>").attr('type', 'text').attr('name', 'hk_theme[syn_'+nr+'][name]').attr('value', '');
				var td_name = $("<td>").html(input_name);

				//text-field syn_tag_synonyms
				var input_syn = $("<input>").attr('type', 'text').attr('style', 'width:100%').attr('name', 'hk_theme[syn_'+nr+'][value]').attr('value', '');
				var td_syn = $("<td>").html(input_syn);

				//remove-button
				var btn = $("<button>").addClass('btn_removeRow').addClass('button-secondary').html('Ta bort').click( function(ev){
					ev.preventDefault();
					//$(this) == <button>
					//$(this).parent().parent() == <tr>
					//debugHTML(this, 2);
					var currRow = $(this).parent().parent();
					removeRow(currRow);
				});
				var td_btn = $("<td>").html(btn);

				//new table-row
				var tr = $("<tr>").attr('id','syn_'+nr).addClass('row_syn').append(td_name).append(td_syn).append(td_btn);

				//add the new field between the last field and the button
				$(".row_btn").before(tr);
				nr += 1;
				$("#syn_nr").attr('value', nr);

				return false;
			});

			//check values on submit
			$("#btn_submit").click(function(){

				var error = new Array();

				//creates a temp table to use when searching
				//for duplicates.
				var nr = parseInt( $("#syn_nr").attr('value') );
				var table = new Array();
				for (i = 0; i < nr; i++){
					table[i] = $("#syn_"+i).find('input').attr('value');
				}

				//steps up through the table row by row until row has no class
				var currRow = $(".row_btn").prev(); //selects the row above '.row_btn'
				while( currRow.hasClass('row_syn') ){
					//checks if any of the input-fields are empty
					var empty = false;
					var both = false;
					var i = 0;
					currRow.find('input').each(function(){
						if( $(this).attr('value') == '' ){
							empty = true;
							i++;
						}
						both = i < 2 ? false : true;
					});

					if( empty ){
						if( both ){
							//if both are empty, step up one row and delete previous row
							var prevRow = currRow;
							currRow = currRow.prev();
							removeRow(prevRow);
						}
						else{
							//if one are empty
							if( !error[0] ){
								error[0] = "Några fält är tomma!";
							}
							currRow.find('input').css({'background-color':'rgba(236, 90, 119, 0.45)'}).click(function(){
								$(this).parent().parent().find('input').css({'background-color':'white'});
							});
							currRow = currRow.prev();
						}
					}
					else{
						//check for duplicates
						var value_toLookFor = currRow.find('input').attr('value');
						var index_toLookFor = parseInt(currRow.attr('id').split('syn_')[1]);
						var multipleMatches = false;
						var firstMatch = -1;
						for(i = 0; i < nr; i++){
							if( table[i] == value_toLookFor ){
								if( firstMatch == -1 ){
									firstMatch = i;
								}
								else{
									multipleMatches = true;
								}
							}
						}
						if (multipleMatches /*&& (index_toLookFor != firstMatch)*/ ){
							//if duplicate, step up one row and delete previous row
							/*var prevRow = currRow;
							currRow = currRow.prev();
							removeRow(prevRow);*/
							if( !error[1] ){
								error[1] = "Dubbletter hittades!";
							}
							currRow.find('input').css({'background-color':'rgba(236, 90, 119, 0.45)'}).click(function(){
								$(this).parent().parent().find('input').css({'background-color':'white'});
							});
						}
						currRow = currRow.prev();
					}
				}
				if( error.length > 0 ){
					var error_text = "";
					for (i = 0; i < error.length; i++){
						if(error[i]){
							if(i > 0){ error_text += "\n\n"; }
							error_text += error[i];
						}
					}
					alert(error_text);
					//don't submit form
					return false;
				}
				else{
					//submit form
					return true;
				}
			});
		})(jQuery);
	</script>
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
