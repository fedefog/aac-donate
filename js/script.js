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
var standing = 'standing-orders-current.php';


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
// Slide toggle desktop search
$(document).on('click', '.btn-dropdown-search', function(event) {
	event.preventDefault ( );
	$('.dropdown-search').slideToggle();
});

$(document).on('click', '.add-notes', function(event) {
	event.preventDefault ( );
	$('.more-note, .less-note').toggle();
	$('.box-notes').slideToggle();
});
$(document).on('click', '.lkn-sortby , .sort-back', function(event) {
	event.preventDefault ( );
	$('.drop-down-sort').toggleClass('active');
	$('.sort-back').toggleClass("in");
});
$(document).on('click', '.btn-yes-cancelled', function(event) {
	event.preventDefault ( );
	$('.title-cancelled, #modal-delete-transaction .btns-options').hide();
	$('.title-cancelled-ok').fadeIn().css('display', 'table-cell');

	
});

// Sortby Transaction page


load_js()

/* Ajax navigation */
	// STANDING ORDERS NAV
	$(document).on('click', '.nav-standing-orders-li a', function(event) {

	  event.preventDefault(); // stop the browser from following the link  

	  if ( $(this).attr('href') == standing ){
	  	// do nothing 
	  }else{
	  	progress_bar();

			  $("#myBar").addClass("visible"); // Loading bar visibility 
			  $('.nav-mobile').removeClass("open");

			  var thisnav= $(this);

			  standing = $(this).attr('href'); 
			  console.log(standing);

			  $("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			  setTimeout(function(){
					$('.ajax-standing').load(standing, function() { 
						$('.ajax-standing').css({ opacity: 0 }).fadeTo(400,1);//Efect fade
					  $('.nav-standing-orders-li a').removeClass('active')
					  $(thisnav).addClass('active');
						$("#myBar").removeClass("visible");  // fadeout of the bar loading 
						load_js()
						sticky_footer ();
					}); // load the html response into a DOM element
				}, 2000);
		  }
	});


	// TRANSACTIONS NAV
	$(document).on('click', '.nav-transactions a', function(event) {

	  event.preventDefault(); // stop the browser from following the link  

	  if ( $(this).attr('href') == transaction ){
	  	// do nothing 
	  }else{
	  	progress_bar();

			  $("#myBar").addClass("visible"); // Loading bar visibility 
			  $('.nav-mobile').removeClass("open");

			  var thisnav	= $(this);
			  // $("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			  transaction = $(this).attr('href'); 
			  console.log(transaction);

			  $("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			  setTimeout(function(){
			  	// $('body').removeClass('menu-mobile-open');
				$('.ajax-transaction').load(transaction, function() { 
					$('.ajax-transaction').css({ opacity: 0 }).fadeTo(400,1);//Efect fade
				  $('.nav-transactions a').removeClass('active');
				  $(thisnav).addClass('active');
					$("#myBar").removeClass("visible");  // fadeout of the bar loading 
					load_js()
					sticky_footer ();
				}); // load the html response into a DOM element
				}, 2000);
		  }
	});

