<?php

require_once 'config.inc.php';
require_once 'dbconn.inc.php';

$id = $_REQUEST['id'];
$action = $_REQUEST['action'];
if ($action == "cancel") {
    $qry = "";
    $qry = "UPDATE aac_requests ";
    $qry .= "SET Request = 'Cancel Standing Order',OfficeComments = 'Please cancel Standing order #" . $id . "'";
    $qry .= " WHERE id = " . $id;
    /* echo $qry; */
    $result = mysql_query($qry);
    if ($result) {
        echo '1';
    }/* else {
      echo $qry.'=><br>'.mysql_error();
      } */
}
?>
