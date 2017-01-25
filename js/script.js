function ToGBPAmount(amount){
	var gbpamount;
	var currency = $('#Currency').val();
	if (currency=='NIS') gbpamount = amount  / NIS_exrate;
	else if (currency=='USD') gbpamount = amount  / USD_exrate;
	else if (currency=='EUR') gbpamount = amount  / EUR_exrate;
	else gbpamount = amount;

	return gbpamount;
}

var viewportHeight = $(window).height();
var viewportHeight_menos = 220;
function navigator_scroll( ) {
    if (viewportHeight < 665) {
        $('.navigator .hoverflow').height(viewportHeight - viewportHeight_menos);
    }
}
/* inizialization */
var url = 'dashboard.php';
var transaction = 'transactions-all.php';
// AACDESING //
var voucher = 'vouchers.php';
var standing = 'standing-orders-current.php';
// Navigation sidebar 
$(document).on('click', '.nav-icon4', function (event) {
    event.preventDefault( );
    $(this).toggleClass('open');
    $('body').toggleClass('menu-mobile-open');
    viewportHeight = $(window).height();
    navigator_scroll( );
});
$(document).on('click', '.layer-navigator', function (event) {
    event.preventDefault( );
    $('.nav-icon4').removeClass('open');
    $('body').removeClass('menu-mobile-open');
});

$(document).on('click', '.close-notification', function (event) {
    event.preventDefault( );
    
    $(this).parent().hide();
    $('body').removeClass('has-notification');
});

$(document).on('click', '.close-nav', function (event) {
    event.preventDefault( );
    $('.nav-icon4').toggleClass('open');
    $('body').toggleClass('menu-mobile-open');
});
$(document).on('click', '.btn-dropdown-search', function (event) {
    event.preventDefault( );
    $('.dropdown-search').slideToggle();
});
$(document).on('click', '.add-notes', function (event) {
    event.preventDefault( );
    $('.more-note, .less-note').toggle();
    $('.box-notes').slideToggle();
});
$(document).on('click', '.lkn-sortby , .sort-back', function (event) {
    event.preventDefault( );
    $('.dropdown-search').hide();
    $(this).parent().find('.drop-down-sort').toggleClass('active');
    $(this).parent().find('.sort-back').toggleClass("in");
});
$(document).on('click', '.sortby-lkn', function (event) {
    event.preventDefault( );
    $('.navigator-transactions-sortby').addClass('active');
});
$(document).on('click', '.cancel-standing-order-bt', function (event) {
    event.preventDefault( );
    setTimeout(function () {
        $('.modal-current-standing-order').hide();
    }, 200);
});
$(document).on('click', '.btn-yes-cancelled', function (event) {
    event.preventDefault( );
    $('.title-cancelled, #modal-delete-transaction .btns-options').hide();
    $('.title-cancelled-ok').fadeIn().css('display', 'table-cell');
    setTimeout(function(){
        /* AACDESIGN3*/
        $('#modal-delete-transaction').modal('hide');
        $('#modal-voucher').modal('hide');
        $('.title-cancelled, #modal-delete-transaction .btns-options').show();
        $('.title-cancelled-ok').hide();

    },2000);
});
$(document).on('click', '.nav-transactions-li', function (event) {
    event.preventDefault( );
    $('.dropdown-search').hide();
});

$(document).on('click', '.sortby-lkn', function (event) { //sort by link
    event.preventDefault( );
    if ($('.drop-down-sort').hasClass('active') === true) {
        $('.drop-down-sort').removeClass('active');
    }
});

