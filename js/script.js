$(document).ready(function( ) {

		$('.nav-icon4').click(
			function(event) {
			event.preventDefault ( );
			$(this).toggleClass('open');
			$('body').toggleClass('menu-mobile-open');
		});
		
		$('.close-nav').click(
			function(event) {
			event.preventDefault ( );
			$('.nav-icon4').toggleClass('open');
			$('body').toggleClass('menu-mobile-open');
		});
		$('.lkn-daily').click(
			function(event) {
			event.preventDefault ( );
			$(this).toggleClass('open');
			$(this).parent().find('.text').slideToggle();
			
		});
		
		$('.lkn-sortby').click(
			function(event) {
			event.preventDefault ( );
			$('.drop-down-sort').toggleClass('active');
			
		});
 		
	}
);
$(window).load(function(){
	 
	 function load_login(){
		$( 'body' ).addClass( 'loaded' );
	}
	setTimeout(load_login, 4000);		
});


