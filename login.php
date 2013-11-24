<?
include "header.php";



if ($loggedin == true){ //if $logged in is already initialized and true, user is already signed in
	//it means that the user returned to the login.php of his own free will, log him out
	$loggedin = false;
}


if ($loggedin == false){ //if user not logged in, check for the submission of sign-in form or output one
	if (isset($_POST['username'])){ //checks whether sign-in form is submitted or not
		
		$username = $_POST['username'];
		$username = sanitizeString($username); //sanitize username input
		
		
		
		$firstlast = explode('.', $username); //splits 'eric.yu' into 'eric' and 'yu'
		
		
		
		$query = "SELECT * FROM volunteers where firstname = '$firstlast[0]' AND lastname = '$firstlast[1]'"; //select user from database based on first name and last name
		$result = queryMySql($query);
		$userid = mysql_result($result, 0,'id');

		if ($userid != ""){ //if the user has an id (valid username or password), set session variables so that they are stored
			$_SESSION['userid'] = $userid;
			$_SESSION['ufirstname'] = $firstlast[0];
			$_SESSION['ulastname'] = $firstlast[1];
			$loggedin = true;

			//redirect to page that user came from

			$url = $_SESSION['redirecturl'];
			if ($url != ""){ //uses javascript redirect to redirect user to signup.php
				echo "<script>window.location.replace('$url');</script>";
			}
			else{
				echo "<script>window.location.replace('signup.php');</script>";
			}
			
		}
		else{ //if not valid username/password then show sign in again (with a slightly different message)
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
	
	
	else{ //if user has not signed in, display sign in form. sign-in form submits to the same php page
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
