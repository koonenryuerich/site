<?php
/*
	Ajax script
*/

$query = "";
$result = "";
include 'functions.php';


if (isset($_POST['id']) && isset($_POST['eventid'])){
	$studentid = $_POST['id'];
	$eventid=$_POST['eventid'];
	$query = "INSERT INTO signups(eventid,studentid) VALUES($eventid,$studentid)";
	$result = queryMySql($query);

    $query = "SELECT * from volunteers where id=$studentid";
    $result = queryMySql($query);
    $studentFirstName = mysql_result($result,0,'firstname');
    $studentLastName = mysql_result($result,0,'lastname');
    $studentGrade = mysql_result($result,0,'grade');
    $studentAdvisor = mysql_result($result,0,'advisor');
    $studentEmail = mysql_result($result,0,'email');
    $parentEmail = mysql_result($result,0,'parentemail');
    $studentCredits = mysql_result($result,0,'credits');


    $data = array(
      "firstname" => "$studentFirstName",
       "lastname" => "$studentLastName",
        "grade" => "$studentGrade",
        "advisor" => "$studentAdvisor",
        "email" => "$studentEmail",
        "parentemail" => "$parentEmail",
        "credits" => "$studentCredits"

    );
    echo json_encode($data);
}

?>
