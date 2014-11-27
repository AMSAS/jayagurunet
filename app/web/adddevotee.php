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
input[type="email"] {
    width: 200px;
}
</style>

</head>
<body width="100%">
<div style="text-align:center">
  <a href="index.php"><img src="/images/orgnz.gif"/></a><br>
<?php
	session_start();
	include 'db.php';
	if (isset($_SESSION['PID']) && isAllowed($GLOBALS[ROLE_SA])) {
		//var_dump($_POST);
		if(isset($_POST['Devotee_id'])){
			$query="";
			if ($_POST['Devotee_id']=="-1"){
				$query = addDevoteeQuery();
			}else{
				$query = updateDevotee();
			}
			//echo $query;
			$results=mysql_query($query);
			echo "<h4>";
			if($results){
				echo $_POST['First_name']." saved successfully";
			}else{
				echo "Error updating ".$_POST['First_name'];
			}
			echo "</h4>";
		}
		$user_query= "select ";
		$user_query.= "all_devotee.* ";
		$user_query.= "from Devotee all_devotee,Devotee self ";
		$user_query.= "where all_devotee.Sangha_id=self.Sangha_id and self.Devotee_id='".$_SESSION['PID']."' ";
		$user_query.= "order by all_devotee.First_name";
		$user_results = mysql_query($user_query);
		$submit_button='Submit';
		if($user_results){
			echo "<table class='alignCenter' cellspacing='0' cellpadding='0'>";
			echo "<thead><tr><td width='100px'><b>First Name</b></td><td width='100px'><b>Last Name</b></td><td width='150px'><b>Email</b></td><td><b>Gender</b></td><td><b>Member Category</b></td><td><b>Add/Update</b></td></tr></thead>";
			echo "<tr>";
			echo "<form class='validate-form' action='adddevotee.php' method='post'>";
			echo "<td><input required maxlength='30' type='text' name='First_name'></input></td>";
			echo "<td><input required maxlength='30' type='text' name='Last_name'></input></td>";
			echo "<td><input type='hidden' name='Devotee_id' value='-1'></input>";
			echo "<input required maxlength='50' type='email' name='EmailId'></input></td>";
			echo "<td><input required type='text' pattern='M|F' title='Allowed values are M/F.' name='Gender'></input></td>";
			echo "<td><input required type='text' pattern='C|G' title='Allowed values are C/G.' name='Member_category'></input></td>";
			echo "<td><input type='submit' value='Add'></input></td>";
			echo "</form>";
			echo "</tr>\n";
			while($user_row = mysql_fetch_array($user_results)) {
				echo "<tr>";
				echo "<form class='validate-form' action='adddevotee.php' method='post'>";
				echo "<td><input required maxlength='30' type='text' name='First_name' value='" .$user_row['First_name']. "'></input></td>";
				echo "<td><input required maxlength='30' type='text' name='Last_name' value='" .$user_row['Last_name']. "'></input></td>";
				echo "<td><input type='hidden' name='Devotee_id' value='" .$user_row['Devotee_id']. "'></input>";
				echo "<input required maxlength='50' type='email' name='EmailId' value='" .$user_row['EmailId']. "'></input></td>";
				echo "<td><input required type='text' pattern='M|F' name='Gender' title='Allowed values are M/F.' value='" .$user_row['Gender']. "'></input></td>";
				echo "<td><input required type='text' pattern='C|G' name='Member_category' title='Allowed values are C/G.' value='" .$user_row['Member_category']. "'></input></td>";
				echo "<td><input type='submit' value='Update'></input></td>";
				echo "</form>";
				echo "<tr>\n";
			}
			echo "</table>";
		}
	}else{
  		echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
	}

	function addDevoteeQuery(){
		$insertQuery = "insert into Devotee(EmailId,First_name,Last_name,Gender,Member_category,Sangha_id,Termination_date,Share_security,phone_nbr)";
		$insertQuery.= " values('".$_POST['EmailId']."','".$_POST['First_name']."','".$_POST['Last_name']."','".$_POST['Gender']."','".$_POST['Member_category']."','".$_SESSION['SANGHA_ID']."','2020-01-01','','0')";
		return $insertQuery;
	}

	function updateDevotee(){
		$updateQuery = "update Devotee set EmailId='".$_POST['EmailId']."',First_name='".$_POST['First_name']."',Last_name='".$_POST['Last_name']."',Gender='".$_POST['Gender']."',Member_category='".$_POST['Member_category']."',Sangha_id='".$_SESSION['SANGHA_ID']."',Termination_date='2020-01-01',Share_security='',phone_nbr='0' where Devotee_id='".$_POST['Devotee_id']."' ";
		return $updateQuery;
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