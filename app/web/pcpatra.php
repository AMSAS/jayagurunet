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
input[type="number"] {
    width: 60px;
}
</style>

</head>
<body width="100%">
<div style="text-align:center">
  <h4>America Saraswata Sangha</h4>
  <h4>Parichaya Patra Application 2015</h4>
<?php
	session_start();
	include 'db.php';
	if (isset($_SESSION['PID']) && isAllowed($GLOBALS[ROLE_SA])) {
		//var_dump($_POST);
		if(isset($_POST['Parichaya_patra'])){
			$index=0;
			foreach( $_POST['Devotee_id'] as $D_id ) {
				$query="delete from Parichaya_patra where Devotee_id=".$D_id. " and PP_year=".$_POST['PP_year'][$index];
				echo $query."<br>\n";
				$results=mysql_query($query);
				$index=$index+1;
			}

			$index=0;
			$noerror=true;
			foreach( $_POST['Devotee_id'] as $D_id ) {
				$query=insertPPQuery($index);
				echo $query."<br>\n";
				$results=mysql_query($query);
				if($results){
					//echo "Submitted successfully";
				}else{
					$noerror=false;
				}
				$index=$index+1;
			}
			echo "<h4>";
			if($noerror){
				echo "Submitted successfully";
			}else{
				echo "Error Occured while Submitting";
			}
			echo "</h4>";
		}
		$user_query= "SELECT Devotee.Devotee_id LT_Devotee_id,Gender,First_name,YEAR(CURDATE()) CurrentYear,Value Exch_Rate,Parichaya_patra.* FROM Devotee ";
		$user_query.= "JOIN Exchange_rate ON Exchange_rate.PP_year=YEAR(CURDATE()) ";
		$user_query.= "LEFT OUTER JOIN Parichaya_patra ON Devotee.Devotee_id=Parichaya_patra.Devotee_id and Parichaya_patra.PP_year=YEAR(CURDATE()) ";
		//$user_query.= "where Devotee.Devotee_id=(select Family_id from Devotee where Devotee_id=".$_SESSION['PID'].") order by Fam_Pri_contact,First_name";
		$user_query.= "where Devotee.Family_id=(select Family_id from Devotee where Devotee_id=1) order by Fam_Pri_contact desc,First_name asc";
		//echo $user_query;
		$user_results = mysql_query($user_query);
		$submit_button='Submit';
		if($user_results){
			echo "<table class='alignCenter' cellspacing='0' cellpadding='0'>";
			echo "<form class='validate-form' onsubmit='javascript:subTotal(event)' action='pcpatra.php' method='post'>\n";
			echo "<tr><td><b>Name</b></td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td>";
			echo "<input type='hidden' name='Exch_Rate[]' value='" .$user_row['Exch_Rate']. "' disabled/>";
			echo "<input type='hidden' name='Devotee_id[]' value='" .$user_row['LT_Devotee_id']. "'/>";
			echo "<input type='hidden' name='PP_year[]' value='" .$user_row['CurrentYear']. "'/>";
			echo "<b>" .$user_row['First_name']. "</b></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Parichaya Patra (&#x20B9 100)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
				echo "<td><input required pattern='100' type='text' name='Parichaya_patra[]' value='100' readonly></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Aabaahaka (&#x20B9 126)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required pattern='0|126' type='text' title='Enter 0 or 126' name='Aabaahaka[]' value='" .$user_row['Aabaahaka']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Sammilani Daily Seba (&#x20B9 1101)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required pattern='0|1101' type='text' title='Enter 0 or 1101' name='Sammilani_Daily_seba[]' value='" .$user_row['Sammilani_Daily_seba']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Kutira Pali (&#x20B9 0/151/252/501/602)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
				if($user_row['Gender']=="M"){
					echo "<td><input type='text' name='Kutira_pali[]' value='0' readonly></input></td>";
				}else{
					echo "<td><input required pattern='0|151|252|501|602' type='text' title='Enter 0/151/252/501/602' name='Kutira_pali[]' value='" .$user_row['Kutira_pali']. "'></input></td>";
				}
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Sangha Sebaka($ 20)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required pattern='0|20' type='text'  title='Enter 0 or 20' name='Sangha_sebaka[]' value='" .$user_row['Sangha_sebaka']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Musti Bhikhyaa($ 25)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required pattern='0|25' type='text'  title='Enter 0 or 25' name='Musti_Bhikhyaa[]' value='" .$user_row['Musti_Bhikhyaa']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Gruhaasana($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required min='0' max='9999' type='number' name='Gruhaasana[]' value='" .$user_row['Gruhaasana']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Janmotsaba($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required min='0' max='9999' type='number' name='Janmotsaba[]' value='" .$user_row['Janmotsaba']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Kendra Unnayana($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required  min='0' max='9999' type='number' name='Kendra_Unnayana[]' value='" .$user_row['Kendra_Unnayana']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Nirmana($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required  min='0' max='9999' type='number' name='Nirmana[]' value='" .$user_row['Nirmana']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Sammilani Sahajya($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required  min='0' max='9999' type='number' name='Sammilani_sahajya[]' value='" .$user_row['Sammilani_sahajya']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Narayana Sebaa($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required  min='0' max='9999' type='number' name='Narayana_sebaa[]' value='" .$user_row['Narayana_sebaa']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Webcast($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required  min='0' max='9999' type='number' name='Webcast[]' value='" .$user_row['Webcast']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Nitya Puja($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required  min='0' max='9999' type='number' name='Nitya_Puja[]' value='" .$user_row['Nitya_Puja']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Bidhyaa Nidhi($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required min='0' max='9999' type='number' name='Bidhyaa_nidhi[]' value='" .$user_row['Bidhyaa_nidhi']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Swaasthya Seba($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required min='0' max='9999' type='number' name='Swaasthya_seba[]' value='" .$user_row['Swaasthya_seba']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Sammilani Baalya($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required min='0' max='9999' type='number' maxlength='4' name='Sammilani_Baalya[]' value='" .$user_row['Sammilani_Baalya']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>Misc pranami($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input required min='0' max='9999' type='number' maxlength='4' name='Misc_pranami[]' value='" .$user_row['Misc_pranami']. "'></input></td>";
			}
			echo "</tr>\n";

			mysql_data_seek($user_results, 0);
			echo "<tr><td>PP Total($)</td>";

			while($user_row = mysql_fetch_assoc($user_results)) {
			echo "<td><input type='hidden' name='Round_up[]' value='0'/><input required min='0' max='9999' type='number' maxlength='4' name='PP_Total[]' value='" .$user_row['PP_Total']. "' readonly></input></td>";
			}
			echo "</tr>\n";

			echo "<tr><td colspan='4'><input type='submit' value='Save'></input></td><tr>\n";
			echo "</form>\n";

			echo "</table>";
		}
	}else{
  		echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
	}

	function insertPPQuery($index){
		$keys= array();
		$values== array();

		foreach($_POST as $key => $value) {
			  $keys[]=$key;
			  $values[]=$value[$index];
		}
		$insertQuery = "insert into Parichaya_patra(Audit_Time,".implode(', ',$keys).") values (NOW(),".implode(', ',$values).")";
		return $insertQuery;
	}
?>
</div>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
<script>
function hasHtml5Validation () {
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
function subTotal(myEvent){
	var myEl = myEvent.currentTarget.elements;
	var exchRates = myEl.namedItem("Exch_Rate[]");
	var famTotal=0;
	for(index=0;index<exchRates.length;index++){
		var pmTot = 0.0;
		var exchRate = exchRates[index].value;
		pmTot=pmTot+parseInt(myEl.namedItem("Parichaya_patra[]")[index].value)/exchRate;
		pmTot=pmTot+parseInt(myEl.namedItem("Aabaahaka[]")[index].value)/exchRate;
		pmTot=pmTot+parseInt(myEl.namedItem("Sammilani_Daily_seba[]")[index].value)/exchRate;
		pmTot=pmTot+parseInt(myEl.namedItem("Kutira_pali[]")[index].value)/exchRate;
		pmTot=pmTot+parseInt(myEl.namedItem("Sangha_sebaka[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Musti_Bhikhyaa[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Gruhaasana[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Janmotsaba[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Kendra_Unnayana[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Nirmana[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Sammilani_sahajya[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Narayana_sebaa[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Webcast[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Nitya_Puja[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Bidhyaa_nidhi[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Swaasthya_seba[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Sammilani_Baalya[]")[index].value);
		pmTot=pmTot+parseInt(myEl.namedItem("Misc_pranami[]")[index].value);
		myEl.namedItem("Round_up[]")[index].value=0;
		myEl.namedItem("PP_Total[]")[index].value=pmTot;
		famTotal = famTotal+ pmTot;
		//alert(pmTot);
	}
	var leftOver = Math.ceil(famTotal)-famTotal;
	myEl.namedItem("Round_up[]")[0].value = leftOver
	myEl.namedItem("PP_Total[]")[0].value=parseFloat(myEl.namedItem("PP_Total[]")[0].value)+leftOver;
}
</script>
</body>
</html>