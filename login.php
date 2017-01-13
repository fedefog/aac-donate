<?php
require_once 'inc/config.inc.php';
require_once 'inc/dbconn.inc.php';
require_once 'cls/base.cls.php';
require_once 'cls/users.cls.php';
session_start();

if ($_REQUEST['logout']) {

    $u = User::GetInstance();

    User::DoLogout();

    setcookie('u[' . $u->Username . ']', '', time() - (3600 * 24 * 365));
    setcookie('e[' . $u->Username . ']', '', time() - (3600 * 24 * 365));

    if ($_REQUEST['return'])
        header('location:' . $_REQUEST['return']);
    else
        header('location:http://www.achisomoch.org/');
    exit;
}

if (!$_REQUEST['doAction']) {

    $users = $_COOKIE['u'];
    $passwords = $_COOKIE['e'];

    if (count($users)) {
        $first_user = reset($users);
        $fu = $first_user;
    }

    //check that the cookie user is the same as one from the query string
    if ($fu && $_REQUEST['username'] && $fu != $_REQUEST['username'])
        $fu = null;

//var_dump($fu);

	if($fu) {
		$ul = new UserList();
		$users = $ul->GetUsersByUsername($fu);
		$u = reset($users);
		if(!$u->AutomaticLogin) unset($fu);
	}

    if ($fu && $passwords[$fu] && (User::DoLogin2($fu, $passwords[$fu], 'desktop'))) {
        setcookie('u[' . $_REQUEST['username'] . ']', $_REQUEST['username'], time() + (3600 * 24 * 365));
        setcookie('e[' . $_REQUEST['username'] . ']', sha1($_REQUEST['password']), time() + (3600 * 24 * 365));

        if ($_REQUEST['return'])
            header('location:' . $_REQUEST['return']);
        else
            header('location:index.php');
        exit;
    }
}
if ($_REQUEST['doAction']) {
    if (User::DoLogin($_REQUEST['username'], $_REQUEST['password'])) {

		$u = User::GetInstance();
		if($u->AutomaticLogin) {
	        setcookie('u[' . $_REQUEST['username'] . ']', $_REQUEST['username'], time() + (3600 * 24 * 365));
    	    setcookie('e[' . $_REQUEST['username'] . ']', sha1($_REQUEST['password']), time() + (3600 * 24 * 365));
		}

		//temporary
		unset($_REQUEST['return']);

        if ($_REQUEST['return'])
            header('location:' . $_REQUEST['return']);
        else
            header('location:index.php');
        exit;
    } else
        $error = 'Invalid username or password';
}

if ($_REQUEST['return'] && strpos($_REQUEST['return'], 'aac_requests_editor.php?Request=New%20Voucher%20Book') !== false) {
    $isVoucherLogin = true;
} else
    $isVoucherLogin = false;
?>

<html lang="en-UK">
    <head>

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>AAC</title>        

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


        <link href="css/sections.css" rel="stylesheet">

        <link href="css/login.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    <body onkeyup="onEnterSubmit(event)">
        <script type="text/javascript">
            function onEnterSubmit(event) {
                if (event.which == 13) {
                    document.getElementById('myForm').submit();
                }
            }
        </script>
        <main id="login" >
            <h1 class="logo-login">
                <img src="images/logo-aac.svg" alt="">
            </h1>
            <div class="container-login">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
                            <form id="myForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form" method="post">
                                <div class="form-group">
                                    <label for=""> ACCOUNT NUMBER</label>	
                                    <input type="text" name="username" value="<?php echo $_REQUEST['username'] ?>" class="input" placeholder="Enter your account number">
                                </div><!-- /form-group -->
                                <div class="form-group">
                                    <label for="">PASSWORD</label>	
                                    <input type="password" name="password" class="input" placeholder="Enter your password">
                                </div><!-- /form-group -->
                                <div class="form-group">
                                    <a href="forgot_password.php" class="forgot-pass">Forgot your password ?  Get in touch with us.</a>
                                </div><!-- /form-group -->
                                <a href="#" id="lnkLogin" onclick="document.getElementById('myForm').submit();" class="submit-login">Login</a>
                                <input type="hidden" name="doAction" value="login"  />
                                <input type="hidden" name="return" value="<?php echo $_REQUEST['return'] ?>"  />
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- /container-login -->
        </main>	
        <script src="js/jquery-1.11.2.min.js"></script>
        <script src="js/bootstrap.min.js" ></script>
        <script src="js/script.js"></script>
    </body>
</html>