/* Navigation from dashboard  */
	

	$(document).on('click', '.dashboard-li a, .external-lkn,  .anim-li a, .pending-bt', function(event) {

		  event.preventDefault(); // stop the browser from following the link  

		  progress_bar();

			$('body').removeClass('modal-open');
		  $("#myBar").addClass("visible"); // Loading bar visibility 
		  $('.nav-mobile').removeClass("open");
		  transaction = 'transactions-all.php';
		  standing = 'standing-orders-current.php';



		  if ( url == 'dashboard.php' ) {

			  $("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			  url = $(this).attr('href'); 
			  console.log(url);

			  $("html, body").animate({ scrollTop: 0 }, "fast"); // Animation to top of window

			  
			  	// alert('ahora')
			  setTimeout(function(){
			  

			  	$('body').removeClass('menu-mobile-open');
				$('#main-container').load(url, function() { 
			  		$('#main-container').css({ opacity: 0 }).fadeTo(400,1);//Efect fade
					$("#myBar").removeClass("visible");  // fadeout of the bar loading 
					load_js()
					sticky_footer ();
					// $('#main-container').removeClass('fade-section');
				}); // load the html response into a DOM element
				}, 2000);

			  } else {

			  	url = $(this).attr('href'); 
			  	console.log(url);

			  	setTimeout(function(){
			  		$('body').removeClass('menu-mobile-open');
					$('#main-container').load(url, function() { 
						$('#main-container').css({ opacity: 0 }).fadeTo(400,1);//Efect fade
						$("#myBar").removeClass("visible");  // fadeout of the bar loading 
						load_js()
						sticky_footer ();
					}); // load the html response into a DOM element
				}, 2000);


			  } // end conditional 


			// current page	
			$('.dashboard-li .current-page').removeClass('current-page');
			$('.dashboard-li a[href$="'+url+'"]').addClass('current-page');


		});

	


	$(document).on('click', '.go-back , .li-dashboard a', function(event) {

		event.preventDefault(); // stop the browser from following the link  
		transaction = 'transactions-all.php';
		standing = 'standing-orders-current.php';
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
		    	$('#main-container').css({ opacity: 0 }).fadeTo(400,1);//Efect fade
				$("#myBar").removeClass("visible");  // fadeout of the bar loading 
				$('body').removeClass(); // Remove all classes from body (this works for pages like make a donation or vouchers where the footer and CTA is fixed )
				load_js()
				sticky_footer ();
			}); // load the html response into a DOM element
			}, 2000);

			setTimeout(function(){
				
			}, 1000);
		}
		// current page
		$('.dashboard-li .current-page').removeClass('current-page');
		$('.dashboard-li a[href$="'+url+'"]').addClass('current-page');

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

			$('.standing-order-switch').on('switchChange.bootstrapSwitch', function (event, state) {

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
			 $('.lkn-order-vouchers.disabled').click(
				function(event) {
				event.preventDefault ( );
				// if order vouchers buton is disabled, prevent default even
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

			var options = {};

			var start = moment().subtract(6, 'days');
    		var end = moment();

			$('#dates-bt-modal, #config-date').daterangepicker(
			{
			    locale: {
			      format: 'DD-MM-YYYY'
			    },
			    startDate: start,
			    endDate: end
			});

			$('#dates-bt-modal, #config-date').on('show.daterangepicker', function(ev, picker) {
	          $('<div class="modal-backdrop fade date-back"></div>').appendTo("body");
	          setTimeout(function(){
				$('.date-back').addClass("in");
			  }, 20);
	          $(".daterangepicker").addClass("calendar-visible");
	        });

	        $('#dates-bt-modal, #config-date').on('showCalendar.daterangepicker', function(ev, picker) {
	          $( ".calendar.right tbody" ).remove();
	        });      

	        $('#dates-bt-modal, #config-date').on('apply.daterangepicker', function(ev, picker) {
	          console.log(picker.startDate.format('YYYY-MM-DD'));
	          console.log(picker.endDate.format('YYYY-MM-DD'));
	          var value = picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD');
	          /*$('#config-date').val( value );*/
	        });  

	        $('#dates-bt-modal, #config-date').on('cancel.daterangepicker', function(ev, picker) {
	        	$( ".date-back" ).remove();
	        });   

	        $('#dates-bt-modal, #config-date').on('hide.daterangepicker', function(ev, picker) {
	        	$( ".date-back" ).remove();
	        	$(".daterangepicker").removeClass("calendar-visible");
	        });    

			// MAKE A DONATION FORM VALIDATION


			// function if value input is > 16000
	    	$('.amount-input input').focusout(function(event) {
	    		if ( $('.amount-input input').val() > 15000 ) {
	    			$('.confirmation-amount').show();
	    			$('.large-amount').show();
	    		}else{
	    			$('.confirmation-amount').hide();
	    		}
	    	});
	    	$('.amount-input input').focusout(function(event) {
	    		if (  $('.amount-input input').val() > 5000  && $('.amount-input input').val() < 16000 ) {
	    			$('.donations-are-subject-error').show();
	    		}else{
	    			
	    			$('.donations-are-subject-error').hide();
	    		}
	    	});

	    	// function confirmation amount value == input before

	    	$( ".confirmation-amount" ).keyup(function() {
			  if ( $('.amount-input input').val() == $('.confirmation-amount').val() ){
			  	$('.confirmation-amount').addClass('success-amount');
			  	$('.confirmation-amount').removeClass('incorrect-amount');
		  		$('.confirmation-amount-error').hide();
		  		$('.confirmation-amount-succes').show();
			  }else {
			  	
			  	$('.confirmation-amount').addClass('incorrect-amount');
			  	$('.confirmation-amount-success').hide();
			  	$('.confirmation-amount-error').show();
			  }
			});

			
			//search field select a beneficiary

			$('.search .input-beneficiary').focus(function() {
			    $(this).attr('placeholder', 'Type your search');
			}).blur(function() {
			    $(this).attr('placeholder', 'Please select a Beneficiary');
			})

			$('.search .input-beneficiary').click(function() {
			    $(".results").css("visibility","visible");			    
			}).blur(function() {
				setTimeout(function(){
				  $(".results").css("visibility","hidden");
				}, 200);
			})


			$('.search').on("click",'a', function(event) {
				event.preventDefault ( );

				var str = $(this).text();
				$('.beneficiary-select-error').show();
				$( '.search .input-beneficiary' ).val( str );
				$(".results").css("visibility","hidden");		 

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
				

				// Validation if including words RAFFLE / FEES / TUITION
				$('.textarea-make-dontation').each(function() {
				    if( $(this).val().match('RAFFLE') || $(this).val().match('FEES') || $(this).val().match('TUITION') || $(this).val().match('raffle') || $(this).val().match('fees') || $(this).val().match('tuition') ) {
				        $(this).parent().find('.error-text').show();
				    }     
				    
				});

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
