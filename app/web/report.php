<html>
	<head>
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
		.alignCenter { margin-left: auto; margin-right: auto;}
		</style>
		<style type="text/css" media="print">
		.dontprint	{ display: none; }
		</style>
	</head>
	<body width="100%">
	<div style="text-align:center">
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

				$Date = new DateTime($dateStart);

				$reportQuery=  "select Question_Seq,Question_desc,Q_response,DAY(Dinalipi_date) as day from Devotee ";
				$reportQuery.= "join Question_master ";
				$reportQuery.= "on Devotee.Member_Category=Question_master.Member_Category ";
				$reportQuery.= "left outer join Daily_transaction  ";
				$reportQuery.= "on ( ";
				$reportQuery.= "Devotee.Devotee_id=Daily_transaction.Devotee_id AND  ";
				$reportQuery.= "Question_master.Question_id=Daily_transaction.Question_id AND ";
				$reportQuery.= "Dinalipi_date between '".$dateStart."' and '".$dateEnd."' ";
				$reportQuery.= ") ";
				$reportQuery.="where Devotee.Devotee_id='".$_SESSION['PID']."' ";
				//$reportQuery.="and Devotee.Devotee_id='-1' ";
				$reportQuery.="order by Question_Seq,Dinalipi_date";

				//echo $reportQuery;

				$report_results = mysql_query($reportQuery);
				$qid=-100;
				$curdate=0;
  	  			echo "<table class='alignCenter' cellspacing='0' cellpadding='1'>\n";
  	  			echo "<tr><td style='text-align:center'><img height='100' src='/images/orgnz.gif'/></td>";
  	  			echo "<td style='text-align:center' colspan='".($days)."'><span style='font-size:18px;color:#000099'>Nilachala Saraswata Sangha</span><br>";
  	  			echo "<span style='color:#660033'>Branch: America Saraswata Sangha</span><br>";
  	  			echo "<span style='font-size:20px;color:#FF3300'>DINALIPI</span>";
  	  			echo "</td></tr>\n";
  	  			echo "<tr><td style='text-align:center;font-weight: bold'>".$_SESSION['display_name']."</td>\n";
  	  			echo "<td style='border:0px;text-align:center' colspan='".($days-10)."'>&nbsp;</td>\n";
  	  			echo "<td style='border:0px;text-align:center' colspan='10'>".$Date->format('F,Y')."</td></tr>\n";
				echo "<tr><td style='text-align:center;font-weight: bold'>Items</td>\n";
				for ($counter=1;$counter<=$days;$counter++) {
					$Date = new DateTime($year."-".$month."-".$counter);
					echo "\n<td style='text-align:center;font-weight: bold' width='20px'>".$Date->format('d')."</td>";
				}
				echo "</tr>\n";
				while($one_record = mysql_fetch_array($report_results)) {
					if($qid==-100){
						echo "<tr>";
						echo "\n<td style='white-space: nowrap'>" .$one_record['Question_desc']. "</td>" ;
						$day = $one_record['day'];
						fill_gaps($curdate,$day);
						echo "\n<td style='font-size:10px'>" .strtoupper($one_record['Q_response']). "</td>" ;
					}else if($qid!=$one_record['Question_Seq']){
						fill_gaps($curdate,$days);
						echo "</tr>";
						$curdate=0;
						echo "<tr>";
						echo "\n<td style='white-space: nowrap'>" .$one_record['Question_desc']. "</td>" ;
						$day = $one_record['day'];
						fill_gaps($curdate,$day);
						echo "\n<td style='font-size:10px'>" .strtoupper($one_record['Q_response']). "</td>" ;
					}else{
						$day = $one_record['day'];
						fill_gaps($curdate,$day);
						echo "\n<td style='font-size:10px'>" .strtoupper($one_record['Q_response']). "</td>" ;
					}
					$qid=$one_record['Question_Seq'];
					$curdate=$day;
				}
				//Fill any gaps for last question row
				fill_gaps($curdate,$days);
				echo "</tr>\n";
				echo "<tr><td cellpadding='2px' style='border:0px;text-align:center' colspan='10'>Observations/Exceptions<br><br>&nbsp;</td>\n";
				echo "<td cellpadding='2px' style='border:0px;text-align:left' colspan='".($days+1-20)."'>&nbsp;<br><br>President:</td>\n";
				echo "<td cellpadding='2px' style='border-left:0px;border-bottom:0px;text-align:left' colspan='10'>Shree Shree Thakura Charanashrita<br><br>Signature:</td></tr>\n";
				echo "<tr><td style='border:0px;' colspan='".($days+1)."'>&nbsp;</td></tr>";
				echo "<tr><td style='border:0px;' colspan='".($days+1)."'>&nbsp;</td></tr>";
				echo "<tr><td style='border:0px;' colspan='".($days+1)."'>&nbsp;</td></tr>";
				echo "</table>";
				echo "<div class='dontprint'>";
				echo "<a href='index.php?mon=".$month."&year=".$year."'>Back to Calendar</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<a href='javascript:window.print();'>Print</a>";
				echo "</div>";

			}else{
  				echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
			}





function fill_gaps($curdate,$day){
	if($curdate<$day-1){
		echo "\n<!--".$curdate."/".$day."-->\n" ;
		for($ctr=$curdate+1;$ctr<$day;$ctr++){
			echo "\n\t<td style='font-size:10px'>&nbsp;</td>" ;
		}
	}
}
		?>
</div>
</body>
</html>