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
<?php //include 'header.inc.php'; ?>
<form method="post" id="agree-form">
<table width="100%" height="400" border="0" cellspacing="0" cellpadding="0">
							<tr>
							<td colspan="2" height="10"></td>
							</tr>
							<tr>
							<td colspan="2" height="10"></td>
							</tr>
					<tr>
						<td colspan="2" valign="top" align="center" id="agree-content">

						<p>We notice that you have not yet confirmed your acceptance to our standard Terms and Conditions.</p>
						<p>Please spend a few minutes to read through this document at <a href="http://www.achisomoch.org/pdf/Ts&Cs.pdf" target="_blank">www.achisomoch.org/pdf/Ts&Cs.pdf</a> and confirm that you have read them.</p>

						<p>From early 2016, we will offer online facilities only to those clients who have read/agreed to these Terms and Conditions.</p>

						<form method="post">

						<p><input type="checkbox" name="tandc_agreed" id="tandc_agreed"> I agree to the <a href="http://www.achisomoch.org/pdf/Ts&Cs.pdf" target="_blank">Terms & Conditions</a>

						<p><input id="agree-tandc" type="button" value="I Agree" /></p>

						<input type="hidden" name="doAction" value="Agree"  />
						<input type="hidden" name="return" value="<?php echo $_REQUEST['return'] ?>"  />
						</form>




								  </td>
                                </tr>
</table>
</form>

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

							<?php //include 'footer.inc.php'; ?>