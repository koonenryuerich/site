<?php

/*
	signup.php is the main page for students/clients. It handles form submissions from 'form.php', the sign up page


*/
include 'header.php';


$query = "";
$result = "";

if (isset($_POST['signup'])){ //User just returned from form.php
	//database insertion logic here
	$eventid = $_POST['eventid'];
	$notes = sanitizeString($_POST['notes']);
	if ($notes == "Write things you want us to know about here (reasons why you might not be able to come, etc.)")
		 $notes = "";
	$query = "SELECT * FROM events WHERE id = '$eventid'";
	$result = queryMySql($query);
	$eventname = mysql_result($result, 0,'eventname');
	$query = "INSERT into signups(eventid,studentid,extra) values($eventid, $userid ,'$notes')";
	$result = queryMySql($query);
	

	//email the student a confirmation email
	require 'library/phpmailer/class.phpmailer.php';
	
	$mail = new PHPMailer;
	$mail->IsSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->Port       = 587;
	$mail->SMTPAuth = true;
	$mail->Username = 'kinkaidcommunityservice@gmail.com';
	$mail->Password = 'kinkaidcs2014';
	$mail->SMTPSecure = 'tls';
	
	$subject = "Event Confirmation Email";//add subject
	$message = "You have succesfully signed up for Event: $eventname!"; // add message
	$recipient =  "$ufirstname"."."."$ulastname"."@kinkaid.org";
	$mail->AddAddress($recipient);
	
	$mail->From = 'kinkaidcommunityservice@gmail.com';
	$mail->FromName = 'Kinkaid Community Service Council';
	
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->Send();
	
	echo <<<END
	</head>
	<body>
		<script>
			
		
		bootbox.alert("Thanks for signing up for $eventname, $ufirstname!", function() {
				window.location.replace('signup.php');
		});			
				
		
		</script>
END;
   		
	}
else{
	//put any specific styles here
	echo <<<END
	<script>
		$(document).ready(function(){
			console.log("fdjsl");
			$('td button.signup').click(function(){
				var id = 1;
				var eventname = $(this).parent().siblings(":first").text();
				var eventid = $('input[name=eventid]').val();
				var data = 'id='+id+'&eventid='+eventid;
				bootbox.confirm("<h3>Signing Up for "+eventname+"</h1><hr><p>Please write anything you want us to know about here, or just hit the OK button! This field is NOT required. <br><form id = 'signup' action ='signup.php'><textarea style = 'width:50%' name = 'notes'></textarea></form>",function(result){
					if (result){
						$('#signup').submit();

					}


				});



			});





		});


	</script>

	
	</head>
END;
	
}


if ($loggedin == false || $loggedin == null){
	$_SESSION['redirecturl'] = "signup.php";
	echo "<script>window.location.replace('login.php');</script>";
}



$query = "SELECT * FROM events where closed=0 and eventdate > NOW() ORDER BY eventdate";
$result = queryMySql($query);


//output navbar
echo <<<END
		<body>

		    <div class="container">
		
		      <div class="masthead">
		      	<p style="float:right;" >Welcome, $ufirstname</p>
		        <h3 class="muted">Sign Up</h3>
		        <div class="navbar">
		          <div class="navbar-inner">
		            <div class="container">
		              <ul class="nav">
		                <li><a href="index.php">Home</a></li>
		                <li><a href="about.html">About</a></li>

		                <li class = "dropdown">
		                	<a href="#" class = "dropdown-toggle" data-toggle="dropdown">
		                	Projects<b class = "caret"></b>
		                	</a>
		                	<ul class="dropdown-menu">
		                	  <li><a href = "construction.html">Habitat for Humanity</a></li>
		                	  <li><a href = "construction.html">Bocce Ball</a></li>
							  <li><a href = "construction.html">Meals on Wheels</a></li>
		                	</ul>
		                </li>
		                
		                <li class="active" ><a href = 'signup.php'>Sign Up</a></li>
		              </ul>
		            </div>
		          </div>
		        </div><!-- /.navbar -->
		      </div>
END;

//output table
echo "<div class = 'container'>\n<h3>Sign Up Forms</h3><table class = 'table'>";
echo <<<END
<tr>
      <th>Event Name</th>
      <th>Date</th>
      <th>Time</th>
      <th>Max Volunteers</th>
      <!--<th>Current # of Volunteers</th>-->
      <th>Supervisor</th>
      <th>Sign Up</th>
</tr>
END;

$months = array('1'=>'January',
		'2'=>'February',
		'3'=>'March,',
		'4'=>'April',
		'5'=>'May',
		'6'=>'June',
		'7'=>'July',
		'8'=>'August',
		'9'=>'September',
		'10'=>'October',
		'11'=>'November',
		'12'=>'December');

$numrows = mysql_num_rows($result);
$eventid = null;
for ($i = 0;$i<$numrows;++$i){
	$eventid = mysql_result($result, $i,'id');
	
	//check if currrent volunteers are equal to the maximum number of allowed voluntters. if it is, do not show it on the list of events
	$currentvolunteers = mysql_num_rows(queryMySql("SELECT * FROM signups where eventid=$eventid"));
	if ($currentvolunteers == mysql_result($result, $i,'max') && mysql_result($result, $i,'max')!=0)
		continue;
	
	echo"<tr>";
	echo '<td>'.mysql_result($result, $i,'eventname').'</td>';
	
	$eventdate = explode('-', mysql_result($result, $i,'eventdate'));
	
	echo '<td>'.$months[(int)$eventdate[1]].' '.(int)$eventdate[2].', '.$eventdate[0].'</td>';
	
	echo '<td>'.mysql_result($result, $i,'eventtime').'</td>';
	echo '<td>'.mysql_result($result, $i,'max').'</td>';
	//echo '<td>'.mysql_result($result, $i,'current').'</td>';
	echo '<td>'.mysql_result($result, $i,'supervisor').'</td>';
	
	$query = "SELECT * FROM signups WHERE eventid=$eventid AND studentid=$userid";
	if (mysql_num_rows(mysql_query($query)) > 0){
		echo '<td><button disabled="disabled" class = "btn" type = "submit">Volunteer!</button></form>';
	}
	else{
		//echo '<td><form action = "form.php" method = "POST"><input type = "hidden" name = "eventid" value = "'.mysql_result($result, $i,'id').'"/> 
		//	<button class = "btn signup" type = "submit">Volunteer!</button></form>';
		echo '<td><input type = "hidden" name = "eventid" value = "'.mysql_result($result, $i,'id').'"/><button class = "btn signup" type = "submit">Volunteer!</button></td>';
	}
	
	echo "</tr>";
	
}   
echo "</table></div>";


include "footer.php";

?>
