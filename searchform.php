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
    if ($options["gcse_ajax"] != "") { 
        if ($options["gcse_id"] != "") {
            $hk_searchclass = "hk-gcse-ajax-searchbox";
        }
        else {
            $hk_searchclass = "hk-ajax-searchbox";
        }
        $gcse_class = "gcse_ajax_search"; ?>
		<div class="<?php echo $hk_searchclass; ?>">
			<div class="gcse-searchbox"></div>
		</div>
	<?php }  ?>
	<form class="<?php echo ($options["gcse_id"] != "")?"gcse $gcse_class":"$gcse_class"; ?> form" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'twentyeleven' ); ?></label>
		<div class="input-wrapper"><input type="text" class="field" name="s" id="s" autocomplete="off" placeholder="<?php echo $options["search_watermark"]; ?>" value="<?php echo $_REQUEST["s"]; ?>" /></div>
		<input type="submit" class="submit" id="searchsubmit" value="" />
		<?php if ($options['relevanssi_multisite'] != "") { ?>
		<input type="hidden" name="searchblogs" value="<?php echo $options['relevanssi_multisite']; ?>" />
		<?php } ?>
	</form>
	
