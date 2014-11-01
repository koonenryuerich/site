<?php
include 'header.php';

mysql_set_charset("UTF-8");

$query = "SET NAMES utf8;
SET CHARACTER SET utf8;";
 $result = mysql_query($query);


$query = "SELECT * from  events";
$result  = mysql_query($query);
$date = mysql_result($result,0,'eventdate');
echo $date;
echo date('Y-m-d');



?>