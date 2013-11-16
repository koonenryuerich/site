<?php
$username  = 'admin';
$password = 'kinkaidcs2014';
$query = "";
$result = "";
$eventid = 0;



if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && (isset($_POST['eventid']) || isset($_POST['PAST_eventid']))) {
	if ($_SERVER['PHP_AUTH_USER'] == $username && $_SERVER['PHP_AUTH_PW'] == $password){
		
		if ($_POST['eventid'] != ""){
			include 'header.php';

			
			$eventid = $_POST['eventid'];
			
			echo <<<END
			<style>
				table {
					table-layout:fixed;	
					
				}
				td {
					word-wrap:break-word;	
				}
				.btn-delete {
				  background-color: hsl(0, 69%, 32%) !important;
				  background-repeat: repeat-x;
				  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#d93030", endColorstr="#891919");
				  background-image: -khtml-gradient(linear, left top, left bottom, from(#d93030), to(#891919));
				  background-image: -moz-linear-gradient(top, #d93030, #891919);
				  background-image: -ms-linear-gradient(top, #d93030, #891919);
				  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #d93030), color-stop(100%, #891919));
				  background-image: -webkit-linear-gradient(top, #d93030, #891919);
				  background-image: -o-linear-gradient(top, #d93030, #891919);
				  background-image: linear-gradient(#d93030, #891919);
				  border-color: #891919 #891919 hsl(0, 69%, 27%);
				  color: #fff !important;
				  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.33);
				  -webkit-font-smoothing: antialiased;
				}
				.btn-print {
				  background-color: hsl(110, 56%, 31%) !important;
				  background-repeat: repeat-x;
				  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#53c83c", endColorstr="#317b22");
				  background-image: -khtml-gradient(linear, left top, left bottom, from(#53c83c), to(#317b22));
				  background-image: -moz-linear-gradient(top, #53c83c, #317b22);
				  background-image: -ms-linear-gradient(top, #53c83c, #317b22);
				  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #53c83c), color-stop(100%, #317b22));
				  background-image: -webkit-linear-gradient(top, #53c83c, #317b22);
				  background-image: -o-linear-gradient(top, #53c83c, #317b22);
				  background-image: linear-gradient(#53c83c, #317b22);
				  border-color: #317b22 #317b22 hsl(110, 56%, 26%);
				  color: #fff !important;
				  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.33);
				  -webkit-font-smoothing: antialiased;
				}
				.btn-email {
				  background-color: hsl(195, 60%, 32%) !important;
				  background-repeat: repeat-x;
				  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#309fc3", endColorstr="#206a82");
				  background-image: -khtml-gradient(linear, left top, left bottom, from(#309fc3), to(#206a82));
				  background-image: -moz-linear-gradient(top, #309fc3, #206a82);
				  background-image: -ms-linear-gradient(top, #309fc3, #206a82);
				  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #309fc3), color-stop(100%, #206a82));
				  background-image: -webkit-linear-gradient(top, #309fc3, #206a82);
				  background-image: -o-linear-gradient(top, #309fc3, #206a82);
				  background-image: linear-gradient(#309fc3, #206a82);
				  border-color: #206a82 #206a82 hsl(195, 60%, 28%);
				  color: #fff !important;
				  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.26);
				  -webkit-font-smoothing: antialiased;
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
			
		      <div class="masthead">
		        <h3 class="muted">Event details for: $eventname</h3>
		        <div class="navbar">
		          <div class="navbar-inner">
		            <div class="container">
		              <ul class="nav">
		        		<li><a href = "dashboard.php">Dashboard</a></li>
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
		                <li ><a href = 'signup.php'>Sign Up</a></li>
		              </ul>
		            </div>
		          </div>
		        </div><!-- /.navbar -->
		      </div>
END;
			echo "<div class = 'container'>\n";
			
			
			
			echo <<<END
			<form style = 'display:inline;' action = 'editevent.php' method = 'post'>
				<input type  = 'hidden' name = 'eventid' value = '$eventid'/>
				<button type = 'submit' class = 'btn btn-primary'>Edit Event Details</button>
			</form>
			<form target = "_blank" style = 'display:inline;' action = 'printattendance.php' method = 'post'>
					<input type = "hidden" name = "eventid" value = "$eventid"/>
					<button type = 'submit' class = 'btn btn-print' name = 'printattendance'>Print Attendance Sheet</button>
			</form>	
			<form target = "_blank" style = 'display:inline;' action = 'emailvolunteers.php' method = 'post'>
					<input type = "hidden" name = "eventid" value = "$eventid"/>
					<button  name = 'emailvolunteers' class = 'btn btn-email' onsubmit = ''>Email Students & Parents</button>
			</form>	
			<form  id='closeevent' style = 'display:inline;float:right' action = 'dashboard.php' method = 'post' >
					<input type = "hidden" name = "eventid" value = "$eventid"/>
					<input type = "hidden" name = "closeevent"/>
					<button type = 'submit' class = 'btn btn-delete'>Close Event</button>		
			</form>		
			
END;

			
			echo <<<END
			<script>
				$(document).ready(function()
				{

				    $(document.body).on('click', 'td button.delete', function() {

						var id = $(this).attr('value');
						var data = 'id='+id+'&eventid='+$eventid;
						var parent = $(this).parent().parent();
						var firstName = parent.find('td:first-child').text();
                        var lastName = parent.find('td:nth-child(2)').text();

						bootbox.confirm("Are you sure you want to remove this volunteer from the list?", function(result) {
				        if (result) {
							$.ajax(
							{
								type: "POST",
								url:"delete.php",
								data:data,
								cache: false,
								success: function()
								{
									parent.fadeOut('slow', function()
									{
										$(this).remove();
										$('#studentpicker').append('<option value='+id+'>'+firstName+' '+lastName+'</option>');
								        $('.selectpicker').selectpicker('refresh'); //requried to update the ui component after deleting an option


									});

								}
							});

					   		 }
						});
                    });


									
									
					$('#closeevent').submit(function(e) {
						e.preventDefault();
					    var currentForm = this;
					    bootbox.confirm("Are you sure you want to close this event? This change is permanent!", function(result) {
					        if (result) {
					            currentForm.submit();
					        }
					    });
					});			
									
					
									
					$('.selectpicker').selectpicker();	

									
					$('#addstudent').click(function(e){
						e.preventDefault();
						var id = $('#studentpicker').val();
						var parent = $('#volunteers');
						
						if (id!='default'){
							var data = 'id='+id+'&eventid='+$eventid;
							info = new Array();
							$.ajax(
							{
								type: "POST",
								url:"addvolunteer.php",
								data:data,
								cache: false,
								success: function(data)
								{
									info = JSON.parse(data);
									$('#volunteers tr:last').after('<tr><td>'+info.firstname+'</td><td>'+info.lastname+'</td><td>'+info.grade+'</td><td></td><td><button  class = \'delete btn btn-delete\' value = '+id+'>Delete Volunteer</button></td></tr>');
                                    $('#studentpicker option[value='+id+']').remove();
								    $('.selectpicker').selectpicker('refresh'); //requried to update the ui component after deleting an option
								}
							});		
									
							
								
						}
						
						
					});
				});
								

					
			</script>
					
					
					
		<h3>Volunteers:</h3>
		<table id = 'volunteers' class = 'table'>			
		<tr>
		      <th>First Name</th>
		      <th>Last Name</th>
		      <th>Grade</th>
		      <th>Notes</th>
			  <th>Delete</th>
		</tr>
END;
			


			$query = "SELECT * FROM volunteers";
			$result = queryMySql($query);
			/*Now I have in results all the ids of students who signed up for an event*/
			
			$students = array(); //students who are signed up
			$otherstudents = array(); //students who are not signed up
			
			
			$numrows = mysql_num_rows($result);
			for ($i = 0;$i<$numrows;$i++){
				$studentid = mysql_result($result, $i,'id');
				$query = "SELECT * FROM signups where studentid=$studentid AND eventid=$eventid";
				$signupsresult = queryMySql($query);
				if (mysql_num_rows($signupsresult)>0){
					$students[$studentid] = mysql_result($result, $i,'lastname');
				}
				else{
					$otherstudents[$studentid] = mysql_result($result, $i,'lastname');
				}
								
			}
			asort($students); 
			asort($otherstudents);
			

			
			/*Created an array of students' lastname to their ids, and sorted it alphabetically by last name*/
			foreach ($students as $id => $value){
				$studentresult = queryMySql("SELECT * FROM volunteers where id=$id");
				echo "<tr><td id = 'firstname' height = '100'>".mysql_result($studentresult, 0,'firstname')."</td>";
				echo "<td id = 'lastname'>".mysql_result($studentresult, 0,'lastname')."</td>";
				echo '<td>'.mysql_result($studentresult, 0,'grade').'</td>';
				
				
				$query = "SELECT * FROM signups where studentid=$id AND eventid=$eventid";
				$noteresult = mysql_query($query);
				echo '<td>'.mysql_result($noteresult, 0,'extra').'</td>';
				
				echo "<td ><button  class = 'delete btn btn-delete' value = '$id'>Delete Volunteer</button></td>";
				echo "</tr>";
			}
			

			echo "</table></div>";
			echo "<select id='studentpicker' class='selectpicker' data-width='200px' data-size='10' data-live-search='true' >";
			
			echo"<option value=default >Select one--</option>";
	
			
			foreach ($otherstudents as $id => $value){
				$studentresult = queryMySql("SELECT * FROM volunteers where id=$id");
				echo "<option value=$id>".mysql_result($studentresult, 0,'firstname').' '.mysql_result($studentresult, 0,'lastname')."</option>";
			}
			

			
			
			echo "</select><br>";
			echo <<<END
			<form id='addstudentform' style = 'display:inline;' action = 'eventinfo.php' method = 'post'>
				<input type  = 'hidden' name = 'eventid' value = '$eventid'/>
				<button id = 'addstudent' type = 'submit' class = 'btn btn-print' >Add Student</button>
			</form>
END;
		
			
			
			
			
		}else if ($_POST['PAST_eventid'] != ""){ //Viewing a past event
			
			include 'header.php';
			
				
			$eventid = $_POST['PAST_eventid'];
			$query = "SELECT * from events where id=$eventid";
			$result = mysql_query($query);
			$eventname = mysql_result($result, 0,'eventname');
			echo <<<END
			<style>
				table {
					table-layout:fixed;
			
				}
				td {
					word-wrap:break-word;
				}
				.btn-delete {
				  background-color: hsl(0, 69%, 32%) !important;
				  background-repeat: repeat-x;
				  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#d93030", endColorstr="#891919");
				  background-image: -khtml-gradient(linear, left top, left bottom, from(#d93030), to(#891919));
				  background-image: -moz-linear-gradient(top, #d93030, #891919);
				  background-image: -ms-linear-gradient(top, #d93030, #891919);
				  background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #d93030), color-stop(100%, #891919));
				  background-image: -webkit-linear-gradient(top, #d93030, #891919);
				  background-image: -o-linear-gradient(top, #d93030, #891919);
				  background-image: linear-gradient(#d93030, #891919);
				  border-color: #891919 #891919 hsl(0, 69%, 27%);
				  color: #fff !important;
				  text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.33);
				  -webkit-font-smoothing: antialiased;
				}


			</style>
			<script>
				$(document).ready(function(){
					$('#deleteevent').submit(function(e) {
						e.preventDefault();
					    var currentForm = this;
					    bootbox.confirm("Are you sure you want to DELETE this event? All data will be lost!", function(result) {
					        if (result) {
					            currentForm.submit();
					        }
					    });
					});		
					
					
				});
					
					
			</script>
			
			
			</head>
END;
			echo <<<END
			<body>
		
		    <div class="container">
		
		      <div class="masthead">
		        <h3 class="muted">Event details for: $eventname</h3>
		        <div class="navbar">
		          <div class="navbar-inner">
		            <div class="container">
		              <ul class="nav">
		        		<li><a href = "dashboard.php">Dashboard</a></li>
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
		                <li ><a href = 'signup.php'>Sign Up</a></li>
		              </ul>
		            </div>
		          </div>
		        </div><!-- /.navbar -->
		      </div>
END;
			echo "<div class = 'container'>\n";
				
				
				
			echo <<<END

			<form  id='deleteevent' style = 'display:inline' action = 'dashboard.php' method = 'post' >
					<input type = "hidden" name = "eventid" value = "$eventid"/>
					<input type = "hidden" name = "deleteevent"/>
					<button type = 'submit' class = 'btn btn-delete'>Delete Event</button>
			</form>
		
END;

		
						echo <<<END
						
			
			
			
		<h3>Volunteers:</h3>
		<table id = 'volunteers' class = 'table'>
		<tr>
		      <th>First Name</th>
		      <th>Last Name</th>
		      <th>Grade</th>
		      <th>Notes</th>
		</tr>
END;
		
			
			
			$query = "SELECT * FROM volunteers";
			$result = queryMySql($query);
			/*Now I have in results all the ids of students who signed up for an event*/
		
			$students = array(); //students who are signed up
			$otherstudents = array(); //students who are not signed up
		
		
			$numrows = mysql_num_rows($result);
			for ($i = 0;$i<$numrows;$i++){
				$studentid = mysql_result($result, $i,'id');
				$query = "SELECT * FROM signups where studentid=$studentid AND eventid=$eventid";
				$signupsresult = queryMySql($query);
				if (mysql_num_rows($signupsresult)>0){
					$students[$studentid] = mysql_result($result, $i,'lastname');
				}
				else{
					$otherstudents[$studentid] = mysql_result($result, $i,'lastname');
				}
			
			}
			asort($students);
			asort($otherstudents);
		
			
		
			/*Created an array of students' lastname to their ids, and sorted it alphabetically by last name*/
			foreach ($students as $id => $value){
				$studentresult = queryMySql("SELECT * FROM volunteers where id=$id");
				echo "<tr><td id = 'firstname' height = '100'>".mysql_result($studentresult, 0,'firstname')."</td>";
				echo "<td id = 'lastname'>".mysql_result($studentresult, 0,'lastname')."</td>";
				echo '<td>'.mysql_result($studentresult, 0,'grade').'</td>';
			
			
				$query = "SELECT * FROM signups where studentid=$id AND eventid=$eventid";
				$noteresult = mysql_query($query);
				echo '<td>'.mysql_result($noteresult, 0,'extra').'</td>';
			
				echo "</tr>";
			}
		
			
			echo "</table></div>";
		

			
			
			
			
			
			
		}
		
		
	}
	else{
		header('WWW-Authenticate: Basic realm="Restricted Section"');
		header('HTTP/1.0 401 Unauthorized');
		die("Please enter your username and password");
	
	}
}
else{
	echo "Error loading page. Please return to the <a href = 'index.php'>home page</a>.";
}




?>
<hr>
   
   
   <div class="footer">
        <p>© Kinkaid</p>
   </div>
      
      
      
</body>
</html>
