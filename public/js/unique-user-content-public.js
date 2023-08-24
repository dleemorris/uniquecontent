(function( $ ) {
	'use strict';

	$(document).ready(function() {

		//$('.ld-section-heading').css({'display':'none'});
		$('.ld_ucc_item_container > span').on('click', function(){
			$(this).closest('.ld_ucc_item_container').find('.ld_ucc_item_content').slideToggle();
		});

		$('.ld-tab-content .ld_ucc_item_container').first().find('.ld_ucc_item_content').css({'display':'block'});

	});

})( jQuery );
