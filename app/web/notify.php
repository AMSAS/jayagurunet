<?php

		$headers = "From: admin@jayaguru.net\r\n";
		$headers.= "Reply-To: admin@jayaguru.net\r\n";
		$headers.= "MIME-Version: 1.0\r\n";
		$headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";


		include 'db.php';
		$user_query= "SELECT EmailId, Gender, First_name,(CURDATE( ) - INTERVAL 1 DAY) as Missing FROM Devotee d WHERE NOT EXISTS ";
		$user_query.= "(SELECT Devotee_id FROM Daily_transaction t WHERE t.Devotee_id = d.Devotee_id AND Dinalipi_date = (CURDATE( ) - INTERVAL 1 DAY)) ";

		$user_results = mysql_query($user_query);
		while($user_row = mysql_fetch_array($user_results)) {
			$message = "<html><body>";
			$message.= "Jayaguru ".$user_row['First_name'];
			if($user_row['Gender']=='M'){
				$message.=" Bhai";
			}else{
				$message.=" Maa";
			}
			$message.= " please enter <a href='http://diary.jayaguru.net'>Dinalipi</a>";
			$message.= "</body></html>";
			$missing = $user_row['Missing'];
			$subject='Dinalipi Reminder '.$missing;
			$emailid=$user_row['EmailId'];

			try{
				mail($emailid,$subject,$message,$headers);
			}catch(Exception $e){
    			echo 'Caught exception: ',  $e->getMessage(), "\n";
			}
		}
?>