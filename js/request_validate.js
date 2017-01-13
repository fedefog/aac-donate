var Utils = {
	TestNumber : function(amount) {
		if(isNaN(amount)) return false;
		
		var arr = amount.split('.');		
		
		if(arr.length==2) {
			var length = arr[1].length;
	
		
			if (length > 2) return false;
		}
		
		return true;
	}
}

var RequestValidate = {


	//public
	form : null,
	balance:0,

	//private
	completed:[],


	init: function()
	{
		$(document).ajaxError(function(event, request, settings) {
			alert('System error - please contact support or try again');
			//alert('error in: ' + settings.url + ' \n'+'error:\n' + request.responseText);
		});
	},

	
	showDialog : function(message,id,dialogType) {
		
		if(typeof(dialogType)=='undefined') dialogType = 'alert';

		if(dialogType=='confirm') {
            BootstrapDialog.show({
                message: message,
                buttons: [{
                        label: 'Confirm',
                        cssClass: 'btn-primary',
                        action: function (dialogItself) {
                            dialogItself.close();
							$('#confirm-'+id).val('1');
                            RequestValidate.doSaveDonation();
                        }
                    }, {
                        label: 'Cancel',
                        action: function (dialogItself) {
                            dialogItself.close();
                        }
                    }]
            });		
		} else if(dialogType=='success') {
            jQuery("#modal-quick-donation p").html(message);
            jQuery("#modal-quick-donation").modal('show');
			$('#modal-quick-donation').on('hidden.bs.modal', function (e) {
				  window.location.href='./';
			})		
		} else {
            jQuery("#modal-quick-donation p").html(message);
            jQuery("#modal-quick-donation").modal('show');

			if(id=='SOMEdit'){
				loadpage('dashboard.php');
			}

		}
	},

	checked : function(id){
			return ReqestValidate.completed.indexOf(id)>-1;
	}
,

	validate : function(form){
		RequestValidate.form = form;
		RequestValidate.completed = [];
		RequestValidate.doValidate();	
	},

	saveDonation : function(){
        $('.has-error-box').removeClass('has-error-box');
		$('.confirmation-box').val('0');
		RequestValidate.doSaveDonation();
	},

	doSaveDonation : function(){

		var formData = $('#editor').serialize();

		$.ajax({
			url: 'remote.php?m=save-donation',
			type: 'post',
			dataType: 'json',
			data: formData,
			success: function(data)
			{
				if(data.error){
		            $('.box-'+data.errorField).addClass('has-error-box');
					RequestValidate.showDialog(data.errorMessage,data.errorCode,data.errorType);		

				} else {
					var charityName = $('#Beneficiary').val();
					loadpage('dashboard.php');
					$('body').addClass('has-notification');
					//$('.notification-box span').html(charityName);
					$('.notification-box font').html('Your donation to <span>'+charityName+'</span> <strong>is being processed.</strong>');
					$('.notification-box').show();
					//RequestValidate.showDialog('Donation Complete','','success');		
				}
			}
		});		

	},

	doValidate : function(){
		var form = RequestValidate.form;
		
		//var balance = RequestValidate.balance;
		if(!form.elements['fields[Amount]']) return true;

		var so = ($('#StandingOrderType').val() != 'No');

		var currency = $('#Currency').val();

		var amount = form.elements['fields[Amount]'].value;
		
		if (!Utils.TestNumber(amount) && !RequestValidate.checked('AmountFormat')) {
			RequestValidate.showdialog('Amount should be a number without any formatting, e.g. 200 or 200.99','AmountFormat');
			return false;		
		}

		var neg = parseFloat(amount)<0;

		var gbpamount = amount;

		var beneficiary = $('#Beneficiary').val();

		if(!RequestValidate.checked('AmountFormat')) {
			if(beneficiary=='' || beneficiary =='Please select charity from list') {
				RequestValidate.showdialog('Please select a Beneficiary','SelectBeneficiary');
				return false;
			}
		}

		if(!RequestValidate.checked('AmountFormat')) {
			if(amount=='' || amount==0) {
				RequestValidate.showdialog('Please complete all fields','EnterAmount');
				return false;
			} else if (isNaN(amount)) {
				RequestValidate.showdialog('Amount must be a number','EnterAmount');
				return false;
			}
		}

		/**
		if($('#Reference').length && !$('#Reference').val()){
			alert('Please enter a reference');
			return false;
		}
		**/
		


		if (currency=='NIS') gbpamount = gbpamount  / NIS_exrate;
		if (currency=='USD') gbpamount = gbpamount  / USD_exrate;
		if (currency=='EUR') gbpamount = gbpamount  / EUR_exrate;

		//console.log(currency);
		//console.log(parseFloat(gbpamount) +'='+ parseFloat(balance));
		
		console.log(2);

		if(selectedCharityCountry==null) selectedCharityCountry='';

		selectedCharityCountry = $.trim(selectedCharityCountry.toUpperCase());

		if(selectedCharityCountry=='') selectedCharityCountry='UK';
		
		/**
		if((selectedCharityCountry == 'ISRAEL') && ($('#office-comment-option').val()=='')) {
			$('.dialog-option').removeAttr('checked');
			$( "#dialog" ).dialog( "open" );
			return false;
		}	
		**/
		
		console.log('2a');
		
		if(!currencyWarningShown && !RequestValidate.checked('BankCharges')) {
			if(selectedCharityCountry == 'ISRAEL') {
				RequestValidate.showdialog( 'Please note '+"\u00a3"+'4 will be deducted for bank charges','BankCharges');
				return false;
			} else if(selectedCharityCountry == 'USA') {
				RequestValidate.showdialog( 'Please note '+"\u00a3"+'15 will be deducted for bank charges','BankCharges');
				return false;	
			} else if(selectedCharityCountry == 'FRANCE' || selectedCharityCountry == 'GERMANY' || selectedCharityCountry == 'BELGIUM' || selectedCharityCountry == 'ITALY') {
				RequestValidate.showdialog( 'Please note '+"\u00a3"+'5 will be deducted for bank charges','BankCharges');
				return false;			
			}		
		}
		
				//console.log(3);

				gbpamount = parseFloat(gbpamount);
				amount = parseFloat(amount);
		
		var donationPurposeDef = $('#donationPurpose').val();			
		$('#donationPurpose').val('');				
			
			/**
			if(gbpamount >=5000 && gbpamount <= 14999) {
				RequestValidate.showdialog( 'All donations are subject to compliance checks. Given the size of this donation, it is more likely to be selected for a random check. Please be aware that our Compliance Officer may be in touch with you to determine more information about this donation','Compliance');
				return false;
			} else **/

			if (gbpamount >= 15000) {
				if (!$('#donationPurpose').val()) {
					RequestValidate.showdialog( 'All donations are subject to compliance checks. Given the size of this donation, it is more likely to be selected for a random check. Please be aware that our Compliance Officer may be in touch with you to determine more information about this donation','Compliance');
					return false;
				}
				if (!$('#confirmAmount').val()) {
					RequestValidate.showdialog( 'For your own safety please re-enter the amount you wish to donate','Compliance');
					return false;
				}
				if (parseFloat($('#confirmAmount').val()) != amount) {
					RequestValidate.showdialog( 'The amount entered does not match the origional value, please check','Compliance');
					return false;
				}
			}	
					

		//console.log(selectedCharityCountry);
		
		if(  		($('#ClientComments').val().toLowerCase().indexOf("raffle",0)>-1) ||
					($('#OfficeComments').val().toLowerCase().indexOf("raffle",0)>-1) ||
					($('#UserComments').val().toLowerCase().indexOf("raffle",0)>-1)
				){
			RequestValidate.showdialog( 'You cannot pay for raffles with AAC funds');
			return false;
			//alert('You cannot pay for raffles with AAC funds');
			//return false;
		} else if(  ($('#ClientComments').val().toLowerCase().indexOf("fees",0)>-1) ||
					($('#OfficeComments').val().toLowerCase().indexOf("fees",0)>-1) ||
					($('#UserComments').val().toLowerCase().indexOf("fees",0)>-1)
				){
			RequestValidate.showdialog( 'You cannot pay for fees with AAC funds');
			return false;
		} else if(  ($('#ClientComments').val().toLowerCase().indexOf("invoice",0)>-1) ||
					($('#OfficeComments').val().toLowerCase().indexOf("invoice",0)>-1) ||
					($('#UserComments').val().toLowerCase().indexOf("invoice",0)>-1)
				){
			RequestValidate.showdialog( 'You cannot pay for invoices with AAC funds');
			return false;
		} else if (!so && !neg && (parseFloat(gbpamount)<10) && (selectedCharityCountry == 'UK')) {
			RequestValidate.showdialog( 'Sorry, this system can only be used to transfer '+"\u00a3"+'10 or more - please try again');
			return false;
		} else if (so && (selectedCharityCountry != 'UK') && (selectedCharityCountry != 'ISRAEL')) {
			RequestValidate.showdialog( 'Sorry, standing orders can only be to UK or Israeli charities');
			return false;
		} else if ((selectedCharityCountry != 'UK') && (parseFloat(gbpamount)<50)) {
			RequestValidate.showdialog( 'Sorry, transfers to charities abroad must be '+"\u00a3"+'50 or more');
			return false;
		} else if (so && !neg && (parseFloat(gbpamount)<10)) {
			RequestValidate.showdialog( 'Sorry, this system can only be used to transfer '+"\u00a3"+'10 or more - please try again');
			return false;
		} else if (neg && (parseFloat(gbpamount) >= -18) && (parseFloat(gbpamount) < 0) ) {
			RequestValidate.showdialog( 'Sorry, this system can only be used to transfer '+"\u00a3"+'18 or more- please try again');
			return false;
		} else if (!form.ConfirmTransfer.checked) {
			RequestValidate.showdialog( 'Please confirm the transaction is charitable');
			return false;
		} else if(!so && (balance !='' && (parseFloat(gbpamount) > parseFloat(balance) ))) {
			RequestValidate.showdialog( 'Your account balance is insufficient for this transaction, would you like to proceed?','insufficiantbalance','confirm');
			return false;
		} else if (so && (currency != 'GBP') ) {
			RequestValidate.showdialog( 'Sorry, standing orders can only be requested in Pounds (sterling) - please alter the currency selection or remove the Standing Order option');
			return false;
		} else if($('#StandingOrderType').val()=='Continuous payments' && !$('#StandingOrderStartDateContinuous').val()) {
			RequestValidate.showdialog('Please specify the standing order date.');
			return false;
		} else if($('#StandingOrderType').val()=='Fixed number of payments') {//Repeat Payments
			if(!$('#StandingOrderStartDate').val()){
				RequestValidate.showdialog('Please specify the standing order date.');
				return false;
			} else if(!$('#StandingOrderNumPayments').val()){
				RequestValidate.showdialog('Please specify how many payments.');
				return false;
			} else if(!$('#StandingOrderFrequency').val()){
				RequestValidate.showdialog('Please specify the payment interval.');
				return false;
			}
		}

		if(!RequestValidate.checked('confirm')) {
			RequestValidate.showdialog('You have selected to donate ' + currency + ' ' + gbpamount + ' to ' + beneficiary + '. Please confirm your donation.  Please note that reqests cannot be edited.','confirm','confirm');
			return false;
		}
	
	}
}