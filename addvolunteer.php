<?php
/*
	Ajax script
*/

$query = "";
$result = "";
include 'header.php';


if (isset($_POST['id']) && isset($_POST['eventid'])){
	$studentid = $_POST['id'];
	$eventid=$_POST['eventid'];
	$query = "INSERT INTO signups(eventid,studentid) VALUES($eventid,$studentid)";
	$result = queryMySql($query);

}

?>
