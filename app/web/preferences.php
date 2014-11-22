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
    width: 60px;
}
</style>

</head>
<body width="100%">
<div style="text-align:center">
  <img src="/images/orgnz.gif"/><br>
<?php
	session_start();
	if (isset($_SESSION['PID'])) {
		include 'db.php';
		$user_query= "select ";
		$user_query.= "Question_master.Question_desc qdesc, ";
		$user_query.= "Question_master.Question_id as qid, ";
		$user_query.= "Question_master.ValidPattern as vpattern, ";
		$user_query.= "Question_master.Message as message, ";
		$user_query.= "coalesce(Personal_default.Default_value,Question_master.Default_value) as qanswer ";
		$user_query.= "from Devotee ";
		$user_query.= "join Question_master ";
		$user_query.= "on Devotee.Member_Category=Question_master.Member_Category ";
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
			echo "<form  class='validate-form' action='savepreferences.php' method='post'><table class='alignCenter' cellspacing='0' cellpadding='0'>";
			echo "<tr><td style='text-align:center'><h4>Jayaguru<br>" . $_SESSION['display_name'] ."<br>Dinalipi Preferences</h4><a href='index.php'>Calendar</a></td></tr>";
			echo "<tr><td><table>";
			while($user_row = mysql_fetch_array($user_results)) {
				echo "<tr><td>" .$user_row['qdesc']. "</td><td><input title='".$user_row['message']."' pattern='".$user_row['vpattern']."' style='text-transform:uppercase' name='" .$user_row['qid']. "' type='text' maxlength='2' value='" .strtoupper($user_row['qanswer']). "'></td></tr>";
			}
			echo "</table></td></tr>";
			echo "<tr><td><span style='text-align:right'><input type='submit' value='Save'><span></td></tr>";
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