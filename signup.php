<?php

/*
	signup.php is the main page for students/clients. It handles form submissions from 'form.php', the sign up page


*/
include 'header.php';


$query = "";
$result = "";


//put any specific styles here
echo <<<END
	<script>
		$(document).ready(function(){
			console.log("fdjsl");
			$('td button.signup').click(function(){
			    var button = this;

				var id = $userid;
				var eventname = $(this).parent().siblings(":first").text();
				var eventid = $('input[name=eventid]').val();
				var data = 'id='+id+'&eventid='+eventid;
				bootbox.signup("Signing up for event: "+eventname,function(result) {
					if (result){


					    var notes = result;
					    if (result == 'default'){
					        var data = 'id='+id+'&eventid='+eventid;
					    }else{
					        var data = 'id='+id+'&eventid='+eventid+'&notes='+notes;
					    }

						$.ajax(
							{
								type: "POST",
								url:"signupajax.php",
								data:data,
								cache: false,
								success: function()
								{
									console.log(data);
									button.disabled = true;
									bootbox.alert("Thanks for signing up, $ufirstname!");

								}
							});


					}

				});



			});





		});


	</script>

	
	</head>
END;
	



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
