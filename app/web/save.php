<html>
	<head>
	</head>
	<body>
	  <div style="text-align:center">
  	  <img src="/images/orgnz.gif"/><br>
		<?php
			session_start();
			if (isset($_SESSION['PID'])) {
				include 'db.php';
				$errorCount=0;
				foreach ($_POST as $key => $value){
					$insertQuery = "insert into Daily_transaction(Devotee_id,Dinalipi_date,Question_id,Q_response) values('".$_SESSION['PID']."','".$_GET['Date']."','".$key."','".$value."')";
					//echo $insertQuery;
					//echo "<br>";
					$insert_results = mysql_query($insertQuery);
					if(!$insert_results){
						$updateQuery = "update Daily_transaction set Q_response='".$value."' where Devotee_id='".$_SESSION['PID']."' and Dinalipi_date='".$_GET['Date']."' and Question_id='".$key."'";
						//echo $updateQuery;
						//echo "<br>";
						$update_results = mysql_query($updateQuery);
						if(!$update_results){
							$errorCount=$errorCount+1;
						}
					}
				}
				if($errorCount==0){
  					echo "<a href='index.php'>Dinalipi Updated For ".$_GET['Date']."</a>";
  				}else{
  					echo "<a href='index.php'>Failed to Save/Update ".$errorCount." Records </a>";
  				}
			}else{
  				echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
			}
		?>
	  </div>
</body>
</html>