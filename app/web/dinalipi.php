<html>
<head>
</head>
<body>
<div class="box">
  <div class="request">
<?php
	session_start();
	if (isset($_SESSION['PID'])) {
		$selectedDay = new DateTime($_GET['Date']);
		$previousDay = new DateTime($_GET['Date']);
		$previousDay->modify('-1 day');
		$nextDay = new DateTime($_GET['Date']);
		$nextDay->modify('+1 day');

		include 'db.php';
		$user_query= "select ";
		$user_query.= "Question_master.Question_desc qdesc, ";
		$user_query.= "Question_master.Question_id as qid, ";
		$user_query.= "coalesce(Daily_transaction.Q_response,Personal_default.Default_value,Question_master.Default_value) as qanswer ";
		$user_query.= "from Devotee ";
		$user_query.= "join Question_master ";
		$user_query.= "on Devotee.Member_Category=Question_master.Member_Category ";
		$user_query.= "left outer join Daily_transaction  ";
		$user_query.= "on ( ";
		$user_query.= "Devotee.Devotee_id=Daily_transaction.Devotee_id AND  ";
		$user_query.= "Question_master.Question_id=Daily_transaction.Question_id AND ";
		$user_query.= "Daily_transaction.Dinalipi_date='".$selectedDay->format('Y-m-d')."' ";
		$user_query.= ") ";
		$user_query.= "left outer join Personal_default  ";
		$user_query.= "on ( ";
		$user_query.= "Devotee.Devotee_id=Personal_default.Devotee_id AND  ";
		$user_query.= "Question_master.Question_id=Personal_default.Question_id ";
		$user_query.= ") where Devotee.Devotee_id='".$_SESSION['PID']."'";
		$user_query.= "order by Question_Seq";
		$user_results = mysql_query($user_query);

		if($user_results){
			//var_dump($_SESSION);
			echo "<form action='save.php?Date=".$selectedDay->format('Y-m-d')."' method='post'><table border='1'>";
			echo "<tr><td colspan='7' style='text-align:center'><h4>Jayaguru<br>" . $_SESSION['display_name'] ."<br>Dinalipi For ".$selectedDay->format('Y-m-d')."</h4></td></tr>";
			echo "<tr><td><a href='?Date=".$previousDay->format('Y-m-d')."'>&lt;-Previous Day</a></td>";
			echo "<td colspan='5' style='text-align:center'><a href='index.php?mon=".$selectedDay->format('m')."&year=".$selectedDay->format('Y')."'>Calendar</a></td>";
			echo "<td><a href='?Date=".$nextDay->format('Y-m-d')."'>Next Day-&gt;</a></td></tr>";
			echo "<tr><td colspan='7'><table>";
			while($user_row = mysql_fetch_array($user_results)) {
				echo "<tr><td>" .$user_row['qdesc']. "</td><td><input name='" .$user_row['qid']. "' type='text' value='" .$user_row['qanswer']. "'></td></tr>";
			}
			echo "</table></td></tr>";
			echo "<tr><td colspan='7' style='text-align:right'><input type='submit' value='Submit'></td></tr>";
			echo "</table></form>";
		}
	}else{
  		echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
	}
?>
  </div>
</div>
</body>
</html>