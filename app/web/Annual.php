<?php
	session_start();
	include 'db.php';
	$Seva_cat='Event';
	$AmYear = new DateTime('NOW');
	$AmYear->add(new DateInterval('P1M'));
	if (isset($_REQUEST['Seva_cat'])){
		$Seva_cat=$_REQUEST['Seva_cat']; 
	}

	$SubmitTime = new DateTime('NOW');
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="styles/media-detect.css">
<meta name="viewport" content="width=480">
<style class="cp-pen-styles">

.invalid input:invalid {
    background: #BE4C54;
}

.invalid input:valid {
    background: #17D654 ;
}

input {
  display: block;
}
</style>

<style>
* {
	font-family: Arial, "Times New Roman", Times, serif;
	font-size:12px;
}
.container{
width: 800px;
text-align:left;
}
</style>

</head>
	<body>
		<div class="container">
		
		To:<p>
	Respected President of America Saraswata Sangha.</p>
<p>
Dear Sir,
</p>
<p>
With divine grace of Shri Shri Thakura, I am a member of Nilachala Saraswata Sangha with a parichaya patra, I have been regularly worshiping Sri Sri thakura at my residence and also regularly  attending the sangha puja sessions of America Saraswata Sangha. I desire to continue joining the sangha puja sessions and participate in sangha puja pali when my turn comes in year  <?=$AmYear->format("Y")?>. I also desire to perform the following seva.<br>
</p>

<?php
			if (isset($_SESSION['PID'])) {
				$report_query="SELECT Seva_name,lower(Status) xnstatus,Entry_time FROM Seva_master,Seva_xn 
								WHERE Seva_master.Seva_cat='".$Seva_cat."' and
								Seva_master.Seva_id=Seva_xn.Seva_id
								and Seva_xn.Sammilani_year = YEAR( CURDATE() + INTERVAL 1 MONTH )
								and Seva_xn.Devotee_id=".$_REQUEST['Devotee_id'];
				
				//echo $report_query."<br>\n";
				$report_results = mysql_query($report_query);
				if($report_results){
		?>
		
					<ul style="list-style-type:disc">
					
		<?php			
			while($report_row = mysql_fetch_assoc($report_results)) {
		?>
						<li><?php echo $report_row['Seva_name']; ?> (<?php echo $report_row['xnstatus']; ?>)</li>
		<?php			
						$SubmitTime=$report_row['Entry_time'];
					}
		?>
					</ul>
		<?php
				}
			}
		?>

<p>I promise that I will try my best to perform these sevas, I will read the assigned books before the sangha puja sessions, and I will practice assigned songs before the session such that the sangha puja sessions goes smoothly.  While performing the seva I will keep my focus on the seva and will not be affected by actions of others.  I also promise that I will inform the president and secretary about any scheduled absence from the puja sessions via email. I understand that my absence from the puja sessions for three consecutive weeks without permission may result in termination of my membership from the sangha. Kindly grant the permission for the sevas described above.
</p>
<p>
Shri Shri Thakuracharanashrita
</p>
<p>
<?php echo $_REQUEST['First_name']; ?> <?php echo $_REQUEST['Last_name']; ?><br>
Place: USA					             <br>
Date: <?=$SubmitTime?>  <br>
</p>          


<b>Approved By:</b>
<?php
		if (isset($_SESSION['PID'])) {
			$report_query="SELECT sm.Seva_name,d.First_name,d.Last_name FROM Seva_master sm,Seva_xn xn,Devotee d
							WHERE sm.Seva_cat='".$Seva_cat."' 
							and	sm.Seva_id=xn.Seva_id
							and xn.Status='APPROVED'
							and xn.Sammilani_year = YEAR( CURDATE() + INTERVAL 1 MONTH )
							and xn.Reviewer_id=d.Devotee_id
							and xn.Devotee_id=".$_REQUEST['Devotee_id'];
			
			//echo $report_query."<br>\n";
			$report_results = mysql_query($report_query);
			if($report_results){
				if($report_row = mysql_fetch_assoc($report_results)) {
						echo $report_row['First_name']." ".$report_row['Last_name'];
				}else{
						echo 'Approval Pending';
				}
			}else{
		?>
		  		<a href='index.php'>[Session Expired] Visit Landing Page</a>
		<?php			
			}
		}
		?>
		</div>
	</body>
</html>