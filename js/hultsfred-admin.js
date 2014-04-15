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
		
		// add fb share if in post wp-admin
		if ($("body").hasClass("wp-admin") && $("body").hasClass("post-php")) {
			fb_share = "<div id='fb-root'></div> " +
			" <script>(function(d, s, id) { " +
			  "var js, fjs = d.getElementsByTagName(s)[0]; " +
			  " if (d.getElementById(id)) return; " +
			  " js = d.createElement(s); js.id = id; " +
			  " js.src = '//connect.facebook.net/sv_SE/all.js#xfbml=1&appId=544714525648022'; " +
			  " fjs.parentNode.insertBefore(js, fjs); " +
			" }(document, 'script', 'facebook-jssdk'));</script>";
			perma_link = $("#view-post-btn .button").attr("href");
			fb_button = "<div class='fb-share-button' data-href='" + perma_link + "' data-type='button_count'></div>";
			$("#edit-slug-box").before(fb_share);
			$("#edit-slug-box").append(fb_button);
		}
		// remove "svara" button in comments
		$(".dashboard-comment-wrap .row-actions, .comment .row-actions").find(".reply").hide();
	});
})(jQuery);