$(document).on('blur', '.ldate-lkn.page', function (event) {
    event.preventDefault( );
    if ($(this).parent().find('.drop-down-sort').hasClass('active') === true) {
        $(this).parent().find('.drop-down-sort').removeClass('active');
    }
});
// AACDESING //
$(document).on('focus', '.input-to-amount', function (event) {
    if ( $(this).val( ) != ''){
       var res = $(this).val( );
       res = res.slice(3);
       $(this).val( res );
      
    }
    
});
$(document).on('click', '.reset-input', function (event) {
    
    event.preventDefault( );
    
    $( this ).parent( ).find('.input-to-amount,.input-search').val ( '' );
    $( this ).parent( ).find('.input-to-amount,.input-search').focus();
    
    $(this).hide();



});
$(document).on('blur', '.input-to-amount', function (event) {
    event.preventDefault( );
    
        if ( $(this).val( ) != '') {
            var txt = $(this).val();

            $(this).val( 'TO ' + txt );
            $( this ).parent( ).find('.reset-input').show ( );
            //AACDESIGN2
            $(this).removeClass('empty-state-input');
        }else {
            
            $( this ).parent( ).find('.reset-input').hide ( );
        }

    
});
$(document).on('blur', '.input-search', function (event) {
    event.preventDefault( );
    
        if ( $(this).val( ) != '') {
            
            $( this ).parent( ).find('.reset-input').show ( );

        }else {
            
            $( this ).parent( ).find('.reset-input').hide ( );
        }

    
});
// END AACDESING //
load_js();
/* Ajax navigation */
// STANDING ORDERS NAV
/**
$(document).on('click', '.nav-standing-orders-li a', function (event) {
    event.preventDefault(); // stop the browser from following the link  
    if ($(this).attr('href') == standing) {
        // do nothing 
    } else {
        progress_bar();
        $("#myBar").addClass("visible"); // Loading bar visibility 
        $('.nav-mobile').removeClass("open");
        var thisnav = $(this);
        standing = $(this).attr('href');
        $("html, body").animate({scrollTop: 0}, "fast"); // Animation to top of window
        setTimeout(function () {
            $('.ajax-standing').load(standing, function () {
                $('.ajax-standing').css({opacity: 0}).fadeTo(400, 1);//Efect fade
                $('.nav-standing-orders-li a').removeClass('active')
                $(thisnav).addClass('active');
                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
                load_js()
                sticky_footer();
            }); // load the html response into a DOM element
        }, 2000);
    }
});
**/
// AACDESING  VOUCHER BOOKS NAV //
$(document).on('click', '.navigator-voucher-books a', function (event) {
    event.preventDefault(); // stop the browser from following the link  
    if ($(this).attr('href') == voucher) {
        // do nothing 
    } else {
        progress_bar();
        $("#myBar").addClass("visible"); // Loading bar visibility 
        $('.nav-mobile').removeClass("open");
        var thisnav = $(this);
        voucher = $(this).attr('href');

        $("html, body").animate({scrollTop: 0}, "fast"); // Animation to top of window
        setTimeout(function () {
            $('#main-container').load(voucher, function () {
                $('.ajax-voucher').css({opacity: 0}).fadeTo(400, 1);//Efect fade
                $(thisnav).addClass('selected');
                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
                load_js()
                sticky_footer();
            }); // load the html response into a DOM element
        }, 2000);
    }
});

// TRANSACTIONS NAV
$(document).on('click', '.nav-standing-orders-li a,.ajaxlink, .clear-all-filters a, .filter-selected a, .dropdown-dates a.page, .nav-transactions a, .transaction_page_desktop a,.transaction_page_mobile a', function (event) {
    event.preventDefault(); // stop the browser from following the link  

    if ($(this).attr('href') == transaction && false) {
        // do nothing 
    } else {
        progress_bar();
        $("#myBar").addClass("visible"); // Loading bar visibility 
        $('.nav-mobile').removeClass("open");
        var thisnav = $(this);
        transaction = $(this).attr('href');

        //search in selected tab
       
		/**
		var tabQS='';

		if($('.nav-transactions-li .active').length) {
        	tabQS = $('.nav-transactions-li .active').attr('href').split('?')[1];
        	if(tabQS && typeof(tabQS) != 'undefined') {
				transaction = transaction.replace(tabQS,'');
				transaction += '&'+tabQS;
			}
        }
		**/
        /////////////////

        $("html, body").animate({scrollTop: 0}, "fast"); // Animation to top of window
        setTimeout(function () {
            // $('body').removeClass('menu-mobile-open');

            var formData = null;

            $('#main-container').load(transaction, formData, function () {
                $('.ajax-transaction').css({opacity: 0}).fadeTo(400, 1);//Efect fade
                $(thisnav).parent().parent().find('a').removeClass('active');
                //$('.nav-transactions a').removeClass('active');
                $(thisnav).addClass('active');
                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
                load_js()
                sticky_footer();
            }); // load the html response into a DOM element
        }, 500);
    }
});



//search
$(document).on('click', '.custom-date-go', function (event) {
    event.preventDefault(); // stop the browser from following the link  
	$('#startd').val($('#customstartdate').val());
	$('#endd').val($('#customenddate').val());
	$('#dateType').val('custom');
	$('.search-desktop').click();
});

$(document).on('click', '.search-desktop, .date-desktop', function (event) {
    event.preventDefault(); // stop the browser from following the link  
    if ($(this).attr('href') == transaction) {
        // do nothing 
    } else {
        progress_bar();
        $("#myBar").addClass("visible"); // Loading bar visibility 
        $('.nav-mobile').removeClass("open");
        var thisnav = $(this);
        transaction = 'transactions.php';


        $("html, body").animate({scrollTop: 0}, "fast"); // Animation to top of window
        setTimeout(function () {
            // $('body').removeClass('menu-mobile-open');

			var formData = $('#transaction-search').serialize();

            $('#main-container').load(transaction, formData, function () {
                $('.ajax-transaction').css({opacity: 0}).fadeTo(400, 1);//Efect fade
				$(thisnav).parent().parent().find('a').removeClass('active');
                //$('.nav-transactions a').removeClass('active');
                $(thisnav).addClass('active');
                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
                load_js()
                sticky_footer();
            }); // load the html response into a DOM element
        }, 500);
    }	
});

