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

input[type="text"] {
    width: 60px;
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
</style>

</head>
<body width="100%">
<div style="text-align:center">
  <img src="/images/orgnz.gif"/><br>
<?php
	session_start();
	if (isset($_SESSION['PID'])) {

		//If Date is not passed in argument assume its today..
		$Date = "";
		if(isset($_GET['Date']) && $_GET['Date']){
			$Date = $_GET['Date'];
		}else{
			$today = new DateTime();
			$Date = $today->format('Y-m-d');
		}

		$selectedDay = new DateTime($Date);
		$previousDay = new DateTime($Date);
		$previousDay->modify('-1 day');
		$nextDay = new DateTime($Date);
		$nextDay->modify('+1 day');

		include 'db.php';
		$user_query= "select ";
		$user_query.= "Question_master.Question_desc qdesc, ";
		$user_query.= "Question_master.Question_id as qid, ";
		$user_query.= "Question_master.ValidPattern as vpattern, ";
		$user_query.= "Question_master.Message as message, ";
		$user_query.= "Daily_transaction.Q_response as submitted, ";
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
		$submit_button='Submit';
		if($user_results){
			//var_dump($_SESSION);
			echo "<form  class='validate-form' action='save.php?Date=".$selectedDay->format('Y-m-d')."' method='post'><table class='alignCenter' cellspacing='0' cellpadding='0'>";
			echo "<tr><td colspan='7' style='text-align:center'><h4>Jayaguru<br>" . $_SESSION['display_name'] ."<br>Dinalipi For ".$selectedDay->format('Y-m-d l')."</h4></td></tr>";
			echo "<tr><td><a href='?Date=".$previousDay->format('Y-m-d')."'>&lt;-Previous Day</a></td>";
			echo "<td colspan='5' style='text-align:center'><a href='index.php?mon=".$selectedDay->format('m')."&year=".$selectedDay->format('Y')."'>Calendar</a></td>";
			echo "<td><a href='?Date=".$nextDay->format('Y-m-d')."'>Next Day-&gt;</a></td></tr>";
			echo "<tr><td colspan='7'><table>";
			while($user_row = mysql_fetch_array($user_results)) {
				if($user_row['submitted'] == $user_row['qanswer']){
					$submit_button='Update';
				}
				echo "<tr><td>" .$user_row['qdesc']. "</td><td><input title='".$user_row['message']."' pattern='".$user_row['vpattern']."' style='text-transform:uppercase' name='" .$user_row['qid']. "' type='text' maxlength='5' value='" .strtoupper($user_row['qanswer']). "'></td></tr>";
			}
			echo "</table></td></tr>";
			echo "<tr><td colspan='7' style='text-align:right'><input type='submit' value='".$submit_button."'></td></tr>";
			echo "</table></form>";
		}
	}else{
  		echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
	}
?>
</div>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
<script>function hasHtml5Validation () {
  return typeof document.createElement('input').checkValidity === 'function';
}

if (hasHtml5Validation()) {
  $('.validate-form').submit(function (e) {
    if (!this.checkValidity()) {
      e.preventDefault();
      $(this).addClass('invalid');
    } else {
      $(this).removeClass('invalid');
    }
  });
}
</script>
</body>
</html>