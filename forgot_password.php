<?php

	require_once 'inc/config.inc.php';
	require_once 'inc/dbconn.inc.php';
	require_once 'inc/funcs.inc.php';
	require_once 'cls/base.cls.php';
	require_once 'cls/users.cls.php';
	require_once 'cls/sendmail.cls.php';

	require_once 'cls/class.smtp.php';
	require_once 'cls/class.phpmailer.php';

	require_once 'cls/emails.cls.php';
	require_once 'cls/emaillog.cls.php';

	session_start();

	require_once 'cls/mobile_detect.cls.php';


	if($_POST['doAction']) {
		$ul = new UserList();
		$emails = new AchisomochEmails();

		if($_POST['email'] && $_POST['account']) {

			if($_POST['email'] && ($u = User::UserByEmailAndAccountRef($_POST['email'],$_POST['account'])) && $u ) {
				//$u = reset($ui);

				$emails->SendForgotPassword($u);

				header('location:?done=true');
				exit;
			} else if(($u = User::UserByUsername($_POST['account'],'ForgotPass')) && $u && $u->Email) {
				$e = $u->Email;
				$eBits = explode('@',$e);
				$name = $eBits[0];
				$tBits = explode('.',$eBits[1]); 
				$tld = array_pop($tBits);
				$domain = implode('.',$tBits);
				
				$e=mask($name,1,-1).'@'.mask($domain,1,-2).'.'.$tld;
				
				
				$error = 'Sorry the email you have registered with us has the pattern '.$e;
			} else {

				$emails->SendUnfoundUserToAdmin($_POST['email']);

		
				$src = User::DeviceDetect();


				User::LogForgotPasswordFail($_POST['email'],$src,$_POST['account']);
				$error = 'Sorry, we have been unable to locate an account with this email, please contact support';
			}

		} else $error = 'Please enter your account number and email address';

	}

?>
<!-- AACDESIGN3 -->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Recover your password</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/forgot-password.css">
</head>
<body>
<main>
	<div class="container">
	    <div class="row">
	       <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
		       	<h1 class="logo-login">
			        <a href="./"><img src="images/logo-aac.svg" alt=""></a>
			    </h1>
			    <p class="instructions">Enter your account number and email address to be immediately emailed your password.</p>
		       <form method="post">
						<input type="tel" id="account" name="account" placeholder="Enter your account number" /></td></tr>
						<input type="email" id="email" name="email" placeholder="Enter your email address" />
						<input type="submit" value="Send me my password" class="submit-login" />


						<input type="hidden" name="doAction" value="forgotpass"  />
		       </form>
		       <div class="info">
		       		<p>If need be, you can get in touch with the office: email <a href="mailto:admin@achisomoch.org">admin@achisomoch.org</a> or call <a href="tel:02087318988 ">0208 731 8988</a> (Monday to Thursday, 10am - 3pm)</p>
		       </div>
				<?php if ($error) { ?>
		       <div class="error-message">
		       		<p><?php echo $error ?></p>
		       </div>
				<?php } ?>


				<?php if($_REQUEST['done']) { ?>
		       <div class="success-message">
		       		<p>Thank you. We have sent a password reminder to your email address.
							<br/><br/>
							<a href="login.php">Return to login page</a></p>
			   </div>
				<?php } ?>

	       </div>
	    </div>
	</div>
</main>
</body>
</html>