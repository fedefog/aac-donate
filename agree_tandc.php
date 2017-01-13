<?php

require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';

session_start();



if($_REQUEST['doAction']) {
	die('No JS error');
	/**
	if(User::DoLogin($_REQUEST['username'],$_REQUEST['password'])) {

		setcookie('u['.$_REQUEST['username'].']', $_REQUEST['username'], time()+(3600*24*365));
		setcookie('e['.$_REQUEST['username'].']', sha1($_REQUEST['password']), time()+(3600*24*365));

		if($_REQUEST['return'])
			header('location:'.$_REQUEST['return']);
		else
			header('location:index.php');
		exit;
	} else $error = 'Invalid username or password';
	**/
}


?>
<?php //include 'header.inc.php'; ?>

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

						<p><input type="checkbox" id="tandc_agreed"> I agree to the <a href="http://www.achisomoch.org/pdf/Ts&Cs.pdf" target="_blank">Terms & Conditions</a>

						<p><input id="agree-tandc" type="button" value="I Agree" /></p>

						<input type="hidden" name="doAction" value="Agree"  />
						<input type="hidden" name="return" value="<?php echo $_REQUEST['return'] ?>"  />
						</form>




								  </td>
                                </tr>
</table>

  <script>
  $(function() {
  	$( "#dialog" ).dialog();

  	$('#agree-tandc').live('click',function(e){
  		e.preventDefault();
  		if(!$('#tandc_agreed:checked').length){
  			alert('Please agree to the terms & conditions');
  			return;
  		}
  		$('#agree-content').load('remote.php?m=agreeTermsAndConditions','',function(){
  			setTimeout(function(){
  				location.href='<?php echo $_REQUEST['return']?$_REQUEST['return']:'index.php'; ?>';
  			},3000);
  			});
  	});
  });
  </script>

							<?php //include 'footer.inc.php'; ?>