$(document).on('click', '.btn-success', function (event) {

			var r = $(this).parents('.daterangepicker');

			var sd = $('[name="daterangepicker_start"]',r).val();
			var ed = $('[name="daterangepicker_end"]',r).val();

			$('#startd-mobile').val(sd);
			$('#endd-mobile').val(ed);

});

$(document).on('click', '.search-mobile, .date-mobile, .btn-success', function (event) {
    event.preventDefault(); // stop the browser from following the link  
    if ($(this).attr('href') == transaction) {
        // do nothing 
    } else {
        progress_bar();
        $("#myBar").addClass("visible"); // Loading bar visibility 
        $('.nav-mobile').removeClass("open");
        var thisnav = $(this);
        transaction = 'transactions.php';


        $("html, body").animate({scrollTop: 0}, "fast"); // Animation to top of window
        setTimeout(function () {
            // $('body').removeClass('menu-mobile-open');

			var formData = $('#transaction-search-mobile').serialize();

            $('#main-container').load(transaction, formData, function () {
                $('.ajax-transaction').css({opacity: 0}).fadeTo(400, 1);//Efect fade
				$(thisnav).parent().parent().find('a').removeClass('active');
                //$('.nav-transactions a').removeClass('active');
                $(thisnav).addClass('active');
                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
                load_js()
                sticky_footer();
            }); // load the html response into a DOM element
        }, 500);
    }	
});


// AACDESING SORT by
$(document).on('click', '.date-lkn.page', function (event) {
    $('.date-lkn').removeClass('selected');
    $('.custom-range-container').removeClass("active");
    if ($(this).hasClass('selected') === true) {
        $(this).removeClass('selected');
    } else {
        $(this).addClass('selected');
    }
    $('.navigator-transactions-lkn .dates_text_selected').text($(this).text())
});
$(document).on('click', '.sortby-lkn', function (event) {
    
    $('.navigator-transactions-lkn .text').text($(this).text())
});
$(document).on('click', '.custom-range-lkn', function (event) {
    $('.date-lkn').removeClass('selected');
    $('.custom-range-container').addClass("active");
});
// END AACDESING
$(document).on('click', '.sort-transactions a, .navigator-transactions-sortby .reset-sort', function (event) {
    event.preventDefault(); // stop the browser from following the link  
    if ($(this).attr('href') == transaction) {
        // do nothing 
    } else {
        progress_bar();
        $("#myBar").addClass("visible"); // Loading bar visibility 
        $('.nav-mobile').removeClass("open");
        var thisnav = $(this);
        transaction = $(this).attr('href');

		//search in selected tab
		
		console.log($('.nav-transactions .active').attr('href'));		
/**
		var tabQS = $('.nav-transactions-li .active').attr('href').split('?')[1];

		if(tabQS && typeof(tabQS) != 'undefined') {
			transaction = transaction.replace(tabQS,'');
			transaction += '&'+tabQS;
		}
**/
		/////////////////

        $("html, body").animate({scrollTop: 0}, "fast"); // Animation to top of window
        setTimeout(function () {
            // $('body').removeClass('menu-mobile-open');

			var formData = $('#transaction-search').serialize();

            $('#main-container').load(transaction, formData, function () {
                $('.ajax-transaction').css({opacity: 0}).fadeTo(400, 1);//Efect fade
				$(thisnav).parent().parent().find('a').removeClass('active');
                //$('.nav-transactions a').removeClass('active');
                $(thisnav).addClass('active');
                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
                load_js()
                sticky_footer();
            }); // load the html response into a DOM element
        }, 500);
    }
});


$(document).on('click', '.history-back', function (e) {
	e.preventDefault();
			$('#main-container').hide();
			$('#main-container').attr('id','main-container-history');
			$('#main-container-back').show();
			$('#main-container-back').attr('id','main-container');
});

/* Navigation from dashboard */
$(document).on('click', '.btn-being-processed-mobile, .dashboard-li a, .external-lkn,  .anim-li a, .pending-bt', function (event) {
    event.preventDefault(); // stop the browser from following the link  
    progress_bar();
    $(this).closest('.modal').modal('hide');
    $('body').removeClass('modal-open');
    $("#myBar").addClass("visible"); // Loading bar visibility 
    $('.nav-mobile').removeClass("open");
    transaction = 'transactions-all.php';
    standing = 'standing-orders-current.php';
    if (url == 'dashboard.php') {
        $("html, body").animate({scrollTop: 0}, "fast"); // Animation to top of window
        url = $(this).attr('href');
        $("html, body").animate({scrollTop: 0}, "fast"); // Animation to top of window
        setTimeout(function () {
            $('body').removeClass('menu-mobile-open');
            $('#main-container').load(url, function () {
                $('#main-container').css({opacity: 0}).fadeTo(400, 1);//Efect fade
                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
                load_js();
                sticky_footer();
                // $('#main-container').removeClass('fade-section');
            }); // load the html response into a DOM element
        }, 500);
    } else {
        url = $(this).attr('href');
        setTimeout(function () {
            $('body').removeClass('menu-mobile-open');
			$('#main-container-back').attr('id','main-container-history');
			$('#main-container').hide();
			$('#main-container').attr('id','main-container-back');
			$('#main-container-history').show();
			$('#main-container-history').attr('id','main-container');

            $('#main-container').load(url, function () {
                $('#main-container').css({opacity: 0}).fadeTo(400, 1);//Efect fade
                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
                load_js();
                sticky_footer();
            });
        }, 500);
    }
    $('.dashboard-li .current-page').removeClass('current-page');
    $('.dashboard-li a[href$="' + url + '"]').addClass('current-page');
});

