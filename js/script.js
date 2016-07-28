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
		  showSubtext: 'true',
		  size: 4
		});


		$('#chebox-sms').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.container-settings-msj').slideToggle();
		    
		});
		$('#checkbox-automatic-login').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.default-login').slideToggle();
		    
		});


			// VOUCHER 
		 $( ".input-number" ).each(function( i ) {
		    $(this).change(function() {
		    	if ( $(this).val() > 0 ){
			  		$(this).parent().removeClass('input-default');
		    	}else {
		    		
			  		$(this).parent().addClass('input-default');
		    	}
			});
		  });

		 $('.less-input').click(
			function(event) {
			event.preventDefault ( );
			var valor = $(this).parent().find('.input-number').val();
			if ( valor > 0 ){
				valor --;
				$(this).parent().find('.input-number').val( valor  )
			}
			if ( valor == 0 ){
				$(this).parent().addClass('input-default');
			}				


		});

		 $('.more-input').click(
			function(event) {
			event.preventDefault ( );
			var valor = $(this).parent().find('.input-number').val();
			
				valor ++;
				$(this).parent().find('.input-number').val( valor  )
				if ( valor > 0 ){
				$(this).parent().removeClass('input-default');
				}	
		});

		/* Switch Accout Style*/

		$(".switch-account .dropdown-menu .text").lettering('words');
		/*$(".beneficiary-select .filter-option").lettering('words');*/

		/* Datapicker */

		$('#dates-bt-modal').daterangepicker();  

        $('#dates-bt-modal').on('showCalendar.daterangepicker', function(ev, picker) {
          $( ".calendar.right tbody" ).remove();
          $("body").append('<div class="modal-backdrop fade in date-back"></div>')
        });      

        $('#dates-bt-modal').on('apply.daterangepicker', function(ev, picker) {
          console.log(picker.startDate.format('YYYY-MM-DD'));
          console.log(picker.endDate.format('YYYY-MM-DD'));
        });  

        $('#dates-bt-modal').on('cancel.daterangepicker', function(ev, picker) {
        	$( ".date-back" ).remove();
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


