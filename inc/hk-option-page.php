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

			
			<h2>Sidhuvud</h2>
			<p><label for="hk_theme[logo_image]">Logga</label><br/>
				<img width=150  src="<?php echo $options["logo_image"]; ?>" />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo_image]" value="<?php echo $options["logo_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[top_image]">Toppbild (inte klar att anv&auml;ndas)</label><br/>
				<img width=150 src="<?php echo $options["top_image"]; ?>" />
				<input class="upload-url" type="text" size="36" name="hk_theme[top_image]" value="<?php echo $options["top_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[search_watermark]">Vattenst&auml;mpel i s&ouml;k</label><br/><input size="80" type="text" name="hk_theme[search_watermark]" value="<?php echo $options['search_watermark']; ?>" /></p>
			<p><label for="hk_theme[pre_topmenu_html]">HTML f&ouml;re topmenu</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[pre_topmenu_html]"><?php echo $options['pre_topmenu_html']; ?></textarea></p>
			<p><label for="hk_theme[post_topmenu_html]">HTML efter topmenu</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[post_topmenu_html]"><?php echo $options['post_topmenu_html']; ?></textarea></p>

			
			<h3>Extra loggor</h3>
			<p><label for="hk_theme[right_logo_html]">HTML vid eller ist&auml;llet för logo2</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[right_logo_html]"><?php echo $options['right_logo_html']; ?></textarea></p>
			<p><label for="hk_theme[logo2_image]">Logga 2 - till h&ouml;ger i huvudet</label><br/>
				<img width=150  src="<?php echo $options["logo2_image"]; ?>" />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo2_image]" value="<?php echo $options["logo2_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo2_link]">Logga 2 l&auml;nk. </label><br/><input size="80" type="text" name="hk_theme[logo2_link]" value="<?php echo $options['logo2_link']; ?>" /></p>
			<p><label for="hk_theme[logo2_descr]">Logga 2 beskrivning. </label><br/><input size="80" type="text" name="hk_theme[logo2_descr]" value="<?php echo $options['logo2_descr']; ?>" /></p>
			<p><label for="hk_theme[logo3_image]">Logga 3 - till h&ouml;ger i huvudet</label><br/>
				<img width=150  src="<?php echo $options["logo3_image"]; ?>" />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo3_image]" value="<?php echo $options["logo3_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo3_link]">Logga 3 l&auml;nk. </label><br/><input size="80" type="text" name="hk_theme[logo3_link]" value="<?php echo $options['logo3_link']; ?>" /></p>
			<p><label for="hk_theme[logo3_descr]">Logga 3 beskrivning. </label><br/><input size="80" type="text" name="hk_theme[logo3_descr]" value="<?php echo $options['logo3_descr']; ?>" /></p>

			<h2>404</h2>
			<p><label for="hk_theme[404title]">Titel</label><br/><input size="80" type="text" name="hk_theme[404title]" value="<?php echo $options['404title']; ?>" /></p>
			<p><label for="hk_theme[404message]">Meddelande</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[404message]"><?php echo $options['404message']; ?></textarea></p>
			<?php if(function_exists('get_most_viewed')) { ?>
			<p><label for="hk_theme[404message2]">Meddelande2 (innan mest bes&ouml;kta)</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[404message2]"><?php echo $options['404message2']; ?></textarea></p>
			<?php } ?>
			
			
			<h2>Kategorier och menyer</h2>
			
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
			
			<h2>Kontakta-oss flikar - l&auml;nkar</h2>
			<p><label for="hk_theme[comment_side_link]">Kontakta-oss-l&auml;nk</label><br/><input size="80" type="text" name="hk_theme[contact_side_link]" value="<?php echo $options['contact_side_link']; ?>" /></p>
			<p><label for="hk_theme[comment_side_link]">Hjälp-oss-l&auml;nk</label><br/><input size="80" type="text" name="hk_theme[comment_side_link]" value="<?php echo $options['comment_side_link']; ?>" /></p>

			<h2>Till&auml;gg</h2>
			<p><label for="hk_theme[addthis_pubid]">AddThis pubid. L&auml;gger till lyssna i artikel.</label><br/><input type="text" name="hk_theme[addthis_pubid]" value="<?php echo $options['addthis_pubid']; ?>" /></p>
			<p><label for="hk_theme[readspeaker_id]">Readspeaker id. L&auml;gger till lyssna i topmenu i sidhuvud och artikel.</label><br/><input type="text" name="hk_theme[readspeaker_id]" value="<?php echo $options['readspeaker_id']; ?>" /></p>			
			<p><label for="hk_theme[translate_url]">&Ouml;vers&auml;tt url (ex. google-translate). L&auml;gger till lyssna i topmenu i sidhuvud.</label><br/><input type="text" name="hk_theme[translate_url]" value="<?php echo $options['translate_url']; ?>" /></p>
			<p><label for="hk_theme[typekit_url]">Typekit js url - http://&lt;resten av url&gt; f&ouml;r att l&auml;gga till typsnitt.</label><br/><input type="text" name="hk_theme[typekit_url]" value="<?php echo $options['typekit_url']; ?>" /></p>
			<p><label for="hk_theme[in_head_section]">script or other in &lt;head&gt;-section</label><br/><textarea cols="80" rows="5" type="text" name="hk_theme[in_head_section]"><?php echo $options['in_head_section']; ?></textarea></p>

			<h2>Statistik och cookies</h2>
			<p><input type="checkbox" name="hk_theme[cookie_accept_enable]" value="1"<?php checked( 1 == $options['cookie_accept_enable'] ); ?> /> <label for="hk_theme[cookie_accept_enable]">St&auml;ll fr&aring;ga om cookies f&aring;r anv&auml;ndas.</label></p>
			<p><label for="hk_theme[cookie_text]">Förklarande text för att godkänna cookies. </label><br/><input size="80" type="text" name="hk_theme[cookie_text]" value="<?php echo $options['cookie_text']; ?>" /></p>
			<p><label for="hk_theme[cookie_link]">Länk till mer information om cookies. </label><br/><input size="80" type="text" name="hk_theme[cookie_link]" value="<?php echo $options['cookie_link']; ?>" /></p>

			<p><label for="hk_theme[google_analytics]">Google Analytics id (enligt UA-XXXXX-X). </label><br/><input type="text" name="hk_theme[google_analytics]" value="<?php echo $options['google_analytics']; ?>" /></p>
			<p><label for="hk_theme[google_analytics_domain]">Google Analytics topp dom&auml;n (ex. mindom&auml;n.se). </label><br/><input type="text" name="hk_theme[google_analytics_domain]" value="<?php echo $options['google_analytics_domain']; ?>" /></p>
			<p><input type="checkbox" name="hk_theme[google_analytics_disable_if_no_cookies]" value="1"<?php checked( 1 == $options['google_analytics_disable_if_no_cookies'] ); ?> /> <label for="hk_theme[google_analytics_disable_if_no_cookies]">Anv&auml;nd inte Google Analytics om cookies inte &auml;r accepterade (p&aring;verkar bara om "fr&aring;ga om cookies" &auml;r p&aring).</label</p>
						
			<h2>Utseende</h2>
			
			<h2>Cron</h2>
			<p><label for="hk_theme[enable_cron_review_mail]">Aktivera granskningsmail.</label><br/><input type="checkbox" name="hk_theme[enable_cron_review_mail]" <?php echo ($options['enable_cron_review_mail'])?"checked":""; ?> /> <?php echo (wp_next_scheduled( 'hk_review_mail_event' ))?"Aktiverat.":"Inaktiverat."; ?> Kördes senast <?php echo Date("Y-m-d H:i:s",$options["hk_review_mail_check_time"]); ?><br/><?php echo $options["hk_review_mail_log"]; ?></p>
			<p>Normaliserade räknare <?php echo Date("Y-m-d H:i:s",$options["hk_normalize_count_time"]); ?>: <br><?php echo $options["hk_normalize_count_log"]; ?></p>

			<h2>Sidfot</h2>
			<p><label for="hk_theme[footer_image]">Sidfot</label><br/>
				<img width=150 src="<?php echo $options["footer_image"]; ?>" />
				<input class="upload-url" type="text" size="36" name="hk_theme[footer_image]" value="<?php echo $options["footer_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>
			<p><label for="hk_theme[logo_footer_image]">Logga i sidfot</label><br/>
				<img width=150  src="<?php echo $options["logo_footer_image"]; ?>" />
				<input class="upload-url" type="text" size="36" name="hk_theme[logo_footer_image]" value="<?php echo $options["logo_footer_image"]; ?>" />
				<input class="upload_image_button" type="button" value="Upload Image" />
			</p>

			<?php /* hook to be able to add options from child theme */ 
			echo do_action('hk_options_hook', $options); ?>			
			
			<h2>Anv&auml;nds inte just nu:</h2>
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
	if ($_REQUEST["page"] == "hk_theme_options") {
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