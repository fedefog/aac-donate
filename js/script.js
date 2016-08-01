$(document).ready(function( ) {


		

		var viewportHeight = $(window).height();

		function navigator_scroll ( ) {
			if ( viewportHeight < 665 ) {
				$('.navigator .hoverflow').height( viewportHeight - 220);
			}
		}
		navigator_scroll ( );

		$(window).resize(function() {
			navigator_scroll ( );
		});

		// Selects dropdown styles

		$('.selectpicker').selectpicker({
		  style: 'btn-info',
		  showSubtext: 'true',
		  size: 4
		});

		// Navigation sidebar 

		$('.nav-icon4').click(
			function(event) {
			event.preventDefault ( );
			$(this).toggleClass('open');
			$('body').toggleClass('menu-mobile-open');
		});

		$('.layer-navigator').click(
			function(event) {
			event.preventDefault ( );
			$('.nav-icon4').removeClass('open');
			$('body').removeClass('menu-mobile-open');
		});
		
		$('.close-nav').click(
			function(event) {
			event.preventDefault ( );
			$('.nav-icon4').toggleClass('open');
			$('body').toggleClass('menu-mobile-open');
		});

		// slide toggle dashboard

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

		// Sortby Transaction page
		
		$('.lkn-sortby').click(
			function(event) {
			event.preventDefault ( );
			$('.drop-down-sort').toggleClass('active');
			
		});

		// Validation of Search Modal 

		$('.checkbox-input').click(
			function(event) {
			event.preventDefault ( );
			
			if ( $(this).parent( ).find('.input').val() != '') {
				$(this).parent().toggleClass('active');	
			}else {
				$(this).parent().toggleClass('error');	
			}			
		});

		// Confirm checkbox of Make a Donation

		$('.checkbox-box .ckeckbox').click(
			function(event) {
			event.preventDefault ( );
			
				$(this).toggleClass('active');	
						
		});

		// slide toggle Change password Settings


		$('.lkn-change-password').click(
			function(event) {
			event.preventDefault ( );
			
			$(this).parent().find('.container-password-settings').slideToggle();
			$(this).toggleClass('active');	
						
		});

		// Create switch buttons plugin
 		
		$("[name='my-checkbox']").bootstrapSwitch();

		// Function SMS settings

		$('#chebox-sms').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.container-settings-msj').slideToggle();
		    
		});

		// Function Automatic Login settings

		$('#checkbox-automatic-login').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.default-login').slideToggle();
		    
		});

		// Function Disable/Enable standing Orders in Make a donation

		$('#standing-order-switch').on('switchChange.bootstrapSwitch', function (event, state) {

		    $('.standing-order-switch-container').toggleClass("active");
		    $('.standing-order-switch-container .btn-group, .standing-order-switch-container .btn ').toggleClass( "disabled" );
		    $('.standing-order-switch-container .selectpicker ').removeProp( "disabled" );
		    
		});

		// VOUCHER more & less and enable/disable order vouchers button

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

		 // VOUCHER less number input

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

		  // VOUCHER plus number input

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
		 

	 	// FORM SEND A FRIEND

	 	$('.send-invite').click(
			function(event) {
			event.preventDefault ( );
			
			if ( $(this).parent( ).find('.input-text').val() == '' || $(this).parent( ).find('.comment-textarea').val() == '' ) {

				$( ".input-text" ).each(function( i ) {
				    if ( $(this).val() == '') {
				    	$(this).addClass('error');
				    }
				});
				if ( $('.comment-textarea').val() == '' ) {
					$('.comment-textarea').addClass('error');	
				}

			}else {
				$( ".comment-textarea , .input-text" ).removeClass('error');
				scrollToAnchor ( 'main-transactions' );
				
				function show_msj_ok(){
				  $('.msj-ok ').slideToggle();
				  $( ".input-text, .comment-textarea " ).val('');
				}
				setTimeout(show_msj_ok, 1000);
			}			
		});

		/* Switch Accout Style*/

		$(".switch-account .dropdown-menu .text").lettering('words');

		/* Datapicker inicialization plugin */

		$('#dates-bt-modal').daterangepicker();  

		$('#dates-bt-modal').on('show.daterangepicker', function(ev, picker) {
          $('<div class="modal-backdrop fade date-back"></div>').appendTo("body");
          setTimeout(function(){
			$('.date-back').addClass("in");
		  }, 20);
          $(".daterangepicker").addClass("calendar-visible");
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
        	$(".daterangepicker").removeClass("calendar-visible");
        });    

        /* Conditional to set sticky footer and primary action */

        if ( $('main.make-donation').length > 0 || $('main.main-help').length || $('main.main-contact-us').length || $('main.order-voucher').length || $('main.main-settings').length ){
	  		$('body').addClass('sticky-footer');
    	};


		// MAKE A DONATION FORM VALIDATION


		// function if value input is > 1600
    	$('.amount-input input').focusout(function(event) {
    		if ( $('.amount-input input').val() > 1600 ) {
    			$('.confirmation-amount').show();
    			$('.large-amount').show();
    		}else{
    			$('.confirmation-amount').hide();
    		}
    	});

    	// function confirmation amount value == input before

    	$( ".confirmation-amount" ).keyup(function() {
		  if ( $('.amount-input input').val() == $('.confirmation-amount').val() ){
		  	$('.confirmation-amount').addClass('success-amount');
		  	$('.confirmation-amount').removeClass('incorrect-amount');
	  		$('.confirmation-amount-error').hide();
		  }else {
		  	
		  	$('.confirmation-amount').addClass('incorrect-amount');
		  	$('.confirmation-amount-error').show();
		  }
		});

		// click button form  
		$('.make-dontation').click(
			function(event) {
			event.preventDefault ( );

			// Validation Select beneficiary

			if ( $('.beneficiary-select .filter-option').text() == 'Please select a Beneficiary' ) {
				$('.beneficiary-select').parent().addClass('has-error');
				$('.beneficiary-select-error').show();
			}
			// Validation Amount 
			if ( $('.amount-input input').val() == '' ) {
				$('.amount-input').addClass('has-error');
				$('.amount-input input').val( 'Please enter an amount to donate' )
			}
			// Validation Amount < 100
			else if ( $('.amount-input input').val() < 100 ) {
				$('.amount-input').parent().addClass('has-error');
				
				$('.amount-input-error').show();

			}
			
			// Validation coin-amount not selected 			
			if ( $('.coin-amount .filter-option').text() == 'USD' ) {
				$('.coin-amount').addClass('error');
			}
			// Validation checkbox not checked  
			if ( !$('.checkbox-box .ckeckbox').hasClass('active') ){
				$('.checkbox-box').addClass('has-error');
			}

		});
 		
	}
);
$(window).load(function(){
	 
	function load_login(){
		$( 'body' ).addClass( 'loaded' );
	}

	//login animation 

	if ( $('#login').length ){
		setTimeout(load_login, 4000);
	}		
});
	
/* Every time the window is scrolled ... */
$(window).scroll( function(){

	/* Navigator 

	if(!$('body').hasClass('menu-mobile-open')) {
		var scroll = $( window ).scrollTop();
		$('.navigator').css('top', scroll);
	}
	*/

});

// Scroll To function
function scrollToAnchor ( ancla )
{
	var off = $( '.' + ancla ).offset ( );
	off = off.top;
	
	off -= 0;
	$('body, html').animate ( { scrollTop: off } , 'slow' );  
	
}
