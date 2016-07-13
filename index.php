<?php
/************************************************************************************/
/* This is the landing page with url get data 										*/
/* The user enters his Ach password which is checked 								*/
/* If password not ok more than 2 it passes this info back to the charity 			*/
/************************************************************************************/
/*
hash return
https://dmportals.com/donate1/?campaignid=2&id=2&acc=162&amt=0&hash=4a4607ad175b6d4a625232b83d1bf12c9494027e592d478a8e55bf1b4e57470e

no hash return
https://dmportals.com/campaigntest/?campaignid=3&id=1&acc=&amt=

Camp kef web
https://dmportals.com/campaigntest/?campaignid=10&id=1&acc=&amt=&comment=David

*/
if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
    echo 'Error - not using https';
	die();
}
ini_set('display_errors',1);  error_reporting(E_ALL);  // displays php messages
include_once 'connect_to_mysql.php';
include_once 'connect_to_mysql_devex_achisomoch.php';
include_once 'connect_to_mysql_achisomoch.php';
include_once 'url.php';
include_once 'function.php';
$tracker_message = serialize($_REQUEST);

/*******************   T R A C K E R  *********************************************/
tracker($tracker_message);
/*******************   T R A C K E R  E N D    ************************************/

//$dir = $siteurl . '/images/';
$dir = 'images/';

$msg = '';
$achisomoch = 'achisomoch_live';
$account = 'Invalid';
$timenow = date("Y/m/d H:i:s",time()); 
$ipquery = sprintf("%u",ip2long($_SERVER['REMOTE_ADDR']));
$ipaddress = $_SERVER['REMOTE_ADDR'];
$browser = $_SERVER['HTTP_USER_AGENT'];
$referer = $_SERVER['REQUEST_URI'];
$query_string = $_SERVER['QUERY_STRING'];
$referer = str_replace('"', "", $referer);
$referer = str_replace("'", "", $referer);
$email = '';

//	echo '<pre>';	
//	echo '$_REQUEST';	
//	print_r($_REQUEST);
//	echo '<br/>';
//	print_r($_SERVER);
//	echo '</pre>';	
//	die();

