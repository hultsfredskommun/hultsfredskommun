(function($) {
	$(document).ready(function() {
		/* if not administrator */
		if ( !$("#menu-settings").is(":visible") ) {
			$(".tagselect-add-wrap").remove(); // hide add tags in edit.php
			$(".inline-edit-tags").remove(); // hide add tags in quick edit
			$(".special_category-checklist").prev().prev().remove(); // remove special cat title in quick edit
			$(".special_category-checklist").remove() // remove special cat in quick edit
		}
	});

})(jQuery);