<html>
	<head>
		<style>
		* {
		    font-family: Arial, "Times New Roman", Times, serif;
		    font-size:10px;
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

				$sangha_name = "";
				$monthly_comment = "";
				$sangha_name_query="select Sangha_master.Sangha_name,Monthly_comment.Comment from Devotee ";
				$sangha_name_query.="join Sangha_master ";
				$sangha_name_query.="on Devotee.Sangha_id=Sangha_master.Sangha_id ";
				$sangha_name_query.="left outer join Monthly_comment ";
				$sangha_name_query.="on Devotee.Devotee_id=Monthly_comment.Devotee_id and Xn_month='".$dateStart."'";
				$sangha_name_query.="where Devotee.Devotee_id='".$_SESSION['PID']."' ";
				$sangha_name_results = mysql_query($sangha_name_query);
				while($sangha_record = mysql_fetch_array($sangha_name_results)) {
					$sangha_name=$sangha_record['Sangha_name'];
					$monthly_comment=$sangha_record['Comment'];
				}

				$reportQuery=  "select Question_Seq,Question_desc,Q_response,DAY(Dinalipi_date) as day,Q_response REGEXP Question_master.success_pattern as success from Devotee ";
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
  	  			echo "<td style='text-align:center' colspan='".($days+1)."'><span style='font-size:18px;color:#000099'>Nilachala Saraswata Sangha</span><br>";
  	  			echo "<span style='font-size:12px;color:#660033'>Branch: ".$sangha_name."</span><br>";
  	  			echo "<span style='font-size:20px;color:#FF3300'>DINALIPI</span>";
  	  			echo "</td></tr>\n";
  	  			echo "<tr><td style='font-size:12px;text-align:center;font-weight: bold'>".$_SESSION['display_name']."</td>\n";
  	  			echo "<td style='font-size:12px;border:0px;text-align:center' colspan='".($days-10)."'>&nbsp;</td>\n";
  	  			echo "<td style='font-size:12px;border:0px;text-align:center' colspan='11'>".$Date->format('F,Y')."</td></tr>\n";
				echo "<tr><td style='font-size:12px;text-align:center;font-weight: bold'>Items</td>\n";
				for ($counter=1;$counter<=$days;$counter++) {
					echo "\n<td style='font-size:12px;text-align:center;font-weight: bold' width='20px'>".$counter."</td>";
				}
				echo "<td style='font-size:12px;text-align:center;font-weight: bold' width='20px'>%S</td></tr>\n";
				$success_count=0;
				$num_of_days_value_available=0;
				while($one_record = mysql_fetch_array($report_results)) {
					if($qid==-100){
						echo "<tr>";
						echo "\n<td style='font-size:12px;white-space: nowrap'>" .$one_record['Question_desc']. "</td>" ;
						$day = render_cells($curdate,$one_record,$success_count,$num_of_days_value_available);
					}else if($qid!=$one_record['Question_Seq']){
						fill_gaps($curdate,($days+1));
						echo "<td>".(round(100*$success_count/$num_of_days_value_available,2))."</td></tr>";
						$curdate=0;
						$success_count=0;
						$num_of_days_value_available=0;
						echo "<tr>";
						echo "\n<td style='font-size:12px;white-space: nowrap'>" .$one_record['Question_desc']. "</td>" ;
						$day = render_cells($curdate,$one_record,$success_count,$num_of_days_value_available);
					}else{
						$day = render_cells($curdate,$one_record,$success_count,$num_of_days_value_available);
					}
					$qid=$one_record['Question_Seq'];
					if($day>0){
						//echo "\n<!--".$curdate."/".$day."-->\n" ;
						$curdate=$day;
					}
				}
				//Fill any gaps for last question row
				fill_gaps($curdate,($days+1));
				echo "<td>".(round(100*$success_count/$num_of_days_value_available,2))."</td></tr>\n";
				echo "<tr><td cellpadding='2px' style='font-size:12px;border:0px;text-align:center' colspan='10'>Observations/Exceptions<br>";
				echo "<input type='hidden' id='dateStart' value='".$dateStart."'></input>\n";
				echo "<textarea id='monthlyComment' maxlength='1500' rows='5' cols='100' onblur='javascript:saveComments()'>".$monthly_comment."</textarea></td>\n";
				echo "<td cellpadding='2px' style='font-size:12px;border:0px;text-align:left' colspan='".($days+1-20)."'>&nbsp;<br><br>President:</td>\n";
				echo "<td cellpadding='2px' style='font-size:12px;border-left:0px;border-bottom:0px;text-align:left' colspan='11'>Shree Shree Thakura Charanashrita<br><br>Signature:</td></tr>\n";
				echo "<tr><td style='border:0px;' colspan='".($days+1+1)."'>&nbsp;</td></tr>";
				echo "<tr><td style='border:0px;' colspan='".($days+1+1)."'>&nbsp;</td></tr>";
				echo "<tr><td style='border:0px;' colspan='".($days+1+1)."'><img height='1' width='980px' src='trans.gif'><br></td></tr>";
				echo "</table>";
				echo "<div class='dontprint'>";
				$Date->modify('-1 month');
				echo "<a href='report.php?mon=".$Date->format('m')."&year=".$Date->format('Y')."'>Previous</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<a href='index.php?mon=".$month."&year=".$year."'>Calendar</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<a href='javascript:window.print();'>Print</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				echo "<a href='barchart.php?mon=".$month."&year=".$year."'>Chart</a>&nbsp;&nbsp;&nbsp;&nbsp;";
				$Date->modify('2 month');
				echo "<a href='report.php?mon=".$Date->format('m')."&year=".$Date->format('Y')."'>Next</a>";
				echo "</div>";

			}else{
  				echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
			}




function render_cells($curdate,$one_record,&$success_count,&$num_of_days_value_available){
	$day = $one_record['day'];
	fill_gaps($curdate,$day);
	if($day>0){
			//echo "\n<!--".$curdate."/".$day."-->\n" ;
			echo "\n<td style='text-align:center'>" .strtoupper($one_record['Q_response']). "</td>" ;
			$num_of_days_value_available=$num_of_days_value_available+1;
	}
	$success_count=$success_count+$one_record['success'];
	return $day;
}


function fill_gaps($curdate,$day){
	//echo "\n<!--Filling Gaps".($curdate+1)."/".($day-1)." Inclusive-->\n" ;
	if($curdate<$day-1){
		for($ctr=$curdate+1;$ctr<$day;$ctr++){
			echo "\n\t<td>&nbsp;</td>" ;
		}
	}
}

		?>
</div>

		<script>
		function saveComments()
		{
			var comments=document.getElementById("monthlyComment").value;
			var Date=document.getElementById("dateStart").value;
			var url="savecomments.php?Comment="+comments+"Xn_month="+Date;
			var xmlhttp;
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					//alert(comments);
				}
			  }
			xmlhttp.open("GET","savecomments.php?Comment="+comments+"&Xn_month="+Date,false);
			xmlhttp.send();
		}
	</script>
</body>
</html>