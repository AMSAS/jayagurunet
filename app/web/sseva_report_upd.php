<?php
	session_start();
	include 'db.php';
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
table {
	border-collapse: collapse;
}
table, td, th {
	border: 1px solid black;
}
.alignCenter {
 margin-left: auto; margin-right: auto;
}

td.alignRight {
 text-align:right;
}

input[type="text"] {
    width: 100px;
}
input[type="number"] {
    width: 100px;
}
select{
    width: 100px;
}
</style>

</head>
	<body width="100%">
		<div style="text-align:center">
		  <h2><a href="http://diary.jayaguru.net/">America Saraswata Sangha</a></h2>
		  <h4>Sammilani Seva Applicants <?php echo date("Y"); ?></h4>
		<?php
			if (isset($_SESSION['PID']) && isAllowed($GLOBALS[ROLE_SA])) {
				//var_dump($_POST);
				if(isset($_POST['Submitted'])){
					//Delete existing records
					$query="update Seva_xn set Seba_mukhya='N' where Sammilani_year=YEAR(CURDATE())";
					$results=mysql_query($query);
					if($results){
						echo "<h4>Reset Mukhya</h4>\n";
					} else {
						echo "<h4>Reset Mukhya failed</h4>\n";
					}
						
					foreach( $_POST['Mukhya'] as $D_id ) {
						$position = strpos($D_id,"_");
						$Seva_id = substr($D_id,0,$position);
						$Devotee_id = substr($D_id,$position+1);
						$query="update Seva_xn set Seba_mukhya='Y' where Sammilani_year=YEAR(CURDATE()) and Seva_id=".$Seva_id." and Devotee_id=".$Devotee_id;
						$results=mysql_query($query);
						//echo $query."<br>\n";
					}
					echo "<h4>Seva Application Saved</h4>\n";
				}

				$report_query="SELECT Seva_name,
							Seva_master.Seva_id,
							Devotee.Devotee_id,
							Pref_name Sevakas,
							Seba_mukhya Mukhyas
							FROM Seva_xn  JOIN Devotee ON ( Devotee.Devotee_id = Seva_xn.Devotee_id AND Seva_xn.Sammilani_year = YEAR( CURDATE( ) ) )
							RIGHT OUTER JOIN Seva_master ON ( Seva_master.Seva_id = Seva_xn.Seva_id )
							ORDER BY Seva_master.Seva_id,Pref_name";

				//echo $user_query."<br>\n";
				$report_results = mysql_query($report_query);
				if($report_results){
		?>

					<form method='post'>
					<input type='hidden' name='Submitted' value='true'/>
					<table class='alignCenter' cellspacing='0' cellpadding='0'>
					<tr><td><b>Seva Name</b></td><td><b>Mukhyas</b></td><td><b>Sevakas</b></td></tr>
					
					<?php
						while($report_row = mysql_fetch_assoc($report_results)) {
					?>
					<tr>
						<td><?php echo $report_row['Seva_name']; ?></td><td>
						<?php 
								if(isset($report_row['Sevakas'])){
									if($report_row['Mukhyas']=='Y') {
							?>
						<input type='checkbox' name='Mukhya[]' value='<?php echo $report_row['Seva_id']?>_<?php echo $report_row['Devotee_id']?>' checked>
						<?php
							}else{
							?>
						<input type='checkbox' name='Mukhya[]' value='<?php echo $report_row['Seva_id']?>_<?php echo $report_row['Devotee_id']?>'>
						<?php 
								}
							}?>
						</td><td><?php echo $report_row['Sevakas']; ?></td>
					</tr>
					<?php
							}
					?>
					<tr><td colspan='2'><a href='sseva_report.php'>Applicants</a></td><td><input type='submit' value='Save'></td></tr>
					</table>
				</form>
		<?php
				}
			}else{
		?>
		  		<a href='index.php'>[Session Expired] Visit Landing Page</a>
		<?php
			}
		?>
		</div>
	</body>
</html>