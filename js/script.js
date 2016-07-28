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
		$('.lkn-change-password').click(
			function(event) {
			event.preventDefault ( );
			
			$(this).parent().find('.container-password-settings').slideToggle();
			$(this).toggleClass('active');	
						
		});
 		
		$("[name='my-checkbox']").bootstrapSwitch();
		
		$('.selectpicker').selectpicker({
		  style: 'btn-info',
		  size: 4
		});


		$('#chebox-sms').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.container-settings-msj').slideToggle();
		    
		});
		$('#checkbox-automatic-login').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.default-login').slideToggle();
		    
		});

		/* Switch Accout Style*/

		/*$( '.switch-account .dropdown-menu .text' ).addClass( 'test' );*/
		$(".switch-account .dropdown-menu .text").lettering('words');

		/* Datapicker */

		$('#dates-bt-modal').daterangepicker();  
        $('#dates-bt-modal').on('showCalendar.daterangepicker', function(ev, picker) {
          $( ".calendar.right tbody" ).remove();
          /*$( ".calendar.right thead tr:nth-child(2)").remove();*/
          /*$( ".calendar.left thead tr:first-child th:last-child" ).addClass("next available");
          $( ".calendar.left thead tr:first-child th:last-child" ).append( '<i class="fa fa-chevron-right glyphicon glyphicon-chevron-right"></i>' );*/
        });      
        $('#dates-bt-modal').on('apply.daterangepicker', function(ev, picker) {
          console.log(picker.startDate.format('YYYY-MM-DD'));
          console.log(picker.endDate.format('YYYY-MM-DD'));
        });      

 		
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


