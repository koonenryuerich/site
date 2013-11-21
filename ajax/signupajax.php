<?php
/*Ajax 
Script*/

include '../header.php';

if (isset($_POST['id']) && isset($_POST['eventid'])){

        $eventid = $_POST['eventid'];
        $studentid = $_POST['id'];

        if (isset($_POST['notes'])){
			if ($_POST['notes'] != ""){
                $notes = sanitizeString($_POST['notes']);
                $query = "insert into signups(eventid,studentid,extra) values($eventid,$studentid,'$notes')";
                $result = mysql_query($query);
            }
        }
        else{
            $query = "insert into signups(eventid,studentid) values($eventid,$studentid)";
            $result = mysql_query($query);
        }
        $query = "select * from events where id = $eventid";
        $result = mysql_query($query);
        $eventname = mysql_result($result, 0,'eventname');

        //email the student a confirmation email
		require '../library/phpmailer/class.phpmailer.php';
		
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


	
}else{
}



?>
