<?php
	session_start();
	include 'db.php';
	$Seva_cat='Event';
	if (isset($_REQUEST['Seva_cat'])){
		$Seva_cat=$_REQUEST['Seva_cat']; 
	}
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
With divine grace of Shri Shri Thakura, I have been joining in the sangha puja sessions of America Saraswata Sangha regularly. I desire to continue joining the sangha puja sessions for the coming year.<br>
</p>

<p>I promise that I will join the puja sessions regularly.  I also promise that I will inform the president and secretary about any scheduled absence from the puja sessions in advance via email. I understand that my absence from the puja sessions for three consecutive weeks without permission may result in termination of my privilege of joining the sangha session.  Kindly grant the permission to join America Saraswata Sangha as a darshak (Guest) for next year.
</p>
<p>
Shri Shri Thakuracharanashrita
</p>
<p>
<?php echo $_REQUEST['First_name']; ?> <?php echo $_REQUEST['Last_name']; ?><br>
Place: USA					             <br>
Date:<?php echo date("Y-m-d"); ?>  <br>
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