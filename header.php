<?php

/*
	The header.php file is a script almost all php files on the site include, which allows each page to access the database
	check verification, etc.

*/
session_start(); //start a session to store variables for the user
include 'functions.php'; //include all the functions needed to query database, clean input, etc. 
//set up basic css and javascript
echo <<<END
	<!DOCTYPE html>\n<html><head><meta http-equiv='content-type' content='text/html; charset=UTF-8'>
	 <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content=''>
    <meta name='author' content=''>
	<script src = 'justifiedpage_files/OSC.js'></script>
	<script src='justifiedpage_files/jquery.js'></script>
    <script src='justifiedpage_files/bootstrap-transition.js'></script>
    <script src='justifiedpage_files/bootstrap-alert.js'></script>
    <script src='justifiedpage_files/bootstrap-modal.js'></script>
    <script src='justifiedpage_files/bootstrap-dropdown.js'></script>
    <script src='justifiedpage_files/bootstrap-scrollspy.js'></script>
    <script src='justifiedpage_files/bootstrap-tab.js'></script>
    <script src='justifiedpage_files/bootstrap-tooltip.js'></script>
    <script src='justifiedpage_files/bootstrap-popover.js'></script>
    <script src='justifiedpage_files/bootstrap-button.js'></script>
    <script src='justifiedpage_files/bootstrap-collapse.js'></script>
    <script src='justifiedpage_files/bootstrap-carousel.js'></script>
    <script src='justifiedpage_files/bootstrap-typeahead.js'></script>
		
	<script src ='plugins/bootbox.js'></script>
	<script src = 'plugins/bootstrap-select.js'></script>

		
	<link rel="stylesheet" type="text/css" href="plugins/bootstrap-select.css">
		
		
		
		
    <link href='justifiedpage_files/bootstrap.css' rel='stylesheet'>
    <style type='text/css'>
      body {
        padding-top: 20px;
        padding-bottom: 60px;
      }

      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1000px;
      }
      .container > hr {
        margin: 60px 0;
      }

      /* Main marketing message and sign up button */
      .jumbotron {
        margin: 80px 0;
        text-align: center;
      }
      .jumbotron h1 {
        font-size: 100px;
        line-height: 1;
      }
      .jumbotron .lead {
        font-size: 24px;
        line-height: 1.25;
      }
      .jumbotron .btn {
        font-size: 21px;
        padding: 14px 24px;
      }

      /* Supporting marketing content */
      .marketing {
        margin: 60px 0;
      }
      .marketing p + h4 {
        margin-top: 28px;
      }


      /* Customize the navbar links to be fill the entire space of the .navbar */
      .navbar .navbar-inner {
        padding: 0;
      }
      .navbar .nav {
        margin: 0;
        display: table;
        width: 100%;
      }
      .navbar .nav li {
        display: table-cell;
        width: 1%;
        float: none;
      }
      .navbar .nav li a {ø
        font-weight: bold;
        text-align: center;
        border-left: 1px solid rgba(255,255,255,.75);
        border-right: 1px solid rgba(0,0,0,.1);
      }
      .navbar .nav li:first-child a {
        border-left: 0;
        border-radius: 3px 0 0 3px;
      }
      .navbar .nav li:last-child a {
        border-right: 0;
        border-radius: 0 3px 3px 0;
      }
		
	.centereddiv {
		 margin:0 auto;
		 float:none;
	}
		
		
		
    </style>
    <link href='justifiedpage_files/bootstrap-responsive.css' rel='stylesheet'>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src='../assets/js/html5shiv.js'></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel='apple-touch-icon-precomposed' sizes='144x144' href='http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-144-precomposed.png'>
    <link rel='apple-touch-icon-precomposed' sizes='114x114' href='http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-114-precomposed.png'>
      <link rel='apple-touch-icon-precomposed' sizes='72x72' href='http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-72-precomposed.png'>
                    <link rel='apple-touch-icon-precomposed' href='http://twitter.github.io/bootstrap/assets/ico/apple-touch-icon-57-precomposed.png'>
                                   <link rel='shortcut icon' href='http://twitter.github.io/bootstrap/assets/ico/favicon.png'>



END;



if (isset($_SESSION['userid'])){ //check if the user is logged in already using the session variable 
	$ufirstname = ucfirst($_SESSION['ufirstname']); //sets variables based on stored session variables
	$ulastname = ucfirst($_SESSION['ulastname']);
	$userid = $_SESSION['userid'];
	$loggedin = true;
}
else{ //if the session has expired or been terminated, no variables will be stored so user must log in
	$loggedin = false;
	
		
	
}




?>
