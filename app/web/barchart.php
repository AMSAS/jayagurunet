<html>
	<head>
			<meta name="viewport" content="width=480">
			<style>
				* {
					font-family: Arial, "Times New Roman", Times, serif;
					font-size:12px;
				}
				.alignCenter { margin-left: auto; margin-right: auto;}
			</style>
	</head>
	<body>
		<table class='alignCenter' cellspacing="0" cellpadding="0">
				<?php
					session_start();
					if (isset($_SESSION['PID'])) {
						include 'db.php';

						$year=date('Y');
						if(isset($_GET['year'])){
							$year=$_GET['year'];
						}

						$month=date('m');
						if(isset($_GET['mon'])){
							$month=$_GET['mon'];
						}
						$days = date('t',mktime(0,0,0,$month,1,$year));

						$dateStart=$year.'-'.$month.'-01';
						$dateEnd=$year.'-'.$month.'-'.$days;
						$reportQuery=  "SELECT DAY(Dinalipi_date) as day, count( DISTINCT Devotee_id ) as cnt FROM Daily_transaction ";
						$reportQuery.= "where Dinalipi_date between '".$dateStart."' and '".$dateEnd."' GROUP BY Dinalipi_date ";
						$report_results = mysql_query($reportQuery);
						$one_record = mysql_fetch_array($report_results);
  						echo "<tr><td style='text-align:center' colspan='".$days."'><img src='/images/orgnz.gif'/></td></tr>";
						echo "<tr>";
						for ($counter=1;$counter<=$days;$counter++) {
							echo "<td style='vertical-align:bottom;'>";
							if($counter%2==1){
								echo "<div style='background-color:cyan;'>";
							}else{
								echo "<div style='background-color:purple;'>";
							}
							$num_devotee=0;
							if($one_record){
								if($one_record['day']==$counter){
									$num_devotee=$one_record['cnt'];
									$one_record = mysql_fetch_array($report_results);
								}
							}
							echo "<img src='trans.gif' height='".($num_devotee*10)."px' width='20px' title='".$num_devotee." submitted dinalipis'/>";
							echo "</div></td>";
						}
						echo "</tr>";
						echo "<tr>";
						for ($counter=1;$counter<=$days;$counter++) {
							if($counter%2==1){
								echo "<td width='20px' style='background-color:cyan;text-align:center'>".$counter."</td>";
							}else{
								echo "<td width='20px' style='background-color:purple;text-align:center'>".$counter."</td>";
							}
						}
						echo "</tr>";
						$Date = new DateTime($dateStart);
  						echo "<tr><td style='text-align:center' colspan='".$days."'><h1>".$Date->format('F')."</h4></td></td>";
						$Date->modify('-1 month');
  						echo "<tr><td style='text-align:center' colspan='".$days."'>";
						echo "<a href='barchart.php?mon=".$Date->format('m')."&year=".$Date->format('Y')."'>".$Date->format('F')."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
  						echo "<a href='report.php?mon=".$month."&year=".$year."'>Report</a>&nbsp;&nbsp;&nbsp;&nbsp;";
  						echo "<a href='index.php?mon=".$month."&year=".$year."'>Calendar</a>&nbsp;&nbsp;&nbsp;&nbsp;";
						$Date->modify('2 month');
						echo "<a href='barchart.php?mon=".$Date->format('m')."&year=".$Date->format('Y')."'>".$Date->format('F')."</a></td></tr>";
					}else{
  						echo "<tr><td><a href='index.php'>[Session Expired] Visit Landing Page</a></td></tr>";
					}
				?>
		</table>
	</body>
</html>