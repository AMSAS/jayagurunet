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
		$Sangha_id=$_SESSION['SANGHA_ID'];
		if(isSuper() && isset($_POST['Sangha_id'])){
			$Sangha_id=$_POST['Sangha_id'];
		}
		if(isSuper()){
			echo "<form class='validate-form' name='switch_sangha' action='adddevotee.php' method='post'>";
			echo "<select name='Sangha_id' onchange='javascript:document.forms[\"switch_sangha\"].submit()'>";
			$sangha_results = mysql_query("select * from Sangha_master");
			while($sangha_record = mysql_fetch_array($sangha_results)) {
				if($Sangha_id==$sangha_record['Sangha_id']){
					echo "<option selected='selected' value='".$sangha_record['Sangha_id']."'>".$sangha_record['Sangha_name']."</option>";
				}else{
					echo "<option value='".$sangha_record['Sangha_id']."'>".$sangha_record['Sangha_name']."</option>";
				}
			}
			echo "</select></form>";
		}
		$user_query= "select ";
		$user_query.= "all_devotee.* ";
		$user_query.= "from Devotee all_devotee ";
		$user_query.= "where all_devotee.Sangha_id='".$Sangha_id."' ";

		$user_query.= "order by all_devotee.Family_id,all_devotee.Fam_Pri_contact,all_devotee.First_name";
		$user_results = mysql_query($user_query);
		$submit_button='Submit';
		if($user_results){
			?>
			
			<table class='alignCenter' cellspacing='0' cellpadding='0'>
			<tr>
			<td width='100px'><b>Family</b>
			<td width='100px'><b>Primary</b></td>
			<td width='100px'><b>Parichaya Patra</b></td>
			<td width='100px'><b>First Name</b></td>
			<td width='100px'><b>Last Name</b></td>
			<td width='100px'><b>Pref Name</b></td>
			<td width='150px'><b>Email</b></td>
			<td><b>Gender</b></td>
			<td><b>Member Category</b></td>
			<td><b>Send Reminder</b></td>
			<td width='100px'><b>Add/Update</b></td>
			</tr>
			<tr>
			<form class='validate-form' action='adddevotee.php' method='post'>
			<td><input required maxlength='15' type='text' name='Family_id'></input></td>
			<td><input required maxlength='15' type='text' pattern='Y|N' title='Allowed values are Y/N.' name='Fam_Pri_contact'></input></td>
			<td><input required maxlength='15' type='text' pattern='Y|N' title='Allowed values are Y/N.' name='PP_member'></input></td>
			<td><input required maxlength='30' type='text' name='First_name'></input></td>
			<td><input required maxlength='30' type='text' name='Last_name'></input></td>
			<td><input required maxlength='30' type='text' name='Pref_name'></input></td>
			<td><input type='hidden' name='Devotee_id' value='-1'></input>
			<input type='hidden' name='Sangha_id' value='<?php echo $Sangha_id?>'></input>
			<input required maxlength='50' type='email' name='EmailId'></input></td>
			<td><input required type='text' pattern='M|F' title='Allowed values are M/F.' name='Gender'></input></td>
			<td><input required type='text' pattern='C|G|S' title='Allowed values are C/G/S.' name='Member_category'></input></td>
			<td><input required type='text' pattern='0|1' title='Allowed values are 0/1.' name='Reminder'></input></td>
			<td><input type='submit' value='Add'></input></td>
			</form>
			</tr>
			<?php
			while($user_row = mysql_fetch_array($user_results)) {?>
				<tr>
				<form class='validate-form' action='adddevotee.php' method='post'>
				<td><input required maxlength='15' type='text' name='Family_id' value='<?php echo $user_row['Family_id'];?>'></input></td>
				<td><input required maxlength='15' type='text' pattern='Y|N' title='Allowed values are Y/N.' name='Fam_Pri_contact' value='<?php echo $user_row['Fam_Pri_contact'];?>'></input></td>
				<td><input required maxlength='15' type='text' pattern='Y|N' title='Allowed values are Y/N.' name='PP_member' value='<?php echo $user_row['PP_member'];?>'></input></td>
				<td><input required maxlength='30' type='text' name='First_name' value='<?php echo $user_row['First_name'];?>'></input></td>
				<td><input required maxlength='30' type='text' name='Last_name' value='<?php echo $user_row['Last_name'];?>'></input></td>
				<td><input required maxlength='30' type='text' name='Pref_name' value='<?php echo $user_row['Pref_name'];?>'></input></td>
				<td><input type='hidden' name='Devotee_id' value='<?php echo $user_row['Devotee_id'];?>'></input>
				<input type='hidden' name='Sangha_id' value='<?php echo $Sangha_id;?>'></input>
				<input required maxlength='50' type='email' name='EmailId' value='<?php echo $user_row['EmailId'];?>'></input></td>
				<td><input required type='text' pattern='M|F' name='Gender' title='Allowed values are M/F.' value='<?php echo $user_row['Gender'];?>'></input></td>
				<td><input required type='text' pattern='C|G|S' name='Member_category' title='Allowed values are C/G/S.' value='<?php echo $user_row['Member_category'];?>'></input></td>
				<td><input required type='text' pattern='0|1' name='Reminder' title='Allowed values are 0/1.' value='<?php echo $user_row['Reminder'];?>'></input></td>
				<td><input type='submit' value='Update'></input></td>
				</form>
				<tr>
			<?php
			}?>
			</table>
<?php
		}
	}else{
  		echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
	}

	function addDevoteeQuery(){
		$insertQuery = "insert into Devotee(Family_id,Fam_Pri_contact,PP_member,EmailId,First_name,Last_name,Pref_name,Gender,Member_category,Sangha_id,Termination_date,phone_nbr,Reminder)";
		$insertQuery.= " values('".$_POST['Family_id']."','".$_POST['Fam_Pri_contact']."','".$_POST['PP_member']."','".$_POST['EmailId']."','".$_POST['First_name']."','".$_POST['Last_name']."','".$_POST['Pref_name']."','".$_POST['Gender']."','".$_POST['Member_category']."','".$_POST['Sangha_id']."','2020-01-01','0','".$_POST['Reminder']."')";
		return $insertQuery;
	}

	function updateDevotee(){
		$updateQuery = "update Devotee set Family_id='".$_POST['Family_id']."',Fam_Pri_contact='".$_POST['Fam_Pri_contact']."',PP_member='".$_POST['PP_member']."',EmailId='".$_POST['EmailId']."',First_name='".$_POST['First_name']."',Last_name='".$_POST['Last_name']."',Pref_name='".$_POST['Pref_name']."',Gender='".$_POST['Gender']."',Member_category='".$_POST['Member_category']."',Sangha_id='".$_POST['Sangha_id']."',Termination_date='2020-01-01',phone_nbr='0',Reminder='".$_POST['Reminder']."' where Devotee_id='".$_POST['Devotee_id']."' ";
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