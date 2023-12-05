(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	jQuery(document).ready(function(){
		jQuery('#post-types').change(function(){
			var postType = jQuery(this).val();

			var data = { "action" : 'post_type_taxonomy_list', "post-type" :  postType };
			jQuery.ajax({
				url: my_ajax_object.ajax_url, // change according the enqeue from function file
				type: "POST",
				dataType: "json",
				data: data,
				success: function (response) {
					if( response.status == 1 ){
						jQuery('.categories-list').html( response.taxonomy_list );
						jQuery('#select-categories').show();
					}
				},error: function (jqXHR, textStatus, errorThrown) {

				},
			});
		});

		jQuery('input[name="method"]').change(function(){
			if(jQuery(this).val() == 1){
				jQuery('select[name="top"] option[value="Infinite-scroll"]').removeAttr('disabled','disabled');
				jQuery('select[name="top"] option[value="Loadmore"]').removeAttr('disabled','disabled');
			} else{
				jQuery('select[name="top"] option[value="Pagination"]').attr('selected','selected');
				jQuery('select[name="top"] option[value="Infinite-scroll"]').attr('disabled','disabled');
				jQuery('select[name="top"] option[value="Loadmore"]').attr('disabled','disabled');
			}
		});

	});
	





})( jQuery );

function myFunction(_this) {
        
	jQuery(_this).css("background","green");
	var text = jQuery(_this).text();
	jQuery(_this).text("Shortcode copied");
	
	setTimeout(function(){
		 jQuery(_this).text('Copy Shortcode');
		 jQuery(_this).css("background","#2271b1");
	}, 5000);
	
	
	
	var text = document.getElementById("my_youtube_video").innerText;
	var elem = document.createElement("textarea");
	document.body.appendChild(elem);
	elem.value = text;
	elem.select();
	document.execCommand("copy");
	document.body.removeChild(elem);
  
}