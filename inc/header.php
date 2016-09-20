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

    </head>

    <body>

    <div id="myProgress">
      <div id="myBar"></div>
    </div> 

    <section class="section">

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

                            <a href="transactions-pending.php" title="Pending Transactions" class="pending-bt">
                                <img src="images/pending-icon.png" width="21" height="21">
                                <span class="badge">2</span>
                            </a>
                        
                        </div><!-- /col -->

                        <div class="col-sm-4 col-md-4 ">
                        
                            <div class="box-account-header">
                                
                                <div class="box-account">
                                    
                                    <h2 class="title">ACCOUNT</h2> 
                                    
                                    <h3 class="account-number">A7895</h3>
                                    
                                </div><!-- /box-account -->

                                <div class="box-balance">
                                    
                                    <h2 class="title">BALANCE</h2>

                                    <h3 class="balance-number">£ 3,344.99</h3>

                                </div><!-- /box-balance -->

                                <div class="box-time">
                                    
                                    <h2 class="title">AS OF </h2>

                                    <h3 class="time-number">1 SEP 2016, 2:15PM</h3>

                                </div><!-- /box-time -->

                            </div><!-- /box-account-header -->

                        </div><!-- /col --> 

                        <div class="col-sm-4 col-md-4 ">

                            <div class="name-user visible-md visible-lg">
                                David Jacobs
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
       
<?
include 'navigator.php';
include 'logout-modal.php';
?>    