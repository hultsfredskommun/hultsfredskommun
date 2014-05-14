(function($) {
	$(document).ready(function() {
		
		// change of helptext
		$("#sticky-span .selectit").html("Klistra det h&auml;r inl&auml;gget.");
		
		/* if not administrator */
		if ( !$("#menu-settings").is(":visible") ) {
			$(".tagselect-add-wrap").remove(); // hide add tags in edit.php
			$(".inline-edit-tags").remove(); // hide add tags in quick edit
		}

		//$("#attachment_caption").parent().remove(); // hide media caption
		$(".compat-field-post_tag").remove();
		//$("#content-add_media").attr("href",$("#content-add_media").attr("href") + "&tab=library");
		
		// add addthis share if in post wp-admin
		if ($("body").hasClass("wp-admin") && $("body").hasClass("post-php") && hultsfred_object["addthis_pubid_admin"] != "") {
			perma_link = $("#view-post-btn .button").attr("href");
			var addthis_share = {
				url: perma_link
			}
			hk_addthis = '<div class="addthis_toolbox addthis_default_style" style="float: right">' +
				'<a class="addthis_button_facebook"></a>' + 
				'<a class="addthis_button_twitter"></a>' +
				'<a class="addthis_button_email"></a>' +
				'<a class="addthis_button_print"></a>' +
				'<a class="addthis_button_compact"></a>' +
				'<a class="addthis_counter addthis_bubble_style"></a>' +
				'</div>' +
				'<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=' + hultsfred_object["addthis_pubid_admin"] + '"></script>';
			$("#edit-slug-box").before(hk_addthis);
			
		}
		// remove "svara" button in comments
		$(".dashboard-comment-wrap .row-actions, .comment .row-actions").find(".reply").hide();
	});
})(jQuery);
