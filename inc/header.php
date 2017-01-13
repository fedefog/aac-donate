<!DOCTYPE html>
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



        <link href="css/bootstrap-switch.css" rel="stylesheet">
        <link href="css/bootstrap-select.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="all" href="css/daterangepicker.css" />
        <link href="css/bootstrap-dialog.min.css" rel="stylesheet">
        <link href="css/sections.css" rel="stylesheet">

        <link href="style.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <? if (  $section == 'dashboard') {?>
        <link href="css/home.css" rel="stylesheet">
        <?}?>
        <? if (  $section == 'login') {?>
        <link href="css/login.css" rel="stylesheet">
        <?}?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
		<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>

		<script>
/**
			var performUnloadCheck=true;
			window.onbeforeunload= function(){
				if(!performUnloadCheck) return true;
				//if(!confirm('Are you sure you want to leave this page?')) return false;
				return 'Are you sure you want to leave this page?';
			}
**/
		</script>

    </head>
    
    <!-- AACDESIGN2 -->
    <!-- 
        Comment :  if has notification add this class to de body .
    -->
    <body>
    <!-- END AACDESIGN2 -->
        <?php
		/**
        $transaction = $td->getTransactionDetailByAccountName($user->Reference);

        foreach ($transaction as $tr) {
            $balance = $tr->Close_balance;
            $balance = number_format($balance, 2);
            $account = $tr->Reference;
            $date = date('d M Y, H:iA', strtotime($tr->Last_statement_date));
        }
		**/
			$user = User::GetInstance();
            $balance = number_format($user->Close_balance, 2);
            $account = $user->Reference;
            $date = date('d M Y, H:iA', strtotime($tr->Close_balance_date));
        ?>
        <div id="myProgress">
            <div id="myBar"></div>
        </div> 

        <section class="section">
            <!-- AACDESIGN2 -->
            <div class="notification-box">
                <p class="text-notification"> <i class="fa fa-check" aria-hidden="true"></i>
 <font>Your donation to <span>CHARITY NAME</span> <strong>is being processed.</strong></font></p>
                <a class="close-notification">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
<?php /**
            <div class="notification-box hide">
                <p class="text-notification"> <i class="fa fa-check" aria-hidden="true"></i>
 Your Standing order to CHARITY NAME<strong> has been registered.</strong></p>
                <a class="close-notification">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
            <div class="notification-box hide">
                <p class="text-notification"> <i class="fa fa-check" aria-hidden="true"></i>
 our Voucher Book order <strong> has been placed.</strong></p>
                <a class="close-notification">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </div>
		**/ ?>
                <!-- END AACDESIGN2 -->
            <div class="header-fixed hidden-xs" >

                <header class="header ">

                    <div class="container-fluid ">

                        <div class="row">

                            <div class="col-sm-4 col-md-4 ">

                                <h1 class="logo-header">

                                    <a href="#">

                                        <img src="images/logo-aac.svg" alt="">

                                    </a>

                                </h1>
                                <?php
                                /* $sql .= " SELECT a.* FROM";
                                  $sql .= " aac_requests a";
                                  $sql .= " LEFT JOIN charities c on c.remote_charity_id = a.RemoteCharityID";
                                  $sql .= " LEFT JOIN users u on u.Username = a.Username";
                                  $sql .= " WHERE a.Username = '" . $user->Username . "' AND a.ResultCode = 'Pending'";
                                  $result = mysql_query($sql);
                                  $count = mysql_num_rows($result); */
                                $transactionlist = new TransactionList();
                                $ptl = $transactionlist->getPendingTransactionList($user->Username);
                                $count = count($ptl);
                                if ($count > 0) {
                                    ?>
                                    <!-- AACDESING --> 
                                    
                                    <!-- we've deleted pending icon -->

                                    <!-- AACDESING END --> 
                                    <?php
                                }
                                ?>
                            </div><!-- /col -->

                            <div class="col-sm-4 col-md-4 ">

                                <div class="box-account-header">

                                    <div class="box-account">

                                        <h2 class="title">ACCOUNT</h2> 

                                        <h3 class="account-number"><?php echo $account; ?></h3>

                                    </div><!-- /box-account -->

                                    <div class="box-balance">

                                        <h2 class="title">BALANCE</h2>

                                        <h3 class="balance-number">£ <?php echo $balance; ?></h3>

                                    </div><!-- /box-balance -->

                                    <div class="box-time">

                                        <h2 class="title">AS OF </h2>

                                        <?php /* <h3 class="time-number"><?php echo date('d M Y, H:iA'); ?></h3> */ ?>
                                        <h3 class="time-number"><?php echo $date; ?></h3>

                                    </div><!-- /box-time -->

                                </div><!-- /box-account-header -->

                            </div><!-- /col --> 

                            <div class="col-sm-4 col-md-4 ">

                                <div class="name-user visible-md visible-lg">
                                    <?php
                                    /*$qry = "";
                                    $qry .= " SELECT * FROM users";
                                    $qry .= " WHERE id = " . $user->id;
                                    $result = mysql_query($qry);
                                    $row = mysql_fetch_row($result, MYSQL_ASSOC);*/

/**
                                    $row = User::getUserData($user->id);
                                    if ($row['ShowUserDisplayName'] == "1") {
                                        echo $user->UserDisplayName;
                                    }
**/
									echo $user->ShowUserDisplayName?$user->UserDisplayName:'';
                                    ?>
                                </div>

                                <a href="#" class="nav-mobile nav-icon4 visible-sm visible-md visible-lg ">

                                    <span></span>
                                    <span></span>
                                    <span></span>

                                </a>

                            </div><!-- /col -->

                        </div><!-- /row  -->    

                    </div><!-- /container  -->

                </header>

            </div><!-- /header-fixed -->

            <?php
            include 'navigator.php';
            include 'logout-modal.php';
            require_once 'dbconn.inc.php';

            /* $sql = "SELECT * FROM charities_currencies";
              $res = mysql_query($sql) or die(mysql_error());
              while ($r = mysql_fetch_array($res)) {
              define($r['CurrencyCode'] . '_EXRATE', $r['ExRate']);
              } */
            ?>    