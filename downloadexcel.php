<?php
/*
	opens a tab, creates and downloads an excel sheet

*/

$query = "";
$result = "";
$username  = 'admin';
$password = 'kinkaidcs2014';

if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW']) && isset($_POST['downloadexcel'])) {
	if ($_SERVER['PHP_AUTH_USER'] == $username && $_SERVER['PHP_AUTH_PW'] == $password){
		include 'functions.php';
		include 'library/phpexcel/PHPExcel.php';
		include 'library/phpexcel/PHPExcel/Writer/Excel2007.php';
		
		$phpExcel = new PHPExcel();
		$sheet=$phpExcel->getActiveSheet();
		
		
		$phpExcel->getProperties()->setCreator("Kinkaid Community Service Council");
		$phpExcel->getProperties()->setLastModifiedBy("Kinkaid Community Service Council");
		$phpExcel->getProperties()->setTitle("Current Event Data");
		$phpExcel->getProperties()->setSubject("Current Event Data");
		$phpExcel->getProperties()->setDescription("Kinkaid Community Service Event data.");
		
		
		$row = 2;
		$col = 1;
		$query = "SELECT * FROM events WHERE closed=true ORDER by eventdate ASC"; //consider only selecting closed events
		$eventsresult = mysql_query($query); //stores the results from selecting all the events in the events tables, past and present
		for ($i = 0;$i<mysql_num_rows($eventsresult);$i++){
			$sheet->setCellValueByColumnAndRow($col,$row,mysql_result($eventsresult, $i,'eventname'));
			$col++;
		}
		$highestcol = $phpExcel->setActiveSheetIndex(0)->getHighestColumn();
		$sheet->setCellValueByColumnAndRow($col,$row,'Total');
		$row++;
		
		
		
		$col = 0;
		$query = "SELECT * FROM volunteers";

		$studentresult = mysql_query($query);//stores results of selecting all volunteers from the volunteer table
		for ($i = 0;$i<mysql_num_rows($studentresult);$i++){
			
			$studentid = mysql_result($studentresult, $i,'id');
			
			$col = 0;
			$sheet->setCellValueByColumnAndRow($col,$row,mysql_result($studentresult, $i,'firstname')." ".mysql_result($studentresult, $i,'lastname'));
			$col++;
			for ($x = 0;$x<mysql_num_rows($eventsresult)+1;$x++){
				if ($x == mysql_num_rows($eventsresult)){
					if ($highestcol != "B")
						$sheet->setCellValueByColumnAndRow($col,$row,"=SUM(B$row:$highestcol$row)");
					break;
				}
				
				$eventid = mysql_result($eventsresult, $x,'id');
				
				if (mysql_num_rows(mysql_query("SELECT * FROM signups WHERE eventid = '$eventid' AND studentid = '$studentid'"))) { 
					$sheet->setCellValueByColumnAndRow($col,$row,mysql_result($eventsresult, $x,'defaultcredits'));
				}
				else{
					$sheet->setCellValueByColumnAndRow($col,$row,0);
				}
				
				$col++;
			}
			
			$row++;	
		}
		
		
		$phpExcel->setActiveSheetIndex(0);
		
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="eventdata.xlsx"');
		header('Cache-Control: max-age=0');
		
		PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

		
		$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel2007');
		$objWriter->save('php://output');
		
	}
}





?>
