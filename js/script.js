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
		$('.daily-dashboard').click(
			function(event) {
			event.preventDefault ( );
			$(this).toggleClass('open');
			$(this).parent().find('.text').slideToggle();
			
		});
		
		$('.lkn-daily-donate').click(
			function(event) {
			event.preventDefault ( );
			if($(this).parent().parent().hasClass("open")) {
			    $(this).parent().parent().animate({"height": "50px"}).removeClass("open");
			  } else {
			    $(this).parent().parent().animate({"height": "120px"}).addClass("open");
			}
			
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
		});
		$('.checkbox-box .ckeckbox').click(
			function(event) {
			event.preventDefault ( );
			
			
				$(this).toggleClass('active');	
			
			
			
		});
 		
		$("[name='my-checkbox']").bootstrapSwitch();
		
		$('.selectpicker').selectpicker({
		  style: 'btn-info',
		  size: 4
		});




		/* Switch Accout Style*/

		/*$( '.switch-account .dropdown-menu .text' ).addClass( 'test' );*/
		$(".switch-account .dropdown-menu .text").lettering('words');

 		
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


