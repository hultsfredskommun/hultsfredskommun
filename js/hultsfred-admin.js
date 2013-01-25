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
	});
})(jQuery);