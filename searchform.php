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
			/* reset button */
			$(".gsst_a").click(function(event) {
				gcse_clear_search();
			});
			
			/* esc key press */
			$(document).keyup(function(event) { 
				var hk_document_key = event.keyCode || event.which;
				
				if ( hk_document_key == 27 ) {
					gcse_clear_search();
					$(".contact-popup").remove();
				}
			});

			/* key press in input */
			$("#gsc-i-id1").keyup(function(event) { 
				var gcse_key = event.keyCode || event.which;
				var gcse_searchstring = $("#gsc-i-id1").val();
				if ( gcse_searchstring == "" || gcse_key == 27 ) {
					gcse_clear_search();
				}
				if ( gcse_key == 13 ) {
					gcse_do_hook_callback();
				}
				
			})
			/* input box blur */
			.blur(function(event) { 
				$(".gsc-input").css("background-image","none");
				var gcse_searchstring = $("#gsc-i-id1").val();
				if (gcse_searchstring == "") {
					gcse_clear_search();
				}
			});

			/* search button click */
			$(".gsc-search-button").click(function(event) {
				gcse_do_hook_callback();
			});
		}
		function gcse_clear_search() {
			$(".gsc-input").css("background-image","none");
			$(".hk-gcse-hooks").hide().html("");
			$(".hk-gcse-wrapper").removeClass("unhidden");
			$(".hk-gcse-overlay").remove();
			$(".gsst_a").hide();
		}
		function gcse_do_hook_callback() {
			var gcse_searchstring = $("#gsc-i-id1").val();
			if (gcse_searchstring == "") {
				gcse_clear_search();
			} else {
				$(".hk-gcse-overlay").remove();
				$(".hk-gcse-wrapper").addClass("unhidden").before("<div class='hk-gcse-overlay'></div>");
				$(".hk-gcse-overlay").click(function() {
					$("#gsc-i-id1").val("");
					gcse_do_hook_callback();
				});
				$(".hk-gcse-hooks").show().html("H&auml;mtar s&ouml;kresultat... " + gcse_searchstring).load(hultsfred_object["templateDir"]+"/ajax/search_hooks.php", 
						{ searchstring: gcse_searchstring }, function() {
						});
			}
		}
		
	  })(jQuery);
	</script>
	<gcse:searchbox></gcse:searchbox>
	<?php endif; ?>
