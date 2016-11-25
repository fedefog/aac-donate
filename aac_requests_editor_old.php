<?php

	require_once 'inc/config.inc.php';
	require_once 'inc/dbconn.inc.php';
	require_once 'cls/base.cls.php';
	require_once 'cls/users.cls.php';
	require_once 'cls/vouchers.cls.php';
	require_once 'cls/charities.cls.php';
	require_once 'cls/ui.cls.php';
	require_once 'cls/aac_requests.cls.php';
	require_once 'cls/sendmail.cls.php';

	require_once 'cls/class.smtp.php';
	require_once 'cls/class.phpmailer.php';

	require_once 'cls/emails.cls.php';
	require_once 'cls/emaillog.cls.php';
	require_once 'inc/funcs.inc.php';
	require_once 'inc/domit/xml_domit_include.php';



	session_start();

	User::LoginCheck();

	$user = new User();
	$user = User::GetInstance();

	$request = new AACRequestItem();

	$record = $user->GetXMLRecord();

	$balance = $record?GetVal('bal'):0;

	$id = $_REQUEST['id'];


	if($id) {
		$request->Load($id) or die('Unable to locate this request - please contact support');
		
		if(!$_SESSION['ADMUSER'] && ($request->Username != $user->Username)) die('Access denied');
		
		$fields = $request->GetProperties();
	} else if($_REQUEST['Request']) {
		$fields['Request'] = $_REQUEST['Request'];
	} else {
		$fields = $_REQUEST;
		$fields['Request'] = 'Initiate Transfer';
	}


//var_dump($fields['RemoteCharityID']);
	if($_REQUEST['doAction']=='clone') {
		unset($id);
		unset($fields['id']);
		if(!$fields['RemoteCharityID']){
			$charity = new CharityItem();

			if($charity->LoadByColumnName($fields['Beneficiary'],'Name')) {

				$fields['RemoteCharityID'] = $charity->remote_charity_id;

			} else $fields['RemoteCharityID'] = -1;
		} else {
			$charity = new CharityItem();
			if($charity->LoadByColumnName($fields['RemoteCharityID'],'remote_charity_id')) {
				$fields['Beneficiary'] = $charity->Name;
			}
		}
	}