$(document).on('click', '.go-back , .li-dashboard a', function (event) {
    event.preventDefault(); // stop the browser from following the link  
    transaction = 'transactions-all.php';
    standing = 'standing-orders-current.php';
    if (url == 'dashboard.php') {
        event.preventDefault();
    } else {
        progress_bar()
        $("#myBar").addClass("visible"); // Loading bar visibility 
        $("html, body").animate({scrollTop: 0}, "fast"); // Animation to top of window
        url = $(this).attr('href');
        setTimeout(function () {
            $('#main-container').load(url, function () {
                $('#main-container').css({opacity: 0}).fadeTo(400, 1);//Efect fade
                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
                $('body').removeClass(); // Remove all classes from body (this works for pages like make a donation or vouchers where the footer and CTA is fixed )
                load_js();
                sticky_footer();
            }); // load the html response into a DOM element
        }, 1000);
        setTimeout(function () {
        }, 1000);
    }
    // current page
    $('.dashboard-li .current-page').removeClass('current-page');
    $('.dashboard-li a[href$="' + url + '"]').addClass('current-page');
});

/* Conditional to set sticky footer and primary action */
function sticky_footer() {
    if ($('main.make-donation').length > 0 || $('main.main-help').length || $('main.main-contact-us').length || $('main.order-voucher').length || $('main.main-settings').length) {
        $('body').addClass('sticky-footer');
    } else {
        $('body').removeClass('sticky-footer');
    }
    ;
}
/* Progress bar */
function progress_bar() {
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
    $(document).ready(function ( ) {
        /* Navigator Scroll */
        navigator_scroll( );
        $(window).resize(function () {
            navigator_scroll( );
        });
        $('.selectpicker').selectpicker({
            style: 'btn-info',
            showSubtext: 'true',
            size: 4,
        });
        $('.daily-dashboard').click(
                function (event) {
                    event.preventDefault( );
                    $(this).toggleClass('open');
                    $(this).parent().find('.text').slideToggle();
                });
        $('.lkn-daily-donate').click(
                function (event) {
                    event.preventDefault( );
                    if ($(this).parent().parent().hasClass("open")) {
                        $(this).parent().parent().animate({"height": "50px"}).removeClass("open");
                    } else {
                        $(this).parent().parent().animate({"height": "120px"}).addClass("open");
                    }
                });
        /*var ckeckbox_ckeched = false;
         $('.checkbox-input').click(function (event) {
         console.log("checkbox-input click Main -->");
         event.preventDefault( );
         if (ckeckbox_ckeched == false) {
         console.log("checkbox-input click --> IF ");
         ckeckbox_ckeched = true;
         $(this).parent().toggleClass('active');
         } else {
         console.log("checkbox-input click --> Else ");
         if ($(this).parent().hasClass('active')) {
         console.log("checkbox-input click --> Else IF ");
         $(this).parent().toggleClass('active');
         ckeckbox_ckeched = false;
         } else {
         console.log("checkbox-input click --> Else Else");
         $('.checkbox-input').parent().removeClass('active');
         $(this).parent().toggleClass('active');
         ckeckbox_ckeched = true;
         }
         }
         });*/

        /*$('.checkbox-input').click(function (event) {
         event.preventDefault( );
         //if ($('.checkbox-input').parent().hasClass('active') === true) {
         //$('.checkbox-input').parent().removeClass('active');
         //} else {
         $(this).parent().addClass('active');
         //}
         });*/
        /*$('#chkTransactionId').click(function (event) {
         event.preventDefault( );
         if ($(this).parent().hasClass('active') === true) {
         $(this).parent().removeClass('active');
         } else {
         $(this).parent().addClass('active');
         }
         });
         $('#chkCharityName').click(function (event) {
         event.preventDefault( );
         if ($(this).parent().hasClass('active') === true) {
         $(this).parent().removeClass('active');
         } else {
         $(this).parent().addClass('active');
         }
         });
         $('#chkAmount').click(function (event) {
         event.preventDefault( );
         if ($(this).parent().hasClass('active') === true) {
         $(this).parent().removeClass('active');
         } else {
         $(this).parent().addClass('active');
         }
         });
         $('#chkNotes').click(function (event) {
         event.preventDefault( );
         if ($(this).parent().hasClass('active') === true) {
         $(this).parent().removeClass('active');
         } else {
         $(this).parent().addClass('active');
         }
         });
         //console.log("chkVoucherNumber .click Event Code Call");
         $('#chkVoucherNumber').click(function (event) {
         //console.log("chkVoucherNumber --> Click");
         event.preventDefault();
         //console.log("chkVoucherNumber Parent -->" + $('#chkVoucherNumber').parent().hasClass('active') + "<--");
         if ($('#chkVoucherNumber').parent().hasClass('active')) {
         $('#chkVoucherNumber').parent().removeClass('active');
         } else {
         $('#chkVoucherNumber').parent().addClass('active');
         }
         });
         $('#chkBookVoucherNumber').click(function (event) {
         event.preventDefault();
         if ($(this).parent().hasClass('active') === true) {
         $(this).parent().removeClass('active');
         } else {
         $(this).parent().addClass('active');
         }
         });
         $('#chkType').click(function (event) {
         event.preventDefault( );
         if ($(this).parent().hasClass('active') === true) {
         $(this).parent().removeClass('active');
         } else {
         $(this).parent().addClass('active');
         }
         });*/

        $('.input').focus(function (event) {
            event.preventDefault( );
            $(this).parent().parent().addClass('active');
            //AACDESIGN2
            if ( $(this).parent().parent().find( '.input-to-amount' ).val() == '' ) {
                $(this).parent().parent().find( '.input-to-amount' ).addClass('empty-state-input');
            }
            else{
                $(this).parent().parent().find( '.input-to-amount' ).removeClass('empty-state-input');
            }
            //END AACDESIGN2
        });
       $('.input').blur(function (event) {
            event.preventDefault( );

            // AACDESIGN2
            if ( !$(this).hasClass('input-to-amount')){
    			if($(this).val()) return;
                $(this).parent().parent().removeClass('active');
            }
            
        });

        /*if ($('.checkbox-input').parent().hasClass('active'))
         {
         //ckeckbox_ckeched = true;
         }*/
        // Validation of Search Modal if input is empty 
        /*$('.btn-search').click(
         function (event) {        
         if ($('.row-input.active').find('.input').val() == '') {
         $('.row-input.active').parent().toggleClass('error');
         event.preventDefault( );
         }
         });*/
		/**
        $('.btn-search').on('click',
                function (event) {
                    if ($('.row-input.active').find('.input').val() == '' && $('.row-input.active').find('.input').prop('name') != 'charity_name') {
                        $('.row-input.active').parent().toggleClass('error');
                        event.preventDefault();
                    } else {
                        var param = "";
                        $(".row-input.active").each(function () {
                            var name = $(this).find('.input').prop('name');
                            var value = $(this).find('.input').val();
                            param = param + "&&" + name + "=" + encodeURIComponent(value);
                            param = param + "&&startdate=" + encodeURIComponent($('#startd').val()) + "&&enddate=" + encodeURIComponent($('#endd').val());
                            //alert(name + "&" + value);
                            //alert(param);
                        });
                        var url = "";
                        url = "transactions-all.php?result=search" + param;
                        $(".sortby-li > a").each(function (index) {
                            var u = "";
                            u = $(this).prop('href');
                            $(this).prop('href',u + param);
                            //alert($(this).prop('href'));
                        });

                        //alert($('.sortby-li > a').prop('href'));
                        $('.btn-search').prop('href', url);
                        //var name = $('.row-input.active').find('.input').prop('name');
                        //var value = $('.row-input.active').find('.input').val();
                        //$('.btn-search').prop('href', "transactions-all.php?result=search&&" + name + "=" + encodeURIComponent(value));
                        $('.dropdown-search').hide();
                        $('.modal-search').modal('hide');
                    }
                });
		**/
        // Confirm checkbox of Make a Donation
        //$('.checkbox-box .ckeckbox').click(
		//$(document).ready(function(){

            /* AACDESIGN3 */
            /*
				$('#main-container').on('click','.checkbox-box .ckeckbox',function (event) {
                    event.preventDefault();
                    $(this).toggleClass('active');
                });
            */
		//});
        // slide toggle Change password Settings
        $('.lkn-change-password').click(
                function (event) {
                    event.preventDefault();
                    $(this).parent().find('.container-password-settings').slideToggle();
                    $(this).toggleClass('active');
                });
        $(".switch-settings").bootstrapSwitch();
        $(".standing-order-switch").bootstrapSwitch();
        $('#chebox-sms').on('switchChange.bootstrapSwitch', function (event, state) {
            $('.container-settings-msj').slideToggle();
        });
        $('#checkbox-automatic-login').on('switchChange.bootstrapSwitch', function (event, state) {
            $('.default-login').slideToggle();
        });
		        $('.switch-settings-sms').on('switchChange.bootstrapSwitch', function (event, state) {
						var me = $(this).val();
			            $('#'+me).slideToggle();
			    });		
        $('.standing-order-switch').on('switchChange.bootstrapSwitch', function (event, state) {
            $('.standing-order-switch-container').toggleClass("active");
            $('.standing-order-switch-container .btn-group, .standing-order-switch-container .btn').toggleClass("disabled");
            $('.standing-order-switch-container .selectpicker ').removeProp("disabled");
            if (jQuery('.standing-order-switch-container').hasClass('active') === true) {
                jQuery('#txtNumberOfPayments').removeAttr("disabled");
            } else {
                jQuery('#txtNumberOfPayments').attr("disabled", "disabled");
            }
        });
        // VOUCHER more & less and enable/disable order vouchers button
        $(".input-number").each(function (i) {
            $(this).change(function () {
                if ($(this).val() > 0) {
                    $(this).parent().removeClass('input-default');
                    $('.lkn-order-vouchers').removeClass('disabled');
                } else {
                    $(this).parent().addClass('input-default');
                    $('.lkn-order-vouchers').addClass('disabled');
                }
            });
        });
        $('.less-input').click(
                function (event) {
                    event.preventDefault( );
                    var valor = $(this).parent().find('.input-number').val();
                    if (valor > 0) {
                        valor--;
                        $(this).parent().find('.input-number').val(valor)
                    }
                    if (valor == 0) {
                        $(this).parent().parent().addClass('input-default');
                        $('.lkn-order-vouchers').addClass('disabled');
                    }
                });
        // VOUCHER plus number input
        $('.more-input').click(
                function (event) {
                    event.preventDefault( );
                    var valor = $(this).parent().find('.input-number').val();

                    valor++;
                    $(this).parent().find('.input-number').val(valor)
                    if (valor > 0) {
                        $(this).parent().parent().removeClass('input-default');
                        $('.lkn-order-vouchers').removeClass('disabled');
                    }
                });
        $('.lkn-order-vouchers.disabled').click(
                function (event) {
                    event.preventDefault( );
                    // if order vouchers buton is disabled, prevent default even
                });
	/**
        $('.send-invite').click(
                function (event) {
                    event.preventDefault( );
                    if ($(this).parent( ).find('.input-text').val() == '' || $(this).parent( ).find('.comment-textarea').val() == '') {
                        $(".input-text").each(function (i) {
                            if ($(this).val() == '') {
                                $(this).addClass('error');
                            }
                        });
                        if ($('.comment-textarea').val() == '') {
                            $('.comment-textarea').addClass('error');
                        }
                    } else {
                        $(".comment-textarea , .input-text").removeClass('error');
                        scrollToAnchor('main-transactions');

                        function show_msj_ok() {
                            $('.msj-ok ').slideToggle();
                            $(".input-text, .comment-textarea ").val('');
                        }
                        setTimeout(show_msj_ok, 1000);
                    }
                });
		**/
        $(".switch-account .dropdown-menu .text").lettering('words');
        var options = {};
        /*var start = moment().subtract(18, 'month');
         var end = moment();*/

        if ($('#startd').val() == "" && $('#endd').val() == "") {
            var start = moment().subtract(18, 'month');
            var end = moment();

            //$('#startd').attr('value', start.format('DD-MM-YYYY'));
            //$('#endd').attr('value', end.format('DD-MM-YYYY'));
        } else {
            var start = $('#startd').val();
            var end = $('#endd').val();
        }


        /*var sd = $('#startd').val();
         var ed = $('#endd').val();*/

        // AACDESING
        $('input[name="customstartdate"]').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            singleDatePicker: true,
            "showDropdowns": true,
            "opens": "left",
            "drops": "up",
            "autoApply": true,
            startDate: start
        });
        $('input[name="customenddate"]').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            singleDatePicker: true,
            "showDropdowns": true,
            "opens": "left",
            "drops": "up",
            "autoApply": true,
            startDate: end
        });

        $('#dates-bt-modal, #config-date').daterangepicker({
            locale: {
                format: 'DD-MM-YYYY'
            },
            "showDropdowns": true,
            startDate: start,
            endDate: end
        });
        $('#dates-bt-modal, #config-date').on('show.daterangepicker', function (ev, picker) {
            $('.dropdown-search').hide();
            $('<div class="modal-backdrop fade date-back"></div>').appendTo("body");
            setTimeout(function () {
                $('.date-back').addClass("in");
            }, 20);
            $(".daterangepicker").addClass("calendar-visible");
        });
        $('.custom-range-container input').on('show.daterangepicker', function (ev, picker) {
            $('.dropdown-search').hide();
            $(".daterangepicker").addClass("calendar-visible");
        });
        $('#dates-bt-modal, #config-date, .custom-range-container input').on('showCalendar.daterangepicker', function (ev, picker) {
            $(".calendar.right tbody").remove();
        });
        $('#dates-bt-modal, #config-date, .custom-range-container input').on('apply.daterangepicker', function (ev, picker) {
            var value = picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD');
            var searchDate = $('#config-date').val();
            var str = new String('"' + searchDate + '"');
            var startdate = str.substring(1, 11);
            var enddate = str.substring(14, 24);
            //alert(startdate + " - " + enddate);
            $('#config-date').prop('value', startdate + " - " + enddate);
            $('#startd').prop('value', startdate);
            $('#endd').prop('value', enddate);
            $('#startDate').prop('class', 'transaction_page');
            $('#startDate').prop('href', 'transactions-all.php?startdate=' + startdate + '&&enddate=' + enddate);
            //window.location.replace('transactions-all.php?startdate=' + startdate + '&&enddate=' + enddate);
            $('#startDate').trigger('click');
        });
        $('#dates-bt-modal, #config-date, .custom-range-container input').on('cancel.daterangepicker', function (ev, picker) {
            $(".date-back").remove();
        });
        $('#dates-bt-modal, #config-date, .custom-range-container input').on('hide.daterangepicker', function (ev, picker) {
            $(".date-back").remove();
            $(".daterangepicker").removeClass("calendar-visible");
        });
        $('input[name="customstartdate"]').on('apply.daterangepicker', function (ev, picker) {
            startdate = picker.startDate.format('DD/MM/YYYY')
            //alert(startdate);
        });
        // AACDESING END
        $('input[name="customenddate"]').on('apply.daterangepicker', function (ev, picker) {
            enddate = picker.endDate.format('DD/MM/YYYY')
            var date_complete = startdate + ' - ' + enddate;
            //$('.dropdown-dates').removeClass('active');
            $('.navigator-transactions-lkn .dates_text_selected').html(date_complete);
            //alert(enddate);
        });
        $('#Amount').focusout(function (event) {
             $('.confirmation-amount-error').hide();

            if (ToGBPAmount($('#Amount').val()) >= 15000) {
                $('.confirmation-amount').show();
            } else {
                $('.confirmation-amount').hide();
            }
            if (ToGBPAmount($('#Amount').val()) > 5000 && $('#Amount').val() < 14999) {
                $('.donations-are-subject-error').show();
            } else {
                $('.donations-are-subject-error').hide();
            }
        });
        $('#Amount').focus(function (event) {
            $('#Amount').parent().removeClass('has-error');
        });
        // function confirmation amount value == input before
        $("#confirmAmount").blur(function () {
            if ($('#Amount').val() == $('#confirmAmount').val()) {
                $('.confirmation-amount').addClass('success-amount');
                $('.confirmation-amount').removeClass('incorrect-amount');
                $('.confirmation-amount-error').hide();
                $('.confirmation-amount-succes').show();
            } else {
                $('.confirmation-amount').addClass('incorrect-amount');
                $('.confirmation-amount-success').hide();
                $('.confirmation-amount-error').show();
            }
        });
        //search field select a beneficiary
        $('.input-beneficiary').focus(function () {
            $(this).attr('placeholder', 'Type your search');
            $(".results").css("visibility", "visible");
            //console.log('focus');
        }).blur(function () {
            //console.log('blur');
            $(this).attr('placeholder', 'Please select a Beneficiary');
        })
        $('.search .caret').click(function () {
            if ($(".results").css("visibility") == "hidden")
            {
                $(this).attr('placeholder', 'Type your search');
                $(".results").css("visibility", "visible");
            } else
            {
                $(".results").css("visibility", "hidden");
                $(this).attr('placeholder', 'Please select a Beneficiary');
            }
        })
        $('.search .input-beneficiary').click(function () {
            //$(".results").css("visibility", "visible");
            $(".results").css("display", "block");
        }).blur(function () {
            setTimeout(function () {
                //$(".results").css("visibility", "hidden");
                $(".results").css("display", "none");
            }, 100);
        })
        $('.search').on("click", '.results a', function (event) {
            event.preventDefault();
            var str = $(this).text();
            $('.beneficiary-select-error').show();
            setTimeout(function () {
                $('.beneficiary-select-error').hide()
            }, 10000);
            $('.search .input-beneficiary').val(str);
            //$(".results").css("visibility", "hidden");
            $(".results").css("display", "none");
            DoCharityChange();
        });
        // click button form
        $('.make-dontation-mobile').click(function (event) {
                    event.preventDefault( );
					
					var StandingOrderTypeMobile = $('#StandingOrderTypeMobile').val();
					var NumberOfPaymentsMobile = $('#NumberOfPaymentsMobile').val();
					var StandingOrderStartDateMobile = $('#StandingOrderStartDateMobile').val();
					var StandingOrderFrequencyMobile = $('#StandingOrderFrequencyMobile').val();

					$('#StandingOrderType').val(StandingOrderTypeMobile);
					$('#NumberOfPayments').val(NumberOfPaymentsMobile);
					$('#StandingOrderStartDate').val(StandingOrderStartDate);
					$('#StandingOrderFrequency').val(StandingOrderFrequency);
		});
        $('.make-dontation').click(
                function (event) {
                    event.preventDefault( );
					RequestValidate.saveDonation();
					return;
					/**
                    // Validation Select beneficiary
                    if ($('.beneficiary-select .filter-option').text() == 'Please select a Beneficiary') {
                        $('.beneficiary-select').parent().addClass('has-error');
                        $('.beneficiary-select-error').show();
                    }
                    // Validation Amount 
                    if ($('.amount-input input').val() == '') {
                        $('.amount-input').addClass('has-error');
                        $('.amount-input input').attr("placeholder", "Please enter an amount to donate");
                    }
                    // Validation Amount < 100
                    else if ($('.amount-input input').val() < 100) {
                        $('.amount-input').parent().addClass('has-error');
                        $('.amount-input-error').show();
                    }
                    // Validation coin-amount not selected 			
                    if ($('.coin-amount .filter-option').text() == 'USD') {
                        $('.coin-amount').addClass('error');
                    }
                    // Validation checkbox not checked  
                    if (!$('.checkbox-box .ckeckbox').hasClass('active')) {
                        $('.checkbox-box').addClass('has-error');
                    }
                    // Validation if including words RAFFLE / FEES / TUITION
                    $('.textarea-make-dontation').each(function () {
                        if ($(this).val().match('RAFFLE') || $(this).val().match('FEES') || $(this).val().match('TUITION') || $(this).val().match('raffle') || $(this).val().match('fees') || $(this).val().match('tuition')) {
                            $(this).parent().find('.error-text').show();
                        }
                    });
                    if (Validate(document.editor)) {
                        $('#editor').submit();
                    }
					**/

                });

        jQuery('.btn-make-a-donation').click(
                function (event) {
                    event.preventDefault( );
					RequestValidate.saveDonation();
					/**
                    if (Validate(document.editor)) {
                        $('#quick-donation').submit();
                    }
					**/
                });

        jQuery("#Currency").on('shown.bs.select', function () {
            DoCurrencyList();
        });

        jQuery("#Beneficiary").keyup(function () {
            var filter = jQuery(this).val().toLowerCase();
            jQuery(".results li").each(function () {
                var x = jQuery(this).text().toLowerCase();
                if (x.indexOf(filter) != -1) {
                    jQuery(this).show();
                } else {
                    jQuery(this).hide();
                }
            });
        });

        /* Save Settings Form*/
		/**
        $('.lkn-save').click(function (event) {
            event.preventDefault( );
            //alert('save setting');
            if (Validate(document.editor)) {
                $('#editor').submit();
                //redirectUrl('settings.php');
            }
        });
		**/
    }
    );

} // end load js 