/**************************************************************************************************/
/*       F I R S T   T I M E   I N   															  */
/**************************************************************************************************/
if (isset($_GET['campaignid']) 
//	&& isset($_GET['id']) && isset($_GET['acc'])  && isset($_GET['amt']) 
		)
{
		$campaignid = mysqli_real_escape_string($mysqli, $_GET['campaignid']);
		$campaignid = ($campaignid == '' ? 0 : $campaignid);
		$charity_transaction_id = (int)($_GET['id']);
		$account = mysqli_real_escape_string($mysqli, $_GET['acc']);
		$account = ($account == '0' ? '' : $account);
//		$amount = mysqli_real_escape_string($mysqli, $_GET['amt']);
		$amount = (double)($_GET['amt']);
		$amount1 = (double)($_GET['amt']);
		if ($amount == 0)
		{
//			$amount1 = '';
			$amount1 = 0;
		}
		$comment = mysqli_real_escape_string($mysqli, $_GET['comment']);
//		$amount = ($amount == 0 ? '' : $amount);
		$hash_from_charity = mysqli_real_escape_string($mysqli, $_GET['hash']);
		
		$sql = "select * from campaign where id = $campaignid;";
		if (!$result = $mysqli->query($sql)) { die($mysqli->errno . ' ' . $mysqli->error . '<br />');}
		if ($result->num_rows != 1)
		{
			$error_message = serialize($_GET);
			$sql = "INSERT into campaign_error (`type_of_error`, `message`, `datetime`, `ip_address`, `ip_num`, `uagent`, `visited_page`)
			values ('invalid campaignid', '$error_message', '$timenow', '$ipaddress', '$ipquery', '$browser', '$referer')";
			if (!$result = $mysqli->query($sql)) { die($mysqli->errno . ' ' . $mysqli->error . '</br>');}
			echo 'invalid campaignid';
			exit;
		}
		$row = $result->fetch_assoc();
		$campaign_type = $row['campaign_type'];

		if ($campaign_type == 3 && $comment == '')  // 3 must have comment
		{
			echo 'Must have comment';
			exit;
		}

		$campaign_name = $row['campaign_name'];
		$campaign_description = $row['campaign_description'];
		$hashkey = $row['hashkey'];
		$use_hash = $row['use_hash'];
		$use_email = $row['use_email'];
		$post_url = $row['post_url'];
		
		if ($campaign_type == 5 && isset($_GET['mos'])) // Generic Charity
		{
			$charityno = (int)($_GET['mos']);
			$sql = "select * from $achisomoch.ach_charity where charityno = $charityno";
			if (!$result_ach = $mysqli_ach->query($sql)) { die($mysqli_ach->errno . ' charity name error ' . $mysqli_ach->error . '<br />');}
			$row = $result_ach->fetch_assoc();
			$campaign_description = $row['name'];
		}
		else if ($campaign_type == 5) // Charity not in url 
		{
			echo 'Must have chatity number';
			exit;
		}
		
		$string_hash = 'campaignid=' .$campaignid . '&id=' . $charity_transaction_id . '&acc=' . $account .
					'&amt=' . $amount;
		$hash = hash_hmac('sha256', $string_hash, $hashkey); // calculate hash
		if (trim($hash) != trim($hash_from_charity) && $use_hash == 'Y')  // INVALID HASH
		{
//			echo $hash . '<br>';
//			echo $hash_from_charity;
//			echo 'Invalid hash';
//			die();

			/* Log the error */
			$error_message = serialize($_GET);
//			$error_message = implode("|", $_GET);
			$sql = "INSERT into campaign_error (`type_of_error`, `message`, `datetime`, `ip_address`, `ip_num`, `uagent`, `visited_page`)
				values ('hash', '$error_message', '$timenow', '$ipaddress', '$ipquery', '$browser', '$referer')";
			if (!$result = $mysqli->query($sql)) { die($mysqli->errno . ' ' . $mysqli->error . '</br>');}
			$achid = $mysqli->insert_id; // Auto generated id from insert.  I put it in the hash string as there is no achid 
			$achid = $achid + 10000;
//			$achid = 0;

			$res = 2;  // Invalid hash 
			$string_hash = 'campaignid=' .$campaignid . '&id=' .$charity_transaction_id . '&acc=' . $account .
					'&amt=' . $amount . '&result='. $res .  '&achid='. $achid;
			$hash = hash_hmac('sha256', $string_hash, $hashkey); // calculate hash
			$fields_string = array('campaignid'=>$campaignid, 'id'=>$charity_transaction_id, 'acc'=>$account,
				 'amt'=>$amount, 'result'=>$res, 'achid'=>$achid, 'hash'=>$hash); 

			// For seeing what the hash looks like ----------------------------------------------------------
			$x = serialize($fields_string);
			$sql = "INSERT into test (`date`, `message`) values (now(), '$x')";
			if (!$result = $mysqli->query($sql)) { die($mysqli->errno . ' ' . $mysqli->error . '</br>');}
			// ----------------------------------------------------------------------------------------------

			$response = '';
			echo 'bad hash';
			exit;

		}  // end bad hash
} // end GET 
else
{
	$error_message = serialize($_GET);
	$sql = "INSERT into campaign_error (`type_of_error`, `message`, `datetime`, `ip_address`, `ip_num`, `uagent`, `visited_page`)
	values ('invalid url', '$error_message', '$timenow', '$ipaddress', '$ipquery', '$browser', '$referer')";
	if (!$result = $mysqli->query($sql)) { die($mysqli->errno . ' ' . $mysqli->error . '</br>');}
	echo 'invalid url';
	exit;
}
include 'index.html';
?>