//var_dump($fields['Beneficiary']);

	if($_REQUEST['doAction']=='cancelstandingorder') {
		unset($fields);
		$fields['Request'] = 'Cancel Standing Order';
		$fields['OfficeComments'] = 'Please cancel Standing order #'.$id;
		unset($id);
	}


	if($_POST['doAction']) {
		$fields = $_REQUEST['fields'];


		$error = '';

		if($fields['StandingOrderType'] == 'Continuous payments' && $fields['StandingOrderStartDateContinuous']) {
			$fields['StandingOrderStartDate'] = $fields['StandingOrderStartDateContinuous'];
			$fields['StandingOrderFrequency'] = $fields['StandingOrderFrequencyContinuous'];
		} else if($fields['StandingOrderType'] == 'Fixed number of payments' && $fields['StandingOrderStartDateFixed']) $fields['StandingOrderStartDate'] = $fields['StandingOrderStartDateFixed'];
		else if ($fields['StandingOrderType'] == 'No') $fields['StandingOrderFrequency'] = 'No';

		if($fields['StandingOrderType'] == 'No') {
			$fields['StandingOrderStartDate']=null;
			$fields['StandingOrderEndDate']=null;
		}
		
		unset($fields['StandingOrderType']);
		unset($fields['StandingOrderStartDateContinuous']);
		unset($fields['StandingOrderStartDateFixed']);
		unset($fields['StandingOrderFrequencyContinuous']);
		unset($fields['NumPayments']);

		switch($fields['Request']) {
			case 'Initiate Transfer':

				//$fields['Amount'] = floatval($fields['Amount']);
			
				$fields['Amount'] = abs($fields['Amount']);

				if(!$fields['Beneficiary'] || $fields['Beneficiary']=='Please select charity from list') $error = 'Please select a Beneficiary';
				else if(!$fields['Amount']) $error = 'Please enter an amount';
				else if(!is_numeric($fields['Amount'])) $error = 'Amount must be a number';
				else if(!$_REQUEST['ConfirmTransfer']) $error = 'Please confirm the transaction is charitable';
				else if($fields['StandingOrderFrequency'] != 'No' && !$fields['StandingOrderStartDate']) $error = 'Please enter a standing order start date';

				$NIS_exrate = NIS_EXRATE;
				$USD_exrate = USD_EXRATE;
				$EUR_exrate = EUR_EXRATE;

				$gbpAmount=0;

				if($fields['Currency']=='GBP' || !$fields['Currency'] || !$fields['Amount']){

				} else if($fields['Currency']=='EUR') {
					$gbpAmount = $fields['Amount'] / $EUR_exrate;
				} else if($fields['Currency']=='USD') {
					$gbpAmount = $fields['Amount'] / $USD_exrate;
				} else if($fields['Currency']=='NIS') {
					$gbpAmount = $fields['Amount'] / $NIS_exrate;
				}

				if($_REQUEST['charityRemoteID']) {
					//$fields['OfficeComments'] .= "Charity # ".$_REQUEST['charityRemoteID'];
					$fields['RemoteCharityID'] = $_REQUEST['charityRemoteID'];
					
					$charity = new CharityItem();
					if($charity->LoadByColumnName($fields['Beneficiary'],'Name')) {
						$RemoteCharityCountry = $charity->CountryName;
					} 
					
				} else {
					$charity = new CharityItem();
					if($charity->LoadByColumnName($fields['Beneficiary'],'Name')) {

						$fields['RemoteCharityID'] = $charity->remote_charity_id;
						$RemoteCharityCountry = $charity->CountryName;

					} else $fields['RemoteCharityID'] = -2;
				}
				
				if($RemoteCharityCountry && (strtoupper(trim($RemoteCharityCountry)) !='UK')) $fields['OfficeComments'] .= "\nCountry: ".$RemoteCharityCountry;
				if($_REQUEST['donationPurpose']) $fields['OfficeComments'] .= "\nPurpose: ".$_REQUEST['donationPurpose'];

				
				//if($_REQUEST['office-comment-option']) $fields['OfficeComments'] .= "\nIsrael delivery option: ".$_REQUEST['office-comment-option'];

				if($gbpAmount) {
					$gbpAmount=round($gbpAmount,2);
					$gbpAmountF = number_format($gbpAmount,2);
					$fields['OfficeComments'] .= "\nEstimated GBP Amount ".utf8_decode('£').$gbpAmountF;
					$fields['GBPAmount'] = $gbpAmount;
				} else $fields['GBPAmount'] = $fields['Amount'];
				
				$fields['OfficeComments'] = trim($fields['OfficeComments'],"\n");

				break;
			case 'New Voucher Book':
				$vbCount=0;

				if(count($fields['VoucherBooks'])) {
					foreach($fields['VoucherBooks'] as $qty) $vbCount+=$qty;
				}
				if(!$vbCount) $error = 'Please specify a quantity for voucher books';
				else if(!$fields['VoucherBookDelivery']) $error = 'Please select a delivery method';

				if( ($vbCount>2) && ($fields['VoucherBookDelivery']=='Post')) $error = 'Post is not available for more than 2 voucher books';

				break;
		}

		//print_r($fields);

		if(!$error) {
			$request->Username = $user->Username;
			if(!$id) {
				$request->ResultCode = 'Pending';
				$request->RequestDateTime = time();
			}
//var_dump($fields['VoucherBooks']);
			if($fields['VoucherBooks'] && is_array($fields['VoucherBooks']) && count($fields['VoucherBooks'])) {
				$vb='';
				foreach($fields['VoucherBooks'] as $vbook=>$qty) {
					if(!$qty) continue;
					$vbook = utf8_decode(html_entity_decode($vbook));
					$vb .= "{$qty}x{$vbook}; ";
				}
				//$fields['VoucherBooks'] = implode("\r\n",$fields['VoucherBooks']);
				$fields['VoucherBooks']=trim($vb,' ;');
			}
			//echo $fields['VoucherBooks'];
			//exit;

			//$fields['StandingOrderStartDate'] = $fields['StandingOrderStartDate']?strtotime('01-'.$fields['StandingOrderStartDate'])+3600:'0';
			$fields['StandingOrderStartDate'] = $fields['StandingOrderStartDate']?strtotime($fields['StandingOrderStartDate'])+3600:'0';

			$fields['StandingOrderEndDate'] = $fields['StandingOrderEndDate']?intval($fields['StandingOrderEndDate'])+3600:'0';

//echo date('d-M-Y',$fields['StandingOrderStartDate']);
//			print_r($fields);
//			exit;

			$fields['System']='Desktop';
			$request->SetProperties($fields);
			$request->UpdateSummary();
			$request->VoucherBookUrgent = $request->VoucherBookUrgent?'Yes':'No';

			/**
			if(!$id && $fields['Reference']) {
				$request->ClientComments = "REFERENCE: {$fields['Reference']}\n\n".$request->ClientComments;
				unset($request->Reference);
			}
			**/

			$request->Save();
			$emails = new AchisomochEmails();
			$emails->SendRequestConfirmations($user,$request);



			$details = "Request: ".$fields['Request'];
     		if($fields['StandingOrderFrequency'] && $fields['StandingOrderFrequency'] != 'No') $details .= ' : Standing Order';
     		if($_POST['clone']) $details .= ' : Re-Request';
			User::LogAccessRequest($user->Username,'',$details);


			UI::Redirect('?done=true');
		}
	} else if(!$_REQUEST['done'] && !$id)  {
		$details = "New Request: ".$fields['Request'];
		User::LogAccessRequest($user->Username,'',$details);
	}

	switch($fields['Request']) {
		case 'New Voucher Book':
			$field_list = array('VoucherBookField');
			break;
		case 'Transfer Notification':
			$field_list = array('AmountField','BankAccountField');
			break;
		case 'Initiate Transfer':
			$field_list = array('BeneficiaryField','AmountField','StandingOrderField');
			break;
		case 'General Message':
			$field_list = array();
			break;
		case 'Bank Details Request':
			$field_list = array('BankDetailsField');
			break;
		case 'Cancel Standing Order':
			$field_list = array();
			break;
		default:
			die('Unknown request');
			$field_list = array();

	}


	$PAGE_TITLE = 'Create Achisomoch Request';

	$HEADERS = '
		<script language="javascript">
		function ToggleStandingOrder() {
			var so = $(\'#StandingOrderFrequency\').val();

			if (so==\'No\') {
				$(\'#StandingOrderDates\').hide();
			} else {
				$(\'#StandingOrderDates\').show();
			}
		}
		</script>
	';

//header("Content-Type: text/html; charset=utf-8");
?>
<?php include 'header.inc.php'; ?>

<script language="javascript" src="popup_win.js"></script>
<script language="javascript" src="js/date.js"></script>
<script language="javascript">

	var NIS_exrate = <?php echo NIS_EXRATE ?>;
	var USD_exrate = <?php echo USD_EXRATE ?>;
	var EUR_exrate = <?php echo EUR_EXRATE ?>;

	var selectedCharityCountry='<?php echo trim($RemoteCharityCountry) ?>';
	var donationPurpose='';


	function DoCharitySearch() {
			var charity = document.editor.charity_name.value;
			var url = 'search_results.php?doAction=true&searchType=charity&select=true&charity_name='+charity;
			popupWin(url,760,590); //600x400
	}

	function DoCharityChange(){
	
		var charityName=$('#Beneficiary').val();
		$.ajax({
		  dataType:'json',
		  url: 'remote.php?m=getCharityDetail&charityName='+encodeURIComponent(charityName),
		  success: function(data) {
			if(data.found==1){
				$('#charityAddressBox').show();
				$('#charityAddressBoxData').html(data.address);
				$('#charityRemoteID').val(data.remoteCharityID);
				selectedCharityCountry=data.countryName;
			} else
			    $('#charityAddressBox').hide();
		  }
		});

		DoCurrencyList();
	}

	function DoCurrencyList(){
		var charityName=$('#Beneficiary').val();
		$.ajax({
		  url: 'remote.php?m=getCurrencyCodes&charityName='+encodeURIComponent(charityName),
		  success: function(data) {
			if(data=='')
			    $('#Currency').html('<option value="GBP">GBP</option>');
			else
			    $('#Currency').html(data);
		  }
		});
	}

	function monthDiff(d1, d2) {
		var months;
		months = (d2.getFullYear() - d1.getFullYear()) * 12;
		months -= d1.getMonth() ;//+ 1;
		months += d2.getMonth();
		return months <= 0 ? 0 : months;
	}
	
	function TestNumber(amount){
		if(isNaN(amount)) return false;
		
		var arr = amount.split('.');		
		
		if(arr.length==2) {
			var length = arr[1].length;
	
		
			if (length > 2) return false;
		}
		
		return true;
	}

	function Validate(form) {
		
		var balance = '<?php echo trim($balance); ?>';
		if(!form.elements['fields[Amount]']) return true;

		var so = ($('#StandingOrderType').val() != 'No');

		var currency = $('#Currency').val();

		var amount = form.elements['fields[Amount]'].value;
		
		if (!TestNumber(amount)) {
			alert('Amount should be a number without any formatting, e.g. 200 or 200.99');
			return false;		
		}

		var neg = parseFloat(amount)<0;

		var gbpamount = amount;

		var beneficiary = $('#Beneficiary').val();

		console.log(1);

		if(beneficiary=='' || beneficiary =='Please select charity from list') {
			alert('Please select a Beneficiary');
			return false;
		}

		if(amount=='' || amount==0) {
			alert('Please complete all fields');
			return false;
		} else if (isNaN(amount)) {
			alert('Amount must be a number');
			return false;
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
		
		if(!currencyWarningShown) {
			if(selectedCharityCountry == 'ISRAEL') {
				$( "#dialog .message" ).html( 'Please note '+"\u00a3"+'4 will be deducted for bank charges' );
				$( "#dialog" ).dialog( "open" );
				return false;
			} else if(selectedCharityCountry == 'USA') {
				$( "#dialog .message" ).html( 'Please note '+"\u00a3"+'15 will be deducted for bank charges' );
				$( "#dialog" ).dialog( "open" );
				return false;	
			} else if(selectedCharityCountry == 'FRANCE' || selectedCharityCountry == 'GERMANY' || selectedCharityCountry == 'BELGIUM' || selectedCharityCountry == 'ITALY') {
				$( "#dialog .message" ).html( 'Please note '+"\u00a3"+'5 will be deducted for bank charges' );
				$( "#dialog" ).dialog( "open" );
				return false;			
			}		
		}
		
				//console.log(3);

				gbpamount = parseFloat(gbpamount);
				amount = parseFloat(amount);
		
		var donationPurposeDef = $('#donationPurpose').val();			
		$('#donationPurpose').val('');				
			
		if(gbpamount >=5000 && gbpamount <= 14999) {
			alert('All donations are subject to compliance checks. Given the size of this donation, it is more likely to be selected for a random check. Please be aware that our Compliance Officer may be in touch with you to determine more information about this donation');
		} else if (gbpamount >= 15000) {
			donationPurpose = prompt('In view of the amount you wish to donate and to comply with money laundering regulations, this donation will also be eligible for random checks by our Compliance Officer. Please provide us a few sentences to outline the purpose of the donation to determine if we need to be in touch for more information.',donationPurpose);
			var confirmAmount = prompt('For your own safety please re-enter the amount you wish to donate:');
			if(confirmAmount==null) return false;
			confirmAmount = parseFloat(confirmAmount);
			if(confirmAmount != amount) {
				alert('The amount entered does not match the origional value, please check');
				return false;
			}
			$('#donationPurpose').val(donationPurpose);
		}	
					

		//console.log(selectedCharityCountry);
		
		if(  		($('#ClientComments').val().toLowerCase().indexOf("raffle",0)>-1) ||
					($('#OfficeComments').val().toLowerCase().indexOf("raffle",0)>-1) ||
					($('#UserComments').val().toLowerCase().indexOf("raffle",0)>-1)
				){
			alert('You cannot pay for raffles with AAC funds');
			return false;
		} else if(  ($('#ClientComments').val().toLowerCase().indexOf("fees",0)>-1) ||
					($('#OfficeComments').val().toLowerCase().indexOf("fees",0)>-1) ||
					($('#UserComments').val().toLowerCase().indexOf("fees",0)>-1)
				){
			alert('You cannot pay for fees with AAC funds');
			return false;		
		} else if(  ($('#ClientComments').val().toLowerCase().indexOf("invoice",0)>-1) ||
					($('#OfficeComments').val().toLowerCase().indexOf("invoice",0)>-1) ||
					($('#UserComments').val().toLowerCase().indexOf("invoice",0)>-1)
				){
			alert('You cannot pay for invoices with AAC funds');
			return false;			
		} else if (!so && !neg && (parseFloat(gbpamount)<10) && (selectedCharityCountry == 'UK')) {
			alert('Sorry, this system can only be used to transfer '+"\u00a3"+'10 or more - please try again');
			return false;
		//} else if (so && (currency != 'GBP')) {
		} else if (so && (selectedCharityCountry != 'UK') && (selectedCharityCountry != 'ISRAEL')) {
			//alert('Standing Orders can be only in Sterling, please respecify in GBP');
			alert('Sorry, standing orders can only be to UK or Israeli charities');
			return false;
		} else if ((selectedCharityCountry != 'UK') && (parseFloat(gbpamount)<50)) {
			alert('Sorry, transfers to charities abroad must be '+"\u00a3"+'50 or more');
			return false;
		} else if (so && !neg && (parseFloat(gbpamount)<10)) {
			alert('Sorry, this system can only be used to transfer '+"\u00a3"+'10 or more - please try again');
			return false;
		} else if (neg && (parseFloat(gbpamount) >= -18) && (parseFloat(gbpamount) < 0) ) {
			alert('Sorry, this system can only be used to transfer '+"\u00a3"+'18 or more- please try again');
			return false;
		} else if (!form.ConfirmTransfer.checked) {
			alert('Please confirm the transaction is charitable');
			return false;
		} else if(!so && (balance !='' && (parseFloat(gbpamount) > parseFloat(balance) ))) {
			if(!confirm('Your account balance is insufficient for this transaction, would you like to proceed?')) return false;
		} else if (so && (currency != 'GBP') ) {
			alert('Sorry, standing orders can only be requested in Pounds (sterling) - please alter the currency selection or remove the Standing Order option');
			return false;
		} else if($('#StandingOrderType').val()=='Continuous payments' && !$('#StandingOrderStartDateContinuous').val()) {
			alert('Please specify the standing order date.');
			return false;
		} else if($('#StandingOrderType').val()=='Fixed number of payments') {//Repeat Payments
			if(!$('#StandingOrderStartDate').val()){
				alert('Please specify the standing order date.');
				return false;
			} else if(!$('#StandingOrderNumPayments').val()){
				alert('Please specify how many payments.');
				return false;
			} else if(!$('#StandingOrderFrequency').val()){
				alert('Please specify the payment interval.');
				return false;
			}

		/**
		} else if($('#StandingOrderFrequency').val()!='No' && !$('#StandingOrderStartDate').val()) {
			alert('Please specify a standing order start date.');
			return false;
		} else if($('#StandingOrderFrequency').val()!='No' && !$('#StandingOrderEndDate').val()) {
			if(!confirm('Is this a continuous standing order?  if not, please click cancel and enter an end date')) return false;
		**/
		}

		/**
		if(so) {

			var ms_fd = Date.parse('1 '+$('#StandingOrderStartDate').val());
			var fd = new Date(ms_fd);

			if($('#StandingOrderEndDate').val()){
				var td = new Date(Date.parse('1 '+$('#StandingOrderEndDate').val()));

				var months = monthDiff(fd,td)+1;

				if(!confirm('Please note that your standing order will run for '+months+' months, click cancel to change')) return false;
			}

		}
		**/

		return confirm('Would you like to save this request - please note requests cannot be edited'+"\n\n"+'Click OK to proceed or Cancel to edit');
	}

	function UpdateStandingOrderContinuousCaption() {
			var startdate = '1 '+$('#StandingOrderStartDateContinuous').val();
			var payint = $('#StandingOrderFrequencyContinuous').val();

			if (payint=='' || startdate=='') return;

			$('#StandingOrderEndDate').val('');

			var monthPeriod = payint.replace('Monthly','months');
			if(monthPeriod == 'months') monthPeriod = 'month';

			var d = new Date(startdate);

			$('#StandingOrderInfoContinuous').show();
			$('#StandingOrderInfoContinuous').html('Every '+monthPeriod+' from '+d.toDateString()+', continuously ');
	}

	function UpdateStandingOrderFixedCaption() {

			var numpay = parseInt($('#StandingOrderNumPayments').val());
			var startdate = '1 '+$('#StandingOrderStartDate').val();
			var payint = $('#StandingOrderFrequency').val();

			if(numpay<=1) {
				alert('Standing orders must be for at least 2 payments');
				return;
			}

			if(numpay>1) numpay = numpay-1;

			if(numpay == 'NaN' || isNaN(numpay) || numpay==0) numpay = '';

			if (payint=='' || numpay=='' || startdate=='') return;

			//alert(numpay);

			var monthInc;
			var months;

			if(payint=='Monthly') monthInc=1;
			else if(payint=='2 Monthly') monthInc=2;
			else if(payint=='3 Monthly') monthInc=3;

			var monthPeriod = payint.replace('Monthly','months');
			if(monthPeriod == 'months') monthPeriod = 'month';

			//alert(payint);

			//console.log(payint);
			//console.log(monthInc);

			months = (numpay * monthInc);
			//console.log(months);
			//alert(startdate);
			//var d = new Date('01 '+startdate);
//console.log(startdate);
			var sd = new Date(startdate);
			var d = new Date(startdate);
			var endDate = d.add(months).month();
			//alert(endDate.toDateString());
			$('#StandingOrderInfo').show();
			$('#StandingOrderInfo').html('Every '+monthPeriod+' from '+sd.toDateString()+' until '+endDate.toDateString());
			$('#StandingOrderEndDate').val(endDate.getTime()/1000);

			return;
			if($('#StandingOrderStartDate').val() ==''){
				$('#StandingOrderInfo').hide();
				return;
			}

			//var ms_fd = Date.parse('1 '+$('#StandingOrderStartDate').val());
			var ms_fd = Date.parse($('#StandingOrderStartDate').val());
			if(!ms_fd) {
				$('#StandingOrderInfo').hide();
				return;
			}
			var fd = new Date(ms_fd);

			if($('#StandingOrderEndDate').val()){
				//var td = new Date(Date.parse('1 '+$('#StandingOrderEndDate').val()));
				var td = new Date(Date.parse($('#StandingOrderEndDate').val()));

				var months = monthDiff(fd,td)+1;

				$('#StandingOrderInfo').html(''+months+' month'+(months>1?'s':''));
			}  else {
				$('#StandingOrderInfo').html('Continuous payment');
			}

			$('#StandingOrderInfo').show();
	}

	$(document).ready(function(){


		$('.VoucherBooks').live('blur change keyup',function(){
			var total = 0;

			$('.VoucherBooks').each(function(){
//console.log($(this).val());

				var intRegex = /^\d+$/;

				if(intRegex.test($(this).val())) {
					total += parseInt($(this).val())  ;
				}
				if(total>2) {
					$('#Post').attr('disabled',true);
					$('#Post').attr('checked',false);
				} else {
					$('#Post').attr('disabled',false);
				}
			});
		});

		$('#Amount, #Currency').live('blur change keyup',function(){

			var amount = $('#Amount').val();
			var currency = $('#Currency').val();
			var gbpAmount=0;

			//console.log(amount);
			//console.log(currency);
			//console.log(EUR_exrate);

			if(currency=='GBP' || !currency || !amount){
				$('#gbpAmountBox').hide();
				return false;
			} else if(currency=='EUR') {
				gbpAmount = amount / EUR_exrate;
			} else if(currency=='USD') {
				gbpAmount = amount / USD_exrate;
			} else if(currency=='NIS') {
				gbpAmount = amount / NIS_exrate;
			}

			$('#gbpAmountBoxData').html('Approximately &pound;'+gbpAmount.toFixed(2)+' GBP');
			$('#gbpAmountBox').show();




		});

		$('.autocomplete-charities').autocomplete({
			source: 'remote.php?m=getCharityList',
			resultTextLocator:'label',
			select: function(event, ui){
				event.preventDefault();
				$('#Beneficiary').val(ui.item.name);
				$('.autocomplete-charities').val(ui.item.name);

				if(ui.item.address!=''){
					$('#charityAddressBox').show();
					$('#charityAddressBoxData').html(ui.item.address);
				} else
					$('#charityAddressBox').hide();

				DoCharityChange();
			}
		});

		$('#StandingOrderStartDateContinuous,.so-repeat').blur(function(){
			UpdateStandingOrderFixedCaption();
		});
		$('.so-repeat').change(function(){
			UpdateStandingOrderFixedCaption();
		});

		$('#StandingOrderStartDate,#StandingOrderEndDate,.so-continuous').blur(function(){
			UpdateStandingOrderContinuousCaption();
		});
		$('.so-continuous').change(function(){
			UpdateStandingOrderContinuousCaption();
		});


		$('#StandingOrderType').change(function(){
			var v = $(this).val();

			$('.soRows').hide();

			if(v=='No') {

			} else if(v=='Fixed number of payments'){
				$('#StandingOrderDatesFixed').show();
			} else if(v=='Continuous payments'){//Repeat Payments
				$('#StandingOrderDatesContinuous').show();
				UpdateStandingOrderContinuousCaption();
			}
		});
		
		DoCharityChange();

	});

	function UpdateForm() {
		var r = $('#Request').val();
		window.location.href='aac_requests_editor.php?Request='+r;
	}

	function UpdateCharity(id) {
		$('#Beneficiary').val(id);
		//DoCurrencyList();
		DoCharityChange();
	}
	<?php if(time()<mktime(0,0,0,3,18,2015)){ ?>
		$(document).ready(function(){
			$('input[name="fields[VoucherBookDelivery]"]').click(function(){
				if($(this).val()=='Post') alert('Please note that until  Purim there is a '+"\u00a3"+'2 delivery charge');
			});
		});
	<?php }	?>
</script>

<style>
	.white {
		background-color:#ffffff;
	}
</style>

<table align="center" width="100%"><tr><td>
<div style="text-align:left">
<?php if($_REQUEST['done']) { ?>
	<p class="blue-text">Your request has been sent.  <a href="aac_requests.php">Return to request history</a></p>
	<div style="height:150px"></div>
<?php } else { ?>
<?php if(!$id) { ?>
<p>Please enter the details of the request you wish to make:<br/>
</p>
<?php } ?>

                <?php
                  $alert = GetVal('alert');
				  $pend  = GetVal('pend');
				  $below  = GetVal('below');

				  if($alert){
						?>
		                  <div style="padding-top:10px;padding-bottom:10px" >

		                    <span class="title2" style="color:#00ff00;font-weight:bold"><?php echo $alert ?></span>

		                  <//div>
						<?php
				  }

				  if($pend){
						?>
		                  <div style="padding-top:10px;padding-bottom:10px" >

		                    <span class="title2" style="color:#0000ff;font-weight:bold"><?php echo $pend ?></span>

		                  </div>
						<?php
				  }


				  if($below){
						?>
		                  <div style="padding-top:10px;padding-bottom:10px" >

		                    <span class="title2" style="color:#ff0000;font-weight:bold"><?php echo $below ?></span>

		                  </div>
						<?php
				  }

                  ?>


                  <?php
                  if(file_exists('records/notes.htm')) {
                  ?>
                  <div>
                    <span class="red-title1" style="font-size:8pt"><?php include 'records/notes.htm'; ?></span>
                  </div>
                  <?php
                  }
                  ?>

<table cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="10" valign="top" class="title2"><img src="images/sp.gif" width="1" height="10" /></td>
                  </tr>
                  <tr>
                    <td valign="top">&nbsp;</td>
                  </tr>
                      <tr>
                        <td width="684" valign="top"><img src="images/list-top.jpg" width="684" height="11" /></td>
                      </tr>
                      <tr>
                        <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td valign="top" bgcolor="#ffffff" >
                            <form name="editor" id="editor" method="POST" action="<?php echo basename($_SERVER['PHP_SELF']) ?>" ><!--onsubmit="return Validate(this)"-->
                            <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="transfer-req blue-text" >
	                        <?php
	                          	$u = new UIFormFields();
	                           	$u->fields = $fields;
	                           	$u->readOnly = $id?true:false;
	                        ?>
							<?php if($error) { ?>
							<tr>
								<td class="error" colspan="2" style="padding-bottom:10px;text-align:center"><?php echo $error ?></td>
							</tr>
							<?php } ?>
	                        <?php if($id) { ?>
							<tr>
								<td class="caption">Request ID</td>
								<td class="value"><?php echo $request->id ?></td>
							</tr>
							<tr>
								<td class="caption">Request Date</td>
								<td class="value"><?php echo $request->FormatRequestDateTime() ?></td>
							</tr>
							<tr>
								<td class="caption">Result code</td>
								<td class="value"><?php echo $request->ResultCode ?></td>
							</tr>
							<tr>
								<td class="caption">Date Last Action</td>
								<td class="value"><?php echo $request->FormatModifiedDate() ?></td>
							</tr>
							<tr>
								<td colspan="2">&nbsp;</td>
							</tr>
							<?php } ?>
							<tr>
								<td class="caption">Balance</td>
								<td class="value"><?php echo number_format($balance,2).($balance<0?' <b style="color:#ff0000">OVERDRAWN</b>':'') ?></td>
							</tr>
							<tr>
								<td class="caption">Request</td>
								<td class="value"><?php
										$requests = array(
											'New Voucher Book'=>'Order new voucher books',
											'Transfer Notification'=>'Notify us of a transfer paid into the account',
											'Initiate Transfer'=>'Initiate transfer and Standing Order',
											'General Message'=>'Send general message',
											'Bank Details Request'=>'What are Achisomoch bank details for a transfer'
										);
										if(!in_array($fields['Request'],array_keys($requests))) $requests[$fields['Request']] = $fields['Request'];

										//echo $id?$requests[$fields['Request']]:$u->MakeComboBox('Request',$requests,'','fields','',' id="Request" onchange="UpdateForm()" ',true);
										echo $requests[$fields['Request']]."<input type=\"hidden\" name=\"fields[Request]\" value=\"{$fields['Request']}\">";
//$u->MakeComboBox('Request',$requests,'','fields','',' id="Request" onchange="UpdateForm()" ',true);
								?></td>
							</tr>
                            <?php if(in_array('BankDetailsField',$field_list)) { ?>
							<tr>
								<td colspan="2" ><br><br>
	                            <?php include 'inc/achisomoch_details.inc.php'; ?>
								</td>
							</tr>
                            <?php } else { ?>
								<?php if(in_array('BeneficiaryField',$field_list)) { ?>
								<tr>
									<td class="caption">Beneficiary</td>
									<td class="value"><?php
											$cl = new CharityList();
											$charities = $cl->ListItems();
											if(count($charities)) {
												//foreach($charities as $c) $options[$c->Name] = $c->Name;
												//echo $u->MakeComboBox('Beneficiary',$options,'','fields','',' id="Beneficiary" onchange="DoCharityChange()" ');


												//useKeys means that array key is the value
												$select = "<select id=\"Beneficiary\" name=\"fields[Beneficiary]\" onchange=\"DoCharityChange()\">";
												//if(!$required) $select .= '<option value=""></option>';

												if(count($charities)) {
													foreach($charities as $c) {
														$style = $c->RedFlag?'color:#ff0000':'';
														$select .= "<option style=\"".$style."\" value=\"$c->Name\" ".($c->Name==$fields['Beneficiary']?' SELECTED ':'').">$c->Name</option>";
													}
												}
												$select .= '</select>';

												echo $id?$fields['Beneficiary']:$select;
											}
									?></td>
								</tr>
								<?php if(!$id) { ?>
								<tr>
									<td class="caption" align="right" style="padding-right:5px;">or Search by name, address or charity number</td>
									<td class="value"><?php
											echo $u->MakeTextBox('charity_name','','','autocomplete-charities');
											echo '&nbsp;<a href="javascript:DoCharitySearch()">Search</a>';
									?></td>
								</tr>
								<?php } ?>
								<tr style="display:none;color:#ff0000" id="charityAddressBox">
									<td class="caption">&nbsp;</td>
									<td class="value" id="charityAddressBoxData" style="padding-bottom:10px;"></td>
								</tr>
								<?php } ?>
								<?php if(in_array('VoucherBookField',$field_list)) { ?>
								<tr>
									<td class="caption" valign="top">Voucher Book</td>
									<?php
					$pound = iconv("ISO-8859-1", "UTF-8", "£");
										$voucher_options = array(
/**
											'Prepaid 50p vouchers (100 vouchers)'=>'Prepaid 50p vouchers (100 vouchers)',
											'Prepaid 1 Pound  voucher (50 vouchers)'=>'Prepaid &pound;1 voucher (50 vouchers)',
											'Pre-printed 3 Pound voucher book'=>'Pre-printed &pound;3 voucher book',
											'Pre-printed 5 Pound voucher book'=>'Pre-printed &pound;5 voucher book',
											'Pre-printed 10 Pound voucher book'=>'Pre-printed &pound;10 voucher book',
											'Pre-printed 18 Pound voucher book'=>'Pre-printed &pound;18 voucher book',

											'Pre-printed 25 Pound voucher book'=>'Pre-printed &pound;25 voucher book',
											'Pre-printed 36 Pound voucher book'=>'Pre-printed &pound;36 voucher book',
											'Pre-printed 50 Pound voucher book'=>'Pre-printed &pound;50 voucher book',
											'Blank voucher book'=>'Blank voucher book'
**/


											'50p'=>'Prepaid 50p vouchers (100 vouchers)',
											'&pound;1'=>'Prepaid &pound;1 voucher (50 vouchers)',
											'&pound;3'=>'Pre-printed &pound;3 voucher book',
											'&pound;5'=>'Pre-printed &pound;5 voucher book',
											'&pound;10'=>'Pre-printed &pound;10 voucher book',
											'&pound;18'=>'Pre-printed &pound;18 voucher book',

											'&pound;25'=>'Pre-printed &pound;25 voucher book',
											'&pound;36'=>'Pre-printed &pound;36 voucher book',
											'&pound;50'=>'Pre-printed &pound;50 voucher book',
											'&pound;100'=>'Pre-printed &pound;100 voucher book',

											'Blank'=>'Blank voucher book'
										);
										$vouchers = is_array($fields['VoucherBooks'])?$fields['VoucherBooks']:explode("\n",$fields['VoucherBooks']);

										if(!is_array($fields['VoucherBooks'])) {
											$fields['VoucherBooks'] = explode("; ",$fields['VoucherBooks']);
											if(count($fields['VoucherBooks'])) {
												$vb = array();
												foreach($fields['VoucherBooks'] as $k=>$v) {
													$bit = explode("x",$v);
													$vb[$bit[1]] = $bit[0];
												}
												$fields['VoucherBooks'] = $vb;
											}
										}
									?>
									<td class="value"><?php
										//echo $id?nl2br($request->VoucherBooks):$u->MakeListBox('VoucherBooks',$voucher_options,$vouchers,'fields','transfer-req',100);

										if($id) {
											echo nl2br(htmlentities($request->VoucherBooks));
										} else {

//this is a bit of a fudge fix for UTF-8 encoding problem with £ signs
$tmp = array();
foreach($fields['VoucherBooks'] as $k=>$v)$tmp[str_replace('&Acirc;','',htmlentities($k))]=$v;

											$listbox = "<div class=\"listbox\" style=\"height:100;overflow:auto;border:1px solid #7F9DB9;padding:5px\">";
											if(count($voucher_options)) {
												foreach($voucher_options as $val=>$opt) {
													//$val = htmlentities($val);

													//$v = $fields['VoucherBooks'][$val]?$fields['VoucherBooks'][$val]:0;
													$v = $tmp[$val]?$tmp[$val]:0;
													$listbox .= "<input type=\"text\" size=\"1\" name=\"fields[VoucherBooks][$val]\" value=\"$v\" style=\"margin-bottom:3px\" class=\"VoucherBooks\" /> $opt<br/>";
												}
											}
											$listbox .= '</div>';
											echo $listbox;
										}

									?></td>
								</tr>
								<tr>
									<td class="caption" valign="top">Delivery</td>
									<?php
										$options = array(
											/**
											'Post'=>'Post',
											'Pick up from office'=>'I will pick up from your office',
											'Special Delivery'=>'Special Delivery (&pound;5)'
											**/
											'Post'=>'<b>Post:</b> Up to two books  (I take responsibility for any 50p/&pound;1 PPV books lost in the post)<br/>',
											'Pick up from office'=>'<b>Office Collection:</b> 9.30am - 3.30pm Mon-Thurs<br/>',
											'Special Delivery'=>'<b>Special Delivery:</b> At a cost of &pound;5 to be deducted from my account<br/>',
											//'Purim order'=>'<font color="#ff0000"><b>Purim order:</b> Free Purim delivery (orders will be delivered Purim week)</font><br/>'
										);
										if(time()<mktime(0,0,0,3,17,2014))$options['Post'] = "Post at a cost of &pound;2";
									?>
									<td class="value"><?php
											//echo $u->MakeRadioGroup('VoucherBookDelivery',$options,null,'fields','transfer-req');
											foreach($options as $k=>$v) {
												echo "<input type=\"radio\" id=\"".str_replace(' ','',$k)."\" name=\"fields[VoucherBookDelivery]\" value=\"$k\" ".($k==$fields['VoucherBookDelivery']?' checked ':'').">$v</br>";
											}
									?></td>
								</tr>
								<?php if(is_file('records/vb.htm')) { ?>
								<tr>
									<td class="caption" valign="top">&nbsp;</td>
									<td class="caption" colspan="2"><?php include 'records/vb.htm' ?></td>
								</tr>
								<?php } ?>
<!--
								<tr>
									<td class="caption" valign="top">&nbsp;</td>
									<td class="caption" colspan="2" style="color:#ff0000">Please note that orders are no longer being accepted for Purim.<br><br></td>
								</tr>
-->
								<tr>
									<td class="caption">This is urgent</td>
									<td class="value"><?php echo $u->MakeCheckbox('VoucherBookUrgent','','fields','transfer-req','Yes',' style="width:15px" '); ?></td>
								</tr>
								<?php } ?>
								<?php if(in_array('BankAccountField',$field_list)) { ?>
								<tr>
									<td class="caption">Bank Account</td>
									<td class="value"><?php echo $id?$request->BankAccount:$u->MakeTextBox('BankAccount','','fields','transfer-req'); ?></td>
								</tr>
								<?php } ?>
								<?php if(in_array('AmountField',$field_list)) { ?>
									<?php if(!$id) { ?>
									<tr>
										<td class="caption">&nbsp;</td>
										<td class="value red">Please note: Achisomoch carries out random checks on the charitable status of the organisations mentioned on this list, However no guarantee is  implied that all charities mentioned on this list are bona-fide</td>
									</tr>
									<?php } ?>
								<tr>
									<td class="caption">Amount</td>
									<td class="value"><?php echo $id?number_format($request->Amount,2):$u->MakeTextBox('Amount','','fields','transfer-req',' id="Amount" '); ?>
									<?php
									//$options = array('GBP','Shekels','Dollars','Euros');
									$options = array();
									if($request->id) {
										$beneficiary = $request->Beneficiary;
									} else if(is_array($charities)) {
										$c = reset($charities);
										$beneficiary = $c->Name;
									} else $beneficiary='';

									if($beneficiary) {
										$ccl = new CharityCurrencyList();
										$ccl_items = $ccl->GetCurrencyCodesByCurrencyName($beneficiary);
										if(count($ccl_items)) foreach($ccl_items as $i) $options[] = $i->CurrencyCode;
									} else {
										$options[] = 'GBP';
									}
									?>
									<?php echo $id?$request->Currency:$u->MakeComboBox('Currency',$options,'','fields','transfer-req','  '); ?>
									</td>
								</tr>
									<?php if(!$id) { ?>
									<tr>
										<td class="caption">&nbsp;</td>
										<td class="value red">Please note: Payments for under &pound;100 may take longer to process</td>
									</tr>
									<?php } ?>
								<tr style="display:none;color:#ff0000" id="gbpAmountBox">
									<td class="caption">&nbsp;</td>
									<td class="value" id="gbpAmountBoxData" style="padding-bottom:10px;"></td>
								</tr>
								<?php } ?>
								<?php if($dontShow && !$id && ($fields['Request']=='Initiate Transfer') ) { ?>
								<tr>
									<td class="caption" valign="top">Reference</td>
									<td class="value"><?php echo $u->MakeTextBox('Reference','','fields','transfer-req',' id="Reference" ') ?></td>
								</tr>
								<?php } ?>
								<?php /**
								<tr>
									<td class="caption" valign="top">Additional Comments</td>
									<td class="value"><?php echo $u->MakeTextArea('ClientComments','','fields','transfer-req',' id="ClientComments" ') ?></td>
								</tr>
								 **/ ?>
								 <?php if($fields['Request']=='Initiate Transfer' ) { ?>
								<tr>
									<td class="caption" valign="top">Notes to Charity</td>
									<td class="value"><?php echo $u->MakeTextArea('ClientComments','','fields','transfer-req',' id="ClientComments" ') ?></td>
								</tr>
								<?php } ?>
								<tr>
									<td class="caption" valign="top">Notes to AAC</td>
									<td class="value"><?php echo $u->MakeTextArea('OfficeComments','','fields','transfer-req',' id="OfficeComments" ') ?></td>
								</tr>
								 <?php if($fields['Request']=='Initiate Transfer' ) { ?>
								<tr>
									<td class="caption" valign="top">Notes to Self</td>
									<td class="value"><?php echo $u->MakeTextArea('UserComments','','fields','transfer-req',' id="UserComments" ') ?></td>
								</tr>
								<?php } ?>								
								<?php if($fields['Request']=='General Message') { ?>
								<tr>
									<td class="caption" valign="top">Bank Details</td>
									<td class="value">
Achisomoch Aid Co. Ltd.<br/>
Sort Code 20-29-37<br/>
Account no 2033 2003<br/>
<b>Please mention your client number as the reference.</b>
									</td>
								</tr>
								<?php } ?>
								<?php if($fields['Request']=='Initiate Transfer') { ?>
								<tr>
									<td class="caption" valign="top">Standing order</td>
									<?php
									//$options = array('No','Monthly','2 Monthly','3 Monthly');
									//$options = array('No','Single Payment','Repeat Payments');
									//$options = array('No','Yes');
									$options = array('No','Fixed number of payments','Continuous payments');

									if($id) {
										if($request->StandingOrderFrequency=='No')
											$standingOrderType = 'No';
										else if (!$request->FormatStandingOrderEndDate())
											$standingOrderType = 'Single Payment';
										else
											$standingOrderType = 'Repeat Payments';
									}


									?>
									<td class="value">
									<?php echo $id?$standingOrderType:$u->MakeComboBox('StandingOrderType',$options,'','fields','transfer-req',' id="StandingOrderType" '); ?>
									</td>
								</tr>

								<?php
								if(!$id) {
								?>
								<tr id="StandingOrderDatesContinuous" class="soRows" style="display:<?php echo ($fields['StandingOrderFrequency'] && $fields['StandingOrderFrequency']!='No')?'':'none' ?>">
									<td class="caption" valign="top">&nbsp;</td>
									<td class="value"><table><?php
									echo '<tr><td>Starting:</td><td>';
									//echo $id?$request->FormatStandingOrderStartDate():$u->MakeTextBox('StandingOrderStartDateContinuous',$request->StandingOrderStartDate,'fields','so-continuous sodate datepicker',' id="StandingOrderStartDateContinuous" ');

									$options = array(date('Y-m-1')=>date('M Y'));
									for($i=1;$i<=3;$i++) {
										$t = strtotime("+{$i} months");
										$options[date('Y-m-1',$t)] = date('M Y',$t);
									}

									echo $id?$request->FormatStandingOrderStartDate():$u->MakeComboBox('StandingOrderStartDateContinuous',$options,$request->StandingOrderStartDate,'fields','so-continuous sodate ',' id="StandingOrderStartDateContinuous" ');
									echo '</td></tr>';
									echo '<tr><td>Payment Interval:</td><td>';
									$options = array('Monthly','2 Monthly','3 Monthly');
									echo $id?$request->StandingOrderFrequency:$u->MakeComboBox('StandingOrderFrequencyContinuous',$options,'','fields','so-continuous sodate ',' id="StandingOrderPaymentIntervalContinuous" ');
									echo '</td></tr>';
									echo '<tr><td colspan="2">';
									echo '<div id="StandingOrderInfoContinuous" class="" style="display:none;color:#ff0000"></div>';
									echo '</td></tr>';
									?>
									</table></td>
								</tr>

								<tr id="StandingOrderDatesFixed" class="soRows" style="display:<?php echo ($fields['StandingOrderFrequency'] && $fields['StandingOrderFrequency']!='No')?'':'none' ?>">
									<td class="caption" valign="top">&nbsp;</td>
									<td class="value">
									<?php
									if(!$id) {
										echo '<table>';
										echo '<tr><td>Number of payments:</td><td>';
										echo $id?$request->FormatStandingOrderEndDate():$u->MakeTextBox('NumPayments',$request->StandingOrderEndDate,'fields','so-repeat sodate',' style="width:30px" id="StandingOrderNumPayments"');
										echo '</td></tr>';
										echo '<tr><td>Starting from:</td><td>';
										//echo $id?$request->FormatStandingOrderStartDate():$u->MakeTextBox('StandingOrderStartDate',$request->StandingOrderStartDate,'fields','so-repeat sodate datepicker',' id="StandingOrderStartDate" ');

									$options = array(date('Y-m-1')=>date('M Y'));
									for($i=1;$i<=3;$i++) {
										$t = strtotime("+{$i} months",strtotime(date('Y-m-1')));
										$options[date('Y-m-1',$t)] = date('M Y',$t);
									}

									echo $id?$request->FormatStandingOrderStartDate():$u->MakeComboBox('StandingOrderStartDate',$options,$request->StandingOrderStartDate,'fields','so-repeat sodate ',' id="StandingOrderStartDate" ');

										echo '</td></tr>';
										echo '<tr><td>Payment Interval:</td><td>';
										$options = array('Monthly','2 Monthly','3 Monthly');
										echo $id?$request->StandingOrderFrequency:$u->MakeComboBox('StandingOrderFrequency',$options,'','fields','so-repeat sodate ',' id="StandingOrderPaymentInterval" ');

										echo '</td></tr>';
										echo '<tr><td colspan="2">';
										echo '<div id="StandingOrderInfo" class="" style="display:none;color:#ff0000"></div>';
										echo '<input type="hidden" id="StandingOrderEndDate" name="fields[StandingOrderEndDate]" value="" />';
										echo '</td></tr>';
										echo '</table>';
									} else {
										echo '<div  class="" style="display:none;color:#ff0000">'.$request->FormatStandingOrderEndDate().'</div>';
									}
									?>
									</td>
								</tr>
								<?php } else { ?>
								<tr  style="display:<?php echo ($fields['StandingOrderFrequency'] && $fields['StandingOrderFrequency']!='No')?'':'none' ?>">
									<td class="caption" valign="top">&nbsp;</td>
									<td class="value">
										<div  class="" style="color:#ff0000">
											<?php
												$monthPeriod = str_replace('Monthly','months',$request->StandingOrderFrequency);
												if($monthPeriod == 'months') $monthPeriod = 'month';

												if(!$request->FormatStandingOrderEndDate()) {
													echo "Every $monthPeriod from ".$request->FormatStandingOrderStartDate().", continuously";
												} else {
													echo "Every $monthPeriod from ".$request->FormatStandingOrderStartDate()." until ".$request->FormatStandingOrderEndDate();
												}
											?>
											</div>
									</td>
								</tr>
								<?php } ?>

								<?php } ?>
								<?php if(!$id && ($fields['Request']=='Initiate Transfer')) { ?>
								<tr>
									<td>&nbsp;</td>
									<td colspan="1">
									<input type="checkbox" name="ConfirmTransfer" value="1" /> I confirm that this donation is for charitable purposes only, I will not benefit directly or indirectly by way of goods or services from the donation
									</td>
								</tr>
								<?php } ?>
								<?php if($id) { ?>
								<!--
								<tr>
									<td class="caption" valign="top">Office Comments</td>
									<td class="value"><?php echo $request->FormatOfficeComments() ?></td>
								</tr>
								-->
								<?php } else { ?>
								<tr>
									<td>&nbsp;</td>
									<td colspan="1" align="left"><input id="send" type="submit" value="Send" style="width:280px"></td>
								</tr>
								<?php } ?>
							<?php } // end of bank details (no form)?>
							<tr>
								<td colspan="2" style="height:30px">&nbsp;</td>
							</tr>

                            </table>
                            <input type="hidden" name="doAction" value="save" />
                            <input type="hidden" name="charityRemoteID" value="<?php echo $fields['RemoteCharityID'] ?>" id="charityRemoteID" />

							<?php if($_REQUEST['doAction']=='clone') { ?>
                            <input type="hidden" name="clone" value="1" />
							<?php } ?>
							<input type="hidden" name="office-comment-option" id="office-comment-option" value="<?php echo $_REQUEST['office-comment-option'] ?>" />
							<input type="hidden" name="donationPurpose" id="donationPurpose" value="<?php echo $_REQUEST['donationPurpose'] ?>" />
							
                            </form>
                            </td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td width="683" height="14" valign="top"><img src="images/list-bottom.jpg" width="684" height="14" /></td>
                      </tr>
                    </table>
</div>
<?php } ?>
</td></tr></table>

  <script>
  
  var currencyWarningShown=false;
  
  $(function() {
    $( "#dialog" ).dialog({autoOpen: false});
	

		$('#dialog input.dialog-option').live('click',function(e){
			//e.preventDefault();
			var o = $(this).val();
			console.log(o);
			$('#office-comment-option').val(o);
		});
		
		$('#editor').submit(function (){return Validate(document.editor)});		
		
		
		$('#dialog input#DialogOK').live('click',function(e){
		
			currencyWarningShown=true;
		
			//console.log('test');
			/**
			if(!$('.dialog-option:checked').val()){
				alert('Please select an option');
				return;
			}
			**/
		
			$('#dialog').dialog('close');
			//if(Validate(document.editor)) $('#editor').submit();		
			$('#editor').submit();		
		});
		
		
		$('#dialog input#DialogCancel').live('click',function(e){
			$('#dialog').dialog('close');
		});		
		
		$('#send').live('click',function(e){
			currencyWarningShown=false;
			$('#office-comment-option').val('');
		});
		
		$('.VoucherBooks').blur(function(){
			var val = $(this).val();
			if(isNaN(val) || Math.floor(val) != val){
				alert('Please enter a valid whole number');
				$(this).val(0);
			}
		});
	
	
  });
  </script>



<div id="dialog">
<p class="message"></p>
<!--
<p>The bank that Achisomoch uses in Jerusalem has increased its charges to &pound;8 for each electronic transfer. We regret that as from Feb 19th we will have to pass this on to our clients. Since there is no charge for cheques, if there is no urgency, we will write/post a cheque to Israel, however this can be very slow. Hopefully this will be temporary as we seek alternative arrangements.</p>
<p>
<input type="radio" class="dialog-option" name="DialogOption" value="Bank Transfer" /> Option 1. &pound;8 bank charge for bank transfer<br/>
<input type="radio" class="dialog-option" name="DialogOption" value="Cheque" /> Option 2. Cheque will be posted from UK  
</p>
-->
<p style="text-align:center">
	<input type="button" value="OK" id="DialogOK" />
	<input type="button" value="CANCEL" id="DialogCancel" />
</p>


</div>

<?php include 'footer.inc.php'; ?>