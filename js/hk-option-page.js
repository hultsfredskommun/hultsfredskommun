(function($) {

	$(document).ready(function() {
	    $('.upload_image_button').click(function() {
	         targetfield = jQuery(this).prev('.upload-url');
	         tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	         return false;
	    });
	 
	    window.send_to_editor = function(html) {
	         imgurl = jQuery('img',html).attr('src');
	         jQuery(targetfield).val(imgurl);
	         tb_remove();
	    }
	});
})(jQuery);