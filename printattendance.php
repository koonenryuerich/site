<?php

/*
	opens a new tab and prints an attendance sheet

*/
$query = "";
$result = "";

if (isset($_POST['printattendance']) && isset($_POST['eventid'])){
		if ($_POST['eventid'] != ""){
			include 'header.php';
			echo <<<END
			<script>
				window.print();
				window.onfocus=function(){ window.close();}
					
			</script>
			
END;
			
			$eventid = $_POST['eventid'];
			$query = "SELECT * from events where id=$eventid";
			$result = mysql_query($query);
			$eventname = mysql_result($result, 0,'eventname');
			echo <<<END
			<body>
		
		    <div class="container">
		
		      
END;
			echo "<div class = 'container'>\n";
			
			echo "<h3>Volunteers for Event: $eventname</h3>";
			echo "<table class = 'table'>";
			echo <<<END
						<tr>
		      <th>First Name</th>
		      <th>Last Name</th>
		      <th>Grade</th>
			  <th>Advisor</th>
			  <th>Attended</th>
		</tr>
END;
			
			$query = "SELECT * FROM signups WHERE eventid = $eventid";
			$result = queryMySql($query);
			/*Now I have in results all the ids of students who signed up for an event*/
				
			$students = array();
			$numrows = mysql_num_rows($result);
			for ($i = 0;$i<$numrows;$i++){
				$studentid = mysql_result($result, $i,'studentid');
				$query = "SELECT * FROM volunteers where id=$studentid";
				$studentresult = queryMySql($query);
				//$students[mysql_result($studentresult, $i,'lastname')] = $studentid;
				$students[$studentid] = mysql_result($studentresult, $i,'lastname');
			}
			asort($students);
			/*Created an array of students' lastname to their ids, and sorted it alphabetically by last name*/
			foreach ($students as $id => $value){
				echo "<tr>";
				$studentresult = queryMySql("SELECT * FROM volunteers where id=$id");
				echo "<td id = 'firstname' height = '100'>".mysql_result($studentresult, 0,'firstname')."</td>";
				echo "<td id = 'lastname'>".mysql_result($studentresult, 0,'lastname')."</td>";
				echo '<td>'.mysql_result($studentresult, 0,'grade').'</td>';
				$noteresult = queryMySql("SELECT * FROM signups where studentid=$id AND eventid=$eventid");
				echo "<td>".mysql_result($studentresult, 0,'advisor');
				echo "<td >YES / NO</td";
				echo "</tr>";
			}
					
					
				echo "</table></div>";

		

		}
		else{
			echo "Error loading attendance list. Please try again.";
		}

		
}
else{
	echo "Error printing attendance list. Please try again.";
}
	



?>
<hr>
   
   
   <div class="footer">
        <p>© Kinkaid</p>
   </div>
      
      
      
</body>
</html>
