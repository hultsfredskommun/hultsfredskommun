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
	<?php if ($options["gcse_id"] == "") : ?>
	<form class="form" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'twentyeleven' ); ?></label>
		<div class="input-wrapper"><input type="text" class="field" name="s" id="s" autocomplete="off" placeholder="<?php echo $options["search_watermark"]; ?>" /></div>
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="" />
		<?php if ($options['relevanssi_multisite'] != "") { ?>
		<input type="hidden" name="searchblogs" value="<?php echo $options['relevanssi_multisite']; ?>" />
		<?php } ?>
	</form>
	<?php else : ?>

	<script>
	(function($) {
		var cx = '<?php echo $options["gcse_id"]; ?>'; //017163027625550103349:urmqx2nuhpg
		var gcse = document.createElement('script');
		gcse.type = 'text/javascript';
		gcse.async = true;
		gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
			'//www.google.com/cse/cse.js?cx=' + cx;
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(gcse, s);
		window.__gcse = {
			callback: gcse_Callback
		};
		
		function gcse_Callback() {
			$(".gsc-input").css("background-image","none").attr("placeholder","<?php echo $options["search_watermark"]; ?>");
			$("#gsc-i-id1").blur(function(event) { 
				$(".gsc-input").css("background-image","none");
			})
			$("#gsc-i-id1").blur(function(event) { 
				var gcse_searchstring = $("#gsc-i-id1").val();
				if (gcse_searchstring == "") {
					$(".gsc-input").css("background-image","none");
					$(".hk-gcse-hooks").hide().html("");
				}
			});
			$(".gsst_a").click(function(event) {
				$(".gsc-input").css("background-image","none");
				$(".hk-gcse-hooks").hide().html("");
			});
			$("#gsc-i-id1").keyup(function(event) { 
				var gcse_key = event.keyCode || event.which;
				var gcse_searchstring = $("#gsc-i-id1").val();
				if (gcse_searchstring == "") {
					$(".gsc-input").css("background-image","none");
					$(".hk-gcse-hooks").hide().html("");
				}
				if (gcse_key == 13) {
					gcse_do_hook_callback();
				}
			});
			$(".gsc-search-button").click(function(event) {
				gcse_do_hook_callback();
			});
		}
		function gcse_do_hook_callback() {
			var gcse_searchstring = $("#gsc-i-id1").val();
			if (gcse_searchstring == "") {
				$(".gsc-input").css("background-image","none");
				$(".hk-gcse-hooks").hide().html("");
			} else {
				$(".hk-gcse-hooks").show().html("H&auml;mtar s&ouml;kresultat... " + gcse_searchstring).load(hultsfred_object["templateDir"]+"/ajax/search_hooks.php", 
						{ searchstring: gcse_searchstring }, function() {
						});
			}
		}
		
	  })(jQuery);
	</script>
	<gcse:searchbox></gcse:searchbox>
	<?php endif; ?>
