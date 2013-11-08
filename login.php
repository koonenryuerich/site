<?
include "header.php";

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
if ($loggedin == true){
	//it means that the user returned to the login.php of his own free will, log him out
	$loggedin = false;



}

if ($loggedin == false){
	if (isset($_POST['username'])){ //checks whether sign-in form is submitted or not
		
		$username = $_POST['username'];
		$username = sanitizeString($username); //sanitize username input
		
		
		
		$firstlast = explode('.', $username); //splits 'eric.yu' into 'eric' and 'yu'
		
		
		
		$query = "SELECT * FROM volunteers where firstname = '$firstlast[0]' AND lastname = '$firstlast[1]'"; //select user from database based on first name and last name
		$result = queryMySql($query);
		$userid = mysql_result($result, 0,'id');
		//more checking here?

		if ($userid != ""){ //if the user has an id (valid username or password), set session variables so that they are stored
			$_SESSION['userid'] = $userid;
			$_SESSION['ufirstname'] = $firstlast[0];
			$_SESSION['ulastname'] = $firstlast[1];
			$loggedin = true;
			echo "logged in";

			//redirect to page that user came from

			$url = $_SESSION['redirecturl'];
			if ($url != ""){
				echo $url;
				echo "<script>window.location.replace('$url');</script>";
			}
			else{
				echo "<script>window.location.replace('signup.php');</script>";
			}
			
		}
		else{ //if not valid username/password then show sign in again
			echo <<<END
			<body>

			<div style="margin:100px auto;float:none;" class=" centereddiv">
				<div class="row">
					<div class="span4 offset4 well">
						<legend>Please Sign In</legend>
			          	<div class="alert alert-error">
			                <a class="close" data-dismiss="alert" href="#"></a>The username was not valid! Please try again.
			            </div>
						<form method="POST" action="signup.php" accept-charset="UTF-8">
						<input type="text" id="username" class="span4" name="username" placeholder="Username">
			
						<button type="submit" name="submit" class="btn btn-info btn-block">Sign in</button>
						</form>
					</div>
				</div>
			</div>
			
			
END;
			die();
		}

	}
	
	
	else{ //if user has not signed in, display sign in form
		echo <<<END
			<body>

END;
		echo <<<END
				
			<div style="margin:100px auto;float:none;"  class="centereddiv">
				<div class="row">
					<div class="span4 offset4 well">
						<legend>Please Sign In</legend>
			          	<div class="alert alert-error">
			                <a class="close" data-dismiss="alert" href="#"></a>You are not logged in! Please log in here.
			            </div>
						<form method="POST" action="login.php" accept-charset="UTF-8">
						<input type="text" id="username" class="span4" name="username" placeholder="Username">

						<button type="submit" name="submit" class="btn btn-info btn-block">Sign in</button>
						</form>    
					</div>
				</div>
			</div>
				
		
END;
		die();
	}



}



?>
