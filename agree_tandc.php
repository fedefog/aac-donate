<?php

require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';

session_start();



if($_REQUEST['doAction']) {
	if(!$_REQUEST['tandc_agreed']) die('You have to agree to the terms and conditions');

	$user =& User::GetInstance();
	if(!$user) die('Error updating T&C');
	$user->TermsAndConditionsAccepted=1;
	$sql = 'UPDATE users SET TermsAndConditionsAccepted=1 WHERE Username="'.$user->Username.'"';
	mysql_query($sql);
	User::LogAccessRequest($user->Username,$_SERVER['REMOTE_ADDR'],"User agreed to Terms & Conditions");
	header('location: index.php');
	exit;
}


?>
<!-- AACDESIGN3 -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Terms and Conditions</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/terms-and-conditions.css">

</head>
<body>
        <main id="back-screen" >
        <h1 class="logo-login">
                <img src="images/logo-aac.svg" alt="">
            </h1>
        <div class="container-login">
            <div class="container">
                <div class="row">
                   <div class="col-xs-12 col-sm-10 col-md-10 col-md-offset-1 col-sm-offset-1">
                   	<div class="terms-container">
                   		<ol>
                   			<h1>Terms and Conditions</h1>
                   			<li>
                   				<span class="title">OWNERSHIP OF FUNDS</span>
                   				<p>AAC is a registered charity (charity number 278387). References in these Terms and Conditions to AAC shall be deemed, where the context 
								requires, to refer also to the directors, trustees, consultants to and employees of AAC.  
								A donation of funds to AAC, which is made by you (whether in cash, by cheque, electronically or by any other means) is an irrevocable charitable 
								donation to AAC and such funds immediately become the property of AAC.   AAC will maintain a notional account in your name to identify any 
								donations made by you (“Notional Account”). 
								[AAC is under no duty of care to you to maintain funds which have been credited to a Notional Account.  In the event that such funds are lost, for 
								example, as a result of the insolvency of a bank with which AAC has made deposits, you will have no recourse to AAC in respect of such loss.]
								Interest which is earned on funds donated to AAC shall be the property of AAC and will not be credited to your Notional Account.</p>
                   			</li>
                   			<li>
                   				<span class="title">TAX REBATES</span>
                   				<p>To the extent that you have declared that your donations are eligible donations under the HM Revenue & Customs (“HMRC”) Gift Aid scheme, 
								AAC will make a claim for basic rate tax from HMRC as permitted by law, and will apply the amount received from HMRC to your Notional 
								Account as if it were a donation of funds to AAC.   
								You are responsible for verifying whether or not and the extent to which your donations are eligible under the HMRC Gift Aid Scheme. To the 
								extent that AAC apply for and/or receive an amount from HMRC in respect of your donations and such amount is found to have been received in 
								error, AAC will be entitled to deduct any such sums from your Notional Account or to require you to make such payment to your Notional 
								Account as may be required to rectify such error.
								Claims for tax rebates to HMRC are usually submitted fortnightly and tax credits are shown on statements once the funds have been received by 
								AAC. This normally takes two weeks from the time the claim is submitted but can take longer.</p>
                   			</li>
                   			<li>
                   				<span class="title">REQUEST FOR PAYMENTS TO CHARITY</span>
                   				<p>You may request funds to be paid by AAC to a charitable organisation of your selection by means of completion of a voucher provided to you by 
								AAC which you may give to a charity or by any electronic means as may be approved from time to time by AAC, any such payment will reduce 
								the balance of your Notional Account.  </p>
                   			</li>
                   			<li>
                   				<span class="title">DONATIONS TO CHARITY</span>
                   				<p>Achisomoch may only allocate funds to bona fide charities. This includes the allocation of funds to charities which are registered in the UK with 
								the Charities Commission and/or charities which are registered in Israel, USA and elsewhere with an equivalent registration. AAC will have 
								absolute discretion in determining the eligibility of the proposed charity and whether to or when to distribute to the proposed charity. You are 
								responsible for ascertaining whether or not a charity to which you may request an allocation be made, in the form of issuing a voucher or 
								otherwise, is a charity which is eligible to received funds from AAC. Once funds have been transferred to AAC, they cannot be returned to you 
								under any circumstances.
								At no time may you, or any person connected to you, for example, your spouse or close relative, be permitted to derive a benefit from the funds 
								which you donate to AAC. No allocation may be made by AAC at your request to discharge or satisfy a legally enforceable obligation to which 
								you are party. AAC is not and will not be responsible for verifying the charitable status of any charity to which payments are made from your 
								Notional Account or for ascertaining whether or not you or any persons connected to you benefit from such payment.</p>
                   			</li>
                   			<li>
                   				<span class="title">SCHOOL FEES</span>
                   				<p>Without prejudice to the general statement set out in paragraphs 3 and 4 above, the following shall also apply in relation to school and education 
								related fees.  If you are in any doubt of the eligibility of the proposed recipient of an allocation by AAC, you should confirm such eligibility prior to 
								transferring funds to AAC</p>
                   			</li>
                   			<li>
                   				<span class="title">PRIVATE SCHOOL / COLLEGE FEES</span>
                   				<p>AAC cannot use funds to pay any private school or college fees whether such fees relate to secular or Hebrew tuition. This also applies to Boarding Schools, Yeshivas and Seminaries and other colleges of higher education, whether in the UK and abroad. </p>
                   			</li>
                   			<li>
                   				<span class="title">STATE AIDED SCHOOLS</span>
                   				<p>In accordance with current HMRC practice, voluntary contributions requested by State Aided schools in relation to the provision of Kodesh tuition may be paid by donations from AAC.</p>
                   			</li>
                   			<li>
                   				<span class="title">DONATIONS TO SCHOOLS / COLLEGES</span>
                   				<p>General donations to educational establishments which qualify as a charitable organisation under the relevant law may be made with charitable funds provided all tuition charges have been paid.</p>
                   			</li>
                   			<li>
                   				<span class="title">STATEMENTS</span>
                   				<p>Statements are issued monthly if an email or fax number is provided otherwise quarterly. Notional Accounts are usually updated daily and can be accessed through the AAC website.</p>
                   			</li>
                   			<li>
                   				<span class="title">OVERDRAWN ACCOUNTS</span>
                   				<p>You are responsible for ensuring that the balance of your Notional Account exceeds the amounts which you request to be paid to charities from 
								time to time whether by the issue by you of a voucher to a charity or otherwise. To the extent that your Notional Account does not hold sufficient 
								funds to satisfy a request for a payment to be made to a charity, such payment will not be made. AAC will not be responsible for notifying you of 
								the balance of your Notional Account and owes no duty of care to either you or any other party in this regard.
								In the event that a request is made by you for a payment to be made to a charity for an amount which exceeds the balance of your Notional 
								Account, in its absolute discretion, AAC may choose to advise such charity you have been advised of this fact.  In the event that you do not 
								make a donation to AAC in respect of such shortfall within two weeks of receipt of a notification, the voucher which you have issued to the 
								charity may be returned. AAC reserves the right to levy an additional charge to you in such a case. In the event that amounts have been 
								requested to be paid to a number of charities, AAC has absolute discretion in relation to the priority of payment</p>
                   			</li>
                   			<li>
                   				<span class="title">REQUESTS MADE BY PHONE/EMAIL</span>
                   				<p>AAC will use its best endeavours to make payments requested of it as soon as is practicably possible but shall be under no obligation to do so.   
								Requests made by phone/email should not be regarded as having been made unless you receive formal email acknowledgement of such 
								request from AAC.</p>
                   			</li>
                   			<li>
                   				<span class="title">BLANK VOUCHERS</span>
                   				<p>Vouchers should not be issued by you without the name of the payee being stated. AAC reserves the right to refuse to pay any voucher where the payee’s name is omitted, altered or in a different handwriting to the rest of the voucher unless that amendment is signed by you.</p>
                   			</li>
                   			<li>
                   				<span class="title">FORGED / EXPIRED VOUCHERS</span>
                   				<p>Checks made on the validity, the date and the signature on a voucher presented for payment are limited. Pre-paid vouchers are processed automatically and are not checked. AAC has no liability to you in the event that it honours a voucher which is found to be forged, expired or fraudulent.</p>
                   			</li>
                   			<li>
                   				<span class="title">YOUR IDENTITY</span>
                   				<p>Unless advised to the contrary in writing, AAC will always reveal your name to the beneficiary of the donation.</p>
                   			</li>
                   			<li>
                   				<span class="title">DEATH</span>
                   				<p>In the event of your death, AAC may, in its discretion, allow your relatives to make requests regarding the allocation of funds held in your Notional Account following your death</p>
                   			</li>
                   			<li>
                   				<span class="title">MONEY LAUNDERING</span>
                   				<p>In order to safeguard against Money Laundering, AAC randomly checks payments requested by clients.  Donors may be asked to confirm in writing that they receive no benefit from a donation which they request be made by AAC. The recipient charity may also be asked to confirm that no benefit has/will result. Details of the charity/project may also be requested.</p>
                   			</li>
                   			<li>
                   				<span class="title">DORMANT ACCOUNTS</span>
                   				<p>AAC is not operating a bank and is established for the purposes of making charitable donations. In the event that funds which have been donated by you are not subsequently the subject of a request to be distributed to a charity within 24 months, AAC may, in its discretion, use such funds to make allocations to charities of its own choice without further notification to you.</p>
                   			</li>
                   			<li>
                   				<span class="title">COMPLIANCE OFFICER</span>
                   				<p>AAC’s Compliance Officer is authorised to inspect any transaction.</p>
                   				<p>He may contact a client to confirm details of a payment and/or to request additional information.</p>
                   			</li>
                   			<li>
                   				<span class="title">SCALE OF CHARGES</span>
                   				<p>AAC makes a charge of 5% of all payments into a client’s account. By making a donation to AAC, you irrevocably authorise AAC to levy such charge. Additional charges may be due in accordance with paragraph 7. Any such charges will reduce the balance of your Notional Account.</p>
                   			</li>
                   			<li>
                   				<span class="title">AMENDMENT OF THESE TERMS</span>
                   				<p>AAC may, in its absolute discretion, vary the terms of these Terms and Conditions. Any such variation will be effective 30 days after you have received written notice of such variation which may be made via email or by post at the discretion of AAC</p>
                   			</li>
                   			<li>
                   				<span class="title">TERMINATION OF ARRANGEMENT </span>
                   				<p>AAC reserves the right to terminate its agreement with you at any time. In such circumstances, pending vouchers will be returned to the relevant charities</p>
                   			</li>
                   		</ol>
                   		<div class="agreement">




						<form method="post" id="agree-form">

               			<input type="checkbox" name="tandc_agreed" id="tandc_agreed">
               			<label for="tandc_agreed">I agree to the Terms & Conditions</label>
               			<input type="button" id="agree-tandc" value="Continue">

						<input type="hidden" name="doAction" value="Agree"  />
						<input type="hidden" name="return" value="<?php echo $_REQUEST['return'] ?>"  />
						</form>

               			</div>
                   	</div>
                   </div>
                </div>
            </div>
        </div><!-- /container-login -->
    </main>	
</body>
	<script src="js/jquery-1.11.2.min.js"></script>
  <script>
  $(function() {
	
  	$('#agree-tandc').click(function(e){
  		e.preventDefault();
  		if(!$('#tandc_agreed:checked').length){
  			alert('Please agree to the terms & conditions');
  			return;
  		}

		$('#agree-form').submit();
/**
  		$('#agree-content').load('remote.php?m=agreeTermsAndConditions','',function(){
  			setTimeout(function(){
  				location.href='<?php echo $_REQUEST['return']?$_REQUEST['return']:'index.php'; ?>';
  			},3000);
  			});
**/
  	});
  });
  </script>
</html>


