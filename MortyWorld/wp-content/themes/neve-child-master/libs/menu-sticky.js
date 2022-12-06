jQuery(document).ready(function( $ ){
    $(document).ready(function() {
	
		   	var MenuStickyTop = $('.menu-sticky').offset().top;
		   	var MenuSticky = function(){
			    var scrollTop = $(window).scrollTop(); 
          
          
			   /* if (scrollTop > MenuStickyTop) { */

				if($(this).scrollTop() > 370){
			        $('.menu-sticky').addClass('menu-fixed');
			    } else {
			        $('.menu-sticky').removeClass('menu-fixed'); 
			    }
			};

			MenuSticky();
			$(window).scroll(function() {
				MenuSticky();
			});
		});
});