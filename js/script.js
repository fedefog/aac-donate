var viewportHeight = $(window).height();

var viewportHeight_menos = 220;

function navigator_scroll ( ) {
	if ( viewportHeight < 665 ) {
		$('.navigator .hoverflow').height( viewportHeight - viewportHeight_menos);
	}
}

/* inizialization */

var url = 'dashboard.php';
var transaction = 'transactions-all.php';

// Navigation sidebar 
$(document).on('click', '.nav-icon4', function(event) {
	event.preventDefault ( );
	$(this).toggleClass('open');
	$('body').toggleClass('menu-mobile-open');
	viewportHeight = $(window).height();
	navigator_scroll ( );
});

$(document).on('click', '.layer-navigator', function(event) {
	event.preventDefault ( );
	$('.nav-icon4').removeClass('open');
	$('body').removeClass('menu-mobile-open');
});

$(document).on('click', '.close-nav', function(event) {
	event.preventDefault ( );
	$('.nav-icon4').toggleClass('open');
	$('body').toggleClass('menu-mobile-open');
});

load_js()

/* Ajax navigation */
	
	$(document).on('click', '.nav-transactions a', function(event) {

		  event.preventDefault(); // stop the browser from following the link  

		  progress_bar();

		  $("#myBar").addClass("visible"); // Loading bar visibility 
		  $('.nav-mobile').removeClass("open");

		  
			  // $("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			  transaction = $(this).attr('href'); 
			  console.log(transaction);

			  $("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			  setTimeout(function(){
			  	// $('body').removeClass('menu-mobile-open');
				$('.ajax-transaction').load(transaction, function() { 
					$("#myBar").removeClass("visible");  // fadeout of the bar loading 
					load_js()
					sticky_footer ();
				}); // load the html response into a DOM element
				}, 2000);

			  

		});

/* Navigation from dashboard  */
	

	$(document).on('click', '.nav-dashboard a, .anim-li a, .pending-bt', function(event) {

		  event.preventDefault(); // stop the browser from following the link  

		  progress_bar();

		  $("#myBar").addClass("visible"); // Loading bar visibility 
		  $('.nav-mobile').removeClass("open");

		  if ( url == 'dashboard.php' ) {

			  $("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			  url = $(this).attr('href'); 
			  console.log(url);

			  $("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			  setTimeout(function(){
			  	$('body').removeClass('menu-mobile-open');
				$('#main-container').load(url, function() { 
					$("#myBar").removeClass("visible");  // fadeout of the bar loading 
					load_js()
					sticky_footer ();
				}); // load the html response into a DOM element
				}, 2000);

			  } else {

			  	url = $(this).attr('href'); 
			  	console.log(url);

			  	setTimeout(function(){
			  		$('body').removeClass('menu-mobile-open');
					$('#main-container').load(url, function() { 
						$("#myBar").removeClass("visible");  // fadeout of the bar loading 
						load_js()
						sticky_footer ();
					}); // load the html response into a DOM element
				}, 2000);


			  } // end conditional 

		});

	


	$(document).on('click', '.go-back , .li-dashboard a', function(event) {

		event.preventDefault(); // stop the browser from following the link  

		if ( url == 'dashboard.php') {
			event.preventDefault();
			// alert('nada')
		} else {

			progress_bar()      
  			$("#myBar").addClass("visible"); // Loading bar visibility 

  			$("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			url = $(this).attr('href'); 
		    console.log(url);

		    setTimeout(function(){
		    $('#main-container').load(url, function() { 
				$("#myBar").removeClass("visible");  // fadeout of the bar loading 
				$('body').removeClass(); // Remove all classes from body (this works for pages like make a donation or vouchers where the footer and CTA is fixed )
				load_js()
				sticky_footer ();
			}); // load the html response into a DOM element
			}, 2000);

			setTimeout(function(){
				
			}, 1000);
		}
	});

/* Conditional to set sticky footer and primary action */

	function sticky_footer(){
	    if ( $('main.make-donation').length > 0 || $('main.main-help').length || $('main.main-contact-us').length || $('main.order-voucher').length || $('main.main-settings').length ){
	  		$('body').addClass('sticky-footer');
		} else {
			$('body').removeClass('sticky-footer');
		};	
	};

/* Progress bar */

	function progress_bar () {
	  var elem = document.getElementById("myBar");
	  var width = 1;
	  var id = setInterval(frame, 10);
	  function frame() {
	    if (width >= 100) {
	      clearInterval(id);
	    } else {
	      width++;
	      elem.style.width = width + '%';
	    }
	  }
	}

/* inizialization main function */	

	function load_js() {


		$(document).ready(function( ) {


			/* Navigator Scroll */

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
				$('.sort-back').toggleClass("in");
			});

			// Validation of Search Modal && Vouches Chebox
			var ckeckbox_ckeched = false;

			$('.checkbox-input').click(
				function(event) {
				event.preventDefault ( );
				
				if ( ckeckbox_ckeched == false ) {
					ckeckbox_ckeched = true;
					$(this).parent().toggleClass('active');	
				}else  {

					if ( $(this).parent().hasClass('active') ) {
						$(this).parent().toggleClass('active');
						ckeckbox_ckeched = false;
					}
					else {
						$('.checkbox-input').parent().removeClass('active');	
						$(this).parent().toggleClass('active');
						ckeckbox_ckeched = true;		
					}
				}			
			});
			// Validation of Search Modal if input is empty 
			$('.btn-search').click(
				function(event) {
				
				if ( $('.row-input.active').find('.input').val() == '' ) {
					$('.row-input.active').parent().toggleClass('error');
					event.preventDefault ( );
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

	} // end load js 


$(window).load(function(){
	 
	function load_login(){
		$( 'body' ).addClass( 'loaded' );
	}

	//login animation 

	if ( $('#login').length ){
		setTimeout(load_login, 4000);
	}		
});


// Scroll To function
function scrollToAnchor ( ancla )
{
	var off = $( '.' + ancla ).offset ( );
	off = off.top;
	
	off -= 0;
	$('body, html').animate ( { scrollTop: off } , 'slow' );  
	
}