$(window).load(function () {

    function load_login() {
        $('body').addClass('loaded');
    }

    //login animation 

    if ($('#login').length) {
        setTimeout(load_login, 4000);
    }
});


// Scroll To function
function scrollToAnchor(ancla)
{
    var off = $('.' + ancla).offset( );
    off = off.top;

    off -= 0;
    $('body, html').animate({scrollTop: off}, 'slow');

}

function redirectUrl(str) {
    progress_bar();
    $('body').removeClass('modal-open');
    $("#myBar").addClass("visible");
    $('.nav-mobile').removeClass("open");
    url = str;
    setTimeout(function () {
        $('body').removeClass('menu-mobile-open');
        $('#main-container').load(url, function () {
            $('#main-container').css({opacity: 0}).fadeTo(400, 1);//Efect fade
            $("#myBar").removeClass("visible");
            load_js()
            sticky_footer();
        });
    }, 2000);
    $('.dashboard-li .current-page').removeClass('current-page');
    $('.dashboard-li a[href$="' + url + '"]').addClass('current-page');
}

$(document).on('click', '.form-modal-search a.checkbox-input', function (event) {
	$(this).parent().find('input,select').val('');
});


    function cancelStandingOrder(id,charityName)
    {
        BootstrapDialog.show({
            message: 'Are you sure you want to cancel this standing order'+(charityName?' for '+charityName:'')+'?',
            buttons: [{
                    label: 'Confirm',
                    cssClass: 'btn-primary',
                    action: function (dialogItself) {
                        cancelOrder(id);
                        dialogItself.close();
                    }
                }, {
                    label: 'Cancel',
                    action: function (dialogItself) {
                        dialogItself.close();
                    }
                }]
        });
    }

    function cancelOrder(id) {
        //var url = "inc/ajax_cancel_standing_order.php?id=" + id + "&action=cancel";
        var url = "inc/ajax_cancel_standing_order.php";
        var url = "remote.php?m=cancel-standing-order&id="+id;
        jQuery.ajax({
            type: 'POST',
            data: {'id': id, 'action': 'cancel'},
            url: url,
            success: function (data) {
				if(!data) { //blank means sucess

		            jQuery("#modal-quick-donation p").html('Your request to cancel your standing order is currently being processed and will be updated shortly');
		            jQuery("#modal-quick-donation").modal('show');

				}
                /*if(data == "1")
                 {
                 alert('Success');
                 }*/
            }
        });
    }


		function loadpage(url) {
				progress_bar();
			    $('body').removeClass('modal-open');
			    $("#myBar").addClass("visible"); // Loading bar visibility 
			    $('.nav-mobile').removeClass("open");
			
				$('#main-container').load(url, function () {
			                $('#main-container').css({opacity: 0}).fadeTo(400, 1);//Efect fade
			                $("#myBar").removeClass("visible");  // fadeout of the bar loading 
			                load_js();
			                sticky_footer();
			    });	
			}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
} 
