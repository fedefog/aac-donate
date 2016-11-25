<?php

require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
require_once 'cls/charities.cls.php';
require_once 'cls/aac_requests.cls.php';
require_once 'cls/sendmail.cls.php';
require_once 'cls/class.smtp.php';
require_once 'cls/class.phpmailer.php';
require_once 'cls/emails.cls.php';
require_once 'cls/emaillog.cls.php';
require_once 'inc/funcs.inc.php';




session_start();


//if($m=='agreeTermsAndConditions'){
	User::LoginCheck();
//}



	$user = new User();
	$user = User::GetInstance();


$m = $_REQUEST['m'];

function TestNumber($amount) {
	if(!is_numeric($amount)) return false;

	$arr = explode('.',$amount);

	if(count($amount)>2) return false;

	if(strlen($amount[1])>2) return false;
		
		
		return true;
}

	function HandleResult($errorMessage='',$errorField='',$errorCode='',$errorType='alert'){

		if(!$errorCode) $errorCode =$errorField;



		$result = array(
			'error'=>$errorMessage?1:0,//is an error
			'errorMessage'=>$errorMessage, //message to user,
			'errorCode'=>$errorCode,//error type identifier
			'errorField'=>$errorField,//error fieldidentifier
			'errorType'=>$errorType,//confirm/alert/success
		);
		echo json_encode($result);
		exit;
	}

