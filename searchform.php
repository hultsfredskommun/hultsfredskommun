<?php
/**
 * The template for displaying search forms in Twenty Eleven
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
?>
	<?php $options = get_option('hk_theme'); ?>
	<?php
		$hk_search_form_class = '';
		$rekai_search = get_field('rekai_search', 'options');

    if ( $rekai_search ) {
		$hk_search_form_class = '';
	} 
	else if( !empty($options["gcse_ajax"]) && $options["gcse_ajax"] != "") {
		$hk_searchclass = "hk-ajax-searchbox";
        $hk_search_form_class = "gcse_ajax_search"; ?>
		<div class="<?php echo $hk_searchclass; ?>">
			<div class="gcse-searchbox"></div>
		</div>
	<?php }  ?>
	<form class="<?php echo $hk_search_form_class ?> form" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'twentyeleven' ); ?></label>
		<div class="input-wrapper"><input type="text" class="field" name="s" id="s" autocomplete="off" placeholder="<?php echo $options["search_watermark"]; ?>" value="<?php echo (!empty($_REQUEST["s"])) ? $_REQUEST["s"]:''; ?>" /></div>
		<input type="submit" class="submit" id="searchsubmit" value="" />
	</form>
