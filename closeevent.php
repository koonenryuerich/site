<?php
/**
 * Created by PhpStorm.
 * User: cyrieu
 * Date: 11/1/14
 * Time: 9:55 AM
 */

$username  = 'superadmin';
$password = 'adminkinkaidcs';


if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) { //prompts admin username and password
    if ($_SERVER['PHP_AUTH_USER'] == $username && $_SERVER['PHP_AUTH_PW'] == $password) {

        include "header.php";
        /*
         * Handler for closing events
         */
        if ($_POST['eventid'] != "" && isset($_POST['closeevent']) ){

        }




    }
}





?>