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
		$('.checkbox-input').click(
			function(event) {
			event.preventDefault ( );
			
			if ( $(this).parent( ).find('.input').val() != '') {
				$(this).parent().toggleClass('active');	
			}else {
				$(this).parent().toggleClass('error');	
			}


			// $(this).parent().toggleClass('active');
			
		});
 		
		$("[name='my-checkbox']").bootstrapSwitch();

 		
	}
);
$(window).load(function(){
	 
	 function load_login(){
		$( 'body' ).addClass( 'loaded' );
	}
	if ( $('#login').length ){
		setTimeout(load_login, 4000);
	}		
});


