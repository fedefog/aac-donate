$(document).ready(function( ) {

		$('.selectpicker').selectpicker({
		  style: 'btn-info',
		  showSubtext: 'true',
		  size: 4
		});

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


		$('#chebox-sms').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.container-settings-msj').slideToggle();
		    
		});
		$('#checkbox-automatic-login').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.default-login').slideToggle();
		    
		});


		$('#standing-order-switch').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.standing-order-switch-container').toggleClass("active");
		    $('.standing-order-switch-container .btn-group, .standing-order-switch-container .btn ').toggleClass( "disabled" );
		    $('.standing-order-switch-container .selectpicker ').removeProp( "disabled" );
		    
		});

		// VOUCHER more & less
		 $( ".input-number" ).each(function( i ) {
		    $(this).change(function() {
		    	if ( $(this).val() > 0 ){
			  		$(this).parent().removeClass('input-default');
			  		$('.lkn-order-vouchers').removeClass('disabled');

		    	}else {
		    		
			  		$(this).parent().addClass('input-default');
			  		$('.lkn-order-vouchers').addClass('disabled');
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
				$(this).parent().parent().addClass('input-default');
				$('.lkn-order-vouchers').addClass('disabled');
			}				


		});

		 $('.more-input').click(
			function(event) {
			event.preventDefault ( );
			var valor = $(this).parent().find('.input-number').val();
			
			valor ++;
			$(this).parent().find('.input-number').val( valor  )
			if ( valor > 0 ){
				$(this).parent().parent().removeClass('input-default');
				$('.lkn-order-vouchers').removeClass('disabled');
			}	
		});

		 $('.lkn-order-vouchers').click(
			function(event) {
			event.preventDefault ( );
			
		});

		 

		/* Switch Accout Style*/

		$(".switch-account .dropdown-menu .text").lettering('words');

		/* Datapicker */

		$('#dates-bt-modal').daterangepicker();  

		$('#dates-bt-modal').on('show.daterangepicker', function(ev, picker) {
          $("body").append('<div class="modal-backdrop fade in date-back"></div>')
        });

        $('#dates-bt-modal').on('showCalendar.daterangepicker', function(ev, picker) {
          $( ".calendar.right tbody" ).remove();
        });      

        $('#dates-bt-modal').on('apply.daterangepicker', function(ev, picker) {
          console.log(picker.startDate.format('YYYY-MM-DD'));
          console.log(picker.endDate.format('YYYY-MM-DD'));
        });  

        $('#dates-bt-modal').on('cancel.daterangepicker', function(ev, picker) {
        	$( ".date-back" ).remove();
        });   

        $('#dates-bt-modal').on('hide.daterangepicker', function(ev, picker) {
        	$( ".date-back" ).remove();
        });    

        /* Conditional to set sticky footer and primary action */

        if ( $('main.make-donation').length > 0 || $('main.main-help').length || $('main.main-contact-us').length ){
	  		$('body').addClass('sticky-footer');
    	};

 		
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
	
/* Every time the window is scrolled ... */
$(window).scroll( function(){

	/* Navigator */

	if(!$('body').hasClass('menu-mobile-open')) {
		var scroll = $( window ).scrollTop();
		$('.navigator').css('top', scroll);
	}

});
