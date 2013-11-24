<?php

/*
	signup.php is the main page for students/clients. It handles form submissions from 'form.php', the sign up page


*/
include 'header.php';


$query = "";//initialize variables to prevent security threats
$result = "";


//put any specific styles/scripts here
echo <<<END

    <style>
    #loading-indicator { /*some styles for the loading indicator*/
          position: absolute;
            left: 50%;
            top: 50%;
            margin-left: -32px; /* -1 * image width / 2 */
            margin-top: -32px;  /* -1 * image height / 2 */
            display: block;
    }

    p { /*this is so the description text that appears in the modal when a user signs up does not keep on going horizontally forever*/
        word-wrap: break-word;
    }
    </style>
    <script src="plugins/blockui.js"></script>
	<script>
		$(document).ready(function(){ //Runs these scripts when document is loaded 

			$('td button.signup').click(function(){ //sets a click handler for the signup button next to events
			    var button = this;

				var id = $userid; //userid is a session variable initialized in headers.php
				var eventname = $(this).parent().siblings(":first").text(); //selects the parent, the row, and then gets the text from the first <td>
				var eventid = $(this).parent().find('input[type=hidden]').val(); //selects the parent (<td>) and gets the value of the hidden input text inside it.
				var data = 'id='+id+'&eventid='+eventid; //initializes the data variable that will be sent as parameters to ajax
				var eventinfo = $(this).parent().siblings(":first").find('input[type=hidden]').val(); //selects the hidden input in the first <td> in the <tablee>

				bootbox.signup("Signing up for event: "+eventname+'|'+eventinfo,function(result) { //calls bootbox library's custom signup function
					/*Makes a modal signup interface. The user can either click 'ok' immediatly and signup, which 
					*will return 'default', or type
					*something into the <textarea> and return whatever the user typed in (result)
					*/
					if (result){
					    var notes = result; //sets var notes as the return value (what the user entered)
					    if (result == 'default'){ //if user did not enter anything
					        var data = 'id='+id+'&eventid='+eventid;
					    }else{
					        var data = 'id='+id+'&eventid='+eventid+'&notes='+notes;
					    }

						$.ajax( //sends ajax request
							{
								type: "POST",
								url:"ajax/signupajax.php",
								data:data,
								cache: false,
								success: function()
								{
									button.disabled = true; //disables button so that user cannot sign up again
									bootbox.alert("Thanks for signing up, $ufirstname!"); //alerts user that he/she has signed up succesfully

								}
							});


					}

				});
			});
			
			/*These two scripts make sure that when an ajax request is runing, the user cannot interact with the 
			*webpage and displays a loading screen
			*/
            $(document).ajaxSend(function(event, request, settings) {
                $.blockUI({ message: '<h1>Signing Up...<img src="images/ajax-loader.gif" /> </h1>' });
            });
            $(document).ajaxComplete(function(event, request, settings) {
                $.unblockUI();
            });




		});


	</script>

	
	</head>
END;
//End of styles and scripts
	



if ($loggedin == false || $loggedin == null){ //if user is not logged in, redirect user to login.php, and store the current url so that he can be redirected back from login.php
	$_SESSION['redirecturl'] = "signup.php"; //Session variables are essentially globals
	echo "<script>window.location.replace('login.php');</script>";//javascript redirect
}



$query = "SELECT * FROM events where closed=0 and eventdate > NOW() ORDER BY eventdate"; //Selects all open events and orders them by most recent in the future to furthest
$result = queryMySql($query); //stores query in a result object


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

//Create an array of months in order to output date better
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
for ($i = 0;$i<$numrows;++$i){ //for loop, runs through each row of data obtained in the query
	$eventid = mysql_result($result, $i,'id'); //gets the eventid
	
	//check if currrent volunteers are equal to the maximum number of allowed voluntters. if it is, do not show it on the list of events
	$currentvolunteers = mysql_num_rows(queryMySql("SELECT * FROM signups where eventid=$eventid"));
	if ($currentvolunteers == mysql_result($result, $i,'max') && mysql_result($result, $i,'max')!=0)
		continue;
	
	echo"<tr>"; //Table row

    $eventDescription = mysql_result($result,$i,'description');//gets the event description from the sql query

	echo "<td>".mysql_result($result, $i,'eventname')."<input type='hidden' name='eventinfo' value = '$eventDescription'></td>"; //puts the event description as a hidden input in the first <td>
	
	$eventdate = explode('-', mysql_result($result, $i,'eventdate')); //explode/split the string that mysql stores the date in E.G 2013-12-28
	
	echo '<td>'.$months[(int)$eventdate[1]].' '.(int)$eventdate[2].', '.$eventdate[0].'</td>'; //outputs date using the months array: month, day, year
	
	echo '<td>'.mysql_result($result, $i,'eventtime').'</td>'; //displays the eventtime
    $max = mysql_result($result, $i,'max'); //displays max volunteers
    if ($max == 0) //if admin did not set max volunteers, then just displaay nothing
	    echo '<td></td>';
    else
        echo '<td>'.$max.'</td>';
	echo '<td>'.mysql_result($result, $i,'supervisor').'</td>'; //output supervisor
	
	$query = "SELECT * FROM signups WHERE eventid=$eventid AND studentid=$userid";
	if (mysql_num_rows(mysql_query($query)) > 0){ //if student has signed up for event already, make the button disabled
		echo '<td><button disabled="disabled" class = "btn" type = "submit">Volunteer!</button></form>';
	}
	else{ //otherwise, output a hidden input with the event's id and a button(its handler is in the script section)
		echo '<td><input type = "hidden" name = "eventid" value = "'.mysql_result($result, $i,'id').'"/><button class = "btn signup" type = "submit">Volunteer!</button></td>';
	}
	
	echo "</tr>"; //end one row, one event
	
}   
echo "</table></div>"; //end table


include "footer.php";//include a footer

?>
