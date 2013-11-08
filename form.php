<?php
include 'header.php';
if (isset($_POST['eventid'])) $eventid = $_POST['eventid'];
else die("Error confirming sign up. Please return to previous page.");
//put any specific styles here
echo <<<END
	<style type = "text/css">
		.margindiv{
			margin-left:60px;
		}
		
	</style>
	
		
	</head>
END;

$query = "SELECT * from events where id=$eventid";
$result = mysql_query($query);
$eventname = mysql_result($result, 0,'eventname');

echo <<<END
<body>
<div class="container">
  <div class="row">
    <div class = "margindiv">
	<h3 class = "muted">Confirm Sign Up</h3>
	<form class = "form-horizontal" action = "signup.php" method = "POST">
		<fieldset>
		<legend>You are signing up for Event: $eventname</legend>
		<p>If there is anything we should know about, please put it in the 'Notes' section. Otherwise, just hit sign up!</p><br>
		<input type = "hidden" name = "eventid" value = "$eventid"/>
				

				
				
		<div class = "control-group">
			<label class = "control-label" for ="input01">Notes:</label>
			<div class = "controls">
				<textarea name = "notes" cols "200" rows = "6" wrap ="type" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;">
Write things you want us to know about here (reasons why you might not be able to come, etc.)</textarea>
			</div>
		</div>		

				
				
		<div class = "form-actions">
			<button name = 'signup' type = "submit" class = "btn btn-primary">Sign Me Up!</button>
			<button class = "btn">Nevermind</button>
		</div>
	
		</fieldset>
				
	</form>
	</div>
</div>
</div>
END;





?>
</body>
</html>
