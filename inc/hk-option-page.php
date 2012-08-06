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
		<form id="form_hk_options" method="post" action="options.php">
			<?php settings_fields('hk_theme_options_options'); ?>
			<?php $options = get_option('hk_theme'); ?>



			<p><fieldset>Välj den kategori som innehåller <b>startsidans</b> sidor.</fieldset>
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
					'show_count'           => true,
					'hide_empty'      => false,
					'hide_if_empty'      => false );  
				wp_dropdown_categories( $args ); 
			?>
			</p>
			
			<p><fieldset>Välj den kategori som innehåller <b>nyheter</b>.</fieldset>
							<?php 
				$args = array(
					'orderby'            => 'ID', 
					'order'              => 'ASC',
					'echo'               => 1,
					'selected'           => esc_attr( $options["news_cat"] ),
					'hierarchical'       => 1, 
					'name'               => 'hk_theme[news_cat]',
					'depth'              => 0,
					'taxonomy'           => 'category',
					'show_count'           => true,
					'hide_empty'      => false,
					'hide_if_empty'      => false );  
				wp_dropdown_categories( $args ); 
			?>
			</p>

			<p><fieldset>Topp navigeringsmeny</fieldset><input type="text" name="hk_theme[topmenu]" value="<?php echo $options['topmenu']; ?>" /><span>Skriv in namnet på den meny som ska vara toppmeny. Visar bara första nivån i den nivån.</span></p>

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
			<p class="submit">
			<input type="submit" id="btn_submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
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

