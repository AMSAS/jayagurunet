<html>
<head>
<link rel="stylesheet" type="text/css" href="styles/media-detect.css">
<meta name="viewport" content="width=480">
<style class="cp-pen-styles">

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
</style>

</head>
<body width="100%">
<div style="text-align:center">
  <a href="index.php"><img src="/images/orgnz.gif"/></a><br>
<?php
	session_start();
	include 'db.php';
	if (isset($_SESSION['PID']) && isAllowed($GLOBALS[ROLE_SA])) {
		$Sangha_id=$_SESSION['SANGHA_ID'];
		if(isSuper() && isset($_POST['Sangha_id'])){
			$Sangha_id=$_POST['Sangha_id'];
		}
		if(isSuper()){
			echo "<form class='validate-form' name='switch_sangha' method='post'>";
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
		$user_query= "SELECT d.Pref_name,d.Devotee_id,sm.Seva_cat,sm.Seva_id,sm.Seva_name,sx.Status 
					FROM Devotee d,Seva_xn sx,Seva_master sm 
					where sx.Devotee_id=d.Devotee_id
					and sx.Seva_id=sm.Seva_id
					and sx.Sammilani_year=YEAR(CURDATE() + INTERVAL 1 MONTH)
					and d.Sangha_id='".$Sangha_id."' 
					order by d.Family_id,d.Pref_name,sm.Seva_name";
		
		$user_results = mysql_query($user_query);
		if($user_results){
			?>
			
			<table class='alignCenter' cellspacing='0' cellpadding='0'>
			<tr>
			<td width='200px'><b>Pref Name</b></td>
			<td><b>Seva Category</b></td>
			<td><b>Applied Seva</b></td>
			<td><b>Approve</b></td>
			<td><b>Deny</b></td>
			</tr>
			<?php
			$object_num=0;
			while($user_row = mysql_fetch_array($user_results)) {
			$object_num=$object_num+1;
			?>
			<tr>
				<td><?= $user_row['Pref_name']?></td>
				<td><?= $user_row['Seva_cat']?></td>
				<td><?= $user_row['Seva_name']?></td>
				<td>
					<input name='on<?=$object_num?>' type='radio' onclick='javascript:saveApproval(event,<?=$user_row['Seva_id']?>,<?=$user_row['Devotee_id']?>)' value='Approve' <?php echo $user_row['Status']=="APPROVED"?'checked':'';?>></input> 
				</td>
				<td>
					<input name='on<?=$object_num?>' type='radio' onclick='javascript:saveApproval(event,<?=$user_row['Seva_id']?>,<?=$user_row['Devotee_id']?>)' value='Deny' <?php echo $user_row['Status']=="DENIED"?'checked':'';?>></input>
				</td>
			<tr>
			<?php
			}?>
			</table>
<?php
		}
	}else{
  		echo "<a href='index.php'>[Session Expired] Visit Landing Page</a>";
	}
?>
</div>
<script>
function saveApproval(event,Seva_id,Devotee_id)
{
	var url="saveapproval.php?Seva_id="+Seva_id+"&Devotee_id="+Devotee_id+"&current_op="+event.currentTarget.value;
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
	xmlhttp.open("GET",url,false);
	xmlhttp.send();
}
</script>
</body>
</html>