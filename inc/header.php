<!DOCTYPE html>
<html lang="en-UK">
    <head>
        
        <meta charset="utf-8">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
        <title></title>        

        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->

        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        


        <link href="css/bootstrap-switch.css" rel="stylesheet">
        <link href="css/bootstrap-select.css" rel="stylesheet">
        
        <link href="css/sections.css" rel="stylesheet">
        
        <link href="style.css" rel="stylesheet">
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

    <section class="section">
       
<?
include 'navigator.php';
include 'logout-modal.php';
?>    