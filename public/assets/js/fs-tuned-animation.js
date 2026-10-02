jQuery(document).ready(function($){
	$(document).on( "scroll", function() {
		$('[data-animate="fadeInRight"]').each(function(){
			if(isInViewport($(this))){
				var element = $(this);
				setTimeout(() => {
					element.attr('data-animated', true)
				}, 300);
				
			}
		});
		$('[data-animate="fadeInLeft"]').each(function(){
			if(isInViewport($(this))){
				var element = $(this);
				setTimeout(() => {
					element.attr('data-animated', true)
				}, 300);
			}
		});
	} );

	function isInViewport(element) {
		const rect = $(element).get(0).getBoundingClientRect();
		var inViewPort = window.innerHeight - rect.top >0
		return inViewPort;
	}
});