if($m=='getCurrencyCodes') {

	$charityName = html_entity_decode($_REQUEST['charityName']);

	$ccl = new CharityCurrencyList();

	$currencies = $ccl->GetCurrencyCodesByCurrencyName($charityName);

	$output='';

	if(count($currencies)){
		foreach($currencies as $cc){
			$output .= "<option value=\"{$cc->CurrencyCode}\">{$cc->CurrencyCode}</option>";
		}
	}
	echo $output;
} else if($m=='getCharityList'){
	$term = $_REQUEST['term'];
	$cl = new CharityList();
	$clItems = $cl->ListItems();
	$cl->limit = "limit 20";
	$cl->distinct = true;
	$items = $cl->ListItems(" (`Name` LIKE '%$term%' OR add_1 LIKE '%$term%' OR Postcode LIKE '%$term%'  OR Charity_number LIKE '%$term%' )  ",15);

//	$label = str_replace($label,"<font color=\"#ff0000\">$term</font>",$label);

	foreach($items as $i) {
		$label = $i->Name.' ('.$i->add_1.', '.$i->Charity_number .','.$i->Phone.')';
		//$label = str_ireplace($term,"<b>$term</b>",$label);
		$result[] = array('label'=>$label,'name'=>$i->Name,'itemId'=>$i->id,'address'=>$i->FullAddress(),'CharityNo'=>$i->Charity_number);
	}
	echo json_encode($result);
} else if($m=='getCharityDetail'){
	$charityName = $_REQUEST['charityName'];

	$charity = new CharityItem();
	if($charity->LoadByColumnName($charityName,'Name')) {
		$data['found']=1;
		$data['address'] = $charity->FullAddress();
		$data['countryName'] = $charity->CountryName;
		$data['minimumDonationValue'] = $charity->MinimumDonationValue;
		$data['remoteCharityID'] = $charity->remote_charity_id;
	} else $data = array('found'=>0);

	echo json_encode($data);
} else if($m=='agreeTermsAndConditions'){
	$user =& User::GetInstance();
	if(!$user) die('Error updating T&C');
	$user->TermsAndConditionsAccepted=1;
	$sql = 'UPDATE users SET TermsAndConditionsAccepted=1 WHERE Username="'.$user->Username.'"';
	mysql_query($sql);
	User::LogAccessRequest($user->Username,$_SERVER['REMOTE_ADDR'],"User agreed to Terms & Conditions");

	echo 'Thank you for accepting the Terms and Conditions';
} else if($m=='save-donation'){

	$fields = $_REQUEST['fields'];


///////////////////////////

	$so = false; //need toset
	$currency = $fields['Currency'];

	$amount = $fields['Amount'];

	$neg = floatVal($amount)<0;



	$gbpamount = $amount;

	$beneficiary = $fields['Beneficiary'];

	if($beneficiary=='' || ($beneficiary =='Please select charity from list') ) {
		HandleResult('Please select a Beneficiary','Beneficiary');
	}



	$charityRemoteID = $fields['RemoteCharityID'];
	if(!$charityRemoteID) {
		HandleResult('Problem locating Beneficiary, please re-select them','Beneficiary');
	}

	$charity = new CharityItem();
	if(!$charity->loadByRemoteID($charityRemoteID)) {
		HandleResult('Problem locating Beneficiary, please contact support','Beneficiary');
	}

	if($amount=='' || $amount==0) {
		HandleResult('Please enter an amount','Amount');
	} else if(!TestNumber($amount)) {
		HandleResult('Amount should be a number without any formatting, e.g. 200 or 200.99','Amount');
	} else if (!is_numeric($amount)) {
		HandleResult('Please enter a valid amount','Amount');
	}




	if ($currency=='NIS') $gbpamount = $gbpamount  / NIS_EXRATE;
	else if ($currency=='USD') $gbpamount = $gbpamount  / USD_EXRATE;
	else if ($currency=='EUR') $gbpamount = $gbpamount  / EUR_EXRATE;




	$selectedCharityCountry = strtoupper(trim($charity->CountryName));
	if(!$selectedCharityCountry) $selectedCharityCountry='UK';

	$RemoteCharityCountry=$selectedCharityCountry;


	$currencyWarningShown = $_REQUEST['confirm-bankcharges'];

	if(!$currencyWarningShown) {
			if($selectedCharityCountry == 'ISRAEL') {
				HandleResult( 'Please note &pound;4 will be deducted for bank charges','bankcharges','','confirm');
			} else if(selectedCharityCountry == 'USA') {
				HandleResult( 'Please note &pound;15 will be deducted for bank charges','bankcharges','','confirm');
			} else if(selectedCharityCountry == 'FRANCE' || selectedCharityCountry == 'GERMANY' || selectedCharityCountry == 'BELGIUM' || selectedCharityCountry == 'ITALY') {
				HandleResult( 'Please note &pound;5 will be deducted for bank charges','bankcharges','','confirm');
			}		
	}

		

	$gbpamount = (float)$gbpamount;
	$amount = (float)$amount;

	//legacy from prev developer - need tidy
	$td = new TransactionDetailList();
	$transaction = $td->getTransactionDetailByAccountName($user->Reference);
	foreach ($transaction as $tr) {
	    $balance = $tr->Close_balance;
	}
	$balance = $balance ? $balance : 0;
		

	if($gbpamount >=5000 && $gbpamount <= 14999 && !$_REQUEST['confirm-compliancemed']) {
		HandleResult( 'All donations are subject to compliance checks. Given the size of this donation, it is more likely to be selected for a random check. Please be aware that our Compliance Officer may be in touch with you to determine more information about this donation','compliancemed','compliancemed','confirm');	
	} else if ($gbpamount >= 15000) {
		$donationPurpose = $_REQUEST['donationPurpose'];			
		$confirmAmount = (float)$_REQUEST['confirmAmount'];			

		if (!$donationPurpose) {
			HandleResult( 'In view of the amount you wish to donate and to comply with money laundering regulations, this donation will also be eligible for random checks by our Compliance Officer. Please provide us a few sentences to outline the purpose of the donation to determine if we need to be in touch for more information.','donationPurpose','Compliance');
		}
		if (!$confirmAmount) {
			HandleResult( 'For your own safety please re-enter the amount you wish to donate','confirmAmount','Compliance');
		}
		if ($confirmAmount != $amount) {
			HandleResult( 'The amount entered does not match the origional value, please check','amount_ConfirmAmount','Compliance');
		}
	}	

	$blockedWords = array('raffle'=>'You cannot pay for raffles with AAC funds',
						'fees'=>'You cannot pay for fees with AAC funds',
						'invoice'=>'You cannot pay for invoices with AAC funds'
					);					
	$bwFields = array('ClientComments','OfficeComments','UserComments');

	foreach($blockedWords as $bw=>$msg) {
		foreach($bwFields as $bwf) {
			$data = $fields[$bwf];
			if(strpos(strtolower($data),$bw)!==false) HandleResult($msg,$bwf,'Blocked');
		}
	}

		if(!$so && !$neg && $gbpamount<10 && $selectedCharityCountry=='UK') {
			HandleResult('Sorry, this system can only be used to transfer &pound;10 or more - please try again');		
		} else if (!$so && !$neg && ($gbpamount<10) && ($selectedCharityCountry == 'UK')) {
			HandleResult( 'Sorry, this system can only be used to transfer &pound;10 or more - please try again');
		} else if ($so && ($selectedCharityCountry != 'UK') && ($selectedCharityCountry != 'ISRAEL')) {
			HandleResult( 'Sorry, standing orders can only be to UK or Israeli charities');
		} else if (($selectedCharityCountry != 'UK') && ($gbpamount<50)) {
			HandleResult( 'Sorry, transfers to charities abroad must be &pound;50 or more, '.$currency.$amount.' is appox. &pound'.number_format($gbpamount,2));
		} else if ($so && !$neg && ($gbpamount<10)) {
			HandleResult( 'Sorry, this system can only be used to transfer &pound;10 or more - please try again');
		} else if ($neg && ($gbpamount >= -18) && ($gbpamount < 0) ) {
			HandleResult( 'Sorry, this system can only be used to transfer $pound;18 or more- please try again');
		} else if (!$_REQUEST['ConfirmTransfer']) {
			HandleResult( 'Please confirm the transaction is charitable');
		} else if(!$so && $balance && (gbpamount > $balance) && !$_REQUEST['confirm-insufficiantbalance'] ) {
			HandleResult( 'Your account balance is insufficient for this transaction, would you like to proceed?','','insufficiantbalance','confirm');
		} else if ($so && ($currency != 'GBP') ) {
			HandleResult( 'Sorry, standing orders can only be requested in Pounds (sterling) - please alter the currency selection or remove the Standing Order option');
		} else if($so=='Continuous payments' && !$fields['StandingOrderContinuous']) {
			HandleResult('Please specify the standing order date.');
		} else if($so=='Fixed number of payments') {//Repeat Payments
			if(!$_REQUEST['StandingOrderStartDate']){
				HandleResult('Please specify the standing order date.');
			} else if(!$_REQUEST['StandingOrderNumPayments']){
				HandleResult('Please specify how many payments.');
			} else if(!$_REQUEST['StandingOrderFrequency']){
				HandleResult('Please specify the payment interval.');
			}
		}

		if(!$_REQUEST['confirm-transdetails']) {
			$gbpInfo = $currency=='GBP'?'':'(approx. &pound;'.number_format($gbpamount,2).')';
			HandleResult('You have selected to donate ' . $currency . ' ' . $amount . $gbpInfo.' to ' . $beneficiary . '. Please confirm your donation.  Please note that reqests cannot be edited.','','transdetails','confirm');
		}

		//
		//validations over    
		//
		$request = new AACRequestItem();
        $fields['Amount'] = abs($fields['Amount']);


            if ($RemoteCharityCountry && (strtoupper(trim($RemoteCharityCountry)) != 'UK'))
                $fields['OfficeComments'] .= "\nCountry: " . $RemoteCharityCountry;

			if($_REQUEST['donationPurpose']) $fields['OfficeComments'] .= "\nPurpose: ".$_REQUEST['donationPurpose'];

            if ($gbpAmount) {
                $gbpAmount = round($gbpAmount, 2);
                $gbpAmountF = number_format($gbpAmount, 2);
                $fields['OfficeComments'] .= "\nEstimated GBP Amount " . utf8_decode('�') . $gbpAmountF;
                $fields['GBPAmount'] = $gbpAmount;
            } else
                $fields['GBPAmount'] = $fields['Amount'];

            $fields['OfficeComments'] = trim($fields['OfficeComments'], "\n");


        $request->Username = $user->Username;
        if (!$id) {
            $request->ResultCode = 'Pending';
            $request->RequestDateTime = time();
        }
        $fields['StandingOrderStartDate'] = $fields['StandingOrderStartDate'] ? strtotime($fields['StandingOrderStartDate']) + 3600 : '0';
        $fields['StandingOrderEndDate'] = $fields['StandingOrderEndDate'] ? intval($fields['StandingOrderEndDate']) + 3600 : '0';
        $fields['System'] = 'Desktop';//check??

        $request->SetProperties($fields);
        $request->UpdateSummary();
        $request->Save();

		$emails = new AchisomochEmails();
		$emails->SendRequestConfirmations($user,$request);

		$details = "Request: ".$fields['Request'];
    	if($fields['StandingOrderFrequency'] && $fields['StandingOrderFrequency'] != 'No') $details .= ' : Standing Order';
    	if($_POST['clone']) $details .= ' : Re-Request';
		User::LogAccessRequest($user->Username,'',$details);

		HandleResult(); //no params means success

}

?>