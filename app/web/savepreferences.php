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
					$insertQuery = "insert into Personal_default(Devotee_id,Question_id,Default_value) values('".$_SESSION['PID']."','".$key."','".$value."')";
					//echo $insertQuery;
					//echo "<br>";
					$insert_results = mysql_query($insertQuery);
					if(!$insert_results){
						$updateQuery = "update Personal_default set Default_value='".$value."' where Devotee_id='".$_SESSION['PID']."' and Question_id='".$key."'";
						//echo $updateQuery;
						//echo "<br>";
						$update_results = mysql_query($updateQuery);
						if(!$update_results){
							$errorCount=$errorCount+1;
						}
					}
				}
				if($errorCount==0){
  					echo "<a href='index.php'>Preferences Updated</a>";
  				}else{
  					echo "<a href='index.php'>Failed to Save/Update Preferences ".$errorCount." Records </a>";
  				}
			}else{
  				echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
			}
		?>
	  </div>
</body>
</html>