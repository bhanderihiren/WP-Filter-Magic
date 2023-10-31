(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
		jQuery('.pagination .load-more').click(function(){
			var formdata = new FormData(jQuery(this).closest('.pagination').find('form').get(0));
			var _this    = jQuery(this);
			jQuery.ajax({
				url: my_ajax_object.ajax_url, // change according the enqeue from function file
				type: "POST",
				dataType: "json",
				data: formdata,
				processData: false,
				contentType: false,
				cache: false,
				success: function (response) {
					if( response.status == 1 ){
						jQuery('#rend-post').append(response.data);
						jQuery('#paged').val(response.page);

						if( response.loadmore == 0){
							console.log(_this);
							jQuery(_this).hide();
						}
					}
				},error: function (jqXHR, textStatus, errorThrown) {

				},
			});
		});

		jQuery(document).on('click', '.pagination .page-numbers a', function(e){
			e.preventDefault();
			var url = jQuery(this).attr('href');
			var match = url.match(/(\d+)(?!.*\d)/);
			var paged = 1;
			if (match) {
				paged = match[0];
			}
			var formdata = new FormData(jQuery(this).closest('.pagination').find('form').get(0));
			formdata.append('paged', paged);
			formdata.append('ajax_by', "page-numbers");
			var _this    = jQuery(this);
			jQuery.ajax({
				url: my_ajax_object.ajax_url, // change according the enqeue from function file
				type: "POST",
				dataType: "json",
				data: formdata,
				processData: false,
				contentType: false,
				cache: false,
				success: function (response) {
					if( response.status == 1 ){
						jQuery('#rend-post').html(response.data);
						jQuery('#paginate').html(response.paginate);
					}
				},error: function (jqXHR, textStatus, errorThrown) {

				},
			});
		});
	});


})( jQuery );
